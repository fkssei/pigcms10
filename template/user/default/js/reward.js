/**
 * Created by pigcms-s on 2015/06/16.
 */
var reward_condition_html = "";
$(function() {
	location_page(location.hash);
	$('a').live('click',function(){
		if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#') {
			location_page($(this).attr('href'));
		}
	});

	function location_page(mark, page) {
		var mark_arr = mark.split('/');
		switch(mark_arr[0]){
			case '#create':
				load_page('.app__content', load_url , {page:'reward_create'}, '', function () {
					defaultRewardCondition();
				});
				break;
			case "#edit":
				if(mark_arr[1]){
					load_page('.app__content', load_url, {page : 'reward_edit', id : mark_arr[1]}, '', function() {
						defaultRewardCondition();
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
	
	// 分页
	$(".js-reward_list_page a").live("click", function () {
		var p = $(this).data("page-num");
		var keyword = $('.js-reward-keyword').val();
		var type = window.location.hash.substring(1);
		
		$('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type, 'p' : p}, function(){
		});
	})

	//初始化操作(防刷新)
	refresh_reward();
	
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
	
	//选择优惠设置
	$("input[name='type']").live('change',function() {
		var preferential_method = $(this).val();
		switch(preferential_method){
			case '1':
				$("#reward-condition tr").each(function(i){
					if(i!=0) {
						$(this).remove();
					}
				})
				$(".add-reward-toolbar").hide();
				break;
			case '2':
				$(".add-reward-toolbar").css({"display":"table-footer-group"});
				var reward_len = $("#reward-condition tr").length;
				if(reward_len < 5) {
					$(".js-add-reward").show();
					$(".add-reward-toolbar").show();
				}
				break;
		}
	})

	//选择活动商品
	$("input[name='range_type']").live('change',function() {
		var range_type = $(this).val();
		switch(range_type){
			case 'all':
				$(".js-goods-box").hide();
				break;
			case 'part':
				$(".js-goods-box").css({"display":"table-footer-group"});
				if ($(".js_select_goods_loading").has("table").length == 0) {
					loadProduct();
				}
				
				break;
		}

	})

	//优惠方式选择
	$(".reward-setting input[type='checkbox']").live('click',function(event) {
		var controls = $(this).closest(".controls");

		if($(this).next(".origin-status").text()!='免邮'){
			if($(this).attr("checked")){
				$(this).closest(".controls").find(".origin-status").hide();
				$(this).closest(".controls").find(".replace-status").show();
			} else{
				$(this).closest(".controls").find(".origin-status").show();
				$(this).closest(".controls").find(".replace-status").hide();
			}
		}
	})
	
	
	//新增优惠条件
	$(".js-add-reward").live('click',function() {
		var reward_len =  $("#reward-condition tr").length;
		if(reward_len >= 4) {
			$(this).hide();
		}
		reward_len++;
		$("#reward-condition").append(reward_condition_html.replace(/{==number==}/ig, reward_len));
	})
	
	// 删除优惠条件
	$(".js-delete-condition").live("click", function () {
		$(this).closest("tr").remove();
		orderRewardCondition();
		
		$(".js-add-reward").show();
	});
	
	// 刷新优惠券列表
	$(".js-refresh-coupon").live("click", function () {
		$.getJSON("user.php?c=reward&a=coupon_option", function (data) {
			try {
				var option_html = '';
				for (i in data) {
					option_html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
				}
				$(".js-reward-coupon").html(option_html);
			} catch(e) {
			}
		});
	});
	
	// 刷新赠品列表
	$(".js-refresh-present").live("click", function () {
		$.getJSON("user.php?c=reward&a=present_option", function (data) {
			try {
				var option_html = '';
				for (i in data) {
					option_html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
				}
				$(".js-reward-present").html(option_html);
			} catch(e) {
			}
		});
	});
	
	// 商品列表和选中商品tab
	$(".ui-nav-tab li").live("click", function () {
		var number = $(".ui-nav-tab li").index($(this));
		$(this).closest("ul").find("li").each(function (i){
			$(this).removeClass("active");
			if (i == number) {
				$(this).addClass("active");
			}
		});
		
		// 盒子
		$(".goods-list-wrap .js-goods-list-tab").hide();
		$(".goods-list-wrap .js-goods-list-tab").eq(number).show();
		
		// 当“选择商品”显示时，访问服务器调用值
		if (number == 0) {
			if ($(".js_select_goods_loading").has("table").length == 0) {
				var group_id = $(".js-goods-group").val();
				var type = $(".js-search-type").val();
				var title = $(".js-title").val();
				loadProduct(group_id, type, title, 1);
			}
		}
	});
	
	// 类型切换
	$(".js-search-type").live('change', function () {
		$(".js-title").attr("placeholder", $(".js-title").attr("data-goods-" + $(this).val()));
	});
	
	// 搜索添加满减/送
	$(".js-search").live('click', function () {
		var group_id = $(".js-goods-group").val();
		var type = $(".js-search-type").val();
		var title = $(".js-title").val();
		loadProduct(group_id, type, title, 1);
	})
	
	// 搜索商品分页
	$(".js-product_list_page a").live('click', function () {
		var page = $(this).attr("data-page-num");
		var group_id = $(".js-goods-group").val();
		var type = $(".js-search-type").val();
		var title = $(".js-title").val();
		loadProduct(group_id, type, title, page);
	});
	
	// 单个产品增加满减/送
	$(".js-add-product").live("click", function () {
		if ($(this).hasClass("btn-primary")) {
			addProductSelect($(this).data("product_id"));
		}
	});
	
	// 全选
	$(".js-select-all").live("click", function () {
		if ($(this).prop("checked")) {
			$(this).closest(".ump-select-goods").find("input[type='checkbox']").prop("checked", true);
		} else {
			$(this).closest(".ump-select-goods").find("input[type='checkbox']").prop("checked", false);
		}
	});
	
	// 批量添加
	$(".js-batch-add").live("click", function () {
		var product_id = "";
		var is_selected = false;
		$(".js-product-list-add").find("input[type='checkbox']").each(function () {
			if ($(this).prop("checked")) {
				product_id = $(this).closest("tr").data("product_id");
				addProductSelect(product_id);
			}
		});
	});
	
	
	// 单个产品删除满减/送
	$(".js-delete-product").live("click", function () {
		deleteProductSelect($(this).data("product_id"));
	});
	
	// 批量删除满减/送产品
	$(".js-batch-delete").live("click", function () {
		var product_id = "";
		var is_selected = false;
		$(".js-product-list-selected").find("input[type='checkbox']").each(function () {
			if ($(this).prop("checked")) {
				product_id = $(this).closest("tr").data("product_id");
				deleteProductSelect(product_id);
			}
		});
	});
	
	
	// 保存
	$(".js-btn-save").live("click", function () {
		var name = $("#name").val();
		var start_time = $("#js-start-time").val();
		var end_time = $("#js-end-time").val();
		
		if (name.length == 0) {
			layer_tips(1, '活动名称没有填写，请填写');
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
		
		var money;
		var is_ok = true;
		var is_selected = false;
		var reward_str = "";
		// 检查每一级优惠
		$("#reward-condition tr").each(function (i) {
			var tr_obj = $(this);
			var reward_each = "";
			money = tr_obj.find("input[name='money']").val();
			if (money.length == 0) {
				layer_tips(1, '请填写优惠门槛');
				tr_obj.find("input[name='money']").focus();
				is_ok = false;
				return false;
			}
			
			if (isNaN(money)) {
				layer_tips(1, '请输入有效的数字');
				tr_obj.find("input[name='money']").focus();
				is_ok = false;
				return false;
			}
			
			reward_each = money;
			
			is_selected = false;
			// 检查每个优惠方式
			tr_obj.find("input[type='checkbox']").each(function () {
				if ($(this).prop("checked")) {
					is_selected = true;
					if ($(this).attr("name") == "cash_required") {
						var cash = tr_obj.find("input[name='cash']").val();
						if (cash == "") {
							layer_tips(1, '请输入金额');
							tr_obj.find("input[name='cash']").focus();
							is_ok = false;
							return false;
						}
						
						if (isNaN(cash)) {
							layer_tips(1, '请输入有效的金额');
							tr_obj.find("input[name='cash']").focus();
							is_ok = false;
							return false;
						}
						
						if (parseFloat(cash) > parseFloat(money)) {
							layer_tips(1, '请正确填写减的金额,减现金必须小于满减金额');
							tr_obj.find("input[name='cash']").focus();
							is_ok = false;
							return false;
						}
						
						reward_each += ",cash:" + cash;
					} else if ($(this).attr("name") == "score_required") {
						var score = tr_obj.find("input[name='score']").val();
						if (score == "") {
							layer_tips(1, '请输入积分');
							tr_obj.find("input[name='score']").focus();
							is_ok = false;
							return false;
						}
						
						if(!(/^(\+|-)?\d+$/.test(score)) || score < 0) {
							layer_tips(1, '请输入正整数的积分');
							tr_obj.find("input[name='score']").focus();
							is_ok = false;
							return false;
						}
						
						reward_each += ",score:" + score;
					} else if ($(this).attr("name") == "coupon_required") {
						var coupon = tr_obj.find("select[name='coupon']").val();
						if (coupon == "0") {
							layer_tips(1, '请先创建一个可用的优惠');
							tr_obj.find("select[name='coupon']").focus();
							is_ok = false;
							return false;
						}
						
						reward_each += ",coupon:" + coupon;
					} else if ($(this).attr("name") == "present_required") {
						var present = tr_obj.find("select[name='present']").val();
						if (present == "0") {
							layer_tips(1, '请先创建一个可用的赠品');
							tr_obj.find("select[name='present']").focus();
							is_ok = false;
							return false;
						}
						
						reward_each += ",present:" + present;
					} else if ($(this).attr("name") == "postage") {
						reward_each += ",postage:1";
					}
				}
				
				
			});
			
			if (!is_selected) {
				var level = i + 1;
				layer_tips(1, "优惠层级" + level + ",请至少要选择一个优惠方式");
				is_ok = false;
				return false;
			}
			
			if (reward_str.length == 0) {
				reward_str = reward_each;
			} else {
				reward_str += "|" + reward_each;
			}
		});
		
		if (!is_ok) {
			return;
		}
		
		var product_id = "";
		var range_type = $("input[name='range_type']:checked").val();
		if (range_type == "part") {
			if ($(".js-amount").html() == "0") {
				layer_tips(1, "参与活动的产品至少要选择一个");
				is_ok = false;
				return false;
			}
			
			$(".js-product-list-selected").find("tr").each(function () {
				if (product_id.length == 0) {
					product_id = $(this).data('product_id');
				} else {
					product_id += ',' + $(this).data('product_id');
				}
			});
		}
		
		var rid = $("#rid").val();
		var page_url = page_reward_create;
		if (typeof rid != "undefined") {
			page_url = page_reward_edit;
		}
		
		// 关闭多次提交
		if ($(this).hasClass("disabled")) {
			return;
		}
		
		$(this).addClass("disabled");
		$(this).val($(this).data("loading-text"));
		$.post(load_url, {"page" : page_url, "id" : rid, "name" : name, "start_time" : start_time, "end_time" : end_time, "reward_str" : reward_str, "is_all" : range_type, "product_id" : product_id,  "is_submit" : "submit"}, function (data) {
			if (data.err_code == '0') {
				layer_tips(0, data.err_msg);
				var t = setTimeout(rewardList(), 2000);
				return;
			} else {
				layer_tips(1, data.err_msg);
				
				$(".js-btn-save").removeClass("disabled");
				$(".js-btn-save").val("保存");
				return;
			}
		});
		
	});
	
	// 使赠品失效
	$(".js-disabled").live("click", function (e) {
		var disabled_obj = $(this);
		var reward_id = disabled_obj.parent().data("reward_id");
		button_box($(this), e, 'left', 'confirm', '确认失效？', function(){
			$.get(disabled_url, {"id" : reward_id}, function (data) {
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
	
	// 删除活动
	$('.js-delete').live("click", function(e){
		var delete_obj = $(this);
		var reward_id = $(this).parent().data('reward_id');
		$('.js-delete').addClass('active');
		button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
			$.get(delete_url, {'id': reward_id}, function(data) {
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
	
	//回车提交搜索
	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.js-reward-keyword').is(':focus')) {
			var keyword = $('.js-reward-keyword').val();
			var type = window.location.hash.substring(1);
			
			$('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type}, function(){
			});
		}
	})
	
	
	//刷新页面操作
	function refresh_reward() {
		var preferential_method = $("input[name='preferential_method']").val();
		var range_type = $("input[name='range_type']").val();
		$(".js-goods-box").hide();

		var a = $("#reward-condition").html();
	}
});

// 重新设置优惠条件顺序值,一般在删除某优惠条件时触发
function orderRewardCondition() {
	$("#reward-condition tr").each(function (i) {
		$(this).find(".center_tds").html(i + 1);
	});
}


// 添加页面加载进入时，获取默认的优惠条件
function defaultRewardCondition() {
	$("#myformaaaaaaa").validate({
		event:"blur",
		errorElement: "em",
		errorPlacement: function(error,element){
			error.appendTo(element.parent("div"));
		}
	})
	
	var tr_obj = $("<tr>" + $(".js-default-reward-condition").html() + "</tr>");
	tr_obj.find(".center_tds").html("{==number==}");
	tr_obj.find(".js-delete-td").html('<a href="javascript:" class="js-delete-condition">删除</a>');
	reward_condition_html = "<tr>" + tr_obj.html() + "</tr>";
}

// 加载产品
function loadProduct(group_id, type, title, page) {
	// 优惠id
	var rid = $("#rid").val();
	load_page(".js_select_goods_loading", load_url, {"page" : page_product_list, "group_id" : group_id, "type" : type, "title" : title, "p" : page, "rid" : rid}, '', function() {
		checkProductStatus();
	});
}

//检查已经设置为活动商品，更改状态
function checkProductStatus() {
	var product_id = '';
	$(".js-product-list-selected").find("tr").each(function () {
		product_id = $(this).data('product_id');
		try {
			$("#js-add-reward-" + product_id).html("已参加活动");
			$("#js-add-reward-" + product_id).removeClass("btn-primary");
		} catch (e) {
			
		}
	});
}

// 添加一个产品到活动产品中
function addProductSelect(product_id) {
	// 先查找产品是否已选
	var is_exist = false;
	$(".js-product-list-selected").find("tr").each(function () {
		if (product_id == $(this).data("product_id")) {
			is_exist = true;
			return false;
		}
	});
	
	$(".js-product-list-selected").find(".js-no-data").remove();
	
	if (!is_exist) {
		var tr_obj = $("<tr>" + $("#js-product-deteil-" + product_id).html() + "</tr>");
		tr_obj.find(".js-add-product").html("取消参加活动");
		tr_obj.find(".js-add-product").addClass("js-delete-product");
		tr_obj.find(".js-add-product").removeAttr("id");
		
		$(".js-product-list-selected").append('<tr class="widget-list-item js-product-detail-' + product_id + '" data-product_id="' + product_id + '">' + tr_obj.html() + "</tr>");
	}
	
	// 选中产品数量
	$(".js-amount").html($(".js-product-list-selected tr").size());
	
	$("#js-product-deteil-" + product_id).find(".js-add-product").removeClass("btn-primary");
	$("#js-product-deteil-" + product_id).find(".js-add-product").html("已参加活动");
}

// 删除一个选中活动的产品
function deleteProductSelect(product_id) {
	$(".js-product-list-selected").find(".js-product-detail-" + product_id).remove();
	// 选中产品数量
	$(".js-amount").html($(".js-product-list-selected tr").size());
	$("#js-product-deteil-" + product_id).find(".js-add-product").addClass("btn-primary");
	$("#js-product-deteil-" + product_id).find(".js-add-product").html("设置为参加活动");
	if ($(".js-product-list-selected tr").length == 0) {
		$(".js-product-list-selected").append('<tr class="js-no-data"><td colspan="5" style="text-align:center; height:100px;">还没有相关数据。</td></tr>');
	}
}

// 成功后跳转
function rewardList() {
	location.href = "user.php?c=reward&a=reward_index";
}

//
function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}