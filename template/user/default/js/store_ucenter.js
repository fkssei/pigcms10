/**
 * Created by pigcms_21 on 2015/2/6.
 */
$(function(){
	var defaultFieldObj;
    load_page('.app__content',load_url,{page:'ucenter_content'},'',function(){
		defaultFieldObj = $('.js-config-region .app-field');
		defaultFieldObj.data({'page_title':ucenter_page_title,'bg_pic':ucenter_bg_pic,'show_level':ucenter_show_level,'show_point':ucenter_show_point}).live('click',function(){
			$('.app-entry .app-field').removeClass('editing');
			$(this).addClass('editing');
			$('.js-sidebar-region').html(defaultHtmlObj());
			$('.app-sidebar').css('margin-top',$(this).offset().top - $('.js-app-main').offset().top);
		});
		
		$('.page-title').html(ucenter_page_title);
		$('.custom-level-img').attr('src',ucenter_bg_pic);
		var cli = $('.custom-level-img');
		var clts = $('<div class="custom-level-title-section">');
		/*if(ucenter_show_level && ucenter_show_point){
			//clts.html('<h5 class="custom-level-title">尊贵的｛会员等级名｝<br/>你拥有本店积分：888</h5>');
			clts.html('<h5 class="custom-level-title">尊贵的｛会员等级名｝');
			cli.after(clts);
		}else if(ucenter_show_level){
			//clts.html('<h5 class="custom-level-title">尊贵的｛会员等级名｝</h5>');
			//cli.after(clts);
		}else if(ucenter_show_point){
			clts.html('<h5 class="custom-level-title">你拥有本店积分：888</h5>');
			cli.after(clts);
		}*/
		
		clts.html('<h5 class="custom-level-title">尊贵的会员');
		cli.after(clts);


		$('.js-sidebar-region').html(defaultHtmlObj());
		
		customField.init();
		customField.setHtml(ucenter_customField);
	});
	
	var defaultHtmlObj = function(){
		return '<div><form class="form-horizontal"><div class="control-group"><label class="control-label"><em class="required">*</em>页面名称：</label><div class="controls"><input class="input-xxlarge page-title-text" type="text" name="title" value="'+(defaultFieldObj.data('page_title'))+'" /></div></div><div class="control-group"><label class="control-label">背景图：</label><div class="controls"><img src="'+(defaultFieldObj.data('bg_pic'))+'" width="100"/>&nbsp;&nbsp;&nbsp;<a class="js-choose-bg control-action" href="javascript: void(0);">修改背景图</a><p class="help-block">建议尺寸：640 x 320 像素</p></div></div><!--<div class="control-group"><label class="control-label">等级：</label><div class="controls"><label class="checkbox inline"><input type="checkbox" name="show_level" class="show-level" value="1" ' + (defaultFieldObj.data('show_level') ? 'checked="checked"' : '') + '/>显示等级</label></div></div><div class="control-group"><label class="control-label">积分：</label><div class="controls"><label class="checkbox inline"><input type="checkbox" name="show_point" class="show-point" value="1" ' + (defaultFieldObj.data('show_point') ? 'checked="checked"' : '') + '/>显示积分</label></div></div>--></form></div>';
	};

    //页面标题
    $('.page-title-text').live('blur', function(e){
		var t_l = $(this).val().length;
		if(t_l == 0 || t_l > 50){
			layer_tips(1,'标题长度不能少于一个字或者大于50个字！');
		}else{
			$('.page-title').html($(this).val());
			defaultFieldObj.data('page_title',$(this).val());
		}
    });
	
	$('.show-level,.show-point').live('change',function(){
		var cli = $('.custom-level-img');
		$('.custom-level-title-section').remove();
		var clts = $('<div class="custom-level-title-section">');
		var l_c = $('.show-level').prop('checked');
		var p_c = $('.show-point').prop('checked');
		if(l_c && p_c){
			clts.html('<h5 class="custom-level-title">尊贵的｛会员等级名｝<br/>你拥有本店积分：888</h5>');
			cli.after(clts);
		}else if(l_c){
			clts.html('<h5 class="custom-level-title">尊贵的｛会员等级名｝</h5>');
			cli.after(clts);
		}else if(p_c){
			clts.html('<h5 class="custom-level-title">你拥有本店积分：888</h5>');
			cli.after(clts);
		}
		defaultFieldObj.data('show_level',l_c);
		defaultFieldObj.data('show_point',p_c);
	});
	
	$('.js-choose-bg').live('click',function(){
		var dom = $(this);
		upload_pic_box(1,true,function(pic_list){
			for(var i in pic_list){
				dom.siblings('img').attr('src',pic_list[i]);
				$('.custom-level-img').attr('src',pic_list[i]);
				defaultFieldObj.data('bg_pic',pic_list[i]);
			}
		},1);
	});
	
	$('.form-actions .btn-save,.form-actions .btn-preview').live('click',function(){
		var isPerview = $(this).hasClass('btn-preview') ? true : false;
		var post_data = {};
		post_data.page_title = defaultFieldObj.data('page_title');
		post_data.bg_pic = defaultFieldObj.data('bg_pic');
		post_data.show_level = defaultFieldObj.data('show_level') ? 1 : 0;
		post_data.show_point = defaultFieldObj.data('show_point') ? 1 : 0;
		post_data.custom = customField.checkEvent();
		$.post(post_url,post_data,function(result){
			if(result.err_code == 0){
				if(isPerview){
					layer_tips(0,'修改成功，正在跳转');
					setTimeout(function(){
						window.location.href = wap_site_url+'/ucenter.php?id='+store_id;
					},1000);
				}else{
					layer_tips(0,result.err_msg);
				}
			}else{
				layer_tips(1,result.err_msg);
			}
		});
	});
});