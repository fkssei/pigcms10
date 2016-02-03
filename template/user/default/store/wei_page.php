<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>页面杂志 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		
		<link href="<?php echo TPL_URL;?>css/store_ucenter.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/store_wei_page.css" type="text/css" rel="stylesheet"/>
		
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="./static/js/area/area.min.js"></script>
		
		<?php include display('public:custom_header');?>
		<style>.app-preview .custom-tag-list{background:#f9f9f9;overflow:hidden}.app-preview .custom-tag-list ul,.app-preview .custom-tag-list li{padding:0;margin:0;list-style:none}.app-preview .custom-tag-list .custom-tag-list-menu-block{position:relative;width:90px;margin-right:1px;float:left;border-right:1px solid #ddd;background:#e6e6e6}.app-preview .custom-tag-list .custom-tag-list-menu-block .custom-tag-list-side-menu{background:#e6e6e6;padding-top:25px;position:relative}.app-preview .custom-tag-list .custom-tag-list-menu-block .fixed{position:fixed;top:0}.app-preview .custom-tag-list .custom-tag-list-menu-block .to-bottom{position:absolute;left:0;bottom:0}.app-preview .custom-tag-list .custom-tag-list-menu-block li{border-top:1px solid #e6e6e6;border-bottom:1px solid #e6e6e6}.app-preview .custom-tag-list .custom-tag-list-menu-block li a{display:block;width:80px;padding:10px 5px;font-size:14px;-webkit-tap-highlight-color:transparent}.app-preview .custom-tag-list .custom-tag-list-menu-block li a span{display:block;max-height:28px;overflow:hidden;line-height:14px}.app-preview .custom-tag-list .custom-tag-list-menu-block li.current{background:#f9f9f9;border-top:1px solid #ddd;border-bottom:1px solid #ddd}.app-preview .custom-tag-list .custom-tag-list-menu-block li.current a{padding-right:6px;background:#f9f9f9;color:#f60}.app-preview .custom-tag-list .custom-tag-list-menu-block .custom-tag-list-space{height:24px;background:#e6e6e6}.app-preview .custom-tag-list .custom-tag-list-goods{overflow:hidden}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-title{width:100%;height:26px;line-height:26px;font-size:12px;white-space:nowrap;word-break:keep-all;overflow:hidden;text-overflow:ellipsis;font-weight:normal;background:#eee;padding:0 0 0 10px;margin:0;background:#eee}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-list{margin-left:5px}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-single-goods{border-bottom:1px solid #ddd}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-single-goods:last-child{border-bottom:none}.app-preview .custom-tag-list .custom-tag-list-goods .no-goods-list{color:#999;padding:0 5px;line-height:40px;font-size:14px}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-img{display:block;float:left;width:60px;height:60px;padding:10px 5px 10px 0}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-img img{width:60px;height:60px}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-detail{margin-left:65px;position:relative;padding-bottom:2px}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-detail .custom-tag-list-goods-title{display:block;margin:0;padding:10px 0;line-height:30px;white-space:nowrap;word-break:keep-all;overflow:hidden;text-overflow:ellipsis;font-size:14px}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-detail .custom-tag-list-goods-price{color:#f60;padding:0}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-detail .custom-tag-list-goods-buy{display:block;position:absolute;right:10px;bottom:0;width:60px;height:50px;-webkit-tap-highlight-color:transparent}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-detail .custom-tag-list-goods-buy span{position:absolute;right:0;bottom:0;width:20px;height:20px;text-align:center;line-height:24px;font-size:12px;background-image:url("/v2/image/wap/showcase-1416814739063.png");background-position:0 -88px;background-repeat:no-repeat}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-detail .custom-tag-list-goods-buy .ajax-error,.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-detail .custom-tag-list-goods-buy .ajax-loading{display:none}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-detail .custom-tag-list-goods-buy .ajax-loading{background-image:url("/v2/image/wap/common/loading.gif");background-repeat:no-repeat;background-position:center center}@media only screen and (-webkit-min-device-pixel-ratio: 1.5),only screen and (min--moz-device-pixel-ratio: 1.5),only screen and (-o-min-device-pixel-ratio: 3/2),only screen and (min-device-pixel-ratio: 1.5){.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-detail .custom-tag-list-goods-buy .ajax-loading{background-image:url("/v2/image/wap/common/loading@2x.gif");background-size:16px}.app-preview .custom-tag-list .custom-tag-list-goods .custom-tag-list-goods-detail .custom-tag-list-goods-buy span{background-image:url("/v2/image/wap/showcase2x-1416814739063.png");background-size:40px auto}}.app-preview .custom-coupon{padding:10px;text-align:center;font-size:0}.app-preview .custom-coupon li{display: block;width: 94px;height: 67px;border: 1px solid #ff93b2;border-radius: 4px;background: #ffeaec;float: left; margin:5px 4px 0 0;}.app-preview .custom-coupon li a{color:#fa5262}.app-preview .custom-coupon li:nth-child(1){margin-left:0}.app-preview .custom-coupon li:nth-child(2){background:#f3ffef;border-color:#98e27f}.app-preview .custom-coupon li:nth-child(2) a{color:#7acf8d}.app-preview .custom-coupon li:nth-child(3){background:#ffeae3;border-color:#ffa492}.app-preview .custom-coupon li:nth-child(3) a{color:#ff9664}.app-preview .custom-coupon .custom-coupon-price{height:24px;line-height:24px;padding-top:12px;font-size:24px;overflow:hidden}.app-preview .custom-coupon .custom-coupon-price span{font-size:16px}.app-preview .custom-coupon .custom-coupon-desc{height:20px;line-height:20px;font-size:12px;padding-top:4px;overflow:hidden}.current{ background:#fff}</style>

		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">var load_url="<?php dourl('load');?>",set_home_url="<?php dourl('set_home');?>",update_storelogo_url="<?php dourl('update_store_logo'); ?>",add_url="<?php dourl('wei_page_add');?>",edit_url="<?php dourl('wei_page_edit');?>",delete_url="<?php dourl('wei_page_delete');?>",add_pageCategory_url="<?php dourl('wei_page_category');?>#create",get_pageCategory_url="<?php dourl('get_pageCategory');?>";</script>
		<script>
			var siteurl = "<?php echo option('config.site_url');?>";
				<?php if($_SESSION['user']['admin_id']) {?>
					var is_adminuser = 1;
				<?php }else {?>
					var is_adminuser = 0;
				<?php }?>
		</script>
		
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/store_wei_page.js"></script>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
                    <nav class="ui-nav">
                        <ul>
                            <li id="js-nav-list-index" class="active">
                                <a href="#list">微页面</a>
                            </li>
                        </ul>
                    </nav>
					<div class="app-init-container">
						<div class="nav-wrapper--app"></div>
						<div class="app__content js-app-main"></div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>