<?php
// 网站错误处理
class WebError{
  //戳无处理
  public function manage($arr){
    switch($arr['type']){
      //关闭脚本处理
      case 'stop':
        echo $arr['msg'];
        exit();
        break;
    }
  }
}
