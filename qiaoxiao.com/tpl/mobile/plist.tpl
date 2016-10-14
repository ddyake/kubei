<!--{include file="./mobile/header.tpl"}-->
<!--{include file="./mobile/nav.tpl"}-->
<!--{include file="./mobile/slide.tpl"}-->
<div class="flex m-picture">
  <div class="flex today">
    <div class="middle"><p><!--{$type['tit']}--></p></div>
  </div>
  <!--{for($i=0;$i<count($art['data']);$i+=2)}-->
  <div class="flex plist">
    <div>
      <a href="<!--{if ($art['data'][0]['tid']==5673)}--><!--{fn_url href='/act.php?act=article&aid='.$art['data'][$i]['id']}--><!--{else}--><!--{fn_url href='/act.php?act=picture&aid='.$art['data'][$i]['id']}--><!--{/if}-->">
        <img src="<!--{fn_url href=$art['data'][$i]['image']}-->" alt="<!--{$art['data'][$i]['tit']}-->" />
        <span><!--{$art['data'][$i]['tit']}--></span>
      </a>
    </div>
    <div>
      <a href="<!--{if ($art['data'][0]['tid']==5673)}--><!--{fn_url href='/act.php?act=article&aid='.$art['data'][$i+1]['id']}--><!--{else}--><!--{fn_url href='/act.php?act=picture&aid='.$art['data'][$i+1]['id']}--><!--{/if}-->">
        <img src="<!--{fn_url href=$art['data'][$i+1]['image']}-->" alt="<!--{$art['data'][$i+1]['tit']}-->" />
        <span><!--{$art['data'][$i+1]['tit']}--></span>
      </a>
    </div>
  </div>
  <!--{/for}-->

  <div class="more">
    <a href="<!--{fn_url href='/act.php?act=plist&p='.$art['downPage'].'&tid='.$art['data'][0]['tid']}-->">换一换</a>
  </div>
  <div class="dd">

  </div>

</div>
<!--{include file="./mobile/footer.tpl"}-->
