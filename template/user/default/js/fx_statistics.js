/**
 * Created by pigcms_21 on 2015/5/8.
 */
$(function(){
    load_page('.app__content', load_url, {page:'statistics_content', 'store_id': store_id}, '');

    //开始时间
    $('#js-start-time').live('focus', function() {
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            showTimepicker: false,
            showButtonPanel: false,
            beforeShow: function() {
                if ($('#js-end-time').val() != '') {
                    $(this).datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
                }
            },
            onSelect: function() {
                if ($('#js-start-time').val() != '') {
                    $('#js-end-time').datepicker('option', 'minDate', new Date($('#js-start-time').val()));
                }
            }
        };
        $('#js-start-time').datetimepicker(options);
    })


    //结束时间
    $('#js-end-time').live('focus', function(){
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            showTimepicker: false,
            showButtonPanel: false,
            beforeShow: function() {
                if ($('#js-start-time').val() != '') {
                    $(this).datepicker('option', 'minDate', new Date($('#js-start-time').val()));
                }
            },
            onSelect: function() {
                if ($('#js-end-time').val() != '') {
                    $('#js-start-time').datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
                }
            }
        };
        $('#js-end-time').datetimepicker(options);
    })

    //最近7天或30天
    $('.js-filter-quickday > li').live('click', function(){
        var tmp_days = $(this).attr('data-days');
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $('.js-start-time').val(changeDate(tmp_days).begin);
        $('.js-end-time').val(changeDate(tmp_days).end);
    })

    //筛选
    $('.js-filter-btn').live('click', function(){
        var start_time = $('#js-start-time').val();
        var stop_time = $('#js-end-time').val();
        var index = $('.js-filter-quickday > .active').index('.js-filter-quickday > li');
        load_page('.app__content', load_url, {page:'statistics_content', 'start_time': start_time, 'stop_time': stop_time, 'store_id': store_id}, '', function(){
            $('.js-start-time').val(start_time);
            $('.js-end-time').val(stop_time);
            $('.js-filter-quickday > li').removeClass('active');
            $('.js-filter-quickday > li').eq(index).addClass('active');
        });
    })
})

function changeDate(days){
    var today=new Date(); // 获取今天时间
    var begin;
    var endTime;
    if(days == 3){
        today.setTime(today.getTime()-3*24*3600*1000);
        begin = today.format('yyyy-MM-dd');
        today = new Date();
        today.setTime(today.getTime()-1*24*3600*1000);
        end = today.format('yyyy-MM-dd');
    }else if(days == 7){
        today.setTime(today.getTime()-7*24*3600*1000);
        begin = today.format('yyyy-MM-dd');
        today = new Date();
        today.setTime(today.getTime()-1*24*3600*1000);
        end = today.format('yyyy-MM-dd');
    }else if(days == 30){
        today.setTime(today.getTime()-30*24*3600*1000);
        begin = today.format('yyyy-MM-dd');
        today = new Date();
        today.setTime(today.getTime()-1*24*3600*1000);
        end = today.format('yyyy-MM-dd');
    }
    return {'begin': begin, 'end': end};
}

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