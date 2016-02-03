/**
 * Created by pigcms_21 on 2015/2/6.
 */
$(function(){

    location_page(window.location.hash);
    var page_name= '';
    var page_id = '';
    function location_page(action) {
        if (action == '' || action == undefined) {
            action = '#list';
        }
        var query = action.split('/') || [];
        var action = query[0] || '';
        page_id = query[1] || 0;
        switch (action) {
            case '#create':
                load_page('.app__content', load_url,{page:'create_page_content'}, '',function(){
                    page_create(page_id);
                });
                break;
            case '#edit':
                load_page('.app__content', load_url,{page:'edit_page_content', 'page_id': page_id}, '',function(){
                    customField.setHtml($('#edit_custom').attr('custom-field'));
                    if ($('#edit_custom').attr('custom-field') != ''){
                        $('.app-sidebar').removeClass('hide');
                    }
                    page_create(page_id);
                    page_name = $('#edit_custom').attr('page-name');
                    page_id = $('#edit_custom').attr('page-id');
                    $('#edit_custom').remove();
                });
                break;
            default:
                load_page('.app__content',load_url,{page:'page_content'},'',function(){});
                break;
        }
    }

    function page_create(page_id){
        defaultFieldObj = $('.js-config-region .app-field');
        defaultFieldObj.click(function(){
            $('.app-entry .app-field').removeClass('editing');
            $('.js-sidebar-region').empty();
            $('.app-sidebar').hide();
        });
        customField.init();
        if (page_id) {
            $('.js-fields-region .app-field').eq(0).trigger('click');
        } else {
            defaultFieldObj.trigger('click');
        }
    }

    //分页
    $('.pagenavi > a').live('click', function(){
        var keyword = $('.js-list-search > .txt').val();
        var p = $(this).attr('data-page-num');
        load_page('.app__content',load_url,{'page': 'page_content', 'p': p, 'keyword': keyword},'',function(){
            $('.js-list-search > .txt').val(keyword);
        });
    })

    //改名
    $('.js-rename').live('click', function(e){
        var name = $(this).closest('tr').find('td:first-child > .new-window').text();
        var obj = this;
        button_box($(this), e, 'left', 'input', name, function(){
            var name  = $('.js-rename-placeholder').val();
            var page_id = $(obj).attr('data-id');
            $.post(rename_page_url, {'page_id': page_id, 'name': name}, function(data){
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    $(obj).closest('tr').find('td:first-child > .new-window').text(name);
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
            close_button_box();
        })
    })

    //回车提交搜索
    $(window).keydown(function(event){
        if (event.keyCode == 13 && $('.js-list-search > .txt').is(':focus')) {
            var keyword = $('.js-list-search > .txt').val();
            $('.app__content').load(load_url, {page: 'page_content', 'keyword': keyword}, function(){
                $('.js-list-search > .txt').val(keyword);
            });
        }
    })

    //搜索框动画
    $('.js-list-search > .txt').live('focus', function(){
        $(this).animate({width: '180px'}, 100);
    })
    $('.js-list-search > .txt').live('blur', function(){
        $(this).animate({width: '70px'}, 100);
    })

    //添加自定义页面
    $('.js-add-btn').live('click', function(){
        location_page('#create');
    })

    //修改自定义页面
    $('.js-edit').live('click', function(){
        var url = $(this).attr('href');
        location_page(url);
    })

    $('.js-new-field').live('click', function(){
        $('.app-sidebar').removeClass('hide');
    })

    $('.alert-error > .close').live('click', function(){
        $('body').children('.notify-backdrop').remove();
        $('.notifications').html('');
    })

    //保存页面
    $('.btn-save').live('click', function(e) {
        if (customField.checkEvent() == '') {
            $('body').append('<div class="notify-backdrop fade in"></div>');
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>自定义模块不能为空。</div>');
            return false;
        }

        button_box($(this),e,'top','module', page_name, function(){
            var post_data = {};
            page_name = $('.js-text-placeholder').val();
            post_data.page_id = page_id;
            post_data.name = page_name;
            post_data.custom = customField.checkEvent();
            $.post(create_page_url, post_data, function(data){
                close_button_box();
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    location_page();
                    window.location.hash = '#';
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
        });
    })

    $('.js-fields-region .app-field').live('click',function(){
        $('.app-sidebar').show();
    })

    $('.js-delete').live('click', function(e){
        var page_id = $(this).attr('data-id');
        button_box($(this), e, 'left', 'confirm', '确定删除？', function(){
            $.post(del_page_url, {'page_id': page_id}, function(data){
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    location_page();
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
                close_button_box();
            })
        })
    })
});

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}

