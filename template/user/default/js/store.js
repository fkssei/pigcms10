/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
$(function(){
    load_page('.app__content', load_url, {page:'index_content'}, '');

    $('.ui-store-board-logo').live('hover', function(event){
        if(event.type == 'mouseenter') {
            $(this).find('.hide').show();
        } else {
            $(this).find('.hide').hide();
        }
    })
})
