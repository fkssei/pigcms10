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
    <title>提取佣金失败 - <?php echo $store['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css" />


</head>
<body class="body-gray">

<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a href="./drp_commission.php?a=withdrawal" class="menu-icon"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">提取佣金失败</h1>
        </section>
    </nav>
</div>

<div class="panel tippage">
    <span class="icon-fail"></span>
    <p class="text-fail">提现失败！</p>
    <p class="text-gray">
        提现金额<b>￥<?php echo $amount; ?></b>
    </p>
    <a href="./drp_commission.php?a=withdrawal">再试一次</a>
</div>

<?php echo $shareData;?>
</body>
</html>