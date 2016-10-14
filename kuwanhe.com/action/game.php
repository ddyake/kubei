<?php



  // 头部幻灯
  $topLink = $this->website['class']['db']
                  ->table('links')
                  ->field('color','target','tit','href','image')
                  ->where('tid=5674')
                  ->order('id desc')
                  ->select();
  // 火热游戏排行
  $rankLink = $this->website['class']['db']
                  ->table('links')
                  ->field('color','target','tit','href','cont')
                  ->where('tid=5676')
                  ->order('id desc')
                  ->limit(7)
                  ->select();
  // 热门游戏
  $hotLink  = $this->website['class']['db']
                  ->table('links')
                  ->field('color','target','tit','href','image')
                  ->where('tid=5677')
                  ->order('id desc')
                  ->limit(8)
                  ->select();
  // 推荐游戏
  $tjLink  = $this->website['class']['db']
                  ->table('links')
                  ->field('color','target','tit','href','image')
                  ->where('tid=5678')
                  ->order('id desc')
                  ->limit(6)
                  ->select();
  // 右侧大图
  $rightLink= $this->website['class']['db']
                  ->table('links')
                  ->field('color','target','tit','href','image')
                  ->where('tid=5679')
                  ->order('id desc')
                  ->one();


// 游戏推荐
$this->website['class']['tpl']
    ->assign('css',array('/css/game.css'))
    ->assign('jss',array('js/slide.js','js/game.js'))
    ->assign('tit','游戏推荐')
    ->assign('keywords','游戏推荐')
    ->assign('description','游戏推荐')
    ->assign('topLink',$topLink)
    ->assign('rankLink',$rankLink)
    ->assign('tjLink',$tjLink)
    ->assign('hotLink',$hotLink)
    ->assign('rightLink',$rightLink)
    ->display('game.tpl');
