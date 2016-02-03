/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
$(function(){
    load_page('.app__content', load_url, {page:'index_content'}, '', function(){
        $.post(service_url, {'type': 'check'}, function(data){
            if (data.err_code > 0) {
                var html = '<div class="modal-backdrop fade in"></div><div class="modal modal-contact hide fade in" data-reactid=".0" aria-hidden="false" style="margin-top: -1000px; display: block;"><div class="modal-header"><h6 class="modal-title">设置分销客服联系方式</h6></div><div class="modal-body"><div class="ui-message-warning">为了保障供销两端的有效沟通和维权，您必须设置客服联系方式。</div><form class="form-horizontal"><div class="control-group"><label class="control-label">客服电话：</label><div class="controls"><input class="input-large" type="text" name="mobile" /></div></div><div class="control-group"><label class="control-label">客服 QQ：</label><div class="controls"><input class="input-large" type="text" name="qq" /></div></div><div class="control-group"><label class="control-label">客服微信：</label><div class="controls"><input class="input-large" type="text" name="weixin" /></div></div><div class="form-actions"><input type="button" value="提交" class="btn btn-primary" /><input type="button" value="取消" class="btn btn-cancel" /></div></form></div></div>';
                $('body').append(html);
                $('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
            }
        })
    });

    $('.btn-primary').live('click', function(){
        var tel = $("input[name='mobile']").val();
        var qq = $("input[name='qq']").val();
        var weixin = $("input[name='weixin']").val();
        $.post(service_url, {'type': 'add', 'tel': tel, 'qq': qq, 'weixin': weixin}, function(data){
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
                    $('.modal-backdrop,.modal').remove();
                });
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    })

    $('.btn-cancel').live('click', function(){
        $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
            $('.modal-backdrop,.modal').remove();
        });
    })

    //启用分销商审核
    $('.ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(open_drp_approve_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //关闭分销商审核
    $('.ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_drp_approve_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}
