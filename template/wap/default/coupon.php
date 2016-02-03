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
		<title>我的优惠券 - <?php echo $now_store['name'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/customer.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<style>
			.promote-card-list .curr_li{height: auto}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="tabber tabber-n4 tabber-double-11 clearfix">
					<a href="./cart.php">购物车</a>
					<a class="active" href="./coupon.php">优惠券</a>
					<a href="./trade.php">购物记录</a>
					<a href="./back.php">我的返现</a>
				</div>
				<div class="block block-border-none">
					<div class="tabber  tabber-ios clearfix">
						<a <?php if($action=='all'){ ?>class="active"<?php } ?> href="./coupon.php">全部</a>
						<a <?php if($action=='unused'){ ?>class="active"<?php } ?> href="./coupon.php?action=unused">即将过期</a>
					</div>
				</div>
                <div class="block block-coupon-list block-list2 block-no-background">
					<div class="empty-list" style="margin-top:40px;">
						<div>
							<span class="font-size-16 c-black">神马，我还没有券？</span>
						</div>
						<div>
							<span class="font-size-12">怎么能忍？</span>
						</div>
						<div><a href="<?php echo $now_store['url'];?>" class="tag tag-big tag-orange" style="padding:8px 30px;">马上去领取</a></div>
					</div>
				</div>
			</div>
			<?php include display('footer');?>
		</div>
	</body>
</html>