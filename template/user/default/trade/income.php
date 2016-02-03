<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>收入/提现 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet" />
        <link href="./static/css/jquery.ui.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo TPL_URL;?>css/income.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="./static/js/area/area.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
        <script type="text/javascript" src="./static/js/plugin/jquery-ui.js"></script>
        <script type="text/javascript" src="./static/js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">var load_url="<?php dourl('delivery_load');?>",add_url="<?php dourl('selffetch_modify');?>",get_url="<?php dourl('selffetch_get');?>",edit_url="<?php dourl('selffetch_amend');?>";status_url="<?php dourl('selffetch_status');?>", settingwithdrawal_url = "<?php dourl('settingwithdrawal'); ?>", applywithdrawal_url = "<?php dourl('applywithdrawal'); ?>", delwithdrawal_url="<?php dourl('delwithdrawal'); ?>";</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/income.js"></script>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="nav-wrapper--app"></div>
                        <nav class="ui-nav">
                            <ul>
                                <li id="js-nav-settlement-income" class="active">
                                    <a href="#income">我的收入</a>
                                </li>
                                <li id="js-nav-settlement-trade">
                                    <a href="#trade">交易记录</a>
                                </li>
                                <li id="js-nav-settlement-inoutdetail">
                                    <a href="#inoutdetail">收支明细</a>
                                </li>
                                <li id="js-nav-settlement-withdraw">
                                    <a href="#withdraw">提现记录</a>
                                </li>
                            </ul>
                        </nav>
						<div class="app__content"></div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>