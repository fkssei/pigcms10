<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title><?php echo $config['site_name'];?></title>
	<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
	<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link rel="icon"  href="favicon.ico" type="image/x-icon">
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css">
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.lazyload.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/animate.css">
<script src="<?php echo TPL_URL;?>js/jquery.nav.js"></script>
<script src="<?php echo TPL_URL;?>js/distance.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>
<script src="<?php echo TPL_URL;?>js/myindex.js"></script>
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script src="<?php echo TPL_URL;?>js/index2.js"></script>

<!--[if lt IE 9]>
<script src="<?php echo TPL_URL;?>js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="<?php echo TPL_URL;?>js/DD_belatedPNG_0.0.8a.js" mce_src="<?php echo TPL_URL;?>js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<style type="text/css">
body{ behavior:url("csshover.htc");}
</style>
<![endif]-->
	<script>
		$(function() {
			$.get("index.php?c=index&a=user", function (data) {
				try {
					if (data.status == true) {

						var login_info = '<em>Hi，' + data.data.nickname + '</em>';
						login_info += '<a target="_top" href="index.php?c=account&a=logout" class="sn-register">退出</a>';
						$("#login-info").html(login_info);

						$("#header_cart_number").html(data.data.cart_number);
						
						if(ParesInt(data.data.cart_number)>99) {data.data.cart_number = "99";}
						
						$(".mui-mbar-tab-sup-bd").html(data.data.cart_number);
					}
				} catch (e) {

				}
			}, "json");

			if ($("#location_long_lat").length > 0) {
				$.getJSON("/index.php?c=index&a=ajax_loaction", function (data) {
					try {
						if (data.status == true) {
							$("#location_long_lat").html(data.msg);
							$("#location_long_lat").attr("title",data.msgAll[0]);
						}
					} catch(e) {
					}
				});
			}
		})
	</script>

<style>
.content .content_shear .content_list_shear ul li .content_txt{word-wrap:break-word}
.content .content_list_nameplat .content_nameplate_left img{width:305px;}
</style>
</head>
<style>
.content .content_shear .content_list_shear ul li .content_txt{word-wrap:break-word}
.content .content_list_nameplat .content_nameplate_left img{width:305px;}

	.content .content_activity_asid.hot_activity dl dd .content_asit_img{
		margin-top: 5px;
	}
	.content .content_activity_asid.hot_activity dl dd .content_asit_img img{
		width:65px;
		height:65px;
	}
	.content .content_activity_asid.hot_activity dl dd{
		padding:12px 5px;
		border-top: 1px dashed #d9d9d9;
		border-bottom: 0;
	}
	.banner .banner_content .banner_content_asid .banner_content_txt{padding-bottom:6px;}
	.banner .banner_content .banner_content_asid .banner_content_asid_bottom{padding:6px 12px 0;}
	/*.banner .banner_content .banner_content_asid .banner_content_asid_center img{height:167px;width:auto}*/
</style>
</head>

<body>
<div class="content_rihgt">
	<ul>
		<li class="content_rihgt_shpping"><a href="#"></a></li>
		<li class="content_rihgt_erweima"><a href="#">
			<div class="content_rihgt_erweima_img"><img src="<?php echo option('config.wechat_qrcode');?>"/></div>
			</a> </li>
		<li class="content_rihgt_gotop"><a href="javascript:scroll(0,0)"></a> </li>
	</ul>
</div>
<div class="header">
	<div role="navigation" id="site-nav">
		<div id="sn-bg">
			<div class="sn-bg-right"></div>
		</div>
		<div id="sn-bd">
			<b class="sn-edge"></b>
			<div class="sn-container">
				<p class="sn-back-home"><i class="mui-global-iconfont"></i><a href="#"></a></p>
				<p class="sn-login-info" id="login-info">
					<em>Hi，欢迎来<?php echo option('config.site_name');?></em>
					<a target="_top" href="<?php echo url('account:login') ?>" class="sn-login">请登录</a>
					<a target="_top" href="<?php echo url('account:register') ?>" class="sn-register">免费注册</a>
				</p>
				<ul class="sn-quick-menu">
					<li class="sn-cart mini-cart"><i class="mui-global-iconfont"></i>
						<a rel="nofollow" href="<?php echo url('cart:one') ?>" class="sn-cart-link" id="mc-menu-hd">购物车<span class="mc-count mc-pt3" id="header_cart_number">0</span>件</a>
					</li>
					<li class="sn-mobile">
						<a href="<?php echo url('account:order') ?>">我的订单</a>
					</li>
					<li class="sn-mytaobao menu-item j_MyTaobao">
						<div class="sn-menu">
							<a rel="nofollow" target="_top" href="<?php echo url('account:index') ?>" class="menu-hd" tabindex="0" aria-haspopup="menu-2" aria-label="右键弹出菜单，tab键导航，esc关闭当前菜单">我的账户<b></b></a>
							<div class="menu-bd" role="menu" aria-hidden="true" id="menu-2">
								<div id="myTaobaoPanel" class="menu-bd-panel">
									<a rel="nofollow" target="_top" href="<?php echo url('account:index') ?>">个人设置</a>
									<a rel="nofollow" target="_top" href="<?php echo url('account:password') ?>">修改密码</a>
									<a rel="nofollow" target="_top" href="<?php echo url('account:address') ?>">收货地址</a>
								</div>
							</div>
						</div>
					</li>
					<li class="sn-favorite menu-item">
						<div class="sn-menu">
							<a rel="nofollow" href="<?php echo url('account:collect_store') ?>" class="menu-hd" tabindex="0" >我的收藏<b></b></a>
							<div class="menu-bd" role="menu" aria-hidden="true" id="menu-4">
								<div class="menu-bd-panel">
									<a rel="nofollow"  href="<?php echo url('account:collect_goods') ?>">收藏的宝贝</a>
									<a rel="nofollow" href="<?php echo url('account:collect_store') ?>">收藏的店铺</a>
								</div>
							</div>
						</div>
					</li>

					<li class="sn-mobile">
						<a href="javascript:" class="sn-mobile-hover" >
							<i class="mui-global-iconfont-mobile"></i>微信版
							<div class="sn-qrcode"><div class="sn-qrcode-content"><img src="<?php echo option('config.wechat_qrcode');?>" width="175px" height="175px"></div>
								<p>扫一扫，定制我的微店！</p><b></b>
							</div>
						</a>
					</li>

					<li class="sn-separator"></li>
					<li class="sn-favorite menu-item">
						<div class="sn-menu">
							<span rel="nofollow" href="javascript:void(0)" class="menu-hd" tabindex="0" >卖家中心<b></b></span>
							<div class="menu-bd" role="menu" aria-hidden="true" id="menu-4">
								<div class="menu-bd-panel">
									<a rel="nofollow"  href="<?php echo url('user:store:select') ?>">我的店铺</a>
									<a rel="nofollow" href="<?php echo url('user:store:index') ?>">管理店铺</a>
								</div>
							</div>
						</div>
					</li>

				</ul>
			</div>
		</div>
	</div>


	<div class="header_nav">
		<div class="header_logo cursor"
			onclick="javascript:location.href='<?php echo option('config.site_url');?>'"> <img src="<?php echo $config['site_logo'] ?>"> </div>
		<div class="header_search">
			<form class="pigSearch-form clearfix" onsubmit="return false" name="searchTop" action="" target="_top">
				<input type="hidden" name="st" id="searchType" value="product" />
				<div class="header_search_left"><font>商品</font><span></span>
					<div class="header_search_left_list">
						<ul>
							<li listfor="product" <?php if(MODULE_NAME != 'search' && ACTION_NAME != 'store'){echo 'selected="selected"';}?>><a href="javascript:">商品</a></li>
							<li listfor="shops" <?php if(MODULE_NAME == 'search' && ACTION_NAME == 'store'){echo 'selected="selected"';}?>><a href="javascript:void(0)">店铺</a></li>
						</ul>
					</div>
				</div>
				<div class="header_search_input">
					<input class="combobox-input" name="" class="input" type="text" placeholder="请输入商品名、称地址等">
				</div>
				<div class="header_search_button sub_search">
					<button> <span></span> 搜索</button>
				</div>
				<div  style="clear:both"></div>
			</form>
			<ul class="header_search_list">
				<?php
				if(count($search_hot)) {?>
					<?php foreach($search_hot as $k=>$v) {?>
						<li <?php if($v['type']){echo 'class="hotKeyword"';}?>><a href="<?php echo $v['url']?>"><?php echo $v['name'];?></a></li>
					<?php }?>
				<?php }?>
			</ul>





		</div>
			<div class="header_shop">
			<?php if(!empty($public_top_ad)){?>
			<a href="<?php echo $public_top_ad['url'];?>"><img
				src="<?php echo $public_top_ad['pic'];?>"></a>
			<?php } ?>
		</div>
	</div>
</div>
<div class="nav indexpage">
	<div class="nav_top">
		<div class="nav_nav ">
			<div class="nav_nav_mian"><span></span>所有商品分类</div>
			<ul class="nav_nav_mian_list" style="padding:4px 0 3px 0">
				<?php foreach ($categoryList as $k=>$v) { ?>
					<li><a href="<?php  echo url_rewrite('category:index',array('id'=>$v['cat_id']))?>"><span class="woman" style="background:url('<?php echo $v[cat_pc_pic]?>')"></span><?php echo $v['cat_name']?></a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="<?php echo url_rewrite('category:index',array('id'=>$v['cat_id']))?>"><?php echo $v['cat_name']?> </a></dt>
									 <?php if($v['larray']){ ?>
										<?php foreach($v['larray'] as $k1=>$v1) { ?>
										<dd><a href="<?php echo url_rewrite('category:index',array('id'=>$v1['cat_id']))?>" ><?php echo $v1['cat_name']?></a></dd>
										<?php }?>
									<?php }?>
								</dl>
								
							  
							</div>
						 </div>  
					</li>
					<?php };?>
			</ul>
		</div>



		<ul class="nav_list">
			<li><a href="<?php echo option('config.site_url');?>"  class="nav_list_curn">首页</a></li>
			<?php foreach($navList as $k=>$v) {?>
				<?php if($k<7){?>
					<li><a href="<?php echo $v['url'];?>" target="_blank"><?php echo $v['name'];?></a></li>
				<?php }?>
			<?php }?>
		</ul>




	</div>
</div>
<div class="banner">
	<div class="banner_arct">
		<div class="banner_content">
			<div class="banner_content_main"> 
				<!--  -->
				<div class="content__cell content__cell--slider">
					<div class="component-index-slider">
						<div class="index-slider ui-slider log-mod-viewed">
							<div class="pre-next"> <a style="opacity: 0.8; display: none;" href="javascript:;" hidefocus="true" class="mt-slider-previous sp-slide--previous"></a> <a style="opacity: 0.8; display: none;" href="javascript:;" hidefocus="true" class="mt-slider-next sp-slide--next"></a> </div>
							<div class="head ccf">
								<ul class="trigger-container ui-slider__triggers mt-slider-trigger-container">
									<?php foreach($adList as $adk => $adv) {?>
										<li class="mt-slider-trigger <?php if($adk=='0') {?>mt-slider-current-trigger<?php }?>"><?php echo $adv['name'];?></li>
									<?php }?>
									<div style="clear:both"></div>
								</ul>
							</div>
							<ul class="content">

								 <?php foreach($adList as $adk => $adv) {?>
								   <!-- <li class="mt-slider-trigger <?php if($adk=='0') {?>mt-slider-current-trigger<?php }?>"><?php echo $adv['name'];?></li>
-->
									<li class="cf" style="opacity: 1; <?php if($adk=='0') {?>display: block;<?php }else{?>display:none<?php }?>"><a href="<?php echo $adv['url'] ?>"><img  src="<?php echo $adv['pic']?>"></a></li>

								  <?php }?>

							</ul>
						</div>
					</div>
				</div>
				<ul class="m-demo m-demo-1">
					<?php 
					foreach ($ad_activity_list as $ad_activity) {
					?>
						<li><a href="<?php echo $ad_activity['url'] ?>"><img src="<?php echo $ad_activity['pic'] ?>" alt=""/></a></li>
					<?php 
					}
					?>
				</ul>
			</div>
			<div class="banner_content_asid">
				<div class="banner_content_asid_top">
					<ul>
												<li class="banner_content_asid_top_t"><span></span>
							<p><?php echo $common_data['store_qty']['value']?$common_data['store_qty']['value']:0;?>个店铺</p>
						</li>
						<li class="banner_content_asid_top_b"><span></span>
							<p><?php echo $common_data['drp_seller_qty']['value']?$common_data['drp_seller_qty']['value']:0;?>个分销商</p>
						</li>
					</ul>
				</div>
				<div class="banner_content_asid_center" style="height:217px"> 
				<?php if ($is_have_activity) { ?>
					<?php  foreach ($rec as $key => $value) { ?>
						<img onload="AutoResizeImage(255,167,this)" height="167px"  class="huodong cursor" src="<?php echo $value['image']?>" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'一元夺宝','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
						<div style="clear:both;color: #191919;font-size: 14px;line-height: 50px;padding: 0 10px;" class="huodong cursor banner_content_asid_center_txt" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'一元夺宝','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
							<div class="banner_content_asid_center_txt_left"><?php echo $value['name']?></div>
							<div class="banner_content_asid_center_txt_right"><span><?php echo $value['count']?></span>人已参与</div>
						</div>								
					<?php }?>
				<?php }else{?>	
					<?php  foreach ($adList_right as $key => $value) { ?>
						<img onload="AutoResizeImage(255,167,this)"  height="167px"   class="cursor" src="<?php echo $value['pic']?>">
						<div style="clear:both;color: #191919;font-size: 14px;line-height: 50px;padding: 0 10px;" class="huodong cursor banner_content_asid_center_txt" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'一元夺宝','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
							<div class="banner_content_asid_center_txt_left"><?php echo $value['name']?></div>
							<div class="banner_content_asid_center_txt_right"></div>
						</div>								
					<?php }?>
				<?php }?>
				</div>

				
				<?php if(empty($user_session)){?>
				<div class="banner_content_asid_bottom hq_location" data-json="{}">
					<div class="banner_content_asid_bottom_img"><img src="<?php echo TPL_URL;?>images/ico/moren.jpg"  class="hq_location" data-json="{}"></div>
					<div class="banner_content_asid_bottom_info">
						<div class="banner_content_asid_bottom_info_name"><a href="javascript:void(0)" class="hq_location" data-json="{}">点击登录</a><span></span></div>
						<div class="banner_content_asid_bottom_info_dec"><span></span>点击获取您的信息</div>
					</div>
				</div>
				<div class="banner_content_txt " >您附近共有<span><?php echo $nearshop_count;?></span>家店铺</div>				
				<?php }else{?>
					<div class="banner_content_asid_bottom hq_location" data-json="{}">
						<div class="banner_content_asid_bottom_img "><img src="<?php if($user_session['avatar']) {echo $user_session['avatar'];}else{ echo  TPL_URL."images/ico/moren.jpg";}?>"   class="hq_location" data-json="{}"></div>
						<div class="banner_content_asid_bottom_info" >
							<div class="banner_content_asid_bottom_info_name"><a href="javascript:void(0)" class="" data-json="{}"><?php echo $user_session['nickname'];?></a><span></span></div>
							<div class="banner_content_asid_bottom_info_dec hq_location" data-json="{}"><span></span><a href="javascript:void(0)" id="location_long_lat" title="<?php echo $WebUserInfo['address'];?>" data-long="<?php echo $WebUserInfo['long'] ?>" data-lat="<?php echo $WebUserInfo['lat'] ?>"><?php if($WebUserInfo['long']) {echo '位置获取中';}else{echo "点击获取您的位置！";}?></a></div>
						</div>
						
					</div>
					<div class="banner_content_txt hq_location" data-json="{}">您附近共有<span><?php echo $nearshop_count;?></span>家店铺</div>					
				<?php }?>
				
			</div>
		</div>
	</div>
</div>
<div class="content index_content"> 
	<!------------------------->
	<div class="gd_box" style="position: absolute; top: 0;  margin-left: -80px;  z-index:99;" >
		<div id="gd_box">
			<div id="gd_box1">
				<div id="nav">
					<ul>
						<li class="current gd_hot"> <a class="f1" onclick="scrollToId('#f1');"><span>热卖商品</span></a></li>
						<li class="gd_shop"><a class="f2" onclick="scrollToId('#f2');"> <span>周边店铺</span></a></li>
						<?php 
						if ($is_have_activity) {
						?>
							<li class="gd_activity"><a class="f3" onclick="scrollToId('#f3');"><span>周边活动</span> </a></li>
						<?php 
						}
						?>
						<li class="gd_nameplate"><a class="f4" onclick="scrollToId('#f4');"><span>热门品牌 </span></a></li>
						<li class="gd_product"><a class="f5" onclick="scrollToId('#f5');"><span>分销产品 </span></a></li>
						<li class="gd_show"><a class="f6" onclick="scrollToId('#f6');"> <span>网友晒单</span></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	
	<!------------------------->
	<div class="content_commodity content_woman" id="f1">
		<div class="content_commodity_title">
			<div class="content_commodity_title_left"><a href="#"><span></span>热卖商品</a></div>
			<div class="hot_category_sales_category content_commodity_title_content">

				<ul class="tab tabs" >
					<li class="content_curn"><a href="javascript:void(0)">全部热卖</a></li>
					<?php foreach($hot_products['category'] as $k=>$v) {?>
						<li class="hot_li_category" data_li_id="<?php echo $v['cat_id'];?>"><a href="javascript:void(0)"><?php echo $v['cat_name']?></a></li>
					<?php }?>
				</ul>

			</div>
			<div class="content_commodity_title_right"><a  href="<?php echo url('store:store_list',array('order'=>'collect'))?>">更多&gt;&gt;</a></div>
		</div>
		<div class="content_list">
			<div style="height:530px;">
			<ul  class="content_list_ul hot_ul_product" style="height:530px">


				<?php foreach($hot_products['product'] as $k=>$v) {?>
				<li> <a href="<?php echo $v['link']?>">
					<div class="content_list_img"><img onloads="AutoResizeImage(224,159,this)" class="lazys"  data-original="<?php echo TPL_URL;?>images/ico/grey.gif"  src="<?php echo $v['image'];?>">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img src="<?php echo  $config['site_url'].'/source/qrcode.php?type=good&id='.$v['product_id'];?>" /></div>
							<div class="content_shop_name"><?php echo $v['name'];?></div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_list_pice">￥<span><?php echo $v['price'];?></span></div>
						<div class="content_list_dec"><span>售<?php echo $v['sales'];?>/</span>分销<?php echo $v['drp_seller_qty'];?></div>
					</div>
					<div class="content_list_txt">
						<div class="content_list_day">&nbsp;
							<script>expressTimeWrite("<?php echo $v['lat'];?>","<?php echo $v['long'];?>")</script>
						</div>
						<div class="content_list_add">
							<span></span>
							<script>show_distance(<?php echo $v['lat'];?>,<?php echo $v['long'];?>,'km')</script>
						</div>
					</div>
					</a> </li>
				<?php }?>
			</ul>
			<?php foreach($hot_products['category'] as $k=>$v) {?>
				<ul style="height:530px;display:none" class="content_list_ul hot_ul_product hot_ul_product_<?php echo $v['cat_id'];?>" data_ul_id = "<?php echo $v['cat_id'];?>"></ul>
			<?php }?>
			</div>
		</div>
	</div>
	<div class="content_commodity content_shop" id="f2">
		<div class="content_commodity_title ">
			<div class="content_commodity_title_left"><a  target="_blank" href="<?php echo url('search:store') ?>"><span></span>周边店铺</a></div>
			<div class="content_commodity_title_content">

			</div>
			<div class="content_commodity_title_right"><a target="_blank" href="<?php echo url('search:store') ?>">更多&gt;&gt;</a></div>
		</div>
		<div class="content_list">
			<ul  class="content_list_ul">
				<?php foreach($nearshops as $k=>$v) {?>
				<li> <a href="<?php echo $v['pcurl']?>">
					<div class="content_list_img"><img class="lazys" data-original="<?php echo TPL_URL;?>images/ico/grey.gif" src="<?php echo $v['logo']?>" onloads="AutoResizeImage(217,144,this)" width="217px" height="144px">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img src="<?php echo  $config['site_url'].'/source/qrcode.php?type=home&id='.$v['store_id'];?>"></div>
							<div class="content_shop_name"><?php echo $v['name'];?></div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name"><?php echo $v['name'];?></div>
					</div>
					<?php if($WebUserInfo['long']) {?>
						<?php if($v['juli']) {?>
							<div class="content_list_txt">
								<div class="content_list_distance">周边<?php echo ceil($v['juli']/1000)?>km内 </div>
								<div class="content_list_add"><span></span><?php echo sprintf("%.2f", $v['juli']/1000);  ?>km</div>
							</div>
						 <?php }?>
					 <?php } else {?>
						<div class="content_list_txt">
							<div class="content_list_distance">请设置您的位置 </div>
							<div class="content_list_add"><span></span>0km</div>
						</div>
					 <?php }?>
					</a>
				</li>
				<?php }?>


			</ul>
		</div>
	</div>
	<?php 
	if ($is_have_activity) {
	?>
		<div class="content_commodity content_activity" id="f3">
			<div class="content_commodity_title ">
				<div class="content_commodity_title_left"><a href=""><span></span>周边活动</a></div>
				<div class="content_commodity_title_content">
					<ul class="">
						<li class="content_curn"><a href="javascript:void(0);">一元夺宝</a></li>
						<li><a href="javascript:void(0);">众筹</a></li>
						<li><a href="javascript:void(0);">降价拍</a></li>
						<li><a href="javascript:void(0);">限时秒杀</a></li>
						<li><a href="javascript:void(0);">超级砍价</a></li>
					</ul>
				</div>
				<div class="content_commodity_title_right"><a href="<?php echo url('activity:index');?>">更多&gt;&gt;</a></div>
			</div>
			<div class="content_list_activity cur">
				<ul  class="content_list_ul">
					<?php  foreach ($duobao as $key => $value) { ?>
					<li> 
						<a href="javascript:void(0);">
						<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'一元夺宝','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
							<img height="159" src="<?php echo $value['image'];?>">
							<div class="content_list_erweima">
								<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
								<div class="content_shop_name"><?php echo $value['name'];?></div>
							</div>
						</div>
						<div class="content_list_txt">
							<div class="content_shop_name"><?php echo $value['name'];?></div>
							<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
						</div>
						</a> 
					</li>
					<?php }?>
				</ul>
			</div>
			<div class="content_list_activity">
				<ul  class="content_list_ul">
					<?php  foreach ($zhongchou as $key => $value) { ?>
					<li> 
						<a href="javascript:void(0);">
						<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'众筹','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
							<img height="159" src="<?php echo $value['image'];?>">
							<div class="content_list_erweima">
								<div class="content_list_erweima_img" ><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
								<div class="content_shop_name"><?php echo $value['name'];?></div>
							</div>
						</div>
						<div class="content_list_txt">
							<div class="content_shop_name"><?php echo $value['name'];?></div>
							<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
						</div>
						</a> 
					</li>
					<?php }?>
				</ul>
			</div>
			<div class="content_list_activity">
				<ul  class="content_list_ul">
					<?php  foreach ($jiangjia as $key => $value) { ?>
					<li> 
						<a href="javascript:void(0);">
						<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'降价拍','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
							<img height="159" src="<?php echo $value['image'];?>">
							<div class="content_list_erweima">
								<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
								<div class="content_shop_name"><?php echo $value['name'];?></div>
							</div>
						</div>
						<div class="content_list_txt">
							<div class="content_shop_name"><?php echo $value['name'];?></div>
							<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
						</div>
						</a> 
					</li>
					<?php }?>
				</ul>
			</div>
			<div class="content_list_activity">
				<ul  class="content_list_ul">
					<?php if(is_array($miaosha)) {?>
						<?php  foreach ($miaosha as $key => $value) { ?>
						<li> 
							<a href="javascript:void(0);">
							<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'限时秒杀','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
								<img height="159" src="<?php echo $value['image'];?>">
								<div class="content_list_erweima">
									<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
									<div class="content_shop_name"><?php echo $value['name'];?></div>
								</div>
							</div>
							<div class="content_list_txt">
								<div class="content_shop_name"><?php echo $value['name'];?></div>
								<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
							</div>
							</a> 
						</li>
						<?php }?>
					 <?php }?>   
				</ul>
			</div>		
			<div class="content_list_activity">
				<ul  class="content_list_ul">
					<?php  foreach ($kanjia as $key => $value) { ?>
					<li> 
						<a href="javascript:void(0);">
						<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'超级砍价','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
							<img height="159" src="<?php echo $value['image'];?>">
							<div class="content_list_erweima">
								<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
								<div class="content_shop_name"><?php echo $value['name'];?></div>
							</div>
						</div>
						<div class="content_list_txt">
							<div class="content_shop_name"><?php echo $value['name'];?></div>
							<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
						</div>
						</a> 
					</li>
					<?php }?>
				</ul>
			</div>
	
			<div class="content_activity_asid hot_activity">
				<dl>
					<dt>
						<div class="content_activity_asid_title content_activity_title">热门活动</div>
					<dt>
					<?php if(is_array($hot)){?>
						<?php  foreach ($hot as $key => $value) { ?>
						<dd class="remenhuodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'超级砍价','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
							<div class="content_conmment">
								<div  class="content_asit_img">
									<a  href="javascript:void(0);" >
										<img src="<?php echo $value['image'];?>">
									</a>
								</div>
								<div class="content_custom">
									<div class="content_time"><a href="javascript:void(0)"><?php echo $value['name'];?></a></div>
									<p>已有 <font color="#c91623"><?php echo $value['count'];?></font> 人参与</p>
									<p><?php echo date('Y-m-d H:i:s',$value['time']);?></p>
								</div>
							</div>
						</dd>
						<?php }?>
		 			<?php }?>
				</dl>
			</div>
		</div>
	<?php 
	}
	?>
	
	
	
	<!-- --- -->
	<div class="content_commodity content_nameplate" id="f4">
		<div class="content_commodity_title ">
			<div class="content_commodity_title_left"><a href="<?php echo url('store:store_list')?>"  ><span></span>热门品牌</a></div>
			<div class="content_commodity_title_content hot_category_brand" style=" ">
				<style>
					.hot_category_brand{float:left}
					.content_commodity_title ul.tabs{height:37px;}

					.content_nameplate_left_big li{width:305px;height:147px;}
					.content_nameplate_left li{width:305px;height:147px;}
					.content_nameplate_left li.content_nameplate_left_big{width:305px;height:314px;}

					  </style>
				<ul class="tab tabs" >
					<li class="content_curn"><a href="javascript:void(0)">全部品牌</a></li>
					<?php foreach($hot_brand['type'] as $k=>$v) {?>
						<li class="hot_li_brand" data_li_id2="<?php echo $v['type_id'];?>"><a href="javascript:void(0)"><?php echo $v['type_name']?></a></li>
					<?php }?>
				</ul>

			</div>
			<div class="content_commodity_title_right"><a  href="<?php echo url('store:store_list')?>">更多&gt;&gt;</a></div>
		</div>
		<div class="content_list_nameplat" style="height:501px;">
			<div class="hot_ul_brand_div">

			
            <ul  class="content_list_ul content_nameplate_left hot_ul_brand hot_ul_brand_0">
				<?php foreach($hot_brand['brand'] as $k=>$v) {?>
					<?php if($k<2) {?>
                <li  <?php if ($k == 0) {?>class="content_nameplate_left_big"<?php }?>><a href="<?php echo $v['link'];?>"><img src="<?php echo $v['pic']?>"></a> </li>
					<?php }?>
				<?php }?>	
            </ul>
            <ul  class="content_list_ul content_nameplate_content hot_ul_brand hot_ul_brand_0">
				<?php foreach($hot_brand['brand'] as $k=>$v) {?>
					<?php if($k<8 && $k>1) {?>
						<li><a href="<?php echo $v['link'];?>"><img src="<?php echo $v['pic']?>"></a> </li>
					<?php }?>
				<?php }?>	
			</ul>
            <ul  class="content_list_ul content_nameplate_right hot_ul_brand hot_ul_brand_0">
				<?php foreach($hot_brand['brand'] as $k=>$v) {?>
					<?php if($k>7) {?>
						<li><a href="<?php echo $v['link'];?>"><img src="<?php echo $v['pic']?>"></a> </li>
					<?php }?>
				<?php }?>	

            </ul>			
			
			</div>

			<?php foreach($hot_brand['type'] as $k=>$v) {?>
			<ul  class="content_list_ul content_nameplate_left hot_ul_brand hot_ul_brand_<?php echo $v['type_id'];?>" style="display:none;"></ul>
			 <ul  class="content_list_ul content_nameplate_content hot_ul_brand hot_ul_brand_<?php echo $v['type_id'];?>" style="display:none;"></ul>
			<ul  class="content_list_ul content_nameplate_right hot_ul_brand hot_ul_brand_<?php echo $v['type_id'];?>" style="display:none"></ul>
			<?php }?>
		</div>
	</div>
	<div class="content_commodity content_product" id="f5">
		<div class="content_commodity_title ">
			<div class="content_commodity_title_left duobao"><a href="javascript:"><span></span >优质分销产品</a></div>

		</div>
		<div class="content_list_product">
			<ul  class="content_list_ul">
				<?php if(is_array($excellfx)) {?>
					<?php foreach($excellfx as $k=>$v) {?>
					<li><a href="<?php echo $v['link'];?>">
						<div class="content_list_img "><img src="<?php echo $v['image']?>">
							<div class="content_list_erweima">
								<div class="content_list_erweima_img"><img src="<?php echo $v['wx_image']?>"></div>
								<div class="content_shop_name"><?php echo $v['name']?></div>
							</div>
						</div>
						<div class="content_list_txt"> 派送总利润： <span><?php echo $v['drp_profit']?>元</span> </div>
						<div class="content_list_txt"> 分销数量：<span><?php echo $v['drp_seller_qty'];?>个</span> </div>
						<div class="content_list_txt"> 分销利润：<span><?php echo ($v['min_fx_price']-$v['cost_price']).'~'.($v['max_fx_price']-$v['cost_price'])?></>元</span> </div>
							<form onsubmit="return false">
						<div class="content_list_txt">
							<div class="content_distribution"><a href="javascript:void(0)" data-json="{'name':'<?php echo $v[name]?>','type':'product','wx_image':'<?php echo $v[wx_image]?>','pszlr':'<?php echo $v[drp_profit];?>','fxsl':'<?php echo $v[drp_seller_qty]?>','fxlr':'<?php echo ($v[min_fx_price]-$v[cost_price]).'~'.($v[max_fx_price]-$v[cost_price])?>'}"  class="wyfx">我要分销</a></div>
						</div>
							</form>
							</a>
					</li>
					<?php }?>
				<?php }?>



			</ul>
		</div>
		<div class="content_activity_asid ">
			<dl>
				<dt>
					<div class="content_activity_asid_title content_product_title ">分销动态</div>
				<dt>
				<?php if(is_array($financiallist)) {?>
					<?php foreach($financiallist as $k=>$v) {?>
					<dd onclick="javascript:location.href='<?php echo url_rewrite('store:index', array('id' => $v['store_id'])) ?>'">
						<div class="content_conmment">
							<div  class="content_asit_img"><a href="javascript:"><img src="<?php echo $v['logo'];?>" ></a></div>
							<div class="content_custom">
								<div class="content_time"><a href="javascript:"><?php echo msubstr($v['name'],0,12,'utf-8');?></a></div>
								<p>分销获得了<?php echo $v['profit'];?>元利润</p>
							</div>
							<div class="content_comment_txt"><?php echo date("Y-m-d H:i:s",$v['add_time']);?></div>
						</div>
					</dd>
					<?php }?>
					<?php }?>
			</dl>
		</div>
	</div>
	<div class="content_commodity content_shear" id="f6">
		<div class="content_commodity_title">
			<div class="content_commodity_title_left"><a href="javascript:void(0)"><span></span>评论晒单</a></div>
			<div class="content_commodity_title_content" style=" ">

			</div>
			<div class="content_commodity_title_right"><!--<a href="###">更多&gt;&gt;</a>--></div>
		</div>
		<div class="content_list_shear">
			<?php if(is_array($comment)) {?>
				<ul  class="content_list_ul content_shear_left">
					
					<?php foreach($comment as $k=>$v) {?>
						<?php if($k<3) {?>
							<li  <?php if($k==0) {?>class="content_shear_left_big"<?php }?>>
								<a href="<?php echo $v['ilink'];?>" >
									<img <?php if($k==0) {?>width="390px" height="390px"<?php } else {?>width="185px" height="185px"<?php }?> src="<?php echo $v['file']?>">
								</a>
								<div class="content_show">
								<!--<div class="content_show_xin"><span></span>789</div>-->
									<div class="content_txt"><a href="<?php echo $v['ilink'];?>"><?php echo msubstr($v['content'],0,29,'utf-8');?></a></div>
							 </div>
							</li>
						<?php }?>
					<?php }?>
				</ul>
				
				<ul  class="content_list_ul content_shear_content" >
					<?php foreach($comment as $k=>$v) {?>
						<?php if($k>2 && $k<9) {?>
							<li>	<a href="<?php echo $v['ilink'];?>" ><img width="185x" height="185x"  src="<?php echo $v['file']?>"></a>
								<div class="content_show">
								
									<div class="content_txt"><a href="<?php echo $v['ilink'];?>"><?php echo msubstr($v['content'],0,29,'utf-8');?></a></div>
								</div>
							</li>
						<?php }?>
					<?php }?>
				</ul>

				<ul  class="content_list_ul content_shear_right">
					<?php foreach($comment as $k=>$v) {?>
						<?php if($k>8) {?>
						<li <?php if($k==11) {?> class="content_shear_left_big" <?php }?>>	<a href="<?php echo $v['ilink'];?>" ><img  <?php if($k==11) {?>width="390px" height="390px"<?php }else {?> width="185x" height="185x"<?php }?> src="<?php echo $v['file']?>"></a>
							<div class="content_show">
								<!--<div class="content_show_xin"><span></span>789</div>-->
								<div class="content_txt"><a href="<?php echo $v['ilink'];?>" ><?php echo msubstr($v['content'],0,29,'utf-8');?></a></div>
							</div>
						</li>
						<?php }?>
					<?php }?>
				</ul>
			<?php }?>
		</div>
	</div>
</div>
	<?php include display('public:footer');?>
</body>
</html>