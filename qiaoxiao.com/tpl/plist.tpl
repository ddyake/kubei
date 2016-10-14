<!--{include file='header.tpl'}-->
<div class="p-list">
	<ul>
		<!--{foreach $pages['data'] as $v}-->
		<li>
			<a href="<!--{fn_url href='/act.php?act=picture&aid='.$v['id']}-->" target="_blank">
			<img src="<!--{fn_url href=$v['image']}-->">
			<span><!--{$v['tit']}--></span>
			</a>
		</li>
		<!--{/foreach}-->
	</ul>
	<!--{if $page['max'] !=1}-->
	<div class="pagination">
		<ul class="paging">
				<li class="first">
					<a href="<!--{fn_url href='/act.php?act=plist&p=1'}-->">首页</a>
				</li>
				<!--{if $pages['nowPage'] !=1}-->
				<li class="uppage">
					<a href="<!--{fn_url href='/act.php?act=plist&p='.$pages['upPage']}-->">上一页</a>
				</li>
				<!--{/if}-->

					<!--{for($page['min'];$page['min']<=$page['max'];$page['min']++)}-->
				<li class="page<!--{if $page['min'] == $pages['nowPage']}--> act<!--{/if}-->">
					<a href="<!--{fn_url href='/act.php?act=plist&p='.$page['min']}-->"><!--{$page['min']}--><br/></a>
				</li>
				<!--{/for}-->
				<!--{if $pages['nowPage'] != $page['max']}-->
				<li class="downpage">
						<a href="<!--{fn_url href='/act.php?act=plist&p='.$pages['downPage']}-->">下一页</a>
				</li>
				<!--{/if}-->
				<li class="last">
					<a href="<!--{fn_url href='/act.php?act=plist&p='.$pages['maxPage']}-->">末页</a>
				</li>

		</ul>
	</div>
	<!--{/if}-->
</div>
<!--{include file='footer.tpl'}-->
