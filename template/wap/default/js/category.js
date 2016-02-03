$(function(){
	FastClick.attach(document.body);
	$('#title-text').click(function(){
		var caretDom = $(this).find('.caret');
		if(!caretDom.hasClass('up')){
			caretDom.addClass('up');
			$('#cate_list').show();
		}else{
			caretDom.removeClass('up');
			$('#cate_list').hide();
		}
	});
	$('.top-search').click(function(){
		$('body').append('<div id="search-box" style="position:fixed;top:0px;bottom:0px;z-index:1000;width:100%;display:block;background:rgba(0,0,0,0.498039);"><div class="details-head" style="width:100%;height:90px;text-align:left;padding:15px;-webkit-box-sizing:border-box;box-sizing:border-box;"><input id="keyword" type="search" style="-webkit-box-sizing:border-box;box-sizing:border-box;padding:10px;padding-left:15px;height:60px;width:75%;border:0;font-size:28px;border-radius:0;float:left;" placeholder="请输入关键字"/> <a style="color:#fff;font-size:34px;display:inline-block;width:25%;text-align:center;height:60px;line-height:60px;float:right;" href="javascript:void(0);" onclick="this.parentNode.parentNode.style.display=\'none\';">取消</a></div></div>');
	});
	$('#keyword').live('keyup',function(e){
		if(e.keyCode == 13){
			alert(111);
		}
	});
	$('#swiper-container').swiper({
		slidesPerView: 4,
		freeModeFluid : true,
		freeMode : true
	});
	$('#nav li').click(function(){
		$(this).addClass('current').siblings().removeClass('current');
	});
	$(window).scroll(function(){
		$('#header').css('display',($(window).scrollTop()>80 ? 'none' : 'block'));
	});
});