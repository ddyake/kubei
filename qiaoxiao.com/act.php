<?php
session_start();
header("Content-Type:text/html;charset=utf-8");
date_default_timezone_set("Etc/GMT-8");//设置中国时区

require 'conf/website.conf.php';
require $website['path']['lib'].'/func.php';
require $website['path']['lib'].'/Website.class.php';
require $website['path']['lib'].'/WebError.class.php';
require $website['path']['lib'].'/Database.class.php';
require $website['path']['lib'].'/Template.class.php';
require $website['path']['lib'].'/Log.class.php';
require $website['path']['lib'].'/Adv.class.php';


// set_include_path($website['path']['lib']);
// spl_autoload_extensions('.class.php');
// spl_autoload('Website');
// spl_autoload('Error');
// spl_autoload('Database');
// spl_autoload('Log');
// spl_autoload('Template');
// echo '<!-- ';
// echo $website['url']['wap'],'------',$_SERVER['SERVER_NAME'];
// echo ' -->';

// 手机直接跳转域名
if(fn_device() != 'Pc' && strpos($website['url']['wap'],$_SERVER['HTTP_HOST']) === false){
  fn_jump_header($website['url']['wap'].
                  ($_SERVER["SERVER_PORT"] != '80' ? ':'.$_SERVER["SERVER_PORT"] : '').
                  $_SERVER["REQUEST_URI"]);
}

//链接上次URL
$website['url']['up']	= isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : $website['url']['root'];
$website['url']['now']	= 'http://'.
                        $_SERVER['HTTP_HOST'].
                        ($_SERVER["SERVER_PORT"] != '80' ? ':'.$_SERVER["SERVER_PORT"] : '').
                        $_SERVER["REQUEST_URI"];

// 广告来源记录
$adv  = new Adv($website);
$adv->count();

//网站开始
$main = new Website($website);
$main->website['class']['tpl']
  ->assign('website',$website)
  ->assign('css',0)
  ->assign('jss',0)
  ->assign('user',fn_session('user'))
  ->assign('url',urlencode($website['url']['now']))
  ->custom('fn_url','fn_url')
  ->custom('fn_substr','fn_substr');
$main->start();
