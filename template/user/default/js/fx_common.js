$(function() {
    $('.chosen-single').live('click', function(){
        $(".chosen-search input").focus();
        if ($(this).closest('.chosen-container-single').hasClass('chosen-container-active')) {
            $(this).closest('.chosen-container-single').removeClass('chosen-container-active').removeClass('chosen-with-drop');
        } else {
            $(this).closest('.chosen-container-single').addClass('chosen-container-active').addClass('chosen-with-drop');
        }
    })

    //分组选择
    $('.active-result').live('hover', function(){
        $(this).addClass('result-selected').addClass('highlighted');
        $(this).siblings('.active-result').removeClass('result-selected').removeClass('highlighted');
    })

    $('body').click(function(e){
        var _con = $('.chosen-container');   // 设置目标区域
        if(!_con.is(e.target) && _con.has(e.target).length === 0){ // Mark 1
            if ($('.chosen-container-single').hasClass('chosen-with-drop')) {
                $('.chosen-container-single').removeClass('chosen-container-active').removeClass('chosen-with-drop');
            }
        }
    })
    $('body').mousedown(function(e){
        if (event.button==2) {
            if ($('.chosen-container-single').hasClass('chosen-with-drop')) {
                $('.chosen-container-single').removeClass('chosen-container-active').removeClass('chosen-with-drop');
            }
        }
    });

    $('.js-check-all').live('click', function(){
        if ($(this).is(':checked')) {
            $('.js-check-toggle').attr('checked', true);
            $('input:disabled').attr('checked', false);
        } else {
            $('.js-check-toggle').attr('checked', false);
        }
    })
    $('.js-check-toggle').live('click', function(){
        if ($(this).is(':checked')) {
            if (!$('.js-check-toggle').not(':checked').length) {
                $('.js-check-all').attr('checked', true);
            }
        } else {
            $('.js-check-all').attr('checked', false);
        }
    })

    //关闭提示窗
    $('.close').live('click', function(e){
        $('.notifications').html('');
        $('.notify-backdrop').remove();
    })
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}