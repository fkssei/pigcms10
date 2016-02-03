/*! js 2015-2-7 */
var customField={
	list:function(){
		// return [{type:"rich_text",val:"富文本"},{type:"goods",val:"商品"},{type:"goods_list",val:"商品<br/>列表"},{type:"cube2",val:"魔方"},{type:"title",val:"标题"},{type:"text_nav",val:"文本<br/>导航"},{type:"image_nav",val:"图片<br/>导航"},{type:"link",val:"关联<br/>链接"},{type:"search",val:"商品<br/>搜索"},{type:"showcase",val:"橱窗"},{type:"line",val:"辅助线"},{type:"white",val:"辅助<br/>空白"},{type:"component",val:"自定义<br/>模块"},{type:"store",val:"进入<br/>店铺"},{type:"notice",val:"公告"}];
		try{
			is_adminuser;
		}catch(e){
			var is_adminuser="";
		}
		if(is_adminuser) {	
		return [{type:"rich_text",val:"富文本"},{type:"image_ad",val:"图片<br/>广告"},{type:"goods",val:"商品"},{type:"title",val:"标题"},{type:"text_nav",val:"文本<br/>导航"},{type:"image_nav",val:"图片<br/>导航"},{type:"link",val:"关联<br/>链接"},{type:"search",val:"商品<br/>搜索"},{type:"line",val:"辅助线"},{type:"white",val:"辅助<br/>空白"},{type:"component",val:"自定义<br/>模块"},{type:"store",val:"进入<br/>店铺"},{type:"notice",val:"公告"},{type:"goods_group1",val:"餐饮小食1"},{type:"goods_group2",val:"餐饮小食2"},{type:"coupons",val:"优惠券"},
			        {type:"tpl_shop",val:"网店logo抬头"},
					{type:"tpl_shop1",val:"网店logo抬头1"}

		];
		}else {
		return [{type:"rich_text",val:"富文本"},{type:"image_ad",val:"图片<br/>广告"},{type:"goods",val:"商品"},{type:"title",val:"标题"},{type:"text_nav",val:"文本<br/>导航"},{type:"image_nav",val:"图片<br/>导航"},{type:"link",val:"关联<br/>链接"},{type:"search",val:"商品<br/>搜索"},{type:"line",val:"辅助线"},{type:"white",val:"辅助<br/>空白"},{type:"component",val:"自定义<br/>模块"},{type:"store",val:"进入<br/>店铺"},{type:"notice",val:"公告"},{type:"goods_group1",val:"餐饮小食1"},{type:"goods_group2",val:"餐饮小食2"},{type:"coupons",val:"优惠券"},

		
		
		];			
			
		}
		

	

		
	},
	listHtml:function(){
		/*if($('.app-preview').size() != 1){
			layer_tips(1,'DOM中请先有“.app-preview”的DOM，且只能有1个。');
		}*/
		var arr = customField.list();
		var html = '<div class="js-add-region"><div><div class="app-add-field"><h4>添加内容</h4><ul>';
		for(var i in arr){
			html += '<li><a class="js-new-field rich-text" data-field-type="'+ arr[i].type +'">'+ arr[i].val +'</a></li>';
		}
		html += '</ul></div></div></div>';
		$('.app-preview').append(html);
	},
	init:function(){
		customField.listHtml();
		$('.js-add-region .js-new-field').click(function(){
			if($(this).attr("data-field-type") == 'tpl_shop' || $(this).attr("data-field-type") == 'tpl_shop1')   {
				if($('.tpl-shop').length>0 || $('.tpl-shop1').length>0 ) {
					layer_tips(1,'一个模板只可拥有一个模板头部！');
					return false;
				}
			} 		
			

			var app_field = $('<div class="app-field clearfix"><div class="control-group"><div class="component-border"></div></div><div class="actions"><div class="actions-wrap"><span class="action edit">编辑</span><span class="action add">加内容</span><span class="action delete">删除</span></div></div><div class="sort"><i class="sort-handler"></i></div></div>');
			
			
			
			app_field.data('field-type',$(this).data('field-type'));
			$('.js-fields-region .app-fields').append(app_field);
			app_field.trigger('click');
		});
			
		var doMouseDownTimmer= null;
		$('.js-fields-region .app-field').live('click',function(){
			clearTimeout(doMouseDownTimmer);
			if(!$(this).hasClass('editing')){
				customField.clickEvent($(this));
			}
		}).live('mousedown',function(ee){
			var preview_top = $('.app-preview').offset().top;
			var dom = $(this);
			var moveCssDom = $('<style>*{cursor:move!important;}</style>');
			var newTop=0;
			var fieldTop = ee.pageY - dom.offset().top;
			doMouseDownTimmer = setTimeout(function(){
				$('body').bind('mousemove mouseup',function(e){
					if(e.type == 'mousemove'){
						if(dom.data('noFirst') == '1'){
							newTop = e.pageY - preview_top - fieldTop;
							dom.css('top',newTop);
							if(newTop > ($('.ui-sortable-placeholder').offset().top - preview_top + ($('.ui-sortable-placeholder').height()*1))){
								$('.ui-sortable-placeholder').insertAfter($('.ui-sortable-placeholder').next());
							}else if($('.ui-sortable-placeholder').index() > 0 && newTop < ($('.ui-sortable-placeholder').prev().offset().top - preview_top + ($('.ui-sortable-placeholder').prev().height()*0.1))){
								$('.ui-sortable-placeholder').insertBefore($('.ui-sortable-placeholder').prev());
							}
						}else{
							$('body').bind("selectstart",function(){return false;}).css({'cursor':'move','-moz-user-select':'none','-khtml-user-select':'none','user-select':'none'}).append(moveCssDom);
							dom.css({position:'absolute',width:'320px',height:(dom.height())+'px','z-index':'1000','top':(dom.offset().top-preview_top-1)+'px'}).data('noFirst','1').after('<div class="app-field clearfix editing ui-sortable-placeholder" style="visibility:hidden;height:'+(dom.height())+'px;"></div>');
						}
					}else{
						$('body').css({'cursor':'auto','-moz-user-select':'','-khtml-user-select':'','user-select':''}).unbind('mousemove mouseup selectstart');
						dom.data({'mousedown':false,'noFirst':'0'}).attr('style','position:relative');
						$('.ui-sortable-placeholder').replaceWith(dom);
						//moveCssDom.remove();
						if(dom.hasClass('editing')){
							//customField.clickEvent(dom);
						}
					}
				});
			},200);
		});
		$('.js-fields-region .action.add').live('click',function(event){
			clearTimeout(doMouseDownTimmer);
			var dom = $(this).closest('.app-field');
			var arr = customField.list();
			var rightContent = '<div><div class="app-add-field"><h4>添加内容</h4><ul>';
			for(var i in arr){
				rightContent += '<li><a class="js-new-field rich-text" data-field-type="'+ arr[i].type +'">'+ arr[i].val +'</a></li>';
			}
			rightContent += '</ul></div></div>';
			rightHtml = $(rightContent);
			rightHtml.find('.js-new-field').click(function(){
				var app_field = $('<div class="app-field clearfix"><div class="control-group"><div class="component-border"></div></div><div class="actions"><div class="actions-wrap"><span class="action edit">编辑</span><span class="action add">加内容</span><span class="action delete">删除</span></div></div><div class="sort"><i class="sort-handler"></i></div></div>');
				app_field.data('field-type',$(this).data('field-type'));
				dom.after(app_field);
				app_field.trigger('click');
			});
			$('.js-sidebar-region').empty().html(rightHtml);
			$('.app-sidebar').css('margin-top',dom.offset().top - $('.app-preview').offset().top);
			event.stopPropagation();
			return false;
		});
		$('.js-fields-region .action.delete').live('click',function(event){
			clearTimeout(doMouseDownTimmer);
			var nowDom = $(this);
			button_box($(this),event,'left','delete','确定删除？',function(){
				nowDom.closest('.app-field').remove();
				if(nowDom.closest('.app-field').hasClass('editing')){
					$('.js-config-region .app-field').eq(0).trigger('click');
				}
				close_button_box();
			});
			event.stopPropagation();
			return false;
		});
	},
	clickEvent:function(dom){
		$('.app-entry .app-field').removeClass('editing');
		dom.addClass('editing');
		var clickArr=[],domHtml='',rightHtml='',defaultHtml='';
		clickArr['rich_text'] = function(){
			defaultHtml = '<p>点此编辑『富文本』内容 ——&gt;</p><p>你可以对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration: line-through;">删除线</span>、文字<span style="color: rgb(0, 176, 240);">颜色</span>、<span style="background-color:rgb(255, 192, 0);color:rgb(255, 255, 255);">背景色</span>、以及字号<span style="font-size:20px;">大</span><span style="font-size: 14px;">小</span>等简单排版操作。</p><p>还可以在这里加入表格了</p><table><tr><td width="93" valign="top" style="word-break: break-all;">中奖客户</td><td width="93" valign="top" style="word-break: break-all;">发放奖品</td><td width="93" valign="top" style="word-break: break-all;">备注</td></tr><tr><td width="93" valign="top" style="word-break: break-all;">猪猪</td><td width="93" valign="top" style="word-break: break-all;">内测码</td><td width="93" valign="top" style="word-break: break-all;"><em><span style="color: rgb(255, 0, 0);">已经发放</span></em></td></tr><tr><td width="93" valign="top" style="word-break: break-all;">大麦</td><td width="93" valign="top" style="word-break: break-all;">积分</td><td width="93" valign="top" style="word-break: break-all;"><a href="javascript: void(0);" target="_blank">领取地址</a></td></tr></table><p style="text-align: left;"><span style="text-align: left;">也可在这里插入图片、并对图片加上超级链接，方便用户点击。</span></p>';
			if(dom.find('.control-group .custom-richtext').size() == 0){
				domHtml = $('<div class="custom-richtext"></div>');
				domHtml.html(defaultHtml);
				domHtml.data({'bgcolor':'','fullscreen':'0','has_amend':'0'});
				dom.find('.control-group').prepend(domHtml);
			}else{
				domHtml = dom.find('.custom-richtext');
			}
			
			rightHtml = $('<div class="edit-rich-text"><form class="form-horizontal"><div class="control-group"><div class="left"><label class="control-label">背景颜色：</label><div class="input-append"><input type="color" value="'+ (domHtml.data('bgcolor')!='' ? domHtml.data('bgcolor') : '#ffffff')+'" name="color" class="span1"/><button class="btn js-reset-bg" type="button">重置</button></div></div><div class="left"><label class="control-label">是否全屏：</label><label class="checkbox inline" style="padding-top:0px;"><input type="checkbox" name="fullscreen" ' + (domHtml.data('fullscreen')=='1' ? 'checked="checked"' : '') + '/> 全屏显示</label></div></div><div class="control-group"><script class="js-editor" type="text/plain"></script></div></form></div>');
			rightHtml.find('input[name="color"]').change(function(){
				domHtml.css('background-color',$(this).val()).data('bgcolor',$(this).val());
			});
			rightHtml.find('.js-reset-bg').click(function(){
				$(this).siblings('input[name="color"]').val('#ffffff');
				domHtml.css('background-color','').data('bgcolor','');
			});
			rightHtml.find(':checkbox[name="fullscreen"]').click(function(){
				if($(this).prop('checked')){
					domHtml.data('fullscreen','1');
					dom.find('.control-group .custom-richtext').addClass('custom-richtext-fullscreen');
				}else{
					domHtml.data('fullscreen','0');
					dom.find('.control-group .custom-richtext').removeClass('custom-richtext-fullscreen');
				}
			});
			$('.js-sidebar-region form').remove();
			$('.js-sidebar-region').empty().html(rightHtml);
			
			var ueditor = new window.UE.ui.Editor({
				toolbars: [["bold", "italic", "underline", "strikethrough", "forecolor", "backcolor", "justifyleft", "justifycenter", "justifyright", "|", "insertunorderedlist", "insertorderedlist", "blockquote"], ["emotion", "uploadimage", "insertvideo", "link", "removeformat", "|", "rowspacingtop", "rowspacingbottom", "lineheight", "paragraph", "fontsize"], ["inserttable", "deletetable", "insertparagraphbeforetable", "insertrow", "deleterow", "insertcol", "deletecol", "mergecells", "mergeright", "mergedown", "splittocells", "splittorows", "splittocols"]],
				autoClearinitialContent: false,
				autoFloatEnabled: true,
				wordCount: true,
				elementPathEnabled: false,
				maximumWords: 10000,
				initialFrameWidth: 458,
				initialFrameHeight: 300,
				focus: false
			});
			ueditor.addListener("blur",function(){
				var ue_con = ueditor.getContent();
				if(ue_con != ''){
					domHtml.data('has_amend','1').html(ue_con);		
				}else{
					domHtml.data('has_amend','0').html(defaultHtml);
				}
			});
			ueditor.addListener("contentChange",function(){
				var ue_con = ueditor.getContent();
				if(ue_con != ''){
					domHtml.data('has_amend','1').html(ue_con);
				}else{
					domHtml.data('has_amend','0').html(defaultHtml);
				}
			});
			ueditor.render($('.js-editor')[0]);
			ueditor.ready(function(){
				if(domHtml.data('has_amend') == 1){
					ueditor.setContent(domHtml.html());
				}
			});
		};
		clickArr['notice'] = function(){
			defaultHtml = '<div class="custom-notice-inner"><div class="custom-notice-scroll"><span>公告：</span></div></div>';
			
			if(dom.find('.control-group .custom-notice').size() == 0){
				domHtml = $('<div class="custom-notice"></div>');
				domHtml.html(defaultHtml).data('content','');
				dom.find('.control-group').prepend(domHtml);
			}else{
				domHtml = dom.find('.custom-notice');
			}
			
			rightHtml = $('<div><form class="form-horizontal edit-tpl-11-11" onsubmit="return false"><div class="control-group"><label class="control-label">公告：</label><div class="controls"><input type="text" name="content" value="' + (domHtml.data('content')) + '" class="input-xxlarge" placeholder="请填写内容，如果过长，将会在手机上滚动显示"/></div></div></form></div>');
			
			rightHtml.find('.input-xxlarge').blur(function(){
				domHtml.data('content',$(this).val()).find('.custom-notice-scroll').html('<span>公告：' + $(this).val() + '</span>');
			});
			
			$('.js-sidebar-region').empty().html(rightHtml);
		};
		clickArr['title'] = function(){
			var defaultTitle = '点击编辑『标题』';
			defaultHtml = '<h2 class="title">'+defaultTitle+'</h2>';
			
			if(dom.find('.control-group .custom-title').size() == 0){
				domHtml = $('<div class="custom-title text-left"></div>');
				domHtml.data({'title':'','sub_title':'','show_method':'0','bgcolor':''}).html(defaultHtml);
				dom.find('.control-group').prepend(domHtml);
			}else{
				domHtml = dom.find('.custom-title');
			}
			
			rightHtml = $('<div><form class="form-horizontal"><div class="control-group"><label class="control-label"><em class="required">*</em>标题名：</label><div class="controls"><input type="text" name="title" value="' + (domHtml.data('title')) + '" maxlength="100"/></div></div><div class="control-group"><label class="control-label">副标题：</label><div class="controls"><input type="text" class="js-time-holder" value="' + (domHtml.data('sub_title')) + '" style="position:absolute;z-index:-1;"/><input type="text" name="sub_title" value="' + (domHtml.data('sub_title')) + '" maxlength="100"/>&nbsp;&nbsp;<a href="javascript:void(0);" class="js-time">日期</a></div></div><div class="control-group"><label class="control-label">显示：</label><div class="controls"><label class="radio inline"><input type="radio" name="show_method" value="0" ' + (domHtml.data('show_method') == '0' ? 'checked="checked"' : '') + '/>居左显示</label><label class="radio inline"><input type="radio" name="show_method" value="1" ' + (domHtml.data('show_method') == '1' ? 'checked="checked"' : '') + '/>居中显示</label><label class="radio inline"><input type="radio" name="show_method" value="2" ' + (domHtml.data('show_method') == '2' ? 'checked="checked"' : '') + '/>居右显示</label></div></div><div class="control-group"><label class="control-label">背景颜色：</label><div class="controls"><input type="color" name="color" value="' + (domHtml.data('bgcolor') == '' ? '#ffffff' : domHtml.data('bgcolor')) + '"/> <button class="btn js-reset-bg" type="button">重置</button></div></div></form></div>');
			
			rightHtml.find('input[name="title"]').blur(function(){
				domHtml.data('title',$(this).val()).find('h2.title').html(($(this).val().length != 0 ? $(this).val() : defaultTitle));
			});
			rightHtml.find('input[name="sub_title"]').blur(function(){
				if($(this).val().length == 0){
					domHtml.data('sub_title','').find('.sub_title').remove();
				}else{
					domHtml.data('sub_title',$(this).val());
					if(domHtml.find('.sub_title').size() > 0){
						domHtml.find('.sub_title').html($(this).val());
					}else{
						domHtml.find('.title').after('<p class="sub_title">'+$(this).val()+'</p>');
					}
				}
			});
			
			var timepicker = rightHtml.find('.js-time-holder');
			timepicker.datetimepicker({
				dateFormat: "yy-mm-dd",
				timeFormat: "HH:mm",
				minDate: new Date,
				changeMonth:true,
				changeYear:true,
				onSelect: function(e){
					timepicker.siblings('input[name="sub_title"]').val(e).trigger('blur');
				}
			});
			rightHtml.find('a.js-time').click(function(){
				timepicker.datepicker('show');
			});
			
			rightHtml.find('input[name="show_method"]').change(function(){
				domHtml.data('show_method',$(this).val());
				switch($(this).val()){
					case '0':
						domHtml.removeClass('text-center text-right').addClass('text-left');
						break;
					case '1':
						domHtml.removeClass('text-left text-right').addClass('text-center');
						break;
					default:
						domHtml.removeClass('text-left text-center').addClass('text-right');
				}
			});
			
			rightHtml.find('input[name="color"]').change(function(){
				domHtml.css('background-color',$(this).val()).data('bgcolor',$(this).val());
			});
			rightHtml.find('.js-reset-bg').click(function(){
				$(this).siblings('input[name="color"]').val('#ffffff');
				domHtml.css('background-color','').data('bgcolor','');
			});
			
			$('.js-sidebar-region form').remove();
			$('.js-sidebar-region').empty().html(rightHtml);
		};
		clickArr['line'] = function(){
			if(dom.find('.control-group .custom-line-wrap').size() == 0){
				dom.find('.control-group').prepend('<div class="custom-line-wrap"><hr class="custom-line"/></div>');
			}
			$('.js-sidebar-region').empty().html('<div><div class="app-component-desc"><p>辅助线</p></div></div>');
		};
		clickArr['white'] = function(){
			if(dom.find('.control-group .custom-white').size() == 0){
				domHtml = $('<div class="custom-white text-center" style="height:30px;"></div>');
				domHtml.data({'left':0,'height':30});
				dom.find('.control-group').prepend(domHtml);
			}else{
				domHtml = dom.find('.control-group .custom-white');
			}
			rightHtml = $('<div><form class="form-horizontal"><div class="control-group white-space-group"><label class="control-label">空白高度：</label><div class="controls controls-slider"><div class="js-slider white-space-slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false"><a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left:'+domHtml.data('left')+'%;"></a></div><div class="slider-height"><span class="js-height">'+domHtml.data('height')+'</span> 像素</div></div></div></form></div>');
			var heightDom = rightHtml.find('.js-height');
			rightHtml.find('.ui-slider-handle').hover(function(){
				$(this).addClass('ui-state-hover');
			},function(){
				$(this).removeClass('ui-state-hover ui-state-active');
			}).mousedown(function(){
				$(this).addClass('ui-state-active');
			}).mouseup(function(){
				$(this).removeClass('ui-state-active');
				return false;
			}).mousemove(function(e){
				if($(this).hasClass('ui-state-active')){
					var newLeft = e.pageX - rightHtml.find('.js-slider').offset().left;
					if(newLeft < 0 || newLeft > 250){
						return false;
					}else{
						var left = newLeft/250*100;
						if(left < 1) left = 0;
						if(left > 99) left = 100;
						var height = parseInt(30+left/100*70);
						$(this).css('left',left+'%');
						heightDom.html(height);
						domHtml.data({'left':left,'height':height}).css('height',height);
					}
				}
			});
			rightHtml.find('.js-slider').click(function(e){
				var newLeft = e.pageX - $(this).offset().left;
				if(newLeft < 0 || newLeft > 250){
					return false;
				}else{
					var left = newLeft/250*100;
					if(left < 1) left = 0;
					if(left > 99) left = 100;
					var height = parseInt(30+left/100*70);
					rightHtml.find('.ui-slider-handle').css('left',left+'%');
					heightDom.html(height);
					domHtml.data({'left':left,'height':height}).css('height',height);
				}
				return false;
			});
			$('.js-sidebar-region').empty().html(rightHtml);
		};
		clickArr['search'] = function(){
			if(dom.find('.control-group .custom-search').size() == 0){
				dom.find('.control-group').prepend('<div class="custom-search"><form action="/" method="GET"><input type="text" class="custom-search-input" placeholder="商品搜索：请输入商品关键字" disabled=""/><button type="submit" class="custom-search-button">搜索</button></form></div>');
			}
			$('.js-sidebar-region').empty().html('<div><div class="app-component-desc"><p>可随意插入任何页面和位置，方便粉丝快速搜索商品.</p><p>注意：搜索的商品是根据商品标题匹配的。</p></div></div>');
		};
		clickArr['store'] = function(){
			if(dom.find('.control-group .custom-store').size() == 0){
				dom.find('.control-group').prepend('<div class="custom-store"><a class="custom-store-link clearfix" href="javascript:;"><div class="custom-store-img"></div><div class="custom-store-name">店铺名称</div><div class="custom-store-enter">进入店铺</div></a></div>');
			}
			$('.js-sidebar-region').empty().html('<div><div class="app-component-desc"><p>进入店铺</p></div></div>');
		};
		clickArr['text_nav'] = function(){
			rightHtml = $('<div><form class="form-horizontal"><div class="control-group js-collection-region"><ul class="choices ui-sortable"></ul></div><div class="control-group options"><a class="add-option js-add-option" href="javascript:void(0);"><i class="icon-add"></i> 添加一个文本导航</a></div></form></div>');
			if(dom.find('.control-group .custom-nav').size() == 0){
				domHtml = $('<ul class="custom-nav clearfix"></ul>');
				domHtml.data({'navList':[]});
				dom.find('.control-group').prepend(domHtml);
			}else{
				domHtml = dom.find('.control-group .custom-nav');
			}
			var addContent = function(num,dom){
				var navList = domHtml.data('navList');
				if(num >= 0){
					randNumber = num;
					var liContent = '<li class="choice" data-id="'+randNumber+'"><div class="control-group"><label class="control-label"><em class="required">*</em>导航名称：</label><div class="controls"><input type="text" name="title" value="'+navList[num].title+'"/></div></div><div class="control-group"><label class="control-label"><em class="required">*</em>链接到：</label><div class="controls"><div class="control-action clearfix">';
					
					if(navList[num].name == ''){
						liContent += '<div class="dropdown hover"><a class="js-dropdown-toggle dropdown-toggle" href="javascript:void(0);">设置链接到的页面地址 <i class="caret"></i></a></div>';
					}else{
						liContent += '<div class="left js-link-to link-to"><a href="'+navList[num].url+'" target="_blank" class="new-window link-to-title"><span class="label label-success">'+navList[num].prefix+' <em class="link-to-title-text">'+navList[num].name+'</em></span></a><a href="javascript:;" class="js-delete-link link-to-title close-modal" title="删除">×</a></div><div class="dropdown hover right"><a class="dropdown-toggle" href="javascript:void(0);">修改 <i class="caret"></i></a></div>';
					}
					liContent += '</div></div></div><div class="actions"><span class="action add close-modal" title="添加">+</span><span class="action delete close-modal" title="删除">×</span></div></li>';
					var liHtml  = $(liContent);
					if(navList[num].name != ''){
						liHtml.find('.js-delete-link').click(function(){
							var fDom = $(this).closest('.control-action');
							fDom.find('.js-link-to').remove();
							fDom.find('.dropdown').removeClass('right').children('a').attr('class','js-dropdown-toggle dropdown-toggle').html('设置链接到的页面地址 <i class="caret">');
							var navList = domHtml.data('navList');
							navList[liHtml.data('id')] = {'title':titleDom.val(),'prefix':'','url':'','name':''};
							domHtml.data('navList',navList);
						});
					}
				}else{
					var randNumber = getRandNumber();
					navList[randNumber] = {'title':'','prefix':'','url':'','name':''};
					domHtml.data('navList',navList);
					var liHtml  = $('<li class="choice" data-id="'+randNumber+'"><div class="control-group"><label class="control-label"><em class="required">*</em>导航名称：</label><div class="controls"><input type="text" name="title" value=""/></div></div><div class="control-group"><label class="control-label"><em class="required">*</em>链接到：</label><div class="controls"><div class="control-action clearfix"><div class="dropdown hover"><a class="js-dropdown-toggle dropdown-toggle" href="javascript:void(0);">设置链接到的页面地址 <i class="caret"></i></a></div></div></div></div><div class="actions"><span class="action add close-modal" title="添加">+</span><span class="action delete close-modal" title="删除">×</span></div></li>');
				}
				var titleDom = liHtml.find('input[name="title"]');
				var nowDom = liHtml.find('.dropdown');
				titleDom.blur(function(){ //标题文框失去焦点
					var navList = domHtml.data('navList');
					navList[liHtml.data('id')].title = titleDom.val();
					domHtml.data('navList',navList);
					buildContent();
				});
				link_box(nowDom,[],function(type,prefix,title,href){
					nowDom.siblings('.js-link-to').remove();
					var beforeDom = $('<div class="left js-link-to link-to"><a href="'+href+'" target="_blank" class="new-window link-to-title"><span class="label label-success">'+prefix+' <em class="link-to-title-text">'+title+'</em></span></a><a href="javascript:;" class="js-delete-link link-to-title close-modal" title="删除">×</a></div>');
					if(titleDom.val().length == 0){
						titleDom.val(title);
					}
					var navList = domHtml.data('navList');
					navList[liHtml.data('id')] = {'title':titleDom.val(),'prefix':prefix,'url':href,'name':title};
					domHtml.data('navList',navList);
					buildContent();
					
					beforeDom.find('.js-delete-link').click(function(){
						var fDom = $(this).closest('.control-action');
						fDom.find('.js-link-to').remove();
						fDom.find('.dropdown').removeClass('right').children('a').attr('class','js-dropdown-toggle dropdown-toggle').html('设置链接到的页面地址 <i class="caret">');
						var navList = domHtml.data('navList');
						navList[liHtml.data('id')] = {'title':titleDom.val(),'prefix':'','url':'','name':''};
						domHtml.data('navList',navList);
					});
					nowDom.before(beforeDom);
					nowDom.children('a').attr('class','dropdown-toggle').html('修改 <i class="caret"></i>');
				});
				liHtml.find('span.add').click(function(){
					addContent(-1,liHtml);
				});
				liHtml.find('span.delete').click(function(){
					var navList = domHtml.data('navList');
					delete navList[liHtml.data('id')];
					domHtml.data('navList',navList);
					$(this).closest('li.choice').remove();
					buildContent();
				});
				if(dom){
					dom.after(liHtml);
					var navList = domHtml.data('navList');
					var newNavList = [];
					$.each(rightHtml.find('.js-collection-region .ui-sortable > li'),function(i,item){
						newNavList[i] = navList[$(item).data('id')];
						$(item).data('id',i);
					});
					domHtml.data('navList',newNavList);
				}else{
					rightHtml.find('.js-collection-region .ui-sortable').append(liHtml);
				}
				buildContent();
			};
			var buildContent = function(){
				var navList = domHtml.data('navList');
				var html = '';
				for(var i in navList){
					html += '<li><a class="clearfix" href="javascript:void(0);"><span class="custom-nav-title">'+navList[i].title+'</span><i class="right right-arrow"></i></a></li>';
				}
				domHtml.html(html);
			};
			var navList = domHtml.data('navList');
			for(var num in navList){
				addContent(num);
			}
			rightHtml.find('.js-add-option').click(function(){
				addContent(-1);
			});
			
			$('.js-sidebar-region').empty().html(rightHtml);
		};
		clickArr['image_nav'] = function(){
			rightHtml = $('<div><form class="form-horizontal"><div class="js-collection-region"><ul class="choices ui-sortable"></ul></div></form></div>');
			if(dom.find('.control-group .custom-nav-4').size() == 0){
				domHtml = $('<ul class="custom-nav-4 clearfix"></ul>');
				domHtml.data({'navList':[{'title':'','prefix':'','url':'','name':'','image':''},{'title':'','prefix':'','url':'','name':'','image':''},{'title':'','prefix':'','url':'','name':'','image':''},{'title':'','prefix':'','url':'','name':'','image':''}]});
				dom.find('.control-group').prepend(domHtml);
			}else{
				domHtml = dom.find('.control-group .custom-nav-4');
			}
			var rightUl = rightHtml.find('.js-collection-region .ui-sortable');
			var navList = domHtml.data('navList');

			for(var i in navList){
				(function(){
					var liContent = '<li class="choice" data-id="'+i+'">';
					liContent += '<div class="choice-image">';
					if(navList[i].image){
						liContent += '<img src="'+navList[i].image+'" width="118" height="118" class="thumb-image"/><a class="modify-image js-trigger-image" href="javascript: void(0);">重新上传</a>';
					}else{
						liContent += '<a class="add-image js-trigger-image" href="javascript: void(0);"><i class="icon-add"></i>  添加图片</a>';
					}
					liContent += '</div>';
					liContent += '<div class="choice-content"><div class="control-group"><label class="control-label">文字：</label><div class="controls"><input class="" type="text" name="title" value="'+(navList[i].title!='' ? navList[i].title : '')+'" maxlength="15"/></div></div><div class="control-group"><label class="control-label">链接：</label><div class="control-action clearfix">';
					if(navList[i].name != ''){
						liContent += '<div class="left js-link-to link-to"><a href="'+navList[i].url+'" target="_blank" class="new-window link-to-title"><span class="label label-success">'+navList[i].prefix+' <em class="link-to-title-text">'+navList[i].name+'</em></span></a><a href="javascript:;" class="js-delete-link link-to-title close-modal" title="删除">×</a></div><div class="dropdown hover right"><a class="dropdown-toggle" href="javascript:void(0);">修改 <i class="caret"></i></a></div>';
					}else{
						liContent += '<div class="dropdown hover"><a class="js-dropdown-toggle dropdown-toggle" href="javascript:void(0);">设置链接到的页面地址 <i class="caret"></i></a></div>';
					}
					liContent += '</div></div></div></li>';
					var liHtml = $(liContent);
					if(navList[i].name != ''){
						liHtml.find('.js-delete-link').click(function(){
							var fDom = $(this).closest('.control-action');
							fDom.find('.js-link-to').remove();
							fDom.find('.dropdown').removeClass('right').children('a').attr('class','js-dropdown-toggle dropdown-toggle').html('设置链接到的页面地址 <i class="caret">');
							var navList = domHtml.data('navList');
							navList[liHtmlId].prefix = '';
							navList[liHtmlId].url = '';
							navList[liHtmlId].name = '';
							domHtml.data('navList',navList);
						});
					}
					var titleDom = liHtml.find('input[name="title"]');
					var nowDom = liHtml.find('.dropdown');
					titleDom.blur(function(){
						var navList = domHtml.data('navList');
						navList[liHtml.data('id')].title = titleDom.val();
						domHtml.data('navList',navList);
						buildContent();
					});
					liHtml.find('.js-trigger-image').click(function(){
						var imageDom = $(this);
						upload_pic_box(1,true,function(pic_list){
							if(pic_list.length > 0){
								for(var i in pic_list){
									imageDom.siblings('.thumb-image').remove();
									imageDom.removeClass('add-image').addClass('modify-image').html('重新上传').before('<img src="'+pic_list[i]+'" width="118" height="118" class="thumb-image"/>');	
									var navList = domHtml.data('navList');
									navList[liHtml.data('id')].image = pic_list[i];								
									domHtml.data('navList',navList);
									buildContent();
								}
							}
						},1);
					});
					link_box(nowDom,[],function(type,prefix,title,href){
						nowDom.siblings('.js-link-to').remove();
						var beforeDom = $('<div class="left js-link-to link-to"><a href="'+href+'" target="_blank" class="new-window link-to-title"><span class="label label-success">'+prefix+' <em class="link-to-title-text">'+title+'</em></span></a><a href="javascript:;" class="js-delete-link link-to-title close-modal" title="删除">×</a></div>');
						
						var navList = domHtml.data('navList');
						var liHtmlId = liHtml.data('id');
						navList[liHtmlId].prefix = prefix;
						navList[liHtmlId].url = href;
						navList[liHtmlId].name = title;
						
						beforeDom.find('.js-delete-link').click(function(){
							var fDom = $(this).closest('.control-action');
							fDom.find('.js-link-to').remove();
							fDom.find('.dropdown').removeClass('right').children('a').attr('class','js-dropdown-toggle dropdown-toggle').html('设置链接到的页面地址 <i class="caret">');
							var navList = domHtml.data('navList');
							navList[liHtmlId].prefix = '';
							navList[liHtmlId].url = '';
							navList[liHtmlId].name = '';
							domHtml.data('navList',navList);
						});
						
						domHtml.data('navList',navList);
						buildContent();
						nowDom.before(beforeDom);
						nowDom.addClass('right').children('a').attr('class','dropdown-toggle').html('修改 <i class="caret"></i>');
					});
					rightUl.append(liHtml);
				})();
			}
			var buildContent = function(){
				var navList = domHtml.data('navList');
				var html = '';
				for(var i in navList){
					html += '<li><span class="nav-img-wap">'+ (navList[i].image!='' ? '<img src="'+navList[i].image+'"/>' : '&nbsp;')+'</span>'+ (navList[i].title!='' ? '<span class="title">'+navList[i].title+'</span>' : '')+'</li>';
				}
				domHtml.html(html);
			};
			var navList = domHtml.data('navList');
			$('.js-sidebar-region').empty().html(rightHtml);
		};
		clickArr['component'] = function(){
			if(dom.find('.control-group .custom-richtext').size() == 0){
				domHtml = $('<div class="custom-richtext" style="padding-bottom:10px;">点击编辑『自定义页面模块』</div>');
				domHtml.data({'name':'','id':'','url':''});
				dom.find('.control-group').prepend(domHtml);
			}else{
				domHtml = dom.find('.control-group .custom-richtext');
			}
			var rightContent = '<div><form class="form-horizontal"><div class="control-group control-group-large"><label class="control-label">自定义页面模块：</label><div class="controls"><div class="control-action">';
			if(domHtml.data('name')!=''){
				rightContent += '<div class="left link-to"><a href="'+domHtml.data('url')+'" target="_blank" class="new-window link-to-title"><span class="label label-success">自定义页面模块 <em class="link-to-title-text">'+domHtml.data('name')+'</em></span></a></div><a href="javascript:void(0);" class="js-add-component add-component">修改</a>';
			}else{
				rightContent += '<a href="javascript:void(0);" class="js-add-component add-component">+添加</a>';
			}
			rightContent += '</div></div></div></form></div>';
			rightHtml = $(rightContent);
			rightHtml.find('.js-add-component').click(function(){
				var nowDom = $(this);
				$('.modal-backdrop,.modal').remove();
				$('body').append('<div class="modal-backdrop fade in widget_link_back"></div>');
				var randNum = getRandNumber();
				var load_url = 'user.php?c=widget&a=component&number='+randNum;
				link_save_box[randNum] = function(type,prefix,title,href){
					nowDom.html('修改').siblings('.link-to').remove();
					nowDom.before('<div class="left link-to"><a href="'+href+'" target="_blank" class="new-window link-to-title"><span class="label label-success">自定义页面模块 <em class="link-to-title-text">'+title+'</em></span></a></div><a href="javascript:void(0);" class="js-add-component add-component">修改</a>');
					domHtml.html(title).data({'name':title,'id':type,'url':href});
				};
				modalDom = $('<div class="modal fade hide js-modal in widget_link_box" aria-hidden="false" style="margin-top:0px;display:block;"><iframe src="'+load_url+'" style="width:100%;height:200px;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;"></iframe></div>');
				$('body').append(modalDom);
				modalDom.animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
			});
			$('.js-sidebar-region').empty().html(rightHtml);
		};
		clickArr['link'] = function(){
			defaultHtml = '<li><a class="clearfix" href="javascript: void(0);" target="_blank"><span class="custom-nav-title">点此编辑第1条『关联链接』</span><i class="pull-right right-arrow"></i></a></li><li><a class="clearfix" href="javascript: void(0);" target="_blank"><span class="custom-nav-title">点此编辑第2条『关联链接』</span><i class="pull-right right-arrow"></i></a></li><li><a class="clearfix" href="javascript: void(0);" target="_blank"><span class="custom-nav-title">点此编辑第n条『关联链接』</span><i class="pull-right right-arrow"></i></a></li>';
			rightHtml = $('<div><form class="form-horizontal"><div class="control-group js-collection-region"><ul class="choices ui-sortable"></ul></div><div class="control-group options"><a class="add-option js-add-option" href="javascript:void(0);"><i class="icon-add"></i> 添加一个关联链接</a></div></form></div>');
			if(dom.find('.control-group .custom-nav').size() == 0){
				domHtml = $('<ul class="custom-nav clearfix">'+defaultHtml+'</ul>');
				domHtml.data({'navList':[]});
				dom.find('.control-group').prepend(domHtml);
			}else{
				domHtml = dom.find('.control-group .custom-nav');
			}
			var addContent = function(num,dom){
				var navList = domHtml.data('navList');
				if(num >= 0){
					randNumber = num;
					if(navList[num].name == ''){
						var liContent = '<li class="choice" data-id="'+randNumber+'"><div class="control-group"><label class="control-label"><em class="required">*</em>内容来源：</label><div class="controls"><div class="control-action clearfix"><div class="dropdown hover"><a class="js-dropdown-toggle dropdown-toggle" href="javascript:void(0);">设置链接到的页面地址 <i class="caret"></i></a></div></div></div></div><div class="actions"><span class="action add close-modal" title="添加">+</span><span class="action delete close-modal" title="删除">×</span></div></li>';
					}else{
						var liContent = '<li class="choice" data-id="'+randNumber+'">';
						if(navList[num].type == 'link'){
							liContent += '<div class="control-group"><label class="control-label"><em class="required">*</em>内容来源：</label><div class="controls"><div class="control-action clearfix"><div class="left js-link-to link-to"><span class="label label-success">自定义外链</span></div></div></div></div><div class="control-group"><label class="control-label"><em class="required">*</em>链接名称：</label><div class="controls"><input type="text" name="name" value="'+navList[num].name+'"/></div></div><div class="control-group"><label class="control-label"><em class="required">*</em>链接地址：</label><div class="controls"><input type="text" name="url" value="'+navList[num].url+'"/></div></div>';
						}else{
							liContent += '<div class="control-group"><label class="control-label"><em class="required">*</em>内容来源：</label><div class="controls"><div class="control-action clearfix"><div class="left js-link-to link-to"><a href="'+navList[num].url+'" target="_blank" class="new-window link-to-title"><span class="label label-success">'+navList[num].prefix+' <em class="link-to-title-text">'+navList[num].name+'</em></span></a></div><div class="dropdown hover right"><a class="dropdown-toggle" href="javascript:void(0);">修改 <i class="caret"></i></a></div></div></div></div> <div class="control-group"><label class="control-label">显示条数：</label><div class="controls"><select name="number"><option value="1" '+(navList[num].number=='1' ? 'selected="selected"' : '')+'>1条</option><option value="2" '+(navList[num].number=='2' ? 'selected="selected"' : '')+'>2条</option><option value="3" '+(navList[num].number=='3' ? 'selected="selected"' : '')+'>3条</option><option value="4" '+(navList[num].number=='4' ? 'selected="selected"' : '')+'>4条</option><option value="5" '+(navList[num].number=='5' ? 'selected="selected"' : '')+'>5条</option></select></div></div>';
						}
						liContent += '<div class="actions"><span class="action add close-modal" title="添加">+</span><span class="action delete close-modal" title="删除">×</span></div></li>';
					}
					var liHtml  = $(liContent);
					if(navList[num].name != ''){
						liHtml.find('input[name="name"]').blur(function(){
							var navList = domHtml.data('navList');
							navList[liHtml.data('id')].name = $(this).val();
							domHtml.data('navList',navList);
							buildContent();
						});
						liHtml.find('input[name="url"]').blur(function(){
							$(this).val($.trim($(this).val()));
							var navList = domHtml.data('navList');						
							navList[liHtml.data('id')].url = $(this).val();
							buildContent();
						});
						liHtml.find('select[name="number"]').change(function(){
							var navList = domHtml.data('navList');
							navList[liHtml.data('id')].number = parseInt($(this).val());
							domHtml.data('navList',navList);
							buildContent();
						});
					}
				}else{
					var randNumber = getRandNumber();
					navList[randNumber] = {'title':'','prefix':'','url':'','name':''};
					domHtml.data('navList',navList);
					var liHtml = $('<li class="choice" data-id="'+randNumber+'"><div class="control-group"><label class="control-label"><em class="required">*</em>内容来源：</label><div class="controls"><div class="control-action clearfix"><div class="dropdown hover"><a class="js-dropdown-toggle dropdown-toggle" href="javascript:void(0);">设置链接到的页面地址 <i class="caret"></i></a></div></div></div></div><div class="actions"><span class="action add close-modal" title="添加">+</span><span class="action delete close-modal" title="删除">×</span></div></li>');
				}
				var nowDom = liHtml.find('.dropdown');
				link_box(nowDom,['pagecat_only','goodcat_only','link'],function(type,prefix,title,href){
					nowDom.siblings('.js-link-to').remove();
					if(type =='link'){
						var beforeDom = $('<div class="left js-link-to link-to"><span class="label label-success">自定义外链</span></div>');
					}else{
						var beforeDom = $('<div class="left js-link-to link-to"><a href="'+href+'" target="_blank" class="new-window link-to-title"><span class="label label-success">'+prefix+' <em class="link-to-title-text">'+(typeof title=='object' ? title[1] : title)+'</em></span></a></div>');
					}
					var groupDom = nowDom.closest('.control-group');
					groupDom.siblings('.control-group').remove();
					
					nowDom.before(beforeDom);
					if(type =='link'){
						var nextDom1 = $('<div class="control-group"><label class="control-label"><em class="required">*</em>链接名称：</label><div class="controls"><input type="text" name="name" value="'+href+'"/></div></div>');
						var nextDom2 = $('<div class="control-group"><label class="control-label"><em class="required">*</em>链接地址：</label><div class="controls"><input type="text" name="url" value="'+href+'"/></div></div>');
						nextDom1.find('input').blur(function(){
							var navList = domHtml.data('navList');
							navList[liHtml.data('id')].name = $(this).val();
							domHtml.data('navList',navList);
							buildContent();
						});
						nextDom2.find('input').blur(function(){
							$(this).val($.trim($(this).val()));
							var navList = domHtml.data('navList');						
							navList[liHtml.data('id')].url = $(this).val();
							buildContent();
						});
						groupDom.after(nextDom2);
						groupDom.after(nextDom1);
						
						nowDom.remove();
						var navList = domHtml.data('navList');						
						navList[liHtml.data('id')] = {'type':'link','prefix':prefix,'url':href,'name':href};
						domHtml.data('navList',navList);
					}else{
						var nextDom = $('<div class="control-group"><label class="control-label">显示条数：</label><div class="controls"><select name="number"><option value="1">1条</option><option value="2">2条</option><option value="3" selected="selected">3条</option><option value="4">4条</option><option value="5">5条</option></select></div></div>');
						nextDom.find('select').change(function(){
							var navList = domHtml.data('navList');
							navList[liHtml.data('id')].number = parseInt($(this).val());
							domHtml.data('navList',navList);
							buildContent();
						});
						groupDom.after(nextDom);
						nowDom.children('a').attr('class','dropdown-toggle').html('修改 <i class="caret"></i>');
						var navList = domHtml.data('navList');
						navList[liHtml.data('id')] = {'type':'widget','widget':type,'number':3,'prefix':prefix,'url':href,'id':title[0],'name':title[1]};
						domHtml.data('navList',navList);
					}
					buildContent();
				});
				liHtml.find('span.add').click(function(){
					addContent(-1,liHtml);
				});
				liHtml.find('span.delete').click(function(){
					var navList = domHtml.data('navList');
					delete navList[liHtml.data('id')];
					domHtml.data('navList',navList);
					$(this).closest('li.choice').remove();
					buildContent();
				});
				if(dom){
					dom.after(liHtml);
					var navList = domHtml.data('navList');
					var newNavList = [];
					$.each(rightHtml.find('.js-collection-region .ui-sortable > li'),function(i,item){
						newNavList[i] = navList[$(item).data('id')];
						$(item).data('id',i);
					});
					domHtml.data('navList',newNavList);
				}else{
					rightHtml.find('.js-collection-region .ui-sortable').append(liHtml);
				}
				buildContent();
			};
			var buildContent = function(){
				var navList = domHtml.data('navList');
				var html = '';
				for(var i in navList){
					if(navList[i].type == 'link'){
						html += '<li><a class="clearfix" href="javascript:void(0);"><span class="custom-nav-title">'+navList[i].name+'</span><i class="right right-arrow"></i></a></li>';
					}else{
						for(var j=1;j<=navList[i].number;j++){
							html += '<li><a class="clearfix" href="javascript:void(0);"><span class="custom-nav-title">第'+j+'条 '+navList[i].name+' 的『关联链接』</span><i class="right right-arrow"></i></a></li>';
						}
					}
				}
				domHtml.html(html);
			};
			var navList = domHtml.data('navList');
			for(var num in navList){
				addContent(num);
			}
			rightHtml.find('.js-add-option').click(function(){
				addContent(-1);
			});
			
			$('.js-sidebar-region').empty().html(rightHtml);
		};
		clickArr['image_ad'] = function(){
			defaultHtml = '<div class="custom-image-swiper"><div class="swiper-container" style="height:80px"><div class="swiper-wrapper"><img style="max-height:80px;display:block;" src="'+upload_url+'/images/image_ad_demo.jpg"/></div></div></div>';
			domHtml = dom.find('.control-group');
			if(domHtml.html() == '<div class="component-border"></div>'){
				domHtml.prepend(defaultHtml);
				domHtml.data({'navList':[],'type':'0','size':'0','max_height':0,'max_width':0});
			}
			rightHtml = $('<div><form class="form-horizontal"><div class="control-group"><label class="control-label">显示方式：</label><div class="controls"><label class="radio inline"><input type="radio" name="type" value="0"'+(domHtml.data('type')=='0' ? ' checked="checked"' : '')+'/>折叠轮播</label><label class="radio inline"><input type="radio" name="type" value="1"'+(domHtml.data('type')=='1' ? ' checked="checked"' : '')+'/>分开显示</label></div></div><div class="control-group"><label class="control-label">显示大小：</label><div class="controls"><label class="radio inline"><input type="radio" name="size" value="0" '+(domHtml.data('size')=='0' ? ' checked="checked"' : '')+'/>大图</label><label class="radio inline size_1_label" '+(domHtml.data('type')=='0' ? 'style="display:none;"' : '')+'><input type="radio" name="size" value="1"  '+(domHtml.data('size')=='1' ? ' checked="checked"' : '')+'/>小图</label></div></div><div class="control-group js-choices-region"><ul class="choices ui-sortable"></ul></div><div class="control-group options"><a href="javascript:void(0);" class="add-option js-add-option"><i class="icon-add"></i> 添加一个广告</a></div></form></div>');
			rightHtml.find('input[name="type"]').change(function(){
				domHtml.data('type',$(this).val());
				if($(this).val() == '1'){
					rightHtml.find('.size_1_label').show();
				}else{
					domHtml.data('size','0');
					rightHtml.find('input[name="size"][value="0"]').prop('checked',true);
					rightHtml.find('.size_1_label').hide();
				}
				buildContent();
			});
			rightHtml.find('input[name="size"]').change(function(){
				domHtml.data('size',$(this).val());
				buildContent();
			});
			var rightUl = rightHtml.find('.js-choices-region .ui-sortable');
			var addContent = function(num,dom){
				if(num >= 0){
					var navList = domHtml.data('navList');
					var liContent = '<li class="choice" data-id="'+num+'">';
					liContent += '<div class="choice-image">';
					if(navList[num].image){
						liContent += '<img src="'+navList[num].image+'" width="118" height="118" class="thumb-image"/><a class="modify-image js-trigger-image" href="javascript: void(0);">重新上传</a>';
					}else{
						liContent += '<a class="add-image js-trigger-image" href="javascript:void(0);"><i class="icon-add"></i>  添加图片</a>';
					}
					liContent += '</div>';
					liContent += '<div class="choice-content"><div class="control-group"><label class="control-label">文字：</label><div class="controls"><input class="" type="text" name="title" value="'+(navList[num].title!='' ? navList[num].title : '')+'" maxlength="20"/></div></div><div class="control-group"><label class="control-label">链接：</label><div class="control-action clearfix">';
					if(navList[num].name != ''){
						liContent += '<div class="left js-link-to link-to"><a href="'+navList[num].url+'" target="_blank" class="new-window link-to-title"><span class="label label-success">'+navList[num].prefix+' <em class="link-to-title-text">'+navList[num].name+'</em></span></a><a href="javascript:;" class="js-delete-link link-to-title close-modal" title="删除">×</a></div><div class="dropdown hover right"><a class="dropdown-toggle" href="javascript:void(0);">修改 <i class="caret"></i></a></div>';
					}else{
						liContent += '<div class="dropdown hover"><a class="js-dropdown-toggle dropdown-toggle" href="javascript:void(0);">设置链接到的页面地址 <i class="caret"></i></a></div>';
					}
					liContent += '</div></div></div><div class="actions"><span class="action add close-modal" title="添加">+</span><span class="action delete close-modal" title="删除">×</span></div></li>';
					var liHtml = $(liContent);
					if(navList[num].name != ''){
						liHtml.find('.js-delete-link').click(function(){
							var fDom = $(this).closest('.control-action');
							fDom.find('.js-link-to').remove();
							fDom.find('.dropdown').removeClass('right').children('a').attr('class','js-dropdown-toggle dropdown-toggle').html('设置链接到的页面地址 <i class="caret">');
							var navList = domHtml.data('navList');
							navList[liHtml.data('id')] = {'title':titleDom.val(),'prefix':'','url':'','name':''};
							domHtml.data('navList',navList);
						});
					}
				}else{
					var randNumber = getRandNumber();
					var navList = domHtml.data('navList');
					navList[randNumber] = {'title':'','prefix':'','url':'','name':'','image':''};
					domHtml.data('navList',navList);
					var liHtml = $('<li class="choice" data-id="'+randNumber+'"><div class="choice-image"><a class="add-image js-trigger-image" href="javascript: void(0);"><i class="icon-add"></i>  添加图片</a></div><div class="choice-content"><div class="control-group"><label class="control-label">文字：</label><div class="controls"><input type="text" name="title" value="" maxlength="20"/></div></div><div class="control-group"><label class="control-label">链接：</label><div class="control-action clearfix"><div class="dropdown hover"><a class="js-dropdown-toggle dropdown-toggle" href="javascript:void(0);">设置链接到的页面地址 <i class="caret"></i></a></div></div></div></div><div class="actions"><span class="action add close-modal" title="添加">+</span><span class="action delete close-modal" title="删除">×</span></div></li>');
				}
				var titleDom = liHtml.find('input[name="title"]');
				var nowDom = liHtml.find('.dropdown');
				titleDom.blur(function(){
					var navList = domHtml.data('navList');
					navList[liHtml.data('id')].title = titleDom.val();
					domHtml.data('navList',navList);
					buildContent();
				});
				liHtml.find('.js-trigger-image').click(function(){
					var imageDom = $(this);
					upload_pic_box(1,true,function(pic_list){
						if(pic_list.length > 0){
							for(var i in pic_list){
								var image = new Image();
								image.src = pic_list[i];
								image.onload=function(){
									imageDom.siblings('.thumb-image').remove();
									imageDom.removeClass('add-image').addClass('modify-image').html('重新上传').before('<img src="'+pic_list[i]+'" width="118" height="118" class="thumb-image"/>');	
									var navList = domHtml.data('navList');
									if(image.height > domHtml.data('max_height')){
										domHtml.data('max_height',image.height);
									}
									if(image.width > domHtml.data('max_width')){
										domHtml.data('max_width',image.width);
									}
									navList[liHtml.data('id')].image = pic_list[i];
									domHtml.data('navList',navList);
									buildContent();
								}
							}
						}
					},1);
				});
				link_box(nowDom,[],function(type,prefix,title,href){
					nowDom.siblings('.js-link-to').remove();
					var beforeDom = $('<div class="left js-link-to link-to"><a href="'+href+'" target="_blank" class="new-window link-to-title"><span class="label label-success">'+prefix+' <em class="link-to-title-text">'+title+'</em></span></a><a href="javascript:;" class="js-delete-link link-to-title close-modal" title="删除">×</a></div>');
					
					var navList = domHtml.data('navList');
					var liHtmlId = liHtml.data('id');
					navList[liHtmlId].prefix = prefix;
					navList[liHtmlId].url = href;
					navList[liHtmlId].name = title;
					
					beforeDom.find('.js-delete-link').click(function(){
						var fDom = $(this).closest('.control-action');
						fDom.find('.js-link-to').remove();
						fDom.find('.dropdown').removeClass('right').children('a').attr('class','js-dropdown-toggle dropdown-toggle').html('设置链接到的页面地址 <i class="caret">');
						var navList = domHtml.data('navList');
						navList[liHtmlId].prefix = '';
						navList[liHtmlId].url = '';
						navList[liHtmlId].name = '';
						domHtml.data('navList',navList);
					});
					
					domHtml.data('navList',navList);
					buildContent();
					nowDom.before(beforeDom);
					nowDom.addClass('right').children('a').attr('class','dropdown-toggle').html('修改 <i class="caret"></i>');
				});
				liHtml.find('span.add').click(function(){
					addContent(-1,liHtml);
				});
				liHtml.find('span.delete').click(function(){
					var navList = domHtml.data('navList');
					delete navList[liHtml.data('id')];
					domHtml.data('navList',navList);
					$(this).closest('li.choice').remove();
					buildContent();
				});
				if(dom){
					dom.after(liHtml);
					var navList = domHtml.data('navList');
					var newNavList = [];
					$.each(rightHtml.find('.js-collection-region .ui-sortable > li'),function(i,item){
						newNavList[i] = navList[$(item).data('id')];
						$(item).data('id',i);
					});
					domHtml.data('navList',newNavList);
				}else{
					rightUl.append(liHtml);
				}
			};
			var buildContent = function(){
				var navList = domHtml.data('navList');
				if(getObjLength(navList) == 0){
					domHtml.find('.component-border').siblings('div').remove();
					domHtml.prepend(defaultHtml);
				}else{
					var html = '';
					if(domHtml.data('type') == '0'){
						html+= '<div class="custom-image-swiper"><div class="swiper-container" style="height:'+domHtml.data('max_height')+'px"><div class="swiper-wrapper">';
						for(var i in navList){
							html += '<div style="height:'+domHtml.data('max_height')+'px" class="swiper-slide"><a href="javascript:void(0);" style="height:'+domHtml.data('max_height')+'px;">'+(navList[i].title!='' ? '<h3 class="title">'+navList[i].title+'</h3>' : '')+'<img src="'+navList[i].image+'"></a></div>';
						}
						html+= '</div></div></div>';
						if(getObjLength(navList) > 1){
							html+= '<div class="swiper-pagination">';
							var num=0;
							for(var i in navList){
								html += '<span class="swiper-pagination-switch'+(num==0 ? ' swiper-active-switch' :'')+'"></span>';
								num++;
							}
							html+= '</div>';
						}
					}else{
						html+= '<ul class="custom-image clearfix">';
						for(var i in navList){
							html+= '<li'+(domHtml.data('size')=='1' ? ' class="custom-image-small"' : '')+'>'+(navList[i].title!='' ? '<h3 class="title">'+navList[i].title+'</h3>' : '')+'<img src="'+navList[i].image+'"/></li>';
						}
						html+= '</ul>';
					}
					domHtml.html(html);
				}
			};
			var navList = domHtml.data('navList');
			for(var num in navList){
				addContent(num);
			}
			rightHtml.find('.js-add-option').click(function(){
				addContent(-1);
			});
			$('.js-sidebar-region').empty().html(rightHtml);
		};
		//////=====click start =====/////
		clickArr['tpl_shop'] = function(){
			
			//判定左侧是否已经有了
			var defaultTitle = '店铺名xx';
			
			//defaultHtml = '<div class="tpl-shop"><div class="tpl-shop-header" style="background-images:url(/upload/images/head_bg1.png);background-color:#6DABEB"><div class="tpl-shop-title">'+defaultTitle+'</div><div class="tpl-shop-avatar"><img src="/upload/images/default_shop.png" alt=""></div></div><div class="tpl-shop-content"><ul class="clearfix"><li><a href="javascript:;"><span class="count">0</span> <span class="text">全部商品</span></a></li><li><a href="javascript:;"><span class="count">0</span> <span class="text">上新商品</span></a></li><li><a href="javascript:;"><span class="count user"></span> <span class="text">我的订单</span></a></li></ul></div></div>';
			var logos = "";
			
			default_shop = "/upload/images/default_shop.png";
			logos = store_logo?store_logo:default_shop;

			defaultHtml = '<div class="tpl-shop"><div class="tpl-shop-header" style="background-color:#6DABEB"><div class="tpl-shop-title">'+defaultTitle+'</div><div class="tpl-shop-avatar"><img src="'+logos+'" alt=""></div></div><div class="tpl-shop-content"><ul class="clearfix"><li><a href="javascript:;"><span class="count">0</span> <span class="text">全部商品</span></a></li><li><a href="javascript:;"><span class="count">0</span> <span class="text">上新商品</span></a></li><li><a href="javascript:;"><span class="count user"></span> <span class="text">我的订单</span></a></li></ul></div></div>';
			
			if(dom.find('.control-group .tpl-shop').size() == 0){
				domHtml = $('<div class="tpl-shop text-left"></div>');
				domHtml.data({'shop_head_bg_img':'','shop_head_logo_img':'','bgcolor':'','title':''}).html(defaultHtml);
				dom.find('.control-group').prepend(domHtml);
				//取默认数据
				domHtml.data('title',defaultTitle);
				domHtml.data('shop_head_logo_img',logos);
				//domHtml.data('shop_head_bg_img',"/upload/images/head_bg1.png");
				domHtml.data('bgcolor',"#6DABEB");				
			}else{
				domHtml = dom.find('.tpl-shop');
			}
			
			
			rightHtml = $('<div><form class="form-horizontal" novalidate><div class="control-group"><label class="control-label">背景图片：</label><div class="controls"><div class="tpl-shop-header" style="width:320px;background-image:url(/upload/images/head_bg1.png)"><a class="close-modal small hide js-delete-image" data-index="0">×</a></div><a class="control-action js-trigger-image" href="javascript: void(0);">修改</a><p class="help-desc">最佳尺寸：640 x 200 像素。</p><p class="help-desc">尺寸不匹配时，图片将被压缩或拉伸以铺满画面。</p></div></div><div class="control-group"><label class="control-label">背景颜色：</label><div class="controls"><input type="color" value="#ffffff" name="backgroundColor"> <button class="btn js-reset-bg" type="button">重置</button></div></div><div class="control-group"><label class="control-label">店铺名称：</label><div class="controls"><input type="text" name="title" value="" maxlength="100"></div></div><div class="control-group"><label class="control-label">店铺Logo：</label><div class="controls"><img src="'+logos+'" width="80" height="80" class="thumb-image" style="width:80px;height:80px"> <a class="control-action js-trigger-avatar" href="javascript: void(0);">修改店铺Logo</a></div></div></form></div>');
			//右侧 背景图片上传
			rightHtml.find('.js-trigger-image').click(function(){
				var imageDom = $(this);
				upload_pic_box(1,true,function(pic_list){
					if(pic_list.length > 0){
						for(var i in pic_list){
							//替换左侧 背景图和 背景色
							domHtml.find(".tpl-shop-header").css({ "background-color": "#ff0011", "background-image": "url("+pic_list[i]+")" });
							domHtml.data("shop_head_bg_img",pic_list[i]);
							
						}
					}
				},1);
			});
			

			rightHtml.find('input[name="title"]').blur(function(){
				domHtml.data('title',$(this).val()).find('.tpl-shop-title').html(($(this).val().length != 0 ? $(this).val() : defaultTitle));
			});
			
			//背景色
			rightHtml.find('input[name="backgroundColor"]').change(function(){
				domHtml.find(".tpl-shop-header").css('background-color',$(this).val());
				domHtml.data("bgcolor",$(this).val());
			});		
			//右侧 店铺logo图片上传弹层
			/*
			rightHtml.find('.js-trigger-avatar').click(function(){
				var imageDom = $(this);
				upload_logo_box(1,true,function(pic_list){
					if(pic_list.length > 0){
						for(var i in pic_list){
							//imageDom.siblings('.thumb-image').remove();
							//imageDom.removeClass('add-image').addClass('modify-image').html('重新上传').before('<img src="'+pic_list[i]+'" width="118" height="118" class="thumb-image"/>');	
							//替换左侧 背景图和 背景色
						//	domHtml.find(".tpl-shop-header").css({ "background-color": "#ff0011", "background-image": "url("+pic_list[i]+")" });
							
							//var navList = domHtml.data('navList');
							//navList[rightHtml.data('id')].image = pic_list[i];								
						//	domHtml.data('navList',navList);
						//	buildContent();
						}
					}
				},1);
			});
			*/
			rightHtml.find('.js-trigger-avatar').click(function(){
				var imageDom2 = $(this);
				upload_pic_box2(1,true,function(pic_list){
					if(pic_list.length > 0){
						for(var i in pic_list){
							imageDom2.siblings('.thumb-image').remove();
							imageDom2.removeClass('add-image').addClass('modify-image').html('重新上传').before('<img src="'+pic_list[i]+'" width="80" height="80" class="thumb-image"/>');	
							//替换左侧 小logo
							domHtml.find(".tpl-shop-avatar img").attr("src",pic_list[i]);
							domHtml.data("shop_head_logo_img",pic_list[i]);
							logos = pic_list[i];
						}
					}
				},1);
			});			
			////////////////////////////////////////////
			//右侧 小图
			//var shop_head_logo_img_data = domHtml.data('shop_head_logo_img');
			var shop_head_logo_img_data = logos;
			var html = '';
			if(shop_head_logo_img_data) {
				html= '<img src="'+shop_head_logo_img_data+'" width="80" height="80" class="thumb-image"/>';
				rightHtml.find('.js-trigger-avatar').siblings('.thumb-image').remove();
				rightHtml.find('.js-trigger-avatar').removeClass('add-image').addClass('modify-image').html('重新上传').before(html);					
			}
			//右侧背景图
			var shop_head_bg_img_data = domHtml.data('shop_head_bg_img');
			var html = '';
			if(shop_head_bg_img_data) {
				rightHtml.find('.tpl-shop-header').css({height:"0px"});
				rightHtml.find('.tpl-shop-header').css({height: "90px", "background-image": "url("+shop_head_bg_img_data+")" });
			}			
			//标题
			var title_data = domHtml.data('title');
			var html = '';
			if(title_data) {
				rightHtml.find("input[name='title']").val(title_data);
			}				
			//背景色
			var bgcolor_data = domHtml.data('bgcolor');
			var html = '';
			if(bgcolor_data) {
				rightHtml.find("input[name='backgroundColor']").val(bgcolor_data);
			}	
			////////////////////////////////////////////
			var timepicker = rightHtml.find('.js-time-holder');
			timepicker.datetimepicker({
				dateFormat: "yy-mm-dd",
				timeFormat: "HH:mm",
				minDate: new Date,
				changeMonth:true,
				changeYear:true,
				onSelect: function(e){
					timepicker.siblings('input[name="sub_title"]').val(e).trigger('blur');
				}
			});
			rightHtml.find('a.js-time').click(function(){
				timepicker.datepicker('show');
			});
			
			rightHtml.find('input[name="show_method"]').change(function(){
				domHtml.data('show_method',$(this).val());
				switch($(this).val()){
					case '0':
						domHtml.removeClass('text-center text-right').addClass('text-left');
						break;
					case '1':
						domHtml.removeClass('text-left text-right').addClass('text-center');
						break;
					default:
						domHtml.removeClass('text-left text-center').addClass('text-right');
				}
			});
			
			rightHtml.find('.js-reset-bg').click(function(){
				$(this).siblings('input[name="color"]').val('#ffffff');
				domHtml.css('background-color','').data('bgcolor','');
			});
			
			$('.js-sidebar-region form').remove();
			$('.js-sidebar-region').empty().html(rightHtml);
		};
		//////=====click end =====/////
		//////=====click1 start =====/////
		clickArr['tpl_shop1'] = function(){
			var defaultTitle = '店铺名xx';
			var logos = "";
			default_shop = "/upload/images/moren_head.jpg";
			logos = store_logo?store_logo:default_shop;
			
		//defaultHtml = '<div class="tpl-shop1 tpl-wxd"> <div class="tpl-wxd-header" style="background-image: url(/upload/images/tpl_wxd_bg.png)"><div class="tpl-wxd-title">"</div><div class="tpl-wxd-avatar"><img src="/upload/images/moren_head.jpg" alt=""></div> </div></div>';
		defaultHtml = '<div class="tpl-shop1 tpl-wxd"> <div class="tpl-wxd-header" style="background-color:#FF6600" ><div class="tpl-wxd-title">"</div><div class="tpl-wxd-avatar"><img src="'+logos+'" alt=""></div> </div></div>';
			
			if(dom.find('.control-group .tpl-shop1').size() == 0){
				domHtml = $('<div class="tpl-shop1 text-left"></div>');
				domHtml.data({'shop_head_bg_img':'','shop_head_logo_img':'','bgcolor':'','title':''}).html(defaultHtml);
				dom.find('.control-group').prepend(domHtml);
				//标题(店铺名字)
				domHtml.data('title',defaultTitle);
				domHtml.data('shop_head_logo_img',logos);
				domHtml.data('shop_head_bg_img',"/upload/images/tpl_wxd_bg.png");
				domHtml.data('bgcolor',"#FF6600");				
			}else{
				domHtml = dom.find('.tpl-shop1');
			}

			//beijing
			
			rightHtml = $('<div><form class="form-horizontal" novalidate><div class="control-group"><label class="control-label">背景图片：</label><div class="controls"><div class="tpl-shop-header" style="width:320px;background-image:url(/upload/images/head_bg1.png)"><a class="close-modal small hide js-delete-image" data-index="0">×</a></div><a class="control-action js-trigger-image" href="javascript: void(0);">修改</a><p class="help-desc">最佳尺寸：640 x 200 像素。</p><p class="help-desc">尺寸不匹配时，图片将被压缩或拉伸以铺满画面。</p></div></div><div class="control-group"><label class="control-label">背景颜色：</label><div class="controls"><input type="color" value="#ffffff" name="backgroundColor"> <button class="btn js-reset-bg" type="button">重置</button></div></div><div class="control-group"><label class="control-label">店铺名称：</label><div class="controls"><input type="text" name="title" value="" maxlength="100"></div></div><div class="control-group"><label class="control-label">店铺Logo：</label><div class="controls"><img src="/upload/images/default_shop.png" width="80" height="80" class="thumb-image" style="width:80px;height:80px"> <a class="control-action js-trigger-avatar" href="javascript: void(0);">修改店铺Logo</a></div></div></form></div>');
			//右侧 背景图片上传
			rightHtml.find('.js-trigger-image').click(function(){
				var imageDom = $(this);
				upload_pic_box(1,true,function(pic_list){
					if(pic_list.length > 0){
						for(var i in pic_list){
							//imageDom.siblings('.thumb-image').remove();
							//imageDom.removeClass('add-image').addClass('modify-image').html('重新上传').before('<img src="'+pic_list[i]+'" width="118" height="118" class="thumb-image"/>');	
							//替换左侧 背景图和 背景色
							domHtml.find(".tpl-wxd-header").css({ "background-color": "#ff0011", "background-image": "url("+pic_list[i]+")" });
							domHtml.data("shop_head_bg_img",pic_list[i]);
							
							//替换右侧 背景图
							rightHtml.find('.tpl-shop-header').css({height:"0px"});
							rightHtml.find('.tpl-shop-header').css({height: "90px", "background-image": "url("+pic_list[i]+")" });				
						}
					}
				},1);
			});
			//背景色
			rightHtml.find('input[name="backgroundColor"]').change(function(){
				domHtml.find(".tpl-wxd-header").css('background-color',$(this).val());
				domHtml.data("bgcolor",$(this).val());
			});		

			
			//标题 店铺名字
			//domHtml.data('title',defaultTitle);
			rightHtml.find('input[name="title"]').blur(function(){
				domHtml.data('title',$(this).val()).find('.tpl-wxd-title').html(($(this).val().length != 0 ? $(this).val() : defaultTitle));
			});
			
			
			rightHtml.find('.js-trigger-avatar').click(function(){
				var imageDom2 = $(this);
				upload_pic_box2(1,true,function(pic_list){
					if(pic_list.length > 0){
						for(var i in pic_list){
							imageDom2.siblings('.thumb-image').remove();
							imageDom2.removeClass('add-image').addClass('modify-image').html('重新上传').before('<img src="'+pic_list[i]+'" width="80" height="80" class="thumb-image"/>');	
							//替换左侧 小logo
							domHtml.find(".tpl-wxd-avatar img").attr("src",pic_list[i]);
							domHtml.data("shop_head_logo_img",pic_list[i]);
							
							logos = pic_list[i];

						}
					}
				},1);
			});			
			
			////////////////////////////////////////////
			//右侧 小图
			//var shop_head_logo_img_data = domHtml.data('shop_head_logo_img');
			var shop_head_logo_img_data = logos;
			var html = '';
			if(shop_head_logo_img_data) {
				html= '<img src="'+shop_head_logo_img_data+'" width="80" height="80" class="thumb-image"/>';
				rightHtml.find('.js-trigger-avatar').siblings('.thumb-image').remove();
				rightHtml.find('.js-trigger-avatar').removeClass('add-image').addClass('modify-image').html('重新上传').before(html);					
			}
			//右侧背景图
			var shop_head_bg_img_data = domHtml.data('shop_head_bg_img');
			if(shop_head_bg_img_data) {
				rightHtml.find('.tpl-shop-header').css({height:"0px"});
				rightHtml.find('.tpl-shop-header').css({height: "90px", "background-image": "url("+shop_head_bg_img_data+")" });
			}			
			//标题
			var title_data = domHtml.data('title');
			if(title_data) {
				rightHtml.find("input[name='title']").val(title_data);
			}				
			//背景色
			var bgcolor_data = domHtml.data('bgcolor');
			if(bgcolor_data) {
				rightHtml.find("input[name='backgroundColor']").val(bgcolor_data);
			}	
			////////////////////////////////////////////
			
			var timepicker = rightHtml.find('.js-time-holder');
			timepicker.datetimepicker({
				dateFormat: "yy-mm-dd",
				timeFormat: "HH:mm",
				minDate: new Date,
				changeMonth:true,
				changeYear:true,
				onSelect: function(e){
					timepicker.siblings('input[name="sub_title"]').val(e).trigger('blur');
				}
			});
			rightHtml.find('a.js-time').click(function(){
				timepicker.datepicker('show');
			});
			
			rightHtml.find('input[name="show_method"]').change(function(){
				domHtml.data('show_method',$(this).val());
				switch($(this).val()){
					case '0':
						domHtml.removeClass('text-center text-right').addClass('text-left');
						break;
					case '1':
						domHtml.removeClass('text-left text-right').addClass('text-center');
						break;
					default:
						domHtml.removeClass('text-left text-center').addClass('text-right');
				}
			});
			

			rightHtml.find('.js-reset-bg').click(function(){
				$(this).siblings('input[name="color"]').val('#ffffff');
				domHtml.css('background-color','').data('bgcolor','');
			});
			
			$('.js-sidebar-region form').remove();
			$('.js-sidebar-region').empty().html(rightHtml);
		};
		//////=====click1 end =====/////		
		clickArr['coupons']=function(){	
		rightHtml=$('<div><form class="form-horizontal edit-custom-coupon" novalidate="" onsubmit="return false"><div class="control-group"><label class="control-label">优惠券：</label><div class="controls"><ul class="coupon-list"></ul><a href="javascript:;" class="control-action js-add-coupon js-add-goods">添加优惠券</a><input type="hidden" name="coupon"></div></div></form></div>');
			$('.js-sidebar-region').empty().html(rightHtml);

			widget_link_yhq(rightHtml.find('.js-add-goods'),'coupon',function(result){
				var coupon_data = domHtml.data('coupon_data');
				if(coupon_data){
					if (coupon_data.coupon_arr != undefined) {
						$.merge(coupon_data.coupon_arr,result);	
					} else {
						$.merge(coupon_data,result);
					}
				}else{
					coupon_data = result;
				}

				domHtml.data('coupon_data',coupon_data);
				var html='';
				if (coupon_data.coupon_arr != undefined) {
					for(var i in coupon_data.coupon_arr){//alert(coupon_data.coupon_arr[i].face_money);
						html+='<li>  <a href="javascript:;"><div class="custom-coupon-price"><span>￥</span>'+coupon_data.coupon_arr[i].face_money+'</div><div class="custom-coupon-desc">'+coupon_data.coupon_arr[i]['condition']+'</div>  </a> </li>';
					}
				} else {
					for(var i in coupon_data){//alert(coupon_data.coupon_arr[i].face_money);
						html+='<li>  <a href="javascript:;"><div class="custom-coupon-price"><span>￥</span>'+coupon_data[i].face_money+'</div><div class="custom-coupon-desc">'+coupon_data[i]['condition']+'</div>  </a> </li>';
					}
				}
				domHtml.html(html);
			})
				
			var defaultHtml='<li><a href="javascript:;"><div class="custom-coupon-price"><span>￥</span>100</div><div class="custom-coupon-desc">满500元可用</div></a></li><li><a href="javascript:;"><div class="custom-coupon-price"><span>￥</span>100</div><div class="custom-coupon-desc">满500元可用</div></a></li><li><a href="javascript:;"><div class="custom-coupon-price"><span>￥</span>100</div><div class="custom-coupon-desc">满500元可用</div></a></li>';
			if(dom.find('.control-group .custom-coupon').size()==0){
				domHtml = $('<ul class="custom-coupon clearfix"></ul>');
				domHtml.html(defaultHtml).data({'coupons_arr':[],'type':'goods'});;
				dom.find('.control-group').prepend(domHtml);
			}else{
				domHtml = dom.find('.custom-coupon');
				var obj = domHtml.data('coupon_data');
				var defaultHtml = '';
				for(var i in obj.coupon_arr){
					defaultHtml += '<li><a href="javascript:;"><div class="custom-coupon-price"><span>￥</span>'+obj.coupon_arr[i]['face_money']+'</div><div class="custom-coupon-desc"> '+obj.coupon_arr[i]['condition']+'</div>  </a> </li>';
				}
				domHtml.html(defaultHtml);
			}
			
			
		}
	
		clickArr['goods_group1']=function(){
			var rightHtml=$('<div><form class="form-horizontal" novalidate=""><div class="control-group options js-add-subentry" style="display: block;"><a class="add-option js-add-option" href="javascript:void(0);"><i class="icon-add"></i> 添加商品分组</a></div><div class="control-group"><p class="app-component-desc help-desc">选择商品来源后，左侧实时预览暂不支持显示其包含的商品数据</p></div></form></div>');
			if(dom.find('.control-group .goods_group1').size()==0){
				domHtml = $('<ul class="goods_group1 clearfix"></ul>');
				domHtml.data({'goods_group1_arr':[]});
				dom.find('.control-group').prepend(domHtml);
				var defaultHtml='<div class="custom-tag-list clearfix"><div class="custom-tag-list-menu-block js-collection-region" style="min-height: 323px;"><ul class="custom-tag-list-side-menu"><li><a href="javascript:;" class="current">商品组一</a><a href="javascript:;">商品组二</a><a href="javascript:;">商品组三</a></li></ul></div><div class="custom-tag-list-goods"><ul class="custom-tag-list-goods-list"><li class="custom-tag-list-single-goods clearfix"><div class="custom-tag-list-goods-img"><img src="/upload/images/kd5.jpg" style="display: inline;"></div><div class="custom-tag-list-goods-detail"><p class="custom-tag-list-goods-title">此处显示商品名称</p><span class="custom-tag-list-goods-price">￥100.00</span><a class="custom-tag-list-goods-buy" href="javascript:void(0)"><span></span></a></div></li><li class="custom-tag-list-single-goods clearfix"><div class="custom-tag-list-goods-img"><img src="upload/images/kd1.jpg" style="display: inline;"></div><div class="custom-tag-list-goods-detail"><p class="custom-tag-list-goods-title">此处显示商品名称</p><span class="custom-tag-list-goods-price">￥100.00</span><a class="custom-tag-list-goods-buy" href="javascript:void(0)"><span></span></a></div></li><li class="custom-tag-list-single-goods clearfix"><div class="custom-tag-list-goods-img"><img src="/upload/images/kd7.jpg" style="display: inline;"></div><div class="custom-tag-list-goods-detail"><p class="custom-tag-list-goods-title">此处显示商品名称</p><span class="custom-tag-list-goods-price">￥100.00</span><a class="custom-tag-list-goods-buy" href="javascript:void(0)"><span></span></a></div></li><li class="custom-tag-list-single-goods clearfix"><div class="custom-tag-list-goods-img"><img src="/upload/images/kd4.jpg" style="display: inline;"></div><div class="custom-tag-list-goods-detail"><p class="custom-tag-list-goods-title">此处显示商品名称</p><span class="custom-tag-list-goods-price">￥100.00</span><a class="custom-tag-list-goods-buy" href="javascript:void(0)"><span></span></a></div></li></ul></div></div>';
			}else{
				domHtml = dom.find('.control-group .goods_group1');
			}
			
			var goods_group1_arr = domHtml.data('goods_group1_arr');
			var html='';
			for(var i in goods_group1_arr){
				html+='<li class="choice"  data-id="'+goods_group1_arr[i].id+'"><div class="edit-tag-list"><div class="tag-source"><div class="control-group"><label class="control-label pull-left">商品来源：</label><div class="controls pull-left"><a href="#" target="_blank" class="tag-title new-window">'+goods_group1_arr[i].title+'</a><input type="hidden" name="title"></div></div></div><div class="split-line"></div><div class="goods-number"><span>显示商品数量</span><div class="dropdown hover pull-right"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">'+(goods_group1_arr[i].show_num?goods_group1_arr[i].show_num:10)+' <i class="caret"></i></a><ul class="dropdown-menu" role="menu"><li><a class="js-goods-number" data-value="5" href="javascript:void(0);">5</a></li><li><a class="js-goods-number" data-value="10" href="javascript:void(0);">10</a></li><li><a class="js-goods-number" data-value="15" href="javascript:void(0);">15</a></li><li><a class="js-goods-number" data-value="30" href="javascript:void(0);">30</a></li></ul></div></div></div><div class="actions"><span class="action delete close-modal" title="删除">×</span></div></li>';
			}
			
			
			rightHtml.find('.form-horizontal .js-add-subentry').prepend(html);


			//上传商品
			widget_link_box(rightHtml.find('.js-add-option'),'goodcat',function(result){
				var goods_group1_arr = domHtml.data('goods_group1_arr');
				if(goods_group1_arr){
					//alert(1);
					$.merge(goods_group1_arr,result);
				}else{
					//alert(2);
					goods_group1_arr = result;
				}
				

				domHtml.data('goods_group1_arr',goods_group1_arr);
				rightHtml.find('.module-goods-list .sort').remove();

				
				var html = '';
				var shtml='';

				for(var i in goods_group1_arr){
					html+='<li class="choice"  data-id="'+goods_group1_arr[i].id+'"><div class="edit-tag-list"><div class="tag-source"><div class="control-group"><label class="control-label pull-left">商品来源：</label><div class="controls pull-left"><a href="#" target="_blank" class="tag-title new-window">'+goods_group1_arr[i].title+'</a><input type="hidden" name="title"></div></div></div><div class="split-line"></div><div class="goods-number"><span>显示商品数量</span><div class="dropdown hover pull-right"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">'+(goods_group1_arr[i].show_num?goods_group1_arr[i].show_num:10)+' <i class="caret"></i></a><ul class="dropdown-menu" role="menu"><li><a class="js-goods-number" data-value="5" href="javascript:void(0);">5</a></li><li><a class="js-goods-number" data-value="10" href="javascript:void(0);">10</a></li><li><a class="js-goods-number" data-value="15" href="javascript:void(0);">15</a></li><li><a class="js-goods-number" data-value="30" href="javascript:void(0);">30</a></li></ul></div></div></div><div class="actions"><span class="action delete close-modal" title="删除">×</span></div></li>';
					shtml+='<li data-title="'+goods_group1_arr[i]["title"]+'" id="'+goods_group1_arr[i]["id"]+'"><a href="javascript:;"><span>'+goods_group1_arr[i]["title"]+'</span></a></li>';
				}

				$('.custom-tag-list-side-menu').empty().html(shtml);
			//rightHtml.find('.form-horizontal .js-add-subentry').empty().prepend(html);
			rightHtml.find('.form-horizontal .js-add-subentry li').remove();
			rightHtml.find('.form-horizontal .js-add-subentry').prepend(html);
			rightHtml.find('.delete').click(function(){
				var dataId = $(this).parents('.choice').attr('data-id');
				
				for(var i in goods_group1_arr){
					if(goods_group1_arr[i].id==dataId){
						delete goods_group1_arr[i];
					}
				}
				domHtml.data('goods_group1_arr',goods_group1_arr);
				$(this).parents('.choice').remove();
			});
			
			rightHtml.find('.dropdown').toggle(function(){
				$(this).find('.dropdown-menu').show();
			},function(){
				$(this).find('.dropdown-menu').hide();
			});
			
			rightHtml.find('.dropdown-menu li').each(function(){
				$(this).click(function(){
					var selVal=$(this).find('a').attr('data-value');
					$(this).parents('.dropdown').find('.dropdown-toggle').html(selVal+'<i class="caret"></i>');
					var dataId = $(this).parents('.choice').attr('data-id');
					for(var i in goods_group1_arr){
					if(goods_group1_arr[i].id==dataId){
						goods_group1_arr[i]['show_num']=selVal;
					}
				}
				});
			});
			
			});
			rightHtml.find('.delete').click(function(){
				var dataId = $(this).parents('.choice').attr('data-id');
				
				for(var i in goods_group1_arr){
					if(goods_group1_arr[i].id==dataId){
						delete goods_group1_arr[i];
					}
				}
				domHtml.data('goods_group1_arr',goods_group1_arr);
				$(this).parents('.choice').remove();
			});
			
			rightHtml.find('.dropdown').toggle(function(){
				$(this).find('.dropdown-menu').show();
			},function(){
				$(this).find('.dropdown-menu').hide();
			});
			
			rightHtml.find('.dropdown-menu li').each(function(){
				$(this).click(function(){
					var selVal=$(this).find('a').attr('data-value');
					$(this).parents('.dropdown').find('.dropdown-toggle').html(selVal+'<i class="caret"></i>');
					var dataId = $(this).parents('.choice').attr('data-id');
					for(var i in goods_group1_arr){
					if(goods_group1_arr[i].id==dataId){
						goods_group1_arr[i]['show_num']=selVal;
					}
				}
				});
			});

			$('.js-sidebar-region').empty().html(rightHtml);
			domHtml.html(defaultHtml);
		}

		
clickArr['goods_group2']=function(){//alert(66);
			if(dom.find('.control-group .sc-goods-list').size() == 0){
				domHtml = dom.find('.control-group');
				domHtml.html('<ul class="sc-goods-list clearfix size-2 card pic"></ul>').data({'goods':[],'size':'2','size_type':'0','buy_btn':'1','buy_btn_type':'1','show_title':'0','price':'1'});
			}else{
				domHtml = dom.find('.control-group');
			}
			
			rightHtml = $('<div><div class="form-horizontal"><div class="js-meta-region" style="margin-bottom:20px;"><div><div class="control-group"><label class="control-label">选择商品分组：</label><div class="controls"><ul class="module-goods-list clearfix ui-sortable" name="goods"><li><a href="javascript:void(0);" class="js-add-goods add-goods"><i class="icon-add"></i></a></li></ul></div></div><div class="control-group"><label class="control-label">列表样式：</label><div class="controls"><label class="radio inline"><input type="radio" name="size" value="0"/>大图</label><label class="radio inline"><input type="radio" name="size" value="1"/>小图</label><label class="radio inline"><input type="radio" name="size" value="2"/>一大两小</label><label class="radio inline"><input type="radio" name="size" value="3"/>详细列表</label></div></div><div class="control-group"></div></div></div></div></div>');
			
			var good_data = domHtml.data('goods');

			var html = '';
			for(var i in good_data){
				var item = good_data[i];
				html+= '<li class="choice">'+item.title+'<a class="close-modal js-delete-goods small hide" data-id="'+i+'" title="删除">×</a></li>';
			}
			rightHtml.find('.module-goods-list').prepend(html);
			rightHtml.find('.module-goods-list .sort .js-delete-goods').click(function(){
				$(this).closest('.sort').remove();
				var good_data = domHtml.data('goods');
				delete good_data[$(this).data('id')];
				domHtml.data('goods',good_data);
			});

			//上传商品

			widget_link_box(rightHtml.find('.js-add-goods'),'goodcat',function(result){
				//alert(domHtml.data('goods'))
				var good_data = domHtml.data('goods');
				if(good_data){
					$.merge(good_data,result);
				}else{
					good_data = result;
				}
				domHtml.data('goods',good_data);
				rightHtml.find('.module-goods-list .sort').remove();
				var html = '';
				for(var i in good_data){
					var item = good_data[i];
					html+= '<li class="sort">'+item.title+'<a class="close-modal js-delete-goods small hide" data-id="'+i+'" title="删除">×</a></li>';
				}
				rightHtml.find('.module-goods-list').prepend(html);
				rightHtml.find('.module-goods-list .sort .js-delete-goods').click(function(){
					$(this).closest('.sort').remove();
					var good_data = domHtml.data('goods');
					delete good_data[$(this).data('id')];
					domHtml.data('goods',good_data);
				});
			});
			//列表样式
			rightHtml.find('input[name="size"]').change(function(){
				domHtml.data('size',$(this).val());
				switch($(this).val()){
					case '0':
						$(this).closest('.control-group').next().replaceWith('<div class="control-group"><div class="controls"><div class="controls-card"><div class="controls-card-tab"><label class="radio inline"><input type="radio" name="size_type" value="0"/>卡片样式</label><label class="radio inline"><input type="radio" name="size_type" value="2"/>极简样式</label></div><div class="controls-card-item"><div><label class="checkbox inline"><input type="checkbox" name="buy_btn" value="1" />显示购买按钮</label></div><div style="margin:10px 0 0 20px;"><label class="radio inline"><input type="radio" name="buy_btn_type" value="1" />样式1</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="2"/>样式2</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="3"/>样式3</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="4"/>样式4</label></div></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="show_title" value="1"/>显示商品名</label></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="price" value="1"/>显示价格</label></div></div></div></div>');
						if(domHtml.data('size_type') != '0' && domHtml.data('size_type') != '2'){
							domHtml.data('size_type','0');
						}
						break;
					case '1':
						$(this).closest('.control-group').next().replaceWith('<div class="control-group"><div class="controls"><div class="controls-card"><div class="controls-card-tab"><label class="radio inline"><input type="radio" name="size_type" value="0"/>卡片样式</label><label class="radio inline"><input type="radio" name="size_type" value="1"/>瀑布流</label><label class="radio inline"><input type="radio" name="size_type" value="2"/>极简样式</label></div><div class="controls-card-item"><div><label class="checkbox inline"><input type="checkbox" name="buy_btn" value="1" />显示购买按钮</label></div><div style="margin:10px 0 0 20px;"><label class="radio inline"><input type="radio" name="buy_btn_type" value="1" />样式1</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="2"/>样式2</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="3"/>样式3</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="4"/>样式4</label></div></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="show_title" value="1"/>显示商品名</label></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="price" value="1"/>显示价格</label></div></div></div></div>');
						break;
					case '2':
						$(this).closest('.control-group').next().replaceWith('<div class="control-group"><div class="controls"><div class="controls-card"><div class="controls-card-tab"><label class="radio inline"><input type="radio" name="size_type" value="0"/>卡片样式</label><label class="radio inline"><input type="radio" name="size_type" value="2"/>极简样式</label></div><div class="controls-card-item"><div><label class="checkbox inline"><input type="checkbox" name="buy_btn" value="1" />显示购买按钮</label></div><div style="margin:10px 0 0 20px;"><label class="radio inline"><input type="radio" name="buy_btn_type" value="1" />样式1</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="2"/>样式2</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="3"/>样式3</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="4"/>样式4</label></div></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="show_title" value="1"/>显示商品名 (小图不显示名称)</label></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="price" value="1"/>显示价格</label></div></div></div></div>');
						if(domHtml.data('size_type') != '0' && domHtml.data('size_type') != '2'){
							domHtml.data('size_type','0');
						}
						break;
					case '3':
						$(this).closest('.control-group').next().replaceWith('<div class="control-group"><div class="controls"><div class="controls-card"><div class="controls-card-tab"><label class="radio inline"><input type="radio" name="size_type" value="0"/>卡片样式</label><label class="radio inline"><input type="radio" name="size_type" value="2"/>极简样式</label></div><div class="controls-card-item"><div><label class="checkbox inline"><input type="checkbox" name="buy_btn" value="1" />显示购买按钮</label></div><div style="margin:10px 0 0 20px;"><label class="radio inline"><input type="radio" name="buy_btn_type" value="1" />样式1</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="2"/>样式2</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="3"/>样式3</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="4"/>样式4</label></div></div></div></div></div>');
						if(domHtml.data('size_type') != '0' && domHtml.data('size_type') != '2'){
							domHtml.data('size_type','0');
						}
						break;
				}

				rightHtml.find('input[name="size_type"][value="'+domHtml.data('size_type')+'"]').prop('checked',true);
				
				if(domHtml.data('buy_btn') != '1'){
					rightHtml.find('input[name="buy_btn"]').closest('div').next().remove();
				}else{
					rightHtml.find('input[name="buy_btn"]').prop('checked',true);
					rightHtml.find('input[name="buy_btn_type"][value="'+domHtml.data('buy_btn_type')+'"]').prop('checked',true);
				}
				
				rightHtml.find('input[name="show_title"]').prop('checked',(domHtml.data('show_title') == '1' ? true : false));
				rightHtml.find('input[name="price"]').prop('checked',(domHtml.data('price') == '1' ? true : false));
				
				//列表样式属性
				rightHtml.find('input[name="size_type"]').change(function(){
					domHtml.data('size_type',$(this).val());
					if(domHtml.data('size') != '3'){
						if($(this).val() == '2'){
							$(this).closest('.controls-card-tab').next().hide();
						}else{
							$(this).closest('.controls-card-tab').next().show();
						}
					}else{
						if($(this).val() == '2'){
							if(domHtml.data('buy_btn_type') == '3'){
								domHtml.data('buy_btn_type','1');
								rightHtml.find('input[name="buy_btn_type"][value="1"]').prop('checked',true);
							}
							rightHtml.find('input[name="buy_btn_type"][value="3"]').closest('label').hide();
						}else{
							rightHtml.find('input[name="buy_btn_type"][value="3"]').closest('label').show();
						}
					}
					changeStyleContent();
				});
				rightHtml.find('input[name="buy_btn"]').change(function(){
					if($(this).prop('checked')){
						$(this).closest('div').next().show();
						domHtml.data('buy_btn','1');
					}else{
						$(this).closest('div').next().hide();
						domHtml.data('buy_btn','0');
					}
					changeStyleContent();
				});
				rightHtml.find('input[name="buy_btn_type"]').change(function(){
					domHtml.data('buy_btn_type',$(this).val());
					changeStyleContent();
				});
				
				rightHtml.find('input[name="show_title"]').change(function(){
					domHtml.data('show_title',$(this).prop('checked') ? '1' : '0');
					changeStyleContent();
				});
				rightHtml.find('input[name="price"]').change(function(){
					domHtml.data('price',$(this).prop('checked') ? '1' : '0');
					changeStyleContent();
				});
				
				changeStyleContent();
			}).each(function(i,item){
				if($(item).val() == domHtml.data('size')){
					$(item).prop('checked',true).change();
				}
			});
			
			function changeStyleContent(){
				var html = '';
				switch(domHtml.data('size')){
					case '0':
						switch(domHtml.data('size_type')){
							case '0':
								html  = '<ul class="sc-goods-list clearfix size-2 card pic"><li class="goods-card big-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card big-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card big-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li></ul>';
								break;
							case '2':
								html = '<ul class="sc-goods-list clearfix size-2 normal pic"><li class="goods-card big-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card big-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card big-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li></ul>';
								break;
						}
						break;
					case '1':
						switch(domHtml.data('size_type')){
							case '0':
								html  = '<ul class="sc-goods-list clearfix size-1 card pic"><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/third_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥32.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li></ul>';
								break;
							case '1':
								html  = '<ul class="sc-goods-list clearfix size-1 waterfall pic">';
									html += '<li class="sc-waterfall-half clearfix">';
										html += '<ul class="clearfix">';
											html += '<li class="goods-card goods-list small-pic waterfall"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg" style="height:145px;"/></div>';
											if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
												html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
											}
											if(domHtml.data('buy_btn') == '1'){
												html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
											}
											html += '</a></li>';
											html += '<li class="goods-card goods-list small-pic waterfall"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/third_demo_goods.jpg" style="height:205px;"/></div>';
											if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
												html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥32.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
											}
											if(domHtml.data('buy_btn') == '1'){
												html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
											}
											html += '</a></li>';
										html += '</ul>';
									html += '</li>';
									html += '<li class="sc-waterfall-half clearfix">';
										html += '<ul class="clearfix">';
											html += '<li class="goods-card goods-list small-pic waterfall"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg" style="height:155px;"/></div>';
											if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
												html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
											}
											if(domHtml.data('buy_btn') == '1'){
												html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
											}
											html += '</a></li>';
											html += '<li class="goods-card goods-list small-pic waterfall"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg" style="height:175px;"/></div>';
											if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
												html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
											}
											if(domHtml.data('buy_btn') == '1'){
												html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
											}
											html += '</a></li>';
										html += '</ul>';
									html += '</li>';
								html += '</ul>';
								break;
							case '2':
								html  = '<ul class="sc-goods-list clearfix size-1 normal pic"><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div>';
								if(domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div>';
								if(domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/third_demo_goods.jpg"/></div>';
								if(domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥32.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div>';
								if(domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li></ul>';
								break;
						}
						break;
					case '2':
						switch(domHtml.data('size_type')){
							case '0':
								html  = '<ul class="sc-goods-list clearfix size-2 card pic"><li class="goods-card big-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li></ul>';
								break;
							case '2':
								html  = '<ul class="sc-goods-list clearfix size-2 normal pic"><li class="goods-card big-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div>';
								if(domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div>';
								if(domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li></ul>';
								break;
						}
						break;
					case '3':
						switch(domHtml.data('size_type')){
							case '0':
								html  = '<ul class="sc-goods-list clearfix size-3 card list"><li class="goods-card card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p>';
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</div>';
								html += '</a></li><li class="goods-card card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p>';
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</div>';
								html += '</a></li><li class="goods-card card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p>';
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</div>';
								html += '</a></li></ul>';
								break;
							case '2':
								html  = '<ul class="sc-goods-list clearfix size-3 normal list"><li class="goods-card normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p>';
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</div>';
								html += '</a></li><li class="goods-card normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p>';
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</div>';
								html += '</a></li><li class="goods-card normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p>';
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</div>';
								html += '</a></li></ul>';
								break;
						}
						break;
				}
				domHtml.find('.sc-goods-list').replaceWith(html);
			}
			
			$('.js-sidebar-region').empty().html(rightHtml);
		}
		
		clickArr['goods'] = function(){
			if(dom.find('.control-group .sc-goods-list').size() == 0){
				domHtml = dom.find('.control-group');
				domHtml.html('<ul class="sc-goods-list clearfix size-2 card pic"></ul>').data({'goods':[],'size':'2','size_type':'0','buy_btn':'1','buy_btn_type':'1','show_title':'0','price':'1'});
			}else{
				domHtml = dom.find('.control-group');
			}
			
			rightHtml = $('<div><div class="form-horizontal"><div class="js-meta-region" style="margin-bottom:20px;"><div><div class="control-group"><label class="control-label">选择商品：</label><div class="controls"><ul class="module-goods-list clearfix ui-sortable" name="goods"><li><a href="javascript:void(0);" class="js-add-goods add-goods"><i class="icon-add"></i></a></li></ul></div></div><div class="control-group"><label class="control-label">列表样式：</label><div class="controls"><label class="radio inline"><input type="radio" name="size" value="0"/>大图</label><label class="radio inline"><input type="radio" name="size" value="1"/>小图</label><label class="radio inline"><input type="radio" name="size" value="2"/>一大两小</label><label class="radio inline"><input type="radio" name="size" value="3"/>详细列表</label></div></div><div class="control-group"></div></div></div></div></div>');
			
			var good_data = domHtml.data('goods');

			var html = '';
			for(var i in good_data){
				var item = good_data[i];
				html+= '<li class="sort"><a href="'+item.url+'" target="_blank"><img src="'+item.image+'" alt="'+item.title+'" title="'+item.title+'" width="50" height="50"></a><a class="close-modal js-delete-goods small hide" data-id="'+i+'" title="删除">×</a></li>';
				
			}
			rightHtml.find('.module-goods-list').prepend(html);
			rightHtml.find('.module-goods-list .sort .js-delete-goods').click(function(){
				$(this).closest('.sort').remove();
				var good_data = domHtml.data('goods');
				delete good_data[$(this).data('id')];
				domHtml.data('goods',good_data);
			});

			//上传商品

			widget_link_box(rightHtml.find('.js-add-goods'),'good',function(result){
				var good_data = domHtml.data('goods');
				if(good_data){
					$.merge(good_data,result);
				}else{
					good_data = result;
				}
				domHtml.data('goods',good_data);
				rightHtml.find('.module-goods-list .sort').remove();
				var html = '';
				for(var i in good_data){
					var item = good_data[i];
					html+= '<li class="sort"><a href="'+item.url+'" target="_blank"><img src="'+item.image+'" alt="'+item.title+'" title="'+item.title+'" width="50" height="50"></a><a class="close-modal js-delete-goods small hide" data-id="'+i+'" title="删除">×</a></li>';
				}
				rightHtml.find('.module-goods-list').prepend(html);
				rightHtml.find('.module-goods-list .sort .js-delete-goods').click(function(){
					$(this).closest('.sort').remove();
					var good_data = domHtml.data('goods');
					delete good_data[$(this).data('id')];
					domHtml.data('goods',good_data);
				});
			});
			//列表样式
			rightHtml.find('input[name="size"]').change(function(){
				domHtml.data('size',$(this).val());
				switch($(this).val()){
					case '0':
						$(this).closest('.control-group').next().replaceWith('<div class="control-group"><div class="controls"><div class="controls-card"><div class="controls-card-tab"><label class="radio inline"><input type="radio" name="size_type" value="0"/>卡片样式</label><label class="radio inline"><input type="radio" name="size_type" value="2"/>极简样式</label></div><div class="controls-card-item"><div><label class="checkbox inline"><input type="checkbox" name="buy_btn" value="1" />显示购买按钮</label></div><div style="margin:10px 0 0 20px;"><label class="radio inline"><input type="radio" name="buy_btn_type" value="1" />样式1</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="2"/>样式2</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="3"/>样式3</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="4"/>样式4</label></div></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="show_title" value="1"/>显示商品名</label></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="price" value="1"/>显示价格</label></div></div></div></div>');
						if(domHtml.data('size_type') != '0' && domHtml.data('size_type') != '2'){
							domHtml.data('size_type','0');
						}
						break;
					case '1':
						$(this).closest('.control-group').next().replaceWith('<div class="control-group"><div class="controls"><div class="controls-card"><div class="controls-card-tab"><label class="radio inline"><input type="radio" name="size_type" value="0"/>卡片样式</label><label class="radio inline"><input type="radio" name="size_type" value="1"/>瀑布流</label><label class="radio inline"><input type="radio" name="size_type" value="2"/>极简样式</label></div><div class="controls-card-item"><div><label class="checkbox inline"><input type="checkbox" name="buy_btn" value="1" />显示购买按钮</label></div><div style="margin:10px 0 0 20px;"><label class="radio inline"><input type="radio" name="buy_btn_type" value="1" />样式1</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="2"/>样式2</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="3"/>样式3</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="4"/>样式4</label></div></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="show_title" value="1"/>显示商品名</label></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="price" value="1"/>显示价格</label></div></div></div></div>');
						break;
					case '2':
						$(this).closest('.control-group').next().replaceWith('<div class="control-group"><div class="controls"><div class="controls-card"><div class="controls-card-tab"><label class="radio inline"><input type="radio" name="size_type" value="0"/>卡片样式</label><label class="radio inline"><input type="radio" name="size_type" value="2"/>极简样式</label></div><div class="controls-card-item"><div><label class="checkbox inline"><input type="checkbox" name="buy_btn" value="1" />显示购买按钮</label></div><div style="margin:10px 0 0 20px;"><label class="radio inline"><input type="radio" name="buy_btn_type" value="1" />样式1</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="2"/>样式2</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="3"/>样式3</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="4"/>样式4</label></div></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="show_title" value="1"/>显示商品名 (小图不显示名称)</label></div><div class="controls-card-item"><label class="checkbox inline"><input type="checkbox" name="price" value="1"/>显示价格</label></div></div></div></div>');
						if(domHtml.data('size_type') != '0' && domHtml.data('size_type') != '2'){
							domHtml.data('size_type','0');
						}
						break;
					case '3':
						$(this).closest('.control-group').next().replaceWith('<div class="control-group"><div class="controls"><div class="controls-card"><div class="controls-card-tab"><label class="radio inline"><input type="radio" name="size_type" value="0"/>卡片样式</label><label class="radio inline"><input type="radio" name="size_type" value="2"/>极简样式</label></div><div class="controls-card-item"><div><label class="checkbox inline"><input type="checkbox" name="buy_btn" value="1" />显示购买按钮</label></div><div style="margin:10px 0 0 20px;"><label class="radio inline"><input type="radio" name="buy_btn_type" value="1" />样式1</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="2"/>样式2</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="3"/>样式3</label><label class="radio inline"><input type="radio" name="buy_btn_type" value="4"/>样式4</label></div></div></div></div></div>');
						if(domHtml.data('size_type') != '0' && domHtml.data('size_type') != '2'){
							domHtml.data('size_type','0');
						}
						break;
				}
				rightHtml.find('input[name="size_type"][value="'+domHtml.data('size_type')+'"]').prop('checked',true);
				
				if(domHtml.data('buy_btn') != '1'){
					rightHtml.find('input[name="buy_btn"]').closest('div').next().remove();
				}else{
					rightHtml.find('input[name="buy_btn"]').prop('checked',true);
					rightHtml.find('input[name="buy_btn_type"][value="'+domHtml.data('buy_btn_type')+'"]').prop('checked',true);
				}
				
				rightHtml.find('input[name="show_title"]').prop('checked',(domHtml.data('show_title') == '1' ? true : false));
				rightHtml.find('input[name="price"]').prop('checked',(domHtml.data('price') == '1' ? true : false));
				
				//列表样式属性
				rightHtml.find('input[name="size_type"]').change(function(){
					domHtml.data('size_type',$(this).val());
					if(domHtml.data('size') != '3'){
						if($(this).val() == '2'){
							$(this).closest('.controls-card-tab').next().hide();
						}else{
							$(this).closest('.controls-card-tab').next().show();
						}
					}else{
						if($(this).val() == '2'){
							if(domHtml.data('buy_btn_type') == '3'){
								domHtml.data('buy_btn_type','1');
								rightHtml.find('input[name="buy_btn_type"][value="1"]').prop('checked',true);
							}
							rightHtml.find('input[name="buy_btn_type"][value="3"]').closest('label').hide();
						}else{
							rightHtml.find('input[name="buy_btn_type"][value="3"]').closest('label').show();
						}
					}
					changeStyleContent();
				});
				rightHtml.find('input[name="buy_btn"]').change(function(){
					if($(this).prop('checked')){
						$(this).closest('div').next().show();
						domHtml.data('buy_btn','1');
					}else{
						$(this).closest('div').next().hide();
						domHtml.data('buy_btn','0');
					}
					changeStyleContent();
				});
				rightHtml.find('input[name="buy_btn_type"]').change(function(){
					domHtml.data('buy_btn_type',$(this).val());
					changeStyleContent();
				});
				
				rightHtml.find('input[name="show_title"]').change(function(){
					domHtml.data('show_title',$(this).prop('checked') ? '1' : '0');
					changeStyleContent();
				});
				rightHtml.find('input[name="price"]').change(function(){
					domHtml.data('price',$(this).prop('checked') ? '1' : '0');
					changeStyleContent();
				});
				
				changeStyleContent();
			}).each(function(i,item){
				if($(item).val() == domHtml.data('size')){
					$(item).prop('checked',true).change();
				}
			});
			
			function changeStyleContent(){
				var html = '';
				switch(domHtml.data('size')){
					case '0':
						switch(domHtml.data('size_type')){
							case '0':
								html  = '<ul class="sc-goods-list clearfix size-2 card pic"><li class="goods-card big-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card big-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card big-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li></ul>';
								break;
							case '2':
								html = '<ul class="sc-goods-list clearfix size-2 normal pic"><li class="goods-card big-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card big-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card big-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li></ul>';
								break;
						}
						break;
					case '1':
						switch(domHtml.data('size_type')){
							case '0':
								html  = '<ul class="sc-goods-list clearfix size-1 card pic"><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/third_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥32.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li></ul>';
								break;
							case '1':
								html  = '<ul class="sc-goods-list clearfix size-1 waterfall pic">';
									html += '<li class="sc-waterfall-half clearfix">';
										html += '<ul class="clearfix">';
											html += '<li class="goods-card goods-list small-pic waterfall"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg" style="height:145px;"/></div>';
											if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
												html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
											}
											if(domHtml.data('buy_btn') == '1'){
												html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
											}
											html += '</a></li>';
											html += '<li class="goods-card goods-list small-pic waterfall"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/third_demo_goods.jpg" style="height:205px;"/></div>';
											if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
												html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥32.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
											}
											if(domHtml.data('buy_btn') == '1'){
												html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
											}
											html += '</a></li>';
										html += '</ul>';
									html += '</li>';
									html += '<li class="sc-waterfall-half clearfix">';
										html += '<ul class="clearfix">';
											html += '<li class="goods-card goods-list small-pic waterfall"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg" style="height:155px;"/></div>';
											if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
												html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
											}
											if(domHtml.data('buy_btn') == '1'){
												html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
											}
											html += '</a></li>';
											html += '<li class="goods-card goods-list small-pic waterfall"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg" style="height:175px;"/></div>';
											if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
												html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
											}
											if(domHtml.data('buy_btn') == '1'){
												html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
											}
											html += '</a></li>';
										html += '</ul>';
									html += '</li>';
								html += '</ul>';
								break;
							case '2':
								html  = '<ul class="sc-goods-list clearfix size-1 normal pic"><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div>';
								if(domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div>';
								if(domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/third_demo_goods.jpg"/></div>';
								if(domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥32.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div>';
								if(domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li></ul>';
								break;
						}
						break;
					case '2':
						switch(domHtml.data('size_type')){
							case '0':
								html  = '<ul class="sc-goods-list clearfix size-2 card pic"><li class="goods-card big-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li><li class="goods-card small-pic card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</a></li></ul>';
								break;
							case '2':
								html  = '<ul class="sc-goods-list clearfix size-2 normal pic"><li class="goods-card big-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div>';
								if(domHtml.data('show_title') == '1' || domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+' '+(domHtml.data('price')=='1' ? 'info-price' : 'info-no-price')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>379.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div>';
								if(domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>5.50</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li><li class="goods-card small-pic normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div>';
								if(domHtml.data('price') == '1'){
									html += '<div class="info clearfix '+(domHtml.data('show_title') == '0' ? 'info-no-title' : '')+'"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>60.00</em>' : '')+'</p><p class="goods-price-taobao"></p></div>';
								}
								html += '</a></li></ul>';
								break;
						}
						break;
					case '3':
						switch(domHtml.data('size_type')){
							case '0':
								html  = '<ul class="sc-goods-list clearfix size-3 card list"><li class="goods-card card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p>';
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</div>';
								html += '</a></li><li class="goods-card card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p>';
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</div>';
								html += '</a></li><li class="goods-card card"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p>';
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</div>';
								html += '</a></li></ul>';
								break;
							case '2':
								html  = '<ul class="sc-goods-list clearfix size-3 normal list"><li class="goods-card normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/first_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥379.00</em>' : '')+'</p><p class="goods-price-taobao"></p>';
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</div>';
								html += '</a></li><li class="goods-card normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/two_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥5.50</em>' : '')+'</p><p class="goods-price-taobao"></p>';
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</div>';
								html += '</a></li><li class="goods-card normal"><a href="javascript:void(0);" class="link js-goods clearfix"><div class="photo-block"><img class="goods-photo js-goods-lazy" src="/upload/images/n_demo_goods.jpg"/></div><div class="info"><p class="goods-title">此处显示商品名称</p><p class="goods-price goods-price-icon">'+(domHtml.data('price')=='1' ? '<em>￥60.00</em>' : '')+'</p><p class="goods-price-taobao"></p>';
								if(domHtml.data('buy_btn') == '1'){
									html += '<div class="goods-buy btn'+domHtml.data('buy_btn_type')+'"></div>';
								}
								html += '</div>';
								html += '</a></li></ul>';
								break;
						}
						break;
				}
				domHtml.find('.sc-goods-list').replaceWith(html);
			}
			
			$('.js-sidebar-region').empty().html(rightHtml);
		};
			
		$('.app-sidebar').css('margin-top',dom.offset().top - $('.app-preview').offset().top);
		var fieldType = dom.data('field-type');
		clickArr[fieldType]();
	},
	setEvent:function(obj){
		var clickArr=[];
		var show_deletes="";

		
		if(obj.field_type == 'tpl_shop' || obj.field_type == 'tpl_shop1') {
			if(is_adminuser) {
				show_deletes = '<span class="action delete">删除</span>';
			}
			var app_field = $('<div class="app-field clearfix"><div class="control-group"><div class="component-border"></div></div><div class="actions"><div class="actions-wrap"><span class="action edit">编辑</span><span class="action add">加内容</span>'+show_deletes+'</div></div><div class="sort"><i class="sort-handler"></i></div></div>');
			
		} else {
			var app_field = $('<div class="app-field clearfix"><div class="control-group"><div class="component-border"></div></div><div class="actions"><div class="actions-wrap"><span class="action edit">编辑</span><span class="action add">加内容</span><span class="action delete">删除</span></div></div><div class="sort"><i class="sort-handler"></i></div></div>');
			
		}
		app_field.data('field-type',obj.field_type);
		
		
		
		clickArr['rich_text'] = function(){
			var defaultHtml = '<p>点此编辑『富文本』内容 ——&gt;</p><p>你可以对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、文字<span style="color:rgb(0,176,240);">颜色</span>、<span style="background-color:rgb(255,192,0);color:rgb(255,255,255);">背景色</span>、以及字号<span style="font-size:20px;">大</span><span style="font-size:14px;">小</span>等简单排版操作。</p><p>还可以在这里加入表格了</p><table><tr><td width="93" valign="top" style="word-break:break-all;">中奖客户</td><td width="93" valign="top" style="word-break:break-all;">发放奖品</td><td width="93" valign="top" style="word-break: break-all;">备注</td></tr><tr><td width="93" valign="top" style="word-break:break-all;">猪猪</td><td width="93" valign="top" style="word-break: break-all;">内测码</td><td width="93" valign="top" style="word-break:break-all;"><em><span style="color: rgb(255, 0, 0);">已经发放</span></em></td></tr><tr><td width="93" valign="top" style="word-break:break-all;">大麦</td><td width="93" valign="top" style="word-break:break-all;">积分</td><td width="93" valign="top" style="word-break: break-all;"><a href="javascript: void(0);" target="_blank">领取地址</a></td></tr></table><p style="text-align:left;"><span style="text-align:left;">也可在这里插入图片、并对图片加上超级链接，方便用户点击。</span></p>';
			
			domHtml = $('<div class="custom-richtext"></div>');
			
			if(obj.content.content){
				domHtml.html(obj.content.content).data('has_amend','1');
			}else{
				domHtml.html(defaultHtml).data('has_amend','0');
			}
			if(obj.content.bgcolor){
				domHtml.css('background-color',obj.content.bgcolor).data('bgcolor',obj.content.bgcolor);
			}else{
				domHtml.data('bgcolor','');
			}
			if(obj.content.screen){
				domHtml.addClass('custom-richtext-fullscreen').data('fullscreen','1');
			}else{
				domHtml.data('fullscreen','0');
			}
			app_field.find('.control-group').prepend(domHtml);
		};
		clickArr['notice'] = function(){
			var content = '';
			if(typeof obj.content.content != 'undefined'){
				content = obj.content.content;
			}
			app_field.find('.control-group').prepend('<div class="custom-notice"><div class="custom-notice-inner"><div class="custom-notice-scroll"><span>公告：' + content + '</span></div></div></div>');
			app_field.find('.custom-notice').data('content',content);
		};
		clickArr['title'] = function(){
			var content = '<div class="custom-title text-left"><h2 class="title">' + (obj.content.title ? obj.content.title : '') + '</h2>';
			content += '<p class="sub_title">' + (obj.content.sub_title ? obj.content.sub_title : '') + '</p>';
			content += '</div>';
			app_field.find('.control-group').prepend(content);
			app_field.find('.custom-title').data({'title':(obj.content.title ? obj.content.title : ''),'sub_title':(obj.content.sub_title ? obj.content.sub_title : ''),'show_method':(obj.content.show_method ? obj.content.show_method : ''),'bgcolor':(obj.content.bgcolor ? obj.content.bgcolor : '')});
			if(obj.content.bgcolor){
				app_field.find('.custom-title').css('background-color',obj.content.bgcolor);
			}
		};
		clickArr['tpl_shop'] = function(){
                    	var bg1 = "";
                    	if(obj.content.bgcolor){
                    		bg1 += "background-color:"+obj.content.bgcolor+";";
                    	}
						
					//	alert(obj.content.bgcolor)
                    	if(obj.content.shop_head_bg_img) {
                    		 bg1 += "background-image:url("+obj.content.shop_head_bg_img+");";
                    	} else {
                    		 //bg1 += "background-image: url(/upload/images/head_bg1.png);";
                    	}
                    	var imgs="";
                    	if(obj.content.shop_head_logo_img) {
                    		//imgs = obj.content.shop_head_logo_img;
								//读取店铺logo
								imgs = store_logo?store_logo:obj.content.shop_head_logo_img;	
                    	} else {
								imgs = "/upload/images/default_shop.png";
								//读取店铺logo
								imgs = store_logo?store_logo:"/upload/images/default_shop.png";
                    	}   
						
                    	var content = '<div class="custom-title text-left"><div class="tpl-shop">';
                    	 content += '		<div class="tpl-shop-header" style="'+bg1+'">';
                    	 content += '		<div class="tpl-shop-title">'+obj.content.title+'</div>';
                    	 content += '		<div class="tpl-shop-avatar"><img width="80" height="80" src="'+imgs+'" alt=""></div></div>';
                    	 content += '	<div class="tpl-shop-content">';
                    	 content += '<ul class="clearfix"><li><a href="javascript:;"><span class="count">0</span> <span class="text">全部商品</span></a></li><li><a href="javascript:;"><span class="count">0</span> <span class="text">上新商品</span></a></li><li><a href="javascript:;"><span class="count user"></span> <span class="text">我的订单</span></a></li></ul>';
                    	 content += '</div></div></div><div class="component-border"></div>';			
						 app_field.find('.control-group').prepend(content);
						 
						 app_field.find('.tpl-shop').data({'bgcolor':(obj.content.bgcolor ? obj.content.bgcolor : ''),'title':(obj.content.title ? obj.content.title : ''),'shop_head_bg_img':(obj.content.shop_head_bg_img ? obj.content.shop_head_bg_img : ''),'shop_head_logo_img':(obj.content.shop_head_logo_img ? obj.content.shop_head_logo_img : '')});
						 if(obj.content.bgcolor){
							 if(!obj.content.shop_head_bg_img) {
								app_field.find('.tpl-shop-header').css('background-color',obj.content.bgcolor);
							}
						 }			

			/***************/
			
			
		};		
		//头部模版2
		clickArr['tpl_shop1'] = function(){
                    	var bg1 = "";
                    	if(obj.content.bgcolor){
                    		bg1 += "background-color:"+obj.content.bgcolor+";";
                    	}
						
						//alert(obj.content.bgcolor)
                    	if(obj.content.shop_head_bg_img) {
                    		 bg1 += "background-image:url("+obj.content.shop_head_bg_img+");";
                    	} else {
                    		 //bg1 += "background-image: url(/upload/images/tpl_wxd_bg.png);";
                    	}
                    	var imgs="";
                    	if(obj.content.shop_head_logo_img) {
                    		imgs = obj.content.shop_head_logo_img;
                    	} else {
                    		imgs = "/upload/images/moren_head.jpg";
                    	}   

						 var content  = '<div class="tpl-shop1 tpl-wxd"> ';
						   content += '<div class="tpl-wxd-header" style="'+bg1+'">';;
						   content += '<div class="tpl-wxd-title">'+obj.content.title+'</div>';
						   content += '<div class="tpl-wxd-avatar"><img src="'+imgs+'" alt=""></div> </div>';
						   content += '</div>';
			
						 
						 app_field.find('.control-group').prepend(content);
						 
						 app_field.find('.tpl-shop1').data({'bgcolor':(obj.content.bgcolor ? obj.content.bgcolor : ''),'title':(obj.content.title ? obj.content.title : ''),'shop_head_bg_img':(obj.content.shop_head_bg_img ? obj.content.shop_head_bg_img : ''),'shop_head_logo_img':(obj.content.shop_head_logo_img ? obj.content.shop_head_logo_img : '')});
						 if(obj.content.bgcolor){
							  if(!obj.content.shop_head_bg_img) {
									app_field.find('.tpl-wxd-header').css('background-color',obj.content.bgcolor);
							  }
						 }			

			/***************/
			
			
		};				
		clickArr['line'] = function(){
			app_field.find('.control-group').prepend('<div class="custom-line-wrap"><hr class="custom-line"/></div>');
		};
		clickArr['white'] = function(){
			app_field.find('.control-group').prepend('<div class="custom-white text-center" style="height:'+obj.content.height+'px;"></div>');
			app_field.find('.custom-white').data({'left':obj.content.left,'height':obj.content.height});
		};
		clickArr['search'] = function(){
			app_field.find('.control-group').prepend('<div class="custom-search"><form action="/" method="GET"><input type="text" class="custom-search-input" placeholder="商品搜索：请输入商品关键字" disabled=""/><button type="submit" class="custom-search-button">搜索</button></form></div>');
		};
		clickArr['store'] = function(){
			app_field.find('.control-group').prepend('<div class="custom-store"><a class="custom-store-link clearfix" href="javascript:;"><div class="custom-store-img"></div><div class="custom-store-name">店铺名称</div><div class="custom-store-enter">进入店铺</div></a></div>');
		};
		clickArr['text_nav'] = function(){
			var html = '<ul class="custom-nav clearfix">';
			for(var i in obj.content){
				html += '<li><a class="clearfix" href="javascript:void(0);"><span class="custom-nav-title">'+obj.content[i].title+'</span><i class="right right-arrow"></i></a></li>';
			}
			html += '</ul>';
			app_field.find('.control-group').prepend(html);
			app_field.find('.custom-nav').data('navList',obj.content);
		};
		clickArr['image_nav'] = function(){
			var html = '<ul class="custom-nav-4 clearfix">';
			for(var i in obj.content){
				obj.content[i].image = obj.content[i].image!='' ? obj.content[i].image : '';
				html += '<li><span class="nav-img-wap">'+ (obj.content[i].image!='' ? '<img src="'+obj.content[i].image+'"/>' : '&nbsp;')+'</span>'+ (obj.content[i].title!='' ? '<span class="title">'+obj.content[i].title+'</span>' : '')+'</li>';
			}
			html += '</ul>';
			app_field.find('.control-group').prepend(html);
			app_field.find('.custom-nav-4').data('navList',obj.content);
		};
		clickArr['component'] = function(){
			var domHtml = $('<div class="custom-richtext" style="padding-bottom:10px;">'+obj.content.name+'</div>');
			domHtml.data({'name':obj.content.name,'id':obj.content.id,'url':obj.content.url});
			app_field.find('.control-group').prepend(domHtml);
		};
		clickArr['link'] = function(){
			var html = '<ul class="custom-nav clearfix">';
			for(var i in obj.content){
				if(obj.content[i].type == 'link'){
					html += '<li><a class="clearfix" href="javascript:void(0);"><span class="custom-nav-title">'+obj.content[i].name+'</span><i class="right right-arrow"></i></a></li>';
				}else{
					for(var j=1;j<=obj.content[i].number;j++){
						html += '<li><a class="clearfix" href="javascript:void(0);"><span class="custom-nav-title">第'+j+'条 '+obj.content[i].name+' 的『关联链接』</span><i class="right right-arrow"></i></a></li>';
					}
				}
			}
			html += '</ul>';
			app_field.find('.control-group').prepend(html);
			app_field.find('.custom-nav').data('navList',obj.content);
		};
		clickArr['image_ad'] = function(){
			var html = '';
			if(getObjLength(obj.content.nav_list) == 0){
				html += '<div class="custom-image-swiper"><div class="swiper-container" style="height: 80px"><div class="swiper-wrapper"><img style="max-height:80px;display:block;" src="'+upload_url+'/images/image_ad_demo.jpg"/></div></div></div>';
				obj.content.nav_list = {};
			}else{
				if(!obj.content.image_type){
					obj.content.image_type = 0;
				}
				if(!obj.content.image_size){
					obj.content.image_size = 0;
				}
				var html = '';
				if(obj.content.image_type == '0'){
					html+= '<div class="custom-image-swiper"><div class="swiper-container" style="height:'+obj.content.max_height+'px"><div class="swiper-wrapper">';
					for(var i in obj.content.nav_list){
						obj.content.nav_list[i].image = obj.content.nav_list[i].image!='' ? obj.content.nav_list[i].image : '';
						html += '<div style="height:'+obj.content.max_height+'px" class="swiper-slide"><a href="javascript:void(0);" style="height:'+obj.content.max_height+'px;">'+(obj.content.nav_list[i].title!='' ? '<h3 class="title">'+obj.content.nav_list[i].title+'</h3>' : '')+'<img src="'+obj.content.nav_list[i].image+'" style="max-height:'+obj.content.max_height+'px;"/></a></div>';
					}
					html+= '</div></div></div>';
					if(getObjLength(obj.content.nav_list) > 1){
						html+= '<div class="swiper-pagination">';
						var num=0;
						for(var i in obj.content.nav_list){
							html += '<span class="swiper-pagination-switch'+(num==0 ? ' swiper-active-switch' :'')+'"></span>';
							num++;
						}
						html+= '</div>';
					}
				}else{
					html+= '<ul class="custom-image clearfix">';
					for(var i in obj.content.nav_list){
						//obj.content.nav_list[i].image = obj.content.nav_list[i].image!='' ? './upload/'+obj.content.nav_list[i].image : '';
						obj.content.nav_list[i].image = obj.content.nav_list[i].image!='' ? obj.content.nav_list[i].image : '';
						html+= '<li'+(obj.content.image_size=='1' ? ' class="custom-image-small"' : '')+'>'+(obj.content.nav_list[i].title!='' ? '<h3 class="title">'+obj.content.nav_list[i].title+'</h3>' : '')+'<img src="'+obj.content.nav_list[i].image+'"/></li>';
					}
					html+= '</ul>';
				}
			}
			app_field.find('.control-group').prepend(html).data({'navList':obj.content.nav_list,'type':(obj.content.image_type ? obj.content.image_type : 0),'size':(obj.content.image_size ? obj.content.image_size : 0),'max_height':(obj.content.max_height ? obj.content.max_height : 0),'max_width':(obj.content.max_width ? obj.content.max_width : 0)});
		};
		clickArr['goods_group1'] = function(){
			var html='<ul class="goods_group1 clearfix"><div class="custom-tag-list clearfix"><div class="custom-tag-list-menu-block js-collection-region" style="min-height: 323px;"><ul class="custom-tag-list-side-menu"><li>';

			for(var i in obj.content.goods_group1){

				html+='<a href="javascript:;" class="current">'+obj.content.goods_group1[i].title+'</a>';	
			}
			html += '</li></ul></div><div class="custom-tag-list-goods"><ul class="custom-tag-list-goods-list"><li class="custom-tag-list-single-goods clearfix"><div class="custom-tag-list-goods-img"><img src="/upload/images/kd5.jpg" style="display: inline;"></div><div class="custom-tag-list-goods-detail"><p class="custom-tag-list-goods-title">此处显示商品名称</p><span class="custom-tag-list-goods-price">￥100.00</span><a class="custom-tag-list-goods-buy" href="javascript:void(0)"><span></span></a></div></li><li class="custom-tag-list-single-goods clearfix"><div class="custom-tag-list-goods-img"><img src="/upload/images/kd1.jpg" style="display: inline;"></div><div class="custom-tag-list-goods-detail"><p class="custom-tag-list-goods-title">此处显示商品名称</p><span class="custom-tag-list-goods-price">￥100.00</span><a class="custom-tag-list-goods-buy" href="javascript:void(0)"><span></span></a></div></li><li class="custom-tag-list-single-goods clearfix"><div class="custom-tag-list-goods-img"><img src="/upload/images/kd7.jpg" style="display: inline;"></div><div class="custom-tag-list-goods-detail"><p class="custom-tag-list-goods-title">此处显示商品名称</p><span class="custom-tag-list-goods-price">￥100.00</span><a class="custom-tag-list-goods-buy" href="javascript:void(0)"><span></span></a></div></li><li class="custom-tag-list-single-goods clearfix"><div class="custom-tag-list-goods-img"><img src="/upload/images/kd4.jpg" style="display: inline;"></div><div class="custom-tag-list-goods-detail"><p class="custom-tag-list-goods-title">此处显示商品名称</p><span class="custom-tag-list-goods-price">￥100.00</span><a class="custom-tag-list-goods-buy" href="javascript:void(0)"><span></span></a></div></li></ul></div></div></ul>';
			app_field.find('.control-group').prepend(html);

			app_field.find('.control-group > .goods_group1').data('goods_group1_arr',obj.content.goods_group1);
		}

clickArr['goods_group2'] = function(){
			if(obj.content.goods){
				for(var i in obj.content.goods){
					obj.content.goods[i].image = obj.content.goods[i].image;
				}
			}
			//此处给已经添加的商品赋值给data
			app_field.find('.control-group').html('<ul class="sc-goods-list clearfix size-2 card pic"></ul>').data({'goods':obj.content.goods,'size':(obj.content.size ? obj.content.size : '0'),'size_type':(obj.content.size_type ? obj.content.size_type : '0'),'buy_btn':(obj.content.buy_btn ? obj.content.buy_btn : '0'),'buy_btn_type':(obj.content.buy_btn_type ? obj.content.buy_btn_type : '0'),'show_title':(obj.content.show_title ? obj.content.show_title : '0'),'price':(obj.content.price ? obj.content.price : '0')});
			customField.clickEvent(app_field);
			app_field.removeClass('editing');
			$('.js-config-region .app-field').eq(0).trigger('click');
		}
/*		clickArr['title'] = function(){
			var content = '<div class="custom-title text-left"><h2 class="title">' + (obj.content.title ? obj.content.title : '') + '</h2>';
			content += '<p class="sub_title">' + (obj.content.sub_title ? obj.content.sub_title : '') + '</p>';
			content += '</div>';
			app_field.find('.control-group').prepend(content);
			app_field.find('.custom-title').data({'title':(obj.content.title ? obj.content.title : ''),'sub_title':(obj.content.sub_title ? obj.content.sub_title : ''),'show_method':(obj.content.show_method ? obj.content.show_method : ''),'bgcolor':(obj.content.bgcolor ? obj.content.bgcolor : '')});
			if(obj.content.bgcolor){
				app_field.find('.custom-title').css('background-color',obj.content.bgcolor);
			}
		};	
*/
		clickArr['title3'] = function(){
			var content = '<div class="custom-title text-left"><h2 class="title">' + (obj.content.title ? obj.content.title : '') + '</h2>';
			content += '<p class="sub_title">' + (obj.content.sub_title ? obj.content.sub_title : '') + '</p>';
			content += '</div>';
			app_field.find('.control-group').prepend(content);
			app_field.find('.custom-title').data({'title':(obj.content.title ? obj.content.title : ''),'sub_title':(obj.content.sub_title ? obj.content.sub_title : ''),'show_method':(obj.content.show_method ? obj.content.show_method : ''),'bgcolor':(obj.content.bgcolor ? obj.content.bgcolor : '')});
			if(obj.content.bgcolor){
				app_field.find('.custom-title').css('background-color',obj.content.bgcolor);
			}
		};			
		clickArr['coupons']=function(){
			/*console.log(obj.content.coupon_arr);
			return false;*/
			/*if(obj.content.coupon_arr){
				var html='<ul class="custom-coupon  clearfix">';
			for(var i in obj.content.coupon_arr){
					html+='<li><a href="javascript:;"><div class="custom-coupon-price"><span>￥</span>'+obj.content.coupon_arr[i]['face_money']+'</div><div class="custom-coupon-desc"> '+obj.content.coupon_arr[i]['condition']+'</div>  </a> </li>';	*/
					//app_field.find('.control-group').data({'id':obj.content.coupon_arr[i]['id'],'face_money':(obj.content.coupon_arr[i]['face_money'] ? obj.content.coupon_arr[i]['face_money'] : '0'),'condition':(obj.content.coupon_arr[i]['condition']?obj.content.coupon_arr[i]['condition']:'')});
					app_field.find('.control-group').empty()
					app_field.find('.control-group').html('<ul class="custom-coupon clearfix"></ul>')
					app_field.find('.control-group > .custom-coupon').data('coupon_data', {'coupon_arr':obj.content.coupon_arr});
		
			/*}
			html+='</ul></div><div class="actions"><div class="actions-wrap"><span class="action edit">编辑</span><span class="action add">加内容</span><span class="action delete">删除</span></div></div><div class="sort"><i class="sort-handler"></i></div>';
				
			
			}
			//alert(obj2String(obj.content.coupon_arr));
			app_field.find('.control-group').empty().prepend(html);
			app_field.find('.control-group .custom-coupon').data('coupons_data',obj.content.coupon_arr);
			customField.clickEvent(app_field);
			*/
			//app_field.removeClass('editing');
			//$('.js-config-region .app-field').eq(0).trigger('click');
			customField.clickEvent(app_field);
			app_field.removeClass('editing');
			$('.js-config-region .app-field').eq(0).trigger('click');
		}
		/*clickArr['goods'] = function(){
			if(obj.content.goods){
				for(var i in obj.content.goods){
					obj.content.goods[i].image = obj.content.goods[i].image;
				}
			}
			//此处给已经添加的商品赋值给data
			app_field.find('.control-group').html('<ul class="sc-goods-list clearfix size-2 card pic"></ul>').data({'goods':obj.content.goods,'size':(obj.content.size ? obj.content.size : '0'),'size_type':(obj.content.size_type ? obj.content.size_type : '0'),'buy_btn':(obj.content.buy_btn ? obj.content.buy_btn : '0'),'buy_btn_type':(obj.content.buy_btn_type ? obj.content.buy_btn_type : '0'),'show_title':(obj.content.show_title ? obj.content.show_title : '0'),'price':(obj.content.price ? obj.content.price : '0')});
			customField.clickEvent(app_field);
			app_field.removeClass('editing');
			$('.js-config-region .app-field').eq(0).trigger('click');
		};*/
		
	/*
		clickArr['coupons']=function(){
			var html = '';
			for(var i in obj.content.coupon_arr){
					html+='<li><a href="javascript:;"><div class="custom-coupon-price"><span>￥</span>'+obj.content.coupon_arr[i]['face_money']+'</div><div class="custom-coupon-desc"> '+obj.content.coupon_arr[i]['condition']+'</div>  </a> </li>';	
			}
			app_field.find('.control-group').html('<ul class="custom-coupon clearfix"></ul>').data({'coupons':obj.content.coupon_arr,'title':(obj.content.title ? obj.content.title : ''),'face_money':(obj.content.face_money ? obj.content.face_money : '0')}).append(html);
			return false;
			customField.clickEvent(app_field);
			app_field.removeClass('editing');
			$('.js-config-region .app-field').eq(0).trigger('click');
			
		}
		*/
		clickArr['goods'] = function(){
			if(obj.content.goods){
				for(var i in obj.content.goods){
					obj.content.goods[i].image = obj.content.goods[i].image;
				}
			}
			//此处给已经添加的商品赋值给data
			app_field.find('.control-group').html('<ul class="sc-goods-list clearfix size-2 card pic"></ul>').data({'goods':obj.content.goods,'size':(obj.content.size ? obj.content.size : '0'),'size_type':(obj.content.size_type ? obj.content.size_type : '0'),'buy_btn':(obj.content.buy_btn ? obj.content.buy_btn : '0'),'buy_btn_type':(obj.content.buy_btn_type ? obj.content.buy_btn_type : '0'),'show_title':(obj.content.show_title ? obj.content.show_title : '0'),'price':(obj.content.price ? obj.content.price : '0')});
			customField.clickEvent(app_field);
			app_field.removeClass('editing');
			$('.js-config-region .app-field').eq(0).trigger('click');
		};
		
		clickArr[obj.field_type]();
		$('.js-fields-region .app-fields').append(app_field);
	},
	checkEvent:function(){
		var returnArr = [];
		$.each($('.js-fields-region .app-field'),function(i,item){
			returnArr[i] = customField.getContent($(item));
		});
		return returnArr;
	},
	getContent:function(dom){
		var returnArr = [],returnObj = {},domHtml={};
		returnArr['rich_text'] = function(){
			returnObj.type = 'rich_text';
			domHtml = dom.find('.custom-richtext');
			returnObj.bgcolor = domHtml.data('bgcolor');
			returnObj.screen  = domHtml.data('fullscreen');
			returnObj.content = domHtml.data('has_amend')=='1' ? domHtml.html() : '';
		};
		returnArr['notice'] = function(){
			returnObj.type = 'notice';
			domHtml = dom.find('.custom-notice');
			returnObj.content = domHtml.data('content');
		};
		returnArr['title'] = function(){
			returnObj.type = 'title';
			domHtml = dom.find('.custom-title');
			returnObj.title = domHtml.data('title');
			returnObj.sub_title = domHtml.data('sub_title');
			returnObj.show_method = domHtml.data('show_method');
			returnObj.bgcolor = domHtml.data('bgcolor');
		};

		returnArr['tpl_shop'] = function(){
			returnObj.type = 'tpl_shop';
			domHtml = dom.find('.tpl-shop');
			returnObj.shop_head_bg_img = domHtml.data('shop_head_bg_img');
			returnObj.shop_head_logo_img = domHtml.data('shop_head_logo_img');
			returnObj.bgcolor = domHtml.data('bgcolor');
			returnObj.title = domHtml.data('title');
			return;
		};
		returnArr['tpl_shop1'] = function(){
			returnObj.type = 'tpl_shop1';
			domHtml = dom.find('.tpl-shop1');
			returnObj.shop_head_bg_img = domHtml.data('shop_head_bg_img');
			returnObj.shop_head_logo_img = domHtml.data('shop_head_logo_img');
			returnObj.bgcolor = domHtml.data('bgcolor');
			returnObj.title = domHtml.data('title');
		};		
		returnArr['line'] = function(){
			returnObj.type = 'line';
		};
		returnArr['white'] = function(){
			returnObj.type = 'white';
			domHtml = dom.find('.custom-white');
			returnObj.left = domHtml.data('left');
			returnObj.height = domHtml.data('height');
		};
		returnArr['search'] = function(){
			returnObj.type = 'search';
		};
		returnArr['store'] = function(){
			returnObj.type = 'store';
		};
		returnArr['text_nav'] = function(){
			returnObj.type = 'text_nav';
			var navList = dom.find('.custom-nav').data('navList');
			var num = 10;
			for(var i in navList){
				returnObj[num] = {title:navList[i].title,name:navList[i].name,prefix:navList[i].prefix,url:navList[i].url};
				num++;
			}
		};
		returnArr['image_nav'] = function(){
			returnObj.type = 'image_nav';
			var navList = dom.find('.custom-nav-4').data('navList');
			var num = 10;
			for(var i in navList){
				returnObj[num] = {title:navList[i].title,name:navList[i].name,prefix:navList[i].prefix,url:navList[i].url,image:navList[i].image.replace('./upload/','')};
				num++;
			}
		};
		returnArr['component'] = function(){
			domHtml = dom.find('.custom-richtext');
			if(domHtml.data('name')!=''){
				returnObj.type = 'component';
				returnObj.name = domHtml.data('name');
				returnObj.id = domHtml.data('id');
				returnObj.url = domHtml.data('url');
			}
		};
		returnArr['link'] = function(){
			returnObj.type = 'link';
			var navList = dom.find('.custom-nav').data('navList');
			var num = 10;
			for(var i in navList){
				if(navList[i].type == 'link'){
					returnObj[num] = {name:navList[i].name,url:navList[i].url,prefix:navList[i].prefix,type:navList[i].type};
				}else{
					returnObj[num] = {id:navList[i].id,name:navList[i].name,number:navList[i].number,url:navList[i].url,prefix:navList[i].prefix,type:navList[i].type,'widget':navList[i].widget};
				}
				num++;
			}
		};
		
		returnArr['image_ad'] = function(){
			var domHtml = dom.find('.control-group');
			returnObj.type = 'image_ad';
			returnObj.image_type = domHtml.data('type');
			returnObj.image_size = domHtml.data('size');
			returnObj.max_height = domHtml.data('max_height');
			returnObj.max_width = domHtml.data('max_width');
			returnObj.nav_list = {};
			var navList = domHtml.data('navList');
			var num = 10;
			for(var i in navList){
				returnObj.nav_list[num] = {title:navList[i].title,name:navList[i].name,prefix:navList[i].prefix,url:navList[i].url,image:navList[i].image.replace('./upload/','')};
				num++;
			}
		};
		
		returnArr['goods_group1'] = function(){
			var domHtml = dom.find('.goods_group1');
			returnObj.type = 'goods_group1';

			returnObj.goods_group1={};
			var goods_group_arr = domHtml.data('goods_group1_arr');
			var num=0;
			for(var i in goods_group_arr){
				returnObj.goods_group1[num] = {id:goods_group_arr[i].id,title:goods_group_arr[i].title,show_num:goods_group_arr[i].show_num};
				num++;
			}
		}
		
		returnArr['goods_group2'] = function(){//alert(22222)
			var domHtml = dom.find('.control-group');
			returnObj.type = 'goods_group2';
			returnObj.size = domHtml.data('size');
			returnObj.size_type = domHtml.data('size_type');
			returnObj.buy_btn = domHtml.data('buy_btn');
			returnObj.buy_btn_type = domHtml.data('buy_btn_type');
			returnObj.show_title = domHtml.data('show_title');
			returnObj.price = domHtml.data('price');
			returnObj.goods = {};
			var goods = domHtml.data('goods');
			//alert(goods)
			var num = 0;
			//alert(obj2String(goods));
			
			for(var i in goods){
				returnObj.goods[num] = {id:goods[i].id,title:goods[i].title,url:goods[i].url};
				num++;
			}
			//alert(obj2String(returnObj));
		}
		
	returnArr['coupons']=function(){
			var domHtml=dom.find('.custom-coupon');
			returnObj.type='coupons';
			returnObj.coupon_arr={};
			var coupon_list=domHtml.data('coupon_data');
			var num=0;

			if(!coupon_list){
				coupon_list={};
				}
			
			if (coupon_list.coupon_arr != undefined) {
;				for(var i in coupon_list.coupon_arr){
					returnObj.coupon_arr[num]={id:coupon_list.coupon_arr[i].id,title:coupon_list.coupon_arr[i].title,face_money:coupon_list.coupon_arr[i]['face_money'],condition:coupon_list.coupon_arr[i]['condition']};
					num++;
				}
			} else {
				for(var i in coupon_list){
					returnObj.coupon_arr[num]={id:coupon_list[i].id,title:coupon_list[i].title,face_money:coupon_list[i]['face_money'],condition:coupon_list[i]['condition']};
					num++;
				}	
			}
		}
		returnArr['goods'] = function(){//alert(22222)
			var domHtml = dom.find('.control-group');
			returnObj.type = 'goods';
			returnObj.size = domHtml.data('size');
			returnObj.size_type = domHtml.data('size_type');
			returnObj.buy_btn = domHtml.data('buy_btn');
			returnObj.buy_btn_type = domHtml.data('buy_btn_type');
			returnObj.show_title = domHtml.data('show_title');
			returnObj.price = domHtml.data('price');
			returnObj.goods = {};
			var goods = domHtml.data('goods');
			//alert(goods)
			var num = 0;
			//alert(obj2String(goods));
			
			for(var i in goods){
				returnObj.goods[num] = {id:goods[i].id,title:goods[i].title,price:goods[i].price,url:goods[i].url,image:goods[i].image.replace('./upload/','')};
				num++;
			}
			//alert(obj2String(returnObj));
		}

		var fieldType = dom.data('field-type');
		//alert(fieldType);
		returnArr[fieldType]();
		return returnObj;
	},
	setHtml:function(json){
		var arr = $.parseJSON(json);
		for(var i in arr){
			customField.setEvent(arr[i]);
		}
	}
}

var obj2String = function(_obj) {
    var t = typeof(_obj);
    if (t != 'object' || _obj === null) {
        // simple data type
        if (t == 'string') {
            _obj = '"' + _obj + '"';
        }
        return String(_obj);
    } else {
        if (_obj instanceof Date) {
            return _obj.toLocaleString();
        }
        // recurse array or object
        var n, v, json = [],
        arr = (_obj && _obj.constructor == Array);
        for (n in _obj) {
            v = _obj[n];
            t = typeof(v);
            if (t == 'string') {
                v = '"' + v + '"';
            } else if (t == "object" && v !== null) {
                v = this.obj2String(v);
            }
            json.push((arr ? '': '"' + n + '":') + String(v));
        }
        return (arr ? '[': '{') + String(json) + (arr ? ']': '}');
    }
};