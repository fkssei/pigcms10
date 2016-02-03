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
    <title>提现账号 - <?php echo $store['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_common.js"></script>
    <style type="text/css">
        .default {
            color: #A9A9A9;
        }
    </style>
</head>
<body class="body-gray">
<div data-alert="" class="alert-box alert" style="display: none;" id="errerMsg"><a href="#" class="close">×</a></div>
<div data-alert="" class="alert-box success" style="display: none;">保存成功！</div>
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a href="javascript:;" onclick="window.history.go(-1);" class="menu-icon"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">提现账号</h1>
        </section>
        <section class="right-small right-small-text2">
            <a href="javascript:void(0)" id="btnSave" class="button [radius round] top-button">保存</a>
        </section>
    </nav>
</div>
<form class="mt-55 mlr-15">
    <div class="panel callout radius formstyle">
        <div class="row collapse">
            <div class="small-12 large-12 columns">
                <select name="BankId" id="BankId" <?php if (empty($store['bank_id'])) { ?>class="default"<?php } ?>>
                    <option value="0" style="color: #A9A9A9;">选择发卡银行</option>
                    <?php foreach ($banks as $bank) { ?>
                        <option style="color: black" value="<?php echo $bank['bank_id']; ?>" <?php if ($bank['bank_id'] == $store['bank_id']) { ?>selected="true"<?php } ?>><?php echo $bank['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="row collapse">
            <div class="small-12 large-12 columns">
                <input type="text" placeholder="开户行" id="OpeningBank" name="OpeningBank" value="<?php echo $store['opening_bank']; ?>"/>
                <span class="close-input" style="display: none;"></span>
            </div>
        </div>
        <div class="row collapse">
            <div class="small-12 large-12 columns">
                <input type="text" placeholder="银行卡号" id="BankCard" name="BankCard" value="<?php echo $store['bank_card']; ?>"/>
                <span class="close-input" style="display: none;"></span>
            </div>
        </div>
        <div class="row collapse">
            <div class="small-12 large-12 columns">
                <input type="text" placeholder="持卡人" id="BankCardUser" name="BankCardUser" value="<?php echo $store['bank_card_user']; ?>"/>
                <span class="close-input" style="display: none;"></span>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(function () {
        $('#BankId').change(function(){
            if ($(this).val() > 0) {
                $(this).removeClass('default');
            } else {
                $(this).addClass('default');
            }
        })
        $("#btnSave").click(function () {
            $("#errerMsg").hide(300, "linear");
            var BankId = $("#BankId").val();
            if (BankId == 0) {
                $("#BankId").focus();
                ShowMsg("请选择发卡银行");
                return false;
            }
            var OpeningBank = $.trim($("#OpeningBank").val());
            if (OpeningBank == "") {
                $("#OpeningBank").focus();
                ShowMsg("请填写开户银行");
                return false;
            }
            var BankCard = $.trim($("#BankCard").val());
            if (BankCard == "") {
                $("#BankCard").focus();
                ShowMsg("请填写银行卡号");
                return false;
            }
            var BankCardUser = $.trim($("#BankCardUser").val());
            if (BankCardUser == "") {
                $("#BankCardUser").focus();
                ShowMsg("请填写持卡人");
                return false;
            }

            $.post('./drp_commission.php', {'type': 'withdraw_account', 'bank_card_user': BankCardUser, 'bank_card': BankCard, 'opening_bank': OpeningBank, 'bank_id': BankId}, function(data){
                if (data.err_code == 0) {
                    window.location.href = './drp_commission.php?a=withdrawal';
                } else {
                    ShowMsg("保存失败,请稍候再试");
                    return;
                }
            })
        })
    })
</script>

<?php echo $shareData;?>
</body>
</html>