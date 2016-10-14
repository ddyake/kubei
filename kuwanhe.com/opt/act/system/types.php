<?php


//分类功能-增加
function act_types_insert(&$website){
    if(!isset($_POST['upid']) || !is_numeric($_POST['upid'])){
        return json_encode(array('status'=>'error','msg'=>'types-add','data'=>'上级ID不是数字!'));
    }elseif(!isset($_POST['tit']) || !is_string($_POST['tit'])){
        return json_encode(array('status'=>'error','msg'=>'types-add','data'=>'分类名称不能为空!'));
    }

    $id = $website['class']['db']
            ->table('type')
            ->field('upid','tp','tit','cont')
            ->value(
                    $_POST['upid'],
                    is_string($_POST['tp'])?$_POST['tp'] : '',
                    $_POST['tit'],
                    is_string($_POST['cont'])?$_POST['cont'] : ''
            )
            ->insert();
    if($_POST['upid'] != '0'){
        $website['class']['db']->PDO->exec("update `type` set `num`=num+1 where `id` = '{$_POST['upid']}'");
    }
    return json_encode(array('status'=>'ok','msg'=>'types-add','data'=>'添加分类成功!id:'.$id));

}


//分类修改
function act_types_update(&$website){
    if(!isset($_POST['tit']) || !is_string($_POST['tit'])){
        return json_encode(array('status'=>'error','status'=>'msg','data'=>'分类名称不能为空!'));
    }elseif(!isset($_POST['tid']) || !preg_match('/\d+/',$_POST['tid'])){
        return json_encode(array('status'=>'error','status'=>'msg','data'=>'分类ID必须为数字'.$_POST['id']));
    }elseif(!preg_match('/\d+/',$_POST['upid'])){
        return json_encode(array('status'=>'error','status'=>'msg','data'=>'分类上级ID必须为数字'.$_POST['upid']));
    }
    $old = $website['class']['db']->table('type')->field('upid')->where('id=?',$_POST['tid'])->one();
    $num = $website['class']['db']
                ->table('type')
                ->field('upid','tit','tp','cont')
                ->value($_POST['upid'],$_POST['tit'],$_POST['tp'],$_POST['cont'])
                ->where('id=?',$_POST['tid'])
                ->limit(1)
                ->update();
    $website['class']['db']->PDO->exec("update `type` set `num`=num-1 where `id` = '{$old['upid']}'");
    if($_POST['upid'] != '0'){
        $website['class']['db']->PDO->exec("update `type` set `num`=num+1 where `id` = '{$_POST['upid']}'");
    }
    return json_encode(array('status'=>'ok','msg'=>'types-update','data'=>'修改成功,影响行数：'.$num.'行'));
}

//分类删除
function act_types_delete(&$website){
    if(!isset($_POST['tid']) || !preg_match('/\d+/',$_POST['tid'])){
        return json_encode(array('status'=>'error','status'=>'msg','data'=>'分类ID必须为数字'.$_POST['tid']));
    }
    $arr = $website['class']['db']->table('type')->field('num','upid')->where('id=?',$_POST['tid'])->one();
    if($arr['num'] !== '0'){
        return json_encode(array('status'=>'error','status'=>'msg','data'=>'不能删除,此分类含有下级分类.'));
    }
    $num = $website['class']['db']
                ->table('type')
                ->where('id=?',$_POST['tid'])
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
                'msg'=>'types-mend',
                'data'=>'删除成功,影响行数：'.$num.'行 上级ID:'.$arr['upid']
            )
    );
}
