<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>商品搜索</title>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/category.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/main.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/gonggong.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/fastclick.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/idangerous.swiper.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/js/category.js"></script>
		<script >
		$(function(){
			$(".toast").fadeTo(5000,0, function () {
				$(this).hide();
			});
			$(".s-combobox-input").val("");

			$(".js_product_search").click(function () {
				var val = $.trim($(".s-combobox-input").val());
				if (val.length == 0) {
					return;
				} else {
					window.location.href = './category.php?keyword='+encodeURIComponent(val);
				}
			});
		})
		</script>
	</head>
	<body>
<header class="index-head">
	<a class="logo"  href="./index.php"><img src="<?php echo TPL_URL;?>images/danye_03.png" /></a>
	<div class="search J_search">
		<span class="js_product_search"></span><input placeholder="输入商品名" class="search_input s-combobox-input" />
	</div>
	<a href="./my.php" class="me"></a>
	<div id="J_toast" class="toast ">你可以在这输入商品名称</div>
</header>
<div class="footerheight" style="clear:both; width:100%; height:60px;"></div>
		<div class="wx_loading2"><i class="wx_loading_icon"></i></div>
		<div class="wx_wrap" style="display:none">
			<div id="yScroll1" style="overflow:hidden;position:absolute;top:60px;left:0;width:76px;background-color:#f3f3f3;">
				<div class="swiper-container">
					<ul class="category1 swiper-wrapper" id="allcontent" style="border-bottom:none;"></ul>
				</div>
			</div>
			<div id="yScroll2" style="overflow:hidden;position:absolute;top:60px;left:76px;">
				<div class="swiper-container2" style="padding:0 10px 10px 10px;">
					<dl class="category2 swiper-wrapper" id="category2"></dl>
				</div>
			</div>
		</div>
		<?php include display('public_search');?>
		<?php include display('public_menu');?>
		<?php echo $shareData;?>
	</body>
</html>