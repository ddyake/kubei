<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/9874f5f8af60e81ceb130e1f9803301d-header.tpl.php') ?>
<div class="m-picture">
  <div class="bigleft">
    <h3><?php echo $article['tit']; ?></h3>
    <div class="picjs">
      <div class="time">
        <div class="image"></div>
        <p><?php echo date('Y年m月d日',$article['createtime']); ?></p>
      </div>
      <div class="shar">
        <div></div>
        <a href="#">分享</p>
      </div>
    </div>
    <div class="photo">
      <a href="<?php echo fn_url(array('href'=>'/act.php?act=picture&aid='.$aid.'&p='.$pic['upPage'])); ?>">
        <div class="left"></div>
      </a>
      <div class="view">
        <a href="<?php echo fn_url(array('href'=>'/act.php?act=picture&aid='.$aid.'&p='.$pic['downPage'])); ?>"><img src="<?php echo $pic['data']['0']['img']; ?>"/></a>
      </div>
      <a href="<?php echo fn_url(array('href'=>'/act.php?act=picture&aid='.$aid.'&p='.$pic['downPage'])); ?>">
        <div class="right"></div>
      </a>
    </div>
    <div class="page">
      <div class="pages">
        <em><?php echo $pic['nowPage']; ?></em>
        <i>/</i>
        <em class="mother"><?php echo $pic['maxPage']; ?></em>
      </div>
      <div class="tit">
        <?php echo $article['tit']; ?>
      </div>
    </div>
    <ul class="bottom">
      <?php if((empty($upPicture))){ ?>
        <li>上一组:<a href="#">╮(╯_╰)╭再看看其他的吧</a></li>
      <?php }else{ ?>
      <li>上一组:<a href="<?php echo fn_url(array('href'=>'/act.php?act=picture&aid='.$upPicture['id'])); ?>"><?php echo $upPicture['tit']; ?></a></li>
      <?php } ?>
      <?php if((empty($downPicture))){ ?>
      <li class="up">下一组:<a href="#">╮(╯_╰)╭再看看其他的吧</a></li>
      <?php }else{ ?>
      <li class="up">下一组:<a href="<?php echo fn_url(array('href'=>'/act.php?act=picture&aid='.$downPicture['id'])); ?>"><?php echo $downPicture['tit']; ?></a></li>
      <?php } ?>
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
    <?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/302c547c7c34f495eda5479797601f90-right.tpl.php') ?>
    <div class="br"></div>
  </div>
  <div class="br"></div>
</div>
<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/2d83b6430a17920690c40ef4a2b67c59-footer.tpl.php') ?>
