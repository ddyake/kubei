<?php
//分类管理功能选择

//获取后台管理者/编辑者
function act_authority_init(&$website){
    $user = fn_session('optLogin');
    $users= $website['class']['db']
            ->table('user')
            ->field('id','authority','phone','nick')
            ->where('authority >= ?',110000)
            ->select();

    $mods = $website['class']['db']
            ->table('type')
            ->field('id','tit','cont')
            ->where('upid='.$website['tid']['admin'])
            ->select();

    foreach($users as $k=>$v){
      $users[$k]['module'] = $mods;
      $users[$k]['authority'] = $users[$k]['authority'] =='120000'?'系统管理员':'网站编辑';
      foreach($users[$k]['module'] as $kk=>$vv){
        if($website['class']['db']->table('admin')->where('uid=? and tid=?',$v['id'],$vv['id'])->count()){
          $users[$k]['module'][$kk]['authority'] = true;
        }else{
          $users[$k]['module'][$kk]['authority'] = false;
        }
        $next = $website['class']['db']
                ->table('type')
                ->field('id','tit','cont')
                ->where('upid='.$vv['id'])
                ->select();

        $users[$k]['module'][$kk]['next'] =$next;
        foreach($users[$k]['module'][$kk]['next'] as $kkk=>$vvv){
          if($website['class']['db']->table('admin')->where('uid=? and tid=?',$v['id'],$vvv['id'])->count()){
            $users[$k]['module'][$kk]['next'][$kkk]['authority'] = true;
          }else{
            $users[$k]['module'][$kk]['next'][$kkk]['authority'] = false;
          }
        }
      }

    }

    return json_encode(array(
            'status'    => 'ok',
            'msg'       => 'authority',
            'data'      => $users,
            'sql'       => print_r($users,true)
        )
    );
}


//设置权限
function act_authority_set(&$website){
    //$_POST uid,tid,upid,authority
    $count = $website['class']['db']
                ->table('admin')
                ->where('uid =? and tid=?',$_POST['uid'],$_POST['tid'])
                ->count();
    if($_POST['authority'] == 'false' && $count){
        $website['class']['db']
            ->table('admin')
            ->where('uid =? and tid=?',$_POST['uid'],$_POST['tid'])
            ->limit(1)
            ->delete();
    }elseif($_POST['authority'] == 'true' && !$count){
        $website['class']['db']
            ->table('admin')
            ->field('uid','tid')
            ->value($_POST['uid'],$_POST['tid'])
            ->insert();
    }

    return json_encode(
                array(
                    'status'    => 'ok',
                    'msg'       => 'authority-set',
                    'data'      => '权限设置成功'
                )
            );
}
