<!--{include file='header.tpl'}-->
	<div class="m-main">
		<div class="bigtitle">
			<div class="btitle"><span>
				<!--{$article['tit']}-->
			</span></div>
			<div class="bmore">
				<div class="left">
					<div class="more">
						<div class="time">
							<div class="img"></div>
						<div class="time1">
							<span><!--{date:('Y年m月d日',$article['createtime'])}--></span>
						</div>
					</div>
					<div class="look">
						<div class="img"></div>
						<div class="look1">
							<span><!--{$article['click']}--></span>
						</div>
					</div>
					<div class="wangz">
						<div class="img"></div>
						<div class="wangz1">
							<span><!--{if $article['source']}--><!--{$article['source']}--><!--{else}-->网络改编<!--{/if}--></span>
						</div>
					</div>
					<div class="eight">
						<div class="img"></div>
						<div class="eight1">
							<span><!--{if $article['editor']}--><!--{$article['editor']}--><!--{else}-->吃土八卦<!--{/if}--></span>
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
				<!--{$detail['article']}-->
			</div>
			<!--{if $article['pg']!=1}-->
			<span class="pagination" >
				<ul class="paging">
					<li class="page">共<!--{$article['pg']}-->页：</li>
					<!--{if $page != 1}-->
					<li class="up"><a href="<!--{fn_url href='/act.php?act=article&aid='.$aid.'&p='.$up}-->">上一页</a></li>
					<!--{/if}-->
					<!--{for($i=1;$i<=$article['pg'];$i++)}-->
					<li class="pages<!--{if $i == $paging['nowPage']}--> act<!--{/if}-->">
						<a href="<!--{fn_url href='/act.php?act=article&aid='.$aid.'&p='.$article['page']=$i }-->"><!--{$i}--></a>
					</li>
					<!--{/for}-->
					<!--{if $page !=$article['pg']}-->
					<li class="down"><a href="<!--{fn_url href='/act.php?act=article&aid='.$aid.'&p='.$down}-->" >下一页</a></li>
					<!--{/if}-->
				</ul>
			</span>
			<!--{/if}-->
			<div class="reading">
				<div class="rarticle"><span></span>&nbsp;相关阅读</div>
				<div class="rmain">
					<div class="r-left">
						<div class="l-top">
              <ul>
                <!--{foreach $related as $v}-->
								<li>
									<a title="<!--{$v['tit']}-->" target="_blank" href="<!--{fn_url href='/act.php?act=article&aid='.$v['id']}-->"><!--{$v['tit']}--></a>
									<span><!--{date:('m-d',$v['createtime'])}--></span>
								</li>
                <!--{/foreach}-->
							</ul>
						</div>
						<div class="l-bottom">
              	<ul>
                <!--{foreach $related2 as $v}-->
                		<li>
                  			<a title="<!--{$v['tit']}-->" target="_blank" href="<!--{fn_url href='/act.php?act=article&aid='.$v['id']}-->"><!--{$v['tit']}--></a>
                  					<span><!--{date:('m-d',$v['createtime'])}--></span>
                		</li>
                <!--{/foreach}-->
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
						<!--{foreach $looking as $key=>$v}-->
						<li>
							<a href="<!--{fn_url href='/act.php?act=article&aid='.$v['id']}-->">
								<img src="<!--{$v['image']}-->" alt="">
								<span><!--{$v['tit']}--></span>
							</a>
						</li>
						<!--{/foreach}-->
					</ul>
				</div>
			</div>
		</div>
		<div class="bigright">
			<!--{include file='right.tpl'}-->
		</div>
		<div class="br"></div>
	</div>
		<div class="br"></div>
<!--{include file='footer.tpl'}-->
