<?php
// 渠道商查看数据页面
$cid = $_GET['cid']??false;
$login= isset($_SESSION['channel']) && $_SESSION['channel'] ?$_SESSION['channel']:false;
$date= $_GET['date']??false;


if(isset($_SESSION['channel']) && $_SESSION['channel']){
  $channel = $this->website['class']['db']
                  ->table('box_channel')
                  ->field('tit','scale')
                  ->where('id=?',$_SESSION['channel'])
                  ->one();
  if(!$date){
    $date   = $_SERVER['REQUEST_TIME'];
  }else{
    $dates = explode('-',$date);
    if(count($dates)!=3){
      $date   = $_SERVER['REQUEST_TIME'];
    }else{
      $date = mktime(0,0,0,$dates[1],$dates[2],$dates[0]);
    }
  }
  $time   = fn_between_time($date);
  $count    = $this->website['class']['db']
                             ->table('box_install')
                             ->where('createtime between ? and ? and fid=?',$time['first'],$time['last'],$_SESSION['channel'])
                             ->count();
 $channel['num'] = floor($count*($channel['scale']/100));
 // $channel['num'] = $count;
  $this->website['class']['tpl']
       ->assign('channel',$channel);
  // print_r($this->website['class']['db']->sql);
}






// 游戏推荐
$this->website['class']['tpl']
    ->assign('css',array('/css/channel.css','/opt/js/ui/ui.css'))
    ->assign('jss',array('/js/channel.js','/opt/js/ui/ui.js'))
    ->assign('tit','查看数据')
    ->assign('keywords','查看数据')
    ->assign('description','查看数据')
    ->assign('cid',$cid)
    ->assign('login',$login)
    ->assign('date',$date)
    ->display('channel/index.tpl');
