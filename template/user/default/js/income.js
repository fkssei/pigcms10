/**
 * Created by pigcms_21 on 2015/2/4.
 */
var clock = '';
var order_no = ''; //订单号
var start_time = ''; //起始时间
var stop_time  = ''; //结束时间
var type = ''; //类型
var status = ''; //状态
var t = '';
$(function() {
    if (window.location.hash != '') {
        var patt1 =new RegExp("/")
        if (patt1.test(window.location.hash)) {
            var hash_arr = window.location.hash.split('/');
            var action = hash_arr[0].replace('#', '');
            var page_content = action + '_content';
            var param = hash_arr[1];
        } else {
            var action = window.location.hash.replace('#', '');
            var page_content = action + '_content';
            var param = '';
        }
        load_page('.app__content',load_url,{page: page_content, 'param': param},'', function(){
            $('#js-nav-settlement-' + action).siblings('li').removeClass('active');
            $('#js-nav-settlement-' + action).addClass('active');
        });
    } else {
        load_page('.app__content',load_url,{page:'income_content'},'');
    }

    //选项卡切换
    $('.ui-nav > ul > li > a').live('click', function(){
        var page_content = $(this).attr('href').replace('#', '') + '_content';
        var index = $(this).index('.ui-nav > ul > li > a');
        load_page('.app__content',load_url,{page: page_content},'', function(){
            $('.ui-nav > ul > li').eq(index).siblings('li').removeClass('active');
            $('.ui-nav > ul > li').eq(index).addClass('active');
        });
    })

    //分页
    $('.pagenavi > a').live('click', function(){
        var p = $(this).data('page-num');
        var patt1 =new RegExp("/")
        if (patt1.test(window.location.hash)) {
            var hash_arr = window.location.hash.split('/');
            var action = hash_arr[0].replace('#', '');
            var page_content = action + '_content';
        } else {
            var action = window.location.hash.replace('#', '');
            var page_content = action + '_content';
        }
        var index = $('.ui-nav > ul > .active').index('.ui-nav > ul > li');
        load_page('.app__content',load_url,{'page': page_content, 'p': p, 'order_no': order_no, 'start_time': start_time, 'stop_time': stop_time, 'type': type},'', function(){
            $('.ui-nav > ul > li').eq(index).siblings('li').removeClass('active');
            $('.ui-nav > ul > li').eq(index).addClass('active');

            _save_search_condition();
        });
    })

    //开始时间
    $('#js-stime').live('focus', function() {
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js-etime').val() != '') {
                    $(this).datepicker('option', 'maxDate', new Date($('#js-etime').val()));
                }
            },
            onSelect: function() {
                if ($('#js-stime').val() != '') {
                    $('#js-etime').datepicker('option', 'minDate', new Date($('#js-stime').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($(this).datepicker('getDate'), $('#js-etime').datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js-etime').datepicker('getDate'));
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
        $('#js-stime').datetimepicker(options);
    })


    //结束时间
    $('#js-etime').live('focus', function(){
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js-stime').val() != '') {
                    $(this).datepicker('option', 'minDate', new Date($('#js-stime').val()));
                }
            },
            onSelect: function() {
                if ($('#js-etime').val() != '') {
                    $('#js-stime').datepicker('option', 'maxDate', new Date($('#js-etime').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($('#js-stime').datepicker('getDate'), $(this).datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js-stime').datepicker('getDate'));
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
        $('#js-etime').datetimepicker(options);
    })

    //最近7天或30天
    $('.date-quick-pick').live('click', function(){
        $(this).addClass('current');
        $(this).siblings('.date-quick-pick').removeClass('current');

        var tmp_days = $(this).attr('data-days');
        $('.js-stime').val(changeDate(tmp_days).begin);
        $('.js-etime').val(changeDate(tmp_days).end);
    })

    //查询
    $('.js-filter').live('click', function(){
        if ($("input[name='order_no']").length > 0) {
            order_no = $("input[name='order_no']").val();
        }
        start_time = $("input[name='stime']").val();
        stop_time = $("input[name='etime']").val();
        if ($("select[name='type']").length > 0) {
            type = $("select[name='type']").val();
        }
        if ($("select[name='status']").length > 0) {
            status = $("select[name='status']").val();
        }
        var patt1 =new RegExp("/")
        if (patt1.test(window.location.hash)) {
            var hash_arr = window.location.hash.split('/');
            var action = hash_arr[0].replace('#', '');
            var page_content = action + '_content';
        } else {
            var action = window.location.hash.replace('#', '');
            var page_content = action + '_content';
        }
        load_page('.app__content',load_url,{'page': page_content, 'order_no': order_no, 'start_time': start_time, 'stop_time': stop_time, 'type': type, 'status': status},'', function(){
            $('#js-nav-settlement-' + action).siblings('li').removeClass('active');
            $('#js-nav-settlement-' + action).addClass('active');

            _save_search_condition()
        });
    })

    //提现
    $('.js-goto').live('click', function(){
        window.location.hash = $(this).attr('href');
        var page_content = $(this).attr('href').replace('#', '') + '_content'; //提现账号设置
        load_page('.app__content',load_url,{'page': page_content},'', function(){});
    })

    //提现方式切换
    $('.type-item').live('click', function(){
        var msg = [];
        msg[0] = '1. 请仔细填写账户信息，如果由于您填写错误导致资金流失，平台概不负责；<br>2. 只支持提现到银行借记卡，<span class="text-strong">不支持信用卡和存折</span>。提现审核周期为3个工作日；';
        msg[1] = '1. 请仔细填写账户信息，如果由于您填写错误导致资金流失，平台概不负责；<br>2. 只支持提现到的公司银行卡账户，<span class="text-strong">不支持信用卡和存折</span>，提现审核周期为1个工作日；<br>3. 准确填写银行开户许可证上的公司名称，否则无法提现；'
        var label = [];
        label[0] = '<em class="required">*</em>开卡人姓名：';
        label[1] = '<em class="required">*</em>公司名称：';
        var index = $(this).index('.type-item');
        $('.js-type > .alert').html(msg[index]);
        $('.js-type > .control-group:eq(3) > .control-label').html(label[index]);
    })

    //卡号每4位分隔显示
    $('.js_bank_card').live('keyup', function(){
        var value = $(this).val();
        var tmp_value = '';
        if (value.length > 4 && value[4] != '') {
            for (i in value) {
                i++;
                tmp_value += value[i-1];
                if (i > 0 && i % 4 == 0) {
                    tmp_value += ' ';
                }
            }
            value = tmp_value;
        }
        $(this).next('.js-account-pretty').text(value);
        $(this).next('.js-account-pretty').show();
    })

    $('.js_bank_card').live('blur', function(){
        $(this).next('.js-account-pretty').hide();
    })

    $('.js_bank_card').live('focus', function(){
        if ($(this).next('.js-account-pretty').text() != '') {
            $(this).next('.js-account-pretty').show();
        }
    })

    $("input[name='opening_bank']").live('blur', function(){
        if ($("input[name='opening_bank']").val() != '') {
            $("input[name='opening_bank']").closest('.control-group').removeClass('error');
            $("input[name='opening_bank']").next('.error-message').remove();
        }
    })

    $("input[name='bank_card']").live('blur', function(){
        if (isNaN($("input[name='bank_card']").val())) {
            $('.widget-account-pretty').closest('.control-group').removeClass('error');
            $('.widget-account-pretty').next('.error-message').remove();

            $('.widget-account-pretty').closest('.control-group').addClass('error');
            $('.widget-account-pretty').after('<p class="help-block error-message">银行卡只能为数字</p>');
            return false;
        }
        if ($("input[name='bank_card']").val() != '') {
            $('.widget-account-pretty').closest('.control-group').removeClass('error');
            $('.widget-account-pretty').next('.error-message').remove();
        }
    })

    $("input[name='bank_card_user']").live('blur', function(){
        if ($("input[name='bank_card_user']").val() != '') {
            $("input[name='bank_card_user']").closest('.control-group').removeClass('error');
            $("input[name='bank_card_user']").next('.error-message').remove();
        }
    })

    $("input[name='verify_code']").live('blur', function(){
        if ($("input[name='verify_code']").val() != '' && !isNaN($("input[name='verify_code']").val())) {
            $("input[name='verify_code']").closest('.control-group').removeClass('error');
            $('.c-gray').next('.error-message').remove();
        }
    })

    //获取短信验证码
    $('.js-fetch-sms').live('click', function() {
        var tel = $('.js-mobile').val();
        $(this).addClass('btn-disabled').attr('disabled', true);
        $('.js-fetch-sms').parents('.control-group').removeClass('error');
        $('.js-fetch-sms').next('.error-message').remove();
        $.get('user.php?c=store&a=create&type=captcha_generate', {'tel' : tel},function(data){
            if (!data) {
                $('.js-fetch-sms').parents('.control-group').addClass('error');
                $('.js-fetch-sms').after('<p class="help-block error-message">验证码发送失败，请点击“获取”重新发送</p>');
            }
        })
        var value = '<span class="time">60</span>秒后重新获取';
        $(this).html(value);
        var clock = setInterval('timeFun()', 1000);
    })

    $('.notifications .close').live('click', function(){
        $('body > .notify-backdrop').remove();
        $('.notifications').html('');
    })

    $('.js-submit-btn').live('click', function(){
        var obj = this;
        var withdrawal_type = $(".type-item > input[name='type']:checked").val();
        var bank_id = $("select[name='bank']").val();
        var opening_bank = $("input[name='opening_bank']").val();
        var bank_card = $("input[name='bank_card']").val();
        var bank_card_user = $("input[name='bank_card_user']").val();
        var verify_code = $("input[name='verify_code']").val();
        var tel = $('.js-mobile').val();
        var flag = true;
        $("input[name='opening_bank']").closest('.control-group').removeClass('error');
        $("input[name='opening_bank']").next('.error-message').remove();
        if (opening_bank == '') {
            flag = false;
            $("input[name='opening_bank']").closest('.control-group').addClass('error');
            $("input[name='opening_bank']").after('<p class="help-block error-message">不能为空</p>');
        }
        $('.widget-account-pretty').closest('.control-group').removeClass('error');
        $('.widget-account-pretty').next('.error-message').remove();
        if (bank_card == '') {
            flag = false;
            $('.widget-account-pretty').closest('.control-group').addClass('error');
            $('.widget-account-pretty').after('<p class="help-block error-message">不能为空</p>');
        }
        if (isNaN($("input[name='bank_card']").val())) {
            flag = false;
            $('.widget-account-pretty').closest('.control-group').addClass('error');
            $('.widget-account-pretty').after('<p class="help-block error-message">银行卡只能为数字</p>');
        }

        $("input[name='bank_card_user']").closest('.control-group').removeClass('error');
        $("input[name='bank_card_user']").next('.error-message').remove();
        if (bank_card_user == '') {
            flag = false;
            $("input[name='bank_card_user']").closest('.control-group').addClass('error');
            $("input[name='bank_card_user']").after('<p class="help-block error-message">不能为空</p>');
        }

        $("input[name='verify_code']").closest('.control-group').removeClass('error');
        $('.c-gray').next('.error-message').remove();
        if ($("input[name='verify_code']").length > 0 && verify_code == '') {
            flag = false;
            $("input[name='verify_code']").closest('.control-group').addClass('error');
            $('.c-gray').after('<p class="help-block error-message">短信验证码是6位数字</p>');
        }
        if (flag) {
            $.post(settingwithdrawal_url, {'withdrawal_type': withdrawal_type, 'bank_id': bank_id, 'opening_bank': opening_bank, 'bank_card': bank_card, 'bank_card_user': bank_card_user, 'tel': tel, 'verify_code': verify_code}, function(data) {
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    t = setTimeout('msg_hide()', 3000);
                    if (!$(obj).hasClass('account')) {
                        window.location.hash = '#applywithdrawal';
                        var page_content = 'applywithdrawal_content'; //申请提现
                        load_page('.app__content', load_url, {'page': page_content}, '', function () {});
                    } else {
                        window.location.hash = '';
                        var page_content = 'income_content'; //我的收入
                        load_page('.app__content', load_url, {'page': page_content}, '', function () {});
                    }
                } else if (data.err_code == 1000) { //验证码失败
                    $('body').append('<div class="notify-backdrop fade in"></div>');
                    $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>' + data.err_msg + '</div>');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                    t = setTimeout('msg_hide()', 3000);
                }
            })
        }
    })

    $('.js-money').live('blur', function(){
        var money = $(this).val();
        var balance = $(this).data('balance');
        $(this).closest('.control-group').removeClass('error');
        $(this).parent('.controls').children('.error-message').remove();
        if (money == '') {
            $(this).closest('.control-group').addClass('error');
            $(this).parent('.controls').append('<p class="help-block error-message">提现金额不能为空</p>');
        } else if (isNaN(money)) {
            $(this).closest('.control-group').addClass('error');
            $(this).parent('.controls').append('<p class="help-block error-message">提现金额必须为数字</p>');
        } else if (money < 1) {
            $(this).closest('.control-group').addClass('error');
            $(this).parent('.controls').append('<p class="help-block error-message">提现金额不能小于1元</p>');
        } else if (parseFloat(balance) < parseFloat(money)) {
            $('.js-money').closest('.control-group').addClass('error');
            $('.js-money').parent('.controls').append('<p class="help-block error-message">帐户余额不足</p>');
        }
    })
    //提交提现申请
    $('.js-submit').live('click', function(){
        var flag = true;
        var money = $('.js-money').val();
        var balance = $('.js-money').data('balance');
        if ($('.js-bank-list-region > ul > .bank').length == 0) {
            $('body').append('<div class="notify-backdrop fade in"></div>');
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请先添加一张银行卡</div>');
            return false;
        }
        $('.js-money').closest('.control-group').removeClass('error');
        $('.js-money').parent('.controls').children('.error-message').remove();
        if (money == '') {
            flag = false;
            $('.js-money').closest('.control-group').addClass('error');
            $('.js-money').parent('.controls').append('<p class="help-block error-message">提现金额不能为空</p>');
        } else if (isNaN(money)) {
            flag = false;
            $('.js-money').closest('.control-group').addClass('error');
            $('.js-money').parent('.controls').append('<p class="help-block error-message">提现金额必须为数字</p>');
        } else if (money < 1) {
            flag = false;
            $('.js-money').closest('.control-group').addClass('error');
            $('.js-money').parent('.controls').append('<p class="help-block error-message">提现金额不能小于1元</p>');
        } else if (parseFloat(balance) < parseFloat(money)) {
            flag = false;
            $('.js-money').closest('.control-group').addClass('error');
            $('.js-money').parent('.controls').append('<p class="help-block error-message">帐户余额不足</p>');
        }

        if (flag) {
            var bank_id = $('.js-bank-list-region > ul > .bank').data('id');
            var opening_bank = $('.js-bank-list-region > ul > .bank').data('opening-bank');
            var bank_card_user = $('.js-bank-list-region > ul > .bank').data('user');
            var bank_card = $('.js-bank-list-region > ul > .bank').data('card');
            var withdrawal_type = $('.js-bank-list-region > ul > .bank').data('type');
            $.post(applywithdrawal_url, {'bank_id': bank_id, 'opening_bank': opening_bank, 'bank_card_user': bank_card_user, 'bank_card': bank_card, 'withdrawal_type': withdrawal_type, 'amount': money}, function(data){
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    $('#js-nav-settlement-withdraw > a').trigger('click');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
        }
    })

    //修改提现账户
    $('.dropdown-menu > li > .js-edit').live('click', function(){
        var hash_str = $(this).attr('href');
        var action = hash_str.replace('#', '');
        var page_content = action + '_content';
        load_page('.app__content',load_url,{page:page_content},'');
    })

    //删除提现账户
    $('.dropdown-menu > li > .js-delete').live('click', function(){
        $.post(delwithdrawal_url, '', function(data){
            if (!data.err_code) {
                $('.js-bank-list-region').html('<ul></ul>');
                $('.js-bank-list-region').after('<div class="controls" style="padding-top: 5px;"><a href="#settingWithdrawal" class="js-add-bankcard">添加银行卡</a></div>');
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })

    })

    //添加银行卡（提现账户）
    $('.js-add-bankcard').live('click', function(){
        var page_content = 'settingwithdrawal_content';
        load_page('.app__content',load_url,{'page': page_content},'', function(){});
    })

    //首页-提现账号
    $('.js-setup-account').live('click', function(){
        var page_content = 'editwithdrawal_content';
        window.location.hash = '#editwithdrawal/account';
        load_page('.app__content',load_url,{page:page_content, 'param': 'account'},'');
    })

    $('.caret').live('click', function(){
        var bank = $(this).data('bank');
        var opening_bank = $(this).data('opening-bank');
        var bank_account = $(this).data('bank-account');
        var bank_card = $(this).data('bank-card');
        $('body > .popover').remove();
        $('body').append('<div class="popover center-bottom bottom" style="display: block; top: ' + ($(this).offset().top) + 'px; left: ' + ($(this).offset().left - 129) + 'px;"><div class="arrow"></div><div class="popover-inner popover-delete"><div class="popover-content"><div class="js-content"><div><p>收款银行：' + bank + '</p><p>开户银行：' + opening_bank + '</p><p>银行帐户：' + bank_card + '</p><p>帐户名称：' + bank_account + '</p></div></div></div></div></div>');
    })

    $('body').click(function(e){
        var _con = $('.popover');   // 设置目标区域
        if((!_con.is(e.target) && _con.has(e.target).length === 0)){ // Mark 1
            $('.popover').remove();
        }
    })

    $('.balance-content > .inoutdetail').live('click', function(){
        var action = $(this).attr('href').replace('#', '');
        var page_content = action + '_content';
        load_page('.app__content',load_url,{page:page_content},'', function(){
            $('#js-nav-settlement-' + action).siblings('li').removeClass('active');
            $('#js-nav-settlement-' + action).addClass('active');
        });
    })

    $('.trade-list-nav > ul > li').live('click', function(){
        status = $(this).data('id');
        var patt1 =new RegExp("/")
        if (patt1.test(window.location.hash)) {
            var hash_arr = window.location.hash.split('/');
            var action = hash_arr[0].replace('#', '');
            var page_content = action + '_content';
        } else {
            var action = window.location.hash.replace('#', '');
            var page_content = action + '_content';
        }
        load_page('.app__content',load_url,{page: page_content, 'status': status},'', function(){
            $('.status-' + status).siblings('li').removeClass('active');
            $('.status-' + status).addClass('active');
        });
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

//保存查询条件
function _save_search_condition()
{
    if (order_no != '') {
        $("input[name='order_no']").val(order_no);
    }
    if (start_time != '') {
        $("input[name='stime']").val(start_time);
    }
    if (stop_time != '') {
        $("input[name='etime']").val(stop_time);
    }
    if (type > 0) {
        $("select[name='type']").find("[value='" + type + "']").attr('selected', true);
    }

    if (status > 0) {
        $("select[name='status']").find("[value='" + status + "']").attr('selected', true);
    }
}

function timeFun() {
    var time = $('.time').text();
    time = parseInt(time);
    time = time - 1;
    $('.time').text(time);
    if (time <= 0) {
        clearInterval(clock);
        $('.js-fetch-sms').removeClass('btn-disabled').attr('disabled', false);
        $('.js-fetch-sms').html('重新获取');
    }
}

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}