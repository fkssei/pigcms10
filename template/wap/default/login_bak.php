<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>登录</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/buyer.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script>var redirect_uri="<?php echo $redirect_uri;?>";</script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/login.js"></script>
	</head>
	<body>
		<!-- container -->
		<div class="container js-modal-login">
            <div class="account-form login-form">
				<form class="js-login-form " method="GET" action="<?php echo $redirect_uri;?>">
					<h2 class="js-login-title form-title big">
						<span>请先登录账号</span>
					</h2>
					<!-- 表单主体 -->
					<ul class="block block-form margin-bottom-normal">
						<li class="block-item">
							<label for="phone">手机号码</label>
							<input id="phone" type="tel" name="phone" maxlength="11" class="js-login-phone" autocomplete="off" placeholder="请输入您的手机号" value="">
						</li>
						<li class="block-item" style="margin-bottom: -1px">
							<label for="password">登录密码</label>
							<input id="password" type="password" name="password" autocomplete="off" class="js-login-pwd" placeholder="请填写您的密码">
						</li>
						<li class="relative block-item js-auth-code-li auth-hide" style="margin-top: 1px">
							<label for="code">验证码</label>
							<input id="code" type="tel" name="code" class="js-auth-code" placeholder="请输入短信验证码" maxlength="6">
							<button type="button" class="btn btn-green btn-auth-code font-size-12 js-auth-code-btn">获取验证码</button>
						</li>
					</ul>
					<div class="action-container">
						<button type="submit" class="js-submit btn btn-green btn-block" disabled="disabled">登录</button>
					</div>
					<div class="action-links">
						<p class="center">
							<a class="js-login-mode c-blue" href="javascript:;">注册账号</a>
						</p>
					</div>
				</form>
			</div>
        </div>
	</body>
</html>