<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title><?php if(!$is_weixin){echo $config['site_name'];}else{echo '商品分类';} ?></title>
		<meta name="format-detection" content="telephone=no"/>
		<meta content="width=640, target-densitydpi=320, user-scalable=0" name="viewport" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/index.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<?php if(!$is_weixin){ ?><div class="header top_header"><?php echo $config['site_name'];?></div><?php } ?>
			<div class="category-block">
				<ul id="category-slide-box">
					<li class="c-box">
						<ul class="category-row">
							<?php 
								if($cat_list){
									foreach($cat_list as $value){
							?>
										<li><a href="./category.php?id=<?php echo $value['cat_id'];?>"><img src="<?php echo $config['site_url'];?>/upload/category/<?php echo $value['cat_pic'];?>"/><h2><?php echo $value['cat_name'];?></h2></a></li>
							<?php
									}
								}
							?>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<script type="text/javascript">
			window.addEventListener("pageshow",function(){if(window.screen.width>0&&/android\s4/.test(navigator.userAgent.toLowerCase())){var c,b,a;a=window.screen.width;if(a>0){if(a<320){c=120}else{if(a<480){c=160}else{if(a<640){c=240}else{if(a<960){c=320}else{if(a<1280){c=480}else{c=640}}}}}}b=640*c/a;var d=document.querySelector("meta[name=viewport]").getAttribute("content").match(/target-densitydpi=([^,]*),/);if(d&&Math.abs(b-d[1])>3){document.querySelector("meta[name=viewport]").setAttribute("content","width=640, target-densitydpi="+b+", user-scalable=0")}}},false);
		</script>
	</body>
</html>