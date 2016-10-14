<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <meta name="description" content="<?php echo $description; ?>" />

    <title><?php echo $tit; ?></title>
    <?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/007b5b06d12e6d2c8df0913dca3a0b30-css.tpl.php') ?>
</head>

<body>
<div class="m-header">
  <div class="ico">
    <a href="/"></a>
  </div>
  <div class="search">
    <form action="/act.php">
    <div class="ipt"><input type="hidden" name="act" value="search">
        <input name="wd" placeholder="输入需要查询的内容" class="txt" type="text" />
        <input class="btn" type="submit" value="" />
    </div>
  </form>
    <div class="hot">
      热点内容：
        <a class="radius-10" href="#">新歌声</a>
        <a class="radius-10 act" href="#">青云志</a>
        <a class="radius-10" href="#">里约奥运会</a>
        <a class="radius-10" href="#">老九门</a>
    </div>
  </div>
  <ul class="movier">
    <li>
      <a class="img" href="#"><img src="<?php echo fn_url(array('href'=>'/image/test.jpg')); ?>" /><b></b></a>
      <a href="#">李易峰</a>
    </li>
    <li>
      <a class="img" href="#"><img src="<?php echo fn_url(array('href'=>'/image/test.jpg')); ?>" /><b></b></a>
      <a href="#">李易峰</a>
    </li>
    <li>
      <a class="img" href="#"><img src="<?php echo fn_url(array('href'=>'/image/test.jpg')); ?>" /><b></b></a>
      <a href="#">李易峰</a>
    </li>
    <li>
      <a class="img" href="#"><img src="<?php echo fn_url(array('href'=>'/image/test.jpg')); ?>" /><b></b></a>
      <a href="#">李易峰</a>
    </li>
    <li>
      <a class="img" href="#"><img src="<?php echo fn_url(array('href'=>'/image/test.jpg')); ?>" /><b></b></a>
      <a href="#">李易峰</a>
    </li>
  <ul>
  <div class="br"></div>
</div>
<div class="m-nav">
    <ul>
      <li class="act"><a class="<?php if(!isset($tid)){ ?>ngb<?php } ?>" href="/">首页</a></li>
      <li><a target="_blank" class="<?php if($tid == '5663'){ ?>ngb<?php } ?>" href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid=5663')); ?>">明星动态</a></li>
      <li><a target="_blank" class="<?php if($tid == '5664'){ ?>ngb<?php } ?>" href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid=5664')); ?>">影视资讯</a></li>
      <li><a target="_blank" class="<?php if($tid == '5665'){ ?>ngb<?php } ?>" href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid=5665')); ?>">综艺资讯</a></li>
      <li><a target="_blank" class="<?php if($tid == '5666'){ ?>ngb<?php } ?>" href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid=5666')); ?>">趣说八卦</a></li>
      <li><a target="_blank" class="<?php if($tid == '5667'){ ?>ngb<?php } ?>" href="<?php echo fn_url(array('href'=>'/act.php?act=plist&tid=5667')); ?>">明星美图</a></li>
      <li><a target="_blank" class="<?php if($tid == '5674'){ ?>ngb<?php } ?>" href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid=5674')); ?>">戏说娱乐</a></li>
      <li><a target="_blank" class="<?php if($tid == '5669'){ ?>ngb<?php } ?>" href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid=5669')); ?>">潮流前线</a></li>
      <li><a target="_blank" class="<?php if($tid == '5670'){ ?>ngb<?php } ?>" href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid=5670')); ?>">游戏资讯</a></li>
      <li><a target="_blank" class="<?php if($tid == '5673'){ ?>ngb<?php } ?>" href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid=5673')); ?>">网红集锦</a></li>
      <li class="btn"></li>
    </ul>
</div>
