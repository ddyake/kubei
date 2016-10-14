<?php
// 用户信息相关

//获取用户信息
function act_info_select(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'none');
  $uid  = $_GET['id']??false;
  if(!$uid || !is_numeric($uid)){
    $json['msg'] = 'uid';
    $json['data'] = '用户编号错误!';
    return json_encode($json);
  }else{
    $user = $website['class']['db']
            ->table('user')
            ->field('authority','phone','createtime','isId','isPhone','isEmail','isDisabled','nick','email')
            ->where('id=?',$uid)
            ->one();
    $sql = $website['class']['db']->sql;
    $detail = $website['class']['db']
                  ->table('user_detail')
                  ->field('gold','rip','qq','sex','idc','over','name','job','address')
                  ->where('id=?',$uid)
                  ->one();
    $login = $website['class']['db']
                  ->table('user_record')
                  ->field('ip','times')
                  ->where('id=?',$uid)
                  ->order('id desc')
                  ->one();

    if(!$user || !is_array($user) || !count($user) || !$detail || !is_array($detail) || !count($detail)){
      $json['msg'] = 'user';
      $json['data'] = '未找到用户'.$sql;
      return json_encode($json);
    }else{
      $arr = array_merge((array)$user,(array)$detail,(array)$login);
      //解析权限
      $arr['authority'] = fn_user_authority_resolve($arr['authority']);

      $arr['rip']    = $arr['rip'] ? long2ip($arr['rip']) : '0.0.0.0';
      $arr['ip']    = $arr['ip'] ? long2ip($arr['ip']) : '0.0.0.0';

      $json['status'] = 'ok';
      $json['msg'] = 'ok';
      $json['data'] = $arr;
    }
  }
  return json_encode($json);

}


// 更新用户信息
function act_info_update(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'none');
  $uid  = $_POST['id']??false;

  if(!$uid || !is_numeric($uid)){
    $json['msg'] = 'uid';
    $json['data'] = '用户编号错误!';
    return json_encode($json);
  }elseif(!$website['class']['db']
           ->table('user')
           ->where('id=?',$uid)
           ->count() ||
          !$website['class']['db']
           ->table('user_detail')
           ->where('id=?',$uid)
           ->count()){
    $json['msg'] = 'uid';
    $json['data'] = '未找到用户!';
    return json_encode($json);
  }else{
    // $detail = $website['class']['db']
    //               ->table('user_detail')
    //               ->field('gold','rip','qq','sex','idc','over','name','job','address')
    //               ->where('id=?',$uid)
    //               ->one();


    // user表
    $uField = array();
    $uValue = array();
    if(isset($_POST['email'])){array_push($uField,'email');array_push($uValue,$_POST['email']);}
    if(isset($_POST['phone'])){array_push($uField,'phone');array_push($uValue,$_POST['phone']);}
    if(isset($_POST['nick'])){array_push($uField,'nick');array_push($uValue,$_POST['nick']);}
    if(isset($_POST['isId'])){array_push($uField,'isId');array_push($uValue,$_POST['isId']);}
    if(isset($_POST['isPhone'])){array_push($uField,'isPhone');array_push($uValue,$_POST['isPhone']);}
    if(isset($_POST['isEmail'])){array_push($uField,'isEmail');array_push($uValue,$_POST['isEmail']);}
    if(isset($_POST['isDisabled'])){array_push($uField,'isDisabled');array_push($uValue,$_POST['isDisabled']);}
    // 权限
    $authority = array();
    if(isset($_POST['doctor']) && $_POST['doctor']=='1'){$authority[] = 'doctor';}
    if(isset($_POST['hospital']) && $_POST['hospital']=='1'){$authority[] = 'hospital';}
    if(isset($_POST['company']) && $_POST['company']=='1'){$authority[] = 'company';}
    if(isset($_POST['drugstore']) && $_POST['drugstore']=='1'){$authority[] = 'drugstore';}
    if(isset($_POST['edit']) && $_POST['edit']=='1'){$authority[] = 'edit';}
    if(isset($_POST['admin']) && $_POST['admin']=='1'){$authority[] = 'admin';}
    if(count($authority)){
      $user = $website['class']['db']
              ->table('user')
              ->field('authority')
              ->where('id=?',$uid)
              ->one();
      $str = fn_user_authority_num($authority);
      if($user['authority'] != $str){
        $uField[]='authority';
        $uValue[]=fn_user_authority_num($authority);
      }
    }else{
      $uField[]='authority';
      $uValue[]=100000;
    }


    if(isset($_POST['phone']) && $website['class']['db']->table('user')->where('phone=?',$_POST['phone'])->count()){
      $json['msg'] = 'phone';
      $json['data']= '手机号码已存在!';
      return json_encode($json);
    }elseif(in_array('email',$uField) && $website['class']['db']->table('user')->where('email=?',$_POST['email'])->count()){
      $json['msg'] = 'email';
      $json['data']= '邮箱已存在!';
      return json_encode($json);
    }elseif(in_array('nick',$uField) && $website['class']['db']->table('user')->where('nick=?',$_POST['nick'])->count()){
      $json['msg'] = 'nick';
      $json['data']= '昵称已存在!';
      return json_encode($json);
    }elseif(count($uField)){
      $website['class']['db']
        ->table('user')
        ->field($uField)
        ->value($uValue)
        ->where('id=?',$uid)
        ->limit(1)
        ->update();
    }

    // 密码单独计算
    $md5 =[];
    if(isset($_POST['pwd'])){$md5['pwd'] = $_POST['pwd'];}
    if(isset($_POST['pwdd'])){$md5['pwdd'] = $_POST['pwdd'];}
    if(count($md5)){
      $user = $website['class']['db']
              ->table('user')
              ->field('phone','createtime')
              ->where('id=?',$uid)
              ->one();
      if(isset($md5['pwd'])){$md5['pwd'] = md5($md5['pwd'].$user['createtime'].$user['phone']);}
      if(isset($md5['pwdd'])){$md5['pwdd'] = md5($md5['pwdd'].$user['createtime'].$user['phone']);}
      $key  = [];
      $val  = [];
      foreach($md5 as $k=>$v){
        array_push($key,$k);
        array_push($val,$v);
      }

      $website['class']['db']
        ->table('user')
        ->field($key)
        ->value($val)
        ->where('id=?',$uid)
        ->limit(1)
        ->update();
    }

    // user_detail表
    $dField = array();
    $dValue = array();
    if(isset($_POST['gold'])){array_push($dField,'gold');array_push($dValue,$_POST['gold']);}
    if(isset($_POST['qq'])){array_push($dField,'qq');array_push($dValue,$_POST['qq']);}
    if(isset($_POST['sex'])){array_push($dField,'sex');array_push($dValue,$_POST['sex']);}
    if(isset($_POST['idc'])){array_push($dField,'idc');array_push($dValue,$_POST['idc']);}
    if(isset($_POST['address'])){array_push($dField,'address');array_push($dValue,$_POST['address']);}
    if(isset($_POST['name'])){array_push($dField,'name');array_push($dValue,$_POST['name']);}
    if(isset($_POST['job'])){array_push($dField,'job');array_push($dValue,$_POST['job']);}
    if(in_array('idc',$dField) && $website['class']['db']->table('user_detail')->where('idc=?',$_POST['idc'])->count()){
      $json['msg'] = 'idc';
      $json['data']= '身份证号码已存在!';
      return json_encode($json);
    }elseif(count($dField)){
      $website['class']['db']
        ->table('user_detail')
        ->field($dField)
        ->value($dValue)
        ->where('id=?',$uid)
        ->limit(1)
        ->update();
    }
    $json['status'] = 'ok';
    $json['msg'] = 'ok';
    $json['data'] = '保存成功!';

  }

  return json_encode($json);
}

// 插入用户信息
function act_info_insert(&$website){
  $json = array('status'=>'error','msg'=>'error','data'=>'none');
  $pwd  = $_POST['pwd']??false;
  $phone= $_POST['phone']??false;
  $email= $_POST['email']??false;

  if(!$pwd){
    $json['msg'] = 'pwd';
    $json['data'] = '请输入密码!';
    return json_encode($json);
  }elseif(!$phone){
    $json['msg'] = 'phone';
    $json['data'] = '请输入手机号!';
    return json_encode($json);
  }elseif(!$email){
    $json['msg'] = 'email';
    $json['data'] = '请输入邮箱!';
    return json_encode($json);
  }else{
    // user表
    $uField = array('createtime');
    $uValue = array($_SERVER['REQUEST_TIME']);
    if(isset($_POST['email'])){array_push($uField,'email');array_push($uValue,$_POST['email']);}
    if(isset($_POST['phone'])){array_push($uField,'phone');array_push($uValue,$_POST['phone']);}
    if(isset($_POST['nick'])){array_push($uField,'nick');array_push($uValue,$_POST['nick']);}
    if(isset($_POST['isId'])){array_push($uField,'isId');array_push($uValue,$_POST['isId']);}
    if(isset($_POST['isPhone'])){array_push($uField,'isPhone');array_push($uValue,$_POST['isPhone']);}
    if(isset($_POST['isEmail'])){array_push($uField,'isEmail');array_push($uValue,$_POST['isEmail']);}
    if(isset($_POST['isDisabled'])){array_push($uField,'isDisabled');array_push($uValue,$_POST['isDisabled']);}

    if(isset($_POST['phone']) && $website['class']['db']->table('user')->where('phone=?',$_POST['phone'])->count()){
      $json['msg'] = 'phone';
      $json['data']= '手机号码已存在!';
      return json_encode($json);
    }elseif(in_array('email',$uField) && $website['class']['db']->table('user')->where('email=?',$_POST['email'])->count()){
      $json['msg'] = 'email';
      $json['data']= '邮箱已存在!';
      return json_encode($json);
    }elseif(in_array('nick',$uField) && $website['class']['db']->table('user')->where('nick=?',$_POST['nick'])->count()){
      $json['msg'] = 'nick';
      $json['data']= '昵称已存在!';
      return json_encode($json);
    }elseif(count($uField)){
      $uid = $website['class']['db']
        ->table('user')
        ->field($uField)
        ->value($uValue)
        ->insert();
      // 权限
      $authority = array();
      if(isset($_POST['edit']) && $_POST['edit']=='1'){$authority[] = 'edit';}
      if(isset($_POST['admin']) && $_POST['admin']=='1'){$authority[] = 'admin';}
      $aField=['authority'];
      $aValue=[];
      if(count($authority)){
        $aValue[] = fn_user_authority_num($authority);
      }else{
        $aValue[]=100000;
      }
      // 密码计算
      if(isset($_POST['pwd'])){$md5['pwd'] = $_POST['pwd'];}
      if(isset($_POST['pwdd'])){$md5['pwdd'] = $_POST['pwdd'];}
      if(count($md5)){
        if(isset($md5['pwd'])){$md5['pwd'] = md5($md5['pwd'].$_SERVER['REQUEST_TIME'].$_POST['phone']);}
        if(isset($md5['pwdd'])){$md5['pwdd'] = md5($md5['pwdd'].$_SERVER['REQUEST_TIME'].$_POST['phone']);}
        $key  = [];
        $val  = [];
        foreach($md5 as $k=>$v){
          array_push($aField,$k);
          array_push($aValue,$v);
        }
        $website['class']['db']
          ->table('user')
          ->field($aField)
          ->value($aValue)
          ->where('id=?',$uid)
          ->limit(1)
          ->update();
      }
      // user_detail表
      $dField = array('id','rip');
      $dValue = array($uid,fn_ip_long());
      if(isset($_POST['gold'])){array_push($dField,'gold');array_push($dValue,$_POST['gold']);}
      if(isset($_POST['qq'])){array_push($dField,'qq');array_push($dValue,$_POST['qq']);}
      if(isset($_POST['sex'])){array_push($dField,'sex');array_push($dValue,$_POST['sex']);}
      if(isset($_POST['idc']) && $_POST['idc']){array_push($dField,'idc');array_push($dValue,$_POST['idc']);}
      if(isset($_POST['address'])){array_push($dField,'address');array_push($dValue,$_POST['address']);}
      if(isset($_POST['name'])){array_push($dField,'name');array_push($dValue,$_POST['name']);}
      if(isset($_POST['job'])){array_push($dField,'job');array_push($dValue,$_POST['job']);}
      if(in_array('idc',$dField) && $website['class']['db']->table('user_detail')->where('idc=?',$_POST['idc'])->count()){
        $json['msg'] = 'idc';
        $json['data']= '身份证号码已存在!';
        return json_encode($json);
      }elseif(count($dField)){
        $website['class']['db']
          ->table('user_detail')
          ->field($dField)
          ->value($dValue)
          ->insert();
      }
      $json['status'] = 'ok';
      $json['msg'] = 'ok';
      $json['data'] = '保存成功!';
    }else{
      $json['msg'] = 'insert';
      $json['data']= '未写入数据库';
      return json_encode($json);
    }
  }

  return json_encode($json);
}
