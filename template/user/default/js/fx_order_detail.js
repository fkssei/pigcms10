/**
 * Created by pigcms_21 on 2015/3/11.
 */
$(function() {
    load_page('.app__content', load_url, {page: page_content, 'order_id': order_id}, '', function(){});

    //切换包裹选项卡
    $('.js-express-tab > li').live('click', function(){
        var index  = $(this).index('.js-express-tab > li');
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $('.section-detail > .js-express-tab-content').eq(index).siblings('div').addClass('hide')
        $('.section-detail > .js-express-tab-content').eq(index).removeClass('hide');
    })
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}
