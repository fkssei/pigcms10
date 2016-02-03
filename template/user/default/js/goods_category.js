/**
 * Created by pigcms_21 on 2015/2/6.
 */
$(function(){
	location_page(location.hash);
	$('a').live('click',function(){
		if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#') location_page($(this).attr('href'),$(this));
	});
	
	function location_page(mark,dom){
		var mark_arr = mark.split('/');
		switch(mark_arr[0]){
			case '#create':
				load_page('.app__content', load_url,{page:'category_create'}, '',function(){page_create(1);});
				break;
			case "#edit":
				if(mark_arr[1]){
					load_page('.app__content', load_url,{page:'category_edit',group_id:mark_arr[1]},'',function(){
						var editDataDom = $('#edit_data');
						defaultFieldObj = $('.js-config-region .app-field');
						defaultFieldObj.data({'cat_id':editDataDom.attr('cat-id'),'cat_name':editDataDom.attr('cat-name'),'show_tag_title':editDataDom.attr('show-tag-title'),'first_sort':editDataDom.attr('first-sort'),'second_sort':editDataDom.attr('second-sort'),'size':editDataDom.attr('size'),'size_type':editDataDom.attr('size-type'),'buy_btn':editDataDom.attr('buy-btn'),'buy_btn_type':editDataDom.attr('buy-btn-type'),'show_title':editDataDom.attr('show-title'),'price':editDataDom.attr('price')});

						$('.js-config-region h1 span').html(editDataDom.attr('cat-name'));
						
						if(defaultFieldObj.data('show_tag_title') == '1'){
							$('.js-config-region .custom-title .group-title').html(editDataDom.attr('cat-name'));
						}else{
							$('.js-config-region .custom-title .group-title').closest('.control-group').remove();
						}
						if($('#edit_data').html() != ''){
							if(defaultFieldObj.data('show_tag_title') == '1'){
								defaultFieldObj.find('.custom-title').closest('.control-group').after('<div class="control-group"><div class="custom-richtext">'+$('#edit_data').html()+'</div></div>');
							}else{
								defaultFieldObj.find('.page-title').after('<div class="control-group"><div class="custom-richtext">'+$('#edit_data').html()+'</div></div>');
							}
						}
						
						page_create(0);
						customField.setHtml($('#edit_custom').attr('custom-field'));
						
						// editDataDom.remove();
						// $('#edit_custom').remove();
					});
				}else{
					layer.alert('非法访问！');
					location.hash = '#list';
					location_page('');
				}
				break;
			default:
				load_page('.app__content', load_url,{page:'category_content'}, '');
		}
	}
	
	function page_create(emptyData){
		defaultFieldObj = $('.js-config-region .app-field');
		if(emptyData == 1) defaultFieldObj.data({'cat_id':'0','cat_name':'','show_tag_title':'1','first_sort':'0','second_sort':'0','size':'2','size_type':'0','buy_btn':'1','buy_btn_type':'1','show_title':'0','price':'1'});
		defaultFieldObj.click(function(){
			$('.app-entry .app-field').removeClass('editing');
			$(this).addClass('editing');
			$('.js-sidebar-region').html(defaultHtmlObj());
			$('.app-sidebar').css('margin-top',$(this).offset().top - $('.js-app-main').offset().top);
			
			//分类名
			$('.js-sidebar-region input[name="group_title"]').val(defaultFieldObj.data('cat_name')).live('blur',function(){
				var val = $(this).val();
				if(val.length == 0 || val.length > 50){
					layer_tips(1,'分组名称不能少于一个字或者多余50个字');
				}
				var customTitleObj = $('.js-config-region .custom-title .group-title');
				if(val.length == 0){
					defaultFieldObj.data('cat_name','');
					customTitleObj.html('商品分组');
					$('.js-config-region h1 span').html('商品分组');
				}else{
					defaultFieldObj.data('cat_name',val);
					customTitleObj.html(val);
					$('.js-config-region h1 span').html(val);
				}
			});
			
			//显示商品分组名称
			$('.js-sidebar-region input[name="show_tag_title"]').change(function(){
				if($(this).prop('checked')){
					defaultFieldObj.data('show_tag_title','1');
					$('.js-config-region h1').after('<div class="control-group"><div class="custom-title text-left"><h2 class="group-title">'+(defaultFieldObj.data('cat_name') ? defaultFieldObj.data('cat_name') : '商品分组')+'</h2></div></div>');
				}else{
					$('.js-config-region h1').next('div').remove();
					defaultFieldObj.data('show_tag_title','0');
				}
				
			}).prop('checked',(defaultFieldObj.data('show_tag_title') == '1' ? true : false));
			
			//第一优先级
			$('.js-sidebar-region select[name="first_sort"]').change(function(){
				defaultFieldObj.data('first_sort',$(this).val());
			}).find('option[value="'+defaultFieldObj.data('first_sort')+'"]').prop('selected',true);
			
			//第二优先级
			$('.js-sidebar-region select[name="second_sort"]').change(function(){
				defaultFieldObj.data('second_sort',$(this).val());
			}).find('option[value="'+defaultFieldObj.data('second_sort')+'"]').prop('selected',true);
			
			//列表样式
			$('.js-sidebar-region input[name="size"]').change(function(){
				defaultFieldObj.data('size',$(this).val());
				switch($(this).val()){
					case '0':
						$(this).closest('.control-group').next().replaceWith('<div class="control-group"><div class="controls"><div class="controls-card"><div class="controls-card-tab"><label class="radio inline"><input type="radio" name="size_type" value="0"/>卡片样式</label><label class="radio inline"><input type="radio" name="size_type" value="2"/>极简样式</label></div><div class="controls-card-item"><div><label class="checkbox inline"><input type="checkbox" name="buy_btn" value="1" />显示购买按钮</label></div><div style="margin:10px 0 0 20px;"><label class="radio inline"><input type="radio" name="buy_btn_type" value="1" />样式1</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="2"/>样式2</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="3"/>样式3</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="4"/>样式4</label></div></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="show_title" value="1"/>显示商品名</label></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="price" value="1"/>显示价格</label></div></div></div></div>');
						if(defaultFieldObj.data('size_type') != '0' && defaultFieldObj.data('size_type') != '2'){
							defaultFieldObj.data('size_type','0');
						}
						break;
					case '1':
						$(this).closest('.control-group').next().replaceWith('<div class="control-group"><div class="controls"><div class="controls-card"><div class="controls-card-tab"><label class="radio inline"><input type="radio" name="size_type" value="0"/>卡片样式</label><label class="radio inline"><input type="radio" name="size_type" value="1"/>瀑布流</label><label class="radio inline"><input type="radio" name="size_type" value="2"/>极简样式</label></div><div class="controls-card-item"><div><label class="checkbox inline"><input type="checkbox" name="buy_btn" value="1" />显示购买按钮</label></div><div style="margin:10px 0 0 20px;"><label class="radio inline"><input type="radio" name="buy_btn_type" value="1" />样式1</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="2"/>样式2</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="3"/>样式3</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="4"/>样式4</label></div></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="show_title" value="1"/>显示商品名</label></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="price" value="1"/>显示价格</label></div></div></div></div>');
						break;
					case '2':
						$(this).closest('.control-group').next().replaceWith('<div class="control-group"><div class="controls"><div class="controls-card"><div class="controls-card-tab"><label class="radio inline"><input type="radio" name="size_type" value="0"/>卡片样式</label><label class="radio inline"><input type="radio" name="size_type" value="2"/>极简样式</label></div><div class="controls-card-item"><div><label class="checkbox inline"><input type="checkbox" name="buy_btn" value="1" />显示购买按钮</label></div><div style="margin:10px 0 0 20px;"><label class="radio inline"><input type="radio" name="buy_btn_type" value="1" />样式1</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="2"/>样式2</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="3"/>样式3</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="4"/>样式4</label></div></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="show_title" value="1"/>显示商品名 (小图不显示名称)</label></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="price" value="1"/>显示价格</label></div></div></div></div>');
						if(defaultFieldObj.data('size_type') != '0' && defaultFieldObj.data('size_type') != '2'){
							defaultFieldObj.data('size_type','0');
						}
						break;
					case '3':
						$(this).closest('.control-group').next().replaceWith('<div class="control-group"><div class="controls"><div class="controls-card"><div class="controls-card-tab"><label class="radio inline"><input type="radio" name="size_type" value="0"/>卡片样式</label><label class="radio inline"><input type="radio" name="size_type" value="2"/>极简样式</label></div><div class="controls-card-item"><div><label class="checkbox inline"><input type="checkbox" name="buy_btn" value="1" />显示购买按钮</label></div><div style="margin:10px 0 0 20px;"><label class="radio inline"><input type="radio" name="buy_btn_type" value="1" />样式1</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="2"/>样式2</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="3"/>样式3</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="4"/>样式4</label></div></div></div></div></div>');
						if(defaultFieldObj.data('size_type') != '0' && defaultFieldObj.data('size_type') != '2'){
							defaultFieldObj.data('size_type','0');
						}
						break;
				}
				$('.js-sidebar-region input[name="size_type"][value="'+defaultFieldObj.data('size_type')+'"]').prop('checked',true);
				
				if(defaultFieldObj.data('buy_btn') != '1'){
					$('.js-sidebar-region input[name="buy_btn"]').closest('div').next().remove();
				}else{
					$('.js-sidebar-region input[name="buy_btn"]').prop('checked',true);
					$('.js-sidebar-region input[name="buy_btn_type"][value="'+defaultFieldObj.data('buy_btn_type')+'"]').prop('checked',true);
				}
				
				$('.js-sidebar-region input[name="show_title"]').prop('checked',(defaultFieldObj.data('show_title') == '1' ? true : false));
				$('.js-sidebar-region input[name="price"]').prop('checked',(defaultFieldObj.data('price') == '1' ? true : false));
				
				//列表样式属性
				$('.js-sidebar-region input[name="size_type"]').change(function(){
					defaultFieldObj.data('size_type',$(this).val());
					if(defaultFieldObj.data('size') != '3'){
						if($(this).val() == '2'){
							$(this).closest('.controls-card-tab').next().hide();
						}else{
							$(this).closest('.controls-card-tab').next().show();
						}
					}else{
						if($(this).val() == '2'){
							if(defaultFieldObj.data('buy_btn_type') == '3'){
								defaultFieldObj.data('buy_btn_type','1');
								$('.js-sidebar-region input[name="buy_btn_type"][value="1"]').prop('checked',true);
							}
							$('.js-sidebar-region input[name="buy_btn_type"][value="3"]').closest('label').hide();
						}else{
							$('.js-sidebar-region input[name="buy_btn_type"][value="3"]').closest('label').show();
						}
					}
					changeStyleContent();
				});
				$('.js-sidebar-region input[name="buy_btn"]').change(function(){
					if($(this).prop('checked')){
						$(this).closest('div').next().show();
						defaultFieldObj.data('buy_btn','1');
					}else{
						$(this).closest('div').next().hide();
						defaultFieldObj.data('buy_btn','0');
					}
					changeStyleContent();
				});
				$('.js-sidebar-region input[name="buy_btn_type"]').change(function(){
					defaultFieldObj.data('buy_btn_type',$(this).val());
					changeStyleContent();
				});
				
				$('.js-sidebar-region input[name="show_title"]').change(function(){
					defaultFieldObj.data('show_title',$(this).prop('checked') ? '1' : '0');
					changeStyleContent();
				});
				$('.js-sidebar-region input[name="price"]').change(function(){
					defaultFieldObj.data('price',$(this).prop('checked') ? '1' : '0');
					changeStyleContent();
				});
				
				changeStyleContent();
			}).each(function(i,item){
				if($(item).val() == defaultFieldObj.data('size')){
					$(item).prop('checked',true).change();
				}
			});
			
			
			// var domHtml = defaultFieldObj.find('.custom-richtext');
			
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
					if(defaultFieldObj.find('.custom-richtext').size() > 0){
						defaultFieldObj.find('.custom-richtext').html(ue_con);
					}else{
						if(defaultFieldObj.data('show_tag_title') == '1'){
							defaultFieldObj.find('.custom-title').closest('.control-group').after('<div class="control-group"><div class="custom-richtext">'+ue_con+'</div></div>');
						}else{
							defaultFieldObj.find('.page-title').after('<div class="control-group"><div class="custom-richtext">'+ue_con+'</div></div>');
						}
					}
				}else{
					defaultFieldObj.find('.custom-richtext').closest('.control-group').remove();
				}
			});
			ueditor.addListener("contentChange",function(){
				var ue_con = ueditor.getContent();
				if(ue_con != ''){
					if(defaultFieldObj.find('.custom-richtext').size() > 0){
						defaultFieldObj.find('.custom-richtext').html(ue_con);
					}else{
						if(defaultFieldObj.data('show_tag_title') == '1'){
							defaultFieldObj.find('.custom-title').closest('.control-group').after('<div class="control-group"><div class="custom-richtext">'+ue_con+'</div></div>');
						}else{
							defaultFieldObj.find('.page-title').after('<div class="control-group"><div class="custom-richtext">'+ue_con+'</div></div>');
						}
					}
				}else{
					defaultFieldObj.find('.custom-richtext').closest('.control-group').remove();
				}
			});
			ueditor.render($('.js-editor')[0]);
			ueditor.ready(function(){
				if(defaultFieldObj.find('.custom-richtext').size() > 0){
					ueditor.setContent(defaultFieldObj.find('.custom-richtext').html());
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
				layer_tips(1,'分组名称不能少于一个字或者多余50个字');
				defaultFieldObj.trigger('click');
				return false;
			}
			post_data.show_tag_title  = defaultFieldObj.data('show_tag_title');
			post_data.first_sort  = defaultFieldObj.data('first_sort');
			post_data.second_sort = defaultFieldObj.data('second_sort');
			post_data.cat_desc    = defaultFieldObj.find('.custom-richtext').html();	
			post_data.size  = defaultFieldObj.data('size');
			post_data.size_type  = defaultFieldObj.data('size_type');
			post_data.buy_btn  = defaultFieldObj.data('buy_btn');
			post_data.buy_btn_type  = defaultFieldObj.data('buy_btn_type');
			post_data.show_title  = defaultFieldObj.data('show_title');
			post_data.price  = defaultFieldObj.data('price');
			
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
		
		function changeStyleContent(){
			var html = '';
			switch(defaultFieldObj.data('size')){
				case '0':
					switch(defaultFieldObj.data('size_type')){
						case '0':
							html  = '<ul class="sc-goods-list clearfix size-2 card pic"><li class="goods-card big-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/first_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+' '+(defaultFieldObj.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</a></li><li class="goods-card big-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/two_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</a></li><li class="goods-card big-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/n_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</a></li></ul>';
							break;
						case '2':
							html = '<ul class="sc-goods-list clearfix size-2 normal pic"><li class="goods-card big-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/first_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+' '+(defaultFieldObj.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							html += '</a></li><li class="goods-card big-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/two_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							html += '</a></li><li class="goods-card big-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/n_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							html += '</a></li></ul>';
							break;
					}
					break;
				case '1':
					switch(defaultFieldObj.data('size_type')){
						case '0':
							html  = '<ul class="sc-goods-list clearfix size-1 card pic"><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/first_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+' '+(defaultFieldObj.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/two_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/third_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥32.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/n_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</a></li></ul>';
							break;
						case '1':
							html  = '<ul class="sc-goods-list clearfix size-1 waterfall pic">';
								html += '<li class="sc-waterfall-half clearfix">';
									html += '<ul class="clearfix">';
										html += '<li class="goods-card goods-list small-pic waterfall"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/first_demo_goods.jpg" style="height:145px;"/></div>';
										if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
											html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+' '+(defaultFieldObj.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
										}
										if(defaultFieldObj.data('buy_btn') == '1'){
											html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
										}
										html += '</a></li>';
										html += '<li class="goods-card goods-list small-pic waterfall"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/third_demo_goods.jpg" style="height:205px;"/></div>';
										if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
											html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+' '+(defaultFieldObj.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥32.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
										}
										if(defaultFieldObj.data('buy_btn') == '1'){
											html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
										}
										html += '</a></li>';
									html += '</ul>';
								html += '</li>';
								html += '<li class="sc-waterfall-half clearfix">';
									html += '<ul class="clearfix">';
										html += '<li class="goods-card goods-list small-pic waterfall"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/two_demo_goods.jpg" style="height:155px;"/></div>';
										if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
											html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+' '+(defaultFieldObj.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
										}
										if(defaultFieldObj.data('buy_btn') == '1'){
											html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
										}
										html += '</a></li>';
										html += '<li class="goods-card goods-list small-pic waterfall"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/n_demo_goods.jpg" style="height:175px;"/></div>';
										if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
											html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+' '+(defaultFieldObj.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
										}
										if(defaultFieldObj.data('buy_btn') == '1'){
											html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
										}
										html += '</a></li>';
									html += '</ul>';
								html += '</li>';
							html += '</ul>';
							break;
						case '2':
							html  = '<ul class="sc-goods-list clearfix size-1 normal pic"><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/first_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+' '+(defaultFieldObj.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/two_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/third_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥32.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/n_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							html += '</a></li></ul>';
							break;
					}
					break;
				case '2':
					switch(defaultFieldObj.data('size_type')){
						case '0':
							html  = '<ul class="sc-goods-list clearfix size-2 card pic"><li class="goods-card big-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/first_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+' '+(defaultFieldObj.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/two_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/n_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</a></li></ul>';
							break;
						case '2':
							html  = '<ul class="sc-goods-list clearfix size-2 normal pic"><li class="goods-card big-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/first_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('show_title') == '1' || defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+' '+(defaultFieldObj.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/two_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/n_demo_goods.jpg"/></div>';
							if(defaultFieldObj.data('price') == '1'){
								html += '<div class="info clearfix '+(defaultFieldObj.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
							}
							html += '</a></li></ul>';
							break;
					}
					break;
				case '3':
					switch(defaultFieldObj.data('size_type')){
						case '0':
							html  = '<ul class="sc-goods-list clearfix size-3 card list"><li class="goods-card card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/first_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p>';
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</div>';
							html += '</a></li><li class="goods-card card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/two_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p>';
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</div>';
							html += '</a></li><li class="goods-card card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/n_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p>';
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</div>';
							html += '</a></li></ul>';
							break;
						case '2':
							html  = '<ul class="sc-goods-list clearfix size-3 normal list"><li class="goods-card normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/first_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p>';
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</div>';
							html += '</a></li><li class="goods-card normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/two_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p>';
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</div>';
							html += '</a></li><li class="goods-card normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="./upload/images/n_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(defaultFieldObj.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p>';
							if(defaultFieldObj.data('buy_btn') == '1'){
								html += '<div class="goods-buy btn'+defaultFieldObj.data('buy_btn_type')+'"></div>';
							}
							html += '</div>';
							html += '</a></li></ul>';
							break;
					}
					break;
			}
			defaultFieldObj.find('.sc-goods-list').replaceWith(html);
		}
	}
	
	var defaultHtmlObj = function(){
		return '<div><div class="form-horizontal"><div class="js-meta-region" style="margin-bottom:20px;"><div><div class="control-group"><label class="control-label"><em class="required">*</em>分组名称：</label><div class="controls"><input class="input-xxlarge" type="text" name="group_title" value=""></div></div><div class="control-group"><div class="controls"><label class="checkbox"><input type="checkbox" name="show_tag_title" value="1"/><span>页面上显示商品分组名称</span></label></div></div><div class="control-group"><label class="control-label">第一优先级：</label><div class="controls"><select name="first_sort"><option value="0">序号越大越靠前</option><option value="1">最热的排在前面</option></select></div></div><div class="control-group"><label class="control-label">第二优先级：</label><div class="controls"><select name="second_sort"><option value="0">创建时间越晚越靠前</option><option value="1">创建时间越早越靠前</option><option value="2">最热的排在前面</option></select></div></div><div class="control-group"><label class="control-label">列表样式：</label><div class="controls"><label class="radio inline"><input type="radio" name="size" value="0"/>大图</label><label class="radio inline"><input type="radio" name="size" value="1"/>小图</label><label class="radio inline"><input type="radio" name="size" value="2"/>一大两小</label><label class="radio inline"><input type="radio" name="size" value="3"/>详细列表</label></div></div><div class="control-group"></div></div></div></div><div class="control-group"><hr/><div class="separate-line"><p class="text-center">商品标签简介</p><p class="text-center">v</p></div><div class="control-group"><div name="content"><script class="js-editor" type="text/plain"></script></div></div></div></div>';
	};
	
	$('.js-app-main .js-delete').live('click',function(e){
		var dom = $(this);
		button_box(dom,e,'left','confirm','确定删除?',function(){
			$.post(delete_url,{group_id:dom.closest('tr').attr('group-id')},function(result){
				if(result.err_code == 0){
					layer_tips(0,result.err_msg);
					dom.closest('tr').remove();
				}else{
					layer.alert(result.err_msg,0);
				}
                close_button_box();
			});
		});
	});
	$('.js-app-main .js-copy-link').live('click',function(e){
		button_box($(this),e,'left','copy',wap_cat_url+'?id='+$(this).closest('tr').attr('group-id'),function(){
			layer_tips(0,'复制成功');
		});
	});
	$('.js-page-list a').live('click',function(e){
		if(!$(this).hasClass('active')){
			load_page('.app__content',load_url,{page:'category_content',p:$(this).attr('data-page-num')},'');
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
            alert(1)
        }
    })
})