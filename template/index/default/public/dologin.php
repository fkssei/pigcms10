<?php if(!defined( 'PIGCMS_PATH')) exit( 'deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录-<?php echo $config['seo_title'] ?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/public.css">
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script src="<?php echo TPL_URL;?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/jquery.lazyload.min.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.form.min.js"></script>

<script>
		var has_property = "<?php echo $product['has_property'] ?>";
		var product_sku = <?php echo json_encode($product_sku_list) ?>;
		var is_sku = "<?php echo $product['show_sku'] ?>";
	</script>
<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
<script>
		$(function(){
			$('#login').ajaxForm({
				beforeSubmit: showRequest,
				success: iframe_showResponse,
				dataType: 'json'
			});
			$("#phone").focus();
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
			var password = $("#password").val();

			if (phone.length == 0 && password.length == 0) {
				tusi("请填写手机号和密码");
				return false;
			}

			if (!checkMobile(phone)) {
				tusi("请正确填写您的手机号");
				return false;
			}

			if (password.length < 6) {
				tusi("密码不能少于六位，请正确填写");
				return false;
			}
			return true;
		}


		function iframe_showResponse(data) {

			if (data.status == true) {
				//当有信息提示时
				if (data.msg != '') {
					if (data.data.nexturl != '' && data.data.nexturl != 'undefined') {
						j_url = data.data.nexturl;
					}
					//refresh_vdcode();
					parent.tusi(data.msg);
				}
				window.parent.location.reload();
			} else {
				if (data.msg != '') {
					tusi(data.msg);
				}
			}
			return true;
		}


	</script>
<style type="text/css">
.box-shadow-sec { margin: 0 auto; min-width: 150px; width: 100%; border-collapse: collapse; border-spacing: 0; }
.bs-left, .bs-middle, .bs-right { height: 12px; width: 11px }
.bs-header .bs-left { background: #00bb88; height: 55px }
.bs-header .bs-middle { background: #00bb88; height: 55px }
.bs-middle-title { height: 40px; font: 16px/45px '\5FAE\8F6F\96C5\9ED1'; color: #fff; text-align: left; letter-spacing: 1px }
.bs-header .bs-right { background: #00bb88; height: 55px }
.bs-body .bs-left { background: #fff }
.bs-body .bs-main { background: #fff }
.bs-body .bs-right { background: #fff }
.bs-footer .bs-left { background: #fff }
.bs-footer .bs-middle { background: #fff }
.bs-footer .bs-right { background: #fff }
.miniLogin-close, .J_weixinDialog-close, .J_ConfirmReceiptDialog-close, .J_downDialog-close { background-image: url(<?php echo TPL_URL;
?>images/vdian/dial_close.png); _background-image: url(<?php echo TPL_URL;
?>images/vdian/dial_close_8.png); background-repeat: no-repeat; background-position: 0 0; width: 40px; height: 40px; position: absolute; cursor: pointer; right: 20px; top: 10px }
.miniLogin-close:HOVER, .general-close, .J_weixinDialog-close:HOVER, .J_ConfirmReceiptDialog-close:HOVER, .J_downDialog-close:HOVER { background-position: -39px 0 }
a.search-tag-a { padding: 0 10px }
.kd-login { padding-top: 45px }
.kd-login-title { font-size: 16px; margin-bottom: 15px; color: #404040 }
.kd-login-title h6 { font-size: 12px; font-weight: bold; line-height: 28px; }
.kd-login-title a { color: #404040; text-decoration: underline }
.ie7 .input_for_login, .ie8 .input_for_login { height: 30px }
.ie7 .input_for_login, .ie7 .input-code input, .ie7 .input-nick input, .ie7 .input-phone input, .ie7 .input-pwd input, .ie7 .input-code, .ie8 .input-code input, .ie8 .input-nick input, .ie8 .input-phone input, .ie8 .input-pwd input, .ie8 .input_for_login, .ie8 .input-code { padding-top: 2px; padding-bottom: 2px; border: 1px solid #ddd }
.input-code, .input-nick, .input-phone, .input-pwd { width: 320px; position: relative; margin-bottom: 12px }
.input-code .icon, .input-nick .icon, .input-phone .icon, .input-pwd .icon { position: absolute; z-index: 1; top: 0; right: 0; left: 1px; height: 35px; _width: 100%; *left: 1px;
*top: 1px;
*height: 37px;
background: #fff url(<?php echo TPL_URL;?>images/login_bg_icons.png) no-repeat }
.input-phone .icon { background-position: 0 0 }
.input-pwd .icon { background-position: 0 -120px }
.input-nick .icon { background-position: 0 -60px }
.input-code .icon { background-position: 0 -180px }
.input-code label.input-text, .input-nick label.input-text, .input-phone label.input-text, .input-pwd label.input-text, .regist-validate label.input-text { position: absolute; top: 8px; left: 55px; z-index: 2; display: block; color: #d1d0d0; cursor: text; -moz-user-select: none; -webkit-user-select: none; -moz-transition: all .16s ease-in-out; -webkit-transition: all .16s ease-in-out }
.regist-validate label.input-text { left: 10px }
.regist-validate { position: relative; margin-bottom: 20px }
.regist-validate .v_error span { display: none }
.validator_error span, .regist-validate .v_error span { border: 1px solid #d6d6d6; border-left: 0; border-top-right-radius: 3px; border-bottom-right-radius: 3px; -webkit-border-top-right-radius: 3px; -webkit-border-bottom-right-radius: 3px; -moz-border-radius-bottomright: 3px; -moz-border-radius-topright: 3px; height: 39px; display: inline-block; background: #fffede; padding-right: 10px; line-height: 39px; background: #fffede }
.input-code input, .input-nick input, .input-phone input, .input-pwd input {-moz-box-sizing: border-box; -ms-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; resize: none; outline: 0; position: relative; z-index: 3; display: block; width: 100%; *width: 264px;
background: transparent; padding-left: 55px; height: 36px; line-height: 100%; line-height: 36px\9; color: #666; font-size: 14px; font-weight: 700; border: 1px solid #d9d9d9; box-shadow: inset 0 1px 4px rgba(125,125,125,.65); -moz-box-shadow: inset 0 1px 4px rgba(125,125,125,.65); -webkit-box-shadow: inset 0 1px 4px rgba(125,125,125,.65); -webkit-transition: all .08s ease-in-out; -moz-transition: all .08s ease-in-out }
.input-code { width: 200px; *width: 200px
}
.input-code input { width: 200px; *width: 145px
}
.input-code label.validator_error { left: 210px; *left: 220px
}
.auto-login { line-height: 18px; padding-top: 10px }
.auto-login input[type="checkbox"] { width: 14px; height: 14px }
.kd-form-error { height: 50px; color: #fcd500; font-size: 12px }
.kd-login .kd-form-error { line-height: 50px; width: 500px }
.kd-form-btn { display: inline-block; background: #f60; background: linear-gradient(#f60, #f50); box-shadow: inset 0 1px 0 rgba(255,255,255,.08), 0 1px 0 rgba(255,255,255,.3); text-shadow: 0 -1px 0 rgba(0,0,0,.1); color: #fff; border: 1px solid #c90000; font-size: 18px; padding: 0; border-radius: 3px; height: 40px; line-height: 40px; width: 320px; text-align: center; cursor: pointer }
.kd-form-btn.orangeBtn { display: inline-block; *display: inline;
*zoom: 1;
padding: 0 17px; line-height: 37px; height: 37px; text-align: center; border-radius: 3px; font-size: 12px; border: 0; font-weight: normal; color: #fff; cursor: pointer; background: #00bb88; background: -webkit-gradient(linear, 0 0, 0 100%, from(#00bb88), to(#00bb88)); background-image: -ms-linear-gradient(top, #00bb88 0, #00bb88 100%); background-image: -moz-linear-gradient(top, #00bb88 0, #00bb88 100%); background-image: -o-linear-gradient(top, #00bb88 0, #00bb88 100%); background-image: -webkit-linear-gradient(top, #00bb88 0, #00bb88 100%); background-image: linear-gradient(to bottom, #00bb88 0, #00bb88 100%) }
.kd-form-btn.orangeBtn:hover { color: #fff; background: #00bb88; text-decoration: none }
.v-login-form .kd-login { position: relative; z-index: 10; display: inline; float: right; margin-right: 20px; box-shadow: 0 0 5px rgba(200,200,200,0.5) }
.v-login-ad-a { display: block; float: left; height: 250px; margin: 0 auto; width: 430px; margin-top: 37px }
.v-login-ad-a img { display: block; width: 430px; height: 250px }
.v-login-register { position: relative; bottom: 0; display: block; float: right; font-size: 12px; vertical-align: bottom; line-height: 28px }
.v-login-form .kd-login { padding-top: 0; padding: 15px 43px; background: #fff; border: 1px solid #ddd }
.v-login-form .kd-form-error { width: 282px; color: #fc6000 }
.v-login-form .v-login-register { text-decoration: none }
.v-login-forget-pwd { margin-left: 10px }
.v-login-next-auto { margin-right: 8px }
.v-login-next-auto input { vertical-align: middle }
.v-login-form .kd-form-btn { height: 37px; line-height: 37px }
.v-login-form .orangeBtn { width: 100% }
.v-login-form .input-code, .v-login-form .input-nick, .v-login-form .input-phone, .v-login-form .input-pwd { width: 282px }
.v-login-form label.validator_error { width: 170px }
.v-login-form .other-register { padding-top: 26px; display: none }
.v-login-form .other-register h3 { font-size: 16px; margin-bottom: 25px }
.v-login-form .other-register-qq, .v-login-form .other-register-weibo { padding: 3px 0 6px 32px; margin-right: 35px; background-image: url(<?php echo TPL_URL;
?>images/login_bg_icons.png); background-repeat: no-repeat }
.v-login-form .other-register-qq { background-position: 0 -280px }
.v-login-form .other-register-weibo { background-position: 0 -240px }
.v-login-form .input-code label.validator_error, .v-login-form .input-nick label.validator_error, .v-login-form .input-phone label.validator_error, .v-login-form .input-pwd label.validator_error { left: 282px }
.miniLogin .v-login-form .kd-login { margin: 0; -webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border: 0 }
.miniLogin .bs-middle-title { margin-left: 20px }
.open_shop { text-align: center; line-height: 40px; }
.open_shop a { display: block; color: #fff; text-decoration: none; background: #00bb88; }
.open_shop a:hover, .open_shop a:active { color: #fff; text-decoration: none; background: #ff6666; }
</style>
</head>

<body>
<div id="miniLogin" class="miniLogin" style="width:370px;height:460px;overflow:hidden">
  <table class="box-shadow-sec">
    <tbody>
      <tr class="bs-header">
        <td class="bs-left"></td>
        <td class="bs-middle" style="text-align: center;"><div class="bs-middle-title"> <?php echo $config['seo_title'] ?> </div></td>
        <td class="bs-right"><div id="miniLogin-close" class="miniLogin-close"> &nbsp; </div></td>
      </tr>
      <tr class="bs-body">
        <td class="bs-left"></td>
        <td class="bs-main"><div class="v-login-form">
            <div id="loginPane" class="kd-login">
              <div class="kd-login-wrapper">
                <form id="login" action="<?php echo url('account:ajax_login') ?>" method="post">
                  <div class="kd-login-title"> <a href="javascript:void(0);" class="v-login-register">注册&gt;&gt;</a>
                    <h6>登录</h6>
                  </div>
                  <div class="J_textboxPrompt input-phone">
                    <input cssErrorClass="error" id="phone" size="25" maxlength="11" tabindex="1" path="username" name="phone" autocomplete="off" htmlEscape="true" placeholder="手机号码"/>
                    <span class="icon"></span> </div>
                  <div class="J_textboxPrompt input-pwd">
                    <input id="password" name="password" class="required" tabindex="2" accesskey="p" type="password" value="" size="25" autocomplete="off" placeholder="密码"/>
                    <span class="icon"></span> </div>
                  <!-- <div class="auto-login">
									 <span class="v-login-forget-pwd"><a data-piwik-spm='{"n":"&#x5FD8;&#x8BB0;&#x5BC6;&#x7801;"}' href="#" target="_blank">忘记密码了?</a></span>
								</div> -->
                  <section class="row btn-row" style="height: 89px; position: relative;">
                    <input type="hidden" name="_eventId" value="submit" />
                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER'] ?>" />
                    <input id="J_Login" class="kd-form-btn orangeBtn large" name="submit" accesskey="l" value="登    录" tabindex="4" type="submit" style=" top: 30px;"/>
                  </section>
                </form>
                <style>
								.oauth-wrapper .title {
									background: #fff none repeat scroll 0 0;
									color: #666;
									font-size: 12px;
									font-weight: 400;
									left: 50%;
									margin-left: -75px;
									position: absolute;
									text-align: center;
									top: -10px;
									width: 120px;
								}

								.oauth-wrapper .oauth {
									text-align: center;
								}

								.oauth-wrapper .oauth__link--weixin {
									background:  url("<?php echo TPL_URL;?>images/weixin_48.png") repeat scroll 0 0;
									display: inline-block;
									float: none;
									height: 48px;
									width: 48px;
								}
							</style>
                <div class="oauth-wrapper" style="margin-top: 50px;width:100%;">
                  <h3 class="title-wrapper" style="border-bottom: 1px solid #ccc;height: 0;margin-bottom: 30px;overflow: visible;position: relative;width: 100%;"><span class="title">用手机微信扫码登录</span></h3>
                  <div class="oauth cf"> <a href="javascript:void(0);" id="wx_login" class="oauth__link oauth__link--weixin"></a> </div>
                </div>
              </div>
            </div>
          </div></td>
        <td class="bs-right"></td>
      </tr>
      <tr class="bs-footer">
        <td class="bs-left"></td>
        <td class="bs-middle"></td>
        <td class="bs-right"></td>
      </tr>
    </tbody>
  </table>
</div>
<script>
	$(function(){
		$('.miniLogin-close').click(function(){
			$("#alertbgid", window.parent.document).remove();
			$("#alertwinid", window.parent.document).remove();

		//	$("html", window.parent.document).css("overflow","");
			$("select", window.parent.document).css("display","block");
		});

		$("#alertbgid", window.parent.document).click(function(){
			$("#alertbgid", window.parent.document).remove();
			$("#alertwinid", window.parent.document).remove();
		});

		$('.v-login-register').click(function(){
			window.parent.location.href='<?php echo url('account:register');?>';
		});
	});
</script>
</body>
</html>