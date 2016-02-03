/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
var category_id = 0;
var category_fid = 0;
var index = 0;
var text = '';
var keyword = '';
$(function(){
    load_page('.app__content', load_url, {page:'supplier_market_content'}, '');

    //分页
    $('.pagenavi > a').live('click', function(e){
        var p = $(this).attr('data-page-num');
        var category = $('.result-selected').data('option-array-index');
        if (category != undefined && category != '') {
            var category = category.split('|');
            category_fid = category[0];
            category_id = category[1];
            if (category_fid == 0) {
                category_fid = category_id;
                category_id = 0;
            } else {
                category_fid = 0;
            }
        }
        index = $('.result-selected').index('.active-result');
        text = $('.result-selected').text();
        keyword = $.trim($('.js-list-search > .js-keyword').val());
        $('.app__content').load(load_url, {page: 'supplier_market_content', 'p': p, 'category_id': category_id, 'category_fid': category_fid, 'keyword': keyword}, function(){
            $('.chosen-single > span').text(text);
            $('.active-result').not(index).removeClass('result-selected highlighted')
            $('.active-result').eq(index).addClass('result-selected highlighted');
            $('.js-list-search > .js-keyword').val(keyword);
        });
    })

    //选择分类触发
    $('.active-result').live('click', function(){
        var category = $(this).data('option-array-index');
        var category = category.split('|');
        category_fid = category[0];
        category_id = category[1];
        if (category_fid == 0) {
            category_fid = category_id;
            category_id = 0;
        } else {
            category_fid = 0;
        }
        index = $('.result-selected').index('.active-result');
        text = $('.result-selected').text();
        load_page('.app__content', load_url, {page: 'supplier_market_content', 'category_id': category_id, 'category_fid': category_fid}, '', function(){
            $('.chosen-single > span').text(text);
            $('.active-result').not(index).removeClass('result-selected highlighted')
            $('.active-result').eq(index).addClass('result-selected highlighted');
        });
    })

    $('.market-search-btn').live('click', function(){
        var category = $('.result-selected').data('option-array-index');
        if (category) {
            category = category.split('|');
            category_fid = category[0];
            category_id = category[1];
        } else {
            category_fid = 0;
            category_id = 0;
        }
        if (category_fid == 0) {
            category_fid = category_id;
            category_id = 0;
        } else {
            category_fid = 0;
        }
        index = $('.result-selected').index('.active-result');
        text = $('.result-selected').text();
        keyword = $.trim($('.js-list-search > .js-keyword').val());
        load_page('.app__content', load_url, {page: 'supplier_market_content', 'category_id': category_id, 'category_fid': category_fid, 'keyword': keyword}, '', function(){
            $('.chosen-single > span').text(text);
            $('.active-result').not(index).removeClass('result-selected highlighted')
            $('.active-result').eq(index).addClass('result-selected highlighted');
            $('.js-list-search > .js-keyword').val(keyword);
            $('.js-list-search > .js-keyword').focus();
        });
    })
    $('.js-cancel-to-fx').live('click', function(){
        var products = $(this).data('id');
        $.post(supplier_market_url, {'products': products}, function(data){
            if (!data.err_code) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                load_page('.app__content', load_url, {page:'supplier_market_content', 'category_id': category_id, 'category_fid': category_fid, 'keyword': keyword}, '', function(){
                    if (text != '' && text != undefined && index != undefined) {
                        $('.chosen-single > span').text(text);
                        $('.active-result').not(index).removeClass('result-selected highlighted')
                        $('.active-result').eq(index).addClass('result-selected highlighted');
                    }
                    if (keyword != '' && keyword != undefined) {
                        $('.js-list-search > .js-keyword').val(keyword);
                    }
                });
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    })

    $('.js-batch-cancel-to-fx').live('click', function(){
        if ($('.js-check-toggle:checked').length == 0) {
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择商品。</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        var products = [];
        $('.js-check-toggle:checked').each(function(i){
            products[i] = $(this).val();
        })
        $.post(supplier_market_url, {'products': products.toString()}, function(data){
            if (!data.err_code) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                load_page('.app__content', load_url, {page:'supplier_market_content', 'category_id': category_id, 'category_fid': category_fid, 'keyword': keyword}, '', function(){
                    if (text != '' && text != undefined && index != undefined) {
                        $('.chosen-single > span').text(text);
                        $('.active-result').not(index).removeClass('result-selected highlighted')
                        $('.active-result').eq(index).addClass('result-selected highlighted');
                    }
                    if (keyword != '' && keyword != undefined) {
                        $('.js-list-search > .js-keyword').val(keyword);
                    }
                });
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    })

    $(".js-keyword").live('keyup', function(e){
        if (event.keyCode == 13) { //回车
            $('.market-search-btn').trigger('click');
        }
    })

})
