<html>
<head>
    <meta charset="utf-8"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="renderer" content="webkit"/>
    <title id="js-meta-title">选择公司/店铺 | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <link rel="icon" href="./favicon.ico" />
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/base.css" />
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/app_team.css" />
	<script type="text/javascript" src="./static/js/jquery.min.js"></script>
	<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL; ?>js/base.js"></script>
	<script type="text/javascript">var load_url="<?php dourl('store_load');?>",delete_url="<?php dourl('store_delete');?>",select_url="<?php dourl('store_select');?>",open_url="<?php dourl('store_open');?>";</script>
	<script type="text/javascript" src="<?php echo TPL_URL; ?>js/select_store.js"></script>
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
			<h2 class="tc hd_title">
                选择公司/店铺
            </h2>
		</div>
	</div>
	<div class="container wrap_800">
			<div class="content" role="main">
				<div class="app">
					<div class="app-init-container">
						<div class="team">
							<div class="wrapper-app">
								<div id="header">
									<div class="addition">
										<div class="user-info">
											<span class="avatar" style="background-image: url(<?php if (!empty($avatar)) { ?><?php echo $avatar; ?><?php } else { ?>./static/images/avatar.png<?php } ?>)"></span>
											<div class="user-info-content">
												<div class="info-row"><?php echo !empty($user_session['nickname']) ? $user_session['nickname'] : ''; ?></div>
                                                <?php if (!empty($user_session['phone'])) { ?>
                                                <div class="info-row info-row-info">账号: <?php echo $user_session['phone']; ?></div>
                                                <?php } ?>
												<a href="<?php dourl('account:personal'); ?>" class="personal-setting">设置</a>
											</div>
											<div class="search-team hide">
												<div class="form-search">
													<input type="text" class="span3 search-query" placeholder="搜索店铺/微信/微博"/>
													<button type="button" class="btn search-btn">搜索</button>
												</div>
											</div>
                                            <?php if ($create_store_status) { ?>
											<div class="team-opt-wrapper">
												<a href="<?php dourl('store:create');?>" class="js-create-all">创建新公司和店铺</a>
											</div>
                                            <?php } ?>
										</div>
									</div>
								</div>
								<div id="content" class="team-select">
									
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