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
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/tail.js"></script>
		<script type="text/javascript">var content = '<?php echo $reply_tail['content'];?>'</script>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css">
		<style type="text/css">
		.popover{
			display: block;
		}
		.label {
		  padding: 1px 4px 2px;
		  font-size: 10.998px;
		  font-weight: bold;
		  line-height: 13px;
		  color: #ffffff;
		  vertical-align: middle;
		  white-space: nowrap;
		  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		  background-color: #999999;
		  -webkit-border-radius: 3px;
		  -moz-border-radius: 3px;
		  border-radius: 3px;
		}
		.label:hover {
		  color: #ffffff;
		  text-decoration: none;
		}
		.theme_blue .btn-success {
		background-color: #07d;
		border-color: #006cc9;
		}
		.theme_blue .btn-success:hover, .theme_blue .btn-success:active, .theme_blue .btn-success.active, .theme_blue .btn-success.disabled, .theme_blue .btn-success[disabled] {
		background-color: #0080ed;
		}
		.mal15 {
		margin-left: 15px !important;
		}
		.label-success {
		background-color: #468847;
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
								<li>
									<a href="/user.php?c=weixin&a=auto">关键词自动回复</a>
								</li>
								<li>
									<a href="/user.php?c=weixin&a=auto_reply">关注后自动回复</a>
								</li>
								<!--li>
									<a href="">消息托管</a>
								</li-->
								<li class="active">
									<a href="/user.php?c=weixin&a=tail">小尾巴</a>
								</li>
							</ul>
						</nav>
						<div id="kdt_messages_autoreply" class="content clearfix">
							<div class="kdt_module">
								<div class="module_cont">
									<div id="J_autoreply_rules" class="autoreply_rules">
										<div id="tail_on_off" class="form-horizontal kdt_form pull-left">
											<p style="margin-bottom: 15px;">开启后，回复给粉丝的文本消息末尾都会自动加上“小尾巴”里的内容</p>
											<div class="control-group">
												<label class="control-label">状态：</label>
												<div class="controls">
													<?php if ($reply_tail['is_open']) {?>
													<span class="label label-success">已开启</span>
													<button type="button" data-loading-text="请稍候..." class="btn mal15" data-val="0" id="operation">关闭</button>
													<?php } else {?>
													<span class="label">未开启</span>
													<button type="button" data-loading-text="请稍候..." class="btn mal15 btn-success" data-val="1" id="operation">开启</button>
													<?php }?>
												</div>
											</div>
										</div>
										<div id="form_tail" class="form-horizontal kdt_form pull-left">
											<div class="control-group">
												<label class="control-label">内容：</label>
												<div class="controls">
													<div style="min-height: 200px;"><textarea rows="10" cols="160" id="content"></textarea></div>
													<p class="help-block">不多于200个字（含链接字符数）</p>
												</div>
											</div>
											<div class="form-actions">
												<input data-loading-text="请稍候..." type="button" class="btn mal15 btn-success" value="&nbsp;保&nbsp;存&nbsp;">
											</div>
										</div>
										<div class="autoreply_rules_opts clearfix"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>