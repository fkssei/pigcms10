/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
var buyer_order_no = '';
var seller_order_no = '';
var delivery_user = '';
var start_time = '';
var end_time = '';
var supplier_id = '';
var delivery_tel = '';
var p = 1;

$(function(){
    load_page('.app__content', load_url, {page:'pay_order_content', 'trade_no': trade_no}, '');

    $('.js-show-order-list').live('click', function(){
        if ($(this).hasClass('total-orders-open')) {
            $('.js-order-pay-list').show();
            $(this).removeClass('total-orders-open');
        } else {
            $(this).addClass('total-orders-open');
            $('.js-order-pay-list').hide();
        }
    })

    //付款给供货商
    $('.js-pay-supplier').live('click', function(e){
        if ($(this).hasClass('sync-store')) { //对接店铺
            button_box($(this), e, 'right', 'confirm', '确认使用余额支付？', function(){
                var trade_no = $("input[name='trade_no']").val();
                var total = $("input[name='total']").val();
                var order_id = $("input[name='order_id']").val();
                var supplier_id = $("input[name='supplier_id']").val();
                var seller_id = $("input[name='seller_id']").val();
                var timestamp = $("input[name='timestamp']").val();
                var hash = $("input[name='hash']").val();
                $.post(pay_order_url, {'trade_no': trade_no, 'total': total, 'order_id': order_id, 'supplier_id': supplier_id, 'seller_id': seller_id, 'timestamp': timestamp, 'hash': hash}, function(data){
                    if (data.err_code == 0) {
                        $('.pay-detail').remove();
                        $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    } else {
                        $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                    }
                    t = setTimeout('msg_hide()', 2000);
                    close_button_box();
                })
            });
            return true;
        }
        var html = '<div class="modal-backdrop in"></div>';
            html += '<div class="modal hide widget-express in" aria-hidden="false" style="display: block; margin-top: -500px;">';
            html += '   <div class="modal-header ">';
            html += '       <a class="close" data-dismiss="modal">×</a>';
            html += '       <h3 class="title">余额支付（' + $('.price-container').text() + '）</h3>';
            html += '   </div>';
            html += '   <div class="modal-body">';
            html += '   <table class="ui-table"><thead><tr><th class="text-left">付款给供货商</th></tr></table><br/>';
            html += '       <form onsubmit="return false;" class="form-horizontal">';
            html += '       <div class="clearfix control-2-col js-express-info">';
            html += '           <div class="control-group">';
            html += '               <label class="control-label">账户密码：</label>';
            html += '               <div class="controls">';
            html += '                   <input type="password" class="input js-number" name="password" />';
            html += '               </div>';
            html += '           </div>';
            html += '       </div>';
            html += '       </form>';
            html += ' </div>';
            html += '<div class="modal-footer"><a href="javascript:;" class="ui-btn ui-btn-primary js-confirm">确认付款</a></div></div>';
        $('body').append(html);
        $('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
        /*return false;
        var trade_no = $("input[name='trade_no']").val();
        var total = $("input[name='total']").val();
        var order_id = $("input[name='order_id']").val();
        var supplier_id = $("input[name='supplier_id']").val();
        var seller_id = $("input[name='seller_id']").val();
        var timestamp = $("input[name='timestamp']").val();
        var hash = $("input[name='hash']").val();

        $.post(pay_order_url, {'trade_no': trade_no, 'total': total, 'order_id': order_id, 'supplier_id': supplier_id, 'seller_id': seller_id, 'timestamp': timestamp, 'hash': hash}, function(data){
            if (data.err_code == 0) {
                $('.pay-detail').remove();
            }
        })*/
    })

    $('.js-confirm').live('click', function(){
        var password = $.trim($("input[name='password']").val());

        $("input[name='password']").closest('.control-group').removeClass('error');
        $("input[name='password']").next('.error-message').remove();
        //if (password == '') {
            //$("input[name='password']").closest('.control-group').addClass('error');
            //$("input[name='password']").after('<p class="help-block error-message">请输入账户密码！</p>');
        //} else {
            $.post(check_password_url, {'password': password}, function(data){
                if (data.err_code != 0) {
                    $("input[name='password']").closest('.control-group').addClass('error');
                    $("input[name='password']").after('<p class="help-block error-message">账户密码输入错误！</p>');
                } else {
                    var trade_no = $("input[name='trade_no']").val();
                    var total = $("input[name='total']").val();
                    var order_id = $("input[name='order_id']").val();
                    var supplier_id = $("input[name='supplier_id']").val();
                    var seller_id = $("input[name='seller_id']").val();
                    var timestamp = $("input[name='timestamp']").val();
                    var hash = $("input[name='hash']").val();
                    $.post(pay_order_url, {'trade_no': trade_no, 'total': total, 'order_id': order_id, 'supplier_id': supplier_id, 'seller_id': seller_id, 'timestamp': timestamp, 'hash': hash}, function(data2){
                        if (data2.err_code == 0) {
                            $('.pay-detail').remove();
                            $('.notifications').html('<div class="alert in fade alert-success">' + data2.err_msg + '</div>');
                            $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
                                $('.modal-backdrop,.modal').remove();
                            });
                        } else {
                            $('.notifications').html('<div class="alert in fade alert-error">' + data2.err_msg + '</div>');
                        }
                        t = setTimeout('msg_hide()', 2000);
                    })
                }
            })
        //}
    })

    $('.close').live('click', function(){
        $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
            $('.modal-backdrop,.modal').remove();
        });
    })
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}
