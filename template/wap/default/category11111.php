<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title><?php echo $now_cat['cat_name'];?></title>
		<meta name="format-detection" content="telephone=no"/>
		<meta content="width=640, target-densitydpi=320, user-scalable=0" name="viewport" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/category.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/fastclick.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/idangerous.swiper.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/category.js"></script>
	</head>
	<body>
		<div id="pagebox">		
			<header id="header-box" style="width:640px;height:<?php if($two_cat_list){echo '160';}else{echo '80';}?>px;margin:0px auto;overflow:hidden;display:block;">
				<div style="width:640px;position:fixed;z-index:300;top:0;background:#fff;">
					<div id="header" class="details-head">
						<div id="title-text" class="menunav"><?php echo $now_cat['cat_name'];?><span class="caret"></span>
							<ul id="cate_list" class="dropdown-menu">
								<li><a href="<?php echo $config['wap_site_url'];?>">首页</a></li>
								<?php 
									if($first_cat_list){
										foreach($first_cat_list as $value){
								?>
											<li><a href="./category.php?id=<?php echo $value['cat_id'];?>" <?php if($value['cat_id'] == $now_cat['cat_id']){echo 'class="cur"';}?>><?php echo $value['cat_name'];?></a></li>
								<?php
										}
									}
								?>
							</ul>
						</div>
						<a href="javascript:history.back();" title="返回" rel="nofollow" class="details-back-button" style="display: block;"> </a>
						<div class="top-search"></div>
					</div>
					<?php if($two_cat_list){ ?>					
						<div id="swiper-container" style="overflow:hidden;">
							<ul id="nav" class="nav-list swiper-wrapper" style="display:block;width:640px;">
								<li class="swiper-slide current" data-id="0">全部</li>
								<?php foreach($two_cat_list as $value){ ?>
											<li class="swiper-slide" data-id="<?php echo $value['cat_id'];?>"><?php echo $value['cat_name'];?></li>
								<?php } ?>
							</ul>
						</div>
					<?php } ?>
				</div>
			</header>
			<ul id="pic-main" style="margin-top:20px" class="pic-list2">
				<?php
					if($product_list){
						foreach($product_list as $value){
				?>
					<li data-id="<?php echo $value['product_id']?>">
						<?php if($value['original_price'] != '0.00' && $value['original_price'] > $value['price']){ ?>
							<div class="preference-zeke">
								<span><?php echo round($value['price']/$value['original_price']*10,1);?>折</span>
							</div>
						<?php } ?>
						<a style="background:url(<?php echo $value['image'] ?>) no-repeat center center;background-size:cover" title="<?php echo $value['name'];?>" href="./good.php?id=<?php echo $value['product_id']?>"></a>
						<h4 class="shop-title"><span class="orange"></span><?php echo $value['name'];?></h4>
						<div class="item-nav-info">
							<div>￥<?php echo floatval($value['price']);?><?php if($value['original_price']!='0.00'){ ?><span class="oldprice">￥<?php echo floatval($value['original_price']);?></span><?php } ?></div>
                            <?php if($value['sales']){ ?><div>销量<?php echo $value['sales'];?></div><?php } ?>
                            </div>
					</li>
				<?php 
						}
					}
				?>
			</ul>
		</div>
		<script type="text/javascript">
			window.addEventListener("pageshow",function(){if(window.screen.width>0&&/android\s4/.test(navigator.userAgent.toLowerCase())){var c,b,a;a=window.screen.width;if(a>0){if(a<320){c=120}else{if(a<480){c=160}else{if(a<640){c=240}else{if(a<960){c=320}else{if(a<1280){c=480}else{c=640}}}}}}b=640*c/a;var d=document.querySelector("meta[name=viewport]").getAttribute("content").match(/target-densitydpi=([^,]*),/);if(d&&Math.abs(b-d[1])>3){document.querySelector("meta[name=viewport]").setAttribute("content","width=640, target-densitydpi="+b+", user-scalable=0")}}},false);
		</script>
	</body>
</html>