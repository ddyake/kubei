<!--{include file="./mobile/header.tpl"}-->
<!--{include file="./mobile/nav.tpl"}-->
<!--{include file="./mobile/slide.tpl"}-->
<div class="flex m-index">
  <div class="line"></div>
  <div class="flex today">
    <p><span class="yule"></span>今日头条</p>
  </div>
  <div class="flex t-list">
<!--{foreach $article as $key=>$v}-->
    <a href="<!--{fn_url href=$v['href']}-->" class="flex lists<!--{if $key>2}--> none<!--{/if}-->">
      <div class="flex top">
        <img src="<!--{fn_url href=$v['image']}-->" alt="<!--{$v['tit']}-->" />
        <div class="flex pp">
            <p><!--{$v['tit']}--></p>
            <p class="p2"><!--{fn_substr str=$v['cont'] len=30}--></p>
        </div>

      </div>
      <ul class="flex foot<!--{if $key==2}--> noborder<!--{/if}-->">

        <li class="middle"><!--{date:('Y-m-d')}--></li>
        <li class="last"><img src="<!--{fn_url href='/image/mobile/5.png'}-->" /><!--{$v['click']}--></li>
      </ul>
    </a>
<!--{/foreach}-->
  </div>
  <a href="javascript:;" class="flex radius-9 t-more">
    <span class="flex">
      查看更多
      <img src="<!--{fn_url href='/image/mobile/25.png'}-->"  />
    </span>

  </a>
  <div class="line"></div>


  <div class="flex today1">
    <p><span class="dongtai"></span>明星动态</p>
  </div>

  <div class="flex t-list1">
    <!--{foreach $start as $key=>$vo}-->
    <a href="<!--{fn_url href='/act.php?act=article&aid='.$vo['id']}-->" class=" lists1">
      <div class="flex top1">
        <img src="<!--{fn_url href=$vo['image']}-->" />
        <div><!--{$vo['tit']}--></div>
      </div>
      <ul class="flex foot1<!--{if $key==2}--> noborder<!--{/if}-->">

        <li><!--{date:('Y-m-d',$vo['createtime'])}--></li>
        <li class="last1"><img src="<!--{fn_url href='/image/mobile/5.png'}-->" /><!--{$vo['click']}--></li>
      </ul>
    </a>
    <!--{/foreach}-->
  </div>
  <a href="<!--{fn_url href='/act.php?act=list&tid=5663'}-->"class="flex radius-9 t-more1">
    <span class="flex">
      查看更多
      <img src="<!--{fn_url href='/image/mobile/25.png'}-->" alt="" />
    </span>

  </a>
  <div class="line"></div>

  <div class="flex today1">
    <p><span class="yingxun"></span>影视资讯</p>
  </div>

  <div class="flex t-list1">
    <!--{foreach $tv as $key=>$vo}-->
    <a href="<!--{fn_url href='/act.php?act=article&aid='.$vo['id']}-->" class="flex lists1">
      <div class="flex top1">
        <img src="<!--{fn_url href=$vo['image']}-->" />
        <div><!--{$vo['tit']}--></div>
      </div>
      <ul class="flex foot1<!--{if $key==2}--> noborder<!--{/if}-->">

        <li><!--{date:('Y-m-d',$vo['createtime'])}--></li>
        <li class="last1"><img src="<!--{fn_url href='/image/mobile/5.png'}-->" /><!--{$vo['click']}--></li>
      </ul>
    </a>
    <!--{/foreach}-->


  </div>
  <a href="<!--{fn_url href='/act.php?act=list&tid=5664'}-->" class="flex radius-9 t-more1">
    <span class="flex">
      查看更多
      <img src="<!--{fn_url href='/image/mobile/25.png'}-->" alt="" />
    </span>

  </a>
  <div class="line"></div>

  <div class="flex today1">
    <p><span class="xishuo"></span>综艺资讯</p>
  </div>

  <div class="flex t-list1">
    <!--{foreach $fn as $key=>$vo}-->
    <a href="<!--{fn_url href='/act.php?act=article&aid='.$vo['id']}-->" class="flex lists1">
      <div class="flex top1">
        <img src="<!--{fn_url href=$vo['image']}-->" width="100px" height="64px" />
        <div><!--{$vo['tit']}--></div>
      </div>
      <ul class="flex foot1<!--{if $key==2}--> noborder<!--{/if}-->">

        <li><!--{date:('Y-m-d',$vo['createtime'])}--></li>
        <li class="last1"><img src="<!--{fn_url href='/image/mobile/5.png'}-->" /><!--{$vo['click']}--></li>
      </ul>
    </a>
    <!--{/foreach}-->


  </div>
  <a href="<!--{fn_url href='/act.php?act=list&tid=5665'}-->" class="flex radius-9 t-more1">
    <span class="flex">
      查看更多
      <img src="<!--{fn_url href='/image/mobile/25.png'}-->" alt="" />
    </span>

  </a>
  <div class="line"></div>

  <div class="flex today1">
    <p><span class="yule"></span>趣说八卦</p>
  </div>

  <div class="flex t-list1">
    <!--{foreach $eight as $key=>$vo}-->
    <a href="<!--{fn_url href='/act.php?act=article&aid='.$vo['id']}-->" class="flex lists1">
      <div class="flex top1">
        <img src="<!--{fn_url href=$vo['image']}-->"  />
        <div><!--{$vo['tit']}--></div>
      </div>
      <ul class="flex foot1<!--{if $key==2}--> noborder<!--{/if}-->">

        <li><!--{date:('Y-m-d',$vo['createtime'])}--></li>
        <li class="last1"><img src="<!--{fn_url href='/image/mobile/5.png'}-->" /><!--{$vo['click']}--></li>
      </ul>
    </a>
    <!--{/foreach}-->


  </div>
  <a href="<!--{fn_url href='/act.php?act=list&tid=5666'}-->" class="flex radius-9 t-more1">
    <span class="flex">
      查看更多
      <img src="<!--{fn_url href='/image/mobile/25.png'}-->" alt="更多" />
    </span>
</a>
  </div>
</div>
<!--{include file="./mobile/footer.tpl"}-->
