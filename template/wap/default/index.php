<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>首页</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/main.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/index.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/fastclick.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.waterfall.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/idangerous.swiper.min.js"></script>
		<script>var noCart=true;</script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/js/index.js"></script>
	</head>
	<body style="padding-bottom:50px;background-color:#f7f7f7;min-width:320px;max-width:640px;margin:0 auto;">
		<div class="wx_wrap">
	      <div id="J_TmMobileHeader" class="tm-mobile-header mui-flex">
	        <div class="category-menu cell fixed">
	          <a href="category.php" target="_self" id="J_CategoryTrigger" class="category-trigger">????</a>
	        </div>
	        <div id="J_MobileSearch" class="mobile-search cell">
	          <form id="J_SearchForm" action="" method="post" onsubmit="return false;">
	            <div class="s-combobox-input-wrap">
	              <input placeholder="搜索商品" name="q" value="" class="search-input" type="search" accesskey="s" autocomplete="off">
	            </div>
	            <input type="submit" class="search-button">
	          </form>
	        </div>
	        <div class="my-info cell fixed">
	          <?php if(empty($wap_user)){?>
	          <a href="login.php" target="_self"  class="my-info-trigger">登录</a>
	          <?php }else{?>
	          <a href="my.php" target="_self"  class="category-my">???</a>
	          <?php }?>
	        </div>
	      </div>
			<div class="container" style="background-color:<?php if($homePage['bgcolor']){ echo $homePage['bgcolor']; }else{ echo '#f3f3f3'; }?>;">
				<div class="content" style="margin-top:0px;margin-bottom:0px;width:auto;min-width:320px;max-width:640px;">
					<div class="content-body" style="width:auto;min-width:320px;max-width:640px;border:none;">
						<?php if($homeCustomField){ foreach($homeCustomField as $value){echo $value['html'];} } ?>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public_search');?>
    	<?php include display('public_menu');?>
    	<?php echo $shareData;?>
	</body>
</html>