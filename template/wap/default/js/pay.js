var addressList={};//,postage=0.00;
var l_express = true;
var l_friend = true;
var selffetch_obj = {};
var friend_obj = {};
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
	
	
	/*收货地址*/
	var editAdress = function(callbackObj,address_id){
		var addAdressDom = $('<div id="addAdress" class="modal order-modal active"><div><form class="js-address-fm address-ui address-fm"><div class="block" style="margin-bottom:10px;"><div class="block-item"><label class="form-row form-text-row"><em class="form-text-label">收货人</em><span class="input-wrapper"><input type="text" name="user_name" class="form-text-input" value="" placeholder="名字"></span></label></div><div class="block-item"><label class="form-row form-text-row"><em class="form-text-label">联系电话</em><span class="input-wrapper"><input type="tel" name="tel" class="form-text-input" value="" placeholder="手机或固话"></span></label></div><div class="block-item"><div class="form-row form-text-row"><em class="form-text-label">选择地区</em><div class="input-wrapper input-region js-area-select"><span><select id="province" name="province" class="address-province"></select></span><span><select id="city" name="city" class="address-city"><option>城市</option></select></span><span><select id="county" name="county" class="address-county"><option>区县</option></select></span></div></div></div><div class="block-item"><label class="form-row form-text-row"><em class="form-text-label">详细地址</em><span class="input-wrapper"><input type="text" name="address" class="form-text-input" value="" placeholder="街道门牌信息"></span></label></div><div class="block-item"><label class="form-row form-text-row"><em class="form-text-label">邮政编码</em><span class="input-wrapper"><input type="tel" maxlength="6" name="zipcode" class="form-text-input" value="" placeholder="邮政编码"></span></label></div></div><div><div class="action-container"><a class="js-address-save btn btn-block btn-blue">保存</a><a class="js-address-cancel btn btn-block">取消</a></div></div></form></div></div>');
		$('body').append(addAdressDom);
		getProvinces('province','','省份');
		addAdressDom.find('#province').change(function(){
			if($(this).val() != ''){
				getCitys('city','province','','城市');
			}else{
				$('#city').html('<option>城市</option>');
			}
			$('#county').html('<option>区县</option>');
		});
		addAdressDom.find('#city').change(function(){
			if($(this).val() != ''){
				getAreas('county','city','','区县');
			}else{
				$('#county').html('<option>区县</option>');
			}
		});
		addAdressDom.find('.js-address-cancel').click(function(){
			if(confirm('确定要放弃此次编辑吗？')){
				addAdressDom.removeClass('active').remove();
			}
		});
		addAdressDom.find('.js-address-save').click(function(){
			if($(this).attr('disabled')){
				motify.log('提交中,请稍等...');
				return false;
			}
			//收货人
			var nameDom = addAdressDom.find('input[name="user_name"]');
			var name = $.trim(nameDom.val());
			if(name.length == 0){
				motify.log('请填写名字');
				nameDom.focus();
				return false;
			}
			//联系电话
			var telDom = addAdressDom.find('input[name="tel"]');
			var tel = $.trim(telDom.val());
			if(tel.length == 0){
				motify.log('请填写联系电话');
				telDom.focus();
				return false;
			}else if(!/^0[0-9\-]{10,13}$/.test(tel) && !/^((\+86)|(86))?(1)\d{10}$/.test(tel)){
				motify.log('请填写正确的<br />手机号码或电话号码');
				telDom.focus();
				return false;
			}
			//地区
			var province = parseInt(addAdressDom.find('select[name="province"]').val());
			var city = parseInt(addAdressDom.find('select[name="city"]').val());
			var area = parseInt(addAdressDom.find('select[name="county"]').val());
			if(isNaN(province) || isNaN(city) || isNaN(area)){
				motify.log('请选择地区');
				return false;
			}
			//详细地址
			var addressDom = addAdressDom.find('input[name="address"]');
			var address = $.trim(addressDom.val());
			if(address.length == 0){
				motify.log('请填写详细地址');
				addressDom.focus();
				return false;
			}
			//邮政编码
			var zipcodeDom = addAdressDom.find('input[name="zipcode"]');
			var zipcode = $.trim(zipcodeDom.val());
			if(zipcode.length > 0 && !/^\d{6}$/.test(zipcode)){
				motify.log('邮政编码格式不正确');
				zipcodeDom.focus();
				return false;
			}
			var nowDom = $(this);
			nowDom.html('保存中...').attr('disabled',true);
			var post_data = {name:name,tel:tel,province:province,city:city,area:area,address:address,zipcode:zipcode};
			if(address_id){
				var post_url = 'address.php?action=edit';
				post_data.address_id = address_id;
			}else{
				var post_url = 'address.php?action=add';
			}
			$.post(post_url,post_data,function(result){
				if(result.err_code){
					motify.log(result.err_msg);
				}else{
					var data = result.err_msg;
					var area_text = '';
                    if (__alldiv[area][0] != '市辖区' && __alldiv[area][0] != '县') {
                        area_text = __alldiv[area][0];
                    }
                    $('.js-logistics-content').html('<div><div class="block block-form block-border-top-none block-border-bottom-none"><div class="js-order-address express-panel" style="padding-left:0;"><div class="opt-wrapper"><a href="javascript:;" class="btn btn-xxsmall btn-grayeee butn-edit-address js-edit-address">修改</a></div><ul><li><span>'+data.name+'</span>, '+data.tel+'</li><li>'+__alldiv[province][0]+' '+__alldiv[city][0]+' '+area_text+' </li><li>'+data.address+'</li></ul></div></div><div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">很抱歉，该地区暂不支持配送。</div></div>');
					$('#address_id').val(data.address_id);
					addAdressDom.removeClass('active').remove();
					getPostage();
					refreshAdress();
				}
			});
		});
		if(callbackObj) callbackObj();
	}
	$('.js-order-address > .js-edit-address').live('click',function(){
		editAdress();
	});
	
	var getPostage = function(type){
		var address_id = 0;
		var province_id = 0;
		
		if (!is_logistics) {
			return false;
		}
		if (typeof type == "undefined") {
			if($('#address_id').size() == 0){
				return false;
			}
			address_id = $('#address_id').val();
		} else {
			if ($("#friend_province").size() > 0 && $("#friend_province").val() != "") {
				province_id = $("#friend_province").val();
			}
		}
		
		$.post('address.php?action=postage',{orderNo:orderNo,address_id:address_id,province_id:province_id},function(result){
            if(typeof(result) == 'object'){
                if (result.err_msg == undefined || result.err_msg == null || result.err_msg == ''){
                    result.err_msg = 0;
                }
				if (result.err_code == 1001) {
                    window.location.reload();
                } else if(result.err_code == 1009){
					$('.js-step-topay').addClass('hide');
					$('.js-logistics-tips').removeClass('hide');
					
					if (typeof type == "undefined") {
						l_express = false;
					} else {
						l_friend = false;
					}
				}else if(result.err_code){
					$('.js-step-topay').removeClass('hide');
					alert('无法获取该订单支付信息\r\n错误提示：'+result.err_msg);
					
					if (typeof type == "undefined") {
						l_express = false;
					} else {
						l_friend = false;
					}
				}else{
					postage = parseFloat(result.err_msg);
					$("#js-postage").html(postage);

					resetPrice();
					
					//$('.js-order-total').html('<p>￥'+sub_total.toFixed(2)+' + ￥'+postage.toFixed(2)+'运费</p><strong class="js-real-pay c-orange js-real-pay-temp">需付：￥'+(sub_total+postage).toFixed(2)+'</strong>');
					$('.js-step-topay').removeClass('hide');
					$('.js-logistics-tips').addClass('hide');
					if (typeof type == "undefined") {
						l_express = true;
					} else {
						l_friend = true;
					}
				}
			}else{
				motify.log('访问异常，请重试');
			}
		});
	}
	var refreshAdress = function(){
		$.post('address.php?action=list',function(result){
			if(typeof(result) == 'object'){
				if(result.err_code == 0){
					addressList = result.err_msg;
				}
			}else{
				motify.log('访问异常，请重试');
			}
		});
	}
	
	var selffetchEdit = false;
	$('.js-logistics-select button').click(function(){
		if(!$(this).hasClass('tag-orange')){
			if($('#address_id').size() == 0){
				motify.log('您不能再修改配送方式');
				$(this).blur();
				return false;
			}
			
			// 保存切换之前填写的数据
			if ($(this).siblings(".tag-orange").data("type") == "selffetch") {
				var self_name = $(".js-name").val();
				var self_phone = $(".js-phone").val();
				var self_date = $(".js-self-date").val();
				var self_time = $(".js-self-time").val();
				
				selffetch_obj.self_name = self_name;
				selffetch_obj.self_phone = self_phone;
				selffetch_obj.self_date = self_date;
				selffetch_obj.self_time = self_time;
			} else if ($(this).siblings(".tag-orange").data("type") == "friend") {
				var friend_name = $(".js-friend_name").val();
				var friend_phone = $(".js-friend_phone").val();
				var friend_province = $("#friend_province").val();
				var friend_city = $("#friend_city").val();
				var friend_county = $("#friend_county").val();
				var friend_address = $(".js-friend_address").val();
				var friend_date = $(".js-friend_time").eq(0).val();
				var friend_time = $(".js-friend_time").eq(1).val();
				
				friend_obj.friend_name = friend_name;
				friend_obj.friend_phone = friend_phone;
				friend_obj.friend_province = friend_province;
				friend_obj.friend_city = friend_city;
				friend_obj.friend_county = friend_county;
				friend_obj.friend_address = friend_address;
				friend_obj.friend_date = friend_date;
				friend_obj.friend_time = friend_time;
			}
			
			$(this).addClass('tag-orange').siblings('button').removeClass('tag-orange');
			if($(this).data('type') == 'selffetch'){
				$("#confirm-pay-way-opts").find("button").each(function () {
					if ($(this).data("pay-type") == "offline") {
						$(this).show();
					}
				});
				var selffetchListJson = $.parseJSON(selffetchList);
				$('.js-step-topay').removeClass('hide');
				if($('#selffetch_id').val() != '0' && selffetchEdit == false){
					for(var i in selffetchListJson){
						var selffetch = selffetchListJson[i];
						if(selffetch.pigcms_id == $('#selffetch_id').val()){
							var myDate=new Date();
							var dateVal = myDate.getFullYear() + '-' + (myDate.getMonth()<9 ? '0'+(myDate.getMonth()+1) : (myDate.getMonth()+1)) + '-' + (myDate.getDate()<10 ? '0'+myDate.getDate() : myDate.getDate());
							var timeVal = (myDate.getHours()<10 ? '0'+myDate.getHours() : myDate.getHours()) + ':' + (myDate.getMinutes()<10 ? '0'+myDate.getMinutes() : myDate.getMinutes());
							var self_name = '';
							var self_phone = '';
							
							if (typeof selffetch_obj.self_name != 'undefined') {
								self_name = selffetch_obj.self_name;
								self_phone = selffetch_obj.self_phone;
								dateVal = selffetch_obj.self_date;
								timeVal = selffetch_obj.self_time;
							}
							
							
							
							$('.js-logistics-content').html('<div><div class="block block-form block-border-top-none block-border-bottom-none"><div class="js-order-address express-panel" style="padding-left:0;"><div class="opt-wrapper"><a href="javascript:;" class="btn btn-xxsmall btn-grayeee butn-edit-address js-edit-address">修改</a></div><ul><li><span>'+selffetch.name+'</span>, '+selffetch.tel+'</li><li>'+selffetch.province_txt+' '+selffetch.city_txt+' '+selffetch.county_txt+' </li><li>'+selffetch.address+'</li></ul></div><div class="clearfix block-item self-fetch-info-show"><label>预约人</label><input class="txt txt-black ellipsis js-name" placeholder="到店人姓名" value="' + self_name + '" /></div><div class="clearfix block-item   self-fetch-info-show "><label>联系方式</label><input type="text" class="txt txt-black ellipsis js-phone" placeholder="用于短信接收和便于卖家联系" value="' + self_phone + '" /></div><div class="clearfix block-item   self-fetch-info-show "><label class="pull-left">预约时间</label><input style="width:125px" class="txt txt-black js-time pull-left date-time js-self-date" type="date" placeholder="日期" value="'+dateVal+'"/><input style="width:70px" class="txt txt-black js-time pull-left date-time js-self-time" type="time" placeholder="时间" value="'+timeVal+'"/></div></div></div>');
							
							$("#js-postage").html('0.00');
							resetPrice();

							//$('.js-order-total').html('<p>￥'+sub_total.toFixed(2)+' + ￥0.00运费</p><strong class="js-real-pay c-orange js-real-pay-temp">需付：￥'+sub_total.toFixed(2)+'</strong>');
							break;
						}
					}
				}else{
					selffetchEdit = false;
					var selffetchListHtml = '<div class="modal order-modal active"><div class="js-scene-address-list "><div class="address-ui address-list"><div class="block"><div class="js-address-container address-container">';
					for(var i in selffetchListJson){
						business_hours = "";
						if (selffetchListJson[i].business_hours.length > 0) {
							business_hours = "，自营时间：" + selffetchListJson[i].business_hours;
						}
						//selffetchListHtml += '<div><div class="js-address-item block-item" data-id="'+i+'"><h4>'+selffetchListJson[i].name+', '+selffetchListJson[i].tel + business_hours +'</h4><span class="address-str address-str-sf">'+selffetchListJson[i].province_txt+selffetchListJson[i].city_txt+selffetchListJson[i].county_txt+selffetchListJson[i].address+'</span><div class="address-opt"></div></div></div>';
						
						selffetchListHtml += '<div class="block block-order">';
						selffetchListHtml += '	<div class="store-header header">';
						selffetchListHtml += '		<span>店铺：' + selffetchListJson[i].name + '</span>&nbsp;&nbsp;<button type="button" class="js-address-item btn btn-green" data-id="' + i + '">选择此门店</button>';
						selffetchListHtml += '	</div>';
						selffetchListHtml += '	<hr class="margin-0 left-10"/>';
						selffetchListHtml += '	<div class="name-card name-card-3col name-card-store clearfix">';
						selffetchListHtml += '		<a href="javascript:;" class="thumb js-view-image-list"><img class="js-view-image-item " src="' + selffetchListJson[i].logo + '"/></a>';
						selffetchListHtml += '		<a href="tel:' + selffetchListJson[i].tel + '"><div class="phone"></div></a>';
						
						if (selffetchListJson[i].pigcms_id == '99999999_store') {
							selffetchListHtml += '		<a class="detail" target="_blank" href="./physical_detail.php?store_id=' + selffetchListJson[i].store_id + '">';
						} else {
							selffetchListHtml += '		<a class="detail" target="_blank" href="./physical_detail.php?id=' + selffetchListJson[i].pigcms_id + '">';
						}
						
						selffetchListHtml += '			<h3>' + selffetchListJson[i].province_txt + selffetchListJson[i].city_txt + selffetchListJson[i].county_txt + selffetchListJson[i].address + '</h3>';
						if (selffetchListJson[i].business_hours.length > 0) {
							selffetchListHtml += '			<p class="c-gray-dark ellipsis" style="margin-top:5px">营业时间：' + selffetchListJson[i].business_hours + '</p>';
						}
						selffetchListHtml += '		</a>';
						
						if (long != 0 && lat != 0 && selffetchListJson[i].long != 0 && selffetchListJson[i].lat != 0) {
							store_juli = 0;
							try {
								store_juli = (getFlatternDistance(lat, long, selffetchListJson[i].lat, selffetchListJson[i].long) / 1000).toFixed(2);
							} catch (e) {
								store_juli = 0;
							}
							
							if (store_juli > 0) {
								selffetchListHtml += "&nbsp;&nbsp;距离：" + store_juli + "km";
							}
						}
						
						selffetchListHtml += '	</div>';
						if (selffetchListJson[i].description.length > 0) {
							selffetchListHtml += '	<hr/>';
							selffetchListHtml += '	<div class="name-card-bottom c-gray-dark">商家推荐：' + selffetchListJson[i].description + '</div>';
						}
						selffetchListHtml += '</div>';
					}
					selffetchListHtml += '</div></div><div class="action-container"><button type="button" class="js-cancel btn btn-block">返回</button></div></div></div>';
					var selffetchListDom = $(selffetchListHtml);
					
					
					$('body').append(selffetchListDom);
					
					selffetchListDom.find('.js-cancel').click(function(){
						if($('#selffetch_id').val() == '0'){
							$('.js-tabber-self-fetch').removeClass('tag-orange').siblings('button').trigger('click');
						}
						selffetchListDom.remove();
					});

					selffetchListDom.find('.js-address-item').click(function(){
						var selffetch = selffetchListJson[$(this).data('id')];
						var myDate=new Date();
						var dateVal = myDate.getFullYear() + '-' + (myDate.getMonth()<9 ? '0'+(myDate.getMonth()+1) : (myDate.getMonth()+1)) + '-' + (myDate.getDate()<10 ? '0'+myDate.getDate() : myDate.getDate());
						var timeVal = (myDate.getHours()<10 ? '0'+myDate.getHours() : myDate.getHours()) + ':' + (myDate.getMinutes()<10 ? '0'+myDate.getMinutes() : myDate.getMinutes());
						
						business_hours = "";
						if (selffetch.business_hours.length > 0) {
							business_hours = "，自营时间：" + selffetch.business_hours;
						}
						$('.js-logistics-content').html('<div><div class="block block-form block-border-top-none block-border-bottom-none"><div class="js-order-address express-panel" style="padding-left:0;"><div class="opt-wrapper"><a href="javascript:;" class="btn btn-xxsmall btn-grayeee butn-edit-address js-edit-address">修改</a></div><ul><li><span>'+selffetch.name+'</span>, '+selffetch.tel + business_hours +'</li><li>'+selffetch.province_txt+' '+selffetch.city_txt+' '+selffetch.county_txt+' </li><li>'+selffetch.address+'</li></ul></div><div class="clearfix block-item self-fetch-info-show"><label>预约人</label><input class="txt txt-black ellipsis js-name" placeholder="到店人姓名"/></div><div class="clearfix block-item   self-fetch-info-show "><label>联系方式</label><input type="text" class="txt txt-black ellipsis js-phone" placeholder="用于短信接收和便于卖家联系" /></div><div class="clearfix block-item   self-fetch-info-show "><label class="pull-left">预约时间</label><input style="width:125px" class="txt txt-black js-time pull-left date-time js-self-date" type="date" placeholder="日期" value="'+dateVal+'"/><input style="width:70px" class="txt txt-black js-time pull-left date-time js-self-time" type="time" placeholder="时间" value="'+timeVal+'"/></div></div></div>');
						$('#selffetch_id').val(selffetch.pigcms_id);
						
						$("#js-postage").html('0.00');
						resetPrice();

						//$('.js-order-total').html('<p>￥'+sub_total.toFixed(2)+' + ￥0.00运费</p><strong class="js-real-pay c-orange js-real-pay-temp">需付：￥'+sub_total.toFixed(2)+'</strong>');
						selffetchListDom.remove();
					});
				}
			} else if ($(this).data('type') == 'friend') {
				if (l_friend) {
					$('.js-step-topay').removeClass('hide');
					$('.js-logistics-tips').addClass('hide');
				} else {
					$('.js-step-topay').addClass('hide');
					$('.js-logistics-tips').removeClass('hide');
				}
				
				$("#confirm-pay-way-opts").find("button").each(function () {
					if ($(this).data("pay-type") == "offline") {
						$(this).hide();
					}
				});
				
				var friend_name = '';
				var friend_phone = '';
				var friend_province = '';
				var friend_city = '';
				var friend_county = '';
				var friend_address = '';
				var myDate=new Date();
				var dateVal = myDate.getFullYear() + '-' + (myDate.getMonth()<9 ? '0'+(myDate.getMonth()+1) : (myDate.getMonth()+1)) + '-' + (myDate.getDate()<10 ? '0'+myDate.getDate() : myDate.getDate());
				var timeVal = (myDate.getHours()<10 ? '0'+myDate.getHours() : myDate.getHours()) + ':' + (myDate.getMinutes()<10 ? '0'+myDate.getMinutes() : myDate.getMinutes());
				
				
				if (typeof friend_obj.friend_name != "undefined") {
					friend_name = friend_obj.friend_name;
					friend_phone = friend_obj.friend_phone;
					friend_province = friend_obj.friend_province;
					friend_city = friend_obj.friend_city;
					friend_county = friend_obj.friend_county;
					friend_address = friend_obj.friend_address;
					dateVal = friend_obj.friend_date;
					timeVal = friend_obj.friend_time;
				}
				
				var html = '<div>\
								<div class="block block-form block-border-top-none block-border-bottom-none">\
								<div class="clearfix block-item self-fetch-info-show">\
									<label>朋友姓名</label>\
									<input class="txt txt-black ellipsis js-friend_name" placeholder="朋友姓名" value="' + friend_name + '" />\
								</div>\
								<div class="clearfix block-item self-fetch-info-show ">\
									<label>联系方式</label>\
									<input type="text" class="txt txt-black ellipsis js-friend_phone" placeholder="用于短信接收和便于卖家联系" value="' + friend_phone + '" />\
								</div>\
								<div class="clearfix block-item self-fetch-info-show ">\
									<label>选择地区</label>\
										<span>\
										<select id="friend_province" name="friend_province" class="address-province" style="width:80px; margin:0px;">\
											<option>省</option>\
										</select>\
									</span>\
									<span>\
										<select id="friend_city" name="friend_city" class="address-city" style="width:80px; margin:0px;">\
											<option>城市</option>\
										</select>\
									</span>\
									<span>\
										<select id="friend_county" name="friend_county" class="address-county" style="width:80px; margin:0px;">\
											<option>区县</option>\
										</select>\
									</span>\
								</div>\
								<div class="clearfix block-item self-fetch-info-show ">\
									<label>详细地址</label>\
									<input type="text" class="txt txt-black ellipsis js-friend_address" placeholder="详细地址" value="' + friend_address + '" />\
								</div>\
								<div class="clearfix block-item friend-info-show ">\
									<label class="pull-left">预约时间</label>\
									<input style="width:125px" class="txt txt-black js-friend_time pull-left date-time" type="date" placeholder="日期" value="'+dateVal+'"/>\
									<input style="width:70px" class="txt txt-black js-friend_time pull-left date-time" type="time" placeholder="时间" value="'+timeVal+'"/>\
								</div>\
							</div>\
							<div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">很抱歉，该地区暂不支持配送。</div>\
						</div>';
				
				$('.js-logistics-content').html(html);
				
				$('#friend_province').change(function(){
					if($(this).val() != ''){
						getPostage('friend');
						getCitys('friend_city','friend_province','','城市');
					}else{
						$('#friend_city').html('<option>城市</option>');
					}
					$('#friend_county').html('<option>区县</option>');
				});
				$('#friend_city').change(function(){
					if($(this).val() != ''){
						getAreas('friend_county','friend_city','','区县');
					}else{
						$('#friend_county').html('<option>区县</option>');
					}
				});
				
				getProvinces('friend_province',friend_province,'省份');
				if (friend_city != '') {
					getCitys('friend_city','friend_province',friend_city,'城市');
				}
				if (friend_county != '') {
					getAreas('friend_county','friend_city',friend_county,'区县');
				}
			}else{
				$("#confirm-pay-way-opts").find("button").each(function () {
					if ($(this).data("pay-type") == "offline") {
						$(this).show();
					}
				});
				if (l_express == true) {
					$('.js-step-topay').removeClass('hide');
					$('.js-logistics-tips').addClass('hide');
				} else {
					$('.js-step-topay').addClass('hide');
					$('.js-logistics-tips').removeClass('hide');
				}
				if($('#address_id').val() != '0'){
					var nowAdress = addressList[$('#address_id').val()];
                    var area_text = '';
                    if (__alldiv[nowAdress.area][0] != '市辖区' && __alldiv[nowAdress.area][0] != '县') {
                        area_text = __alldiv[nowAdress.area][0];
                    }
					$('.js-logistics-content').html('<div><div class="block block-form block-border-top-none block-border-bottom-none"><div class="js-order-address express-panel" style="padding-left:0;"><div class="opt-wrapper"><a href="javascript:;" class="btn btn-xxsmall btn-grayeee butn-edit-address js-edit-address">修改</a></div><ul><li><span>'+nowAdress.name+'</span>, '+nowAdress.tel+'</li><li>'+__alldiv[nowAdress.province][0]+' '+__alldiv[nowAdress.city][0]+' '+area_text+' </li><li>'+nowAdress.address+'</li></ul></div></div><div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">很抱歉，该地区暂不支持配送。</div></div>');

					$("#js-postage").html(postage);
					resetPrice();
					//$('.js-order-total').html('<p>￥'+sub_total.toFixed(2)+' + ￥'+postage.toFixed(2)+'运费</p><strong class="js-real-pay c-orange js-real-pay-temp">需付：￥'+(sub_total+postage.toFixed(2))+'</strong>');
				}else{
					$('.js-logistics-content').html('<div><div class="js-order-address express-panel"><div class="js-edit-address address-tip"><span>添加收货地址</span></div></div></div>');
				}
			}
		}
	});
	
	$('.js-order-address .opt-wrapper .js-edit-address').live('click',function(){
		/*优先判断到店自提*/
		if(selffetchList && $('.js-tabber-self-fetch').hasClass('tag-orange')){
			selffetchEdit = true;
			$('.js-tabber-self-fetch').removeClass('tag-orange').trigger('click');
		}else{
			// if(!isLogin){
				var nowAdress = addressList[$('#address_id').val()];
				editAdress(function(){
					$('#addAdress input[name="user_name"]').val(nowAdress.name);
					$('#addAdress input[name="tel"]').val(nowAdress.tel);
					$('#addAdress input[name="address"]').val(nowAdress.address);
					$('#addAdress input[name="zipcode"]').val(nowAdress.zipcode);
					
					getProvinces('province',nowAdress.province);
					getCitys('city','province',nowAdress.city,'城市');
					getAreas('county','city',nowAdress.area,'区县');
				},nowAdress.address_id);
			// }
		}
	});
	
	//页面初始化
	if($('.js-order-address > .js-edit-address').size()){
		if (is_logistics) {
			$('.js-order-address > .js-edit-address').trigger('click');
		}
	}else{
		//if($('.js-step-topay').hasClass('hide')){
			getPostage();
		//}
		refreshAdress();
	}
	
	if ($(".js-order-address > .js-selffetch-address").size() && is_selffetch) {
		$('.js-logistics-select button').trigger('click');
	}
	
	$(".js-selffetch-address").click(function () {
		$('.js-logistics-select button').trigger('click');
	});
	
	
	$('.js-msg-container').focus(function(){
		$(this).addClass('two-rows');
	}).blur(function(){
		$(this).removeClass('two-rows');
	});
	var nowScroll=0;
	var payShowAfter = function(){
		$('html').css({'overflow':'visible','height':'auto','position':'static'});
		$('body').css({'overflow':'visible','height':'auto','padding-bottom':'45px'});
		$(window).scrollTop(nowScroll);
	}
	$('#confirm-pay-way-opts .btn-pay').click(function(){
		if (!is_logistics && !is_selffetch) {
			motify.log('商家未设置配送方式，暂时不能购买');
			return;
		}
		
		var payType = $(this).data('pay-type');
		var post_data = {payType:payType,orderNo:orderNo,msg:$('.js-msg-container').val()};
		if($('#address_id').size() > 0){
			if($('.js-tabber-self-fetch').hasClass('tag-orange')){
				var selffetch_id = $('#selffetch_id').val();
				var selffetch_name = $.trim($('.js-logistics-content .js-name').val());
				var selffetch_phone = $.trim($('.js-logistics-content .js-phone').val());
				if(parseInt(selffetch_id) < 1){
					motify.log('请选择自提点');
					return false;
				}else if(selffetch_name.length == 0){
					motify.log('请填写您的姓名');
					return false;
				}else if(!/^0[0-9\-]{10,13}$/.test(selffetch_phone) && !/^((\+86)|(86))?(1)\d{10}$/.test(selffetch_phone)){
					motify.log('请填写正确的联系方式');
					return false;
				}else{
					post_data.shipping_method = 'selffetch';
					post_data.selffetch_id = selffetch_id;
					post_data.selffetch_name = selffetch_name;
					post_data.selffetch_phone = selffetch_phone;
					post_data.selffetch_date = $('.js-logistics-content .js-time').eq(0).val();
					post_data.selffetch_time = $('.js-logistics-content .js-time').eq(1).val();
				}
			} else if ($(".js-tabber-friend").hasClass("tag-orange")) {
				var friend_name = $(".js-friend_name").val();
				var friend_phone = $(".js-friend_phone").val();
				var province = $("#friend_province").val();
				var city = $("#friend_city").val()
				var county = $("#friend_county").val();
				var friend_address = $(".js-friend_address").val();
				
				if (friend_name.length == 0) {
					motify.log("请填写朋友姓名");
					return false;
				}
				if(!/^0[0-9\-]{10,13}$/.test(friend_phone) && !/^((\+86)|(86))?(1)\d{10}$/.test(friend_phone)){
					motify.log("请填写正确的联系方式");
					return false;
				}
				if (province.length == 0) {
					motify.log("请选择省");
					return false;
				}
				if (city.length == 0) {
					motify.log("请选择城市");
					return false;
				}
				if (county.length == 0) {
					motify.log("请选择区县");
					return false;
				}
				if (friend_address.length == 0) {
					motify.log("请填写详细地址");
					return false;
				}
				if (friend_address.length < 10) {
					motify.log("详细地址不能少于10个字符");
					return false;
				}
				
				post_data.shipping_method = "friend";
				post_data.friend_name = friend_name;
				post_data.friend_phone = friend_phone;
				post_data.province = province;
				post_data.city = city;
				post_data.county = county;
				post_data.friend_address = friend_address;
				post_data.friend_date = $('.js-logistics-content .js-time').eq(0).val();
				post_data.friend_time = $('.js-logistics-content .js-time').eq(1).val();
			} else {
				if(parseInt($('#address_id').val()) < 1){
					motify.log('请选择收货地址');
					return false;
				}else{
					post_data.address_id = $('#address_id').val();
				}
			}
		}
		
		try {
			if ($("input[name='user_coupon_id']").length > 0) {
				post_data.user_coupon_id = $("input[name='user_coupon_id']:checked").val();
			}
		} catch(e) {

		}


		var loadingCon = $('<div style="overflow:hidden;visibility:visible;position:absolute;z-index:1100;transition:opacity 300ms ease;-webkit-transition:opacity 300ms ease;opacity:1;top:'+(($(window).height()-100)/2)+'px;left:'+(($(window).width()-200)/2)+'px;"><div class="loader-container"><div class="loader center">处理中</div></div></div>');
		var loadingBg = $('<div style="height:100%;position:fixed;top:0px;left:0px;right:0px;z-index:1000;opacity:1;transition:opacity 0.2s ease;-webkit-transition:opacity 0.2s ease;background-color:rgba(0,0,0,0.901961);"></div>');
		$('html').css({'position':'relative','overflow':'hidden','height':$(window).height()+'px'});
		$('body').css({'overflow':'hidden','height':$(window).height()+'px','padding':'0px'}).append(loadingCon).append(loadingBg);
		nowScroll = $(window).scrollTop();

        if ($(this).hasClass('go-pay')) {
            $.post('saveorder.php?action=go_pay',post_data,function(result){
                if (!result.err_code) {
                    window.location.href = result.err_msg;
                } else {
                    motify.log(result.err_msg);
                }
            })
            return true;
        }
		$.post('saveorder.php?action=pay',post_data,function(result){
			payShowAfter();
			loadingBg.css('opacity',0);
			setTimeout(function(){
				loadingCon.remove();loadingBg.remove();
			},200);
			if(typeof(result) == 'object'){
				if(result.err_code == 0){
					if(payType == 'weixin' && window.WeixinJSBridge){
						window.WeixinJSBridge.invoke("getBrandWCPayRequest",result.err_msg,function(res){
							WeixinJSBridge.log(res.err_msg);
							if(res.err_msg=="get_brand_wcpay_request:ok"){
								window.location.href = './order.php?orderno='+orderNo;
							}else{
								if(res.err_msg == "get_brand_wcpay_request:cancel"){
									var err_msg = "您取消了微信支付";
								}else if(res.err_msg == "get_brand_wcpay_request:fail"){
									var err_msg = "微信支付失败<br/>错误信息："+res.err_desc;
								}else{
									var err_msg = res.err_msg +"<br/>"+res.err_desc;
								}
								motify.log(err_msg);
							}
						});
					}else{
						window.location.href = result.err_msg;
					}
				}else{
					if(result.err_code == 1008){
						motify.log("此订单为货到付款，现在无须支付");
						window.location.href = result.err_msg;
						return;
					}
					
					motify.log(result.err_msg);
					if(result.err_code == 1007){
						window.location.href = './order.php?orderno='+orderNo;
					}
				}
			}else{
				motify.log(result.err_msg);
				// motify.log('访问异常，请重试');
			}
		});
	});

	// 更改优惠券
	$("input[name='user_coupon_id']").click(function () {
		var user_coupon = parseFloat($(this).closest("p").find("span").html());
		user_coupon = user_coupon.toFixed(2)

		if ($("#js-user_coupon").length > 0) {
			$("#js-user_coupon").html(user_coupon);
		}
		resetPrice();
	});
	
	if ($(".js-logistics-select .js-tabber-self-fetch").size() > 0) {
		if (is_selffetch) {
			getLocation();
		}
	}
});


function resetPrice() {
	var postage1 = parseFloat($("#js-postage").html());
	var sub_total = parseFloat($("#js-sub_total").html());
	var reward = 0;
	var user_coupon = 0;
	var float_amount = 0;

	if ($("#js-reward").length > 0) {
		reward = parseFloat($("#js-reward").html());
	}

	if ($("#js-user_coupon").length > 0) {
		user_coupon = parseFloat($("#js-user_coupon").html());
	}

	if ($("#js-float_amount").length > 0) {
		float_amount = parseFloat($("#js-float_amount").html());
	}

	$("#js-total").html(sub_total + postage1 - reward - user_coupon - float_amount);
}



var long = 0;
var lat = 0;
function getLocation() {
	var options = {
		enableHighAccuracy:true, 
		maximumAge:1000
	}
	if(navigator.geolocation) {
		//浏览器支持geolocation
		navigator.geolocation.getCurrentPosition(onSuccess, onError, options);
	} else {
		//浏览器不支持geolocation
	}
}

//成功时
function onSuccess(position){
	long = position.coords.longitude;
	lat = position.coords.latitude;
}

//失败时
function onError(error) {
}

function getFlatternDistance(lat1,lng1,lat2,lng2){
	lat1 = parseFloat(lat1);
	lng1 = parseFloat(lng1);
	lat2 = parseFloat(lat2);
	lng2 = parseFloat(lng2);

	var f = getRad((lat1 + lat2)/2);
	var g = getRad((lat1 - lat2)/2);
	var l = getRad((lng1 - lng2)/2);

	var sg = Math.sin(g);
	var sl = Math.sin(l);
	var sf = Math.sin(f);

	var s,c,w,r,d,h1,h2;
	var a = EARTH_RADIUS;
	var fl = 1/298.257;

	sg = sg*sg;
	sl = sl*sl;
	sf = sf*sf;

	s = sg*(1-sl) + (1-sf)*sl;
	c = (1-sg)*(1-sl) + sf*sl;

	w = Math.atan(Math.sqrt(s/c));
	r = Math.sqrt(s*c)/w;
	d = 2*w*a;
	h1 = (3*r -1)/2/c;
	h2 = (3*r +1)/2/s;

	return d*(1 + fl*(h1*sf*(1-sg) - h2*(1-sf)*sg));
}

/*获取位置距离*/
var EARTH_RADIUS = 6378137.0;	//单位M
var PI = Math.PI;

function getRad(d) {
	return d*PI/180.0;
}