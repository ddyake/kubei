<?php
// 渠道商相关


function act_channel_select(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'');
  $cid  = $_GET['cid']??false;
  if(!$cid || !is_numeric($cid)){
    $json['msg'] = 'cid';
    $json['data']= '渠道编号错误!';
  }elseif(!$website['class']['db']
           ->table('box_channel')
           ->where('id=?',$cid)
           ->count()){
     $json['msg'] = 'cid';
     $json['data']= '未找到渠道!';
  }else{
    $json['data'] = $website['class']['db']
                    ->table('box_channel')
                    ->where('id=?',$cid)
                    ->one();
    $json['status'] = 'ok';
    $json['msg']    = 'ok';
  }

  return json_encode($json);
}
function act_channel_update(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'');
  $tit  = $_POST['tit']??false;
  $pwd  = $_POST['pwd']??false;
  $cid  = $_POST['cid']??false;
  // tit:$tit.val(),
  // num:$num.text(),
  // pwd:$pwd.val(),
  // url:$down.find('option:selected').val()
  if(!$cid || !is_numeric($cid)){
    $json['msg'] = 'cid';
    $json['data']= '渠道编号错误!';
  }elseif(!$tit){
    $json['msg'] = 'tit';
    $json['data']= '渠道名称不能为空!';
  }elseif(!$pwd){
    $json['msg'] = 'tit';
    $json['data']= '渠道查看密码不能为空!';
  }else{
     $website['class']['db']
        ->table('box_channel')
        ->field('tit','scale','pwd')
        ->value($tit,$_POST['scale'],$pwd)
        ->where('id=?',$cid)
        ->update();
    $json['data'] = '修改成功!';
    $json['msg'] = 'ok';
    $json['status']='ok';
  }
  return json_encode($json);
}
function act_channel_insert(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'');
  $tit  = $_POST['tit']??false;
  $pwd  = $_POST['pwd']??false;

  if(!$tit){
    $json['msg'] = 'tit';
    $json['data']= '渠道名称不能为空!';
  }elseif(!$pwd){
    $json['msg'] = 'tit';
    $json['data']= '渠道查看密码不能为空!';
  }else{
    $json['data'] = $website['class']['db']
                    ->table('box_channel')
                    ->field('createtime','tit','scale','pwd')
                    ->value($_SERVER['REQUEST_TIME'],$tit,$_POST['scale'],$pwd)
                    ->insert();
    $json['msg'] = 'ok';
    $json['status']='ok';
    // $json['sql']=$website['class']['db']->sql;
  }
  return json_encode($json);
}



// 删除渠道信息
function act_channel_delete(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'');
  $cid  = $_GET['cid']??false;
  if(!$cid || !is_numeric($cid)){
    $json['msg'] = 'cid';
    $json['data']= '渠道编号错误!';
  }elseif(!$website['class']['db']
           ->table('box_channel')
           ->where('id=?',$cid)
           ->count()){
     $json['msg'] = 'cid';
     $json['data']= '未找到渠道!';
  }else{
    $website['class']['db']
      ->table('box_channel')
      ->where('id=?',$cid)
      ->limit(1)
      ->delete();
    $json['status'] = 'ok';
    $json['msg'] = 'ok';
    $json['data']= '删除成功!';
  }
  return json_encode($json);
}




//上传功能 上传到temp文件夹里
function act_channel_upload(&$website){

  $json = array('status'=>'error','msg'=>'error','data'=>'');

  if(!isset($_FILES['file'])){
    $json['msg'] = 'upload';
    $json['data'] = '没有文件被上传!';
  }elseif($_FILES['file']['size']>1024*1024*100){
    $json['msg'] = 'size';
    $json['data'] = '文件超过100M!';
  }else{
    // 文件名
    $sfx      = explode('.',$_FILES['file']['name']);
    $fileName = basename($_FILES['file']['name']);

    // 临时文件地址
    $path     = $website['path']['root'].'/download';
    if(move_uploaded_file($_FILES['file']['tmp_name'],$path)){//$chmod o+rw galleries
      $json['status']='ok';
      $json['msg']='upload';
      $json['data']=array('url'=>$fileName);
    }else{
      $json['msg']='upload';
      $json['data']='移动文件错误！'.$path;
    }
  }



  return json_encode($json);

}
