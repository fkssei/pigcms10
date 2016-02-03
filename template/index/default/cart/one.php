<?php if(!defined( 'PIGCMS_PATH')) exit( 'deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>购物车-<?php echo $config['seo_title'] ?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link rel="icon"  href="favicon.ico" type="image/x-icon" />
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet" />
<link href="<?php echo TPL_URL;?>css/cart.css" type="text/css" rel="stylesheet" />
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.form.min.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script src="<?php echo TPL_URL;?>js/cart.js"></script>

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
	<div class="Breadcrumbs"> 您的位置：<a href="/">首页</a> &gt; <a href="<?php echo url('account:index') ?>">会员中心</a> &gt; <a href="<?php echo url('account:order') ?>" class="current">我的订单</a> </div>
	<div class="steps six_steps">
		<ul class="part2">
			<li class="first"><hr /></li>
			<li class="icon"><span class="yellow_30_30"></span></li>
			<li class="cur_last"><hr /></li>
			<li class="cur_last grey_line"><hr /></li>
			<li class="icon"><span class="grey_30_30"></span></li>
				<li class="cur_last grey_line"><hr /></li>	<li class="cur_last grey_line"><hr /></li> 
			<li class="icon"><span class="grey_30_30"></span></li>
			<li class="grey_line"><hr /></li>
		</ul>
		<ul class="part3">
			<li><span>购物车</span><br /></li>
			<li><span class="no_rea">确认收货地址</span><br /></li>
			<li><span class="no_rea">支付</span><br /></li>
		</ul>
	</div>
	<div class="b-wrapper">
		<div class="main-body">
			<div class="cart-wrapper clearf">
				<form name="" id="cart_form" action="<?php echo url('cart:two') ?>" method="post">
					<table class="order-table" id="J_OrderTable">
						<colgroup>
						<col class="baobei">
						<col class="status">
						<col class="price">
						<col class="quantity">
						<col class="amount">
						<col class="operate">
						</colgroup>
						<thead>
							<tr class="order_list_head clearfix">
								<th class="first">宝贝信息</th>
								<th> 型号</th>
								<th> 单价</th>
								<th> 数量</th>
								<th> 小计 </th>
								<th class="last"> 操作 </th>
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach ($cart_store_list as $key => $cart_list) {
							?>
								<tr class="sep-row">
									<td colspan="6"></td>
								</tr>
								<tr class="order-hd order-hd-nobg bright">
									<td colspan="6">
										<div class="shop-detail-top-attrs">
											<span class="shop-detail-title">
												<input class="store_check" type="checkbox" value="<?php echo $key ?>" data-store-id="<?php echo $key ?>" />
												<a href="<?php echo url_rewrite('store:index', array('id' => $key)) ?>" target="_blank"><?php echo $store_name_list[$key] ?></a>
											</span>
										</div>
									</td>
								</tr>
								<?php 
								foreach ($cart_list as $cart) {
								?>
								<tr class="order-bd cart_list_<?php echo $key ?> js-order-detail">
									<td class="baobei">
										<label class="cart-chk">
											<input type="checkbox" name="id[]" class="j_cartItem" data-store-id="<?php echo $key ?>" value="<?php echo $cart['pigcms_id'] ?>" />
										</label>
										<a target="_blank" title="查看宝贝详情" href="<?php echo url_rewrite('goods:index', array('id' => $cart['product_id'])) ?>" class="pic">
											<img src="<?php echo $cart['image'] ?>" width="50">
										</a>
										<div class="desc">
											<p>
												<a class="cart-title" target="_blank" title="<?php echo htmlspecialchars($cart['name']) ?>" href="<?php echo url_rewrite('goods:index', array('id' => $cart['product_id'])) ?>">
													<?php echo htmlspecialchars($cart['name']) ?>
												</a>
											</p>
										</div>
									</td>
									<td class="status" rowspan="1">
										<p>
											<?php
											if (!empty($cart['sku_data'])) {
												foreach ($cart['sku_data'] as $sku) {
													echo $sku['name'] . ':' . $sku['value'] . '<br />';
												}
											} else {
												echo '-';
											}
											?>
										</p>
									</td>
									<td class="price"><i><?php echo $cart['pro_price'] ?></i></td>
									<td class="quantity">
										<span class="buyNum" data-cart-id="<?php echo $cart['pigcms_id'] ?>">
											<span class="reduce" id="reduce"></span>
											<span class="add" id="add"></span>
											<input type="text" class="buyNumInput" id="buyNumInput" name="amout" value="<?php echo $cart['pro_num'] ?>" data-product_id="<?php echo $cart['pigcms_id'] ?>" data-price="<?php echo $cart['pro_price'] ?>" old_value="<?php echo $cart['pro_num'] ?>" maxlength="8" />
											<span class="j_numError num_error"> ！超出购买上限 </span>
										</span>
									</td>
									<td class="ammout" rowspan="1">
										<b class="orange yen"> ¥</b>
										<b class="orange j_itemTotal" id="product_price_total_<?php echo $cart['pigcms_id'] ?>"><?php echo $cart['pro_price'] * $cart['pro_num'] ?></b>
									</td>
									<td class="operate" rowspan="1">
										<a href="javascript:;" class="j_cartDel" data-cart-id="<?php echo $cart['pigcms_id'] ?>">删除 </a>
									</td>
								</tr>
							<?php
								}
							}
							?>
							<tr class="sep-row">
								<td colspan="6"></td>
							</tr>
							<style>
							.order-hd-bottom .disabled {background:gray;}
							</style>
							<tr class="order-hd">
								<td colspan="6" class="heji">
									<span>
										<label class="cart-chk-not">
									</span>
									<span>
										<a class="cart-del j_cartDelAll" href="javascript:;">清空购物车</a>
									</span>
									<div class="order-hd-bottom">
										<span>共 <b class="cart-nums"> <?php echo $total ?></b> 件 </span>
										<span> 合计 <i> ( 不含运费 ) </i>  ： </span>
										<span class="cart-allPrice"> &yen; <?php echo $total_money ?> </span>
										<a href="javascript:;" class="cart-go j_cartGo" style="visibility:visible">结算</a>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<?php include display( 'public:footer');?>
</body>
</html>
