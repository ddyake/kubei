<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/9874f5f8af60e81ceb130e1f9803301d-header.tpl.php') ?>
<div class="p-list">
	<ul>
		<?php if (isset($pages['data']) && is_array($pages['data'])){foreach($pages['data'] as $v){ ?>
		<li>
			<a href="<?php echo fn_url(array('href'=>'/act.php?act=picture&aid='.$v['id'])); ?>" target="_blank">
			<img src="<?php echo fn_url(array('href'=>$v['image'])); ?>">
			<span><?php echo $v['tit']; ?></span>
			</a>
		</li>
		<?php }} ?>
	</ul>
	<?php if($page['max'] !=1){ ?>
	<div class="pagination">
		<ul class="paging">
				<li class="first">
					<a href="<?php echo fn_url(array('href'=>'/act.php?act=plist&p=1')); ?>">首页</a>
				</li>
				<?php if($pages['nowPage'] !=1){ ?>
				<li class="uppage">
					<a href="<?php echo fn_url(array('href'=>'/act.php?act=plist&p='.$pages['upPage'])); ?>">上一页</a>
				</li>
				<?php } ?>

					<?php for($page['min'];$page['min']<=$page['max'];$page['min']++){ ?>
				<li class="page<?php if($page['min'] == $pages['nowPage']){ ?> act<?php } ?>">
					<a href="<?php echo fn_url(array('href'=>'/act.php?act=plist&p='.$page['min'])); ?>"><?php echo $page['min']; ?><br/></a>
				</li>
				<?php } ?>
				<?php if($pages['nowPage'] != $page['max']){ ?>
				<li class="downpage">
						<a href="<?php echo fn_url(array('href'=>'/act.php?act=plist&p='.$pages['downPage'])); ?>">下一页</a>
				</li>
				<?php } ?>
				<li class="last">
					<a href="<?php echo fn_url(array('href'=>'/act.php?act=plist&p='.$pages['maxPage'])); ?>">末页</a>
				</li>

		</ul>
	</div>
	<?php } ?>
</div>
<?php include_once('/Volumes/DATA/workspace/www/kubei/qiaoxiao.com/data/compile/2d83b6430a17920690c40ef4a2b67c59-footer.tpl.php') ?>
