/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
var keyword = '';
var approve = '*';
var p = 1;
$(function(){
    load_page('.app__content', load_url, {page:'seller_content'}, '');

    $('.js-search-btn').live('click', function(){
        keyword = $.trim($('.js-search').val());
        approve = $.trim($('.js-search-drp-approve').val());
        load_page('.app__content', load_url, {page:'seller_content', 'keyword': keyword, 'approve': approve}, '', function(){
            $('.js-search').val(keyword);
            $('.js-search-drp-approve').find("option[value='" + approve + "']").attr("selected",true);
            $('.js-search').focus();
        });
    })
    //搜索
    $(".js-search").live('keyup', function(e){
        if (event.keyCode == 13) { //回车
            $('.js-search-btn').trigger('click');
        }
    })
    //审核
    $('.js-drp-approve').live('click', function(e) {
        var seller_id = $(this).data('id');
        button_box($(this), e, 'left', 'confirm', '确认审核？', function(){
            $.post(drp_approve_url, {'seller_id': seller_id}, function(data) {
                close_button_box();
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    load_page('.app__content', load_url, {page:'seller_content', 'p': p, 'keyword': keyword, 'approve': approve}, '');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
        });
    })
    //分销商禁用
    $('.js-drp-disabled').live('click', function(e) {
        var seller_id = $(this).data('id');
        button_box($(this), e, 'left', 'confirm', '确认禁用？', function(){
            $.post(drp_status_url, {'seller_id': seller_id, 'status': 0}, function(data) {
                close_button_box();
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    load_page('.app__content', load_url, {page:'seller_content', 'p': p, 'keyword': keyword, 'approve': approve}, '');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
        });
    })
    //分销商启用
    $('.js-drp-enabled').live('click', function(e) {
        var seller_id = $(this).data('id');
        button_box($(this), e, 'left', 'confirm', '确认启用？', function(){
            $.post(drp_status_url, {'seller_id': seller_id, 'status': 1}, function(data) {
                close_button_box();
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    load_page('.app__content', load_url, {page:'seller_content', 'p': p, 'keyword': keyword, 'approve': approve}, '');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
        });
    })
    //分页
    $('.pagenavi > a').live('click', function(e){
        p = $(this).attr('data-page-num');
        keyword = $.trim($('.js-search').val());
        $('.app__content').load(load_url, {page: 'seller_content', 'p': p, 'keyword': keyword}, function(){
            if (keyword != '') {
                $('.js-search').val(keyword);
            }
        });
    })
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}
