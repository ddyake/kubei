<?php include_once('/Volumes/DATA/workspace/www/kubei/kuwanhe.com/data/compile/c7aa220d8192e8ec0c2c3bf49480c28b-header.tpl.php') ?>
<?php include_once('/Volumes/DATA/workspace/www/kubei/kuwanhe.com/data/compile/a197b9ca631cc1bc1723e8570117aad5-tool.tpl.php') ?>



<div class="m-index">
  <div class="index">
    <div class="index-1">
      <div class="slide" id="slide">
        <div class="hd">
          <ul>
            <?php if (isset($topLink) && is_array($topLink)){foreach($topLink as $v){ ?>
            <li></li>
            <?php }} ?>
          </ul>
        </div>
        <div class="bd">
            <ul>
              <?php if (isset($topLink) && is_array($topLink)){foreach($topLink as $v){ ?>
              <li><a target="_blank" href="<?php echo $v['href']; ?>" title="<?php echo $v['tit']; ?>"><img alt="<?php echo $v['tit']; ?>" src="<?php echo $v['image']; ?>" /></a></li>
              <?php }} ?>
            </ul>
        </div>
      </div>
      <ul class="list">
        <li class="tit">火热游戏排行榜</li>
        <?php if (isset($rankLink) && is_array($rankLink)){foreach($rankLink as $v){ ?>
        <li><a target="_blank" href="<?php echo $v['href']; ?>" title="<?php echo $v['tit']; ?>"><?php echo $v['tit']; ?><span><?php echo $v['cont']; ?></span></a></li>
        <?php }} ?>
      </ul>
    </div>
    <div class="index-block index-2">
      <div class="tit">热门游戏</div>
      <div class="block">
        <?php if (isset($hotLink) && is_array($hotLink)){foreach($hotLink as $v){ ?>
        <a target="_blank" href="<?php echo $v['href']; ?>" title="<?php echo $v['tit']; ?>">
          <img src="<?php echo fn_url(array('href'=>$v['image'])); ?>" alt="<?php echo $v['tit']; ?>">
          <span><?php echo $v['tit']; ?></span>
        </a>
        <?php }} ?>
        <div class="br"></div>
      </div>
    </div>
    <div class="index-block index-3">
      <div class="tit">推荐游戏</div>
      <div class="block">
        <?php if (isset($tjLink) && is_array($tjLink)){foreach($tjLink as $v){ ?>
        <a target="_blank" href="<?php echo $v['href']; ?>" title="<?php echo $v['tit']; ?>">
          <img src="<?php echo fn_url(array('href'=>$v['image'])); ?>" alt="<?php echo $v['tit']; ?>">
          <span><?php echo $v['tit']; ?></span>
        </a>
        <?php }} ?>
        <div class="br"></div>
      </div>
    </div>

  </div>
  <div class="m-tj">
    <a target="_blank" href="<?php echo $rightLink['href']; ?>" title="<?php echo $rightLink['tit']; ?>">
      <img src="<?php echo fn_url(array('href'=>$rightLink['image'])); ?>" alt="<?php echo $rightLink['tit']; ?>">
    </a>
  </div>
  <div class="br"></div>
</div>














<?php include_once('/Volumes/DATA/workspace/www/kubei/kuwanhe.com/data/compile/88a65bad884ed77fdc40b31d0e25272a-footer.tpl.php') ?>
