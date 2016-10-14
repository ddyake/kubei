<?php

// 添加游戏相关

// 插入游戏
function act_game_insert(&$website){
  $json   = array('status'=>'error','msg'=>'error','data'=>'');
  $tit    = $_POST['tit']??false;
  $tag    = $_POST['tag']??false;
  $about  = $_POST['about']??false;
  $image  = $_POST['image']??false;
  $icon   = $_POST['icon']??false;
  $platform=$_POST['platform']??false;
  if(!$tit || !$tag || !$about || !$image || !$icon || !$platform){
    $json['msg'] = 'args';
    $json['data']= '数据请填写完整!';
  }else{
    $image  = act_game_save_tmp_image($website,$image);
    $icon   = act_game_save_tmp_icon($website,$icon);
    $gid    = $website['class']['db']
              ->table('game')
              ->field('tit','tag','image','icon','about')
              ->value($tit,$tag,$image,$icon,$about)
              ->insert();
    if($gid && $pf = json_decode($platform,1)){
      foreach($pf as $v){
        $website['class']['db']
              ->table('game_platform')
              ->field('gid','tit','url')
              ->value($gid,$v['tit'],$v['url'])
              ->insert();
      }
      $json['status'] = 'ok';
      $json['msg']    = 'ok';
      $json['data']   = '数据插入成功！';
    }else{
      $json['msg']    = 'data';
      $json['data']   = '数据插入失败！';
    }

  }
  return json_encode($json);
}

// 修改游戏
function act_game_update(&$website){
  $json   = array('status'=>'error','msg'=>'error','data'=>'');
  $tit    = $_POST['tit']??false;
  $tag    = $_POST['tag']??false;
  $about  = $_POST['about']??false;
  $image  = $_POST['image']??false;
  $icon   = $_POST['icon']??false;
  $platform=$_POST['platform']??false;
  $gid    = $_POST['gid']??false;

  if(!$gid || !is_numeric($gid)){
    $json['msg'] = 'args';
    $json['data']= '游戏编号错误!';
  }elseif(!$tit || !$tag || !$about || !$image || !$icon || !$platform){
    $json['msg'] = 'args';
    $json['data']= '数据请填写完整!';
  }elseif(!$website['class']['db']
          ->table('game')
          ->where('id=?',$gid)
          ->count()){
    $json['msg'] = 'gid';
    $json['data']= '未找到相关游戏！';
  }else{
    $game = $website['class']['db']
            ->table('game')
            ->where('id=?',$gid)
            ->one();
    $field = array('tit','tag','about');
    $value = array($tit,$tag,$about);
    if($game['image'] != $image){
      $image  = act_game_save_tmp_image($website,$image);
      $field[]='image';
      $value[]=$image;
    }
    if($game['icon'] != $icon){
      $icon   = act_game_save_tmp_icon($website,$icon);
      $field[]='icon';
      $value[]=$icon;
    }
    $num    = $website['class']['db']
                ->table('game')
                ->field($field)
                ->value($value)
                ->where('id=?',$gid)
                ->limit(1)
                ->update();
    if($pf = json_decode($platform,1)){
      foreach($pf as $v){
        if(isset($v['gid']) && is_numeric($v['gid'])){
          $website['class']['db']
                ->table('game_platform')
                ->field('tit','url')
                ->value($v['tit'],$v['url'])
                ->where('id=?',$v['gid'])
                ->update();
        }else{
          $website['class']['db']
                ->table('game_platform')
                ->field('gid','tit','url')
                ->value($gid,$v['tit'],$v['url'])
                ->insert();
        }
      }
      $json['status'] = 'ok';
      $json['msg']    = 'ok';
      $json['data']   = '数据更新成功！';
    }else{
      $json['msg']    = 'data';
      $json['data']   = '数据更新失败！';
    }
  }

  return json_encode($json);
}


// 获取游戏
function act_game_select(&$website){
  $json   = array('status'=>'error','msg'=>'error','data'=>$_POST['act']);
  $gid    = $_GET['gid']??false;
  if(!$gid || !is_numeric($gid)){
    $json['msg'] = 'gid';
    $json['data']= '游戏编号错误！';
  }elseif(!$website['class']['db']
          ->table('game')
          ->where('id=?',$gid)
          ->count()){
    $json['msg'] = 'gid';
    $json['data']= '未找到相关游戏！';
  }else{
    $game = $website['class']['db']
              ->table('game')
              ->field('tit','tag','image','icon','about')
              ->where('id=?',$gid)
              ->one();
    $game['platform'] = $website['class']['db']
                          ->table('game_platform')
                          ->field('id','tit','url')
                          ->where('gid=?',$gid)
                          ->select();
     $json['status'] = 'ok';
     $json['msg'] = 'ok';
     $json['data'] = $game;
  }
  return json_encode($json);
}



// 删除游戏
function act_game_delete(&$website){
  $json   = array('status'=>'error','msg'=>'error','data'=>$_POST['act']);
  $gid    = $_GET['gid']??false;
  if(!$gid || !is_numeric($gid)){
    $json['msg'] = 'gid';
    $json['data'] = '游戏编号错误!';
  }elseif(!$website['class']['db']
            ->table('game')
            ->where('id=?',$gid)
            ->count()){
    $json['msg'] = 'game';
    $json['data'] = '未找到游戏';
  }else{
    $website['class']['db']
              ->table('game')
              ->where('id=?',$gid)
              ->limit(1)
              ->delete();
    $website['class']['db']
              ->table('game_platform')
              ->where('gid=?',$gid)
              ->delete();
    $json['status'] = 'ok';
    $json['msg'] = 'ok';
    $json['data'] = '删除成功!';
  }


  return json_encode($json);
}

// 删除平台
function act_game_delplatform(&$website){
  $json   = array('status'=>'error','msg'=>'error','data'=>$_POST['act']);
  $gid    = $_GET['gid']??false;
  if(!$gid || !is_numeric($gid)){
    $json['msg'] = 'gid';
    $json['data'] = '平台编号错误!';
  }elseif(!$website['class']['db']
            ->table('game_platform')
            ->where('id=?',$gid)
            ->count()){
    $json['msg'] = 'game';
    $json['data'] = '未找到平台!';
  }else{
    $website['class']['db']
              ->table('game_platform')
              ->where('id=?',$gid)
              ->delete();
    $json['status'] = 'ok';
    $json['msg']    = 'ok';
    $json['data']   = '删除成功!';
  }


  return json_encode($json);
}




// 移动临时图片位置
function act_game_save_tmp_image(&$website,$image){
  $path = $website['path']['upload']['image'].date('/Ym/d/')
          .bin2hex(random_bytes(10)).'.'.pathinfo($image, PATHINFO_EXTENSION);
  fn_mkdir($path);
  if(!preg_match('/^\//',$image)){ //上传了新图片
    $tempName = $website['path']['temp'].'/'.$image;
    if(is_file($tempName)){
      rename($tempName,$path);
      $image = str_replace($website['path']['root'],'',$path);
      return $image;
    }
  }
  return '';
}

// 移动临时icon位置
function act_game_save_tmp_icon(&$website,$image){
  $path = $website['path']['upload']['icon'].date('/Ym/d/')
          .bin2hex(random_bytes(10)).'.'.pathinfo($image, PATHINFO_EXTENSION);
  fn_mkdir($path);
  if(!preg_match('/^\//',$image)){ //上传了新图片
    $tempName = $website['path']['temp'].'/'.$image;
    if(is_file($tempName)){
      rename($tempName,$path);
      $image = str_replace($website['path']['root'],'',$path);
      return $image;
    }
  }
  return '';
}
