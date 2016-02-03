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
	$.each($('.container .content-body a'),function(i,item){
		var tmpHref = $(item).attr('href'),newHref = '';
		if(tmpHref.length > 5){
			if(tmpHref.indexOf('?') != -1){
				newHref = tmpHref+'&platform=1';
			}else{
				newHref = tmpHref+'?platform=1';
			}
		}
		$(item).attr('href',newHref);
	});
});