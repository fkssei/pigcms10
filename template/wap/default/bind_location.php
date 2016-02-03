<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){echo ' responsive-320';}elseif($_GET['ps']>=540){echo ' responsive-540';} if($_GET['ps']>540){echo ' responsive-800';} ?>" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title><?php echo $nowCategory['cat_name'];?> - <?php echo $now_store['name'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<?php if($is_mobile){ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
		<?php }else{ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css"/>
		<?php } ?>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.waterfall.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/idangerous.swiper.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
	</head>
	<body style="padding-bottom:45px;">
		<div style="height:300px;line-height:300px;text-align:center;">
			<a href="javascriopt:void(0);" style="color:#ff0000" id="my_location">点击获取我的位置</a>
		</div>
		<?php echo $shareData;?>
		<script>
		
			$(function(){
				wx.hideMenuItems({
				    menuList: [] // 要隐藏的菜单项，所有menu项见附录3
				});

				$('#my_location').click(function(){
					wx.getLocation({
					    timestamp: 0, // 位置签名时间戳，仅当需要兼容6.0.2版本之前时提供
					    nonceStr: '', // 位置签名随机串，仅当需要兼容6.0.2版本之前时提供
					    addrSign: '', // 位置签名，仅当需要兼容6.0.2版本之前时提供，详见附录4
					    success: function (res) {
					       var longitude = res.longitude; // 纬度，浮点数，范围为90 ~ -90
					       var latitude = res.latitude; // 经度，浮点数，范围为180 ~ -180。
					       var speed = res.speed; // 速度，以米/每秒计
					       var accuracy = res.accuracy; // 位置精度
					       alert(longitude);
					    }
					});
				});
			});
			
		</script>
	</body>
</html>