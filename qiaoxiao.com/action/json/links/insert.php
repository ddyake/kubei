<?php
require 'public.php';
// 插入一条新链接
$json = array('status'=>'error','msg'=>'error','data'=>'');

$tit  = $_POST['tit']??false;
$tid  = $_POST['tid']??false;
$image = $_POST['image']??'';

if(!$tid){
  $json['msg']    = 'tid';
  $json['status'] = '分类错误!';
}elseif(!$tit){
  $json['msg']    = 'tit';
  $json['data'] = '请输入标题';
}else{
  if($image){
    $image = global_img_save_img($this->website,$image);
  }
  $json['lid'] = $this->website['class']['db']
                       ->table('links')
                       ->field('tid','tit','href','image','cont')
                       ->value($tid,$tit,$_POST['href'],$image,$_POST['cont'])
                       ->insert();
  $json['status'] = 'ok';
  $json['msg']    = 'ok';
  $json['data']   = '链接创建成功!';
}





echo json_encode($json);
