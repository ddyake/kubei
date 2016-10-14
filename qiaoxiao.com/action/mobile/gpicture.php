<?php
$tid=5667;
$page = $_GET['p']??1;
$id=$_GET['id']??1;
$aid=$_GET['pid']??1;
// 明扣选择
$mk = fn_device() == 'Android' ? $this->website['jump']['android'] : $this->website['jump']['ios'];

$type=$this->website['class']['db']
            ->table('type')
            ->where('id=?',$tid)
            ->field('id','tit')
            ->one();


$article = $this->website['class']['db']
                ->table('article')
                ->field('tid','pg','tit','createtime')
                ->where('id=?',$aid)
                ->one();

$picture    = $this->website['class']['db']
               ->table('article_image')
               ->field('img')
               ->where('aid=? and page=?',$aid,$page)
               ->one();
$pages = array('up'=>0,'down'=>0,'now'=>0,'max'=>$article['pg']);
if($article['pg']<=1){
  $pages=false;
}else{
  $pages['now'] = $page;
  $pages['up']  = $page-1<1?1:$page-1;
  $pages['down']= $page+1>$article['pg']?$article['pg']:$page+1;
}



$upPicture = $this->website['class']['db']
                ->table('article')
                ->field('id','tit')
                ->where('tid=? and id>?',$article['tid'],$aid)
                ->order('id asc')
                ->one();
if(!isset($upPicture['id'])){
  $upPicture = $this->website['class']['db']
                  ->table('article')
                  ->field('min(id)','tit')
                  ->where('tid=?',$article['tid'])
                  ->one();
  $upPicture['id'] = $upPicture['min(id)'];

}

$downPicture = $this->website['class']['db']
                ->table('article')
                ->field('id','tit')
                ->where('tid=? and id<?',$article['tid'],$aid)
                ->order('id desc')
                ->one();
if(!isset($downPicture['id'])){
  $downPicture = $this->website['class']['db']
                  ->table('article')
                  ->field('max(id)','tit')
                  ->where('tid=?',$article['tid'])
                  ->one();
  $downPicture['id'] = $downPicture['max(id)'];

}

// 相关图片
$about = $this->website['class']['db']
                ->table('article')
                ->field('image','tit','id')
                ->order('id desc')
                ->limit('6')
                ->where('tid=?',$tid)
                ->select();



// 中间浮动图片
$floatGif = $this->website['class']['db']
                ->table('article')
                ->field('image','tit','id')
                ->order('rand()')
                ->where('tid=? and id != ?',5700,$aid)
                ->limit(2)
                ->select();
$floatMk = $this->website['class']['db']
                ->table('links')
                ->field('id,image','tit')
                ->order('rand()')
                ->where('tid=?',5696)
                ->limit(2)
                ->select();
$floatMkId=[];
foreach($floatMk as &$v){
  $floatMkId[]=$v['id'];
  $v['href'] = $mk;
}
$gifId=[$aid];
foreach($floatGif as &$v){
  $gifId[] = $v['id'];
  $v['href'] = fn_url(array('href'=>'/act.php?act=gpicture&pid='.$v['id']));
}



// 头部浮动图片
$floatHead = $this->website['class']['db']
                ->table('links')
                ->field('id','image')
                ->order('rand()')
                ->where('tid=5720')
                ->one();
// 底部浮动图片
$floatFoot = $this->website['class']['db']
                ->table('links')
                ->field('image')
                ->order('rand()')
                ->where('tid=5720 and id!='.$floatHead['id'])
                ->one();

// 推荐图片
$look = $this->website['class']['db']
                ->table('article')
                ->field('image','tit','id')
                ->order('rand()')
                ->where('tid=5700')
                ->limit(6)
                ->select();
// echo '<b style="display:none">',print_r($downPicture,1),'</b>';
// 网站图片页
$this->website['class']['tpl']
    ->assign('css',array('/css/mobile/gpicture.css'))
    ->assign('jss',array(''))
    ->assign('tit','巧笑星闻-m.qiaoxiao.com')
    ->assign('keywords','巧笑星闻,m.qiaoxiao.com')
    ->assign('description','巧笑星闻m.qiaoxiao.com')
    ->assign('type',$type)
    ->assign('pages',$pages)
    ->assign('picture',$picture)
    ->assign('article',$article)
    ->assign('upPicture',$upPicture)
    ->assign('downPicture',$downPicture)
    ->assign('about',array_slice($about,0,3))
    ->assign('abouts',array_slice($about,-3))
    ->assign('look',array_slice($look,0,3))
    ->assign('looks',array_slice($look,-3))
    ->assign('floatTop',[$floatMk[0],$floatGif[0]])
    ->assign('floatBtm',[$floatGif[1],$floatMk[1]])
    ->assign('floatFoot',$floatFoot)
    ->assign('floatHead',$floatHead)
    ->assign('mk',$mk)
    ->assign('mkImg','/data/upload/image/201609/20/d04f53f91ddbe1f41acb.jpg')
    ->assign('aid',$aid)
    ->display('mobile/gpicture.tpl');
