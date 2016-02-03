<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>找人代付- <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/pay_agent.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="./static/js/area/area.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">var load_url="<?php dourl('delivery_load');?>",pay_agent_content_buyer_url="<?php dourl('pay_agent_content_buyer');?>",pay_agent_content_payer_url="<?php dourl('pay_agent_content_payer');?>",pay_agent_content_add_url="<?php dourl('pay_agent_content_add');?>",pay_agent_content_edit_url="<?php dourl('pay_agent_content_edit');?>",pay_agent_content_del_url="<?php dourl('pay_agent_content_del');?>",status_url="<?php dourl('pay_agent_status');?>"</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/pay_agent.js"></script>
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