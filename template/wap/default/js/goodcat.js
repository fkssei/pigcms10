$(function(){
	$('.js-goods-buy').live('click',function(e){
		var btn = $(this).siblings('.goods-buy');
		btn.addClass('ajax-loading');
		skuBuy($(this).attr('data-id'),0,function(){
			btn.removeClass('ajax-loading');
		});
		return false;
	});
	
	$('.js-goods-list .js-goods').live('click',function(e){
		window.location.href = $(this).attr('href');
		return false;
	});
});