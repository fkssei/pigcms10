<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>公共广告 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/customField.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/store_ucenter.css" type="text/css" rel="stylesheet"/>
		
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="./static/js/area/area.min.js"></script>
		
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/customField.js"></script>
		<script type="text/javascript" charset="utf-8" src="./static/js/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="./static/js/ueditor/ueditor.all.min.js"></script>

        <?php include display('public:custom_header');?>

		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">var load_url="<?php dourl('case_load');?>", open_ad_url="<?php dourl('open_ad'); ?>", save_ad_url="<?php dourl('save_ad'); ?>", action="<?php echo $action; ?>";</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/common_ad.js"></script>
    </head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
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
