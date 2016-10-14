<?php

// 获取链接内容
$links = function($tid,$num) use(&$website){
  return $website['class']['db']
       ->table('links')
       ->field('tit','href','cont')
       ->where('tid=?',$tid)
       ->order('id desc')
       ->limit($num)
       ->select();
};

$jss = array('/js/index.js');
$css = array('/css/index.css');
// 后台页面编辑功能
$optLogin = fn_session('optLogin');

if($optLogin){
  $authority = fn_user_authority_resolve($optLogin['authority']);
  if(in_array('edit',$authority) || in_array('admin',$authority)){
    $optLogin = true;
    $jss[] = '/js/edit.js';
    $jss[] = '/opt/js/ui/ui.js';
    $jss[] = '/opt/js/plugin.js';
    $jss[] = '/opt/js/upload.js';
    $css[] = '/opt/js/ui/ui.css';
    $css[] = '/css/edit.css';
  }else{
    $optLogin = false;
  }
}
// 明星
$mingxing = $this->website['class']['db']
                  ->table('article')
                  ->field('id','tit','createtime')
                  ->where('tid=5663')
                  ->limit(10)
                  ->order('id desc')
                  ->select();
// 影视资讯
$yszx      = $this->website['class']['db']
                  ->table('article')
                  ->field('id','tit','createtime')
                  ->where('tid=5666')
                  ->limit(12)
                  ->order('id desc')
                  ->select();


// 网站首页
$this->website['class']['tpl']
    ->assign('css',$css)
    ->assign('jss',$jss)
    ->assign('tit','巧笑星闻')
    ->assign('keywords','巧笑星闻,qiaoxiao.com')
    ->assign('description','巧笑星闻qiaoxiao.com')
    ->assign('jrtt',$links(5677,3))
    ->assign('mxA',array_splice($mingxing,0,5))
    ->assign('mxB',array_splice($mingxing,-5))
    // 趣说八卦
    ->assign('qsba',$this->website['class']['db']
                      ->table('article')
                      ->field('id','tit','note')
                      ->where('tid=5666')
                      ->limit(3)
                      ->order('id desc')
                      ->select()
    )
    //影视资讯
    ->assign('yszxA',array_splice($yszx,0,6))
    ->assign('yszxB',array_splice($yszx,-6))
    ->assign('yszxC',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image')
                      ->where('tid=5683')
                      ->order('id desc')
                      ->limit(12)
                      ->select()
    )
    // 娱乐资讯链接
    ->assign('ylzxA',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image','cont')
                      ->where('tid=5676')
                      ->order('id desc')
                      ->one()
    )
    ->assign('ylzxB',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image')
                      ->where('tid=5678')
                      ->order('id desc')
                      ->one()
    )
    ->assign('ylzxC',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image')
                      ->where('tid=5679')
                      ->order('id desc')
                      ->limit(6)
                      ->select()
    )
    ->assign('ylzxD',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image','cont')
                      ->where('tid=5681')
                      ->order('id desc')
                      ->limit(3)
                      ->select()
    )
    ->assign('ylzxE',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image')
                      ->where('tid=5682')
                      ->order('id desc')
                      ->limit(6)
                      ->select()
    )
    // 明星美图链接
    ->assign('mxmtA',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image')
                      ->where('tid=5686')
                      ->order('id desc')
                      ->one()
    )
    ->assign('mxmtB',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image')
                      ->where('tid=5687')
                      ->order('id desc')
                      ->one()
    )
    ->assign('mxmtC',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image')
                      ->where('tid=5699')
                      ->order('id desc')
                      ->select()
    )
    // 网红整容
    ->assign('wanghongA',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image','cont')
                      ->where('tid=5702')
                      ->order('id desc')
                      ->one()
    )
    ->assign('wanghongB',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image')
                      ->where('tid=5703')
                      ->order('id desc')
                      ->limit(2)
                      ->select()
    )
    ->assign('wanghongC',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image','cont')
                      ->where('tid=5704')
                      ->order('id desc')
                      ->one()
    )
    ->assign('wanghongD',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image')
                      ->where('tid=5705')
                      ->order('id desc')
                      ->one()
    )
    ->assign('wanghongE',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image','cont')
                      ->where('tid=5706')
                      ->order('id desc')
                      ->limit(2)
                      ->select()
    )
    // 综艺资讯
    ->assign('zyzxA',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image','cont')
                      ->where('tid=5711')
                      ->order('id desc')
                      ->one()
    )
    ->assign('zyzxB',$this->website['class']['db']
                      ->table('links')
                      ->field('id','tit','href','image','cont')
                      ->where('tid=5712')
                      ->limit(2)
                      ->order('id desc')
                      ->select()
    )
    ->assign('optLogin',$optLogin)
    ->display('index.tpl');
