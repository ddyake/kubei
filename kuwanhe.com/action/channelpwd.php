<?php
// 验证登录
$pwd = $_POST['pwd']??false;
$cid = $_POST['cid']??false;
$json= array('status'=>'error','msg'=>'error','data'=>'');


if(!$pwd){
  $json['data']='请输入密码!';
}elseif(!$cid || !is_numeric($cid)){
  $json['data']='渠道编号错误!';
}elseif(!$this->website['class']['db']
              ->table('box_channel')
              ->where('id=?',$cid)
              ->count()){
  $json['data']='未找到渠道信息!';
}else{
  $channel = $this->website['class']['db']
                ->table('box_channel')
                ->field('pwd')
                ->where('id=?',$cid)
                ->one();
  if($channel['pwd'] == $pwd){
    $_SESSION['channel'] = $cid;
    $json['status'] = 'ok';
    $json['msg'] = 'ok';
    $json['data'] = '登录成功!';
  }else{
    $json['data'] = '密码错误！';
  }
}






echo json_encode($json);
