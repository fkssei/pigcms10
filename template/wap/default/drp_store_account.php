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
    <meta class="foundation-data-attribute-namespace"/>
    <meta class="foundation-mq-xxlarge"/>
    <meta class="foundation-mq-xlarge"/>
    <meta class="foundation-mq-large"/>
    <meta class="foundation-mq-medium"/>
    <meta class="foundation-mq-small"/>
    <title>管理店铺 - <?php echo $store['name'];?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/drp_dis.css"/>
    <style type="text/css">
        .header-r .try-tip {
            width: 100px;
        }
    </style>
    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_foundation.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_foundation.reveal.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_func.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_common.js"></script>
</head>

<body class="body-gray">
<div class="mask"></div>
<div id="myStore" class="reveal-modal alert-header radius" data-reveal="">
    <ul class="side-nav">
        <li class="first"><a href="./drp_store.php?a=edit"><i class="icon-edit-w"></i>编辑我的微店</a></li>
        <li class="second"><a href="./home.php?id=<?php echo $store['store_id']; ?>"><i class="icon-eye-w"></i>进入我的微店</a></li>
    </ul>
</div>
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a class="menu-icon" href="./drp_ucenter.php"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">管理店铺</h1>
        </section>
    </nav>
</div>
<div class="panel memberhead">
    <div class="header-l">
        <i class="icon-level-dis"></i>
    </div>
    <div class="header-r">
        <a href="./drp_ucenter.php?a=profile">
            <span class="name"><?php echo $store['name']; ?></span>
            <?php if ($drp_approve) { ?>
                <i class="try-tip">正式分销商</i>
            <?php } else { ?>
                <i class="try-tip">待审核分销商</i>
            <?php } ?>
            <span class="header-tip-text">
                <?php if (!empty($store['supplier'])) { ?>
                    供货商：<?php echo $store['supplier']; ?>
                <?php } else { ?>
                    您已成为正式分销商...
                <?php } ?>
            </span>
            <i class="arrow"></i>
        </a>
    </div>
    <a href="./drp_ucenter.php?a=profile"></a></div>
<a href="./drp_ucenter.php?a=profile"></a>

<div class="row count"><a href="./drp_ucenter.php?a=profile"></a>

    <div class="small-4 large-3 columns mid"><a href="./drp_ucenter.php?a=profile">
        </a><a href="./drp_store.php?a=sales" class="count-a">
            <p class="count-dis-mony"><?php echo $store['sales']; ?></p>
            <span class="count-title">本店销售总额(元)</span></a>
    </div>
    <div class="small-4 large-3 columns mid">
        <a href="./drp_commission.php?a=statistics" class="count-a">
            <p class="count-dis-mony"><?php echo $store['balance']; ?></p>
            <span class="count-title">佣金余额(元)</span></a>
    </div>
</div>
<div class="panel member-nav">
    <ul class="side-nav">
        <li><a href="javascript:;"><span class="text">管理地址：<?php echo $admin_url; ?></span></a></li>
        <li><a href="javascript:;"><span class="text">登录账户：<?php echo $phone; ?></span></a></li>
        <li <?php if (!$password) { ?>class="last"<?php } ?>><a href="javascript:;"><span class="text">初始密码：<?php echo $phone; ?></span></a></li>
        <?php if ($password) { ?>
        <li class="last"><a href="./drp_store.php?a=reset_pwd" class="button [radius red round]" style="padding: 0;margin-top:10px;margin-bottom: 10px;">重置为初始密码</a></li>
        <?php } ?>
    </ul>
</div>
<div class="h50"></div>
<?php echo $shareData;?>
</body>
</html>