<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta class="foundation-data-attribute-namespace"/>
    <meta class="foundation-mq-xxlarge"/>
    <meta class="foundation-mq-xlarge"/>
    <meta class="foundation-mq-large"/>
    <meta class="foundation-mq-medium"/>
    <meta class="foundation-mq-small"/>
    <title>佣金统计 - <?php echo $store['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/drp_dis.css"/>


    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_foundation.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_foundation.tab.js"></script>
    <script src="<?php echo TPL_URL; ?>js/highcharts.js"></script>
    <script src="<?php echo TPL_URL; ?>js/chartline.js"></script>
    <script>
        function GetToDayPrice(data) {
            var str = data;
            var timeSlot = JSON.parse(str);
            for (var i = 0; i < timeSlot.length; i++) {
                if (timeSlot[i] != 0) {
                    $("#panel").show();
                }
            }
            return timeSlot;
        }
        function GetYesterDayPrice(data) {
            var str = data;
            var timeSlot = JSON.parse(str);
            for (var i = 0; i < timeSlot.length; i++) {
                if (timeSlot[i] != 0) {
                    $("#panel1").show();
                }
            }
            return timeSlot;
        }
        function GetThisWeekPrice(data) {
            var str = data;
            var timeSlot = JSON.parse(str);
            for (var i = 0; i < timeSlot.length; i++) {
                if (timeSlot[i] != 0) {
                    $("#panel2").show();
                }
            }
            return timeSlot;
        }
        function GetThisMonthPrice(data) {
            var str = data;
            var timeSlot = JSON.parse(str);
            for (var i = 0; i < timeSlot.length; i++) {
                if (timeSlot[i] != 0) {
                    $("#panel3").show();
                }
            }
            return timeSlot;
        }
    </script>
</head>
<body>
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a class="menu-icon" href="./drp_ucenter.php"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">佣金统计</h1>
        </section>
    </nav>
</div>
<div class="panel bro-yesterday">
    <p><i class="icon-money"></i>佣金余额(元)</p>
    <span><?php echo $store['balance']; ?></span>
</div>
<div class="bro-amount">
    <span class="bro-amount-title">总金额(元)</span>

    <p class="bro-amount-money"><?php echo $store['income']; ?></p>
</div>

<dl class="tabs tab-title4-chart" data-tab="">
    <dd class="active"><a href="./drp_commission.php?a=statistics#panel2-1" id="today">今日</a></dd>
    <dd><a href="./drp_commission.php?a=statistics#panel2-2" id="yesterday">昨日</a></dd>
    <dd><a href="./drp_commission.php?a=statistics#panel2-3" id="week">本周</a></dd>
    <dd><a href="./drp_commission.php?a=statistics#panel2-4" id="month">本月</a></dd>
</dl>

<div class="tabs-content tabcontent04">

    <div class="content active" id="panel2-1">
        <a href="./drp_commission.php?a=detail&date=today" style="display:none" id="panel" class="view-detail">查看详情</a>
        <div id="totaltoday" style="min-width: 100%; height: 400px; margin-top: 10px;" data-highcharts-chart="0">
            <div class="highcharts-container" id="highcharts-0"
                 style="position: relative; overflow: hidden; width: auto; height: 400px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></div>
        </div>
    </div>

    <div class="content" id="panel2-2">
        <a href="./drp_commission.php?a=detail&date=yesterday" style="display:none" id="panel1" class="view-detail">查看详情</a>
        <div id="yestoday" style="min-width: 100%; height: 400px; margin-top: 10px;" data-highcharts-chart="1">
            <div class="highcharts-container" id="highcharts-4" style="position: relative; overflow: hidden; width: auto; height: 400px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></div>
        </div>
    </div>

    <div class="content" id="panel2-3">
        <a href="./drp_commission.php?a=detail&date=week" style="display:none" id="panel2" class="view-detail">查看详情</a>
        <div id="weekday" style="min-width: 100%; height: 400px; margin-top: 10px;" data-highcharts-chart="2">
            <div class="highcharts-container" id="highcharts-8"
                 style="position: relative; overflow: hidden; width: auto; height: 400px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></div>
        </div>
    </div>

    <div class="content" id="panel2-4">
        <a href="./drp_commission.php?a=detail&date=month" style="display:none" id="panel3" class="view-detail">查看详情</a>
        <div id="moonth" style="min-width: 100%; height: 400px; margin-top: 10px;" data-highcharts-chart="3">
            <div class="highcharts-container" id="highcharts-12"
                 style="position: relative; overflow: hidden; width: auto; height: 400px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></div>
        </div>
    </div>

</div>
<input type="hidden" name="url" class="url" value="./drp_commission.php?a=statistics"/>

<div class="h50"></div>

<script>
    $(document).foundation().foundation('joyride', 'start');
</script>

<?php echo $shareData;?>
</body>
</html>