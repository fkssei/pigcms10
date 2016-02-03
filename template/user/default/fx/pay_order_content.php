<style type="text/css">
    .popover-confirm {
        width: auto;
    }
    .popover-inner {
        padding: 3px!important;
        background-color: #000000!important;
    }
    .popover.right .arrow {
        top: 50%;
        left: -11px;
        margin-top: -5px;
        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
        border-right: 5px solid #000000;
    }
    .popover.right .arrow:after {
        bottom: -10px;
        left: 1px;
        border-right-color: #ffffff;
        border-left-width: 0;
    }
    .order-pay-container .order-pay-wrap .order-pay-list .order-content .supplier-name p {
        height: auto;
    }
</style>
<div class="order-pay-container">
    <div class="order-pay-wrap clearfix">
        <div class="total-orders js-show-order-list">
            <span>合并 | <?php echo count($orders); ?>笔订单</span>
        </div>
        <div class="order-pay-list js-order-pay-list">
            <div class="order-banner">
                <span class="supplier-span">供货商</span>
                <span class="order-span">订单</span>
                <span class="price-span">单价</span>
                <span class="num-span">数量</span>
                <span class="freight-span">运费</span>
                <span class="subtotal-span">小计</span>
            </div>
            <div class="order-content">
                <div class="supplier-name">
                    <p><?php echo $supplier; ?></p>
                </div>
                <?php $order_ids = array(); ?>
                <?php foreach ($orders as $order) { ?>
                <?php $order_ids[] = $order['fx_order_id']; ?>
                <div class="order-container">
                    <div class="order-detail">
                        <div class="order-item">
                            <div class="order-num">订单号: <?php echo $order['fx_order_no']; ?></div>
                            <?php foreach ($order['products'] as $product) { ?>
                            <div class="title-price-num">
                                <div class="title"><p><?php echo $product['name']; ?></p></div>
                                <div class="price">￥<?php echo $product['cost_price']; ?></div>
                                <div class="num"><?php echo $product['quantity']; ?></div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="freight"><p>￥<?php echo $postage; ?></p></div>
                    <div class="subtotal"><p>￥<?php echo $total; ?></p></div>
                </div>
                <?php } ?>
                <?php
                $data = array();
                $data['trade_no'] = $trade_no;
                $data['order_id'] = implode(',', $order_ids);
                $data['total'] = intval($total);
                $data['supplier_id'] = $supplier_id;
                $data['seller_id'] = $seller_id;
                $data['salt'] = 'pigcms-weidian-fx-order-pay-to-supplier';
                ksort($data);
                $hash = sha1(http_build_query($data));
                ?>
            </div>
        </div>
        <div class="total-price clearfix">
            <span>总金额：</span>
            <div class="price-container"><?php echo $total; ?>元</div>
        </div>
        <?php if ($pay) { ?>
        <div class="pay-detail">
        <input type="hidden" value="<?php echo $total?>" class="total" name="total" />
        <input type="hidden" value="<?php echo $trade_no; ?>" class="trade_no" name="trade_no" />
        <input type="hidden" value="<?php echo implode(',', $order_ids); ?>" name="order_id" class="order_id" />
        <input type="hidden" value="<?php echo $supplier_id; ?>" name="supplier_id" class="supplier_id" />
        <input type="hidden" value="<?php echo $seller_id; ?>" name="seller_id" class="seller_id" />
        <input type="hidden" value="<?php echo time(); ?>" name="timestamp" class="timestamp" />
        <input type="hidden" value="<?php echo $hash; ?>" name="hash" class="hash" />
        <a href="javascript:;" class="ui-btn ui-btn-primary js-pay-supplier <?php if (!empty($_SESSION['sync_store'])) { ?>sync-store<?php } ?>" data-loading-text="正在付款...">付款给供货商</a>
        <a href="javascript:window.history.go(-1);" class="ui-btn js-export">取消付款</a>
        <br/>
        <br/>
        <p style="color: #f60">* 付款给供货商：从分销商的账户余额中减去订单商品的成本价格，并添加到供货商的账户余额。</p>
        </div>
        <?php } ?>
    </div>
</div>