/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
var history_nav_styles_setting = [];
var history_nav_styles_menu = []; //样式菜单
history_nav_styles_setting[1] = '';//样式一配置
history_nav_styles_setting[2] = '';//样式二配置
history_nav_styles_setting[3] = '';//样式三配置

history_nav_styles_menu[1] = ''; //样式一菜单
history_nav_styles_menu[2] = ''; //样式二菜单
history_nav_styles_menu[3] = ''; //样式三菜单

var li_drp = '';
if (allow_store_drp == 1) {
    li_drp = '<li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li>';
}
$(function(){
    load_page('.app__content', load_url, {page:'storenav_content'}, '');

    //关闭提示
    $('.alert > .close').live('click', function(){
        $(this).closest('.alert').remove();
    })

    //启用店铺导航
    $('.ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(open_nav_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //关闭店铺导航
    $('.ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_nav_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //添加一级导航
    $('.js-add-nav').live('click', function(e){
        var shopnav_style_id = $('.shopnav-style-id').val();
        var shopnav_styles = [];
        var shopnav_limit = []; //菜单数量限制
        shopnav_styles[1] = '<li class="choice"><div class="first-nav"><h3>一级导航</h3><div class="js-first-nav-item-meta-region"><div><div class="shopnav-item"><div class="shopnav-item-title"><span>标题</span></div><div class="shopnav-item-link"><a href="javascript:;" class="pull-left shopnav-item-action js-edit-title">编辑</a><span class="pull-left shopnav-item-split">|</span><span class="pull-left">链接：</span><div class="pull-left"><div class="dropdown hover"> <a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a> <ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div></div></div></div></div></div><div class="second-nav" data-first-nav-index="0"><h4>二级导航</h4><div class="actions"><span class="action delete close-modal" title="删除">×</span></div><div class="js-second-nav-region"><ul class="choices ui-sortable"></ul></div><p class="add-shopnav add-second-shopnav js-add-second-nav hide" style="display: block;">+ 添加二级导航</p></div></li>';
        shopnav_styles[2] = '<li class="choice"><div class="app-nav"><div class="actions"><span class="action delete close-modal" title="删除">×</span></div><div class="app-nav-image-group clearfix"><div class="app-nav-image-normal pull-left"><p>普通：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="" style=""></div><a href="javascript:;" class="js-trigger-image">选择</a></div></div><div class="app-nav-image-active-box pull-left"> <p>高亮（可选）：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="" style=""></div><a href="javascript:;" class="js-trigger-actived-image">选择</a></div></div></div><div class="control-group"><div class="controls" style="margin-left: 0;"></div></div><p class="c-gray">图片尺寸要求：不大于128*100像素，支持PNG格式</p><div class="split-line"></div><div class="control-group control-group-link"><label class="control-label">链接：</label><div class="controls"><div class="dropdown hover"><a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div><input type="hidden" name="link_url"></div></div></div></li>';
        shopnav_styles[3] = '<li class="choice"><div class="app-nav"><div class="actions"><span class="action delete close-modal" title="删除">×</span></div><div class="app-nav-image-group clearfix"><div class="app-nav-image-normal pull-left"><p>普通：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="" style=""></div><a href="javascript:;" class="js-trigger-image">选择</a></div></div><div class="app-nav-image-active-box pull-left"><p>高亮（可选）：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="" style=""></div><a href="javascript:;" class="js-trigger-actived-image">选择</a></div></div></div><div class="control-group"><div class="controls" style="margin-left: 0;"></div></div><p class="c-gray">图片尺寸要求：不大于128*100像素，支持PNG格式</p><div class="split-line"></div><div class="control-group control-group-link"><label class="control-label">链接：</label><div class="controls"><div class="dropdown hover"><a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div><input type="hidden" name="link_url"></div></div></div></li>';
        shopnav_limit[1] = 3;
        shopnav_limit[2] = 5;
        shopnav_limit[3] = 4;
        $('.js-nav-region > .choices').append(shopnav_styles[shopnav_style_id]);
        var length = $('.js-nav-region > .choices > .choice').length;

        if (length >= shopnav_limit[shopnav_style_id]) {
            $('.js-add-nav').addClass('hide');
            $('.js-add-nav').hide();
        }
        $('.js-navmenu').removeClass('has-menu-' + (length -1));
        $('.js-navmenu').addClass('has-menu-' + length);
        $('.no-nav-pop-sub-item').remove();
        if (shopnav_style_id == 1) { //样式一
            $('.js-nav-preview-region > .nav-items').append('<div class="nav-item-www"><a class="mainmenu" href="javascript:;" target="_blank"><span class="mainmenu-txt">标题</span></a><div class="submenu js-submenu" style="display: none;"><span class="arrow before-arrow" style="left:63px;right:auto;"></span><span class="arrow after-arrow" style="left:63px;right:auto;"></span><div class="js-nav-2nd-region"><ul></ul></div></div></div>');
        } else if (shopnav_style_id == 2) { //样式二
            $('.js-nav-preview-region > .nav-pop-sub').append('<li class="nav-item nav-pop-sub-item nav-pop-sub-item-' + length + '"><a href="javascript:;" style=""></a></li>');
        } else if (shopnav_style_id == 3) { //样式三
            length = $('.nav-pop-sub > .nav-pop-sub-item').length;
            if (length == 0) {
                $('.js-navmenu > .nav-pop-sub').prepend('<li class="nav-item nav-pop-sub-item nav-pop-sub-item-' + (length + 1) + '"><a href="javascript:;" style="background-image: url();"></a></li>');
            } else if (length == 2) {
                var tmp = $('.js-nav-preview-mainIcon-region').html();
                $('.nav-pop-sub > li').eq(1).html($('.nav-pop-sub > .nav-pop-sub-item:last').html()).removeClass().addClass('nav-item nav-pop-sub-item nav-pop-sub-item-2');
                $('.nav-pop-sub > li').eq(2).html(tmp).removeClass().addClass('nav-special-item nav-item js-nav-preview-mainIcon-region');
                $('.js-navmenu > .nav-pop-sub').append('<li class="nav-item nav-pop-sub-item nav-pop-sub-item-' + (length + 1) + '"><a href="javascript:;" style="background-image: url();"></a></li>');
            } else {
                $('.js-navmenu > .nav-pop-sub').append('<li class="nav-item nav-pop-sub-item nav-pop-sub-item-' + (length + 1) + '"><a href="javascript:;" style="background-image: url();"></a></li>');
            }
        }
    })

    //修改模板
    $('.js-select-nav-style').live('click', function(){ 
        $('body').append('<div class="modal-backdrop fade in"></div><div class="modal fade in" style="width: 800px; margin-left: -400px; margin-top: -1000px; display: block;" aria-hidden="false"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><h3 class="title">选择导航模板</h3></div><div class="modal-body shopnav-modal" style="padding: 30px;"><div class="pull-left clearfix"><div class="shopnav-sample"><label class="radio inline"><input type="radio" name="nav_style" value="1" checked="" />微信公众号自定义菜单样式</label><div class="shopnav-sample-wechat"></div></div><div class="shopnav-sample"><label class="radio inline"><input type="radio" name="nav_style" value="2" />APP导航模板（图标及底色都可配置）</label><div class="shopnav-sample-app shopnav-sample-app2"></div></div></div><div class="pull-left clearfix" style="margin-left: 20px;"><div class="shopnav-sample"><label class="radio inline"><input type="radio" name="nav_style" value="3" />带购物车导航模板</label><div class="shopnav-sample-app shopnav-sample-app3"></div></div><!--<div class="shopnav-sample"><label class="radio inline"><input type="radio" name="nav_style" value="4" />Path展开形式导航</label><div class="shopnav-sample-app shopnav-sample-app4"></div></div><div class="shopnav-sample"><label class="radio inline"><input type="radio" name="nav_style" value="5" />两侧展开形式导航</label><div class="shopnav-sample-app shopnav-sample-app5"></div></div>--></div></div><div class="modal-footer"><a href="javascript:;" class="ui-btn ui-btn-primary js-confirm">确定</a> <a href="javascript:;" class="ui-btn js-cancel">取消</a></div></div>');
        $('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
        var nav_style_id = $('.shopnav-style-id').val();
        $("input[value='" + nav_style_id + "']").attr('checked', true);
    })

    //导航模板关闭
    $('.modal-header > .close').live('click', function(){
        $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
			$('.modal-backdrop,.modal').remove();
		});
        if ($('.pull-left').hasClass('active')) {
            $('.pull-left').removeClass('active');
        }
        if ($('.controls').hasClass('active')) {
            $('.controls').removeClass('active');
        }
    })
    //导航模板取消
    $('.modal-footer > .js-cancel').live('click', function(){
        $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
			$('.modal-backdrop,.modal').remove();
		});
    })
    //修改导航文字
    $('.js-edit-title').live('click', function(e){
        var content = $(this).closest('.shopnav-item-link').prev('.shopnav-item-title').children('span').html();
        var obj = this;
        button_box($(this), e, 'bottom', 'input', content, function(){
            var title = $('.js-btn-confirm').prev("input[type='text']").val();
            if (title != '') {
                if ($(obj).closest('.first-nav').length > 0) { //一级导航标题修改
                    var index = $(obj).closest('.choice').index('.js-nav-region > .choices > .choice');
                    $('.first-nav').eq(index).find('.shopnav-item-title span').html(title);
                    $('.mainmenu-txt').eq(index).html(title);
                }
                if ($(obj).closest('.second-nav').length > 0) {
                    var index = $(obj).closest('.second-nav').closest('.choice').index('.js-nav-region > .choices > .choice');
                    var index2 = $(obj).closest('.shopnav-item').index('.second-nav:eq(' + index + ') > .js-second-nav-region > .choices > .choice > .shopnav-item');
                    $('.second-nav:eq(' + index + ')').find('.shopnav-item-title span').eq(index2).html(title);
                    $('.nav-item-www').eq(index).find('.js-submenu > .js-nav-2nd-region > ul > li:eq('+ (index2) +')').find('a').html(title);
                }
            }
            close_button_box();
        })
    })
    //链接
    $('.dropdown-menu > li').live('click', function(e) {
        //当前样式id
        var shopnav_style_id = $('.shopnav-style-id').val();

        var type = $(this).children('a').attr('data-type');
        if (type == 'feature') { //微页面
            var page = 'storenav_wei_page';
            if (shopnav_style_id == 1) { //样式一
                $(this).closest('.pull-left').addClass('active');
            } else { //其它样式
                $(this).closest('.controls').addClass('active');
            }
        } else if (type == 'category') { //微页面分类
            var page = 'storenav_wei_page_category';
            if (shopnav_style_id == 1) { //样式一
                $(this).closest('.pull-left').addClass('active');
            } else { //其它样式
                $(this).closest('.controls').addClass('active');
            }
        } else if (type == 'goods') { //商品
            var page = 'storenav_goods';
            if (shopnav_style_id == 1) { //样式一
                $(this).closest('.pull-left').addClass('active');
            } else { //其它样式
                $(this).closest('.controls').addClass('active');
            }
        } else if (type == 'goods_group') { //商品分组
            var page = 'storenav_goods_group';
            if (shopnav_style_id == 1) { //样式一
                $(this).closest('.pull-left').addClass('active');
            } else { //其它样式
                $(this).closest('.controls').addClass('active');
            }
        } else if (type == 'homepage') { //店铺主页
            if (shopnav_style_id == 1) { //样式一
                $(this).closest('.pull-left').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a> <ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
            } else if (shopnav_style_id == 2) { //样式二
                $(this).closest('.controls').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a> <ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
            } else if (shopnav_style_id == 3) { //样式三
                if ($(this).closest('.js-main-icon-setting').length == 1) {
                    $(this).closest('.controls').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-cart" data-type="cart" href="javascript:;">购物车</a></li><li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
                } else {
                    $(this).closest('.controls').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a> <ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
                }
            }
            return false;
        } else if (type == 'usercenter') { //会员主页
            if (shopnav_style_id == 1) { //样式一
                $(this).closest('.pull-left').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a> <ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
            } else if (shopnav_style_id == 2) { //样式二
                $(this).closest('.controls').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a> <ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
            } else if (shopnav_style_id == 3) { //样式三
                if ($(this).closest('.js-main-icon-setting').length == 1) {
                    $(this).closest('.controls').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-cart" data-type="cart" href="javascript:;">购物车</a></li><li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
                } else {
                    $(this).closest('.controls').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a> <ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
                }
            }
            return false;
        } else if (type == 'drp') {
            if (shopnav_style_id == 1) { //样式一
                $(this).closest('.pull-left').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a> <ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
            } else if (shopnav_style_id == 2) { //样式二
                $(this).closest('.controls').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a> <ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
            } else if (shopnav_style_id == 3) { //样式三
                if ($(this).closest('.js-main-icon-setting').length == 1) {
                    $(this).closest('.controls').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-cart" data-type="cart" href="javascript:;">购物车</a></li><li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
                } else {
                    $(this).closest('.controls').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a> <ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
                }
            }
            return false;
        } else if (type == 'link') { //自定义外链
            var obj = this;
            if (shopnav_style_id == 1) { //样式一
                var link_obj = $(obj).closest('.pull-left')
            } else if (shopnav_style_id == 2) { //样式二
                var link_obj = $(obj).closest('.controls');
            } else if (shopnav_style_id == 3) { //样式三
                var link_obj = $(obj).closest('.controls');
            }
            button_box(link_obj, event, 'bottom', 'url', '链接地址：http://example.com', function(){
                var url = $('.js-link-placeholder').val();
                if (url != '') {
                    if (!check_url(url)){
                        url = 'http://' + url;
                    }
                    link_obj.html('<div class="clearfix"><div class="pull-left js-link-to link-to"><a href="' + url + '" target="_blank" class="new-window link-to-title">[外链] ' + url + '</a></div><div class="dropdown hover pull-right"><a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
                } else {
                    return false;
                }
                close_button_box();
            });
            return false;
        } else if (type == 'cart') { //购物车
            $(this).closest('.controls').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><span class="link-to-title">' + '[' + $(this).children('a').html() + ']' + '</span></div><div class="dropdown hover pull-right"> <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-cart" data-type="cart" href="javascript:;">购物车</a></li><li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
            return false;
        }

        $('.modal-backdrop,.modal').remove();
        $('body').append('<div class="modal-backdrop fade in"></div><div class="modal fade hide js-modal in" aria-hidden="false" style="margin-top: -1000px; display: block;"></div>');
        $('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
        load_page('.modal', load_url, {'page': page}, '', function() {
            $('.pagenavi > .total > a').attr('data-type', type);
            $('.js-update').attr('data-type', type);
            $('.js-modal-search').attr('data-type', type);
        });
    })
    //选项卡切换
    $('.modal-tab > li').live('click', function(){
        if ($(this).hasClass('active')) {
            return false;
        }
        if ($(this).hasClass('link-group')) {
            return true;
        }
        $(this).addClass('active');
        $(this).siblings('li').removeClass('active');
        var type = $(this).children('a').attr('data-type');
        if (type == 'feature') { //微页面
            var page = 'storenav_wei_page';
        } else if (type == 'category') { //微页面分类
            var page = 'storenav_wei_page_category';
        } else if (type == 'goods') { //商品
            var page = 'storenav_goods';
        } else if (type == 'goods_group') {
            var page = 'storenav_goods_group';
        }
        load_page('.modal', load_url, {'page': page}, '', function() {
            $('.pagenavi > .total > a').attr('data-type', type);
            $('.js-update').attr('data-type', type);
            $('.js-modal-search').attr('data-type', type);
        });
    })
    //刷新
    $('.js-update').live('click', function(){
        var type = $(this).attr('data-type');
        if (type == 'feature') { //微页面
            var page = 'storenav_wei_page';
        } else if (type == 'category') { //微页面分类
            var page = 'storenav_wei_page_category';
        } else if (type == 'goods') {
            var page = 'storenav_goods';
        } else if (type == 'goods_group') {
            var page = 'storenav_goods_group';
        }
        load_page('.modal', load_url, {'page': page}, '', function() {
            $('.pagenavi > .total > a').attr('data-type', type);
            $('.js-update').attr('data-type', type);
            $('.js-modal-search').attr('data-type', type);
        });
    })
    //分页
    $('.pagenavi > .total > a').live('click', function(){
        if ($(this).hasClass('active')) {
            return false;
        }
        var type = $(this).attr('data-type');
        var p = $(this).attr('data-page-num');
        if (type == 'feature') { //微页面
            var page = 'storenav_wei_page';
        } else if (type == 'category') { //微页面分类
            var page = 'storenav_wei_page_category';
        } else if (type == 'goods') {
            var page = 'storenav_goods';
        } else if (type == 'goods_group') {
            var page = 'storenav_goods_group';
        }
        if ($('.js-modal-search-input').val() != '') {
            var keyword = $('.js-modal-search-input').val();
        } else {
            var keyword = '';
        }
        load_page('.modal', load_url, {'page': page, 'p': p}, '', function() {
            $('.pagenavi > .total > a').attr('data-type', type);
            $('.js-update').attr('data-type', type);
            $('.js-modal-search').attr('data-type', type);
            $('.js-modal-search-input').val(keyword);
        });
    })
    //搜索
    $('.js-modal-search').live('click', function() {
        var type = $(this).attr('data-type');
        if (type == 'feature') { //微页面
            var page = 'storenav_wei_page';
        } else if (type == 'category') { //微页面分类
            var page = 'storenav_wei_page_category';
        } else if (type == 'goods') { //商品
            var page = 'storenav_goods';
        } else if (type == 'goods_group') {
            var page = 'storenav_goods_group';
        }
        var keyword = $(this).prev('.js-modal-search-input').val();
        load_page('.modal', load_url, {'page': page, 'keyword': keyword}, '', function() {
            $('.pagenavi > .total > a').attr('data-type', type);
            $('.js-update').attr('data-type', type);
            $('.js-modal-search').attr('data-type', type);
            $('.js-modal-search-input').val(keyword);
        });
    })
    //添加二级导航
    $('.js-add-second-nav').live('click', function(){
        var html = '<li class="choice"><div class="shopnav-item"><div class="actions"><span class="action delete close-modal" title="删除">×</span></div><div class="shopnav-item-title"><span>标题</span></div><div class="shopnav-item-link"><a href="javascript:;" class="pull-left shopnav-item-action js-edit-title">编辑</a><span class="pull-left shopnav-item-split">|</span><span class="pull-left">链接：</span><div class="pull-left"><div class="dropdown hover"><a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div></div></div></li>';
        $(this).prev('.js-second-nav-region').children('ul').append(html);
        var index  = $(this).index('.js-add-second-nav');
        if ($('.nav-item-www').eq(index).find('.arrow-weixin').length == 0) {
            $('.nav-item-www').eq(index).children('a').prepend('<i class="arrow-weixin"></i>');
            $('.nav-item-www').eq(index).children('a').attr('href', 'javascript:;');
        }
        $('.nav-item-www').eq(index).find('.js-nav-2nd-region > ul').append('<li><a href="javascript:;" target="_blank">标题</a></li>');
        if ($(this).prev('.js-second-nav-region').find('.choice').length >= 5) {
            $(this).hide();
        }
        $(this).closest('.second-nav').prev('.first-nav').find('.shopnav-item-split').nextAll().remove();
        $(this).closest('.second-nav').prev('.first-nav').find('.shopnav-item-split').after('<span class="pull-left c-gray">使用二级导航后主链接已失效。</span>');
    });
    //
    $('.js-mainmenu').live('click', function() {

    });
    //子菜单显示
    $('.nav-item-www').live('click', function(){
        $('.js-submenu').hide();
		if($(this).find('.js-submenu .js-nav-2nd-region li').size() > 0){
			var submenu = $(this).find('.js-submenu');
			submenu.show();
			var subleft = $(this).position().left+(($(this).width()-submenu.width())/2)-7;
			var arrowleft = (submenu.width()+6)/2;
			submenu.css({'left': (subleft > 5 ? subleft : 5) + 'px', 'right': 'auto'}).find('.before-arrow,.after-arrow').css({'left':arrowleft+'px'});
		}
    });
    //点击“删除窗口”之外区域删除“删除窗口”
    $('body').click(function(e){
        var _con = $('.js-submenu');   // 设置目标区域
        if(!_con.is(e.target) && _con.has(e.target).length === 0){ // Mark 1
            $('.js-submenu').addClass('hide');
            $('.js-submenu').hide();
        }
    });
    //导航样式
    $('.modal-footer > .js-confirm').live('click', function(e){
        //当前样式
        var shopnav_style_id = $('.shopnav-style-id').val();
        //切换样式前保存当前样式
        history_nav_styles_setting[shopnav_style_id] = $('.edit-shopnav-header').nextAll();
        history_nav_styles_menu[shopnav_style_id] = $('.preview-nav-menu').html();

        //新样式
        var nav_style = $("input[name='nav_style']:checked").val();
        var nav_styles = [];
        var nav_style_names = ['微信公众号自定义菜单样式', 'APP导航模板', '带购物车导航模板', 'Path展开形式导航', '两侧展开形式导航'];
        $('.shopnav-style-name').text(nav_style_names[nav_style-1]);

        if (history_nav_styles_setting[nav_style] != '' && history_nav_styles_setting[nav_style] != undefined) {
            $('.edit-shopnav-header').nextAll().remove();
            $('.edit-shopnav-header').after(history_nav_styles_setting[nav_style]);
            $('.shopnav-style-id').val(nav_style);

            if (history_nav_styles_menu[nav_style] != '' && history_nav_styles_menu[nav_style] != undefined) {
                $('.preview-nav-menu').html(history_nav_styles_menu[nav_style]);
            }

            $('.modal').animate({'margin-top': '-1000px'}, "slow");
            $('body').children('.modal-backdrop').fadeOut('slow');
            return false;
        }

        nav_styles[1] = '<div class="js-main-icon-setting main-icon-setting"></div><div class="js-nav-region clearfix"><ul class="choices ui-sortable"></ul></div><p class="add-shopnav js-add-nav">+ 添加一级导航</p>';
        nav_styles[2] = '<div class="shopnav-background-color"><span>底色：<span></span><input type="color" name="background_color" class="span2" value="#2B2D30"> <a href="javascript:;" class="btn js-reset-background-color">重置</a></span></div><div class="js-main-icon-setting main-icon-setting"><ul class="choices ui-sortable"></ul></div><div class="js-nav-region clearfix"><ul class="choices ui-sortable"><li class="choice"><div class="app-nav"><div class="actions"><span class="action delete close-modal" title="删除">×</span></div><div class="app-nav-image-group clearfix"><div class="app-nav-image-normal pull-left"><p>普通：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="./template/user/default/images/shopnav_01.png" style="background-image: url(./template/user/default/images/shopnav_01.png);background-size: 64px 50px;"></div><a href="javascript:;" class="js-trigger-image">修改</a></div></div><div class="app-nav-image-active-box pull-left"><p>高亮（可选）：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="./template/user/default/images/shopnav_01_on.png" style="background-image: url(./template/user/default/images/shopnav_01_on.png);background-size: 64px 50px;"></div><a href="javascript:;" class="js-trigger-actived-image">修改</a><div class="actions"><span class="action js-delete-actived-image close-modal" title="删除">×</span></div></div></div></div><div class="control-group"><div class="controls" style="margin-left: 0;"></div></div><p class="c-gray">图片尺寸要求：不大于128*100像素，支持PNG格式</p><div class="split-line"></div><div class="control-group control-group-link"><label class="control-label">链接：</label><div class="controls"><div class="dropdown hover"><a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li> <a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div><input type="hidden" name="link_url"></div></div></div></li><li class="choice"><div class="app-nav"><div class="actions"><span class="action delete close-modal" title="删除">×</span></div><div class="app-nav-image-group clearfix"><div class="app-nav-image-normal pull-left"><p>普通：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="./template/user/default/images/shopnav_02.png" style="background-image: url(./template/user/default/images/shopnav_02.png);background-size: 64px 50px;"></div><a href="javascript:;" class="js-trigger-image">修改</a></div></div><div class="app-nav-image-active-box pull-left"><p>高亮（可选）：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="./template/user/default/images/shopnav_02_on.png" style="background-image: url(./template/user/default/images/shopnav_02_on.png);background-size: 64px 50px;"></div><a href="javascript:;" class="js-trigger-actived-image">修改</a><div class="actions"><span class="action js-delete-actived-image close-modal" title="删除">×</span></div></div></div></div><div class="control-group"><div class="controls" style="margin-left: 0;"></div></div><p class="c-gray">图片尺寸要求：不大于128*100像素，支持PNG格式</p><div class="split-line"></div><div class="control-group control-group-link"><label class="control-label">链接：</label><div class="controls"><div class="dropdown hover"><a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div><input type="hidden" name="link_url"></div></div></div></li><li class="choice"><div class="app-nav"><div class="actions"><span class="action delete close-modal" title="删除">×</span></div><div class="app-nav-image-group clearfix"><div class="app-nav-image-normal pull-left"><p>普通：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="./template/user/default/images/shopnav_03.png" style="background-image: url(./template/user/default/images/shopnav_03.png);background-size: 64px 50px;"></div><a href="javascript:;" class="js-trigger-image">修改</a></div></div><div class="app-nav-image-active-box pull-left"><p>高亮（可选）：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="./template/user/default/images/shopnav_03_on.png" style="background-image: url(./template/user/default/images/shopnav_03_on.png);background-size: 64px 50px;"></div><a href="javascript:;" class="js-trigger-actived-image">修改</a><div class="actions"><span class="action js-delete-actived-image close-modal" title="删除">×</span></div></div></div></div><div class="control-group"><div class="controls" style="margin-left: 0;"><input type="hidden" name="image_url"></div></div><p class="c-gray">图片尺寸要求：不大于128*100像素，支持PNG格式</p><div class="split-line"></div><div class="control-group control-group-link"><label class="control-label">链接：</label><div class="controls"><div class="dropdown hover"><a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li><li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li><li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a> </li></ul></div><input type="hidden" name="link_url"></div></div></div></li></ul></div><p class="add-shopnav js-add-nav hide" style="display: block;">+ 添加导航</p>';
        nav_styles[3] = '<div class="shopnav-background-color"><span>底色：<span></span><input type="color" name="background_color" class="span2" value="#2B2D30"> <a href="javascript:;" class="btn js-reset-background-color">重置</a> </span></div><p class="shop-nav-class">添加中间主图标</p><div class="js-main-icon-setting main-icon-setting"><ul class="choices ui-sortable"><li class="choice"><div class="app-nav"><div class="actions"><span class="action delete close-modal" title="删除">×</span></div><div class="app-nav-image-group clearfix"><div class="app-nav-image-normal pull-left"><p>普通：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="" style=""></div><a href="javascript:;" class="js-trigger-image">选择</a></div></div><div class="app-nav-image-active-box pull-left"><p>高亮（可选）：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="" style=""></div><a href="javascript:;" class="js-trigger-actived-image">选择</a></div></div></div><div class="control-group"><div class="controls" style="margin-left: 0;"></div></div><p class="c-gray">图片尺寸要求：不大于128*100像素，支持PNG格式</p><div class="split-line"></div><div class="control-group control-group-link"><label class="control-label">链接：</label><div class="controls"><div class="dropdown hover"><a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li><li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li><li><a class="js-modal-cart" data-type="cart" href="javascript:;">购物车</a></li><li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div><input type="hidden" name="link_url"></div></div></div></li></ul></div><p class="shop-nav-class">添加两侧图标</p><p class="shop-nav-icon-tips">此导航模板建议您用两个或者四个自定义图标效果图最佳哦！</p><div class="js-nav-region clearfix"><ul class="choices ui-sortable"><li class="choice"><div class="app-nav"><div class="actions"><span class="action delete close-modal" title="删除">×</span></div><div class="app-nav-image-group clearfix"><div class="app-nav-image-normal pull-left"><p>普通：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="./template/user/default/images/shopnav_01.png" style="background-image: url(./template/user/default/images/shopnav_01.png);background-size: 64px 50px;"></div><a href="javascript:;" class="js-trigger-image">修改</a></div></div><div class="app-nav-image-active-box pull-left"><p>高亮（可选）：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="./template/user/default/images/shopnav_01_on.png" style="background-image: url(./template/user/default/images/shopnav_01_on.png);background-size: 64px 50px;"></div><a href="javascript:;" class="js-trigger-actived-image">修改</a><div class="actions"><span class="action js-delete-actived-image close-modal" title="删除">×</span></div></div></div></div><div class="control-group"><div class="controls" style="margin-left: 0;"></div></div><p class="c-gray">图片尺寸要求：不大于128*100像素，支持PNG格式</p><div class="split-line"></div><div class="control-group control-group-link"><label class="control-label">链接：</label><div class="controls"><div class="dropdown hover"><a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a> </li></ul></div><input type="hidden" name="link_url"></div></div></div></li><li class="choice"><div class="app-nav"><div class="actions"><span class="action delete close-modal" title="删除">×</span></div><div class="app-nav-image-group clearfix"><div class="app-nav-image-normal pull-left"><p>普通：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="./template/user/default/images/shopnav_02.png" style="background-image: url(./template/user/default/images/shopnav_02.png);background-size: 64px 50px;"></div><a href="javascript:;" class="js-trigger-image">修改</a></div></div><div class="app-nav-image-active-box pull-left"><p>高亮（可选）：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="./template/user/default/images/shopnav_02_on.png" style="background-image: url(./template/user/default/images/shopnav_02_on.png);background-size: 64px 50px;"></div><a href="javascript:;" class="js-trigger-actived-image">修改</a><div class="actions"><span class="action js-delete-actived-image close-modal" title="删除">×</span></div></div></div></div><div class="control-group"> <div class="controls" style="margin-left: 0;"></div></div> <p class="c-gray">图片尺寸要求：不大于128*100像素，支持PNG格式</p> <div class="split-line"></div> <div class="control-group control-group-link"> <label class="control-label">链接：</label> <div class="controls"><div class="dropdown hover"><a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div><input type="hidden" name="link_url"></div></div></div></li><li class="choice"><div class="app-nav"><div class="actions"><span class="action delete close-modal" title="删除">×</span></div><div class="app-nav-image-group clearfix"><div class="app-nav-image-normal pull-left"><p>普通：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="./template/user/default/images/shopnav_03.png" style="background-image: url(./template/user/default/images/shopnav_03.png);background-size: 64px 50px;"></div><a href="javascript:;" class="js-trigger-image">修改</a></div></div><div class="app-nav-image-active-box pull-left"><p>高亮（可选）：</p><div class="app-nav-image-box" style="background-color: #2B2D30"><div class="app-nav-image" data-image="./template/user/default/images/shopnav_03_on.png" style="background-image: url(./template/user/default/images/shopnav_03_on.png);background-size: 64px 50px;"></div><a href="javascript:;" class="js-trigger-actived-image">修改</a><div class="actions"><span class="action js-delete-actived-image close-modal" title="删除">×</span></div></div></div></div><div class="control-group"><div class="controls" style="margin-left: 0;"></div></div><p class="c-gray">图片尺寸要求：不大于128*100像素，支持PNG格式</p><div class="split-line"></div><div class="control-group control-group-link"><label class="control-label">链接：</label><div class="controls"><div class="dropdown hover"><a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div><input type="hidden" name="link_url"></div></div></div></li></ul></div><p class="add-shopnav js-add-nav hide" style="display: block;">+ 添加导航</p>';
        $('.edit-shopnav-header').nextAll().remove();
        $('.edit-shopnav-header').after(nav_styles[nav_style]);
        $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow");
        $('body').children('.modal-backdrop').fadeOut('slow');
        if (nav_style == 1) { //样式一
            $('.js-navmenu').html('<div class="nav-special-item nav-item"><a href="javascript:;" class="home">主页</a></div><div class="js-nav-preview-region nav-items-wrap"><div class="nav-items"></div></div>');
        } else if (nav_style == 2) { //样式二
            $('.js-navmenu').html('<div class="js-nav-preview-region"><ul class="nav-pop-sub"><li class="nav-item nav-pop-sub-item nav-pop-sub-item-1"><a href="javascript:;" style="background-image: url(./template/user/default/images/shopnav_01.png);background-size: 64px 50px"></a></li><li class="nav-item nav-pop-sub-item nav-pop-sub-item-2"><a href="javascript:;" style="background-image: url(./template/user/default/images/shopnav_02.png);background-size: 64px 50px"></a></li><li class="nav-item nav-pop-sub-item nav-pop-sub-item-3"><a href="javascript:;" style="background-image: url(./template/user/default/images/shopnav_03.png);background-size: 64px 50px"></a> </li></ul></div>');
        } else if (nav_style == 3) { //样式三
            $('.js-navmenu').html('<ul class="nav-pop-sub"><li class="nav-item nav-pop-sub-item nav-pop-sub-item-1"><a href="javascript:;" style="background-image: url(./template/user/default/images/shopnav_01.png);"></a></li><li class="nav-item nav-pop-sub-item nav-pop-sub-item-2"><a href="javascript:;" style="background-image: url(./template/user/default/images/shopnav_02.png);"></a></li><li class="nav-special-item nav-item js-nav-preview-mainIcon-region"><div><ul><li class=""><a href="javascript:;" style="background-image: url();border-color: #2B2D30;"></a></li></ul></div></li><li class="nav-item nav-pop-sub-item nav-pop-sub-item-3"><a href="javascript:;" style="background-image: url(./template/user/default/images/shopnav_03.png);"></a></li></ul>');
        }
        var old_style_id = $('.shopnav-style-id').val();
        $('.shopnav-style-id').val(nav_style);
        $('.js-navmenu').removeClass('nav-menu-' + old_style_id).addClass('nav-menu-' + nav_style);
        if ($("input[name='background_color']").val() != '' && $("input[name='background_color']").val() != undefined) {
            $('.js-navmenu').css('background-color', $("input[name='background_color']").val());
        } else {
            $('.js-navmenu').removeAttr('style');
        }
        $('.js-navmenu').removeClass().addClass('js-navmenu').addClass('nav-show').addClass('nav-menu-' + nav_style).addClass('nav-menu').addClass('has-menu-' + $('.nav-pop-sub > .nav-pop-sub-item').length);
    })

    //显示一级菜单删除按钮显示/隐藏
    $('.js-nav-region > .choices > .choice').live('hover', function(){
        //当前样式
        var shopnav_style_id = $('.shopnav-style-id').val();

        if(event.type=='mouseover'){
            $(this).children('div').children('.actions').show();
            if (shopnav_style_id > 1 && $(this).find('.app-nav-image-active-box > .app-nav-image-box > .app-nav-image').attr('style') != '') {
                $(this).find('.app-nav-image-active-box > .app-nav-image-box > .actions').show();
            }
        }else{
            $(this).children('div').children('.actions').hide();
            if (shopnav_style_id > 1 && $(this).find('.app-nav-image-active-box > .app-nav-image-box > .app-nav-image').attr('style') != '') {
                $(this).find('.app-nav-image-active-box > .app-nav-image-box > .actions').hide();
            }
        }
    })

    //一级菜单删除
    $('.js-nav-region > .choices > .choice > div > .actions > .close-modal').live('click', function(){
        //当前菜单样式
        var shopnav_style_id = $('.shopnav-style-id').val();
        var index = $(this).closest('.choice').index('.js-nav-region > .choices > .choice');
        $(this).closest('.choice').remove();
        if (shopnav_style_id == 1) { //样式一
            var old_navs = $('.nav-items > .nav-item-www').length;
            $('.nav-items > .nav-item-www').eq(index).remove();
            var new_navs = $('.nav-items > .nav-item-www').length;
            $('.js-navmenu').removeClass('has-menu-' + old_navs).addClass('has-menu-' + new_navs);
        } else if (shopnav_style_id == 2) { //样式二
            var old_navs = $('.nav-pop-sub > .nav-pop-sub-item').length;
            $('.nav-pop-sub > .nav-pop-sub-item').eq(index).remove();
            var new_navs = $('.nav-pop-sub > .nav-pop-sub-item').length;
            $('.js-navmenu').removeClass('has-menu-' + old_navs).addClass('has-menu-' + new_navs);
        } else if (shopnav_style_id == 3) { //样式三
            var old_navs = $('.nav-pop-sub > .nav-pop-sub-item').length;
            $('.nav-pop-sub > .nav-pop-sub-item').eq(index).remove();
            var new_navs = $('.nav-pop-sub > .nav-pop-sub-item').length;
            $('.js-navmenu').removeClass('has-menu-' + old_navs).addClass('has-menu-' + new_navs);
            if (new_navs == 2) {
                var tmp = $('.js-nav-preview-mainIcon-region').html();
                $('.nav-pop-sub > li').eq(2).html($('.nav-pop-sub > .nav-pop-sub-item:last').html()).removeClass().addClass('nav-item nav-pop-sub-item nav-pop-sub-item-2');
                $('.nav-pop-sub > li').eq(1).html(tmp).removeClass().addClass('nav-special-item nav-item js-nav-preview-mainIcon-region');
            } else if (new_navs == 1) {
                var tmp = $('.js-nav-preview-mainIcon-region').html();
                $('.nav-pop-sub > li').eq(0).html($('.nav-pop-sub > .nav-pop-sub-item:last').html()).removeClass().addClass('nav-item nav-pop-sub-item nav-pop-sub-item-2');
                $('.nav-pop-sub > li').eq(1).html(tmp).removeClass().addClass('nav-special-item nav-item js-nav-preview-mainIcon-region');
            } else if (new_navs == 0) {
                $('.js-nav-preview-mainIcon-region').before('<li class="nav-item nav-pop-sub-item no-nav-pop-sub-item"><a href="javascript:;"></a></li>');
            }
        }
        $('.js-add-nav').show();
    })

    //显示二级菜单删除按钮显示/隐藏
    $('.js-second-nav-region > .choices > .choice').live('hover', function(){
        if(event.type=='mouseover'){
            $(this).find('.actions').show();
        }else{
            $(this).find('.actions').hide();
        }
    })

    //二级菜单删除
    $('.js-second-nav-region > .choices > .choice > div > .actions > .close-modal').live('click', function(){
        var length = $(this).closest('.choice').siblings('.choice').length;
        if (length == 0) {
            $(this).closest('.second-nav').prev('.first-nav').find('.shopnav-item-split').nextAll().remove();
            $(this).closest('.second-nav').prev('.first-nav').find('.shopnav-item-split').after('<span class="pull-left">链接：</span><div class="pull-left"><div class="dropdown hover"><a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li> <a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
        }
        var index1 = $(this).closest('.js-second-nav-region').index('.js-second-nav-region');
        var index2 = $(this).closest('.choice').index('.js-second-nav-region:eq(' + index1 + ') > .choices > .choice');
        $(this).closest('.choice').remove();
        $('.nav-items > .nav-item-www:eq(' + index1 + ') > .js-submenu > .js-nav-2nd-region > ul > li:eq(' + index2 + ')').remove();
        if ($('.nav-items > .nav-item-www:eq(' + index1 + ') > .js-submenu > .js-nav-2nd-region > ul > li').length == 0) {
            $('.nav-items > .nav-item-www:eq(' + index1 + ') > a > .arrow-weixin').remove();
        }
    });

    //图标删除
    $('.js-delete-actived-image').live('click', function(){
        $(this).closest('.actions').hide();
        $(this).closest('.actions').prevAll('.app-nav-image').attr('style', '');
        $(this).closest('.actions').prev('.js-trigger-actived-image').html('选择');
    })

    //颜色修改
    $("input[name='background_color']").live('change', function(){
        $('.js-navmenu').css('background-color', $(this).val());
        $('.app-nav-image-box').css('background-color', $(this).val());
        if ($('.js-nav-preview-mainIcon-region').length) {
            $('.js-nav-preview-mainIcon-region').find('a').css('border-color', $(this).val());
        }
    })

    //颜色重置
    $('.js-reset-background-color').live('click', function(e){
        $("input[name='background_color']").val('#2B2D30');
        $('.js-navmenu').css('background-color', '#2B2D30');
        $('.app-nav-image-box').css('background-color', '#2B2D30');
        if ($('.js-nav-preview-mainIcon-region').length) {
            $('.js-nav-preview-mainIcon-region').find('a').css('border-color', '#2B2D30');
        }
    })

    //链接选取
    $('.js-choose').live('click', function(){
        var title = $(this).attr('data-title');
        var type = $(this).attr('data-page-type');
        var id = $(this).attr('data-id');
        var href = $(this).attr('href');
        if (type == 'feature') {
            title = '[微页面] ' + title;
        } else if (type == 'category') {
            title = '[微页面分类] ' + title;
        } else if (type == 'tag') {
            title = '[商品标签] ' + title;
        } else if (type == 'goods') {
            title = '[商品] ' + title;
        }
        if ($('.shopnav-item-link > .active').length){
            $('.shopnav-item-link > .active').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><a href="' + href + '" target="_blank" class="new-window link-to-title">' + title + '</a></div><div class="dropdown hover pull-right"><a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
        }
        if ($('.control-group-link > .active').length) {
            $('.control-group-link > .active').html('<div class="clearfix"><div class="pull-left js-link-to link-to"><a href="' + href + '" target="_blank" class="new-window link-to-title">' + title + '</a></div><div class="dropdown hover pull-right"><a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a><ul class="dropdown-menu"><li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li><li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li><li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li><li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>' + li_drp + '<li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li></ul></div></div>');
        }
        $('.modal').animate({'margin-top': '-1000px'}, "slow");
        $('body').children('.modal-backdrop').fadeOut('slow');
        if ($('.pull-left').hasClass('active')) {
            $('.pull-left').removeClass('active');
        }
        if ($('.controls').hasClass('active')) {
            $('.controls').removeClass('active');
        }
    })

    //上传图标
    $('.app-nav-image-box > a').live('click', function(){
        var shopnav_style_id = $('.shopnav-style-id').val();
        var index = $(this).closest('.choice').index('.js-nav-region > .choices > .choice')
        var obj = this;
        upload_pic_box(1,true,function(pic_list){
            if(pic_list.length > 0){
                for(var i in pic_list){
                    $(obj).prev('.app-nav-image').attr('data-image', pic_list[i]).attr('style', 'background-image: url(' + pic_list[i] + ');background-size: 64px 50px;');
                }
            } else {
                return false;
            }
            $(obj).html('修改');
            $(obj).removeClass('js-trigger-image').addClass('js-trigger-actived-image');
            if ($(obj).next('actions').length) {
                $(obj).next('.actions').show();
            } else {
                $(obj).after('<div class="actions"><span class="action js-delete-actived-image close-modal" title="删除">×</span></div>');
            }
            if ($(obj).closest('.app-nav-image-normal').length) {
                if (shopnav_style_id == 2) { //样式二
                    $('.js-nav-preview-region > .nav-pop-sub > .nav-pop-sub-item:eq(' + index + ') > a').attr('style', 'background-image: url(' + pic_list[i] + ');background-size: 64px 50px;');
                } else if (shopnav_style_id == 3) { //样式三
                    if ($(obj).closest('.js-main-icon-setting').length) {
                        $('.js-nav-preview-mainIcon-region > div > ul > li > a').attr('style', 'background-image: url(' + pic_list[i] + ');border-color: #2B2D30;');
                    } else {
                        $('.js-navmenu > .nav-pop-sub > .nav-pop-sub-item:eq(' + index + ') > a').attr('style', 'background-image: url(' + pic_list[i] + ');');
                    }
                }
            }
        },1);
    })

    //保存
    $('.btn-save').live('click', function(){
        //使用导航的页面
        var use_nav_pages = [];
        //导航样式
        var shopnav_style_id = $('.shopnav-style-id').val();
        //背景颜色
        var bgcolor = '';
        $("input[name='use_nav_page']:checked").each(function(i) {
            use_nav_pages[i] = $(this).val();
        })
        if ($("input[name='background_color']").length) {
            bgcolor = $("input[name='background_color']").val();
        }
        //一级/二级导航菜单
        var nav_menus = [];
        if ($('.choices > .choice').length) {
            if (shopnav_style_id == 1) { //样式一
                $('.js-nav-region > .choices > .choice').each(function(i){
                    var first_nav_menu_name = $(this).children('.first-nav').find('.shopnav-item > .shopnav-item-title > span').text(); //一级导航菜单名称
                    var first_nav_menu_link = $(this).children('.first-nav').find('.js-link-to > .link-to-title').text();
                    var first_nav_menu_url = ''; //一级导航菜单链接
                    if ($.trim(first_nav_menu_link) == '[店铺主页]') {
                        first_nav_menu_url = 'home';
                    }
                    if ($.trim(first_nav_menu_link) == '[会员主页]') {
                        first_nav_menu_url = 'ucenter';
                    }
                    if ($.trim(first_nav_menu_link) == '[我要分销]') {
                        first_nav_menu_url = 'drp';
                    }
                    /*if ($(this).find('.js-link-to > .link-to-title').attr('href')) {
                        first_nav_menu_url = $(this).find('.js-link-to > .link-to-title').attr('href');
                    }*/
                    if ($(this).find('.first-nav > .js-first-nav-item-meta-region > div > .shopnav-item > .shopnav-item-link > .pull-left > div > .js-link-to > .link-to-title').length > 0 && $(this).find('.first-nav > .js-first-nav-item-meta-region > div > .shopnav-item > .shopnav-item-link > .pull-left > div > .js-link-to > .link-to-title').attr('href')) {
                        first_nav_menu_url = $(this).find('.first-nav > .js-first-nav-item-meta-region > div > .shopnav-item > .shopnav-item-link > .pull-left > div > .js-link-to > .link-to-title').attr('href');
                    }
                    //二级导航菜单
                    var second_nav_menus = [];
                    if ($(this).find('.second-nav > .js-second-nav-region > .choices > .choice').length) {
                        $(this).find('.second-nav > .js-second-nav-region > .choices > .choice').each(function(j){
                            var second_nav_menu_name = $(this).find('.shopnav-item > .shopnav-item-title > span').text(); //二级导航菜单名称
                            var second_nav_menu_link = $(this).find('.js-link-to > .link-to-title').text();
                            var second_nav_menu_url = ''; //二级导航菜单链接
                            if ($.trim(second_nav_menu_link) == '[店铺主页]') {
                                second_nav_menu_url = 'home';
                            }
                            if ($.trim(second_nav_menu_link) == '[会员主页]') {
                                second_nav_menu_url = 'ucenter';
                            }
                            if ($.trim(second_nav_menu_link) == '[我要分销]') {
                                second_nav_menu_url = 'drp';
                            }
                            if ($(this).find('.js-link-to > .link-to-title').attr('href')) {
                                second_nav_menu_url = $(this).find('.js-link-to > .link-to-title').attr('href');
                            }
                            second_nav_menus[j] = {'name': second_nav_menu_name, 'text': second_nav_menu_link, 'url': second_nav_menu_url, 'image1': '', 'image2': ''};
                        })
                    }
                    nav_menus[i] = {'name': first_nav_menu_name, 'text': first_nav_menu_link, 'url': first_nav_menu_url, 'submenu': second_nav_menus, 'image1': '', 'image2': ''};
                })
            } else if (shopnav_style_id == 2) { //样式二
                $('.js-nav-region > .choices > .choice').each(function(i){
                    var image1 = $(this).find('.app-nav > .app-nav-image-group > .app-nav-image-normal > .app-nav-image-box > .app-nav-image').attr('data-image');
                    var image2 = $(this).find('.app-nav > .app-nav-image-group > .app-nav-image-active-box > .app-nav-image-box > .app-nav-image').attr('data-image');
                    var first_nav_menu_link = $(this).find('.js-link-to > .link-to-title').text();
                    var first_nav_menu_url = ''; //一级导航菜单链接
                    if ($.trim(first_nav_menu_link) == '[店铺主页]') {
                        first_nav_menu_url = 'home';
                    }
                    if ($.trim(first_nav_menu_link) == '[会员主页]') {
                        first_nav_menu_url = 'ucenter';
                    }
                    if ($.trim(first_nav_menu_link) == '[我要分销]') {
                        first_nav_menu_url = 'drp';
                    }
                    if ($(this).find('.js-link-to > .link-to-title').attr('href')) {
                        first_nav_menu_url = $(this).find('.js-link-to > .link-to-title').attr('href');
                    }
                    nav_menus[i] = {'name': '', 'text': first_nav_menu_link, 'url': first_nav_menu_url, 'submenu': [], 'image1': image1, 'image2': image2};
                });
            } else if (shopnav_style_id == 3) { //样式三
                $('.js-main-icon-setting > .choices > .choice').each(function(i){
                    var image1 = $(this).find('.app-nav > .app-nav-image-group > .app-nav-image-normal > .app-nav-image-box > .app-nav-image').attr('data-image');
                    var image2 = $(this).find('.app-nav > .app-nav-image-group > .app-nav-image-active-box > .app-nav-image-box > .app-nav-image').attr('data-image');
                    var first_nav_menu_link = $(this).find('.js-link-to > .link-to-title').text();
                    var first_nav_menu_url = ''; //一级导航菜单链接
                    if ($.trim(first_nav_menu_link) == '[购物车]') {
                        first_nav_menu_url = 'cart';
                    }
                    if ($.trim(first_nav_menu_link) == '[店铺主页]') {
                        first_nav_menu_url = 'home';
                    }
                    if ($.trim(first_nav_menu_link) == '[会员主页]') {
                        first_nav_menu_url = 'ucenter';
                    }
                    if ($.trim(first_nav_menu_link) == '[我要分销]') {
                        first_nav_menu_url = 'drp';
                    }
                    if ($(this).find('.js-link-to > .link-to-title').attr('href')) {
                        first_nav_menu_url = $(this).find('.js-link-to > .link-to-title').attr('href');
                    }
                    nav_menus[i] = {'name': '', 'text': first_nav_menu_link, 'url': first_nav_menu_url, 'submenu': [], 'image1': image1, 'image2': image2};
                })
                $('.js-nav-region > .choices > .choice').each(function(i){
                    i++;
                    var image1 = $(this).find('.app-nav > .app-nav-image-group > .app-nav-image-normal > .app-nav-image-box > .app-nav-image').attr('data-image');
                    var image2 = $(this).find('.app-nav > .app-nav-image-group > .app-nav-image-active-box > .app-nav-image-box > .app-nav-image').attr('data-image');
                    var first_nav_menu_link = $(this).find('.js-link-to > .link-to-title').text();
                    var first_nav_menu_url = ''; //一级导航菜单链接
                    if ($.trim(first_nav_menu_link) == '[店铺主页]') {
                        first_nav_menu_url = 'home';
                    }
                    if ($.trim(first_nav_menu_link) == '[会员主页]') {
                        first_nav_menu_url = 'ucenter'
                    }
                    if ($.trim(first_nav_menu_link) == '[我要分销]') {
                        first_nav_menu_url = 'drp'
                    }
                    if ($(this).find('.js-link-to > .link-to-title').attr('href')) {
                        first_nav_menu_url = $(this).find('.js-link-to > .link-to-title').attr('href');
                    }
                    nav_menus[i] = {'name': '', 'text': first_nav_menu_link, 'url': first_nav_menu_url, 'submenu': [], 'image1': image1, 'image2': image2};
                });
            }
            $.post(store_nav_url, {'use_nav_pages': use_nav_pages, 'style_id': shopnav_style_id, 'bgcolor': bgcolor, 'nav_menus': nav_menus}, function(data){
                if(!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 2000);
            })
        } else {
            layer_alert(1,'请添加导航菜单！');
            return false;
        }
    })
})

function check_url(url) {
    var reg = new RegExp();
    reg.compile("^(http|https)://.*?$");
    if (!reg.test(url)) {
        return false;
    }
    return true;
}

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}

