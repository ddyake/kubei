<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/9874f5f8af60e81ceb130e1f9803301d-header.tpl.php') ?>

<div class="m-list" >
	<div class="main">
		<div class="left">
			<div class="ltop">
<?php if (isset($paging['data']) && is_array($paging['data'])){foreach($paging['data'] as $v){ ?>
				<div class="left1">
					<div class="picture"><a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$v['id'])); ?>"><img src="<?php echo fn_url(array('href'=>$v['image'])); ?>"></a></div>
					<div class="article">
						<div class="title">
							<a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$v['id'])); ?>" target="_blank"><?php echo $v['tit']; ?></a>
						</div>
						<div class="middle">
							<span><?php echo $v['note']; ?></span><a class="anymore" href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$v['id'])); ?>" target="_blank">[查看全部]</a>
						</div>
						<div class="more">
							<div class="time">
								<div class="img"></div>
								<div class="time1">
									<span><?php echo date('Y年m月d日',$v['createtime']); ?></span>
								</div>
							</div>
							<div class="look">
								<div class="img"></div>
								<div class="look1">
									<?php echo $v['click']; ?>
								</div>
							</div>
							<div class="wangz">
								<div class="img"></div>
								<div class="wangz1">
									<span>网络改编</span>
								</div>
							</div>
							<div class="eight">
								<div class="img"></div>
								<div class="eight1">
									<span>吃土知八卦</span>
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

    	</div>
<?php }} ?>

      <?php if($paging['maxPage'] > 1){ ?>
			<div class="pagination">
				<ul class="paging">
						<li class="first">
							<a href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid='.$tid.'&p=1')); ?>">首页</a>
						</li>
						<?php if($paging['nowPage'] !=1){ ?>
						<li class="uppage">
							<a href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid='.$tid.'&p='.$paging['upPage'])); ?>">上一页</a>
						</li>
						<?php } ?>


							<?php for($page['min'];$page['min']<=$page['max'];$page['min']++){ ?>
						<li class="page<?php if($page['min'] == $paging['nowPage']){ ?> act<?php } ?>">
							<a href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid='.$tid.'&p='.$page['min'])); ?>"><?php echo $page['min']; ?><br/></a>
						</li>
						<?php } ?>
						<?php if($paging['nowPage'] != $page['max']){ ?>
						<li class="downpage">
								<a href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid='.$tid.'&p='.$paging['downPage'])); ?>">下一页</a>
						</li>
						<?php } ?>
						<li class="last">
							<a href="<?php echo fn_url(array('href'=>'/act.php?act=list&tid='.$tid.'&p='.$paging['maxPage'])); ?>">末页</a>
						</li>

				</ul>
			</div>
      <?php } ?>

			<div class="br"></div>

		</div>
	</div>
		<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/302c547c7c34f495eda5479797601f90-right.tpl.php') ?>

		<div class="br"></div>

	</div>

</div>





<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/2d83b6430a17920690c40ef4a2b67c59-footer.tpl.php') ?>
