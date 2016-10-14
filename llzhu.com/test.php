<?php
session_start();
header("Content-Type:text/html;charset=utf-8");
date_default_timezone_set("Etc/GMT-8");//设置中国时区

require 'conf/website.conf.php';
require 'lib/Template.class.php';
require 'lib/Database.class.php';
require 'lib/func.php';


echo '<!DOCTYPE html><html><head><meta charset="utf-8" /></head><body>
  <video src="/1.mp4" autoplay controls>
  Your browser does not support the video tag.
  </video>

</body></html>';


$db= new Database($website);
// get_article($db,$website);//采集文章------未完成

// duanzi($website,$db); //段子采集
// joke($website,$db);   //笑话采集
// get_kx_img_1($db,$website); //各种图片
//meinvzipai($db,$website);  //美女自拍

// get_video($db,$website);//采集视频


// 采集视频
function get_video(&$db,&$website){
  $caiji = [
    array('tid'=>45,'str'=>'meinvshipin','max'=>39),
    array('tid'=>46,'str'=>'gaoxiaoshipin','max'=>3),
    array('tid'=>47,'str'=>'qinwenshipin','max'=>3),
    array('tid'=>48,'str'=>'buyashipin','max'=>3),
  ];
  // 获取当前页面上的视频地址
  $video = function(&$url){ //返回 [['tit'=>'标题','src'=>'视频地址']]
    $cont = curl_file_get_contents($url);
    $return=[];
    if(preg_match_all('/<div id="\d+" class="gaoxiao"><h4><a[\s\S]*?>([\s\S]*?)<\/a><\/h4>([\s\S]*?)<\/div>/',$cont,$arr)){
      $conts = $arr[2];
      $tit  = $arr[1];
      foreach($conts as $k=>$v){
        preg_match('/src="([\s\S]*?)"/',$v,$swf);
        $return[] = array('tit'=>$tit[$k],'src'=>$swf[1]);
      }
    }
    return $return;
  };
  foreach($caiji as $v){
    for($i=$v['max'];$i>0;$i--){
      $url = 'http://m.kx1d.com/'.$v['str'].'/index_'.$i.'.html';
      $videos = $video($url);
      print_r($videos);exit();
      foreach($videos as $v){

      }
    }
  }
}


// 采集文章---未完成
function get_article(&$db,&$website){
    $caiji = [
      array('tid'=>41,'str'=>'yulexinwen','list'=>'index','max'=>47),
      array('tid'=>42,'str'=>'shijian','list'=>'index','max'=>4),
      array('tid'=>43,'str'=>'toutiao','list'=>'index','max'=>25),
        array('tid'=>40,'str'=>'lieqi','list'=>'list','max'=>25),
    ];
    $rand= ['/201610/01/','/201610/02/','/201610/03/','/201610/04/','/201610/05/','/201610/06/','/201610/07/',
            '/201610/08/','/201610/09/','/201610/10/',
            '/201610/11/','/201610/12/','/201610/13/',
            '/201609/01/','/201609/02/','/201609/03/','/201609/04/','/201609/05/','/201609/06/','/201609/07/',
            '/201609/11/','/201609/12/','/201609/13/',
          ];
    $list = function(&$url){//返回[[tit,href,src]]
      $html = curl_file_get_contents($url);
      $return = [];
      if(preg_match('/<ul class="list">([\s\S]*?)<\/ul>/',$html,$arr)){

        preg_match_all('/<li>([\s\S]*?)<\/li>/',$arr[0],$lis);

        $li = array_slice($lis[1],0,count($lis[1])-2);
        foreach($li as $v){
          if(preg_match('/<a href="([\s\S]*?)"><img class="kt" src=\'([\s\S]*?)\' alt=\'([\s\S]*?)\'\/>/',$v,$article)){
            $return[] = array(
              'href'=>'http://m.kx1d.com'.$article[1],
              'tit'=>$article[3],
              'src'=>$article[2]
            );
          }
        }
      }
      return $return;
    };


    $articles = function(&$url){
      $article = function(&$url){
        $html = curl_file_get_contents($url);
        preg_match('/<div id="bj" class="cont">([\s\S]*?)<\/div><div class="pagearti">/',$html,$arr);
        echo $url;
        echo '<pre>',print_r($arr,1),'</pre>';exit();
        return $arr[1];
      };
      $html = curl_file_get_contents($url);
      $articles=[$article($url)];
      if(preg_match('/<span>1\/(\d+)页<\/span>/',$html,$counts)){
        $count = $counts[1];
      }
      for($i=2;$i<$count+1;$i++){
        $urls = str_replace('.html','_'.$i.'.html',$url);
        $articles[] = $article($urls);
      }
      return $articles;
    };

    // 保存图片到本地服务器
    $images = function(&$src) use(&$website){

    };


    foreach($caiji as $v){
      for($i=$v['max'];$i>0;$i--){
        $url = 'http://m.kx1d.com/'.$v['str'].'/'.$v['list'].'_'.$i.'.html';
        $lists = $list($url);
        foreach($lists as $v){
          $conts = $articles($v['href']);
          foreach($conts as &$v){
            preg_match_all('/src="([\s\S]*?)"/',$conts,$images);
            echo '<pre>',print_r($images,1),'</pre>';
          }

          exit();
        }
      }
    }
}

// 采集图片单独不同 美女自白
function meinvzipai(&$db,&$website){
  $rand= ['/201610/01/','/201610/02/','/201610/03/','/201610/04/','/201610/05/','/201610/06/','/201610/07/',
          '/201610/08/','/201610/09/','/201610/10/',
          '/201610/11/','/201610/12/','/201610/13/',
          '/201609/01/','/201609/02/','/201609/03/','/201609/04/','/201609/05/','/201609/06/','/201609/07/',
          '/201609/11/','/201609/12/','/201609/13/',
        ];
  $imgList = function(&$url){
    $html = curl_file_get_contents($url);
    $return = [];
    if(preg_match_all('/<div id="\d+" class="gaoxiao">(.*?)<\/div>/',$html,$arr)){
      foreach($arr[1] as $v){
        preg_match_all('/src="([\s\S]*?)"/',$v,$imgs);
        preg_match('/<h4><a href="[\s\S]*?">([\s\S]*?)<\/a><\/h4>/',$v,$tits);
        $return[] = array('tit'=>$tits[1],'image'=>$imgs[1]);
      }
    }
    return $return;
  };
  //max 158
  for($i=158;$i>0;$i--){
    $url = 'http://m.kx1d.com/meinvzipai/list_'.$i.'.html';
    $imgs = $imgList($url);
    foreach($imgs as &$v){
      foreach($v['image'] as &$image){
        $img = curl_file_get_image($image);
        $image  = '/data/upload/image'.$rand[array_rand($rand)].basename($image);
        $lpaths = $website['path']['root'].$image;
        fn_mkdir($lpaths);
        file_put_contents($lpaths,$img);
      }
      $aid = $db->table('article')
               ->field('tid','createtime','pg','tit','image')
               ->value(28,$_SERVER['REQUEST_TIME'],count($v['image']),$v['tit'],$v['image'][0])
               ->insert();
      foreach($v['image'] as $k=>$image){
        $db->table('article_image')
           ->field('page','aid','img')
           ->value($k+1,$aid,$image)
           ->insert();
      }
    }
  }
}

// 采集图片
function get_kx_img_1(&$db,&$website){

  $rand= ['/201610/01/','/201610/02/','/201610/03/','/201610/04/','/201610/05/','/201610/06/','/201610/07/',
          '/201610/08/','/201610/09/','/201610/10/',
          '/201610/11/','/201610/12/','/201610/13/',
          '/201609/01/','/201609/02/','/201609/03/','/201609/04/','/201609/05/','/201609/06/','/201609/07/',
          '/201609/11/','/201609/12/','/201609/13/',
        ];
  $manhua = [
    // 漫画系列
      // 邪恶漫画
      array('str' => 'xieemanhua','max' => 26,'tid' => 22),
      // 少女漫画
      array('str' => 'shaonvmanhua','max' => 23,'tid' => 23),
      // 耽美漫画
      array('str' => 'danmeimanhua','max' => 3,'tid' => 24),
      // 内涵漫画
      array('str' => 'neihanmanhua','max' => 15,'tid' => 25),
      // 日本漫画
      array('str' => 'ribenmanhua','max' => 17,'tid' => 26),

      // 搞笑图片
      array('str' => 'gaoxiaotupian','max' => 131,'tid' => 29),
      // 美女图片
      array('str' => 'meinvtupian','max' => 63,'tid' => 30),
      // 邪恶图片
      array('str' => 'xieetupian','max' => 101,'tid' => 31),

      // 动态图
      // 邪恶动态图片
      array('str' => 'xieegif','max' => 736,'tid' => 33),
      // 美女动态图片
      array('str' => 'meinvdongtaitu','max' => 53,'tid' => 34),
      // 搞笑动态图片
      array('str' => 'gaoxiaodongtaitu','max' => 111,'tid' => 35),
      // 漫画动态图片
      array('str' => 'xieemanhuadongtaitu','max' => 7,'tid' => 36),


    ];

  // 列表页分页  返回[[href=详细页,src=列表图,tit=标题]]
  $caricature_list = function(&$url,&$str){
    $html = curl_file_get_contents($url);
    $return=[];
    if(preg_match('/<ul class="list">.*?<\/ul>/',$html,$arr)){
      if(preg_match_all('/<li><a href="([\s\S]*?)"><img class="kt" src=\'([\s\S]*?)\' alt=\'([\s\S]*?)\'\/><h3>[\s\S]*?<\/h3><\/a><\/li>/',$arr[0],$list)){
        // $href = array_slice($list[1],0,count($list[1])-2);//  http://m.kx1d.com + /xieemanhua/2291.html
        // $src  = array_slice($list[2],0,count($list[1])-2);
        // $tit  = array_slice($list[3],0,count($list[1])-2);
        foreach($list[1] as $k=>$v){
          if(strripos($v,$str) !== false){
            $return[] = array(
              'href'=>'http://m.kx1d.com'.$v,
              'src'=>$list[2][$k],
              'tit'=>$list[3][$k]
            );
          }
        }
      }
    }
    return $return;
  };

  // 获取内容页内容
  $caricature_cont =function(&$url){
    $html = curl_file_get_contents($url);
    $return = [];
    // 获取具体图片
    $caricature_image = function(&$url){
      $html = $html = curl_file_get_contents($url);
      if(preg_match('/<div id="\d+" class="warp">.*?<\/div>/',$html,$arr)){
        preg_match('/src="([\s\S]*?)"/',$arr[0],$src);
        return $src[1];
      }
    };
    if(preg_match('/<span>1\/(\d+)页<\/span>/',$html,$arr)){// 多页
      $page = $arr[1]+1;
      $return[] = $caricature_image($url);
      for($i=2;$i<$page;$i++){
        $urls     = str_replace('.html','_'.$i.'.html',$url);
        $return[] = $caricature_image($urls);
        // echo $urls,'<br/>';
      }
    }else{//单页
      $return[] = $caricature_image($url);
    }
    return $return;
  };


  foreach($manhua as $v){
    $str = $v['str'];
    $max = $v['max'];
    $tid = $v['tid'];
    for($i=$max;$i>0;$i--){
      $url = 'http://m.kx1d.com/'.$str.'/index_'.$i.'.html';
      // echo 'urllist:',$url,'<br/>';
      if(@fopen($url,"r")){
        $list = $caricature_list($url,$str);
        // echo 'list:'.print_r($list),'<br/>';exit();
        foreach($list as $v){
          // 列表图
          $limg = curl_file_get_image($v['src']);
          $lpath  = '/data/upload/image'.$rand[array_rand($rand)].basename($v['src']);
          $lpaths = $website['path']['root'].$lpath;
          fn_mkdir($lpaths);
          file_put_contents($lpaths,$limg);
          // 内容页图片
          $images = $caricature_cont($v['href']);
          // echo $v['href'].'   '.count($images),'<br />';
          // 写入标题表
          $aid  = $db->table('article')
                     ->field('tid','createtime','pg','tit','image')
                     ->value($tid,$_SERVER['REQUEST_TIME'],count($images),$v['tit'],$lpath)
                     ->insert();
          foreach($images as $k=>$img){
            $image = curl_file_get_image($img);
            $path  = '/data/upload/image'.$rand[array_rand($rand)].basename($img);
            $paths = $website['path']['root'].$path;
            fn_mkdir($paths);
            file_put_contents($paths,$image);
            // 写入图片内容表
            $aid  = $db->table('article_image')
                       ->field('page','aid','img')
                       ->value($k+1,$aid,$path)
                       ->insert();
          }
        }
      }
    }
  }


}

// 笑话 http://m.kx1d.com/xiaohua/list_130.html
function joke(&$website,&$db){
  // 获取该页内笑话返回数组  [array('tit'=>'标题','cont'=>'内容')]
  $joke_list=function(&$html){
    $arr = [];
    $return=[];
    if(preg_match_all('/<div id="\d+" class="gaoxiao"><h4>([\s\S]*?)<\/h4><div id="dz" class="cont">([\s\S]*?)<\/div>/',$html,$arr)){
      foreach($arr[1] as $k=>$v){
        $return[] = array('tit'=>strip_tags($v),'cont'=>strip_tags($arr[2][$k]));
      }
    }
    return $return;
  };

  for($i=130;$i>0;$i--){
    $url  = 'http://m.kx1d.com/xiaohua/list_'.$i.'.html';
    $html = curl_file_get_contents($url);
    $arr = $joke_list($html);
    foreach($arr as $v){
      $db->table('article_joke')
         ->field('tid','createtime','tit','cont')
         ->value(37,$_SERVER['REQUEST_TIME'],$v['tit'],$v['cont'])
         ->insert();
    }

  }

}

// 段子 http://m.kx1d.com/duanzi/index_2.html
function duanzi(&$website,&$db){
  // 获取该页内笑话返回数组  [array('tit'=>'标题','cont'=>'内容')]
  $joke_list=function(&$html){
    $arr = [];
    $return=[];
    if(preg_match_all('/<div id="\d+" class="gaoxiao"><h4>([\s\S]*?)<\/h4><div id="dz" class="cont">([\s\S]*?)<\/div>/',$html,$arr)){
      foreach($arr[1] as $k=>$v){
        $return[] = array('tit'=>strip_tags($v),'cont'=>strip_tags($arr[2][$k]));
      }
    }
    return $return;
  };

  for($i=401;$i>0;$i--){
    $url  = 'http://m.kx1d.com/duanzi/index_'.$i.'.html';
    $html = curl_file_get_contents($url);
    $arr = $joke_list($html);
    foreach($arr as $v){
      $db->table('article_joke')
         ->field('tid','createtime','tit','cont')
         ->value(38,$_SERVER['REQUEST_TIME'],$v['tit'],$v['cont'])
         ->insert();
    }

  }

}


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
