/**
 * Created by pigcms_21 on 2015/2/5.
 */
$(function() {
    load_page('.app__content', load_url, {page: page_content, 'status': '*'}, '', function(){
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