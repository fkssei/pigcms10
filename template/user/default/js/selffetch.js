var t;
$(function(){
	load_page('.app__content',load_url,{page:'selffetch_content'},'');
	$('.js-add').live('click',function(){
		var html = '<div class="modal-backdrop fade in"></div><div class="js-modal modal fade in"><div class="modal-header"><a class="close">×</a><h3 class="title">添加自提点</h3></div><div class="modal-body"><form class="form-horizontal"><div class="control-group"><label class="control-label">自提点名称</label><div class="controls"><input type="text" class="span6" value="" name="name" placeholder="请填写自提点名称便于买家理解和管理"/></div></div><div class="control-group"><label class="control-label">自提点地址</label><div class="controls"><span><select class="span2 js-province-select" name="province" id="s1"></select></span><span><select class="span2 js-city-select" name="city" id="s2"><option value="-1">选择城市</option></select></span><span><select class="span2 js-county-select" name="county"  id="s3"><option value="-1">选择地区</option></select></span></div></div><div class="control-group"><div class="controls"><textarea name="address_detail" cols="20" rows="2" class="span6" placeholder="请填写自提点的具体地址，最短5个字符，最长120字。"></textarea></div></div> <div class="control-group"><label class="control-label">联系电话</label><div class="controls"><input type="text" value="" name="tel" placeholder="填写准确的联系电话，便于买家联系"></div></div></form></div><div class="modal-footer"><div style="text-align:center;"><a href="javascript:;" class="ui-btn ui-btn-primary js-save">保存自提点</a></div></div></div>';
		$('body').append(html);
		
		getProvinces('s1','');
	});
	
	$('.js-selffetch-list .js-edit').live('click',function(){
		var layer_load = layer.load(0);
		
		$.post(get_url,{pigcms_id:$(this).attr('pigcms-id')},function(result){
			layer.close(layer_load);
			if(result.err_code == 0){
				var html = '<div class="modal-backdrop fade in"></div><div class="js-modal modal fade in"><div class="modal-header"><a class="close">×</a><h3 class="title">编辑自提点</h3></div><div class="modal-body"><form class="form-horizontal"><input name="pigcms_id" type="hidden" value="'+result.err_msg.pigcms_id+'"/><div class="control-group"><label class="control-label">自提点名称</label><div class="controls"><input type="text" class="span6" value="'+result.err_msg.name+'" name="name" placeholder="请填写自提点名称便于买家理解和管理"/></div></div><div class="control-group"><label class="control-label">自提点地址</label><div class="controls"><span><select class="span2 js-province-select" name="province" id="s1"></select></span><span><select class="span2 js-city-select" name="city" id="s2"><option value="-1">选择城市</option></select></span><span><select class="span2 js-county-select" name="county"  id="s3"><option value="-1">选择地区</option></select></span></div></div><div class="control-group"><div class="controls"><textarea name="address_detail" cols="20" rows="2" class="span6" placeholder="请填写自提点的具体地址，最短5个字符，最长120字。">'+result.err_msg.address+'</textarea></div></div> <div class="control-group"><label class="control-label">联系电话</label><div class="controls"><input type="text" value="'+result.err_msg.tel+'" name="tel" placeholder="填写准确的联系电话，便于买家联系"></div></div></form></div><div class="modal-footer"><div style="text-align:center;"><a href="javascript:;" class="ui-btn ui-btn-primary js-save">保存自提点</a></div></div></div>';
				$('body').append(html);
				
				getProvinces('s1',result.err_msg.province);
				getCitys('s2','s1',result.err_msg.city);
				getAreas('s3','s2',result.err_msg.county);
			}else{
				layer.alert(result.err_msg,0);
			}
		});
		
	});
	
	$(".js-buyer_selffetch_name").live("click", function () {
		var buyer_selffetch_name = $("input[name='buyer_selffetch_name']").val();
		if ($.trim(buyer_selffetch_name).length == 0) {
			layer_tips(1, '自提点前台显示名没有填写');
			return false;
		}
		
		$.post(buyer_selffetch_name_url, {buyer_selffetch_name : buyer_selffetch_name}, function (result) {
			if(result.err_code == 0){
				layer_tips(0, result.err_msg);
			}else{
				layer.alert(result.err_msg, 0);
			}
		})
	});

    //删除
    $('.js-selffetch-list .js-delete').live('click', function(e) {
        var pigcms_id = $(this).attr('pigcms-id');
        $('.js-delete').addClass('active');
        button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
            $.post(del_url, {'pigcms_id': pigcms_id}, function(data) {
                close_button_box();
                t = setTimeout('msg_hide()', 3000);
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    load_page('.app__content',load_url,{page:'selffetch_content'},'');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
            })
        });
    })

	$('#s1').live('change',function(){
		if($(this).val() != ''){
			getCitys('s2','s1','');
		}else{
			$('#s2').html('<option>选择城市</option>');
		}
		$('#s3').html('<option>选择地区</option>');
	});
	$('#s2').live('change',function(){
		getAreas('s3','s2','');
	});
	
	$('.js-modal .close').live('click',function(){
		$('.js-modal,.modal-backdrop').remove();
	});
	
	$('.js-modal .js-save').live('click',function(){
		var name_dom = $('.js-modal .form-horizontal input[name="name"]');
		name_dom.val($.trim(name_dom.val()));
		if(name_dom.val().length == 0){
			layer_tips(1,'自提点名称不能为空');
			return false;
		}
		if($('#s1').val() =='' || $('#s2').val() =='' || $('#s3').val() ==''){
			layer_tips(1,'地址未选择');
			return false;
		}
		
		var address_detail_dom = $('.js-modal .form-horizontal textarea[name="address_detail"]');
		address_detail_dom.val($.trim(address_detail_dom.val()));
		if(address_detail_dom.val().length == 0){
			layer_tips(1,'具体地址不能为空');
			return false;
		}
		
		var tel_dom = $('.js-modal .form-horizontal input[name="tel"]');
		tel_dom.val($.trim(tel_dom.val()));
		if(tel_dom.val().length == 0){
			layer_tips(1,'手机号码不能为空');
			return false;
		}else if(!/^[0-9]{11}$/.test(tel_dom.val()) && !/^([0-9]{3,4})\-([0-9]{7,8})$/.test(tel_dom.val())){
			layer_tips(1,'请输入正确的联系电话');
			return false;
		}
		$.post($('.js-modal .form-horizontal input[name="pigcms_id"]').val() ? edit_url : add_url,$('.js-modal .form-horizontal').serialize(),function(result){
			if(result.err_code == 0){
				$('.js-modal,.modal-backdrop').remove();
				layer_tips(0,result.err_msg);
				load_page('.app__content',load_url,{page:'selffetch_content'},'');
			}else{
				layer.alert(result.err_msg,0);
			}
		});
	});
	
	$('.js-page-list a').live('click',function(e){
		if(!$(this).hasClass('active')){
			load_page('.app__content',load_url,{page:'selffetch_content',p:$(this).attr('data-page-num')},'');
		}
	});

    $('.js-switch').live('click', function(){
        var obj = this;
        if ($(this).hasClass('ui-switch-off')) {
            var status = 1;
            var oldClassName = 'ui-switch-off';
            var className = 'ui-switch-on';
        } else {
            var status = 0;
            var oldClassName = 'ui-switch-on';
            var className = 'ui-switch-off';
        }
        $.post(status_url, {'status': status}, function(data){
            if(!data.err_code) {
                $(obj).removeClass(oldClassName);
                $(obj).addClass(className);
            }
        })
    })
});

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}