<?php
header('Content-Type:text/html;charset=utf-8');//设置编码
date_default_timezone_set("Etc/GMT-8");//设置中国时区
session_start();
require '../conf/website.conf.php';
require $website['path']['lib'].'/func.php';
require $website['path']['lib'].'/Database.class.php';
require $website['path']['lib'].'/Log.class.php';
require $website['path']['lib'].'/WebError.class.php';


error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
//数据文件不缓存
$website['db']['caching'] = false;

$get  = $_GET['act']??($_POST['act']??'');

//寻找执行文件及执行函数
if(!$get){
  echo json_encode(array('status'=>'error','msg'=>'act','data'=>'无效ACT'.$get));
  exit();
}

$act 	= explode('-',$get);
$count= count($act);
//执行函数名
if($count === 2){//$get = 'xxx-xxx'
  $func = 'act_'.implode('_',$act);
}elseif($count > 2){//$get = 'xxx-xxx-xxx-xxx....'
  $func	= 'act_'.$act[$count-2].'_'.$act[$count-1];
  array_pop($act);
}else{
  echo json_encode(array('status'=>'error','msg'=>'路由地址错误!','data'=>$actFile));
  exit();
}

//执行文件名
$actFile= $website['path']['opt']['act'].'/'.implode('/',$act).'.php';

if($func !== 'act_global_login' && !isset($_SESSION['optLogin'])){
    echo json_encode(array('status'=>'error','msg'=>'login-fail','data'=>'登陆失效请重新登录!'));
    exit();
}

//数据库加入$website全局配置
$db	= new Database($website);
$website['class']['db']	= $db;


/*******************************网站根据链接寻找执行文件，及执行函数名*******************************/
//公共文件夹内的公共模块,以及系统管理员不需要检测权限
$usr = isset($_SESSION['optLogin']) ? fn_session($_SESSION['optLogin']) : array();
if($act[0] !== 'global'){

}


//加载函数文件错误
if(!is_file($actFile)){
    echo json_encode(array('status'=>'error','msg'=>'act','data'=>'无效文件'.$actFile));
    exit();
}
include_once($actFile);

//调用执行函数
if(function_exists($func)){
  $str = $func($website);
  if(is_string($str)){
    echo $str;
  }elseif(is_array($str)){
    echo json_encode($str);
  }
}else{//错误
  echo json_encode(array('status'=>'error','msg'=>'act','data'=>'无效函数 '.$func.'<br />'.$actFile));
  exit();
}
