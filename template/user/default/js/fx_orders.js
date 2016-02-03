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
    load_page('.app__content', load_url, {page:'orders_content'}, '');

    //开始时间
    $('#js-start-time').live('focus', function() {
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js-end-time').val() != '') {
                    $(this).datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
                }
            },
            onSelect: function() {
                if ($('#js-start-time').val() != '') {
                    $('#js-end-time').datepicker('option', 'minDate', new Date($('#js-start-time').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($(this).datepicker('getDate'), $('#js-end-time').datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js-end-time').datepicker('getDate'));
                }
            },
            _afterClose: function(date1, date2) {
                var starttime = 0;
                if (date1 != '' && date1 != undefined) {
                    starttime = new Date(date1).getTime();
                }
                var endtime = 0;
                if (date2 != '' && date2 != undefined) {
                    endtime = new Date(date2).getTime();
                }
                if (endtime > 0 && endtime < starttime) {
                    alert('无效的时间段');
                    return false;
                }
                return true;
            }
        };
        $('#js-start-time').datetimepicker(options);
    })


    //结束时间
    $('#js-end-time').live('focus', function(){
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js-start-time').val() != '') {
                    $(this).datepicker('option', 'minDate', new Date($('#js-start-time').val()));
                }
            },
            onSelect: function() {
                if ($('#js-end-time').val() != '') {
                    $('#js-start-time').datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($('#js-start-time').datepicker('getDate'), $(this).datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js-start-time').datepicker('getDate'));
                }
            },
            _afterClose: function(date1, date2) {
                var starttime = 0;
                if (date1 != '' && date1 != undefined) {
                    starttime = new Date(date1).getTime();
                }
                var endtime = 0;
                if (date2 != '' && date2 != undefined) {
                    endtime = new Date(date2).getTime();
                }
                if (starttime > 0 && endtime < starttime) {
                    alert('无效的时间段');
                    return false;
                }
                return true;
            }
        };
        $('#js-end-time').datetimepicker(options);
    })

    //最近7天或30天
    $('.date-quick-pick').live('click', function(){
        $(this).siblings('.date-quick-pick').removeClass('current');
        $(this).addClass('current');
        var tmp_days = $(this).attr('data-days');
        $('.js-start-time').val(changeDate(tmp_days).begin);
        $('.js-end-time').val(changeDate(tmp_days).end);
    })

    $('.js-filter').live('click', function(){
        buyer_order_no = $.trim($("input[name='buyer_order_no']").val());
        seller_order_no = $.trim($("input[name='seller_order_no']").val());
        delivery_user = $.trim($("input[name='customer_name']").val());
        start_time = $.trim($("input[name='start_time']").val());
        end_time = $.trim($("input[name='end_time']").val());
        supplier_id = $.trim($("select[name='supplier_id']").val());
        status = $.trim($("select[name='state']").val());
        delivery_tel = $.trim($("select[name='customer_mobile']").val());

        load_page('.app__content', load_url, {page:'orders_content', 'p': p, 'order_no': buyer_order_no, 'fx_order_no': seller_order_no, 'delivery_user': delivery_user, 'start_time': start_time, 'end_time': end_time, 'supplier_id': supplier_id, 'status': status, 'delivery_tel': delivery_tel}, '', function(){
            if (buyer_order_no != '') {
                $("input[name='buyer_order_no']").val(buyer_order_no);
            }
            if (seller_order_no != '') {
                $("input[name='seller_order_no']").val(seller_order_no)
            }
            if (delivery_user != '') {
                $("input[name='delivery_user']").val(delivery_user)
            }
            if (start_time != '') {
                $("input[name='start_time']").val(start_time)
            }
            if (end_time != '') {
                $("input[name='end_time']").val(end_time)
            }
            if (supplier_id != '') {
                $("select[name='supplier_id']").find("option[value='" + supplier_id + "']").attr('selected', true);
            }
            if (status != '') {
                $("select[name='state']").find("option[value='" + status + "']").attr('selected', true);
            }
            if (delivery_tel != '') {
                $("input[name='delivery_tel']").val(delivery_tel)
            }
        });
    })

    //分页
    $('.pagenavi > a').live('click', function(){
        var p = $(this).attr('data-page-num');
        buyer_order_no = $.trim($("input[name='buyer_order_no']").val());
        seller_order_no = $.trim($("input[name='seller_order_no']").val());
        delivery_user = $.trim($("input[name='customer_name']").val());
        start_time = $.trim($("input[name='start_time']").val());
        end_time = $.trim($("input[name='end_time']").val());
        supplier_id = $.trim($("select[name='supplier_id']").val());
        status = $.trim($("select[name='state']").val());
        delivery_tel = $.trim($("select[name='customer_mobile']").val());
        load_page('.app__content', load_url, {page:'orders_content', 'p': p, 'order_no': buyer_order_no, 'fx_order_no': seller_order_no, 'delivery_user': delivery_user, 'start_time': start_time, 'end_time': end_time, 'supplier_id': supplier_id, 'status': status, 'delivery_tel': delivery_tel}, '', function(){
            if (buyer_order_no != '') {
                $("input[name='buyer_order_no']").val(buyer_order_no);
            }
            if (seller_order_no != '') {
                $("input[name='seller_order_no']").val(seller_order_no)
            }
            if (delivery_user != '') {
                $("input[name='delivery_user']").val(delivery_user)
            }
            if (start_time != '') {
                $("input[name='start_time']").val(start_time)
            }
            if (end_time != '') {
                $("input[name='end_time']").val(end_time)
            }
            if (supplier_id != '') {
                $("select[name='supplier_id']").find("option[value='" + supplier_id + "']").attr('selected', true);
            }
            if (status != '') {
                $("select[name='state']").find("option[value='" + status + "']").attr('selected', true);
            }
            if (delivery_tel != '') {
                $("input[name='delivery_tel']").val(delivery_tel)
            }
        });
    })

    $('.js-pay-btn').live('click', function(){
        var order_id = $(this).data('id');
        $.post(pay_url, {'order_id': order_id, 'type': 'pay'}, function(data){
            if (data.err_code == 0) {
                window.location.href= data.err_msg;
            }
        })
    })

    $('.js-batch-pay').live('click', function(){
        if ($('.js-check-toggle:checked').length == 0) {
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择订单。</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        var order_id = [];
        var supplier_id = [];
        var flag = false;
        $('.js-check-toggle:checked').each(function(i){
            order_id[i] = $(this).val();
            if ($.inArray($(this).data('supplier-id'), supplier_id) >= 0 || i == 0) {
                supplier_id[i] = $(this).data('supplier-id');
            } else { //不同供货商
                flag = true;
            }
        })
        if (flag) {
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>不同供货商订单不能合并支付。</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        order_id = order_id.toString();
        $.post(pay_url, {'order_id': order_id, 'type': 'pay'}, function(data){
            if (data.err_code == 0) {
                window.location.href= data.err_msg;
            }
        })
    })
})

function changeDate(days){
    var today=new Date(); // 获取今天时间
    var begin;
    var endTime;
    if(days == 3){
        today.setTime(today.getTime()-3*24*3600*1000);
        begin = today.format('yyyy-MM-dd');
        today = new Date();
        today.setTime(today.getTime()-1*24*3600*1000);
        end = today.format('yyyy-MM-dd');
    }else if(days == 7){
        today.setTime(today.getTime()-7*24*3600*1000);
        begin = today.format('yyyy-MM-dd');
        today = new Date();
        today.setTime(today.getTime()-1*24*3600*1000);
        end = today.format('yyyy-MM-dd');
    }else if(days == 30){
        today.setTime(today.getTime()-30*24*3600*1000);
        begin = today.format('yyyy-MM-dd');
        today = new Date();
        today.setTime(today.getTime()-1*24*3600*1000);
        end = today.format('yyyy-MM-dd');
    }
    return {'begin': begin + ' 00:00:00', 'end': end + ' 23:59:59'};
}

//格式化时间
Date.prototype.format = function(format){
    var o = {
        "M+" : this.getMonth()+1, //month
        "d+" : this.getDate(),    //day
        "h+" : this.getHours(),   //hour
        "m+" : this.getMinutes(), //minute
        "s+" : this.getSeconds(), //second
        "q+" : Math.floor((this.getMonth()+3)/3),  //quarter
        "S" : this.getMilliseconds() //millisecond
    }
    if(/(y+)/.test(format)) {
        format=format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
    }
    for(var k in o) {
        if(new RegExp("("+ k +")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
        }
    }
    return format;
}
