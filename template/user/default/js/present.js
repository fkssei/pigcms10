/**
 * Created by pigcms_21 on 2015/2/6.
 */
$(function(){
	location_page(location.hash, 1);
	
	$(".js-list-filter-region a").live('click', function () {
		var action = $(this).attr("href");
		location_page(action, 1)
	});
	
	
	$(".js-page-list a").live("click", function () {
		var page = $(this).data("page-num");
		location_page(window.location.hash, page);
	});
	
	//开始时间
	$('#js-start-time').live('focus', function() {
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js-end-time').val() != '') {
					$(this).datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
				}
			},
			onSelect: function() {
				if ($('#js-start-time').val() != '') {
					$('#js-end-time').datepicker('option', 'minDate', new Date($('#js-start-time').val()));
				}
			},
			onClose: function() {
				var flag = options._afterClose($(this).datepicker('getDate'), $('#js-end-time').datepicker('getDate'));
				if (!flag) {
					$(this).datepicker('setDate', $('#js-end-time').datepicker('getDate'));
				}
			},
			_afterClose: function(date1, date2) {
				var starttime = 0;
				if (date1 != '' && date1 != undefined) {
					starttime = new Date(date1).getTime();
				}
				var endtime = 0;
				if (date2 != '' && date2 != undefined) {
					endtime = new Date(date2).getTime();
				}
				if (endtime > 0 && endtime < starttime) {
					alert('无效的时间段');
					return false;
				}
				return true;
			}
		};
		$('#js-start-time').datetimepicker(options);
	})
	
	//结束时间
	$('#js-end-time').live('focus', function(){
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js-start-time').val() != '') {
					$(this).datepicker('option', 'minDate', new Date($('#js-start-time').val()));
				}
			},
			onSelect: function() {
				if ($('#js-end-time').val() != '') {
					$('#js-start-time').datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
				}
			},
			onClose: function() {
				var flag = options._afterClose($('#js-start-time').datepicker('getDate'), $(this).datepicker('getDate'));
				if (!flag) {
					$(this).datepicker('setDate', $('#js-start-time').datepicker('getDate'));
				}
			},
			_afterClose: function(date1, date2) {
				var starttime = 0;
				if (date1 != '' && date1 != undefined) {
					starttime = new Date(date1).getTime();
				}
				var endtime = 0;
				if (date2 != '' && date2 != undefined) {
					endtime = new Date(date2).getTime();
				}
				if (starttime > 0 && endtime < starttime) {
					alert('无效的时间段');
					return false;
				}
				return true;
			}
		};
		$('#js-end-time').datetimepicker(options);
	})
	
	function location_page(mark, page){
		var mark_arr = mark.split('/');
		
		switch(mark_arr[0]){
			case '#create':
				load_page('.app__content', load_url, {page : page_present_create}, '');
				break;
			case "#edit":
				if(mark_arr[1]){
					load_page('.app__content', load_url,{page:'present_edit', id : mark_arr[1]},'',function(){
						
					});
				}else{
					layer.alert('非法访问！');
					location.hash = '#list';
					location_page('');
				}
				break;
			case "#future" :
				action = "future";
				load_page('.app__content', load_url, {page : page_content, "type" : action, "p" : page}, '');
				break;
			case "#on" :
				action = "on";
				load_page('.app__content', load_url, {page : page_content, "type" : action, "p" : page}, '');
				break;
			case "#end" :
				action = "end";
				load_page('.app__content', load_url, {page : page_content, "type" : action, "p" : page}, '');
				break;
			default :
				action = "all";
				load_page('.app__content', load_url, {page : page_content, "type" : action, "p" : page}, '');
		}
	}
	
	// 取消
	$(".js-btn-quit").live("click", function () {
		location_page('');
	})
	
	// 添加赠品
	$(".js-add-present").live("click", function () {
		$(".js-select-goods-list").show();
		loadProduct();
	});
	
	// 类型切换
	$(".js-search-type").live('change', function () {
		$(".js-title").attr("placeholder", $(".js-title").attr("data-goods-" + $(this).val()));
	})
	
	// 搜索添加赠品
	$(".js-search").live('click', function () {
		var group_id = $(".js-goods-group").val();
		var type = $(".js-search-type").val();
		var title = $(".js-title").val();
		loadProduct(group_id, type, title, 1);
	})
	
	// 搜索商品切换
	$(".js-product_list_page a").live('click', function () {
		var page = $(this).attr("data-page-num");
		var group_id = $(".js-goods-group").val();
		var type = $(".js-search-type").val();
		var title = $(".js-title").val();
		loadProduct(group_id, type, title, page);
	});
	
	// 设置为赠品
	$(".js-add-reward").live('click', function () {
		var product_id = $(this).data('product_id');
		
		var is_exists = false;
		$(".js-show-present").find(".current-present").each(function () {
			if (product_id == $(this).data("product_id")) {
				is_exists = true;
				//alert("此产品已经在赠品里，无须重复添加");
				return false;
			}
		});
		
		if (is_exists) {
			$(this).removeClass("btn-primary");
			return;
		}
		
		var img_url = $(this).parent().parent().find(".js-goods-image").html();
		var title_url = $(this).parent().parent().find(".goods-title").html();
		var quantity = $(this).parent().parent().find(".js-quantity").html();
		
		var html = '<div class="current-present clearfix" data-product_id="' + product_id + '">' + img_url;
		html += '	<div class="current-present-tips">' + title_url;
		html += '		<p>库存： ' + quantity + '</p>\
									</div>\
									<a class="ui-btn ui-btn-success add-present modify-present js-modify-present" href="javascript:void(0)">删除此赠品</a>\
								</div>';
		
		$(".js-show-present").append(html);
		$(this).removeClass("btn-primary");
		$(this).html("已设为赠品");
	});
	
	// 删除赠品
	$(".js-modify-present").live("click", function () {
		var product_id = $(this).parent().data("product_id");
		$("#js-add-reward-" + product_id).addClass("btn-primary");
		$("#js-add-reward-" + product_id).html("设置为赠品");
		$(this).parent().remove();
	});
	
	// 分页
	$(".js-present_list_page a").live("click", function () {
		var p = $(this).data("page-num");
		var keyword = $('.js-present-keyword').val();
		var type = window.location.hash.substring(1);
		
		$('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type, 'p' : p}, function(){
		});
	})
	
	// 添加保存
	$(".js-btn-save").live("click", function () {
		var name = $("#name").val();
		var start_time = $("#js-start-time").val();
		var end_time = $("#js-end-time").val();
		var expire_date = $("#expire_date").val();
		var expire_number = $("#expire_number").val();
		
		if (name.length == 0) {
			layer_tips(1, '赠品名称没有填写，请填写');
			$("#name").focus();
			return;
		}
		
		if (start_time.length == 0) {
			layer_tips(1, '请选择赠品开始时间');
			$("#js-start-time").focus();
			return;
		}
		
		if (end_time.length == 0) {
			layer_tips(1, '请选择赠品结束时间');
			$("#js-end-time").focus();
			return;
		}
		
		var product_id = ''
		$(".js-show-present").find(".current-present").each(function () {
			if (product_id.length == 0) {
				product_id = $(this).data('product_id');
			} else {
				product_id += ',' + $(this).data('product_id');
			}
		});
		
		if (product_id.length == 0) {
			layer_tips(1, '请至少选择一个产品作为赠品');
			return;
		}
		
		$.post(load_url, {"page" : page_present_create, "name" : name, "start_time" : start_time, "end_time" : end_time, "expire_date" : expire_date, "expire_number" : expire_number, "product_id" : product_id, "is_submit" : "submit"}, function (data) {
			if (data.err_code == '0') {
				layer_tips(0, data.err_msg);
				var t = setTimeout(presentList(), 2000);
				return;
			} else {
				layer_tips(1, data.err_msg);
				return;
			}
		});
	});
	
	// 修改保存
	$(".js-btn-edit-save").live("click", function () {
		var id = $("#present_id").val();
		var name = $("#name").val();
		var start_time = $("#js-start-time").val();
		var end_time = $("#js-end-time").val();
		var expire_date = $("#expire_date").val();
		var expire_number = $("#expire_number").val();
		
		if (name.length == 0) {
			layer_tips(1, '赠品名称没有填写，请填写');
			$("#name").focus();
			return;
		}
		
		if (start_time.length == 0) {
			layer_tips(1, '请选择赠品开始时间');
			$("#js-start-time").focus();
			return;
		}
		
		if (end_time.length == 0) {
			layer_tips(1, '请选择赠品结束时间');
			$("#js-end-time").focus();
			return;
		}
		
		var product_id = ''
		$(".js-show-present").find(".current-present").each(function () {
			if (product_id.length == 0) {
				product_id = $(this).data('product_id');
			} else {
				product_id += ',' + $(this).data('product_id');
			}
		});
		
		if (product_id.length == 0) {
			layer_tips(1, '请至少选择一个产品作为赠品');
			return;
		}
		
		$.post(load_url, {"page" : page_present_edit, "name" : name, "start_time" : start_time, "end_time" : end_time, "expire_date" : expire_date, "expire_number" : expire_number, "product_id" : product_id, "id" : id, "is_submit" : "submit"}, function (data) {
			if (data.err_code == '0') {
				layer_tips(0, data.err_msg);
				var t = setTimeout(presentList(), 2000);
				return;
			} else {
				layer_tips(1, data.err_msg);
				return;
			}
		});
	});
	
	// 使赠品失效
	$(".js-disabled").live("click", function (e) {
		var disabled_obj = $(this);
		var present_id = disabled_obj.parent().data("present_id");
		button_box($(this), e, 'left', 'confirm', '确认失效？<br />失效后赠品将不能用', function(){
			$.get(disabled_url, {"id" : present_id}, function (data) {
				close_button_box();
				t = setTimeout('msg_hide()', 3000);
				if (data.err_code == "0") {
					disabled_obj.closest("tr").find("td").eq(2).html("已结束");
					disabled_obj.parent().html("已失效");
					layer_tips(0, data.err_msg);
				} else {
					layer_tips(1, data.err_msg);
				}
			})
		})
	});
	
	// 删除赠品
	$('.js-delete').live("click", function(e){
		var delete_obj = $(this);
		var present_id = $(this).parent().data('present_id');
		$('.js-delete').addClass('active');
		button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
			$.get(delete_url, {'id': present_id}, function(data) {
				close_button_box();
				t = setTimeout('msg_hide()', 3000);
				if (data.err_code == 0) {
					$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
					load_page('.app__content',load_url,{page: page_content},'');
				} else {
					$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
				}
			})
		});
	});
	
	// 编辑资料
	$(".js-edit").live("click", function () {
		location_page($(this).attr("href"));
	});
	
	//回车提交搜索
	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.js-present-keyword').is(':focus')) {
			var keyword = $('.js-present-keyword').val();
			var type = window.location.hash.substring(1);
			
			$('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type}, function(){
			});
		}
	})
})

function presentList() {
	location.href = "user.php?c=appmarket&a=present";
}

function loadProduct(group_id, type, title, page) {
	load_page(".js_select_goods_loading", load_url, {"page" : page_product_list, "group_id" : group_id, "type" : type, "title" : title, "p" : page}, '', function() {
		checkProductStatus();
	});
}

// 检查已经设置为赠品，更改状态
function checkProductStatus() {
	var product_id = '';
	$(".js-show-present").find(".current-present").each(function () {
		product_id = $(this).data('product_id');
		try {
			$("#js-add-reward-" + product_id).html("已设为赠品");
			$("#js-add-reward-" + product_id).removeClass("btn-primary");
		} catch (e) {
			
		}
	});
}

// 
function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}