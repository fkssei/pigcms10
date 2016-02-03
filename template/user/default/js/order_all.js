/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
$(function() {

    var tmp_status = '*';

    if (getQueryString('start_time')) {
        time_type = 'add_time';
        start_time = getQueryString('start_time').replace('+', ' ');
    }

    if (getQueryString('stop_time')) {
        time_type = 'add_time';
        stop_time = getQueryString('stop_time').replace('+', ' ');
    }

    if (getQueryString('status')) {
        tmp_status = getQueryString('status');
    }

    load_page('.app__content', load_url, {page: page_content, 'status': tmp_status, 'start_time': start_time, 'stop_time': stop_time, 'time_type': time_type}, '', function(){
        if (start_time) {
            $('#js-start-time').val(start_time);
        }
        if (stop_time) {
            $('#js-end-time').val(stop_time);
        }
        //状态
        if (tmp_status) {
            $("select[name='status']").find("option[value='" + tmp_status + "']").attr('selected', true);
            $('.ui-nav > ul > li').removeClass('active');
            if (tmp_status != '*') {
                $(".status-" + tmp_status).closest('li').addClass('active');
                return false;
            } else {
                $(".all").closest('li').addClass('active');
                return false;
            }
        }
        $('.all').parent('li').addClass('active').siblings('li').removeClass('active');
    });

    $('.js-save-data').live('click', function(){
        var sub_total = parseFloat($('.js-price-container').text());
        var float_amount = $("input[name='change']").val();
        var postage = $("input[name='postage']").val();
        var obj = this;
        var order_id = $(this).attr('data-id');
        $.post(float_amount_url, {'order_id': order_id, 'float_amount': float_amount, 'postage': postage, 'sub_total': sub_total}, function(data){
            if (!data.err_code) {
                $('.js-change-price-' + order_id).siblings('.order-total').text(data.err_msg.total.toFixed(2));
                $('.js-change-price-' + order_id).siblings('.c-gray').text('(含运费: ' + data.err_msg.postage.toFixed(2) + ')');
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
