$(function () {
	$("input[name='defaultRadio']").click(function () {
		var val = $(this).val();
		
		
		if (val == "default") {
			document.getElementById("address_add").reset();
			$("#address_id").val("");
			$("#J_AddressEditContainer").show();
		} else {
			$("#J_AddressEditContainer").hide();
		}
	});
	
	$("#cart_add_submit").click(function () {
		if (!is_logistics && !is_selffetch) {
			tusi("商家未设置物流方式，暂时不能购买");
			return;
		}
		var address_id;
		
		if (is_click) {
			return;
		}
		is_click = true;
		$("#cart_add_submit").html("正在提交信息");
		$(".js-express-address-list li").each(function () {
			if ($(this).hasClass('order_curn')) {
				address_id = $(this).data("address_id");
			}
		});
		
		if ($(".js-tab").length > 0) {
			var shipping_method = $(".js-tab").find(".off").data("for");
			if (shipping_method == "buyerInfo") {
				$("#shipping_method").val("express");
				if (address_id == 'default') {
					tusi("请选择收货地址");
					$("#cart_add_submit").html("确认收货信息");
					is_click = false;
					return false;
				}
			} else if (shipping_method == "friend") {
				$("#shipping_method").val("friend");
				var friend_name = $("#friend_name").val();
				var provinceId_friend = $("#provinceId_friend").val();
				var cityId_friend = $("#cityId_friend").val();
				var areaId_friend = $("#areaId_friend").val();
				var jiedao_friend = $("#jiedao_friend").val();
				var friend_tel = $("#friend_tel").val();
				var friend_time = $("#js-friend-time").val();
				
				if (friend_name.length == 0) {
					$("#friend_name").focus();
					tusi("请填写朋友姓名");
					$("#cart_add_submit").html("确认收货信息");
					is_click = false;
					return false;
				}
				
				if (provinceId_friend.length == 0) {
					$("#provinceId_friend").focus();
					tusi("请选择省份");
					$("#cart_add_submit").html("确认收货信息");
					is_click = false;
					return false;
				}
				
				if (cityId_friend.length == 0) {
					$("#cityId_friend").focus();
					tusi("请选择城市");
					$("#cart_add_submit").html("确认收货信息");
					is_click = false;
					return false;
				}
				
				if (areaId_friend.length == 0) {
					$("#areaId_friend").focus();
					tusi("请选择区县");
					$("#cart_add_submit").html("确认收货信息");
					is_click = false;
					return false;
				}
				
				if (jiedao_friend.length < 10) {
					$("#jiedao_friend").focus();
					tusi('街道地址不能少于10个字');
					$("#cart_add_submit").html("确认收货信息");
					is_click = false;
					return false;
				}
				
				if (friend_tel.length == 0) {
					$("#friend_tel").focus();
					tusi('请填写手机号码');
					$("#cart_add_submit").html("确认收货信息");
					is_click = false;
					return false;
				}

				if (!checkMobile(friend_tel)) {
					$("#friend_tel").focus();
					tusi("手机号码格式不正确");
					$("#cart_add_submit").html("确认收货信息");
					is_click = false;
					return false;
				}
				$("#address_user").val(friend_name);
				$("#address_tel").val(friend_tel);
				$("#address_time").val(friend_time);
				$("#provinceId").val(provinceId_friend);
				$("#cityId").val(cityId_friend);
				$("#areaId").val(areaId_friend);
				$("#address_friend").val(jiedao_friend);
			} else {
				$("#shipping_method").val("selffetch");
				var self_name = $("#self_name").val();
				var self_tel = $("#self_tel").val();
				var time = $("#js-time").val();

				if (self_name.length == 0) {
					$("#self_name").focus();
					tusi("请填写预约人姓名");
					$("#cart_add_submit").html("确认收货信息");
					is_click = false;
					return false;
				}
				
				if (self_tel.length == 0) {
					$("#self_tel").focus();
					tusi("请填写手机号码");
					$("#cart_add_submit").html("确认收货信息");
					is_click = false;
					return false;
				}

				if (!checkMobile(self_tel)) {
					$("#self_tel").focus();
					tusi("请填写正确的手机号");
					$("#cart_add_submit").html("确认收货信息");
					is_click = false;
					return false;
				}
				
				if (time.length == 0) {
					$("#js-time").focus();
					tusi("请选择预约时间");
					$("#cart_add_submit").html("确认收货信息");
					is_click = false;
					return false;
				}
				$("#selffetch_id").val($(".js-self-address-list").find(".order_curn").data("address-id"));
				$("#address_user").val(self_name);
				$("#address_tel").val(self_tel);
				$("#address_time").val(time);
			}
		} else {
			if (address_id == 'default') {
				tusi("请选择收货地址");
				$("#cart_add_submit").html("确认收货信息");
				is_click = false;
				return false;
			}
		}
		
		if ($(".js-payment_list").size() > 0) {
			var payment_obj = $(".js-payment_list").find(".selected");
			if (payment_obj.data("payment") == "off" && payment_obj.css("display") == "none") {
				tusi("请选择支付方式 ");
				$("#cart_add_submit").html("确认收货信息");
				is_click = false;
				return false;
			}
			
			$("#payment_method").val(payment_obj.data("payment"));
		} else {
			$("#payment_method").val("on");
		}

		$("#express_address_id").val(address_id);
		$("input[name='comment']").val($("input[name='buyer_comment']").val());
		
		$("#cart_add_form").submit();
	});
	
	$(".e-modify").live('click',function (event) {
		var address_id = $(this).attr("data_id");
		var name = $(this).attr("data_name");
		var province = $(this).attr("data_province");
		var city = $(this).attr("data_city");
		var area = $(this).attr("data_area");
		var tel = $(this).attr("data_tel");
		var address = $(this).attr('data_address');
		var moren = $(this).attr("data_default");
		
		
		$("#name").val(name);
		$("#tel").val(tel);
		$("#provinceId_m").attr("data-province", province);
		$("#cityId_m").attr("data-city", city);
		$("#areaId_m").attr("data-area", area);
		$("#jiedao").val(address);
		$("#address_id").val(address_id);
		
		if (moren == '1') {
			$("#isDefault").attr("checked", true);
		}
		
		event.stopPropagation();
		$("#J_AddressEditContainer").show();
		changeArea();
	});
	
	// 删除
	$(".e-delete").click(function (event) {
		var address_id = $(this).attr("data-address-id");
		
		if (confirm('您确认要删除些收货地址？')) {
			var url = 'index.php?c=account&a=delete_address&id=' + address_id;
			$.getJSON(url, function (data) {
				if (data.status == true) {
					$("#address_" + address_id).remove();
				}
				if (data.msg != '') {
					tusi(data.msg);
				}
			});
		}
		event.stopPropagation(); 
	});
	
	try {
		getProvinces('provinceId_m','','省份');
	} catch(e) {
		
	}
	
	$('#provinceId_m').change(function(){
		if($(this).val() != ''){
			getCitys('cityId_m','provinceId_m','','城市');
		}else{
			$('#cityId_m').html('<option value="">城市</option>');
		}
		$('#areaId_m').html('<option value="">区县</option>');
	});
	$('#cityId_m').change(function(){
		if($(this).val() != ''){
			getAreas('areaId_m','cityId_m','','区县');
		}else{
			$('#areaId_m').html('<option value="">区县</option>');
		}
	});
	
	$("#checkBuyerInfo").click(function () {
		$("#address_add").submit();
	});
});


$(document).ready(function () {
	$('#address_add').ajaxForm({
		beforeSubmit: showRequest,
		success: cartAddress,
		dataType: 'json'
	});
});


function showRequest() {
	var name = $("#name").val();
	var tel = $("#tel").val();
	var province = $("#provinceId_m").val();
	var city = $("#cityId_m").val();
	var area = $("#areaId_m").val();
	var address = $("#jiedao").val();

	if (name.length == 0) {
		tusi("请填写收货人姓名");
		$("#name").focus();
		return false;
	}

	if (tel.length == 0) {
		tusi('请填写手机号码');
		$("#tel").focus();
		return false;
	}

	if (!checkMobile(tel)) {
		tusi("手机号码格式不正确");
		$("#tel").focus();
		return false;
	}

	if (province.length <= 0) {
		tusi("请选择省份");
		$("#provinceId_m").focus();
		return false;
	}

	if (city.length <= 0) {
		tusi("请选择城市");
		$("#cityId_m").focus();
		return false;
	}

	if (area.length <= 0) {
		tusi("请选择地区");
		$("#areaId_m").focus();
		return false;
	}

	if (address.length < 10) {
		tusi('街道地址不能少于10个字');
		("#jiedao").focus();
		return false;
	}

	if (address.length　> 120) {
		tusi('街道地址不能多于120个字');
		("#jiedao").focus();
		return false;
	}
	
	return true;
}

function cartAddress(data) {
	if (data.status == true) {
		if (data.data.address != '') {
			changeAddress(data.data.address);
			$("#J_AddressEditContainer").hide();
		}
		
		if (data.msg != '') {
			tusi(data.msg);
		}
	} else {
		if (data.msg != '') {
			tusi(data.msg);
		}
	}
}


function changeAddress(address) {
	var str = '<span></span>';
	str += '<div class="order_add_add">' + address.province_txt + address.city_txt + address.area_txt + address.address + '</div>';
	str += '<div class="order_add_name">' + address.name + '</div>';
	str += '<div class="order_add_shouji">' + address.tel + '</div>';
	str += '<div class="order_add_caozuo">';
	str += '	<i  class="e-modify" data_id="' + address.address_id + '" data_name="' + address.name + '>" data_province="' + address.province + '" data_city="' + address.city + '" data_area="' + address.area + '" data_tel="' + address.tel + '" data_address="' + address.address + '" data_default="' + address.default + '">修改</i>|<i data-address-id="' + address.address_id + '" class="e-delete">删除</i>';
	str += '</div>';
	
	if ($('#address_' + address.address_id).length > 0) {
		$('#address_' + address.address_id).html(str);
		$(".js-express-address-list li").removeClass("order_curn");
		$('#address_' + address.address_id).addClass("order_curn");
	} else {
		str = '<li class="order_curn" id="address_' + address.address_id + '" class="current" data-address_id="' + address.address_id + '">' + str + '</tr>';
		$(".js-express-address-list li").removeClass("order_curn");
		$(".js-express-address-list li").eq(-1).before(str);
		//$("#J_AddressList").append(str);
	}
	
	// 更新
	try {
		getPostage();
	} catch (e) {
		
	}
	//$(".address-table a").click();
}

function changeArea() {
	getProvinces('provinceId_m',$('#provinceId_m').attr('data-province'),'省份');
	getCitys('cityId_m','provinceId_m',$('#cityId_m').attr('data-city'),'城市');
	getAreas('areaId_m','cityId_m',$('#areaId_m').attr('data-area'),'区县');
	$('#provinceId_m').change(function(){
		if($(this).val() != ''){
			getCitys('cityId_m','provinceId_m','','城市');
		}else{
			$('#cityId_m').html('<option value="">城市</option>');
		}
		$('#areaId_m').html('<option value="">区县</option>');
	});
	$('#cityId_m').change(function(){
		if($(this).val() != ''){
			getAreas('areaId_m','cityId_m','','区县');
		}else{
			$('#areaId_m').html('<option value="">区县</option>');
		}
	});
}