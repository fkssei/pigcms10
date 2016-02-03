$(function(){
	$('.app-add-field').show();
	var ueditor = UE.getEditor('content', {
		toolbars: [["link"]],
		autoClearinitialContent: false,
		autoFloatEnabled: true,
		wordCount: false,
		elementPathEnabled: false,
		initialFrameWidth: 360,
		initialFrameHeight: 220
	});
	ueditor.ready(function(){
		ueditor.setContent(content);
	});
	
	$('.form-actions .btn').click(function(){
		$(this).text($(this).attr('data-loading-text'));
		$.post('/user.php?c=weixin&a=save_tail', {'content':ueditor.getContent()}, function(response){
			if (response.err_code) {
				golbal_tips(response.err_msg, 1);
			} else {
				alert('修改成功！点击确定后自动刷新页面。');
				location.reload();
			}
		}, 'json');
	});
	
	$("#operation").click(function(){
		var obj = $(this), is_open = parseInt($(this).attr('data-val'));
		obj.text($(this).attr('data-loading-text'));
		$.post('/user.php?c=weixin&a=operation', {'is_open':is_open}, function(response){
			if (is_open == 1) {
				obj.text('关闭').removeClass('btn-success');
				obj.parents('.controls').find('.label').text('已开启').addClass('label-success')
				obj.attr('data-val', 0);
			} else {
				obj.text('开启').addClass('btn-success');
				obj.parents('.controls').find('.label').text('未开启').removeClass('label-success');
				obj.attr('data-val', 1);
			}
		}, 'json');
	});
});