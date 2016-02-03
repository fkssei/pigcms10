<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>
	<body>
		<div class="login" id="wxdl">
		<p style="<?php if(empty($_GET['mt'])){ ?>margin-top:50px;<?php } ?>margin-bottom:0px;text-align:center;">请使用微信扫描二维码注册</p>
		<p style="text-align:center;"><img src="<?php echo $ticket;?>" style="width:260px;height:260px;background:url('<?php echo $config['site_url'];?>/static/images/lightbox-ico-loading.gif') no-repeat center"/></p>
		<p id="login_status" style="margin-top:20px;display:none;text-align:center;font-size:14px;"></p>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<link href="<?php echo TPL_URL;?>css/login.css" type="text/css" rel="stylesheet">
		<script>
			<?php if($_GET['referer']){ ?>var redirect_url = "<?php echo str_replace('&amp;', '&', htmlspecialchars_decode($_GET['referer']));?>";<?php }else{ ?>var redirect_url = window.top.location.href;<?php } ?>
			window.setTimeout(function(){
				window.location.href = window.location.href;
			},1200000);
			window.setTimeout(function(){
				ajax_weixin_login();
			},3000);
			function ajax_weixin_login(){
				
				$.get("<?php dourl('index:wxlogin:ajax_weixin_login');?>",{qrcode_id:<?php echo $id;?>},function(result){
					if(result == 'reg_user'){
						$('#login_status').html('已扫描！请在微信公众号中点击授权登录。').css('color','green').show();
						ajax_weixin_login();
					}else if(result == 'no_user'){
						$('#login_status').html('没有查找到此用户，请重新扫描二维码！').css('color','red').show();
						window.location.href = redirect_url;
					}else if(result!=='true'){
						ajax_weixin_login();
					}else{
						$('#login_status').html('注册成功！正在跳转。').css('color','green').show();
						window.top.location.href = redirect_url;
					}
				});
			}
		</script>
		<p style="<?php if(empty($_GET['mt'])){ ?>margin-top:50px;<?php } ?>margin-bottom:0px;text-align:center;cursor:pointer" class="zh">选择账号密码注册</p>
		
		</div>
		
		<div id="zhdl" class="login" style="display:none">
			<form id="register" action="<?php echo url('account:register') ?>" method="post">
				<input type="hidden" value="P-M" name="login_type">			
                <table class="login-table">
                    <tbody>
					<tr>
                        <td class="login-tip">
                            <div style="display: none;" class="error login_error" id="login_error"></div>
                        </td>
                    </tr>
                     <tr class="line_4" id="line_4">
                        <td>
                            <div class="input_div">
                                <input type="text" placeholder="请输入手机号" style="font-size:12px;" class="txt txt-m txt-focus cgrey2" tabindex="1" autocomplete="off" id="phone1" name="phone">
                            </div>
                        </td>
                    </tr>
                   <tr class="line_1" id="line_1">
                        <td>
                            <div class="input_div">
                                <input type="text" placeholder="请输入昵称" class="txt txt-m" tabindex="2" autocomplete="off" id="nickname1" name="nickname">
                            </div>
                        </td>
                    </tr>						
                    <tr class="line_2" id="line_2">
                        <td>
                            <div class="input_div">
                                <input type="password" class="txt txt-m" tabindex="2" autocomplete="off" name="password" id="password1">
                            </div>
                        </td>
                    </tr>
					<!--
                     <tr class="line_4">
                        <td class="cgrey2 line2">
                            <label style="vertical-align:middle"><input class="remember_me" tabindex="4" name="remember_me" id="rememberme2" value="1" style="vertical-align:middle" type="checkbox">&nbsp;两周内自动登录</label>
                            <a target="_blank" href="" class="search_psw">忘记密码？</a>
                        </td>
                    </tr>-->

                    <tr>
                        <td class="line2">
							<input type="hidden" value="" name="current_login_url">
							<input type="hidden" value="<?php echo $referer ?>" name="referer">
							<input type="submit" value="注册" name="submit_login" onclick="" tabindex="5" class="sub">
						</td>
                    </tr>
                </tbody></table>
				</form>	
			<div class="partner-login">
				<div class="oauth-wrapper" style="width:280px;margin-top:25px;">
					<h3 class="title-wrapper"><span class="title" style="left:40%">用手机微信扫码注册</span></h3>
					<div  style="text-align:center" class="oauth cf">
						<a href="javascript:void(0);" id="wx_login" class="oauth__link oauth__link--weixin"></a>
					</div>   
				</div>				
			</div>		
		</div>
		
		
		
		
		
		
		<script>
		$(".zh").click(function(){
			$(".login").hide();
			$("#zhdl").show();		
			
		})
		$("#wx_login").click(function(){
			$(".login").hide();
			$("#wxdl").show();				
			
		})
		</script>
	</body>
</html>