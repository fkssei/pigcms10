<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title><?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript">var load_url="<?php dourl('auto_load');?>";</script>
		<script type="text/javascript">var home_url = '<?php echo $home_url;?>', member_url = '<?php echo $member_url;?>';</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/auto.js"></script>		
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/image_text.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/app_weixin.css"/>
		<style type="text/css">
		.popover{
			display: block;
		}
		</style>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="nav-wrapper--app"></div>
						<div class="app__content page-showcase-dashboard"></div>
					</div>
				</div>
			</div>
			<?php include display('sidebar');?>
		</div>
		<?php include display('public:footer');?>
	</body>
</html>