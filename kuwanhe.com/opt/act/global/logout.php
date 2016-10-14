<?php

//注销用户
function act_global_logout(&$website){
    unset($_SESSION['optLogin']);
    return json_encode(array('status'=>'ok','msg'=>'logout','data'=>'ok'));
}
