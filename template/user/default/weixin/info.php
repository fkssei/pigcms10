<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>公众号信息 - <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/sendall.css" rel="stylesheet" type="text/css"/>
		<style>
		
		</style>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="nav-wrapper--app"></div>
						<div class="app__content page-setting-weixin">
							<div>
								<div class="wx-qrcode-wrap">
									<img class="wx-qrcode" src="<?php echo ($weixin_bind['alias'] ? 'http://open.weixin.qq.com/qr/code/?username='.$weixin_bind['alias'] : $weixin_bind['qrcode_url']);?>"/>					
								</div>
								<form class="form-horizontal weixin-form">
									<div class="control-group">
										<label class="control-label" for="mp-weixin">公众微信号：</label>
										<div class="controls">
											<div class="control-action"><?php echo ($weixin_bind['alias'] ? $weixin_bind['alias'] : $weixin_bind['user_name']);?></div>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="mp-nickname">公众号昵称：</label>
										<div class="controls">
											<div class="control-action"><?php echo $weixin_bind['nick_name'];?></div>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="mp-nickname">微信账号类型：</label>
										<div class="controls">
											<div class="control-action"><?php echo $weixin_bind['service_type_txt'];?></div>
										</div>
									</div>
									<div class="control-group">
										<div class="controls info-pane">
											<p>如果您的公众号已修改类型，<br/>请在微信公众平台取消授权后再进行授权！</p>
										</div>
									</div>
								</form>
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