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
                    data:['店铺浏览次数','店铺浏览人数', '商品浏览次数', '商品浏览人数']
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
                        name:'店铺浏览次数',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_pv; ?>
                    },
                    {
                        name:'店铺浏览人数',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_uv; ?>
                    },
                    {
                        name:'商品浏览次数',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_goods_pv; ?>
                    },
                    {
                        name:'商品浏览人数',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_goods_uv; ?>
                    }
                ]
            });
        }
    );
</script>
<div class="js-app-inner app-inner-wrap hide" style="display: block;">

    <div id="js-store-board" class="ui-store-board">
        <dl class="clearfix">
            <dt class="js-store-board-logo ui-store-board-logo">
                <a href="<?php dourl('setting:store'); ?>" <?php if (empty($store_session['logo'])) { ?>style="background-image:url(<?php echo TPL_URL;?>images/shop2.png!145x145.jpg);"<?php } else { ?>style="background-image:url(<?php echo $store_session['logo']; ?>);"<?php } ?>>
                    <i class="hide" style="display: none;">修改</i>
                </a>
            </dt>
            <dd class="ui-store-board-desc">
                <h2><?php echo $store_session['name']; ?></h2>
                <nav>
                    <a class="ui-btn ui-btn-success" href="<?php dourl('goods:create'); ?>">+发布商品</a>
                    <a class="js-create-template ui-btn ui-btn-success" href="<?php dourl('wei_page'); ?>#create">+新建微页面</a>
                    <a class="ui-btn visit-store" href="javascript:void(0);" data-ui-version="3" data-class="bottom center">访问店铺</a>
                    <span class="js-notes-cont hide">
                        <p>手机扫码访问：</p>
                        <p class="team-code">
                            <img src="./source/qrcode.php?type=home&id=<?php echo $store_session['store_id']; ?>" alt="">
                        </p>
                        <p>
                            <a class="js-help-notes-btn-copy" href="javascript:void(0);" data-clipboard-text="<?php echo $config['wap_site_url'];?>/home.php?id=<?php echo $store_session['store_id']; ?>">复制页面链接</a>
                            <a href="<?php echo $config['wap_site_url'];?>/home.php?id=<?php echo $store_session['store_id']; ?>" target="_blank">电脑上查看</a>
                        </p>
                    </span>
                </nav>
            </dd>
        </dl>
        <?php if ($store_session['approve']) { ?>
            <!--<div class="ui-store-board-cert-waiting">已认证</div>-->
        <?php } else { ?>
            <!--<div class="ui-store-board-cert-died">未认证</div>-->
        <?php } ?>
    </div>

    <div id="js-overview" class="ui-overview">
        <div class="overview-group">
            <div class="overview-group-inner">
                <span class="h4"><?php echo $store_pv_yesterday; ?></span>
                <span class="h5">昨日店铺浏览次数</span>
            </div>
        </div>
        <div class="overview-group">
            <div class="overview-group-inner">
                <span class="h4"><?php echo $store_uv_yesterday; ?></span>
                <span class="h5">昨日店铺浏览人数</span>
            </div>
        </div>
        <div class="overview-group">
            <div class="overview-group-inner">
                <span class="h4"><?php echo $goods_pv_yesterday; ?></span>
                <span class="h5">昨日商品浏览次数</span>
            </div>
        </div>
        <div class="overview-group">
            <div class="overview-group-inner">
                <span class="h4"><?php echo $goods_uv_yesterday; ?></span>
                <span class="h5">昨日商品浏览人数</span>
            </div>
        </div>
        <div class="overview-group">
            <div class="overview-group-inner">
                <a class="h4" href="<?php dourl('store:wei_page'); ?>"><?php echo $wei_page_total; ?></a>
                <span class="h5">微页面</span>
            </div>
        </div>
        <div class="overview-group">
            <div class="overview-group-inner">
                <a class="h4" href="<?php dourl('goods:index'); ?>"><?php echo $product_total; ?></a>
                <span class="h5">商品</span>
            </div>
        </div>
    </div>

    <div id="js-pageview" class="ui-block app-block-pageview">
        <div class="ui-block-head">
            <h3 class="block-title">流量趋势</h3>
            <div class="block-help">
                <a href="javascript:void(0);" class="js-help-notes"></a>

                <div class="js-notes-cont hide">
                    <p><strong>店铺浏览次数：</strong>浏览当前店铺页面的次数；</p>
                    <p><strong>店铺浏览人数：</strong>浏览当前店铺页面的人数；</p>
                    <p><strong>商品浏览次数：</strong>浏览当前店铺的单品页的次数；</p>
                    <p><strong>商品浏览人数：</strong>浏览当前店铺的单品页的人数。</p>
                </div>
            </div>
        </div>
        <div class="ui-block-body has-border has-padding">
            <div class="js-body app-block-body-inner" id="chart-body" style="cursor: default;">

            </div>
        </div>
    </div>

    <div id="js-pagerank" class="ui-block app-block-pagerank ui-block-no-data">
        <div class="ui-block-head">
            <h3 class="block-title">7天浏览排行</h3>
            <div class="block-help">
                <a href="javascript:void(0);" class="js-help-notes"></a>

                <div class="js-notes-cont hide">
                    <p>浏览次数/人数：页面被访问的用户数和浏览次数；</p>
                </div>
            </div>
        </div>

        <div class="ui-block-body">
            <div class="js-body" <?php if (empty($analytics)) { ?>style="display: none"<?php } ?>>
            <table class="ui-table">
                <thead>
                    <tr>
                        <th class="cell-37">页面名称</th>
                        <th class="cell-12">浏览人数/次数</th>
                    </tr>
                </thead>
                <tbody class="js-list-tbody">
                <?php if (!empty($analytics)) { ?>
                <?php foreach ($analytics as $analytic) { ?>
                    <tr>
                        <td class="">
                            <?php
                            switch ($analytic['module']) {
                                case 'home':
                                    $url = 'wap/home.php?id=' . $analytic['store_id'];
                                    break;
                                case 'ucenter':
                                    $url = 'wap/ucenter.php?id=' . $analytic['page_id'];
                                    break;
                                case 'wei_page_category':
                                    $url = 'wap/pagecat.php?id=' . $analytic['store_id'];
                                    break;
                                case 'wei_page':
                                    $url = 'wap/page.php?id=' . $analytic['page_id'];
                                    break;
                                case 'goods_group':
                                    $url = 'wap/goodcat.php?id=' . $analytic['page_id'];
                                    break;
                                case 'goods':
                                    $url = 'wap/good.php?id=' . $analytic['page_id'];
                                    break;
                                case 'search':
                                    $url = 'wap/search.php?store_id=' . $analytic['page_id'];
                                    break;
                                default:
                                    $url = 'javascript:void(0);';
                                    break;
                            }
                            ?>
                            <a href="<?php echo $url; ?>" class="new-window" target="_blank"><?php echo $analytic['title']; ?></a>
                        </td>
                        <td><?php echo $analytic['uv'];?> / <?php echo $analytic['pv']; ?></td>
                    </tr>
                <?php } ?>
                <?php } ?>
                </tbody>
            </table>
            </div>
            <?php if (empty($analytics)) { ?>
            <div class="js-block-content ui-block-no-data-content">
                <p><strong>暂无数据</strong></p>
                <p>
                    您可以 <a href="<?php dourl('goods:create'); ?>">创建商品</a> 或
                    <a class="js-create-template" href="<?php dourl('wei_page'); ?>#create">创建微页面</a>，发送给您的微信粉丝。
                </p>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    var t0 = '';
    var t = '';
    var t2 = '';
    $(function(){
        $('.visit-store').hover(function(){
            //复制链接
            $.getScript('./static/js/plugin/jquery.zclip.min.js',function() {
                $('.js-help-notes-btn-copy').zclip({
                    path: './static/js/plugin/ZeroClipboard.swf',
                    copy: function () {
                        return $('.js-help-notes-btn-copy').attr('data-clipboard-text');
                    },
                    afterCopy: function () {
                        $('.notifications').html('<div class="alert in fade alert-success">复制成功</div>');
                        t0 = setTimeout('msg_hide()', 3000);
                    }
                });
            })
            var content = $(this).next('.js-notes-cont').html();
            $('.popover-intro').remove();
            var html = '<div class="js-intro-popover popover popover-intro bottom center" style="display: none; top: ' + ($(this).offset().top + $(this).height() + 7) + 'px; left: ' + $(this).offset().left + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + content + '</div></div></div>';
            $('body').append(html);
            $('.popover-intro').show();
        }, function(){
            t = setTimeout('hide()', 200);
        })

        $('.popover-intro').live('mouseleave', function(){
            clearTimeout(t);
            hide();
        })

        $('.popover-intro').live('mouseover', function(){
            clearTimeout(t);
        })

        $('.js-help-notes').hover(function(){
            var content = $(this).next('.js-notes-cont').html();
            $('.popover-help-notes').remove();
            var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 16) + 'px; left: ' + ($(this).offset().left - 250) +'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + content + '</div></div></div>';
            $('body').append(html);
            $('.popover-help-notes').show();
        }, function(){
            t2 = setTimeout('hide2()', 200);
        })

        $('.popover-help-notes').live('hover', function(event){
            if (event.type == 'mouseenter') {
                clearTimeout(t2);
            } else {
                clearTimeout(t2);
                hide2();
            }
        })
    })

    function hide() {
        $('.popover-intro').remove();
    }
    function hide2() {
        $('.popover-help-notes').remove();
    }
    function msg_hide() {
        $('.notifications').html('');
        clearTimeout(t0);
    }
</script>