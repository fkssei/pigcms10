/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
$(function(){
    load_page('.app__content', load_url, {page:'supplier_content'}, '');

    $('.js-search-btn').live('click', function(){
        var keyword = $.trim($('.js-search').val());
        load_page('.app__content', load_url, {page:'supplier_content', 'keyword': keyword}, '', function(){
            $('.js-search').val(keyword);
            $('.js-search').focus();
        });
    })

    $(".js-search").live('keyup', function(e){
        if (event.keyCode == 13) { //回车
            $('.js-search-btn').trigger('click');
        }
    })

    //分页
    $('.pagenavi > a').live('click', function(e){
        var p = $(this).attr('data-page-num');
        var keyword = $.trim($('.js-search').val());
        $('.app__content').load(load_url, {page: 'supplier_content', 'p': p, 'keyword': keyword}, function(){
            if (keyword != '') {
                $('.js-search').val(keyword);
            }
        });
    })
})
