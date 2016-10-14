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


// set_include_path($website['path']['lib']);
// spl_autoload_extensions('.class.php');
// spl_autoload('Website');
// spl_autoload('Error');
// spl_autoload('Database');
// spl_autoload('Log');
// spl_autoload('Template');


//链接上次URL
$website['url']['up']	= isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : $website['url']['root'];
$website['url']['now']	= 'http://'.
                        $_SERVER['SERVER_NAME'].
                        ($_SERVER["SERVER_PORT"] != '80' ? ':'.$_SERVER["SERVER_PORT"] : '').
                        $_SERVER["REQUEST_URI"];
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
