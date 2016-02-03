//评论分页开始
var pinlunPage = 1;
var pinlunIsAjax = false;
var pinlunSort = 'default';
var pinlunShowRows = false;
var hrefs2 = '#pl_goods';

$(function(){
	if($('.swiper-pagination').size()){
		$('.swiper-container').swiper({
			pagination:'.swiper-pagination',
			loop:true,
			grabCursor: true,
			paginationClickable: true
		});
	}
	$('.js-buy-it').click(function(){
		if (!is_logistics && !is_selffetch) {
			motify.log('商家未设置配送方式，暂时不能购买');
			return;
		}
		
		var nowDom = $(this);
		if(nowDom.attr('disabled')){
			motify.log('提交中,请稍等..');
			return false;
		}
		nowDom.attr('disabled',true).html('提交中...');
		skuBuy(product_id,1,function(){
			nowDom.attr('disabled',false).html('我想要');
		});
	});
	$('.js-add-cart').click(function(){
		if (!is_logistics && !is_selffetch) {
			motify.log('商家未设置配送方式，暂时不能购买');
			return;
		}
		
		var nowDom = $(this);
		if(nowDom.attr('disabled')){
			motify.log('提交中,请稍等..');
			return false;
		}
		nowDom.attr('disabled',true).html('提交中...');
		skuBuy(product_id,2,function(){
			nowDom.attr('disabled',false).html('加入购物车');
		});
	});
	if(showBuy===true && motify.checkMobile()===true){
		$('.js-buy-it').trigger('click');
	}

	//切换选项卡
	$(".xuanxiangka").click(function(){
		$(".xuanxiangka").removeClass("on");
		$(this).addClass("on");
		var xxk_index = $(".xuanxiangka").index($(this));
		
		$("#div_sections .section_section").hide();
		$("#div_sections .section_section").eq(xxk_index).show();
		
		if (xxk_index == 1) {
			if ($("#list_comments .list_comments").eq(0).data("type") == "default") {
				getComment(0, 1);
			}
		}
	});
	
	// 滚动显示评论
	$(window).scroll(function(){
		if($(".section_section").eq(1).is(":visible") == false) {
			return false;
		}
		
		var tab_index = $(".js-comment-tab a").index($(".js-comment-tab a.active"));
		var type = $("#list_comments .list_comments").eq(tab_index).data("type");
		if (type == "default") {
			return false;
		}
		
		var next = $("#list_comments .list_comments").eq(tab_index).attr("next");
		if (next == "false") {
			return false;
		}
		
		if($(window).scrollTop()/($('body').height() -$(window).height())>=0.95){
			var page = $("#list_comments .list_comments").eq(tab_index).data("page");
			getComment(tab_index, page);
		}
	});
	
	$(".js-comment-tab a").click(function () {
		$(this).closest("div").find("a").removeClass("active");
		$(this).addClass("active");
		
		var tab_index = $(this).closest("div").find("a").index($(this));
		var tab = $(this).data("tab");
		if ($("#list_comments .list_comments").eq(tab_index).data("type") == "default") {
			// 未加载评论
			getComment(tab, 1)
		}
		
		$("#list_comments .list_comments").hide();
		$("#list_comments .list_comments").eq(tab_index).show();
	});
})

$(".promote-item").live("click",function(){
	$(".promote-item").removeClass("curr_li");
   $(this).addClass("curr_li");
	$(".promote-item .p_card,.promote-item .p_card2").hide();
	$(this).find(".p_card,.p_card2").show();

})

function getComment(index, page) {
	var product_id = $(".section_body").attr("data-product-id");
	if(!product_id) {
		return false;
	}
	
	var tab = "HAO";
	switch(index) {
		case 0 :
			tab = "HAO";
			break;
		case 1 :
			tab = "ZHONG";
			break;
		case 2 :
			tab = "CHA";
			break;
		default :
			index = 0;
			tab = "HAO";
	}
	
	if ($(".wx_loading" + index).css("display") != "none") {
		return;
	}
	
	
	$(".wx_loading" + index).show();
	var url = "comment.php?type=PRODUCT&tab=" + tab + "&id=" + product_id + "&page=" + page + "&action=get_pinlun_list";
	$.get(url, function (result) {
		var plHtml = "";
		var comments_index='';
		
		for(var i in result.err_msg.list){
			var pinlun = result.err_msg.list[i];
			var users = result.err_msg.userlist[pinlun.uid];
			
			
			if(pinlun.content){
				var miaoshu = pinlun.content;
			} else {
				var miaoshu = "暂无描述";
			}
			if(users.avatar){
				var touxiang = users.avatar;
			} else {
				var touxiang = "";
			}
			if(users.nickname){
				var nickname = users.nickname;
			} else {
				var nickname = "匿名";
			}						
			var dateline = new Date((pinlun.dateline)*1000);
			
			plHtml += '<li>';
			plHtml += '	<div class="tbox">';
			plHtml += '		<div>';
			plHtml += '			<span class="img_wrap">';
			plHtml += '				<img src="' + touxiang + '">';
			plHtml += '			</span>';
			plHtml += '			<p>' + nickname + '</p>';
			plHtml += '			<p style="align:center;"></p>';
			plHtml += '		</div>';
			plHtml += '		<div>';
			plHtml += '			<p class="comment_content">' + miaoshu +  '</p>';
			plHtml += '			<p>';
			plHtml += '				<label class="comment_time">' + formatDate(dateline) + '</label>';
			plHtml += '			</p>';
			plHtml += '		</div>';
			plHtml += '	</div>';
			plHtml += '</li>';
		}
		
		page = parseInt(page) + 1;
		
		$(".wx_loading" + index).hide();
		$("#list_comments .list_comments").hide();
		$("#list_comments .list_comments").eq(index).show().append(plHtml);
		$("#list_comments .list_comments").eq(index).data("type", "value");
		$("#list_comments .list_comments").eq(index).data("page", page);
		
		if (result.err_msg.noNextPage) {
			$("#list_comments .list_comments").eq(index).show().append('<div class="s_empty" style="display:block;">已无更多评价！</div>');
			$("#list_comments .list_comments").eq(index).attr("next", "false");
		}
	});
}

function   formatDate(now)   {
	var   year=now.getFullYear();
	var   month=now.getMonth()+1;
	var   date=now.getDate();
	var   hour=now.getHours();
	var   minute=now.getMinutes();
	var   second=now.getSeconds();
	return   year+"."+month+"."+date;
}