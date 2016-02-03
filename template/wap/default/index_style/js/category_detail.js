var productPage = 1;
var productIsAjax = false;
var productSort = 'default';
var productShowRows = false;
$(function(){
	FastClick.attach(document.body);
	$(window).scroll(function(){
		if(productPage > 1 && $(window).scrollTop()/($('body').height() -$(window).height())>=0.95){
			if(productIsAjax == false){
				getProducts();
			}
		}
		if($(document).scrollTop() > 50){
			$('.mod_filter').css('top',0);
		}else{
			$('.mod_filter').css('top',45);
		}
	});
	if($(window).width() < 400){
		// alert(111);
		productShowRows = true;
		$('#itemList').addClass('mod_itemlist_small').removeClass('mod_itemgrid');
		$('#sortBlock .icon_switch').closest('a').removeClass('state_switch');
	}
	$('#sortBlock a').click(function(){
		var sortType = $(this).data('type');
		
		if (sortType == 'prop') {
			$("html,body").animate({scrollTop: 0}, 0)
			$(".sidebar-content").show();
			$("body").addClass("body_no_scroll");
			return;
		}
		if(sortType == 'listmode'){
			if(productShowRows){
				$(this).addClass('state_switch');
				productShowRows = false;
				$('#itemList').addClass('mod_itemgrid').removeClass('mod_itemlist_small').find('.hproduct').addClass('item_long_cover');
			}else{
				$(this).removeClass('state_switch');
				productShowRows = true;
				$('#itemList').addClass('mod_itemlist_small').removeClass('mod_itemgrid').find('.hproduct').removeClass('item_long_cover');
			}
		}else{
			if(sortType == 'price'){
				if($(this).data('mark') == 1){
					$(this).data('mark',2).removeClass('state_switch').addClass('select').siblings().removeClass('select');
					productSort = 'price_asc';
				}else{
					$(this).data('mark',2).addClass('select state_switch').siblings().removeClass('select');
					$(this).data('mark',1);
					productSort = 'price_desc';
				}

			}else{
				$(this).addClass('select').siblings().removeClass('select');
				$('#sortBlock .icon_sort').closest('a').removeClass('select state_switch').data('mark',1);
				productSort = sortType;
			}
			$('#noMoreTips,#sFound,#itemList').addClass('hide');
			productIsAjax = false;
			$('#itemList').empty();
			productPage = 1;	
			$('.wx_loading2').show();
			getProducts();		
		}
	});
	getProducts();
	$('#topSearchClear').click(function(){
		$('#topSearchTxt').val('');
		$(this).hide();
		// location.href = './category.php';
	});
	$('#itemList .hproduct').live('click',function(){
		$(this).addClass('active').siblings('.hproduct').removeClass('active');
	});
	
	$(".sidebar-list li a").click(function () {
		var prop_ul_obj = $(this).parent().find("ul");
		var prop_display = prop_ul_obj.css("display");
		if (prop_display == "none") {
			prop_ul_obj.slideDown(600);
			$(this).parent().addClass("opened");
		} else {
			prop_ul_obj.slideUp(600);
			$(this).parent().removeClass("opened");
		}
	});
	
	$(".tab-con li").click(function () {
		if ($(this).hasClass("checked")) {
			$(this).closest(".opened").find("small").html("全部");
			$(this).removeClass("checked");
		} else {
			$(this).closest(".opened").find("small").html($(this).find("span").html());
			$(this).addClass("checked");
			
			$(this).siblings().removeClass("checked");
		}
	});
	
	$(".J_search_prop").click(function () {
		//window.scrollTo(0, 0); 
		$("body").removeClass("body_no_scroll");
		$(".sidebar-content").hide();
		
		prop = "";
		$(".sidebar-items-container").find(".checked").each(function () {
			if (prop.length == 0) {
				prop = $(this).data("prop_id");
			} else {
				prop += "_" + $(this).data("prop_id");
			}
		});
		
		$('#noMoreTips,#sFound,#itemList').addClass('hide');
		productIsAjax = false;
		$('#itemList').empty();
		productPage = 1;	
		$('.wx_loading2').show();
		getProducts();
	});
	
	$(".J_search_reset").click(function () {
		$(".sort-of-brand").html("全部");
		$(".sidebar-categories li").removeClass("checked");
		
		prop = "";
	});
});

var prop = "";
function getProducts(){
	$('.wx_loading2').show();
	productIsAjax = true;
	
	$.ajax({
		type:"POST",
		url:'index_ajax.php?action=get_product_list',
		data:'keyword='+keyword+'&key_id='+key_id+'&page='+productPage+'&sort='+productSort + "&prop=" + prop,
		dataType:'json',
		success:function(result){
			$('.wx_loading2').hide();
			if(result.err_code){
				motify.log(result.err_msg);
			}else{	
				if(result.err_msg.list.length > 0){
					if(result.err_msg.count){
						$('#sFound').removeClass('hide').find('#totResult').html(result.err_msg.count);
					}
					var productHtml = '';
					for(var i in result.err_msg.list){
						var product = result.err_msg.list[i];
						productHtml+= '<div class="hproduct '+(productShowRows ? '' : 'item_long_cover')+'"> <a href="./good.php?id='+product.product_id+'&platform=1"><p class="cover"><img src="'+product.image+'"></p><p class="fn">'+product.name+'</p><p class="prices"><strong><em>¥'+product.price+'</em></strong></p><p class="sku"><span class="comment_num '+(product.sales=='0' ? 'hide' : '')+'">销量 <span>'+product.sales+'</span></span>&nbsp;<span class="stock hide">无货</span></p></a></div>';
					}
					$('#itemList').append(productHtml).removeClass('hide');		
				
					if(typeof(result.err_msg.noNextPage) == 'undefined'){
						productIsAjax = false;
					}else{
						$('#noMoreTips').removeClass('hide');
					}
				}else{
					if(productPage == 1){
						$('#sNull01').removeClass('hide');
					}else{
						$('#noMoreTips').removeClass('hide');
					}
				}
				productPage ++;
			}
		},
		error:function(){
			$('.wx_loading2').hide();
			motify.log('商品分类读取失败，<br/>请刷新页面重试',0);
		}
	});
}

