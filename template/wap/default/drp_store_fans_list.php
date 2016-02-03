<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <title>粉丝列表 - <?php echo $store['name']; ?></title>
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
        var page = 1;
        var PAGESIZE = 10;
        var MaxPage = Math.ceil(parseInt('<?php echo $fans_count?>') / PAGESIZE);
        var hasMoreData = true;
        $(function () {
            if ($('#ordernull:visible').length == 0) {
                $("#dataArea").hide();
                page = 1;
                FillData(1, PAGESIZE);
            } else {
                $("#dataArea").hide();
                return false;
            }
        })

        function FillData(_pagenum, _pagesize) {
            $.post("./drp_store_fans.php?a=list<?php echo !empty($_GET['date']) ? '&date=' . $_GET['date'] : ''; ?>", {
                p: _pagenum,
                pagesize: _pagesize
            }, function (response) {

                if (response != '') {
                    var response = $.parseJSON(response);
                } else {
                    var response = '';
                }
                if (response != '' && response.data != '') {
                    $("#ordernull").hide();
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
                } else if ($("#dataArea table > tbody > tr").length <= 1) {
                    $("#dataArea").html('');
                    $("#ordernull").show();
                    $('#pulldown').hide();
                }
                $("#dataArea").show();
                return false;
            })

        }

        (function ($) {
            $(function () {
                if ($('#ordernull:visible').length > 0) { //没有粉丝
                    return false;
                }
                var pulldownAction = function () {
                    /*$("#dataArea").hide();
                    if (page > 1) {
                        page--;
                    } else {
                        page = 1;
                    }
                    $("#dataArea table > tbody > tr").html('');
                    FillData(page, PAGESIZE);*/
                    this.refresh();
                    //下拉
                };
                var pullupAction = function () {
                    if (hasMoreData) {
                        page++;
                        if (page <= MaxPage) {
                            FillData(page, PAGESIZE);
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
            top:30px
        }
        tr {
            border: 1px solid #ebebeb;;
        }
    </style>
</head>
<body>
<!--topbar begin-->
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a class="menu-icon" href="javascript:window.history.go(-1);"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">粉丝(<?php echo $fans_count; ?>)</h1>
        </section>
    </nav>
</div>

<div class="tabs-content" id="wrapper">
    <div id="scroller" class="content active">
        <div id="pulldown" class="idle">
            <span class="pullDownIcon"></span>
            <span class="pullDownLabel" id="pulldown-label"></span>
        </div>
        <?php if ($fans_count > 0) { ?>
            <div id="dataArea">
                <table width="100%">
                    <thead>
                    <tr>
                        <th style="text-align: left">粉丝</th>
                        <th style="text-align: right">订单数</th>
                        <th style="text-align: right">金额（元）</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        <?php } ?>

        <div class="nocontent-tip" id="ordernull" <?php if ($fans_count > 0) { ?>style="display: none"<?php } ?>>
            <i class="icon-nocontent-laugh"></i>

            <p class="nocontent-tip-text">
                你还没有粉丝，<br>
                别人都开始数钱啦，快发展粉丝赚钱去！
            </p>
        </div>


        <div id="pullup" class="idle">
            <span class="pullUpIcon"></span><span class="pullUpLabel" id="pullup-label"></span>
        </div>
    </div>
    <div class="iScrollVerticalScrollbar iScrollLoneScrollbar"
         style="position: absolute; z-index: 9999; width: 7px; bottom: 2px; top: 2px; right: 1px; pointer-events: none;">
        <div class="iScrollIndicator"
             style="box-sizing: border-box; position: absolute; border: 1px solid rgba(180, 180, 180, 0.901961); border-radius: 2px; opacity: 0.8; width: 100%; transition: 0ms cubic-bezier(0.1, 0.57, 0.1, 1); -webkit-transition: 0ms cubic-bezier(0.1, 0.57, 0.1, 1); display: none; height: 845px; transform: translate(0px, 0px) translateZ(0px); background-image: -webkit-gradient(linear, 0% 100%, 100% 100%, from(rgb(221, 221, 221)), color-stop(0.8, rgb(255, 255, 255)));"></div>
    </div>
</div>

<?php echo $shareData;?>
</body>
</html>