<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>个人中心</title>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/my.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/fastclick.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
	</head>
	<body style="padding-bottom:70px;">
		<div class="wx_wrap">
			<div class="my_head">
				<img src="<?php echo getAttachmentUrl('images/default_ucenter.jpg', false);?>" style="width:100%;max-height:220px;display:block;margin:auto;"/>
				<!-- S 账户信息 -->
				<a class="my_user">
					<h5>尊敬的 <?php echo $wap_user['nickname'];?> ，<?php echo $time_tip;?></h5>
				</a>
				<!-- E 账户信息 -->
			</div>
			<!-- S 入口菜单 -->
			<div class="my_menu">
				<ul>
					<li class="tiao">
						<a href="./my_order.php" class="menu_1">全部订单</a>
					</li>
					<li class="tiao">
						<a href="./my_order.php?action=unpay" class="menu_2">待付款</a>
					</li>
					<li class="tiao">
						<a href="./my_order.php?action=unsend" class="menu_4">待发货</a>
					</li>
					<li class="tiao">
						<a href="./my_order.php?action=send" class="menu_3">已发货</a>
					</li>
					
				</ul>
			</div>
			<!-- E 入口菜单 -->

			<!-- S 入口列表 -->
			<ul class="my_list"> 
				<li class="tiao"><a href="./my_cart.php">我的购物车</a></li>
				<li class="tiao"><a href="./my_recently.php">我的浏览记录</a></li>
				<li class="hr"></li>
				<li class="tiao"><a href="./my_address.php">收货地址管理</a></li>
			</ul>
			<!-- E 入口列表 -->
			<!--div class="my_links">
				<a href="tel:4006560011" class="link_tel">致电客服</a>
				<a href="#" class="link_online">在线客服</a>
			</div-->
		</div>
		<div class="wx_nav">
			<a href="./index.php" class="nav_index">首页</a>
			<a href="./category.php" class="nav_search">分类</a>
			<a href="./weidian.php" class="nav_shopcart">店铺</a>
			<a href="./my.php" class="nav_me on">个人中心</a></div>
		<?php echo $shareData;?>
	</body>
</html>