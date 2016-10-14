<?php
class Website{
  var $website;//网站配制
  public function __construct(&$website){
      $this->website  = $website;
      $this->website['class']['db'] = new Database($website);
      $this->website['class']['tpl'] = new Template($website);
      $this->website['class']['err'] = new WebError($website);
      $this->website['class']['log'] = new Log($website);
  }


  //网站初始化运行
  public function start(){
    $route= $this->route();
    $addr = $this->website['path']['action'].'/'.$route;
    if(is_file($addr)){
      try{
        $website = $this->website;
        include $addr;
      }catch(EngineException $e){
        $this->website['class']['err']->manage(array(
          'type'  => 'top',
          'msg'   => $route.'：'.$e->getMessage()
        ));

      }
    }else{
      //echo $addr;
      die('错误的网络地址，请核对后执行！');
    }
  }

  //地址路由分析--返回执行文件地址
  private function route(){
    $act  = isset($_GET['act'])?$_GET['act']:0;
    $acts = str_replace('-','/',$act);

    if(!$act){
      $addr = 'index.php';
    }elseif(is_file($this->website['path']['action'].'/'.$acts.'.php')){
      $addr = $acts.'.php';
      // $arr  = explode('-', $act);
      // switch (count($arr)) {
      //   case 1://act.php?act=xxx  : 默认执行xxx.php或者xxx/index.php文件
      //     if(is_file($this->website['path']['action'].'/'.$arr[0].'.php')){
      //       $addr = $arr[0].'.php';
      //     }elseif(is_dir($this->website['path']['action'].'/'.$arr[0])){
      //       $addr = $arr[0].'/index.php';
      //     }else{
      //       $addr = 'error.php';
      //     }
      //     break;
      //   case 0://act.php  ：没有参数则显示错误页面
      //     $addr = 'error.php';
      //   default://act.php?act=xxx-xxx ：   xxx/xxx.php
      //     $addr = str_replace('-', '/',$act).'.php';
      //     break;
      // }
    }elseif(is_file($this->website['path']['action'].'/'.$acts.'/index.php')){
      $addr = $acts.'/index.php';
    }else{
      $addr = '/error.php';
    }
    return $addr;
  }


}
