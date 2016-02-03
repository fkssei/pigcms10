$(function () {
	$("textarea[name='content']").bind("keyup blur", function () {
		var word_count = $(this).val().length;
		if (word_count > 300) {
			$(this).val($(this).val().substr(0, 300));
			word_count = 300;
		}
		
		$(".js-word-number").html(word_count + "/" + 300);
	});
	
	$("#upload_image").change(function () {
		if ($(".shop_pingjia_list ul").find("li").size() == 11) {
			motify.log("最多只能上传10张图片");
			$(this).val('');
			return false;
		}
		var file = $(this).val();
		if (file.length == 0) {
			return;
		}
		
		if(!/.(gif|jpg|jpeg|png)$/.test(file)) {
			motify.log("图片类型必须是gif,jpeg,jpg,png中的一种");
			return;
		} else {
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
		var id = $("input[name='id']").val();
		var type = $("input[name='type']").val();
		var tag_id_str = "";
		var content = $("textarea[name='content']").val();
		var score = $("input[name='manyi']:checked").val();
		
		if (content.length == 0) {
			$("textarea[name='content']").focus();
			motify.log("请填写评论内容");
			return;
		}
		
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
		
		$.post("comment_add.php", {"id" : id, "type" : type, "score" : score, "content" : content, "images_id_str" : images_id_str, "tag_id_str" : tag_id_str}, function (data) {
			try {
				if (data.status == true) {
					motify.log("评论成功");
					if (type == "PRODUCT") {
						location.href = "good.php?id=" + id + "&platform=1";
					} else {
						location.href = "home.php?id=" + id;
					}
				} else {
					motify.log(data.msg);
				}
			} catch(e) {
				motify.log("评论失败");
			}
		}, "json");
	});
})

function showRequestUpload() {
	return true;
}

function showResponseUpload(data) {
	
	try {
		if (data.err_code == "0") {
			var html_upload = '<li data-attachment_id="' + data.err_msg.id + '"><img src="' + data.err_msg.file + '" /><span></span></li>';
			var form_li_html = $(".shop_pingjia_list ul").last("li").html();
			$(".shop_pingjia_list ul li").eq(-1).before(html_upload);
			
			$(".upload_image").val("");
			uploadImageNumber();
		} else if (data.err_code == "1000") {
			
		} else if (data.err_code == "1002") {
			motify.log("上传失败");
		}
		
	} catch (e) {
		motify.log("上传失败");
		return;
	}
}

function uploadImageNumber() {
	var number = $(".shop_pingjia_list ul").find("li").size() - 1;
	$(".updat_pic p").html(number + "/10");
}