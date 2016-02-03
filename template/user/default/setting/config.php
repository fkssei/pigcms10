<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>店铺物流配置 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/store.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/setting_store.css" type="text/css" rel="stylesheet"/>
	<script type="text/javascript" src="./static/js/jquery.min.js"></script>
	<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
	<script type="text/javascript" src="./static/js/area/area.min.js"></script>
	<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<script type="text/javascript">
	var load_url = "<?php dourl('load') ?>";
	var trade_load_url = "<?php dourl('trade:offline_payment_load') ?>";
	var offline_payment_status_url = "<?php dourl('trade:offline_payment_status') ?>";
	var trade_selffetch_url = "<?php dourl('trade:delivery_load') ?>";
	var selffetch_status_url = "<?php dourl('trade:selffetch_status') ?>";
	var buyer_selffetch_name_url = "<?php dourl('trade:buyer_selffetch_name') ?>";
	var logistics_url = "<?php dourl('setting:logistics') ?>";
	var logistics_status_url = "<?php dourl('setting:logistics_status') ?>";
	var friend_status_url = "<?php dourl('setting:friend_status') ?>";
	</script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/setting_config.js"></script>
</head>
<body class="font14 usercenter">
<?php include display('public:header');?>
<div class="wrap_1000 clearfix container">
	<?php include display('store:sidebar');?>
	<div class="app">
		<div class="app-inner clearfix">
			<div class="app-init-container">
				<div class="ui-nav dianpu">
					<ul>
						<li class="js-app-nav active info">
							<a href="#logistics">物流开关</a>
						</li>
						<li class="js-app-nav contact">
							<a href="#selffetch" id="buyer_selffetch_name_txt"><?php echo $store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '上门自提' ?></a>
						</li>
						<li class="js-app-nav contact">
							<a href="#friend">送朋友开关</a>
						</li>
						<li class="js-app-nav list">
							<a href="#offline_payment">货到付款</a>
						</li>
					</ul>
				</div>
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