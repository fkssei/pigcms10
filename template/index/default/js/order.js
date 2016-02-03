// 邮费
var address_msg = '';
var is_click = false;
var is_first = true;
var postage_money = 0;
var friend_postage_money = 0;
function getPostage(province_id) {
	var address_id = '';
	var pid = 0;
	if (typeof province_id == "undefined") {
		var address_id = $(".order_add_list_ul").find(".order_curn").data("address_id");
		if (typeof address_id == 'undefined') {
			$("#postage").val(0);
			return;
		}
	} else {
		if (province_id.length == 0) {
			return;
		}
		pid = province_id;
	}

	var order_id = $("#order_no").val();
	var url = '/wap/address.php?action=postage';
	$.post(url, {'address_id' : address_id, 'province_id' : pid, 'orderNo' : order_id}, function (data) {
		if (data.err_code != "0") {
			if (data.err_code == '1009') {
				address_msg = '很抱歉，该地区暂不支持配送。';
				if (!is_first) {
					tusi('很抱歉，该地区暂不支持配送。');
				}
			} else {
				address_msg = data.err_msg;
				if (!is_first) {
					tusi(data.err_msg);
				}
			}

			is_first = false;
			if (pid != 0) {
				$("#postage_friend").val(0);
			} else {
				$("#postage").val(0);
			}
			
			return;
		} else {
			if (typeof data.err_msg != 'undefined') {
				$("#J_postage").html(data.err_msg);
				
				if ($("#J_reward_postage_money").length > 0) {
					$("#J_reward_postage_money").html(data.err_msg);
				}
				
				if (pid != "0") {
					friend_postage_money = data.err_msg;
				} else {
					postage_money = data.err_msg;
				}
				
				resetMoney();
			}
			if (pid != 0) {
				$("#postage_friend").val(1);
			} else {
				$("#postage").val(1);
			}
			is_first = false;
		}
	}, 'json');
	
}

$(function () {
	if ($(".js-friend").size() > 0) {
		getProvinces('provinceId_friend','','省份');
		$('#provinceId_friend').change(function(){
			if($(this).val() != ''){
				getPostage($(this).val());
				getCitys('cityId_friend','provinceId_friend','','城市');
			}else{
				$("#J_postage").html(0);
				$('#cityId_friend').html('<option value="">城市</option>');
			}
			$('#areaId_friend').html('<option value="">区县</option>');
			resetMoney();
		});
		$('#cityId_friend').change(function(){
			if($(this).val() != ''){
				getAreas('areaId_friend','cityId_friend','','区县');
			}else{
				$('#areaId_friend').html('<option value="">区县</option>');
			}
		});
	}
	
	
	getPostage();
	resetMoney();
	
	$(".js-tab li").click(function () {
		if ($(this).hasClass("off")) {
			return;
		}
		
		$(this).addClass("off");
		$(this).siblings().removeClass("off");
		
		if ($(this).data("for") == "friend") {
			if ($(".js-payment_list").size() > 0) {
				$(".js-payment_list span").eq(1).hide();
			}
		} else {
			$(".js-payment_list span").show();
		}
		
		var index = $(".js-tab li").index($(this));
		
		$(".js_address_detail").eq(index).show();
		$(".js_address_detail").eq(index).siblings().hide();
		
		var data_for = $(this).data("for");
		if (data_for == "buyerInfo") {
			$("#J_postage").html(postage_money);
		} else if (data_for == "friend") {
			$("#J_postage").html(friend_postage_money);
		} else {
			$("#J_postage").html(0);
		}
		
		resetMoney();
	});
	
	$(".payment_list span").click(function () {
		if ($(this).hasClass("selected")) {
			return;
		}
		
		var payment = $(this).data("payment");
		$("#payment_method").val(payment);
		
		$(this).addClass("selected");
		$(this).siblings().removeClass("selected");
	});
	
	$("#J_AddressList input[name='defaultRadio']").change(function () {
		getPostage();
	});

	$('#cart_add_form').ajaxForm({
		beforeSubmit: cart_add_form,
		success: showAddressResponse,
		dataType: 'json'
	});
	
	$(".js-express-address-list li").live("click", function (event) {
		var has_class = $(this).hasClass("order_curn");
		
		var v = $(this).data("address_id");
		$(this).addClass("order_curn");
		$(this).siblings().removeClass("order_curn");
		
		if (v == 'default') {
			document.getElementById("address_add").reset();
			$("#address_id").val("");
			$("#J_AddressEditContainer").show();
		} else {
			$("#address_id").val(v);
			$("#J_AddressEditContainer").hide();
		}
		
		if (has_class == false && v != "default") {
			getPostage();
		}
		event.stopPropagation(); 
	});
	

	// 自提地址li点击
	$(".js-self-address-list li").live("click", function (event) {
		$(this).addClass("order_curn");
		$(this).siblings().removeClass("order_curn");
	});
	
	// 更改优惠券
	$(".js-youhui").click(function () {
		$(".js-youhui span").removeClass("order_curn");
		$(this).find(".order_tongji_left span").addClass("order_curn");
		
		var coupon_money = parseFloat($(this).find(".js-coupon-money").html());
		if ($("#J_coupon_money").length > 0) {
			$("#J_coupon_money").html(coupon_money);
		}
		
		$("#coupon_id").val($(this).data("coupon_id"));
		resetMoney();
	});

	$('#js-time').live('focus', function() {
		var options = {
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: false,
			minDate : date_time
		};
		$('#js-time').datetimepicker(options);
	});
	
	$('#js-friend-time').live('focus', function() {
		var options = {
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: false,
			minDate : date_time
		};
		$('#js-friend-time').datetimepicker(options);
	});
	
	// 优惠券
	$("#J_user_coupon tr").click(function () {
		$(this).find("input").prop("checked", true);
		
		$("#coupon_id").val($(this).find("input").val());
		$("#J_coupon_money").html($(this).find("span").html());
		resetMoney();
	});
	
	$("#J_user_coupon tr").hover(function () {
		$(this).css("background", "#e9e9e9");
		$(this).css("cursor", "pointer");
	}, function () {
		$(this).css("background", "white");
	});
});

function cart_add_form() {
	var address_id = $("#address_id").val();
	var postage = $("#postage").val();
	var postage_friend = $("#postage_friend").val();
	$("#cart_add_submit").html("确认收货信息");
	
	if ($(".js-tab").length > 0 && $(".js-tab").find(".off").data("for") == "buyerInfo") {
		if (postage != "1") {
			if (address_msg.length > 0) {
				tusi(address_msg);
			} else {
				tusi("请选择收货地址");
			}
			$("#cart_add_submit").html("确认收货信息");
			is_click = false;
			return false;
		}
	} else if ($(".js-tab").length > 0 && $(".js-tab").find(".off").data("for") == "friend") {
		if (postage_friend != "1") {
			if (address_msg.length > 0) {
				tusi(address_msg);
			} else {
				tusi("请选择收货地址");
			}
			$("#cart_add_submit").html("确认收货信息");
			is_click = false;
			return false;
		}
	}
	
	return true;
}

function showAddressResponse(data) {
	if (data.status == true) {
		showResponse(data);
	} else {
		$("#cart_add_submit").html("确认收货信息");
		is_click = false;
		if (data.msg != '') {
			tusi(data.msg);
		}
	}
}

// 计算价格
function resetMoney() {
	var total_money = parseFloat($("#J_payTotalFee").html());
	var postage = parseFloat($("#J_postage").html());
	var t_money = parseFloat(total_money) + parseFloat(postage);
	var reward_money = 0;
	var reward_postage = 0;
	var coupon_money = 0;
	var float_money = 0;
	if ($("#J_reward_money").length > 0) {
		reward_money = parseFloat($("#J_reward_money").html());
	}
	
	if ($("#J_reward_postage_money").length > 0) {
		$("#J_reward_postage_money").html(postage);
		reward_postage = parseFloat(postage);
	}
	
	if ($("#J_coupon_money").length > 0) {
		coupon_money = parseFloat($("#J_coupon_money").html());
	}

	if ($("#J_float_money").length > 0) {
		float_money = parseFloat($("#J_float_money").html());
	}
	
	t_money = t_money - reward_money - reward_postage - coupon_money - float_money;
	
	$("#J_total_money").html(t_money);
}
