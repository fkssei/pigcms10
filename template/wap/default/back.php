<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){ ?>responsive-320<?php }elseif($_GET['ps']>=540){ ?>responsive-540<?php }?> <?php if($_GET['ps']>540){ ?> responsive-800<?php } ?>" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>返现记录 - <?php echo $now_store['name'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/tuan.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="tabber tabber-n4 tabber-double-11 clearfix">
					<a href="./cart.php">购物车</a>
					<a href="./my_coupon.php">优惠券</a>
					<a href="./trade.php">购物记录</a>
					<a class="active" href="./back.php">我的返现</a>
				</div>
                <div id="backs-list-container" class="block" style="margin-top:20px;">
					<div class="empty-list" style="margin-top:30px;">
						<div>
							<h4>哎呀，还没返现？</h4>
							<p class="font-size-12">不落单一起团</p>
						</div>
						<div><a href="<?php echo $now_store['url'];?>" class="tag tag-big tag-orange" style="padding:8px 30px;">找返现</a></div>
					</div>
				</div>
			</div>
			<?php include display('footer');?>
			<?php echo $shareData;?>
		</div>
	</body>
</html>