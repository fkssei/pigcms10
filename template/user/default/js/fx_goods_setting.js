$(function(){
    var min_cost_price = [];
    min_cost_price[0] = [];
    min_cost_price[1] = [];
    min_cost_price[2] = [];
    min_cost_price[3] = [];
	var min_price = [];
    var max_price = [];
    min_price[0] = [];
    min_price[1] = [];
    min_price[2] = [];
    min_price[3] = [];
    max_price[0] = [];

    load_page('.app__content',load_url,{page:'goods_fx_setting_content', 'id': product_id},function(){


	});

    //批量设置
    var js_batch_type = '';
    $('.js-batch-cost').live('click',function(){
        js_batch_type = 'cost';
        $('.js-batch-form').html('<input type="text" class="fx-cost-price input-mini" placeholder="成本价格" /> <a class="js-batch-save" href="javascript:;">保存</a> <a class="js-batch-cancel" href="javascript:;">取消</a><p class="help-desc"></p>');
        $('.js-batch-form').show();
        $('.js-batch-type').hide();
        $('.fx-cost-price').focus();
    });
    var js_batch_type2 = '';
    $('.js-batch-cost2').live('click', function() {
        js_batch_type2 = 'cost';
        $(this).parent('span').next('.js-batch-form2').html('<input type="text" class="fx-cost-price input-mini" placeholder="成本价" /> <a class="js-batch-save2" href="javascript:;">保存</a> <a class="js-batch-cancel2" href="javascript:;">取消</a><p class="help-desc"></p>');
        $(this).parent('span').next('.js-batch-form2').show();
        $(this).parent('span').hide();
    })

    $('.js-batch-price').live('click',function(){
        if ($("input[name='cost_price']").val() == '' || $("input[name='cost_price']").val() == 0) {
            layer_tips(1,'您还没有设置成本价');
            return false;
        }
        js_batch_type = 'price';
        $('.js-batch-form').html('<input type="text" class="fx-min-price input-mini" placeholder="分销最低价" /> - <input type="text" class="fx-max-price input-mini" placeholder="分销最高价" /> <a class="js-batch-save" href="javascript:;">保存</a> <a class="js-batch-cancel" href="javascript:;">取消</a><p class="help-desc"></p>');
        $('.js-batch-form').show();
        $('.js-batch-type').hide();
        $('.fx-min-pricet').focus();
    });

    $('.js-batch-price2').live('click',function(){
        js_batch_type2 = 'price';
        $(this).parent('span').next('.js-batch-form2').html('<input type="text" class="fx-price input-mini" placeholder="分销价" /> <a class="js-batch-save2" href="javascript:;">保存</a> <a class="js-batch-cancel2" href="javascript:;">取消</a><p class="help-desc"></p>');
        $(this).parent('span').next('.js-batch-form2').show();
        $(this).parent('span').hide();
    });

    $('.js-batch-save').live('click',function(){
        if(js_batch_type == 'price'){
            if ($("input[name='cost_price']").val() == '' || $("input[name='cost_price']").val() == 0) {
                layer_tips(1,'您还没有设置成本价');
                return false;
            }
            var fx_min_price = parseFloat($('.fx-min-price').val());
            var fx_max_price = parseFloat($('.fx-max-price').val());
            $(this).closest('td').removeClass('manual-valid-error');
            $('.help-desc').next('.error-message').remove();
            if(fx_min_price > 9999999.99){
                //layer_tips(1,'价格最大为 9999999.99');
                //$('.fx-min-price').focus();
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">价格最大为 9999999.99</div>');
                return false;
            } else if (fx_max_price < 0.01) {
                //layer_tips(1,'价格最小为 0.01');
                //$('.fx-max-price').focus();
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">价格最小为 0.01</div>');
                return false;
            } else if(!/^\d+(\.\d+)?$/.test($('.fx-min-price').val())){
                //layer_tips(1,'请输入合法的价格');
                //$('.fx-min-price').focus();
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">请输入合法的价格</div>');
                return false;
            } else if (!/^\d+(\.\d+)?$/.test($('.fx-max-price').val())) {
                //layer_tips(1,'请输入合法的价格');
                //$('.fx-max-price').focus();
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">请输入合法的价格</div>');
                return false;
            } else if (fx_min_price < parseFloat($("input[name='cost_price']").val())) {
                //layer_tips(1,'分销价格不能低于成本价格');
                //$('.fx_min_price').focus();
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">分销价不能低于成本价</div>');
                return false;
            } else if (fx_min_price > fx_max_price) {
                //layer_tips(1,'无效的价格区间');
                //$('.fx-max-price').focus();
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">无效的价格区间</div>');
                return false;
            } else{
                $('.fx-min-price').val(fx_min_price.toFixed(2));
                $('.fx-max-price').val(fx_max_price.toFixed(2));
            }


            //商品价格
            $("input[name='fx-min-price']").val(fx_min_price.toFixed(2));
            //$("input[name='fx-min-price']").attr('readonly', true);

            $("input[name='fx-max-price']").val(fx_max_price.toFixed(2));
            //$("input[name='fx-max-price']").attr('readonly', true);
            var flag = true;
            var fx_min_price = parseFloat($('.fx-min-price').val());
            var fx_max_price = parseFloat($('.fx-max-price').val());
            var min_price = [];
            var max_price = [];
            $('.js-fx-min-price').each(function(i) {
                var sku_min_price = parseFloat($('.js-fx-min-price').eq(i).data('min-price'));
                var sku_max_price = parseFloat($('.js-fx-max-price').eq(i).data('max-price'));
                if (fx_min_price < sku_min_price || fx_max_price > sku_max_price) {
                    flag = false;
                }
                min_price[i] = sku_min_price;
                max_price[i] = sku_max_price;
            })

            if (flag) {
                $('.js-fx-min-price').val($('.fx-min-price').val());
                $('.js-fx-max-price').val($('.fx-max-price').val());

                $('.fx-min-price').val('');
                $('.fx-max-price').val('');

                $('.js-batch-form').hide();
                $('.js-batch-type').show();
            } else {
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">分销价只能在￥' + Math.max.apply({},min_price) + '-' + Math.max.apply({},max_price) + '之间</div>');
            }
        } else if (js_batch_type == 'cost') {
            var fx_cost_price = parseFloat($('.fx-cost-price').val());
            $(this).closest('td').removeClass('manual-valid-error');
            $('.help-desc').next('.error-message').remove();
            var flag = true;
            var min_price = [];
            var max_price = [];
            var cost_price = [];
            if (fx_cost_price == '' || isNaN(fx_cost_price)) {
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">请输入合法的价格</div>');
                return false;
            }
            $('.js-cost-price').each(function(i) {
                var min_cost_price = parseFloat($('.js-cost-price').eq(i).data('min-cost-price'));
                var max_cost_price = parseFloat($('.js-cost-price').eq(i).data('max-cost-price'));
                if (fx_cost_price < min_cost_price || fx_cost_price > max_cost_price) {
                    flag = false;
                }
                min_price[i] = min_cost_price;
                max_price[i] = max_cost_price;
            })
            if (flag) {
                $("input[name='cost_price']").val(fx_cost_price.toFixed(2));
                $('.js-cost-price').val(fx_cost_price.toFixed(2));
                $('.js-batch-form').hide();
                $('.js-batch-type').show();
            } else {
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">成本价只能在￥' + Math.max.apply({},min_price) + '-' + Math.max.apply({},max_price) + '之间</div>');
            }
        }
    });


    $('.js-batch-save2').live('click', function() {
        var level = $(this).closest('table').data('level'); //分销商等级
        $(this).closest('td').removeClass('manual-valid-error');
        $('.help-desc').next('.error-message').remove();
        if (js_batch_type2 == 'price') {
            var cost_price = $(this).closest('.js-batch-form2').prev('.js-batch-type2').children('.js-batch-cost2').data('batch-cost-price');
            var fx_price = $(this).prev('.fx-price').val();
            if (fx_price == '' || fx_price == 0) {
                return false;
            } else if (parseFloat(fx_price) < 0 || !/^\d+(\.\d+)?$/.test(fx_price)) {
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">分销价填写有误</div>');
                return false;
            } else if (cost_price != undefined && fx_price < cost_price) { //分销价低于成本价
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">分销价不能低于成本价</div>');
                return false;
            }
            $(this).closest('table').find('.js-price').val(fx_price);
            $('.fx-price-' + level).val(fx_price);
            $(this).parent('.js-batch-form2').prev('.js-batch-type2').children('.js-batch-price2').attr('data-batch-price', fx_price);
        } else if (js_batch_type2 == 'cost') {
            var fx_price = $(this).closest('.js-batch-form2').prev('.js-batch-type2').children('.js-batch-price2').data('batch-price');
            var cost_price = $(this).prev('.fx-cost-price').val();
            if (cost_price == '' || cost_price == 0) {
                return false;
            } else if (parseFloat(cost_price) < 0 || !/^\d+(\.\d+)?$/.test(cost_price)) {
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">成本价填写有误</div>');
                return false;
            } else if (fx_price != undefined && cost_price > fx_price) {
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">成本价不能高于分销价</div>');
                return false;
            }
            $('.cost-price-' + level).val(cost_price);
            $(this).closest('table').find('.js-cost-price').val(cost_price);
            $(this).parent('.js-batch-form2').prev('.js-batch-type2').children('.js-batch-cost2').attr('data-batch-cost-price', cost_price);
        }
        $(this).parent('.js-batch-form2').hide();
        $(this).parent('.js-batch-form2').prev('.js-batch-type2').show();
        $(this).parent('.js-batch-form2').html('');
    })

    $('.js-cost-price').live('blur', function(){
        var fx_min_price = $(this).closest('td').next('td').find('.js-fx-min-price').val();
        if (fx_min_price != '') {
            fx_min_price = parseFloat(fx_min_price);
        } else {
            fx_min_price = 0;
        }
        $(this).parent('td').removeClass('manual-valid-error');
        $(this).next('.error-message').remove();
        if ($(this).val() != '' && !/^\d+(\.\d+)?$/.test($(this).val())) {
            $(this).parent('td').addClass('manual-valid-error');
            $(this).after('<div class="error-message">价格有误</div>');
            //$(this).val('');
            //$(this).focus();
            return false;
        } else if (fx_min_price > 0 && parseFloat($(this).val()) > fx_min_price) {
            //$(this).parent('td').addClass('manual-valid-error');
            //$(this).after('<div class="error-message">分销价不能低于成本价</div>');
        }

        var unified_price_setting = $('.unified-price-setting:checked').val(); //供货统一定价
        if (unified_price_setting == 1) {
            var level = $(this).closest('table').data('level');
            if (level != undefined && $(this).val() != '') {
                min_cost_price[level].push($(this).val());
                $('.cost-price-' + level).val(Math.min.apply(null, min_cost_price[level]));
            }
        } else {
            min_cost_price[0].push($(this).val());
            $("input[name='cost_price']").val(Math.min.apply(null, min_cost_price[0]));
        }
    })

    $('.js-fx-price').live('blur', function() {
        var price = $(this).val();
        $(this).parent('td').removeClass('manual-valid-error');
        $(this).next('.error-message').remove();
        if ($(this).val() != '' && !/^\d+(\.\d+)?$/.test($(this).val())) {
            $(this).parent('td').addClass('manual-valid-error');
            $(this).after('<div class="error-message">价格有误</div>');
            return false;
        }

        var level = $(this).closest('table').data('level');
        if (level != undefined && $(this).val() != '') {
            min_price[level].push($(this).val());
            $('.fx-price-' + level).val(Math.min.apply(null, min_price[level]));
        }
    })

    $('.js-batch-cancel').live('click',function(){
        $(this).closest('td').removeClass('manual-valid-error');
        $('.help-desc').next('.error-message').remove();
        $('.js-batch-form').hide();
        $('.js-batch-form').html('');
        $('.js-batch-type').show();
    });

    $('.js-batch-cancel2').live('click', function() {
        $(this).closest('td').removeClass('manual-valid-error');
        $(this).next('.help-desc').next('.error-message').remove();
        $(this).parent('.js-batch-form2').hide();
        $(this).parent('.js-batch-form2').prev('.js-batch-type2').show();
        $(this).parent('.js-batch-form2').html('');
    })

    $('.js-btn-save').live('click', function(){
        $('td').removeClass('manual-valid-error');
        $('.error-message').remove();
        var unified_price_setting = $('.unified-price-setting:checked').val(); //供货统一定价
        if (unified_price_setting == 0 || unified_price_setting == undefined) {
            var cost_price = $("input[name='cost_price']").val();
            if (!/^\d+(\.\d+)?$/.test(cost_price) || cost_price < 0.01) {
                layer_tips(1,'请输入合法的成本价格');
                $("input[name='cost_price']").focus();
                return false;
            }
            var num = $('.js-cost-price:visible').length;
            for (var i=0; i< num; i++) {
                if (!/^\d+(\.\d+)?$/.test($('.js-cost-price').eq(i).val())) {
                    layer_tips(1,'请输入合法的价格');
                    $('.js-cost-price').eq(i).focus();
                    return false;
                }
                if(!/^\d+(\.\d+)?$/.test($('.js-fx-min-price').eq(i).val())){
                    layer_tips(1,'请输入合法的价格');
                    $('.js-fx-min-price').eq(i).focus();
                    return false;
                }
                if (parseFloat($('.js-cost-price').eq(i).val()) > parseFloat($('.js-fx-min-price').eq(i).val())) {
                    layer_tips(1,'分销价格不能低于成本价格');
                    $('.js-fx-min-price').eq(i).focus();
                    return false;
                }
                if(!/^\d+(\.\d+)?$/.test($('.js-fx-max-price').eq(i).val())){
                    layer_tips(1,'请输入合法的价格');
                    $('.js-fx-max-price').eq(i).focus();
                    return false;
                }
                if (parseFloat($('.js-fx-min-price').eq(i).val()) > parseFloat($('.js-fx-max-price').eq(i).val())) {
                    layer_tips(1,'无效的价格区间');
                    $('.js-fx-max-price').eq(i).focus();
                    return false;
                }
            }

            if (!/^\d+(\.\d+)?$/.test($("input[name='fx-min-price']").val())) {
                layer_tips(1,'请输入合法的价格');
                $("input[name='fx-min-price']").focus();
                return false;
            }
            if (!/^\d+(\.\d+)?$/.test($("input[name='fx-max-price']").val())) {
                layer_tips(1,'请输入合法的价格');
                $("input[name='fx-max-price']").focus();
                return false;
            }

            if (parseFloat($("input[name='fx-min-price']").val()) > parseFloat($("input[name='fx-max-price']").val())) {
                layer_tips(1,'无效的价格区间');
                $("input[name='fx-max-price']").focus();
                return false;
            }
        } else {
            if ($('.cost-price-1 .cost-price-1:visible').length > 0 && !/^\d+(\.\d+)?$/.test($('.cost-price-1 .cost-price-1').val())) {
                layer_tips(1,'一级分销商成本价格输入有误');
                $('.cost-price-1 .cost-price-1').focus();
                return false;
            }
            if ($('.cost-price-1 .cost-price-2:visible').length > 0 && !/^\d+(\.\d+)?$/.test($('.cost-price-1 .cost-price-2').val())) {
                layer_tips(1,'二级分销商成本价格输入有误');
                $('.cost-price-1 .cost-price-2').focus();
                return false;
            }
            if ($('.cost-price-1 .cost-price-3:visible').length > 0 && !/^\d+(\.\d+)?$/.test($('.cost-price-1 .cost-price-3').val())) {
                layer_tips(1,'三级分销商成本价格输入有误');
                $('.cost-price-1 .cost-price-3').focus();
                return false;
            }
            $('.js-cost-price:visible').each(function(i) {
                if (!/^\d+(\.\d+)?$/.test($(this).val())) {
                    $(this).parent('td').addClass('manual-valid-error');
                    $(this).after('<div class="error-message">价格有误</div>');
                }
                if (!/^\d+(\.\d+)?$/.test($('.js-fx-price').eq(i).val())) {
                    $('.js-fx-price').eq(i).parent('td').addClass('manual-valid-error');
                    $('.js-fx-price').eq(i).after('<div class="error-message">价格有误</div>');
                }
                if (parseFloat($('.js-fx-price').eq(i).val()) < parseFloat($(this).val())) {
                    $('.js-fx-price').eq(i).parent('td').addClass('manual-valid-error');
                    $('.js-fx-price').eq(i).after('<div class="error-message">分销价不能低于成本价</div>');
                }
            });
            if ($('.price-1 .fx-price-1:visible').length > 0 && !/^\d+(\.\d+)?$/.test($('.price-1 .fx-price-1').val())) {
                layer_tips(1,'一级分销商分销价格输入有误');
                $('.price-1 .fx-price-1').focus();
                return false;
            }
            if ($('.price-1 .fx-price-2:visible').length > 0 && !/^\d+(\.\d+)?$/.test($('.price-1 .fx-price-2').val())) {
                layer_tips(1,'二级分销商分销价格输入有误');
                $('.price-1 .fx-price-2').focus();
                return false;
            }
            if ($('.price-1 .fx-price-3:visible').length > 0 && !/^\d+(\.\d+)?$/.test($('.price-1 .fx-price-3').val())) {
                layer_tips(1,'三级分销商分销价格输入有误');
                $('.price-1 .fx-price-3').focus();
                return false;
            }
        }
        if ($('.error-message').length > 0) {
            layer_tips(1,'信息填写有误，请检查');
            return false;
        }

        var cost_price = $("input[name='cost_price']").val();

        var drp_level_1_cost_price = 0;
        var drp_level_2_cost_price = 0;
        var drp_level_3_cost_price = 0;
        var drp_level_1_price = 0;
        var drp_level_2_price = 0;
        var drp_level_3_price = 0;
        if (unified_price_setting) {
            drp_level_1_cost_price = $('.cost-price-1 .cost-price-1').val();
            drp_level_2_cost_price = $('.cost-price-1 .cost-price-2').val();
            drp_level_3_cost_price = $('.cost-price-1 .cost-price-3').val();

            drp_level_1_price = $('.price-1 .fx-price-1').val();
            drp_level_2_price = $('.price-1 .fx-price-2').val();
            drp_level_3_price = $('.price-1 .fx-price-3').val();
        }

        //库存信息
        var skus = [];
        if (unified_price_setting == 0) {
            if ($('.sku-price-0 > .table-sku-stock > tbody > .sku').length > 0) {
                $('.sku-price-0 > .table-sku-stock > tbody > .sku').each(function(i){
                    var sku_id = $(this).attr('sku-id');

                    var cost_price = $(this).find('.js-cost-price').val();
                    var min_fx_price = $(this).find('.js-fx-min-price').val();
                    var max_fx_price = $(this).find('.js-fx-max-price').val();
                    var drp_level_1_cost_price = 0;
                    var drp_level_2_cost_price = 0;
                    var drp_level_3_cost_price = 0;
                    var drp_level_1_price = 0;
                    var drp_level_2_price = 0;
                    var drp_level_3_price = 0;
                    var properties = $(this).attr('properties');
                    skus[i] = {'sku_id': sku_id, 'cost_price': cost_price, 'min_fx_price': min_fx_price, 'max_fx_price': max_fx_price, 'properties': properties, 'drp_level_1_cost_price': drp_level_1_cost_price, 'drp_level_2_cost_price': drp_level_2_cost_price, 'drp_level_3_cost_price': drp_level_3_cost_price, 'drp_level_1_price': drp_level_1_price, 'drp_level_2_price': drp_level_2_price, 'drp_level_3_price': drp_level_3_price};
                })
            }
        } else {
            if ($('.table-sku-stock:eq(1) > tbody > .sku').length > 0) {
                $('.table-sku-stock:eq(1) > tbody > .sku').each(function(i){
                    var drp_level = $(this).closest('table').data('level');
                    var sku_id = $(this).attr('sku-id');
                    var cost_price = 0;
                    var min_fx_price = 0;
                    var max_fx_price = 0;

                    var drp_level_1_cost_price = $('.table-sku-stock-1 > tbody > .sku').eq(i).find('.js-cost-price').val();
                    var drp_level_1_price      = $('.table-sku-stock-1 > tbody > .sku').eq(i).find('.js-price').val();
                    var drp_level_2_cost_price = $('.table-sku-stock-2 > tbody > .sku').eq(i).find('.js-cost-price').val();
                    var drp_level_2_price      = $('.table-sku-stock-2 > tbody > .sku').eq(i).find('.js-price').val();
                    var drp_level_3_cost_price = $('.table-sku-stock-3 > tbody > .sku').eq(i).find('.js-cost-price').val();
                    var drp_level_3_price      = $('.table-sku-stock-3 > tbody > .sku').eq(i).find('.js-price').val();

                    var properties = $(this).attr('properties');
                    skus[i] = {'sku_id': sku_id, 'cost_price': cost_price, 'min_fx_price': min_fx_price, 'max_fx_price': max_fx_price, 'properties': properties, 'drp_level_1_cost_price': drp_level_1_cost_price, 'drp_level_2_cost_price': drp_level_2_cost_price, 'drp_level_3_cost_price': drp_level_3_cost_price, 'drp_level_1_price': drp_level_1_price, 'drp_level_2_price': drp_level_2_price, 'drp_level_3_price': drp_level_3_price};
                })
            }
        }

        var min_fx_price = $("input[name='fx-min-price']").val();
        var max_fx_price = $("input[name='fx-max-price']").val();
        var is_recommend = 0;
        var is_edit_name = 0;
        var is_edit_desc = 0;
        if ($("input[name='is_recommend']:checked").length) {
            var is_recommend = $("input[name='is_recommend']:checked").val();
        }
        if ($("input[name='is_edit_name']:checked").length) {
            var is_edit_name = $("input[name='is_edit_name']:checked").val();
        }
        if ($("input[name='is_edit_desc']:checked").length) {
            var is_edit_desc = $("input[name='is_edit_desc']:checked").val();
        }
        var product_id = $(this).attr('data-product-id');
        $.post(fx_url, {'product_id': product_id, 'cost_price': cost_price, 'min_fx_price': min_fx_price, 'max_fx_price': max_fx_price, 'is_recommend': is_recommend, 'is_recommend': is_recommend, 'is_recommend': is_recommend, 'is_edit_name': is_edit_name, 'is_edit_desc': is_edit_desc, 'skus': skus, 'drp_level_1_cost_price': drp_level_1_cost_price, 'drp_level_2_cost_price': drp_level_2_cost_price, 'drp_level_3_cost_price': drp_level_3_cost_price, 'drp_level_1_price': drp_level_1_price, 'drp_level_2_price': drp_level_2_price, 'drp_level_3_price': drp_level_3_price, 'unified_price_setting': unified_price_setting}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">商品保存成功</div>');
                t = setTimeout('msg_hide(true, "' + data.err_msg + '")', 1000);
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                t = setTimeout('msg_hide(false, "")', 3000);
            }
        })
    })

    //库存价格
    $(".js-fx-min-price").live('focus', function(){
        $(this).parent('td').removeClass('manual-valid-error');
        $(this).next('.js-fx-max-price').next('.error-message').remove();
    })
    $(".js-fx-min-price").live('blur', function(){
        var min_fx_price = parseFloat($(this).data('min-price'));
        var max_fx_price = parseFloat($(this).next('.js-fx-max-price').data('max-price'));
        var tmp_price = parseFloat($(this).val());
        var cost_price = parseFloat($(this).closest('td').prev('td').find('.js-cost-price').val());
        var flag = false;
        if ($('.error-message').length > 0) {
            flag = true;
        }
        $(this).parent('td').removeClass('manual-valid-error');
        $(this).next('.js-fx-max-price').next('.error-message').remove();
        if (isNaN(tmp_price)) {
            $(this).parent('td').addClass('manual-valid-error');
            $(this).next('input').after('<div class="error-message">价格有误</div>');
            return false;
        } else if (cost_price > tmp_price) {
            $(this).parent('td').addClass('manual-valid-error');
            $(this).next('input').after('<div class="error-message">分销价不能低于成本价</div>');
            return false
        } else if (parseFloat(tmp_price) > parseFloat($(this).next('.js-fx-max-price').val())) {
            $(this).parent('td').addClass('manual-valid-error');
            $(this).next('input').after('<div class="error-message">无效的价格区间</div>');
            return false;
        } else if (min_fx_price > 0 && max_fx_price > 0) {
            if (parseFloat(tmp_price) < min_fx_price || parseFloat(tmp_price) > max_fx_price) {
                $(this).parent('td').addClass('manual-valid-error');
                $(this).next('input').after('<div class="error-message">价格区间￥' + min_fx_price + ' - ' + max_fx_price + '</div>');
                return false;
            }
        }
        if (flag) {
            $(this).next('.js-fx-max-price').trigger('blur');
        } else {
            min_price[0].push($(this).val());
            $("input[name='fx-min-price']").val(Math.min.apply(null, min_price[0]));
        }
    })
    $(".js-fx-max-price").live('focus', function(){
        $(this).parent('td').removeClass('manual-valid-error');
        $(this).next('.error-message').remove();
    })
    $(".js-fx-max-price").live('blur', function(){
        var min_fx_price = parseFloat($(this).prev('.js-fx-min-price').data('min-price'));
        var max_fx_price = parseFloat($(this).data('max-price'));
        var tmp_price = $(this).val();
        var flag = false;
        if ($('.error-message').length > 0) {
            flag = true;
        }
        $(this).parent('td').removeClass('manual-valid-error');
        $(this).next('.error-message').remove();
        if (isNaN(tmp_price)) {
            $(this).parent('td').addClass('manual-valid-error');
            $(this).after('<div class="error-message">价格有误</div>');
            return false;
        } else if (parseFloat(tmp_price) < parseFloat($(this).prev('.js-fx-min-price').val())) {
            $(this).parent('td').addClass('manual-valid-error');
            $(this).after('<div class="error-message">无效的价格区间</div>');
            return false;
        } else if (min_fx_price > 0 && max_fx_price > 0) {
            if (parseFloat(tmp_price) < min_fx_price || parseFloat(tmp_price) > max_fx_price) {
                $(this).parent('td').addClass('manual-valid-error');
                $(this).after('<div class="error-message">价格区间￥' + min_fx_price + ' - ' + max_fx_price + '</div>');
                return false;
            }
        }
        if (flag) {
            $(this).prev('.js-fx-min-price').trigger('blur');
        } else {
            max_price[0].push($(this).val());
            $("input[name='fx-max-price']").val(Math.max.apply(null, max_price[0]));
        }
    })

    $("input[name='cost_price']").live('blur', function(){
        $(this).closest('.control-group').removeClass('manual-valid-error');
        $(this).next('.error-message').remove();
        var cost_price = $(this).val();
        var fx_min_price = $("input[name='fx-min-price']").val();
        if (fx_min_price != '' && fx_min_price != undefined) {
            fx_min_price = parseFloat(fx_min_price);
        } else {
            fx_min_price = 0;
        }
        if (isNaN(cost_price)) {
            $(this).closest('.control-group').addClass('manual-valid-error');
            $(this).after('<div class="error-message">价格有误</div>');
            return false;
        } else if (fx_min_price > 0 && parseFloat(cost_price) > fx_min_price) {
            $(this).closest('.control-group').addClass('manual-valid-error');
            $(this).after('<div class="error-message">分销价不能低于成本价</div>');
            return false;
        }
    })

    $("input[name='fx-min-price']").live('focus', function(){
        $(this).closest('.control-group').removeClass('manual-valid-error');
        $(this).nextAll('input').next('.error-message').remove();
    })
    $("input[name='fx-min-price']").live('blur', function(){
        var min_fx_price = parseFloat($(this).data('min-price'));
        var max_fx_price = parseFloat($(this).nextAll("input").data('max-price'));
        var tmp_price = $(this).val();
        var cost_price = $("input[name='cost_price']").val();
        if (cost_price != '' && cost_price != undefined) {
            cost_price = parseFloat(cost_price);
        } else {
            cost_price = 0;
        }
        var flag = false;
        if ($('.error-message').length > 0) {
            flag = true;
        }
        $(this).closest('.control-group').removeClass('manual-valid-error');
        $(this).nextAll('input').next('.error-message').remove();
        if (isNaN(tmp_price)) {
            $(this).closest('.control-group').addClass('manual-valid-error');
            $(this).nextAll('input').after('<div class="error-message">价格有误</div>');
        } else if (parseFloat(tmp_price) > parseFloat($(this).nextAll('input').val())) {
            $(this).closest('.control-group').addClass('manual-valid-error');
            $(this).nextAll('input').after('<div class="error-message">无效的价格区间</div>');
        } else if (min_fx_price > 0 && max_fx_price > 0) {
            if (parseFloat(tmp_price) < min_fx_price || parseFloat(tmp_price) > max_fx_price) {
                $(this).closest('.control-group').addClass('manual-valid-error');
                $(this).nextAll('input').after('<div class="error-message">价格区间￥' + min_fx_price + ' - ' + max_fx_price + '</div>');
            }
        } else if (cost_price > 0 && cost_price > parseFloat(tmp_price)) {
            $(this).closest('.control-group').addClass('manual-valid-error');
            $(this).nextAll('input').after('<div class="error-message">分销价不能低于成本价</div>');
        }
        if (flag) {
            $(this).nextAll("input").trigger('blur');
        }
    })
    $("input[name='fx-max-price']").live('focus', function(){
        $(this).closest('.control-group').removeClass('manual-valid-error');
        $(this).next('.error-message').remove();
    })
    $("input[name='fx-max-price']").live('blur', function(){
        var min_fx_price = parseFloat($(this).prevAll('input').data('min-price'));
        var max_fx_price = parseFloat($(this).data('max-price'));
        var tmp_price = $(this).val();
        var flag = false;
        if ($('.error-message').length > 0) {
            flag = true;
        }
        $(this).closest('.control-group').removeClass('manual-valid-error');
        $(this).next('.error-message').remove();
        if (isNaN(tmp_price)) {
            $(this).closest('.control-group').addClass('manual-valid-error');
            $(this).after('<div class="error-message">价格有误</div>');
        } else if (parseFloat(tmp_price) < parseFloat($(this).prevAll('input').val())) {
            $(this).closest('.control-group').addClass('manual-valid-error');
            $(this).after('<div class="error-message">无效的价格区间</div>');
        } else if (min_fx_price > 0 && max_fx_price > 0) {
            if (parseFloat(tmp_price) < min_fx_price || parseFloat(tmp_price) > max_fx_price) {
                $(this).closest('.control-group').addClass('manual-valid-error');
                $(this).after('<div class="error-message">价格区间￥' + min_fx_price + ' - ' + max_fx_price + '</div>');
            }
        }
        if (flag) {
            $(this).prevAll("input").trigger('blur');
        }
    })
    $('.js-btn-cancel').live('click', function(){
        window.history.go(-1);
    })

    $('.unified-price-setting').live('click', function() {
        if ($(this).val() == 1) {
            $('.cost-price-1').removeClass('hide');
            $('.cost-price-0').addClass('hide');

            $('.sku-price-1').removeClass('hide');
            $('.sku-price-0').addClass('hide');

            $('.price-1').removeClass('hide');
            $('.price-0').addClass('hide');
        } else {
            $('.cost-price-0').removeClass('hide');
            $('.cost-price-1').addClass('hide');

            $('.sku-price-0').removeClass('hide');
            $('.sku-price-1').addClass('hide');

            $('.price-0').removeClass('hide');
            $('.price-1').addClass('hide');
        }
    })
});

function msg_hide(redirect, url) {
    if (redirect) {
        window.location.href = url;
    }
    $('.notifications').html('');
    clearTimeout(t);
}