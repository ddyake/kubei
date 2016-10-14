<div class="right">
	<div class="focuse">
		<div class="title">
			<div class="word"><p>娱乐聚焦<p></div>
		</div>
		<div class="main1">
			<ul>
				<?php if (isset($yljj) && is_array($yljj)){foreach($yljj as $v){ ?>
				<li>
					<a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$v['id'])); ?>" target="_blank">
						<img src="<?php echo fn_url(array('href'=>$v['image'])); ?>">
						<span><?php echo $v['tit']; ?></span>
					</a>
				</li>
				<?php }} ?>





			</ul>
		</div>
	</div>
	<div class="hot">
		<div class="title">
			<div class="word"><p>热门资讯<p></div>
		</div>
		<div class="news">
			<?php if (isset($hot) && is_array($hot)){foreach($hot as $key=>$v){ ?>
			<div class="new1">
				<div class="name">
					<a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$v['id'])); ?>"><?php echo fn_substr(array('str'=>$v['tit'],'len'=>17)); ?></a>
				</div>
				<div class="main4">
					<ul>
						<li>
							<a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$v['id'])); ?>" target="_blank">
							<img src="<?php echo fn_url(array('href'=>$v['image'])); ?>">
							<span><?php echo $v['note']; ?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<?php }} ?>
		</div>
	</div>
	<div class="start">
		<div class="title">
			<div class="word"><p>热搜明星</p></div>
			<a href="<?php echo fn_url(array('href'=>'/act.php?act=plist&tid=5667')); ?>" target="_blank"><div class="add"></div></a>
			</div>
			<div class="main2">
				<ul>
					<?php if (isset($start) && is_array($start)){foreach($start as $key=>$v){ ?>
					<li>
						<a href="<?php echo fn_url(array('href'=>'/act.php?act=picture&aid='.$v['id'])); ?>" target="_blank">
							<img src="<?php echo fn_url(array('href'=>$v['image'])); ?>">
							<span><?php echo $v['tit']; ?></span>
						</a>
					</li>
					<?php }} ?>
				</ul>
			</div>
		</div>

			<div class="recommends" >
				<div class="title">
					<div class="word"><p>图文推荐</p></div>
					<div class="add"><a href="<?php echo fn_url(array('href'=>'/act.php?act=plist&tid=5673')); ?>" target="_blank"></a></div>
				</div>
				<div class="main3">
					<ul>
						<?php if (isset($red) && is_array($red)){foreach($red as $key=>$v){ ?>
						<li>
							<a href="<?php echo fn_url(array('href'=>'/act.php?act=article&aid='.$v['id'])); ?>" target="_blank">
							<img src="<?php echo fn_url(array('href'=>$v['image'])); ?>">
							<span><?php echo $v['tit']; ?></span>
							</a>
						</li>

					<?php }} ?>




					</ul>
				</div>
			</div>
		</div>
</div>
