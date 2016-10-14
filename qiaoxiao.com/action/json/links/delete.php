<?php



// 删除链接

// 插入一条新链接
$json = array('status'=>'error','msg'=>'error','data'=>'');

$lid  = $_GET['lid']??false;
if(!$lid || !is_numeric($lid)){
  $json['msg']    = 'id';
  $json['status'] = '链接ID错误!';
}else{
  $this->website['class']['db']
       ->table('links')
       ->where('id=?',$lid)
       ->delete();
  $json['status'] = 'ok';
  $json['msg'] = 'ok';
  $json['data'] = '删除成功!';
}




echo json_encode($json);
