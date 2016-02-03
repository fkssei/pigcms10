$(function(){
	load_page('.app__content',load_url,{page:'stockout_content'},'');

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
        $('.app__content').load(load_url, {page: 'stockout_content', 'p': p, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod}, function(){
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
        $('.app__content').load(load_url, {page: 'stockout_content','orderbyfield': orderbyfield, 'orderbymethod': orderbymethod}, function(){
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
        if ($('.js-check-toggle:checked').length == 0) {
            $('.notifications').html('');
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择商品</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        $('body').children('.popover').remove();
        var html = '<div class="popover bottom" style="display: block; top: ' + ($(this).offset().top + $(this).height()) + 'px; left: ' + ($(this).offset().left - $(this).width() - 5) + 'px;"><div class="arrow"></div><div class="popover-inner popover-category2"><div class="popover-header clearfix">修改分组<a href="http://koudaitong.com/v2/showcase/tag#list" target="_blank" class="pull-right">管理</a></div><div class = "popover-content" > <ul class="popover-content-categories js-popover-content-categories"> <li data-id="10924962" class="clearfix"><span class="js-category-check category-check category-check-none"></span><span class="category-title">列表中隐藏</span></li></ul></div><div class="popover-footer"><a href="javascript:;" class="ui-btn ui-btn-primary js-btn-confirm">保存</a><a href="javascript:;" class="ui-btn js-btn-cancel">取消</a></div></div></div>';
        $('body').append(html);
    })

    //选择分组
    $('.js-popover-content-categories > li').live('click', function(e){
        if ($('.js-popover-content-categories > li > .js-category-check').hasClass('category-check-all')) {
            $('.js-popover-content-categories > li > .js-category-check').removeClass('category-check-all').addClass('category-check-none');
        } else {
            $('.js-popover-content-categories > li > .js-category-check').removeClass('category-check-none').addClass('category-check-all');
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
                $('.app__content').load(load_url, {page: 'stockout_content', 'p': p, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod}, function(){
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
        button_box($(this), e, 'right', 'confirm', '确认删除？', function(){
            //暂时未处理
        });
    })

    //删除单个商品
    $('.js-delete').live('click', function(e){
        var product_id = $(this).attr('data');
        button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
            //暂时未处理
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
            $('.app__content').load(load_url, {page: 'stockout_content', 'keyword': keyword}, function(){
                $('.ui-search-box .txt').val(keyword);
            });
        }
    })

    $('.chosen-single').live('click', function(){
        $(".chosen-search input").focus();
        $(this).toggle(function(){
            $(this).parent('.chosen-container-single').addClass('chosen-container-active').addClass('chosen-with-drop');
        }, function(){
            $(this).parent('.chosen-container-single').removeClass('chosen-container-active').removeClass('chosen-with-drop');
        }).trigger('click');
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
        var _con = $('.chosen-drop');   // 设置目标区域
        if(!_con.is(e.target) && _con.has(e.target).length === 0){ // Mark 1
            if ($('.chosen-container-single').hasClass('chosen-with-drop')) {
                $('.chosen-single').trigger('click');
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

    //失去焦点
    $(".chosen-search input").live('blur', function(){
        $('.chosen-container-single').removeClass('chosen-container-active').removeClass('chosen-with-drop');
    });

    //推广
    $('.js-promotion-btn').live('click', function(){
        $('body').children('.widget-promotion').remove();
        var html = '<div class="widget-promotion" style="top: ' + ($(this).offset().top - 68) + 'px; left: ' + ($(this).offset().left - 370) + 'px;"><ul class="widget-promotion-tab clearfix js-tab"><li class="active" data-tab="qrcode">商品二维码</li><li data-tab="link">商品链接</li></ul><div class="widget-promotion-content js-tabs-content"><div class="js-link-region js-tab-content js-tab-content-link" style="display: none;"><div><div class="widget-promotion-main"><div class="alert">分享才有更多人看到哦</div><div class="widget-promotion-content"><label>商品页链接</label><div class="input-append"><input type="text" class="" readonly="" value="http://wap.koudaitong.com/v2/showcase/goods?alias=i50bsf4z"><button type="button" class="btn js-btn-copy" data-clipboard-text="http://wap.koudaitong.com/v2/showcase/goods?alias=i50bsf4z">复制</button></div><label>直接弹出购买界面的链接</label><div class="input-append"><input type="text" class="" readonly="" value="http://wap.koudaitong.com/v2/showcase/goods?alias=i50bsf4z&amp;showsku=true"><button type="button" class="btn js-btn-copy" data-clipboard-text="http://wap.koudaitong.com/v2/showcase/goods?alias=i50bsf4z&amp;showsku=true">复制</button></div></div></div></div></div><div class="js-qrcode-region js-tab-content js-tab-content-qrcode"><div><div class="widget-promotion-main"><div class="js-qrcode-content"><div class="alert">扫一扫，在手机上查看并分享<a class="new-window qrcode-help pull-right" href="http://kdt.im/BnjPhMW6" target="_blank">帮助</a></div><div class="qrcode-content"><div class="qrcode-left-sidebar js-qrcode-left-sidebar"><div class="qrcode-left-lists"><ul><li class="clearfix active">直接购买商品</li><li class="clearfix">关注后购买商品</li></ul></div><a href="javascript:;" class="js-create-qrcode qrcode-create-button">创建一个优惠二维码</a></div><div class="qrcode-right-sidebar js-qrcode-right-sidebar"><div class="text-center"><img class="loading" src="data:image/png;base64,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" width="190" height="190"><p>扫码后直接访问商品</p><div class="clearfix qrcode-links"><a class="pull-left" href="http://koudaitong.com/v2/showcase/goods/downloadQr?id=7622469&amp;qr=0">下载二维码</a></div></div></div></div></div><div class="qrcode-create-content js-qrcode-create-content"></div></div></div></div></div></div>';
        $('body').append(html);
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
                            var t = setTimeout('msg_hide()', 3000);
                        }
                    });
                })
            })
        }
    })

    //商品二维码
    $('.qrcode-left-lists > ul > li').live('click', function(){
        var arr = [];
        arr[0] = '<div class="text-center"><img class="loading" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZUAAAGVAQAAAAAeIFGWAAADqUlEQVR4nO2cQY6jSBBFXxgkSqpF9q6X+AZ9BGpOBj5Kn6ThJng5O7MYCVSYP4tMXK7euWpUNtORK0B+UqRCkRnxM9Imbh3T7mYEnHHGGWecceZ/zwwWx354QmZme6YcoLs8pF80X26bMx9kCklSSxgsk5qqH8Isg6qnmMEaSknSPWxz5oPMOcVg8iBwzsThBSbboQYGs9175qtsc+bGkf/2ni0Axz3FgoGFv7NXo/7rHrY5858wUy6T2vJUTGZqKI9hyn4vYTc0nz+ZySQ1QDFlsqbbhyE3mdSVQ7EAEKTlPrY58yFmMjOzF4an9HkIM0BXHUOUjY5mZnYP25y5deQAYV1dB5Dp8FJCdjbg+I1iQXC9/j7yfJwBJOlEtkDdlhoBNZU0ZgtSW0qzibpNtUwtaXzk+ThD8mkxA7V0IktFaKEFSX3QDJL6uOfKffr4DNFNKSpPZAtqqp5CElTRp9RXfnefPjqzxqkpxikAlTQC1G1UIajfAtZ9ug0mjNkCdPtVc2AIWoCqJ0ZuV52mwmuZbTBrjnRZaS0WqmCiVh/dvYawx+kWmOQmUnI7AlfbaFtKWmIm7HnvtphiBlndWdCC1MKaAEcVom6jmH8P25y5eaQ4jSOuvUrVaMqElb543rsRJuW9sRqNRQ2krCk5NiZLYcS8Pt0EszounonHLDcqDJdFOEpMp8L3000xca+s+jCe07mMonSf1EKru29T/p75KtucuXnEEH0n6gJhzCRq9UkkbEkB63H6+Mzbpimpf2tMimVpS4iCkmJjku+n22Ks6arTlF/3IwFJRyImwN43uAUmBxi+/5PDoe0Zn0F0QPZqAEOYdnD49fPHYF9tmzOfzXvTe9IGo6rfctlPg+tIW2GS3gtAtSZLl9PSt/30uoZ95Pk4w3WfA5RKOlIMz+RlYsPD6lz36aMzq44kqaniA7CutG1sF4yn5OmM1X366Mx1z3ZnYTCgbo4/0qeyn55nGeyZckxfapszn9cGU4NKLFRngCodrdZpffb9dDPM5V5bGArJzPZJwz9YqdjouwfM69MNMat8RDHL1FQ6Pp0zWVP1g+UQm1juZJszN4/LkhsPX2ZiRsRbf+/6S+8F3SoTF9gwnncAx8txTNAsv1O8QSYMuSzqSFp7V1L72fB0UYC3M58/k0lRmAnoGL7POUYF0/PrTkA4nXeL4MiU43egNsSs99rSvzdQHuO9tqofnrIl3v0fM7/7vw3G/D+vnHHGGWeccebTzL/3wv2Ib3SlzwAAAABJRU5ErkJggolQTkcNChoKAAAADUlIRFIAAAGuAAABrgEAAAAA4I7fNwAAA3ZJREFUeJztnE1uo0AQhV8ZS7DDN4CbtG9GczO4CdzA7IiEebPoasAZZZNkxmpUbGwTPhmrUn+vyhbiG8fz8h0KMMwwwwwzzDDDDDPspJiE4wLxGEXkArR3hMIxPNErijfepGE/xkCSJBqSXIT0qDhnJBoOJfV45IvoE5LkksRnM+xrrFfPbTpMwYV79/i4AmilLmcAIlK/+SYN+3XMDQAoaJthKp4igOtjDP/9dzPsvVh7HysuQjStVDOEwtY9/tW7Gfbm3M2uCpnao3rkXEHvLHefDWtFRK6AeD0h7AA8MwrbGgBFROT21ps07KfYNTwc5f2xmq4CwPW3HBS03YAZrwOAJD6bYV9hIvdRiucFlDuAbAXljnKGkGzrqdDJzWR9d9LYlrs7ICcJOD4AQPvuFWSHklwBuNiHW+5OG6M0QzkHFx6rOVsBoBpFY/1UINTqpqqdAhO2biyyFUBfTwWEFJFb/nGJxRuFHijnN96kYT/GwO145IswyCwqoiLnqlF9EdK7KKtaME8Ui7kbjg9kK8iuorrw1ncPmtYBM3faWPRuj01dAdTugKorQzlnMQKYuc+ANR3KKX+KkEPJBdhKdPEA8gVAayOS1LHdu+PLrlI1VWXV0H8FfTU0a+bdyWK7Zq5lmHdDOL8XZhxCePeorO9OGztU5tQYPkRRZYvqA/JFiMZyd+rYoVQjGVz4kS9QMS32X0F4cWbuxLHNu+PckwwVWph77n03ENzczH0KzPXVnD1FPKDGxXjD8wKK1FORrUDT1qaqnQabimdGtPfDrlr4gxvKGaFEH00zPwMmvq/xka84COOuvwGAsK3xcaXQ1huSx46auZ5REbXpQs225W5T1dLHNs0cALJYs23T7QWgh47C981zM3ei2D4iGQCE1cTQgDcc4j9A7Mhgqlri2HETVb88oo0YSW3AqX1301UWzNPGXsyNLXSv0dxCereldRuAJo69iKgMS2tBRG06hD2HKKapvmrmThh7KdVw8GXypSDX0ZgF87Sxv79FossMmqkPUrmZO33sZfF4kRDMdSCiK2rs4rUuhnwz93mwaiwA0Pc1wldB7+E82Y22eJw29tm7g4iarXp+22KyRuwU2OfcrQX5qtssS1xn4houN3MnjX2uzMPj/mMdK/YlFm+lWuqY2E87GmaYYYYZZphhhhn2/7E/luWe/2hgYj4AAAAASUVORK5CYII=" width="190" height="190"><p>扫码后直接访问商品</p><div class="clearfix qrcode-links"><a class="pull-left" href="http://koudaitong.com/v2/showcase/goods/downloadQr?id=7622469&amp;qr=0">下载二维码</a></div></div>';
        arr[1] = '你需要将微信公众号升级成为微信认证的服务号，才能够获得该类型的商品二维码。'
        $(this).addClass('active');
        $(this).siblings('li').removeClass('active');
        var index = $(this).index('.qrcode-left-lists > ul > li');
        $('.js-qrcode-right-sidebar > .text-center').html(arr[index]);
    })

    //创建优惠二维码
    $('.js-create-qrcode').live('click', function(){
        var html = '<div><div class="widget-promotion-main"><div class="js-qrcode-content hide"><div class="alert">扫一扫，在手机上查看并分享<a class="new-window qrcode-help pull-right" href="http://kdt.im/BnjPhMW6" target="_blank">帮助</a></div><div class="qrcode-content"><div class="qrcode-left-sidebar js-qrcode-left-sidebar"><div class="qrcode-left-lists"><ul><li class="clearfix">直接购买商品</li><li class="clearfix active">关注后购买商品</li></ul></div><a href="javascript:;" class="js-create-qrcode qrcode-create-button">创建一个优惠二维码</a></div><div class="qrcode-right-sidebar js-qrcode-right-sidebar"><div class="text-center"><p class="text-left">你需要将微信公众号升级成为微信认证的服务号，才能够获得该类型的商品二维码。</p></div></div></div></div><div class="qrcode-create-content js-qrcode-create-content"><form novalidate="" class="form-horizontal qrcode-form-create"><div class="control-group"><label class="control-label">购买方式：</label><div class="controls"><select name="buy_type" class="input-medium"><option value="0" selected="">扫码直接购买</option></select><p class="qrcode-text js-qrcode-text-0 ">*由商品链接直接生成二维码。</p></div></div><div class="control-group"><label class="control-label">优惠方式：</label><div class="controls"><label class="radio inline"><input type="radio" name="type" value="0" checked="">扫码折扣</label><label class="radio inline"><input type="radio" name="type" value="1">扫码可减优惠</label></div></div><div class="js-coupon-0"><div class="control-group"><label class="control-label">扫码折扣：</label><div class="controls"><div class="input-append"><input type="text" name="discount" class="input input-mini js-price" data-fixed="1" value=""><span class="add-on">折</span></div></div></div><div class="control-group"><label class="control-label">折后价：</label><div class="controls"><div class="control-action">￥<span class="js-final-price">500.00</span> 元</div></div></div></div><div class="js-coupon-1 hide"><div class="control-group"><label class="control-label">扫码优惠：</label><div class="controls"><div class="input-prepend"><span class="add-on">-￥</span><input type="text" name="price" class="input input-mini js-price" value=""></div></div></div><div class="control-group" style="margin-top: 20px;"></div></div><div class="control-group"><div class="controls"><button type="submit" class="ui-btn ui-btn-primary js-submit-btn" data-loading-text="保 存...">保 存</button> <button type="cancel" class="ui-btn js-cancel-btn">取 消</button></div></div></form></div></div></div>';
        $('.js-tab-content-qrcode').html(html);
    })

    //取消创建优惠二维码
    $('.controls > .js-cancel-btn').live('click', function(){
        var html = '<div class="js-qrcode-region js-tab-content js-tab-content-qrcode" style="display: block;"><div><div class="widget-promotion-main"><div class="js-qrcode-content"><div class="alert">扫一扫，在手机上查看并分享<a class="new-window qrcode-help pull-right" href="http://kdt.im/BnjPhMW6" target="_blank">帮助</a></div><div class="qrcode-content"><div class="qrcode-left-sidebar js-qrcode-left-sidebar"><div class="qrcode-left-lists"><ul><li class="clearfix active">直接购买商品</li><li class="clearfix">关注后购买商品</li></ul></div><a href="javascript:;" class="js-create-qrcode qrcode-create-button">创建一个优惠二维码</a></div><div class="qrcode-right-sidebar js-qrcode-right-sidebar"><div class="text-center"><img class="loading" src="data:image/png;base64,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" width="190" height="190"><p>扫码后直接访问商品</p><div class="clearfix qrcode-links"><a class="pull-left" href="http://koudaitong.com/v2/showcase/goods/downloadQr?id=7622469&amp;qr=0">下载二维码</a></div></div></div></div></div><div class="qrcode-create-content js-qrcode-create-content"></div></div></div></div>';
        $('.js-tab-content-qrcode').html(html);
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
});
function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}