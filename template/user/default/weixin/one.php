<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title><?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
        <script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" charset="utf-8" src="./static/js/ueditor/ueditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="./static/js/ueditor/ueditor.all.js"></script>
		<script type="text/javascript">var content = '<?php echo $image_text['content'];?>';</script>
		<?php include display('public:global_header');?>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/one.js"></script>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/image_text.css" type="text/css" rel="stylesheet"/>
		<style type="text/css">
			.pull-left {
				float: left;
			}
		</style>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<nav class="ui-nav">
							<ul>
								<li id="js-nav-list-index" class="active">
									<a href="">微信图文</a>
								</li>
							</ul>
						</nav>
						<div class="app__content js-app-main">
							<div class="app-design clearfix without-add-region">
								<div class="alert fade in">
									<button type="button" class="close" data-dismiss="alert">×</button>
									<p class="color-danger">由于微信公众平台的接口规范，仅提供向微信认证服务号商户，提供群发接口。如您的公众号同时具有微信支付权限，您还可以在正文内添加超级链接。</p>
								</div>
								<div class="app-preview">
									<div class="app-header"></div>
									<input type="hidden" id="pigcms_id" value="<?php echo $pigcms_id; ?>" />
									<input type="hidden" id="thisid" value="<?php echo $image_text['pigcms_id']; ?>" />
									<div class="app-entry">
										<div class="app-config js-config-region">
											<div class="app-field clearfix">
												<h1><span>微信图文</span></h1>
											</div>
										</div>
										<div class="app-fields appmsg-single js-fields-region">
											<div class="app-fields ui-sortable">
												<div class="app-field clearfix not-sortable js-not-sortable editing">
													<div class="appmsg appmsg-multiple-first">
														<h4 class="appmsg-title"><?php echo $image_text['title']; ?></h4>
														<p class="appmsg-meta"><?php echo date('Y-m-d', $image_text['dateline']);?></p>
														<div class="appmsg-thumb-wrap">
															<?php 
																if ($image_text['cover_pic']) {
															?>
															<img src="<?php echo $image_text['cover_pic'];?>">
															<?php 
																} else {
															?>
															<p>封面图片</p>
															<?php 
																}
															?>
														</div>
														<div class="appmsg-digest"><?php echo $image_text['digest'];?></div>
														<div class="appmsg-view-full clearfix">
															<span>阅读全文</span>
															<span class="pull-right">&gt;</span>
														</div>
													</div>
													<div class="actions">
														<div class="actions-wrap">
															<span class="action edit">编辑</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="app-sidebar" style="margin-top:142px;">
									<div class="arrow"></div>
									 
									<div class="app-sidebar-inner app-sidebar-single js-sidebar-region">
										<div class="edit-rich-text">
											<form class="form-horizontal" novalidate="" action="" >
												<div class="control-group">
													<label>标题</label>
													<input type="text" name="title" id="title" value="<?php echo $image_text['title'];?>" data-error-style="block">
													<input type="hidden" name="url" id="url" value="<?php echo $image_text['url'];?>" />
													<input type="hidden" name="url_title" id="url_title" value="<?php echo $image_text['url_title'];?>" />
												</div>
												<div class="control-group">
													<label>作者<span class="label-desc">（选填）</span></label>
													<input type="text" name="author" id="author" value="<?php echo $image_text['author'];?>" data-error-style="block">
												</div>
												<div class="control-group image-region js-image-region">
													<div>
														<label>封面<span class="label-desc">（图片建议尺寸：900 x 500像素）</span></label>
														<?php if ($image_text['cover_pic']) { ?>
															<img src="<?php echo $image_text['cover_pic'];?>" width="100" height="100"/>
														<?php } ?>
														<?php if(empty($image_text)){ ?>
															<a class="js-add-image-one control-action" href="javascript:;">添加图片...</a>
														<?php }else{ ?>
															<a class="js-add-image-one control-action" href="javascript:;">重新选择</a>
														<?php } ?>
														<input type="hidden" name="image" id="image" value="<?php echo $image_text['cover_pic'];?>">
													</div>
												</div>
												<div class="control-group">
													<label class="checkbox">
														<input type="checkbox" name="show_image" id="show_image" <?php if($image_text['is_show']) echo 'checked'; ?> >封面图片显示在正文中
													</label>
												</div>
												<div class="control-group digest">
													<label>摘要</label>
													<textarea id="digest" name="digest" cols="30" rows="3"><?php echo $image_text['digest'];?></textarea>
												</div>
												<div class="control-group">
													<label>正文</label>
													<textarea class="js-editor edui-default" id="content" name="content"></textarea>
												</div>
												<div class="control-group js-link-region ">
													<div>
														<label>阅读原文</label>
														<?php if(empty($image_text['url'])){ ?>
															<div class="dropup hover">
																<a class="js-dropdown-toggle dropdown-toggle control-action" href="javascript:void(0);" style="color:#07d;position:relative;">设置链接到的页面地址 <i class="caret"></i></a>
															</div>
														<?php }else{ ?>
															<div class="dropup hover">
																<div class="left js-link-to link-to"><a href="<?php echo $image_text['url']?>" target="_blank" class="new-window link-to-title"><span class="label label-success"><?php echo $image_text['url_title'];?></span></a></div><a class="dropdown-toggle js-dropdown-toggle" href="javascript:void(0);" style="color:#07d;position:relative;">修改 <i class="caret"></i></a>
															</div>
														<?php } ?>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="app-actions" style="bottom:0px;">
									<div class="form-actions text-center">
										<input class="btn btn-primary btn-add" type="submit" value="上 架" data-loading-text="上架...">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="notify-bar js-notify animated hinge hide"></div>
				</div>
			</div>
		</div>
	</body>
</html>