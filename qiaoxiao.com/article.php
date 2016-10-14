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

$db = new Database($website);
// $arr=[];
// $arr['url'] = 'http://www.365j.com/ylfx/35377.html';
// $pages = detail_analyze($arr);
// print_r($pages);

// 娱乐资讯  5672
// 明星动态  5663 http://www.365j.com/ylfx/mxdt.html
// 影视资讯  5664 http://www.365j.com/ylfx/yszx.html
// 综艺资讯  5665 http://www.365j.com/ylfx/zyzx.html
// 趣说八卦  5666 http://www.365j.com/ylfx/bgtc.html
$ylzx = array(
  5663=>'http://www.365j.com/ylfx/mxdt.html',
  5664=>'http://www.365j.com/ylfx/yszx.html',
  5665=>'http://www.365j.com/ylfx/zyzx.html',
  5666=>'http://www.365j.com/ylfx/bgtc.html'
);
$upid = 5672;

foreach($ylzx as $tid=>$url){
  $str = curl_file_get_contents($url);
  $num = get_max_page($str);
  for($i=$num;$i>0;$i--){
    $pageUrl = $i== 1 ? $url : str_replace('.html','_'.$i.'.html',$url);
    // echo '当前分页页面-',$pageUrl.'<br />';
    $pageList= curl_file_get_contents($pageUrl);
    file_put_contents($website['path']['data'].'/temp.txt',json_encode(array('tid'=>$tid,'url'=>$ylzx[$tid],'page'=>$i)));
    // 返回文章一些信息   [tit ,image,url,time]
    $arr     = get_page_url($pageList);
    foreach($arr as $v){
      // 文章内容 数组[1=>'文章内容']  下标是分页数
      $details  = detail_analyze($v);
      $img      = image_save($website,$v['image'],$v);
      // 文章列表页图片
      $imgId    = 0;
      if($img){
        $imgId    = $db->table('article_image')
                       ->field('createtime','image')
                       ->value($v['time'],$img)
                       ->insert();
      }
      // 保存在文章总列表
      $aid      = $db->table('article')
                     ->field('upid','tid','imgid','createtime','page','tit')
                     ->value(5672,$tid,$imgId,$v['time'],count($details),$v['tit'])
                     ->insert();
      $details  = image_replace($website,$details,$v['time']);
      // 文章详细页写入数据库
      foreach($details as $k=>$v){
        $db->table('article_detail')
           ->field('aid','page','article')
           ->value($aid,$k,$v)
           ->insert();
      }
    }//foreach
  }
}

// 替换文章中的图片并保存在服务器中
function image_replace(&$website,&$details,&$time){
  foreach($details as $k=>&$detail){
    // 下载文章中的图片并替换
    preg_match_all('/src="(.*?)"/',$detail,$images);
    $search = [];
    $replace= [];
    foreach($images[1] as $vv){
      $image = curl_file_get_image($vv);
      $path = $website['path']['upload']['image'].'/'.date('Ym',$time).'/'.date('d',$time).'/'.basename($vv);
      if(is_file($path)){
        $path = $website['path']['upload']['image'].'/'.date('Ym',$time).'/'.date('d',$time).'/'.date('Ymd').basename($vv);
      }
      fn_mkdir(dirname($path));
      file_put_contents($path, $image);
      $search[] = $vv;
      $replace[]= str_replace($website['path']['root'],'',$path);
    }//foreach $images
    $detail = str_replace($search,$replace,$detail);
  }//foreach
  return $details;
}

// 保存图片返回图片相对地址
function image_save(&$website,&$url,&$arr){
  $image = curl_file_get_image($url);

  if($image){
    $path = $website['path']['upload']['image'].'/'.date('Ym',$arr['time']).'/'.date('d',$arr['time']).'/'.basename($url);
    if(is_file($path)){
      $path = $website['path']['upload']['image'].'/'.date('Ym',$arr['time']).'/'.date('d',$arr['time']).'/'.date('Ymd').basename($url);
    }
    fn_mkdir(dirname($path));
    file_put_contents($path, $image);
    return str_replace($website['path']['root'],'',$path);
  }else{
    return false;
  }
}



// 获取最大页数
function get_max_page(&$str){
  if(preg_match('/<div class="pages"><a class="on">1<\/a><a href="[\s\S]+?">(.*?)<\/a><\/div>/',$str,$arr)){
    if(preg_match_all('/<a href=".*?">(.*?)<\/a>/',$arr[0],$page)){
      return str_replace('...','',$page[1][count($page[1])-2]);
    }else{
      return 0;
    }
  }else{
   echo 0;
  }
}

// 返回列表中的详细页链接
function get_page_url(&$str){
  if(preg_match('/<dl>.*?<\/dl><div class="pages">/',$str,$arr)){
    preg_match_all('/<dl>(.*?)<\/dl>/',$arr[0],$detail);
    // [['tit'=>'标题','url'=>'详细页地址','image'=>'缩略图地址','time'=>'时间']]
    $list = array();
    foreach($detail[1] as $v){
      preg_match('/href="([\s\S]*?)"/',$v,$url);
      preg_match('/title="([\s\S]*?)"/',$v,$tit);
      preg_match('/data-original="([\s\S]*?)"/',$v,$image);
      preg_match('/<span class="time">([\s\S]*?)<\/span>/',$v,$time);

      $list[] = array(
        'tit'=>$tit[1],
        'url'=>$url[1],
        'image'=>$image[1],
        'time'=>mktime_get($time[1])
      );
    }
    return $list;
  }else{
    return 'none';
  }
}

// 解析文章，返回所有页数内容,并将图片下载到本地
function detail_analyze(&$arr){
// $arr = [title ,image,url,time]
  // echo '当前新闻详细页-'.$arr['url'];
  // $arr['url'] = 'http://www.365j.com/ylfx/48270.html'; //多页面
  //  $arr['url'] = 'http://www.365j.com/ylfx/48126.html'; //单页面
  $str = curl_file_get_contents($arr['url']);
  $page = [];
  // 多页内容
  if(preg_match('/<div class="news\_contet">([\s\S]*?)<\/div><div class="pages">/',$str,$arrs)){
    // print_r($arrs[1]);
    // 第一页内容
    $page[1] = preg_replace("#<a[^>]*>(.*?)</a>#is", "$1", $arrs[1]);
    // 总页数
    $maxPage = detail_max_page($str);

    for($i=2;$i<$maxPage;$i++){
      $url = str_replace('.html','_'.$i.'.html',$arr['url']);
      $cont= curl_file_get_contents($url);
      preg_match('/<div class="news\_contet">([\s\S]*?)<\/div><div class="pages">/',$cont,$cont);
      $page[$i] = preg_replace("#<a[^>]*>(.*?)</a>#is", "$1", $cont[1]);
    }
  }elseif(preg_match('/<div class="news\_contet">([\s\S]*?)<\/div>/',$str,$arrs)){// 单页内容
    $page[1] = preg_replace("#<a[^>]*>(.*?)</a>#is", "$1", $arrs[1]);
  }else{
    return false;
  }
  return $page;
}

function detail_max_page(&$str){
  preg_match('/<div class="pages"><a class="on">1<\/a>((<a href="[\s\S]*?">\d+<\a>)?)<a href="[\s\S]*?" title="下一页">下一页<\/a>/',$str,$p);
  preg_match_all('/<\/a>/',$p[0],$page);
  return count($page[0]);
}




// 分解时间
function mktime_get(&$time){
  // 2015年11月25日 15：47
  $arr = explode(' ',$time);
  $year= explode('年',$arr[0]);
  $arr[0] = str_replace($year[0].'年','',$arr[0]);
  $month= explode('月',$arr[0]);
  $arr[0] = str_replace($month[0].'月','',$arr[0]);
  $day= explode('日',$arr[0]);
  $times = explode('：',$arr[1]);
  return mktime( $times[0], $times[1], 0, $month[0], $day[0], $year[0]);
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
