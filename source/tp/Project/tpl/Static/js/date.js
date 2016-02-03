$(function(){
    //开始时间
    $('#js-start-time').live('focus', function() {
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js-end-time').val() != '') {
                    $(this).datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
                }
            },
            onSelect: function() {
                if ($('#js-start-time').val() != '') {
                    $('#js-end-time').datepicker('option', 'minDate', new Date($('#js-start-time').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($(this).datepicker('getDate'), $('#js-end-time').datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js-end-time').datepicker('getDate'));
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
        $('#js-start-time').datetimepicker(options);
    })


    //结束时间
    $('#js-end-time').live('focus', function(){
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js-start-time').val() != '') {
                    $(this).datepicker('option', 'minDate', new Date($('#js-start-time').val()));
                }
            },
            onSelect: function() {
                if ($('#js-end-time').val() != '') {
                    $('#js-start-time').datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($('#js-start-time').datepicker('getDate'), $(this).datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js-start-time').datepicker('getDate'));
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
        $('#js-end-time').datetimepicker(options);
    })


    //最近7天或30天
    $('.date-quick-pick').live('click', function(){
        $(this).addClass('current');
        $(this).siblings('.date-quick-pick').removeClass('current');

        var tmp_days = $(this).attr('data-days');
        $('#js-start-time').val(changeDate(tmp_days).begin);
        $('#js-end-time').val(changeDate(tmp_days).end);
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
    return {'begin': begin + ' 00:00:00', 'end': end + ' 23:59:59'};
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