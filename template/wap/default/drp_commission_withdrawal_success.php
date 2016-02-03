<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <title>提取佣金成功 - <?php echo $store['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
</head>
<body class="body-gray">
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a href="./drp_commission.php?a=withdrawal" class="menu-icon"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">提取佣金成功</h1>
        </section>
    </nav>
</div>

<div class="panel tippage">
    <span class="icon-success"></span>
    <p class="text-success">提现申请成功！</p>
    <p class="text-gray">
        提现金额<b>￥<?php echo $amount; ?></b><br>
        请耐心等待工作人工处理...
    </p>
    <a href="/index.php?g=Wap&m=DrpUcenter&a=commission_log&type=1">查看提现记录</a>
</div>

<?php echo $shareData;?>
</body>
</html>