<?php

$aid = $_GET['aid']??1;
$page= $_GET['p']??1;
$id = $_GET['id']??1;
$tid = $_GET['tid']??1;
$click = fn_session('click'); //$click = array('1','2','3','5')
if($click){
  if(!in_array($aid,$click)){
    $click[] = $aid;
    $_SESSION['click']=json_encode($click);
    $this->website['class']['db']->exec('update article set `click`=`click`+1 where id='.$aid.' limit 1');
  }
}else{
  $click=array();
  $click[] = $aid;
  $_SESSION['click']=json_encode($click);
  $this->website['class']['db']->exec('update article set `click`=`click`+1 where id='.$aid.' limit 1');
}

$article = $this->website['class']['db']
                ->table('article')
                ->where('id=?',$aid)
                ->one();
$detail  = $this->website['class']['db']
                ->table('article_detail')
                ->where('aid=? and page=?',$aid,$page)
                ->one();

$related = $this->website['class']['db']
                ->table('article')
                ->limit(5)
                ->order('createtime desc')
                ->select();
$related2 = $this->website['class']['db']
                ->table('article')
                ->limit('5,5')
                ->order('createtime desc')
                ->select();

$yljj = $this->website['class']['db']
                ->table('article')
                ->field('tit','image','id')
                ->order('id desc')
                ->limit('6')
                ->page($page)
                ->where('tid=?',5674)
                ->select();


$up = $detail['page']-1;
if($up < 1){
  $up =1;
}
$down = $page+1;

if($down >= $article['pg']){
  $down = $article['pg'];
}

$ll = fn_between_time();

if($this->website['class']['db']
        ->table('article')
        ->where('createtime between ? and ?',$ll['first'],$ll['last'])
        ->count()>8){
        $looking = $this->website['class']['db']
                        ->table('article')
                        ->order('click desc')
                        ->where('createtime between ? and ?',$ll['first'],$ll['last'])
                        ->limit(8)
                        ->select();
                  }else{
                    $looking = $this->website['class']['db']
                                    ->table('article')
                                    ->order('click desc')
                                    ->limit(8)
                                    ->select();
                        }

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
                      ->where('createtime between ? and ? and tid=?',$ll['first'],$ll['last'],5667)
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
        ->where('createtime between ? and ? and tid=?',$ll['first'],$ll['last'],5673)
        ->count()>8){
          $red = $this->website['class']['db']
                      ->table('article')
                      ->order('click desc')
                      ->where('createtime between ? and ? and tid=?',$ll['first'],$ll['last'],5673)
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
// print_r($hot);
// echo '</pre>';

// 网站详情页
$this->website['class']['tpl']
    ->assign('keywords','巧笑星闻')
    ->assign('css',array('/css/article.css'))
    ->assign('jss',array(''))
    ->assign('tit',$article['tit'].'_巧笑星闻')
    ->assign('keywords','巧笑星闻,qiaoxiao.com')
    ->assign('description','巧笑星闻qiaoxiao.com')
    ->assign('article',$article)
    ->assign('detail',$detail)
    ->assign('related',$related)
    ->assign('related2',$related2)
    ->assign('up',$up)
    ->assign('down',$down)
    ->assign('aid',$aid)
    ->assign('tid',$article['tid'])
    ->assign('page',$page)
    ->assign('yljj',$yljj)
    ->assign('looking',$looking)
    ->assign('hot',$hot)
    ->assign('start',$start)
    ->assign('red',$red)
    ->display('article.tpl');
