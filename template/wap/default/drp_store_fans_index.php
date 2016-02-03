<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <title>我的粉丝- <?php echo $store['name'];?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css" />
    <meta class="foundation-data-attribute-namespace" />
    <meta class="foundation-mq-xxlarge" />
    <meta class="foundation-mq-xlarge" />
    <meta class="foundation-mq-large" />
    <meta class="foundation-mq-medium" />
    <meta class="foundation-mq-small" />
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/drp_dis.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css" />
</head>
<body class="body-gray my-memvers">
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a class="menu-icon" href="./drp_ucenter.php"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">我的粉丝</h1>
        </section>
    </nav>
</div>
<section class="member-count">
    <h2 class="member-count-title"><i class="icon-chunk-gray"><i class="icon-chunk-blue"></i></i><span>我的粉丝</span></h2>
    <div class="row member-count-row">
        <div class="small-4 columns member-count-column">
            <span class="member-count-label">今日新增</span><em class="member-count-number"><?php echo $today_fans; ?></em>
            <a class="member-count-more" href="javascript:;" onclick="window.location.href='./drp_store_fans.php?a=list&date=today'">查看详细</a>
        </div>
        <div class="small-4 columns member-count-column">
            <span class="member-count-label">昨日新增</span><em class="member-count-number"><?php echo $yesterday_fans; ?></em>
            <a class="member-count-more" href="javascript:;" onclick="window.location.href='./drp_store_fans.php?a=list&date=yesterday'">查看详细</a>
        </div>
        <div class="small-4 columns member-count-column">
            <span class="member-count-label">粉丝总数</span><em class="member-count-number"><?php echo $fans; ?></em>
            <a class="member-count-more" href="javascript:;" onclick="window.location.href='./drp_store_fans.php?a=list'">查看详细</a>
        </div>
    </div>
</section>
<?php echo $shareData;?>
</body>
</html>