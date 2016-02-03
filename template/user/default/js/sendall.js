$(function(){
	var ueditor = UE.getEditor('editor', {
		toolbars: [["link", 'emotion']],
		autoClearinitialContent: false,
		autoFloatEnabled: true,
		wordCount: false,
		elementPathEnabled: false,
		initialFrameWidth: 296,
		initialFrameHeight: 320
	});
	
	$('.msg_multiple_nav a').on('click', function(){
		var type = $(this).attr('data-type');
		$(this).parent('li').addClass('active').siblings().removeClass('active');
		if (type == 'text') {
			$('#J_type').val(0);
			$('#editor').show();
			$('.msgSenderPlugin').show();
			$('.kdt_news_preview_wrap, .no_mab').remove();
		} else if(type == 'image'){
			$('#J_type').val(1);
			var obj = $(this);
			upload_pic_box(1,true,function(pic_list){
				$('#editor').hide();
				$('.msgSenderPlugin').css({'min-height':'250px'}).show();
				$('.kdt_news_preview_wrap, .no_mab').remove();
				var html = '';
				for(pic in pic_list) {
					html += '<li class="choosed_item" data-attachment-id="" title="0.jpg">';
					html += '<div class="kdt_pic_wrapper">';
					html += '<a class="kdt_pic" href="' + pic_list[pic] +'" target="_blank">';
					html += '<img src="' + pic_list[pic] +'" alt="" data-src="' + pic_list[pic] +'" data-size=""></a>';
					html += '</div>';
					html += '<input type="hidden" name="attachment_id" value="" class="for-post"/>';
					html += '<div class="kdt_images_opts"> <a href="javascript:;" class="delete">×</a> </div>';
					html += '</li>';
					
					$('#J_img_container').html(html);
					$('#J_image').val(pic_list[pic]);
					break;
				}
			},1);
		} else if (type == 'pic') {
			$('#J_type').val(2);
			wentu_list(1, 0);
		} else if (type == 'pics') {
			$('#J_type').val(3);
			wentu_list(1, 1);
		}
	});
	$('.selector').live('click', function(){
		var type = $(this).attr('data-type');
		if (type == 'pic') {
			$('#J_type').val(2);
			wentu_list(1, 0);
		} else if (type == 'pics') {
			$('#J_type').val(3);
			wentu_list(1, 1);
		}
	});
	$('.delete').live('click', function(){
		if ($(this).parents('.choosed_item').attr('class') != undefined) {
			$(this).parents('.choosed_item').remove();
		} else {
			$(this).parents('.kdt_news_preview_wrap').remove();
		}
		
	});
	$('.js-news-modal-dismiss').live('click', function(){
		$(this).parents('.js-modal').remove();
		$('.modal-backdrop').remove();
	});

	$('.js-choose_btn').live('click', function(){
		$('#editor').hide();
		$('.msgSenderPlugin').hide();
		$('.kdt_news_preview_wrap, .no_mab').remove();
		$.get('/user.php?c=weixin&a=fetch_wentu', {'pigcms_id':parseInt($(this).attr('data-id'))}, function(response){
			if (response.error) {
				golbal_tips(response.msg, response.error);
			} else {
				$('#J_source_id').val(response.pigcms_id);
				var html = '';
				if (response.type == 0) {
					
					html += '<div class="control-group no_mab">';
					html += '<div class="controls">';
					html += '<a data-toggle-text="选取图文素材..." class="selector" data-toggle="modal" href="#J_news_modal" data-type="pic">选取图文素材...</a><span>&nbsp;|&nbsp;</span>';
					html += '<a href="/user.php?c=weixin&a=one">+新建单条图文</a>';
					html += '</div>';
					html += '</div>';
					
					html += '<div class="kdt_news_preview_wrap">';
					html += '<div id="kdt_news_preview">';
					html += '<div id="kdt_news_create" class="clearfix kdt_single_message">';
					html += '<div class="kdt_module">';
					html += '<div class="pre_container pre_new_0">';
					html += '<div id="kdt_preview" class="ip_preview" style="padding-left: 0px;min-height: 0;">';
					html += '<div class="kdt_images_opts">';
					html += '<a href="javascript:void(0);" class="delete">×</a>';
					html += '</div>';
					html += '<div class="pre_inner">';
					html += '<a href="'+response.data.info_url+'" target="_blank" class="pre_link">';
					html += '<p class="ip5_height_guide">首屏线</p>';
					html += '<div class="pre_header">';
					html += '<h4>'+response.data.title+'</h4>';
					html += '<p class="meta">'+response.data.date+'</p>';
					html += '</div>';
					html += '<div class="pre_ad">';
					html += '<div class="pic">';
					html += '<img src="'+response.data.cover_pic+'" style="margin-left: 0px; margin-top: -62.4358974358974px; width: 268px; height: 274.871794871795px; display: inline;">';
					html += '</div>';
					html += '</div>';
					html += '<div class="pre_footer">';
					html += '<div class="pre_content_ubb">'+response.data.digest+'</div>';
					html += '</div>';
					html += '<div class="view_full clearfix">';
					html += '<span>阅读全文</span>';
					html += '<span class="pull-right">&gt;</span>';
					html += '</div>';
					html += '</a>';
					html += '</div>';
					html += '</div>';
					html += '</div>';
					html += '</div>';
					html += '</div>';
					html += '</div>';
					html += '<a class="btn-edit hide" href="/user.php?c=weixin&a=one&pigcms_id='+response.pigcms_id+'" style="display: inline;">编辑</a>';
					html += '</div>';
				} else {
					html += '<div class="control-group no_mab">';
					html += '<div class="controls">';
					html += '<a data-toggle-text="选取图文素材..." class="selector" data-toggle="modal" href="#J_news_modal" data-type="pics">选取图文素材...</a><span>&nbsp;|&nbsp;</span>';
					html += '<a href="/user.php?c=weixin&a=multi">+新建多条图文</a>';
					html += '</div>';
					html += '</div>';
					
					html += '<div class="kdt_news_preview_wrap">';
					html += '<div id="kdt_news_preview">';
					html += '<div id="kdt_news_create" class="clearfix kdt_multi_message ">';
					html += '<div class="kdt_module">';
					html += '<div class="pre_container pre_new_0">';
					html += '<div id="kdt_preview" class="ip_preview" style="padding-left: 0px;min-height: 0;">';
					html += '<div class="kdt_images_opts">';
					html += '<a href="javascript:void(0);" class="delete">×</a>';
					html += '</div>';
					html += '<div class="pre_inner">';
					$.each(response.data, function(i, data) {
						if (i == 0) {
							html += '<a href="'+data.info_url+'" target="_blank" class="pre_link">';
							html += '<div class="pre_new pre_wrap_1">';
							html += '<div class="pre_header">';
							html += '<h4>'+data.title+'</h4>';
							html += '</div>';
							html += '<div class="pre_ad">';
							html += '<div class="pic">';
							html += '<img src="'+data.cover_pic+'" style="margin-left: 0px; margin-top: -62.4358974358974px; width: 268px; height: 274.871794871795px; display: inline;">';
							html += '</div>';
							html += '</div>';
							html += '</div>';
							html += '</a>';
						} else {
							html += '<a href="'+data.info_url+'" target="_blank" class="pre_link">';
							html += '<div class="pre_new pre_list">';
							html += '<div class="pre_header">';
							html += '<h4 style="padding-right: 70px;">'+data.title+'</h4>';
							html += '</div>';
							html += '<div class="pre_ad">';
							html += '<div class="pic">';
							html += '<img src="'+data.cover_pic+'" style="width: 50px; height: 50px;">';
							html += '</div>';
							html += '</div>';
							html += '</div>';
							html += '</a>';	
						}
					});
					html += '</div>';
					html += '</div>';
					html += '</div>';
					html += '</div>';
					html += '</div>';
					html += '</div>';
					html += '<a class="btn-edit hide" href="/user.php?c=weixin&a=multi&pigcms_id='+response.pigcms_id+'" style="display: inline;">编辑</a>';
					html += '</div>';
				}
				$('#J_form_messages_link').append(html);
			}
		}, 'json');
		
		$('.js-news-modal-dismiss').parents('.js-modal').remove();
		$('.modal-backdrop').css('display', 'none');
	});
	
	
	$('.btn-success').on('click', function(){
		var type = parseInt($('#J_type').val()), source_id = parseInt($('#J_source_id').val()), image = $('#J_image').val(), content = '', obj = $(this);
		if (type == 0) {
			content = ueditor.getContent();
		}
		obj.val(obj.attr('data-loading-text')).attr('disabled', true);
		$.post('/user.php?c=weixin&a=send', {'type':type, 'source_id':source_id, 'image':image, 'content':content}, function(data){
			golbal_tips(data.errmsg, data.errcode);
			obj.text('直接群发').attr('disabled', false);
		}, 'json');
	});
	
});


function wentu_list(p, type)
{
	$.post('/user.php?c=weixin&a=get_wentu', {'p':p, 'type':type}, function(response){
		$('.js-news-modal-dismiss').parents('.js-modal').remove();
		$('.modal-backdrop').remove();
		var html = '<div class="modal fade js-modal in" aria-hidden="false">';
			html += '<div class="modal-header">';
			html += '<a class="close js-news-modal-dismiss" data-dismiss="modal">×</a>';
			html += '<ul class="module-nav modal-tab">';
//			html += '<li class=""><a href="#js-module-news" data-type="news" class="js-modal-tab">高级图文</a> | </li>';
			html += '<li class="active"><a href="#js-module-mpNews" data-type="mpNews" class="js-modal-tab">微信图文</a> | </li>';
			html += '<li class="link-group link-group-1" style="display: inline-block;"><a href="/user.php?c=weixin&a=index" target="_blank" class="new_window">微信图文素材管理</a></li>';
			html += '</ul>';
			html += '</div>';
			html += '<div class="modal-body">';
			html += '<div class="tab-content">';
			
			html += '<div id="js-module-mpNews" class="tab-pane module-mpNews active">';
			html += '<table class="table">';
			html += '<colgroup>';
			html += '<col class="modal-col-title">';
			html += '<col class="modal-col-time" span="2">';
			html += '<col class="modal-col-action">';
			html += '</colgroup>';
			html += '<thead>';
			html += '<tr>';
			html += '<th class="title">';
			html += '<div class="td-cont">';
			html += '<span>标题</span> <a class="js-update" href="javascript:void(0);">刷新</a>';
			html += '</div>';
			html += '</th>';
			html += '<th class="time">';
			html += '<div class="td-cont">';
			html += '<span>创建时间</span>';
			html += '</div>';
			html += '</th>';
			html += '<th class="opts">';
//			html += '<div class="td-cont">';
//			html += '<form class="form-search">';
//			html += '<div class="input-append">';
//			html += '<input class="input-small js-modal-search-input" type="text"><a href="javascript:void(0);" class="btn js-fetch-page js-modal-search" data-action-type="search">搜</a>';
//			html += '</div>';
//			html += '</form>';
//			html += '</div>';
			html += '</th>';
			html += '</tr>';
			html += '</thead>';
			html += '<tbody>';
			for (var thisid in response.data) {
				html += '<tr>';
				html += '<td class="title">';
				html += '<div class="td-cont">';
				html += '<div class="ng ng-multiple">';
				var i = 0;
				var title = '', pre = '';
				for (var imageid in response.data[thisid].list) {
					i ++;
					title += pre + response.data[thisid].list[imageid].title;
					pre = '|';
					html += '<div class="ng-item">';
					if (response.data[thisid].list.length > 1) {
						html += '<span class="label label-success">图文' + i + '</span>';
					} else {
						html += '<span class="label label-success">图文</span>';
					}
					html += '<div class="ng-title">';
					html += '<a href="' + response.data[thisid].list[imageid].info_url + '" class="new_window" title="' + response.data[thisid].list[imageid].title + '">　' + response.data[thisid].list[imageid].title + '</a>';
					html += '</div>';
					html += '</div>';
				}

				html += '</div>';
				html += '</div>';
				html += '</td>';
				
				html += '<td class="time">';
				html += '<div class="td-cont">';
				html += '<span>'+response.data[thisid].dateline+'</span>';
				html += '</div>';
				html += '</td>';
				
				html += '<td class="opts">';
				html += '<div class="td-cont">';
				html += '<button class="btn js-choose_btn" href="#" data-id="' + response.data[thisid].pigcms_id + '" data-url="" data-type="wentu" data-title="' + title + '" data-alias="">选取</button>';
				html += '</div>';
				html += '</td>';
				
				html += '</tr>';
			}

			
			html += '</tbody>';
			html += '</table>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '<div class="modal-footer wentu">';
			html += '<div style="display: none;" class="js-confirm-choose pull-left">';
			html += '<input type="button" class="btn btn-primary" value="确定使用">';
			html += '</div>';
			html += '<div class="pagenavi">';
			html += '<span class="total">'+response.page+'</span>';
			html += '</div>';
			html += '</div>';
			html += '</div><div class="modal-backdrop fade in"></div>';
			$('body').append(html);
		}, 'json');
}