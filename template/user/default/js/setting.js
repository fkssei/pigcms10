$(function(){
	load_page('.app__content',load_url,{page:'setting_content'},'');
	$('.form-horizontal').live('submit',function(){
		var pay_cancel_time = $('input[name="pay_cancel_time"]').val();
		if(isNaN(pay_cancel_time) || (parseInt(pay_cancel_time) != 0 && (parseInt(pay_cancel_time) < 20 || parseInt(pay_cancel_time) > 1440))){
			layer.alert('拍下未付款的时间必须在20-1440分钟之间。填0表示关闭该功能。',0);
			return false;
		}
		var pay_alert_time = $('input[name="pay_alert_time"]').val();
		if(isNaN(pay_alert_time) || parseInt(pay_alert_time) > 200){
			layer.alert('催付通知的时间必须在0-200分钟之间。',0);
			return false;
		}
		$('.form-horizontal .js-btn-save').val('保 存...').prop('disabled',true);
		
		setTimeout(function(){
			$.post(edit_url,$('.form-horizontal').serialize(),function(result){
				if(result.err_code == 0){
					layer_tips(0,result.err_msg);
				}else{
					layer.alert(result.err_msg,0);
				}
				$('.form-horizontal .js-btn-save').val('保 存').prop('disabled',false);
			});
		},500);
		return false;
	});
});