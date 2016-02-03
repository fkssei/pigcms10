var tmp_again_time = 0,phone_again_time = 0,layer_page=null,check_phone='';
$(function(){
	var get_imgcode=function(){
		return './verifyimg.php?t='+Math.random();
	},send_phonecode=function(){
		$('#sentValidation').val('正在发送').prop('disabled',true);
		$.post('./account.php?action=register_getcode',function(result){
			tmp_again_time = phone_again_time;
			if(result.err_code == 0){
				var timer = window.setInterval(function(){
					if(tmp_again_time == 0){
						window.clearInterval(timer);
						$('#sentValidation').val('发送验证码').prop('disabled',false);
					}else{
						$('#sentValidation').val(tmp_again_time+'秒后可以重新发送');
						tmp_again_time--;
					}
				},1000);
			}else if(result.err_code == 1005){
				layer.alert(result.err_msg,0,function(){
					layer.closeAll();
					$('#phoneValidate').click();
				});
			}else{
				$('#sentValidation').val('发送验证码').prop('disabled',false);
				layer.alert(result.err_msg,0);
			}
		});
	}
	
	$('.J_textboxPrompt input').live('focusin focusout',function(event){
		if(event.type == 'focusin'){
			$(this).siblings('.input-text').hide();
		}else{
			if($(this).val().length == 0){
				$(this).siblings('.input-text').show();
			}
		}
	});
	
	$('#phoneValidate').click(function(){
		$('label.validator_error').remove();
		var is_validate = true;
		var phone = $('#phone').val();
		if($.trim(phone).length == 0){
			$('.input-phone').append('<label class="validator_error"><span>请输入手机号</span></label>');
			is_validate = false;
		}else if(!/^[0-9]{11}$/.test(phone)){
			$('.input-phone').append('<label class="validator_error"><span>请输入合法的手机号</span></label>');
			is_validate = false;
		}
		
		var nickname = $('#nickname').val();
		if($.trim(nickname).length < 2){
			$('.input-nick').append('<label class="validator_error"><span>昵称长度限制为2～12个字</span></label>');
			is_validate = false;
		}
		
		var password = $('#password').val();
		if($.trim(password).length < 6){
			$('.input-pwd').append('<label class="validator_error"><span>请输入您常用密码，6-20个字符</span></label>');
			is_validate = false;
		}
		
		if(is_validate == false){
			$('label.validator_error:eq(0)').siblings('input').focus();
		}else{
			$.post('./account.php?action=register',{phone:phone,nickname:nickname,password:password},function(result){
				if(result.err_code == 0){
					window.location.href = './user.php?c=store&a=select';
				}else if(result.err_code == 1004){
					phone_again_time = result.err_msg.again_time;
					layer_page = $.layer({
						type: 1,
						title:[
							result.err_msg.tips,
							'border:none;background:#61BA7A;color:#fff;'
						],
						area:['auto','auto'],
						shift:'top',
						page:{
							html: '<div id="phoneValidatePane"><div style="margin-bottom:10px;font-size:16px;"><label>手机号：</label><label id="phoneNumLabel" style="font-weight:bold;display:inline-block;">'+phone+'</label><input type="button" id="sentValidation" value="发送验证码"/></div><div class="J_textboxPrompt input-code"><input id="validateCode" name="code" type="text" maxlength="4"/><label class="input-text" style="display:block;">请输入您的手机验证码</label><span class="icon"></span></div><div style="margin:0 0 10px 0;color:#aaa;font-size:12px;">请查收我们发到您手机上的短信。如果没有收到，请点击重发短信</div><!--div class="J_textboxPrompt regist-validate"><input class="inputText" style="height:26px; padding-left:5px;border:1px solid gray;" id="validCode" name="validCode" type="text" maxlength="6"><label class="input-text" style="display:block;">请输入图形验证码</label><img alt="点击更换图形验证码" style="cursor:pointer;margin-left:5px;width:53px;height:28px;" id="imgCode" src="'+get_imgcode()+'"/><label class="v_error" style="left:220px;display:none;"><span>请输入图形验证码</span></label></div--><div style="margin:10px 0;color:red;font-size:12px;" id="errorMsg"></div><input id="register" class="kd-form-btn" type="button" value="确      定" style="width:168px;"/></div>'
						},
						success:function(layero){
							send_phonecode();
						}
					});
				}else{
					layer.alert(result.err_msg,0);
				}
			});
		}
	});
	
	$('label.validator_error').live('click',function(){$(this).siblings('input').focus();});
	$('#imgCode').live('click',function(){$(this).attr('src',get_imgcode());});
	$('#register').live('click',function(){
		var c = $.trim($('#validateCode').val());
		if(c.length==0){
			layer.alert('请输入手机验证码！',0);
			return false;
		}
		$(this).prop('disabled',true);
		$.post('./account.php?action=register_checkcode',{code:c},function(result){
			if(result.err_code == 0){
				layer.alert(result.err_msg,1,function(){
					window.location.href='./user.php';
				});
			}else if(result.err_code == 1005){
				$('#register').prop('disabled',false);
				layer.alert(result.err_msg,0,function(){
					layer.closeAll();
					$('#phoneValidate').click();
				});
			}else{
				$('#register').prop('disabled',false);
				layer.alert(result.err_msg,0);
			}
		});
	});
	$('#sentValidation').live('click',function(){send_phonecode();});
	
	$('#wx_login').click(function(){
		$.layer({
			type: 2,
			title: false,
			shadeClose: true,
			shade: [0.4, '#000'],
			area: ['330px','430px'],
			border: [0],
			iframe: {src:'./index.php?c=recognition&a=see_login_qrcode&referer='+encodeURIComponent('./user.php')}
		}); 
	});
});