<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">

<title><?php echo $config['seo_title'] ?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />

<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/index_person.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css">
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
<script src="<?php echo TPL_URL;?>js/jquery.nav.js"></script>
<script type="text/javascript" src="./static/js/jquery.form.min.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>
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
<script type="text/javascript">
			$("#pages a").click(function () {
		var page = $(this).attr("data-page-num");
		location.href="<?php echo url('account:order') ?>&page=" + page;
	});
			</script>
<style type="text/css">
.danye_content{ padding:0}
.form-table td{ font-size:12px;}
.yuuhuiquan_info_list .youhuiquan_shop_info_r button.go_shop{ float:right}
.order_add_list .order_add_add{ width:400px;}
.order_list ul.order_list_list li .order_list_txt{ text-align:center}
.order_list ul.order_list_list dd{ border:0}
.order_list ul.order_list_list::after{ min-height:50px;}
.order_list ul.order_list_list li .order_list_img img{ height:71px; width:100px;}
.order_list ul.order_list_list li .order_list_txt{ width:150px; padding-left:50px;}
span.error { color: red; background: url(<?php echo TPL_URL;?>images/weidian_icon_03.png) no-repeat center left; padding-left: 20px; display: block; float: left; line-height:25px }
span.success { color: green; background: url(<?php echo TPL_URL;?>images/weidian_icon_05.png) no-repeat center left; padding-left: 20px; float: left; display: block; line-height:25px; }
#login-info li,.common_div input{ float:left}
.form-table input{ margin:0}
</style>
</head>

<body>

<div class="header">
    <div role="navigation" id="site-nav">
		<div id="sn-bg">
			<div class="sn-bg-right"></div>
		</div>
		<div id="sn-bd"> <b class="sn-edge"></b>
			<div class="sn-container">
				<p class="sn-back-home"><i class="mui-global-iconfont"></i><a href="###"></a></p>
				<p class="sn-login-info" id="login-info"> <em>Hi，欢迎来小猪微店</em> <a target="_top" href="<?php echo url('account:login') ?>" class="sn-login">请登录</a> <a target="_top" href="<?php echo url('account:register') ?>" class="sn-register">免费注册</a> </p>
				<ul class="sn-quick-menu">
					<li class="sn-cart mini-cart"><i class="mui-global-iconfont"></i> <a rel="nofollow" href="<?php echo url('cart:one') ?>" class="sn-cart-link" id="mc-menu-hd">购物车<span class="mc-count mc-pt3" id="header_cart_number">0</span>件</a> </li>
					<li class="sn-mobile"> <a href="<?php echo url('account:order') ?>">我的订单</a> </li>
					<li class="sn-mytaobao menu-item j_MyTaobao">
						<div class="sn-menu"> <a rel="nofollow" target="_top" href="<?php echo url('account:index') ?>" class="menu-hd" tabindex="0" aria-haspopup="menu-2" aria-label="右键弹出菜单，tab键导航，esc关闭当前菜单">我的账户<b></b></a>
							<div class="menu-bd" role="menu" aria-hidden="true" id="menu-2">
								<div id="myTaobaoPanel" class="menu-bd-panel"> <a rel="nofollow" target="_top" href="<?php echo url('account:index') ?>">个人设置</a> <a rel="nofollow" target="_top" href="<?php echo url('account:password') ?>">修改密码</a> <a rel="nofollow" target="_top" href="<?php echo url('account:address') ?>">收货地址</a> </div>
							</div>
						</div>
					</li>
					<li class="sn-favorite menu-item">
						<div class="sn-menu"> <a rel="nofollow" href="<?php echo url('account:collect_store') ?>" class="menu-hd" tabindex="0" >我的收藏<b></b></a>
							<div class="menu-bd" role="menu" aria-hidden="true" id="menu-4">
								<div class="menu-bd-panel"> <a rel="nofollow"  href="<?php echo url('account:collect_goods') ?>">收藏的宝贝</a> <a rel="nofollow" href="<?php echo url('account:collect_store') ?>">收藏的店铺</a> </div>
							</div>
						</div>
					</li>
					<li class="sn-mobile"> <a href="javascript:" class="sn-mobile-hover" > <i class="mui-global-iconfont-mobile"></i>微信版
						<div class="sn-qrcode">
							<div class="sn-qrcode-content"><img src="<?php echo option('config.wechat_qrcode');?>" width="175px" height="175px"></div>
							<p>扫一扫，定制我的小猪！</p>
							<b></b> </div>
						</a> </li>

					<li class="sn-separator"></li>
					<li class="sn-favorite menu-item">
						<div class="sn-menu"> <span rel="nofollow" href="javascript:void(0)" class="menu-hd" tabindex="0" >卖家中心<b></b></span>
							<div class="menu-bd" role="menu" aria-hidden="true" id="menu-4">
								<div class="menu-bd-panel"> <a rel="nofollow"  href="<?php echo url('user:store:select') ?>">我的店铺</a> <a rel="nofollow" href="<?php echo url('user:store:index') ?>">管理店铺</a> </div>
							</div>
						</div>
					</li>
					<!-- <li class="sn-mobile">
						<a href="#">服务帮助</a>
					</li> -->
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="danye_menu">
    <ul>
        <li class="danye_index">
        
        <a href="<?php echo option('config.site_url');?>"><img src="<?php echo option('config.pc_usercenter_logo');?>"></a>
        
        
        
        
        </li>
       <!--   <li class="danye_list"><a href="#">会员首页</a></li>-->
        <li class="danye_list"><a href="<?php echo dourl('account:index') ?>">个人资料</a></li>
        <li class="fanhui"><a href="/">返回首页<span></span></a></li>
    </ul>
</div>

<div id="userinfo" class="m m3 clearfix">
    <div class="user">
        <div class="u-icon picture">
            <div class="hide" id="modifyheader" style="display: none;">
                <div class="upper fore" id="modUserImgbox"></div>
                <a class="fore" href="###">修改头像</a> </div>
            <img alt="用户头像" src="<?php if (!empty($user['avatar'])) { ?><?php echo getAttachmentUrl($user['avatar']) ?><?php } else { ?><?php echo TPL_URL;?>/images/touxiang.png<?php } ?>" id="userImg"> </div>
    </div>
    <!--user-->
    <div id="i-userinfo">
        <div class="username">
            <div id="userinfodisp" class="fl ftx-03"><strong><?php echo $user['nickname'] ?></strong>，欢迎您！</div>
            <div id="jdTask" class="extra"></div>
        </div>
        <div class="account">
                        <div class="member" id="memberInfo">
                            <p><span class="col_s"></span>
                                <input type="hidden" id="ga" value="0">
                                <a href="#" class="cgreen" title="注册会员">登陆IP：&nbsp;</a><?php echo $user['last_ip']?>&nbsp;&nbsp; <a href="###" target="_blank" class="cgreen">登陆时间：</a><?php echo date('Y-m-d H:i:s',$user["last_time"])?> </p>
                        </div>
                    </div>
    </div>
</div>
<div class="danye_content">
    <div class="tab11" id="tab11">
        <div class="menu">
            <div class="danye_title kaidian" onClick="window.open('<?php echo dourl('user:store:select')?>')"><span></span>我要开店<i></i></div>
            <div class="danye_title order" ><span></span>订单中心<i></i></div>
            <ul>
                <li id="one1" onClick="location.href='<?php echo dourl('account:order') ?>'" <?php if($_GET['a']=='order'){?>class="off"<?php } ?>>我的订单</li>
            </ul>
            <div class="danye_title shouchang"><span></span>收藏中心<i></i></div>
            <ul>
                <li id="one2" onClick="location.href='<?php echo dourl('account:collect_goods') ?>'" <?php if($_GET['a']=='collect_goods'){?>class="off"<?php } ?> >商品收藏</li>
                <li id="one3" onClick="location.href='<?php echo dourl('account:collect_store') ?>'" <?php if($_GET['a']=='collect_store'){?>class="off"<?php } ?>>店铺收藏</li>
           		<li id="one3" onClick="location.href='<?php echo dourl('account:attention_store') ?>'" <?php if($_GET['a']=='attention_store'){?>class="off"<?php } ?>>关注店铺</li>
            </ul>
            <div class="danye_title geren"><span></span>个人中心<i></i></div>
            <ul>
                <li id="one3" onClick="location.href='<?php echo dourl('account:address') ?>'" <?php if($_GET['a']=='address'){?>class="off"<?php } ?>>收货地址</li>
		<li id="one4" onClick="location.href='<?php echo dourl('account:password') ?>'" <?php if($_GET['a']=='password'){?>class="off"<?php } ?>>修改密码</li>
		<li id="one5" onClick="location.href='<?php echo dourl('account:index') ?>'" <?php if($_GET['a']=='index'){?>class="off"<?php } ?>>个人资料</li>
            </ul>
            <div class="danye_title zichan"><span></span>资产中心<i></i></div>
            <ul>
                <li id="one7" onClick="location.href='<?php echo dourl('account:coupon') ?>'" <?php if($_GET['a']=='coupon'){?>class="off"<?php } ?>>优惠券</li>
            </ul>
        </div>
		
		 <div class="danye_content_right">
            <div class="menudiv">