<?php
$tid=$_GET['tid']??1;
$page = $_GET['p']??1;
$id=$_GET['id']??1;

$articles = $this->website['class']['db']
                ->table('article')
                ->field()
                ->order('id desc')
                ->num(6)
                ->page($page)
                ->where('tid=?',$tid)
                ->paging();

$type=$this->website['class']['db']
            ->table('type')
            ->where('id=?',$tid)
            ->field('tit','id')
            ->one();
            // echo '<pre>';
            // print_r($type);
            // echo '</pre>';
// 网站图片列表
$this->website['class']['tpl']
    ->assign('css',array('/css/mobile/plist.css'))
    ->assign('jss',[])
    ->assign('tit',$type['tit'])
    ->assign('keywords','巧笑星闻,m.qiaoxiao.com')
    ->assign('description','巧笑星闻m.qiaoxiao.com')
    ->assign('art',$articles)
    ->assign('type',$type)
    ->assign('slider',$this->website['class']['db']
                            ->table('links')
                            ->field('tit','href','image')
                            ->where('tid=5691')
                            ->limit(5)
                            ->order('id desc')
                            ->select()
    )
    ->assign('nav',$tid)
    ->display('mobile/plist.tpl');
