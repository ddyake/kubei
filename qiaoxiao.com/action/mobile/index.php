<?php

$article = $this->website['class']['db']
                        ->table('links')
                        ->field('tit','href','image','cont')
                        ->where('tid=5721')
                        ->limit(6)
                        ->order('id desc')
                        ->select();
foreach($article as &$v){
  if(preg_match('/aid=(\d+)/',$v['href'],$arr)){
    $one = $this->website['class']['db']
                            ->table('article')
                            ->field('click')
                            ->where('id=?',$arr[1])
                            ->one();
    $v['click'] = $one['click'];
  }else{
    $v['click'] = 1;
  }
}

$start = $this->website['class']['db']
                ->table('article')
                ->order('id desc')
                ->where('tid=?',5663)
                ->limit(3)
                ->select();
$tv = $this->website['class']['db']
              ->table('article')
              ->order('id desc')
              ->where('tid=?',5664)
              ->limit(3)
              ->select();
$fine = $this->website['class']['db']
              ->table('article')
              ->order('id desc')
              ->where('tid=?',5665)
              ->limit(3)
              ->select();
$eight = $this->website['class']['db']
              ->table('article')
              ->order('id desc')
              ->where('tid=?',5666)
              ->limit(3)
              ->select();

              // echo '<pre>';
              // print_r($article);
              // echo '</pre>';


// 网站首页
$this->website['class']['tpl']
    ->assign('css',array('/css/mobile/index.css'))
    ->assign('jss',array('/js/mobile/index.js'))
    ->assign('tit','巧笑星闻')
    ->assign('keywords','巧笑星闻,m.qiaoxiao.com')
    ->assign('description','巧笑星闻m.qiaoxiao.com')
    // 今日头条
    ->assign('article',$article)
    ->assign('start',$start)
    ->assign('tv',$tv)
    ->assign('fn',$fine)
    ->assign('eight',$eight)
    ->assign('nav','index')
    ->assign('slider',$this->website['class']['db']
                            ->table('links')
                            ->field('tit','href','image')
                            ->where('tid=5691')
                            ->limit(5)
                            ->order('id desc')
                            ->select()
    )
    ->display('mobile/index.tpl');
