<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/9874f5f8af60e81ceb130e1f9803301d-header.tpl.php') ?>
	<div class="m-main">
		<div class="bigtitle">
			<div class="btitle"><span>
				<?php echo $article['tit']; ?>
			</span></div>
			<div class="bmore">
				<div class="left">
					<div class="more">
						<div class="time">
							<div class="img"></div>
						<div class="time1">
							<span><?php echo date('Y年m月d日',$article['createtime']); ?></span>
						</div>
					</div>
					<div class="look">
						<div class="img"></div>
						<div class="look1">
							<span><?php echo $article['click']; ?></span>
						</div>
					</div>
					<div class="wangz">
						<div class="img"></div>
						<div class="wangz1">
							<span><?php if($article['source']){ ?><?php echo $article['source']; ?><?php }else{ ?>网络改编<?php } ?></span>
						</div>
					</div>
					<div class="eight">
						<div class="img"></div>
						<div class="eight1">
							<span><?php if($article['editor']){ ?><?php echo $article['editor']; ?><?php }else{ ?>吃土八卦<?php } ?></span>
						</div>
					</div>
					<div class="shar">
						<div class="img"></div>
						<div class="shar1">
							<span>分享</span>
						</div>
					</div>
				</div>
				</div>
				<div class="right">
					<div class="img1"></div>
					<div class="img2"></div>
					<div class="img3"></div>
					<div class="img4"></div>
					<div class="img5"></div>
				</div>
			</div>
		</div>
		<div class="bigleft">
			<div class="article">
				<?php echo $detail['article']; ?>
			</div>
			<?php if($article['pg']!=1){ ?>
			<span class="pagination" >
				<ul class="paging">
					<li class="page">共<?php echo $article['pg']; ?>页：</li>
					<?php if($page != 1){ ?>
					<li class="up"><a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$aid.'&p='.$up)); ?>">上一页</a></li>
					<?php } ?>
					<?php for($i=1;$i<=$article['pg'];$i++){ ?>
					<li class="pages<?php if($i == $paging['nowPage']){ ?> act<?php } ?>">
						<a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$aid.'&p='.$article['page']=$i)); ?>"><?php echo $i; ?></a>
					</li>
					<?php } ?>
					<?php if($page !=$article['pg']){ ?>
					<li class="down"><a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$aid.'&p='.$down)); ?>" >下一页</a></li>
					<?php } ?>
				</ul>
			</span>
			<?php } ?>
			<div class="reading">
				<div class="rarticle"><span></span>&nbsp;相关阅读</div>
				<div class="rmain">
					<div class="r-left">
						<div class="l-top">
              <ul>
                <?php if (isset($related) && is_array($related)){foreach($related as $v){ ?>
								<li>
									<a title="<?php echo $v['tit']; ?>" target="_blank" href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$v['id'])); ?>"><?php echo $v['tit']; ?></a>
									<span><?php echo date('m-d',$v['createtime']); ?></span>
								</li>
                <?php }} ?>
							</ul>
						</div>
						<div class="l-bottom">
              	<ul>
                <?php if (isset($related2) && is_array($related2)){foreach($related2 as $v){ ?>
                		<li>
                  			<a title="<?php echo $v['tit']; ?>" target="_blank" href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$v['id'])); ?>"><?php echo $v['tit']; ?></a>
                  					<span><?php echo date('m-d',$v['createtime']); ?></span>
                		</li>
                <?php }} ?>
              		</ul>
						</div>

					</div>
					<div class="r-right">
						<div class="bd">
							<ul>
								<li class="b1"></li>
								<li class="b2"></li>
							</ul>
						</div>
						<div class="hd">
							<ul>
								<li class="p1">
									<img src="./image/mingxing/0Z6494246-0.jpg" alt="">
									<span>习近平会见第31届奥运会中国体育代表团</span>
								</li>
								<li class="p1">
									<img src="./image/mingxing/0Z6494246-0.jpg" alt="">
									<span>习近平会见第31届奥运会中国体育代表团</span>
								</li>

							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="looking">
				<div class="larticle"><span></span>&nbsp;大家都在看</div>
				<div class="lpictures">
					<ul>
						<?php if (isset($looking) && is_array($looking)){foreach($looking as $key=>$v){ ?>
						<li>
							<a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$v['id'])); ?>">
								<img src="<?php echo $v['image']; ?>" alt="">
								<span><?php echo $v['tit']; ?></span>
							</a>
						</li>
						<?php }} ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="bigright">
			<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/302c547c7c34f495eda5479797601f90-right.tpl.php') ?>
		</div>
		<div class="br"></div>
	</div>
		<div class="br"></div>
<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/2d83b6430a17920690c40ef4a2b67c59-footer.tpl.php') ?>
