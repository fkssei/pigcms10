$(function(){
	if($('li.block-order').size() == 0){
		$('.empty-list').show();
	}
	$('.js-cancel-order').click(function(){
		var nowDom = $(this);
		$.post('./order.php?del_id='+$(this).data('id'),function(result){
			motify.log(result.err_msg);
			if(result.err_code == 0){
				nowDom.closest('li').remove();
				if($('li.block-order').size() == 0){
					$('.empty-list').show();
				}
			}
		});
	});
});