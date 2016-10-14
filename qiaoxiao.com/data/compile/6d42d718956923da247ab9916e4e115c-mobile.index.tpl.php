<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/49845257f81de2445c59e6969d3fc000-mobile.header.tpl.php') ?>
<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/2f2025dc3ed238ae4c5382527d489dbc-mobile.nav.tpl.php') ?>
<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/4542159bb15fbc771dac9afc017de420-mobile.slide.tpl.php') ?>
<div class="flex m-index">
  <div class="line"></div>
  <div class="flex today">
    <p><span class="yule"></span>今日头条</p>
  </div>
  <div class="flex t-list">
<?php if (isset($article) && is_array($article)){foreach($article as $key=>$v){ ?>
    <a href="<?php echo $v['href']; ?>" class="flex lists<?php if($key>2){ ?> none<?php } ?>">
      <div class="flex top">
        <img src="<?php echo fn_url(array('href'=>$v['image'])); ?>" alt="<?php echo $v['tit']; ?>" />
        <div class="flex pp">
            <p><?php echo $v['tit']; ?></p>
            <p class="p2"><?php echo fn_substr(array('str'=>$v['cont'],'len'=>30)); ?></p>
        </div>

      </div>
      <ul class="flex foot<?php if($key==2){ ?> noborder<?php } ?>">

        <li class="middle"><?php echo date('Y-m-d'); ?></li>
        <li class="last"><img src="<?php echo fn_url(array('href'=>'/image/mobile/5.png')); ?>" /><?php echo $v['click']; ?></li>
      </ul>
    </a>
<?php }} ?>
  </div>
  <a href="javascript:;" class="flex radius-9 t-more">
    <span class="flex">
      查看更多
      <img src="<?php echo fn_url(array('href'=>'/image/mobile/25.png')); ?>" alt="" />
    </span>

  </a>
  <div class="line"></div>
  <?php if(0){ ?>
  <div class="line"></div>
  <div class="flex advert">
    <ul class="flex left">
      <a href="#" class="flex left1">
        <li class="l1"><img src="<?php echo fn_url(array('href'=>'/image/mobile/6.png')); ?>" alt="" /></li>
        <li class="l2">这是广告位推送消息</li>
      </a>

    </ul>
    <div class="right"></div>
  </div>
  <?php } ?>

  <div class="flex today1">
    <p><span class="dongtai"></span>明星动态</p>
  </div>

  <div class="flex t-list1">
    <?php if (isset($start) && is_array($start)){foreach($start as $key=>$vo){ ?>
    <a href="<?php echo fn_url(array('href'=>'/act.php?act=article&tid='.$vo['tid'].'&aid='.$vo['id'])); ?>" class="flex lists1">
      <div class="flex top1">
        <img src="<?php echo fn_url(array('href'=>$vo['image'])); ?>" alt="" />
        <p><?php echo $vo['tit']; ?></p>
      </div>
      <ul class="flex foot1<?php if($key==2){ ?> noborder<?php } ?>">

        <li><?php echo date('Y-m-d',$vo['createtime']); ?></li>
        <li class="last1"><img src="<?php echo fn_url(array('href'=>'/image/mobile/5.png')); ?>" /><?php echo $vo['click']; ?></li>
      </ul>
    </a>
    <?php }} ?>
  </div>
  <a href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid=5663')); ?>"class="flex radius-9 t-more1">
    <span class="flex">
      查看更多
      <img src="<?php echo fn_url(array('href'=>'/image/mobile/25.png')); ?>" alt="" />
    </span>

  </a>
  <div class="line"></div>

  <div class="flex today1">
    <p><span class="yingxun"></span>影视资讯</p>
  </div>

  <div class="flex t-list1">
    <?php if (isset($tv) && is_array($tv)){foreach($tv as $key=>$vo){ ?>
    <a href="<?php echo fn_url(array('href'=>'/act.php?act=article&tid='.$vo['tid'].'&aid='.$vo['id'])); ?>" class="flex lists1">
      <div class="flex top1">
        <img src="<?php echo fn_url(array('href'=>$vo['image'])); ?>" alt="" />
        <p><?php echo $vo['tit']; ?></p>
      </div>
      <ul class="flex foot1<?php if($key==2){ ?> noborder<?php } ?>">

        <li><?php echo date('Y-m-d',$vo['createtime']); ?></li>
        <li class="last1"><img src="<?php echo fn_url(array('href'=>'/image/mobile/5.png')); ?>" /><?php echo $vo['click']; ?></li>
      </ul>
    </a>
    <?php }} ?>


  </div>
  <a href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid=5664')); ?>" class="flex radius-9 t-more1">
    <span class="flex">
      查看更多
      <img src="<?php echo fn_url(array('href'=>'/image/mobile/25.png')); ?>" alt="" />
    </span>

  </a>
  <div class="line"></div>

  <div class="flex today1">
    <p><span class="xishuo"></span>综艺资讯</p>
  </div>

  <div class="flex t-list1">
    <?php if (isset($fn) && is_array($fn)){foreach($fn as $key=>$vo){ ?>
    <a href="<?php echo fn_url(array('href'=>'/act.php?act=article&tid='.$vo['tid'].'&aid='.$vo['id'])); ?>" class="flex lists1">
      <div class="flex top1">
        <img src="<?php echo fn_url(array('href'=>$vo['image'])); ?>" alt="" />
        <p><?php echo $vo['tit']; ?></p>
      </div>
      <ul class="flex foot1<?php if($key==2){ ?> noborder<?php } ?>">

        <li><?php echo date('Y-m-d',$vo['createtime']); ?></li>
        <li class="last1"><img src="<?php echo fn_url(array('href'=>'/image/mobile/5.png')); ?>" /><?php echo $vo['click']; ?></li>
      </ul>
    </a>
    <?php }} ?>


  </div>
  <a href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid=5665')); ?>" class="flex radius-9 t-more1">
    <span class="flex">
      查看更多
      <img src="<?php echo fn_url(array('href'=>'/image/mobile/25.png')); ?>" alt="" />
    </span>

  </a>
  <div class="line"></div>

  <div class="flex today1">
    <p><span class="yule"></span>趣说八卦</p>
  </div>

  <div class="flex t-list1">
    <?php if (isset($eight) && is_array($eight)){foreach($eight as $key=>$vo){ ?>
    <a href="<?php echo fn_url(array('href'=>'/act.php?act=article&tid='.$vo['tid'].'&aid='.$vo['id'])); ?>" class="flex lists1">
      <div class="flex top1">
        <img src="<?php echo fn_url(array('href'=>$vo['image'])); ?>" alt="" />
        <p><?php echo $vo['tit']; ?></p>
      </div>
      <ul class="flex foot1<?php if($key==2){ ?> noborder<?php } ?>">

        <li><?php echo date('Y-m-d',$vo['createtime']); ?></li>
        <li class="last1"><img src="<?php echo fn_url(array('href'=>'/image/mobile/5.png')); ?>" /><?php echo $vo['click']; ?></li>
      </ul>
    </a>
    <?php }} ?>


  </div>
  <a href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid=5666')); ?>" class="flex radius-9 t-more1">
    <span class="flex">
      查看更多
      <img src="<?php echo fn_url(array('href'=>'/image/mobile/25.png')); ?>" alt="更多" />
    </span>
</a>
  </div>
</div>
<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/8b7c20e2b3a6d39239af41b65874f412-mobile.footer.tpl.php') ?>
