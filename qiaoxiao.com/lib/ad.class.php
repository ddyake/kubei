<?php
// 站内统计
namespace QiaoXiao;


class Adv{
  var $webisite;

  function __construct(&$website){
    $this->website = $website;
    if(!is_object($this->website['class']['db'])){
      $this->website['class']['db']=new Database($website);
    }
  }

  // 开始统计
  function count(){
    
  }


}
