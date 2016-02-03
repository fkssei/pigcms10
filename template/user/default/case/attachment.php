<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>我的文件 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		<meta name="author" content="小猪CMS"/>
		<meta name="generator" content="小猪CMS微店程序"/>
		<meta name="copyright" content="pigcms.com"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/attachment.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="./static/js/area/area.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">var load_url="<?php dourl('case_load');?>",get_url="<?php dourl('attchment_get');?>",edit_name_url="<?php dourl('attchment_amend_name');?>",delete_url="<?php dourl('attchment_delete');?>",del_more_url="<?php dourl('attchment_delete_more');?>";</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/attachment.js"></script>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="nav-wrapper--app">
							<nav class="nav nav--app clearfix">
								<ul class="third-nav with-fourth clearfix">
									<li>
										<ul class="third-nav__links">
											<li id="js-nav-list-index" class="active">
												<a href="#">全部文件</a>
											</li>
										</ul>
									</li>
									<li>
										<span class="divide">|</span>
										<ul class="third-nav__links">
											<li id="js-nav-list-image">
												<a href="#list_image">所有图片</a>
											</li>
											<li id="js-nav-list-upload_image">
												<a href="#list_upload_image">上传的</a>
											</li>
											<li id="js-nav-list-import_image" class="">
												<a href="#list_import_image">导入的</a>
											</li>
											<li id="js-nav-list-collect_image" class="">
												<a href="#list_collect_image">收藏的</a>
											</li>
										</ul>
									</li>
									<li>
										<span class="divide">|</span>
										<ul class="third-nav__links">
											<li id="js-nav-list-voice" class="">
												<a href="#list_voice">语音</a>
											</li>
											<li id="js-nav-list-upload_voice" class="">
												<a href="#list_upload_voice">上传的</a>
											</li>
											<li id="js-nav-list-collect_voice" class="">
												<a href="#list_collect_voice">收藏的</a>
											</li>
										</ul>
									</li>
									<li>
										<span class="divide">|</span>
										<ul class="third-nav__links">
											<li>
												<a href="javascript:;" class="js-upload-image">上传图片</a>
											</li>
											<li>
												<a href="javascript:;" class="js-upload-voice">上传语音</a>
											</li>
										</ul>
									</li>
								</ul>
								<div class="js-list-search form--search">
									<input class="txt" type="text" placeholder="输入名称搜索"/>
								</div>
							</nav>
						</div>
						<div class="app__content"></div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>