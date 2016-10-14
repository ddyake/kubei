<?php
class Website{
  var $website;//网站配制
  var $action;
  public function __construct(&$website){
      $this->website  = $website;
      $this->website['class']['db'] = new Database($website);
      $this->website['class']['tpl'] = new Template($website);
      $this->website['class']['err'] = new WebError($website);
      $this->website['class']['log'] = new Log($website);
  }


  //网站初始化运行
  public function start(){

    switch(fn_device()){
      case 'iPad':
      case 'Android':
      case 'iPhone':
        $this->action =$this->website['path']['mobile'];
        break;
      case 'Pc':
      default:
        $this->action =$this->website['path']['action'];
    }
    $route= $this->route();
    $addr = $this->action.'/'.$route;

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
      die('错误的网络地址，请核对后执行！');
    }
  }

  //地址路由分析--返回执行文件地址
  private function route(){
    $act  = isset($_GET['act'])?$_GET['act']:0;
    $acts = str_replace('-','/',$act);

    if(!$act){
      $addr = 'index.php';
    }elseif(is_file($this->action.'/'.$acts.'.php')){
      $addr = $acts.'.php';
    }elseif(is_file($this->action.'/'.$acts.'/index.php')){
      $addr = $acts.'/index.php';
    }else{
      $addr = '/error.php';
    }
    return $addr;
  }


}
