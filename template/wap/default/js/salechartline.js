// JavaScript Document

//today
$(function () {
    $('#today').click(function() {
        var url = $('.url').val() + '&type=today';
        $.post(url, '', function (data) {
            var date = GetToDayPrice(data);
            $('#totaltoday').highcharts({
                chart: {
                    type: 'line'
                },
                title: {
                    text: '销售额统计'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: ['00:00-6:00', '6:00-12:00', '12:00-18:00', '18:00-24:00']
                },
                yAxis: {
                    title: {
                        text: '销售额(元)'
                    },
                    min: 0,
                    labels : {
                        formatter : function () {return this.value.toFixed(2);}
                    }
                },
                tooltip: {
                    enabled: false,
                    formatter: function () {
                        return '<b>' + this.series.name + '</b><br/>' + this.x + ': ' + this.y + '°C';
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true,
                            formatter: function() { return this.y.toFixed(2);}
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    name: '时间',
                    data: date
                }]
            });
        });
    }).trigger('click');
});	

//yestoday
$(function () {
    $('#yesterday').click(function(){
        var url = $('.url').val() + '&type=yesterday';
        $.post(url, '', function(data){
            var yesterday = GetYesterDayPrice(data);
            $('#yestoday').highcharts({
                chart: {
                    type: 'line'
                },
                title: {
                    text: '销售额统计'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: ['00:00-6:00', '6:00-12:00', '12:00-18:00', '18:00-24:00']
                },
                yAxis: {
                    title: {
                        text: '销售额(元)'
                    },
                    min: 0,
                    labels : {
                        formatter : function () {return this.value.toFixed(2);}
                    }
                },
                tooltip: {
                    enabled: false,
                    formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'°C';
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true,
                            formatter: function() { return this.y.toFixed(2);}
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    name: '时间',
                    data: yesterday
                }]
            });
        })
    })

});
//weekday
$(function () {
    $('#week').click(function(){
        var url = $('.url').val() + '&type=week';
        $.post(url, '', function(data){
            var thisweek = GetThisWeekPrice(data);
            $('#weekday').highcharts({
                chart: {
                    type: 'line'
                },
                title: {
                    text: '销售额统计'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
                },
                yAxis: {
                    title: {
                        text: '销售额(元)'
                    },
                    min: 0,
                    labels : {
                        formatter : function () {return this.value.toFixed(2);}
                    }
                },
                tooltip: {
                    enabled: false,
                    formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'°C';
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true,
                            formatter: function() { return this.y.toFixed(2);}
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    name: '时间',
                    data: thisweek
                }]
            });
        });
    })
});

//moonth
$(function () {
    $('#month').click(function(){
        var url = $('.url').val() + '&type=month';
        $.post(url, '', function(data){
            var data = $.parseJSON(data);
            var lastday = data.data.lastday;
            var data = data.data.monthsaletotal;
            var thismonth = GetThisMonthPrice(data);
            $('#moonth').highcharts({
                chart: {
                    type: 'line'
                },
                title: {
                    text: '销售额统计'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: ['01-07', '07-14', '14-21', '21-' + lastday]
                },
                yAxis: {
                    title: {
                        text: '销售额(元)'
                    },
                    min: 0,
                    labels : {
                        formatter : function () {return this.value.toFixed(2);}
                    }
                },
                tooltip: {
                    enabled: false,
                    formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'°C';
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true,
                            formatter: function() { return this.y.toFixed(2);}
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    name: '时间',
                    data: thismonth
                }]
            });
        })
    })
});	