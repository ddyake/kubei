<?php
// 站内统计
// namespace QiaoXiao;


class Adv{
  var $webisite;

  function __construct(&$website){
    $this->website = $website;
    if(!isset($this->website['class']['db']) || !is_object($this->website['class']['db'])){
      $this->website['class']['db']=new Database($website);
    }
  }


  // 开始统计
  function count(){
    // 检测来源方式 A post get标签跳转为1 否则为0
    $jump = 0;
    if($_SERVER['HTTP_REFERER']??false){
      $jump = 1;
    }
    $cid = $_GET['channel']??false;

    // 获取cid
    $adv = fn_session('adv');// json数据
    if($cid || ($adv && isset($adv['cid']) && $adv['cid'])){
      $id = $_GET['aid']??$_GET['pid'];
      $domain = '';
      $source = '';

      if($jump){
        preg_match('/^(http:\/\/)?([^\/]+)/i', $_SERVER['HTTP_REFERER'], $matches);
        $host = $matches[2];
        // 从主机名中取得后面两段
        preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
        $domain = $matches[0];
        $source = $_SERVER['HTTP_REFERER'];
      }
      if(!isset($adv['cid'])){
        $_SESSION['adv'] = json_encode(array('cid'=>$cid,'id'=>[$id]));
      }else{
        if(!in_array($id,$adv['id'])){
          $adv['id'][]= $id;
          $_SESSION['adv'] = json_encode($adv);
        }
      }

      $this->website['class']['db']
           ->table('adv_count')
           ->field('cid','createtime','jump','ip','os','device','browser','domain','source','url','info')
           ->value(
            $cid,
            $_SERVER['REQUEST_TIME'],
            $jump,
            fn_ip_long(fn_ip()),
            fn_os(),
            fn_device(),
            fn_browser(),
            $domain,
            $source,
            $this->website['url']['now'],
            $_SERVER['HTTP_USER_AGENT'].' ip：'.fn_ip()
           )
           ->insert();
    }
  }


}
