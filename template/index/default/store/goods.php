<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<div class="shop_list_left">
	<div class="cata_table content_commodity" style="margin:0px auto 25px auto;">
		<input type="hidden" id="product_sort" value="<?php echo $sort ?>" />
		<dl style="margin:0px 0px 25px 0px; border:0px; border-bottom:1px solid #e5e5e5;">
			<dd class="<?php echo empty($sort) ? 'cata_curnt' : '' ?> cata_table_li js-goods-sort" data-sort="default">默认</dd>
			<dd class="<?php echo $sort == 'sales' ? 'cata_curnt' : '' ?> cata_table_li js-goods-sort" data-sort="sales">热销</dd>
			<dd class="<?php echo $sort == 'price' ? 'cata_curnt' : '' ?> cata_table_li js-goods-sort" data-sort="price">价格</dd>
			<dt class="shortcut_page">
				<div class="cata_left <?php echo $current_page_arr['page'] > 1 ? 'cata_left_t' : '' ?>" data-page="<?php echo $current_page_arr['page'] > 1 ? $current_page_arr['page'] - 1 : 0 ?>"></div>
				<div class=" <?php echo $current_page_arr['page'] < $current_page_arr['total_pages'] ? 'cata_right' : 'cata_right_t' ?>" data-page="<?php echo $current_page_arr['page'] < $current_page_arr['total_pages'] ? $current_page_arr['page'] + 1 : 0 ?>"></div>
			</dt>
			<dt><span><?php echo $current_page_arr['page'] ?></span>/<?php echo $current_page_arr['total_pages'] ?></dt>
		</dl>
		<?php 
		if (!empty($product_list)) {
		?>
			<div class="content_list">
				<ul class="content_list_ul">
					<?php 
					foreach ($product_list as $product) {
						$long = '';
						$lat = '';
						if (!empty($product['supplier_id'])) {
							$long = $store_contact_list[$product['supplier_id']]['long'];
							$lat = $store_contact_list[$product['supplier_id']]['lat'];
						} else {
							$long = $store_contact_list[$product['store_id']]['long'];
							$lat = $store_contact_list[$product['store_id']]['lat'];
						}
					?>
						<li>
							<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>">
							<div class="content_list_img"><img src="<?php echo $product['image'] ?>">
								<div class="shop_list">
									<form onsubmit="return false">
										<div class="shop_guanzhu">
											<button onclick="userAttention('<?php echo $product['product_id'] ?>', '1')">关注产品</button>
										</div>
										<div class="shop_shoucang">
											<button onclick="userCollect('<?php echo $product['product_id'] ?>', '1')">收藏产品</button>
										</div>
									</form>
								</div>
							</div>
							<div class="content_list_txt">
								<div class="content_list_pice">￥<span><?php echo $product['price'] ?></span></div>
								<div class="content_list_dec"><span>已售<?php echo $product['sales'] ?>/</span>分销<?php echo $product['drp_seller_qty'] ?></div>
							</div>
							<div class="content_list_txt js-store-position" data-long="<?php echo $long ?>" data-lat="<?php echo $lat ?>">
								<div class="content_list_day">预计2-5天内送达 </div>
								<div class="content_list_add"></div>
							</div>
							<div class="shop_info">
								<div class="content_shop_name"><?php echo $product['name'] ?></div>
								<div class="content_shop_add"><?php echo $store_contact_list[$product['store_id']]['city_txt']; ?></div>
							</div>
							</a>
						</li>
					<?php 
					}
					?>
				</ul>
			</div>
		<?php 
		} else {
		?>
			<div class="content_list">暂无产品</div>
		<?php 
		}
		?>
	</div>
	<?php 
	if ($pages) {
	?>
		<style>
		.page_list .active{margin-right:5px; width:auto; padding:0 12px; height:36px; border:1px solid #00bb88; cursor:pointer; background:#00bb88;display:inline-block; color:white}
		.page_list .fetch_page {margin-right:5px; width:auto; padding:0 15px; height:36px;border:1px solid #00bb88; cursor:pointer;display:inline-block;}
		.page_list .fetch_page:hover {background:#00bb88; color:white;}
		</style>
		<div class="page_list js-goods-page">
			<dl>
				<?php echo $pages ?>
				<?php 
				if ($current_page_arr['total_pages'] > 1) {
				?>
					<dt>
						<form onsubmit="return false;">
							<span>跳转到:</span>
							<input name="page" class="js-jump-page" value="" />
							<button class="js-jump-product-page-btn">GO</button>
						</form>
					</dt>
				<?php 
				}
				?>
				&nbsp;&nbsp;
			</dl>
		</div>
	<?php 
	}
	?>
</div>