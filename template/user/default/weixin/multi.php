<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title><?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
        <script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" charset="utf-8" src="./static/js/ueditor/ueditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="./static/js/ueditor/ueditor.all.min.js"></script>
		<?php include display('public:global_header');?>
		<script type="text/javascript">var contents = <?php echo $contents;?>;</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/multi.js"></script>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/image_text.css" type="text/css" rel="stylesheet"/>
		<style type="text/css">
		.app-design.without-add-region .app-preview {
			border-bottom-width: 0;
			padding-bottom: 0;
			border-radius: 0;
		}
		.app-design.without-add-region .app-preview:after {
			position: absolute;
			content:'';
			bottom: 0;
			left: 0;
			width: 0;
			height: 0;
			border: 1px solid #ddd;
			border-radius: 0;
		}
		.app-design .app-preview .app-field.editing {
			cursor: pointer;
		}
		.control-group.error input, .control-group.error select, .control-group.error textarea {
			border-color: #b94a48;
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		}
		.control-group.error .checkbox, .control-group.error .radio, .control-group.error input, .control-group.error select, .control-group.error textarea {
			color: #b94a48;
		}
		.control-group.error .control-label, .control-group.error .help-block, .control-group.error .help-inline {
			color: #b94a48;
		}
		.form-horizontal input + .help-block, .form-horizontal select + .help-block, .form-horizontal textarea + .help-block, .form-horizontal .uneditable-input + .help-block, .form-horizontal .input-prepend + .help-block, .form-horizontal .input-append + .help-block {
			margin-top: 10px;
		}
		.popover{
			display: block;
		}
		.pull-left {
			float: left;
		}
		</style>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<div class="">
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
								<div class="app-design clearfix">
									<div class="alert fade in">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<p class="color-danger">由于微信公众平台的接口规范，仅提供向微信认证服务号商户，提供群发接口。如您的公众号同时具有微信支付权限，您还可以在正文内添加超级链接。</p>
									</div>
									<div class="app-preview">
										<input type="hidden" id="index" value="0"/>
										<input type="hidden" id="pigcms_id" value="<?php echo $pigcms_id; ?>" />
										<input type="hidden" id="url" value="" />
										<input type="hidden" id="url_title" value="" />
										<div class="app-header"></div>
										<div class="app-entry">
											<div class="app-config js-config-region"></div>
											<div class="app-fields appmsg-multiple js-fields-region">
												<div class="app-fields ui-sortable">
													<?php 
														if (empty($text_list)) {
													?>
															<div class="app-field clearfix not-sortable js-not-sortable"  data-id="0">
																<div class="appmsg appmsg-multiple-first">
																	<h4 class="appmsg-title">标题</h4>
																	<p class="appmsg-meta">2015-02-07</p>
																	<div class="appmsg-thumb-wrap">
																		<p>封面图片</p>
																	</div>
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

															<div class="app-field clearfix editing" data-id="0">
																<div class="appmsg appmsg-multiple-others">
																	<h4 class="appmsg-title">标题</h4>
																	<div class="appmsg-thumb-wrap">
																		<p>缩略图</p>
																	</div>
																</div>
																<div class="actions">
																	<div class="actions-wrap">
																		<span class="action edit">编辑</span>
																		<span class="action delete">删除</span>
																	</div>
																</div>
															</div>
													<?php 
														} else {
															foreach($text_list as $i=>$vo){
																if(empty($i)){
													?>
													
																	<div class="app-field clearfix not-sortable js-not-sortable"  data-id="<?php echo $vo['pigcms_id'];?>">
																		<div class="appmsg appmsg-multiple-first">
																			<h4 class="appmsg-title"><?php echo $vo['title'];?></h4>
																			<p class="appmsg-meta"><?php echo date('Y-m-d', $vo['dateline']);?></p>
																			<div class="appmsg-thumb-wrap">
																				<img src="<?php echo $vo['cover_pic'];?>">
																			</div>
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
													<?php 
																}else{
													?>
																	<div class="app-field clearfix editing" data-id="0">
																		<div class="appmsg appmsg-multiple-others">
																			<h4 class="appmsg-title"><?php echo $vo['title'];?></h4>
																			<div class="appmsg-thumb-wrap">
																				<img src="<?php echo $vo['cover_pic'];?>">
																			</div>
																		</div>
																		<div class="actions">
																			<div class="actions-wrap">
																				<span class="action edit">编辑</span>
																				<span class="action delete">删除</span>
																			</div>
																		</div>
																	</div>
													<?php 
																}
															}
														}
													?>
												</div>
											</div>
										</div>
										<div class="js-add-region">
											<div>
												<div class="app-add-field">
													<h4><a class="js-new-field app-add-image-text" data-field-type="image_text">+ 新增</a></h4>
												</div>
											</div>
										</div>
									</div>
									
									<div class="app-sidebar" style="margin-top:82px;">
										<div class="arrow"></div>
										 
										<div class="app-sidebar-inner app-sidebar-single js-sidebar-region">
											<div class="edit-rich-text">
												<form class="form-horizontal" novalidate="" action="" >
													<div class="control-group">
														<label>标题</label>
														<input type="text" name="title" id="title" value="" data-error-style="block">
													</div>
													<div class="control-group">
														<label>作者<span class="label-desc">（选填）</span></label>
														<input type="text" name="author" id="author" value="" data-error-style="block">
													</div>
													<div class="control-group image-region js-image-region">
														<div>
															<label>封面<span class="label-desc">（图片建议尺寸：900 x 500像素）</span></label>
															<a class="js-add-image-one control-action" href="javascript:;">添加图片...</a>
															<input type="hidden" name="image" id="image">
														</div>
													</div>
													<div class="control-group">
														<label class="checkbox">
															<input type="checkbox" name="show_image" id="show_image">封面图片显示在正文中
														</label>
													</div>
													
													<div class="control-group digest">
														<label>摘要</label>
														<textarea id="digest" name="digest" cols="30" rows="3"></textarea>
													</div>
													
													<div class="control-group" id="text-content">
														<label>正文</label>
														<textarea class="js-editor edui-default" id="content" name="content"></textarea>
													</div>
													
													<div class="control-group js-link-region">
														<div>
															<label>阅读原文</label>
															<div class="dropup hover">
																<a class="js-dropdown-toggle dropdown-toggle control-action" href="javascript:void(0);" style="color:#07d;position:relative;">设置链接到的页面地址 <i class="caret"></i></a>
															</div>
														</div>
													</div>
													<textarea name="editorValue" id="ueditor_textarea_editorValue" style="display: none;"></textarea>
												</form>
											</div>
										</div>
									</div>
									<div class="app-actions" style="bottom: 0px;">
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
				<?php include display('sidebar');?>
			</div>
		</div>
	</body>
</html>