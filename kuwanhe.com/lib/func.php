<?php
/*
 * 转换URL--后缀
 *$arr = array(href)
*/
function fn_url($args){
  global $website;

  $href= '/';
  if(is_string($args)){
    $href= $args;
  }elseif(is_array($args)){
    extract($args);
    if(is_array($href)){
      foreach($href as $k=>$v){
        $href[$k]=$v;
        // $href[$k]=$website['url']['root'].$v;
      }
    }
  }

  return $href;
  // return $href??'';
}



/*
 * 截取字符
 * $arr = array(str,len,sfx='...',start=0,coding='utf-8')
*/
function fn_substr($arr){
	/*
		$str,$len,$sfx='...',$start=0,$coding='utf-8'
	*/
	extract($arr);
	$sfx 	= isset($sfx) ? $sfx : '...';
	$start	= isset($start) ? $start : 0;
	$coding	= isset($coding) ? $coding : 'utf-8';
	$lens	= mb_strlen($str);
	if($len < $lens){
		return mb_substr($str,$start,$len,$coding).$sfx;
	}else{
		return $str;
	}
}

// 设备信息
function fn_device(){
  if(stristr($_SERVER['HTTP_USER_AGENT'],'iPad')) {
    return 'iPad';
  }elseif(stristr($_SERVER['HTTP_USER_AGENT'],'Android')) {
    return 'Android';
  }elseif(stristr($_SERVER['HTTP_USER_AGENT'],'Linux')){
    return 'Linux';
  }elseif(stristr($_SERVER['HTTP_USER_AGENT'],'iPhone')){
    return 'iPhone';
  }else{
    return 'Pc';
  }
}

// 浏览器信息
function fn_browser(){
  if (preg_match('/MSIE\s(\d+)\..*/i', $_SERVER['HTTP_USER_AGENT'], $regs)){
      return 'MSIE'.$regs[1];
  }elseif (preg_match('/FireFox\/(\d+)\..*/i', $_SERVER['HTTP_USER_AGENT'], $regs)){
      return 'Firefox'.$regs[1];
  }elseif (preg_match('/Opera[\s|\/](\d+)\..*/i', $_SERVER['HTTP_USER_AGENT'], $regs)){
      return 'Opera'.$regs[1];
  }elseif (preg_match('/Chrome\/(\d+)\..*/i', $_SERVER['HTTP_USER_AGENT'], $regs)){
      return 'Chrome'.$regs[1];
  }elseif((strpos($_SERVER['HTTP_USER_AGENT'],'Chrome')==false)&&strpos($_SERVER['HTTP_USER_AGENT'],'Safari')!==false){
    if(preg_match('/Version\/(\d+)\..* Safari/i',$_SERVER['HTTP_USER_AGENT'],$regs)){
      return 'Safari'.$regs[1];
    }else{
      return 'Safari';
    }
  }elseif(preg_match('/Edge\/([\d\.]+)/i', $_SERVER['HTTP_USER_AGENT'], $regs)){
    return 'Edge'.$regs[1];
  }else{
      return 'unknow';
  }
}

// 获取操作系统
function fn_os(){
  if (preg_match('/win/i', $_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], '95')){
      return 'Windows 95';
  }elseif(preg_match('/win 9x/i', $_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], '4.90')){
      return 'Windows ME';
  }elseif(preg_match('/win/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/98/', $_SERVER['HTTP_USER_AGENT'])){
      return 'Windows 98';
  }elseif(preg_match('/win/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/nt 6.0/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'Windows Vista';
  }elseif(preg_match('/win/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/nt 6.1/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'Windows 7';
  }elseif(preg_match('/win/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/nt 6.2/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'Windows 8';
  }else if(preg_match('/win/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/nt 10.0/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'Windows 10';#添加win10判断
  }elseif(preg_match('/win/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/nt 5.1/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'Windows XP';
  }elseif(preg_match('/win/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/nt 5/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'Windows 2000';
  }elseif(preg_match('/win/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/nt/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'Windows NT';
  }elseif(preg_match('/win/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/32/', $_SERVER['HTTP_USER_AGENT'])){
    return 'Windows 32';
  }elseif(preg_match('/win/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'Windows';
  }elseif(preg_match('/linux/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'Linux';
  }elseif(preg_match('/unix/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'Unix';
  }elseif(preg_match('/sun/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/os/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'SunOS';
  }elseif(preg_match('/ibm/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/os/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'IBM OS/2';
  }elseif(preg_match('/Mac OS X/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'Mac';
  }elseif(preg_match('/PowerPC/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'PowerPC';
  }elseif(preg_match('/AIX/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'AIX';
  }elseif(preg_match('/HPUX/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'HPUX';
  }elseif(preg_match('/NetBSD/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'NetBSD';
  }elseif(preg_match('/BSD/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'BSD';
  }elseif(preg_match('/OSF1/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'OSF1';
  }elseif(preg_match('/IRIX/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'IRIX';
  }elseif(preg_match('/FreeBSD/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'FreeBSD';
  }elseif(preg_match('/teleport/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'teleport';
  }elseif(preg_match('/flashget/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'flashget';
  }elseif(preg_match('/webzip/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'webzip';
  }elseif(preg_match('/offline/i', $_SERVER['HTTP_USER_AGENT'])){
    return 'offline';
  }else{
    return 'unknown';
  }
}


//获取访问者IP
function fn_ip(){
	$onlineip = '0';
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
    	$onlineip = getenv('HTTP_CLIENT_IP');
	}elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
	    $onlineip = getenv('HTTP_X_FORWARDED_FOR');
	}elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
	    $onlineip = getenv('REMOTE_ADDR');
	}elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
	    $onlineip = $_SERVER['REMOTE_ADDR'];
	}
	return $onlineip;
}



//获取IP信息需要百度API账户
function fn_ip_info($args){
  if(isset($args)){
    extract($args);
  }else{
    $ip = fn_ip();
  }
  $ch = curl_init();
    $url = 'http://apis.baidu.com/apistore/iplookupservice/iplookup?ip='.$ip;
    $header = array(
        'apikey: f61804e4125d35b6327635d8e91e223f',
    );
    // 添加apikey到header
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 执行HTTP请求
    curl_setopt($ch , CURLOPT_URL , $url);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}


//返回ip转换成无负数long
function fn_ip_long($ip=''){
  return bindec(decbin(ip2long($ip?$ip:fn_ip())));
}


//解析session里的值，返回数组
function fn_session($str){
    if(!isset($_SESSION[$str])){return 0;}
    return json_decode($_SESSION[$str],1);
}

// 判断用户的账户类型 返回 bool
function fn_authority(&$website,$authority,$name){
  // $authority   用户权限值  100000....
  // $name        用户权名称  doctor name.....
  if(array_key_exists($name,$website['authority'])){
    if($website['authority'][$name] == $authority){
      return true;
    }
  }
  return false;
}


//获取所有下级分类
function fn_next_type(&$website,$tid){
    $tps = $website['class']['db']
            ->table('type')
            ->field()
            ->where('upid=?',$tid)
            ->select();
    foreach($tps as $key=>$tp){
        if($website['class']['db']->table('type')->where('upid=?',$tp['id'])->count()){
            $tps[$key]['next'] = fn_next_type($website,$tp['id']);
        }
    }
    return $tps;
}

//功能：逐层创建文件夹
function fn_mkdir($path,$mode=0777,$recursive=false){
    $path   = dirname($path);
    $arr    = explode('/', $path);
    array_shift($arr);
    $paths  = '';
    foreach($arr as $v){
        $paths.='/'.$v;
        if(!is_dir($paths)){
            try{
              if(!mkdir($paths,$mode,$recursive)){
                  return '创建文件夹：'.$paths.'失败!';
              }
            }catch(Exception $e){
              return $e->getMessage();
            }
        }
    }
    return true;
}
// 功能:遍历文件夹 删除文件
// $path  完整地址
// $fname 文件名称
function fn_loop_del($path,$fname){

  $loop = function($path,$fname) use(&$loop){
    $arr = scandir($path);
    foreach($arr as $v){
      if($v == '.' || $v=='..'){
        continue;
      }elseif(is_dir($path.'/'.$v)){
        $loop($path.'/'.$v,$fname);
      }elseif(is_file($path.'/'.$v) && $v==$fname){
        unlink($path.'/'.$v);
      }else{
        continue;
      }
    }
  };
  $loop($path,$fname);
}


//格式化时间
function fn_format_time($args){
// args(
//   'time'=>''  LINUX时间
//   'format'=>'Y-m-d'   格式化
// )
  extract($args);

  return date($format,$time);

}


//获取当前星期一至星期日的日期
function fn_mon_to_sun(){
  //当前时间
  $now   = explode('-',date('Y-m-d'));
  //当前凌晨时间 linux格式
  $time  = mktime(0,0,0,$now[1],$now[2],$now[0]);
  //当前时间-(星期几-1)*一天的秒数=星期一时间
  $monday    = $time - (date('N')-1)*86400;
  $month     = array(date('Ymd',$monday));
  for($i=1;$i<7;$i++){
    array_push($month,date('Ymd',$monday+($i*86400)));
  }
  return $month;
}

//页面跳转
function fn_jump_url(&$website,$arrs){
  $arr = array(
    'url'=>$website['url']['root'],
    'alert'=>'必须登录后才能使用此功能!',
    'second'=>3
  );
  if(isset($arrs) && is_array($arrs)){
    $arr = array_merge($arr,$arrs);
  }

  $website['class']['tpl']
          ->assign('keywords','提示,百医网,wobaiyi.com')
          ->assign('description','提示')
          ->assign('tit','提示-百医网-wobaiyi.com')
          ->assign('alert',$arr)
          ->display('alert.tpl');
  exit();
}
//页面返回跳转
function fn_jump_back(&$website,$arrs){
  $arr = array(
    'alert'=>'必须登录后才能使用此功能!',
    'second'=>3
  );
  if(isset($arrs) && is_array($arrs)){
    $arr = array_merge($arr,$arrs);
  }
  $website['class']['tpl']
          ->assign('keywords',"提示,百医网,wobaiyi.com")
          ->assign('description','提示')
          ->assign('tit','提示-我百医-wobaiyi.com')
          ->assign('alert',$arr)
          ->display('alert.tpl');
  exit();
}
//直接跳转
function fn_jump_header($url){
  header('Location:'.$url);
  exit();
}
// 地址后退
function fn_jump_header_back(){
  header('Cache-control: private');
  exit();
}


//获取省市区  直辖市没有下级
function fn_province_city(&$website){
  $arr = $website['class']['db']
          ->table('type')
          ->field('id')
          ->where('upid='.$website['tid']['pivCit'])
          ->select();
  $pc  = array();
  foreach($arr as $v){
    //省 直辖市
    $arrs = $website['class']['db']
              ->table('type')
              ->field('id','tit','tp')
              ->where('upid='.$v['id'])
              ->select();
    //如果是直辖市就下一个
    foreach($arrs as $k=>$vv){
      $c = $website['class']['db']
                ->table('type')
                ->field('id','tit')
                ->where('upid='.$vv['id'])
                ->select();
      $vv['next'] = $c;
      array_push($pc,$vv);
    }
  }
  return $pc;
}

// 与当前时间比较
// 分钟级别  具体大于的分钟
// 小时级别  具体大于的小时
// 天级别    ........天
// 月       ........月
// 年       ........年
function fn_contrast_time($time){
  $contrast = $_SERVER['REQUEST_TIME']-$time;
  $year = 6060243012;
  $month= 60602430;
  $day  = 606024;
  $hour= 3600;
  $minute= 60;
  if($contrast > $year){
    return array('time'=>floor($contrast/$year),'val'=>'年');
  }elseif($contrast > $month){
    return array('time'=>floor($contrast/$month),'val'=>'月');
  }elseif($contrast > $day){
    return array('time'=>floor($contrast/$day),'val'=>'天');
  }elseif($contrast > $hour){
    return array('time'=>floor($contrast/$hour),'val'=>'小时');
  }elseif($contrast > $minute){
    return array('time'=>floor($contrast/$minute),'val'=>'分钟');
  }else{
    return array('time'=>$contrast,'val'=>'秒');
  }
}


//发送邮件
function fn_mail($to,
                 $message = '',
                 $from_email='admin@wobaiyi.com',
                 $from_user='百医网-wobaiyi.com',
                 $subject = '百医网系统邮件'){
 $headers = 'From: '.$from_email. "\r\n" .
            'Reply-To: '.$from_user. "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=UTF-8' . "\r\n";


 return mail($to, $subject, $message, $headers);
}

// 获取毫秒数
function fn_millisecond() {
  list($t1, $t2) = explode(' ', microtime());
  return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}


//根据 key 删除二维数组中的重复值
function fn_unique_multidim_array(&$array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

// 递归合并二维数组
function fn_array_merge_recursive_distinct ( array &$array1, array &$array2 ){
  $merged = $array1;
  foreach ( $array2 as $key => &$value ){
    if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) ){
      $merged [$key] = fn_array_merge_recursive_distinct ( $merged [$key], $value );
    }else{
      $merged [$key] = $value;
    }
  }
  return $merged;
}

// 返回医院等级
function fn_hospital_rank($rank){
  if(strlen($rank) != 2){
    return '';
  }else{
    $num = array('1'=>'一','2'=>'二','3'=>'三');
    $rak = array('1'=>'甲','2'=>'乙','3'=>'丙');
    $a   = substr($rank,0,1);
    $b   = substr($rank,1,1);
    if(!array_key_exists($a,$num)){
      return '';
    }elseif(!array_key_exists($b,$rak)){
      return '';
    }else{
      return $num[$a].'级'.$rak[$b].'等医院';
    }
  }
}


// 生成分页数----未完成
function fn_page(&$paging,$num){
  if($paging['maxPage']<$num || $paging['maxPage']-$num<=1){
    return array(
      'min'=>1,
      'max'=>$paging['maxPage']
    );
  }else{

    $max = ceil($paging['nowPage']/$num)*$num+1;

    $max = $max > $paging['maxPage'] ? $paging['maxPage']:$max;

    $min = $max-$num;
    return array('min'=>$min,'max'=>$max);
  }

}

// 发送短消息
function fn_sms($msg,$phone){
  $usr = '830017';
  $pwd = 'QW4YQIG1KD';
  $code= '10690203700433';
  $url = 'http://43.243.130.33:8860';
  $arr = array(
    'cust_code='.urlencode($usr),
    'destMobiles='.urlencode($phone),//手机号码，多个可用逗号隔开
    'content='.urlencode($msg),
    'sign='.urlencode(md5(urlencode($msg.$pwd))),
    'sp_code='.urlencode($code)
  );
  $data = implode('&',$arr);
  // print_r($data);echo '<br />';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  //为了支持cookie
  // curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}



// 获取中文首字母
function fn_china_charter($str){
  if (empty($str)) {
      return '';
  }elseif(preg_match('/^\d/',$str,$arr)){
    return $arr[0];
  }
  $fchar = ord($str{0});
  if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
  $s1 = iconv('UTF-8', 'gb2312', $str);
  $s2 = iconv('gb2312', 'UTF-8', $s1);
  $s = $s2 == $str ? $s1 : $str;
  $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
  if ($asc >= -20319 && $asc <= -20284) return 'A';
  if ($asc >= -20283 && $asc <= -19776) return 'B';
  if ($asc >= -19775 && $asc <= -19219) return 'C';
  if ($asc >= -19218 && $asc <= -18711) return 'D';
  if ($asc >= -18710 && $asc <= -18527) return 'E';
  if ($asc >= -18526 && $asc <= -18240) return 'F';
  if ($asc >= -18239 && $asc <= -17923) return 'G';
  if ($asc >= -17922 && $asc <= -17418) return 'H';
  if ($asc >= -17417 && $asc <= -16475) return 'J';
  if ($asc >= -16474 && $asc <= -16213) return 'K';
  if ($asc >= -16212 && $asc <= -15641) return 'L';
  if ($asc >= -15640 && $asc <= -15166) return 'M';
  if ($asc >= -15165 && $asc <= -14923) return 'N';
  if ($asc >= -14922 && $asc <= -14915) return 'O';
  if ($asc >= -14914 && $asc <= -14631) return 'P';
  if ($asc >= -14630 && $asc <= -14150) return 'Q';
  if ($asc >= -14149 && $asc <= -14091) return 'R';
  if ($asc >= -14090 && $asc <= -13319) return 'S';
  if ($asc >= -13318 && $asc <= -12839) return 'T';
  if ($asc >= -12838 && $asc <= -12557) return 'W';
  if ($asc >= -12556 && $asc <= -11848) return 'X';
  if ($asc >= -11847 && $asc <= -11056) return 'Y';
  if ($asc >= -11055 && $asc <= -10247) return 'Z';
  return '';
}

// 根据数字解析返回账户的权限名称
function fn_user_authority_resolve(&$authority){
  if($authority[0] != '1'){return 0;}
  $back = [];
  // 管理员
  if($authority[1] == '1'){
    $back[] = 'admin';
  }elseif($authority[1] == '2'){
    $back[] = 'edit';
  }
  return $back;
}
// 根据数组 返回权限数字
function fn_user_authority_num(&$arr){
  $authority=100000;
  if(in_array('admin',$arr) && in_array('edit',$arr)){
      unset($arr[array_search('edit', $arr)]);
  }
  if(in_array('edit',$arr)){$authority+=20000;}
  if(in_array('admin',$arr)){$authority+=10000;}

  return $authority;
}

// 返回一天之间的事件数
function fn_between_time($time=0){
  $time  = (isset($time) && $time) ? $time :$_SERVER['REQUEST_TIME'];
  $year  = date('Y',$time);
  $month = date('m',$time);
  $day   = date('d',$time);
  $first = mktime(0, 0, 0, $month, $day, $year);
  $last  = mktime(23,59,59, $month, $day, $year);
  return array('first'=>$first,'last'=>$last);
}
