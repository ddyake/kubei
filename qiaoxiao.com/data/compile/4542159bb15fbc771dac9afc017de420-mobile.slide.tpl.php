<div class="m-slide swiper-container">
    <div class="swiper-wrapper">
      <?php if (isset($slider) && is_array($slider)){foreach($slider as $v){ ?>
        <div class="swiper-slide">
          <a title="<?php echo $v['tit']; ?>" href="<?php echo fn_url(array('href'=>$v['href'])); ?>">
            <img src="<?php echo fn_url(array('href'=>$v['image'])); ?>" alt="<?php echo $v['tit']; ?>">
          </a>
        </div>
      <?php }} ?>
    </div>
  <div class="swiper-pagination"></div>
  <div class="swiper-tit">
    <p></p>
  </div>
</div>
