var category_list = [];
var swiper2 = null;
$(function(){
	FastClick.attach(document.body);
	$(window).resize(function(){
		//window.location.reload();
	});
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
	$.ajax({
		type:"POST",
		url:'index_ajax.php?action=get_category',
		dataType:'json',
		success:function(result){
			$('.wx_loading2').hide();
			if(result.err_code){
				motify.log(result.err_msg);
			}else{
				category_list = result.err_msg;
				var yScroll1Html = '';
				for(var i in category_list){
					yScroll1Html+= '<li data-id="'+i+'" class="swiper-slide">'+category_list[i].cat_name+'</li>';
				}
				
				if(window.location.hash != ''){
					var locationHash = parseInt(window.location.hash.substr(1));
					if(locationHash > 0){
						show_son_category(locationHash);
						$('#allcontent').html(yScroll1Html).find('li[data-id="'+locationHash+'"]').addClass('cur');
					}else{
						$('#allcontent').html(yScroll1Html).find('li:first').addClass('cur');
						show_son_category($('#allcontent li:first').data('id'));
					}
				}else{
					$('#allcontent').html(yScroll1Html).find('li:first').addClass('cur');
					show_son_category($('#allcontent li:first').data('id'));
				}
				$('#allcontent li').click(function(){
					// window.location.hash = $(this).data('id');
					$(this).addClass('cur').siblings().removeClass('cur');
					show_son_category($(this).data('id'));
				});
							
				$('.wx_wrap').show();
				// $('.wx_wrap,#yScroll1,#allcontent').height($(window).height()-$('.WX_search').height()-1);
				$('.wx_wrap,#yScroll1,#yScroll2,#category2,.swiper-container,.swiper-container2,#allcontent').height($(window).height()-$('.WX_search').height()-1);
				$('#yScroll2').width($(window).width()-76);
				$('.swiper-container').swiper({
					mode: 'vertical',
					cssWidthAndHeight:true,
					slidesPerView:'auto',
					freeModeFluid : true,
					freeMode : true
				});
				swiper2 = new Swiper('.swiper-container2',{
					mode: 'vertical',
					cssWidthAndHeight:true,
					slidesPerView:'auto',
					freeModeFluid : true,
					freeMode : true
				});
			}
		},
		error:function(){
			$('.wx_loading2').hide();
			motify.log('商品分类读取失败，<br/>请刷新页面重试',0);
		}
	});
});

function show_son_category(id){
	var tmp_category = category_list[id];
	var tmp_son_category = tmp_category.cat_list
	// var yScroll2Html = '<dt>'+tmp_category.cat_name+'</dt><dd class="swiper-slide">';
	var yScroll2Html = '<dd class="swiper-slide">';
	for(var i in tmp_son_category){
		yScroll2Html+= '<a href="./category.php?keyword='+encodeURIComponent(tmp_son_category[i].cat_name)+'&id='+(tmp_son_category[i].cat_id)+'"><img src="'+(tmp_son_category[i].cat_pic)+'" alt="'+(tmp_son_category[i].cat_name)+'"/><span class="tit">'+(tmp_son_category[i].cat_name)+'</span></a>';
	}
	yScroll2Html    += '</dd>';
	$('#category2').html(yScroll2Html);
	if(swiper2){
		swiper2.setWrapperTranslate(0,0,0);
		swiper2.reInit();
	}
}