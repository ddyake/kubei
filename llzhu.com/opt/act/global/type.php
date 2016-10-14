<?php
//获取分类
function act_global_type(&$website){
    //获取分类 //$_GET['tid']
    $where  = '';
    if(is_numeric($_GET['tid'])){
        $where  = array("id = ? ",$_GET['tid']);
        if(!preg_match('/,/',$_GET['tid'])){
            $limit = 1;
        }
    }elseif(isset($_GET['upid'])){
        $where  = array("upid = ?",$_GET['upid']);
        if(!preg_match('/,/',$_GET['upid'])){
            $limit = 1;
        }
    }
    $data = $website['class']['db']
            ->table('type')
            ->field()
            ->where($where)
            ->select();

            return json_encode(
                array(
                    'status'=>'ok',
                    //测试使用'sql'=>$website['class']['db']->sql,
                    'msg'=>'global-type',
                    'data'=>$data
                )
            );
}

//根据tid获取数据
function act_type_id(&$website){
  return json_encode(
      array(
          'status'=>'ok',
          'msg'=>'global-type-id',
          'data'=>$website['class']['db']
                  ->table('type')
                  ->field()
                  ->where('id=?',$_GET['tid'])
                  ->one()
      )
  );
}

// 获取所有下级分类
function act_type_next(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'');
  $tid  = $_GET['tid']??false;
  if(!$tid){
    $json['msg'] = 'tid';
    $json['data']= '请输入分类id';
  }else{
    $json['status'] = 'ok';
    $json['msg'] = 'ok';
    $json['data'] = fn_next_type($website,$tid);
  }

  return json_encode($json);
}
