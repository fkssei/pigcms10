<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<!--title><?php echo $pageTitle;?> - <?php echo $now_store['name'];?></title-->
		<title><?php echo $pageTitle;?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/order_list.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/order.js"></script>
		<script>
		$(function () {
			$("#pages a").click(function () {
				var page = $(this).attr("data-page-num");
				location.href = "<?php echo $page_url ?>&page=" + page;
			});
		});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="content">
                <div id="order-list-container">
					<div class="b-list">
						<?php foreach($orderList as $order){ ?>
							<li class="block block-order animated">
								<div class="header">
									<span class="font-size-12">订单号：<?php echo $order['order_no_txt'];?></span>
									<?php if($order['status']<2){ ?>
										<a class="js-cancel-order pull-right font-size-12 c-blue" href="javascript:;" data-id="<?php echo $order['order_id'];?>">取消</a>
									<?php } ?>
								</div>
								<hr class="margin-0 left-10"/>
								<?php 
								foreach ($order['order_product_list'] as $order_product) {
								?>
									<div class="block block-list block-border-top-none block-border-bottom-none">
										<div class="block-item name-card name-card-3col clearfix">
											<a href="good.php?id=<?php echo $order_product['product_id'] ?>" class="thumb">
												<img src="<?php echo $order_product['image'];?>"/>
											</a>
											<div class="detail">
												<a href="<?php echo $order['url'];?>"><h3 style="margin-bottom:6px;"><?php echo $order_product['name'];?></h3></a>
												<?php
													if($order_product['sku_data_arr']){
														foreach($order_product['sku_data_arr'] as $v){
												?>
															<p class="c-gray ellipsis"><?php echo $v['name'];?>：<?php echo $v['value'];?></p>
												<?php 
														}
													}
												?>
											</div>
											<div class="right-col">
												<div class="price">¥&nbsp;<span><?php echo $order_product['pro_price'];?></span></div>
												<div class="num">×<span class="num-txt"><?php echo $order_product['pro_num'];?></span></div>
											</div>
										</div>
									</div>
								<?php 
								}
								if ($order['shipping_method'] == 'selffetch') {
								?>
									<hr class="margin-0 left-10"/>
									<div class="bottom">
										<?php 
										if ($order['address']['physical_id']) {
										?>
											<?php echo $physical_list[$order['address']['physical_id']]['buyer_selffetch_name'] ?> (<?php echo $physical_list[$order['address']['physical_id']]['name'] ?>)
											<div class="opt-btn">
												<a class="btn btn-in-order-list" href="./physical_detail.php?id=<?php echo $order['address']['physical_id'] ?>">查看</a>
											</div>
										<?php
										} else if ($order['address']['store_id']) {
										?>
											<?php echo $store_contact_list[$order['address']['store_id']]['buyer_selffetch_name'] ?> (<?php echo $store_contact_list[$order['address']['store_id']]['name'] ?>)
											<div class="opt-btn">
												<a class="btn btn-in-order-list" href="./physical_detail.php?store_id=<?php echo $order['address']['store_id'] ?>">查看</a>
											</div>
										<?php
										}
										?>
										
									</div>
								<?php
								}
								?>
								
								<hr class="margin-0 left-10"/>
								<div class="bottom">
									<?php if($order['total']){ ?>
										<?php if (!empty($order['float_amount']) && $order['float_amount'] < 0) { ?>
											减免：<span class="c-red">￥<?php echo number_format(abs($order['float_amount']), 2, '.', '');?></span><br/>
										<?php } ?>
										总价：<span class="c-orange">￥<?php echo $order['total'];?></span>
									<?php }else{ ?>
										商品价格：<span class="c-orange">￥<?php echo $order['sub_total'];?></span>
									<?php } ?>
									<div class="opt-btn">
										<?php if($order['status']<2){ ?>
											<a class="btn btn-orange btn-in-order-list" href="<?php echo $order['url'];?>">付款</a>
										<?php }else{ ?>
											<a class="btn btn-in-order-list" href="<?php echo $order['url'];?>">详情</a>
										<?php } ?>
									</div>
								</div>
							</li>
						<?php } ?>
						<div class="bottom" id="pages">
							<?php echo $pages ?>
						</div>
					</div>
					<div class="empty-list list-finished" style="padding-top:60px;display:none;">
						<div>
							<h4>居然还没有订单</h4>
							<p class="font-size-12">好东西，手慢无</p>
						</div>
						<div><a href="<?php echo $now_store['url'];?>" class="tag tag-big tag-orange" style="padding:8px 30px;">去逛逛</a></div>
					</div>
				</div>
			</div>
			<?php include display('footer');?>
			<?php echo $shareData;?>
		</div>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>