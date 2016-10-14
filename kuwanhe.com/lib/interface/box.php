<?php
header("Content-Type:text/html;charset=utf-8");
date_default_timezone_set("Etc/GMT-8");//设置中国时区
require '../../conf/website.conf.php';
require $website['path']['lib'].'/func.php';
require $website['path']['lib'].'/Database.class.php';
// 游戏盒子接口
// base64加密数据
// 数据格式
// mac='网卡地址'&
// action='open|install|unstall|download'&
// time='20161002'&
// bar='0|1'&
// md5='md5地址(mac+action+time+key)'
// fid='客户端编号'



if(!isset($_GET['mac'])){
  echo 'error-no-mac';
}else{
  $data =array(
    'mac'     => $_GET['mac'],
    'action'  => $_GET['action'],
    'time'    => $_GET['time'],
    'bar'     => $_GET['bar']??0,
    'md5'     => $_GET['md5'],
    'fid'     => $_GET['fid']??0,
    'ip'      => (isset($_GET['ip']) && $_GET['ip'])?$_GET['ip']:fn_ip()
  );
  $BOX  = new Box($website,$data);
}




class Box{
  // 站内信息
  var $website;
  // 数据信息
  var $data;
  function __construct(&$website,&$data){
    $this->website = $website;
    $this->website['class']['db'] = new Database($website);
    $this->data = $data;
    // 异常数据处理
    if(!$this->analyze()){
      $this->abnormal(json_encode($data));
      echo 'error-'.$this->data.'abnormal';
    }else{
      $this->abnormal(json_encode($data));
      switch($this->data['action']){
        case 'open':
          echo 'open:',$this->open();
          break;
        case 'unstall':
          echo 'unstall:',$this->unstall();
          break;
        case 'install':
          echo 'install:',$this->install();
          break;
        case 'download':
          echo 'download:',$this->download();
          break;
        detault:
          $this->abnormal('no-action:'.json_encode($data));
          echo 'error:no-action';
      }
    }
  }

  private function analyze(){
    $md5 =md5(
        $this->data['mac'].
        $this->data['action'].
        $this->website['safe']['key']
    );

    if($md5 != $this->data['md5']){//md5
      $this->data='md5('.$md5.'):';
      return false;
    }else{
      $this->data['mac'] = hexdec(str_replace(array('-',':'),'',$this->data['mac']));
      $this->data['ip']  = $this->data['ip']?fn_ip_long($this->data['ip']):fn_ip_long();

      return true;
    }
  }

  // 异常数据处理
  private function abnormal($data){
    return $this->website['class']['db']
                 ->table('box_abnormal')
                 ->field('createtime','ip','data')
                 ->value(
                  $_SERVER['REQUEST_TIME'],
                  fn_ip_long(),
                  $data
                 )
                 ->insert();
  }


  // 打开游戏
  private function open(){
    // 用来判断每天开机一次就记录一次信息
    $date = fn_between_time();
    if(!$this->website['class']['db']
             ->table('box_open')
             ->where('createtime between ? and ? and mac=?',$date['first'],$date['last'],$this->data['mac'])
             ->count()){
      $fid = $this->channel();
      $this->website['class']['db']
          ->table('box_open')
          ->field('fid','createtime','mac','ip','bar')
          ->value(
            $fid,
            $_SERVER['REQUEST_TIME'],
            $this->data['mac'],
            $this->data['ip'],
            $this->data['bar'])
          ->insert();
      // echo '<br/>open-database:',$this->website['class']['db']->sql,'<br />';
    }
    return 0;
  }

  // 卸载记录
  private function unstall(){
    if(!$this->website['class']['db']
            ->table('box_unstall')
            ->where('mac=?',$this->data['mac'])
            ->count()){
      $fid = $this->channel();
      // echo '<br/>sql：',$this->website['class']['db']->sql,'<br/>';
      // echo 'fid:',$fid;
      $this->website['class']['db']
            ->table('box_unstall')
            ->field('fid','createtime','mac','ip','bar')
            ->value(
              $fid,
              $_SERVER['REQUEST_TIME'],
              $this->data['mac'],
              $this->data['ip'],
              $this->data['bar']
            )
            ->insert();
      // 增加渠道卸载量
      if($fid){
        $this->website['class']['db']->exec('update `box_channel` set `unstall`=`unstall`+1 where id='.$fid);
      }
    }
    return 0;
  }
  // 安装记录
  private function install(){
    // 判断用户是否已经安装过
    if(!$this->website['class']['db']
             ->table('box_install')
             ->where('mac=?',$this->data['mac'])
             ->count()){
      $field = array('createtime','bar','mac','ip');
      $value = array($_SERVER['REQUEST_TIME'],$this->data['bar'],$this->data['mac'],$this->data['ip']);
      $time  = fn_between_time();
      $download = $this->website['class']['db']
                         ->table('box_download')
                         ->field('fid')
                         ->where('ip=? and createtime between ? and ?',$this->data['ip'],$time['first'],$time['last'])
                         ->one();
      // echo '<br/>download：',$this->website['class']['db']->sql;
      // 判断是否渠道安装
      if(isset($download) && $download['fid']){
        $field[] = 'fid';
        $value[] = $download['fid'];
        // 下载数据更新
        $this->website['class']['db']
            ->table('box_download')
            ->field('bar')
            ->value($this->data['bar'])
            ->where('ip=?',$this->data['ip'])
            ->update();
        // echo '<br/>update-download：',$this->website['class']['db']->sql;
        // 更新渠道商安装数
        $channel= array();
        // 是否网吧安装
        if($this->data['bar']){$channel[] = '`bar`=`bar`+1';}
        $channel[] = '`install`=`install`+1';
        // 渠道商更新安装数
        $this->website['class']['db']->exec('update `box_channel` set '.implode(',',$channel).' where id='.$download['fid']);
      }

       //  插入安装数据
      $this->website['class']['db']
          ->table('box_install')
          ->field($field)
          ->value($value)
          ->insert();
      // echo '<br/>install：',$this->website['class']['db']->sql;
    }
    return 0;
  }

  // 下载记录
  private function download(){
    // $time = fn_between_time();
    // if(!$this->website['class']['db']
    //        ->table('box_download')
    //        ->where('ip=? and createtime between ? and ?',$this->data['ip'],$time['first'],$time['last'])
    //        ->count()){
    $this->website['class']['db']
            ->table('box_download')
            ->field('bar','ip','fid','createtime')
            ->value(
              $this->data['bar'],
              $this->data['ip'],
              $this->data['fid'],
              $_SERVER['REQUEST_TIME']
            )
            ->insert();
    // }
    return 0;
  }

  // 判断渠道
  private function channel(){
    // 获取渠道id
    $install = $this->website['class']['db']
                    ->table('box_install')
                    ->field('fid')
                    ->where('mac=?',$this->data['mac'])
                    ->one();
    return $install['fid']??0;
  }

}
