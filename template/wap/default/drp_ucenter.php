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
    <title>分销管理 - <?php echo $store['name'];?></title>
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
        <?php if ($drp_approve) { ?>
        <li class="first"><a href="./drp_store.php?a=edit"><i class="icon-edit-w"></i>编辑我的微店</a></li>
        <?php } ?>
        <li class="second"><a href="./home.php?id=<?php echo $store['store_id']; ?>"><i class="icon-eye-w"></i>进入我的微店</a></li>
    </ul>
</div>
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a class="menu-icon" href="./ucenter.php?id=<?php echo $store['store_id']; ?>"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">分销管理</h1>
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
            <span class="count-title">佣金总额(元)</span></a>
    </div>
</div>


<div class="panel member-nav">
    <ul class="side-nav">
        <li><a href="javascript:void(0)" data-reveal-id="myStore"><i class="icon-shop"></i><span class="text">我的微店</span><i class="arrow"></i></a></li>
        <?php if (!empty($sub_drp_levels)) { ?>
        <li>
            <a id="disstroe" href="javascript:void(0)"><i class="icon-lowLevel"></i><span class="text">我的分销</span><i class="arrow"></i></a>
            <div id="disstroe-sub" class="member-nav-sub">
                <ul class="member-nav-sub-ul">
                    <?php foreach ($sub_drp_levels as $key => $value) { ?>
                    <li class="member-nav-sub-li"><a href="./drp_store.php?level=<?php echo $key; ?>"><span class="text"><?php echo $value; ?>级分店</span><i class="arrow"></i></a></li>
                    <?php } ?>
                </ul>
            </div>
        </li>
        <?php } ?>
        <li id="drpOrder"><a href="./drp_order.php?a=index"><i class="icon-disorder"></i><span class="text">采购清单</span><i class="arrow"></i></a></li>
    </ul>
</div>

<div class="panel member-nav">
    <ul class="side-nav">
        <li id="brokerage" class="last"><a href="./drp_commission.php?a=index"><i class="icon-commission"></i><span class="text">我的佣金</span><i class="arrow"></i></a></li>
    </ul>
</div>

<div class="panel member-nav">
    <ul class="side-nav">
        <li <?php if (count($stores) < 0) { ?>class="last"<?php } ?>><a href="./drp_store_qrcode.php"><i class="icon-qrcode"></i><span class="text">店铺二维码</span><i class="arrow"></i></a></li>
        <?php if (count($stores) > 0) { ?>
        <li><a href="./drp_store.php?a=select"><i class="icon-dis"></i><span class="text">切换店铺</span><i class="arrow"></i></a></li>
        <?php } ?>
        <li class="last"><a href="./drp_store.php?a=account"><i class="icon-set"></i><span class="text">管理店铺</span><i class="arrow"></i></a></li>
    </ul>
</div>

<div class="h50"></div>
<div class="fixed bottom">
    <dl class="sub-nav nav-b5">
        <dd>
            <div class="nav-b5-relative">
                <a href="./home.php?id=<?php echo $store['store_id']; ?>"><i class="icon-nav-bag"></i>逛街</a>
            </div>
        </dd>
        <dd class="active">
            <div class="nav-b5-relative">
                <a href="javascript:void(0)"><i class="icon-nav-store"></i>分销管理</a>
            </div>
        </dd>
        <dd>
            <div class="nav-b5-relative">
                <a href="./drp_ucenter.php?a=personal"><i class="icon-nav-heart"></i>会员中心</a>
            </div>
        </dd>
        <dd>
            <div class="nav-b5-relative">
                <a href="./drp_store.php?a=logout"><i class="icon-nav-search"></i>退出</a>
            </div>
        </dd>
    </dl>
</div>

<script>
    $(document).foundation().foundation('joyride', 'start');
</script>

</body>
</html>