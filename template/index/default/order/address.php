<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>确认收货地址-<?php echo $config[ 'site_name'];?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/style.css" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/index.css" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/cart.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $config['site_url'] ?>/static/css/jquery.ui.css" />
<link href=" " type="text/css" rel="stylesheet" id="sc">
<style>
.order_tianjia_form .order_tianjian_form_left span {margin-top:20px;}
</style>
<script>
var date_time = '<?php echo date('Y-m-d') ?>';
var is_logistics = <?php echo ($store['open_logistics'] || $is_all_supplierproduct) ? 'true' : 'false' ?>;
var is_selffetch = <?php echo ($store['buyer_selffetch'] && $is_all_selfproduct) ? 'true' : 'false' ?>;
</script>
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script src="<?php echo $config['site_url'];?>/static/js/area/area.min.js"></script>
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.form.min.js"></script>
<script type="text/javascript" src="./static/js/plugin/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/plugin/jquery-ui-timepicker-addon.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script src="<?php echo TPL_URL;?>js/cart_two.js"></script>
<script src="<?php echo TPL_URL;?>js/order.js"></script>
<script src="<?php echo TPL_URL;?>js/index2.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="js/DD_belatedPNG_0.0.8a.js" mce_src="js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<style type="text/css"> 
body{ behavior:url("csshover.htc");}
</style>
<![endif]-->

</head>
<body>
<?php include display( 'public:header_order');?>
<div class="order_content">
	<div class="Breadcrumbs">
		您的位置：<a href="/">首页</a> &gt; <a href="<?php echo url('account:index') ?>">会员中心</a> &gt; <a href="<?php echo url('account:order') ?>" class="current">我的订单</a>
	</div>
	<div class="steps six_steps">
		<ul class="part2">
			<li class="first">
				<hr>
			</li>
			<li class="icon"><span class="yellow_30_30"></span></li>
			<li class="cur_last">
				<hr>
			</li>
			<li class="cur_last ">
				<hr>
			</li>
			<li class="icon"><span class="yellow_30_30"></span></li>
			<li class="cur_last ">
				<hr>
			</li>
			<li class="cur_last grey_line">
				<hr>
			</li>
			<li class="icon"><span class="grey_30_30"></span></li>
			<li class="grey_line cur_last">
				<hr>
			</li>
	 
		</ul>
		<ul class="part3">
			<li>
				<span>购物车</span><br />
			</li>
			<li>
				<span class="no_rea"><span>确认收货地址</span><br /></span>
			</li>
			<li>
				<span class="no_rea">支付</span><br />
			</li>
		</ul>
	</div>
	<div class="order_contetn_add">
		<?php 
		if ($store['buyer_selffetch'] || $store['open_logistics']) {
		?>
			<div class="order_add">
				<div class="tab1" id="tab1">
					<div class="menu">
						<ul class="clearfix js-tab">
							<?php
							$is_open_logistics = false;
							if ($store['open_logistics'] || $is_all_supplierproduct) {
								$is_open_logistics = true;
							?>
								<li class="off" data-for="buyerInfo">快递配送</li>
							<?php 
							}
							if ($store['buyer_selffetch'] && $is_all_selfproduct) {
							?>
								<li <?php echo !$is_open_logistics ? 'class="off"' : '' ?> data-for="self"><?php echo $store['buyer_selffetch_name'] ? $store['buyer_selffetch_name'] : '到店自提' ?></li>
							<?php
							}
							if ($store['open_friend'] && $is_open_logistics) {
							?>
								<li data-for="friend">送朋友</li>
							<?php
							}
							?>
						</ul>
					</div>
					<div class="menudiv js-address_tab tijiao" style="height:auto; min-height:auto;">
						<?php 
						if ($store['open_logistics'] || $is_all_supplierproduct) {
						?>
							<div class="js_address_detail" id="con_one_1" style="display: block;">
								<div class="danye_content_title">
									<div class="danye_suoyou"><span>选择收货地址</span></div>
								</div>
								<div class="order_add_list">
									<ul class="order_add_list_ul js-express-address-list">
										<?php
										$has_default = false;
										$address_count = count($address_list);
										foreach ($address_list as $key => $tmp) {
											$class = '';
											if ($tmp['default']) {
												$has_default = true;
												$class = 'order_curn';
											}
											
											if ($address_count == $key + 1 && !$has_default) {
												$class = 'order_curn';
											}
										?>
											<li class="<?php echo $class ?>" id="address_<?php echo $tmp['address_id'] ?>" data-address_id="<?php echo $tmp['address_id'] ?>">
												<span></span>
												<div class="order_add_add"><?php echo $tmp['province_txt']?><?php echo $tmp['city_txt'] ?><?php echo $tmp['area_txt'] ?><?php echo htmlspecialchars($tmp['address']) ?></div>
												<div class="order_add_name"><?php echo htmlspecialchars($tmp['name']) ?></div>
												<div class="order_add_shouji"><?php echo $tmp['tel'] ?></div>
												<div class="order_add_caozuo">
													<i class="e-modify" data_id="<?php echo $tmp['address_id'] ?>" data_name="<?php echo htmlspecialchars($tmp['name']) ?>" data_province="<?php echo $tmp['province'] ?>" data_city="<?php echo $tmp['city'] ?>" data_area="<?php echo $tmp['area'] ?>" data_tel="<?php echo $tmp['tel'] ?>" data_address="<?php echo htmlspecialchars($tmp['address']) ?>" data_default="<?php echo $tmp['default'] ?>">修改</i>|<i data-address-id="<?php echo $tmp['address_id'] ?>" class="e-delete">删除</i>
												</div>
											</li>
										<?php 
										}
										?>
										<li class="order_tianjian"  data-address_id="default"><span></span>使用新地址</li>
									</ul>
									<div class="order_tianjia_form" id="J_AddressEditContainer" style="display:none;">
										<form name="address" id="address_add" method="post" action="<?php echo url('account:address') ?>">
											<ul>
												<li>
													<div class="order_tianjian_form_left"><span></span>所在地:</div>
													<div class="order_tianjian_form_select">
														<select name="province" id="provinceId_m" data-province="">
															<option>请选择</option>
														</select>
													</div>
													<div class="order_tianjian_form_select">
														<select name="city" id="cityId_m" data-city="">
															<option>请选择</option>
														</select>
													</div>
													<div class="order_tianjian_form_select">
														<select name="area" id="areaId_m" data-area="">
															<option>请选择</option>
														</select>
													</div>
												</li>
												<li>
													<div class="order_tianjian_form_left"><span></span>所在街道:</div>
													<div class="order_tianjian_form_right order_input">
														<input id="jiedao" name="address" />
													</div>
												</li>
												<li>
													<div class="order_tianjian_form_left"><span></span>收件人:</div>
													<div class="order_tianjian_form_right">
														<input name="name" id="name" >
													</div>
												</li>
												<li>
													<div class="order_tianjian_form_left"><span></span>联系电话:</div>
													<div class="order_tianjian_form_right">
														<input name="tel" id="tel">
													</div>
												</li>
												<li>
													<button class="order_add_queren">确认提交</button>
													<button class="">取消</button>
													<input type="hidden" id="address_id" name="address_id" value="" />
												</li>
											</ul>
										</form>
									</div>
								</div>
							</div>
						<?php 
						}
						if ($selffetch_list) {
						?>
							<div class="js_address_detail" id="con_one_<?php echo $is_open_logistics ? '2' : '1' ?>" <?php echo !$is_open_logistics ? '' : 'style="display: none;"' ?> >
								<div class="danye_content_title">
									<div class="danye_suoyou"><a href="javascript:"><span>选择门店</span></a></div>
								</div>
								<div class="order_add_list">
									<ul class="order_add_list_ul js-self-address-list">
										<?php
										foreach ($selffetch_list as $key => $tmp) {
											$class = '';
											if ($key == 0) {
												$class = 'order_curn';
											}
										?>
											<li class="<?php echo $class ?>" id="self_address_<?php echo $tmp['pigcms_id'] ?>" data-address-id="<?php echo $tmp['pigcms_id'] ?>">
												<span></span>
												<div class="order_add_name"><?php echo htmlspecialchars($tmp['name']) ?></div>
												<div class="order_add_add"><?php echo $tmp['province_txt']?><?php echo $tmp['city_txt'] ?><?php echo $tmp['county_txt'] ?><?php echo htmlspecialchars($tmp['address']) ?></div>
												<div class="order_add_shouji"><?php echo $tmp['tel'] ?></div>
											</li>
										<?php 
										}
										?>
									</ul>
									<div class="danye_content_title">
										<div class="danye_suoyou"><span>收货人信息</span></div>
									</div>
									<div class="order_tianjia_form">
										<ul>
											<li>
												<div class="order_tianjian_form_left"><span></span>预约人姓名:</div>
												<div class="order_tianjian_form_right order_input">
													<input name="self_name" id="self_name" />
												</div>
											</li>
											<li>
												<div class="order_tianjian_form_left"><span></span>手机号码:</div>
												<div class="order_tianjian_form_right">
													<input name="self_tel" id="self_tel" />
												</div>
											</li>
											<li>
												<div class="order_tianjian_form_left"><span></span>预约时间:</div>
												<div class="order_tianjian_form_right">
													<input name="self_date" id="js-time" class="inputText" type="text" value="<?php echo date('Y-m-d', time() + 4 * 3600 * 24) ?> 11:30:00" readonly="readonly" />
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						<?php 
						}
						if ($store['open_friend'] && $is_open_logistics) {
						?>
							<div class="js_address_detail js-friend" id="con_one_3" style="display: none;">
								<div class="order_add_list">
									<div class="danye_content_title">
										<div class="danye_suoyou"><span>填写朋友信息</span></div>
									</div>
									<div class="order_tianjia_form">
										<ul>
											<li>
												<div class="order_tianjian_form_left"><span></span>朋友姓名:</div>
												<div class="order_tianjian_form_right order_input">
													<input name="self_name" id="friend_name" />
												</div>
											</li>
											<li>
												<li>
													<div class="order_tianjian_form_left"><span></span>所在地:</div>
													<div class="order_tianjian_form_select">
														<select name="province" id="provinceId_friend" data-province="">
															<option>请选择</option>
														</select>
													</div>
													<div class="order_tianjian_form_select">
														<select name="city" id="cityId_friend" data-city="">
															<option>请选择</option>
														</select>
													</div>
													<div class="order_tianjian_form_select">
														<select name="area" id="areaId_friend" data-area="">
															<option>请选择</option>
														</select>
													</div>
												</li>
												<li>
													<div class="order_tianjian_form_left"><span></span>所在街道:</div>
													<div class="order_tianjian_form_right order_input">
														<input id="jiedao_friend" name="address" />
													</div>
												</li>
											</li>
											<li>
												<div class="order_tianjian_form_left"><span></span>手机号码:</div>
												<div class="order_tianjian_form_right">
													<input name="self_tel" id="friend_tel" />
												</div>
											</li>
											<li>
												<div class="order_tianjian_form_left"><span></span>预约时间:</div>
												<div class="order_tianjian_form_right">
													<input name="friend_date" id="js-friend-time" class="inputText" type="text" value="<?php echo date('Y-m-d', time() + 4 * 3600 * 24) ?> 11:30:00" readonly="readonly" />
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		<?php 
		}
		if ($offline_payment) {
		?>
			<style>
			.payment_list {padding:10px 50px;}
			.payment_list span{padding:8px; margin-right:20px; height:24px; line-height:24px; border:1px solid #CCC; cursor:pointer;}
			.payment_list .selected {border:1px solid #23cc9e; color:#23cc9e; font-weight:bold;}
			</style>
			<div class="order_add" style="margin-top:50px;">
				<div class="menudiv tijiao" style="height:auto; min-height:auto;">
					<div id="con_one_1" style="display: block;">
						<div class="danye_content_title">
							<div class="danye_suoyou"><span>选择支付方式</span></div>
						</div>
						<div class="payment_list js-payment_list">
							<span data-payment="on" class="selected">在线支付</span>
							<span data-payment="off">货到付款</span>
						</div>
					</div>
				</div>
			</div>
		<?php 
		}
		?>
		<div class="order_order">
			<div class="order_add_titele">确认商品信息</div>
			<ul class="order_add_table">
				<li class="order_product_title clearfix">
					<div class="product_1">商品</div>
					<div class="product_2">单价(元)</div>
					<div class="product_3">数量</div>
					<div class="product_4">小计(元)</div>
				</li>
				<li>
					<dl>
						<dt>
							<div  class="order_dec">店铺:<a href="<?php echo url('store:index', array('id' => $store['store_id'])) ?>"><span><?php echo htmlspecialchars($store['name']) ?></span></a></div>
						</dt>
						
						<?php
						$total_money = 0;
						if (isset($order['proList']) && is_array($order['proList'])) {
							foreach ($order['proList'] as $tmp) {
								$total_money += $tmp['pro_price'] * $tmp['pro_num'];
						?>
								<dd class="clearfix">
									<div class="product_1 clearfix">
										<div  class="order_product_img"><a href="<?php echo url('goods:index', array('id' => $tmp['product_id'])) ?>" target="_blank"><img src="<?php echo $tmp['image'] ?>" /></a></div>
										<div  class="order_product_txt">
											<div  class="order_product_txt_name"><a href="<?php echo url('goods:index', array('id' => $tmp['product_id'])) ?>" target="_blank"><?php echo htmlspecialchars($tmp['name']) ?></a></div>
											<div  class="order_product_txt_dec clearfix">
												<?php 
												if (!empty($tmp['sku_data_arr'])) {
													foreach ($tmp['sku_data_arr'] as  $k=>$sku_data) {
														echo '<div class="order_product_txt_dec_l" style="padding-right:5px;">' . $sku_data['name'] ."<span>:" . $sku_data['value'] . '</span></div>';
													}
												}
												?>
											</div>
										</div>
									</div>
									<div class="product_2"><?php echo $tmp['pro_price'] ?></div>
									<div class="product_3"><?php echo $tmp['pro_num']?></div>
									<div class="product_4"><?php echo $tmp['pro_price'] * $tmp['pro_num'] ?></div>
								</dd>
						<?php 
							}
						}
						?>
						<dt>备注:
							<input name="buyer_comment" />
						</dt>
					</dl>
				</li>
			</ul>
			
			<?php
			$tmp_reward_list = $reward_list;
			unset($tmp_reward_list['product_price_list']);
			if ($tmp_reward_list || $user_coupon_list) {
			?>
				<div class="order_tongji">
					<?php 
					if ($tmp_reward_list) {
					?>
						<div class="order_tongji_title">满减送活动</div>
						<dl>
							<dt class="clearfix">
								<div class="order_tongji_left ">满减送名称</div>
								<div class="order_tongji_right">满减送内容</div>
							</dt>
							<?php
							$reward_money = 0;
							$is_postage = 0;
							foreach ($reward_list as $key => $reward) {
								if ($key === 'product_price_list') {
									continue;
								}
								$reward_money += $reward['cash'];
								if ($reward['postage']) {
									$is_postage = 1;
								}
							?>
								<dd class="clearfix">
									<div class="order_tongji_left "><?php echo htmlspecialchars($reward['name']) ?></div>
									<div class="order_tongji_right"><?php echo getRewardStr($reward) ?></div>
								</dd>
							<?php
							}
							?>
						</dl>
					<?php
					}
					if ($user_coupon_list) {
					?>
						<div class="order_tongji_title">使用优惠券</div>
						<dl class="youhui" style="border:0;">
							<dt class="clearfix">
								<div class="order_tongji_left ">优惠券名称</div>
								<div class="order_tongji_right">优惠券金额</div>
							</dt>
							<dd class="clearfix js-youhui" data-coupon_id="0" style="cursor:pointer;">
								<div class="order_tongji_left"><span></span>不使用优惠券</div>
								<div class="order_tongji_right" style="display:none;"><span class="js-coupon-money"><?php echo $user_coupon['face_money'] + 0 ?></span>元</div>
							</dd>
							<?php
							$coupon_money = 0;
							$coupon_id = 0;
							foreach ($user_coupon_list as $key => $user_coupon) {
								$class = '';
								if ($key == 0) {
									$class = 'order_curn';
									$coupon_money = $user_coupon['face_money'] + 0;
									$coupon_id = $user_coupon['id'];
								}
							?>
								<dd class="clearfix js-youhui" data-coupon_id="<?php echo $user_coupon['id'] ?>" style="cursor:pointer;">
									<div class="order_tongji_left"><span class="<?php echo $class ?>"></span><?php echo htmlspecialchars($user_coupon['cname']) ?></div>
									<div class="order_tongji_right "><span class="js-coupon-money"><?php echo $user_coupon['face_money'] + 0 ?></span>元</div>
								</dd>
							<?php 
							}
							?>
						</dl>
					<?php
					}
					?>
				</div>
			<?php 
			}
			?>
		</div>
		<div class="order_tijiao clearfix">
			<form name="" method="post" action="<?php echo url('order:address', array('order_id' => option('config.orderid_prefix') . $order['order_no'])) ?>" id="cart_add_form">
				<input type="hidden" name="comment" id="comment" value="" />
				<input type="hidden" name="address_id" id="express_address_id" value="" />
				<input type="hidden" name="shipping_method" id="shipping_method" value="express" />
				<input type="hidden" name="selffetch_id" id="selffetch_id" value="" />
				<input type="hidden" name="address_user" id="address_user" value="" />
				<input type="hidden" name="address_tel" id="address_tel" value="" />
				<input type="hidden" name="address_time" id="address_time" value="" />
				<input type="hidden" id="total_money" value="<?php echo $total_money ?>" />
				<input type="hidden" id="order_no" value="<?php echo option('config.orderid_prefix') . $order['order_no'] ?>" />
				<input type="hidden" id="postage" value="<?php echo $is_postage ?>" />
				<input type="hidden" name="coupon_id" id="coupon_id" value="<?php echo $coupon_id ?>" />
				<input type="hidden" name="payment_method" id="payment_method" value="on" />
				<input type="hidden" name="provinceId" id="provinceId" value="" />
				<input type="hidden" name="cityId" id="cityId" value="" />
				<input type="hidden" name="areaId" id="areaId" value="" />
				<input type="hidden" name="address" id="address_friend" value="" />
				<input type="hidden" name="postage_friend" id="postage_friend" value="" />
				<div class="tijiao_txt">
					<div  class="tijiao_txt_l">实付款:</div>
					<div  class="tijiao_txt_c">￥<span id="J_total_money"><?php echo $total_money ?></span></div>
					<div  class="tijiao_txt_r">
						<span id="J_payTotalFee"><?php echo $order['float_amount'] > 0 ? $order['sub_total'] + $order['float_amount'] : $order['sub_total'] ?></span>元 + 运费：<span id="J_postage">0</span>元
						<?php 
						if ($reward_money) {
						?>
						<span id="J_reward">- <span id="J_reward_money"><?php echo $reward_money ?></span>元满减优惠</span>
						<?php 
						}
						if ($is_postage) {
						?>
							<span id="J_reward_postage">- <span id="J_reward_postage_money">0</span>元邮费</span>
						<?php
						}
						if ($coupon_money) {
						?>
							<span id="J_coupon">- <span id="J_coupon_money"><?php echo $coupon_money ?></span>元优惠券</span>
						<?php
						}
						if ($order['float_amount'] < 0) {
						?>
							<span id="J_coupon">- 减免<span id="J_float_money"><?php echo abs($order['float_amount']) ?></span>元</span>
						<?php
						}
						?>
					</div>
					<span class="orangeBtn large enabled" id="cart_add_submit" style="margin:7px 10px 0 30px;">确认收货信息</span>
					<!-- <button class="js-address_submit">确认收货信息</button> -->
				</div>
			</form>
		</div>
	</div>
</div>
<?php include display( 'public:footer');?>
</body>
</html>
