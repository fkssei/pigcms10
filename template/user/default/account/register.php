<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>注册 | <?php echo $config['site_name'];?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/login.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/register.js"></script>
	</head>
	<body>
		<div id="hd" class="wrap rel">
			<div class="wrap_1000 clearfix">
				<h1 id="hd_logo" class="abs" title="<?php echo $config['site_name'];?>">
					<a href="./">
						<img src="<?php echo $config['site_logo'];?>" height="35" alt="<?php echo $config['site_name'];?>"/>
					</a>
				</h1>
				<h2 class="tc hd_title">用户注册</h2>
			</div>
		</div>
		<div id="registerPane" class="kd-regist">
			<div class="kd-regist-wrapper">		
				<?php if($config['web_login_show'] != 2){ ?>
					<div class="kd-regist-title">用户注册</div>
					<div class="J_textboxPrompt input-phone">
						<input id="phone" name="phone" type="text" autocomplete="off"/>
						<label class="input-text">请输入您的手机号码</label>
						<span class="icon"></span>
					</div>
					<div class="J_textboxPrompt input-nick">
						<input id="nickname" name="nickname" type="text" autocomplete="off"/>
						<label class="input-text">请输入您的昵称</label>
						<span class="icon"></span>
					</div>
					<div class="J_textboxPrompt input-pwd">
						<input id="password" name="password" type="password" autocomplete="off"/>
						<label class="input-text">请输入您的密码</label>
						<span class="icon"></span>
					</div>
					<div id="J_registError" class="kd-form-error"></div>
					<input id="phoneValidate" class="kd-form-btn" type="button" value="注	册" style="width:168px;"/>
					<a style="margin-left:20px;font-size:12px;" href="./account.php">已有帐号？前往登录</a>
					<?php if($config['web_login_show'] != 1){ ?>
						<div class="oauth-wrapper">
							<h3 class="title-wrapper"><span class="title">使用微信扫码登录</span></h3>
							<div class="oauth cf">
								<a class="oauth__link oauth__link--weixin" id="wx_login" href="javascript:void(0);"></a>
							</div>   
						</div>
					<?php } ?>
				<?php }else{ ?>
					<iframe src="./index.php?c=recognition&a=see_login_qrcode&mt=none&referer=.%2Fuser.php" style="border:none;height:390px;margin-left:40px;"></iframe>
				<?php } ?>
			</div>
		</div>
	</body>
</html>