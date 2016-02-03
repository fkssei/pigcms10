$(function(){

	load_page('#content',load_url,{page:'select_content'},'');
	var store_id = 0;
	$('.delete-team').live('click',function(e){
		store_id = $(this).attr('store-id');
		var html = '<div class="modal-backdrop fade in"></div><div class="deleteShop-modal modal fade hide in" style="margin-top: -800px; display: block;" aria-hidden="false"><div class="modal-header"><a class="js-cancel close" data-dismiss="modal">×</a><h3 class="title">提示</h3></div><div class="modal-body"><p class="tips">店铺所有内容都将被删除，确定要删除店铺？</p><div class="butn-container"><button class="btn btn-danger btn-delete-shop js-delete">删除店铺</button><button class="btn btn-cancel js-cancel">取消</button></div></div></div>';
		$('body').append(html);
        $('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
		e.stopPropagation();
	});
	$('.js-cancel').live('click',function(){
        $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow", function(){
            $('.deleteShop-modal,.modal-backdrop').remove();
        });
	});
	$('.js-delete').live('click',function(){
		var layer_load = layer.load('正在删除，请稍等',0);
		$.post(delete_url,{store_id:store_id},function(result){
			load_page('#content',load_url,{page:'select_content'},'');
            $('.js-cancel').trigger('click');
			layer.close(layer_load);
		});
	});

    $('.open-team').live('click', function(e) {
        e.stopPropagation();
        var store_id = $(this).attr('store-id');
        $.post(open_url,{store_id:store_id},function(result){
            if (result.err_code == 0) {
                window.location.href = result.err_msg;
            } else {
                $('body').append('<div class="notify-backdrop fade in"></div>');
                $('.js-notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>店铺开启失败，请联系平台帮您处理。</div>');
            }
        });
    })

	$('.team-icon').live('click',function(){
        if ($(this).hasClass('store-closed')) {
        	var status = $(this).data("status");
        	var message = '您访问的店铺已关闭，重新开启后才能访问';
        	if (status == "2") {
        		message = '您访问的店铺正在审核，审核通过后才能访问';
        	} else if (status == "3") {
        		message = '您访问的店铺未通过审核，不能访问';
        	} else if (status == "5") {
        		message = '您访问的店铺被供货商关闭，不能访问';
        	}
        	
            $('body').append('<div class="notify-backdrop fade in"></div>');
            $('.js-notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>' + message + '</div>');
            return false;
        }
        if ($(this).hasClass('drp-unapprove')) {
            $('body').append('<div class="notify-backdrop fade in"></div>');
            $('.js-notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>您访问的店铺正在审核中...</div>');
            return false;
        }
        if ($(this).hasClass('mis')) {
            window.location.href = select_url+'&store_id='+$(this).attr('store-id');
        }
	});

    //关闭提示窗
    $('.close').live('click', function(e){
        $('.notifications').html('');
        $('.notify-backdrop').remove();
    })

	$('.js-page-list a').live('click',function(e){
		if(!$(this).hasClass('active')){
			load_page('#content',load_url,{page:'select_content',p:$(this).attr('data-page-num')},'');
		}
	});
});