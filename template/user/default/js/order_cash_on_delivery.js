/**
 * Created by pigcms_21 on 2015/2/5.
 */
$(function() {
    load_page('.app__content', load_url, {page:'cash_on_delivery_content'}, '');

    //全部订单|待发货的订单|已发货的订单|已完成的订单
    $('.ui-nav > ul > li > a').live('click', function(){
        if (!$(this).parent('li').hasClass('active')) {
            $(this).parent('li').addClass('active').siblings('li').removeClass('active');
            load_page('.orders', load_url, {page: 'status', status: $(this).attr('data'), shipping_method: '', payment_method: 'cash_on_delivery', type: ''}, '');
        }
    });
})