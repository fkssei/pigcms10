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

    switch(mark_arr[0]) {
        case '#used':
            $(".tabber_menu").find("a[href='#used']").addClass('active');
            getCoupons('used',page2);
            break;

        case '#unused':
            $(".tabber_menu").find("a[href='#unused']").addClass('active');
            getCoupons('unused',page2);
            break;
        default:
            $(".tabber_menu").find("a[href='#all']").addClass('active');
            getCoupons('all',page2);
            break;
    }
}


//获取优惠券列表
function getCoupons(type,page2){

    $('.wx_loading2').show();
    couponIsAjax = true;
   // return false;
    if(!type) type ='all' ;
    if(page2 == '0') {}else{couponPage = page2;}
    $.ajax({
        type:"POST",
        url:'my_coupon.php?action=get_usercoupon_list',
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
                            typename = '已使用';
                        }

                        if(coupon.description){
                            var miaoshu = coupon.description;
                        } else {
                            var miaoshu = "暂无描述";
                        }

                        productHtml += '<li class="promote-item coupon-style-0">';
                        productHtml +=      '<div class="promote-left-part"><div class="inner">';
                        productHtml +=           '<h4 class="promote-shop-name font-size-14">'+coupon.cname+'</h4>  ';
                        productHtml +=           '<div class="promote-card-value"> <span>￥</span><i>'+coupon.face_money+'</i></div>';
                        if(coupon.limit_money> 0) {
                            productHtml += '<div class="promote-condition font-size-12">  限制：订单满￥<em>'+coupon.limit_money+'</em>可用 </div>';
                        } else{
                            productHtml += '<div class="promote-condition font-size-12">  无限制 </div>';
                        }
                        productHtml +=      '</div> </div>';
                        productHtml +=      '<div class="promote-right-part center font-size-12"><div class="inner">';
                        productHtml +=          '<div>   </div>';
                        productHtml += '<div class="promote-use-state font-size-16" style="width:12px;padding:8px 16px"> '+typename+'</div> </div> ';
                        productHtml +=          '<i class="expired-icon"></i> <i class="left-dot-line"></i>';
                        productHtml += '</div><div class="p_card_div"><p class="p_card" style="">有效期至：'+formatDate(start_time)+' 至 '+formatDate(end_time)+' </p>';
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

$(".promote-item").live("click",function(){
    $(".promote-item").removeClass("curr_li");
   $(this).addClass("curr_li");
    $(".promote-item .p_card,.promote-item .p_card2").hide();
    $(this).find(".p_card,.p_card2").show();

})


function   formatDate(now)   {
    var   year=now.getFullYear();
    var   month=now.getMonth()+1;
    var   date=now.getDate();
    var   hour=now.getHours();
    var   minute=now.getMinutes();
    var   second=now.getSeconds();
    return   year+"."+month+"."+date;
}


