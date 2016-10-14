<?php
$tid=$_GET['tid']??1;
$id=$_GET['id']??1;

$page = $_GET['p']??1;
$type=$this->website['class']['db']
            ->table('type')
            ->where('id=?',$tid)
            ->field('tit','id')
            ->one();

$articles = $this->website['class']['db']
                ->table('article')
                ->field()
                ->order('id desc')
                ->num(5)
                ->page($page)
                ->where('tid=?',$tid)
                ->paging();


                // echo '<pre>';
                // print_r($tid);
                // echo '</pre>';

// 网站文章列表
$this->website['class']['tpl']
    ->assign('css',array('/css/mobile/list.css'))
    ->assign('jss',array())
    ->assign('tit',$type['tit'])
    ->assign('keywords','巧笑星闻,m.qiaoxiao.com')
    ->assign('description','巧笑星闻m.qiaoxiao.com')
    ->assign('tp',$type)
    ->assign('tid',$tid)
    ->assign('nav',$tid)
    ->assign('art',$articles)

    ->assign('slider',$this->website['class']['db']
                            ->table('links')
                            ->field('tit','href','image')
                            ->where('tid=5691')
                            ->limit(5)
                            ->order('id desc')
                            ->select()
    )
    ->display('mobile/list.tpl');
