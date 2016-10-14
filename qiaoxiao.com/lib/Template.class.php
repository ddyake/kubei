<?php
class Template {
  var $config = array(
    'templateDir'   => 'tpl',//模板地址
    'compileDir'    => 'tpl_c',   //缓存地址
    'left'          => '<!--{',
    'right'         => '}-->',
    'cache'         => false      //是否开启直接读取缓存 ----- 开发时开启，正式运行时关闭
  );
  //存放模板变量
  var $val    = array();
  //存放自定义变量
  var $method = array();
  var $website;
  //错误处理类
  var $Err;
  //初始化
  public function __construct(&$website) {
    //覆盖默认配置
    $this->config = array_merge($this->config,$website['template']);
    $this->website= $website;
    $this->Error  = new Error();
  }

  //显示页面
  public function display(){
    //与定义变量实例化
    extract($this->val);
    include_once $this->compile(func_get_args()[0]);
    return $this;
  }

  //添加自定义变量
  public function assign($key,$value){
    $this->val[$key]=$value;
    return $this;
  }

  //添加自定义函数
  public function custom($name,$func){
    $this->method= array_merge($this->method,array(
      '#'.$this->config['left'].$name.'(.*?)'.$this->config['right'].'#i'=>function($match)use($name,$func){
        if(!function_exists($func)){
          $this->Error->manage(array(
            'type'=>'stop',
            'msg' => '模板类添加自定义函数-未找到自定义"'.$func.'"函数'
          ));
        }
        //匹配属性
         preg_match_all('/(\w+)=(?:(?:(["\'])(.*?)(?=\2)?:(["\']))|([^\s]*))/',$match[1],$arr);
         $args=array();
         foreach($arr[1] as $k=>$v){
           array_push($args,'\''.$v.'\'=>'.$arr[5][$k]);
         }
         return  '<?php echo '.$func.'(array('.implode(',',$args).')); ?>';
      }
    ));
    return $this;
  }

  //解析后的tpl数据转换成php文件并保存
  private function compile($tpl){
    //缓存文件地址
    $cacheFile  = $this->cache_file($tpl);
    $cont       = file_get_contents($this->config['templateDir'].'/'.$tpl);
    if(!$this->config['cache'] || !is_file($cacheFile)){
      file_put_contents($cacheFile, $this->analyze($cont));
    }
    return $cacheFile;
  }
  //获取加密文件名称
  private function cache_file($tpl){
    $file       = str_replace('/','.',$tpl);
    $file       = str_replace('..', '', $file);

    $tpl        = $this->config['templateDir'].'/'.$tpl;
    $cacheFile  = $this->config['compileDir'].'/'.md5($tpl).'-'.$file.'.php';
    return $cacheFile;
  }
  //解析数据并替换内容
  private function analyze($str){
    $self = &$this;
    $def  = array(
      //加载其他模块
      '#'.$this->config['left'].'include file=(?:\'|\"|\s)(.+?)(?:\'|\"|\s)'.$this->config['right'].'#i'=>function($match){
        $this->compile($match[1]);
        $cacheFile = $this->cache_file($match[1]);
        return '<?php include_once(\''.$cacheFile.'\') ?>';
      },
      '#'.$this->config['left'].'include file=\$(.*?)'.$this->config['right'].'#i'=>function($match){
        $this->compile($this->val[$match[1]]??'');
        $cacheFile = $this->cache_file($this->val[$match[1]]??'');
        return '<?php include_once(\''.$cacheFile.'\') ?>';
      },
      //函数
      '#'.$this->config['left'].'([0-9a-zA-Z_]+?):(.*?)'.$this->config['right'].'#i'  => function($match){
        return '<?php echo '.$match[1].$match[2].'; ?>';
      },
      //if语句 <!--{if()}-->
      '#'.$this->config['left'].'\s*if\s+(.+?)\s*'.$this->config['right'].'#i'  => function($match)use($self){
        return '<?php if('.$match[1].'){ ?>';
      },
      //else语句 <!--{else:}-->
      '#'.$this->config['left'].'\s*else\s*'.$this->config['right'].'#i'  => function($match){
        return '<?php }else{ ?>';
      },
      //elseif语句 <!--{elseif()}-->
      '#'.$this->config['left'].'\s*elseif\s+(.+?)\s*'.$this->config['right'].'#i'  => function($match){
        return '<?php }elseif('.$match[1].'){ ?>';
      },
      //endif语句  <!--{endif}-->
      '#'.$this->config['left'].'\s*endif\s*'.$this->config['right'].'#i'  => function(){
        return '<?php } ?>';
      },
      //endif语句另一种写法   <!--{/if}-->
      '#'.$this->config['left'].'\s*\/if\s*'.$this->config['right'].'#i'  => function(){
        return '<?php } ?>';
      },
      //foreach语句    <!--{foreach $contacts as $contact-->}
      '#'.$this->config['left'].'\s*foreach\s+(\S+)\s+as\s+(\S+)\s*'.$this->config['right'].'#i'  => function($match){
        return '<?php if (isset('.$match[1].') && is_array('.$match[1].')){foreach('.$match[1].' as '.$match[2].'){ ?>';
      },
      //foreach语句    <!--{foreach $contacts as $key=>$contact-->}
      '#'.$this->config['left'].'\s*foreach\s+(\S+) as $key\s*=>\s*(\S+)\s*'.$this->config['right'].'#i'  => function($match){
        return '<?php if (isset('.$match[1].') && is_array('.$match[1].')){foreach('.$match[1].' as $key=>'.$match[2].'): ?>';
      },
      //loop语句    <!--{loop $contacts $contact-->}
      '#'.$this->config['left'].'\s*loop\s+(\S+)\s+(\S+)\s*'.$this->config['right'].'#i'  => function($match){
        return '<?php if (isset('.$match[1].') && is_array('.$match[1].')){foreach('.$match[1].' as '.$match[2].'): ?>';
      },

      //endforeach语句    <!--{endforeach-->}
      '#'.$this->config['left'].'\s*endforeach\s*'.$this->config['right'].'#i'  => function(){
        return '<?php endforeach;} ?>';
      },
      //endforeach语句    <!--{/foreach-->}
      '#'.$this->config['left'].'\s*\/foreach\s*'.$this->config['right'].'#i'  => function(){
        return '<?php }} ?>';
      },
      //loop结束语句    <!--{/loop-->}
      '#'.$this->config['left'].'\s*\/loop\s*'.$this->config['right'].'#i'  => function(){
        return '<?php endforeach;} ?>';
      },
      //插入php语句    <!--{php}-->}
      '#'.$this->config['left'].'php'.$this->config['right'].'#i'  => function(){
        return '<?php ';
      },
      //结束插入php语句    <!--{/php}-->}
      '#'.$this->config['left'].'/php'.$this->config['right'].'#i'  => function(){
        return '?> ';
      },
      //for语句    <!--{for($xx;$xx<$xxx;$i++)-->}
      '#'.$this->config['left'].'for\((.*?);(.*?);(.*?)\)'.$this->config['right'].'#i'  => function($match){
        return '<?php for('.$match[1].';'.$match[2].';'.$match[3].'){ ?>';
      },
      //结束for语句    <!--{/for}-->}
      '#'.$this->config['left'].'\s*\/for\s*'.$this->config['right'].'#i'  => function(){
        return '<?php } ?>';
      },
      //显示变量
      '#'.$this->config['left'].'\$(.*?)'.$this->config['right'].'#i'=>function($match){
        return '<?php echo $'.$match[1].'; ?>';
      },
      //Php代码
      '#'.$this->config['left'].'php\s+(.+)'.$this->config['right'].'#i'=>function($match){
        return '<?php '.$match[1].' ?>';
      },
      //替换变量参数
      '#'.$this->config['left'].'\$([0-9a-zA-Z_\[\]\'\"]+?)'.$this->config['right'].'#i'=>function($match){
        return '$'.$match[1];
      },
      /*
      //三维数组
      '#'.$this->config['left'].'\$([0-9a-zA-Z_]+?)\.([0-9a-zA-Z_]+?)\.([0-9a-zA-Z_]+?)\.([0-9a-zA-Z_]+?)'.$this->config['right'].'#i'=>function($match){
        //print_r($match);exit();
        return '<?php echo $'.$match[1].'[\''.$match[2].'\']'.'[\''.$match[3].'\']'.'[\''.$match[4].'\']'.'; ?>';
      },
      //二维数组
      '#'.$this->config['left'].'\$([0-9a-zA-Z_]+?)\.([0-9a-zA-Z_]+?)\.([0-9a-zA-Z_]+?)'.$this->config['right'].'#i'=>function($match){
        //print_r($match);exit();
        return '<?php echo $'.$match[1].'[\''.$match[2].'\']'.'[\''.$match[3].'\']'.'; ?>';
      },
      //1维数组
      '#'.$this->config['left'].'\$([0-9a-zA-Z_]+?)\.([0-9a-zA-Z_]+?)'.$this->config['right'].'#i'=>function($match){
        //print_r($match);exit();
        return '<?php echo $'.$match[1].'[\''.$match[2].'\']'.'; ?>';
      },
      */
    );

    $def = array_merge($def,$this->method);

    return preg_replace_callback_array($def,$str);

  }




}
