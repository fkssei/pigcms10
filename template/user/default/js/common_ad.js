/**
 * Created by pigcms_21 on 2015/2/6.
 */
$(function(){
    load_page('.app__content',load_url,{page:'ad_content'},'',function(){
        location_page(action);
    });

    //启用店铺导航
    $('.ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(open_ad_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //关闭店铺导航
    $('.ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_ad_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })
});

function location_page(action){
    switch(parseInt(action)){
        case 0:
            load_page('.app__content', load_url,{page:'ad_content'}, '',function(){
                page_create(action);
            });
            break;
        case 1:
            load_page('.app__content', load_url,{page:'ad_edit_content'},'',function(){
                var editDataDom = $('#edit_data');
                $('.js-config-region .app-field').data({'position':editDataDom.attr('position'),'page':editDataDom.attr('page')});
                page_create(action);
                customField.setHtml($('#edit_custom').attr('custom-field'));

                $('#edit_data,#edit_custom').remove();
            });
            break;
    }
}

function page_create(emptyData){
    defaultFieldObj = $('.js-config-region .app-field');
    if(emptyData == 0) defaultFieldObj.data({'position': 0, 'page':''});
    defaultFieldObj.click(function(){
        $('.app-entry .app-field').removeClass('editing');
        $(this).addClass('editing');
        var rightHtml = $('<div><form class="form-horizontal" novalidate=""><div class="control-group"><label class="control-label"><em class="required">*</em>展示位置：</label><div class="controls"> <label class="radio inline"><input type="radio" name="position" value="0" />页面头部</label><label class="radio inline"><input type="radio" name="position" value="1">页面底部</label></div></div><div class="control-group"><label class="control-label">出现的页面：</label><div class="controls"><label class="checkbox inline"><input type="checkbox" class="js-not-autoupdate" name="page" value="0">微页面</label><label class="checkbox inline"><input type="checkbox" class="js-not-autoupdate" name="page" value="1">微页面分类</label><label class="checkbox inline"><input type="checkbox" class="js-not-autoupdate" name="page" value="2">商品</label><label class="checkbox inline"><input type="checkbox" class="js-not-autoupdate" name="page" value="3">商品标签</label></div><div class="controls"><label class="checkbox inline"><input type="checkbox" class="js-not-autoupdate" name="page" value="5">店铺主页</label><label class="checkbox inline"><input type="checkbox" class="js-not-autoupdate" name="page" value="4">会员主页</label></div></div></form></div>');
        $('.js-sidebar-region').html(rightHtml);
        //展示位置
        rightHtml.find("input:radio[value='" + $(this).data('position') + "']").attr('checked', true);
        rightHtml.find("input:radio[name='position']").change(function(){
            defaultFieldObj.data({'position': $(this).val()});
        });
        //出现的页面
        var pages = $(this).data('page');
        if (pages.length > 0) {
            for (key in pages) {
                if (pages[key]) {
                    rightHtml.find("input:checkbox[value='" + pages[key] + "']").attr('checked', true);
                }
            }
        } else {
            defaultFieldObj.data({'page': ''});
        }
        rightHtml.find("input:checkbox[name='page']").change(function(){
            var tmp_page = defaultFieldObj.data('page');
            tmp_page = tmp_page.split(',');

            if (!$(this).is(':checked')) {
                var key = $.inArray($(this).val(), tmp_page);
                if (key >= 0){
                    delete tmp_page[key];
                }
            } else {
                tmp_page.push($(this).val());
            }
            if (defaultFieldObj.data('page') == '') {
                defaultFieldObj.data('page', $(this).val());
            } else {
                defaultFieldObj.data('page', tmp_page.toString());
            }
        });
        $('.js-sidebar-region').html(rightHtml);
        $('.app-sidebar').css('margin-top',$(this).offset().top - $('.app-preview').offset().top);
    });
    defaultFieldObj.trigger('click');
    customField.init();
}

$('.form-actions .btn-save').live('click',function(){
    var post_data = {};
    post_data.action = action;
    post_data.position = $("input[name='position']:checked").val();
    if (post_data.position == undefined) {
        post_data.position = 0;
    }
    var pages = [];
    $("input[name='page']:checked").each(function(i) {
        pages[i] = $(this).val();
    })
    post_data.pages = pages.toString();
    post_data.custom = customField.checkEvent();
    /*if(post_data.custom == '') {
        layer_tips(1,'请添加内容！');
        return false;
    }*/
    $.post(save_ad_url,post_data,function(data){
        if (!data.err_code) {
            $('.notifications').html('<div class="alert in fade alert-success">保存成功</div>');
            location_page(1);
            t = setTimeout('msg_hide()', 3000);
        }
    });
});

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}