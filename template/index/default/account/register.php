<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>会员注册 -<?php echo $config['seo_title'] ?></title>
	<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
	<meta name="description" content="<?php echo $config['seo_description'] ?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/public.css">
    <link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/index.css">
    <link type="text/css" rel="stylesheet"	href="<?php echo TPL_URL;?>css/login.css" />
    <script type="text/javascript" src="./static/js/jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/jquery.form.min.js"></script>
	<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
    <script src="<?php echo TPL_URL;?>js/common.js"></script>
    <script>
    $(document).ready(function () {
    	$('#register').ajaxForm({
    		beforeSubmit: showRequest,
    		success: showResponse,
    		dataType: 'json'
    	});
		$("#username1").focus();
		$('#wx_login').click(function(){
			$.layer({
				type: 2,
				title: false,
				shadeClose: true,
				shade: [0.4, '#000'],
				area: ['330px','430px'],
				border: [0],
				iframe: {src:'./index.php?c=recognition&a=see_login_qrcode&referer=<?php echo urlencode($referer);?>'}
			}); 
		});
    });

   
	function showRequest() {
		var phone = $("#phone").val();
		var nickname = $("#nickname").val();
		var password = $("#password").val();

		if (phone.length == 0 && nickname.length == 0 && password.length == 0) {
			tusi("请填写手机号，昵称和密码");
			//$("#msg").html("请填写用户和密码");
			return false;
		}

		if (!checkMobile(phone)) {
			tusi("请正确填写您的手机号");
			//$("#msg").html("请正确填写您的手机号");
			$("#username").focus();
			return false;
		}

		if (nickname.length == 0) {
			tusi('请填写昵称');
			$("#nickname").focus();
			return false;
		}

		if (password.length < 6) {
			tusi("密码不能少于六位，请正确填写");
			$("#password").focus();
			//$("#msg").html("密码不能少于六位，请正确填写");
			return false;
		}

		return true;
	}
    </script>
</head>

<body>
<div class="mod-search">
		<div class="v-h-login">
			<a class="logo entire" href="<?php echo $config['site_url'];?>" style="background:url('<?php echo $config['site_logo'];?>') no-repeat 50% 50%;"></a>
		</div>
	</div>

<div class="b-wrapper">
	<div class="v-login-body clearfix">
		<div class="v-login-form">
			<div id="loginPane" class="kd-login">
				<?php if($config['web_login_show'] != 2){ ?>
					<div class="kd-login-wrapper">
						<form id="register" action="<?php echo url('account:register') ?>" method="post">
							<div class="kd-login-title">
								<a href="<?php echo url('account:login') ?>" class="v-login-register">登录&gt;&gt;</a>
								<h6>注册</h6>
							</div>
							<div class="J_textboxPrompt input-phone">
								<input cssErrorClass="error" id="phone" size="25" maxlength="11" tabindex="1" name="phone" autocomplete="off" htmlEscape="true" placeholder="手机号码"/>
								<span class="icon"></span>
							</div>
							<div class="J_textboxPrompt input-nick">
								<input cssErrorClass="error" id="nickname" size="25" tabindex="2" path="nickname" name="nickname" autocomplete="off" htmlEscape="true" placeholder="昵称"/>
								<span class="icon"></span>
							</div>
							<div class="J_textboxPrompt input-pwd">
								<input id="password" name="password" class="required" tabindex="3" accesskey="p" type="password" value="" size="25" autocomplete="off" placeholder="密码"/>
								<span class="icon"></span>
							</div>
							<!-- <div class="auto-login">
								 <span class="v-login-forget-pwd"><a data-piwik-spm='{"n":"&#x5FD8;&#x8BB0;&#x5BC6;&#x7801;"}'
									href="#" target="_blank">忘记密码了?</a></span>
							</div> -->
							<section class="row btn-row" style="height: 89px; position: relative;">
								<input type="hidden" name="_eventId" value="submit" /> 
								<input id="J_Login" class="orangeBtn large" name="submit" accesskey="l" value="注  册" tabindex="4" type="submit" style="position: absolute; top: 50px;"/>
								<div id="msg" class="errors kd-form-error"></div>
							</section>
							<?php if($config['web_login_show'] != 1){ ?>
								<div class="oauth-wrapper">
									<h3 class="title-wrapper"><span class="title">用手机微信扫码登录</span></h3>
									<div class="oauth cf">
										<a class="oauth__link oauth__link--weixin" id="wx_login" href="javascript:void(0);"></a>
									</div>   
								</div>
							<?php } ?>
						</form>
					</div>
				<?php }else{ ?>
					<iframe src="./index.php?c=recognition&a=see_login_qrcode&mt=none&referer=<?php echo urlencode($referer);?>" style="border:none;height:390px;"></iframe>
				<?php } ?>
			</div>
		</div>
		<a class="v-login-ad-a" target="_blank" href="<?php echo $ad['url'] ?>">
			<img src="<?php echo $ad['pic'] ?>" alt="<?php echo $ad['name'] ?>" />
		</a>
	</div>
	

      <footer>
        <div id="J_footer" class="footer">
	        <p class="copyright">
	        	© 2015 <?php echo getUrlTopDomain($config['site_url']); ?>   <?php echo $config['site_icp'];?> 	
	        </p>
        </div>
      </footer>
    </div>
  
	<div style="display:none;"><?php echo $config['site_footer'];?></div>
  </body>
</html>
