<?php if(!defined( 'PIGCMS_PATH')) exit( 'deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>购物车-<?php echo $config['seo_title'] ?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/public.css">
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/cart.css" />
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script src="<?php echo $config['site_url'];?>/static/js/area/area.min.js"></script>
<script type="text/javascript" src="./static/js/jquery.form.min.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script src="<?php echo TPL_URL;?>js/cart_two.js"></script>
</head>

<body>
	<!-- mod-mini-nav Begin -->
	<?php include display( 'public:cart_header');?>
	<!-- mod-mini-nav End -->
	<div id="fmx_tags" style="position:absolute;left:-9999px;"></div>
	<div class="main">
		<div class="main-body clearf">
			<div class="buyer-info" id="buyerInfo">
				<div id="J_AddressListContainer"  >
					<p class="title">
						<b>选择收货人信息</b>
					</p>
					<table class="address-table" id="J_AddressTable">
						<colgroup>
							<col class="name" />
							<col class="address" />
							<col class="phone" />
							<col class="operate" />
						</colgroup>
						<tbody id="J_AddressList">
							<?php 
							foreach ($user_address_list as $key => $tmp) {
							?>
								<tr id="address_<?php echo $tmp['address_id'] ?>" class="current" >
									<td class="name"><input type="radio" name="defaultRadio" value="<?php echo $tmp['address_id'] ?>" <?php echo $tmp['default'] == 1 || $key == 0 ? 'checked="checked"' : '' ?>  /> <?php echo htmlspecialchars($tmp['name']) ?></td>
									<td class="address"><?php echo $tmp['province_txt']?><?php echo $tmp['city_txt'] ?><?php echo $tmp['area_txt'] ?><?php echo htmlspecialchars($tmp['address']) ?></td>
									<td><?php echo $tmp['tel'] ?></td>
									<td>
										<a href="javascript:void(0)" class="e-modify" data_id="<?php echo $tmp['address_id'] ?>" data_name="<?php echo htmlspecialchars($tmp['name']) ?>" data_province="<?php echo $tmp['province'] ?>" data_city="<?php echo $tmp['city'] ?>" data_area="<?php echo $tmp['area'] ?>" data_tel="<?php echo $tmp['tel'] ?>" data_address="<?php echo htmlspecialchars($tmp['address']) ?>" data_default="<?php echo $tmp['default'] ?>">修改</a><span class="cut">|</span><a href="javascript:void(0)" data-address-id="<?php echo $tmp['address_id'] ?>" class="e-delete">删除</a>
									</td>
								</tr>
							<?php 
							}
							?>
						</tbody>
						<tr class="add-address">
							<td class="name">
								<input type="radio" name="defaultRadio" value="default" />使用新地址
								</td>
							<td class="special" colspan="3">
							</td>
						</tr>
					</table>
				</div>
				<div id="J_AddressEditContainer"  class="none" style="display:none;">
					<p class="title">
						<b id="J_Title">收货人信息</b>
						<span class="e-remark">(注：<span class="red">*</span> 为必填项) </span>
						<span class="modifyBtn" id="editBuyerInfo">[修改]</span>
					</p>
					<form name="address" id="address_add" method="post" action="<?php echo url('account:address') ?>">
						<table id="buyerInfoTable">
							<tr>
								<td style="padding-right: 20px;"><span class="red">*</span> 收货人姓名：</td>
								<td>
									 <input name="name" id="name" class="inputText" type="text" maxlength="12" />
									<span class="v_error"></span>
								</td>
							</tr>
							<tr>
								<td><span class="red">*</span> 手 机 号 码：</td>
								<td>
									<input name="tel" id="tel" class="inputText" type="text" maxlength="11"/>
									<span class="v_error"></span>
									<span class="none" id="J_PhoneTips">请填写您的常用手机号码！</span>
								</td>
							</tr>
							<tr>
								<td><span class="red">*</span> 地<span style="margin-left: 43px;">区</span>：</td>
								<td>
									<div id="addressPanel">
										<select name="province" id="provinceId_m" data-province="">
											<option>省份</option>
										</select>
										<select name="city" id="cityId_m" data-city="">
											<option>城市</option>
										</select>
										<select name="area" id="areaId_m" data-area="">
											<option>区县</option>
										</select>
										<span class="v_error"></span>
									</div>
								</td>
							</tr>
							<tr>
								<td><span class="red">*</span> 街 道 地 址：</td>
								<td class="jiedaodizhi">
									<textarea id="jiedao" name="address" maxlength="120" class="jiedao inputText"  placeholder="不需要重复填写省市区，必须大于10个字，小于120个字"></textarea>
									<span class="v_error"></span>
								</td>
							</tr>
							<tr>
								<td class="col1"></td>
								<td>
									<input id="isDefault" name="default" checked="checked" type="checkbox" value="1" /> <label for="isDefault">设置为默认地址</label>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<a class="orangeBtn large" style="margin-right:30px;margin-top: 25px;width:120px;" href="javascript:void(0)" id="checkBuyerInfo">保   存</a>
									<span id="errorBuyerInfoTable" class="v_error">请确认收货人信息并保存</span>
									<input type="hidden" id="address_id" name="address_id" value="" />
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<!-- 
			<div class="order-type-list">
				<p class="title"><b>在线支付</b></p>
				<div class="order-type clearfix" id="J_OrderType">
					<div class="pay-method-list pay-method-checked" style="border:0;">
						<label class="t1">
							<input type="radio" value="0" name="order_type" checked/>担保交易
						</label>
						<span class="inlineBlock pay-method-txt">
							微店提供担保，确认收货后才会打款给卖家。
							<b class="inlineBlock pay-method-tj">推荐</b>
						</span>
					</div>
				</div>
			</div>
			 -->
			<div class="item-info">
				<p  class="title"><strong>商品信息</strong></p>
				<table style="width: 905px;" class="tableBorder">
					<thead>
						<tr style="background: #e9e9e9;">
							<td width="30%">商 品</td>
							<td width="18%">型 号</td>
							<td width="18%">单价（元）</td>
							<td width="18%">数 量</td>
							<td style="text-align: right;padding-right: 20px;">小 计（元）</td>
						</tr>
					</thead>
					<tbody id="J_itemTbody">
						<?php 
						foreach ($user_cart_list as $tmp) {
						?>
							<tr style="background: #e9e9e9;">
								<td width="30%"><?php echo htmlspecialchars($tmp['product']['name']) ?></td>
								<td width="18%">
									<?php 
									if (!empty($tmp['sku_data'])) {
										foreach ($tmp['sku_data'] as $sku_data) {
											echo $sku_data['name'] . ':' . $sku_data['value'];
										}
									}
									?>
								</td>
								<td width="18%"><?php echo $tmp['pro_price'] ?></td>
								<td width="18%"><?php echo $tmp['pro_num']?></td>
								<td style="text-align: right;padding-right: 20px;"><?php echo $tmp['pro_price'] * $tmp['pro_num'] ?></td>
							</tr>
						<?php 
						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4" style="text-align: left">
								备  注：<input type="text" class="inputText" name="buyer_comment" maxlength="1024" style="width: 400px;" placeholder="给卖家留言"/>
							</td>
							<td style="text-align: right;padding-right: 20px;" id="J_expressFeeTd">

							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<!--1.4.15兼容单品下单-->
			<div class="pay-total">
				<form name="" method="post" action="<?php echo url('cart:three') ?>" id="cart_add_form">
					<?php
					foreach ($user_cart_list as $tmp) { 
					?>
						<input type="hidden" name="id[]" value="<?php echo $tmp['pigcms_id'] ?>" />
					<?php 
					}
					?>
					<input type="hidden" name="comment" value="" />
					<input type="hidden" name="address_id" value="" />
					应付总额：<strong style="color: #dd0f18;font-weight: bold" id="payTotal"> &yen; <span id="J_payTotalFee"><?php echo $total_money ?></span>元</strong>
					<span class="orangeBtn large enabled" id="cart_add_submit" style="margin:7px 10px 0 30px;" id="payButton">提交订单</span>
				</form>
			</div>
			<!--1.4.15兼容单品下单-->

			<input type="hidden" name="itemId" id="itemId"/>
			<input type="hidden" name="vsku_id" id="vsku_id"/>
			<input type="hidden" name="w" id="www"/>
			<input type="hidden" name="category" value="home"/>
			<input type="hidden" name="reqId" value=""/>
			<input type="hidden" name="provinceName" />
			<input type="hidden" name="cityName" />
			<input type="hidden" name="districtName" />
			<input type="hidden" name="cartIds" value="27130414" />

		</div>
	</div>
	<?php include display( 'public:footer');?>
</body>
</html>