$(function(){
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
		ueditor.setContent(content);
	});

	$('input, textarea').keyup(function(){
		$('.appmsg-' + $(this).attr('name')).html($(this).val());
	});
	
	$('.js-add-image-one').live('click',function(){
		var obj = $(this);
		upload_pic_box(1,true,function(pic_list){
			obj.prev('img').remove();
			for(pic in pic_list) {
				obj.before('<img src="' + pic_list[pic] +'" width="100" height="100"/>&nbsp;&nbsp;');
				$('#image').val(pic_list[pic]);
				$('.appmsg-thumb-wrap').html('<img src="' + pic_list[pic] +'"/>');
				break;
			}
			obj.html('重新选择');
		},1);
	});
	
	$('.btn-add').click(function(){
		$(this).attr('disabled', true).val($(this).attr('data-loading-text'));
		var is_show = 0;
		if ($('#show_image').attr('checked')) {
			is_show = 1;
		}
		
		var data = {
				'content':ueditor.getContent(),
				'title':$('#title').val(),
				'author':$('#author').val(),
				'cover_pic':$('#image').val(),
				'is_show':is_show,
				'digest':$('#digest').val(),
				'pigcms_id':$('#pigcms_id').val(),
				'thisid':$('#thisid').val(),
				'url':$('#url').val(),
				'url_title':$('#url_title').val()
		}
		if (data.title.length <1) {
			golbal_tips('标题不能为空', 1);
			$(this).attr('disabled', false).val('上架');
			return;
		}
		if (data.cover_pic.length <1) {
			golbal_tips('必须得有封面图', 1);
			$(this).attr('disabled', false).val('上架');
			return;
		}
		if (data.content.length <1) {
			golbal_tips('内容不能为空', 1);
			$(this).attr('disabled', false).val('上架');
			return;
		}
		$.post('./user.php?c=weixin&a=save_image_text',data, function(data){
			$('.btn-add').attr('disabled', false).val('上架');
			if (data.error_code) {
				golbal_tips(data.msg, 1);
			} else {
				location.href='./user.php?c=weixin&a=index';
			}
		},'json');
	});
	
	link_box($('.js-dropdown-toggle'),[],function(type,prefix,title,href){
		$('.js-dropdown-toggle').siblings('.js-link-to').remove();
		var beforeDom = $('<div class="left js-link-to link-to"><a href="'+href+'" target="_blank" class="new-window link-to-title"><span class="label label-success">'+prefix+(prefix == title ? '' :' <em class="link-to-title-text">'+title+'</em>')+'</span></a></div>');
		$('.js-dropdown-toggle').before(beforeDom);
		$('.js-dropdown-toggle').addClass('right').attr('class','dropdown-toggle js-dropdown-toggle').html('修改 <i class="caret"></i>');
		$('#url').val(href);
		$('#url_title').val(title);
	});
});