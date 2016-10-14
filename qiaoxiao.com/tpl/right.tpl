<div class="right">
	<div class="focuse">
		<div class="title">
			<div class="word"><p>娱乐聚焦<p></div>
		</div>
		<div class="main1">
			<ul>
				<!--{foreach $yljj as $v}-->
				<li>
					<a href="<!--{fn_url href='/act.php?act=article&aid='.$v['id']}-->" target="_blank">
						<img src="<!--{fn_url href=$v['image']}-->">
						<span><!--{$v['tit']}--></span>
					</a>
				</li>
				<!--{/foreach}-->





			</ul>
		</div>
	</div>
	<div class="hot">
		<div class="title">
			<div class="word"><p>热门资讯<p></div>
		</div>
		<div class="news">
			<!--{foreach $hot as $key=>$v}-->
			<div class="new1">
				<div class="name">
					<a href="<!--{fn_url href='/act.php?act=article&aid='.$v['id']}-->"><!--{fn_substr str=$v['tit'] len=17}--></a>
				</div>
				<div class="main4">
					<ul>
						<li>
							<a href="<!--{fn_url href='/act.php?act=article&aid='.$v['id']}-->" target="_blank">
							<img src="<!--{fn_url href=$v['image']}-->">
							<span><!--{$v['note']}--></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<!--{/foreach}-->
		</div>
	</div>
	<div class="start">
		<div class="title">
			<div class="word"><p>热搜明星</p></div>
			<a href="<!--{fn_url href='/act.php?act=plist&tid=5667'}-->" target="_blank"><div class="add"></div></a>
			</div>
			<div class="main2">
				<ul>
					<!--{foreach $start as $key=>$v}-->
					<li>
						<a href="<!--{fn_url href='/act.php?act=picture&aid='.$v['id']}-->" target="_blank">
							<img src="<!--{fn_url href=$v['image']}-->">
							<span><!--{$v['tit']}--></span>
						</a>
					</li>
					<!--{/foreach}-->
				</ul>
			</div>
		</div>

			<div class="recommends" >
				<div class="title">
					<div class="word"><p>图文推荐</p></div>
					<div class="add"><a href="<!--{fn_url href='/act.php?act=plist&tid=5673'}-->" target="_blank"></a></div>
				</div>
				<div class="main3">
					<ul>
						<!--{foreach $red as $key=>$v}-->
						<li>
							<a href="<!--{fn_url href='/act.php?act=article&aid='.$v['id']}-->" target="_blank">
							<img src="<!--{fn_url href=$v['image']}-->">
							<span><!--{$v['tit']}--></span>
							</a>
						</li>

					<!--{/foreach}-->




					</ul>
				</div>
			</div>
		</div>
</div>
