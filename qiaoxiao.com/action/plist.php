<?php
$id = $_GET['id']??1;
$page = $_GET['p']??1;
$aid =$_GET['aid']??1;


$pages=$this->website['class']['db']
     ->table('article')
     ->field()
     ->order('createtime desc')
     ->where('tid=?',5667)
     ->num('30')
     ->page($page)
     ->paging();
// echo '<pre>';
// print_r($pages);
// echo '</pre>';


// 网站图片列表页
$this->website['class']['tpl']
    ->assign('keywords','巧笑星闻')
    ->assign('css',array('/css/plist.css'))
    ->assign('jss',array('/js/plist.js'))
    ->assign('tit','巧笑星闻')
    ->assign('keywords','巧笑星闻,qiaoxiao.com')
    ->assign('description','巧笑星闻qiaoxiao.com')
    ->assign('pages',$pages)
    ->assign('page',fn_page($pages,9))
    ->display('plist.tpl');
