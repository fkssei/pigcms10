$(function(){
	$('.js-wxpay-header-region .js-switch').click(function(){
		var nowDom = $(this);
		var wxpayStatus = $(this).hasClass('ui-switcher-on') ? 0 : 1;
		$.post('./user.php?c=weixin&a=open_wxpay',{wxpay:wxpayStatus},function(result){
			if(result.err_msg == 'ok'){
				if(wxpayStatus){
					nowDom.removeClass('ui-switcher-off').addClass('ui-switcher-on');
				}else{
					nowDom.removeClass('ui-switcher-on').addClass('ui-switcher-off');
				}
			}else{
				alert((wxpayStatus ? '开启' : '关闭')+'失败！请重试。');
			}
		});
		
	});
    $('.js-save').click(function(){
		$('input[name="wxpay_mchid"]').val($.trim($('input[name="wxpay_mchid"]').val()));
		if($('input[name="wxpay_mchid"]').val().length == 0){
			alert('请填写商户号');
			return false;
		}
		$('input[name="wxpay_key"]').val($.trim($('input[name="wxpay_key"]').val()));
		if($('input[name="wxpay_key"]').val().length == 0){
			alert('请填写密钥');
			return false;
		}
		if($('input[name="wx_domain_auth"]').prop('checked') == false){
			alert('您必须同意微信网页授权');
			return false;
		}
        $.post('./user.php?c=weixin&a=save_wxpay',$("#wx_form").serialize(),function(result){
			if(result.err_msg == 'ok'){
				alert('保存成功');
			}else{
				alert(result.err_msg);
			}
        })
    });
})
