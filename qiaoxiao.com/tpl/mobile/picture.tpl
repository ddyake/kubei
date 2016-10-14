<!--{include file="./mobile/header-nav.tpl"}-->
<div class="m-bg opacity-5"></div>
<div class="m-advert">
  <div class="plist">
    <ul class="flex p1">
        <li class="flex">
          <a href="<!--{fn_url href='/act.php?act=article&aid='.$array['id']}-->">
          <img src="<!--{fn_url href=$array['image']}-->" alt="" />
          <span ><!--{fn_substr str=$array['tit'] len=18}--></span>
          </a>
        </li>
        <li class="flex">
            <a href="<!--{$ggao['href']}-->">
            <img src="<!--{fn_url href=$ggao['0']['image']}-->" alt="" />
            <span><!--{fn_substr str=$ggao['0']['tit'] len=18}--></span>
            </a>
        </li>
    </ul>
    <ul class="flex p1">
      <li class="flex">
          <a  href="<!--{$ggao['href']}-->">
          <img src="<!--{fn_url href=$ggao['1']['image']}-->" alt="" />
          <span ><!--{fn_substr str=$ggao['1']['tit'] len=18}--></span>
        </a>
      </li>
      <li class="flex">
          <a href="<!--{fn_url href='/act.php?act=picture&aid='.$arrays['id']}-->">
          <img src="<!--{fn_url href=$arrays['image']}-->" alt="" />
          <span><!--{fn_substr str=$arrays['tit'] len=18}--></span>
        </a>
      </li>
    </ul>
  </div>
</div>
<div class="flex m-pictures">
  <div class="flex title">
    <div class="top"><!--{$article['tit']}--></div>
    <div class="flex bottom">
      <ul class="flex left">
        <li>巧笑星闻</li>
        <li><!--{date:('Y-m-d',$article['createtime'])}--></li>
      </ul>
      <ul class="flex right">
        <li class="flex pp"><img src="<!--{fn_url href='/image/mobile/30.png'}-->" alt="" />&nbsp;<span><!--{$article['click']}--></span></li>
      </ul>
    </div>
  </div>
  <div class="ps">
    <a href="<!--{fn_url href='/act.php?act=picture'.$gifpicture.'&p='.$pic['downPage'].'&aid='.$pic['data'][0]['aid']}-->"><img  jump="<!--{if $pic['nowPage'] == $pic['maxPage']}-->1<!--{else}-->0<!--{/if}-->" src="<!--{fn_url href=$pic['data'][0]['img']}-->" alt="" /></a>

  </div>
  <div class="flex other">
    <a class="big" href="<!--{fn_url href=$pic['data'][0]['img']}-->"><span>原图</span></a>
    <div class="word">
      <i><!--{$pic['nowPage']}--></i>/<i class="mother"><!--{$pic['maxPage']}--></i>
    </div>
  </div>
  <div class="pic-text"><!--{$article['tit']}--></div>
    <!--{if $article['pg'] !=1}-->
  <div class="flex page">
    <a href="<!--{fn_url href='/act.php?act=picture'.$gifpicture.'&aid='.$pic['data'][0]['aid'].'&p='.$pic['upPage']}-->"><img class="up"  src="<!--{fn_url href='/image/mobile/23.png'}-->" alt="" /></a>
    <select class="turn" name="<!--{$i}-->" onchange="self.location.href=options[selectedIndex].value">
      <!--{for($i=1;$i<=$article['pg'];$i++)}-->
      <option value="<!--{fn_url href='/act.php?act=picture'.$gifpicture.'&aid='.$pic['data'][0]['aid'].'&p='.$i }-->" <!--{if $pic['nowPage'] == $i}-->selected="selected"<!--{/if}-->>
        第<!--{$i}-->页</option>
      <!--{/for}-->
      </a>
    </select>
    <p><!--{$pic['nowPage']}-->/<!--{$article['pg']}--><span></span></p>
    <a href="<!--{if $pic['nowPage']==$article['pg']}-->javascript:;<!--{else}--><!--{fn_url href='/act.php?act=picture'.$gifpicture.'&aid='.$pic['data'][0]['aid'].'&p='.$pic['downPage']}--><!--{/if}-->"><img jump="<!--{if $pic['nowPage'] == $pic['maxPage']}-->1<!--{else}-->0<!--{/if}-->" class="up"  src="<!--{fn_url href='/image/mobile/24.png'}-->" alt="" /></a>
  </div>
  <!--{/if}-->

  <ul class="flex sxpage">
    <!--{if (empty($upPicture))}-->
    <li>
      <a href="" class="s1"> < 上一组</a>
      <a href="" class="s2">╮(╯_╰)╭再看看其他的吧</a>
    </li>
    <!--{else}-->
    <li>
      <a href="<!--{fn_url href='/act.php?act=picture&aid='.$upPicture['id']}-->" class="s1"> &lt; 上一组</a>
      <a href="<!--{fn_url href='/act.php?act=picture&aid='.$upPicture['id']}-->" class="s2"><!--{$upPicture['tit']}--></a>
    </li>
    <!--{/if}-->
    <!--{if (empty($downPicture))}-->
    <li class="sx1">
      <a href="" class="s2">╮(╯_╰)╭再看看其他的吧</a>
      <a href="" class="s1">下一组 > </a>
    </li>
    <!--{else}-->
    <li class="sx1">
      <a href="<!--{fn_url href='/act.php?act=picture&aid='.$downPicture['id']}-->" class="s2"><!--{$downPicture['tit']}--></a>
      <a href="<!--{fn_url href='/act.php?act=picture&aid='.$downPicture['id']}-->" class="s1">下一组 &gt; </a>
      <!--{/if}-->
    </li>
  </ul>
  <div class="tt"></div>
  <div class="flex refer">
      <div class="tit">
        <div class="pp1">
          推荐图片
        </div>
      </div>
      <div class="flex picture">
        <div id="imgs" class="flex up">
            <!--{foreach $look as $key=>$vo}-->
          <a class="flex" href="<!--{fn_url href='/act.php?act=article&aid='.$vo['id']}-->">
            <ul class="flex p1">
              <li  class="img"><img src="<!--{fn_url href=$vo['image']}-->" alt="" /></li>
              <li class="text"><!--{$vo['tit']}--></li>
            </ul>
          </a>
          <!--{/foreach}-->
        </div>
      </div>
      <div  class="flex">
        <div id="img" class="flex down">
            <!--{foreach $looks as $key=>$vo}-->
          <a class="flex" href="<!--{fn_url href='/act.php?act=article&aid='.$vo['id']}-->">
            <ul class="flex p2">
              <li  class="img"><img src="<!--{fn_url href=$vo['image']}-->" alt="" /></li>
              <li class="text"><!--{$vo['tit']}--></li>
            </ul>
          </a>
            <!--{/foreach}-->
        </div>
      </div>
  </div>
  <div class="tt"></div>
  <div  class="flex refer">
      <div class="tit">
        <div class="pp1">
          相关图片
        </div>
      </div>
      <div class="flex">
        <div  id="m-img" class="flex up">
          <!--{foreach $about as $key=>$v}-->
          <a class="flex" href="<!--{fn_url href='/act.php?act=picture&aid='.$v['id']}-->">

            <ul class="flex p1">
              <li class="imgs"><img src="<!--{fn_url href=$v['image']}-->" alt="" /></li>
              <li class="text"><!--{$v['tit']}--></li>
            </ul>
          </a>
          <!--{/foreach}-->


        </div>
      </div>
      <div  class="flex">
        <div class="flex down">
          <!--{foreach $abouts as $key=>$v}-->
          <a class="flex" href="<!--{fn_url href='/act.php?act=picture&aid='.$v['id']}-->">
            <ul class="flex p2">
              <li class="img"><img src="<!--{fn_url href=$v['image']}-->" alt="" /></li>
              <li class="text"><!--{$v['tit']}--></li>
            </ul>
          </a>
          <!--{/foreach}-->


        </div>

      </div>
      <div class="flex m-top-index">
        <a class="top " title="回到首页" href="<!--{fn_url href='/act.php?act=index'}-->"></a>
        <a class="index " title="回到顶部" href="javascript:;"></a>
      </div>
  </div>

</div>

<!--{include file="./mobile/footer.tpl"}-->
