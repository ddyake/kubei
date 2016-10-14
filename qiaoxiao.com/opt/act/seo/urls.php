<?php

// 发送推送链接
function act_urls_push(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'');
  $time = $_GET['time']??false;
  if(!$time){
    $json['msg']='time';
    $json['data']='请选择时间!';
  }else{
    $time = explode('-',$time);
    $ctime= mktime(0,0,0,$time[1],$time[2],$time[0]);
    $btw  = fn_between_time($ctime);
    $detail = $website['class']['db']
              ->table('article')
              ->where('createtime between ? and ?',$btw['first'],$btw['last'])
              ->field('id','pg','tid')
              ->select();

    $wUrls=[];
    $mUrls=[];
    foreach($detail as $v){
      $tp = $v['tid'] != '5667' ? 'article':'picture';
      $mUrls[] = 'http://m.qiaoxiao.com/'.$tp.'/'.$v['id'].'.html';
      $wUrls[] = 'http://www.qiaoxiao.com/'.$tp.'/'.$v['id'].'.html';
      for($i=$v['pg'];$i>1;$i-- ){
        $mUrls[] = 'http://m.qiaoxiao.com/'.$tp.'/'.$v['id'].'_'.$i.'.html';
        $wUrls[] = 'http://www.qiaoxiao.com/'.$tp.'/'.$v['id'].'_'.$i.'.html';
      }
    }

    $domainM = 'm.qiaoxiao.com';
    $domainW = 'www.qiaoxiao.com';

    $json['status'] = 'ok';
    $json['msg']    = 'ok';
    $json['data']   = array('m'=> fn_baidu_push($domainM,$mUrls),'w'=> fn_baidu_push($domainW,$wUrls));
  }
  return json_encode($json);
}



function act_urls_curl(&$api,$urls){
  $ch = curl_init();
  $options =  array(
      CURLOPT_URL => $api,
      CURLOPT_POST => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POSTFIELDS => implode("\n", $urls),
      CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
  );
  curl_setopt_array($ch, $options);
  return curl_exec($ch);
}
