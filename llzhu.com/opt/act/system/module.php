<?php
//添加后端模块
function act_module_add(&$website){
  $id = $website['class']['db']
        ->table('type')
        ->field('upid','tit','cont')
        ->value($_POST['upid'],$_POST['tit'],$_POST['cont'])
        ->insert();
  $num = $website['class']['db']->table('type')->where('upid=?',$_POST['upid'])->count();
  $website['class']['db']
    ->table('type')
    ->field('num')
    ->value($num)
    ->where('id=?',$_POST['upid'])
    ->limit(1)
    ->update();
  return json_encode(
    array(
      'status'=> 'ok',
      'msg'   => 'module-add',
      'data'  => '数据写入成功!'
    )
  );
}
//修改后端模块
function act_module_update(&$website){
  $arr   = $website['class']['db']->table('type')->field('upid')->where('id=?',$_POST['tid'])->one();
  $count = $website['class']['db']
            ->table('type')
            ->field('upid','tit','cont')
            ->value($_POST['upid'],$_POST['tit'],$_POST['cont'])
            ->where('id=?',$_POST['tid'])
            ->limit(1)
            ->update();
  if($count){
    $num = $website['class']['db']->table('type')->where('upid=?',$_POST['upid'])->count();
    $website['class']['db']
      ->table('type')
      ->field('num')
      ->value($num)
      ->where('id=?',$_POST['upid'])
      ->limit(1)
      ->update();
    $num2= $website['class']['db']->table('type')->where('upid=?',$arr['upid'])->count();
    $website['class']['db']
      ->table('type')
      ->field('num')
      ->value($num2)
      ->where('id=?',$arr['upid'])
      ->limit(1)
      ->update();
  }
  return json_encode(
    array(
      'status'=> 'ok',
      'msg'   => 'module-update',
      'data'  => '数据写入成功!'
    )
  );
}
//删除后端模块
function act_module_del(&$website){
  if(!isset($_GET['tid']) || !preg_match('/\d+/',$_GET['tid'])){
      return json_encode(array('status'=>'error','status'=>'msg','data'=>'分类ID必须为数字'.$_GET['tid']));
  }
  $arr = $website['class']['db']->table('type')->field('num','upid')->where('id=?',$_GET['tid'])->one();
  if($arr['num'] !== '0'){
      return json_encode(array('status'=>'error','status'=>'msg','data'=>'不能删除,此分类含有下级分类.'));
  }
  $num = $website['class']['db']
              ->table('type')
              ->where('id=?',$_GET['tid'])
              ->limit(1)
              ->delete();
  $count = $website['class']['db']->table('type')->where('upid='.$arr['upid'])->count();
  $website['class']['db']
    ->table('type')
    ->field('num')
    ->value($count)
    ->where('id='.$arr['upid'])
    ->limit(1)
    ->update();
  return json_encode(
          array(
              'status'=>'ok',
              'msg'=>'system-module-del',
              'data'=>'删除成功!'
          )
  );
}
