var t = '';
$(function(){
	load_page('.app__content',load_url,{page:'setting_content'},'');


    //启用分销商审核
    $('.approve > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(open_drp_approve_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //关闭分销商审核
    $('.approve > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_drp_approve_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //启用分销引导
    $('.guidance > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(open_drp_guidance_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //关闭分销引导
    $('.guidance > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_drp_guidance_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //启用分销限制
    $('.limit > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(open_drp_limit_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //关闭分销限制
    $('.limit > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_drp_limit_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //保存
    $('.save-btn').live('click', function(e) {
        $(this).next('.error').remove();
        var drp_limit_buy = $.trim($('.drp-limit-buy').val());
        var drp_limit_share = $.trim($('.drp-limit-share').val());
        var drp_limit_condition = $('.drp-limit-condition:checked').val();

        if (($('.drp-limit-buy').val() == '' && $('.drp-limit-share').val() == '') || ($('.drp-limit-buy').val() == 0 && $('.drp-limit-share').val() == 0)) {
            $(this).after('<div class="error" style="color:#b94a48;margin-left: 30px">必须填写一个条件</div>');
            return false;
        }
        if (isNaN(drp_limit_buy) || parseFloat(drp_limit_buy) < 0) {
            $(this).after('<div class="error" style="color:#b94a48;margin-left: 30px">消费金额填写有误</div>');
            return false;
        }
        if (isNaN(drp_limit_share) || parseFloat(drp_limit_share) < 0) {
            $(this).after('<div class="error" style="color:#b94a48;margin-left: 30px">分享次数填写有误</div>');
            return false;
        }

        $.post(save_drp_limit_url, {'drp_limit_buy': drp_limit_buy, 'drp_limit_share': drp_limit_share, 'drp_limit_condition': drp_limit_condition}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    })
    $('.drp-limit-buy').live('blur', function(e) {
        var drp_limit_buy = $.trim($(this).val());
        if (isNaN(drp_limit_buy) || parseFloat(drp_limit_buy) < 0) {
            $('.save-btn').after('<div class="error" style="color:#b94a48;margin-left: 30px">消费金额填写有误</div>');
            return false;
        }
        if ($(this).val() != '' && !isNaN($(this).val())) {
            $(this).val(parseFloat(drp_limit_buy).toFixed(2));
        }
    })
    $('.drp-limit-share').live('blur', function(e) {
        var drp_limit_share = $.trim($(this).val());
        if (isNaN(drp_limit_share) || parseFloat(drp_limit_share) < 0) {
            $('.save-btn').after('<div class="error" style="color:#b94a48;margin-left: 30px">分享次数填写有误</div>');
            return false;
        }
    })
    $('.drp-limit-buy').live('focus', function(e) {
        $('.save-btn').next('.error').remove();
    })
    $('.drp-limit-share').live('focus', function(e) {
        $('.save-btn').next('.error').remove();
    })
});

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}