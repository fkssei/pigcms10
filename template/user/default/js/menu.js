$(function(){
	parent_sort();
	child_sort();
	var ueditor = UE.getEditor('js-editor', {
		toolbars: [["link", 'emotion']],
		autoClearinitialContent: false,
		autoFloatEnabled: true,
		wordCount: false,
		elementPathEnabled: false,
		initialFrameWidth: 296,
		initialFrameHeight: 120
	});
	//增加一级菜单
	$('.js-add-first').live('click', function(){
		var obj = $(this);
		if ($('.js-first-nav-fields').find('.js-first-field').length >= 3) {
			golbal_tips('最多只能添加3个一级菜单', 1);
			return false;
		}
		$.post('/user.php?c=weixin&a=save_menu',{'pid':0, 'title':'标题'}, function(data){
			golbal_tips(data.msg, data.error);
			if (data.error == 0) {
				var menu_html = '';
				menu_html += '<div class="nav-field js-first-field" data-id="'+data.data+'">';
				menu_html += '<div class="close-modal js-del-first">×</div>';
				menu_html += '<div class="field-wrap clearfix js-field-wrap">';
				menu_html += '<div class="menu-titles">';
				menu_html += '<div class="h4">一级菜单：</div>';
				menu_html += '<ul class="first-nav-field">';
				menu_html += '<li class="js-first-field-li js-menu-li clearfix  active " data-id="'+data.data+'" id="title_'+data.data+'">';
				menu_html += '<span class="h5">标题</span>';
				menu_html += '<span class="opts">';
				menu_html += '<a href="javascript:void(0);" class="js-edit-first" data-title="标题">编辑</a>';
				menu_html += '</span>';
				menu_html += '</li>';
				menu_html += '</ul>';
				menu_html += '<div class="h4">二级菜单：</div>';
				menu_html += '<ul class="sec-nav-field ui-sortable"></ul>';
				menu_html += '<div class="add-second-nav">';
				menu_html += '<a href="javascript:void(0);" class="js-add-second">+ 添加二级菜单</a>';
				menu_html += '</div>';
				menu_html += '</div>';
				menu_html += '<div class="menu-main">';
				menu_html += '<div class="menu-content" style="min-height:80px">';
				menu_html += '<div class="link-to js-link-to " data-id="'+data.data+'" data-type="0" id="content_'+data.data+'"></div>';
				menu_html += '</div>';
				menu_html += '<div class="select-link js-select-link " data-id="'+data.data+'">';
				menu_html += '<span class="change-txt">回复内容：</span>';
				menu_html += '<span class="main-link">';
				menu_html += '<a class="js-modal-txt" data-type="txt" href="javascript:void(0);">一般信息</a> -';
				menu_html += '<a class="js-modal-news" data-type="news" href="javascript:void(0);">图文素材</a> -';
				menu_html += '<a class="js-modal-magazine" data-type="feature" href="javascript:void(0);">微页面</a> -';
				menu_html += '<a class="js-modal-goods" data-type="goods" href="javascript:void(0);">商品</a> -';
				menu_html += '</span>';
				menu_html += '<div class="opts dropdown hover">';
				menu_html += '<span class="dropdown-toggle" style="cursor:pointer;color:#434343">其他<i class="caret"></i></span>';
				menu_html += '<ul class="dropdown-menu">';
		//		menu_html += '<li>';
		//		menu_html += '<a class="js-modal-activity" data-type="activity" href="javascript:void(0);">活动</a>';
		//		menu_html += '</li>';
				menu_html += '<li>';
				menu_html += '<a class="js-modal-homepage" data-type="homepage" data-alias="店铺主页" data-title="" data-url="'+home_url+'" data-id="" href="javascript:void(0);">店铺主页</a>';
				menu_html += '</li>';
				menu_html += '<li>';
				menu_html += '<a class="js-modal-usercenter" data-type="usercenter" data-alias="会员主页" data-title="" data-url="'+member_url+'" data-id="" href="javascript:void(0);">会员主页</a>';
				menu_html += '</li>';
		//		menu_html += '<li>';
		//		menu_html += '<a class="js-modal-search" data-type="search" href="javascript:void(0);">搜索</a>';
		//		menu_html += '</li>';
		//		menu_html += '<li>';
		//		menu_html += '<a class="js-modal-checkin" data-type="checkin" href="javascript:void(0);">签到</a>';
		//		menu_html += '</li>';
		//		menu_html += '<li>';
		//		menu_html += '<a class="js-modal-survey" data-type="survey" href="javascript:void(0);">投票调查</a>';
		//		menu_html += '</li>';
				menu_html += '<li>';
				menu_html += '<a class="js-modal-links" data-type="link" href="javascript:void(0);">自定义外链</a>';
				menu_html += '</li>';
				menu_html += '</ul>';
				menu_html += '</div>';
				menu_html += '<div class="editor-image js-editor-image"></div>';
				menu_html += '<div class="hide editor-place js-editor-place"></div>';
				menu_html += '</div>';
				menu_html += '</div>';
				menu_html += '</div>';
				menu_html += '</div>';
				
				$('.add-first-nav').before(menu_html);
				if (obj.parent('.add-first-nav').attr('class') == 'add-first-nav no-data') {
					obj.parent('.add-first-nav').removeClass('no-data').html('<a href="javascript:void(0);" class="js-add-first">+ 添加一级菜单</a>');
				}
					
				
				var mhtml = '<div class="divide">&nbsp;</div>';
				mhtml += '<div class="one" data-id="1">';
				mhtml += '<a class="mainmenu js-mainmenu" href="javascript:void(0);">';
				mhtml += '<span class="mainmenu-txt" id="menu_'+data.data+'">标题</span>';
				mhtml += '</a>';
				mhtml += '</div>';
				$('.nav-menu').append(mhtml);
				if ($('.nav-menu').find('.one').length == 1) {
					$('.nav-menu').removeClass('has-menu-2').removeClass('has-menu-3').addClass('has-menu-1');
				} else if ($('.nav-menu').find('.one').length == 2) {
					$('.nav-menu').removeClass('has-menu-1').removeClass('has-menu-3').addClass('has-menu-2');
				} else if ($('.nav-menu').find('.one').length == 3) {
					$('.nav-menu').removeClass('has-menu-2').removeClass('has-menu-1').addClass('has-menu-3');
				}
			}
			parent_sort();
		}, 'json');
	});
	//主菜单的移入移出显示效果
	$('.js-first-field').live('mousemove', function(){
		$(this).addClass('hover');
		$(this).find('.js-del-first').show();
	}).live('mouseout', function(){
		$(this).removeClass('hover');
		$(this).find('.js-del-first').hide();
	});
	//主菜单的删除
	$('.js-del-first').live('click', function(e){
		var id = parseInt($(this).parent('.js-first-field').attr('data-id')), obj = $(this);
		button_box($(this),e,'left','confirm','确定删除?',function(){
			$.post('/user.php?c=weixin&a=delete_menu',{'id':id}, function(data){
				golbal_tips(data.msg, data.error);
				if (data.error == 0) {
					var index = obj.parents('.js-first-field').index('.js-first-nav-fields .js-first-field');
					obj.parent('.js-first-field').remove();
					//删除左边的对应菜单
					$('.nav-menu .one').eq(index).remove();
					$('.nav-menu .divide').eq(index).remove();
					
					if ($('.nav-menu').find('.one').length == 1) {
						$('.nav-menu').removeClass('has-menu-2').removeClass('has-menu-3').addClass('has-menu-1');
					} else if ($('.nav-menu').find('.one').length == 2) {
						$('.nav-menu').removeClass('has-menu-1').removeClass('has-menu-3').addClass('has-menu-2');
					} else if ($('.nav-menu').find('.one').length == 3) {
						$('.nav-menu').removeClass('has-menu-2').removeClass('has-menu-1').addClass('has-menu-3');
					}
				}
				$('.popover').remove();
			}, 'json');
		});
		$('.popover').show();
	});
	//添加二级菜单
	$('.js-add-second').live('click', function(){
		var obj = $(this);
		var len = $(this).parents('.menu-titles').find('.sec-nav-field .js-second-field').length + 1;
		if (len >= 6) {
			golbal_tips('最多只能添加5个二级菜单', 1);
			return false;
		}
		var pid = $(this).parents('.js-first-field').attr('data-id');
		$.post('/user.php?c=weixin&a=save_menu',{'pid':pid, 'title':'标题'}, function(data){
			golbal_tips(data.msg, data.error);
			if (data.error == 0) {
				obj.parents('.menu-titles').find('li').removeClass('active');
				var html = '';
				html += '<li class="js-second-field js-menu-li clearfix active" data-id="'+data.data+'" id="title_'+data.data+'">';
				html += '<span class="h5">'+len+'. 标题</span>';
				html += '<span class="opts">';
				html += '<a href="javascript:void(0);" class="js-edit-second" data-title="标题">编辑</a> -';
				html += '<a href="javascript:void(0);" class="js-del-second">删除</a>';
				html += '</span>';
				html += '</li>';
				obj.parents('.menu-titles').find('.sec-nav-field').append(html);
				obj.parents('.js-field-wrap').find('.js-link-to').addClass('hide');
				obj.parents('.js-field-wrap').find('.menu-content').css('min-height', 80 + (len * 38)).append('<div class="link-to js-link-to" data-id="'+data.data+'" id="content_'+data.data+'"></div>');
				
				var index = obj.parents('.js-first-field').index('.js-first-nav-fields .js-first-field');
				if ($('.nav-menu .one .js-mainmenu').eq(index).children().is('.arrow-weixin')) {
					$('.nav-menu .one .js-submenu').eq(index).find('ul').append('<li class="line-divide"></li><li><a class="js-submneu-a" data-id="'+data.data+'" id="menu_'+data.data+'">标题</a></li>');
				} else {
					$('.nav-menu .one .js-mainmenu').eq(index).prepend('<i class="arrow-weixin"></i>');
					$('.nav-menu .one .js-mainmenu').eq(index).after('<div class="submenu js-submenu"><span class="arrow before-arrow"></span><span class="arrow after-arrow"></span><ul><li id="menu_'+data.data+'"><a class="js-submneu-a" data-id="'+data.data+'" id="menu_'+data.data+'">标题</a></li></ul>');
				}
				obj.parents('.js-field-wrap').find('.js-select-link').attr('data-id', data.data);
				child_sort();
			}
		}, 'json');
	});
	
	//删除二级菜单
	$('.js-del-second').live('click', function(e){
		var id = parseInt($(this).parents('.js-second-field').attr('data-id')), obj = $(this), parent_obj = $(this).parents('.sec-nav-field');
		button_box($(this),e,'left','confirm','确定删除?',function(){
			$.post('/user.php?c=weixin&a=delete_menu',{'id':id}, function(data){
				golbal_tips(data.msg, data.error);
				if (data.error == 0) {
					$('.app__content').load('/user.php?c=weixin&a=menu_load&t='+Math.random(),function(){parent_sort();child_sort();});
					$('.popover').remove();
					return false;
				}
				$('.popover').remove();
			}, 'json');
		});
		$('.popover').show();
		
	});
	
	//切换子菜单
	$('.js-menu-li').live('click', function(){
		$(this).parents('.menu-titles').find('li').removeClass('active');
		$(this).addClass('active');
		$(this).parents('.js-field-wrap').find('.js-select-link').attr('data-id', $(this).attr('data-id'));
		var index = $(this).parents('.sec-nav-field').find('.js-second-field').index(this);
		if (index == -1 && $(this).parents('.menu-titles').find('.js-second-field').length > 0) {
			if (!($(this).parents('.menu-titles').find('.js-link-to').eq(0).children().hasClass('died-link-to'))) {
				$('#content_' + $(this).attr('data-id')).html('<span class="died-link-to" data-content="">使用二级菜单后主回复已失效。</span>');
			}
			$(this).parents('.js-field-wrap').find('.js-select-link').addClass('hide');
		} else {
			$(this).parents('.js-field-wrap').find('.js-select-link').removeClass('hide');
		}
		$(this).parents('.js-field-wrap').find('.js-link-to').addClass('hide');
		$(this).parents('.js-field-wrap').find('.js-link-to').eq(index + 1).removeClass('hide');
	});
	
	$('.js-mainmenu').live('click', function(){
		$('.js-submenu').hide();
		$(this).next('.js-submenu').show();
	});
	
	
	$('.js-edit-second').live('click', function(e){
		var obj = $(this);
		var pigcms_id = parseInt($(this).parents('.js-second-field').attr('data-id'));
		button_box($(this),e,'left','edit_txt',$(this).attr('data-title'),function(){
			var title = $('.js-rename-placeholder').val();
			$.post('/user.php?c=weixin&a=save_menu',{'id':pigcms_id, 'title':title}, function(data){
				golbal_tips(data.msg, data.error);
				if (data.error == 0) {
					var html = obj.parents('.js-second-field').find('.h5').text().split('.');
					obj.parents('.js-second-field').find('.h5').html(html[0] + '.' + title);
					if (obj.attr('class') == 'js-edit-first') {
						$('#menu_' + pigcms_id).text(title);
					} else {
						$('#menu_' + pigcms_id).html('<a class="js-submneu-a" data-id="' + pigcms_id + '" href="#" target="_blank">' + title + '</a>');
					}
				}
				$('.popover').remove();
			}, 'json');
		});
		$('.popover').show();
	});
	
	$('.js-edit-first').live('click', function(e){
		var obj = $(this);
		var pigcms_id = parseInt($(this).parents('.js-first-field-li').attr('data-id'));
		button_box($(this),e,'left','edit_txt',$(this).attr('data-title'),function(){
			var title = $('.js-rename-placeholder').val();
			$.post('/user.php?c=weixin&a=save_menu',{'id':pigcms_id, 'title':title}, function(data){
				golbal_tips(data.msg, data.error);
				if (data.error == 0) {
					$('#title_' + pigcms_id).find('.h5').text(title);
					$('#menu_' + pigcms_id).text(title);
				}
				$('.popover').remove();
			}, 'json');
		});
		$('.popover').show();
	});
	
	$('.js-select-link a').live('click', function(e){
		$('#data_id').val($(this).parents('.js-select-link').attr('data-id'));
		if ($(this).attr('class') == 'js-modal-txt') {
			var id = $(this).parents('.js-select-link').attr('data-id');
			var type = $('#content_' + id).attr('data-type');
			if (type == 0) {
				ueditor.setContent($('#content_' + id).text());
			} else {
				ueditor.setContent('');
			}
			$('.js-editor-place').hide();
			$('.js-editor-wrap').css('top', $(this).offset().top +25).show();
			$(this).parents('.js-select-link').find('.js-editor-place').show();
			
		} else if ($(this).attr('class') == 'js-modal-news') {
			wentu_list(1);
		} else if ($(this).attr('class') == 'js-modal-magazine') {
			url_list(1, 'feature');
		} else if ($(this).attr('class') == 'js-modal-goods') {
			url_list(1, 'goods');
		} else if ($(this).attr('class') == 'js-modal-links') {
			button_box($(this).parents('.dropdown'),e,'bottom','edit_txt','链接地址：http://example.com',function(){
				var url = $('.js-rename-placeholder').val();
				if (url.match("http://") == null) {
					url = 'http://' + $('.js-rename-placeholder').val();
				}
				$.post('/user.php?c=weixin&a=save_menu_content',{'id':$('#data_id').val(), 'content':'[外链]' + url, 'url':url, 'fromid':0, 'type':0}, function(data){
					golbal_tips(data.msg, data.error);
					if (data.error == 0) {
						var html = '<a href="'+url+'" target="_blank" class="new-window">[外链]' + url+'</a>';
						$('#content_' + $('#data_id').val()).html(html).attr('data-type', 9);
					}
					$('.popover').remove();
				}, 'json');
			});
			$('.popover').show();
		} else {
			rich_text('['+$(this).attr('data-alias')+']'+$(this).attr('data-title'), $(this).attr('data-url'), $(this).attr('data-type'), parseInt($(this).attr('data-id')));
		}
	}); 
	
	//保存
	$('.js-btn-save').live('click',function(){
		rich_text(ueditor.getContent(), '', 'txt', parseInt($('#data_id').val()));
		$('.js-editor-place, .js-editor-wrap').hide();
	});
	//取消
	$('.js-btn-close').live('click',function(){
		$('.js-editor-place, .js-editor-wrap').hide();
	});
	$('.js-open-articles').live('click', function(){
		wentu_list(1);
	});
	
	//选择图文或商品等 TODO
	$('.js-choose').live('click', function(){
		var title = '';
		if ($(this).attr('data-alias') == '') {
			title = $(this).attr('data-title');
		} else {
			title = '['+$(this).attr('data-alias')+']'+$(this).attr('data-title');
		}
		rich_text(title, $(this).attr('data-url'), $(this).attr('data-type'), parseInt($(this).attr('data-id')));
	});
	
	$('.js-modal-tab').live('click', function(){
		url_list(1, $(this).attr('data-type'));
	});
	$('.js-news-modal-dismiss').live('click', function(){
		$(this).parents('.js-modal').remove();
		$('.modal-backdrop').remove();
	});

	
	$('.js-submit').live('click', function(){
		var obj = $(this);
		obj.val(obj.attr('data-loading-text')).attr('disabled', true);
		$.get('/user.php?c=weixin&a=class_send', function(data){
			golbal_tips(data.errmsg, data.errcode);
			obj.val('提交修改').attr('disabled', false);
		}, 'json');
	});
	
	$(".dropdown-toggle").live("click", function () {
		$(this).closest("div").find(".dropdown-menu").show();
	});
	
	$(".dropdown-menu a").live("click", function () {
		$(this).closest("ul").hide();
	});
});

function parent_sort()
{
	$('.js-first-nav-fields').sortable({handle:'.js-first-field-li'}).on('sortupdate', function() {
		var new_order = [], pid = 0;
		$(".js-first-nav-fields .js-first-field").each(function() {
			pid = $(this).attr('data-id');
			var child = [];
			$(this).find('.sec-nav-field .js-second-field').each(function(){
				child.push($(this).attr('data-id'));
			});
			var t = {};
			t[pid] = child;
			new_order.push(t);
		});
		$.post('/user.php?c=weixin&a=chgorder', {"new_id":JSON.stringify(new_order)}, function(response){
			golbal_tips(response.msg, response.error);
			if (response.error == 0) {
				$('.app__content').load('/user.php?c=weixin&a=menu_load&t='+Math.random(),function(){parent_sort();child_sort();});
			}
		}, 'json');
	}); 
	return false;
}

function child_sort()
{
	$(".sec-nav-field").sortable({connectWith: ".sec-nav-field"}).disableSelection(); 
}

function rich_text(title, url, type, sid)
{
	//type [0:文本，1：图文，2：音乐，3：商品，4：商品分类，5：微页面，6：微页面分类，7：店铺主页，8：会员主页]
	var typeval = 0;
	if (type == 'wentu') {
		typeval = 1;
	} else if (type == 'goods') {
		typeval = 3;
	} else if (type == 'tag') {
		typeval = 4;
	} else if (type == 'feature') {
		typeval = 5;
	} else if (type == 'category') {
		typeval = 6;
	} else if (type == 'homepage') {
		typeval = 7;
	} else if (type == 'usercenter') {
		typeval = 8;
	}
	$.post('/user.php?c=weixin&a=save_menu_content',{'id':$('#data_id').val(), 'content':title, 'url':url, 'fromid':sid, 'type':typeval}, function(data){
		golbal_tips(data.msg, data.error);
		if (data.error == 0) {
			var html = '';
			if (typeval == 0) {
				html += data.content;
			} else if (typeval == 1) {
				var wentu_array = title.split('|');
				
				if (wentu_array.length > 1) {
					html += '<div class="ng ng-multiple">';
					for(index in wentu_array) {
						var t = wentu_array[index].split('#');
						html += '<div class="ng-item">';
						html += '<span class="label label-success">图文'+parseInt(index+1)+'</span> ';
						html += '<div class="ng-title">';
						html += '<a href="' + info_url + t[0] + '" class="new_window" target="_blank"> '+t[1]+'</a>';
						html += '</div>';
						html += '</div>';
					}
					html += '</div>';
				} else {
					var t = title.split('#');
					html += '<div class="ng ng-single">';
					html += '<div class="ng-item">';
					html += '<div class="ng-title">';
					html += '<a href="' + info_url + t[0] + '" target="_blank" class="new-window">'+t[1]+'</a>';
					html += '</div>';
					html += '</div>';
					html += '<div class="ng-item view-more">';
					html += '<a href="' + info_url + t[0] + '" target="_blank" class="clearfix new-window">';
					html += '<span class="pull-left">阅读全文</span>';
					html += '<span class="pull-right">&gt;</span>';
					html += '</a>';
					html += '</div>';
					html += '</div>';
				}
			} else {
				html += '<a href="'+url+'" target="_blank" class="new-window">'+title+'</a>';
			}
			$('#content_' + $('#data_id').val()).html(html).attr('data-type', typeval);
			$('.js-news-modal-dismiss').parents('.js-modal').remove();
			$('.modal-backdrop').css('display', 'none');
		}
	}, 'json');

	
}
function wentu_list(p)
{
	$.post('/user.php?c=weixin&a=get_wentu', {'p':p}, function(response){
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
					title += pre + response.data[thisid].list[imageid].pigcms_id + '#' + response.data[thisid].list[imageid].title;
					pre = '|';
					html += '<div class="ng-item">';
					if (response.data[thisid].list.length > 1) {
						html += '<span class="label label-success">图文' + i + '</span>';
					} else {
						html += '<span class="label label-success">图文</span>';
					}
					html += '<div class="ng-title">';
					html += '<a href="" class="new_window" title="' + response.data[thisid].list[imageid].title + '">　' + response.data[thisid].list[imageid].title + '</a>';
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
				html += '<button class="btn js-choose" href="#" data-id="' + response.data[thisid].pigcms_id + '" data-url="" data-type="wentu" data-title="' + title + '" data-alias="">选取</button>';
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
//商品（与分类），微页面（分类）
function url_list(p, type)
{
	//type [feature, category, goods, tag]
	$.post('/user.php?c=weixin&a=get_url_list', {'p':p, 'type':type}, function(response){
		$('.js-news-modal-dismiss').parents('.js-modal').remove();
		$('.modal-backdrop').remove();
		var html = '<div class="modal fade js-modal in" aria-hidden="false">';
			html += '<div class="modal-header">';
			html += '<a class="close js-news-modal-dismiss" data-dismiss="modal" data-type="' + type +'">×</a>';
			html += '<ul class="module-nav modal-tab">';
			if (type == 'feature' || type == 'category') {
				if (type == 'feature') {
					html += '<li class="active"><a href="#js-module-feature" data-type="feature" class="js-modal-tab">微页面</a> | </li>';
					html += '<li><a href="#js-module-category" data-type="category" class="js-modal-tab">微页面分类</a></li>';
				} else {
					html += '<li><a href="#js-module-feature" data-type="feature" class="js-modal-tab">微页面</a> | </li>';
					html += '<li class="active"><a href="#js-module-category" data-type="category" class="js-modal-tab">微页面分类</a></li>';
				}
			} else {
				if (type == 'goods') {
					html += '<li class="active"><a href="#js-module-goods" data-type="goods" class="js-modal-tab">已上架商品</a> | </li>';
					html += '<li><a href="#js-module-tag" data-type="tag" class="js-modal-tab">商品分组</a></li>';
				} else {
					html += '<li><a href="#js-module-goods" data-type="goods" class="js-modal-tab">已上架商品</a> | </li>';
					html += '<li class="active"><a href="#js-module-tag" data-type="tag" class="js-modal-tab">商品分组</a></li>';
				}
			}
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
			html += '<span>标题</span> <a class="js-update" href="javascript:void(0);" onclick="url_list(' + p +', \'' + type +'\')">刷新</a>';
			html += '</div>';
			html += '</th>';
			html += '<th class="time">';
			html += '<div class="td-cont">';
			html += '<span>创建时间</span>';
			html += '</div>';
			html += '</th>';
			html += '<th class="opts">';
			html += '</th>';
			html += '</tr>';
			html += '</thead>';
			html += '<tbody>';
			for (var thisid in response.page_list) {
				html += '<tr>';
				html += '<td class="title">';
				html += '<div class="td-cont">';
				html += '<a target="_blank" class="new_window" href="'+response.page_list[thisid].url+'">'+response.page_list[thisid].page_name+'</a>';
				html += '</div>';
				html += '</td>';
				
				html += '<td class="time">';
				html += '<div class="td-cont">';
				html += '<span>'+response.page_list[thisid].add_time+'</span>';
				html += '</div>';
				html += '</td>';
				
				html += '<td class="opts">';
				html += '<div class="td-cont">';
				if (type == 'feature') {
					html += '<button class="btn js-choose" href="#" data-id="" data-url="'+response.page_list[thisid].url+'" data-type="' + type + '" data-title="'+response.page_list[thisid].page_name+ '" data-alias="微页面">选取</button>';
				} else if (type == 'category') {
					html += '<button class="btn js-choose" href="#" data-id="" data-url="'+response.page_list[thisid].url+'" data-type="' + type + '" data-title="'+response.page_list[thisid].page_name+ '" data-alias="微页面分类">选取</button>';
				} else if (type == 'goods') {
					html += '<button class="btn js-choose" href="#" data-id="" data-url="'+response.page_list[thisid].url+'" data-type="' + type + '" data-title="'+response.page_list[thisid].page_name+ '" data-alias="商品">选取</button>';
				} else {
					html += '<button class="btn js-choose" href="#" data-id="" data-url="'+response.page_list[thisid].url+'" data-type="' + type + '" data-title="'+response.page_list[thisid].page_name+ '" data-alias="商品分类">选取</button>';
				}
				
				html += '</div>';
				html += '</td>';
				html += '</tr>';
			}
			html += '</tbody>';
			html += '</table>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '<div class="modal-footer">';
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