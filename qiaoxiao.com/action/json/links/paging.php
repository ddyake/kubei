<?php


$json = array('status'=>'error','msg'=>'error','data'=>'');
$tid  = $_GET['tid']??false;
if(!$tid){
  $json['status']='tid';
  $json['data'] = '分类id错误!';
}else{
  $p=$_GET['p']??1;
  $json['data'] = $this->website['class']['db']
                       ->table('links')
                       ->field('id','tit','href','image','cont')
                       ->where('tid=?',$tid)
                       ->num(10)
                       ->order('id desc')
                       ->page($p)
                       ->paging();
  $json['status'] = 'ok';
  $json['msg'] = 'ok';
  $json['tp']  = $this->website['class']['db']
                      ->table('type')
                      ->field('tit')
                      ->where('id=?',$tid)
                      ->one();
  // $json['sql'] = $this->website['class']['db']->sql;
}


echo json_encode($json);
