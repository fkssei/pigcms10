$(function(){
	load_page('#content',load_url,{page:'personal_content'},'');

    $('.js-trigger-image').live('click', function(){
        var obj = this;
        upload_pic_box(1,true,function(pic_list){
            if(pic_list.length > 0){
                for(var i in pic_list){
                    $('.display-image').attr('data-url', pic_list[i]);
                    $('.avatar').css('background-image', 'url(' + pic_list[i] + ')');
                }
            } else {
                return false;
            }
        },1);
    })

    $('.js-btn-submit').live('click', function(){
        var nickname = $("input[name='nickname']").val();
        var avatar = $('.display-image').attr('data-url');
        var intro = $("textarea[name='intro']").val();

        if (nickname == '') {
            $("input[name='nickname']").closest('.control-group').addClass('error');
            $("input[name='nickname']").next('.error-message').remove();
            $("input[name='nickname']").after('<p class="help-block error-message">昵称不能为空</p>');
        } else {
            $("input[name='nickname']").closest('.control-group').removeClass('error');
            $("input[name='nickname']").next('.error-message').remove();
        }
        if ($('.error-message').length == 0) {
            $.post(personal_url, {'nickname': nickname, 'avatar': avatar, 'intro': intro}, function(data){
                if(!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 2000);
            })
        }
    })
});

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}