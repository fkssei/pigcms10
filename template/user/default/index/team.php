<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta name="renderer" content="webkit"/>
        <title id="js-meta-title">选择公司/店铺 | <?php echo $config['site_name'];?></title>
        <link rel="icon" href="./favicon.ico" />
        <link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css" />
        <link rel="stylesheet" href="<?php echo TPL_URL;?>css/app_team.css" />
    </head>
    <body>
		<div id="hd" class="wrap rel">
			<div class="wrap_1000 clearfix">
				<h1 id="hd_logo" class="abs" title="<?php echo $config['site_name'];?>">
					<a href="<?php dourl('store:select');?>">
						<img src="<?php echo $config['site_logo'];?>" width="86" height="35" alt="<?php echo $config['site_name'];?>"/>
					</a>
				</h1>
				<h2 class="tc hd_title">选择公司/店铺</h2>
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
											<span class="avatar" style="background-image: url(./static/images/avatar.png)"></span>
											<div class="user-info-content">
												<div class="info-row"><?php echo $user_session['nickname'];?></div>
												<div class="info-row info-row-info">手机: <?php echo $user_session['phone'];?></div>
												<a href="javascript:;" class="personal-setting">设置</a>
											</div>
											<div class="search-team hide">
												<div class="form-search">
													<input type="text" class="span3 search-query" placeholder="搜索店铺/微信/微博">
													<button type="button" class="btn search-btn">搜索</button>
												</div>
											</div>
											<div class="team-opt-wrapper">
												<a href="<?php dourl('store:create');?>" class="js-create-all">创建新公司和店铺</a>
											</div>
										</div>
									</div>
								</div>
								<div id="content" class="team-select">
									<div>
										<div class="team-select">
											<div class="js-no-company select-info">
												<div class="desc-info">
													您还没有创建或加入任何公司/店铺
												</div>
												<div>
													<a href="<?php dourl('store:create');?>"><button type="button" class="btn btn-success btn-xlarge">创建公司和店铺</button></a>
												</div>
												<div class="how-to-join-info">
													您也可以加入别人创建的店铺参与管理&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" target="_blank">如何加入</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="content-addition"></div>
							</div>
							<?php $show_footer_link = false; include display('public:footer');?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>