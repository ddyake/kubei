<!--{include file="header.tpl"}-->
<!--{include file="searchs.tpl"}-->
<!--{include file="nav.tpl"}-->


<div class="m-alert">

    <div>
      <p>
        <img src="<!--{fn_url href='/image/alert.jpg'}-->" />
        <!--{$alert['alert']}-->
      </p>

      <!--{if isset($alert['url'])}-->
      <span class="jump" second="<!--{$alert['second']}-->" url="<!--{$alert['url']}-->"><!--{$alert['second']}--></span>秒后<a href="<!--{$alert['url']}-->">跳转...</a>
      <!--{else}-->
        <span class="back" second="<!--{$alert['second']}-->"><!--{$alert['second']}--></span>秒后<a href="javascript:;">返回</a>
      <!--{/if}-->

    </div>

</div>

<!--{include file="footer.tpl"}-->
