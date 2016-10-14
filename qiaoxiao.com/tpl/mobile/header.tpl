<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no, width=device-width">
    <meta name="keywords" content="首页" />
    <meta name="description" content="巧笑新闻" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <title><!--{$tit}--></title>
    <!--{include file='./mobile/css.tpl'}-->
  </head>
  <body>
    <div class="flex m-header">
      <div class="ico">
        <a href="/"></a>
      </div>
      <div class="flex btn">
        <a href="javascript:;" class="search"></a>
        <a href="javascript:;" class="list"></a>
      </div>
    </div>

    <div class="m-search">
      <form action="/act.php">
        <div class="flex search"><input type="hidden" name="act" value="search">
          <div class="flex txt"><input class="radius-10" type="text" placeholder="请输入关键词" name="wd" /></div>
          <div class="sub"><input type="submit" value="搜索" /></div>
        </div>
      </form>
    </div>
    <div class="m-navs">
      <div class="nlist">
        <ul class="flex">
          <li><a href="<!--{fn_url href='/act.php?act=list&tid=5663'}-->">明星</a></li>
          <li><a href="<!--{fn_url href='/act.php?act=list&tid=5717'}-->">新闻</a><sup class="hot"></sup></li>
          <li><a href="<!--{fn_url href='/act.php?act=list&tid=5664'}-->">影讯</a></li>
          <li><a href="<!--{fn_url href='/act.php?act=list&tid=5665'}-->">综艺</a></li>
          <li><a href="<!--{fn_url href='/act.php?act=list&tid=5666'}-->">八卦</a><sup class="new"></sup></li>

        </ul>
        <ul class="flex">
          <li><a href="<!--{fn_url href='/act.php?act=plist&tid=5667'}-->">美图</a><sup class="new"></sup></li>
          <li><a href="<!--{fn_url href='/act.php?act=list&tid=5669'}-->">潮流</a></li>
          <li><a href="<!--{fn_url href='/act.php?act=list&tid=5718'}-->">百科</a><sup class="new"></sup></li>
          <li><a href="<!--{fn_url href='/act.php?act=list&tid=5670'}-->">游戏</a><sup class="hot"></sup></li>
          <li><a href="<!--{fn_url href='/act.php?act=plist&tid=5673'}-->">网红</a></li>

        </ul>
      </div>
      <div class="bg opacity-5"></div>
    </div>
