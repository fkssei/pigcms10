<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>店铺</title>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/main.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/weidian.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/gonggong.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/fastclick.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
		<script>
		var sonCatStoreList = '<?php echo json_encode($son_cat_store_list);?>';
		$(function(){
			$(".toast").fadeTo(5000,0, function () {
				$(this).hide();
			});
			$(".s-combobox-input").val("");

			$('.s-combobox-input').keyup(function(e){
				var val = $.trim($(this).val());
				if(e.keyCode == 13){
					if(val.length > 0){
						window.location.href = './category.php?keyword='+encodeURIComponent(val);
					}else{
						motify.log('请输入搜索关键词');
					}
				}
				$('.j_PopSearchClear').show();
			});
			$(".js_product_search").click(function () {
				var val = $.trim($(".s-combobox-input").val());
				if (val.length == 0) {
					return;
				} else {
					window.location.href = './category.php?keyword='+encodeURIComponent(val);
				}
			});
		})
		</script>
		<script src="<?php echo TPL_URL;?>index_style/js/weidian.js"></script>
	</head>
	<body style="padding-bottom:50px;">
		<header class="index-head" style="position:absolute;">
			<a class="logo" href="./index.php"><img src="<?php echo TPL_URL;?>images/danye_03.png" /></a>
			<div class="search J_search">
				<span class="js_product_search"></span><input placeholder="输入商品名" class="search_input s-combobox-input" />
			</div>
			<a href="./my.php" class="me"></a>
			<div id="J_toast" class="toast ">你可以在这输入商品名称</div>
		</header>
		<!--    <div id="J_TmMobileHeader" class="tm-mobile-header mui-flex">
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
	          	<a href="index.php" target="_self" class="category-index">???</a>
			</div>
	      </div> -->
		<div class="wx_wrap wei_v2" style="padding-top:60px;">
			<div class="wei_tab_box" id="divTabList">
				<div class="mod_fix">
					<div class="wei_tab">
						<a id="aRecommendShopBtn" class="cur" href="javascript:;">推荐微店</a>
						<a id="aFollowShopBtn" href="javascript:;">身边的微店</a>
					</div>
				</div>
			</div>
			<div id="divRecommendShop" class="wei_tab_body">
				<?php
					if(!empty($sale_category_list)){
						foreach($sale_category_list as $value){
				?>
							<section class="wei_section">
								<div class="wei_section_title">
									<h2><?php echo $value['name'];?></h2>
									<span><?php echo $value['desc'];?></span>
								</div>
								<?php if(!empty($value['cat_list'])){ ?>
									<div class="wei_tag_box">
										<?php foreach($value['cat_list'] as $cat_key=>$cat_value){ ?>
											<a href="javascript:;" data-index="<?php echo $cat_value['cat_id'];?>" <?php if($cat_key==0){ ?>class="cur"<?php } ?>><span><?php echo $cat_value['name'];?></span></a>
										<?php } ?>
									</div>
								<?php } ?>
								<div class="wei_shop_list">
									<?php
										if(!empty($value['store_list'])){
											foreach($value['store_list'] as $store_value){
									?>
												<div class="item">
													<a href="<?php echo $store_value['url'];?>" class="url">
														<div class="img">
															<img src="<?php echo $store_value['logo'];?>">
														</div>
														<div class="info">
															<div class="name"><?php echo $store_value['name'];?></div>
														</div>
													</a>
												</div>
									<?php
											}
										}else if(!empty($value['cat_list'][0]['store_list'])){
											foreach($value['cat_list'][0]['store_list'] as $store_value){
									?>
												<div class="item">
													<a href="<?php echo $store_value['url'];?>" class="url">
														<div class="img">
															<img src="<?php echo $store_value['logo'];?>">
														</div>
														<div class="info">
															<div class="name"><?php echo $store_value['name'];?></div>
														</div>
													</a>
												</div>
									<?php
											}
										}
									?>
								</div>
							</section>
				<?php
						}
					}
				?>
			</div>
			<div id="divFollowShop" class="wei_tab_body" style="display:none;">
				<section class="wei_section">
					<div class="wei_row_msg" id="divEmptyFollow">
						<div id="arroundErrorTip" style="display:none;"></div>
						<div class="btn_wrap" id="divRecommendShopBtn" style="display:none;">
							<a href="javascript:;" class="btn" ptag="37529.3.1">查看推荐微店</a>
						</div>
					</div>
					<div id="divMyShopList" style="display:none;"></div>
				</section>
			</div>
			<div class="wx_loading2 hide"><i class="wx_loading_icon"></i></div>
		</div>
		<?php include display('public_menu');?>
		<?php echo $shareData;?>
	</body>
</html>