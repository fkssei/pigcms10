$(function () {
	var sc = document.getElementById("sc");
	if (screen.width < 1500) //获取屏幕的的宽度
	{
		sc.setAttribute("href", "/template/index/default/css/ie8.css"); //设置css引入样式表的路径
		$("#sn-bd").css("width", "1000px");
		$(".sn-container").css("width", "1000px");
		$(".js-preson-footer").css("margin-left", "0px");
	}
	
	// 增加购买数量
	$(".add").click(function () {
		var pigcms_id = $(this).parent().attr("data-cart-id");
		var number = parseInt($(this).parent().find(".buyNumInput").val());
		
		number++;
		var url = "index.php?c=cart&a=change&id=" + pigcms_id + "&number=" + number;
		var obj = $(this).parent().find(".buyNumInput");
		$.getJSON(url, function (data) {
			if (data.status == true) {
				obj.val(number);
				obj.attr("old_value", number);
			}
			cartResponse(data);
		});
	});
	
	// 减少购买数量
	$(".reduce").click(function () {
		var pigcms_id = $(this).parent().attr("data-cart-id");
		var number = parseInt($(this).parent().find(".buyNumInput").val());
		
		number--;
		if (number <= 0) {
			tusi("购买产品数量不能小于1");
			return;
		}
		
		var url = "index.php?c=cart&a=change&id=" + pigcms_id + "&number=" + number;
		var obj = $(this).parent().find(".buyNumInput");
		$.getJSON(url, function (data) {
			if (data.status == true) {
				obj.val(number);
				obj.attr("old_value", number);
			}
			cartResponse(data);
		});
	});
	
	// 直接更改数量操作
	$(".buyNumInput").blur(function () {
		var number = $.trim($(this).val());
		var old_val = $(this).attr("old_value");
		var pigcms_id = $(this).parent().attr("data-cart-id");
		
		if (number == old_val) {
			return;
		}
		
		var re = /^[0-9]+[0-9]*]*$/;
		if (!re.test(number)) {
			$(this).val(old_val);
			tusi("请正确填写购买数量");
			return;
		}
		number = parseInt(number);
		if (number <= 0) {
			$(this).val(old_val);
			tusi("购买产品数量不能小于1");
			return;
		}
		
		var url = "index.php?c=cart&a=change&id=" + pigcms_id + "&number=" + number;
		var obj = $(this);
		$.getJSON(url, function (data) {
			if (data.status == false) {
				obj.val(old_val);
				if (data.msg.length > 0) {
					tusi(data.msg);
				}
				return;
			}
			cartResponse(data);
		});
	});
	
	// 删除订单
	$(".j_cartDel").click(function () {
		if (!confirm("您确定要删除购买此产品？")) {
			return;
		}
		
		var pigcms_id = $(this).attr("data-cart-id");
		var url = "index.php?c=cart&a=change&id=" + pigcms_id + "&number=0";
		var tr_obj = $(this).closest("tr");
		$.getJSON(url, function (data) {
			if (data.status == true) {
				if (tr_obj.prev().hasClass("js-order-detail") || tr_obj.next().hasClass("js-order-detail")) {
					
				} else {
					tr_obj.prev().remove();
					tr_obj.prev().remove();
				}
				tr_obj.remove();
			}
			cartResponse(data);
		});
	});
	
	// 全选
	$(".store_check").click(function () {
		var store_id = $(this).val();
		
		if ($(this).attr("checked") == "checked") {
			$(".cart_list_" + store_id + " input[type='checkbox']").attr("checked", true);
		} else {
			$(".cart_list_" + store_id + " input[type='checkbox']").attr("checked", false);
		}
	});
	
	// 结算判断
	$(".cart-go").click(function () {
		if ($(this).hasClass("disabled")) {
			tusi("请勿重复提交");
			return;
		}
		
		$(this).addClass("disabled");
		var store_id = "0";
		var is_ok = true;
		$(".order-table input[type='checkbox']").each(function () {
			if ($(this).attr("checked") == "checked") {
				if (store_id == "0") {
					store_id = $(this).attr("data-store-id");
				}
				
				if (store_id != $(this).attr("data-store-id")) {
					is_ok = false;
				}
			}
		});
		
		if (store_id == "0") {
			tusi("请至少提交一个产品");
			$(this).removeClass("disabled");
			return;
		}
		
		if (!is_ok) {
			tusi("暂时只支付单店铺提交订单");
			$(this).removeClass("disabled");
			return;
		}
		
		$("#cart_form").submit();
	});
	
	// 表单提交
	$('#cart_form').ajaxForm({
		beforeSubmit: cartRequest,
		success: cartSucess,
		dataType: 'json'
	});
	
	function cartRequest() {
		return true;
	}
	
	function cartSucess(data) {
		if (data.status == false && data.msg == "nologin") {
			$(".cart-go").removeClass("disabled");
			alertlogin();
			return;
		} else if (data.status == false && data.msg != '') {
			$(".cart-go").removeClass("disabled");
			tusi(data.msg);
			return;
		} else if (data.status == true) {
			var url = '/index.php?c=order&a=address&order_id=' + data.data.order_no;
			location.href = url;
		} else {
			$(".cart-go").removeClass("disabled");
			tusi("网络错误");
			return;
		}
	}
	
	// 清空购物车
	$(".j_cartDelAll").click(function () {
		if (!confirm("您确定要清空购物车吗？")) {
			return;
		}
		
		var url = "index.php?c=cart&a=clear";
		$.getJSON(url, function (data) {
			if (data.status == true) {
				tusi(data.msg);
				$("#J_OrderTable tbody").remove();
				$(".mc-count").html(0);
				
				var html = '<tbody><tr class="sep-row"><td colspan="6"> </td></tr><tr class="order-hd order-hd-nobg bright"><td colspan="6" style="text-align:center;">购物为空，您可以<a href="/" style="font-weight: bold;">进入首页</a>，或<a href="javascript:history.back();" style="font-weight: bold;">返回</a></td></tr></tbody>'
				$("#J_OrderTable").append(html);
			}
		});
	});
});


function cartResponse(data) {
	if (data.status == false) {
		showResponse(data);
		return;
	}
	
	if (data.msg.length > 0) {
		tusi(data.msg);
	}
	
	// 更改单个产品小计
	var cart_total = 0;
	var cart_money = 0;
	$("input[type='text']").each(function () {
		var num = parseInt($(this).val());
		var price = parseFloat($(this).attr("data-price"));
		var product_id = $(this).attr("data-product_id");
		cart_total += num;
		cart_money += num * price;
		$("#product_price_total_" + product_id).html(num * price);
	});
	
	
	$(".cart-allPrice").html(" &yen; " + cart_money);
	$(".cart-nums").html(cart_total);
	$(".mc-count").html(cart_total);
}
