<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>店铺二维码 - <?php echo $store['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
</head>

<body class="body-gray">
<div class="fixed tab-bar">

    <section class="left-small">
        <a href="./drp_ucenter.php" class="menu-icon"><span></span></a>
    </section>
    <section class="middle tab-bar-section">
        <h1 class="title">店铺二维码</h1>
    </section>

</div>
<div class="qrcode">
    <img src="../source/qrcode.php?type=home&id=<?php echo $store['store_id']; ?>" />
    <a class="qrcode-address" href="javascript:;" onclick="window.location.href='<?php echo $store_url; ?>'"><?php echo $store_url; ?></a>
    <a href="javascript:;" onclick="window.location.href='./home.php?id=<?php echo $store['store_id']; ?>'" class="qrcode-a">点击访问我的微店</a>
</div>

<?php echo $shareData;?>
</body>
</html>
