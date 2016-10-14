<?php

$p = $_GET['p']??1;
$result = $this->website['class']['db']
                ->table('article')
                ->field('tit','image','createtime','note','tid','id')
                ->order('id desc')
                ->where("tit like ?",'%'.$_GET['wd'].'%')
                ->page($p)
                ->num(10)
                ->paging();
$mount =$this->website['class']['db']
                ->table('article')
                ->where("tit like ?",'%'.$_GET['wd'].'%')
                ->count();
                // echo '<pre>';
                // print_r($result);
                // echo '</pre>';
// 网站搜索页
$this->website['class']['tpl']
    ->assign('css',array('/css/search.css'))
    ->assign('jss',array('/js/search.js'))
    ->assign('tit','巧笑星闻.qiaoxiao.com')
    ->assign('keywords','巧笑星闻,qiaoxiao.com')
    ->assign('description','巧笑星闻qiaoxiao.com')
    ->assign('results',$result)
    ->assign('mount',$mount)
    ->display('search.tpl');
