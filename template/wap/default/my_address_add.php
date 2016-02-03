<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>收货地址</title>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/address.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/fastclick.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/area/area.min.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
		<style>.address_list ul:before{display:none;}</style>
		<script src="<?php echo TPL_URL;?>index_style/js/address.js"></script>
	</head>
	<body>
		<div class="wx_wrap">
			<div class="address_new">
				<p><label for="name"><span class="tit">收货人</span><input type="text" id="name" name="name" value="" placeholder="名字"/></label></p>
				<p><label for="mobile"><span class="tit">手机号码</span><input type="tel" id="mobile" name="mobile" value="" placeholder="手机号码"></label></p>
				<p><label for="provinceId"><span class="tit">省份</span><span><select id="provinceId_m" name="provinceId"></select></span></label></p>
				<p><label for="cityId"><span class="tit">市</span><span><select name="cityId" id="cityId_m"><option value="">城市</option></select></span></label></p>
				<p id="areaSelP"><label for="areaId"><span class="tit">区/县</span><span><select name="areaId" id="areaId_m"><option value="">区县</option></select></span></label></p>
				<p><label for="adinfo"><span class="tit">详细地址</span><input id="adinfo" name="adinfo" value="" type="text" placeholder="详细地址"></label></p>
				<p class="action"><button class="submit" id="add">确认</button></p>
			</div>
		</div>
		<?php echo $shareData;?>
	</body>
</html>