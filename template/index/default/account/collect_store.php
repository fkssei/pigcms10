<?php include display( 'public:person_header');?>
<script>
$(function () {
	$(".dt-shop-collect").click(function () {
		if (!confirm("您确定要取消收藏此店铺吗？")) {
			return;
		}

		userCancelCollect($(this).attr("data-id"), 2);
	});

	$("#pages a").click(function () {
		var page = $(this).attr("data-page-num");
		var url = "<?php echo url("account:collect_store") ?>&page=" + page;
		location.href = url;
	});
});
</script>
<div id="con_one_4">
                    <div class="danye_content_title">
                        <div class="danye_suoyou"><a href="###"><span>店铺收藏</span></a></div>
                    </div>
                    <div class="yuuhuiquan_info_list ">
                        <ul>
						<?php 
					if (!empty($store_list)) {
						foreach ($store_list as $store) {
					?>
                            <li>
                                <div class="youhuiquan_shop_info clearfix">
                                    <div class="youhuiquan_shop_info_img"><img src="<?php echo $store['logo'] ?>"></div>
                                    <div class="youhuiquan_shop_info_c">
                                        <div class="youhuiquan_shop_info_c_txt"><?php echo htmlspecialchars($store['name']) ?></div>
                                        <div class="youhuiquan_shop_info_c_txt">联系卖家:<span><?php echo $store['service_tel'] ?></span></div>
                                        <div class="youhuiquan_shop_info_c_txt">店查看优惠券<span><?php echo $store['collect'] ?></span></div>
                                    </div>
                                    <div class="youhuiquan_shop_info_r">
                                        <button class="go_shop" onclick="location.href='<?php echo url_rewrite('store:index', array('id' => $store['store_id'])) ?>'" style="cursor:pointer">进入店铺</button>
                                        <button data-id="<?php echo $store['store_id'] ?>" class="dt-shop-collect" style="cursor:pointer">取消</button>
                                    </div>
                                </div>
                            </li>
                            <?php
						}
					}
					?>
                        </ul>
						<?php if ($pages) { ?>
					
					<div class="page_list" id="pages">
                        <dl>
                            <?php echo $pages ?>
							</dl>
                    </div>
					<?php 
				}
				?>
			</div>
                    </div>
                </div>
				<?php include display( 'public:person_footer');?>