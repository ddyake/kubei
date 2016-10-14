<?php
//登陆
function act_global_login(&$website){
    $pwd	  = $_POST['pwd']??'';
    $usr	= $_POST['usr']??'';
    $remail	= '/^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/';
    $rphone = '/^1\d{10}$/';
    $type	= preg_match($remail,$usr) ? "email" : (preg_match($rphone,$usr) ? "phone" : 0);
    $json	= array('status'=>'error','msg'=>'login','sfx'=>0);

    $_SESSION['sfx']	= $_SESSION['sfx']??0;

    if($_SESSION['sfx'] > 10){
      $json['msg']	= 'many';
      $json['data']	= '登陆错误次数过多,请稍后登陆!';
    }elseif(isset($_SESSION['optLoginSFX']) && ($_POST['sfx'] !== $_SESSION['optLoginSFX'])){//验证码错误
      $_SESSION['sfx'] += 1;
      $json['msg']	= 'sfx';
      $json['data']	= '验证码错误!';
    }elseif(isset($_SESSION['optLogin'])){
      $json['msg']	= 'double';
      $json['data']	= '请不要重复登陆!';
    }elseif(strlen($pwd) < 6 || strlen($pwd) > 20 || preg_match('/\s/',$pwd)){//密码格式错误
      $_SESSION['sfx'] +=1;
      $json['msg']	= 'pwd';
      $json['data']	= '密码错误!,请正确输入密码.';
    }elseif(!$type){
      $json['msg']	= 'usr';
      $json['data']	= '用户名错误!';
    }elseif(!$website['class']['db']
                 ->table('user')
                 ->where($type.'=?',$usr)
                 ->count()){
      $_SESSION['sfx'] +=1;
      $json['msg']	= 'usr';
      $json['data']	= '用户名错误';
    }else{
      $user = $website['class']['db']
                   ->table('user')
                   ->field('id','authority','phone','createtime','pwd','isId','isEmail','isDisabled','nick','email')
                   ->where($type.'=?',$usr)
                   ->one();
      $pwd = md5($pwd.$user['createtime'].$user['phone']);
      if($pwd === $user['pwd']){//登陆成功
        unset($user['pwd']);
        //用户信息到session--json格式
        $_SESSION['optLogin']	= json_encode($user);
        //清空错误登陆次数
        unset($_SESSION['sfx'],$_SESSION['optLoginSFX']);
        $json['status']	= 'ok';
        $json['msg']	= 'ok';
        $json['data']	= $user;
      }else{//登陆失败
        $_SESSION['sfx'] +=1;
        $json['msg']	= 'login';
        $json['data']	= '登录错误';
      }
    }
    return json_encode($json);
}
