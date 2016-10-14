<?php
//加载数据
function act_global_load(&$website){
	$user	= fn_session('optLogin');

	if(!$user){
		return json_encode(
				array(
					'status'=>'error',
					'msg'=>'加载失败!',
					'data'=>'未找到登陆信息,请重新登陆!'.$_SESSION['optLogin']
				)
		);
	}
  //返回数据 存放模块 array(array(顶级模块数据,modules=>'下级模块数据'),array(.....))
  //获取所有模块信息
  $mods = $website['class']['db']
          ->table('type')
          ->field('id','tit','cont')
          ->where('upid='.$website['tid']['admin'])
          ->select();

  $in   = in_array($user['usr'],$website['safe']['system']);
  foreach($mods as $k=>$v){
    $arrs = array();
    if($in){//系统管理员
      $mods[$k]['modules'] = $website['class']['db']
            ->table('type')
            ->field('id','tit','cont')
            ->where('upid='.$v['id'])
            ->select();
    }elseif($website['class']['db']
                ->table('admin')
                ->where('tid=? and uid=?',$v['id'],$user['id'])
                ->count()){//非系统管理员
      $moudles = $website['class']['db']
                  ->table('type')
                  ->field('id','tit','cont')
                  ->where('upid=?',$v['id'])
                  ->select();
      foreach($moudles as $kk=>$vv){
        if(!$website['class']['db']
                    ->table('admin')
                    ->where('tid=? and uid=?',$vv['id'],$user['id'])
                    ->count()){
            unset($moudles[$kk]);
        }
      }
      $mods[$k]['modules'] = $moudles;
    }else{//
      unset($mods[$k]);
    }
  }


  return json_encode(
      array(
        'status'=>'ok',
        'msg'=>'加载成功!',
        'data'=>$mods,
        'website'=>array(
          'path'=>$website['path'],
          'authority'=>$website['authority'],
          'html'=>$website['html'],
          'upload'=>$website['safe']['upload'],
          'url'=>$website['url'],
          'tid'=>$website['tid']
        )
      )
  );
}
