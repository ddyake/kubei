<?php
$aid = $_GET['aid']??1;

$page= $_GET['p']??1;

$article = $this->website['class']['db']
                ->table('article')
                ->where('id=?',$aid)
                ->one();
$detail  = $this->website['class']['db']
                ->table('article_detail')
                ->where('aid=? and page=?',$aid,$page)
                ->one();

$type=$this->website['class']['db']
            ->table('type')
            ->where('id=?',$article['tid'])
            ->field('tit','id')
            ->one();
$pages = $this->website['class']['db']
                ->table('article_detail')
                ->field('page','tits')
                ->order('page asc')
                ->where('aid=?',$aid)
                ->select();

$up = $page-1;
if($up < 1){
  $up =1;
}
$down = $page+1;

if($down >= $article['pg']){
  $down = $article['pg'];
}
// echo '<pre>';
// print_r($pages);
// echo '</pre>';

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


// 相关内容
$tag = explode('，',$article['tag']);
$where = [];
foreach($tag as $v){
  if($v){
    $where[] = "tag like '%".$v."%'";
  }
}

$wheres = count($where)?implode(' or ',$where).' or id <>'.$aid:'id !='.$aid;
$likes = $this->website['class']['db']
                ->table('article')
                ->field('id','tit','note','image')
                ->where($wheres)
                ->limit(12)
                ->order('id desc')
                ->select();
// 明扣
$ggao = $this->website['class']['db']
                ->table('links')
                ->field('tit','image')
                ->where('tid=5696')
                ->limit(8)
                ->order('rand()')
                ->select();

$related = [];
$k=0;
foreach($ggao as $i=>&$v){
  $v['href'] = fn_device() == 'Android' ? 'http://xxx.wei23.cn/crwt234' : 'http://mema.ymre.top:89/wwt089';
  $related[] = $v;
  if(!(($i+1)%2)){
    $related[] = $likes[$k];
    $related[] = $likes[$k+1];
    $related[] = $likes[$k+2];
    $k+=3;
  }
}


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
                ->where('tid=?',5667)
                ->one();

$ggaos = $this->website['class']['db']
                ->table('links')
                ->field('tit','image')
                ->where('tid=5696')
                ->limit(2)
                ->order('rand()')
                ->select();


  $ggaos['href'] = fn_device() == 'Android' ? 'http://xxx.wei23.cn/crwt234' : 'http://mema.ymre.top:89/wwt089';
// echo '<pre>';
// print_r($wheres);
// echo '</pre>';


$this->website['class']['tpl']
    ->assign('css',array('/css/mobile/article.css'))
    ->assign('jss',array())
    ->assign('tit',$article['tit'])
    ->assign('keywords','巧笑星闻,m.qiaoxiao.com')
    ->assign('description','巧笑星闻m.qiaoxiao.com')
    ->assign('article',$article)
    ->assign('detail',$detail)
    ->assign('up',$up)
    ->assign('down',$down)
    ->assign('aid',$aid)
    ->assign('page',$page)
    ->assign('pages',$pages)
    ->assign('type',$type)
    ->assign('related',$related)
    ->assign('array',$array)
    ->assign('arrays',$arrays)
    ->assign('ggaos',$ggaos)
    ->display('mobile/article.tpl');
