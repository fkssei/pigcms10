<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <title>我的<?php echo $levels[$level]; ?>级分店 - <?php echo $store['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/drp_dis.css" />
    <meta class="foundation-data-attribute-namespace" />
    <meta class="foundation-mq-xxlarge" />
    <meta class="foundation-mq-xlarge" />
    <meta class="foundation-mq-large" />
    <meta class="foundation-mq-medium" />
    <meta class="foundation-mq-small" />
</head>
<body>
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a class="menu-icon" href="javascript:window.history.go(-1);"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">我的<?php echo $levels[$level]; ?>级分店</h1>
        </section>
    </nav>
</div>
<div class="disstore-amount">
    <p><i class="icon-organization"></i><?php echo $levels[$level]?>级分店数</p>
    <span><?php echo $sub_sellers; ?></span>
</div>
<div class="disstore-acount">
    <span class="disstore-acount-label">累计销售（元）</span><span class="disstore-acount-number"><?php echo number_format($order_total, 2, '.', ''); ?></span>
</div>

<div class="bro-group row">
    <div class="small-6 columns">
        <span class="bro-group-label">累计订单数</span>
        <span class="bro-group-money"><?php echo $order_count; ?></span>
    </div>
    <div class="small-6 columns">
        <span class="bro-group-label">累计商品数</span>
        <span class="bro-group-money"><?php echo $product_count; ?></span>
    </div>
</div>

<div class="bro-extract-btn">
    <a href="./drp_store.php?&a=view&level=<?php echo $level; ?>" class="button [radius round] red">查看<?php echo $levels[$level]; ?>级分店</a>
</div>

<?php echo $shareData;?>
</body>
</html>