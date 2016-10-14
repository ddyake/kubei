<?php

$p = $_GET['p']??1;
$result = $this->website['class']['db']
                ->table('article')
                ->field('tit','image','createtime','note','tid','id')
                ->order('id desc')
                ->where("tit like ?",'%'.$_GET['wd'].'%')
                ->page($p)
                ->paging();


                // echo '<pre>';
                // print_r($result);
                // echo '</pre>';
  // print_r($result);
// echo $this->website['class']['db']->sql;
// 网站搜索页
$this->website['class']['tpl']
    ->assign('css',array('/css/mobile/search.css'))
    ->assign('jss',array(''))
    ->assign('tit','巧笑星闻-m.qiaoxiao.com')
    ->assign('keywords','巧笑星闻,m.qiaoxiao.com')
    ->assign('description','巧笑星闻m.qiaoxiao.com')
    ->assign('results',$result)
    ->display('mobile/search.tpl');
