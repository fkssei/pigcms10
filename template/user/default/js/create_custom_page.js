/**
 * Created by pigcms_21 on 2015/2/6.
 */
$(function(){
    load_page('.app__content',load_url,{page:'create_page_content'},'',function(){
        location_page();
    });

    function location_page(){

        load_page('.app__content', load_url,{page:'create_page_content'}, '',function(){
            page_create();
        });

    }

    function page_create(){
        defaultFieldObj = $('.js-config-region .app-field');
        defaultFieldObj.click(function(){
            $('.app-entry .app-field').removeClass('editing');
            $(this).addClass('editing');

        });
        defaultFieldObj.trigger('click');
        customField.init();
    }

    $('.js-new-field').live('click', function(){
        $('.app-sidebar').removeClass('hide');
    })

    //保存页面
    $('.btn-save').live('click', function(e) {
        if (customField.checkEvent() == '') {
            $('body').append('<div class="notify-backdrop fade in"></div>');
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>自定义模块不能为空。</div>');
            return false;
        }
        button_box($(this),e,'top','module','模块名称', function(){
            var post_data = {};
            post_data.name = $('.js-text-placeholder').val();
            post_data.custom = customField.checkEvent();
            $.post(create_page_url, post_data, function(data){
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                location_page();
                t = setTimeout('msg_hide()', 3000);
            })
        });
    })

    $('.alert-error > .close').live('click', function(){
        $('body').children('.notify-backdrop').remove();
        $('.notifications').html('');
    })
});