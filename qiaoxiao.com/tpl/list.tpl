<!--{include file='header.tpl'}-->

<div class="m-list" >
	<div class="main">
		<div class="left">
			<div class="ltop">
<!--{foreach $paging['data'] as $v}-->
				<div class="left1">
					<div class="picture"><a href="<!--{fn_url href='/act.php?act=article&aid='.$v['id']}-->"><img src="<!--{fn_url href=$v['image']}-->"></a></div>
					<div class="article">
						<div class="title">
							<a href="<!--{fn_url href='/act.php?act=article&aid='.$v['id']}-->" target="_blank"><!--{$v['tit']}--></a>
						</div>
						<div class="middle">
							<span><!--{$v['note']}--></span><a class="anymore" href="<!--{fn_url href='/act.php?act=article&aid='.$v['id']}-->" target="_blank">[查看全部]</a>
						</div>
						<div class="more">
							<div class="time">
								<div class="img"></div>
								<div class="time1">
									<span><!--{date:('Y年m月d日',$v['createtime'])}--></span>
								</div>
							</div>
							<div class="look">
								<div class="img"></div>
								<div class="look1">
									<!--{$v['click']}-->
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
<!--{/foreach}-->

      <!--{if $paging['maxPage'] > 1}-->
			<div class="pagination">
				<ul class="paging">
						<li class="first">
							<a href="<!--{fn_url href='/act.php?act=list&tid='.$tid.'&p=1'}-->">首页</a>
						</li>
						<!--{if $paging['nowPage'] !=1}-->
						<li class="uppage">
							<a href="<!--{fn_url href='/act.php?act=list&tid='.$tid.'&p='.$paging['upPage']}-->">上一页</a>
						</li>
						<!--{/if}-->


							<!--{for($page['min'];$page['min']<=$page['max'];$page['min']++)}-->
						<li class="page<!--{if $page['min'] == $paging['nowPage']}--> act<!--{/if}-->">
							<a href="<!--{fn_url href='/act.php?act=list&tid='.$tid.'&p='.$page['min']}-->"><!--{$page['min']}--><br/></a>
						</li>
						<!--{/for}-->
						<!--{if $paging['nowPage'] != $page['max']}-->
						<li class="downpage">
								<a href="<!--{fn_url href='/act.php?act=list&tid='.$tid.'&p='.$paging['downPage']}-->">下一页</a>
						</li>
						<!--{/if}-->
						<li class="last">
							<a href="<!--{fn_url href='/act.php?act=list&tid='.$tid.'&p='.$paging['maxPage']}-->">末页</a>
						</li>

				</ul>
			</div>
      <!--{/if}-->

			<div class="br"></div>

		</div>
	</div>
		<!--{include file='right.tpl'}-->

		<div class="br"></div>

	</div>

</div>





<!--{include file='footer.tpl'}-->
