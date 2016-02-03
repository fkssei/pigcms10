<style type="text/css">
    .platform-tag {
        display: inline-block;
        vertical-align: middle;
        padding: 3px 7px 3px 7px;
        background-color: #f60;
        color: #fff;
        font-size: 12px;
        line-height: 14px;
        border-radius: 2px;
    }
</style>
<h1 class="order-title">订单号：<?php echo $order['order_no']; ?></h1>
<ul class="order-process clearfix">
    <li class="active">
        <p class="order-process-state">买家已付款</p>
        <p class="bar"><i class="square">√</i></p>
        <p class="order-process-time"><?php echo date('Y-m-d H:i:s', $order['buyer_paid_time']); ?></p>
    </li>
    <li <?php if (in_array($order['status'], array(2, 3, 4))) { ?>class="active"<?php } ?>>
        <p class="order-process-state"><?php if (in_array($order['status'], array(2, 3, 4))) { ?>分销商已付款<?php } else { ?>等待分销商付款<?php } ?></p>
        <p class="bar"><i class="square">2</i></p>
        <?php if (in_array($order['status'], array(2, 3, 4))) { ?>
        <p class="order-process-time"><?php echo date('Y-m-d H:i:s', $order['paid_time']); ?></p>
        <?php } ?>
    </li>
    <li <?php if (in_array($order['status'], array(3, 4))) { ?>class="active"<?php } ?>>
        <p class="order-process-state">供货商已发货</p>
        <p class="bar"><i class="square">3</i></p>
        <?php if (in_array($order['status'], array(3, 4))) { ?>
        <p class="order-process-time"><?php echo date('Y-m-d H:i:s', $order['supplier_sent_time']); ?></p>
        <?php } ?>
    </li>
    <li <?php if ($order['status'] == 4) { ?>class="active"<?php } ?>>
        <p class="order-process-state">交易完成</p>
        <p class="bar"><i class="square">4</i></p>
        <?php if ($order['status'] == 4) { ?>
        <p class="order-process-time"><?php echo date('Y-m-d H:i:s', $order['complate_time']); ?></p>
        <?php } ?>
    </li>
</ul>
<div class="section">
    <h2 class="section-title clearfix">
        分销订单概况
    </h2>
    <div class="section-detail clearfix">
        <div class="pull-left">
            <table>
                <tbody>
                    <tr>
                        <td>订单状态：</td>
                        <td><?php echo $status[$order['status']]; ?> <?php if ($order['status'] == 5) { ?><?php if ($order['cancel_method'] == 1) { ?>(卖家取消)<?php } else if ($order['cancel_method'] == 2) { ?>(买家取消)<?php } else { ?>(自动过期)<?php } ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>应付金额：</td>
                        <td><strong class="ui-money-income">￥<?php echo $order['total']; ?></strong>（含运费 <?php echo $order['postage']; ?> ）</td>
                    </tr>
                    <tr>
                        <td>下单用户：</td>
                        <td><?php if (empty($order['is_fans'])) { ?>非粉丝<?php } ?></td>
                    </tr>
                    <tr>
                        <td>付款方式：</td>
                        <td><?php if (array_key_exists($order['payment_method'], $payment_method)) { ?><?php echo $payment_method[$order['payment_method']]; ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>物流方式：</td>
                        <td><?php if ($order['shipping_method'] == 'express') { ?>快递配送<?php } else if ($order['shipping_method'] == 'selffetch') { ?>上门自提<?php } ?></td>
                    </tr>
                    <?php $address = !empty($order['address']) ? unserialize($order['address']) : array(); ?>
                    <?php if ($order['shipping_method'] == 'express') { ?>
                    <tr>
                        <td>收货信息：</td>
                        <td><?php echo $address['province']; ?> <?php echo $address['city']; ?> <?php echo $address['area']; ?> <?php echo $address['address']; ?> <?php echo $address['name']; ?> <?php echo $address['tel']; ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($order['shipping_method'] == 'selffetch') { ?>
                    <tr>
                        <td>自提网点：</td>
                        <td><?php echo $address['name']; ?> <?php echo $address['province']; ?> <?php echo $address['city']; ?> <?php echo $address['area']; ?> <?php echo $address['address']; ?> <?php echo $order['address_tel']; ?></td>
                    </tr>
                    <tr>
                        <td>预约人：</td>
                        <td><?php echo $order['address_user']; ?></td>
                    </tr>
                    <tr>
                        <td>联系方式：</td>
                        <td><?php echo $order['address_tel']; ?></td>
                    </tr>
                    <tr>
                        <td>预约时间：</td>
                        <td><?php echo $address['date']; ?> <?php echo $address['time']; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>买家留言：</td>
                        <td style="color: red;"><?php echo $order['comment']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pull-right section-sidebar">
            <p>卖家备注：</p>
            <div class="js-memo-text memo-text"><?php echo $order['bak']; ?></div>
        </div>
    </div>
</div>
<div class="section section-express">
    <div class="section-title clearfix">
        <h2>付款给供货商</h2>
    </div>
    <div class="section-detail">
        <table>
            <tbody>
                <tr>
                    <td>交易单号：</td>
                    <td><?php echo $order['fx_trade_no']; ?></td>
                </tr>
                <tr>
                    <td>付款金额：</td>
                    <td><strong class="ui-money-income">￥<?php echo $order['cost_total']; ?></strong>（含运费 <?php echo $order['postage']; ?> ）</td>
                </tr>
                <tr>
                    <td>付款时间：</td>
                    <td><?php echo date('Y-m-d H:i:s', $order['paid_time']); ?></td>
                </tr>
                <tr>
                    <td>付款方式：</td>
                    <td>余额支付</td>
                </tr>
                <tr>
                    <td>供货商：</td>
                    <td><?php echo $supplier; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php if (!empty($packages)) { ?>
<div class="section section-express">
    <div class="section-title clearfix">
        <h2>供货商物流信息</h2>
        <ul class="js-express-tab">
            <?php foreach ($packages as $key => $package) { ?>
            <li <?php if ($key == 0) { ?>class="active"<?php } ?> data-pack-id="<?php echo $package['package_id']; ?>">包裹<?php echo $key + 1;?></li>
            <?php } ?>
        </ul>
    </div>
    <div class="section-detail">
        <?php if ($packages) { ?>
        <?php foreach ($packages as $key => $package) { ?>
        <div class="js-express-tab-content <?php if ($key > 0) { ?>hide<?php } ?>" data-pack-id="<?php echo $package['page_id']; ?>" data-express-no="<?php echo $package['express_no']; ?>">
            <p><?php echo $package['express_company']; ?> 运单号：<?php echo $package['express_no']; ?>                                                    </p>
            <!--<div class="js-express-detail express-detail" data-number="1"><p>2015-03-10 16:13:23 已签收,签收人是本人签收</p></div>
            <a class="toggler js-toggle-express hide" href="javascript:;">展开▼</a>-->
        </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>
<?php } ?>
<table class="table order-goods">
    <thead>
    <tr>
        <th class="tb-thumb"></th>
        <th class="tb-name">商品名称</th>
        <th class="tb-price">成本价（元）</th>
        <th class="tb-price">分销价（元）</th>
        <th class="tb-num">数量</th>
        <th class="tb-total">小计（元）</th>
        <th class="tb-postage">运费（元）</th>
    </tr>
    </thead>
    <tbody>
    <?php $start_package = false; //订单已经有商品开始打包?>
    <?php foreach ($products as $key => $product) { ?>
    <?php if (!$start_package && $product['is_packaged']) { $start_package = true; }?>
    <?php $skus = !empty($product['sku_data']) ? unserialize($product['sku_data']) : ''; ?>
    <?php $comments = !empty($product['comment']) ? unserialize($product['comment']) : ''; ?>
    <tr data-order-id="<?php echo $order['order_id']; ?>">
        <td class="tb-thumb" <?php if (!empty($comments)) { ?>rowspan="2"<?php } ?>><img src="<?php echo $product['image']; ?>" width="60" height="60" /></td>
        <td class="tb-name">
            <a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>" class="new-window" target="_blank"><?php echo $product['name']; ?></a>
            <?php if ($skus) { ?>
            <p>
                <span class="goods-sku"><?php foreach ($skus as $sku) { ?><?php echo $sku['name']; ?>: <?php echo $sku['value']; ?>&nbsp;<?php } ?></span>
            </p>
            <?php } ?>
        </td>
        <td class="tb-price"><?php echo $product['cost_price']; ?></td>
        <td class="tb-price"><?php echo $product['pro_price']; ?></td>
        <td class="tb-num"><?php echo $product['pro_num']; ?></td>
        <td class="tb-total"><?php echo number_format($product['pro_num'] * $product['pro_price'], 2, '.', ''); ?></td>
        <?php  if (count($comment_count) > 0 && $key == 0) { ?>
        <td class="tb-postage" rowspan="<?php echo $rows; ?>">
            <?php echo $order['postage']; ?>
        </td>
        <?php } ?>
    </tr>
    <?php if (!empty($comments)) { ?>
    <?php foreach ($comments as $comment) { ?>
    <tr class="msg-row">
        <td colspan="5"><?php echo $comment['name']; ?>：<?php echo $comment['value']; ?><br></td>
    </tr>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    </tbody>
</table>
<div class="clearfix section-final">
    <div class="pull-right text-right">
        <table>
            <tbody>
            <tr>
                <td>商品小计：</td>
                <td>￥<?php echo $order['sub_total']; ?></td>
            </tr>
            <tr>
                <td>运费：</td>
                <td>￥<span class="order-postage"><?php echo $order['postage']; ?></span></td>
            </tr>
            <?php if (!empty($order['float_amount']) && $order['float_amount'] != '0.00') { ?>
            <tr>
                <td>卖家改价：</td>
                <?php if ($order['float_amount'] > 0) { ?>
                <td>+￥<?php echo $order['float_amount']; ?></td>
                <?php } else { ?>
                    <td>-￥<?php echo number_format(abs($order['float_amount']), 2, '.', ''); ?></td>
                <?php } ?>
            </tr>
            <?php } ?>
            <tr>
                <td>应收款：</td>
                <td><span class="ui-money-income">￥<span class="order-total"><?php echo $order['total']; ?></span></span></td>
            </tr>
            <tr>
                <td><b>分销利润：</b></td>
                <td><span class="ui-money-income">￥<span class="order-total"><b><?php echo $order['fx_profit']; ?></b></span></span></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>