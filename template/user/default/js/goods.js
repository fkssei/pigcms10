$(function(){
	load_page('.app__content',load_url,{page: page_content},'');

    //分页
    $('.js-page-list > a').live('click', function(e){
        var p = $(this).attr('data-page-num');
        var orderbyfield = '';
        var orderbymethod = '';
        var index = 0;
        //保留排序
        $('.orderby').each(function(i){
            if ($(this).children('span').length > 0) {
                index = i;
                orderbyfield = $(this).attr('data-orderby');
                if ($(this).children('span').hasClass('desc')) {
                    orderbymethod = 'desc';
                }
                if ($(this).children('span').hasClass('asc')) {
                    orderbymethod = 'asc';
                }
            }
        })
        //保留分组
        var group_id = '';
        var group = '';
        if ($('.chosen-single').attr('group-id') != '') {
            group_id = $('.chosen-single').attr('group-id');
            group = $('.chosen-single > span').text();
        }
        //保留关键字
        var keyword = '';
        if ($('.js-list-search > .txt').val() != '') {
            keyword = $('.js-list-search > .txt').val();
        }
        $('.app__content').load(load_url, {page: page_content, 'p': p, 'keyword': keyword, 'group_id': group_id, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod}, function(){
            if (group != '') {
                $('.chosen-single > span').text(group);
            }
            if (keyword != '') {
                $('.js-list-search > .txt').val(keyword);
            }
            $('.orderby').children('span').remove();
            if (orderbymethod == 'asc') {
                $('.orderby').eq(index).append('<span class="orderby-arrow asc"></span>');
            } else {
                $('.orderby').eq(index).append('<span class="orderby-arrow desc"></span>');
            }
        });
    })

    //排序
    $('.orderby').live('click', function(e){
        var index = $(this).index('.orderby');
        var orderbyfield = $(this).attr('data-orderby');
        if ($(this).children('span').length > 0) {
            if ($(this).children('span').hasClass('desc')) {
                var orderbymethod = 'asc';
            } else {
                var orderbymethod = 'desc';
            }
        } else {
            var orderbymethod = 'desc';
        }
        $('.app__content').load(load_url, {page: page_content, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod}, function(){
            if (orderbymethod == 'asc') {
                $('.orderby').children('span').remove();
                $('.orderby').eq(index).append('<span class="orderby-arrow asc"></span>');
            } else {
                $('.orderby').children('span').remove();
                $('.orderby').eq(index).append('<span class="orderby-arrow desc"></span>');
            }
        });
    })

    //全选
    $('.js-check-all').live('click', function(){
        if ($(this).is(':checked')) {
            $('.js-check-toggle').attr('checked', true);
        } else {
            $('.js-check-toggle').attr('checked', false);
        }
    })

    //批量修改分组
    $('.js-batch-tag').live('click', function(){
        if (product_groups_json != '') {
            var product_groups = $.parseJSON(product_groups_json);
        } else {
            var product_groups = '';
        }
        var list = '';
        if (product_groups != '') {
            for(group in product_groups) {
                list += '<li data-id="' + product_groups[group]['group_id'] + '" class="clearfix"><span class="js-category-check category-check category-check-none"></span><span class="category-title">' + product_groups[group]['group_name'] + '</span></li>';
            }
        }
        if (list == '') {
            list = '<span style="color:red">没有商品分组！</span>';
        }
        if ($('.js-check-toggle:checked').length == 0) {
            $('.notifications').html('');
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择商品</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        $('body').children('.popover').remove();
        var html = '<div class="popover bottom" style="display: block; top: ' + ($(this).offset().top + $(this).height()) + 'px; left: ' + ($(this).offset().left - $(this).width() - 5) + 'px;"><div class="arrow"></div><div class="popover-inner popover-category2"><div class="popover-header clearfix">修改分组<a href="' + goods_group_url + '" target="_blank" class="pull-right">管理</a></div><div class = "popover-content" ><ul class="popover-content-categories js-popover-content-categories">' + list + '</ul></div><div class="popover-footer"><a href="javascript:;" class="ui-btn ui-btn-primary js-btn-confirm">保存</a><a href="javascript:;" class="ui-btn js-btn-cancel">取消</a></div></div></div>';
        $('body').append(html);
    })

    //选择分组
    $('.js-popover-content-categories > li').live('click', function(e){
        if ($(this).children('.js-category-check').hasClass('category-check-all')) {
            $(this).children('.js-category-check').removeClass('category-check-all').addClass('category-check-none');
        } else {
            $(this).children('.js-category-check').removeClass('category-check-none').addClass('category-check-all');
        }
    });

    //关闭提示窗
    $('.close').live('click', function(e){
        $('.notifications').html('');
        $('.notify-backdrop').remove();
    })

    //按esc键关闭提示窗
    $('body').live('keyup', function(){
        if(event.keyCode == 27 && $(this).has('.notify-backdrop')) {
            $('.notifications').html('');
            $('.notify-backdrop').remove();
        }
    })

    //点击取消安钮，删除分组修改窗口
    $('.js-btn-cancel').live('click', function(){
        $('body').children('.popover').remove();
    })

    //点击“删除窗口”之外区域删除“删除窗口”
    $('body').click(function(e){
        var _con = $('.popover');   // 设置目标区域
        if(!_con.is(e.target) && _con.has(e.target).length === 0){ // Mark 1
            $('.popover').remove();
        }
    })

    //下架
    $('.js-batch-unload').live('click', function(e){
        if ($('.js-check-toggle:checked').length == 0) {
            $('.notifications').html('');
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择商品</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        button_box($(this), e, 'right', 'confirm', '确认下架？', function(){
            var product_id = [];
            $('.js-check-toggle:checked').each(function(i){
                product_id[i] = $(this).val();
            });
            $.post(soldout_url, {'product_id': product_id}, function(data){
                $('.notifications').html('');
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
                close_button_box();
                if ($('.js-page-list > .active').length > 0) {
                    var p = $('.js-page-list > .active').attr('data-page-num');
                } else {
                    var p = 1;
                }
                var orderbyfield = '';
                var orderbymethod = '';
                var index = 0;
                //保留排序
                $('.orderby').each(function(i){
                    if ($(this).children('span').length > 0) {
                        index = i;
                        orderbyfield = $(this).attr('data-orderby');
                        if ($(this).children('span').hasClass('desc')) {
                            orderbymethod = 'desc';
                        }
                        if ($(this).children('span').hasClass('asc')) {
                            orderbymethod = 'asc';
                        }
                    }
                })
                $('.app__content').load(load_url, {page: page_content, 'p': p, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod}, function(){
                    $('.orderby').children('span').remove();
                    if (orderbymethod == 'asc') {
                        $('.orderby').eq(index).append('<span class="orderby-arrow asc"></span>');
                    } else {
                        $('.orderby').eq(index).append('<span class="orderby-arrow desc"></span>');
                    }
                });
            });
        });
    })

    //上架
    $('.js-batch-load').live('click', function(e){
        if ($('.js-check-toggle:checked').length == 0) {
            $('.notifications').html('');
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择商品</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        button_box($(this), e, 'right', 'confirm', '确认上架？', function(){
            var product_id = [];
            $('.js-check-toggle:checked').each(function(i){
                product_id[i] = $(this).val();
            });
            $.post(putaway_url, {'product_id': product_id}, function(data){
                $('.notifications').html('');
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
                close_button_box();
                if ($('.js-page-list > .active').length > 0) {
                    var p = $('.js-page-list > .active').attr('data-page-num');
                } else {
                    var p = 1;
                }
                var orderbyfield = '';
                var orderbymethod = '';
                var index = 0;
                //保留排序
                $('.orderby').each(function(i){
                    if ($(this).children('span').length > 0) {
                        index = i;
                        orderbyfield = $(this).attr('data-orderby');
                        if ($(this).children('span').hasClass('desc')) {
                            orderbymethod = 'desc';
                        }
                        if ($(this).children('span').hasClass('asc')) {
                            orderbymethod = 'asc';
                        }
                    }
                })
                $('.app__content').load(load_url, {page: page_content, 'p': p, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod}, function(){
                    $('.orderby').children('span').remove();
                    if (orderbymethod == 'asc') {
                        $('.orderby').eq(index).append('<span class="orderby-arrow asc"></span>');
                    } else {
                        $('.orderby').eq(index).append('<span class="orderby-arrow desc"></span>');
                    }
                });
            });
        });
    })

    //批量删除商品
    $('.js-batch-delete').live('click', function(e){
        if ($('.js-check-toggle:checked').length == 0) {
            $('.notifications').html('');
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择商品</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        var product_id = [];
        $('.js-check-toggle:checked').each(function(i){
            product_id[i] = $(this).val();
        })
        button_box($(this), e, 'right', 'confirm', '确认删除？', function(){
            $.post(del_product_url, {'product_id': product_id}, function(data) {
                close_button_box();
                t = setTimeout('msg_hide()', 3000);
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    load_page('.app__content',load_url,{page: page_content},'');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
            })
        });
    })

    //删除单个商品
    $('.js-delete').live('click', function(e){
        var product_id = $(this).attr('data');
        $('.js-delete').addClass('active');
        button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
            $.post(del_product_url, {'product_id': product_id}, function(data) {
                close_button_box();
                t = setTimeout('msg_hide()', 3000);
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    load_page('.app__content',load_url,{page: page_content},'');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
            })
        });
    })

    //会员折扣
    $('.js-batch-discount').live('click', function(e){
        if ($('.js-check-toggle:checked').length == 0) {
            $('.notifications').html('');
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择商品</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        button_box($(this), e, 'top', 'radio', '<label class="radio"><input type="radio" name="discount" value="1" checked="">参与</label><label class="radio"><input type="radio" name="discount" value="0">不参与</label>', function(){
            var product_id = [];
            $('.js-check-toggle:checked').each(function(i){
                product_id[i] = $(this).val();
            });
            var discount = $("input[name='discount']:checked").val();
            $.post(allow_discount_url, {'product_id': product_id, 'discount': discount}, function(data){
                $('.notifications').html('');
                if (!data.err_code) {
                    if (discount == 1) {
                        $('.notifications').html('<div class="alert in fade alert-success">商品已参与会员折扣</div>');
                    } else if (discount == 0) {
                        $('.notifications').html('<div class="alert in fade alert-success">商品已取消参与会员折扣</div>');
                    }
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">不要重复操作</div>');
                }
                t = setTimeout('msg_hide()', 3000);
                close_button_box();
            });
        });
    })

    //搜索框动画
    $('.ui-search-box :input').live('focus', function(){
        $(this).animate({width: '180px'}, 100);
    })
    $('.ui-search-box :input').live('blur', function(){
        $(this).animate({width: '70px'}, 100);
    })

    //回车提交搜索
    $(window).keydown(function(event){
        if (event.keyCode == 13 && $('.ui-search-box .txt').is(':focus')) {
            var keyword = $('.ui-search-box .txt').val();
            var group_id = '';
            var group = '';
            if ($('.chosen-single').attr('group-id') != '') {
                group_id = $('.chosen-single').attr('group-id');
                group = $('.chosen-single > span').text();
            }
            $('.app__content').load(load_url, {page: page_content, 'keyword': keyword, 'group_id': group_id}, function(){
                $('.chosen-single > span').text(group);
                $('.chosen-single').attr('group-id', group_id);
                $('.ui-search-box .txt').val(keyword);
            });
        }
    })

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

    //选择分组触发
    $('.active-result').live('click', function(){

    })

    $('body').click(function(e){
        var _con = $('.chosen-container');   // 设置目标区域
        if(!_con.is(e.target) && _con.has(e.target).length === 0){ // Mark 1
            if ($('.chosen-container-single').hasClass('chosen-with-drop')) {
                $('.chosen-container-single').removeClass('chosen-container-active').removeClass('chosen-with-drop');
            }
        }
    })
    $(".chosen-search input").live('keyup', function(e){
        if (event.keyCode == 38 && $('.chosen-container').hasClass('chosen-container-active')) { //向上
            if ($('.result-selected').prev('.active-result').length > 0) {
                var index = $('.result-selected').index('.active-result');
                $('.active-result').eq(index).removeClass('result-selected').removeClass('highlighted');
                $('.active-result').eq(index).prev('.active-result').addClass('result-selected').addClass('highlighted');
            }
        }
        if (event.keyCode == 40 && $('.chosen-container').hasClass('chosen-container-active')) { //向下
            if ($('.result-selected').next('.active-result').length > 0) {
                var index = $('.result-selected').index('.active-result');
                $('.active-result').eq(index).removeClass('result-selected').removeClass('highlighted');
                $('.active-result').eq(index).next('.active-result').addClass('result-selected').addClass('highlighted');
            }
        }
    })

    //推广
    var qrcode_url = '';
    var product_id = '';
    var price = '';
    var qrcode_arr = [];
    var qrcode_data = [];
    $('.js-promotion-btn').live('click', function(){
        var obj = this;
        product_id = $(this).attr('data');
        price = $(this).closest('tr').find('.goods-meta > p > .goods-price').attr('goods-price')
        var url = $(this).closest('tr').find('.goods-meta > .goods-title > a').attr('href'); //商品详细
        var buy_url = url + '&buy=1'; //直接购买
        qrcode_url = './source/qrcode.php?type=good&id=' + product_id;
        var is_fx = $(this).data('fx');
        $('body').children('.widget-promotion').remove();
        $.post(get_qrcode_activity_url, {'product_id': product_id}, function(data){
            if (!is_fx) {
                var create_qrcode_link = '<a href="javascript:;" class="js-create-qrcode qrcode-create-button">创建一个优惠二维码</a>';
            } else {
                var create_qrcode_link = '';
            }
            var li = '';
            var div = '';
            if (data) {
                var data = $.parseJSON(data);
                qrcode_data = data;
                var j = 0;
                var k = 0;
                for (i in data) {
                    if(data[i]['type'] == 0) {
                        var title = '直接折扣';
                        if (j == 1) {
                            j++;
                            title += j;
                        } else if (j > 0) {
                            title += j;
                        }
                        var desc = '扫码购买立享 ' + data[i]['discount'] + ' 折';
                        j += 1;
                    } else {
                        var title = '直接减优惠';
                        if (k == 1) {
                            k++;
                            title += k;
                        } else if (k > 0) {
                            title += k;
                        }
                        var desc = '扫码购买立减 ' + data[i]['price'] + ' 元';
                        k += 1;
                    }
                    li += '<li class="clearfix type-' + data[i]['type'] + '" data-id="' + data[i]['pigcms_id'] + '"><a href="javascript:;" class="js-delete-qrcode pull-left btn-delete-qrcode" data-id="' + data[i]['pigcms_id'] + '">删除</a>' + title + '</li>';
                    qrcode_arr[data[i]['pigcms_id']] = '<img class="loading" src="./source/qrcode.php?type=good&id=' + product_id + '&activity=' + data[i]['pigcms_id'] + '" /><p>' + desc + '</p><div class="clearfix qrcode-links"><a class="pull-left" href="./source/qrcode.php?type=good&id=' + product_id + '&activity=' + data[i]['pigcms_id'] + '" download="true" target="_blank">下载二维码</a><a class="pull-right js-edit" data-id="' + data[i]['pigcms_id'] + '" href="javascript:;">修改优惠</a></div>';
                }
            }
            var html = '<div class="widget-promotion" style="top: ' + ($(obj).offset().top - 68) + 'px; left: ' + ($(obj).offset().left - 370) + 'px;"><ul class="widget-promotion-tab clearfix js-tab"><li class="active" data-tab="qrcode">商品二维码</li><li data-tab="link">商品链接</li></ul><div class="widget-promotion-content js-tabs-content"><div class="js-link-region js-tab-content js-tab-content-link" style="display: none;"><div><div class="widget-promotion-main"><div class="alert">分享才有更多人看到哦</div><div class="widget-promotion-content"><label>商品页链接</label><div class="input-append"><input type="text" class="" readonly="true" value="' + url + '"><button type="button" class="btn js-btn-copy" data-clipboard-text="' + url + '">复制</button></div><label>直接弹出购买界面的链接</label><div class="input-append"><input type="text" class="" readonly="true" value="' + buy_url + '"><button type="button" class="btn js-btn-copy" data-clipboard-text="' + buy_url + '">复制</button></div></div></div></div></div><div class="js-qrcode-region js-tab-content js-tab-content-qrcode"><div><div class="widget-promotion-main"><div class="js-qrcode-content"><div class="alert">扫一扫，在手机上查看并分享<!--a class="new-window qrcode-help pull-right" href="#" target="_blank">帮助</a--></div><div class="qrcode-content"><div class="qrcode-left-sidebar js-qrcode-left-sidebar"><div class="qrcode-left-lists"><ul><li class="clearfix active" data-id="-1">直接购买商品</li><!--<li class="clearfix" data-id="-2">关注后购买商品</li>-->' + li + '</ul></div>' + create_qrcode_link + '</div><div class="qrcode-right-sidebar js-qrcode-right-sidebar"><div class="text-center"><img class="loading" src="' + qrcode_url + '" /><p>扫码后直接访问商品</p><div class="clearfix qrcode-links"><a class="pull-left" download="" href="' + qrcode_url + '" target="_blank">下载二维码</a></div></div></div></div></div><div class="qrcode-create-content js-qrcode-create-content"></div></div></div></div></div></div>';
            $('body').append(html);
            if (data.length >= 3) {
                $('.js-create-qrcode').hide();
            }
        })
    })

    //商品链接
    $('.js-tab > li').live('click', function(){
        $(this).addClass('active');
        $(this).siblings('li').removeClass('active');
        var type = $(this).attr('data-tab');
        $('.js-tabs-content > .js-tab-content-' + type).show();
        $('.js-tabs-content > .js-tab-content-' + type).siblings('.js-tab-content').hide();
        if (type == 'link') {
            $.getScript('./static/js/plugin/jquery.zclip.min.js',function() {
                $('.js-btn-copy').each(function(i) {
                    var content = $(this).attr('data-clipboard-text');
                    $(this).zclip({
                        path: './static/js/plugin/ZeroClipboard.swf',
                        copy: function () {
                            return content;
                        },
                        afterCopy: function () {
                            $('.notifications').html('<div class="alert in fade alert-success">复制成功</div>');
                            t = setTimeout('msg_hide()', 3000);
                        }
                    });
                })
            })
        }
    })

    //商品二维码
    $('.qrcode-left-lists > ul > li').live('click', function(){
        qrcode_arr[-1] = '<div class="text-center"><img class="loading" src="' + qrcode_url + '" /><p>扫码后直接访问商品</p><div class="clearfix qrcode-links"><a class="pull-left" download="" target="_blank" href="' + qrcode_url + '">下载二维码</a></div></div>';
        qrcode_arr[-2] = '你需要将微信公众号升级成为微信认证的服务号，才能够获得该类型的商品二维码。'
        $(this).addClass('active');
        $(this).siblings('li').removeClass('active');
        var index = $(this).attr('data-id');
        $('.js-qrcode-right-sidebar > .text-center').html(qrcode_arr[index]);
    })

    //创建优惠二维码
    var qrcode_region = '';
    $('.js-create-qrcode').live('click', function(){
        qrcode_region = $('.js-tab-content-qrcode').html();
        var html = '<div><div class="widget-promotion-main"><div class="js-qrcode-content hide"><div class="alert">扫一扫，在手机上查看并分享<a class="new-window qrcode-help pull-right" href="#" target="_blank">帮助</a></div><div class="qrcode-content"><div class="qrcode-left-sidebar js-qrcode-left-sidebar"><div class="qrcode-left-lists"><ul><li class="clearfix">直接购买商品</li><li class="clearfix active">关注后购买商品</li></ul></div><a href="javascript:;" class="js-create-qrcode qrcode-create-button">创建一个优惠二维码</a></div><div class="qrcode-right-sidebar js-qrcode-right-sidebar"><div class="text-center"><p class="text-left">你需要将微信公众号升级成为微信认证的服务号，才能够获得该类型的商品二维码。</p></div></div></div></div><div class="qrcode-create-content js-qrcode-create-content"><form novalidate="" class="form-horizontal qrcode-form-create"><div class="control-group"><label class="control-label">购买方式：</label><div class="controls"><select name="buy_type" class="input-medium"><option value="0" selected="true">扫码直接购买</option></select><p class="qrcode-text js-qrcode-text-0 ">*由商品链接直接生成二维码。</p></div></div><div class="control-group"><label class="control-label">优惠方式：</label><div class="controls"><label class="radio inline"><input type="radio" name="type" value="0" checked="">扫码折扣</label><label class="radio inline"><input type="radio" name="type" value="1">扫码可减优惠</label></div></div><div class="js-coupon-0"><div class="control-group"><label class="control-label">扫码折扣：</label><div class="controls"><div class="input-append"><input type="text" name="discount" class="input input-mini js-price" data-fixed="1" value=""><span class="add-on">折</span></div></div></div><div class="control-group"><label class="control-label">折后价：</label><div class="controls"><div class="control-action">￥<span class="js-final-price">' + price + '</span> 元</div></div></div></div><div class="js-coupon-1 hide"><div class="control-group"><label class="control-label">扫码优惠：</label><div class="controls"><div class="input-prepend"><span class="add-on">-￥</span><input type="text" name="price" class="input input-mini js-price" value=""></div></div></div><div class="control-group" style="margin-top: 20px;"></div></div><div class="control-group"><div class="controls"><button type="submit" class="ui-btn ui-btn-primary js-submit-btn" data-loading-text="保 存...">保 存</button> <button type="cancel" class="ui-btn js-cancel-btn">取 消</button></div></div></form></div></div></div>';
        $('.js-tab-content-qrcode').html(html);
    })

    //修改活动
    $('.qrcode-links > .js-edit').live('click', function(){
        qrcode_region = $('.js-tab-content-qrcode').html();
        var activity_id = $(this).attr('data-id');
        for(i in qrcode_data) {
            if (qrcode_data[i]['pigcms_id'] == activity_id) {
                var html = '<div><div class="widget-promotion-main"><div class="js-qrcode-content hide"><div class="alert">扫一扫，在手机上查看并分享<a class="new-window qrcode-help pull-right" href="#" target="_blank">帮助</a></div><div class="qrcode-content"><div class="qrcode-left-sidebar js-qrcode-left-sidebar"><div class="qrcode-left-lists"><ul><li class="clearfix">直接购买商品</li><li class="clearfix active">关注后购买商品</li></ul></div><a href="javascript:;" class="js-create-qrcode qrcode-create-button">创建一个优惠二维码</a></div><div class="qrcode-right-sidebar js-qrcode-right-sidebar"><div class="text-center"><p class="text-left">你需要将微信公众号升级成为微信认证的服务号，才能够获得该类型的商品二维码。</p></div></div></div></div><div class="qrcode-create-content js-qrcode-create-content"><form novalidate="" class="form-horizontal qrcode-form-create">';
                html += '<div class="control-group"><label class="control-label">购买方式：</label><div class="controls"><select disabled="true" name="buy_type" class="input-medium">';
                if (qrcode_data[i]['buy_type'] == 0) {
                    html += '<option value="0" selected="true">扫码直接购买</option>';
                } else {
                    html += '<option value="0">扫码直接购买</option>';
                }
                html += '</select><p class="qrcode-text js-qrcode-text-0 ">*由商品链接直接生成二维码。</p></div></div>';
                html += '<div class="control-group"><label class="control-label">优惠方式：</label><div class="controls"><label class="radio inline">';
                if (qrcode_data[i]['type'] == 0) {
                    html += '<input type="radio" name="type" value="0" checked="true" disabled="true" />扫码折扣';
                } else {
                    html += '<input type="radio" name="type" value="0" disabled="true" />扫码折扣';
                }
                html += '</label><label class="radio inline">';
                if (qrcode_data[i]['type'] == 1) {
                    html += '<input type="radio" name="type" value="1" checked="true" disabled="true" />扫码可减优惠';
                } else {
                    html += '<input type="radio" name="type" value="1" disabled="true" />扫码可减优惠';
                }
                html += '</label></div></div>';
                var hide = 'hide';
                var tmp_total = price;
                var tmp_discount = '';
                if (qrcode_data[i]['type'] == 0) {
                    if (qrcode_data[i]['discount'] > 0) {
                        tmp_total = (price * (qrcode_data[i]['discount'] / 10)).toFixed(2);
                    }
                    if (qrcode_data[i]['discount'] > 0) {
                        tmp_discount = qrcode_data[i]['discount'];
                    }
                    hide = '';
                }
                html += '<div class="js-coupon-0 ' + hide + '"><div class="control-group"><label class="control-label">扫码折扣：</label><div class="controls"><div class="input-append"><input type="text" name="discount" class="input input-mini js-price" data-fixed="1" value="' + tmp_discount + '" /><span class="add-on">折</span></div></div></div><div class="control-group"><label class="control-label">折后价：</label><div class="controls"><div class="control-action">￥<span class="js-final-price">' + tmp_total + '</span> 元</div></div></div></div>';
                hide = 'hide';
                var tmp_price = '';
                if (qrcode_data[i]['type'] == 1) {
                    if (qrcode_data[i]['price'] > 0) {
                        tmp_price = qrcode_data[i]['price'];
                    }
                    hide = '';
                }
                html += '<div class="js-coupon-1 ' + hide + '"><div class="control-group"><label class="control-label">扫码优惠：</label><div class="controls"><div class="input-prepend"><span class="add-on">-￥</span><input type="text" name="price" class="input input-mini js-price" value="' + tmp_price + '" /></div></div></div><div class="control-group" style="margin-top: 20px;"></div></div>';

                html += '<div class="control-group"><div class="controls"><button type="submit" class="ui-btn ui-btn-primary js-submit-btn" data-id="' + activity_id + '" data-loading-text="保 存...">保 存</button> <button type="cancel" class="ui-btn js-cancel-btn">取 消</button></div></div></form></div></div></div>';
                $('.js-tab-content-qrcode').html(html);
            }
        }
    })

    //取消创建优惠二维码
    $('.controls > .js-cancel-btn').live('click', function(){
        $('.js-tab-content-qrcode').html(qrcode_region);
        return false;
    })

    //优惠方式切换
    $(".radio > input[name='type']").live('click', function(e) {
        if ($(this).val() == 0) {
            $('.js-coupon-0').removeClass('hide');
            $('.js-coupon-1').addClass('hide');
        } else {
            $('.js-coupon-1').removeClass('hide');
            $('.js-coupon-0').addClass('hide');
        }
    });

    //点击“删除窗口”之外区域删除“删除窗口”
    $('body').click(function(e){
        var _con = $('.widget-promotion');   // 设置目标区域
        if(!_con.is(e.target) && _con.has(e.target).length === 0){ // Mark 1
            $('.widget-promotion').remove();
        }
    })

    //点击图片选中复选框
    $('.goods-image-td').live('click', function(){
        if ($(this).prev('.checkbox').children('.js-check-toggle').attr('checked')) {
            $(this).prev('.checkbox').children('.js-check-toggle').attr('checked', false);
        } else {
            $(this).prev('.checkbox').children('.js-check-toggle').attr('checked', true);
        }
    })

    //商品分组修改
    $('.popover-category2 > .popover-footer > .js-btn-confirm').live('click', function(){
        if ($('.category-check-all').length == 0) {
            $('.notifications').html('<div class="alert in fade alert-error">没有选择分组</div>');
            t = setTimeout('msg_hide()', 3000);
            return false;
        }
        var data = [];
        $('.js-check-toggle:checked').each(function(i){
            var product_id = $(this).val();
            var group_id = [];
            $('.category-check-all').each(function(j){
                group_id[j] = $(this).closest('li').attr('data-id');
            })
            group_id = group_id.join(',');
            if (group_id != '' && product_id > 0) {
                data[i] = {'product_id': product_id, 'group_id': group_id};
            }
        })
        $.post(edit_group_url, {'data': data}, function(data) {
            if (!data.err_code) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
            $('.js-check-toggle:checked').attr('checked', false);
            $('.popover-category2').closest('.popover').remove();
        })
    })

    //商品分组筛选
    $('.active-result').live('click', function(){
        var keyword = '';
        var group_id = $(this).attr('data-option-array-index');
        var group = $(this).text();
        if ($('.js-list-search > .txt').val() != '') {
            keyword = $('.js-list-search > .txt').val();
        }
        $('.chosen-single > span').text(group);
        $(this).closest('.chosen-container').removeClass('chosen-container-active chosen-with-drop');
        $('.app__content').load(load_url, {page: page_content, 'keyword': keyword, 'group_id': group_id}, function(){
            $('.chosen-single > span').text(group);
            $('.chosen-single').attr('group-id', group_id);
            if (keyword != ''){
                $('.js-list-search > .txt').val(keyword);
            }
        });
    })

    $(window).keydown(function(event){
        if (event.keyCode == 13 && $('.result-selected').length && $('.result-selected').closest('.chosen-container').hasClass('chosen-container-active')) {
            var keyword = '';
            var group_id = $('.result-selected').attr('data-option-array-index');
            var group = $('.result-selected').text();
            if ($('.js-list-search > .txt').val() != '') {
                keyword = $('.js-list-search > .txt').val();
            }
            $('.result-selected').closest('.chosen-container').removeClass('chosen-container-active chosen-with-drop');
            $('.app__content').load(load_url, {page: page_content, 'keyword': keyword, 'group_id': group_id}, function(){
                $('.chosen-single > span').text(group);
                $('.chosen-single').attr('group-id', group_id);
                if (keyword != ''){
                    $('.js-list-search > .txt').val(keyword);
                }
            });
        }
    })

    //扫码活动保存
    $('.js-qrcode-create-content').find('.js-submit-btn').live('click', function(){
        var activity_id = '';
        if ($(this).attr('data-id') != '') {
            activity_id = $(this).attr('data-id');
        }
        var buy_type = $("select[name='buy_type'] option:selected").val();
        var type = $("input[name='type']:checked").val();
        //折扣
        var discount = 0;
        if ($("input[name='discount']:visible").length) {
            if ($("input[name='discount']").val() != ''){
                discount = $("input[name='discount']").val();
            }
            $("input[name='discount']").closest('.control-group').removeClass('error');
            $("input[name='discount']").parent('.input-append').next('.error-message').remove();
            if (isNaN(discount) || parseFloat(discount) < 0.1 || parseFloat(discount) > 9.9) {
                $("input[name='discount']").closest('.control-group').addClass('error');
                $("input[name='discount']").parent('.input-append').after('<p class="help-block error-message">折扣范围为 0.1 到 9.9</p>');
                return false;
            }
        }
        //优惠金额
        var amount = 0;
        if ($("input[name='price']:visible").length) {
            amount = $("input[name='price']").val();
            $("input[name='price']").closest('.control-group').removeClass('error');
            $("input[name='price']").parent('.input-prepend').next('.error-message').remove();
            if (isNaN(amount) || amount == '' || parseFloat(amount) < 0.01) {
                $("input[name='price']").closest('.control-group').addClass('error');
                $("input[name='price']").parent('.input-prepend').after('<p class="help-block error-message">优惠减免金额必须大于 0.01 元</p>');
                return false;
            }
            if (parseFloat(amount) > price) {
                $("input[name='price']").closest('.control-group').addClass('error');
                $("input[name='price']").parent('.input-prepend').after('<p class="help-block error-message">优惠减免金额 ' + amount + ' 不能高于商品最低价格</p>');
                return false;
            }
        }

        $.post(save_qrcode_activity_url, {'product_id': product_id, 'buy_type': buy_type, 'type': type, 'discount': discount, 'price': amount, 'activity_id': activity_id}, function(data){
            var data = $.parseJSON(data);
            if (data.code) {
                var li = '';
                if(data.data.type == 0) {
                    var title = '直接折扣';
                    var desc = '扫码购买立享 ' + data.data.discount + ' 折';
                } else {
                    var title = '直接减优惠';
                    var desc = '扫码购买立减 ' + data.data.price + ' 元';
                }
                $('.js-tab-content-qrcode').html(qrcode_region);
                if (data.type == 'add') {
                    qrcode_data[qrcode_data.length] = data.data;
                    if ($('.type-' + data.data.type).length > 0) {
                        title += ($('.type-' + data.data.type).length + 1);
                    }
                    li = '<li class="clearfix active type-' + data.data.type + '" data-id="' + data.data.pigcms_id + '"><a href="javascript:;" class="js-delete-qrcode pull-left btn-delete-qrcode" data-id="' + data.data.pigcms_id + '">删除</a>' + title + '</li>';
                    $('.qrcode-left-lists > ul').append(li);
                    $('.qrcode-left-lists > ul > li:last').siblings('li').removeClass('active');
                    if ($('.qrcode-left-lists > ul > li').length >= 5) {
                        $('.js-create-qrcode').hide();
                    }
                    qrcode_arr[data.data.pigcms_id] = '<img class="loading" src="./source/qrcode.php?type=good&id=' + product_id + '&activity=' + data.data.pigcms_id + '" /><p>' + desc + '</p><div class="clearfix qrcode-links"><a class="pull-left" href="./source/qrcode.php?type=good&id=' + product_id + '&activity=' + data.data.pigcms_id + '" download="true" target="_blank">下载二维码</a><a class="pull-right js-edit" data-id="' + data.data.pigcms_id + '" href="javascript:;">修改优惠</a></div>';
                    $('.js-qrcode-right-sidebar > .text-center').html(qrcode_arr[data.data.pigcms_id]);
                } else if (data.type == 'edit') {
                    $('.text-center > p').html(desc);
                }
                $('.notifications').html('<div class="alert in fade alert-success">' + data.msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
        return false;
    })

    //折扣
    $("input[name='discount']").live('blur', function(){
        $(this).closest('.control-group').removeClass('error');
        $(this).parent('.input-append').next('.error-message').remove();
        var tmp_discount = 0;
        if ($(this).val() != '' && $(this).val() != 0) {
            tmp_discount = $(this).val();
        } else {
            $(this).val('0.0');
        }
        if (isNaN(tmp_discount) || parseFloat(tmp_discount) < 0.1 || parseFloat(tmp_discount) > 9.9) {
            $(this).closest('.control-group').addClass('error');
            $(this).parent('.input-append').after('<p class="help-block error-message">折扣范围为 0.1 到 9.9</p>');
            return false;
        }
        if (parseFloat(tmp_discount) > 0){
            var discount_price = parseFloat(tmp_discount / 10) * price;
            $('.js-final-price').text(discount_price.toFixed(2));
        }
    })
    //优惠金额
    $("input[name='price']").live('blur', function(){
        $(this).closest('.control-group').removeClass('error');
        $(this).parent('.input-prepend').next('.error-message').remove();
        var tmp_amount = 0;
        if ($(this).val() != '' && $(this).val() != 0) {
            tmp_amount = $(this).val();
        } else {
            $(this).val('0.00');
        }
        if (isNaN(tmp_amount) || tmp_amount == '' || parseFloat(tmp_amount) < 0.01) {
            $(this).closest('.control-group').addClass('error');
            $(this).parent('.input-prepend').after('<p class="help-block error-message">优惠减免金额必须大于 0.01 元</p>');
            return false;
        }
        if (parseFloat(tmp_amount) > price) {
            $(this).closest('.control-group').addClass('error');
            $(this).parent('.input-prepend').after('<p class="help-block error-message">优惠减免金额 ' + tmp_amount + ' 不能高于商品最低价格</p>');
            return false;
        }
        if (isNaN($(this).val())) {
            return false;
        }
    })

    //显示活动删除按钮
    $('.qrcode-left-lists > ul > li').live('hover', function(){
        if (event.type == 'mouseover') {
            $(this).children('.js-delete-qrcode').show();
        }
        if (event.type == 'mouseout') {
            $(this).children('.js-delete-qrcode').hide();
        }
    })

    //活动删除
    $('.js-delete-qrcode').live('click', function(){
        var activity_id = $(this).attr('data-id');
        if ($(this).closest('li').hasClass('active')) {
            $('.qrcode-left-lists > ul > li:eq(0)').trigger('click');
        }
        var index = $(this).attr('data-id');
        delete qrcode_arr[index];
        $(this).closest('li').remove();
        $.post(del_qcode_activity_url, {'product_id': product_id, 'activity_id': activity_id}, function(data){
            if (!data.err_code) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                $('.js-create-qrcode').show();
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    })

    //显示复制商品按钮
    /*$('.js-list-body-region > tr').live('hover', function(){
        if (event.type == 'mouseover') {
            $(this).find('td:last > p:last > .js-copy').show();
        } else if (event.type == 'mouseout') {
            $(this).find('td:last > p:last > .js-copy').hide();
        }
    })*/

    //排序设置
    $('.js-change-num').live('click', function(){
        $(this).hide();
        $(this).next('.js-input-num').show();
        $(this).next('.js-input-num').focus();
    })
    var flag = false;
    $('.js-input-num').live('change', function(){
        flag = true;
        var sort = $.trim($(this).val());
        if (sort != '') {
            $(this).prev('.js-change-num').text(sort);
        }
    })
    $('.js-input-num').live('blur', function(){
        $(this).hide();
        $(this).prev('.js-change-num').show();
        if (flag) {
            var sort = $.trim($(this).val());
            var id = $(this).data('id');
            if (sort != '') {
                $.post(sort_url, {'id': id, 'sort': sort}, function(data){})
            }
            $('.orderby:last').children('span').removeClass('desc').addClass('asc');
            $('.orderby:last').trigger('click');
        }
        flag = false;
    })
});
function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}