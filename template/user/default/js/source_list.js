$(function(){
	load_page('.app__content', load_url, '', '');
	$('.fetch_page').live('click', function(){
		$('.app__content').load(load_url, {'p': parseInt($(this).attr('data-page-num'))}, function(){});
	});
	
	$('.js-delete').live('click', function(event){
		var obj = $(this);
		var pigcms_id = parseInt($(this).attr('data-id'));
		button_box($(this),event,'left','confirm','确定删除?',function(){
			$.get('/user.php?c=weixin&a=delete_source_material', {'pigcms_id':pigcms_id}, function(data){
				close_button_box();
				golbal_tips(data.msg, data.error_code);
				if (data.error_code) {
				} else {
					obj.parents('tr').hide();
				}
			}, 'json');
		});
	});
	$('.js-create-template').live('click', function(){
		var html = '<div class="popover bottom left-bottom"><div class="popover-inner popover-image-text"><div class="popover-content"><ul class="clearfix"><li class="single-image-text"><a href="./user.php?c=weixin&a=one"><p>单条图文</p><div class="image-text-color-block"></div></a></li><li class="multi-image-text"><a href="./user.php?c=weixin&a=multi"><p>多条图文</p><div class="image-text-color-block"></div><div class="image-text-color-block"></div></a></li></ul></div></div></div>';
		
		var top = $(this).offset().top + $(this).height();
		var left = $(this).offset().left;
		$('body').append(html);
		$('.popover').css({'display':'block', 'top':top+'px', 'left':left+'px'});
	});

	$('body').bind('click',function(){
		close_button_box();
	});
});