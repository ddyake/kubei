<div class="m-slide swiper-container">
    <div class="swiper-wrapper">
      <!--{foreach $slider as $v}-->
        <div class="swiper-slide">
          <a title="<!--{$v['tit']}-->" href="<!--{fn_url href=$v['href']}-->">
            <img src="<!--{fn_url href=$v['image']}-->" alt="<!--{$v['tit']}-->">
          </a>
        </div>
      <!--{/foreach}-->
    </div>
  <div class="swiper-pagination"></div>
  <div class="swiper-tit">
    <p></p>
  </div>
</div>
