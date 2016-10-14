<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no, width=device-width">
    <meta name="keywords" content="首页" />
    <meta name="description" content="巧笑新闻" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <title><!--{$tit}--></title>
    <!--{include file='mobile/css.tpl'}-->
  </head>
  <body>

<div class="flex m-ser">
  <div class="flex head">

    <form class="flex sear" action="/act.php" >
      <input type="hidden" name="act" value="search">
      <div class="f1"><a href="/"><img class="c1" src="<!--{fn_url href='/image/mobile/back-icon.png'}-->" alt="" /></a></div>

        <input type="text" name="wd" value="<!--{$_GET['wd']}-->" placeholder="请输入关键词">


      <div class="f2"><a href=""><img class="c2" src="<!--{fn_url href='/image/mobile/fdj-icon.png'}-->" alt="" /></a></div>
    </form>

  </div>

  <ul class="flex main" id="main">
        <!--{foreach $results['data'] as $key=>$v}-->
    <li class="flex<!--{if $key==0}--> margin<!--{/if}-->" id="m">

      <a href="<!--{if $v['tid'] =='5667'}--><!--{fn_url href='/act.php?act=picture&aid='.$v['id']}--><!--{else}--><!--{fn_url href='/act.php?act=article&aid='.$v['id']}--><!--{/if}-->" class="flex">
        <div class="tit"><!--{$v['tit']}--></div>
        <div class="flex notes">
          <div class="mm">
            <img src="<!--{fn_url href=$v['image']}-->" alt="" />
          </div>

          <p>
            <!--{$v['note']}-->
          </p>
        </div>
        <div class="flex foot">
          <p>m.qiaoxiao.com<!--{if $v['tid'] =='5667'}--><!--{fn_url href=$website['url']['mobile'].'/act.php?act=picture&aid='.$v['id']}--><!--{else}--><!--{fn_url href=$website['url']['mobile'].'/act.php?act=article&aid='.$v['id']}--><!--{/if}--></p><!--{date:('Y-m-d',$v['createtime'])}-->
        </div>
      </a>
    </li>
<!--{/foreach}-->
  </ul>
  <div class="flex page">
    <a href="<!--{fn_url href='/act.php?act=search&wd='.$_GET['wd'].'&p='.$results['upPage']}-->"><img class="up"  src="<!--{fn_url href='/image/mobile/23.png'}-->" alt="" /></a>

    <select class="turn" name="<!--{$i}-->" onchange="self.location.href=options[selectedIndex].value">
      <!--{for($i=1;$i<=$results['maxPage'];$i++)}-->
      <option value="<!--{fn_url href='/act.php?act=search&wd='.$_GET['wd'].'&p='.$i }-->" <!--{if $results['nowPage'] == $i}-->selected="selected"<!--{/if}-->>
        第<!--{$i}-->页</option>
      <!--{/for}-->
      </a>
    </select>
    <p><!--{$results['nowPage']}-->/<!--{$results['maxPage']}--><span></span></p>
    <a href="<!--{fn_url href='/act.php?act=search&wd='.$_GET['wd'].'&p='.$results['downPage']}-->"><img class="up"  src="<!--{fn_url href='/image/mobile/24.png'}-->" alt="" /></a>
  </div>
</div>
<!--{include file='mobile/js.tpl'}-->

</body>
</html>
