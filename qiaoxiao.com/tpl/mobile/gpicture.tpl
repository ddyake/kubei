<!--{include file="./mobile/header-nav.tpl"}-->
<div class="m-bg opacity-5"></div>
<div class="m-advert">
  <div class="plist">
    <ul class="flex p1">
      <!--{foreach $floatTop as $v}-->
        <li class="flex">
          <a href="<!--{$v['href']}-->">
          <img src="<!--{fn_url href=$v['image']}-->" alt="<!--{$v['tit']}-->" />
          <span ><!--{fn_substr str=$v['tit'] len=18}--></span>
          </a>
        </li>
      <!--{/foreach}-->
    </ul>
    <ul class="flex p1">
      <!--{foreach $floatBtm as $v}-->
        <li class="flex">
          <a href="<!--{$v['href']}-->">
          <img src="<!--{fn_url href=$v['image']}-->" alt="<!--{$v['tit']}-->" />
          <span ><!--{fn_substr str=$v['tit'] len=18}--></span>
          </a>
        </li>
      <!--{/foreach}-->
    </ul>
  </div>
</div>
<div class="flex m-pictures">
  <div class="flex title">
    <div class="top"><!--{$article['tit']}--></div>

    <div class="mk-1">
      <p><span class="radius-top-5">关闭</span></p>
      <a href="http://oqr.xgczmf.com/?sid=80053&aid=99"><img src="<!--{$floatHead['image']}-->" /></a>
    </div>

    <div class="flex bottom">
      <ul class="flex left">
        <li>巧笑星闻</li>
      </ul>
      <ul class="flex right">
        <li class="flex pp"><img src="<!--{fn_url href='/image/mobile/30.png'}-->" />&nbsp;<span><!--{$article['click']}--></span></li>
      </ul>
    </div>
  </div>
  <div class="ps">
    <a href="<!--{if $pages['now']==$article['pg']}-->#<!--{else}--><!--{fn_url href='/act.php?act=gpicture&pid='.$aid.'&p='.$pages['down']}--><!--{/if}-->">
      <img src="<!--{fn_url href=$picture['img']}-->" />
    </a>
  </div>
  <!--{if is_array($pages)}-->
  <div class="flex page">
    <a href="<!--{fn_url href='/act.php?act=gpicture&pid='.$aid.'&p='.$pages['up']}-->"><img class="up"  src="<!--{fn_url href='/image/mobile/23.png'}-->" /></a>
    <select class="turn" name="<!--{$i}-->" onchange="self.location.href=options[selectedIndex].value">
      <!--{for($i=1;$i<=$article['pg'];$i++)}-->
      <option value="<!--{fn_url href='/act.php?act=gpicture&pid='.$aid.'&p='.$i }-->" <!--{if $pages['now'] == $i}-->selected="selected"<!--{/if}-->>
        第<!--{$i}-->页</option>
      <!--{/for}-->
      </a>
    </select>
    <p><!--{$pages['now']}-->/<!--{$pages['max']}--><span></span></p>
    <a href="<!--{if $pages['now']==$article['pg']}-->#<!--{else}--><!--{fn_url href='/act.php?act=gpicture&pid='.$aid.'&p='.$pages['down']}--><!--{/if}-->">
      <img class="up"  src="<!--{fn_url href='/image/mobile/24.png'}-->" />
    </a>
  </div>
  <!--{/if}-->
  <ul class="sxpage">
    <li class="flex">
      <a href="<!--{fn_url href='/act.php?act=gpicture&pid='.$upPicture['id']}-->" class="s1"> &lt;上一组</a>
      <a href="<!--{fn_url href='/act.php?act=gpicture&pid='.$downPicture['id']}-->" class="s2">下一组 &gt; </a>
    </li>
  </ul>
  <div class="tt"></div>
  <div class="flex refer">
      <div class="tit">
        <span class="pp1">
          推荐图片
        </span>
      </div>
      <div class="flex picture">
        <div class="gpicture flex up">
            <!--{foreach $look as $v}-->
          <a class="flex" href="<!--{fn_url href='/act.php?act=gpicture&pid='.$v['id']}-->">
            <ul class="flex p1">
              <li class="img"><img src="<!--{fn_url href=$v['image']}-->" alt="<!--{$v['tit']}-->" /></li>
              <li class="text"><!--{$v['tit']}--></li>
            </ul>
          </a>
          <!--{/foreach}-->
        </div>
      </div>
      <div  class="flex">
        <div class="gpicture flex down">
            <!--{foreach $looks as $v}-->
          <a class="flex" href="<!--{fn_url href='/act.php?act=gpicture&pid='.$v['id']}-->">
            <ul class="flex p2">
              <li  class="img"><img src="<!--{fn_url href=$v['image']}-->" alt="<!--{$v['tit']}-->" /></li>
              <li class="text"><!--{$v['tit']}--></li>
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

<div class="m-footer">
  <div class="line"></div>
  <div class="banquan">
    巧笑星闻版权所有
  </div>
</div>


<div class="m-bottom gpicture-bottom">
  <div class="close"><a class="radius-top-5">关闭</a></div>
  <div class="gpicture-image">
    <a target="_blank" href="http://sp.wndoor.com:8080/DownLoad/page.jsp?data=107Q5G">
      <img src="<!--{fn_url href=$floatFoot['image']}-->">
    </a>
  </div>
</div>




<script type="text/javascript">
    var cpro_id = "u2083047";
</script>
<script src="http://cpro.baidustatic.com/cpro/ui/mi.js" type="text/javascript"></script>
<!--{include file='mobile/js.tpl'}-->
</body>
</html>
