<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <title>本店订单 - <?php echo $store['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/drp_control.css"/>
    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_foundation.js"></script>
    <meta class="foundation-data-attribute-namespace"/>
    <meta class="foundation-mq-xxlarge"/>
    <meta class="foundation-mq-xlarge"/>
    <meta class="foundation-mq-large"/>
    <meta class="foundation-mq-medium"/>
    <meta class="foundation-mq-small"/>
    <script src="<?php echo TPL_URL; ?>js/foundation.alert.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_iscroll.js" type="text/javascript"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_iscrollAssist.js" type="text/javascript" charset="gb2312"></script>
    <script type="text/javascript">
        var status = 1; //待付款
        var page = 1;
        var PAGESIZE = 10;
        var MaxPage = 0;
        var MaxPage_1 = Math.ceil(parseInt('<?php echo $not_paid_orders; ?>') / PAGESIZE);
        var MaxPage_2 = Math.ceil(parseInt('<?php echo $paid_orders; ?>') / PAGESIZE);

        $(function () {
            $("#tabs_dl dd").click(function () {
                $("#dataArea table > tbody").html('');
                $("#tabs_dl dd").removeClass("active");
                $(this).addClass("active");
                status = $(this).data("status");
                if (status == 1) {
                    MaxPage = MaxPage_1;
                } else if (status == 2) {
                    MaxPage = MaxPage_2;
                }
                $("#dataArea").hide();
                page = 1;
                FillData(status, page, PAGESIZE);
            })
            $("#tabs_dl dd").eq(0).trigger('click');
        })

        function FillData(status, _pagenum, _pagesize) {
            $.post("./drp_order.php", {
                'type': 'get',
                'status': status,
                'p': _pagenum,
                'pagesize': _pagesize
            }, function (data) {
                if (data != '') {
                    var response = $.parseJSON(data);
                } else {
                    var response = '';
                }
                if (response != '' && response.data != '') {
                    $("#ordernull").hide();
                    if (response.count == 0) {
                        MaxPage--;
                    }
                    if (response.count < PAGESIZE || page > MaxPage) {
                        if (page > 1) {
                            page--;
                        }
                        hasMoreData = false;
                        $("#pullUp").hide();
                    } else {
                        hasMoreData = true;
                        $("#pullUp").show();
                    }
                    $("#dataArea table > tbody").append(response.data);
                    $("#dataArea").show();
                } else if ($("#dataArea table > tbody > tr").length <= 1) {
                    $("#dataArea").hide();
                    $("#ordernull").show();
                }
                return false;
            })
        }

        (function ($) {
            $(function () {
                var pulldownAction = function () {
                    /*$("#dataArea").hide();
                    page = 1;
                    FillData(status, 1, PAGESIZE);*/
                    this.refresh();
                    //下拉
                };
                var pullupAction = function () {
                    if (hasMoreData) {
                        page++;
                        if (page <= MaxPage) {
                            FillData(status, page, PAGESIZE);
                        }
                        else {
                            page--;
                        }
                    }
                    this.refresh();
                    //上拉
                };
                var iscrollObj = iscrollAssist.newVerScrollForPull($('#wrapper'), pulldownAction, pullupAction);
                iscrollObj.refresh();
            });
        })(jQuery);
    </script>
    <style type="text/css">
        tr {
            border: 1px solid #ebebeb;;
        }
        .left {
            float: none!important;
        }
    </style>
</head>
<body>

<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a class="menu-icon" href="javascript:window.history.go(-1);"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">本店订单</h1>
        </section>
    </nav>
</div>
<dl id="tabs_dl" class="tabs tab-title3" data-tab="">
    <dd class="active" data-status="1"><a href="javascript:void(0)">待付款(<?php echo $not_paid_orders; ?>)</a></dd>
    <dd data-status="2"><a href="javascript:void(0)">已付款(<?php echo $paid_orders; ?>)</a></dd>
</dl>
<div class="tabs-content" id="wrapper">
    <div id="scroller" class="content active">
        <div id="pulldown" class="idle">
            <span class="pullDownIcon"></span><span class="pullDownLabel" id="pulldown-label"></span>
        </div>

        <div id="dataArea">
            <table width="100%">
                <thead>
                    <tr>
                        <th class="left">编号</th>
                        <th class="left">粉丝</th>
                        <th class="right">金额（元）</th>
                        <th style="text-align: center">时间</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="nocontent-tip" id="ordernull" style="">
            <i class="icon-nocontent-worry"></i>
            <p class="nocontent-tip-text">你还没有订单</p>
        </div>

        <div id="pullup" class="idle">
            <span class="pullUpIcon"></span><span class="pullUpLabel" id="pullup-label"></span>
        </div>
    </div>
    <div class="iScrollVerticalScrollbar iScrollLoneScrollbar" style="position: absolute; z-index: 9999; width: 7px; bottom: 2px; top: 2px; right: 1px; pointer-events: none;">
        <div class="iScrollIndicator" style="box-sizing: border-box; position: absolute; border: 1px solid rgba(180, 180, 180, 0.901961); border-radius: 2px; opacity: 0.8; width: 100%; transition: 0ms cubic-bezier(0.1, 0.57, 0.1, 1); -webkit-transition: 0ms cubic-bezier(0.1, 0.57, 0.1, 1); display: none; height: 845px; transform: translate(0px, 0px) translateZ(0px); background-image: -webkit-gradient(linear, 0% 100%, 100% 100%, from(rgb(221, 221, 221)), color-stop(0.8, rgb(255, 255, 255)));"></div>
    </div>
</div>
</body>
</html>