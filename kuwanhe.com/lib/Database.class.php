<?php

//网站数据库操作
class Database{
   //网站配置表
   private $website;
   //关键字
   private $keywords    = array(
           'table'=> '',
           'field'=> '',
           'value'=> '',
           'where'=> '',
           'order'=> '',
           'limit'=> '',
           'group'=> '',
           'num'  => '' ,
           'page' => '',
           'conn' =>''      //选择连接的数据
       );
   //PDO Statement类实例
   private $stmt;
   //上次执行的sql
   public  $sql;

   //数据连接池对象 默认执行第一个  array('db'=>$pdo,'aq'=>$pdo)
   public $dbs = array();

   //记录
   public $record = array();

   function __construct(&$website){
       $this->website  = $website;
   }//__construct

   /*
       检索关键字动态方法
       函数参数$args说明
       1,多个字符串或一个字符串
       2,一个数组，例如：field(array('xxx','ssss'))
       3,一个为字符串和一个数组组成 where('xxx=:xxx and yyy<:yyy',array('xxx'=>'111','yyy'=>'222'))
   */
   public function __call($methods,$args){
       $method = strtolower($methods);
       if(count($args) === 1 && is_array($args[0])){
           $this->keywords[$method] = $args[0];
       }elseif(count($args) === 0){
           $this->keywords[$method] = array();
       }else{
           $this->keywords[$method] = $args;
       }
       //echo $methods,'：',count($args),'<br />';

       return $this;
   }


  //格式化关键字内容
  private function fn_format(){
   foreach($this->keywords as $k=>$v){
     switch($k){
       case 'table':
        $this->keywords['table'] = $v;
       break;
       case 'field':
         if(count($v) === 0 || empty($v[0])){
             $this->keywords['field'] = ' * ';
         }elseif(is_array($v)){
            $this->keywords['field'] = implode(',', $v);
         }else{
            $this->keywords['field'] = $v;
         }
         break;
       case 'value':
         if(is_array($v) && count($v)){
             $this->keywords['value']['statement'] = str_repeat("?,", count($v)-1).'?';
             $this->keywords['value']['param'] = $v;
         }else{
             $this->keywords['value']['param'] = array();
         }
         break;
       case 'where':
        if(isset($v['param'])){
          unset($v['param']);
        }
        if(isset($v['statement'])){
          unset($v['statement']);
        }

         $this->keywords['where']['param']       = array();
         if(is_array($v) && count($v) === 1){
             $this->keywords['where']['statement']   = !empty($v[0]) ? ' where '.$v[0] : '';
         }elseif(is_array($v) && count($v) === 2 && is_array($v[1])){
             $this->keywords['where']['statement']   = !empty($v[0]) ? ' where '.$v[0] : '';
             $this->keywords['where']['param']       = $v[1];
         }elseif(is_array($v) && count($v) > 1){
             $this->keywords['where']['statement']   = !empty($v[0]) ? ' where '.$v[0] : '';
             array_shift($v);
             $this->keywords['where']['param']       = is_array($v) ? $v : array();
         }elseif(is_string($v) && !empty($v)){
             $this->keywords['where']['statement']   = ' where '.$v;
         }else{
             $this->keywords['where']['statement']   = '';
         }
         break;
       case 'order':
         if(is_array($v) && count($v) === 1 && !empty($v[0])){
             $this->keywords['order'] = ' order by '.$v[0];
         }elseif(is_string($v) && !empty($v)){
             $this->keywords['order'] = ' order by '.$v[0];
         }else{
             $this->keywords['order'] = '';
         }
         break;
       case 'limit':
         if(is_array($v) && count($v) === 1){
             $this->keywords['limit'] = ' limit '.$v[0];
         }elseif(is_string($v) && !empty($v)){
             $this->keywords['limit'] = ' limit '.$v;
         }else{
             $this->keywords['limit'] = '';
         }
         break;
       case 'group':
         if(is_array($v) && count($v) === 1){
             $this->keywords['group'] = ' group by '.$v[0];
         }elseif(is_string($v) && !empty($v)){
             $this->keywords['group'] = ' group by '.$v;
         }else{
             $this->keywords['group'] = '';
         }
         break;
       //分页显示个数 在分页中使用$this->paging()
       case 'num':
         if(is_array($v) && is_numeric($v[0])){
             $this->keywords['num'] = $v[0];
         }elseif(!empty($v) && is_numeric($v)){
             $this->keywords['num'] = $v;
         }
         break;
       case 'page':
         if(is_array($v) && is_numeric($v[0])){
             $this->keywords['page'] = $v[0];
         }elseif(!empty($v) && is_numeric($v)){
             $this->keywords['page'] = $v;
         }
         break;
       case 'conn':
         if(is_array($v)){
             $this->keywords['conn'] = $v[0];
         }
         break;
       default:
         $this->fn_error(
             '',
             '错误文件：DB.class.php<br />'.
             '未知关键字:'.$k
         );
      }
   }
   if(is_array($this->keywords['table'])){
     $db = $this->fn_now_db();
     foreach($this->keywords['table'] as $k=>$v){
       $this->keywords['table'][$k]=$db['prefix'].$v;
     }
     $this->keywords['table'] = implode(',', $this->keywords['table']);
   }
  }

  //当前操作的数据库信息
  private function fn_now_db(){
    return (isset($this->keywords['conn']) && !empty($this->keywords['conn'])) ? $this->website['database'][$this->keywords['conn']] : current($this->website['database']);
  }

  //当前操作的数据库名
  private function fn_now_db_key(){
    return (isset($this->keywords['conn']) && !empty($this->keywords['conn'])) ? $this->keywords['conn'] :key($this->website['database']);
  }

  //错误处理
  private function fn_error($str='',$e){
   $conn = $this->keywords['conn'] ? $this->keywords['conn'] : key($this->website['database']);
   if($this->website['database'][$conn]['debug']){
     if($e){
       echo $str,'<br />';
       print_r($e);
     }else{
       echo $str,'<br />';
     }
   }
   exit();
  }

  //执行预处理SQL
  private function fn_act($statement,$param){
    $this->fn_db_connect();
    try{
       $this->stmt= $this->PDO->prepare($statement);
       $this->stmt->execute($param);
       $temp =array();
       foreach($param as $v){
           array_push($temp,'/\?/');
       }
       $this->sql = preg_replace($temp, $param, $statement,1);
    }catch(PDOException $e){
       $this->fn_error($e);
    }
    $this->fn_empty_keywords();
    return $this->stmt;
  }

   //清空keywords
   private function fn_empty_keywords(){
     $temp = array_keys($this->keywords);
     $this->keywords = array_fill_keys($temp,'');
   }

   //PDO连接
   private function fn_db_connect(){
     //指定链接
     $conn = $this->fn_now_db_key();
     if(isset($this->website['database'][$conn])){
       if(isset($this->dbs[$conn])){return $this->dbs[$conn];}
       $dbInfo = $this->website['database'][$conn];
     }else{
       echo '未找到指定数据库!';exit();
     }
    //  print_r($dbInfo);exit();
     try{
         $this->PDO = new PDO(
             $dbInfo['name'].
                     ':host='.$dbInfo['host'].
                     ';dbname='.$dbInfo['db'].
                     ';charset='.$dbInfo['charset'],
                      $dbInfo['usr'],
                      $dbInfo['pwd'],
                      array(
                         PDO::MYSQL_ATTR_INIT_COMMAND    => "SET NAMES '{$dbInfo['charset']}';",
                         PDO::ATTR_PERSISTENT            => $dbInfo['durable']
                     )
         );
     }catch(Exception $e){
        echo 1;
        $this->fn_error('数据库连接错误:',$e);
        exit();
     }
     $this->dbs[$conn] = $this->PDO;
     return $this->PDO;
   }

   //Cache
   private function fn_cache($k=false,$v=false){
       $this->fn_cache_conn();
       if(!$v && $k){
           return $this->fn_cache_get($k);
       }elseif($k && $v){
           return $this->fn_cache_set($k,$v);
       }else{
           return 0;
       }
   }

   //创建缓存链接
   private function fn_cache_conn(){
     try{
       if(!is_dir($this->website['database'][$this->fn_now_db_key()]['cache']['path'])){
           if($err = $this->fn_cache_mkdir($this->website['database'][$this->fn_now_db_key()]['cache']['path'])){
               echo $err;
               exit();
           }
       }
     }catch(EngineException $e){
       echo '文件缓存错误：'.$e->getMessage();
       exit();
     }
   }

   //获取数据缓存
   private function fn_cache_get($k){
     if(!$k){return false;}
     $k  = str_replace('-', '/', $k);
     $path = $this->website['database'][$this->fn_now_db_key()]['cache']['path'].'/'.$k;
     if(is_file($path)){
         return file_get_contents($path);
     }else{
         return false;
     }
     return false;
   }

   //设置数据缓存
   private function fn_cache_set($k,$v,$time=0){
     if(!$k || !$v){return false;}
     $path   = $this->website['database'][$this->fn_now_db_key()]['cache']['path'].'/'.str_replace('-', '/', $k);
     $arr    = $this->fn_cache_dir_name($path);
     if(is_file($path)){
         return file_put_contents($path,$v);
     }else{
         if(($err = $this->fn_cache_mkdir($arr['dir'])) !== true){
              echo '缓存数据数据 set--error:',$err,$arr['dir'];
              return false;
         }else{
              return file_put_contents($path,$v);
         }
     }
     return false;
   }

   //删除数据
   public function cache_delete($k,$time=0){
       if(!$k){return false;}
       $path   = $this->website['database'][$this->fn_now_db_key()]['cache']['path'].'/'.str_replace('-', '/', $k);
       if(is_file($path)){
           return unlink($path);
       }
       return false;
   }

   //获取文件夹内文件数
   private function fn_cache_file_num($dir){
       if(is_dir($dir)){
           $i=0;
           $handle = opendir($dir);
           while(false !== $file=(readdir($handle))){
               if($file!=='.' || $file != ''){
                   $i++;
               }
           }
           closedir($handle);
           return $i;
       }
       return false;
   }

   //数据缓存功能----逐级创建文件夹
   private function fn_cache_mkdir($path,$mode=0775,$recursive=false){
       $arr    = explode('/', $path);
       array_shift($arr);
       $paths  = '';
       foreach($arr as $v){
           $paths.='/'.$v;
           if(!is_dir($paths)){
               if(!mkdir($paths,$mode,$recursive)){
                   return '创建缓存文件夹：'.$paths.' 错误';
               }
           }
       }
       return true;
   }

   //file分离路径和文件
   private function fn_cache_dir_name($path){
       $arr    = explode('/',$path);
       $fname  = array_pop($arr);
       return array(
           'dir'   => implode('/', $arr),
           'name'  => $fname
       );
   }

   //数据缓存功能----获取缓存KEY
   private function fn_cache_key(){
       //key的组成    数据库表名-id(类型id/page)-ceil(id编号/文件夹最大文件数)-id-md5(json_encode($this->keywords))
       //feile类型保存地址：type-id(page)-1-5-a9a8b8f79fab379f343d5cb558b5e71b
       $arr = array();
       $key = '';
       //文件名md5(查询字段+where语句)
       $file= '';
       //类型
       //echo $this->keywords['limit'],'<br />';
       $tp  = preg_match('/limit 1/',$this->keywords['limit']) ? 'id' : 'page';
       //判断Where是否有数值
       if(!count($this->keywords['where']['param'])){//未采用预执行模式 ->where('xxx=123')
           preg_match('/id\s*=\s*(\?|\d+)/',$this->keywords['where']['statement'],$arr);
       }else{
           $temp = array();
           foreach($this->keywords['where']['param'] as $v){
               array_push($temp,'/\?/');
           }
           $str = preg_replace($temp, $this->keywords['where']['param'], $this->keywords['where']['statement'],1);
           preg_match('/id\s*=\s*(\?|\d+)/',$str,$arr);
       }
       $num = ceil($arr[1]/$this->website['database'][$this->fn_now_db_key()]['cache']['max']);
       $md5 = md5(json_encode($this->keywords));
       $key = $this->keywords['table'].
              '-'.$tp.
              '-'.$num.
              '-'.$arr[1].
              '-'.$md5;
       return $key;
   }
/*---------------------------------------------*/
/*---------------------------------------------*/
   //输出语句数组
   public function keywords(){
       return $this->keywords;
   }
   //获取执行的SQL
   public function statement(){
       return $this->stmt;
   }
  //  直接执行SQL语句----
  public function exec($sql){
    $this->fn_db_connect();
    $this->sql = $sql;
    return $this->PDO->exec($sql);
  }

   /*插入新数据
       insert  返回插入数据的最后ID
       1,$this->table('表名')->field('字段名','字段名')->value('数值','数值')->insert()
       2,$this->insert(
           array(
               'table'=>'表名',
               'field'=>array('字段名','字段名'),
               'value'=>array('数值','数值')
           )
       );
   */
   public function insert($args=array()){
       $this->keywords = array_merge($this->keywords,$args);
       $this->fn_format();
       $this->fn_act(
           'insert into '.$this->keywords['table'].
               '('.$this->keywords['field'].')'.
               ' values('.$this->keywords['value']['statement'].')',
               $this->keywords['value']['param']
       );
       return $this->PDO->lastInsertId();
   }

   /*查询数据
       select 返回所有数据的字符关键字数组
       1.$this->table('表名')
           ->field('xxx','xxx')
           ->where('xxx=?',yyy)
           ->group('xxx')
           ->order('xxx')
           ->limit('xxx')
           ->select()
       2.$this->select(
           array(
               'table'=>'表名',
               [可选]'field'=>array('字段名','字段名'),
               [可选][数组或字符串]'where'=>array('xxx=? and yyy=?',xxx,yyy)  /  'where'=>'xxx=xxx and yyy=yyy'
               [可选][数组或字符串]'group'=>array('xxx')/'xxx'
               [可选][数组或字符串]'order'=>array('xxx')/'xxx',
               [可选][数组或字符串]'limit'=>array('xxx')/'xxx,xxx'
           )
       );
   */
  public function select($args=array()){

   $this->keywords = array_merge($this->keywords,$args);

   $this->fn_format();


   $statement = 'select '.$this->keywords['field'].
                ' from '.$this->keywords['table'].
                $this->keywords['where']['statement'].
                $this->keywords['group'].
                $this->keywords['order'].
                $this->keywords['limit'];

   $param      = array();
   if(is_array($this->keywords['where']['param'])){
     $param  = $this->keywords['where']['param'];
   }

   $this->fn_act($statement,$param);
   return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
  }

   /*查询一组数据
       one  返回一行数据
       $this
       ->table('表名')
       ->field('xxx','xxx')
       ->where('xxx=?',yyy)
       ->group('xxx')
       ->order('xxx')
       ->one()
       $this->one(
           array(
               'table'=>'表名',
               [可选]'field'=>array('字段名','字段名'),
               [可选][数组或字符串]'where'=>array('xxx=? and yyy=?',xxx,yyy)  /  'where'=>'xxx=xxx and yyy=yyy'
               [可选][数组或字符串]'group'=>array('xxx')/'xxx'
               [可选][数组或字符串]'order'=>array('xxx')/'xxx',
           )
       );
   */
   public function one($args=array()){

       $this->keywords = array_merge($this->keywords,$args);

       $this->keywords['limit'][0] = 1;
       $this->fn_format();

       $statement = 'select '.$this->keywords['field'].
                    ' from '.$this->keywords['table'].
                    $this->keywords['where']['statement'].
                    $this->keywords['group'].
                    $this->keywords['order'].
                    $this->keywords['limit'];

       $param      = is_array($this->keywords['where']['param']) ? $this->keywords['where']['param'] : array();
       if(is_array($this->keywords['where']['param'])){
           $param  = $this->keywords['where']['param'];
       }
       //缓存功能
       $dbInfo = $this->fn_now_db();
       if($dbInfo['caching'] && preg_match('/id\s*=/',$this->keywords['where']['statement'])){
           $this->keywords['field'] = '*';
           $key  = $this->fn_cache_key();
           $json = $this->fn_cache($key);

           if($json){
               $this->fn_empty_keywords();
               return json_decode($json,1);
           }else{
               $this->fn_act($statement,$param);
               $arr = $this->stmt->fetch(PDO::FETCH_ASSOC);
               $this->fn_cache($key,json_encode($arr));
               return $arr;
           }
       }else{
           $this->fn_act($statement,$param);
           $arr = $this->stmt->fetch(PDO::FETCH_ASSOC);
       }
       return $arr;
   }

   /*  更新数据
       update ----返回受影响的行数
       ->table('表名')
       ->field('xxx','xxx')
       ->value('xxx',xxx)
       ->where('xxx=?',yyy)
       ->update()
       $this->update(
           array(
               'table'=>'表名',
               'field'=>array('字段名','字段名'),
               'value'=>array('xxx',xxx),
               [可选][数组或字符串]'where'=>array('xxx=? and yyy=?',xxx,yyy)  /  'where'=>'xxx=xxx and yyy=yyy'
           )
       );
   */
   public function update($args=array()){

       $this->keywords = array_merge($this->keywords,$args);

       $this->fn_format();

       $statement = 'update '.$this->keywords['table'].
                    ' set '.str_replace(',','=?,',$this->keywords['field']).'=?'.
                    $this->keywords['where']['statement'];

       $param        = array();
       if(is_array($this->keywords['value']['param']) && is_array($this->keywords['where']['param'])){
           $param = array_merge($this->keywords['value']['param'],$this->keywords['where']['param']);
       }elseif(is_array($this->keywords['value']['param'])){
           $param = $this->keywords['value']['param'];
       }elseif(is_array($this->keywords['where']['param'])){
           $param = $this->keywords['where']['param'];
       }
       $db = isset($this->conn)? $this->website['database'][$this->conn]:$this->website['database']['db'];
       if($db['caching'] && preg_match('/id\s*=/',$this->keywords['where']['statement'])){
           $key     = $this->fn_cache_key();
           $cache   = $this->cache_delete($key);
       }

       $this->fn_act($statement,$param);
       return $this->stmt->rowCount();
   }

   /*删除数据
       delete ----返回删除的个数
       $PDO->table('表名')
       ->where('xxx=?',yyy)
       ->delete()
       $this->delete(
           array(
               'table'=>'表名',
               [可选][数组或字符串]'where'=>array('xxx=? and yyy=?',xxx,yyy)  /  'where'=>'xxx=xxx and yyy=yyy'
           )
       );
   */
  public function delete($args=array()){

   $this->keywords = array_merge($this->keywords,$args);

   $this->fn_format();
   $statement = 'delete from '.
                   $this->keywords['table'].
                   $this->keywords['where']['statement'].
                   $this->keywords['order'].
                   $this->keywords['limit'];
   $db = isset($this->conn)? $this->website['database'][$this->conn]:$this->website['database']['db'];
   if($db['caching'] && preg_match('/id\s*=/',$this->keywords['where']['statement'])){
       $key     = $this->fn_cache_key();
       $cache   = $this->fn_cache()->delete($key);
   }
   $this->fn_act($statement,$this->keywords['where']['param']);

   return $this->stmt->rowCount();
  }

   /*获取个数
       count ----返回个数
       $PDO->table('表名')
       ->filed()
       ->where('xxx=?',yyy)
       ->count()
       $this->count(
           array(
               'table'=>'表名',
               [可选][数组或字符串]'where'=>array('xxx=? and yyy=?',xxx,yyy)  /  'where'=>'xxx=xxx and yyy=yyy'
           )
       );
   */
  public function count($args=array()){

    $this->keywords = array_merge($this->keywords,$args);

    $this->fn_format();

    $this->fn_act(
               'select count('.$this->keywords['field'].') from '.$this->keywords['table'].$this->keywords['where']['statement'],
               $this->keywords['where']['param']
           );

    return $this->stmt->fetchColumn();
  }


   /*查询分页数据
       paging 返回所有数据的字符关键字数组
       1.$this->table('表名')
           ->field('xxx','xxx')
           ->where('xxx=?',yyy)
           ->group('xxx')
           ->order('xxx')
           ->num('xxx')
           ->page('xxxx')
           ->paging()
       2.$this->paging(
           array(
               'table'=>'表名',
               [可选]'field'=>array('字段名','字段名'),
               [可选][数组或字符串]'where'=>array('xxx=? and yyy=?',xxx,yyy)  /  'where'=>'xxx=xxx and yyy=yyy'
               [可选][数组或字符串]'group'=>array('xxx')/'xxx'
               [可选][数组或字符串]'order'=>array('xxx')/'xxx',
               [可选][数组或字符串]'num'=>array('xxx')/'xxx,xxx'
           )
       );
   */
   public function paging($args=array()){
       $this->keywords = array_merge($this->keywords,$args);
       $this->fn_format();
       extract($this->keywords);

       $num        = isset($num) && is_numeric($num) ? $num : $this->website['page']['num'];
       $maxNum     = $this->table($table)->field('*')->where($where)->conn($conn)->count();
       $maxPage    = ceil($maxNum/$num);


       $nowPage    = $page-1;
       $upPage     = (($page-1) < 1)?(1):($page-1);
       $downPage   = (($page+1) > $maxPage)?($maxPage):($page+1);
       $pages      = $nowPage * $num;
       $limit      = ' limit '.$pages.','.$num;

       $this->keywords['conn']    = $conn;
       $data   = $this->fn_act(
           'select '.$field.' from '.$table.$where['statement'].$order.$limit,
           $where['param']
       );

       //echo 'select '.$field.' from '.$table.$where['statement'].$order.$limit;exit();
       //echo ;exit();
       return array(
               'nowPage'   => $page,
               'upPage'    => $upPage,
               'downPage'  => $downPage,
               'maxPage'   => $maxPage,
               //测试'sql'       => 'select '.$field.' from '.$table.$where['statement'].$order.$limit,
               'data'      => $this->statement()->fetchAll(PDO::FETCH_ASSOC)
           );
   }

}
