var t;
$(function(){
	load_page('.app__content',load_url,{page:'offline_payment_content'},'');

	$('.js-switch').live('click', function(){
		var obj = this;
		if ($(this).hasClass('ui-switch-off')) {
			var status = 1;
			var oldClassName = 'ui-switch-off';
			var className = 'ui-switch-on';
		} else {
			var status = 0;
			var oldClassName = 'ui-switch-on';
			var className = 'ui-switch-off';
		}
		$.post(status_url, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
			}
		})
	})
});

function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}