<?php
//上传功能 上传到temp文件夹里
function act_upload_server(&$website){

  $json = array('status'=>'error','msg'=>'error','data'=>'');
  $sfx  = pathinfo($_FILES['file']['name'])['extension'];
  if(!isset($_FILES['file'])){
    $json['msg'] = 'upload';
    $json['data'] = '没有文件被上传!';
  }elseif($_FILES['file']['size']>$website['safe']['upload']['size']){
    $json['msg'] = 'size';
    $json['data'] = '文件超过'.($website['safe']['upload']['size']/1024).'k!';
  }elseif($sfx != 'exe'){
    $json['msg'] = 'extension';
    $json['data'] = '请上传exe文件格式的文件!';
  }else{
    $path     = $website['path']['root'].'/download/KuwanSetup2.exe';
    if(move_uploaded_file($_FILES['file']['tmp_name'],$path)){//$chmod o+rw galleries
      $json['status']='ok';
      $json['msg']='upload';
      $json['data']='上传成功！';
    }else{
      $json['msg']='upload';
      $json['data']='移动文件错误！'.$path;
    }
  }



  return json_encode($json);

}
