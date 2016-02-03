/**
 * Created by pigcms_21 on 2015/3/11.
 */
$(function() {
    load_page('.app__content', load_url, {page: page_content, 'order_id': order_id}, '', function(){

    });

    //切换包裹选项卡
    $('.js-express-tab > li').live('click', function(){
        var index  = $(this).index('.js-express-tab > li');
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $('.section-detail > .js-express-tab-content').eq(index).siblings('div').addClass('hide')
        $('.section-detail > .js-express-tab-content').eq(index).removeClass('hide');
    })

    /*//订单备注
    $('.js-memo-it').live('click', function(e){
        var order_id = $(this).attr('data-id');
        var bak = $(this).attr('data-bak');
        var self = this;
        var obj = $(this).closest('.header-row').next('.content-row');
        button_box($(this), e, 'left', 'input', bak, function(){
            var bak = $('.js-rename-placeholder').val();
            $.post(save_bak_url, {'order_id': order_id, 'bak': bak}, function(data){
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    $('.js-memo-text').text(bak);
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
            close_button_box();
        }, '最多256个字符')
    })*/

    /*//关闭订单
    $('.js-cancel-order').live('click', function(e){
        var order_id  = $(this).attr('data-id');
        var time = $('.order-process-time:eq(0)').text();
        var obj = this;
        button_box($(this), e, 'left', 'confirm', '确定关闭订单？', function(){
            $.post(cancel_status_url, {'order_id': order_id, 'status': 5}, function(data){
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">订单已关闭</div>');
                    $('.order-process').html('<li class="active"><p class="order-process-state">买家已下单</p><p class="bar"><i class="square">√</i></p><p class="order-process-time">' + time + '</p></li><li class="active"><p class="order-process-state">&nbsp;</p><p class="bar">&nbsp;</p><p class="order-process-time"></p></li><li class="active"><p class="order-process-state">&nbsp;</p><p class="bar">&nbsp;</p><p class="order-process-time"></p></li><li class="active"><p class="order-process-state">卖家取消</p><p class="bar"><i class="square">√</i></p><p class="order-process-time">' + data.err_msg + '</p></li>');
                    $('.order-action-btns').remove();
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">订单关闭失败</div>');
                }
                close_button_box();
            })
        })
    })*/

    /*$('.js-stared-it').live('hover', function(){
        if (event.type == 'mouseover') {
            $(this).closest('.m-opts').hide();
            $(this).closest('.m-opts').next('.raty-action').show();
        }
    })*/

    /*//加星
    $('.raty-action').live('hover', function(){
        if (event.type == 'mouseout') {
            $(this).hide();
            $(this).prev('.m-opts').show();
        }
    })*/

    /*$('.raty-action > img').live('hover', function(){
        if (event.type == 'mouseover') {
            if ($(this).hasClass('raty-cancel')) {
                $(this).attr('src', image_path + 'images/cancel-custom-on.png');
            } else {
                $(this).prevAll('.star').attr('src', image_path + 'images/star-on.png');
                $(this).attr('src', image_path + 'images/star-on.png');
            }
        } else if (event.type == 'mouseout') {
            if ($(this).hasClass('raty-cancel')) {
                $(this).attr('src', image_path + 'images/cancel-custom-off.png');
            } else {
                $(this).nextAll('.star').attr('src', image_path + 'images/star-off.png');
                $(this).attr('src', image_path + 'images/star-off.png');
            }
        }
    })*/

    /*$('.raty-action > .star').live('click', function(){
        var star = $(this).prevAll('.star').length + 1;
        var order_id = $(this).attr('data-id');
        var obj = this;
        $.post(add_star_url, {'order_id': order_id, 'star': star}, function(data) {
            $(obj).closest('.raty-action').prev('.m-opts').children('.js-stared-it').remove();
            $(obj).closest('.raty-action').prev('.m-opts').append('<span class="js-stared-it stared"><img src="' + image_path + 'images/star-on.png"> x ' + star + '</span>');
            $(obj).closest('.raty-action').hide();
            $(obj).closest('.raty-action').prev('.m-opts').show();
        })
    })*/

    /*$('.raty-action > .raty-cancel').live('click', function(){
        var star = 0;
        var order_id = $(this).attr('data-id');
        var obj = this;
        $.post(add_star_url, {'order_id': order_id, 'star': star}, function(data) {
            $(obj).closest('.raty-action').prev('.m-opts').children('.js-stared-it').remove();
            $(obj).closest('.raty-action').prev('.m-opts').append('<a class="js-stared-it" href="javascript:;">加星</a>');
            $(obj).closest('.raty-action').hide();
            $(obj).closest('.raty-action').prev('.m-opts').show();
        })
    })*/

    $('.js-save-data').live('click', function(){
        var sub_total = parseFloat($('.js-price-container').text());
        var float_amount = $("input[name='change']").val();
        var postage = $("input[name='postage']").val();
        var order_id = $(this).attr('data-id');
        $.post(float_amount_url, {'order_id': order_id, 'float_amount': float_amount, 'postage': postage, 'sub_total': sub_total}, function(data){
            if (!data.err_code) {
                $('.tb-postage').text(data.err_msg.postage.toFixed(2));
                $('.order-postage').text(data.err_msg.postage.toFixed(2));
                $('.order-total').text(data.err_msg.total.toFixed(2));
                $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
                    $('.modal-backdrop,.modal').remove();
                });
                $('.notifications').html('<div class="alert in fade alert-success">修改成功</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">修改失败</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    })
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}
