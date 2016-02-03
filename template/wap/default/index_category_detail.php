<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>商品搜索</title>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/main.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/prop.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/category_detail.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/gonggong.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/fastclick.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/idangerous.swiper.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script>var keyword='<?php echo $keyword;?>',key_id='<?php echo $key_id;?>';</script>
		<script src="<?php echo TPL_URL;?>index_style/js/category_detail.js"></script>
		<script >
		$(function(){
			$(".toast").fadeTo(5000,0, function () {
				$(this).hide();
			});
			$(".s-combobox-input").val("");

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
	</head>
	<body>
		<!-- <div id="J_TmMobileHeader" class="tm-mobile-header mui-flex">
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
	          <a href="my_cart.php" target="_self"  class="category-cart">???</a>
	          <?php }?>
	        </div>
	    </div> -->
	    <header class="index-head" style="position:absolute;">
			<a class="logo" href="./index.php"><img src="<?php echo TPL_URL;?>images/danye_03.png" /></a>
			<div class="search J_search">
				<span class="js_product_search"></span><input placeholder="输入商品名" class="search_input s-combobox-input" />
			</div>
			<a href="./my.php" class="me"></a>
			<div id="J_toast" class="toast ">你可以在这输入商品名称</div>
		</header>
		<div class="wx_wrap" style="padding-top:60px;">
			<div id="searchResBlock">
				<div class="mod_fixed_wrapper mod_filter_fixed in" id="sortBlock">
					<div class="mod_filter">
						<div class="mod_filter_inner">
							<a href="javascript:" class="no_icon select" data-type="default" style="width:20%">默认</a>
							<a href="javascript:" data-type="price" data-mark="1" style="width:20%">价格<i class="icon_sort"></i></a>
							<a href="javascript:" class="state_switch" data-type="sale" style="width:20%">销量<i class="icon_sort_single"></i></a>
							<a href="javascript:" class="switch state_switch" data-type="listmode" style="width:20%"><i class="icon_switch"></i></a>
							<a href="javascript:" class="state_switch" data-type="prop" style="width:20%">筛选</a>
						</div>
					</div>
				</div>
				<div class="s_null hide" id="sNull01">
					<h5>抱歉，没有找到符合条件的商品。</h5>
				</div>
				<div class="s_found hide" id="sFound">
					<p class="found_tip_2">找到相关商品 <span id="totResult"></span> 件。</p>
				</div>
				<div class="mod_itemgrid hide" id="itemList"></div>
				<div class="wx_loading2"><i class="wx_loading_icon"></i></div>
				<div class="s_empty hide" id="noMoreTips">已无更多商品，您可以换一个关键字搜一下哦~</div>
			</div>
		</div>
		<?php include display('public_search');?>
	    <?php include display('public_menu');?>
	    <?php echo $shareData;?>

		<div class="sidebar-content" style="-webkit-transform-origin: 0px 0px 0px; opacity: 1; -webkit-transform: scale(1, 1); display:none;">
			<div class="sidebar-header">
				<div class="sidebar-header-right">
					<span class="sidebar-btn-reset J_search_reset" report-eventid="MFilter_Reset" report-eventparam="">
						重置
					</span>
					<span class="sidebar-btn-confirm J_search_prop" report-eventid="MFilter_Confirm" report-eventparam="">
						确定
					</span>
				</div>
			</div>
			<div class="sidebar-items-container">
				<div class="spacer44"></div>
				<ul class="sidebar-list sidebar-categories">
					<?php
					if (count($property_list['property_list']) > 0) {
						foreach ($property_list['property_list'] as $property) {
					?>
							<li class="">
								<a href="javascript:void(0);">
									<i class="arrow"></i>
									<span class="sort-of-brand"><?php echo $property['name'] ?></span>
									<small class="sort-of-brand">全部</small>
								</a>
								<div style="max-height:360px; overflow-y: auto;">
									<ul id="m_searchitem_2934" class="tab-con brand" style="display:none;">
										<li id="m_searchItembutton_2935" class="">
											<i class="tick"></i>
											<span>全部</span>
										</li>
										<?php
										if (!empty($property_list['property_value_list'][$property['pid']])) {
											foreach ($property_list['property_value_list'][$property['pid']] as $property_value) {
										?>
												<li data-prop_id="<?php echo $property_value['vid'] ?>" class="">
													<i class="tick"></i>
													<span data-prop_id="<?php echo $property_value['vid'] ?>"><?php echo $property_value['value'] ?></span>
												</li>
										<?php
											}
										}
										?>
									</ul>
								</div>
							</li>
					<?php
						}
					}
					?>
				</ul>
			</div>
		</div>
	</body>
</html>