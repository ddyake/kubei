<!--{include file="./mobile/header-nav.tpl"}-->
<div  class="m-bg opacity-5"></div>
<div  class="m-advert">
  <div class="plist">
    <ul class="flex p1">
        <li class="flex">
          <a href="<!--{fn_url href='/act.php?act=article&aid='.$array['id']}-->">
          <img src="<!--{fn_url href=$array['image']}-->" alt="" />
          <span ><!--{fn_substr str=$array['tit'] len=18}--></span>
          </a>
        </li>

        <li class="flex">
          <a href="<!--{$ggaos['href']}-->">
          <img src="<!--{fn_url href=$ggaos['0']['image']}-->" alt="" />
          <span><!--{fn_substr str=$ggaos['0']['tit'] len=18}--></span>
          </a>
        </li>
    </ul>
    <ul class="flex p1">
      <li class="flex">
        <a  href="<!--{$ggaos['href']}-->">
        <img src="<!--{fn_url href=$ggaos['1']['image']}-->" alt="" />
        <span ><!--{fn_substr str=$ggaos['1']['tit'] len=18}--></span>
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
    <div class="m-article">
      <div class="main">
        <div class="article"><!--{$article['tit']}--></div>
        <!--{if $detail['tits']}-->
        <div class="two"><!--{$detail['tits']}--></div>
        <!--{/if}-->
        <ul class="flex more">
          <li>时间:<!--{date:('Y-m-d',$article['createtime'])}--></li>
          <li>编辑:<!--{if $article['editor']}--><!--{$article['editor']}--><!--{else}-->吃土知八卦<!--{/if}--></li>
          <li>来源:<!--{if $article['source']}--><!--{$article['source']}--><!--{else}-->网络改编<!--{/if}--></li>
        </ul>
      </div>
      <div class="adv">
        <script type="text/javascript">var cpro_id="u2031554";(window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",hn:"0",wn:"0",imgRatio:"1.7",scale:"20.6",pat:"6",tn:"template_inlay_all_mobile_lu_native",rss1:"#FFFFFF",adp:"1",ptt:"0",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#000000",titSU:"0",ptbg:"70",ptp:"0"}</script>
        <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
      </div>
      <div class="word"><!--{$article['note']}--></div>

      <div class="mains">
        <div class="words"><!--{$detail['article']}--></div>
        <div class="flex m-top-index">
          <a class="top " title="回到首页" href="<!--{fn_url href='/act.php?act=index'}-->"></a>
          <a class="index " title="回到顶部" href="javascript:;"></a>
        </div>
      <!--{if $article['pg'] !=1}-->
        <div class="flex page">
          <a href="<!--{fn_url href='/act.php?act=article&aid='.$aid.'&p='.$up}-->"><img class="up"  src="<!--{fn_url href='/image/mobile/23.png'}-->" alt="" /></a>
          <select class="turn" name="<!--{$i}-->" onchange="self.location.href=options[selectedIndex].value">
            <!--{for($i=1;$i<=$article['pg'];$i++)}-->
            <option value="<!--{fn_url href='/act.php?act=article&aid='.$aid.'&p='.$i }-->" <!--{if $page == $i}-->selected="selected"<!--{/if}-->>
              第<!--{$i}-->页</option>
            <!--{/for}-->
            </a>
          </select>
          <p><!--{$page}-->/<!--{$article['pg']}--><span></span></p>
          <a href="<!--{if $page==$article['pg']}-->javascript:;<!--{else}--><!--{fn_url href='/act.php?act=article&aid='.$aid.'&p='.$down}--><!--{/if}-->"><img jump="<!--{if $article['pg'] == $page}-->1<!--{else}-->0<!--{/if}-->" class="up"  src="<!--{fn_url href='/image/mobile/24.png'}-->" alt="" /></a>
        </div>
      <!--{/if}-->
        <div class="adv">
          <script type="text/javascript">var cpro_id="u2031554";(window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",hn:"0",wn:"0",imgRatio:"1.7",scale:"20.6",pat:"6",tn:"template_inlay_all_mobile_lu_native",rss1:"#FFFFFF",adp:"1",ptt:"0",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#000000",titSU:"0",ptbg:"70",ptp:"0"}</script>
          <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
        </div>
      </div>

      <!--{if $pages[1]['tits']}-->
      <ul class="flex p-note">
        <!--{foreach $pages as $v}-->
        <!--{if $v['tits']}-->
        <li>第<!--{$v['page']}-->页：<a href="<!--{fn_url href='/act.php?act=article&aid='.$aid.'&p='.$v['page'] }-->"><!--{$v['tits']}--></a></li>
        <!--{/if}-->
        <!--{/foreach}-->
      </ul>
      <!--{/if}-->
      <div class="adv-1">
        <script>
            document.write('<ins style="display:none!important" id="tt-un-14761713535000308"></ins>');
            __tt_s = document.createElement('script');
            __tt_s.src = 'http://partner.toutiao.com/union/ask/1/?cid=14761713535000308';
            document.head.appendChild(__tt_s);
        </script>
      </div>


      <div class="mk">
        <b class="love">
          相关阅读
        </b>
        <!--{foreach $related as $v}-->
        <a href="<!--{if isset($v['id'])}--><!--{fn_url href='/act.php?act=article&aid='.$v['id']}--><!--{else}--><!--{$v['href']}--><!--{/if}-->">
          <img src="<!--{fn_url href=$v['image']}-->" alt="<!--{$v['tit']}-->" />
          <div><p><!--{$v['tit']}--></p></div>
        </a>
          <!--{/foreach}-->
      </div>
      <b class="love">
        猜你感兴趣
      </b>

      <div>
          <script type="text/javascript">
          var cpro_id="u2031554";
          (window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",hn:"3",wn:"2",imgRatio:"1.7",scale:"20.20",pat:"6",tn:"template_inlay_all_mobile_lu_native",rss1:"#FFFFFF",adp:"1",ptt:"0",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#FFFFFF",titSU:"0",ptbg:"70",ptp:"1"}
          </script>
          <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
        </div>
    </div>


<!--{include file="./mobile/footer.tpl"}-->
