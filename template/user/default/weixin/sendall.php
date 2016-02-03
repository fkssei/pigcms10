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
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/sendall.js"></script>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/sendall.css" rel="stylesheet" type="text/css"/>
		<style>
		#kdt_news_preview .pre_container {
			position: static;
			float: none;
		}

		#kdt_preview {
			border: 2px solid transparent;
			min-height: auto;
			background-color: transparent;
			margin-left: 128px;
			padding: 0;
		}

		.wd_module {
			margin-bottom: 0;
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
						<div class="app__content page-showcase-dashboard">
							<div id="main">
								<div id="kdt_messages_news" class="content">
									<div class="wd_module">
										<div class="module_cont">
											<form id="J_form_messages_link" class="form-horizontal kdt_form fm_topic" novalidate="">
												<div class="alert alert-info" style="text-align: left;">仅向认证服务号和认证的订阅号提供群发功能；</div>
												<div class="control-group">
													<label class="control-label">信息发送给：</label>
													<div class="controls" id="J_fans_selector">
														<input value="" type="hidden" class="for-post" id="J_fans_id" required="" name="fans_id">
														<div class="filtred_fans">
															<a data-toggle="button" class="filter-selector active" id="J_filter_selector" href="javascript:;">所有人</a>
															<div class="reciever_post">
																<!--span class="num">准备向 74 人发送信息</span>
																<span class="attach_txt"><a href="javascript:;">筛选</a></span-->
															</div>
														</div>
													</div>
												</div>
							                    <hr>
												<div class="control-group hide">
													<div class="controls">
														<input type="hidden" class="for-post" name="type" value="0" id="J_type"/>
														<input type="hidden" class="for-post" name="source_id" value="0" id="J_source_id"/>
														<input type="hidden" class="for-post" name="image" id="J_image"/>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">发送内容：</label>
													<div class="controls">
							                            <ul class="msg_multiple_nav">
															<li class="active"><a href="javascript:void(0);" id="J_text" data-type="text">文本信息</a></li>
															<li><a href="javascript:void(0);" id="J_image" class="open_img_modal" data-type="image">图片</a></li>
															<!--li><a href="javascript:void(0);" id="J_voice" data-type="voice">语音</a></li-->
															<li><a href="javascript:void(0);" id="J_pic" data-type="pic">单条图文</a></li>
															<li><a href="javascript:void(0);" id="J_pics" data-type="pics">多条图文</a></li>
														</ul>
														<div class="msgSenderPlugin" style="display:block;">
															<ul class="tab clearfix"></ul>
															<script type="text/plain" id="editor" name="content"></script>
															<div class="imgContainer">
																<ul id="J_img_container" class="choosed_img clearfix">
																</ul>
															</div>
															<div class="form-actions"></div>
														</div>
													</div>
												</div>
												<div id="btn_actions" class="btn_actions">
													<div style="position:relative;">
														<div class="pin"></div>
														<div class="form-actions ta-c" style="position: fixed; z-index: 1020; bottom: 0px; width: 840px; box-sizing: border-box;">
															<input type="hidden" data-action-type="preview" id="J_action_type" data-task-type="reply">
															<a data-loading-text="正在发送..." class="btn btn-success btn_notify" href="javascript:void(0);" data-original-title="">直接群发</a>
															<!--input data-loading-text="手机预览" type="submit" class="btn btn_prefire btn-preview" value="手机预览">
															<a href="javascript:void(0);" class="btn btn_timer"> 定时发送 </a-->
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include display('sidebar');?>
		</div>
		<?php include display('public:footer');?>
	</body>
</html>