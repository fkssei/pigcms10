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
    <title>佣金明细 - <?php echo $store['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/drp_control.css"/>
    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_foundation.js"></script>
    <script src="<?php echo TPL_URL; ?>js/foundation.alert.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_iscroll.js" type="text/javascript"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_iscrollAssist.js" type="text/javascript" charset="gb2312"></script>
    <script type="text/javascript">
        var type = 'brokeragetab'; //佣金明细
        var page = 1;
        var PAGESIZE = 10;
        var MaxPage = 0;
        var MaxPage_1 = Math.ceil(parseInt('<?php echo $record_count; ?>') / PAGESIZE);
        var MaxPage_2 = Math.ceil(parseInt('<?php echo $withdrawal_count; ?>') / PAGESIZE);
        var null_1 = '你还没有分销佣金';
        var null_2 = '你还没有提现记录';
        $(function () {
            $("#tabs_dl dd").click(function () {
                $("#dataArea table > tbody").html('');
                $("#tabs_dl dd").removeClass("active");
                $(this).addClass("active");
                type = $(this).attr("id");
                if (type == 'brokeragetab') {
                    MaxPage = MaxPage_1;
                    brokeragelistshow();
                } else if (type == 'extracttab') {
                    MaxPage = MaxPage_2;
                    extractlistshow();
                }
                $("#dataArea").hide();
                page = 1;
                FillData(status, page, PAGESIZE);
            })
            $("#tabs_dl dd").eq(0).trigger('click');
        })

        function FillData(status, _pagenum, _pagesize) {
            $.post("./drp_commission.php", {
                'type': type,
                'date': "<?php echo !empty($_GET['date']) ? strtolower(trim($_GET['date'])) : ''; ?>",
                'p': _pagenum,
                'pagesize': _pagesize
            }, function (data) {
                if (data != '') {
                    var response = $.parseJSON(data);
                } else {
                    var response = '';
                    hasMoreData = false;
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
                    if (type == 'brokeragetab') {
                        $('.nocontent-tip-text').html(null_1);
                    } else if (type == 'extracttab') {
                        $('.nocontent-tip-text').html(null_2);
                    }
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
        #wrapper {
            top:93px
        }
        tr {
            border: 1px solid #ebebeb;;
        }
    </style>
</head>

<body>
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a href="javascript:window.history.go(-1);" class="menu-icon"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">佣金</h1>
        </section>
    </nav>
</div>
<dl id="tabs_dl" class="tabs tab-title2">
    <dd class="active" id="brokeragetab">
        <a href="javascript:void(0)"><i class="icon-comdetail"></i>本店佣金明细</a>
    </dd>
    <dd id="extracttab">
        <a href="javascript:void(0)"><i class="icon-extract"></i>提现记录</a>
    </dd>
</dl>
<div class="tabs-content" id="wrapper">
    <div class="content active" id="brokeragelist scroller">
        <div id="pulldown" class="idle">
            <span class="pullDownIcon"></span><span class="pullDownLabel" id="pulldown-label"></span>
        </div>
        <div id="dataArea">
            <table width="100%">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="nocontent-tip" id="ordernull" style="">
            <i class="icon-nocontent-worry"></i>
            <p class="nocontent-tip-text">你还没有分销佣金</p>
        </div>

        <div id="pullup" class="idle">
            <span class="pullUpIcon"></span><span class="pullUpLabel" id="pullup-label"></span>
        </div>
    </div>
    <div class="iScrollVerticalScrollbar iScrollLoneScrollbar" style="position: absolute; z-index: 9999; width: 7px; bottom: 2px; top: 2px; right: 1px; pointer-events: none;">
        <div class="iScrollIndicator" style="box-sizing: border-box; position: absolute; border: 1px solid rgba(180, 180, 180, 0.901961); border-radius: 2px; opacity: 0.8; width: 100%; transition: 0ms cubic-bezier(0.1, 0.57, 0.1, 1); -webkit-transition: 0ms cubic-bezier(0.1, 0.57, 0.1, 1); display: none; height: 845px; transform: translate(0px, 0px) translateZ(0px); background-image: -webkit-gradient(linear, 0% 100%, 100% 100%, from(rgb(221, 221, 221)), color-stop(0.8, rgb(255, 255, 255)));"></div>
    </div>
</div>

<script type="text/javascript">
    $('a[name="list"]').click(function () {
        //  alert(1)
        $(this).parent().children("div").toggle();
        $(this).parent().toggleClass("current");
    })

    $('div[name="listext"]').click(function () {
        $(this).toggleClass("current");
    })
    function brokeragelistshow() {
        $("#brokeragetab").addClass("active");
        $("#extracttab").removeClass("active");
        var html = '';
        html += '<tr>';
        html += '   <th>订单号</th>';
        html += '   <th style="text-align: right">金额（元）</th>';
        html += '   <th style="text-align: center">时间</th>';
        html += '   <th style="text-align: center">状态</th>';
        html += '</tr>';
        $('table > thead').html(html);
    }
    function extractlistshow() {
        $("#extracttab").addClass("active");
        $("#brokeragetab").removeClass("active");
        var html = '';
        html += '<tr>';
        html += '   <th style="text-align: center">时间</th>';
        html += '   <th style="text-align: right">金额（元）</th>';
        html += '   <th style="text-align: center">状态</th>';
        html += '</tr>';
        $('table > thead').html(html);
    }
</script>

<?php echo $shareData;?>
</body>
</html>