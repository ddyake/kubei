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
  <div class="search">
    <div class="header">
      <div class="logo">
        <a href="#"><img src="<!--{fn_url href='/image/ico.png'}-->" alt="" /></a>
      </div>
      <form class="sear" action="/act.php" >
          <input type="hidden" name="act" value="search">
          <input type="text" name="wd" value="<!--{$_GET['wd']}-->" placeholder="请输入关键词">
          <div class="ss">
            <div class="searchs">
              <a href="#">搜本站</a>
            </div>
            <div class="searchall">
              <a href="#">搜全网</a>
            </div>
          </div>
      </form>
    </div>
    <div class="result">为您找到相关结果<!--{$mount}-->个</div>
    <div class="result-list">
      <!--{foreach $results['data'] as $key=>$v}-->
      <a href="<!--{if $v['tid'] =='5667'}--><!--{fn_url href='/act.php?act=picture&aid='.$v['id']}--><!--{else}--><!--{fn_url href='/act.php?act=article&aid='.$v['id']}--><!--{/if}-->">
        <div class="list1">
          <h3  class="tit">
            <!--{$v['tit']}-->_巧笑星闻
          </h3>
          <div class="count">
            <div class="image">
              <img src="<!--{fn_url href=$v['image']}-->" alt="" />
            </div>
            <div class="right">
              <div  class="article">
                <!--{$v['note']}-->
              </div>
              <div class="address">
                <!--{if $v['tid'] =='5667'}-->  www.qiaoxiao.com<!--{fn_url href=$website['url']['mobile'].'/act.php?act=picture&aid='.$v['id']}--><!--{else}-->
                www.qiaoxiao.com<!--{fn_url href=$website['url']['mobile'].'/act.php?act=article&aid='.$v['id']}--><!--{/if}--> <!--{date:('Y-m-d',$v['createtime'])}-->
              </div>
            </div>
          </div>
        </div>
      </a>
      <!--{/foreach}-->
    </div>


    <ul  class="page">
      <!--{if $results['nowPage'] !=1}-->
      <li><a href="<!--{fn_url href='/act.php?act=search&wd='.$_GET['wd'].'&p='.$results['upPage']}-->">&lt;上一页</a></li>
      <!--{/if}-->
        <!--{for($i=1;$i<=$results['maxPage'];$i++)}-->
      <li class="pages"><a href="<!--{fn_url href='/act.php?act=search&wd='.$_GET['wd'].'&p='.$i }-->"<!--{if $results['nowPage'] == $i}-->ngb<!--{/if}-->><!--{$i}--></a></li>
      <!--{/for}-->
      <!--{if $results['maxPage'] != $results['nowPage']}-->
      <li><a href="<!--{fn_url href='/act.php?act=search&wd='.$_GET['wd'].'&p='.$results['downPage']}-->">下一页&gt;</a></li>
      <!--{/if}-->
    </ul>

  </div>
  <!--{include file='js.tpl'}-->
</body>
</html>
