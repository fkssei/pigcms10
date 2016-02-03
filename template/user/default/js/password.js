$(function(){
	load_page('#content',load_url,{page:'password_content'},'');

    $('.js-btn-submit').live('click', function() {
        var old_password = $("input[name='old_password']").val();
        var new_password = $("input[name='new_password']").val();
        var renew_password = $("input[name='renew_password']").val();

        //原密码
        if (old_password == '') {
            $("input[name='old_password']").closest('.control-group').addClass('error');
            $("input[name='old_password']").next('.error-message').remove();
            $("input[name='old_password']").after('<p class="help-block error-message">密码不能为空</p>');
        } else if (old_password.length < 6) {
            $("input[name='old_password']").closest('.control-group').addClass('error');
            $("input[name='old_password']").next('.error-message').remove();
            $("input[name='old_password']").after('<p class="help-block error-message">密码最少 6 位</p>');
        } else {
            $.post(check_password_url, {'password': old_password}, function(data){
                if (data.err_code) {
                    $("input[name='old_password']").closest('.control-group').addClass('error');
                    $("input[name='old_password']").next('.error-message').remove();
                    $("input[name='old_password']").after('<p class="help-block error-message">' + data.err_msg + '</p>');
                }
            })
            $("input[name='old_password']").closest('.control-group').removeClass('error');
            $("input[name='old_password']").next('.error-message').remove();
        }
        //新密码
        if (new_password == '') {
            $("input[name='new_password']").closest('.control-group').addClass('error');
            $("input[name='new_password']").next('.error-message').remove();
            $("input[name='new_password']").after('<p class="help-block error-message">密码不能为空</p>');
        } else if (new_password.length < 6) {
            $("input[name='new_password']").closest('.control-group').addClass('error');
            $("input[name='new_password']").next('.error-message').remove();
            $("input[name='new_password']").after('<p class="help-block error-message">密码最少 6 位</p>');
        } else {
            $("input[name='new_password']").closest('.control-group').removeClass('error');
            $("input[name='new_password']").next('.error-message').remove();
        }
        //重复新密码
        if (new_password != '' && renew_password != new_password) {
            $("input[name='renew_password']").closest('.control-group').addClass('error');
            $("input[name='renew_password']").next('.error-message').remove();
            $("input[name='renew_password']").after('<p class="help-block error-message">重复的密码和第一次不相同</p>');
        } else {
            $("input[name='renew_password']").closest('.control-group').removeClass('error');
            $("input[name='renew_password']").next('.error-message').remove();
        }

        if ($('.error-message').length == 0) {
            $.post(password_url, {'new_password': new_password, 'old_password': old_password}, function(data){
                if (!data.err_code) {
                    $('#content').html('<div><div class="center-area work-done"><div class="primary-notice">密码修改成功</div><div class="control-action"><button class="btn btn-large js-btn-reload">重新登录</button></div></div></div>');
                } else {
                    $('body').append('<div class="notify-backdrop fade in"></div>');
                    $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>' + data.err_msg + '</div>');
                }
            })
        }
    })

    //窗口关闭
    $('.close').live('click', function(){
        $('body').children('.notify-backdrop').remove();
        $('.notifications').html('');
    })

    //刷新
    $('.js-btn-reload').live('click', function(){
        window.location.reload();
    })
});