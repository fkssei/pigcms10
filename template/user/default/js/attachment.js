$(function(){
	load_page('.app__content',load_url,{page:'attachment_content'},'');
	var nav_href = '',search_txt = '';
	$('.third-nav a').click(function(){
		var href = $(this).attr('href');
		if(href != 'javascript:;'){
			nav_href = href.substr(1);
			$('.third-nav li').removeClass('active');
			$(this).closest('li').addClass('active');
		}
		switch(href){
			case '#':
			case '#list_image':
			case '#list_upload_image':
			case '#list_import_image':
			case '#list_collect_image':
			case '#list_voice':
			case '#list_upload_voice':
			case '#list_collect_voice':
				search_txt = '';
				load_page('.app__content',load_url,{page:'attachment_content',type:nav_href},'');
				break;
		}
	});
	
	$('.js-upload-image').click(function(){
		upload_pic_box(1,false,function(files){
			// for(var i in files){
				// console.log(files[i]);
			// }
			if(files.length) load_page('.app__content',load_url,{page:'attachment_content'},'');
		});
	});
	$('.js-upload-voice').click(function(){
		upload_voice_box(6,false,function(files){
			for(var i in files){
				console.log(files[i]);
			}
			if(files.length) load_page('.app__content',load_url,{page:'attachment_content'},'');
		});
	});
	
	$('.js-delete').live('click',function(event){
		var tr_dom = $(this).closest('tr');
		var pigcms_id = tr_dom.attr('pigcms-id');
		button_box($(this),event,'left','delete','确定删除？',function(){
			$.post(delete_url,{pigcms_id:pigcms_id},function(result){
				if(result.err_code == 0){
					close_button_box();
					layer_tips(0,'删除成功');
					tr_dom.remove();
				}else{
					layer_tips(1,result.err_msg);
				}
			});
		});
	});
	$('.js-rename').live('click',function(event){
		var pigcms_id = $(this).closest('tr').attr('pigcms-id');
		var content_dom = $(this).closest('tr').find('.tb-title .new_window');
		button_box($(this),event,'left','edit_txt',$.trim(content_dom.html()),function(){
			var new_content = $.trim($('.js-rename-placeholder').val());
			if(new_content == ''){
			}else if($.trim(content_dom.html()) != new_content){
				$.post(edit_name_url,{pigcms_id:pigcms_id,name:new_content},function(result){
					if(result.err_code == 0){
						close_button_box();
						layer_tips(0,'修改成功');
						content_dom.html(new_content);
					}else{
						layer_tips(1,result.err_msg);
					}
				});
			}else{
				close_button_box();
				layer_tips(1,'未做过修改');
			}
		});
	});
	$('.js-copy-link').live('click',function(event){
		var pigcms_id = $(this).closest('tr').attr('pigcms-id');
		var content = $(this).closest('tr').find('.tb-title .new_window').attr('href');
		button_box($(this),event,'left','copy',content,function(){
			layer_tips(0,'复制成功');
		});
	});
	
	$('.js-page-list a').live('click',function(e){
		if(!$(this).hasClass('active')){
			load_page('.app__content',load_url,{page:'attachment_content',type:nav_href,p:$(this).attr('data-page-num'),txt:search_txt},'');
		}
	});
	
	$('#js-check-all').live('click',function(){
		if($(this).data('check') == 1){
			$(this).data('check',0);
			$('.js-check-toggle').prop('checked',false);
		}else{
			$(this).data('check',1);
			$('.js-check-toggle').prop('checked',true);
		}
	});
	
	$('.js-batch-btn').live('click',function(){
		var pigcms_ids = [];
		$.each($('.js-check-toggle'),function(i,item){
			if($(this).prop('checked')){
				pigcms_ids.push($(this).closest('tr').attr('pigcms-id'));
			}
		});
		$.post(del_more_url,{pigcms_id:pigcms_ids},function(result){
			if(result.err_code == 0){
				load_page('.app__content',load_url,{page:'attachment_content',type:nav_href,p:$('.js-page-list .active').attr('data-page-num')},'');
			}else{
				layer_tips(1,result.err_msg);
			}
		});
	});
	
	$('.js-list-search .txt').keydown(function(event){
		if(event.keyCode == 13){
			$(this).val($.trim($(this).val()));
			if($(this).val().length != 0){
				search_txt = $(this).val();
				load_page('.app__content',load_url,{page:'attachment_content',type:nav_href,txt:search_txt},'');
			}
		}
	});
});