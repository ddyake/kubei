<!--{include file='header.tpl'}-->
<div class="m-picture">
  <div class="bigleft">
    <h3><!--{$article['tit']}--></h3>
    <div class="picjs">
      <div class="time">
        <div class="image"></div>
        <p><!--{date:('Y年m月d日',$article['createtime'])}--></p>
      </div>
      <div class="shar">
        <div></div>
        <a href="#">分享</p>
      </div>
    </div>
    <div class="photo">
      <a href="<!--{fn_url href='/act.php?act=picture&aid='.$aid.'&p='.$pic['upPage']}-->">
        <div class="left"></div>
      </a>
      <div class="view">
        <a href="<!--{fn_url href='/act.php?act=picture&aid='.$aid.'&p='.$pic['downPage']}-->"><img src="<!--{$pic['data']['0']['img']}-->"/></a>
      </div>
      <a href="<!--{fn_url href='/act.php?act=picture&aid='.$aid.'&p='.$pic['downPage']}-->">
        <div class="right"></div>
      </a>
    </div>
    <div class="page">
      <div class="pages">
        <em><!--{$pic['nowPage']}--></em>
        <i>/</i>
        <em class="mother"><!--{$pic['maxPage']}--></em>
      </div>
      <div class="tit">
        <!--{$article['tit']}-->
      </div>
    </div>
    <ul class="bottom">
      <!--{if (empty($upPicture))}-->
        <li>上一组:<a href="#">╮(╯_╰)╭再看看其他的吧</a></li>
      <!--{else}-->
      <li>上一组:<a href="<!--{fn_url href='/act.php?act=picture&aid='.$upPicture['id']}-->"><!--{$upPicture['tit']}--></a></li>
      <!--{/if}-->
      <!--{if (empty($downPicture))}-->
      <li class="up">下一组:<a href="#">╮(╯_╰)╭再看看其他的吧</a></li>
      <!--{else}-->
      <li class="up">下一组:<a href="<!--{fn_url href='/act.php?act=picture&aid='.$downPicture['id']}-->"><!--{$downPicture['tit']}--></a></li>
      <!--{/if}-->
    </ul>
  </div>
  <div class="about">
    <div class="title">
      <span>相关图片</span>
      <ul class="more">
        <a href="#">
          <li class="search">查看更多图片</li>
          <li class="img"></li>
        </a>
      </ul>
    </div>
    <ul class="pictures">
        <li>
            <a href="#">
              <img src="/image/p1.jpg" />
              <span>《青云志》陆雪琪露真容</span>
          </a>
        </li>
        <li>
            <a href="#">
              <img src="/image/p1.jpg" />
              <span>《青云志》陆雪琪露真容</span>
          </a>
        </li>
        <li>
            <a href="#">
              <img src="/image/p1.jpg" />
              <span>《青云志》陆雪琪露真容</span>
          </a>
        </li>
        <li>
            <a href="#">
              <img src="/image/p1.jpg" />
              <span>《青云志》陆雪琪露真容</span>
          </a>
        </li>
        <li>
            <a href="#">
              <img src="/image/p1.jpg" />
              <span>《青云志》陆雪琪露真容</span>
          </a>
        </li>
        <li>
            <a href="#">
              <img src="/image/p1.jpg" />
              <span>《青云志》陆雪琪露真容</span>
          </a>
        </li>
        <li>
            <a href="#">
              <img src="/image/p1.jpg" />
              <span>《青云志》陆雪琪露真容</span>
          </a>
        </li>
        <li>
            <a href="#">
              <img src="/image/p1.jpg" />
              <span>《青云志》陆雪琪露真容</span>
          </a>
        </li>
        <li>
            <a href="#">
              <img src="/image/p1.jpg" />
              <span>《青云志》陆雪琪露真容</span>
          </a>
        </li>
        <li>
            <a href="#">
              <img src="/image/p1.jpg" />
              <span>《青云志》陆雪琪露真容</span>
          </a>
        </li>
        <li>
            <a href="#">
              <img src="/image/p1.jpg" />
              <span>《青云志》陆雪琪露真容</span>
          </a>
        </li>

        <li>
            <a href="#">
              <img src="/image/p1.jpg" />
              <span>《青云志》陆雪琪露真容</span>
          </a>
        </li>

    </ul>

  </div>

  <div class="bigright">
    <!--{include file='right.tpl'}-->
    <div class="br"></div>
  </div>
  <div class="br"></div>
</div>
<!--{include file='footer.tpl'}-->
