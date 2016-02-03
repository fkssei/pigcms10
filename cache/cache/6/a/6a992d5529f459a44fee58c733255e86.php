<?php	return array ( 'content' => '﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title>吾爱源码社区微店系统</title>
	<meta name="keywords" content="吾爱源码社区微店系统_提供小猪独立微店商源码及小猪O2O V1.3破解版源码" />
	<meta name="description" content="吾爱源码社区微店系统_提供小猪独立微店商源码及小猪O2O V1.3破解版源码" />
<link rel="icon"  href="favicon.ico" type="image/x-icon">
<link href="http://localhost/pigcms10/template/index/default/css/style.css" type="text/css" rel="stylesheet">
<link href="http://localhost/pigcms10/template/index/default/css/index.css" type="text/css" rel="stylesheet">
<link href="http://localhost/pigcms10/template/index/default/css/public.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://localhost/pigcms10/template/index/default/css/index-slider.v7062a8fb.css">
<script type="text/javascript" src="http://localhost/pigcms10/static/js/jquery.min.js"></script>
<script type="text/javascript" src="http://localhost/pigcms10/static/js/jquery.lazyload.js"></script>
<link rel="stylesheet" type="text/css" href="http://localhost/pigcms10/template/index/default/css/animate.css">
<script src="http://localhost/pigcms10/template/index/default/js/jquery.nav.js"></script>
<script src="http://localhost/pigcms10/template/index/default/js/distance.js"></script>
<script src="http://localhost/pigcms10/template/index/default/js/common.js"></script>
<script src="http://localhost/pigcms10/template/index/default/js/index.js"></script>
<script src="http://localhost/pigcms10/template/index/default/js/myindex.js"></script>
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script src="http://localhost/pigcms10/template/index/default/js/index2.js"></script>

<!--[if lt IE 9]>
<script src="http://localhost/pigcms10/template/index/default/js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="http://localhost/pigcms10/template/index/default/js/DD_belatedPNG_0.0.8a.js" mce_src="http://localhost/pigcms10/template/index/default/js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix(\'*\');</script>
<style type="text/css">
body{ behavior:url("csshover.htc");}
</style>
<![endif]-->
	<script>
		$(function() {
			$.get("index.php?c=index&a=user", function (data) {
				try {
					if (data.status == true) {

						var login_info = \'<em>Hi，\' + data.data.nickname + \'</em>\';
						login_info += \'<a target="_top" href="index.php?c=account&a=logout" class="sn-register">退出</a>\';
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
			<div class="content_rihgt_erweima_img"><img src="http://d.52codes.net/upload/images/system/55aa280d658c1.jpg"/></div>
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
					<em>Hi，欢迎来吾爱源码社区微店系统</em>
					<a target="_top" href="http://localhost/pigcms10/index.php?c=account&a=login" class="sn-login">请登录</a>
					<a target="_top" href="http://localhost/pigcms10/index.php?c=account&a=register" class="sn-register">免费注册</a>
				</p>
				<ul class="sn-quick-menu">
					<li class="sn-cart mini-cart"><i class="mui-global-iconfont"></i>
						<a rel="nofollow" href="http://localhost/pigcms10/index.php?c=cart&a=one" class="sn-cart-link" id="mc-menu-hd">购物车<span class="mc-count mc-pt3" id="header_cart_number">0</span>件</a>
					</li>
					<li class="sn-mobile">
						<a href="http://localhost/pigcms10/index.php?c=account&a=order">我的订单</a>
					</li>
					<li class="sn-mytaobao menu-item j_MyTaobao">
						<div class="sn-menu">
							<a rel="nofollow" target="_top" href="http://localhost/pigcms10/index.php?c=account&a=index" class="menu-hd" tabindex="0" aria-haspopup="menu-2" aria-label="右键弹出菜单，tab键导航，esc关闭当前菜单">我的账户<b></b></a>
							<div class="menu-bd" role="menu" aria-hidden="true" id="menu-2">
								<div id="myTaobaoPanel" class="menu-bd-panel">
									<a rel="nofollow" target="_top" href="http://localhost/pigcms10/index.php?c=account&a=index">个人设置</a>
									<a rel="nofollow" target="_top" href="http://localhost/pigcms10/index.php?c=account&a=password">修改密码</a>
									<a rel="nofollow" target="_top" href="http://localhost/pigcms10/index.php?c=account&a=address">收货地址</a>
								</div>
							</div>
						</div>
					</li>
					<li class="sn-favorite menu-item">
						<div class="sn-menu">
							<a rel="nofollow" href="http://localhost/pigcms10/index.php?c=account&a=collect_store" class="menu-hd" tabindex="0" >我的收藏<b></b></a>
							<div class="menu-bd" role="menu" aria-hidden="true" id="menu-4">
								<div class="menu-bd-panel">
									<a rel="nofollow"  href="http://localhost/pigcms10/index.php?c=account&a=collect_goods">收藏的宝贝</a>
									<a rel="nofollow" href="http://localhost/pigcms10/index.php?c=account&a=collect_store">收藏的店铺</a>
								</div>
							</div>
						</div>
					</li>

					<li class="sn-mobile">
						<a href="javascript:" class="sn-mobile-hover" >
							<i class="mui-global-iconfont-mobile"></i>微信版
							<div class="sn-qrcode"><div class="sn-qrcode-content"><img src="http://d.52codes.net/upload/images/system/55aa280d658c1.jpg" width="175px" height="175px"></div>
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
									<a rel="nofollow"  href="http://localhost/pigcms10/user.php?c=store&a=select">我的店铺</a>
									<a rel="nofollow" href="http://localhost/pigcms10/user.php?c=store&a=index">管理店铺</a>
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
			onclick="javascript:location.href=\'http://localhost/pigcms10\'"> <img src="http://localhost/pigcms10/static/image/common/logo.png"> </div>
		<div class="header_search">
			<form class="pigSearch-form clearfix" onsubmit="return false" name="searchTop" action="" target="_top">
				<input type="hidden" name="st" id="searchType" value="product" />
				<div class="header_search_left"><font>商品</font><span></span>
					<div class="header_search_left_list">
						<ul>
							<li listfor="product" selected="selected"><a href="javascript:">商品</a></li>
							<li listfor="shops" ><a href="javascript:void(0)">店铺</a></li>
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
															<li ><a href="http://d.mz868.net/category/33">男鞋</a></li>
											<li ><a href="http://d.mz868.net/category/37">男装</a></li>
											<li ><a href="http://d.mz868.net/category/4">美妆</a></li>
											<li class="hotKeyword"><a href="http://d.mz868.net/category/7">数码家电</a></li>
											<li ><a href="http://d.mz868.net/category/36">茶饮冲调</a></li>
											<li class="hotKeyword"><a href="http://d.mz868.net/category/14">婚庆摄影</a></li>
											<li class="hotKeyword"><a href="http://d.mz868.net/category/35">休闲零食</a></li>
												</ul>





		</div>
			<div class="header_shop">
						<a href="http://localhost/pigcms10"><img
				src="http://localhost/pigcms10/upload/adver/2015/08/55d96663639f5.gif"></a>
					</div>
	</div>
</div>
<div class="nav indexpage">
	<div class="nav_top">
		<div class="nav_nav ">
			<div class="nav_nav_mian"><span></span>所有商品分类</div>
			<ul class="nav_nav_mian_list" style="padding:4px 0 3px 0">
									<li><a href="http://localhost/pigcms10/category/1"><span class="woman" style="background:url(\'\')"></span>女人</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/1">女人 </a></dt>
									 																				<dd><a href="http://localhost/pigcms10/category/2" >女装</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/3" >女鞋</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/4" >女包</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/9" >女士内衣</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/16" >家居服</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/17" >服饰配件</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/18" >围巾手套</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/19" >棉袜丝袜</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/47" >女性护理</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/90" >企业测试</a></dd>
																											</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/5"><span class="woman" style="background:url(\'\')"></span>男人</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/5">男人 </a></dt>
									 																				<dd><a href="http://localhost/pigcms10/category/6" >男装</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/7" >男鞋</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/8" >男包</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/10" >男士内衣</a></dd>
																											</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/11"><span class="woman" style="background:url(\'\')"></span>食品酒水</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/11">食品酒水 </a></dt>
									 																				<dd><a href="http://localhost/pigcms10/category/12" >茶叶</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/13" >坚果炒货</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/14" >零食</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/15" >特产</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/57" >酒水</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/58" >水果</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/59" >生鲜</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/60" >粮油</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/61" >干货</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/62" >饮料</a></dd>
																											</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/20"><span class="woman" style="background:url(\'\')"></span>个护美妆</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/20">个护美妆 </a></dt>
									 																				<dd><a href="http://localhost/pigcms10/category/21" >清洁</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/22" >护肤</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/23" >面膜</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/24" >眼霜</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/25" >精华</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/26" >防晒</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/27" >香水彩妆</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/28" >个人护理</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/29" >沐浴洗护</a></dd>
																											</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/30"><span class="woman" style="background:url(\'\')"></span>母婴玩具</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/30">母婴玩具 </a></dt>
									 																				<dd><a href="http://localhost/pigcms10/category/31" >孕妈食品</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/32" >妈妈护肤</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/33" >孕妇装</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/34" >宝宝用品</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/35" >童装童鞋</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/36" >童车童床</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/37" >玩具乐器</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/38" >寝具服饰</a></dd>
																											</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/39"><span class="woman" style="background:url(\'\')"></span>家居百货</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/39">家居百货 </a></dt>
									 																				<dd><a href="http://localhost/pigcms10/category/40" >家纺</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/41" >厨具</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/42" >家用</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/43" >收纳</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/44" >家具</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/45" >建材</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/46" >纸品</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/63" >计生</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/74" >电器</a></dd>
																											</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/49"><span class="woman" style="background:url(\'\')"></span>运动户外</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/49">运动户外 </a></dt>
									 																				<dd><a href="http://localhost/pigcms10/category/50" >运动鞋包</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/51" >运动服饰</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/52" >户外鞋服</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/53" >户外装备</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/54" >垂钓游泳</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/55" >体育健身</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/56" >骑行运动</a></dd>
																											</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/64"><span class="woman" style="background:url(\'\')"></span>电脑数码</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/64">电脑数码 </a></dt>
									 																				<dd><a href="http://localhost/pigcms10/category/65" >手机</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/66" >手机配件</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/67" >电脑</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/68" >平板</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/69" >电脑配件</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/70" >摄影</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/71" >影音</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/72" >网络</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/73" >办公</a></dd>
																											</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/75"><span class="woman" style="background:url(\'\')"></span>手表饰品</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/75">手表饰品 </a></dt>
									 																				<dd><a href="http://localhost/pigcms10/category/76" >钟表</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/77" >饰品</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/78" >天然珠宝</a></dd>
																											</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/79"><span class="woman" style="background:url(\'\')"></span>汽车用品</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/79">汽车用品 </a></dt>
									 																				<dd><a href="http://localhost/pigcms10/category/80" >汽车装饰</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/81" >车载电器</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/82" >美容清洗</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/83" >维修保养</a></dd>
																				<dd><a href="http://localhost/pigcms10/category/84" >安全自驾</a></dd>
																											</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/94"><span class="woman" style="background:url(\'\')"></span>汽车配件</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/94">汽车配件 </a></dt>
									 								</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/95"><span class="woman" style="background:url(\'\')"></span>金融理财</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/95">金融理财 </a></dt>
									 								</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/96"><span class="woman" style="background:url(\'\')"></span>旅行票务</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/96">旅行票务 </a></dt>
									 								</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/97"><span class="woman" style="background:url(\'http://d.52codes.net/upload/category/2015/08/\')"></span>图书音像</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/97">图书音像 </a></dt>
									 								</dl>
								
							  
							</div>
						 </div>  
					</li>
										<li><a href="http://localhost/pigcms10/category/98"><span class="woman" style="background:url(\'\')"></span>厨卫用具</a>
						<div class="nav_nav_subnav">
							<div class="nav_nav_mian_list_left">
								
								
								<dl>
									<dt><a href="http://localhost/pigcms10/category/98">厨卫用具 </a></dt>
									 								</dl>
								
							  
							</div>
						 </div>  
					</li>
								</ul>
		</div>



		<ul class="nav_list">
			<li><a href="http://localhost/pigcms10"  class="nav_list_curn">首页</a></li>
												<li><a href="http:/localhost/pigcms10/category/50" target="_blank">运动鞋包</a></li>
																<li><a href="http://localhost/pigcms10/category/11" target="_blank">食品酒水</a></li>
																<li><a href="http://localhost/pigcms10/category/6" target="_blank">热卖男鞋</a></li>
																<li><a href="http://localhost/pigcms10/category/34" target="_blank">宝宝用品</a></li>
																<li><a href="http://localhost/pigcms10/category/29" target="_blank">沐浴洗护</a></li>
																<li><a href="http://localhost/pigcms10/category/39" target="_blank">居家百货</a></li>
																<li><a href="http://localhost/pigcms10/category/64" target="_blank">电脑数码</a></li>
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
																			<li class="mt-slider-trigger mt-slider-current-trigger">最好广告</li>
																			<li class="mt-slider-trigger ">互动娱乐电商</li>
																			<li class="mt-slider-trigger ">首页幻灯片4</li>
																			<li class="mt-slider-trigger ">首页幻灯片3</li>
																			<li class="mt-slider-trigger ">首页幻灯片2</li>
																			<li class="mt-slider-trigger ">首页幻灯片1</li>
																		<div style="clear:both"></div>
								</ul>
							</div>
							<ul class="content">

								 								   <!-- <li class="mt-slider-trigger mt-slider-current-trigger">最好广告</li>
-->
									<li class="cf" style="opacity: 1; display: block;"><a href="http://localhost/pigcms10"><img  src="http://localhost/pigcms10/upload/adver/2015/08/55d9696691661.png"></a></li>

								  								   <!-- <li class="mt-slider-trigger ">互动娱乐电商</li>
-->
									<li class="cf" style="opacity: 1; display:none"><a href="http://localhost/pigcms10"><img  src="http://localhost/pigcms10/upload/adver/2015/08/55d9690322c5c.png"></a></li>

								  								   <!-- <li class="mt-slider-trigger ">首页幻灯片4</li>
-->
									<li class="cf" style="opacity: 1; display:none"><a href="http://localhost/pigcms10"><img  src="http://localhost/pigcms10/upload/adver/2015/08/55d961615bfe3.png"></a></li>

								  								   <!-- <li class="mt-slider-trigger ">首页幻灯片3</li>
-->
									<li class="cf" style="opacity: 1; display:none"><a href="http://localhost/pigcms10"><img  src="http://localhost/pigcms10/upload/adver/2015/08/55d9618d99073.png"></a></li>

								  								   <!-- <li class="mt-slider-trigger ">首页幻灯片2</li>
-->
									<li class="cf" style="opacity: 1; display:none"><a href="http://localhost/pigcms10"><img  src="http://localhost/pigcms10/upload/adver/2015/08/55d9619a8223d.png"></a></li>

								  								   <!-- <li class="mt-slider-trigger ">首页幻灯片1</li>
-->
									<li class="cf" style="opacity: 1; display:none"><a href="http://localhost/pigcms10"><img  src="http://localhost/pigcms10/upload/adver/2015/08/55d961e004414.png"></a></li>

								  
							</ul>
						</div>
					</div>
				</div>
				<ul class="m-demo m-demo-1">
											<li><a href="http://localhost/pigcms10"><img src="http://localhost/pigcms10/upload/adver/2015/08/55d962e8508c8.png" alt=""/></a></li>
											<li><a href="http://localhost/pigcms10"><img src="http://localhost/pigcms10/upload/adver/2015/08/55d9632072e19.png" alt=""/></a></li>
											<li><a href="http://localhost/pigcms10"><img src="http://localhost/pigcms10/upload/adver/2015/08/55d96345e181e.png" alt=""/></a></li>
											<li><a href="http://localhost/pigcms10"><img src="http://localhost/pigcms10/upload/adver/2015/08/55bc7b205d36a.png" alt=""/></a></li>
											<li><a href="http://localhost/pigcms10"><img src="http://localhost/pigcms10/upload/adver/2015/08/55bc7b05f170a.png" alt=""/></a></li>
											<li><a href="http://localhost/pigcms10"><img src="http://localhost/pigcms10/upload/adver/2015/08/55bc7ae7ce478.png" alt=""/></a></li>
									</ul>
			</div>
			<div class="banner_content_asid">
				<div class="banner_content_asid_top">
					<ul>
												<li class="banner_content_asid_top_t"><span></span>
							<p>0个店铺</p>
						</li>
						<li class="banner_content_asid_top_b"><span></span>
							<p>0个分销商</p>
						</li>
					</ul>
				</div>
				<div class="banner_content_asid_center" style="height:217px"> 
																	</div>

				
									<div class="banner_content_asid_bottom hq_location" data-json="{}">
						<div class="banner_content_asid_bottom_img "><img src="http://localhost/pigcms10/template/user/default//images/avatar.png"   class="hq_location" data-json="{}"></div>
						<div class="banner_content_asid_bottom_info" >
							<div class="banner_content_asid_bottom_info_name"><a href="javascript:void(0)" class="" data-json="{}">Lee</a><span></span></div>
							<div class="banner_content_asid_bottom_info_dec hq_location" data-json="{}"><span></span><a href="javascript:void(0)" id="location_long_lat" title="" data-long="" data-lat="">点击获取您的位置！</a></div>
						</div>
						
					</div>
					<div class="banner_content_txt hq_location" data-json="{}">您附近共有<span>0</span>家店铺</div>					
								
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
						<li class="current gd_hot"> <a class="f1" onclick="scrollToId(\'#f1\');"><span>热卖商品</span></a></li>
						<li class="gd_shop"><a class="f2" onclick="scrollToId(\'#f2\');"> <span>周边店铺</span></a></li>
													<li class="gd_activity"><a class="f3" onclick="scrollToId(\'#f3\');"><span>周边活动</span> </a></li>
												<li class="gd_nameplate"><a class="f4" onclick="scrollToId(\'#f4\');"><span>热门品牌 </span></a></li>
						<li class="gd_product"><a class="f5" onclick="scrollToId(\'#f5\');"><span>分销产品 </span></a></li>
						<li class="gd_show"><a class="f6" onclick="scrollToId(\'#f6\');"> <span>网友晒单</span></a></li>
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
											<li class="hot_li_category" data_li_id="1"><a href="javascript:void(0)">女人</a></li>
											<li class="hot_li_category" data_li_id="5"><a href="javascript:void(0)">男人</a></li>
											<li class="hot_li_category" data_li_id="11"><a href="javascript:void(0)">食品酒水</a></li>
											<li class="hot_li_category" data_li_id="20"><a href="javascript:void(0)">个护美妆</a></li>
											<li class="hot_li_category" data_li_id="30"><a href="javascript:void(0)">母婴玩具</a></li>
											<li class="hot_li_category" data_li_id="39"><a href="javascript:void(0)">家居百货</a></li>
									</ul>

			</div>
			<div class="content_commodity_title_right"><a  href="http://localhost/pigcms10/index.php?c=store&a=store_list&order=collect">更多&gt;&gt;</a></div>
		</div>
		<div class="content_list">
			<div style="height:530px;">
			<ul  class="content_list_ul hot_ul_product" style="height:530px">


							</ul>
							<ul style="height:530px;display:none" class="content_list_ul hot_ul_product hot_ul_product_1" data_ul_id = "1"></ul>
							<ul style="height:530px;display:none" class="content_list_ul hot_ul_product hot_ul_product_5" data_ul_id = "5"></ul>
							<ul style="height:530px;display:none" class="content_list_ul hot_ul_product hot_ul_product_11" data_ul_id = "11"></ul>
							<ul style="height:530px;display:none" class="content_list_ul hot_ul_product hot_ul_product_20" data_ul_id = "20"></ul>
							<ul style="height:530px;display:none" class="content_list_ul hot_ul_product hot_ul_product_30" data_ul_id = "30"></ul>
							<ul style="height:530px;display:none" class="content_list_ul hot_ul_product hot_ul_product_39" data_ul_id = "39"></ul>
						</div>
		</div>
	</div>
	<div class="content_commodity content_shop" id="f2">
		<div class="content_commodity_title ">
			<div class="content_commodity_title_left"><a  target="_blank" href="http://localhost/pigcms10/index.php?c=search&a=store"><span></span>周边店铺</a></div>
			<div class="content_commodity_title_content">

			</div>
			<div class="content_commodity_title_right"><a target="_blank" href="http://localhost/pigcms10/index.php?c=search&a=store">更多&gt;&gt;</a></div>
		</div>
		<div class="content_list">
			<ul  class="content_list_ul">
								<li> <a href="http://localhost/pigcms10/store/26.html">
					<div class="content_list_img"><img class="lazys" data-original="http://localhost/pigcms10/template/index/default/images/ico/grey.gif" src="http://localhost/pigcms10/upload/images/default_shop_2.jpg" onloads="AutoResizeImage(217,144,this)" width="217px" height="144px">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img src="http://localhost/pigcms10/source/qrcode.php?type=home&id=26"></div>
							<div class="content_shop_name">sasas</div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name">sasas</div>
					</div>
											<div class="content_list_txt">
							<div class="content_list_distance">请设置您的位置 </div>
							<div class="content_list_add"><span></span>0km</div>
						</div>
					 					</a>
				</li>
								<li> <a href="http://localhost/pigcms10/store/27.html">
					<div class="content_list_img"><img class="lazys" data-original="http://localhost/pigcms10/template/index/default/images/ico/grey.gif" src="http://localhost/pigcms10/upload/images/default_shop_2.jpg" onloads="AutoResizeImage(217,144,this)" width="217px" height="144px">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img src="http://localhost/pigcms10/source/qrcode.php?type=home&id=27"></div>
							<div class="content_shop_name">sadf v</div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name">sadf v</div>
					</div>
											<div class="content_list_txt">
							<div class="content_list_distance">请设置您的位置 </div>
							<div class="content_list_add"><span></span>0km</div>
						</div>
					 					</a>
				</li>
								<li> <a href="http://localhost/pigcms10/store/28.html">
					<div class="content_list_img"><img class="lazys" data-original="http://localhost/pigcms10/template/index/default/images/ico/grey.gif" src="http://localhost/pigcms10/upload/images/default_shop_2.jpg" onloads="AutoResizeImage(217,144,this)" width="217px" height="144px">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img src="http://localhost/pigcms10/source/qrcode.php?type=home&id=28"></div>
							<div class="content_shop_name">asdg</div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name">asdg</div>
					</div>
											<div class="content_list_txt">
							<div class="content_list_distance">请设置您的位置 </div>
							<div class="content_list_add"><span></span>0km</div>
						</div>
					 					</a>
				</li>
								<li> <a href="http://localhost/pigcms10/store/29.html">
					<div class="content_list_img"><img class="lazys" data-original="http://localhost/pigcms10/template/index/default/images/ico/grey.gif" src="http://localhost/pigcms10/upload/images/default_shop_2.jpg" onloads="AutoResizeImage(217,144,this)" width="217px" height="144px">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img src="http://localhost/pigcms10/source/qrcode.php?type=home&id=29"></div>
							<div class="content_shop_name">微店</div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name">微店</div>
					</div>
											<div class="content_list_txt">
							<div class="content_list_distance">请设置您的位置 </div>
							<div class="content_list_add"><span></span>0km</div>
						</div>
					 					</a>
				</li>
								<li> <a href="http://localhost/pigcms10/store/30.html">
					<div class="content_list_img"><img class="lazys" data-original="http://localhost/pigcms10/template/index/default/images/ico/grey.gif" src="http://localhost/pigcms10/upload/images/default_shop_2.jpg" onloads="AutoResizeImage(217,144,this)" width="217px" height="144px">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img src="http://localhost/pigcms10/source/qrcode.php?type=home&id=30"></div>
							<div class="content_shop_name">123123</div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name">123123</div>
					</div>
											<div class="content_list_txt">
							<div class="content_list_distance">请设置您的位置 </div>
							<div class="content_list_add"><span></span>0km</div>
						</div>
					 					</a>
				</li>
								<li> <a href="http://localhost/pigcms10/store/31.html">
					<div class="content_list_img"><img class="lazys" data-original="http://localhost/pigcms10/template/index/default/images/ico/grey.gif" src="http://localhost/pigcms10/upload/images/default_shop_2.jpg" onloads="AutoResizeImage(217,144,this)" width="217px" height="144px">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img src="http://localhost/pigcms10/source/qrcode.php?type=home&id=31"></div>
							<div class="content_shop_name">昂首待发</div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name">昂首待发</div>
					</div>
											<div class="content_list_txt">
							<div class="content_list_distance">请设置您的位置 </div>
							<div class="content_list_add"><span></span>0km</div>
						</div>
					 					</a>
				</li>
								<li> <a href="http://localhost/pigcms10/store/32.html">
					<div class="content_list_img"><img class="lazys" data-original="http://localhost/pigcms10/template/index/default/images/ico/grey.gif" src="http://localhost/pigcms10/upload/images/default_shop_2.jpg" onloads="AutoResizeImage(217,144,this)" width="217px" height="144px">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img src="http://localhost/pigcms10/source/qrcode.php?type=home&id=32"></div>
							<div class="content_shop_name">微伊科技</div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name">微伊科技</div>
					</div>
											<div class="content_list_txt">
							<div class="content_list_distance">请设置您的位置 </div>
							<div class="content_list_add"><span></span>0km</div>
						</div>
					 					</a>
				</li>
								<li> <a href="http://localhost/pigcms10/store/33.html">
					<div class="content_list_img"><img class="lazys" data-original="http://localhost/pigcms10/template/index/default/images/ico/grey.gif" src="http://localhost/pigcms10/upload/images/default_shop_2.jpg" onloads="AutoResizeImage(217,144,this)" width="217px" height="144px">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img src="http://localhost/pigcms10/source/qrcode.php?type=home&id=33"></div>
							<div class="content_shop_name">飒飒</div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name">飒飒</div>
					</div>
											<div class="content_list_txt">
							<div class="content_list_distance">请设置您的位置 </div>
							<div class="content_list_add"><span></span>0km</div>
						</div>
					 					</a>
				</li>
								<li> <a href="http://localhost/pigcms10/store/34.html">
					<div class="content_list_img"><img class="lazys" data-original="http://localhost/pigcms10/template/index/default/images/ico/grey.gif" src="http://localhost/pigcms10/upload/images/default_shop_2.jpg" onloads="AutoResizeImage(217,144,this)" width="217px" height="144px">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img src="http://localhost/pigcms10/source/qrcode.php?type=home&id=34"></div>
							<div class="content_shop_name">测试</div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name">测试</div>
					</div>
											<div class="content_list_txt">
							<div class="content_list_distance">请设置您的位置 </div>
							<div class="content_list_add"><span></span>0km</div>
						</div>
					 					</a>
				</li>
								<li> <a href="http://localhost/pigcms10/store/35.html">
					<div class="content_list_img"><img class="lazys" data-original="http://localhost/pigcms10/template/index/default/images/ico/grey.gif" src="http://localhost/pigcms10/upload/images/default_shop_2.jpg" onloads="AutoResizeImage(217,144,this)" width="217px" height="144px">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img src="http://localhost/pigcms10/source/qrcode.php?type=home&id=35"></div>
							<div class="content_shop_name">柒柒测试</div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name">柒柒测试</div>
					</div>
											<div class="content_list_txt">
							<div class="content_list_distance">请设置您的位置 </div>
							<div class="content_list_add"><span></span>0km</div>
						</div>
					 					</a>
				</li>
				

			</ul>
		</div>
	</div>
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
				<div class="content_commodity_title_right"><a href="http://localhost/pigcms10/index.php?c=activity&a=index">更多&gt;&gt;</a></div>
			</div>
			<div class="content_list_activity cur">
				<ul  class="content_list_ul">
									</ul>
			</div>
			<div class="content_list_activity">
				<ul  class="content_list_ul">
									</ul>
			</div>
			<div class="content_list_activity">
				<ul  class="content_list_ul">
									</ul>
			</div>
			<div class="content_list_activity">
				<ul  class="content_list_ul">
																    
				</ul>
			</div>		
			<div class="content_list_activity">
				<ul  class="content_list_ul">
									</ul>
			</div>
	
			<div class="content_activity_asid hot_activity">
				<dl>
					<dt>
						<div class="content_activity_asid_title content_activity_title">热门活动</div>
					<dt>
													 							</dl>
			</div>
		</div>
		
	
	
	<!-- --- -->
	<div class="content_commodity content_nameplate" id="f4">
		<div class="content_commodity_title ">
			<div class="content_commodity_title_left"><a href="http://localhost/pigcms10/index.php?c=store&a=store_list"  ><span></span>热门品牌</a></div>
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
									</ul>

			</div>
			<div class="content_commodity_title_right"><a  href="http://localhost/pigcms10/index.php?c=store&a=store_list">更多&gt;&gt;</a></div>
		</div>
		<div class="content_list_nameplat" style="height:501px;">
			<div class="hot_ul_brand_div">

			
            <ul  class="content_list_ul content_nameplate_left hot_ul_brand hot_ul_brand_0">
					
            </ul>
            <ul  class="content_list_ul content_nameplate_content hot_ul_brand hot_ul_brand_0">
					
			</ul>
            <ul  class="content_list_ul content_nameplate_right hot_ul_brand hot_ul_brand_0">
					

            </ul>			
			
			</div>

					</div>
	</div>
	<div class="content_commodity content_product" id="f5">
		<div class="content_commodity_title ">
			<div class="content_commodity_title_left duobao"><a href="javascript:"><span></span >优质分销产品</a></div>

		</div>
		<div class="content_list_product">
			<ul  class="content_list_ul">
														<li><a href="http://localhost/pigcms10/goods/59.html">
						<div class="content_list_img "><img src="http://localhost/pigcms10/upload/images/000/000/029/201508/55d483b4030ad.JPG">
							<div class="content_list_erweima">
								<div class="content_list_erweima_img"><img src="http://localhost/pigcms10/source/qrcode.php?type=good&id=59"></div>
								<div class="content_shop_name">测试</div>
							</div>
						</div>
						<div class="content_list_txt"> 派送总利润： <span>0元</span> </div>
						<div class="content_list_txt"> 分销数量：<span>0个</span> </div>
						<div class="content_list_txt"> 分销利润：<span>2~9</>元</span> </div>
							<form onsubmit="return false">
						<div class="content_list_txt">
							<div class="content_distribution"><a href="javascript:void(0)" data-json="{\'name\':\'测试\',\'type\':\'product\',\'wx_image\':\'http://localhost/pigcms10/source/qrcode.php?type=good&id=59\',\'pszlr\':\'0\',\'fxsl\':\'0\',\'fxlr\':\'2~9\'}"  class="wyfx">我要分销</a></div>
						</div>
							</form>
							</a>
					</li>
									


			</ul>
		</div>
		<div class="content_activity_asid ">
			<dl>
				<dt>
					<div class="content_activity_asid_title content_product_title ">分销动态</div>
				<dt>
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
							<ul  class="content_list_ul content_shear_left">
					
									</ul>
				
				<ul  class="content_list_ul content_shear_content" >
									</ul>

				<ul  class="content_list_ul content_shear_right">
									</ul>
					</div>
	</div>
</div>
	<div  class="chenpage" style="display:none">

<script>

var time_flag=1;
var locationInterval;
	
	$(function(){
		
		locationInterval = window.setInterval(function(){
		check_location_status();
			time_flag++;
		},3000);
	})


function check_location_status(){
	$.getJSON("http://localhost/pigcms10/index.php?c=wxlocation&a=check_status",{qrcode_id:\'\'},function(res){
		//alert(res.errmsg);
		if(res.errmsg == \'scan_ok\'){
			$(\'.tankuang_txt_left\').html(\'您已经扫码二维码，请发送您的<br/>位置！\');
		}else if(res.errmsg == \'location_ok\'){
			$(\'.tankuang_txt_left\').html(\'获取位置并登录成功,<br/>页面正在跳转！\');
			clearInterval(locationInterval);
			location.reload();
		}else if(res.errmsg == \'false\'){
			clearInterval(locationInterval);
		}
	});
}

function setting_location() {

	$(".tankuang_content").hide();
	$(".chenpage").show();
	$(".tankuang4").show();
}
</script>

<style>.tankuang1 .tanchuang_guanbi{bottom:215px;}

.tankuang1 .tankuang_title {
    color: #feed61;
    font-size: 30px;
    line-height: 33px;
    margin-bottom: 30px;
}
</style>


<script>
$(window).resize(function(){
	centerWindow($(".tankuang_content"));
})
</script>


<div class="tankuang_content tankuang4 popup1 hqwz" style="display:none">
		<div class="shouji animated bounceInDown"><img src="http://localhost/pigcms10/template/index/default/images/tankuang_4_20.png">
			<div class="tankuang_erweima animated zoomIn"><img src="http://localhost/pigcms10/template/index/default/images/wx.gif"></div>
		</div>
		<div class="shaoma animated fudong2 "><img src="http://localhost/pigcms10/template/index/default/images/tankuang_4_09.png"></div>
		<div class="tankuang_txt animated zoomInLeft">
			<div class="tankuang_txt_title">”获取我的位置“</div>
			<p>
			<div class="tankuang_txt_left">获取位置后可以查看离你<span>最近</span>的<br/>店铺和商品</div>
			<p>
			<!-- 
			<div class="tankuang_txt_left">参与人数：</div>
			<div class="tankuang_txt_right"><span>76人</span></div> -->
		</div>
		<div class="tankuang_button animated bounceInUp"><img src="http://localhost/pigcms10/template/index/default/images/tankuang1_03.png" /></div>
		<div class="dizuo "><img src="http://localhost/pigcms10/template/index/default/images/tankuang_4_49.png"></div>
		<div  class="xiaoren  animated slideInRight"><img src="http://localhost/pigcms10/template/index/default/images/tankuang_4_30.png"></div>
	</div>

	<div class="tankuang_content tankuang1 tankuang_button_xianshi myfx popup2">
		<div class="shouji animated fadeInDown"><img src="http://localhost/pigcms10/template/index/default/images/tankuang1_06.png">
			<div class="erweima animated rotateIn"><img class="wx_image" src="http://localhost/pigcms10/template/index/default/images/tankuang_1_06.png"></div>
			<div class="shaoma animated fadeIn">扫描二维码即可分销</div>
		</div>
		<div class="dizuo animated fadeInUp"><img src="http://localhost/pigcms10/template/index/default/images/tankuang_1_19.png"></div>
		<div class="tankuang_list animated lightSpeedIn">
			<div class="tankuang_title"></div>
			<div class="tankuang_txt"></div>
			<div class="tankuang_txt"></div>
			<div class="tankuang_txt"></div>
		</div>
		<div class="tanchuang_guanbi animated bounceIn"><img src="http://localhost/pigcms10/template/index/default/images/tankuang_1_14.png" /></div>
	</div>

 
		<div class="tankuang_content tankuang2 tankuang_button_xianshi popup3 rmhd">
			<div class="shouji"><img src="http://localhost/pigcms10/template/index/default/images/tankuang_2_18.png" class="animated flipInY" />
				<div class="erweima animated zoomIn "><img class="wx_image" src="http://localhost/pigcms10/template/index/default/images/tankuang_1_06.png"></div>
				<div class="shaoma animated fadeInUp ">扫描二维码参与</div>
				<div class="niao1"><img src="http://localhost/pigcms10/template/index/default/images/tankuang_2_20.png"></div>
				<div class="niao2"><img src="http://localhost/pigcms10/template/index/default/images/tankuang_2_26.png"></div>
				<div class="niao3"><img src="http://localhost/pigcms10/template/index/default/images/tankuang_2_47.png"></div>
				<div class="yun1 animated fudong "><img src="http://localhost/pigcms10/template/index/default/images/tankuang_2_14.png"></div>
				<div class="yun2 animated fudong1"><img src="http://localhost/pigcms10/template/index/default/images/tankuang_2_33.png"></div>
			</div>
			<div class="dizuo animated fadeInLeft "><img src="http://localhost/pigcms10/template/index/default/images/tankuang_2_42.png"></div>
			<div class="tanchuang_guanbi animated bounceInDown "><img src="http://localhost/pigcms10/template/index/default/images/tankuang_2_55.png" /></div>
			<div  class="songli animated rollIn">我要送礼</div>
			<div class="tankuang_list animated fadeInUp ">
				<div class="tankuang_title">爱丽丝不睡觉</div>
				<div class="tankuang_txt">分销价格: <span> ￥365</span></div>
				<div class="tankuang_txt">派送利润: <span> ￥35</span></div>
				<div class="tankuang_txt_txt">利用节日营销，打造传播新方式。中秋微贺卡，支持商家定制祝福语、背景音乐、自定义上传logo。粉丝在接收到商家发出的微贺卡后，也可对祝福内容进行定制，并分享、转发。利用微贺卡，借助节日气氛，为商家带来爆炸式传播。”</div>
			</div>
		</div>

		<div class="tankuang_content tankuang3 tankuang_button_xianshi yydb popup4">
			<div class="shouji animated zoomIn"><img src="http://localhost/pigcms10/template/index/default/images/tankuang3_18.png">
				<div class="erweima animated rubberBand"><img class="wx_image" src="http://localhost/pigcms10/template/index/default/images/tankuang_1_06.png"></div>
				<div class="shaoma animated bounceInUp">扫描二维码参与</div>
			</div>
			<div class="dizuo animated fadeInLeft"><img src="http://localhost/pigcms10/template/index/default/images/tankuang_3_57.png"></div>
			<div  class="songli animated bounceInDown">一元夺宝</div>
			<div class="tankuang_list animated fadeIn ">
				<div class="tankuang_title">爱丽丝不睡觉</div>
				<div class="tankuang_txt">分销价格: <span> ￥365</span></div>
				<div class="tankuang_txt">派送利润: <span> ￥35</span></div>
				<div class="tankuang_txt_txt">每个用户最低只需1元就有机会获得一件奖品。每个奖品分配对应数量的号码，每个号码价值1元，当一件奖品所有号码售出后，根据既定的算法计算出一个幸运号码，持有该号码的用户，直接获得该奖品。”</div>
			</div>
			<div class="tanchuang_guanbi animated bounceInUp  "><img src="http://localhost/pigcms10/template/index/default/images/tuankuang3_56.png" /></div>
		</div>
		

</div>	
<div class="footer1 ">
	<div class="footer_txt">
				<div class="footer_txt">
			Copyright 2015 (c)吾爱源码微店系统版权所有  
		</div>
	</div>
</div>


<!--二维码弹出层-->



<style>
.right-red-radius {background-color: #cc0000; border-radius: 10px;}
.mui-mbar-tab-sup-bd {font-size:12px;}
</style>
<div class="content_rihgt" id="leftsead" style="position: fixed; top: 352px;">
	<ul>
		<li class="content_rihgt_shpping">
			<div id="cartbottom">
				<div class="right-red-radius" style="margin-top: 0px; color:#fff; position: absolute;z-index:2; width: 20px; height: 22px; font-size: 12px;line-height:22px;">
					<div class="mui-mbar-tab-sup-bd">0</div>
				</div>
			</div>
		</li>
		<li class="content_rihgt_erweima">
			<a href="javascript:void(0)">
				<div class="content_rihgt_erweima_img"><img src="http://d.52codes.net/upload/images/system/55aa280d658c1.jpg"></div>
			</a>
		</li>
		<li class="content_rihgt_gotop"><a href="javascript:scroll(0,0)"></a></li>
	</ul>
</div>
<script>
<!-- 代码 结束 -->
function addCart_pf(event) {
	$("#leftsead").show();
	var offset = $(\'#cartbottom\').offset(), flyer = $(\'<div class="right-red-radius" style="margin-top: 0px; color:#fff; position: absolute;z-index:9999; width: 20px; height: 22px; font-size: 12px;line-height:22px;"><div class="mui-mbar-tab-sup-bd"></div></div>\');
	offset.top="352";
	
	flyer.fly({
		start: {left : event.pageX, top: event.clientY - 30},
		end: {left : offset.left, top : offset.top, width : 20, height : 20},
		onEnd: function() {
			var cart_number = parseInt($("#header_cart_number").text());
			if(cart_number > 99) {
				cart_number = 99;
			}
			$(".mui-mbar-tab-sup-bd").html(cart_number);
		}
	});
}
$(function () {
	$(".content_rihgt_shpping").css("cursor", "pointer");
	$(".content_rihgt_shpping").click(function () {
		location.href = "http://localhost/pigcms10/index.php?c=cart&a=one";
	});
})
</script></body>
</html>', 'expire_time' => 1454525387, );?>