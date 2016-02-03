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
		<!--title>会员主页 - <?php echo $now_store['name'];?></title-->
		<title>会员主页</title>
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
	<body <?php if(!empty($storeNav)){ ?>style="padding-bottom:45px;"<?php } ?>>
		<div class="container">
			<div class="header">
				<?php if(!$is_mobile && $_SESSION['user']){ ?>
					<div class="headerbar">
						<div class="headerbar-wrap clearfix">
							<div class="headerbar-preview">
								<span>预览：</span>
								<ul>
									<li>
									   <a href="<?php echo $now_url;?>&ps=320" class="js-no-follow<?php if(empty($_GET['ps']) || $_GET['ps'] == '320') echo ' active';?>">iPhone版</a>
									</li>
									<li>
									   <a href="<?php echo $now_url;?>&ps=540" class="js-no-follow<?php if($_GET['ps'] == '540') echo ' active';?>">三星Note3版</a>
									</li>
									<li>
									   <a href="<?php echo $now_url;?>&ps=800" class="js-no-follow<?php if($_GET['ps'] == '800') echo ' active';?>">PC版</a>
									</li>
								</ul>
							</div>
							<div class="headerbar-reedit">
								<a href="<?php dourl('user:store:ucenter',array(),true);?>" class="js-no-follow">重新编辑</a>
							</div>
						</div>
					</div>
				<?php } ?>
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
			</div>
			<div class="content">
				<div class="content-body">
					<?php if($pageHasAd && $pageAdPosition == 0 && $pageAdFieldCon){ echo $pageAdFieldCon;}?>
					<!-- 等级/积分 -->
					<div class="custom-level">
						<img class="custom-level-img js-lazy" src="<?php echo $now_ucenter['bg_pic'];?>"/>
						<div class="custom-level-title-section js-custom-level-title-section">
							<h5 class="custom-level-title">
								<?php if(1 || $now_ucenter['show_level'] && $now_ucenter['show_point']){ ?>
								尊贵的 <?php echo !empty($_SESSION['wap_user']['nickname']) ? '<span style="color:green">' . $_SESSION['wap_user']['nickname'] . '</span>' : ''; ?> <span class="js-custom-level">会员</span><!-- <br/>您拥有本店积分： <span class="js-custom-point"><?php echo intval($storeUserData['point']);?></span> -->
								<?php }elseif($now_ucenter['show_level']){ ?>
									尊贵的 <?php echo !empty($_SESSION['wap_user']['nickname']) ? '<span style="color:green">' . $_SESSION['wap_user']['nickname'] . '</span>' : ''; ?> <span class="js-custom-level">会员</span>
								<?php }elseif(0 && $now_ucenter['show_level']){ ?>
									您拥有本店积分： <span class="js-custom-point"><?php echo intval($storeUserData['point']);?></span>
								<?php } ?>
							</h5>
						</div>
					</div>
					<div class="order-related">
						<ul class="uc-order list-horizon clearfix">
							<li>
								<a class="link clearfix" href="./order.php?id=<?php echo $now_store['store_id'];?>&action=unpay" target="_blank">
									<p class="title-num c-black font-size-16"><?php echo intval($storeUserData['order_unpay']);?></p>
									<p class="title-info c-black font-size-12">待付款</p>
								</a>
							</li>
							<li>
								<a class="link clearfix" href="./order.php?id=<?php echo $now_store['store_id'];?>&action=unsend" target="_blank">
									<p class="title-num c-black font-size-16"><?php echo intval($storeUserData['order_unsend']);?></p>
									<p class="title-info c-black font-size-12">待发货</p>
								</a>
							</li>
							<li>
								<a class="link clearfix" href="./order.php?id=<?php echo $now_store['store_id'];?>&action=send" target="_blank">
									<p class="title-num c-black font-size-16"><?php echo intval($storeUserData['order_send']);?></p>
									<p class="title-info c-black font-size-12">已发货</p>
								</a>
							</li>
							<li>
								<a class="link clearfix" href="./order.php?id=<?php echo $now_store['store_id'];?>&action=complete" target="_blank">
									<p class="title-num c-black font-size-16"><?php echo intval($storeUserData['order_complete']);?></p>
									<p class="title-info c-black font-size-12">已完成</p>
								</a>
							</li>
						</ul>
						<div class="block block-list list-vertical">
							<a class="block-item link clearfix icon-order" href="./order.php?id=<?php echo $now_store['store_id'];?>" target="_blank">
								<p class="title-info c-black font-size-14">全部订单</p>
							</a>
						</div>
						<div class="block block-list list-vertical">
							<a class="block-item link clearfix icon-present" href="./cart.php?id=<?php echo $now_store['store_id'];?>" target="_blank">
								<p class="title-info c-black font-size-14">我的购物车</p>
							</a>
							<a class="block-item link clearfix icon-coupon" href="./my_coupon.php?id=<?php echo $now_store['store_id'];?>" target="_blank">
								<p class="title-info c-black font-size-14">我的优惠券</p>
							</a>
							<a class="block-item link clearfix icon-record" href="./trade.php?id=<?php echo $now_store['store_id'];?>" target="_blank">
								<p class="title-info c-black font-size-14">我的购物记录</p>
							</a>
						</div>
                        <?php if ($drp_link) { ?>
						<div class="block block-list list-vertical">
							<a class="block-item link clearfix icon-taobao" href="<?php echo $drp_link_url; ?>" target="_blank">
								<p class="title-info c-black font-size-14">我的分销</p>
							</a>
						</div>
                        <?php } ?>
					</div>
					<?php 
						if($homeCustomField){
							foreach($homeCustomField as $value){
								echo $value['html'];
							}
						}
					?>
					<?php if($pageHasAd && $pageAdPosition == 1 && $pageAdFieldCon){ echo $pageAdFieldCon;}?>
				</div>
				<?php if(!$is_mobile){ ?>
				<div class="content-sidebar">
					<a href="<?php echo $now_store['url'];?>" class="link">
						<div class="sidebar-section shop-card">
							<div class="table-cell">
								<img src="<?php echo $now_store['logo'];?>" width="60" height="60" class="shop-img" alt="<?php echo $now_store['name'];?>"/>
							</div>
							<div class="table-cell">
								<p class="shop-name"><?php echo $now_store['name'];?></p>
							</div>
						</div>
					</a>
					<div class="sidebar-section qrcode-info">
						<div class="section-detail">
							<p class="text-center shop-detail"><strong>手机扫码访问</strong></p>
							<p class="text-center weixin-title">微信“扫一扫”分享到朋友圈</p>
							<p class="text-center qr-code">
								<img width="158" height="158" src="<?php echo $config['site_url'];?>/source/qrcode.php?type=ucenter&id=<?php echo $now_store['store_id'];?>"/>
							</p>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php if(!empty($storeNav)){ echo $storeNav;}?>
			</div>
			<?php include display('footer');?>
		</div>
	</body>
	<?php echo $shareData;?>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>