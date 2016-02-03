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
			<div class="address_list" id="addressList">
				<?php
					if(!empty($address_list)){
						foreach($address_list as $value){
				?>
							<div class="address">
								<ul>
									<li><?php echo $value['province_txt'].$value['city_txt'].$value['area_txt'].$value['address'];?></li>
									<li><strong><?php echo $value['name'];?></strong> <?php echo $value['tel'];?></li>
									<li class="edit" data-id="<?php echo $value['address_id'];?>"><a href="javascript:;">编辑</a></li>
								</ul>
								<p class="act"  data-id="<?php echo $value['address_id'];?>"><span class="del">删除</span></p>
							</div>
				<?php
						}
					}
				?>
				<div class="address_list_link">
					<a href="./my_address.php?action=add" class="item item_new" id="new">新增收货地址</a>
				</div>
			</div>
		</div>
		<div class="wx_loading" id="wxloading" style="display:none;">
			<div class="wx_loading_inner">
				<i class="wx_loading_icon"></i>
				请求加载中...
			</div>
		</div>
		<?php echo $shareData;?>
	</body>
</html>