$(function(){
	load_page('.app__content',load_url,{page:'service_list'},'');
});

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
				break;
			case "#edit":
				if(mark_arr[1]){
					load_page('.app__content', load_url,{page:'service_edit',service_id:mark_arr[1]},'',function(){

							
					});
				}else{
					layer.alert('非法访问！');
					location.hash = '#list';
					location_page('');
				}
				break;
			default:
				load_page('.app__content', load_url,{page:'service_list'}, '');
		}
	}

	$('.js-choose-bg').live('click',function(){
		var dom = $(this);
		upload_pic_box(1,true,function(pic_list){
			for(var i in pic_list){
				$('.avatar_show').attr('src',pic_list[i]);
				$('.avatar').val(pic_list[i]);
			}
		},1);
	});
	

	$('.bind_qrcode').live('click',function(){
		$.layer({
			type: 2,
			title: false,
			shadeClose: true,
			shade: [0.4, '#000'],
			area: ['330px','430px'],
			border: [0],
			iframe: {src:'./user.php?c=store&a=bind_qrcode'}
		});
	});
	
	$('.js-delete').live('click',function(){
		var sid 	= $(this).attr('sid');
		if(confirm('确认要删除吗？')){
			$.post(delete_url,{sid:sid},function(res){
				if(res.err_code == 0){
					layer_tips(0,res.err_msg);
					$("tr[service-id="+sid+"]").remove();
				}else{
					layer_tips(1,res.err_msg);
				}
			});
		}
	
	});
	
	$('.submit-btn').live('click',function(){
		var avatar 	= $('.avatar').val();
		var nickname 	= $('.nickname').val();
		var truename 	= $('.truename').val();
		var tel 			 	= $('.tel').val();
		var qq 				 	= $('.qq').val();
		var email 				= $('.email').val();
		var service_id 			= $('.service_id').val();
		var intro 				= $('.intro').val();

		var telReg 		= /^1[1-9][0-9]{9}$/;
		var emailReg 	= /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
		var qqReg 	 	= /^[1-9]*[1-9][0-9]*$/;

		var flag 	= true;

		if(avatar == ''){
			layer_tips(1,'客服头像必须上传');
			flag 	= false;
			return flag;
		}
		
		if(nickname == ''){
			layer_tips(1,'客服昵称必须填写');
			flag 	= false;
			return flag;
		}

		if(truename == ''){
			layer_tips(1,'客服真实姓名不能为空');
			flag 	= false;
			return flag;
		}
		
		if(!telReg.test(tel)){
			layer_tips(1,'请填写正确的手机号码');
			flag 	= false;
			return flag;
		}

		if(!emailReg.test(email)){
			layer_tips(1,'请填写正确的邮箱');
			flag 	= false;
			return flag;
		}

		if(!qqReg.test(qq)){
			layer_tips(1,'请填写正确的qq号码');
			flag 	= false;
			return flag;
		} 

		var post_data 	= {
			avatar : avatar,
			nickname : nickname,
			truename : truename,
			tel : tel,
			qq : qq,
			email : email,
			service_id : service_id,
			intro : intro
		};

		if(flag){
			$.post(edit_url,post_data,function(res){
				if(res == ''){
					layer_tips(1,'请修改选项后再提交');		
				}else{
					if(res.err_code == 0){
						layer_tips(0,res.err_msg);
						setTimeout(function(){
							window.location=default_url;
						},1000);
					}else{
						layer_tips(1,res.err_msg);
					}
				}	
			});
		}
		
	});
})