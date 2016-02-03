var category_list = [];
var swiper2 = null;
var user_long=0,user_lat=0;
$(function(){
	FastClick.attach(document.body);
	$('#topSearchTxt').focus(function(){
		$('.WX_search_frm').addClass('WX_search_frm_focus');
		$('#topSearchCbtn').show();
	}).blur(function(){
		$('.WX_search_frm').removeClass('WX_search_frm_focus');
		$('#topSearchCbtn').hide();
	}).keyup(function(e){
		var val = $.trim($(this).val());
		if(e.keyCode == 13){
			if(val.length > 0){
				window.location.href = './category.php?keyword='+encodeURIComponent($(this).val());
			}else{	
				motify.log('请输入搜索关键词');
			}
		}
	}).bind('input',function(){
		if($(this).val().length > 0){
			$('#topSearchClear').show();
		}else{
			$('#topSearchClear').hide();
		}
	});
	$('#topSearchClear,#topSearchCbtn').click(function(){
		$('#topSearchTxt').val('');
		$('#topSearchClear').hide();
	});
	sonCatStoreListObj = $.parseJSON(sonCatStoreList);
	$('.wei_tag_box a').click(function(){
		if(!$(this).hasClass('cur')){
			$(this).addClass('cur').siblings().removeClass('cur');
			var tmpHtml = '';
			var nowSonCat = sonCatStoreListObj[$(this).data('index')];
			for(var i in nowSonCat){
				tmpHtml+= '<div class="item"><a href="'+nowSonCat[i].url+'" class="url"><div class="img"><img src="'+nowSonCat[i].logo+'"></div><div class="info"><div class="name">'+nowSonCat[i].name+'</div></div></a></div>';
			}
			$(this).closest('.wei_section').find('.wei_shop_list').html(tmpHtml);
		}
	});
	$('#aRecommendShopBtn').click(function(){
		$(this).addClass('cur').siblings().removeClass('cur');
		$('#divFollowShop').hide();
		$('#divRecommendShop').show();
		$('.wx_loading2').addClass('hide');
	});
	$('#aFollowShopBtn').click(function(){
		$(this).addClass('cur').siblings().removeClass('cur');
		$('#arroundErrorTip').empty().hide();
		$('#divRecommendShop').hide();
		$('#divFollowShop').show();
		$('.wx_loading2').removeClass('hide');
		if(user_long == '0' || user_lat == '0'){
			//检查浏览器是否支持地理位置获取 
			if (navigator.geolocation){ 
				//若支持地理位置获取,成功调用showPosition(),失败调用showError 
				var config = {enableHighAccuracy:true,timeout:30000}; 
				navigator.geolocation.getCurrentPosition(showPosition,showError,config);
			}else{
				arroundErrorTips("地理位置定位失败,您的浏览器不支持或已禁用获取地理位置权限<br/>"); 
			}
		}else{
			get_near_shops();
		}
	});
});

/** 
* 获取地址位置成功 
*/ 
function showPosition(position){
	//获得经度纬度 
	user_lat  = position.coords.latitude;
	user_long = position.coords.longitude;
	get_near_shops();
}
/** 
* 获取地址位置失败[暂不处理] 
*/ 
function showError(error){
	$('#near_dom').remove();
	switch (error.code){
		case error.PERMISSION_DENIED: 
			arroundErrorTips("地理位置定位失败,用户拒绝请求获取地理位置"); 
			break; 
		case error.POSITION_UNAVAILABLE: 
			arroundErrorTips("地理位置定位失败,地理位置信息不可用"); 
			break; 
		case error.TIMEOUT: 
			arroundErrorTips("地理位置定位失败,请求获取用户地理位置超时"); 
			break; 
		case error.UNKNOWN_ERROR:
			arroundErrorTips("地理位置定位失败,地理位置定位系统失效");
			break; 
	} 
}
function arroundErrorTips(msg){
	$('#divEmptyFollow').css('padding','15px 0');
	$('.wx_loading2').addClass('hide');
	$('#arroundErrorTip').html(msg).show();
}
/** 
* 获取附近商家
*/
function get_near_shops(){
	$.post('./index_ajax.php?action=nearshops',{'long':user_long,'lat':user_lat},function(result){
		if(result.err_code){
			arroundErrorTips(result.err_msg);
		}else{
			var near_content = '';
			$.each(result.err_msg,function(i,item){
				near_content += '<div class="wei_item wei_item_foc"><a href="javascript:;" class="wei_logo"><p>'+item.name+'</p></a><a href="'+item.url+'" class="btn_enter">去逛逛</a><ul class="wei_goods">';
				$.each(item.product_list,function(j,jtem){
					near_content += '<li><a href="'+jtem.url+'"><div class="cover"><img src="'+jtem.image+'"/></div><p class="cost"><span class="price">¥'+jtem.price+'</span><!--span class="price_old">'+(jtem.original_price != '0.00' ? '¥'+jtem.original_price : '')+'</span--></p></a></li>';
				});
				near_content += '</ul><ul class="news"><li><div class="info" style="max-height:36px;white-space:normal;">'+item.intro+'</div><div style="position:absolute;right:0px;top:5px;">'+getRange(item.juli)+'</div></li></ul></div>';
			});
			$('#divMyShopList').html(near_content).show();
			$('.wx_loading2').addClass('hide');
			$('#divEmptyFollow').css('padding','7px 0');
		}
	});
}

function getRange(range){
	range = parseInt(range);
	if(range < 1000){
		return range+'m';
	}else if(range<5000){
		return (range/1000).toFixed(2)+'km';
	}else if(range<10000){
		return (range/1000).toFixed(1)+'km';
	}else{
		return Math.floor(range/1000)+'km';
	}
}
