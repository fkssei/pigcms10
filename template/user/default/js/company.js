var t = '';
$(function(){
	load_page('#content',load_url,{page:'company_content'},'');

    $('.submit-btn').live('click', function() {
        var name = $('.company-name').val();
        var province = $('.province').val();
        var city = $('.city').val();
        if ($('.area').length > 0 && !isNaN($('.area').val())) {
            var area = $('.area').val();
        } else {
            var area = '';
        }
        var address = $('.address').val();

        if (name == '') {
            $('.company-name').closest('.control-group').addClass('error');
            $('.company-name').next('.err-message').remove();
            $('.company-name').after('<p class="help-block err-message teamname-err-msg">公司名称没有填写</p>');
        } else {
            $('.company-name').closest('.control-group').removeClass('error');
            $('.company-name').next('.err-message').remove();
        }
        if (province == '') {
            $('.province').closest('.control-group').addClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
            $('.province').closest('.controls').append('<p class="help-block error-message">省份没有选择</p>');
        } else if ($('.city:visible').length > 0 && city == '') {
            $('.province').closest('.control-group').addClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
            $('.province').closest('.controls').append('<p class="help-block error-message">城市没有选择</p>');
        } else if ($('.area:visible').length > 0 && area == '') {
            $('.province').closest('.control-group').addClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
            $('.province').closest('.controls').append('<p class="help-block error-message">地区没有选择</p>');
        } else {
            $('.province').closest('.control-group').removeClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
        }

        if (address == '') {
            $('.address').closest('.control-group').addClass('error');
            $('.address').next('.error-message').remove();
            $('.address').after('<p class="help-block error-message">地址没有填写</p>');
        } else {
            $('.address').closest('.control-group').removeClass('error');
            $('.address').next('.error-message').remove();
        }

        if ($('.err-message').length == 0 && $('.error-message').length == 0) {
            $.post(company_url, {'name': name, 'province': province, 'city': city, 'area': area, 'address': address}, function(data){
                if (data.err_code == 0) {
                    window.location.href = select_url;
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                    t = setTimeout('msg_hide()', 3000);
                }
            })
        }
    })
});

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}