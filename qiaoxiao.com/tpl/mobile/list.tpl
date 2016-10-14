<!--{include file="./mobile/header.tpl"}-->
<!--{include file="./mobile/nav.tpl"}-->
<!--{include file="./mobile/slide.tpl"}-->
<div class="flex m-articles">
  <div class="flex today">
    <div class="middle"><p><!--{$tp['tit']}--></p></div>
  </div>
  <div class="flex t-list">
      <!--{foreach $art['data'] as $v}-->
    <a class="flex" href="<!--{fn_url href='/act.php?act=article&aid='.$v['id']}-->">

      <div class=" left">
        <img src="<!--{fn_url href=$v['image']}-->" alt="" />
      </div>
      <div class="flex right">
        <p><!--{$v['tit']}--></p>
        <ul class="flex foot">
          <li class="first"><!--{date:('Y-m-d',$v['createtime'])}--></li>
          <li class="last"><img src="<!--{fn_url href='/image/mobile/5.png'}-->" /><!--{$v['click']}--></li>
        </ul>
      </div>
    </a>
    <!--{/foreach}-->




    <div class="t-more">
      <a href="<!--{fn_url href='/act.php?act=list&tid='.$tid.'&p='.$art['downPage']}-->">换一换</a>
    </div>
  </div>
  <!--{if 0}-->
  <div class="dd">

  </div>
  <div class="flex advert">
    <ul class="flex left">
      <a href="#" class="flex left1">
        <li class="l1"><img src="<!--{fn_url href='/image/mobile/6.png'}-->" alt="" /></li>
        <li class="l2">这是广告位推送消息</li>
      </a>

    </ul>
    <div class="right"></div>
  </div>
  <!--{/if}-->
</div>
<!--{include file="./mobile/footer.tpl"}-->
