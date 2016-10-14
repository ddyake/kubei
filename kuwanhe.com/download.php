<?php
date_default_timezone_set("Etc/GMT-8");//设置中国时区
require 'conf/website.conf.php';
require $website['path']['lib'].'/func.php';

function send(&$website,$action,$ip,$fid=0,$bar=0,$mac=0){
  $get_file_content = function($durl){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $durl);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_USERAGENT, 'self');
    curl_setopt($ch, CURLOPT_REFERER,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
  };
  // 发送地址
  $str  = 'http://www.kuwanhe.com/lib/interface/box.php?'.
          '&mac='.$mac.
          '&action='.$action.
          '&time='.date('YnjG').
          '&md5='.md5($mac.$action.date('YnjG').$website['safe']['key']).
          '&ip='.($ip??fn_ip()).
          '&bar='.($bar).
          '&fid='.$fid;

  // 获取数据
  $get_file_content($str);
}




$file_path= 'download/KuwanSetup.exe';
$filepath = $website['path']['root'].'/'.$file_path;
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($filepath));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));

readfile($file_path);

$fid = $_GET['id']??0;
$bar = $_GET['bar']??0;
send($website,'download',fn_ip(),$fid,$bar);


exit();
