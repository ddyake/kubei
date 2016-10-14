<?php

$page = $_GET['p']??1;
$tid = $_GET['tid']??1;


$paging=$this->website['class']['db']
            ->table('article')
            ->field()
            ->order('createtime desc')
            ->where('tid=?',$tid)
            ->num('10')
            ->page($page)
            ->paging();

            $yljj = $this->website['class']['db']
                            ->table('article')
                            ->field('tit','image','id')
                            ->order('id desc')
                            ->limit('6')
                            ->page($page)
                            ->where('tid=?',5674)
                            ->select();
$ll = fn_between_time();
if($this->website['class']['db']
        ->table('article')
        ->where('createtime between ? and ?',$ll['first'],$ll['last'])
        ->count()>4){
          $hot = $this->website['class']['db']
                          ->table('article')
                          ->order('click desc')
                          ->where('createtime between ? and ?',$ll['first'],$ll['last'])
                          ->limit(4)
                          ->select();
                }else{
                  $hot = $this->website['class']['db']
                                  ->table('article')
                                  ->order('click desc')
                                  ->limit(4)
                                  ->select();
                }
if($this->website['class']['db']
        ->table('article')
        ->where('createtime between ? and ? and tid=?',$ll['first'],$ll['last'],5667)
        ->count()>4){
          $start = $this->website['class']['db']
                      ->table('article')
                      ->order('click desc')
                      ->where('createtime between ? and ? tid=?',$ll['first'],$ll['last'],5667)
                      ->limit(4)
                      ->select();
                }else{
                  $start = $this->website['class']['db']
                              ->table('article')
                              ->order('click desc')
                              ->where('tid=?',5667)
                              ->limit(4)
                              ->select();
                }

if($this->website['class']['db']
        ->table('article')
        ->where('createtime between ? and tid=?',$ll['first'],$ll['last'],5673)
        ->count()>8){
          $red = $this->website['class']['db']
                      ->table('article')
                      ->order('click desc')
                      ->where('createtime between tid=?',$ll['first'],$ll['last'],5673)
                      ->limit(8)
                      ->select();
                }else{
                  $red = $this->website['class']['db']
                              ->table('article')
                              ->order('click desc')
                              ->where('tid=?',5673)
                              ->limit(8)
                              ->select();
                }
                // echo '<pre>';
                // print_r($start);
                // echo '</pre>';




// 网站列表页
$this->website['class']['tpl']
    ->assign('keywords','巧笑星闻')
    ->assign('css',array('/css/list.css'))
    ->assign('jss',array())
    ->assign('tit','巧笑星闻')
    ->assign('keywords','巧笑星闻,qiaoxiao.com')
    ->assign('description','巧笑星闻qiaoxiao.com')
    ->assign('paging',$paging)
    ->assign('tid',$tid)
    ->assign('page',fn_page($paging,10))
    ->assign('hot',$hot)
    ->assign('start',$start)
    ->assign('red',$red)
    ->assign('yljj',$yljj)
    ->display('list.tpl');
