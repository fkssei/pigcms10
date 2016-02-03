/**
 * Created by pigcms_21 on 2015/2/6.
 */
var keyword = '';
$(function(){
	location_page(location.hash);
	$('a').live('click',function(){
		if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#') location_page($(this).attr('href'),$(this));
	});
	
	function location_page(mark,dom){
		var mark_arr = mark.split('/');
		switch(mark_arr[0]){
			case '#create':
			alert(load_url);
				load_page('.app__content', load_url,{page:'wei_page_category_create'}, '',function(){page_create(1);});
				break;
			case "#edit":
				if(mark_arr[1]){
					load_page('.app__content', load_url,{page:'wei_page_category_edit',cat_id:mark_arr[1]},'',function(){
						var editDataDom = $('#edit_data');
						defaultFieldObj = $('.js-config-region .app-field');
						defaultFieldObj.data({'cat_id':editDataDom.attr('cat-id'),'cat_name':editDataDom.attr('cat-name'),'first_sort':editDataDom.attr('first-sort'),'second_sort':editDataDom.attr('second-sort')});
						defaultFieldObj.find('.custom-richtext').data('has_amend','1').html($('#edit_data').html());
						$('.js-config-region h1 span,.js-config-region .custom-title .title').html(editDataDom.attr('cat-name'));
						
						page_create(0);
						customField.setHtml($('#edit_custom').attr('custom-field'));
						
						editDataDom.remove();
						$('#edit_custom').remove();
					});
				}else{
					layer.alert('非法访问！');
					location.hash = '#list';
					location_page('');
				}
				break;
			default:
				load_page('.app__content', load_url,{page:'cate_mould'}, '');
		}
	}
	
	function page_create(emptyData){
		var defaultDesc = '此处显示分类简介';
		defaultFieldObj = $('.js-config-region .app-field');
		if(emptyData == 1) defaultFieldObj.data({'cat_id':'0','cat_name':'','first_sort':'0','second_sort':'0'});
		defaultFieldObj.click(function(){
			$('.app-entry .app-field').removeClass('editing');
			$(this).addClass('editing');
			$('.js-sidebar-region').html(defaultHtmlObj());
			$('.app-sidebar').css('margin-top',$(this).offset().top - $('.js-app-main').offset().top);
			
			//分类名
			$('.js-meta-region input[name="title"]').val(defaultFieldObj.data('cat_name')).live('blur',function(){
				var val = $(this).val();
				if(val.length == 0 || val.length > 50){
					layer_tips(1,'分类名不能少于一个字或者多余50个字');
				}
				var customTitleObj = $('.js-config-region .custom-title .title');
				if(val.length == 0){
					defaultFieldObj.data('cat_name','');
					customTitleObj.html('微页面分类名');
					$('.js-config-region h1 span').empty();
				}else{
					defaultFieldObj.data('cat_name',val);
					customTitleObj.html(val);
					$('.js-config-region h1 span').html(val);
				}
			});
			//第一优先级
			$('.js-sidebar-region select[name="first_sort"]').change(function(){
				defaultFieldObj.data('first_sort',$(this).val());
			}).find('option[value="'+defaultFieldObj.data('first_sort')+'"]').prop('selected',true);
			//第二优先级
			$('.js-sidebar-region select[name="second_sort"]').change(function(){
				defaultFieldObj.data('second_sort',$(this).val());
			}).find('option[value="'+defaultFieldObj.data('second_sort')+'"]').prop('selected',true);
			
			var domHtml = defaultFieldObj.find('.custom-richtext');
			
			var ueditor = new window.UE.ui.Editor({
				toolbars: [["bold", "italic", "underline", "strikethrough", "forecolor", "backcolor", "justifyleft", "justifycenter", "justifyright", "|", "insertunorderedlist", "insertorderedlist", "blockquote"], ["emotion", "uploadimage", "insertvideo", "link", "removeformat", "|", "rowspacingtop", "rowspacingbottom", "lineheight", "paragraph", "fontsize"], ["inserttable", "deletetable", "insertparagraphbeforetable", "insertrow", "deleterow", "insertcol", "deletecol", "mergecells", "mergeright", "mergedown", "splittocells", "splittorows", "splittocols"]],
				autoClearinitialContent: false,
				autoFloatEnabled: true,
				wordCount: true,
				elementPathEnabled: false,
				maximumWords: 10000,
				initialFrameWidth: 458,
				initialFrameHeight: 108,
				focus: false
			});
			ueditor.addListener("blur",function(){
				var ue_con = ueditor.getContent();
				if(ue_con != ''){
					domHtml.data('has_amend','1').html(ue_con);		
				}else{
					domHtml.data('has_amend','0').html(defaultDesc);
				}
			});
			ueditor.addListener("contentChange",function(){
				var ue_con = ueditor.getContent();
				if(ue_con != ''){
					domHtml.data('has_amend','1').html(ue_con);
				}else{
					domHtml.data('has_amend','0').html(defaultDesc);
				}
			});
			ueditor.render($('.js-editor')[0]);
			ueditor.ready(function(){
				if(domHtml.data('has_amend') == 1){
					ueditor.setContent(domHtml.html());
				}
			});
		});
		defaultFieldObj.trigger('click');
		customField.init();
		
		$('.form-actions .btn-save').live('click',function(){
			var post_data = {};
			post_data.cat_id 	  = defaultFieldObj.data('cat_id');
			post_data.cat_name 	  = defaultFieldObj.data('cat_name');
			if(post_data.cat_name.length == 0 || post_data.cat_name.length > 50){
				layer_tips(1,'分类名不能少于一个字或者多余50个字');
				defaultFieldObj.trigger('click');
				return false;
			}
			
			post_data.first_sort  = defaultFieldObj.data('first_sort');
			post_data.second_sort = defaultFieldObj.data('second_sort');
			post_data.cat_desc    = defaultFieldObj.find('.custom-richtext').html();
			if(post_data.cat_desc == defaultDesc){
				post_data.cat_desc = '';
			}
			post_data.custom      = customField.checkEvent();
			var cat_post_url = defaultFieldObj.data('cat_id') == '0' ? add_url : edit_url;
			$.post(cat_post_url,post_data,function(result){
				if(result.err_code == 0){
					layer_tips(0,result.err_msg);
					if(defaultFieldObj.data('cat_id') == '0'){
						location.hash = '#list';
					}
					location.reload();
				}else{
					layer_tips(1,result.err_msg);
				}
			});
		});
	}
	
	var defaultHtmlObj = function(){
		return '<div><div class="form-horizontal"><div class="js-meta-region" style="margin-bottom: 20px;"><div><div class="control-group"><label class="control-label"><em class="required">*</em>分类名：</label><div class="controls"><input type="text" name="title" value=""></div></div><div class="control-group"><label class="control-label">第一优先级：</label><div class="controls"><select name="first_sort"><option value="0">序号越大越靠前</option><option value="1">最热的排在前面</option></select></div></div><div class="control-group"><label class="control-label">第二优先级：</label><div class="controls"><select name="second_sort"><option value="0">创建时间越晚越靠前</option><option value="1">创建时间越早越靠前</option><option value="2">最热的排在前面</option></select></div></div><!--div class="control-group"><label class="control-label">显示方式：</label><div class="controls"><label class="radio inline"><input type="radio" name="show_method" value="0" checked=""/>仅显示杂志列表</label><label class="radio inline"><input type="radio" name="show_method" value="1"/>用期刊方式展示</label/></div--></div></div></div><div class="control-group"><hr/><div class="separate-line"><p class="text-center">微页面分类简介</p><p class="text-center">v</p></div></div><div class="control-group"><div name="content"><script class="js-editor" type="text/plain"></script></div></div></div></div>';
	};
	
	$('.js-app-main .js-delete').live('click',function(e){
		var dom = $(this);
		button_box(dom,e,'left','confirm','确定删除?',function(){
			$.post(delete_url,{cat_id:dom.closest('tr').attr('cat-id')},function(result){
				if(result.err_code == 0){
                    close_button_box();
					layer_tips(0,result.err_msg);
                    load_page('.app__content', load_url,{page:'wei_page_category_content'}, '');
				}else{
					layer.alert(result.err_msg,0);
				}
			});
		});
	});
	$('.js-app-main .js-copy-link').live('click',function(e){
		button_box($(this),e,'left','copy',wap_cat_url+'?id='+$(this).closest('tr').attr('cat-id'),function(){
			layer_tips(0,'复制成功');
		});
	});
	
	$('.js-page-list a').live('click',function(e){
		if(!$(this).hasClass('active')){
            keyword = $('.ui-search-box :input').val().trim();
			load_page('.app__content', load_url,{page:'wei_page_category_content', 'keyword': keyword, p:$(this).attr('data-page-num')}, '', function() {
                $('.ui-search-box :input').val(keyword);
            });
		}
	});
	
    //搜索框动画
    $('.ui-search-box :input').live('focus', function(){
        $(this).animate({width: '180px'}, 100);
    })
    $('.ui-search-box :input').live('blur', function(){
        $(this).animate({width: '70px'}, 100);
    })

    //回车提交搜索
    $(window).keydown(function(event){
        if (event.keyCode == 13 && $('.ui-search-box .txt').is(':focus')) {
            keyword = $('.ui-search-box :input').val().trim();
            load_page('.app__content', load_url,{page:'wei_page_category_content', 'keyword': keyword}, '', function() {
                $('.ui-search-box :input').val(keyword);
            });
        }
    })
})