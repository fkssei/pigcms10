$(function () {
	// 默认显示产品
	getGoods();
	
	// 分享，收藏
	$(".js-store-operation a").hover();
	
	// 菜单
	$(".js-menu li").click(function () {
		$(this).addClass("off");
		$(this).siblings().removeClass("off");
		
		var index = $(".js-menu li").index($(this));
		var type = $(this).data("type");
		
		var show_obj = $(".js-content .js-content-detail").eq(index);
		$(".js-content .js-content-detail").hide();
		show_obj.show();
		
		switch(index) {
			case 0:
				if (show_obj.find(".js-default").length > 0) {
					getGoods();
				}
				break;
			case 1:
				initMap();//创建和初始化地图
				break;
			case 2:
				getComment("ALL", "0", 1);
				break;
			case 3:
				if (show_obj.find(".js-default").length > 0) {
					getFinancial(1);
				}
				break;
			default:
				break;
		}
	});
	
	// 排序切换
	$(".js-goods-sort").live("click", function () {
		if ($(this).hasClass("cata_curnt")) {
			return;
		}
		
		$(".js-goods-sort").removeClass("cata_curnt");
		$(this).addClass("cata_curnt");
		
		var sort = $(this).data("sort");
		getGoods(sort);
	});
	
	// 产品分页
	$(".js-goods-page a").live("click", function () {
		var page = $(this).data("page-num");
		var sort = $("#product_sort").val();
		
		getGoods(sort, page);
	});
	
	// 简短产品分页
	$(".shortcut_page div").live("click", function () {
		var page = $(this).data("page");
		var sort = $("#product_sort").val();
		
		if (page == "0") {
			return;
		}
		
		getGoods(sort, page);
	})
	
	$(".js-jump-product-page-btn").live("click", function () {
		var page = $(this).closest("form").find(".js-jump-page").val();
		var reg1 =  /^\d+$/;
		if(page.match(reg1) == null) {
			tusi('请用正确填写页码');
			$(this).closest("form").find(".js-jump-page").val('');
			$(this).closest("form").find(".js-jump-page").focus();
			return;
		}
		var sort = $("#product_sort").val();
		getGoods(sort, page);
	});
	
	
	// 分销动态分页
	$(".js-financial-page a").live("click", function () {
		var page = $(this).data("page-num");
		getFinancial(page);
	})
	
	// 分销动态分页
	$(".js-jump-financial-page-btn").live("click", function () {
		var page = $(this).closest("form").find(".js-jump-page").val();
		var reg1 =  /^\d+$/;
		if(page.match(reg1) == null) {
			tusi('请用正确填写页码');
			$(this).closest("form").find(".js-jump-page").val('');
			$(this).closest("form").find(".js-jump-page").focus();
			return;
		}
		
		getFinancial(page);
	});
	
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
			getComment(tab, has_image, 1);
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
		getComment(tab, has_image, 1);
	});
	
	// 评论分页
	$(".page_list a").live("click", function () {
		var tab = $(".tab_title .on").data("tab");
		var has_image = $("#has_image").prop("checked") ? 1: 0;
		var page = $(this).data("page-num");
		getComment(tab, has_image, page);
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
		var has_image = $("#has_image").prop("checked") ? 1: 0;
		var tab = $(".tab_title .on").data("tab");
		getComment(tab, has_image, page);
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
		if (is_login == false) {
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
	
	// 设置上传图片提交表单
	$("#upload_image_form").ajaxForm({
		beforeSubmit: showRequestUpload,
		success: showResponseUpload,
		dataType: 'json'
	});
	
	// 提交评论
	$(".js_save").click(function () {
		var content = $("textarea[name='content']").val();
		var score = $("input[name='manyi']:checked").val();
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
		
		$.post(comment_add, {"id" : store_id, "type" : "STORE", "score" : score, "content" : content, "images_id_str" : images_id_str}, function (data) {
			try {
				if (data.status == true) {
					tusi("评论成功");
					$(".tab_title a").removeClass("on");
					$(".tab_title a").eq(0).addClass("on");
					
					
					$(".tab_title span").eq(0).html(parseInt($(".tab_title span").eq(0).html()) + 1);
					if (score == "5") {
						$(".tab_title span").eq(1).html(parseInt($(".tab_title span").eq(1).html()) + 1);
					} else if (score == "3") {
						$(".tab_title span").eq(2).html(parseInt($(".tab_title span").eq(2).html()) + 1);
					} else {
						$(".tab_title span").eq(3).html(parseInt($(".tab_title span").eq(3).html()) + 1);
					}
					
					$("input[name='manyi']").eq(0).prop("checked", true);
					$("textarea[name='content']").val("");
					$(".shop_pingjia_list li").each(function (i) {
						if (i != li_size - 1) {
							$(this).remove();
						}
					});
					
					getComment("ALL", 0, 1);
				} else {
					showResponse(data);
				}
			} catch(e) {
				tusi("评论失败");
			}
		}, "json");
	});
});

// 获取产品
function getGoods(sort, page) {
	$.get(goods_url, {"store_id" : store_id, "sort" : sort, "page" : page}, function (data) {
		$(".js-content-detail").eq(0).html(data);
		
		var lat_long =  getUserDistance();
		$(".js-store-position").each(function () {
			var long = $(this).data("long");
			var lat = $(this).data("lat");
			if(long && lat_long) {
				var distance = (getFlatternDistance(lat_long.lat, lat_long.long, lat, long) / 1000).toFixed(2);
				
				$(this).find(".content_list_day").html(expressTime(parseFloat(distance)));
				$(this).find(".content_list_add").html("<span></span><em>" + distance + "KM</em>");
			}
		});
	})
}

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
		alert(e.toString())
		return;
	}
}

// 显示上传图片数量
function uploadImageNumber() {
	var number = $(".shop_pingjia_list ul").find("li").size() - 1;
	$(".updat_pic p").html(number + "/10");
}

// 获取评论
function getComment(tab, has_image, page) {
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
	
	$.get(comment_url, {"id" : store_id, "type" : "STORE", "tab" : tab, "has_image" : has_image, "page" : page}, function (data) {
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
			'cyclic'        : false,
			'titleFormat'	: function(title, currentArray, currentIndex, currentOpts) {
				return '<span id="fancybox-title-over">' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
			}
		});
	});
}


// 获取分销动态
function getFinancial(page) {
	if (typeof page == "undefined") {
		page = 1;
	}
	
	var index = 0;
	$(".js-menu li").each(function (i) {
		if ($(this).hasClass("off")) {
			index = i;
			return false;
		}
	});
	
	$(".js-content .js-content-detail").eq(index).html("<div class='fenxiao js-default'>加载中</div>");
	$.get(financial_url, {"page" : page, "store_id" : store_id}, function (data) {
		try {
			$(".js-content .js-content-detail").eq(index).html(data);
		} catch(e) {
			$(".js-content .js-content-detail").eq(index).html("<div class='fenxiao js-default'>网络错误</div>");
		}
	});
}

// 在地图中查看
function viewMap() {
	$(".js-menu li").eq(1).trigger("click");
}