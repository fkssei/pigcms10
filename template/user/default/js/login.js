$(function(){
	$('.J_textboxPrompt input').live('focusin focusout',function(event){
		if(event.type == 'focusin'){
			$(this).siblings('.input-text').hide();
		}else{
			if($(this).val().length == 0){
				$(this).siblings('.input-text').show();
			}
		}
	});
	$('#phone,#password').keyup(function(e){
		if(e.keyCode == 13){
			$('#loginValidate').trigger('click');
		}
	});
	
	$('#loginValidate').click(function(){
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
		
		var password = $('#password').val();
		if($.trim(password).length < 6){
			$('.input-pwd').append('<label class="validator_error"><span>请输入您常用密码，6-20个字符</span></label>');
			is_validate = false;
		}
		
		if(is_validate == false){
			$('label.validator_error:eq(0)').siblings('input').focus();
		}else{
			$.post(window.location.href, {phone:phone,password:password},function(result){
				if(result.err_code == 0){
					window.location.href = './user.php';
				}else{
					layer.alert(result.err_msg,0);
				}
			});
		}
	});
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