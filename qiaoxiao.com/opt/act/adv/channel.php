<?php
// 广告渠道

// 删除
function act_channel_delete(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'');
  $cid  = $_GET['cid']??false;
  if(!$cid || !is_numeric($cid)){
    $json['msg'] = 'cid';
    $json['data']= '渠道编号错误!';
  }elseif(!$website['class']['db']
           ->table('adv_channel')
           ->where('id=?',$cid)
           ->count()){
    $json['msg'] = 'cid';
    $json['data']= '渠道编号未找到,或渠道已被删除!';
  }else{
    $cid = $website['class']['db']
           ->table('adv_channel')
           ->where('id=?',$cid)
           ->limit(1)
           ->delete();
    $json['status'] = 'ok';
    $json['msg'] = 'ok';
    $json['data']= '删除成功!';
  }
  return json_encode($json);
}
// 新建渠道
function act_channel_insert(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'');
  $tit  = $_GET['tit']??false;
  if(!$tit){
    $json['msg'] = 'tit';
    $json['data']= '请输入名称!';
  }else{
    $cid = $website['class']['db']
            ->table('adv_channel')
            ->field('tit','createtime')
            ->value($tit,$_SERVER['REQUEST_TIME'])
            ->insert();
    if($cid){
      $json['status'] = 'ok';
      $json['msg'] = 'ok';
      $json['data']= $cid;
    }else{
      $json['msg'] = 'insert';
      $json['data']= $website['class']['db']->sql;
    }
  }
  return json_encode($json);
}
// 编辑渠道
function act_channel_update(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'');
  $tit  = $_GET['tit']??false;
  $cid  = $_GET['cid']??false;
  if(!$tit){
    $json['msg'] = 'tit';
    $json['data']= '请输入名称!';
  }elseif(!$cid || !is_numeric($cid)){
    $json['msg'] = 'cid';
    $json['data']= '渠道编号错误!';
  }elseif(!$website['class']['db']
           ->table('adv_channel')
           ->where('id=?',$cid)
           ->count()){
    $json['msg'] = 'cid';
    $json['data']= '渠道编号未找到,或渠道已被删除2!';
  }else{
    $cid = $website['class']['db']
           ->table('adv_channel')
           ->field('tit')
           ->value($tit)
           ->where('id=?',$cid)
           ->limit(1)
           ->update();
    $json['status'] = 'ok';
    $json['msg'] = 'ok';
    $json['data']= '修改成功!';
  }
  return json_encode($json);
}
