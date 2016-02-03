<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <title><?php echo $product['name']; ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- ▼ CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/font/icon.css">
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/share-base.css">
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/share-style.css">
    <style type="text/css">
        .product .image {
            height: 300px;
            width: auto;
            background-image: url(<?php echo $product['image']; ?>);background-repeat: no-repeat;filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='scale')";-moz-background-size:100% 100%;background-size:100% 100%;
        }
    </style>
</head>
<body wmall-title="<?php echo $product['name']; ?>" wmall-icon="<?php echo $product['image']; ?>" wmall-link="<?php echo option('config.wap_site_url'); ?>/good.php?id=<?php echo $product['product_id']; ?>" wmall-desc="<?php echo option('config.site_name'); ?>">

<div id="views" style="padding-bottom: 70px;">
    <div class="ad-imgs" style="margin-bottom: 10px;">
        <div class="hd clearfix">
            <i class="iconfont icon" style="color: #ff9900;"></i>
            <p class="info">
                <span class="f18">分销佣金可达<label class="red"><?php echo $profit; ?></label>元</span>
                <!--<span class="f14 gray"><label class="red"><?php /*echo $drp_seller_qty; */?></label>人分销，累计发放佣金<label class="red"><?php /*echo $drp_profit; */?></label>元。</span>-->
                <!--<span class="f14 gray">已销售<label class="red"><?php /*echo $sales; */?></label>件</span>-->
            </p>
        </div>
        <div class="talk-info">
            <div class="talk">
                <ul>
                    <li><img src="<?php echo !empty($avater) ? $avater : option('config.site_url') . '/static/images/avatar.png'; ?>" width="40" height="40" /></li>
                    <li style="font-weight: bold; width: 90%" class="popover right">
                        <div class="arrow"></div>
                        <p class="msg">我是 <span style="color: #FF9900;font-weight: bold"><?php echo $username; ?></span>，<br/>我为 <span style="color: #FF9900;font-weight: bold"><?php echo $store['name']; ?></span> 分销</p>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
        <div class="product">
            <div class="image">
                <div class="name"><span class="name-overflow"><?php echo $product['name']; ?></span><br/><span class="price">￥<?php echo $product['price']; ?></span><?php if (!empty($product['original_price']) && $product['price'] < $product['original_price']) { ?>&nbsp;&nbsp;&nbsp;<span class="original-price">￥<?php echo $product['original_price'];?><?php } ?></span></div>
            </div>
            <div class="qrcode">
                <img width="300" height="300" src="<?php echo $config['site_url'];?>/source/qrcode.php?type=good&id=<?php echo $product['product_id'];?>" />
            </div>
        </div>
        <div class="footer">
            <a class="btn btn-white js-share-link"><i class="iconfont" style="color:#ff7c22;"></i>链接分销</a>
            <a class="btn btn-white js-share-img"><i class="iconfont" style="color:#359999;"></i>图片分销</a>
        </div>
    </div>
    <div class="layout">
        <div class="item">
            <div class="row">
                <div class="hd" style="color: #000;">
                    <i class="iconfont" style="font-size: 18px;color: #ff6600;"></i>分销如何赚钱
                </div>
                <div class="bd" style="padding: 4px 0 0;">
                    <table cellpadding="0" cellspacing="0" style="margin-bottom: 6px;">
                        <tbody><tr>
                            <th width="55" style="text-align: left;vertical-align: top;">第一步
                            </th><td class="deep-gray">分享商品或店铺链接给微信好友；</td>
                        </tr>
                        <tr>
                            <th width="55" style="text-align: left;vertical-align: top;">第二步
                            </th><td class="deep-gray">从您转发的链接进入店铺的好友，他们在您的店铺中购买任何分销商品，您都可以获得分销佣金。</td>
                        </tr>
                        <tr>
                            <th width="55" style="text-align: left;vertical-align: top;">第三步
                            </th><td class="deep-gray">您可以在订单中查看好友下的订单。交易完成后，佣金可提现。</td>
                        </tr>
                        </tbody></table>
                    <p style="font-size14px;background-color: #fe924a;color: #fff;padding: 10px;">
                        说明：分销商品需要分销商到PC端管理后台设置成本和销售价，PC端管理后台地址请在【分销管理】-【店铺管理】中查看。
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="pop-dialog js-dialog-link" style="display: none;">
    <div class="bg"></div>
    <div class="body">
        <img class="collect-img" src="<?php echo TPL_URL; ?>images/share_friend.png">
    </div>
</div>

<div class="dialog js-dialog-img">
    <div class="body">
        <div class="explain-text">
            <i class="iconfont" style="color: #ff9934;"></i>
            <span class="text">长按保存图片并将图片转发给您的好友。</span>
        </div>
        <a class="btn btn-green dialog-close">我知道了</a>
    </div>
</div>

<script type="text/javascript" src="<?php echo TPL_URL; ?>js/jquery.js"></script>
<script type="text/javascript">
    $('.js-share-link').on('click', function(){
        $(".js-dialog-img").Dialog('hide');
        $(".js-dialog-link").show();
    });
    $('.js-dialog-link .body').on('click', function(){
        $(".js-dialog-link").hide();
    });
    $(".js-share-img").on('click', function(){
        $(".js-dialog-link").hide();
        $(".js-dialog-img").Dialog();
    });
</script>
<script type="text/javascript" src="<?php echo TPL_URL; ?>js/dialog.js"></script>
<?php echo $shareData;?>
</body>