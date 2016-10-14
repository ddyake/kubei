<?php
//上传功能 上传到temp文件夹里
function act_global_upload(&$website){

  $json = array('status'=>'error','msg'=>'error','data'=>'');

  if(!isset($_FILES['file'])){
    $json['msg'] = 'upload';
    $json['data'] = '没有文件被上传!';
  }elseif($_FILES['file']['size']>$website['safe']['upload']['size']){
    $json['msg'] = 'size';
    $json['data'] = '文件超过'.($website['safe']['upload']['size']/1024).'k!';
  }elseif(!preg_match('/image\/jpeg|image\/png|image\/gif/',$_FILES['file']['type'],$arr)){
    $json['msg'] = 'size';
    $json['data'] = '请上传以下格式文件,gif,jpg,jpeg,png!';
  }else{

    // 文件名
    $sfx      = explode('.',$_FILES['file']['name']);
    $fileName = md5(basename($_FILES['file']['name']).fn_millisecond()).'.'.$sfx[count($sfx)-1];

    // 临时文件地址
    $path     = $website['path']['temp'].'/'.$fileName;
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
