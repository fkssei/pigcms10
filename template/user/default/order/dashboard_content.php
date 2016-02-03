<style type="text/css">
    .widget .chart-body {
        height: 310px;
    }
</style>
<script type="text/javascript">
    require.config({
        paths: {
            echarts: './static/js/echart'
        }
    });

    require(
        [
            'echarts',
            'echarts/chart/line',
        ],
        function (ec) {
            var myChart = ec.init(document.getElementById('chart-body'));
            myChart.setOption({
                tooltip : {
                    trigger: 'axis',
                    backgroundColor : 'white',
                    borderColor : 'black',
                    borderWidth : 2,
                    borderRadius : 5,
                    textStyle : {color : 'black'},
                    axisPointer : {
                        type: 'line',
                        lineStyle: {
                            color: '#8FD1FA',
                            width: 1,
                            type: 'dotted'
                        }
                    }
                },
                legend: {
                    data:['下单笔数','付款订单', '发货订单']
                },
                grid: {
                    x: 80,
                    y: 60,
                    x2: 80,
                    y2: 60,
                    width : '700px',
                    backgroundColor: 'rgba(0,0,0,0)',
                    borderWidth: 0,
                    borderColor: '#ccc'
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        axisLine : {show : false},
                        axisTick : {show : false},
                        splitLine : {show : false},
                        data : <?php echo $days; ?>
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        axisLine : {show : false},
                        splitArea : {show : false},
                        splitLine : {
                            show : true,
                            lineStyle : {
                                color: ['#ccc'],
                                width: 1,
                                type: 'dotted'
                            }
                        }
                    }
                ],
                series : [
                    {
                        name:'下单笔数',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_orders; ?>
                    },
                    {
                        name:'付款订单',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_paid_orders; ?>
                    },
                    {
                        name:'发货订单',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_send_orders; ?>
                    }
                ]
            });
        }
    );
</script>
<div class="js-app-inner app-inner-wrap hide" style="display: block;">

    <div id="js-overview" class="dash-bar clearfix">
        <div class="js-cont dash-todo__body">
            <div class="info-group">
                <div class="info-group__inner">
                    <span class="h4">
                        <a href="<?php dourl('all', array('start_time' => $start_time, 'stop_time' => $stop_time)); ?>"><?php echo $week_orders; ?></a>
                    </span>
                    <span class="info-description">7天下单笔数</span>
                </div>
            </div>
            <div class="info-group">
                <div class="info-group__inner">
                    <span class="h4">
                        <a href="<?php dourl('all', array('status' => 1)); ?>"><?php echo $not_paid_orders; ?></a>
                    </span>
                    <span class="info-description">待付款</span>
                </div>
            </div>
            <div class="info-group">
                <div class="info-group__inner">
                    <span class="h4">
                        <a href="<?php dourl('all', array('status' => 2)); ?>"><?php echo $not_send_orders; ?></a>
                    </span>
                    <span class="info-description">待发货</span>
                </div>
            </div>
            <div class="info-group">
                <div class="info-group__inner">
                    <span class="h4">
                        <a href="<?php dourl('all', array('status' => 3)); ?>"><?php echo $send_orders; ?></a>
                    </span>
                    <span class="info-description">已发货</span>
                </div>
            </div>
            <div class="info-group">
                <div class="info-group__inner">
                    <span class="h4">
                        <a href="<?php dourl('trade:income'); ?>">￥<?php echo $days_7_income; ?></a>
                    </span>
                    <span class="info-description">
                        7天收入
                        <i>-</i>
                        <a href="<?php dourl('trade:income'); ?>">提现</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div id="js-pagedata" class="widget widget-pagedata">
        <div class="widget-inner">
            <div class="widget-head">
                <h3 class="widget-title">7天订单趋势</h3>
                <ul class="widget-nav">
                    <li>
                        <a href="<?php dourl('statistics'); ?>" class="new-window" target="_blank">详细 》</a>
                    </li>
                </ul>
                <div class="help">
                    <a href="javascript:void(0);" class="js-help-notes"></a>
                    <div class="js-notes-cont hide">
                        <p><strong>下单笔数：</strong>所有用户的下单总数。</p>
                        <p><strong>付款订单：</strong>已付款的订单总数；</p>
                        <p><strong>发货订单：</strong>已发货的订单总数。</p>
                    </div>
                </div>
            </div>
            <div class="widget-body with-border">
                <div class="js-body widget-body__inner clearfix">
                    <ul class="js-body-desc chart-desc">
                        <li>
                            <p class="num">
                                <a href="<?php dourl('all', array('start_time' => $yesterday_start_time, 'stop_time' => $yesterday_stop_time)); ?>"><?php echo $yesterday_orders; ?></a>
                            </p>
                            <p class="title">昨日下单笔数</p>
                        </li>
                        <li>
                            <p class="num">
                                <a href="<?php dourl('all', array('status' => 2, 'start_time' => $yesterday_start_time, 'stop_time' => $yesterday_stop_time)); ?>"><?php echo $yesterday_paid_orders; ?></a>
                            </p>
                            <p class="title">昨日付款订单</p>
                        </li>
                        <li>
                            <p class="num">
                                <a href="<?php dourl('all', array('status' => 3, 'start_time' => $yesterday_start_time, 'stop_time' => $yesterday_stop_time)); ?>"><?php echo $yesterday_send_orders; ?></a>
                            </p>
                            <p class="title">昨日发货订单</p>
                        </li>
                    </ul>
                    <div class="js-body-chart chart-body" id="chart-body">
                        <div class="widget-chart-no-data">暂无数据</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var t= '';
    $(function(){
        $('.js-help-notes').hover(function(){
            $('.popover-help-notes').remove();
            var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 12) + 'px; left: ' + ($(this).offset().left - 20) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p><strong>下单笔数：</strong>所有用户的下单总数。</p><p><strong>付款订单：</strong>已付款的订单总数；</p><p><strong>发货订单：</strong>已发货的订单总数。</p></div></div></div>';
            $('body').append(html);
            $('.popover-help-notes').show();
        }, function(){
            t = setTimeout('hide()', 200);
        })

        $('.popover-help-notes').live('mouseleave', function(){
            clearTimeout(t);
            hide();
        })

        $('.popover-help-notes').live('mouseover', function(){
            clearTimeout(t);
        })

    })

    function hide() {
        $('.popover-help-notes').remove();
    }
</script>