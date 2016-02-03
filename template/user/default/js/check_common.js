/**
 * Created by pigcms_21 on 2015/3/12.
 */

var orderbyfield = ''; //排序字段
var orderbymethod = ''; //排序方式
var page = 1; //页码
var order_no = ''; //订单号
var trade_no = ''; //交易号
var user = ''; //收货人
var tel = ''; //收货电话
var time_type = ''; //时间类型
var start_time = ''; //下单时间
var stop_time = ''; //下单时间
var type = ''; //订单类型 （普通|代付）
var weixin_user = ''; //微信昵称
var payment_method = ''; //付款方式
var shipping_method = ''; //运送方式
var status = '';
var type_check = 'all';	//对账专用	
$(function(){

    //全部订单|待付款订单|待发货的订单|已发货的订单|已完成的订单|已取消的订单|临时订单
    $('.ui-nav > ul > li > a').live('click', function(){
        //if (!$(this).parent('li').hasClass('active')) {
        var obj = this;
        var class_name = $(this).attr('class');
        if (status == '') {
            status = $(this).attr('data');
        }
		var stt =$(this).attr('data');
		
		if(stt == '1') type_check = 'uncheck';
		if(stt == '2') type_check = 'check';
		if(stt == '0') {$(".all").closest('li').addClass('active'); type_check = "all";}	
		
		
        load_page('.app__content', load_url, {'page': page_content, 'status': status, 'p': page,'type_check':type_check, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod, 'order_no': order_no, 'trade_no': trade_no, 'user': user, 'tel': tel, 'time_type': time_type, 'start_time': start_time, 'stop_time': stop_time, 'weixin_user': weixin_user, 'shipping_method': shipping_method, 'payment_method': payment_method, 'type': type}, '', function(){
            $('.' + class_name).parent('li').addClass('active').siblings('li').removeClass('active');
            if (orderbyfield != '' && orderbymethod != '') {
                $('.orderby').children('span').remove();
                $('.orderby_' + orderbyfield).append('<span class="orderby-arrow ' + orderbymethod + '"></span>');
            }
            //订单号
            if (order_no != '') {
                $("input[name='order_no']").val(order_no);
            }
            //交易号
            if (trade_no != '') {
                $("input[name='trade_no']").val(trade_no);
            }
            //状态
            if (status) {
                $("select[name='status']").find("option[value='" + status + "']").attr('selected', true);
                $('.ui-nav > ul > li').removeClass('active');
                if (status != '0') {
                    $(".status-" + status).closest('li').addClass('active');
                } else {
                    $(".all").closest('li').addClass('active');
                }
            } 
			
            if (time_type) {
                $("select[name='time_type']").find("option[value='" + time_type + "']").attr('selected', true);
            }
            //订单类型
            if (type) {
                $("select[name='type']").find("option[value='" + type + "']").attr('selected', true);
            }
            //收货人
            if (user) {
                $("input[name='user']").val(user);
            }
            if (time_type) {
                $("select[name='time_type']").find("option[value='" + time_type + "']").attr('selected', true);
            }
            if (start_time) {
                $('#js-start-time').val(start_time);
            }
            if (stop_time) {
                $('#js-end-time').val(stop_time);
            }
            //收货人手机
            if (tel) {
                $("input[name='tel']").val(tel);
            }
            //支付方式
            if (payment_method) {
                $("select[name='payment_method']").find("option[value='" + payment_method + "']").attr('selected', true);
            }
            //运送方式
            if (shipping_method) {
                $("select[name='shipping_method']").find("option[value='" + shipping_method + "']").attr('selected', true);
            }
 
            status = '';
        });
        //}
    });

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

    //排序
    $('.orderby').live('click', function(){
        orderbyfield = $(this).attr('data-orderby');
        if ($(this).children('span').hasClass('desc')) {
            orderbymethod = 'asc';
        } else {
            orderbymethod = 'desc';
        }
        status = $('.ui-nav > ul > .active > a').attr('data');
        $('.ui-nav > ul > .active > a').trigger('click');
    })

    //分页
    $('.pagenavi > a').live('click', function(){
        page = $(this).attr('data-page-num');
        $('.ui-nav > ul > .active > a').trigger('click');
    })

    //筛选
    $('.js-filter').live('click', function(){
        order_no = $("input[name='order_no']").val();
        trade_no = $("input[name='trade_no']").val();
        user = $("input[name='user']").val();
        tel = $("input[name='tel']").val();
        time_type = $("select[name='time_type']").val();
        start_time = $("input[name='start_time']").val();
        stop_time = $("input[name='end_time']").val();
        type = $("select[name='type']").val();
        status = $("select[name='status']").val();
        payment_method = $("select[name='payment_method']").val();
        shipping_method = $("select[name='shipping_method']").val();
        $('.ui-nav > ul > .active > a').trigger('click');
    })

    //修改价格
    $('.js-change-price').live('click', function(){
        var order_id = $(this).attr('data-id');
        $.post(detail_json_url, {'order_id': order_id}, function(data){
            var data = $.parseJSON(data);
            var html = '<div class="modal-backdrop fade in"></div>';
            html += '   <div class="modal hide fade order-price in" style="margin-top: -1000px; display: block;" aria-hidden="false">';
            html += '       <div class="modal-header">';
            html += '           <a class="close" data-dismiss="modal">×</a><h3 class="title">订单原价(不含运费)：<span class="js-price-container price-color">' + data.sub_total + '</span> 元</h3>';
            html += '       </div>';
            html += '       <div class="modal-body js-detail-container"><div>';
            html += '       <form action="" class="form-inline">';
            html += '       <table class="table order-price-table">';
            html += '           <thead>';
            html += '               <tr>';
            html += '                   <th class="tb-name">商品</th>';
            html += '                   <th class="tb-price">单价（元）</th>';
            html += '                   <th class="tb-num">数量</th>';
            html += '                   <th class="tb-total">小计（元）</th>';
            //html += '                   <th class="tb-coupon">店铺优惠</th>';
            html += '                   <th class="tb-discount">涨价或减价</th>';
            html += '                   <th class="tb-postage">运费（元）</th>';
            html += '               </tr>';
            html += '           </thead>';
            html += '           <tbody>';
            for (i in data.products) {
                html += '               <tr>';
                html += '                   <td class="tb-name">';
                html += '                       <a href="'+data.products[i]['url']+'" class="new-window" target="_blank">' + data.products[i]['name'] + '</a>';
                if (data.products[i]['sku'] != '') {
                    html += '                       <p>';
                    html += '                           <span class="c-gray">';
                    for (j in data.products[i]['skus']) {
                        html += data.products[i]['skus'][j]['name'] + ': ' + data.products[i]['skus'][j]['value'] + '&nbsp;';
                    }
                    html += '                           </span>';
                    html += '                       </p>';
                }
                html += '                   </td>';
                html += '                   <td class="tb-price">' + data.products[i]['price'] + '</td>';
                html += '                   <td class="tb-num">' + data.products[i]['quantity'] + '</td>';
                html += '                   <td class="tb-total" style="border-right: 1px solid #e4e4e4;">' + (data.products[i]['price'] * data.products[i]['quantity']).toFixed(2) + '</td>';
                //html += '                   <td class="tb-coupon" rowspan="5" style="border-right: 1px solid #e4e4e4;"></td>';
                if (i == 0) {
                    html += '                   <td class="tb-discount" rowspan="' + data.products.length + '" style="border-right: 1px solid #e4e4e4;">';
                    html += '                       <input type="text" class="input input-mini" data="' + (data.float_amount != 0 ? data.float_amount : '0.00') + '" name="change" value="' + (data.float_amount != 0 ? data.float_amount : '0.00') + '" />';
                    //html += '                       <label class="checkbox inline"><input type="checkbox" name="is_allow_preference">允许买家再<br>使用其他优惠</label>';
                    html += '                   </td>';
                    html += '                   <td class="tb-postage" rowspan="' + data.products.length + '">';
                    html += '                       <input type="text" class="input input-mini" data="' + (data.postage != 0 ? data.postage : '0.00') + '" value="' + (data.postage != 0 ? data.postage : '0.00') + '" name="postage" />';
                    html += '                       <p><a href="javascript:;" class="js-no-postage">直接免运费</a></p>';
                    html += '                   </td>';
                }
                html += '               </tr>';
            }
            html += '           </tbody>';
            html += '       </table>';
            html += '       </form>';
            html += '   </div>';
            html += '</div>';
            html += '   <div class="modal-footer clearfix">';
            html += '       <a href="javascript:;" class="btn btn-primary pull-right js-save-data" data-id="' + data.order_id + '" data-loading-text="确 定...">确 定</a>';
            html += '       <div class="final js-footer text-left pull-left"><div>';
            html += '       <p>收货地址： ' + (data.address.province != undefined ? data.address.province : '') + ' ' + (data.address.city != undefined ? data.address.city : '') + ' ' + (data.address.area != undefined ? data.address.area : '') + ' ' + (data.address.address != undefined ? data.address.address : '') + '</p>';
            if (data.float_amount > 0) {
                var symbol = '+';
            } else {
                var symbol = '-';
            }
            html += '       <p>买家实付：' + data.sub_total + ' + <span class="js-order-postage">' + data.postage + '</span> <span class="decrease-color js-order-change">' + symbol + ' ' + (data.float_amount != 0 ? Math.abs(data.float_amount).toFixed(2) : '0.00') + '</span> - <span class="decrease-color"> ' + Math.abs(data.reward_money).toFixed(2) + ' </span>  = <span class="price-color js-order-realpay">' + data.total + '</span></p>';
            html += '       <p class="help-block">买家实付 = 原价 + 运费 + 涨价或减价 - 满减或优惠券</p>';
            html += '   </div></div></div></div>';
            $('body').append(html);
            $('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
        })
    })

    $('.modal-header > .close').live('click', function(){
        $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
            $('.modal-backdrop,.modal').remove();
            if ($('.select2-display-none').length > 0) {
                $('.select2-display-none').remove();
            }
        });
    })

    //sub_total浮动
    $("input[name='change']").live('blur', function(){
        if (isNaN($(this).val())) {
            $(this).val('0.00');
            $('.js-order-change').text('- 0.00');
            return false;
        }
        $(this).val(parseFloat($(this).val()).toFixed(2));
        var sub_total = parseFloat($('.js-price-container').text());
        var postage = parseFloat($('.js-order-postage').text());
        var float_amount = parseFloat($(this).val());
        if (float_amount > 0) {
            $('.js-order-change').text('+ ' + Math.abs($(this).val()).toFixed(2));
        } else if (float_amount < 0 && Math.abs(float_amount) < sub_total) {
            $('.js-order-change').text('- ' + Math.abs($(this).val()).toFixed(2));
        } else {
            $('.js-order-change').text('- 0.00');
        }
        $('.js-order-realpay').text((sub_total + postage + float_amount).toFixed(2));
    })

    //运费浮动
    $("input[name='postage']").live('blur', function(){
        if (isNaN($(this).val()) || $(this).val() < 0) {
            $(this).val($('.js-order-postage').text());
            return false;
        }
        $(this).val(parseFloat($(this).val()).toFixed(2));
        $('.js-order-postage').text(parseFloat($(this).val()).toFixed(2));
        var sub_total = parseFloat($('.js-price-container').text());
        var float_amount = parseFloat($('.js-order-change').text().replace(' ', ''));
        var float_postage = parseFloat($(this).val());
        $('.js-order-realpay').text((sub_total + float_postage + float_amount).toFixed(2));
    })

    $('.js-no-postage').live('click', function(){
        $("input[name='postage']").val('0.00');
        $('.js-order-postage').text('0.00');

        var sub_total = parseFloat($('.js-price-container').text());
        var float_amount = parseFloat($('.js-order-change').text().replace(' ', ''));
        var postage = parseFloat($('.js-order-postage').text());
        $('.js-order-realpay').text((sub_total + postage + float_amount).toFixed(2));
    })

    //订单备注
    $('.order-opts-container').find('.js-memo-it').live('click', function(e){
        var order_id = $(this).attr('data-id');
        var bak = $(this).attr('data-bak');
        var self = this;
        var obj = $(this).closest('.header-row').next('.content-row');
        button_box($(this), e, 'left', 'input', bak, function(){
            var bak = $('.js-rename-placeholder').val();
            $.post(save_bak_url, {'order_id': order_id, 'bak': bak}, function(data){
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    $(obj).closest('tbody').children('.remark-row').remove();
                    $(self).attr('data-bak', bak);
                    $(obj).closest('tbody').append('<tr class="remark-row"><td colspan="8">卖家备注：' + bak + '</td></tr>');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
            close_button_box();
        }, '最多256个字符')
    })

    //订单备注
    $('.section').find('.js-memo-it').live('click', function(e){
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
                    $(self).attr('data-bak', bak);
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
            close_button_box();
        }, '最多256个字符')
    })

    //关闭订单
    $('.order-action-btns > .js-cancel-order').live('click', function(e){
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
    })

    //关闭订单
    $('.td-cont > p > .js-cancel-order').live('click', function(e){
        var order_id = $(this).attr('data-id');
        button_box($(this), e, 'left', 'confirm', '确定取消订单？', function(){
            $.post(cancel_status_url, {'order_id': order_id, 'status': 5}, function(data){
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">订单已关闭</div>');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">订单关闭失败</div>');
                }
                close_button_box();
                $('.ui-nav > ul > .active > a').trigger('click');
            })
        })
    })

    $('.js-stared-it').live('hover', function(){
        if (event.type == 'mouseover') {
            $(this).closest('.m-opts').hide();
            $(this).closest('.m-opts').next('.raty-action').show();
        }
    })

    //加星
    $('.raty-action').live('hover', function(){
        if (event.type == 'mouseout') {
            $(this).hide();
            $(this).prev('.m-opts').show();
        }
    })

    $('.raty-action > img').live('hover', function(){
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
    })

    $('.raty-action > .star').live('click', function(){
        var star = $(this).prevAll('.star').length + 1;
        var order_id = $(this).attr('data-id');
        var obj = this;
        $.post(add_star_url, {'order_id': order_id, 'star': star}, function(data) {
            $(obj).closest('.raty-action').prev('.m-opts').children('.js-stared-it').remove();
            $(obj).closest('.raty-action').prev('.m-opts').append('<span class="js-stared-it stared"><img src="' + image_path + 'images/star-on.png"> x ' + star + '</span>');
            $(obj).closest('.raty-action').hide();
            $(obj).closest('.raty-action').prev('.m-opts').show();
        })
    })

    $('.raty-action > .raty-cancel').live('click', function(){
        var star = 0;
        var order_id = $(this).attr('data-id');
        var obj = this;
        $.post(add_star_url, {'order_id': order_id, 'star': star}, function(data) {
            $(obj).closest('.raty-action').prev('.m-opts').children('.js-stared-it').remove();
            $(obj).closest('.raty-action').prev('.m-opts').append('<a class="js-stared-it" href="javascript:;">加星</a>');
            $(obj).closest('.raty-action').hide();
            $(obj).closest('.raty-action').prev('.m-opts').show();
        })
    })

    $('.js-express-goods').live('click', function(){
        var order_id = $(this).attr('data-id');
        $.post(package_product_url, {'order_id': order_id}, function(data){
            var data = $.parseJSON(data);
            var html = '<div class="modal-backdrop in"></div><div class="modal hide widget-express in" aria-hidden="false" style="display: block; margin-top: -1000px;">';
            html += '       <div class="modal-header ">';
            html += '           <a class="close" data-dismiss="modal">×</a>';
            html += '           <h3 class="title">商品发货</h3>';
            html += '       </div>';
            html += '       <div class="modal-body">';
            html += '           <table class="ui-table">';
            html += '               <thead>';
            html += '                   <tr>';
            html += '                       <th class="text-right cell-5">';
            html += '                           <input type="checkbox" checked="true" value="1" class="js-check-all" />';
            html += '                       </th>';
            html += '                       <th class="cell-35">商品</th>';
            html += '                       <th class="cell-10">数量</th>';
            html += '                       <th class="cell-20">物流公司</th>';
            html += '                       <th class="cell-30">快递单号</th>';
            html += '                   </tr>';
            html += '               </thead>';
            html += '               <tbody>';
            if (data.products != '' && data.products.length > 0) {
                for (i in data.products) {
                    html += '                   <tr>';
                    html += '                       <td class="text-right">';
                    html += '                           <input type="checkbox" class="js-check-item" checked="true" value="' + data.products[i]['product_id'] + '" />';
                    html += '                       </td>';
                    html += '                       <td>';
                    html += '                           <div>';
                    html += '                               <a href="" class="new-window" target="_blank">' + data.products[i]['name'] + '</a>';
                    html += '                           </div>';
                    html += '                           <div>';
                    html += '                               <span class="c-gray">';
                    for (j in data.products[i].skus) {
                        html += data.products[i].skus[j]['value'] + '&nbsp;';
                    }
                    html += '                               </span>';
                    html += '                           </div>';
                    html += '                       </td>';
                    html += '                       <td>' + data.products[i]['pro_num'] + '</td>';
                    html += '                       <td></td>';
                    html += '                       <td></td>';
                    html += '                   </tr>';
                }
            }
            html += '               </tbody>';
            html += '           </table>';
            html += '           <form onsubmit="return false;" class="form-horizontal">';
            html += '           <div class="control-group">';
            html += '               <label class="control-label">收货地址：</label>';
            html += '               <div class="controls">';
            html += '                   <div class="control-action">' + data.address.province + ' ' + data.address.city + ' ' + data.address.area + ' ' + data.address.address + '</div>';
            html += '               </div>';
            html += '           </div>';
            html += '           <div class="control-group">';
            html += '               <label class="control-label">发货方式：</label>';
            html += '               <div class="controls">';
            html += '                   <label class="radio inline"><input type="radio" name="no_express" value="0" checked="true" data-validate="no" style="width:auto;height:auto;" />需要物流</label>';
            html += '                   <label class="radio inline"><input type="radio" name="no_express" value="1" data-validate="no" style="width:auto;height:auto;" />无需物流</label>';
            html += '               </div>';
            html += '           </div>';
            html += '           <div class="clearfix control-2-col js-express-info">';
            html += '               <div class="control-group">';
            html += '                   <label class="control-label">物流公司：</label>';
            html += '                   <div class="controls">';
            html += '                       <div class="select2-container js-company select2-container-active" id="s2id_autogen1" style="width: 200px;">';
            html += '                           <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">';
            html += '                               <span class="select2-chosen" data-id="0">请选择一个物流公司</span>';
            html += '                               <abbr class="select2-search-choice-close"></abbr>';
            html += '                               <span class="select2-arrow"><b></b></span>';
            html += '                           </a>';
            html += '                           <input class="select2-focusser select2-offscreen" type="text" id="s2id_autogen2" disabled="" />';
            html += '                       </div>';
            html += '                       <select class="js-company select2-offscreen" name="express_id" tabindex="-1">';
            html += '                           <option value="0">请选择一个物流公司</option>';
            for (i in data.express) {
                html += '                           <option value="' + data.express[i]['code'] + '">' + data.express[i]['name'] + '</option>';
            }
            html += '                       </select>';
            html += '                       <div class="help-desc">*发货后，10分钟内可修改一次物流信息</div>';
            html += '                   </div>';
            html += '               </div>';
            html += '               <div class="control-group">';
            html += '                   <label class="control-label">快递单号：</label>';
            html += '                   <div class="controls"><input type="text" class="input js-number" name="express_no" value="" /></div>';
            html += '               </div>';
            html += '           </div>';
            html += '       </form>';
            html += '       </div>'
            html += '       <div class="modal-footer"><a href="javascript:;" class="ui-btn ui-btn-primary js-save">确定</a></div>';
            html += '   </div>';
            $('body').append(html);
            $('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
            var html = '<div class="select2-drop select2-display-none select2-with-searchbox select2-drop-active" style="top: 0px; left: 0px; width: 200px; display: none;">';
            html += '       <div class="select2-search">';
            html += '           <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" />';
            html += '       </div>';
            html += '       <ul class="select2-results">';
            html += '           <li class="select2-results-dept-0 select2-result select2-result-selectable select2-highlighted" data-id="0"><div class="select2-result-label"><span class="select2-match"></span>请选择一个物流公司</div></li>';
            for (i in data.express) {
                html += '           <li class="select2-results-dept-' + data.express[i]['code'] + ' select2-result select2-result-selectable" data-id="' + data.express[i]['code'] + '"><div class="select2-result-label"><span class="select2-match"></span>' + data.express[i]['name'] + '</div></li>';
            }
            html += '       </ul>';
            html += '   </div>';
            $('body').append(html);
        })
    })

    $('.js-company').live('click', function(){
        if ($(this).hasClass('select2-dropdown-open')) {
            $(this).removeClass('select2-dropdown-open');
            $('.select2-display-none').hide();
        } else {
            $(this).addClass('select2-dropdown-open');
            //设置选中状态
            var express_id  = $(this).find('.select2-chosen').attr('data-id');
            $('.select2-results > .select2-results-dept-' + express_id).addClass('select2-highlighted');

            var top = $(this).offset().top + $(this).height() - 2;
            var left = $(this).offset().left;
            $('.select2-display-none').css({'top': top, 'left': left});
            $('.select2-display-none').show();
            $('.select2-input').focus();
        }
    })

    $("input[name='no_express']").live('change', function(){
        if($(this).val() == 1) {
            $('.js-express-info').hide();
        } else {
            $('.js-express-info').show();
        }
    })

    $('.select2-results > li').live('hover', function(){
        if (event.type == 'mouseover') {
            $(this).siblings('li').removeClass('select2-highlighted');
            $(this).addClass('select2-highlighted');
        } else {
            $(this).removeClass('select2-highlighted');
        }
    })

    $('.js-check-all').live('click', function(){
        if ($(this).is(':checked')) {
            $('.js-check-item').attr('checked', true);
        } else {
            $('.js-check-item').attr('checked', false);
        }
    })

    $('.js-check-item').live('click', function(){
        if ($(this).is(":checked") && $('.js-check-item').not(':checked').length == 0) {
            $('.js-check-all').attr('checked', true);
        } else {
            $('.js-check-all').attr('checked', false);
        }
    })

    $('body').click(function(e){
        var _con = $('.select2-container');   // 设置目标区域
        var _con2 = $('.select2-drop-active');
        if((!_con.is(e.target) && _con.has(e.target).length === 0) && (!_con2.is(e.target) && _con2.has(e.target).length === 0)){ // Mark 1
            $('.js-company').removeClass('select2-dropdown-open');
            $('.select2-display-none').hide();
        }
    })

    //选择快递公司
    $('.select2-results > li').live('click', function(){
        var express_company = $(this).children('.select2-result-label').text();
        var express_id = $(this).attr('data-id');
        if (express_id != 0 && $('.help-desc').next('.error-message').length > 0) {
            $('.help-desc').next('.error-message').remove();
            $('.select2-choice > .select2-chosen').closest('.control-group').removeClass('error');
        }
        $('.select2-choice > .select2-chosen').attr('data-id', express_id);
        $('.select2-choice > .select2-chosen').text(express_company);
        $('.js-company').removeClass('select2-dropdown-open');
        $('.select2-display-none').hide();
    })

    //上下键选择快递公司
    $(".select2-search input").live('keyup', function(e){
        if (event.keyCode == 38 && $('.js-company').hasClass('select2-dropdown-open')) { //向上
            if ($('.select2-highlighted').prev('.select2-result').length > 0) {
                var index = $('.select2-highlighted').index('.select2-result');
                $('.select2-result').eq(index).removeClass('select2-highlighted');
                $('.select2-result').eq(index).prev('.select2-result').addClass('select2-highlighted');
            }
            var scrollTop = $('.select2-results').scrollTop();
            var top = $('.select2-highlighted').position().top;
            if (top == -25) {
                $('.select2-results').scrollTop(scrollTop - 25);
            }
        }
        if (event.keyCode == 40 && $('.js-company').hasClass('select2-dropdown-open')) { //向下
            if ($('.select2-highlighted').next('.select2-result').length > 0) {
                var index = $('.select2-highlighted').index('.select2-result');
                $('.select2-result').eq(index).removeClass('select2-highlighted');
                $('.select2-result').eq(index).next('.select2-result').addClass('select2-highlighted');
            }
            var scrollTop = $('.select2-highlighted').position().top + $('.select2-results').scrollTop();
            if (scrollTop > 175) {
                $('.select2-results').scrollTop((scrollTop - 175));
            }
        }
    })

    $(window).keydown(function(event){
        if (event.keyCode == 13 && $('.select2-highlighted').length && $('.js-company').hasClass('select2-dropdown-open')) {
            var express_id = $('.select2-highlighted').attr('data-id');
            var express_company = $('.select2-highlighted > .select2-result-label').text();
            $('.select2-choice > .select2-chosen').attr('data-id', express_id);
            $('.select2-choice > .select2-chosen').text(express_company);
            $('.js-company').removeClass('select2-dropdown-open');
            $('.select2-display-none').hide();
        }
    })

    //创建包裹
    $('.js-save').live('click', function(){
        if ($('.js-check-item:checked').length == 0) {
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择商品</div>');
            t = setTimeout('msg_hide()', 3000);
            return false;
        }
        var flag = true;
        var products = [];
        var express_id = '';
        var express_company = '';
        var express_no = '';
        var order_id = $('.js-express-goods').attr('data-id');

        if ($("input:radio[name='no_express']:checked").val() == 0) { //需要物流
            $('.help-desc').next('.error-message').remove();
            if ($('.select2-choice > .select2-chosen').attr('data-id') == 0) {
                $('.select2-choice > .select2-chosen').closest('.control-group').addClass('error');
                $('.help-desc').after('<p class="help-block error-message">请选择一个物流公司</p>');
                flag = false;
            } else {
                $('.select2-choice > .select2-chosen').closest('.control-group').removeClass('error');
                express_id = $('.select2-choice > .select2-chosen').attr('data-id');
                express_company = $('.select2-choice > .select2-chosen').text();
            }
            $('.js-number').next('.error-message').remove();
            if ($('.js-number').val() == '') {
                $('.js-number').closest('.control-group').addClass('error');
                $('.js-number').after('<p class="help-block error-message">请填写快递单号</p>');
                flag = false;
            } else {
                $('.js-number').closest('.control-group').removeClass('error');
                express_no = $('.js-number').val();
            }
        }
        if (flag) {
            $('.js-check-item:checked').each(function(i){
                products[i] = $(this).val();
            })
            $.post(create_package_url, {'order_id': order_id, 'express_id': express_id, 'express_company': express_company, 'express_no': express_no, 'products': products.toString()}, function(data) {
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
                        $('.modal-backdrop,.modal').remove();
                    });
                    if (page_content == 'detail_content') { //订单详细
                        load_page('.app__content', load_url, {page: page_content, 'order_id': order_id}, '', function(){});
                    } else { //订单列表
                        status = $('.ui-nav > ul > .active > a').attr('data');
                        $('.ui-nav > ul > li > a').trigger('click');
                    }
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
        }
    })

    //快递单号
    $('.js-number').live('blur', function(){
        if ($(this).val() != '') {
            $(this).next('.error-message').remove();
            $(this).closest('.control-group').removeClass('error');
        }
    })

    $('.alert-error > .close').live('click', function(){
        $('.notifications').html('');
    })


    //交易完成
    $('.js-complate-order').live('click', function(){
        var order_id = $(this).data('id');
        status = $('.ui-nav > ul > .active > a').attr('data');
        $.post(complate_status_url, {'order_id': order_id}, function(data){
            if (!data.err_code) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                page = $(this).attr('data-page-num');
                status = $('.ui-nav > ul > .active > a').attr('data');
                $('.ui-nav > ul > .active > a').trigger('click');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
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

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}

function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}

function winresize() {
    if ($('.js-company').length) {
        $('.select2-display-none').css({
            'top': $('.js-company').offset().top + $('.js-company').height() - 2,
            'left': $('.js-company').offset().left
        });
    }
}