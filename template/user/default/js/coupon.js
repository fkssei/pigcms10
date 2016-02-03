/**
 * Created by pigcms-s on 2015/06/16.
 */
$(function() {
   // load_page('.app__content', load_url, {page:'coupon_index'}, '');


})


$(function() {
    location_page(location.hash, 1);

    $(".js-list-filter-region a").live('click', function () {
        var action = $(this).attr("href");
        location_page(action, 1)
    });

    $(".js-page-list a").live("click", function () {
        var page = $(this).data("page-num");
        location_page(window.location.hash, page);
    });

    //指定优惠券de人详情list
    $(".info_detail_person").live("click",function() {
        var action = $(this).attr("href");
        location_page(action, 1)

    })


    $('a').live('click',function(){
        if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#') location_page($(this).attr('href'),$(this));
    });
    function location_page(mark, page){
        var mark_arr = mark.split('/');

        switch(mark_arr[0]){
            case '#create':
                load_page('.app__content', load_url,{page:'coupon_create'}, '');
                break;
            case "#edit":
                if(mark_arr[1]){
                    load_page('.app__content', load_url,{page:'coupon_edit',coupon_id:mark_arr[1]},'',function(){

                 });
                }else{
                    layer.alert('非法访问！');
                    location.hash = '#list';
                    location_page('');
                }
                break;

            case "#future" :
                load_page('.app__content', load_url, {page : 'coupon_index', "type" : 'future', "p" : page}, '');
                break;
            case "#on" :

                load_page('.app__content', load_url, {page : 'coupon_index', "type" :'on', "p" : page}, '');
                break;
            case "#end" :

                load_page('.app__content', load_url, {page : 'coupon_index', "type" : 'end', "p" : page}, '');
                break;

            case "#fetchlist":
                if(mark_arr[1]){
                    load_page('.app__content', load_url,{page:'fetchlist',coupon_id:mark_arr[1], "p" : page},'',function(){

                    });
                }else{
                    layer.alert('非法访问！');
                    location.hash = '#list';
                    location_page('');
                }
                break;

            default:
                load_page('.app__content', load_url,{page:'coupon_index',"type": 'all', "p" : page}, '');
        }
    }

    //分页
    $('.pagenavi > a').live('click', function(e){
        var p = $(this).attr('data-page-num');

        location_page(window.location.hash, p);

    });

//格式化时间
    Date.prototype.format = function(format){
        var o = {
            "M+" : this.getMonth()+1, //month
            "d+" : this.getDate(),    //day
            "h+" : this.getHours(),   //hour
            "m+" : this.getMinutes(), //minute
            "s+" : this.getSeconds(), //second
            "q+" : Math.floor((this.getMonth()+3)/3),  //quarter
            "S" : this.getMilliseconds() //millisecond
        }
        if(/(y+)/.test(format)) {
            format=format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
        }
        for(var k in o) {
            if(new RegExp("("+ k +")").test(format)) {
                format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
            }
        }
        return format;
    }

    //开始时间
    $('#js_start_time').live('focus', function() {
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js_end_time').val() != '') {
                    $(this).datepicker('option', 'maxDate', new Date($('#js_end_time').val()));
                }
            },
            onSelect: function() {
                if ($('#js_start_time').val() != '') {
                    $('#js_end_time').datepicker('option', 'minDate', new Date($('#js_start_time').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($(this).datepicker('getDate'), $('#js_end_time').datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js_end_time').datepicker('getDate'));
                }
            },
            _afterClose: function(date1, date2) {
                var starttime = 0;
                if (date1 != '' && date1 != undefined) {
                    starttime = new Date(date1).getTime();
                }
                var endtime = 0;
                if (date2 != '' && date2 != undefined) {
                    endtime = new Date(date2).getTime();
                }
                if (endtime > 0 && endtime < starttime) {
                    alert('无效的时间段');
                    return false;
                }
                return true;
            }
        };
        $('#js_start_time').datetimepicker(options);
    })


    //结束时间
    $('#js_end_time').live('focus', function(){
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js_start_time').val() != '') {
                    $(this).datepicker('option', 'minDate', new Date($('#js_start_time').val()));
                }
            },
            onSelect: function() {
                if ($('#js_end_time').val() != '') {
                    $('#js_start_time').datepicker('option', 'maxDate', new Date($('#js_end_time').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($('#js_start_time').datepicker('getDate'), $(this).datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js_start_time').datepicker('getDate'));
                }
            },
            _afterClose: function(date1, date2) {
                var starttime = 0;
                if (date1 != '' && date1 != undefined) {
                    starttime = new Date(date1).getTime();
                }
                var endtime = 0;
                if (date2 != '' && date2 != undefined) {
                    endtime = new Date(date2).getTime();
                }
                if (starttime > 0 && endtime < starttime) {
                    alert('无效的时间段');
                    return false;
                }
                return true;
            }
        };
        $('#js_end_time').datetimepicker(options);
    })

    //面值checkbox 触发事件
    $(".js-is-random").live('change', function(){
          if($(this).find("input[name='is_random']").is(':checked') == true){
           $(".js-random").show();
       } else {
            $(".js-random").hide();
       }
    })



    //错误提示设定
    function error_tips(obj,message){
        obj.closest(".control-group").addClass('error');
        obj.closest(".control-group").find(".error-message").remove();
        var err_message = '<p class="help-block error-message">'+message+'</p>';
        obj.closest(".controls").append(err_message);
    }
    //清除错误提示设定
    function clear_error_tips(obj){
        obj.closest(".control-group").removeClass('error');
        obj.closest(".control-group").find(".error-message").remove();
    }


    //表单提交验证
    function check_form() {
        var  yhq_value = $.trim($("input[name='name']").val());  //优惠券名称
        var yhqmz_value = $.trim($("input[name='value']").val()); //优惠券面值 下限
        //var yhqmz_to_value = $.trim($("input[name='value_random_to']").val());  //优惠券面值上限
        var total = $.trim($("input[name='total']").val());      //发放总量
        var is_at_least = $("input[name='is_at_least']:checked").val();    //订单金额选择
        var at_least = $.trim($("input[name='at_least']").val());
        var start_at = $("input[name='start_at']").val();           //生效时间
        var end_at = $("input[name='end_at']").val();                //过期时间
        var coupon_type = $("input[name='coupon_type']:checked").val();    //券类型

        var is_exists_err = false;
        //券类型不能为空
        if(coupon_type=='1' || coupon_type == '2'){ }else{
            is_exists_err = true;
            error_tips( $("input[name='coupon_type']"),'券类型请选择！');
        }

        //优惠券名称不能为空
        if (yhq_value == '' ) {is_exists_err = true;
            error_tips( $("input[name='name']"),'优惠券名称必须在 1-10 个字内');
        } else {
            if (yhq_value.length > 9)  error_tips( $("input[name='name']"),'优惠券名称必须在 1-10 个字内');
            if (yhq_value.indexOf("测试") > -1)  error_tips( $("input[name='name']"),'请不要输入包含"测试"字样的卡券标题');
        }

        //优惠券面值不能为空
        if (yhqmz_value == '') {is_exists_err = true;
            error_tips( $("input[name='value']"),'优惠券面值必须大于等于 0.01 元');
        } else{
            if (.01 > yhqmz_value) {is_exists_err = true;return "优惠券面值范围必须大于等于 0.01 元";}
        }

        //发放总量不能为空
        if (total == '') {is_exists_err = true;
            error_tips( $("input[name='total']"),'发放总量必须是一个整数');
        }

        //生效时间
        if ($("input[name='start_at']").val() == '') {
            is_exists_err = true;
            error_tips( $("input[name='start_at']"),'必须选择一个生效时间');
        }

        //过期时间
        if ($("input[name='end_at']").val() == '') {
            is_exists_err = true;
           // $("input[name='end_at']").focus();
            error_tips( $("input[name='end_at']"),'必须选择一个过期时间');
        }

        //订单金额选择

        if('1' == is_at_least){
            if(!at_least) {
                is_exists_err = true;
                error_tips($("input[name='at_least']"), '请填写优惠券使用金额下限金额');
            }else{

                if(parseInt(yhqmz_value) > parseInt(at_least)) {
                    is_exists_err = true;
                    error_tips($("input[name='at_least']"), '订单限制金额必须大于等于优惠券的面值额');
                }
            }


        }

        return is_exists_err;
    }


    $("input[name='is_at_least']").live("change",function(){
        var at_least =$("input[name='at_least']").val();
        var  isat_least =  $(this).val();
        switch(isat_least){
            case '0':
                $("#is_at_least").html('无限制');
                clear_error_tips($("input[name='at_least']"));
                break;

            case '1':

                if(!(/^(\+|-)?\d+$/.test( at_least )) || at_least < 0 || at_least== '') {
                    is_exists_err = true;
                    error_tips($("input[name='at_least']"), '必须是一个整数')
                } else{
                    $("#is_at_least").html('<span id="is_at_least">订单满 <span id="jtje">'+at_least+'</span> 元 (含运费)</span>');
                }
                break;

        }


    })

       $("input[name='name']").live("keyup",function(){
           if ($(this).val().length > 10)
           //如果元素区字符数大于最大字符数，按照最大字符数截断；

            $(this).val($(this).val().substring(0, 10));


       })




    $("input[name='coupon_type']").live("change",function(){

        var  coupon_typs =  $(this).val();
        switch(coupon_typs){
            case '1':case '2':
             clear_error_tips($("input[name='coupon_type']"));
            break;
        }

    })



    //表单失焦-
    function check_form_blur(input_name){
        var  yhq_value = $.trim($("input[name='name']").val());  //优惠券名称
        var yhqmz_value = $.trim($("input[name='value']").val()); //优惠券面值 下限
        var yhqmz_to_value = $.trim($("input[name='value_random_to']").val());  //优惠券面值上限
        var total = $.trim($("input[name='total']").val());      //发放总量
        var is_at_least = $("input[name='is_at_least']:checked").val();    //订单金额选择
        var at_least = $("input[name='at_least']").val();
        var start_at = $("input[name='start_at']").val();           //生效时间
        var end_at = $("input[name='end_at']").val();                //过期时间

        switch(input_name){
            case 'name':         //优惠券名称
                if (yhq_value == '' ) {
                    error_tips( $("input[name='name']"),'优惠券名称必须在 1-10 个字内');
                } else {
                    if (yhq_value.length > 10) { error_tips( $("input[name='name']"),'优惠券名称必须在 1-10 个字内');}
                    else if (yhq_value.indexOf("测试") > -1)  {error_tips( $("input[name='name']"),'请不要输入包含"测试"字样的卡券标题');}
                    else {
                        clear_error_tips($("input[name='name']"));
                        $("#mobile_name").html(yhq_value);
                    }
                }
                break;

            case 'value':   //优惠券面值
            case 'value_random_to':
                if (yhqmz_value == '')  {
                    error_tips( $("input[name='value']"),'优惠券面值必须大于等于 0.01 元');
                } else if (0.01 > yhqmz_value) {
                    error_tips( $("input[name='value']"), "优惠券面值范围必须大于等于 0.01 元");
                } else if(  $("input[name='is_random']").is(':checked') == true  ){

                    if(yhqmz_value*1 >= 1*yhqmz_to_value){
                        error_tips( $("input[name='value']"), "优惠券面值范围的上限必须大于下限");
                    }else{
                        clear_error_tips($("input[name='value']"));
                        var yhq_values = yhqmz_value + "~" + yhqmz_to_value;
                        $("#mobile_value").html(yhq_values);
                    }
                }  else {
                    clear_error_tips($("input[name='value']"));
                        var yhq_values = yhqmz_value;

                    $("#mobile_value").html(yhq_values);
                }
                break;


            //订单金额
            case 'at_least':
                    if(!at_least) at_least = "xx";
                    if(!(/^(\+|-)?\d+$/.test( at_least )) || at_least < 0 || at_least== '') {
                        error_tips( $("input[name='at_least']"),'必须是一个整数')
                    }else{
                       if(is_at_least==1) {
                           $("#is_at_least").html('<span id="is_at_least">订单满 <span id="jtje">'+at_least+'</span> 元 (含运费)</span>');
                       }
                        clear_error_tips($("input[name='at_least']"));
                    }
                break;

            case 'total':        //发放总量

                if(!(/^(\+|-)?\d+$/.test( total )) || total < 0 || total== '') {
                    error_tips( $("input[name='total']"),'发放总量必须是一个整数');
                } else {
                    clear_error_tips($("input[name='total']"));
                }

                break;

            case 'start_at':    //生效时间
                if(!start_at) {
                    error_tips( $("input[name='start_at']"),'必须选择一个生效时间！');
                } else {
                    clear_error_tips($("input[name='start_at']"));
                }
                break;

            case 'end_at':      //过期时间
                if(!end_at) {
                    error_tips( $("input[name='end_at']"),'必须选择一个生效时间！');
                } else {

                    clear_error_tips($("input[name='end_at']"));
                }
                break;
        }

    }

    //失焦事件
    $(".app-sidebar-inner input").live("blur",function(){
        var input_name = $(this).attr("name");
        check_form_blur(input_name);
    })

    //提交保存优惠券
    $('.js-btn-save').live('click', function() {
        //验证表单
          if(check_form()){return false;}
       var form_coupon_type =  $("input[name='coupon_type']:checked").val();

        var form_yhq_value = $.trim($("input[name='name']").val());  //优惠券名称
        var form_yhqmz_value = $.trim($("input[name='value']").val()); //优惠券面值 下限
        var form_yhqmz_to_value = $.trim($("input[name='value_random_to']").val());  //优惠券面值上限
        var form_total = $.trim($("input[name='total']").val());      //发放总量
        var form_is_at_least = $("input[name='is_at_least']:checked").val();    //订单金额选择
        var form_at_least = $("input[name='at_least']").val();
        if("1" === form_is_at_least ) {
            var form_at_least2 = form_at_least;
        } else {
            var form_at_least2 = '0.00';
        }
        var form_start_at = $("input[name='start_at']").val();                                                  //生效时间
        var form_end_at = $("input[name='end_at']").val();                                                      //过期时间
        var form_most_have = $("select[name='quota']").val();                                                   //每人限领
        var form_total = $("input[name='total']").val();                                                        //发放总量
        // var  form_is_expire_notice =$("input[name='expire_notice']:checked").val();                              //到期是否通知
        //  var  form_is_share = $("input[name='is_share']:checked").val()?'1':'0';                                  //是否允许分享领取链接
        var form_range_type = $("input[name='range_type']:checked").val();

        if ($("input[name='expire_notice']").is(':checked')) {
            var form_is_expire_notice = 1;
        } else {
            var form_is_expire_notice = 0;
        }
        //是否仅限原价购买商品时可用
        if ($("input[name='is_forbid_preference']").is(':checked')) {
            var form_is_original_price = 1;
        } else {
            var form_is_original_price = 0;
        }
        //是否允许分享领取链接
        if ($("input[name='is_share']").is(':checked')) {
            var form_is_share = 1;
        } else {
            var form_is_share = 0;
        }


        var description = $("textarea[name='description']").val();
        var arrs2_add=[];
        if (form_range_type == 'part'){
           // var product_ids = $(".js-goods-list").attr("pid_arr");
            $(".js-goods-list  .sort").each(function(){
                arrs2_add.push($(this).attr("data-pid"))
            })
            product_ids= arrs2_add.join("-");
            var form_is_product = "1";
         }else{
            var product_ids = "";
            var form_is_product = "0";
        }

        $.post(load_url, {"page" : page_coupon_create, "name" : form_yhq_value, "face_money" : form_yhqmz_value , "limit_money": form_at_least2 ,"most_have":form_most_have,"total_amount":form_total, "start_time" : form_start_at, "end_time" : form_end_at,"is_expire_notice":form_is_expire_notice,"is_share":form_is_share,"is_all_product":form_is_product,"is_original_price":form_is_original_price,"description":description, "product_id" : product_ids,coupon_type:form_coupon_type, "is_submit" : "submit"}, function (data) {

            if (data.err_code == '0') {
                layer_tips(0, data.err_msg);
                var t = setTimeout(couponList(), 2000);
                return;
            } else {
                layer_tips(1, data.err_msg);
                return;
            }
        });

    })


    //修改保存优惠券
    $('.js-btn-edit-save').live('click', function() {
        //验证表单
        if(check_form()){return false;}


        var form_yhq_value = $.trim($("input[name='name']").val());  //优惠券名称
        var form_yhqmz_value = $.trim($("input[name='value']").val()); //优惠券面值 下限
        var form_yhqmz_to_value = $.trim($("input[name='value_random_to']").val());  //优惠券面值上限
        var form_total = $.trim($("input[name='total']").val());      //发放总量
        var form_is_at_least = $("input[name='is_at_least']:checked").val();    //订单金额选择
        var form_at_least = $("input[name='at_least']").val();
        var form_coupon_type = $("input[name='coupon_type']:checked").val();
        if("1" === form_is_at_least ) {
            var form_at_least2 = form_at_least;
        } else {
            var form_at_least2 = '0.00';
        }
        var form_start_at = $("input[name='start_at']").val();                                                  //生效时间
        var form_end_at = $("input[name='end_at']").val();                                                      //过期时间
        var form_most_have = $("select[name='quota']").val();                                                   //每人限领
        var form_total = $("input[name='total']").val();                                                        //发放总量
        // var  form_is_expire_notice =$("input[name='expire_notice']:checked").val();                              //到期是否通知
        //  var  form_is_share = $("input[name='is_share']:checked").val()?'1':'0';                                  //是否允许分享领取链接
        var form_range_type = $("input[name='range_type']:checked").val();
        if ($("input[name='expire_notice']").is(':checked')) {
            var form_is_expire_notice = 1;
        } else {
            var form_is_expire_notice = 0;
        }
        //是否仅限原价购买商品时可用
        if ($("input[name='is_forbid_preference']").is(':checked')) {
            var form_is_original_price = 1;
        } else {
            var form_is_original_price = 0;
        }
        //是否允许分享领取链接
        if ($("input[name='is_share']").is(':checked')) {
            var form_is_share = 1;
        } else {
            var form_is_share = 0;
        }


        var description = $("textarea[name='description']").val();
        var arrs2_edit=[];
        if (form_range_type == 'part'){
          //  var product_ids = $(".js-goods-lists").attr("pid_arr");
            $(".js_add_goods_from_edit1 .sort").each(function(){
                arrs2_edit.push($(this).attr("data-pid"))
            })
             product_ids= arrs2_edit.join("-")

            var form_is_product = "1";
        }else{
            var product_ids = "";
            var form_is_product = "0";
        }

       var couponid = $("#couponid").val();
        $.post(load_url, {"page" : page_coupon_edit, "name" : form_yhq_value,'coupon_id':couponid, "face_money" : form_yhqmz_value , "limit_money": form_at_least2 ,"most_have":form_most_have,"total_amount":form_total, "start_time" : form_start_at, "end_time" : form_end_at,"is_expire_notice":form_is_expire_notice,"is_share":form_is_share,"is_all_product":form_is_product,"is_original_price":form_is_original_price,"description":description, "product_id" : product_ids,coupon_type:form_coupon_type, "is_submit" : "submit"}, function (data) {

            if (data.err_code == '0') {
                layer_tips(0, data.err_msg);
                var t = setTimeout(couponList(), 2000);
                return;
            } else {
                layer_tips(1, data.err_msg);
                return;
            }
        });

    })

    function couponList() {
        location.href = "user.php?c=preferential&a=coupon";
    }

    $("input[name='range_type']").live("change",function(){
        var range_type = $(this).val();
        if(range_type == 'part') {$(".js-add-goods,.js_add_goods_from_edit").show();$(".js-goods-list,.js_add_goods_from_edit1").show();} else {$(".js-add-goods,.js_add_goods_from_edit").hide();$(".js-goods-list,.js_add_goods_from_edit1").hide();}

    })

    //添加商品弹窗显示
    var good_datas=[];var arrs=[];var strs;
    var domHtml = $(".js-goods-list");var html;
    var good_datas_id = domHtml.data('goods');

         widget_link_box1($('.app-sidebar-inner').find('.js-add-goods'),'do_selfgood',function(result){
             var  good_data = result;
             $('.js-goods-list .sort').remove();
            html = '<tr><th class="cell-30">商品名称</th> <th class="cell-50">商品名称</th> <th class="cell-20">操作</th></tr>';
            for(var i in good_data){
                var item = good_data[i];
                if($.inArray(item.id, arrs)>=0){
                }else{
                    html += '<tr class="sort" data-pid="'+item.id+'"><td><a classs="aaa" href="' + item.url + '"  target="_blank"><img src="' + item.image + '"  alt="' + item.title + '" title="' + item.title + '" width="50" height="50"></a </td><td><a href="' + item.url + '" class="aaa">' + item.title + item.title + item.title + '</a></td> <td><a class=" js-delete-goods" href="javascript:void(0)" data-id="0" title="删除">×</a></td> </tr>';
                    arrs.push(item.id);
                    strs= arrs.join("-")
                    $(".js-goods-list").attr("pid_arr",strs);
                }
            }
            $('.js-goods-list').prepend(html);



            //删除选取的商品
            $('.js-add-goods').find('.module-goods-list .sort .js-delete-goods').click(function(){
                $(this).closest('.sort').remove();
                var good_data = domHtml.data('goods');
                delete good_data[$(this).data('id')];
                domHtml.data('goods',good_data);
            });


        })

  //  })



    //修改页面-添加商品弹窗显示
    var good_datas2=[];var arrs2=[];var strs2;
    var domHtml2 = $(".js-goods-lists");var html2;
    var good_datas_id2 = domHtml2.data('goods');


    widget_link_box1($('.app-sidebar-inner').find('.js_add_goods_from_edit'),'do_selfgood',function(result){

        var aaa = $(".js_add_goods_from_edit1").attr("pid_arr");
            arrs2 = aaa.split('-');


        var good_data = result;
       // var tips_is_product = $(".tips_is_product").val();
        var tips_is_product = ($("input[name='range_type']:checked").val()=='part')?'1':'0';

       if(!tips_is_product) html2 = '<tr><th class="cell-30">商品名称</th> <th class="cell-50">商品名称</th> <th class="cell-20">操作</th></tr>';
        for(var i in good_data){
            var item = good_data[i];
            var itemid = parseInt(item.id);
            var  sitemid = itemid.toString();
            //'"'+item.id+'"'
            var tip_key = true;
            if($.inArray(sitemid, arrs2)>=0){

                tip_key = false;
            } else{
                html2 += '<tr class="sort" data-pid="'+item.id+'"><td><a classs="aaa" href="' + item.url + '"  target="_blank"><img src="' + item.image + '"  alt="' + item.title + '" title="' + item.title + '" width="50" height="50"></a </td><td><a href="' + item.url + '" class="aaa">' + item.title + '</a></td> <td><a class=" js-delete-goods" href="javascript:void(0)" data-id="0" title="删除">×</a></td> </tr>';
                arrs2.push(item.id);
                strs2 = arrs2.join("-");
                $(".js-goods-lists").attr("pid_arr",strs2);
                tip_key = true;
            }
        }
        if(tip_key) {
            $('.js-goods-lists tbody').append(html2);
        }


        //删除选取的商品
        $('.js-goods-lists').find('.module-goods-list .sort .js-delete-goods').click(function(){
            $(this).closest('.sort').remove();
            var good_data = domHtml.data('goods');
            delete good_data[$(this).data('id')];
            domHtml.data('goods',good_data);
        });


    })



    //限制文本框输入的字数
    $("textarea[name='description']").live("keydown",function(){
        var textObj = $("textarea[name='description']");

        var curLength= textObj.val().length;
        strLenCalc(textObj,'syzs',60);
    })



    function strLenCalc(obj, checklen, maxlen) {
        $(".controls_syzs").show();
        var v = obj.val(), charlen = 0, maxlen = !maxlen ? 200 : maxlen, curlen = maxlen, len = v.length;
        for(var i = 0; i < v.length; i++) {
            if(v.charCodeAt(i) < 0 || v.charCodeAt(i) > 255) {
                curlen -= 1;
            }
        }

        if(curlen >= len) {
            $("#"+checklen).html(" "+Math.floor((curlen-len)/2)+" ").css('color', '');


        } else {
            var contents = obj.val().substr(0,30);
            obj.val(contents);
            $("#"+checklen).html(" "+Math.ceil((len-curlen)/2)+" ").css('color', '#FF0000');



        }

    }



// 使优惠券失效
    $(".js-disabled").live("click", function (e) {
        var disabled_obj = $(this);
        var coupon_id = disabled_obj.parent().data("coupon_id");
        button_box($(this), e, 'left', 'confirm', '确定让这组优惠券失效?<br><span class="red">失效后将导致该优惠券无法被领取和编辑</span>', function(){
            $.get(disabled_url, {"id" : coupon_id}, function (data) {
                close_button_box();
                if (data.err_code == "0") {
                    disabled_obj.closest("tr").find("td").eq(4).html("已结束");
                    disabled_obj.parent().html("已失效");
                    layer_tips(0, data.err_msg);
                } else {
                    layer_tips(1, data.err_msg);
                }
            })
        });
    });

    // 删除优惠券
    $('.js-delete').live("click", function(e){
        var delete_obj = $(this);
        var coupon_id = $(this).parent().data('coupon_id');
        $('.js-delete').addClass('active');
        button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
            $.get(delete_url, {'id': coupon_id}, function(data) {
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
    });


    // 删除可用商品
    $(".js-delete-goods").live("click",function(){
        var goods_obj = $(this);
        var tables_obj = $(this).closest("table");
        if($(this).closest("table").hasClass("js-goods-list")) {
           // var pid_arr_str2 = $(".js-goods-list").attr("pid_arr");
        } else {
         //   var pid_arr_str2 = $(".js-goods-lists").attr("pid_arr");
        }
        //   var pid_arr_arr2 = pid_arr_str2.split("-");

        button_box($(this), event, 'left', 'confirm', '确认删除？', function(){
              var pid_this =  goods_obj.closest("tr").attr("data-pid");
                goods_obj.closest("tr").remove();
            //    var arr3=$.grep(pid_arr_arr2,function(n,i){
             //       return n!=pid_this;
            //    });

           //      var str3 =  arr3.join("-");
           //      tables_obj.attr("pid_arr",str3);
                 close_button_box();
        })

    })


    // 编辑资料
    $(".js-edit").live("click", function () {
        location_page($(this).attr("href"));
    });



    //回车提交搜索
    $(window).keydown(function(event){
        if (event.keyCode == 13 && $('.js-coupon-keyword').is(':focus')) {
            var keyword = $('.js-coupon-keyword').val();
            var type = window.location.hash.substring(1);

            $('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type}, function(){
            });
        }
    })

    // 取消
    $(".js-btn-quit").live("click", function () {
        location.href = "user.php?c=preferential&a=coupon";
    })

    //
    function msg_hide() {
        $('.notifications').html('');
        clearTimeout(t);
    }

    $(".js-link").live('click',function(e){

        button_box($(this),e,'left','copy',wap_coupon_url+'?cid='+$(this).closest('tr').attr('service_id'),function(){
            layer_tips(0,'复制成功');
        });
    })





})


//
function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}










