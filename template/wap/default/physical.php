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
		<?php if($is_weixin){ ?>
			<title>线下门店</title>
		<?php }else{ ?>
			<title>线下门店 - <?php echo $now_store['name'];?></title>
		<?php } ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/offline_shop.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.waterfall.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/idangerous.swiper.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<?php
					if($store_physical){
						foreach($store_physical as $value){
				?>
							<div class="block block-order">
								<div class="store-header header">
									<span>店铺：<?php echo $value['name'];?></span>
								</div>
								<hr class="margin-0 left-10"/>
								<div class="name-card name-card-3col name-card-store clearfix">
									<a href="javascript:;" class="thumb js-view-image-list">
										<?php foreach($value['images_arr'] as $image_key=>$image_arr){ ?>
											<img class="js-view-image-item <?php if($image_key != 0){ echo 'hide';}?>" src="<?php echo $image_arr?>"/>
										<?php } ?>
									</a>
									<a href="tel:<?php if($value['phone1']){ echo $value['phone1'];}?><?php echo $value['phone2'];?>"><div class="phone"></div></a>
									<a class="detail" href="./physical_detail.php?id=<?php echo $value['pigcms_id'];?>">
										<h3><?php echo $value['province_txt'];?><?php echo $value['city_txt'];?><?php echo $value['county_txt'];?> <?php echo $value['address'];?></h3>
										<?php if($value['business_hours']){ ?><p class="c-gray-dark ellipsis" style="margin-top:5px">营业时间：<?php echo $value['business_hours'];?></p><?php } ?>
									</a>
								</div>
								<?php if($value['description']){ ?>
									<hr/>
									<div class="name-card-bottom c-gray-dark">商家推荐：<?php echo $value['description'];?></div>
								<?php } ?>
							</div>
				<?php
						}
					}
				?>
			</div>
			<?php include display('footer');?>
		</div>
		<?php if($is_weixin){ ?>
			<script>
				$('.js-view-image-list').click(function(){
					var t = [];
					$.each($(this).find('.js-view-image-item'),function(i,item){
						t[i] = $(item).attr('src');
					});
					var i = t[0];
					window.WeixinJSBridge && window.WeixinJSBridge.invoke("imagePreview",{current:i,urls:t});
				});
			</script>
		<?php } ?>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>