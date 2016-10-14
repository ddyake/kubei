<?php
// 数据分析显示

// 显示渠道
function act_data_channel(&$website){
  return json_encode(
    array(
      'status'=>'ok',
      'msg'=>'ok',
      'data'=>$website['class']['db']
              ->table('box_channel')
              ->field('id','tit')
              ->select()
    )
  );
}

// 渠道信息分页
function act_data_paging(&$website){
  $where= '';
  if(isset($_GET['cid']) && $_GET['cid']){
    $where = 'id='.$_GET['cid'];
  }

  $time = $_SERVER['REQUEST_TIME'];
  if(isset($_GET['time']) and $_GET['time']){
   $arr = explode('-',$_GET['time']);
   $time= mktime(0,0,0,$arr[1],$arr[2],$arr[0]);
  }

  $paging   = $website['class']['db']
              ->table('box_channel')
              ->field()
              ->order('id asc')
              ->where($where)
              ->select();
              //
  // $sql = 'nowTime:'.$time.'-----reuesttim:'.$_SERVER['REQUEST_TIME'];

  // 前日时间
  $prev = fn_between_time($time-86400);
  // 今日时间
  $now  = fn_between_time($time);
  $data= array();
  foreach($paging as &$v){

    // -------次日启动数
    // 前日安装
    $prevCont = $website['class']['db']
                     ->table('box_install')
                     ->where('createtime between ? and ? and fid=?',$prev['first'],$prev['last'],$v['id'])
                     ->count();
    // 今日打开量
    $nextOpen = $website['class']['db']
                ->table('box_open')
                ->where('createtime between ? and ? and fid=? and mac in(select mac from box_install where createtime between ? and ? and fid=?)',$now['first'],$now['last'],$v['id'],$prev['first'],$prev['last'],$v['id'])
                ->count();
    $sql = $website['class']['db']->sql;
    // 当前时间安装量
    $install = $website['class']['db']
                ->table('box_install')
                ->where('createtime between ? and ? and fid=? ',$now['first'],$now['last'],$v['id'])
                ->count();
    // 当前时间卸载量
    $unstall = $website['class']['db']
                ->table('box_unstall')
                ->where('createtime between ? and ? and fid=? and mac in(select mac from box_install where createtime between ? and ? and fid=?) ',$now['first'],$now['last'],$v['id'],$now['first'],$now['last'],$v['id'])
                ->count();
    // 当前时间网吧量
    $bar = $website['class']['db']
                ->table('box_install')
                ->where('createtime between ? and ? and fid=? and bar=1',$now['first'],$now['last'],$v['id'])
                ->count();
    // $sql.=$website['class']['db']->sql;
    $data[] = array(
      'id'=>$v['id'],
      'createtime'=>$v['createtime'],
      'tit'=>$v['tit'],
      'pwd'=>$v['pwd'],
      // 安装总量
      'install'=>$install,
      // 折扣总量
      'installs'=>floor($install*($v['scale']/100)),
      // 总卸载量
      'unstall'=>$unstall,
      // 卸载率
      'inun'=>floor(($install)?($unstall/$install*100):(0)).'%',
      // 网吧安装量
      'bar'=>$bar,
      // 网吧安装率
      'barScale'=>floor(($install)?($bar/$install*100):(0)).'%',
      // 次日打开量
      'nextOpen'=>$nextOpen,
      // 次日打开率
      'nextOpenScale'=>floor(($prevCont)?($nextOpen/$prevCont*100):0).'%',
      // 折扣率
      'scale'=>$v['scale'].'%',
      // 'sql'=>$sql
    );

  }
  $paging['data'] = $data;
  $paging['field']= array(
    '编号',
    '创建时间',
    '渠道名称',
    '查看密码',
    '渠道安装量',
    '渠道显示量',
    '卸载量',
    '卸载率',
    '网吧安装量',
    '网吧安装率',
    '次日启动数',
    '次日启动率',
    '渠道折扣'
  );
  return json_encode(array(
      'status'    => 'ok',
      'msg'       => 'paging',
      // 'sql'       => $sql,
      'data'      => $paging
  ));
}
