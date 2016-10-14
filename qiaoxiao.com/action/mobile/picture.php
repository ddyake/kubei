<?php
$tid=$_GET['tid']??5667;
$page = $_GET['p']??1;
$id=$_GET['id']??1;
$aid=$_GET['aid']??1;

$pic = $this->website['class']['db']
                ->table('article_image')
                ->field()
                ->order('id desc')
                ->page($page)
                ->num(1)
                ->where('aid=?',$aid)
                ->paging();
$type=$this->website['class']['db']
            ->table('type')
            ->where('id=?',$tid)
            ->field('tit','id')
            ->one();


$article = $this->website['class']['db']
                ->table('article')
                ->where('id=?',$aid)

                ->one();
$upPicture = $this->website['class']['db']
                ->table('article')
                ->where('id<? && tid=?',$article['id'],$tid)
                // ->where('tid=?',5667)
                ->order('id desc')
                ->one();

$downPicture = $this->website['class']['db']
                ->table('article')
                ->where('id>? && tid=?',$article['id'],$tid)
                // ->where('tid=?',5667)
                ->order('id asc')
                ->one();


$about = $this->website['class']['db']
                ->table('article')
                ->field('image','tit','id')
                ->order('id desc')
                ->limit('6')

                ->where('tid=?',$tid)
                ->select();



$look = $this->website['class']['db']
                ->table('article')
                ->field('image','tit','id')
                ->order('id desc')
                ->limit('6')

                ->where('tid=?',5673)
                ->select();



$array = $this->website['class']['db']
                ->table('article')
                ->field('image','tit','id')
                ->order('rand()')
                ->where('tid=?',5673)
                ->one();
$arrays = $this->website['class']['db']
                ->table('article')
                ->field('image','tit','id')
                ->order('rand()')
                ->where('tid=?',$tid)
                ->one();

$ggao = $this->website['class']['db']
                ->table('links')
                ->field('tit','image')
                ->where('tid=5696')
                ->limit(2)
                ->order('rand()')
                ->select();


  $ggao['href'] = fn_device() == 'Android' ? 'http://xxx.wei23.cn/crwt234' : 'http://mema.ymre.top:89/wwt089';
// $refer =$this->website['class']['db']
//               ->table('article_image')
//               ->where('tid=?',)
    // echo '<pre>';
    // print_r($ggao);
    // echo '</pre>';
    // echo $this->website['class']['db']->sql;


// 网站图片页
$this->website['class']['tpl']
    ->assign('css',array('/css/mobile/picture.css'))
    ->assign('jss',array(''))
    ->assign('tit','巧笑星闻-m.qiaoxiao.com')
    ->assign('keywords','巧笑星闻,m.qiaoxiao.com')
    ->assign('description','巧笑星闻m.qiaoxiao.com')
    ->assign('type',$type)
    ->assign('pic',$pic)
    ->assign('article',$article)
    ->assign('upPicture',$upPicture)
    ->assign('downPicture',$downPicture)
    ->assign('about',array_slice($about,0,3))
    ->assign('abouts',array_slice($about,-3))
    ->assign('look',array_slice($look,0,3))
    ->assign('looks',array_slice($look,-3))
    ->assign('array',$array)
    ->assign('arrays',$arrays)
    ->assign('ggao',$ggao)
    ->assign('gifpicture',$tid !=5667?'&tid='.$tid:'')
    ->display('mobile/picture.tpl');
