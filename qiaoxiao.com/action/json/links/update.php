<?php
require 'public.php';
// 更新一条新链接
$json = array('status'=>'error','msg'=>'error','data'=>'');

$image = $_POST['image']??false;
$lid  = $_POST['id']??false;
if(!$lid || !is_numeric($lid)){
  $json['msg']    = 'lid';
  $json['data'] = '链接编号错误!';
}else{
  $field=[];
  $value=[];
  if(isset($_POST['tit'])){$field[] = 'tit';$value[]=$_POST['tit'];}
  if(isset($_POST['cont'])){$field[] = 'cont';$value[]=$_POST['cont'];}
  if(isset($_POST['href'])){$field[] = 'href';$value[]=$_POST['href'];}
  if($image){
    $image = global_img_save_img($this->website,$image);
    $field[] = 'image';
    $value[] = $image;
  }
  $json['lid'] = $this->website['class']['db']
                       ->table('links')
                       ->field($field)
                       ->value($value)
                       ->where('id=?',$lid)
                       ->limit(1)
                       ->update();
  $json['status'] = 'ok';
  $json['msg']    = 'ok';
  $json['data']   = '链接更新成功!';
}





echo json_encode($json);
