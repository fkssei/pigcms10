/**
 * Created by pigcms_21 on 2015/2/6.
 */
$(function(){
	var hash_arr = location.hash.split("/");
	var current_index = 0;
	switch (hash_arr[0]) {
		case "#selffetch" :
			current_index = 1;
			break;
		case "#friend" :
			current_index = 2;
			break;
		case "#offline_payment" :
			current_index = 3;
			break;
		default :
			current_index = 0;
			break;
	}
	
	$(".js-app-nav").removeClass("active");
	$(".js-app-nav").eq(current_index).addClass("active");
	
	
	
	location_page(location.hash);
	$(".js-app-nav a").live("click", function () {
		$(this).closest("ul").find("li").removeClass("active");
		$(this).closest("li").addClass("active");
		location_page($(this).attr("href"));
	});
	
	function location_page(mark, page){
		var mark_arr = mark.split('/');
		switch(mark_arr[0]){
			case "#selffetch":
				load_page('.app__content', trade_selffetch_url, {page : "selffetch_content"}, '');
				break;
			case "#offline_payment" :
				load_page('.app__content', trade_load_url, {page : "offline_payment_content"}, '');
				break;
			case "#friend" :
				load_page('.app__content', load_url, {page : "friend_content"}, '');
				break;
			default :
				load_page('.app__content', logistics_url, "");
		}
	};
	
	// 货到付款
	$('.js-offline_payment').live('click', function(){
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
		$.post(offline_payment_status_url, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
			}
		})
	});
	
	$(".js-selffetch_payment").live("click", function (event) {
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
		$.post(selffetch_status_url, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
			}
		})
	});
	
	$(".js-friend-status").live("click", function (event) {
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
		$.post(friend_status_url, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
			}
		})
	});
	
	$(".js-logistics-status").live("click", function () {
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
		
		$.post(logistics_status_url, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
			}
		})
	});

	$(".js-buyer_selffetch_name").live("click", function () {
		var buyer_selffetch_name = $("input[name='buyer_selffetch_name']").val();
		if ($.trim(buyer_selffetch_name).length == 0) {
			layer_tips(1, '自提点前台显示名没有填写');
			return false;
		}
		
		$.post(buyer_selffetch_name_url, {buyer_selffetch_name : buyer_selffetch_name}, function (result) {
			if(result.err_code == 0){
				layer_tips(0, result.err_msg);
				location.reload();
			}else{
				layer.alert(result.err_msg, 0);
			}
		})
	});
})


// 
function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}