<?php include_once('/Volumes/DATA/workspace/www/kubei/kuwanhe.com/data/compile/c7aa220d8192e8ec0c2c3bf49480c28b-header.tpl.php') ?>

<div class="m-about">
  <ul class="image">
    <li class="img"><img src="<?php echo $game['image']; ?>" alt="<?php echo $game['tit']; ?>"></li>
    <li class="txt t"><?php echo $game['tit']; ?></li>
    <li class="txt tag">
      <?php if (isset($game['tag']) && is_array($game['tag'])){foreach($game['tag'] as $v){ ?>
      <span><?php echo $v; ?></span>
      <?php }} ?>
    </li>
  </ul>
  <div class="about">简介：<?php echo $game['about']; ?></div>
  <div class="tit">游戏平台</div>
  <div class="s1"></div>
  <div class="s2"></div>
  <div class="s3"></div>
</div>
<div class="m-platform">
  <?php if (isset($platform) && is_array($platform)){foreach($platform as $v){ ?>
  <a href="<?php echo $v['url']; ?>"><?php echo $v['tit']; ?></a>
  <?php }} ?>
</div>



<?php include_once('/Volumes/DATA/workspace/www/kubei/kuwanhe.com/data/compile/88a65bad884ed77fdc40b31d0e25272a-footer.tpl.php') ?>
