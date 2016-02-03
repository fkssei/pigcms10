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
		<title><?php echo $nowOrder['status_txt'];?>的订单</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script>var orderNo='<?php echo $nowOrder['order_no_txt'];?>';</script>
		<script src="<?php echo TPL_URL;?>js/order_paid.js"></script>
	</head>
	<body>
		<div class="container js-page-content wap-page-order">
			<div class="content confirm-container">
				<div class="app app-order">
					<div class="app-inner inner-order" id="js-page-content">
                        <!-- 订单状态 -->
						<div class="important-message">
							<!-- 客户看 -->
							<h3>
								订单状态：
								<?php 
								if ($nowOrder['shipping_method'] == 'selffetch') {
									if ($nowOrder['status'] <= 1) {
										echo '临时订单';
									} else if ($nowOrder['status'] == 2) {
										echo '未' . ($now_store['buyer_selffetch_name'] ? $now_store['buyer_selffetch_name'] : '到店消费');
									} else {
										echo $nowOrder['status_txt'];
									}
								} else {
									echo $nowOrder['status_txt'];
								}
								if($nowOrder['payment_method'] == 'codpay') {
								?>
									支付方式：货到付款
								<?php
								}
								?>
								<a href="javascript:;" class="js-open-share c-blue pull-right hide">分享</a>
							</h3>
							<hr/>
							<p class="c-orange">请收藏该页面地址，方便查询订单状态。</p>
						</div>
						<!-- 物流 -->
						<div class="js-express-msg block block-list express-info append-message">
							<?php 
								if($nowOrder['package_list']){
									foreach($nowOrder['package_list'] as $value){
							?>
                                        <div class="block-item font-size-12">
                                            <p class="express-title">
                                                <?php echo $value['express_company'];?>&nbsp;&nbsp;&nbsp;<span class="c-gray">运单编号：</span><?php echo $value['express_no'];?>
                                            </p>
                                            <p class="express-context">
                                                <!-- <a href="http://m.kuaidi100.com/index_all.html?type=<?php echo $value['express_code'];?>&postid=<?php echo $value['express_no'];?>&callbackurl=<?php echo 'http://'.urlencode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>" target="_blank" style="color:#1B9C46;">查看物流信息</a> -->
                                                <a href="javascript:" data-type="<?php echo $value['express_code'] ?>" data-order_no="<?php echo $nowOrder['order_no_txt'] ?>" data-express_no="<?php echo $value['express_no'] ?>" style="color:#1B9C46;">查看物流信息</a> <span class="js-express_close" style="display:none;">关闭物流信息</span>
                                            </p>
                                            <div class="express_detail" data-is_has="0" style="display:none;">
                                            </div>
                                        </div>
							<?php
									}
								}
							?>
						</div>
                        <!-- 商品列表 -->
						<div class="block block-order block-border-top-none">
							<div class="header">
								<span>店铺：<?php echo $now_store['name'];?></span>
							</div>
							<hr class="margin-0 left-10"/>
							<div class="block block-list block-border-top-none block-border-bottom-none">
								<?php foreach($nowOrder['proList'] as $value){ ?>
									<div class="block-item name-card name-card-3col clearfix js-product-detail">
										<a href="javascript:;" class="thumb">
											<img class="js-view-image" src="<?php echo $value['image'];?>" alt="<?php echo $value['name'];?>"/>
										</a>
										<div class="detail">
											<a href="./good.php?id=<?php echo $value['product_id'];?>"><h3><?php echo $value['name'];?></h3></a>
											<?php
												if($value['sku_data_arr']){
													foreach($value['sku_data_arr'] as $v){
											?>
														<p class="c-gray ellipsis">
															<?php echo $v['name'];?>：<?php echo $v['value'];?>
														</p>
											<?php 
													}
												}
											?>
										</div>
										<div class="right-col">
											<div class="price">￥<span><?php echo number_format($value['pro_num']*$value['pro_price'],2);?></span><?php echo $value['is_present'] == 1 ? '<span style="color:#f60;">赠品</span>' : '' ?></div>
											<div class="num">×<span class="num-txt"><?php echo $value['pro_num'];?></span></div>
											<?php if($value['comment_arr']){ ?>
												<a class="link pull-right message js-show-message" data-comment='<?php echo json_encode($value['comment_arr']) ?>' href="javascript:;">查看留言</a>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
							</div>
							<hr class="margin-0 left-10"/>
							<?php if($nowOrder['status'] == 0){ ?>
								<div class="order-message clearfix" id="js-order-message">
									<textarea class="js-msg-container font-size-12" placeholder="给卖家留言..."></textarea>
								</div>
							<?php }else{ ?>
								<div class="order-message">
									<span class="font-size-12">买家留言：</span><p class="message-content font-size-12"><?php echo $nowOrder['comment'] ? $nowOrder['comment'] : '无'?></p>
								</div>
								<hr class="margin-0 left-10"/>
							<?php } ?>
							<div class="bottom">总价<span class="c-orange pull-right">￥<?php echo $nowOrder['sub_total']?></span></div>
						</div>
						<!-- 物流信息 -->
						<div class="block block-form">
							<!-- 快递 -->
							<div class="block-item " style="padding:5px 0;">
								<?php
								if($nowOrder['address_arr']){
									if ($nowOrder['shipping_method'] == 'selffetch') {
								?>
										<ul>
											<li><?php echo $now_store['buyer_selffetch_name'] ? $now_store['buyer_selffetch_name'] : '上门自提' ?></li>
											<li>
												门店电话：<a style="display:inline-block; overflow:visible; padding:0px; margin:0px;" href="tel:<?php echo $nowOrder['address_arr']['address']['tel'] ?>"><?php echo $nowOrder['address_arr']['address']['tel'] ?></a>
												<?php 
												if ($nowOrder['address_arr']['address']['physical_id']) {
												?>
													<a style="display:inline-block; overflow:visible; padding:0px; margin:0px;" href="./physical_detail.php?id=<?php echo $nowOrder['address_arr']['address']['physical_id'] ?>">查看地图</a>
												<?php
												} else {
												?>
													<a style="display:inline-block; overflow:visible; padding:0px; margin:0px;" href="./physical_detail.php?store_id=<?php echo $now_store['store_id'] ?>">查看地图</a>
												<?php
												}
												?>
											</li>
											<li><?php echo $nowOrder['address_arr']['address']['province'];?> <?php echo $nowOrder['address_arr']['address']['city'];?> <?php echo $nowOrder['address_arr']['address']['area'];?></li>
											<li><?php echo $nowOrder['address_arr']['address']['address'];?></li>
											<li>联系人：<?php echo $nowOrder['address_arr']['user'];?>，<?php echo $nowOrder['address_arr']['tel'];?></li>
											<li>预约时间：<?php echo $nowOrder['address_arr']['address']['date'];?> <?php echo $nowOrder['address_arr']['address']['time'];?></li>
										</ul>
								<?php
									} else {
								?>
										<ul>
											<li><?php echo $nowOrder['address_arr']['user'];?>，<?php echo $nowOrder['address_arr']['tel'];?></li>
											<li><?php echo $nowOrder['address_arr']['address']['province'];?> <?php echo $nowOrder['address_arr']['address']['city'];?> <?php echo $nowOrder['address_arr']['address']['area'];?></li>
											<li><?php echo $nowOrder['address_arr']['address']['address'];?></li>
										</ul>
								<?php
									}
								}
								?>
							</div>
						</div>
						<!-- 满减送优惠信息 -->
						<?php
						$money = 0;
						if ($order_ward_list || $order_coupon) {
						?>
							<div class="block block-bottom-0">
								<div class="js-order-total block-item order-total" style="text-align:left;">
									<?php
									foreach ($order_ward_list as $order_ward) {
										$money += $order_ward['content']['cash'];
									?>
										<p><span style="padding:0px 5px; background:#f60; color:white; border-radius:3px;">满减</span><?php echo getRewardStr($order_ward['content']) ?></p>
									<?php
									}
									if ($order_coupon) {
										$money += $order_coupon['money'];
									?>
										<span style="padding:0px 5px; background:#f60; color:white; border-radius:3px;">优惠券</span><a href="<?php echo url('coupon:detail', array('id' => $order_coupon['coupon_id'])) ?>"><?php echo $order_coupon['name'] ?></a>,优惠金额：<?php echo $order_coupon['money'] ?>元
									<?php
									}
									?>
								</div>
							</div>
						<?php
						}
						?>
						<!-- 支付 -->
						<div class="block block-bottom-0">
							<div class="js-order-total block-item order-total">
								<p>￥<?php echo $nowOrder['sub_total'];?> + ￥<?php echo $nowOrder['postage'];?>运费<?php echo $money ? ' - ￥' . $money . '优惠金额' : '' ?></p>
								<strong class="js-real-pay c-orange js-real-pay-temp">实付：￥<?php echo $nowOrder['total'];?></strong>
							</div>
							<?php if($nowOrder['status'] > 1 && $nowOrder['status'] < 5){ ?>
								<div class="block-item paid-time">
									<div class="paid-time-inner">
										<p>订单号：<?php echo $nowOrder['order_no_txt'];?></p>
										<?php 
										if($nowOrder['payment_method'] != 'codpay') {
										?>
											<p class="c-gray"><?php echo date('Y-m-d H:i:s',$nowOrder['paid_time']);?><br/>完成付款</p>
										<?php 
										}
										?>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="block block-top-0 block-border-top-none center">
							<div class="center action-tip js-pay-tip">支付完成后，如需退换货请及时联系卖家</div>
						</div>
					</div>
				</div>
			</div>
			<?php include display('footer');?>
		</div>

		<?php echo $shareData;?>
	</body>
</html>