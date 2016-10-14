<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">
     <meta name="keywords" content="首页" />
     <meta name="description" content="巧笑新闻" />
     <meta http-equiv="Cache-Control" content="no-cache" />
     <meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no, width=device-width">
     <title><?php echo $tit; ?></title>
      <?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/f2009f6a9f6c5bd56469369e8e5037bb-mobile.css.tpl.php') ?>
  </head>
  <body>
    <header class="flex header-nav">
      <div class="flex left">
        <a class="flex back" href="<?php if(($type['id']==5673||$type['id']==5667)){ ?><?php echo fn_url(array('href'=>'/act.php?act=plist&tid='.$type['id'])); ?><?php }else{ ?><?php echo fn_url(array('href'=>'/act.php?act=list&tid='.$type['id'])); ?><?php } ?>">
          <img src="<?php echo fn_url(array('href'=>'/image/mobile/28.png')); ?>" alt="" /><span><?php echo $type['tit']; ?></span>
        </a>
      </div>
      <?php if(0){ ?>
      <div class="right">
        <a class="shar" href="#"><img src="<?php echo fn_url(array('href'=>'/image/mobile/27.png')); ?>" alt="" /></a>
      </div>
      <?php } ?>
    </header>
