<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="<!--{$keywords}-->" />
    <meta name="description" content="<!--{$description}-->" />

    <title><!--{$tit}--></title>
    <!--{include file='css.tpl'}-->
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
      <a class="img" href="#"><img src="<!--{fn_url href='/image/test.jpg'}-->" /><b></b></a>
      <a href="#">李易峰</a>
    </li>
    <li>
      <a class="img" href="#"><img src="<!--{fn_url href='/image/test.jpg'}-->" /><b></b></a>
      <a href="#">李易峰</a>
    </li>
    <li>
      <a class="img" href="#"><img src="<!--{fn_url href='/image/test.jpg'}-->" /><b></b></a>
      <a href="#">李易峰</a>
    </li>
    <li>
      <a class="img" href="#"><img src="<!--{fn_url href='/image/test.jpg'}-->" /><b></b></a>
      <a href="#">李易峰</a>
    </li>
    <li>
      <a class="img" href="#"><img src="<!--{fn_url href='/image/test.jpg'}-->" /><b></b></a>
      <a href="#">李易峰</a>
    </li>
  <ul>
  <div class="br"></div>
</div>
<div class="m-nav">
    <ul>
      <li class="act"><a class="<!--{if !isset($tid) }-->ngb<!--{/if}-->" href="/">首页</a></li>
      <li><a target="_blank" class="<!--{if $tid == '5663' }-->ngb<!--{/if}-->" href="<!--{fn_url href='/act.php?act=list&tid=5663'}-->">明星动态</a></li>
      <li><a target="_blank" class="<!--{if $tid == '5664' }-->ngb<!--{/if}-->" href="<!--{fn_url href='/act.php?act=list&tid=5664'}-->">影视资讯</a></li>
      <li><a target="_blank" class="<!--{if $tid == '5665' }-->ngb<!--{/if}-->" href="<!--{fn_url href='/act.php?act=list&tid=5665'}-->">综艺资讯</a></li>
      <li><a target="_blank" class="<!--{if $tid == '5666' }-->ngb<!--{/if}-->" href="<!--{fn_url href='/act.php?act=list&tid=5666'}-->">趣说八卦</a></li>
      <li><a target="_blank" class="<!--{if $tid == '5667' }-->ngb<!--{/if}-->" href="<!--{fn_url href='/act.php?act=plist&tid=5667'}-->">明星美图</a></li>
      <li><a target="_blank" class="<!--{if $tid == '5674' }-->ngb<!--{/if}-->" href="<!--{fn_url href='/act.php?act=list&tid=5674'}-->">戏说娱乐</a></li>
      <li><a target="_blank" class="<!--{if $tid == '5669' }-->ngb<!--{/if}-->" href="<!--{fn_url href='/act.php?act=list&tid=5669'}-->">潮流前线</a></li>
      <li><a target="_blank" class="<!--{if $tid == '5670' }-->ngb<!--{/if}-->" href="<!--{fn_url href='/act.php?act=list&tid=5670'}-->">游戏资讯</a></li>
      <li><a target="_blank" class="<!--{if $tid == '5673' }-->ngb<!--{/if}-->" href="<!--{fn_url href='/act.php?act=list&tid=5673'}-->">网红集锦</a></li>
      <li class="btn"></li>
    </ul>
</div>
