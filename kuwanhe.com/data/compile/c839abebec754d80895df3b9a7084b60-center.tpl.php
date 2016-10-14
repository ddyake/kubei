<?php include_once('/Volumes/DATA/workspace/www/kubei/kuwanhe.com/data/compile/c7aa220d8192e8ec0c2c3bf49480c28b-header.tpl.php') ?>
<?php include_once('/Volumes/DATA/workspace/www/kubei/kuwanhe.com/data/compile/a197b9ca631cc1bc1723e8570117aad5-tool.tpl.php') ?>


<div class="m-center">
  <div class="search">
    <div class="a"><label>类别搜索：</label></div>
    <div id="tag" class="b">
      <a class="all act">全部</a>
      <a>角色扮演</a>
      <a>战争策略</a>
      <a>休闲竞技</a>
      <a>模拟经营</a>
    </div>
    <div class="c"><input id="search" type="text" placeholder="搜索游戏" /></div>
  </div>
  <div class="letter">
    <div class="a"><label>字母搜索：</label></div>
    <div id="letter" class="b">
      <a class="all act">全部</a>
      <a>A</a>
      <a>B</a>
      <a>C</a>
      <a>D</a>
      <a>E</a>
      <a>F</a>
      <a>G</a>
      <a>H</a>
      <a>I</a>
      <a>J</a>
      <a>K</a>
      <a>L</a>
      <a>M</a>
      <a>N</a>
      <a>O</a>
      <a>P</a>
      <a>Q</a>
      <a>R</a>
      <a>S</a>
      <a>T</a>
      <a>U</a>
      <a>V</a>
      <a>W</a>
      <a>X</a>
      <a>Y</a>
      <a>Z</a>
    </div>
  </div>
</div>

<div class="m-block">
  <div id="game" class="games">
    <?php if (isset($games) && is_array($games)){foreach($games as $v){ ?>
    <a title="<?php echo $v['tit']; ?>" tag="<?php echo $v['tag']; ?>" href="<?php echo fn_url(array('href'=>'/act.php?act=about&gid='.$v['id'])); ?>">
      <img class="radius-5" src='<?php echo fn_url(array('href'=>'/image/bg.png')); ?>' data-original="<?php echo fn_url(array('href'=>$v['icon'])); ?>" />
      <?php echo $v['tit']; ?>
    </a>
    <?php }} ?>
    <div class="br"></div>
  </div>
</div>






<?php include_once('/Volumes/DATA/workspace/www/kubei/kuwanhe.com/data/compile/88a65bad884ed77fdc40b31d0e25272a-footer.tpl.php') ?>
