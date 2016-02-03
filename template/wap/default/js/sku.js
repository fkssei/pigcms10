if(typeof(activityType) == 'undefined'){
	var hasActivity = false,activityId=0,activityType=0,activityDiscount=0,activityPrice=0;
}
function getFinalPrice(min,max){
	if(hasActivity){
		if(activityType == 1){
			return ((max!=0 && min!=max) ? (min-activityPrice).toFixed(2)+' - '+(max-activityPrice).toFixed(2) : (min-activityPrice).toFixed(2));
		}else{
			return ((max!=0 && min!=max) ? (min*activityDiscount/10).toFixed(2)+' - '+(max*activityDiscount/10).toFixed(2) : (min*activityDiscount/10).toFixed(2));
		}
	}else{
		return ((max!=0 && min!=max) ? min+' - '+max : min)
	}
}
function skuBuy(product_id,buyType,showCallback){
	if(!is_mobile){
		motify.log('预览不支持进行购买，<br/>实际效果请在手机上进行。');
		if(showCallback) showCallback();
		return false;
	}
	$.post('./goodinfo.php',{action:'getSku',product_id:product_id},function(result){
		if(showCallback) showCallback();
		if(result.err_code == 1002){
			window.location.href = result.err_msg;
			return false;
		}else if(result.err_code != 0){
			motify.log(result.err_msg);
			return false;
		}
		var productInfo = result.err_msg.productInfo;
		var quantityCount = productInfo.quantity;
		var popBg = $('<div id="qpPh1bGqgC" style="height:100%;position:fixed;top:0px;left:0px;right:0px;background-color:rgba(0,0,0,0.7);z-index:1000;transition:none 0.2s ease 0s;opacity:1;"></div>');
		var skuHtml = '<div id="n65dA7sX3X" class="sku-layout sku-box-shadow" style="overflow:hidden;bottom:0px;left:0px;right:0px;visibility:visible;position:absolute;z-index:1100;opacity:1;"><div class="layout-title sku-box-shadow name-card sku-name-card"><div class="thumb"><img src="'+productInfo.image+'" alt="'+productInfo.name+'"></div><div class="detail goods-base-info clearfix"><p class="title c-black ellipsis">'+productInfo.name+'</p><div class="goods-price clearfix"><div class="current-price pull-left c-black"><span class="price-name pull-left font-size-14 c-orange">￥</span><i class="js-goods-price price font-size-18 vertical-middle c-orange">'+getFinalPrice(productInfo.minPrice,productInfo.maxPrice)+'</i></div></div></div><div class="js-cancel sku-cancel"><div class="cancel-img"></div></div></div><div class="adv-opts layout-content"><div class="goods-models js-sku-views block block-list block-border-top-none">';
		
		if(result.err_msg.propertyList){
			var skuArr = [];
			for(var i in result.err_msg.skuList){
				var nowSku = result.err_msg.skuList[i];
				skuArr[nowSku.sku_id] = nowSku.properties;
			}
			//自定义属性数量
			var propertyLength = getJsonObjLength(result.err_msg.propertyList);
			//计算库存
			switch(propertyLength){
				case 1:
					var firstProperty = result.err_msg.propertyList[0];
					for(var i in firstProperty.value){
						if($.inArray(firstProperty.pid+':'+i,skuArr) == -1){
							delete result.err_msg.propertyList[0].value[i];
						}
					}
					break;
				case 2:
					var firstProperty = result.err_msg.propertyList[0];
					var twoProperty = result.err_msg.propertyList[1];
					for(var i in firstProperty.value){
						var twoLength = getJsonObjLength(twoProperty.value);
						var twoNoSkuLength = 0;
						for(var j in twoProperty.value){
							if($.inArray(firstProperty.pid+':'+i+ ';' +twoProperty.pid+':'+j,skuArr) == -1){
								twoNoSkuLength++;
							}
						}
						if(twoLength == twoNoSkuLength){
							delete result.err_msg.propertyList[0].value[i];
						}
					}
					break;
                case 3:
                    var firstProperty = result.err_msg.propertyList[0];
                    var twoProperty = result.err_msg.propertyList[1];
                    var threeProperty = result.err_msg.propertyList[2];
                    var threeLength = getJsonObjLength(twoProperty.value);
                    for (var i in firstProperty.value) {
                        for(var j in twoProperty.value){
                            var threeNoSkuLength = 0;
                            for(var k in threeProperty.value){
                                if($.inArray(firstProperty.pid+':'+i+ ';' +twoProperty.pid+':'+j+';'+threeProperty.pid+':'+k,skuArr) == -1){
                                    threeNoSkuLength++;
                                }
                            }
                            if(threeLength == threeNoSkuLength){
                                delete result.err_msg.propertyList[1].value[j];
                                delete result.err_msg.propertyList[0].value[i];
                            }
                        }
                    }
                    break;
			}
			for(var i in result.err_msg.propertyList){
				var nowProperty = result.err_msg.propertyList[i];
				skuHtml+= '<dl class="clearfix block-item"><dt class="model-title sku-sel-title"><label>' + nowProperty.name + '：</label></dt><dd><ul class="model-list sku-sel-list" data-pid="' + nowProperty.pid + '">';
				for(var j in nowProperty.values){
					skuHtml+= '<li class="tag sku-tag pull-left ellipsis" data-vid="' + nowProperty.values[j].vid + '">' + nowProperty.values[j].value + '</li>';
				}
				skuHtml+= '</ul></dd></dl>';
			}
		}else{
			propertyLength = 0;
		}
		
		skuHtml+= '<dl class="clearfix block-item">';
        skuHtml+= '<dt class="model-title sku-num pull-left">';
        skuHtml+= '<label>数量</label>';
        skuHtml+= '</dt>';
        skuHtml+= '<dd>';
        skuHtml+= '<dl class="clearfix">';
        skuHtml+= '<div class="quantity">';
        skuHtml+= '<div class="response-area response-area-minus"></div>';
        skuHtml+= '<button disabled="true" class="minus disabled" type="button"></button>';
        var buyer_quota = 0
        if (productInfo.buyer_quota > 0) {
            if (isNaN($('.buyer-quota').data('buy-quantity'))) {
                buy_quantity = parseInt($('.buyer-quota').data('buy-quantity'));
            } else {
                buy_quantity = 0;
            }
            buyer_quota = productInfo.buyer_quota;
            buyer_quota = buyer_quota - buy_quantity;
        }
        if (buyer_quota == 1) {
            skuHtml+= '<input class="txt" value="1" readonly="true" type="text" />';
            skuHtml += '<button class="plus disabled" type="button" disabled="true"></button>';
        } else {
            skuHtml+= '<input class="txt" value="1" type="text"/>';
            skuHtml += '<button class="plus" type="button"></button>';
        }
        skuHtml+= '<div class="response-area response-area-plus"></div>';
        skuHtml+= '<div class="txtCover"></div>';
        skuHtml+= '</div><div class="stock pull-right font-size-12"></div></dl></dd></dl>';
		if(result.err_msg.customFieldList.length > 0){
			skuHtml+= '<div class="block-item block-item-messages"><div class="sku-message">';
			
			for(var i in result.err_msg.customFieldList){
				var nowField = result.err_msg.customFieldList[i];
				skuHtml+= '<dl class="clearfix"><dt class="pull-left"><label for="ipt-0">'+ (nowField.required == '1' ? '<sup class="required">*</sup>' : '') + nowField.field_name+'</label></dt><dd class="comment-wrapper clearfix">';
				if(nowField.multi_rows == '0'){
					skuHtml+= '<input type="'+nowField.field_type+'" data-valid-type="'+nowField.field_type+'" '+(nowField.required=='1' ? 'required="required"' : '')+' tabindex="'+(i+1)+'" id="ipt-'+i+'" name="message_'+i+'" class="txt js-message font-size-14"/>';
				}else{
					skuHtml+= '<textarea data-valid-type="'+nowField.field_type+'" '+(nowField.required=='1' ? 'required="required"' : '')+' tabindex="'+(i+1)+'" id="ipt-'+i+'" name="message_'+i+'" cols="32" rows="1" class="txta js-message font-size-14"></textarea>';
				}
				skuHtml+= '<div class="txtCover"></div></dd></dl>';
			}
			
			skuHtml+= '</div></div>';
		}
		
		skuHtml+= '</div><div class="confirm-action content-foot">';
		switch(buyType){
			case 0:
				skuHtml+= '<a href="javascript:;" class="js-mutiBtn-confirm confirm btn btn-block btn-orange-dark half-button">立即购买</a> <a href="javascript:;" class="js-mutiBtn-confirm cart btn btn-block btn-orange-dark half-button">加入购物车</a>';
				break;
			case 1:
				skuHtml+= '<a href="javascript:;" class="js-mutiBtn-confirm confirm btn btn-block btn-orange-dark">下一步</a>';
				break;
			default:
				skuHtml+= '<a href="javascript:;" class="js-mutiBtn-confirm cart btn btn-block btn-orange-dark">加入购物车</a>';
				break;
		}
		skuHtml+= '</div></div></div>';
		var popCon = $(skuHtml);
		
		var nowScroll = $(window).scrollTop();
		$('html').css({'position':'relative','overflow':'hidden','height':$(window).height()+'px'});
		$('body').css({'overflow':'hidden','height':$(window).height()+'px','padding':'0px'}).append(popBg).append(popCon);
		setTimeout(function(){
			popCon.height(popCon.height() > $(window).height()-50 ? $(window).height()-50+'px' : popCon.height()).find('.layout-content').height(popCon.height() - 61 + 'px');
			setTimeout(function(){
				popCon.css({'transform':'translate3d(0px,0px,0px)','-webkit-transform':'translate3d(0px,0px,0px)'});
			},100);
		},100);
		
		popCon.find('.js-sku-views .sku-sel-list li').click(function(){
			if($(this).hasClass('unavailable')){
				return false;
			}
			if($(this).hasClass('active')){
				$(this).removeClass('tag-orangef60 active');
                $(this).closest('.block-item').siblings('.block-item').find('.sku-sel-list > li').removeClass('unavailable');
			}else{
				$(this).addClass('tag-orangef60 active').siblings().removeClass('tag-orangef60 active');
				if(propertyLength > 1){
					var nowDom = $(this);
					switch(propertyLength){
						case 2:
							var skuIndex = popCon.find('.js-sku-views .sku-sel-list').index(nowDom.closest('.sku-sel-list'));
							var firstSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(0);
							var twoSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(1);
							if(skuIndex == 1){
								$.each(firstSkuDom.find('li'),function(i,item){
									if($.inArray(firstSkuDom.data('pid')+':'+$(item).data('vid')+';'+twoSkuDom.data('pid')+':'+twoSkuDom.find('li.active').data('vid'),skuArr) == -1){
										$(item).addClass('unavailable');
									}else{
										$(item).removeClass('unavailable');
									}
								});
							}else if(skuIndex == 0){
								$.each(twoSkuDom.find('li'),function(i,item){
									if($.inArray(firstSkuDom.data('pid')+':'+firstSkuDom.find('li.active').data('vid')+';'+twoSkuDom.data('pid')+':'+$(item).data('vid'),skuArr) == -1){
										$(item).addClass('unavailable');
									}else{
										$(item).removeClass('unavailable');
									}
								});
							}
							break;
                        case 3:
                            var skuIndex = popCon.find('.js-sku-views .sku-sel-list').index(nowDom.closest('.sku-sel-list'));
                            var firstSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(0);
                            var twoSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(1);
                            var threeSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(2);
                            if (skuIndex == 0) {
                                $.each(twoSkuDom.find('li'),function(i,item){
                                    if(firstSkuDom.find('li.active').data('vid') != undefined && threeSkuDom.find('li.active').data('vid') != undefined && $.inArray(firstSkuDom.data('pid')+':'+firstSkuDom.find('li.active').data('vid')+';'+twoSkuDom.data('pid')+':'+$(item).data('vid')+';'+threeSkuDom.data('pid')+':'+threeSkuDom.find('li.active').data('vid'),skuArr) == -1){
                                        $(item).addClass('unavailable');
                                    }else{
                                        $(item).removeClass('unavailable');
                                    }
                                });
                                $.each(threeSkuDom.find('li'),function(i,item){
                                    if(firstSkuDom.find('li.active').data('vid') != undefined && twoSkuDom.find('li.active').data('vid') != undefined && $.inArray(firstSkuDom.data('pid')+':'+firstSkuDom.find('li.active').data('vid')+';'+twoSkuDom.data('pid')+':'+twoSkuDom.find('li.active').data('vid')+';'+threeSkuDom.data('pid')+':'+$(item).data('vid'),skuArr) == -1){
                                        $(item).addClass('unavailable');
                                    }else{
                                        $(item).removeClass('unavailable');
                                    }
                                });
                            } else if(skuIndex == 1) {
                                $.each(firstSkuDom.find('li'),function(i,item){
                                    if(twoSkuDom.find('li.active').data('vid') != undefined && threeSkuDom.find('li.active').data('vid') != undefined && $.inArray(firstSkuDom.data('pid')+':'+$(item).data('vid')+';'+twoSkuDom.data('pid')+':'+twoSkuDom.find('li.active').data('vid')+';'+threeSkuDom.data('pid')+':'+threeSkuDom.find('li.active').data('vid'),skuArr) == -1){
                                        $(item).addClass('unavailable');
                                    }else{
                                        $(item).removeClass('unavailable');
                                    }
                                });
                                $.each(threeSkuDom.find('li'),function(i,item){
                                    if(firstSkuDom.find('li.active').data('vid') != undefined && twoSkuDom.find('li.active').data('vid') != undefined && $.inArray(firstSkuDom.data('pid')+':'+firstSkuDom.find('li.active').data('vid')+';'+twoSkuDom.data('pid')+':'+twoSkuDom.find('li.active').data('vid')+';'+threeSkuDom.data('pid')+':'+$(item).data('vid'),skuArr) == -1){
                                        $(item).addClass('unavailable');
                                    }else{
                                        $(item).removeClass('unavailable');
                                    }
                                });
                            } else if (skuIndex == 2) {
                                $.each(firstSkuDom.find('li'),function(i,item){
                                    if(twoSkuDom.find('li.active').data('vid') != undefined && threeSkuDom.find('li.active').data('vid') != undefined && $.inArray(firstSkuDom.data('pid')+':'+$(item).data('vid')+';'+twoSkuDom.data('pid')+':'+twoSkuDom.find('li.active').data('vid')+';'+threeSkuDom.data('pid')+':'+threeSkuDom.find('li.active').data('vid'),skuArr) == -1){
                                        $(item).addClass('unavailable');
                                    }else{
                                        $(item).removeClass('unavailable');
                                    }
                                });
                                $.each(twoSkuDom.find('li'),function(i,item){
                                    if(firstSkuDom.find('li.active').data('vid') != undefined && threeSkuDom.find('li.active').data('vid') != undefined && $.inArray(firstSkuDom.data('pid')+':'+firstSkuDom.find('li.active').data('vid')+';'+twoSkuDom.data('pid')+':'+$(item).data('vid')+';'+threeSkuDom.data('pid')+':'+threeSkuDom.find('li.active').data('vid'),skuArr) == -1){
                                        $(item).addClass('unavailable');
                                    }else{
                                        $(item).removeClass('unavailable');
                                    }
                                });
                            }
                            break;
					}
				}
			}
			//最大可调库存数
			if(popCon.find('.js-sku-views .sku-sel-list').size() == popCon.find('.js-sku-views .sku-sel-list li.active').size()){
				switch(propertyLength){
					case 1:
						var firstSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(0);
						var nowSkuId = $.inArray(firstSkuDom.data('pid')+':'+firstSkuDom.find('li.active').data('vid'),skuArr);
						for(var i in result.err_msg.skuList){
							if(nowSkuId == result.err_msg.skuList[i].sku_id){
								quantityCount = result.err_msg.skuList[i].quantity;
								$('.js-goods-price').html(getFinalPrice(result.err_msg.skuList[i].price,0));
								break;
							}
						}
						break;
					case 2:
						var firstSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(0);
						var twoSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(1);
						var nowSkuId = $.inArray(firstSkuDom.data('pid')+':'+firstSkuDom.find('li.active').data('vid')+';'+twoSkuDom.data('pid')+':'+twoSkuDom.find('li.active').data('vid'),skuArr);
						for(var i in result.err_msg.skuList){
							if(nowSkuId == result.err_msg.skuList[i].sku_id){
								quantityCount = result.err_msg.skuList[i].quantity;
								$('.js-goods-price').html(getFinalPrice(result.err_msg.skuList[i].price,0));
								break;
							}
						}
						break;
                    case 3:
                        var firstSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(0);
                        var twoSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(1);
                        var threeSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(2);
                        var nowSkuId = $.inArray(firstSkuDom.data('pid')+':'+firstSkuDom.find('li.active').data('vid')+';'+twoSkuDom.data('pid')+':'+twoSkuDom.find('li.active').data('vid')+';'+threeSkuDom.data('pid')+':'+threeSkuDom.find('li.active').data('vid'),skuArr);
                        for(var i in result.err_msg.skuList){
                            if(nowSkuId == result.err_msg.skuList[i].sku_id){
                                quantityCount = result.err_msg.skuList[i].quantity;
                                $('.js-goods-price').html(getFinalPrice(result.err_msg.skuList[i].price,0));
                                break;
                            }
                        }
                        break;
                }
			}else{
				quantityCount = productInfo.quantity;
				$('.js-goods-price').html(getFinalPrice(productInfo.minPrice,productInfo.maxPrice));
			}
			checkQuantity();
		});
		function checkQuantity(){
			var numDom = popCon.find('.quantity .txt');
            var buy_quantity = parseInt($('.buyer-quota').data('buy-quantity'));
            var buyer_quota = parseInt(productInfo.buyer_quota);
            buyer_quota = buyer_quota - buy_quantity;
            if (buyer_quota > 0) {
                if (buyer_quota < quantityCount) {
                    quantityCount = buyer_quota;
                }
            }
			if(parseInt(numDom.val()) >= quantityCount){
				popCon.find('.quantity .txt').val(quantityCount);
				popCon.find('.quantity .plus').addClass('disabled').prop('disabled',true);
			}else{
				popCon.find('.quantity .plus').removeClass('disabled').prop('disabled',false);
			}
			if(parseInt(numDom.val()) <= 1){
				popCon.find('.quantity .txt').val(1);
				popCon.find('.quantity .minus').addClass('disabled').prop('disabled',true);
			}else{
				popCon.find('.quantity .minus').removeClass('disabled').prop('disabled',false);
			}
		}
		//数量
		popCon.find('.quantity .txt').blur(function(){
			checkQuantity();
		});
		popCon.find('.quantity .response-area-minus').click(function(){
			var numDom = $(this).siblings('.txt');
			var num = parseInt(numDom.val());
			if(num>1){
				numDom.val(num-1);
			} else {
                return false;
            }
			checkQuantity();
		});
		popCon.find('.quantity .response-area-plus').click(function(){
            var numDom = $(this).siblings('.txt');
			var num = parseInt(numDom.val());
            var buy_quantity = parseInt($('.buyer-quota').data('buy-quantity'));
            var buyer_quota = parseInt(productInfo.buyer_quota);
            buyer_quota = buyer_quota - buy_quantity; //限购 - 已购买数量 = 可购买数量
            if (buyer_quota > 0) {
                if (buyer_quota < quantityCount) {
                    quantityCount = buyer_quota;
                }
            }
            if(num<quantityCount){
                numDom.val(num+1);
            }

			checkQuantity();
		});
		//自定义字段
		popCon.find('.js-sku-views .txtCover').click(function(ee){
            if ($(this).siblings('.plus').hasClass('disabled')) {
                return false;
            }
			ee.stopPropagation();
			var txtCover = $(this);
			txtCover.siblings('textarea').attr('rows','2');
			txtCover.hide().siblings('input,textarea').focus().click(function(eee){	
				eee.stopPropagation();
				txtCover.siblings('textarea').attr('rows','2');
				txtCover.hide();	
			});
			
			$('body').one('click',function(){
				txtCover.siblings('textarea').attr('rows','1');
				txtCover.show();
			});
		});
		
		var popHide = function(){
			popCon.css({'transform':'translate3d(0px,100%,0px)','-webkit-transform':'translate3d(0px,100%,0px)'});
			// setTimeout(function(){
				$('html').css({'overflow':'visible','height':'auto','position':'static'});
				$('body').css({'overflow':'visible','height':'auto','padding-bottom':'45px'});
				$(window).scrollTop(nowScroll);
				popBg.remove(),popCon.remove();
			// },300);
		}
		popBg.click(function(){
			popHide();
		});
		popCon.find('.js-cancel').click(function(){
			popHide();
		});
		
		var isPostNow = false;
		popCon.find('.js-mutiBtn-confirm').click(function(){
			var nowDom = $(this);
			if(isPostNow){
				motify.log('正在提交中，请勿重复提交！');
				return false;
			}
			var post_data = {};
			post_data.activityId = activityId;
			post_data.proId = productInfo.product_id;
			post_data.quantity = parseInt(popCon.find('.quantity .txt').val());
			post_data.isAddCart = nowDom.hasClass('cart') ? 1 : 0;
			if(propertyLength > 0){
				switch(propertyLength){
					case 1:
						var firstSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(0);
						if(firstSkuDom.find('li.active').size() == 0){
							motify.log('请选择 '+result.err_msg.propertyList[0].name);
							return false;
						}else{
							post_data.skuId = $.inArray(firstSkuDom.data('pid')+':'+firstSkuDom.find('li.active').data('vid'),skuArr);
						}
						break;
					case 2:
						var firstSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(0);
						var twoSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(1);
						var firstSkuDomActiveSize = firstSkuDom.find('li.active').size();
						var twoSkuDomActiveSize = twoSkuDom.find('li.active').size();
						if(firstSkuDomActiveSize == 0 && twoSkuDomActiveSize == 0 ){
							motify.log('请选择 '+result.err_msg.propertyList[0].name+' 和 '+result.err_msg.propertyList[1].name);
							return false;
						}else if(firstSkuDomActiveSize == 0){
							motify.log('请选择 '+result.err_msg.propertyList[0].name);
							return false;
						}else if(twoSkuDomActiveSize == 0){
							motify.log('请选择 '+result.err_msg.propertyList[1].name);
							return false;
						}else{
							post_data.skuId = $.inArray(firstSkuDom.data('pid')+':'+firstSkuDom.find('li.active').data('vid')+';'+twoSkuDom.data('pid')+':'+twoSkuDom.find('li.active').data('vid'),skuArr);
						}
						break;
                    case 3:
                        var firstSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(0);
                        var twoSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(1);
                        var threeSkuDom = popCon.find('.js-sku-views .sku-sel-list').eq(2);
                        var firstSkuDomActiveSize = firstSkuDom.find('li.active').size();
                        var twoSkuDomActiveSize = twoSkuDom.find('li.active').size();
                        var threeSkuDomActiveSize = threeSkuDom.find('li.active').size();
                        if(firstSkuDomActiveSize == 0 && twoSkuDomActiveSize == 0 && threeSkuDomActiveSize == 0){
                            motify.log('请选择 '+result.err_msg.propertyList[0].name+' 、 '+result.err_msg.propertyList[1].name + '、' + result.err_msg.propertyList[2].name);
                            return false;
                        } else if (firstSkuDomActiveSize == 0 && twoSkuDomActiveSize == 0) {
                            motify.log('请选择 '+result.err_msg.propertyList[0].name+' 和 '+result.err_msg.propertyList[1].name);
                            return false;
                        } else if (firstSkuDomActiveSize == 0 && threeSkuDomActiveSize == 0) {
                            motify.log('请选择 '+result.err_msg.propertyList[0].name+' 和 '+result.err_msg.propertyList[2].name);
                            return false;
                        } else if (twoSkuDomActiveSize == 0 && threeSkuDomActiveSize == 0) {
                            motify.log('请选择 '+result.err_msg.propertyList[1].name+' 和 '+result.err_msg.propertyList[2].name);
                            return false;
                        } else if(firstSkuDomActiveSize == 0){
                            motify.log('请选择 '+result.err_msg.propertyList[0].name);
                            return false;
                        } else if(twoSkuDomActiveSize == 0){
                            motify.log('请选择 '+result.err_msg.propertyList[1].name);
                            return false;
                        } else if (threeSkuDomActiveSize == 0) {
                            motify.log('请选择 '+result.err_msg.propertyList[2].name);
                            return false;
                        } else{
                            post_data.skuId = $.inArray(firstSkuDom.data('pid')+':'+firstSkuDom.find('li.active').data('vid')+';'+twoSkuDom.data('pid')+':'+twoSkuDom.find('li.active').data('vid')+';'+threeSkuDom.data('pid')+':'+threeSkuDom.find('li.active').data('vid'),skuArr);
                        }
                        break;
				}
			}
			if(result.err_msg.customFieldList.length > 0){
				post_data.custom = {};
				for(var i in result.err_msg.customFieldList){
					var nowField = result.err_msg.customFieldList[i];
					var fieldDom = $('.block-item-messages .comment-wrapper').eq(i).find('input,textarea').eq(0);
					if(nowField.required == '1' && $.trim(fieldDom.val()).length==0){
						motify.log('请填写 '+nowField.field_name+'。');
						fieldDom.focus();
						return false;
					}else if(fieldDom.val().length > 0){
						post_data.custom[i] = {'name':nowField.field_name,'type':nowField.field_type,'value':$.trim(fieldDom.val())};
					}
				}
			}
			nowDom.attr('disabled',true).html('提交中...');
			isPostNow = true;
			$.post('./saveorder.php',post_data,function(result){
				nowDom.attr('disabled',false).html(post_data.isAddCart ? '加入购物车' : '立即购买');
				if(result.err_code){
					motify.log(result.err_msg);
					return false;
				}
				popHide();
				if(post_data.isAddCart){
					motify.log('已成功添加到购物车');
					if($('#global-cart').size()==0){
						$('body').append('<div id="right-icon" class="js-right-icon icon-hide no-border" data-count="1"><div class="right-icon-container clearfix"><a id="global-cart" href="./cart.php?id='+storeId+'" class="no-text new showcart"><p class="right-icon-img"></p><p class="right-icon-txt">购物车</p></a></div></div>');
					}
					isPostNow = false;


                    var buy_quantity = parseInt($('.buyer-quota').data('buy-quantity'));
                    var buyer_quota = parseInt(productInfo.buyer_quota);
                    if ((buy_quantity + post_data.quantity) >= buyer_quota) { //限购
                        $('.js-bottom-opts').html('<div class="btn-1-1"><button disabled="disabled" class="btn">限购，您已购买' + buyer_quota + '件</button></div>');
                    }
                    $('.buyer-quota').attr('data-buy-quantity', (buy_quantity + post_data.quantity));
				}else{
					window.location.href = './pay.php?id='+result.err_msg+'&showwxpaytitle=1';
				}
			});
		});
	});
	return false;
};