<html>
<head>
    <meta charset="utf-8"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="renderer" content="webkit"/>
    <title id="js-meta-title">个人账号设置 | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
    <link rel="icon" href="./favicon.ico" />
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/base.css" />
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/app_team.css" />
	<script type="text/javascript" src="./static/js/jquery.min.js"></script>
	<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL; ?>js/base.js"></script>
	<script type="text/javascript">var load_url="<?php dourl('load');?>", personal_url="<?php dourl('personal'); ?>", select_url="<?php dourl('store:select'); ?>";</script>
	<script type="text/javascript" src="<?php echo TPL_URL; ?>js/account.js?time=<?php echo time();?>"></script>
</head>
<body>
	<div id="hd" class="wrap rel">
		<div class="wrap_1000 clearfix">
			<h1 id="hd_logo" class="abs" title="<?php echo $config['site_name'];?>">
				<?php if($config['pc_shopercenter_logo'] != ''){?>
					<a href="<?php dourl('store:select');?>">
						<img src="<?php echo $config['pc_shopercenter_logo'];?>" height="35" alt="<?php echo $config['site_name'];?>" style="height:35px;width:auto;max-width:none;"/>
					</a>
				<?php }?>
			</h1>
			<h2 class="tc hd_title">个人账号设置</h2>
		</div>
	</div>
	<div class="container wrap_800">
			<div class="content" role="main">
				<div class="app">
					<div class="app-init-container">
						<div class="team">
							<div class="wrapper-app">
								<div id="content">

								</div>
							</div>
							<?php $show_footer_link = false; include display('public:footer');?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>