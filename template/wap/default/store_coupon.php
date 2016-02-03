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
		<title></title>优惠券 - <?php echo $now_store['name'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/customer.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<?php if($is_mobile){ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
		<?php }else{ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css"/>
		<?php } ?>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/coupon.css"/>

		<script src="<?php echo $config['site_url'];?>/static/js/fastclick.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/layer_mobile/layer.m.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/store_coupon.js"></script>
		<style>
			.promote-card-list .curr_li{height: auto}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<!-- ▼顶部通栏 -->
				<div class="js-mp-info share-mp-info">
					<a class="page-mp-info" href="<?php echo $now_store['url'];?>">
						<img class="mp-image" width="24" height="24" src="<?php echo $now_store['logo'];?>" alt="<?php echo $now_store['name'];?>"/>
						<i class="mp-nickname"><?php echo $now_store['name'];?></i>
					</a>
					<div class="links">
						<a class="mp-homepage" href="<?php echo $now_store['ucenter_url'];?>">我的记录</a>
					</div>
				</div>
				<!-- ▲顶部通栏 -->

				<div class="block block-coupon-list block-list2 block-no-background">
					<div class="mod_itemgrid hide" id="itemList"></div>


					<div class="hproduct">
						<ul class="promote-card-list">

						</ul>
					</div>
						<input type="hidden" id="button_store_id" value="<?php echo $store_id;?>">
						<div class="wx_loading2"><i class="wx_loading_icon"></i></div>

						<div class="empty-list" style="margin-top:40px;display: none">
							<div>
								<span class="font-size-16 c-black">神马，我还没有券？</span>
							</div>
							<div>
								<span class="font-size-12">怎么能忍？</span>
							</div>
							<div><a href="<?php echo $now_store['url'];?>" class="tag tag-big tag-orange" style="padding:8px 30px;">马上去领取</a></div>
						</div>
					<div class="s_empty" id="noMoreTips">已无更多优惠券！</div>


				</div>
			</div>
			<?php include display('footer');?>
		</div>
	</body>
</html>