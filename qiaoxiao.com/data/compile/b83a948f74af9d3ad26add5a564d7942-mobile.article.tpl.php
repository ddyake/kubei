<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/b94a18991bed0858d90a84ebd96734c4-mobile.header-nav.tpl.php') ?>
<div  class="m-bg opacity-5"></div>
<div  class="m-advert">

  <div class="plist">
    <ul class="flex p1">
        <li class="flex">
          <a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$array['id'])); ?>">
          <img src="<?php echo fn_url(array('href'=>$array['image'])); ?>" alt="" />
          <span ><?php echo fn_substr(array('str'=>$array['tit'],'len'=>18)); ?></span>
          </a>
        </li>

        <li class="flex">
          <a href="<?php echo $ggaos['href']; ?>">
          <img src="<?php echo fn_url(array('href'=>$ggaos['0']['image'])); ?>" alt="" />
          <span><?php echo fn_substr(array('str'=>$ggaos['0']['tit'],'len'=>18)); ?></span>
          </a>
        </li>
    </ul>
    <ul class="flex p1">
      <li class="flex">
        <a  href="<?php echo $ggaos['href']; ?>">
        <img src="<?php echo fn_url(array('href'=>$ggaos['1']['image'])); ?>" alt="" />
        <span ><?php echo fn_substr(array('str'=>$ggaos['1']['tit'],'len'=>18)); ?></span>
        </a>
      </li>
      <li class="flex">
        <a href="<?php echo fn_url(array('href'=>'/act.php?act=picture&aid='.$arrays['id'])); ?>">
        <img src="<?php echo fn_url(array('href'=>$arrays['image'])); ?>" alt="" />
        <span><?php echo fn_substr(array('str'=>$arrays['tit'],'len'=>18)); ?></span>
        </a>
      </li>
    </ul>
  </div>
</div>
    <div class="m-article">
      <div class="main">
        <div class="article"><?php echo $article['tit']; ?></div>
        <?php if($detail['tits']){ ?>
        <div class="two"><?php echo $detail['tits']; ?></div>
        <?php } ?>
        <ul class="flex more">
          <li>时间:<?php echo date('Y-m-d',$article['createtime']); ?></li>
          <li>编辑:<?php if($article['editor']){ ?><?php echo $article['editor']; ?><?php }else{ ?>吃土知八卦<?php } ?></li>
          <li>来源:<?php if($article['source']){ ?><?php echo $article['source']; ?><?php }else{ ?>网络改编<?php } ?></li>
        </ul>
      </div>
      <div>
        <script type="text/javascript">var cpro_id="u2031554";(window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",hn:"0",wn:"0",imgRatio:"1.7",scale:"20.6",pat:"6",tn:"template_inlay_all_mobile_lu_native",rss1:"#FFFFFF",adp:"1",ptt:"0",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#000000",titSU:"0",ptbg:"70",ptp:"0"}</script>
        <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
      </div>
      <div class="word"><?php echo $article['note']; ?></div>

      <div class="mains">
        <div class="words"><?php echo $detail['article']; ?></div>
        <div class="flex m-top-index">
          <a class="top " title="回到首页" href="<?php echo fn_url(array('href'=>'/act.php?act=index')); ?>"></a>
          <a class="index " title="回到顶部" href="javascript:;"></a>
        </div>
      <?php if($article['pg'] !=1){ ?>
        <div class="flex page">
          <a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$aid.'&p='.$up)); ?>"><img class="up"  src="<?php echo fn_url(array('href'=>'/image/mobile/23.png')); ?>" alt="" /></a>
          <select class="turn" name="<?php echo $i; ?>" onchange="self.location.href=options[selectedIndex].value">
            <?php for($i=1;$i<=$article['pg'];$i++){ ?>
            <option value="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$aid.'&p='.$i)); ?>" <?php if($page == $i){ ?>selected="selected"<?php } ?>>
              第<?php echo $i; ?>页</option>
            <?php } ?>
            </a>
          </select>
          <p><?php echo $page; ?>/<?php echo $article['pg']; ?><span></span></p>
          <a href="<?php if($page==$article['pg']){ ?>javascript:;<?php }else{ ?><?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$aid.'&p='.$down)); ?><?php } ?>"><img jump="<?php if($article['pg'] == $page){ ?>1<?php }else{ ?>0<?php } ?>" class="up"  src="<?php echo fn_url(array('href'=>'/image/mobile/24.png')); ?>" alt="" /></a>
        </div>
      <?php } ?>
        <div>
          <script type="text/javascript">var cpro_id="u2031554";(window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",hn:"0",wn:"0",imgRatio:"1.7",scale:"20.6",pat:"6",tn:"template_inlay_all_mobile_lu_native",rss1:"#FFFFFF",adp:"1",ptt:"0",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#000000",titSU:"0",ptbg:"70",ptp:"0"}</script>
          <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
        </div>
      </div>

      <?php if($pages[1]['tits']){ ?>
      <ul class="flex p-note">
        <?php if (isset($pages) && is_array($pages)){foreach($pages as $v){ ?>
        <?php if($v['tits']){ ?>
        <li>第<?php echo $v['page']; ?>页：<a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$aid.'&p='.$v['page'])); ?>"><?php echo $v['tits']; ?></a></li>
        <?php } ?>
        <?php }} ?>
      </ul>
      <?php } ?>



      <div class="mk">
        <?php if (isset($related) && is_array($related)){foreach($related as $v){ ?>
        <a href="<?php if(isset($v['id'])){ ?><?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$v['id'])); ?><?php }else{ ?><?php echo $v['href']; ?><?php } ?>">
          <img src="<?php echo fn_url(array('href'=>$v['image'])); ?>" alt="<?php echo $v['tit']; ?>" />
          <div><p><?php echo $v['tit']; ?></p></div>
        </a>
          <?php }} ?>
      </div>
      <br/>
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


<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/8b7c20e2b3a6d39239af41b65874f412-mobile.footer.tpl.php') ?>
