// 防止重复提交
// 提交提示信息
var is_submit = false;
var has_image = 0;
var is_save_comment = false;

//读取cookies
function getCookie2(objName){//获取指定名称的cookie的值
//alert(objName)
	var arrStr = document.cookie.split("; ");
	for(var i = 0;i < arrStr.length;i ++){
		var temp = arrStr[i].split("=");
		if(temp[0] == objName) return unescape(temp[1]);
	}
}

function getUserDistance2() {
	
	if(getCookie2("Web_user")) {
	var Cookie_web_user = getCookie2("Web_user");
	
	var objj = eval("("+Cookie_web_user+")");
	
	} else {

		return false;
	}
	return objj;
}


var lat_long =  getUserDistance2();

$(document).ready(function() {
	//var h=$(".shopping").offset().left;
        var navH = $(".shopping_dingwei").offset().top - 0;
        $(window).scroll(function() {
            var scroH = $(this).scrollTop();
            if (scroH >= navH) {
                 $(".shopping_dingwei").css({
                    "position": "fixed",
                    "top": "0px",
					"left":"0px"
					
                });
            } else if (scroH < navH) {			
              $(".shopping_dingwei").css({
                    "position": "absolute",
                    "top": "0%",
					"left":"0"
                });
            }
        })
})

$(function () {
	
	setKus();
	// 计算距离与运送时间
	var long = $(".js-distance").data("long");
	var lat = $(".js-distance").data("lat");
	if(long && lat_long) {
		var distance = (getFlatternDistance(lat_long.lat, lat_long.long, lat, long) / 1000).toFixed(2);	
		$(".js-express").html(expressTime(parseFloat(distance)));
		$(".js-distance").html("<i></i>" + distance + "km");
	} else {
		$(".js-express").html("商家未设置位置");
		$(".js-distance").html("<i></i>0km");
	}
	
	$(".namub_right div").css("cursor", "pointer");
	
	// 减少数量
	$(".stock-change-reduce").click(function () {
		var amout = parseInt($(".stock-change-amout").val());
		
		if (amout <= 1) {
			return;
		}
		
		$(".stock-change-amout").val(--amout);
	});
	
	// 增加数量
	$(".stock-change-increase").click(function () {
		var amout = parseInt($(".stock-change-amout").val());
		
		if (is_sku == '1') {
			// 判断购买是否大于库存
			var sku = parseInt($("#sAmout").text());
			
			if (sku <= amout) {
				tusi("您购买的数量不能大于库存数量");
				return;
			}
		}
		$(".stock-change-amout").val(++amout);
	});
	
	
	// 产品属性选择
	$(".item_property_detail .js_selected_property").click(function () {
		if ($(this).hasClass("notallowed")) {
			return;
		}
		var index = $(this).closest(".item_property_detail").data("index");
		
		var is_selected = $(this).hasClass("selected");
		$(this).closest(".item_property_detail").find("div").removeClass("selected");
		
		if (!is_selected) {
			$(this).addClass("selected");
		}
		setKus(index);
		changePriceAndKu();
	});
	
	// 立即购买
	$(".dt-go").click(function () {
		if (!is_logistics && !is_selffetch) {
			tusi("商家未设置物流方式，暂时不能购买");
			return;
		}
		if (is_submit) {
			tusi("正在提交，请勿重复提交");
			return;
		}
		// 首先检查是否选择产品属性
		if (selectProperty()) {
			dtMessage('show');
			var product_id = $("#product_id").val();
			var sku_id = $("#sku_id").val();
			var quantity = $("#quantity").val();
			$.post('/index.php?c=order&a=add', {"product_id" : product_id, "sku_id" : sku_id, "quantity" : quantity, "type" : "add"}, function (data) {
				if (data.status == false && data.msg == "nologin") {
					dtMessage('hide');
					alertlogin();
					return;
				} else if (data.status == false && data.msg != '') {
					dtMessage('hide');
					tusi(data.msg);
					return;
				} else if (data.status == true) {
					var url = '/index.php?c=order&a=address&order_id=' + data.data.order_no;
					window.location.href = url;
				} else {
					dtMessage('hide');
					tusi("网络错误");
					return;
				}
			}, 'json');
		}
	});
	
	// 加入购物车
	//$(".dt-cart").click(function (event) {

	// 加入购物车

	$(".dt-cart").click(function (event) {
		if (!is_logistics && !is_selffetch) {
			tusi("商家未设置物流方式，暂时不能购买");
			return;
		}
		if (is_submit) {
			tusi("正在提交，请勿重复提交");
			return; 
		}
		// 首先检查是否选择产品属性
		if (selectProperty()) {
			dtMessage('show');
			var product_id = $("#product_id").val();
			var sku_id = $("#sku_id").val();
			var quantity = $("#quantity").val();
			$.post('/index.php?c=order&a=add', {"product_id" : product_id, "sku_id" : sku_id, "quantity" : quantity, "type" : "cart"}, function (data) {
				if (data.status == false && data.msg == "nologin") {
					alertlogin();
				} else if (data.status == false && data.msg != '') {
					tusi(data.msg);
				} else if (data.status == true) {
					try {
						if (data.data.number > 0) {
							$("#header_cart_number").html(data.data.number);
							if(data.data.number>99) data.data.number=99;
							$(".mui-mbar-tab-sup-bd").html(data.data.number);
						}
					} catch (e) {
					
					}
					
					addCart_pf(event)
					tusi("加入购物车成功");
				} else {
					tusi("网络错误");
				}
				dtMessage('hide');
				return;
			}, 'json');
		}
	});
 

	
	// 满意度
	$(".js-score button").click(function () {
		$("#score").val($(this).data("value"));
	});
	
	// 自动加载评论
	var id = $("#product_id").val();
	var load_image = 0;
	try {
		if(location.hash == "#product_comment_image") {
			load_image = 1;
			$("#has_image").prop("checked", true);
		}
	} catch (e) {
		load_image = 0;
	}
	getComment(id, "PRODUCT", "ALL", load_image, 1);
	
	// 切换显示
	$(".tab_title a").click(function () {
		$(this).addClass('on').siblings().removeClass('on');
		var index = $(".tab_title a").index($(this));
		var tab = $(this).data("tab");
		var has_image = 0;
		if ($("#has_image").prop("checked")) {
			has_image = 1;
		}
		
		$(".content_tab li").eq(index).show();
		$(".content_tab li").eq(index).siblings().hide();
		
		if ($(".content_tab li").eq(index).find(".js_default").length == 1) {
			getComment(id, "PRODUCT", tab, has_image, 1);
		}
	});
	
	// 有照片
	$("#has_image").click(function () {
		var tab = $(".tab_title").find(".on").data("tab");
		var has_image = 0;
		if ($(this).prop("checked")) {
			has_image = 1;
		}
		
		$(".content_tab li").html('<div style="height:24px; line-height:24px; padding-top:20px;" class="js_default">加载中</div>');
		
		getComment(id, "PRODUCT", tab, has_image, 1);
	});
	
	// 弹层显示图片
	$(".content_tab .attachment_list img").live("click", function () {
		var rel = $(this).attr("rel");
		alert(rel)
		$("image[rel=" + rel + "]").fancybox({
			'titlePosition' : 'over',
			'cyclic'		: true,
			'titleFormat'	: function(title, currentArray, currentIndex, currentOpts) {
						return '<span id="fancybox-title-over">' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
			}
		});
		
	});
	
	$("textarea[name='content']").bind("keyup blur", function () {
		var word_count = $(this).val().length;
		if (word_count > 300) {
			$(this).val($(this).val().substr(0, 300));
			word_count = 300;
		}
		
		$(".js-word-number").html(word_count + "/" + 300);
	});
	
	
	// 上传图片
	$("#upload_image").change(function () {
		if (is_login != true) {
			alertlogin();
			$(this).val('');
			return;
		}
		
		if ($(".shop_pingjia_list ul").find("li").size() == 11) {
			tusi("最多只能上传10张图片");
			$(this).val('');
			return false;
		}
		var file = $(this).val();
		if (file.length == 0) {
			return;
		}
		
		if(!/.(gif|jpg|jpeg|png)$/.test(file)) {
			alert("图片类型必须是gif,jpeg,jpg,png中的一种");
			return;
		} else {
			$("#upload_message").html("上传中");
			$("#upload_image_form").submit();
		} 
	});
	
	// 删除上传图片
	$(".shop_pingjia_list span").live("click", function () {
		$(this).closest("li").remove();
		uploadImageNumber();
	});
	
	$("#upload_image_form").ajaxForm({
		beforeSubmit: showRequestUpload,
		success: showResponseUpload,
		dataType: 'json'
	});
	
	// 提交评论
	$(".js_save").click(function () {
		var product_id = $("#product_id").val();
		var tag_id_str = "";
		var content = $("textarea[name='content']").val();
		var score = $("input[name='manyi']:checked").val();
		
		if (content.length == 0) {
			$("textarea[name='content']").focus();
			tusi("请填写评论内容");
			return;
		}
		
		if (is_save_comment) {
			tusi("正在提交中，请稍后");
			return;
		}
		is_save_comment = true;
		
		$(".js-tag").each(function () {
			if ($(this).prop("checked")) {
				if (tag_id_str.length == 0) {
					tag_id_str = $(this).val();
				} else {
					tag_id_str += "," + $(this).val();
				}
			}
		});
		
		var images_id_str = "";
		var li_size = $(".shop_pingjia_list li").size();
		$(".shop_pingjia_list li").each(function (i) {
			if (i != li_size - 1) {
				if (images_id_str.length == 0) {
					images_id_str = $(this).data("attachment_id");
				} else {
					images_id_str += "," + $(this).data("attachment_id");
				}
			}
		});
		
		$.post(comment_add, {"id" : product_id, "type" : "PRODUCT", "score" : score, "content" : content, "images_id_str" : images_id_str, "tag_id_str" : tag_id_str}, function (data) {
			try {
				if (data.status == true) {
					tusi("评论成功");
					$(".tab_title a").removeClass("on");
					$(".tab_title a").eq(0).addClass("on");
					
					var id = $("#product_id").val();
					getComment(id, "PRODUCT", "ALL", 0, 1);
					
					$(".tab_title span").eq(0).html(parseInt($(".tab_title span").eq(0).html()) + 1);
					if (score == "5") {
						$(".tab_title span").eq(1).html(parseInt($(".tab_title span").eq(1).html()) + 1);
					} else if (score == "3") {
						$(".tab_title span").eq(2).html(parseInt($(".tab_title span").eq(2).html()) + 1);
					} else {
						$(".tab_title span").eq(3).html(parseInt($(".tab_title span").eq(3).html()) + 1);
					}
					
					$("input[name='manyi']").eq(0).prop("checked", true);
					$(".js-tag").prop("checked", false);
					$("textarea[name='content']").val("");
					$(".shop_pingjia_list li").each(function (i) {
						if (i != li_size - 1) {
							$(this).remove();
						}
					});
					
					is_save_comment = false;
				} else {
					if (data.msg == "nologin") {
						alertlogin();
						return;
					} else {
						showResponse(data);
					}
				}
			} catch(e) {
				tusi("评论失败");
			}
		}, "json");
	});
	
	// 分页
	$(".page_list a").live("click", function () {
		var page = $(this).data("page-num");
		var id = $("#product_id").val();
		var tab = $(".tab_title .on").data("tab");
		getComment(id, "PRODUCT", tab, has_image, page);
	});
	
	// 分页
	$(".js-jump-page-btn").live("click", function () {
		var page = $(this).closest("form").find(".js-jump-page").val();
		var reg1 =  /^\d+$/;
		if(page.match(reg1) == null) {
			tusi('请用正确填写页码');
			$(this).closest("form").find(".js-jump-page").val('');
			$(this).closest("form").find(".js-jump-page").focus();
			return;
		}
		var id = $("#product_id").val();
		var tab = $(".tab_title .on").data("tab");
		getComment(id, "PRODUCT", tab, has_image, page);
	});
	
	if ($(".contact_shop").attr("open-url")) {
		$(".contact_shop").removeClass("js-contact_shop");
	}
	
	$(".contact_shop").click(function () {
		var open_url = $(this).attr("open-url");
		 $.post('/index.php?c=public&a=checkLogin',{},function(res){
			if(res.err_msg == 'logined'){
				var url 	= open_url;
				openWin(url);
			}else{
				alertlogin();
			}
		});
	});
});

function showRequestUpload() {
	return true;
}

function showResponseUpload(data) {
	try {
		if (data.status == true) {
			var html_upload = '<li data-attachment_id="' + data.data.id + '"><img src="' + data.data.file + '" /><span></span></li>';
			var form_li_html = $(".shop_pingjia_list ul").last("li").html();
			$(".shop_pingjia_list ul li").eq(-1).before(html_upload);
			
			$("#upload_message").html("添加图片");
			uploadImageNumber();
		} else {
			showResponse(data);
		}
		
	} catch (e) {
		tusi("上传失败");
		return;
	}
}

function uploadImageNumber() {
	var number = $(".shop_pingjia_list ul").find("li").size() - 1;
	$(".updat_pic p").html(number + "/10");
}

//更改显示价格和库存
function changePriceAndKu() {
	if (!has_property) {
		return;
	}
	
	$(".stock-change-amout").val(1);
	$("#sku_id").val('');
	
	var select_property_detail = '';
	var is_break = false;
	
	$(".item_property_detail").each(function () {
		if (is_break) {
			return;
		}
		
		if (typeof $(this).find(".selected").attr('data-sku') != 'undefined') {
			if (select_property_detail == '') {
				select_property_detail = $(this).find(".selected").attr('data-sku');
			} else {
				select_property_detail += ";" + $(this).find(".selected").attr('data-sku');
			}
		} else {
			is_break = true;
		}
	});

	if (!is_break) {
		for(i = 0; i < product_sku.length; i++) {
			if (product_sku[i].properties == select_property_detail) {
				// 更改价格
				$(".j_realPrice").html(product_sku[i].price);
				// 更改库存
				$("#sAmout").html(product_sku[i].quantity);
				$("#sku_id").val(product_sku[i].sku_id);
			}
		}
	}
}

//提交时判断是否选择了相关属性
function selectProperty() {
	if (!has_property) {
		return true;
	}
	
	var is_break = false;
	$(".item_property_detail").each(function () {
		if (is_break) {
			return false;
		}
		
		
		if (typeof($(this).find(".selected").attr('data-sku')) == 'undefined') {
			var msg = $(this).find(".js_property_name").data("msg")
			tusi('请选择' + msg);
			is_break = true;
			return false;
		}
	});
	
	
	if (is_break) {
		return false;
	} else {
		return true;
	}
}

function dtMessage(type) {
	if (type == 'show') {
		is_submit = true;
		$(".dt-showtxt").css("display", "block");
	} else {
		is_submit = false;
		$(".dt-showtxt").css("display", "none");
	}
}

function getComment(id, type, tab, has_image, page) {
	//var url = comment_url + "?id=" + id + "&type=" + type + "&tab=" + tab + "&has_image=" + has_image
	var i = 0;
	if (tab == 'HAO') {
		i = 1;
	} else if (tab == 'ZHONG') {
		i = 2;
	} else if (tab == 'CHA') {
		i = 3;
	} else {
		i = 0;
	}
	
	$(".content_tab").find("li").eq(i).show();
	$(".content_tab").find("li").eq(i).siblings().hide();
	$(".content_tab").find("li").eq(i).html('<div style="height:24px; line-height:24px; padding-top:20px;" class="js_default">加载中</div>');
	
	$.get(comment_url, {"id" : id, "type" : type, "tab" : tab, "has_image" : has_image, "page" : page}, function (data) {
		$(".content_tab").find("li").eq(i).html(data);
		
		loadBind();
	});
}

// 重新绑定事件
function loadBind() {
	$(".attachment_list").each(function () {
		var rel = $(this).data("rel");
		
		$("a[rel=" + rel + "]").fancybox({
			'titlePosition' : 'over',
			'cyclic'		: false,
			'titleFormat'	: function(title, currentArray, currentIndex, currentOpts) {
				return '<span id="fancybox-title-over">' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
			}
		});
	});
}

// 产品属性筛选时，库存为0的不给选
function setKus(index) {
	if (!has_property) {
		return;
	}
	
	var property_length = $(".item_property_detail").length;
	if (typeof index == "undefined" && property_length > 1) {
		return;
	}
	
	if (property_length == 1) {
		for(var i in product_sku) {
			if (product_sku[i]["quantity"] == "0") {
				$(".item_property_detail .js_selected_property").each(function () {
					if ($(this).data("sku") == product_sku[i]["properties"]) {
						$(this).addClass("notallowed")
					} else {
						$(this).removeClass("notallowed")
					}
				});
			}
		}
	} else if (property_length == 2) {
		var first_sku_dom = $(".item_property_detail").eq(0);
		var second_sku_dom = $(".item_property_detail").eq(1);
		
		if (index == 0) {
			var sku1_str = first_sku_dom.find(".selected").data("sku");
			$.each(second_sku_dom.find(".js_selected_property"), function () {
				sku_str = sku1_str + ";" + $(this).data("sku");
				for(i in product_sku) {
					if (sku_str == product_sku[i]["properties"] && product_sku[i]["quantity"] == "0") {
						$(this).addClass("notallowed")
						break;
					} else {
						$(this).removeClass("notallowed")
					}
				}
			});
		} else {
			var sku2_str = second_sku_dom.find(".selected").data("sku");
			$.each(first_sku_dom.find(".js_selected_property"), function () {
				sku_str = $(this).data("sku") + ";" + sku2_str;
				for(i in product_sku) {
					if (sku_str == product_sku[i]["properties"] && product_sku[i]["quantity"] == "0") {
						$(this).addClass("notallowed")
						break;
					} else {
						$(this).removeClass("notallowed")
					}
				}
			});
		}
	} else if (property_length == 3) {
		if ($(".item_property_detail").find(".selected").length < 2) {
			$(".js_selected_property").removeClass("notallowed");
			return;
		}
		
		var first_sku_dom = $(".item_property_detail").eq(0);
		var second_sku_dom = $(".item_property_detail").eq(1);
		var three_sku_dom = $(".item_property_detail").eq(2);
		if (index == 0) {
			if (first_sku_dom.find(".selected").length == 0) {
				second_sku_dom.find(".js_selected_property").removeClass("notallowed");
				three_sku_dom.find(".js_selected_property").removeClass("notallowed");
				$.each(first_sku_dom.find(".js_selected_property"), function () {
					sku_str = $(this).data("sku") + ";" + second_sku_dom.find(".selected").data("sku") + ";" + three_sku_dom.find(".selected").data("sku");
					
					for(i in product_sku) {
						if (sku_str == product_sku[i]["properties"] && product_sku[i]["quantity"] == "0") {
							$(this).addClass("notallowed")
							break;
						} else {
							$(this).removeClass("notallowed")
						}
					}
				});
				return;
			}
			
			if (second_sku_dom.find(".selected").length > 0) {
				$.each(three_sku_dom.find(".js_selected_property"), function () {
					sku_str = first_sku_dom.find(".selected").data("sku") + ";" + second_sku_dom.find(".selected").data("sku") + ";" + $(this).data("sku");
					
					for(i in product_sku) {
						if (sku_str == product_sku[i]["properties"] && product_sku[i]["quantity"] == "0") {
							$(this).addClass("notallowed")
							break;
						} else {
							$(this).removeClass("notallowed")
						}
					}
				});
			}
			
			if (three_sku_dom.find(".selected").length > 0) {
				$.each(second_sku_dom.find(".js_selected_property"), function () {
					sku_str = first_sku_dom.find(".selected").data("sku") + ";" + $(this).data("sku") + ";" + three_sku_dom.find(".selected").data("sku");
					
					for(i in product_sku) {
						if (sku_str == product_sku[i]["properties"] && product_sku[i]["quantity"] == "0") {
							$(this).addClass("notallowed")
							break;
						} else {
							$(this).removeClass("notallowed")
						}
					}
				});
			}
		} else if (index == 1) {
			if (second_sku_dom.find(".selected").length == 0) {
				first_sku_dom.find(".js_selected_property").removeClass("notallowed");
				three_sku_dom.find(".js_selected_property").removeClass("notallowed");
				$.each(second_sku_dom.find(".js_selected_property"), function () {
					sku_str = first_sku_dom.find(".selected").data("sku") + ";" + $(this).data("sku") + ";" + three_sku_dom.find(".selected").data("sku");
					
					for(i in product_sku) {
						if (sku_str == product_sku[i]["properties"] && product_sku[i]["quantity"] == "0") {
							$(this).addClass("notallowed")
							break;
						} else {
							$(this).removeClass("notallowed")
						}
					}
				});
				return;
			}
			
			$(".item_property_detail").eq(index).find(".js_selected_property").addClass("cursor", "pointer");
			
			if (first_sku_dom.find(".selected").length > 0) {
				$.each(three_sku_dom.find(".js_selected_property"), function () {
					sku_str = first_sku_dom.find(".selected").data("sku") + ";" + second_sku_dom.find(".selected").data("sku") + ";" + $(this).data("sku");
					
					for(i in product_sku) {
						if (sku_str == product_sku[i]["properties"] && product_sku[i]["quantity"] == "0") {
							$(this).addClass("notallowed")
							break;
						} else {
							$(this).removeClass("notallowed")
						}
					}
				});
			}
			
			if (three_sku_dom.find(".selected").length > 0) {
				$.each(first_sku_dom.find(".js_selected_property"), function () {
					sku_str = $(this).data("sku") + ";" + second_sku_dom.find(".selected").data("sku") + ";" + three_sku_dom.find(".selected").data("sku");
					
					for(i in product_sku) {
						if (sku_str == product_sku[i]["properties"] && product_sku[i]["quantity"] == "0") {
							$(this).addClass("notallowed")
							break;
						} else {
							$(this).removeClass("notallowed")
						}
					}
				});
			}
		} else if (index == 2) {
			if (three_sku_dom.find(".selected").length == 0) {
				first_sku_dom.find(".js_selected_property").removeClass("notallowed");
				second_sku_dom.find(".js_selected_property").removeClass("notallowed");
				$.each(three_sku_dom.find(".js_selected_property"), function () {
					sku_str = first_sku_dom.find(".selected").data("sku") + ";" + second_sku_dom.find(".selected").data("sku") + ";" + $(this).data("sku");
					
					for(i in product_sku) {
						if (sku_str == product_sku[i]["properties"] && product_sku[i]["quantity"] == "0") {
							$(this).addClass("notallowed")
							break;
						} else {
							$(this).removeClass("notallowed")
						}
					}
				});
				return;
			}
			
			
			if (first_sku_dom.find(".selected").length > 0) {
				$.each(second_sku_dom.find(".js_selected_property"), function () {
					sku_str = first_sku_dom.find(".selected").data("sku") + ";" + $(this).data("sku") + ";" + three_sku_dom.find(".selected").data("sku");
					
					for(i in product_sku) {
						if (sku_str == product_sku[i]["properties"] && product_sku[i]["quantity"] == "0") {
							$(this).addClass("notallowed")
							break;
						} else {
							$(this).removeClass("notallowed")
						}
					}
				});
			}
			
			if (second_sku_dom.find(".selected").length > 0) {
				$.each(first_sku_dom.find(".js_selected_property"), function () {
					sku_str = $(this).data("sku") + ";" + second_sku_dom.find(".selected").data("sku") + ";" + three_sku_dom.find(".selected").data("sku");
					
					for(i in product_sku) {
						if (sku_str == product_sku[i]["properties"] && product_sku[i]["quantity"] == "0") {
							$(this).addClass("notallowed")
							break;
						} else {
							$(this).removeClass("notallowed")
						}
					}
				});
			}
		}
	}
}