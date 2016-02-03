<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>订单详情 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/order_detail.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="./static/js/area/area.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">var load_url="<?php dourl('load');?>", order_id = "<?php echo $_GET['id']; ?>", save_bak_url = "<?php dourl('save_bak'); ?>", cancel_status_url = "<?php dourl('cancel_status'); ?>", image_path = "<?php echo TPL_URL; ?>", add_star_url = "<?php dourl('add_star'); ?>", detail_json_url = "<?php dourl('detail_json'); ?>", float_amount_url = "<?php dourl('float_amount'); ?>", page_content = 'detail_content', package_product_url = "<?php dourl('package_product'); ?>", create_package_url = "<?php dourl('create_package'); ?>";</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/order_detail.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/order_common.js"></script>
	</head>
	<body class="font14 usercenter" onresize="winresize()">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container" style="background:white;">
						<div class="nav-wrapper--app"></div>
						<div class="app__content"></div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>