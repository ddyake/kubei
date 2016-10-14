<?php
$id=$_GET['id']??1;
$page = $_GET['p']??1;
$aid=$_GET['aid']??1;
$tid=$_GET['tid']??1;
$pic = $this->website['class']['db']
                ->table('article_image')
                ->field()
                ->order('id desc')
                ->page($page)
                ->num(1)
                ->where('aid=?',$aid)
                ->paging();
$article = $this->website['class']['db']
                ->table('article')
                ->where('id=?',$aid)
                ->one();
                $yljj = $this->website['class']['db']
                                ->table('article')
                                ->field('tit','image','id')
                                ->order('id desc')
                                ->limit('6')
                                ->page($page)
                                ->where('tid=?',5674)
                                ->select();
$upPicture = $this->website['class']['db']
                  ->table('article')
                  ->where('id<? && tid=?',$article['id'],$article['tid'])
                  ->order('id desc')
                  ->one();
$downPicture = $this->website['class']['db']
                  ->table('article')
                  ->where('id>? && tid=?',$article['id'],$article['tid'])
                  ->order('id asc')
                  ->one();
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
                // print_r($downPicture);
                // echo '</pre>';
$this->website['class']['tpl']
    ->assign('keywords','巧笑星闻')
    ->assign('css',array('/css/picture.css'))
    ->assign('jss',array(''))
    ->assign('tit',$article['tit'].'_巧笑星闻')
    ->assign('keywords','巧笑星闻,qiaoxiao.com')
    ->assign('description','巧笑星闻qiaoxiao.com')
    ->assign('pic',$pic)
    ->assign('aid',$article['id'])
    ->assign('tid',$tid)
    ->assign('article',$article)
    ->assign('yljj',$yljj)
    ->assign('upPicture',$upPicture)
    ->assign('downPicture',$downPicture)
    ->assign('start',$start)
    ->assign('red',$red)
    ->assign('hot',$hot)
    ->display('picture.tpl');
