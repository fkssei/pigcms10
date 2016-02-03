$(function(){
	load_page('.app__content',load_url,{page:'edit_goods_content', 'id': product_id},function(){});

    //批量设置
    $('.js-batch-price').live('click',function(){
        if ($("input[name='cost_price']").val() == '' || $("input[name='cost_price']").val() == 0) {
            layer_tips(1,'您还没有设置成本价');
            return false;
        }
        $('.js-batch-form').html('<input type="text" class="fx-min-price input-mini" placeholder="分销最低价" /> - <input type="text" class="fx-max-price input-mini" placeholder="分销最高价" /> <a class="js-batch-save" href="javascript:;">保存</a> <a class="js-batch-cancel" href="javascript:;">取消</a><p class="help-desc"></p>');
        $('.js-batch-form').show();
        $('.js-batch-type').hide();
        $('.fx-min-pricet').focus();
    });

    $('.js-batch-save').live('click',function(){
        if ($("input[name='cost_price']").val() == '' || $("input[name='cost_price']").val() == 0) {
            layer_tips(1,'您还没有设置成本价');
            return false;
        }
        var fx_min_price = parseFloat($('.fx-min-price').val());
        var fx_max_price = parseFloat($('.fx-max-price').val());
        if(fx_min_price > 9999999.99){
            layer_tips(1,'价格最大为 9999999.99');
            $('.fx-min-price').focus();
            return false;
        } else if (fx_max_price < 0.01) {
            layer_tips(1,'价格最小为 0.01');
            $('.fx-max-price').focus();
            return false;
        } else if(!/^\d+(\.\d+)?$/.test($('.fx-min-price').val())){
            layer_tips(1,'请输入合法的价格');
            $('.fx-min-price').focus();
            return false;
        } else if (!/^\d+(\.\d+)?$/.test($('.fx-max-price').val())) {
            layer_tips(1,'请输入合法的价格');
            $('.fx-max-price').focus();
            return false;
        } else if (fx_min_price < parseFloat($("input[name='cost_price']").val())) {
            layer_tips(1,'分销价格不能低于成本价格');
            $('.fx_min_price').focus();
            return false;
        } else if (fx_min_price > fx_max_price) {
            layer_tips(1,'无效的价格区间');
            $('.fx-max-price').focus();
            return false;
        } else{
            $('.fx-min-price').val(fx_min_price.toFixed(2));
            $('.fx-max-price').val(fx_max_price.toFixed(2));
        }
        $('.js-fx-min-price').val($('.fx-min-price').val());
        $('.js-fx-max-price').val($('.fx-max-price').val());

        //商品价格
        $("input[name='fx-min-price']").val(fx_min_price.toFixed(2));
        $("input[name='fx-min-price']").attr('readonly', true);

        $("input[name='fx-max-price']").val(fx_max_price.toFixed(2));
        $("input[name='fx-max-price']").attr('readonly', true);

        $('.fx-min-price').val('');
        $('.fx-max-price').val('');

        $('.js-batch-form').hide();
        $('.js-batch-type').show();
    });

    $('.js-cost-price').live('blur', function(){
        if (isNaN($(this).val())) {
            layer_tips(1,'请输入合法的价格');
            $(this).val('');
            $(this).focus();
        }
    })

    $('.js-batch-cancel').live('click',function(){
        $('.js-batch-form').hide();
        $('.js-batch-form').html('');
        $('.js-batch-type').show();
    });

    $('.js-btn-save').live('click', function(){
        var cost_price = $("input[name='cost_price']").val();
        if (!/^\d+(\.\d+)?$/.test(cost_price) || cost_price < 0.01) {
            layer_tips(1,'请输入合法的成本价格');
            $("input[name='cost_price']").focus();
            return false;
        }
        var num = $('.js-cost-price').length;
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

        var cost_price = $("input[name='cost_price']").val();
        //库存信息
        var skus = [];
        if ($('.table-sku-stock > tbody > .sku').length > 0) {
            $('.table-sku-stock > tbody > .sku').each(function(i){
                var sku_id = $(this).attr('sku-id');
                var cost_price = $(this).find('.js-cost-price').val();
                var min_fx_price = $(this).find('.js-fx-min-price').val();
                var max_fx_price = $(this).find('.js-fx-max-price').val();
                var properties = $(this).attr('properties');
                skus[i] = {'sku_id': sku_id, 'cost_price': cost_price, 'min_fx_price': min_fx_price, 'max_fx_price': max_fx_price, 'properties': properties};
            })
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
        $.post(fx_url, {'product_id': product_id, 'cost_price': cost_price, 'min_fx_price': min_fx_price, 'max_fx_price': max_fx_price, 'is_recommend': is_recommend, 'is_recommend': is_recommend, 'is_recommend': is_recommend, 'is_edit_name': is_edit_name, 'is_edit_desc': is_edit_desc, 'skus': skus}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">商品保存成功</div>');
                t = setTimeout('msg_hide(true, "' + data.err_msg + '")', 1000);
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                t = setTimeout('msg_hide(false, "")', 3000);
            }
        })
    })

    $('.js-btn-cancel').live('click', function(){
        window.history.go(-1);
    })
});

function msg_hide(redirect, url) {
    if (redirect) {
        window.location.href = url;
    }
    $('.notifications').html('');
    clearTimeout(t);
}