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

phpinfo();



exit();
$db = new Database($website);
$i=1;
$max=2000;
$rand = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f');
while(1){
  if($i>$max){break;}
  $fid    = mt_rand(0,3);
  $r      = mt_rand(0,10);
  $time   = $_SERVER['REQUEST_TIME']-86400*$r;
  $mac    = implode('',array_slice($rand,0,12));
  $ip     = mt_rand(1,255).'.'.mt_rand(0,255).'.'.mt_rand(0,255).'.'.mt_rand(0,255);
  $bar    = mt_rand(0,1);
  $db->table('box_download')
     ->field('fid','createtime','ip')
     ->value($fid,$time,$ip)
     ->insert();
  $db->table('box_install')
    ->field('fid','createtime','mac','ip','bar')
    ->value($fid,$time,$mac,$ip,$bar)
    ->insert();
  if(mt_rand(0,1)){
    $db->table('box_open')
      ->field('fid','createtime','mac','ip','bar')
      ->value($fid,$time+86400,$mac,$ip,$bar)
      ->insert();
  }
  if(mt_rand(0,10)){
    $db->table('box_unstall')
      ->field('fid','createtime','mac','ip','bar')
      ->value($fid,$time,$mac,$ip,$bar)
      ->insert();
  }
  $i++;
}

exit();

function send(&$website,$action,$mac=0,$fid=0,$bar=0,$ip){
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
  $get = $get_file_content($str);
  // echo '<br />back:'.$get;
}


$i    = 0;
$max  = 1000;
$rand = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f');
$act  = array('install','open','download');

while(true){
  if($i==$max){break;}
  $action = $act[array_rand($act,1)];
  shuffle($rand);
  $mac    = implode('',array_slice($rand,0,12));
  $ip     = mt_rand(1,255).'.'.mt_rand(0,255).'.'.mt_rand(0,255).'.'.mt_rand(0,255);
  $fid    = mt_rand(0,5);
  $bar    = mt_rand(0,1);
    // send($website,$action,$mac,$fid,$bar,$ip);
    // if($action == 'download'){
    //   send($website,'install',$mac,$fid,$bar,$ip);
    // }
    // if(mt_rand(0,1)){
    //   send($website,'unstall',$mac,$fid,$bar,$ip);
    // }
  send($website,'download',$mac,$fid,$bar,$ip);
  send($website,'install',$mac,$fid,$bar,$ip);
  send($website,'open',$mac,$fid,$bar,$ip);
  if(mt_rand(0,3)){
    send($website,'unstall',$mac,$fid,$bar,$ip);
  }
  $i++;
}



exit();
$db = new Database($website);
$sql='';
for($i=0;$i<100;$i++){
  $mac = 70975886873441+$i;
  $ip  = 2130706433+$i;
  $t  = 1473609600+$i;
  $bar = $i%2?1:0;
  $ts = 86400+$t;
  $sql.= "insert into box_install(mac,ip,createtime,bar) values('{$mac}','{$ip}','{$t}','{$bar}');";
  $sql.= "insert into box_uninstall(mac,ip,createtime) values('{$mac}','{$ip}','{$t}');";
  $sql.= "insert into box_open(mac,ip,createtime) values('{$mac}','{$ip}','{$ts}');";
}
$db->exec($sql);



exit();

$jms = array('data'=>'ff-ff-ff-ff-ff-ff');
$data = base64_encode(json_encode($jms));
$datas= array('data'=>$data);
// $data = array('data'=>'123124');
$md5 = md5('0xFFFFFF192.168.10.1open2016090815'.$website['safe']['key']);
$url  = 'http://www.kuwanhe.com/lib/interface/box.php?mac=0xFFFFFF&ip=192.168.10.1&action=open&time=2016090815&md5='.$md5;
echo curl_file_get_contents($url);

// 游戏图片获取
// $db     = new Database($website);
//
// $cont   = file_get_contents($website['path']['root'].'/html.txt');
// $json   = json_decode($cont,1);
// // print_r($json);exit();
//
//
// foreach($json as $v){
//   $game = game_block($v['link']);
//   $image='';
//   // 保存图片
//   if($game['image']){
//     $img  = curl_file_get_image($game['image']);
//     $image= str_replace('http://icon.uuyyzs.com/ghallicon', '/data/upload/image',$game['image']);
//     $path = $website['path']['upload']['image'].str_replace('http://icon.uuyyzs.com/ghallicon', '',$game['image']);
//     fn_mkdir($path);
//     file_put_contents($path,$img);
//   }
//   // 保存头像
//   $icon  = curl_file_get_image($v['gbigicon']);
//   $iconImg= str_replace('http://icon.uuyyzs.com/biggbigicon', '/data/upload/icon',$v['gbigicon']);
//   $iconPath = $website['path']['upload']['icon'].str_replace('http://icon.uuyyzs.com/biggbigicon', '',$v['gbigicon']);
//   fn_mkdir($iconPath);
//   file_put_contents($iconPath,$icon);
//
//   $gid = $db->table('game')
//             ->field('tit','tag','image','icon','about')
//             ->value($game['tit'],$game['tag'],$image,$iconImg,$game['about'])
//             ->insert();
//   foreach($game['platform'] as $kk=>$vv){
//     $db->table('game_platform')
//       ->field('gid','tit','url')
//       ->value($gid,$vv,$kk)
//       ->insert();
//   }
// }





// 解析头像图片
function game_block(&$url){
  $str = curl_file_get_contents($url);
  $game=array('image'=>'','tit'=>'','tag'=>'','about'=>'','platform'=>[]);
  if(preg_match('/<div class="detimg"><img src="([\s\S]*?)"><\/div>/',$str,$arr)){
    $game['image'] = $arr[1];
  }

  if(preg_match('/<div class="fle"><div class="detname">(.*?)<\/div>(<span>.*?<\/span>)+<\/div>/',$str,$arr)){
    $game['tit'] = $arr[1];
    if(preg_match_all('/<span>([\s\S]*?)<\/span>/',$arr[0],$tag)){
      $game['tag'] = implode(',',$tag[1]);
    }
  }

  if(preg_match('/<div class="about">简介：([\s\S]*?)<\/div>/',$str,$arr)){
    $game['about'] = $arr[1];
  }

  if(preg_match_all('/<div class="constr"><a href="([\s\S]*?)">([\s\S]*?)<\/a><\/div>/',$str,$arr)){
    foreach($arr[1] as $k=>$v){
      $game['platform'][$v] = $arr[2][$k];
    }
  }

  return $game;
}




//模拟浏览器
function curl_file_post_data(&$url,&$data){

	$heads= array(
		//
		'Mozilla/5.0 (Windows NT 5.2) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.122 Safari/534.30',
		///
		'Mozilla/5.0 (Windows NT 5.1; rv:5.0) Gecko/20100101 Firefox/5.0',
		///
		'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.2; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C)',
		//
		'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C)',
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)',
		///
		'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)',
		//
		'Opera/9.80 (Windows NT 5.1; U; zh-cn) Presto/2.9.168 Version/11.50',
		///
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
		//
		'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727; .NET CLR 3.0.04506.648; .NET CLR 3.5.21022; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C)',
		///
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1',
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; ) AppleWebKit/534.12 (KHTML, like Gecko) Maxthon/3.0 Safari/534.12',
		//
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727; TheWorld)'
	);
	$ip  		= '125.210.188.'.mt_rand(1,254);



    $cont 		= '';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt ($ch, CURLOPT_HTTPHEADER, array('CLIENT-IP:'.$ip, 'X-FORWARDED-FOR:'.$ip));  //此处可以改为任意假IP
    curl_setopt($ch,CURLOPT_HTTPHEADER,array(
        'Accept-Language: zh-cn',
        'Connection: Keep-Alive',
        'Cache-Control: no-cache'
    ));
    curl_setopt($ch, CURLOPT_USERAGENT, $heads[mt_rand(0,11)]);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    // curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );

    $cont = curl_exec($ch);
    curl_close($ch);

	return $cont;
}

//代理服务器
/*	$proxys 	= file_get_contents('test.txt');
$proxys_arr = explode("\n", $proxys); //必须是双引号
$proxy 		= $proxys_arr[mt_rand(0,count($proxys_arr)-1)];*/
//模拟浏览器
function curl_file_get_contents(&$url){

	$heads= array(
		//
		'Mozilla/5.0 (Windows NT 5.2) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.122 Safari/534.30',
		///
		'Mozilla/5.0 (Windows NT 5.1; rv:5.0) Gecko/20100101 Firefox/5.0',
		///
		'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.2; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C)',
		//
		'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C)',
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)',
		///
		'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)',
		//
		'Opera/9.80 (Windows NT 5.1; U; zh-cn) Presto/2.9.168 Version/11.50',
		///
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
		//
		'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727; .NET CLR 3.0.04506.648; .NET CLR 3.5.21022; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C)',
		///
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1',
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; ) AppleWebKit/534.12 (KHTML, like Gecko) Maxthon/3.0 Safari/534.12',
		//
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727; TheWorld)'
	);
	$ip  		= '125.210.188.'.mt_rand(1,254);



    $cont 		= '';

    $ch = curl_init();
    //curl_setopt ($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt ($ch, CURLOPT_HTTPHEADER, array('CLIENT-IP:'.$ip, 'X-FORWARDED-FOR:'.$ip));  //此处可以改为任意假IP
    curl_setopt($ch,CURLOPT_HTTPHEADER,array(
        'Accept-Language: zh-cn',
        'Connection: Keep-Alive',
        'Cache-Control: no-cache'
    ));
    curl_setopt($ch, CURLOPT_USERAGENT, $heads[mt_rand(0,11)]);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");

    $cont = curl_exec($ch);
    curl_close($ch);

  	// $cont 	= mb_convert_encoding($cont, 'UTF-8','gb2312');
  	$cont   = preg_replace("/\r\n/", "", $cont);
  	$cont   = preg_replace("/\r/", "", $cont);
  	$cont   = preg_replace("/\n/", "", $cont);
    $cont 	= preg_replace("/\s{2}|\h{2}/", " ", $cont);
    $cont 	= preg_replace("/>[ ]+/si",">",$cont);
    $cont 	= preg_replace("/[ ]+>/si",">",$cont);
    $cont 	= preg_replace("/[ ]+</si","<",$cont);

    if(stripos($cont, '<title>访问人数过多，前方道路拥挤中。</title>')){
    	sleep(120);
    	$cont = curl_file_get_contents($url);
    }
	return $cont;
}



//获取图片内容
function curl_file_get_image(&$url) {
   $heads= array(
		//
		'Mozilla/5.0 (Windows NT 5.2) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.122 Safari/534.30',
		///
		'Mozilla/5.0 (Windows NT 5.1; rv:5.0) Gecko/20100101 Firefox/5.0',
		///
		'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.2; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C)',
		//
		'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C)',
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)',
		///
		'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E)',
		//
		'Opera/9.80 (Windows NT 5.1; U; zh-cn) Presto/2.9.168 Version/11.50',
		///
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
		//
		'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727; .NET CLR 3.0.04506.648; .NET CLR 3.5.21022; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C)',
		///
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1',
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; ) AppleWebKit/534.12 (KHTML, like Gecko) Maxthon/3.0 Safari/534.12',
		//
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727; TheWorld)'
	);
	$ip  		= '125.210.188.'.mt_rand(1,254);

	//代理服务器
/*	$proxys 	= file_get_contents('test.txt');
	$proxys_arr = explode("\n", $proxys); //必须是双引号
	$proxy 		= $proxys_arr[mt_rand(0,count($proxys_arr)-1)];*/

    $cont 		= '';

    $ch = curl_init();
    //curl_setopt ($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt ($ch, CURLOPT_HTTPHEADER, array('CLIENT-IP:'.$ip, 'X-FORWARDED-FOR:'.$ip));  //此处可以改为任意假IP
    curl_setopt($ch,CURLOPT_HTTPHEADER,array(
        'Accept-Language: zh-cn',
        'Connection: Keep-Alive',
        'Cache-Control: no-cache'
    ));
    curl_setopt($ch, CURLOPT_USERAGENT, $heads[mt_rand(0,11)]);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");

    $cont = curl_exec($ch);
    curl_close($ch);

	return $cont;
}
