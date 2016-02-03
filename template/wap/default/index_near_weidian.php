<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>身边的微店</title>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/weidian.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/fastclick.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
		<script>
		var domain = '<?php echo $domain;?>';
		</script>
		<script src="<?php echo TPL_URL;?>index_style/js/near_weidian.js"></script>
	</head>
	<body style="background:#efefef;">
		<div class="WX_search" id="mallHead">
			<form action="" method="get" class="WX_search_frm" onsubmit="return false;" style="padding-left:10px;">
				<input type="search" class="WX_search_txt" id="topSearchTxt" placeholder="搜索全部微店"/>
				<a class="WX_search_clear" href="javascript:;" id="topSearchClear" style="display:none;">x</a>
			</form>
			<div class="WX_me">
				<a href="javascript:" id="topSearchbtn" class="WX_search_btn_blue" style="display:none;">搜索</a>
				<a href="javascript:" id="topSearchCbtn" class="WX_search_btn" style="display:none;">取消</a>
			</div>
		</div>
		<div class="wx_wrap wei_v2">
			<!--div class="wei_tab_box" id="divTabList">
				<div class="mod_fix">
					<div class="wei_tab">
						<a id="aFollowShopBtn" class="cur" href="javascript:;">身边的微店</a>
					</div>
				</div>
			</div-->
			<div id="divFollowShop" class="wei_tab_body" style="display:none;padding-top:7px;">
				<section class="wei_section">
					<div class="wei_row_msg" id="divEmptyFollow" style="display:none;">
						<div id="arroundErrorTip" style="display:none;"></div>
						<div class="btn_wrap" id="divRecommendShopBtn" style="display:none;">
							<a href="javascript:;" class="btn">查看推荐微店</a>
						</div>
					</div>
					<div id="divMyShopList" style="display:none;"></div>
				</section>
			</div>
			<div class="wx_loading2 hide"><i class="wx_loading_icon"></i></div>
		</div>
	</body>
</html>