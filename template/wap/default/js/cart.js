$(function(){
	var checkCartPro = function(){
		if($('.block-item-cart').size() == 0){
			$('.js-list-header').hide();
			$('.block-list-cart').html('<div class="empty-list" style="margin-top:30px;"><div class="empty-list-header"><h4>购物车要饿瘪了 T.T</h4><span>快给我挑点宝贝</span></div><div class="empty-list-content"><a href="'+storeUrl+'" class="home-page tag tag-big tag-orange">去逛逛</a></div></div>');
			$('.js-delete-goods').prop('disabled',true);
		}
	}
	var checkCart = function(){
		if($('.block-item-cart').size() == 0){
			checkCartPro();
			return false;
		}
		var cartMoney=0,cartCount=0,hasNocheck=false;
		$.each($('.block-item-cart'),function(i,item){
			if($(this).data('skunum') == '0' || $(this).data('status') != 1 ||  parseInt($(this).data('skunum')) < parseInt($(this).data('num'))){
				$(this).addClass('error disabled').find('.check').removeClass('checked').addClass('info');
				var errorTxt = '';
				if($(this).data('status') != 1){
					errorTxt = '该商品已下架';
				}else if($(this).data('skuid')==0){
					errorTxt = '该商品已售罄';
				}else if(parseInt($(this).data('skunum')) < parseInt($(this).data('num'))){
					errorTxt = '仅剩'+$(this).data('skunum')+'件';
				}else{
					errorTxt = '该规格已售罄';
				}
				$(this).find('.error-box').html(errorTxt);
			}else if($(this).find('.check').hasClass('checked')){
				cartMoney += (parseInt($(item).data('num'))*(parseFloat($(item).data('price'))*100))/100;
				cartCount += parseInt($(item).data('num'));
			}else{
				hasNocheck = true;
			}
		});
		if(hasNocheck){
			$('.select-all').removeClass('checked').find('.check').removeClass('checked');
		}else{
			$('.select-all').addClass('checked').find('.check').addClass('checked');
		}
		$('.js-total-price').html(cartMoney);
		if(cartCount){
			$('.js-go-pay').html('结算('+cartCount+')').prop('disabled',false);
		}else{
			$('.js-go-pay').html('结算').prop('disabled',true);
		}
	}
	var checkDelte = function(){
		if($('.block-item-cart').size() == 0){
			return false;
		}
		var hasCheck=false,hasNocheck=false;
		$.each($('.block-item-cart'),function(i,item){
			if($(this).find('.check').hasClass('delete')){
				hasCheck=true;
			}else{
				hasNocheck=true;
			}
		});
		if(hasCheck){
			$('.js-delete-goods').prop('disabled',false);
		}else{
			$('.js-delete-goods').prop('disabled',true);
		}
		if(hasNocheck){
			$('.select-all').removeClass('delete').find('.check').removeClass('delete');
		}else{
			$('.select-all').addClass('delete').find('.check').addClass('delete');
		}
	}
	var checkQuantity = function(dom){
		var skuNum = parseInt(dom.data('skunum'));
		var numDom = dom.find('.quantity .txt');
		var num = parseInt(numDom.val());
        if ($(dom).find('.num').hasClass('buyer-quota')) {
            var buyer_quota = parseInt($(dom).find('.num').data('buyer-quota'));
            var buy_quantity = parseInt($(dom).find('.num').data('buy-quantity'));
            buyer_quota = buyer_quota - buy_quantity; //限购 - 已购买数 = 可购买数
            if (buyer_quota < skuNum) {
                skuNum = buyer_quota;
            }
        }
		if(num >= skuNum){
			numDom.val(skuNum);
			dom.find('.quantity .plus').addClass('disabled').prop('disabled',true);
		}else{
			dom.find('.quantity .plus').removeClass('disabled').prop('disabled',false);
		}
		if(skuNum == 0 || num <= 1){
			if(skuNum>0){numDom.val(1);}
			dom.find('.quantity .minus').addClass('disabled').prop('disabled',true);
		}else{
			dom.find('.quantity .minus').removeClass('disabled').prop('disabled',false);
		}
		
		var mustPost = false;
		if(dom.data('skunum')!='0'){
			if(num!=dom.data('num')){
				mustPost = true;
			}
			dom.data('num',num);
		}
		if(mustPost){
			var post_data = {};
			if(dom.data('skuid') != '0'){
				post_data.skuId = dom.data('skuid');
			}else{
				post_data.proId = dom.data('proid');
			}
			post_data.num = dom.data('num');
			post_data.id = dom.data('id');
			$.post('./cart.php?action=quantity',post_data,function(result){
				if(result.err_code){
					window.location.reload();
				}else{
					if(num > result.err_msg){
						numDom.val(result.err_msg);
						dom.data('num',result.err_msg);
					}
				}
			});
		}
	}
	
	var isEdit = false;
	checkCart();
	$('.js-edit-list').click(function(){
		if(isEdit == false){
			$('.js-go-pay').addClass('hide');
			$('.js-delete-goods').removeClass('hide');
			$('.block-item-cart .check').removeClass('checked info');
			$('.select-all').removeClass('checked').find('.check').removeClass('checked');
			$('.total-price').hide();
			$.each($('.block-item-cart'),function(i,item){
                var buyer_quota = 0;
                var buy_quantity = 0;
				if ($(item).find('.num').hasClass('buyer-quota')) {
                    buyer_quota = $(item).find('.num').data('buyer-quota');
                    buy_quantity = $(item).find('.num').data('buy-quantity');
                }
                var html = '<div class="quantity">';
                html += '<div class="response-area response-area-minus"></div>';
                html += '<button class="minus" type="button"></button>';
                if (buyer_quota > 0 && buyer_quota >= $(item).data('num')) {
                    html += '<input type="text" class="txt" value="' + ($(item).data('skunum') == '0' ? '0' : $(item).data('num')) + '" readonly="true" />';
                    html += '<button class="plus disabled" type="button" disabled="true"></button><div class="response-area response-area-plus">';
                } else {
                    html += '<input type="text" class="txt" value="' + ($(item).data('skunum') == '0' ? '0' : $(item).data('num')) + '"/>';
                    html += '<button class="plus" type="button"></button><div class="response-area response-area-plus">';
                }
                html += '</div><div class="txtCover"></div></div>';
                $(item).find('.num').html(html);
				checkQuantity($(item));
			});
			$(this).html('完成');
		}else{
			$('.js-delete-goods').addClass('hide');
			$('.js-go-pay').removeClass('hide');
			$('.select-all').addClass('checked').find('.check').addClass('checked');
			$('.block-item-cart .check').removeClass('delete').addClass('checked');
			$('.total-price').show();
			$.each($('.block-item-cart'),function(i,item){
				var newNum = $(this).data('skunum') != '0' ? parseInt($(this).find('.quantity .txt').val()) : 0;
				$(this).find('.num').html('×<span class="num-txt">'+$(this).data('num')+'</span>');
			});
			checkCart();
			$(this).html('编辑');
		}
		isEdit = !isEdit;
	});
	
	//数量
	$('.quantity .txt').live('blur',function(){
		checkQuantity($(this).closest('li'));
	});
	$('.quantity .response-area-minus').live('click',function(){
		var liDom = $(this).closest('li');
		var numDom = $(this).siblings('.txt');
		var num = parseInt(numDom.val());
		if(num>1){
			numDom.val(num-1);
		}
		checkQuantity(liDom);
	});
	$('.quantity .response-area-plus').live('click',function(){
        if ($(this).prev('.plus').hasClass('disabled')) {
            return false;
        }
		var liDom = $(this).closest('li');
		var numDom = $(this).siblings('.txt');
		var num = parseInt(numDom.val());
        var quantityCount = parseInt(liDom.data('skunum'));
        var buy_quantity = 0;
        var buyer_quota = 0;
        if ($(this).closest('.num').hasClass('buyer-quota')) {
            buy_quantity = $(this).closest('.buyer-quota').data('buy-quantity');
            buyer_quota = $(this).closest('.buyer-quota').data('buyer-quota');
        }
        if (buyer_quota > 0 && buyer_quota < quantityCount) {
            quantityCount = buyer_quota;
        }
		if(num < quantityCount){
			numDom.val(num+1);
		}
		checkQuantity(liDom);
	});
		
		
	$('.block-item-cart .check').click(function(){
		if(isEdit){
			if($(this).hasClass('delete')){
				$(this).removeClass('delete');
			}else{
				$(this).addClass('delete');
			}
			checkDelte();
		}else{
			if($(this).hasClass('checked')){
				$(this).removeClass('checked');
			}else{
				$(this).addClass('checked');
			}
			checkCart();
		}
	});
	$('.select-all').click(function(){
		if(isEdit){
			if($(this).hasClass('delete')){
				$(this).removeClass('delete').find('.check').removeClass('delete');
				$('.block-item-cart .check').removeClass('delete');
			}else{
				$(this).addClass('delete').find('.check').addClass('delete');
				$('.block-item-cart .check').addClass('delete');
			}
			checkDelte();
		}else{
			if($(this).hasClass('checked')){
				$('.block-item-cart .check').removeClass('checked');
			}else{
				$('.block-item-cart .check').addClass('checked');
			}
			checkCart();
		}
		
	});
	$('.js-delete-goods').click(function(){
		var ids=[];
		$.each($('.block-item-cart'),function(i,item){
			if($(item).find('.check').hasClass('delete')){
				ids.push($(item).data('id'));
			}
		});
		if(ids.length>0){
			var nowDom = $(this);
			nowDom.prop('disabled',true).html('删除中...');
			$.post('./cart.php?action=del',{storeId:storeId,ids:ids},function(result){
				nowDom.prop('disabled',false).html('删除');
				if(result.err_code == 0){
					for(var i in ids){
						$('.block-item-cart.item-'+ids[i]).remove();
					}
					checkCartPro();
					checkDelte();
				}else{
					motify.log(result.err_msg);
				}
			});
		}
	});
	$('.js-go-pay').click(function(){
		var ids=[];
		$.each($('.block-item-cart'),function(i,item){
			if($(item).find('.check').hasClass('checked')){
				ids.push($(item).data('id'));
			}
		});
		if(ids.length>0){
			$.post('./cart.php?action=pay',{storeId:storeId,ids:ids},function(result){
				if(result.err_code == 0){
					window.location.href = './pay.php?id='+result.err_msg+'&showwxpaytitle=1';
				}else{
					alert(result.err_msg+'\r\n页面将自动刷新');
					window.location.reload();
				}
			});
		}
	});
});