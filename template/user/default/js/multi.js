$(function(){
	$('.app-add-field').show();
	var ueditor = UE.getEditor('content', {
		toolbars: [["bold", "italic", "underline", "strikethrough", "forecolor", "backcolor", "justifyleft", "justifycenter", "justifyright", "|", "insertunorderedlist", "insertorderedlist", "blockquote"], ["emotion", "simpleupload", "link", "removeformat", "|", "rowspacingtop", "rowspacingbottom", "lineheight", "paragraph", "fontsize"], ["inserttable", "deletetable", "insertparagraphbeforetable", "insertrow", "deleterow", "insertcol", "deletecol", "mergecells", "mergeright", "mergedown", "splittocells", "splittorows", "splittocols"]],
		autoClearinitialContent: false,
		autoFloatEnabled: true,
		wordCount: true,
		elementPathEnabled: false,
		maximumWords: 4000,
		initialFrameWidth: 418,
		initialFrameHeight: 240
	});
	ueditor.ready(function(){
		ueditor.setContent(contents[0].content);
	});

	$("#title").val(contents[0].title);
	$("#author").val(contents[0].author);
	$("#image").val(contents[0].cover_pic);
	$("#digest").val(contents[0].digest);
	$("#url").val(contents[0].url);
	$("#url_title").val(contents[0].url_title);
	change_html(contents[0].url_title, contents[0].url);
	if (contents[0].cover_pic != '') {
		$('.js-add-image-one').before('<img src="' + contents[0].cover_pic +'" width="100" height="100">');
	} else {
		$('.js-add-image-one').prev('img').remove();
	}
	if (contents[0].is_show) {
		$('#show_image').attr('checked', true);
	} else {
		$('#show_image').attr('checked', false);
	}
	
	$('.js-add-region').live('click', function(){
		var len = $(".ui-sortable").find(".app-field").length;
		if (len < 10) {
			var title = $('#title').val();
			var author = $('#author').val();
			var image = $('#image').val();
			var digest = $('#digest').val();
			var content = ueditor.getContent();
			var url = $("#url").val();
			var url_title = $("#url_title").val();
			var id = $(".app-field").eq(last_index).attr('data-id');
			var is_show = 0;
			if ($('#show_image').attr('checked')) {
				is_show = 1;
			}
			
			var last_index = $("#index").val();
			contents[last_index] = {'id':id, 'title':title, 'author':author, 'digest':digest , 'cover_pic':image, 'content':content, 'is_show':is_show, 'url':url, 'url_title':url_title};
			
			var html = '<div class="app-field clearfix editing"  data-id="0">';
			html += '<div class="appmsg appmsg-multiple-others">';
			html += '<h4 class="appmsg-title">标题</h4>';
			html += '<div class="appmsg-thumb-wrap"><p>缩略图</p></div></div>';
			html += '<div class="actions">';
			html += '<div class="actions-wrap">';
			html += '<span class="action edit">编辑</span>';
			html += '<span class="action delete">删除</span>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			$('.ui-sortable').append(html);
			$("#index").val(len);
			var top = 82;
			top += 171 + 61 * (len -1);
			$(".app-sidebar").css('margin-top', top + 'px');

			$("#title").val('');
			$("#author").val('');
			$("#digest").val('');
			$('.js-add-image-one').prev('img').remove();
			$("#image").val('');
			$("#url").val('');
			$("#url_title").val('');
			ueditor.setContent('');
			change_html('', '');
			$('#show_image').attr('checked', false);
		} else {
			golbal_tips("最多十个", 1);
		}
		
	});
	
	
	//删除
	$('.delete').live('click', function(event){
		var obj = $(this);
		var len = $(".ui-sortable").find(".app-field").length;
		if (len < 3) {
			golbal_tips("至少有两条图文信息!", 1);
			return false;
		}
		var now_index = parseInt($(".delete").index(this)) + 1;
		
		button_box($(this), event, 'left', 'confirm', '确定删除?', function(){
			var title = $('#title').val();
			var author = $('#author').val();
			var image = $('#image').val();
			var digest = $('#digest').val();
			var content = ueditor.getContent();
			var url = $("#url").val();
			var url_title = $("#url_title").val();
			var is_show = 0;
			if ($('#show_image').attr('checked')) {
				is_show = 1;
			}
			
			var last_index = $("#index").val();
			var id = $(".app-field").eq(last_index).attr('data-id');
			
			contents[last_index] = {'id':id, 'title':title, 'author':author, 'digest':digest , 'cover_pic':image, 'content':content, 'is_show':is_show, 'url':url, 'url_title':url_title};
			var k = 0;
			var tmp = new Array();
			for (var i = 0; i < contents.length; i ++) {
				if (i != now_index) {
					tmp[k] = contents[i];
					k ++;
				}
			}
			contents = tmp;
			if (last_index >= now_index) {
				if (contents[last_index - 1] != undefined) {
					$("#title").val(contents[last_index - 1].title);
					$("#author").val(contents[last_index - 1].author);
					$("#image").val(contents[last_index - 1].cover_pic);
					$("#digest").val(contents[last_index - 1].digest);
					$('.js-add-image-one').prev('img').remove();
					if (contents[last_index - 1].cover_pic != '') {
						$('.js-add-image-one').before('<img src="' + contents[last_index - 1].cover_pic +'" width="100" height="100">');
					}
					if (contents[last_index - 1].is_show) {
						$('#show_image').attr('checked', true);
					} else {
						$('#show_image').attr('checked', false);
					}
					$("#url").val(contents[last_index - 1].url);
					$("#url_title").val(contents[last_index - 1].url_title);
					ueditor.setContent(contents[last_index - 1].content);
					change_html(contents[last_index - 1].url_title, contents[last_index - 1].url);
				} else {
					$("#title").val('');
					$("#author").val('');
					$("#digest").val('');
					$('.js-add-image-one').prev('img').remove();
					$("#image").val('');
					$('#show_image').attr('checked', false);
					$("#url").val('');
					$("#url_title").val('');
					ueditor.setContent('');
					change_html('', '');
				}
				$("#index").val(last_index - 1);
				var top = 82 + 171 + 61 * (last_index - 2);
				$(".app-sidebar").css('margin-top', top + 'px');
			}
			obj.parents('.app-field').remove();//append(html);
			close_button_box();
		});
		
	});	
	
	//切换文图
	$('.app-field').live('click', function(e){
		
		if ($(e.target).attr('class') == 'action delete'){
			return false;
		}
		
		var now_index = $(".app-field").index(this);

		var last_index = $("#index").val();
		
		var title = $('#title').val();
		var author = $('#author').val();
		var image = $('#image').val();
		var digest = $('#digest').val();
		var content = ueditor.getContent();
		var url = $("#url").val();
		var url_title = $("#url_title").val();
		var id = $(".app-field").eq(last_index).attr('data-id');
		var is_show = 0;
		if ($('#show_image').attr('checked')) {
			is_show = 1;
		}
		contents[last_index] = {'id':id, 'title':title, 'author':author, 'digest':digest , 'cover_pic':image, 'content':content, 'is_show':is_show, 'url':url, 'url_title':url_title};
		
		$("#index").val(now_index);
		if (contents[now_index] != undefined) {
			$("#title").val(contents[now_index].title);
			$("#author").val(contents[now_index].author);
			$("#image").val(contents[now_index].cover_pic);
			$("#digest").val(contents[now_index].digest);
			if (contents[now_index].is_show) {
				$('#show_image').attr('checked', true);
			} else {
				$('#show_image').attr('checked', false);
			}
			$('.js-add-image-one').prev('img').remove();
			if (contents[now_index].cover_pic != '') {
				$('.js-add-image-one').before('<img src="' + contents[now_index].cover_pic +'" width="100" height="100">');
			}
			$("#url").val(contents[now_index].url);
			$("#url_title").val(contents[now_index].url_title);
			ueditor.setContent(contents[now_index].content);
			change_html(contents[now_index].url_title, contents[now_index].url);
		} else {
			$('#show_image').attr('checked', false);
			$("#title").val('');
			$("#author").val('');
			$("#digest").val('');
			$('.js-add-image-one').prev('img').remove();
			$("#image").val('');
			$("#url").val('');
			$("#url_title").val('');
			ueditor.setContent('');
			change_html('', '');
		}
		var top = 82;
		if (now_index < 2) {
			top += now_index * 171
		} else {
			top += 171 + 61 * (now_index - 1);
		}
		$(".app-sidebar").css('margin-top', top + 'px');
		
	});
	
	//同步到左边显示的内容
	$('input, textarea').keyup(function(){
		$('.appmsg-' + $(this).attr('name')).eq($("#index").val()).html($(this).val());
	});
	
	//add iamge
	$('.js-add-image-one').live('click',function(){
		var obj = $(this);
		upload_pic_box(1,true,function(pic_list){
			obj.prev('img').remove();
			for(pic in pic_list) {
				obj.before('<img src="' + pic_list[pic] +'" width="100" height="100">&nbsp;&nbsp;');
				$('#image').val(pic_list[pic]);
				$('.appmsg-thumb-wrap').eq($("#index").val()).html('<img src="' + pic_list[pic] +'"/>');
				break;
			}
			obj.html('重新选择');
		},1);
	});
	
	$('.btn-add').click(function(){
		var thisobj = $(this);
		$(this).attr('disabled', true).val($(this).attr('data-loading-text'));
		var title = $('#title').val();
		var author = $('#author').val();
		var image = $('#image').val();
		var digest = $('#digest').val();
		var content = ueditor.getContent();
		var url = $("#url").val();
		var url_title = $("#url_title").val();
		var is_show = 0;
		if ($('#show_image').attr('checked')) {
			is_show = 1;
		}
		
		var last_index = $("#index").val();
		var id = $(".app-field").eq(last_index).attr('data-id');
		
		contents[last_index] = {'id':id, 'title':title, 'author':author, 'digest':digest , 'cover_pic':image, 'content':content, 'is_show':is_show, 'url':url, 'url_title':url_title};
		
		var flag = false;
		var now_index = 0;
		for (var i in contents) {
			if (contents[i].title.length < 1) {
				flag = true;
				$('#title').parent('.control-group').addClass('error');
				$('#title').after('<p class="help-block error-message">标题不能为空</p>');
			}
			if (contents[i].cover_pic.length < 1) {
				flag = true;
				$('.js-image-region').addClass('error').append('<p class="help-block error-message">必须选择一张图片</p>');
			}
			if (contents[i].content.length < 1) {
				flag = true;
				$('#text-content').addClass('error').append('<p class="help-block error-message">正文不能为空</p>');
			}
			if (flag) {
				now_index = i;
				break;
			}
		}
		
		if (flag) {
			$("#title").val(contents[now_index].title);
			$("#author").val(contents[now_index].author);
			$("#image").val(contents[now_index].cover_pic);
			$("#digest").val(contents[now_index].digest);
			$("#url").val(contents[now_index].url);
			$("#url_title").val(contents[now_index].url_title);
			change_html(contents[now_index].url_title, contents[now_index].url);
			if (contents[now_index].is_show) {
				$('#show_image').attr('checked', true);
			} else {
				$('#show_image').attr('checked', false);
			}
			$('.js-add-image-one').prev('img').remove();
			if (contents[now_index].cover_pic != '') {
				$('.js-add-image-one').before('<img src="' + contents[now_index].cover_pic +'" width="100" height="100">');
			}
			$('#index').val(now_index);
			
			var top = 82;
			if (now_index < 2) {
				top += now_index * 171
			} else {
				top += 171 + 61 * (now_index - 1);
			}
			$(".app-sidebar").css('margin-top', top + 'px');
			
			thisobj.attr('disabled', false).val('上架');
			return false;
		}
		
		$.post('/user.php?c=weixin&a=save_multi_image_text',{'data':JSON.stringify(contents), 'pigcms_id':$('#pigcms_id').val()}, function(data){
			thisobj.attr('disabled', false).val('上架');
			if (data.error_code) {
				if (data.index != -1) {
					var now_index = data.index;
					$("#title").val(contents[now_index].title);
					$("#author").val(contents[now_index].author);
					$("#image").val(contents[now_index].cover_pic);
					$("#digest").val(contents[now_index].digest);
					$("#url").val(contents[now_index].url);
					$("#url_title").val(contents[now_index].url_title);
					change_html(contents[now_index].url_title, contents[now_index].url);
					if (contents[now_index].is_show) {
						$('#show_image').attr('checked', true);
					} else {
						$('#show_image').attr('checked', false);
					}
					$('.js-add-image-one').prev('img').remove();
					if (contents[now_index].cover_pic != '') {
						$('.js-add-image-one').before('<img src="' + contents[now_index].cover_pic +'" width="100" height="100">');
					}
					$('#index').val(now_index);
					
					var top = 82;
					if (now_index < 2) {
						top += now_index * 171
					} else {
						top += 171 + 61 * (now_index - 1);
					}
					$(".app-sidebar").css('margin-top', top + 'px');
				} else {
					golbal_tips(data.msg);
				}
			} else {
				location.href='/user.php?c=weixin&a=index';
			}
		},'json');
	});



	link_box($('.js-dropdown-toggle'),[],function(type,prefix,title,href){
		$('.js-dropdown-toggle').siblings('.js-link-to').remove();
		$('.js-dropdown-toggle').before('<div class="left js-link-to link-to"><a href="'+href+'" target="_blank" class="new-window link-to-title"><span class="label label-success">'+prefix+(prefix == title ? '' :' <em class="link-to-title-text">'+title+'</em>')+'</span></a></div>');
		$('.js-dropdown-toggle').addClass('right').attr('class','dropdown-toggle js-dropdown-toggle').html('修改 <i class="caret"></i>');
		$('#url').val(href);
		$('#url_title').val(title);
	});
});

function change_html(title, url){
	$('.js-dropdown-toggle').siblings('.js-link-to').remove();
	if (title != '' && title != undefined){
		$('.js-dropdown-toggle').before('<div class="left js-link-to link-to"><a href="'+url+'" target="_blank" class="new-window link-to-title"><span class="label label-success">'+title+'</span></a></div>');
		$('.js-dropdown-toggle').addClass('right').attr('class','dropdown-toggle js-dropdown-toggle').html('修改 <i class="caret"></i>');
	}else{
		$('.js-dropdown-toggle').html('设置链接到的页面地址 <i class="caret"></i>');
	}
}