<?php

//分类修复
function act_restore_type(&$website){
    $tps    = $website['class']['db']->table('type')->field('id')->where('upid=?',0)->select();
    $num    = count($tps);
    foreach($tps as $tp){
        act_restore_type_recursive($website,$tp['id'],$num);
    }
    return json_encode(array('status'=>'ok','msg'=>'restore','data'=>'修复成功:'.$num.'个'));
}

//商品分类类别修复
function act_restore_type_tp(&$website){
  $arr= array(
    'drug'  => 455,
    'health'=>989,
    'instrument'=>3896,
    'tcmm'=>2275,
    'adult'=>3632,
    'material'=>3636
  );

  foreach($arr as $k=>$v){
    act_restore_type_nextTp($db,$k,$v);
  }
}
function act_restore_type_nextTp(&$website,$tp,$tid){
  $now = $website['class']['db']->table('type')
    ->field('id')
    ->where('upid=?',$tid)
    ->select();
    foreach($now as $v){
      $db->table('type')
        ->field('tp')
        ->value($tp)
        ->where('id=?',$v['id'])
        ->update();
      act_restore_type_nextTp($website,$tp,$v['id']);
    }
}


function act_restore_type_recursive(&$website,$tid,&$num){
     $count = $website['class']['db']->table('type')->where('upid=?',$tid)->count();
     $num+=$count;
     if($count > 0){
        $website['class']['db']
                ->table('type')
                ->field('num')
                ->value($count)
                ->where('id=?',$tid)->update();
        $tps = $website['class']['db']->table('type')->field('id')->where('upid=?',$tid)->select();
        foreach($tps as $tp){
           act_restore_type_recursive($website,$tp['id'],$num);
        }
     }else{
         $website['class']['db']
                ->table('type')
                ->field('num')
                ->value(0)
                ->where('id=?',$tid)
                ->update();
     }
}




//错误功能
function restore_error(){
    return json_encode(array(
        'status'    => 'error',
        'msg'       => 'restore',
        'data'      => '方法名不能为空'
    ));
}
