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
		<title>购物车</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/cart.css"/>
		<script>var noCart=true,storeId=<?php echo $now_store['store_id']?>,storeUrl="<?php echo $now_store['url'];?>";</script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/cart.js"></script>
	</head>
	<body class="body-fixed-bottom">
		<div class="container">
			<div class="content">
				<div class="tabber tabber-n2 tabber-double-11 clearfix">
					<a class="active" href="./cart.php?id=<?php echo $now_store['store_id']?>">购物车</a>
					<a href="./trade.php?id=<?php echo $now_store['store_id']?>">购物记录</a>
				</div>
                <div id="cart-container" class="block block-order">
					<?php if(!empty($cartList)){ ?>
						<div class="header js-list-header">
							<span>店铺：<?php echo $now_store['name']?></span>
							<a href="javascript:;" class="js-edit-list pull-right c-blue font-size-12 edit-list">编辑</a>
						</div>
						<hr class="margin-0 left-10"/>
					<?php } ?>
					<ul class="list block block-list block-list-cart block-border-none">
						<?php 
							if($cartList){
								foreach($cartList as $value){
						?>
									<li class="block-item block-item-cart relative clearfix item-<?php echo $value['pigcms_id'];?>" data-id="<?php echo $value['pigcms_id'];?>" data-num="<?php echo $value['pro_num']?>" data-price="<?php echo floatval($value['pro_price'])?>" data-skuid="<?php echo $value['sku_id'];?>" data-proid="<?php echo $value['product_id'];?>" data-skunum="<?php echo $value['sku_num'];?>" data-status="<?php echo $value['status'];?>">
										<div class="check-container">
											<span class="check checked"></span>
										</div>
										<div class="name-card name-card-3col clearfix">
											<a href="./good.php?id=<?php echo $value['product_id'];?>" class="thumb"><img src="<?php echo $value['image'] ?>"></a>
											<div class="detail">
												<h3 class="js-ellipsis" style="height:32px;overflow:hidden;"><i><?php echo $value['name'];?></i></h3>
												<p class="ellipsis">
													<?php
														if($value['sku_data']){
															$sku_data_arr = unserialize($value['sku_data']);
															foreach($sku_data_arr as $v){
													?>
																<p class="c-gray ellipsis"><?php echo $v['name'];?>：<?php echo $v['value'];?></p>
													<?php 
															}
														}
													?>
												</p>
											</div>
											<div class="right-col price-num">
												<div class="price">￥<span><?php echo floatval($value['pro_price']);?></span></div>
												<div class="num <?php if (!empty($value['buyer_quota'])) { ?>buyer-quota<?php } ?>" <?php if (!empty($value['buyer_quota'])) { ?>data-buyer-quota="<?php echo $value['buyer_quota']; ?>" data-buy-quantity="<?php echo $value['buy_quantity']; ?>"<?php } ?>>
													×<span class="num-txt"><?php echo $value['pro_num'];?></span>
												</div>
												<div class="error-box"></div>
											</div>
										</div>
										<div class="delete-btn"> <span>删除</span> </div>
									</li>
						<?php 
								}
							}
						?>
					</ul>
					<div class="js-bottom-opts bottom-fix" style="padding:0;">
						<div class="bottom-cart clear-fix">
							<div class="select-all"><span class="check"></span>全选</div>
							<div class="total-price">合计：<span class="js-total-price">0</span>元</div>
							<button href="javascript:;" class="js-go-pay btn btn-orange-dark font-size-14" disabled="true">结算</button>
							<button href="javascript:;" class="js-delete-goods btn font-size-14 btn-red hide" disabled="true">删除</button>
						</div>
					</div>
				</div>
			</div>
			<?php include display('footer');?>
			<?php echo $shareData;?>
		</div>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>