<style type="text/css">
    .dash-bar .info-group {
        float: left;
        width: 25.33%;
        padding-top: 18px;
    }
    .widget .chart-body {
        height: 345px;
    }
    .form-horizontal input {
        width: 206px!important;
    }
    .form-actions input {
        width: auto!important;
        height: auto;
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
                    data:['销售额','佣金']
                },
                grid: {
                    x: 80,
                    y: 60,
                    x2: 80,
                    y2: 60,
                    width : '730px',
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
                        name:'销售额',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_sales; ?>
                    },
                    {
                        name:'佣金',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_profits; ?>
                    }
                ]
            });
        }
    );
</script>
<div class="dash-bar clearfix">
    <div class="js-cont">
        <div class="info-group">
            <div class="info-group__inner">
                    <span class="h4">
                        <a href="<?php dourl('goods'); ?>"><?php echo $fx_product_count; ?></a>
                    </span>
                <span class="info-description">分销商品数</span>
            </div>
        </div>
        <div class="info-group">
            <div class="info-group__inner">
                    <span class="h4">
                        <a href="<?php echo dourl('order:all'); ?>">￥<?php echo $sales; ?></a>
                    </span>
                <span class="info-description">销售额</span>
            </div>
        </div>
        <div class="info-group">
            <div class="info-group__inner">
                    <span class="h4">
                        <a href="<?php echo dourl('trade:income'); ?>">￥<?php echo $profit; ?></a>
                    </span>
                    <span class="info-description">
                        佣金
                        <i>-</i>
                        <a href="<?php echo dourl('trade:income'); ?>">提现</a>
                    </span>
            </div>
        </div>
    </div>
</div>
<div id="js-pagedata" class="widget widget-pagedata">
    <div class="widget-inner">
        <div class="widget-head">
            <h3 class="widget-title">7天分销趋势</h3>
            <ul class="widget-nav">
                <li>
                    <a href="<?php dourl('statistics'); ?>" class="new-window" target="_blank">详细 》</a>
                </li>
            </ul>
            <div class="help">
                <a href="javascript:void(0);" class="js-help-notes"></a>
                <div class="js-notes-cont hide">
                    <p><strong>销售额：</strong>分销商出售分销商品的总金额。</p>
                    <p><strong>佣金：</strong>分销商出售分销商品获得的利润。</p>
                </div>
            </div>
        </div>
        <div class="widget-body with-border">
            <div class="js-body widget-body__inner clearfix">
                <div class="js-body-chart chart-body" id="chart-body">
                    <div class="widget-chart-no-data">暂无数据</div>
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
            var help_content = $('.js-notes-cont').html();
            var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 12) + 'px; left: ' + ($(this).offset().left - 20) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + help_content + '</div></div></div>';
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