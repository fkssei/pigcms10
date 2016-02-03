$(function(){
	
	/*查看留言*/
	$(".js-show-message").click(function () {
		var comment_obj = $(this).data("comment");
		var comment_html = '';
		
		for(var i in comment_obj) {
			comment_html += "<li><span>" + comment_obj[i].name + ":</span>" + comment_obj[i].value + "</li>";
		}
		
		var product_content = $(this).closest(".js-product-detail").html();
		product_content_obj = $("<div>" + product_content + "</div>");
		product_content_obj.find(".js-show-message").remove();
		product_content = product_content_obj.html();
		
		var comment_html = '<div class="modal order-modal active">\
								<div class="block block-order block-border-top-none">\
									<div class="block block-list block-border-top-none block-border-bottom-none">\
										<div class="block-item name-card name-card-3col clearfix">' + product_content + '</div>\
									</div>\
								</div>\
								<div class="block express" id="js-logistics-container">\
									<div class="block-item logistics">\
										<h4 class="block-item-title">留言信息</h4>\
									</div>\
									<div class="js-logistics-content logistics-content js-express">\
										<div>\
											<div class="block block-form block-border-top-none block-border-bottom-none">\
												<div class="js-order-address express-panel" style="padding-left:0;">\
													<ul>' + comment_html + '</ul>\
												</div>\
											</div>\
										</div>\
									</div>\
								</div>\
								<div class="action-container"><button type="button" class="js-cancel btn btn-block">查看订单</button></div>\
							</div>';
		
		
		var comment_obj = $(comment_html);
		
		$('body').append(comment_obj);
		
		comment_obj.find('.js-cancel').click(function(){
			comment_obj.remove();
		});
	});
	
	$('.js-save').click(function(){
		var nowScroll = $(window).scrollTop();
		var loadingCon = $('<div class="popout-box" style="overflow:hidden;visibility:visible;position:absolute;z-index:1100;transition:opacity 300ms ease;-webkit-transition:opacity 300ms ease;opacity:1;top:'+(($(window).height()-187)/2)+'px;left:'+(($(window).width()-300)/2)+'px;padding:15px;background:white;border-radius:4px;"><form class="form-dialog js-login-form block-wrapper-form" method="GET" action=""><div class="header"><h2><span class="form-title c-green font-size-16">填写手机号便于找回订单</span></h2></div><fieldset class="font-size-14"><div class="block-form-item"><label for="phone" class="item-label">手机号</label><input id="phone" name="phone" class="item-input" type="tel" maxlength="11" autocomplete="off" placeholder="请输入你的手机号" value=""/><div class="txt-cover js-txt-cover"></div></div><div class="js-help-info font-size-12 error"></div></fieldset><div class="action-container"><button type="button" class="js-confirm btn btn-green btn-block font-size-14">确认手机号码</button></div></form></div>');
		var loadingBg = $('<div style="height:100%;position:fixed;top:0px;left:0px;right:0px;z-index:1000;opacity:1;transition:opacity 0.2s ease;-webkit-transition:opacity 0.2s ease;background-color:rgba(0,0,0,0.901961);"></div>');
		$('html').css({'position':'relative','overflow':'hidden','height':$(window).height()+'px'});
		$('body').css({'overflow':'hidden','height':$(window).height()+'px','padding':'0px'}).append(loadingCon).append(loadingBg);
		$('.js-txt-cover').live('click',function(){
			$(this).hide().siblings('input').focus();
		});
		$('.js-login-form input').blur(function(){
			$(this).siblings('.js-txt-cover').show();
		});
		$('.js-login-form').submit(function(){
			var nowDom = $(this);
			$('.js-help-info').empty();
			var phoneDom = $('.js-login-form #phone');
			if(phoneDom.prop('disabled') === false){
				if(!/^[0-9]{11}$/.test(phoneDom.val())){
					$('.js-help-info').html("请填写正确手机号码");
					return false;
				}
				$.post('./userinfo.php?action=checkPhone',{phone:phoneDom.val()},function(result){
					if(result.err_code){
						motify.log(result.err_msg);
					}else if(result.err_msg.uid == 0){
						nowDom.find('.header h2').html('<span class="form-title c-green font-size-16">填写手机号便于找回订单</span><span class="js-title-info title-info font-size-12">验证码将发送到你的手机</span>');
						phoneDom.prop('disabled',true);
						$('.js-confirm').html('保存订单');
						loadingCon.css({'top':(($(window).height()-311)/2)+'px'});
						nowDom.find('fieldset').html('<fieldset class="font-size-14"><div class="block-form-item"><label for="phone" class="item-label">手机号</label><input id="phone" name="phone" class="item-input" type="tel" maxlength="11" autocomplete="off" disabled="disabled" value="'+phoneDom.val()+'"/><div class="txt-cover js-txt-cover"></div></div><div class="block-form-item"><label for="code" class="item-label">验证码</label><input id="code" name="code" class="item-input" type="text" style="width:178px" maxlength="6" autocomplete="off" placeholder="输入短信验证码"><div class="txt-cover txt-cover-half js-txt-cover"></div><button type="button" class="js-auth-code btn btn-auth-code btn-green font-size-12" data-text="获取验证码">获取验证码</button></div><div class="block-form-item"><label for="password" class="item-label">密码</label><input id="passsword" name="password" class="item-input" type="password" autocomplete="off" placeholder="设置登录密码，下次登录使用"/><div class="txt-cover js-txt-cover" style="display: block;"></div></div><div class="js-help-info font-size-12 error"></div></fieldset>');
					}else if(result.err_msg.uid != 0){
						nowDom.find('.header h2').html('<span class="form-title c-green font-size-16">填写手机号便于找回订单</span><span class="js-title-info title-info font-size-12">该手机号已注册，请输入密码登录账户</span>');
						phoneDom.prop('disabled',true);
						$('.js-confirm').html('保存订单');
						loadingCon.css({'top':(($(window).height()-311)/2)+'px'});
						nowDom.find('fieldset').html('<fieldset class="font-size-14"><div class="block-form-item"><label for="phone" class="item-label">手机号</label><input id="phone" name="phone" class="item-input" type="tel" maxlength="11" autocomplete="off" disabled="disabled" value="'+phoneDom.val()+'"/><div class="txt-cover js-txt-cover"></div></div><div class="block-form-item"><label for="password" class="item-label">密码</label><input id="passsword" name="password" class="item-input" type="password" autocomplete="off" placeholder="请输入登录密码"/><div class="txt-cover js-txt-cover"></div></div><div class="js-help-info font-size-12 error"></div></fieldset>');
					}
				});
			}else if(nowDom.find('#code').size()>0){
				var codeDom = nowDom.find('#code');
				var passswordDom = nowDom.find('#passsword');
				if(codeDom.val().length != 6){
					$('.js-help-info').html("请填写6位短信验证码");
					return false;
				}
				if(passswordDom.val().length < 6){
					$('.js-help-info').html("密码至少6位");
					return false;
				}
				$.post('./login.php?action=reg',{phone:$('.js-login-form #phone').val(),pwd:passswordDom.val(),code:codeDom.val()},function(result){
					if(result.err_code){
						$('.js-help-info').html(result.err_msg);
					}else{
						alert('注册成功！');
						window.location.reload();
					}
				});
			}else{
				var passswordDom = nowDom.find('#passsword');
				if(passswordDom.val().length < 6){
					$('.js-help-info').html("密码至少6位");
					return false;
				}
				$.post('./login.php?action=login',{phone:$('.js-login-form #phone').val(),pwd:passswordDom.val()},function(result){
					if(result.err_code){
						$('.js-help-info').html(result.err_msg);
					}else{
						alert('登录成功！');
						window.location.reload();
					}
				});
			}
			return false;
		});
		$('.js-auth-code').live('click',function(){
			var dom = $(this);
			var phone = $('.js-login-form #phone').val();
			if(phone.length == 0){
				motify.log("请填写您的手机号码");
				return false;
			}else if(!/^[0-9]{11}$/.test(phone)){
				motify.log("请填写正确手机号码");
				return false;
			}
			$.post('./phonecode.php',{phone:phone,type:'reg'},function(result){
				if(result.err_code == 0){
					var timer=null;
					var num = parseInt(result.err_msg);
					dom.html('等待 '+num+' 秒').prop('disabled',true);
					num--;
					window.setInterval(function(){
						if(num == 0){
							dom.html('再次获取').prop('disabled',false);
							window.clearInterval(timer);
						}else{
							dom.html('等待 '+num+' 秒');
							num--;
						}
					},1000);
				}else{
					motify.log(result.err_msg);
				}
			});
		});
	
		$('.js-login-form .js-confirm').click(function(){
			$('.js-login-form').trigger('submit');
		});
		loadingBg.click(function(){
			$('html').css({'overflow':'visible','height':'auto','position':'static'});
			$('body').css({'overflow':'visible','height':'auto','padding-bottom':'0px'});
			$(window).scrollTop(nowScroll);
			loadingBg.css('opacity',0);
			setTimeout(function(){
				loadingCon.remove();loadingBg.remove();
			},200);
		});
	});
	
	
	// 查看物流信息
	$(".express-context a").click(function () {
		$(this).parent().find("span").show();
		
		if ($(this).closest("div").find(".express_detail").data("is_has") == "0") {
			var type = $(this).data("type");
			var order_no = $(this).data("order_no");
			var express_no = $(this).data("express_no");
			
			if (type.length == 0 || order_no.length == 0 || express_no.length == 0) {
				return;
			}
			
			var express_detail_obj = $(this).closest("div").find(".express_detail");
			html = "<p>努力查寻中</p>";
			express_detail_obj.html(html);
			
			var url = "/index.php?c=order&a=express&type=" + type + "&order_no=" + order_no + "&express_no=" + express_no;
			$.getJSON(url, function(data) {
				try {
					if (data.status == true) {
						html = '<table><tr><td width="30%">处理时间</td><td>处理信息</td></tr>';
						for(var i in data.data.data) {
							html += "<tr>";
							html += "<td>" + data.data.data[i].time + "</td>";
							html += "<td>" + data.data.data[i].context + "</td>";
							html += "</tr>";
						}
						html += "</table>";
						express_detail_obj.html(html);
						express_detail_obj.data("is_has", 1);
					} else {
						html = "<p>查寻失败</p>";
						express_detail_obj.html(html);
					}
				}catch(e) {
					html = "<p>查寻失败</p>";
					express_detail_obj.html(html);
				}
			});
		}
		
		$(this).closest("div").find(".express_detail").show();
	});
	
	// 关闭物流信息
	$(".js-express_close").click(function () {
		$(this).hide();
		$(this).closest("div").find(".express_detail").hide();
	});
});