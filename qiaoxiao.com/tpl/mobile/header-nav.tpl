<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">
     <meta name="keywords" content="首页" />
     <meta name="description" content="巧笑新闻" />
     <meta http-equiv="Cache-Control" content="no-cache" />
     <meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no, width=device-width">
     <title><!--{$tit}--></title>
      <!--{include file='./mobile/css.tpl'}-->
  </head>
  <body>
    <header class="flex header-nav">
      <div class="flex left">
        <a class="flex back" href="<!--{if ($type['id']==5673||$type['id']==5667)}--><!--{fn_url href='/act.php?act=plist&tid='.$type['id']}--><!--{else}--><!--{fn_url href='/act.php?act=list&tid='.$type['id']}--><!--{/if}-->">
          <img src="<!--{fn_url href='/image/mobile/28.png'}-->" alt="" /><span><!--{$type['tit']}--></span>
        </a>
      </div>
      <!--{if 0}-->
      <div class="right">
        <a class="shar" href="#"><img src="<!--{fn_url href='/image/mobile/27.png'}-->" alt="" /></a>
      </div>
      <!--{/if}-->
    </header>
