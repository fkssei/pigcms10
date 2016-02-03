<?php include display( 'public:person_header');?>

<script src="<?php echo TPL_URL;?>js/script.js"></script>

<script>
$(function () {
	$(".dt-shop-attention").click(function () {
		if (!confirm("您确定要取消关注此店铺吗？")) {
			return;
		}
		attention_cancel($(this).attr("data-id"), 2);
	});

	$(".page_list a").click(function () {
		var page = $(this).attr("data-page-num");
		var url = "<?php echo url("account:attention_store") ?>&page=" + page;
		location.href = url;
	});
});
</script>
<style>
.Div1_main ul{width:auto}
</style>
		  <div id="con_one_4">
					<div class="danye_content_title">
						<div class="danye_suoyou"><a href="javascript:void(0)"><span>关注店铺</span></a></div>
					</div>
					<ul class="danye_guanzhu" style="margin-bottom:50px;">
					<?php foreach($store_list as $k=>$v) {?>
						<li class="danye_guanzhu_list ">
							<div  class="danye_shop  clearfix">
								<div class="danye_shop_title">
									<div class="danye_shop_title_top clearfix">
									<!--  	<input type="checkbox" />-->
										<div class="shop_img" ><a href="<?php echo url_rewrite('store:index', array('id' => $v['store_id'])) ?>" target="_blank"><img style="height:77px;width:77px;" src="<?php echo $v['logo']?>" /></a> </div>
									</div>
									<div class="danye_shop_txt"><a href="<?php echo url_rewrite('store:index', array('id' => $v['store_id'])) ?>" target="_blank"><?php echo $v['name'];?></a></div>
									<ul>
										<li class=" clearfix">
											<div class="danye_shop_list_tab">关注:<span><?php echo $v['attention_num'] ?>人</span></div>
										</li>
										<li class=" clearfix">
											<div class="danye_shop_list_tab">服务评价:</div>
											<div class="shop_comment">
												<div class="shop_comment_bg" style="width:<?php echo $v['satisfaction_pre'] ?>;"> </div>
											</div>
										</li>
										<li class=" clearfix">
											<div class="danye_shop_list_tab">关注时间:<span><?php echo date("Y-m-d",$v['add_time']);?></span></div>
										</li>
									</ul>
									<div class="danye_button">
										<button  class="danye_go_shop cursor" style="display:none" onclick="javascript:location.href='<?php echo url_rewrite('store:index', array('id' => $v['store_id'])) ?>'">进入店铺</button>
										<button  class="danye_kefu contact_shop cursor " disabled="disabled" open-url="<?php echo $v['imUrl'];?>" data-tel="<?php echo $v['service_tel'] ?>">联系客服</button>
										<button  class="danye_guanzhu dt-shop-attention" data-id="<?php echo $v['store_id'];?>"  >取消关注</button>
									</div>
								</div>
								<div class="danye_shop_list">
									<div class="danye_shop_list_title  clearfix">
										<div  class="rexiao danye_shop_hot">热销(<?php echo $v['hot_list_count'];?>)</div>
										<div class="danye_shop_new">新品(<?php echo $v['news_list_count'];?>)</div>
									</div>
									<div class="danye_shop_list_table danye_product1">
										<div class="Div1 divScroll00"> 
										<?php if($v['hot_list_count']) {?>
											 <b class="Div1_prev Div1_prev1" ><img src="images/lizi_img011.jpg" title="上一页" /></b>
											 <b class="Div1_next Div1_next1" ><img src="images/lizi_img012.jpg"  title="下一页"/></b>
										<?php }?> 
											<div class="Div1_main">
											<style>
											
											</style>
												<ul style="height:159px;">
												<?php foreach($v['hot_list'] as $k1=>$v1) {?>
													<li class="Div1_main_span1"> <a target="_blank" href="<?php echo url_rewrite('goods:index', array('id' => $v1['product_id'])) ?>" class="Div1_main_a1">
														<div class="content_list_img"><img src="<?php echo $v1['image']?>"  width="218px"> </div>
														<div class="content_list_txt"> ￥<?php echo $v1['price']?> </div>
														</a> </li>
												<?php }?>		
												</ul>
											</div>
										</div>
									</div>
									<div class="danye_shop_list_table danye_product2">
										<div class="Div1 divScroll01"> 
										<?php if($v['news_list_count']) {?>
										<b class="Div1_prev Div1_prev1" ><img src="images/lizi_img011.jpg" title="上一页" /></b> 
										<b class="Div1_next Div1_next1" ><img src="images/lizi_img012.jpg"  title="下一页"/></b>
										<?php }?>
											<div class="Div1_main">
												<ul style="height:159px;">
												<?php foreach($v['news_list'] as $k1=>$v1) {?>
													<li class="Div1_main_span1"> <a target="_blank" href="<?php echo url_rewrite('goods:index', array('id' => $v1['product_id'])) ?>" class="Div1_main_a1">
														<div class="content_list_img"><img src="<?php echo $v1['image']?>" width="218px"> </div>
														<div class="content_list_txt"> ￥<?php echo $v1['price']?> </div>
														</a> </li>
												<?php }?>	
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</li>
						<?php }?>
							
												</ul><div class="page_list"><dl>	<?php echo $pages ?></dl></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
				</div>

</div>
				<script>
				//$('.divScroll00').eq(0).cxScroll();
				</script>
				<?php include display( 'public:person_footer');?>