/**
 * Created by pigcms_21 on 2015/2/3.
 */
var t1 = '';
$(function() {
    load_page('.app__content',load_url,{page:'pay_agent_content'},'');

    //添加代付发起人求助
    $('.js-add-buyer').live('click', function(){
        $('body').children('.modal-backdrop').remove();
        $(".js-modal").remove();
        var html = '<div class="js-modal modal fade hide in" style="margin-top: -500px; display: none;" aria-hidden="false"><form class="js-form form-horizontal" novalidate="novalidate" method="post" action="' + pay_agent_content_add_url + '"><div class="modal-header"> <a class="close" data-dismiss="modal">×</a> <h3 class="title"> 添加 </h3> </div> <div class="modal-body"><div class="control-group"><label class="control-label">发起人的求助：</label><div class="controls"><textarea name="content" cols="20" rows="2" class="span6 content" placeholder="最多可支持200个字" maxlength="200"></textarea></div></div></div> <div class="modal-footer"> <div class="pull-left" style="margin-left: 130px;"><button type="button" class="ui-btn ui-btn-primary js-save">保存</button></div></div></form></div>';
        $('body').append('<div class="modal-backdrop fade in"></div>');
        $('.js-app-list').after(html);
        $('.js-modal').show();
        $('.js-modal').animate({'margin-top': '0px'}, "slow");
    })

    //修改代付发起人求助
    $('.js-edit-buyer').live('click', function(){
        var id = $(this).attr('data');
        var content = $('.content-' + id).html();
        $('body').children('.modal-backdrop').remove();
        $(".js-modal").remove();
        var html = '<div class="js-modal modal fade hide in" style="margin-top: -500px; display: none;" aria-hidden="false"><form class="js-form form-horizontal" novalidate="novalidate" method="post" action="' + pay_agent_content_edit_url + '"><div class="modal-header"> <a class="close" data-dismiss="modal">×</a><h3 class="title"> 编辑 </h3></div><div class="modal-body"><div class="control-group"><label class="control-label">发起人的求助：</label><div class="controls"><textarea name="content" cols="20" rows="2" class="span6 content" placeholder="最多可支持200个字" maxlength="200">' + content + '</textarea></div></div></div><div class="modal-footer"><div class="pull-left" style="margin-left: 130px;"><button type="button" class="ui-btn ui-btn-primary js-save">保存</button><input type="hidden" name="agent_id" class="agent_id" value="' + id + '" /></div></div></form></div>';
        $('body').append('<div class="modal-backdrop fade in"></div>');
        $('.js-app-list').after(html);
        $('.js-modal').show();
        $('.js-modal').animate({'margin-top': '0px'}, "slow");
    })

    //删除代付发起人求助/代付人留言
    $('.js-delete').live('click', function(){
        var id = $(this).attr('data');
        $('body').children('.page-popover-del').remove();
        var html = '<div class="popover bottom page-popover-del" style="display: block; top: ' + ($(this).offset().top + 10) + 'px; left: ' + $(this).offset().left + 'px;"><div class="arrow"></div><div class="popover-inner popover-confirm"> <div class="popover-content text-center"><div class="form-inline clearfix"><span class="js-confirm-text data-inline pull-left">确定删除？</span><span class="js-confirm-btn-action pull-right"><button type="button" class="btn btn-primary js-btn-confirm" data="' + id + '" data-loading-text="确定">确定</button><button type="reset" class="btn js-btn-cancel">取消</button></span></div></div></div></div>';
        $('body').append(html);
    })

    //取消删除求助
    $('.js-btn-cancel').live('click', function(){
        $(this).closest('.page-popover-del').remove();
    })

    //确定删除
    $('.js-btn-confirm').live('click', function(){
        var id = $(this).attr('data');
        $.get(pay_agent_content_del_url, {'agent_id': id}, function(data){
            if (!data.err_code) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                $('.page-popover-del').remove();
                $('.content-' + id).parent('tr').remove();
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t1 = setTimeout('msg_hide()', 3000);
        });
    })

    //添加代付人留言
    $('.js-add-peerpay').live('click', function(){
        $('body').children('.modal-backdrop').remove();
        $(".js-modal").remove();
        var html = '<div class="js-modal modal fade hide in" style="margin-top: -700px; display: none;"><form class="js-form form-horizontal" novalidate="novalidate"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><h3 class="title">添加</h3></div><div class="modal-body"><div class="control-group"><label class="control-label">代付人的昵称：</label><div class="controls"><input type="text" name="nickname" class="nickname" value="" maxlength="30"></div></div><div class="control-group"><label class="control-label">代付人的留言：</label><div class="controls"><textarea name="content" cols="20" rows="2" class="span6 content" placeholder="最多可支持200个字" maxlength="200"></textarea></div></div></div><div class="modal-footer"><div class="pull-left" style="margin-left: 130px;"><button type="button" class="ui-btn ui-btn-primary js-save">保存</button></div></div></form></div>';
        $('body').append('<div class="modal-backdrop fade in"></div>');
        $('.js-app-list').after(html);
        $('.js-modal').show();
        $('.js-modal').animate({'margin-top': '0px'}, "slow");
    })

    //修改代付人留言
    $('.js-edit-payer').live('click', function(){
        var id = $(this).attr('data');
        var nickname = $('.nickname-' + id).html();
        var content = $('.content-' + id).html();
        $('body').children('.modal-backdrop').remove();
        $(".js-modal").remove();
        var html = '<div class="js-modal modal fade hide in" style="margin-top: -700px; display: none;"><form class="js-form form-horizontal" novalidate="novalidate"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><h3 class="title">编辑</h3></div><div class="modal-body"><div class="control-group"><label class="control-label">代付人的昵称：</label><div class="controls"><input type="text" name="nickname" class="nickname" value="' + nickname + '" maxlength="30"/></div></div><div class="control-group"><label class="control-label">代付人的留言：</label><div class="controls"><textarea name="content" cols="20" rows="2" class="span6 content" placeholder="最多可支持200个字" maxlength="200">' + content + '</textarea></div></div></div><div class="modal-footer"><div class="pull-left" style="margin-left: 130px;"><button type="button" class="ui-btn ui-btn-primary js-save">保存</button><input type="hidden" name="agent_id" class="agent_id" value="' + id + '" /></div></div></form></div>';
        $('body').append('<div class="modal-backdrop fade in"></div>');
        $('.js-app-list').after(html);
        $('.js-modal').show();
        $('.js-modal').animate({'margin-top': '0px'}, "slow");
    })


    $('.close').live('click', function(){
        $('body').children('.modal-backdrop').remove();
        $(".js-modal").animate({'margin-top': '-' + parseInt($(this).closest('.js-modal').height() + $(this).closest('.js-modal').offset().top + 10) + 'px'}, "slow");
    })

    $('.js-switch').live('click', function(){
        var obj = this;
        if ($(this).hasClass('ui-switch-off')) {
            var status = 1;
            var oldClassName = 'ui-switch-off';
            var className = 'ui-switch-on';
        } else {
            var status = 0;
            var oldClassName = 'ui-switch-on';
            var className = 'ui-switch-off';
        }
        $.post(status_url, {'status': status}, function(data){
            if(!data.err_code) {
                $(obj).removeClass(oldClassName);
                $(obj).addClass(className);
            }
        })
    })

    $('.js-tab-peerpay').live('click', function(){
        if (!$(this).hasClass('active')) {
            $(this).siblings('li').removeClass('active');
            $(this).addClass('active');
            $('.ui-btn-success').removeClass('js-add-buyer').addClass('js-add-peerpay');
            $('.js-app-list').load(pay_agent_content_payer_url);
        }
    })
    $('.js-tab-peerpay').live('click', function(){
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $('.ui-btn-success').removeClass('js-add-buyer').addClass('js-add-peerpay');
        $('.js-app-list').load(pay_agent_content_payer_url);
    })
    $('.js-tab-buyer').live('click', function(){
        if (!$(this).hasClass('active')) {
            $(this).siblings('li').removeClass('active');
            $(this).addClass('active');
            $('.ui-btn-success').removeClass('js-add-peerpay').addClass('js-add-buyer')
            $('.js-app-list').load(pay_agent_content_buyer_url);
        }
    });

    //数据保存
    $('.js-save').live('click', function(){
        if ($('.nickname').length > 0) {
            if ($('.nickname').val() == '') {
                $('.nickname').addClass('valid-error');
                $('.nickname').next('.valid-error').remove();
                $('.nickname').after('<p for="nickname" class="valid-error">昵称不能为空</p>');
            } else {
                $('.nickname').removeClass('valid-error');
                $('.nickname').next('.valid-error').remove();
            }
            var type = 1; //代付人留言
            var nickname = $.trim($('.nickname').val());
        } else {
            var type = 0; //发起人求助
            var nickname = '';
        }
        var content = $.trim($('.content').val());
        if (content == '') {
            $('.content').addClass('valid-error');
            $('.content').next('.valid-error').remove();
            $('.content').after('<p for="content" class="valid-error">内容不能为空</p>');
        } else {
            $('.content').removeClass('valid-error');
            $('.content').next('.valid-error').remove();
        }
        if ($('.valid-error').length > 0) {
            return false;
        }
        var url = pay_agent_content_add_url; //添加
        if ($(this).next('.agent_id').length == 1) {
            var url = pay_agent_content_edit_url + '&agent_id=' + $(this).next('.agent_id').val(); //修改
        }
        $.post(url, {'type': type, 'nickname': nickname, 'content': content}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                if (!type) { //发起人求助
                    load_page('.app__content',load_url,{page:'pay_agent_content'},'');
                } else { //代付人留言
                    $('.js-tab-peerpay').trigger('click');
                }
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t1 = setTimeout('msg_hide()', 3000);
            $('body').children('.modal-backdrop').remove();
            $(".js-modal").animate({'margin-top': '-' + parseInt($('.js-modal').height() + $('.js-modal').offset().top + 10) + 'px'}, "slow");
        })
    })

    //输入昵称时清空错误提示
    $('.nickname').live('keyup', function(){
        $(this).removeClass('valid-error');
        $(this).next('.valid-error').remove();
    })
    //输入内容时清空错误提示
    $('.content').live('keyup', function(){
        $(this).removeClass('valid-error');
        $(this).next('.valid-error').remove();
    })

    //点击“删除窗口”之外区域删除“删除窗口”
    $('body').click(function(e){
        var _con = $('.page-popover-del');   // 设置目标区域
        if(!_con.is(e.target) && _con.has(e.target).length === 0){ // Mark 1
            $('.page-popover-del').remove();
        }
    })
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t1);
}