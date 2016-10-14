<?php
//获取用户信息


function act_get(&$website){
  $user = $website['class']['db']
          ->table('user')
          ->field('authority','phone','email','isId','isPhone','isEmail','isDisabled')
          ->where('id=?',$_GET['id'])
          ->one();

  $userDetail = $website['class']['db']
                ->table('user_detail')
                ->field('gold','rtime','rip','qq','sex','idc','name','address')
                ->where('id=?',$_GET['id'])
                ->one();

  $userRecord = $website['class']['db']
                ->table('user_record')
                ->field('ip','times','device','browser')
                ->where('uid=?',$_GET['id'])
                ->order('id desc')
                ->one();

 $arr = array_merge((array)$user,(array)$userDetail,(array)$userRecord);


 //解析权限
 $arr['authority'] = $website['class']['db']->user_authority_num($arr['authority']);

 $arr['rtime']  = $arr['rtime'] ? date('Y-m-d',$arr['rtime']) : '0-0-0-0';
 $arr['times']  = $arr['times'] ? date('Y-m-d',$arr['ntime']) : '0-0-0-0';

 $arr['rip']    = $arr['rip'] ? long2ip($arr['rip']) : '0.0.0.0';
 $arr['ip']    = $arr['ip'] ? long2ip($arr['ip']) : '0.0.0.0';

  return json_encode(
    array(
      'status'=>'ok',
      'msg'=>'types-add',
      'data'=> $arr
    )
  );
}
