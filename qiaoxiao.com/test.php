<?php
session_start();
header("Content-Type:text/html;charset=utf-8");
date_default_timezone_set("Etc/GMT-8");//设置中国时区

require 'conf/website.conf.php';
require 'lib/func.php';
require 'lib/Template.class.php';
require 'lib/Database.class.php';
require 'lib/Adv.class.php';

echo fn_ip_long('114.234.213.115');

//echo $_SERVER['HTTP_USER_AGENT'];

exit();
$db = new Database($website);
// 站长推送
$detail = $db->table('article')->field('id','pg','tid')->select();
$urls=[];
foreach($detail as $v){
  $tp = $v['tid'] != '5667' ? 'article':'picture';
  $urls[] = 'http://m.qiaoxiao.com/'.$tp.'/'.$v['id'].'.html';
  for($i=$v['pg'];$i>1;$i-- ){
    $urls[] = 'http://m.qiaoxiao.com/'.$tp.'/'.$v['id'].'_'.$i.'.html';
  }
}

$api = 'http://data.zz.baidu.com/urls?site=m.qiaoxiao.com&token=RbbznE6g4jon1k3D';
$ch = curl_init();
$options =  array(
    CURLOPT_URL => $api,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => implode("\n", $urls),
    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
);
curl_setopt_array($ch, $options);
$result = curl_exec($ch);

//echo $result;



exit();
$jm = array(
  'test'=>1,
  'test2'=>&$jm['test']
);
print_r($jm);

// phpinfo();
exit();

// phpinfo();
$image = '["sdfsdfsdfsfsfsfs"]';

$noDouble = function(&$image) use(&$noDouble){
  if(strlen($image)>5){
    $image = substr($image,0,-1);
    $noDouble($image);
  }else{
    echo $image;
  }

};
$noDouble($image);


exit();
$db = new Database($website);

$arr = $db->table('article')->field('id','tag')->where('uid != 0')->select();
foreach($arr as $v){
  $tag = str_replace('、','，',$v['tag']);
  $db->table('article')->field('tag')->value($tag)->where('id=?',$v['id'])->limit(1)->update();
}
