var couponPage = 1;
var couponIsAjax = false;
var couponSort = 'default';
var couponShowRows = false;
var hrefs2 = '';
$(function() {
    FastClick.attach(document.body);
    $(window).scroll(function(){
        if(couponPage > 1 && $(window).scrollTop()/($('body').height() -$(window).height())>=0.95){
            if(couponIsAjax){
                if(location.hash){
                    hrefs2 =location.hash;
                } else {
                    hrefs2 = "#all";
                }
                location_page(hrefs2,'0')
            }
        }
        if($(document).scrollTop() > 50){
            $('.mod_filter').css('top',0);
        }else{
            $('.mod_filter').css('top',45);
        }
    });


    if($(window).width() < 400){
        //窄屏手机
        //  couponShowRows = true;
        //  $('#itemList').addClass('mod_itemlist_small').removeClass('mod_itemgrid');
        //   $('#sortBlock .icon_switch').closest('a').removeClass('state_switch');
    }

    //location_page('#all','1')
    location_page(location.hash,'0');
})

$(".tabber_menu a").live('click',function(){
    var hrefs =  $(this).attr("href");
    $(".promote-card-list").html("");
    $(".s_empty").hide();
    if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#'){
        location_page(hrefs,1);
    } else {
        location_page('#all',1)
    }
})


function location_page(mark,page2) {
    var mark_arr = mark.split('/');
    $(".tabber_menu a").removeClass('active');
    if(!mark_arr[0]) mark_arr[0] = "#all";
    switch(mark_arr[0]) {
        case '#all':
            $(".tabber_menu").find("a[href='#all']").addClass('active');
            getCoupons('all',page2);
            break;

    }
}


//获取优惠券列表
function getCoupons(type,page2){
	var store_id = $("#button_store_id").val();
	if(!store_id) return false;
    $('.wx_loading2').show();
    couponIsAjax = true;
    // return false;
    if(!type) type ='all' ;
    if(page2 == '0') {}else{couponPage = page2;}
    $.ajax({
        type:"POST",
        url:'store_coupon.php?action=get_usercoupon_list&id='+store_id,
        data:'type='+type+'&page='+couponPage+'&sort='+couponSort,
        dataType:'json',
        success:function(result){
            $('.wx_loading2').hide();
            if(result.err_code){
                motify.log(result.err_msg);
            }else{
                if(result.err_msg.list.length > 0){
                    $(".empty-list").hide();
                    if(result.err_msg.count){
                        $('#sFound').removeClass('hide').find('#totResult').html(result.err_msg.count);
                    }
                    var productHtml = '';
                    for(var i in result.err_msg.list){
                        var coupon = result.err_msg.list[i];
                        var start_time =  new Date((coupon.start_time)*1000);
                        var end_time =  new Date((coupon.end_time)*1000);
                        var typename;
                        if(coupon.is_use=='0'){
                            if(coupon.endtime*1000<(new Date()).valueOf()){
                                typename = '已过期'
                            } else {
                                typename = '将过期'; //未使用
                            }
                        }else{
                            typename = '可领取';
                        }
                        if(coupon.description){
                            var miaoshu = coupon.description;
                        } else {
                            var miaoshu = "暂无描述";
                        }
                        var shengyu = parseInt(coupon.total_amount)-parseInt(coupon.number);

                        productHtml += '<li class="promote-item coupon-style-0">';
                        productHtml +=      '<div class="promote-left-part"><div class="inner">';
                        productHtml +=           '<h4 class="promote-shop-name font-size-14">'+coupon.name+'<span style="float:right">'+shengyu+'件</span></h4>  ';
                        productHtml +=           '<div class="promote-card-value"> <span>￥</span><i>'+coupon.face_money+'</i></div>';
                        if(coupon.limit_money> 0) {
                            productHtml += '<div class="promote-condition font-size-12">  限制：订单满￥<em>'+coupon.limit_money+'</em>可用 </div>';
                        } else{
                            productHtml += '<div class="promote-condition font-size-12">  无限制 </div>';
                        }
                        productHtml +=      '</div> </div>';
                        productHtml +=      '<div data='+coupon.id+' class="promote-right-part center font-size-12"><div class="inner">';
                        productHtml +=          '<div>   </div>';
                        productHtml += '<div class="promote-use-state font-size-16" style="width:12px;padding:11px 16px;line-height:20px;"> '+typename+'</div> </div> ';
                        productHtml +=          '<i class="expired-icon"></i> <i class="left-dot-line"></i>';
                        productHtml += '</div><div class="p_card_div"><p class="p_card" style="">有效期至：'+formatDate(start_time,'1')+' 至 '+formatDate(end_time,'1')+' </p>';
                        productHtml += '<p class="p_card2" >描述：'+miaoshu+' </p></div>';
                        productHtml += '</li>';

                    }
                    $('.promote-card-list').append(productHtml).removeClass('hide');

                    if(typeof(result.err_msg.noNextPage) == 'undefined'){
                        couponIsAjax = false;
                    }else{
                        $('#noMoreTips').removeClass('hide');
                    }
                }else {
                    if(couponPage == 1){
                        $('#sNull01').removeClass('hide');
                        $(".empty-list").show();
                    }else{
                        $(".empty-list").hide();
                        $(".s_empty").show();
                        $('#noMoreTips').removeClass('hide');
                    }
                }
                couponPage ++;
            }
        },
        error:function(){
            $('.wx_loading2').hide();
            motify.log('优惠券信息获取失败，<br/>请刷新页面重试',0);
        }
    });
}

//显示详细
$(".promote-item .promote-left-part").live("click",function(){
    $(".promote-item").removeClass("curr_li");
    $(this).closest(".promote-item").addClass("curr_li");
    $(".promote-item .p_card,.promote-item .p_card2").hide();
    $(this).closest(".promote-item").find(".p_card,.p_card2").show();

})

$(".hproduct .promote-card-list li").live("click",function(){

    //优惠券各项信息
   var coupon_id = $(this).find(".couponid").val();
   var coupon_name =  $(this).find(".cname").html();
   var coupon_face_money =  $(this).find(".face_money").attr("data");
   var coupon_start_time = $(this).find(".start_time").attr("data");
   var coupon_end_time = $(this).find(".end_time").attr("data");
   var coupon_limit_money = $(this).find(".limit_money").val();
   var coupon_description = $(this).find(".description").val();
   var coupon_most_have = $(this).find(".most_have").val();
   var syxz;
   if(coupon_limit_money> 0) {
        var syxz = '<span id="is_at_least">订单满 <span id="jtje">'+coupon_limit_money+'</span> 元 (含运费)</span>';
    }else {
        var syxz = '<span id="is_at_least">无限制</span>';
    }
   var most_haves;
    if(coupon_most_have> 0) {
        var most_haves = '<div class="coupon-msg">每人限领 '+coupon_most_have+' 张</div>';
    }else {
        var most_haves = '<span id="is_at_least">无限制</span>';
    }

//页面层
/*
var pageii = $.layer({
    type: 1,
    title: false,
    area: ['auto', 'auto'],
    border: [0], //去掉默认边框
    shade: [0.3,'#000'], //去掉遮罩
    closeBtn: [0, false], //去掉默认关闭按钮
    shift: 'top', //从左动画弹出
    page: {
        html: '<div class="content-body" style="width:270px; height:370px;><div class="ump-coupon-wrap"><div class="ump-coupon-detail">  <div class="ump-coupon-header"><div class="inner">  '+coupon_name+'<!--<div class="share"></div>-->  <div class="js-share share-response"></div> </div></div> <div class="ump-coupon-body"><div class="inner"> <div class="ump-coupon-value"> <span>￥</span><i>'+coupon_face_money+'</i> </div> </div> </div><div class="ump-coupon-footer"> <div class="inner"> <p class="ump-coupon-desc">有效日期：'+coupon_start_time+'  至<br>&#12288;&#12288;&#12288;&#12288;&#12288; '+coupon_end_time+' </p><p class="ump-coupon-desc">使用限制：'+syxz+'</p><p class="ump-coupon-desc">补充说明：</p><p style="height:37px;overflow:hidden" class="ump-coupon-desc addition-desc"> 使用说明使用说明使用说明	</p></div></div></div><div class="ump-coupon-action"><div class="inner">'+most_haves+'<div class="coupon-get"><a class="js-get-promote ump-coupon-item-button coupon_id"  data="'+coupon_id+'"    href="javascript:void(0)">点击领取</a></div></div></div></div> <span class="xubox_setwin"><a style="" href="javascript:;" class="xubox_close xulayer_png32 xubox_close0333 xubox_close1333 " id="pagebtn"></a></span>><</div>'
    }
});


//自设关闭
    $('#pagebtn').on('click', function(){
        layer.close(pageii);
    });
 */
})

function   formatDate(now,types)   {

    var   year= (now.getYear()<1900)?(1900+now.getYear()):now.getYear();

    var   month=now.getMonth()+1;
    var   date=now.getDate();
    var   hour=now.getHours();
    var   minute=now.getMinutes();
    var   second=now.getSeconds();

    switch(types) {
       case "1":     var  times =  year+"."+month+"."+date;   break;
       case "2":     var  times =  year+"."+month+"."+date+" "+hour+":"+minute+":"+second;   break;
       case "3":     var  times =  year+"-"+month+"-"+date; break;
       case "4":     var  times =  year+"-"+month+"-"+date+" "+hour+":"+minute+":"+second; break;
   }
    return times;
}



//领取优惠券
$(".promote-item .promote-right-part").live("click",function(){
    var couponid = $(this).attr("data");
	var store_id = $("#button_store_id").val();
	if(!store_id) return false;
	
    if(!couponid) {tips("缺少参数",'err');; return false;}
    var url = "./store_coupon.php?action=user_get_coupon&id="+store_id+"&couponid=" + couponid;

     $.getJSON( url, function (data) {

      var  data_code = data.err_code;
      var  data_err_msg = data.err_msg;
         if ( data_code!= 0) {
             tips(data_err_msg,'err');
        } else { //领取成功
             tips("领取成功",'ok');

        }



    })
})



function tips(contents,status){
    if(status =='ok') {status='9';}else{status='8';}

    layer.open({
      content:contents,
      time:2,
      title:['温馨提示'],
      cancel:function(index){
        if(status =='ok') {
             location.reload();
        } else {
             layer.close(index)
        }
    }
    });



}
