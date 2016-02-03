/**
 * Created by pigcms_21 on 2015/1/31.
 */
var clock = '';
$(function(){
	if(!has_company){
		getProvinces('s1', '');
		$('#s1').change(function(){
			$('#s2').html('<option>选择城市</option>');
			if($(this).val() != ''){
				getCitys('s2','s1','');
			}
			$('#s3').html('<option>选择地区</option>');
		});
		$('#s2').change(function () {
			getAreas('s3', 's2', '');
		});
	}
    $('.js-readme').click(function(){
        if ($(this).is(':checked')) {
            $('.submit-btn').attr('disabled', false);
        } else {
            $('.submit-btn').attr('disabled', true);
        }
    })

    $('.store-name').live('blur', function(){
        $('.store-name').parents('.control-group').removeClass('error');
        $('.store-name').next('.error-message').remove();
        if ($.trim($(this).val()) != '') {
            $.post(store_name_check, {'name': $.trim($('.store-name').val())}, function(data){
                if (!data) {
                    $('.store-name').parents('.control-group').addClass('error');
                    $('.store-name').next('.error-message').remove();
                    $('.store-name').after('<p class="help-block error-message">店铺名已存在</p>');
                } else {
                    $('.store-name').parents('.control-group').removeClass('error');
                    $('.store-name').next('.error-message').remove();
                }
            })
        } else {
            $('.store-name').parents('.control-group').addClass('error');
            $('.store-name').next('.error-message').remove();
            $('.store-name').after('<p class="help-block error-message">店铺名没有填写</p>');
        }
    })

    $('.submit-btn').click(function(){
        if ($('.company-name').val() == '') {
            $('.company-name').parents('.control-group').addClass('error');
            $('.company-name').next('.error-message').remove();
            $('.company-name').after('<p class="help-block error-message">公司名称没有填写</p>');
        } else {
            $('.company-name').parents('.control-group').removeClass('error');
            $('.company-name').next('.error-message').remove();
        }
        if ($('.province').val() == '') {
            $('.province').closest('.control-group').addClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
            $('.province').closest('.controls').append('<p class="help-block error-message">省份没有选择</p>');
        } else if ($('.city:visible').length > 0 && $('.city').val() == '') {
            $('.province').closest('.control-group').addClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
            $('.province').closest('.controls').append('<p class="help-block error-message">城市没有选择</p>');
        } else if ($('.area:visible').length > 0 && $('.area').val() == '') {
            $('.province').closest('.control-group').addClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
            $('.province').closest('.controls').append('<p class="help-block error-message">地区没有选择</p>');
        } else {
            $('.province').closest('.control-group').removeClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
        }
        if ($('.address').length == 1 && $('.address').val() == ''){
            $('.address').parents('.control-group').addClass('error');
            $('.address').next('.error-message').remove();
            $('.address').after('<p class="help-block error-message">地址没有填写</p>');
        } else {
            $('.address').parents('.control-group').removeClass('error');
            $('.address').next('.error-message').remove();
        }
        if ($.trim($('.store-name').val()) == ''){
            $('.store-name').parents('.control-group').addClass('error');
            $('.store-name').next('.error-message').remove();
            $('.store-name').after('<p class="help-block error-message">店铺名没有填写</p>');
        } else {
            $.post(store_name_check, {'name': $.trim($('.store-name').val())}, function(data){
                if (!data) {
                    $('.store-name').parents('.control-group').addClass('error');
                    $('.store-name').next('.error-message').remove();
                    $('.store-name').after('<p class="help-block error-message">店铺名已存在</p>');
                } else {
                    $('.store-name').parents('.control-group').removeClass('error');
                    $('.store-name').next('.error-message').remove();
                }
            })
        }
        if ($('.sale-category:checked').length == 0) {
            $('.sale-category').parents('.js-business').next('.error-message').remove();
            $('.sale-category').parents('.js-business').after('<p class="help-block error-message">还没有选择主营类目</p>');
        }
        if ($('.contact-man').val() == '') {
            $('.contact-man').parents('.control-group').addClass('error');
            $('.contact-man').next('.error-message').remove();
            $('.contact-man').after('<p class="help-block error-message">联系人不能为空</p>');
        } else {
            $('.contact-man').parents('.control-group').removeClass('error');
            $('.contact-man').next('.error-message').remove();
        }
        if ($('.tel').val() == ''){
            var tel = $.trim($('.tel').val());
            if (!/^[0-9]{11}$/.test(tel)){
                $('.tel').parents('.control-group').addClass('error');
                $('.tel').next('.error-message').remove();
                $('.tel').after('<p class="help-block error-message">手机号码格式不正确</p>');
            } else {
                $('.tel').parents('.control-group').removeClass('error');
                $('.tel').next('.error-message').remove();
                $('.tel').removeClass('btn-disabled').attr('disabled', false);
            }
        }
        if ($('.sms-captcha').length > 0) {
            if ($('.sms-captcha').val() == '') {
                $('.js-fetch-sms').parents('.control-group').addClass('error');
                $('.js-fetch-sms').next('.error-message').remove();
                $('.js-fetch-sms').after('<p class="help-block error-message">验证码不能为空</p>');
            } else {
                $('.js-fetch-sms').parents('.control-group').removeClass('error');
                $('.js-fetch-sms').next('.error-message').remove();
            }
        } else {
            if ($('.error-message').length == 0) {
                $('.form-horizontal').submit();
            }
        }
    })

    $('.company-name').keyup(function(){
        if ($(this).val() != '') {
            $(this).parents('.control-group').removeClass('error');
            $(this).next('.error-message').remove();
        }
    })

    $('.province').change(function(){
        if ($(this).val() != '') {
            $('.province').closest('.control-group').removeClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
        } else {
            $('.province').closest('.control-group').addClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
            $('.province').closest('.controls').append('<p class="help-block error-message">省份没有选择</p>');
        }
    })

    $('.city').change(function(){
        if ($(this).val() != '') {
            $('.province').closest('.control-group').removeClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
        } else {
            $('.province').closest('.control-group').addClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
            $('.province').closest('.controls').append('<p class="help-block error-message">城市没有选择</p>');
        }
    })

    $('.area').change(function(){
        if ($(this).val() != '') {
            $('.province').closest('.control-group').removeClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
        } else {
            $('.province').closest('.control-group').addClass('error');
            $('.province').closest('.controls').children('.error-message').remove();
            $('.province').closest('.controls').append('<p class="help-block error-message">地区没有选择</p>');
        }
    })

    $('.address').keyup(function(){
        if ($(this).val() != '') {
            $(this).parents('.control-group').removeClass('error');
            $(this).next('.error-message').remove();
        }
    })

    $('.store-name').focus(function(){
        $(this).parents('.control-group').removeClass('error');
        $(this).next('.error-message').remove();
    })

    $('.sale-category').live('click', function(){
        var categories = $.parseJSON(json_categories);
        var cat_id = $(this).val();
        $(this).closest('.widget-selectbox').next('.widget-selectbox').remove();
        if ($(this).is(':checked')) {
            if(categories[cat_id] != '' && categories[cat_id] != undefined && categories[cat_id]['children'] != '' && categories[cat_id]['children'] != undefined) {
                var html = ' <div class="widget-selectbox">';
                    html += '   <span href="javascript:;" class="widget-selectbox-handle" style="border-color: rgb(204, 204, 204);">' + categories[cat_id]['children'][0]['name'] + '</span>';
                    html += '   <ul class="widget-selectbox-content" style="display: none;">';
                    for (i in categories[cat_id]['children']) {
                        checked = '';
                        if (i == 0) {
                            var checked = 'checked="true"';
                        }
                        html += '       <li data-id="' + categories[cat_id]['children'][i]['cat_id'] + '"><label class="radio"><input type="radio" name="sale_category_id" class="sale-category" value="' + categories[cat_id]['children'][i]['cat_id'] + '" data="' + categories[cat_id]['children'][i]['name'] + '" ' + checked + ' />' + categories[cat_id]['children'][i]['name'] + '</label></li>';
                    }
                    html += '   </ul>';
                    html += '</div>'
                $('.sale-category').closest('.widget-selectbox').after(html);
            }
            $(this).closest('.widget-selectbox').find('.widget-selectbox-handle').html($(this).attr('data'));
            $(this).closest('.widget-selectbox-content').hide();
            $('.widget-selectbox-handle').css('border-color','#ccc');
            $('.sale-category').parents('.js-business').next('.error-message').remove();
        }
    });
	
    $('.contact-man').focus(function(){
        $(this).parents('.control-group').removeClass('error');
        $(this).next('.error-message').remove();
    })
	
	$('.widget-selectbox').live('hover', function(){
        if (event.type == 'mouseover') {
            $(this).children('.widget-selectbox-handle').css('border-bottom-color', 'transparent');
            $(this).children('.widget-selectbox-content').show();
        } else if (event.type == 'mouseout') {
            $(this).children('.widget-selectbox-handle').css('border-color','#ccc');
            $(this).children('.widget-selectbox-content').hide();
        }
	});

    $('.tel').blur(function(){
        var tel = $.trim($(this).val());
        $('.js-fetch-sms').removeClass('btn-disabled').attr('disabled', true);
        if (tel != '') {
            $('.tel').next('.error-message').remove();
            if (!/^[0-9]{11}$/.test(tel)) {
                $('.tel').parents('.control-group').addClass('error');
                $('.tel').after('<p class="help-block error-message">手机号码格式不正确</p>');
                $('.js-fetch-sms').removeClass('btn-disabled').attr('disabled', true);
            } else {
                $('.tel').parents('.control-group').removeClass('error');
                $('.tel').next('.error-message').remove();
                $('.js-fetch-sms').removeClass('btn-disabled').attr('disabled', false);
            }
        }
    })

    $('.tel').focus(function(){
        $('.tel').parents('.control-group').removeClass('error');
        $('.tel').next('.error-message').remove();
    });

    $('.qq').blur(function() {
        $(this).parents('.control-group').removeClass('error');
        $(this).next('.error-message').remove();
        if ($(this).val() != '') {
            var qq = $.trim($(this).val());
            if (!/^[1-9]\d{5,15}$/.test(qq)) {
                $('.qq').parents('.control-group').addClass('error');
                $('.qq').next('.error-message').remove();
                $('.qq').after('<p class="help-block error-message">QQ号格式不正确</p>');
            }
        }
    })

    $('.qq').focus(function(){
        $(this).parents('.control-group').removeClass('error');
        $(this).next('.error-message').remove();
    });

    //生成短信验证码
    $('.js-fetch-sms').click(function() {
        $(this).addClass('btn-disabled').attr('disabled', true);
        $('.js-fetch-sms').parents('.control-group').removeClass('error');
        $('.js-fetch-sms').next('.error-message').remove();
        $.get('user.php?c=store&a=create&type=captcha_generate', {'tel' : $.trim($('.tel').val())},function(data){
            if (!data) {
                $('.js-fetch-sms').parents('.control-group').addClass('error');
                $('.js-fetch-sms').after('<p class="help-block error-message">验证码发送失败，请点击“获取”重新发送</p>');
            }
        })
        var value = '<span class="time">60</span>秒后重新获取';
        $(this).html(value);
        var clock = setInterval('timeFun()', 1000);
    })

    $('.sms-captcha').keyup(function(){
        $('.js-fetch-sms').parents('.control-group').removeClass('error');
        $('.js-fetch-sms').next('.error-message').remove();
    })

    if ($('.sms-captcha').length > 0) {
        //校验短信验证码
        $('.submit-btn').click(function(){
            if ($('.sms-captcha').val() != '') {
                $('.js-fetch-sms').parents('.control-group').removeClass('error');
                $('.js-fetch-sms').next('.error-message').remove();
                $.get('user.php?c=store&a=create&type=captcha_validate', {'tel' : $.trim($('.tel').val()), 'captcha' : $.trim($('.sms-captcha').val())}, function(data){
                    if (!data) {
                        $('.js-fetch-sms').parents('.control-group').addClass('error');
                        $('.js-fetch-sms').after('<p class="help-block error-message">验证码不正确</p>');
                    } else {
                        if ($('.error-message').length == 0) {
                            $('.form-horizontal').submit();
                        }
                    }
                })
            }
        })
    }

    $('.sms-captcha').focus(function(){
        $('.js-fetch-sms').parents('.control-group').removeClass('error');
        $('.js-fetch-sms').next('.error-message').remove();
    })
})

function timeFun() {
    var time = $('.time').text();
    time = parseInt(time);
    time = time - 1;
    $('.time').text(time);
    if (time <= 0) {
        clearInterval(clock);
        $('.js-fetch-sms').removeClass('btn-disabled').attr('disabled', false);
        $('.js-fetch-sms').html('获取');
    }
}

