<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>对账详情 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
        <link href="./static/css/jquery.ui.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo TPL_URL;?>css/order.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo TPL_URL;?>css/order_detail.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="./static/js/area/area.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
        <script type="text/javascript" src="./static/js/plugin/jquery-ui.js"></script>
        <script type="text/javascript" src="./static/js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">
			var load_url="<?php dourl('load');?>";
			var page_content = "check_content";

			var page_coupon_edit = "coupon_edit";
			var disabled_url = "<?php dourl('disabled') ?>";
			var delete_url = "<?php dourl('delete') ?>";
			//var wap_coupon_url="<?php echo $config['wap_site_url'];?>/store_coupon.php"
			
			save_bak_url = "<?php dourl('save_bak'); ?>", cancel_status_url = "<?php dourl('cancel_status'); ?>", image_path = "<?php echo TPL_URL; ?>", add_star_url = "<?php dourl('add_star'); ?>"
		</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/check_common.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/check.js"></script>
		
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
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