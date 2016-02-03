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
    <title>提取佣金 - <?php echo $store['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_common.js"></script>
    <style type="text/css">
        .side-nav li {
            padding: 5px;
        }

        .bank-info {
            display: inline-block;
            font-weight: bold;
            width: 80px;
            font-family: "微软雅黑", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif !important;
            color: #999;
        }

        .arrow {
            margin-top: -15px !important;
        }

        .commision-total .icon-horn {
            float: right;
            margin: 0;
        }
    </style>
</head>
<body class="body-gray">

<div data-alert="" class="alert-box alert" id="errerMsg" style="display: none;"><a href="#" class="close">×</a></div>

<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a href="./drp_commission.php?a=index" class="menu-icon"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">提取佣金</h1>
        </section>
    </nav>
</div>
<div class="panel extract">
    <div class="commision-total"><span class="span-title">可提现金额</span><span
            class="number">￥<?php echo $balance; ?></span><i class="icon-horn"></i></div>
    <div class="horn-text" style="display:;">可提现金额为交易成功且未提现的金额</div>
    <div class="extract-number">
        <span class="span-title">佣金总额</span><span class="number" id="MaxCashAmount">￥<?php echo $income; ?></span>
    </div>

    <div class="panel extract-account">
        <ul class="side-nav">
            <li>
                <span class="bank-info">银行卡：</span><?php echo $store['bank_card']; ?><br/>
                <span class="bank-info">持卡人：</span><?php echo $store['bank_card_user']; ?><br/>
                <span class="bank-info">开户行：</span><?php echo $store['opening_bank']; ?><a href="./drp_commission.php?a=withdraw_account" style="display:inline"><i class="arrow"></i></a><br/>
                <span class="bank-info">发卡银行：</span><?php echo $bank_name; ?>
                <input type="hidden" name="bank_id" class="bank-id" value="<?php echo $store['bank_id']; ?>" />
                <input type="hidden" name="bank_card" class="bank-card" value="<?php echo $store['bank_card']; ?>" />
                <input type="hidden" name="bank_card_user" class="bank-card-user" value="<?php echo $store['bank_card_user']; ?>" />
                <input type="hidden" name="opening_bank" class="opening-bank" value="<?php echo $store['opening_bank']; ?>"/>
            </li>
        </ul>
    </div>
    <div class="row extract-monynumber">
        <div class="large-12 columns">
            <input type="text" class="" id="CashAmount" placeholder="输入提现金额">
            <span class="close-input" style="display: ;"></span>
        </div>
    </div>
    <?php if ($withdrawal_min_amount > 0) { ?>
        <div class="tip-text">最低提现金额为<b id="MinaAmountCash"><?php echo number_format($withdrawal_min_amount, 2, '.', ''); ?></b>元</div>
    <?php } ?>
    <a href="javascript:void(0)" onclick="btnSave()" class="button [radius round] red">立即提取</a>
</div>

<script type="text/javascript">
    function btnSave() {
        var BalanceAmount = parseFloat("<?php echo $balance; ?>");
        var CashAmount = $.trim($("#CashAmount").val());
        var MaxCashAmount = $.trim($("#MaxCashAmount").text());
        if ($("#MinaAmountCash").length > 0) {
            var MinaAmountCash = $.trim($("#MinaAmountCash").text());
        } else {
            var MinaAmountCash = 0;
        }
        var IntTimes = $.trim($("#IntTimes").html());
        var bank_id = $.trim($('.bank-id').val());
        var bank_card = $.trim($('.bank-card').val());
        var bank_card_user = $.trim($('.bank-card-user').val());
        var opening_bank = $.trim($('.opening-bank').val());
        if (bank_id == '' || bank_card == '' || bank_card_user == '' || opening_bank == '') {
            ShowMsg("收款信息填写不完整，无法提现");
            return false;
        }
        MaxCashAmount = MaxCashAmount.substr(1);
        var reg = /^[0-9]*(\.[0-9]{1,2})?$/;
        if (reg.test(CashAmount)) {
            CashAmount = Number(CashAmount);
            MaxCashAmount = Number(MaxCashAmount);
            MinaAmountCash = Number(MinaAmountCash);
            if (CashAmount > 0) {
                if (BalanceAmount < CashAmount) {
                    ShowMsg('余额不足，无法提现');
                    return false;
                } if (CashAmount <= MaxCashAmount) {
                    if (CashAmount >= MinaAmountCash) {
                        $.post('./drp_commission.php', {'type': 'withdrawal', 'bank_id': bank_id, 'bank_card': bank_card, 'bank_card_user': bank_card_user, 'opening_bank': opening_bank, 'amount': CashAmount}, function(data){
                            if (data.err_code == 0) {
                                window.location.href = "./drp_commission.php?a=withdrawal_result&status=1&amount=" + data.err_msg;
                            } else if (data.err_code == 1002) {
                                ShowMsg(data.err_msg);
                                return false;
                            } else {
                                window.location.href = "./drp_commission.php?a=withdrawal_result&status=0&amount=" + data.err_msg;
                            }
                        })
                    } else {
                        ShowMsg("提现金额必须大于￥" + MinaAmountCash.toFixed(2));
                        return false;
                    }
                } else {
                    ShowMsg("可提现金额为:￥" + MaxCashAmount.toFixed(2));
                    return false;
                }
            } else {
                ShowMsg("当前不可提现");
                return false;
            }
        } else {
            ShowMsg("输入金额不合法");
            return false;
        }
    }

</script>

<?php echo $shareData;?>
</body>
</html>