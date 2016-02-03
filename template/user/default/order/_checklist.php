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
<?php if (!empty($orders)) { ?>
    <table class="ui-table-order">
        <thead class="js-list-header-region tableFloatingHeaderOriginal"><tr><th class="" colspan="2">商品</th>
            <th class="price-cell">单价/数量</th>
            <th class="aftermarket-cell">售后</th>
            <th class="customer-cell">买家</th>
            <th class="time-cell">
                <a href="javascript:;" class="orderby orderby_add_time" data-orderby="add_time">下单时间<span class="orderby-arrow desc"></span></a>
            </th>
            <th class="state-cell">订单状态</th>
            <th class="pay-price-cell"><a href="javascript:;" class="orderby orderby_total" data-orderby="total">实付金额</a></th>
        </tr>
        </thead>
        <?php foreach ($orders as $order) { ?>
            <tbody>
            <tr class="separation-row">
                <td colspan="8"></td>
            </tr>
            <tr class="header-row">
                <td colspan="6">
                    <div>
                        订单号: <?php echo $order['order_no']; ?>
						<?php 
						if ($order['payment_method'] == 'codpay') {
						?>
							<span>支付方式 ：货到付款</span>
						<?php 
						}
						?>
                        <div class="help" style="display:inline-block;">
                            <span class="js-help-notes c-gray" data-class="bottom" style="cursor: help;"><?php if (array_key_exists($order['payment_method'], $payment_method)) { ?><?php echo $payment_method[$order['payment_method']]; ?><?php } ?></span>
                            <div class="js-notes-cont hide">
                                该订单通过代销服务完成交易，请进入“收入/提现”页面，“微信支付”栏目查看收入或提现
                            </div>
                        </div>
                        <?php if ($order['type'] == 3) { ?>
                            <span class="platform-tag">分销</span>
                            <span class="c-gray">
                            分销商：<?php echo $order['seller']; ?>
                        </span>
                        <?php } ?>
                    </div>
                    <div class="clearfix">
                        <?php if (!empty($order['trade_no'])) { ?>
                        <div style="margin-top: 4px;margin-right: 20px;" class="pull-left">
                            外部订单号: <span class="c-gray"><?php echo $order['trade_no']; ?></span>
                        </div>
                        <?php } ?>
                        <?php if (!empty($order['third_id'])) { ?>
                        <div style="margin-top: 4px;" class="pull-left">
                            支付流水号: <span class="c-gray"><?php echo $order['third_id']; ?></span>
                        </div>
                        <?php } ?>
                    </div>
                </td>
                <td colspan="2" class="text-right">
                    <div class="order-opts-container">
                        <div class="js-memo-star-container memo-star-container"><div class="opts">
                                <div class="td-cont message-opts">
                                    <div class="m-opts">
                                        <a href="<?php dourl('detail', array('id' => $order['order_id'])); ?>" class="js-order-detail new-window" target="_blank">查看详情</a>
                                        <span>-</span>
                                        <a class="js-memo-it" rel="popover" href="javascript:;" data-bak="<?php echo $order['bak']; ?>" data-id="<?php echo $order['order_id']; ?>">备注</a>
                                        <span>-</span>
                                        <?php if (empty($order['star'])) { ?>
                                        <a class="js-stared-it" href="javascript:;">加星</a>
                                        <?php } else { ?>
                                        <span class="js-stared-it stared"><img src="<?php echo TPL_URL; ?>/images/star-on.png"> x <?php echo $order['star']; ?></span>
                                        <?php } ?>
                                    </div>
                                    <div id="raty-action-<?php echo $order['order_id']; ?>" class="raty-action" style="display: none; cursor: pointer;">
                                        <img src="<?php echo TPL_URL;?>images/cancel-custom-off.png" data-id="<?php echo $order['order_id']; ?>" alt="x" title="去星" class="raty-cancel" />&nbsp;
                                        <img src="<?php echo TPL_URL;?>images/star-off.png" data-id="<?php echo $order['order_id']; ?>" class="star" alt="1" title="一星" />
                                        <img src="<?php echo TPL_URL;?>images/star-off.png" data-id="<?php echo $order['order_id']; ?>" class="star" alt="2" title="二星" />
                                        <img src="<?php echo TPL_URL;?>images/star-off.png" data-id="<?php echo $order['order_id']; ?>" class="star" alt="3" title="三星" />
                                        <img src="<?php echo TPL_URL;?>images/star-off.png" data-id="<?php echo $order['order_id']; ?>" class="star" alt="4" title="四星" />
                                        <img src="<?php echo TPL_URL;?>images/star-off.png" data-id="<?php echo $order['order_id']; ?>" class="star" alt="5" title="五星" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>

            <?php foreach ($order['products'] as $key => $product) { ?>
                <tr class="content-row">
                    <td class="image-cell">
                        <img src="<?php echo $product['image']; ?>" />
                    </td>
                    <td class="title-cell">
                        <p class="goods-title">
                            <a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                                <?php echo $product['name']; ?>
                            </a>
                        </p>
                        <p>
                            <?php $skus = !empty($product['sku_data']) ? unserialize($product['sku_data']) : ''; ?>
                            <?php if ($skus) { ?>
                                <?php foreach ($skus as $sku) { ?>
                                    <span class="goods-sku"><?php echo $sku['value']; ?></span>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($product['is_fx']) { ?><span class="platform-tag">分销</span><?php } ?>
                        </p>
                    </td>
                    <td class="price-cell">
                        <p><?php echo $product['pro_price']; ?></p>
                        <p>(<?php echo $product['pro_num']; ?>件)</p>
                    </td>
                    <?php if (count($order['products']) > 0 && $key == 0) { ?>
                    <td class="aftermarket-cell" rowspan="<?php echo count($order['products']); ?>"></td>
                    <td class="customer-cell" rowspan="<?php echo count($order['products']); ?>">
                        <?php if (empty($order['is_fans'])) { ?>
                            <p>非粉丝</p>
                        <?php } else { ?>
                            <p><?php echo $order['buyer']; ?></p>
                        <?php } ?>
                        <?php if (!empty($order['address_user'])) { ?>
                            <p class="user-name"><?php echo $order['address_user']; ?></p>
                            <?php echo $order['address_tel']; ?>
                        <?php } ?>
                    </td>
                    <td class="time-cell" rowspan="<?php echo count($order['products']); ?>">
                        <div class="td-cont">
                            <?php echo date('Y-m-d H:i:s', $order['add_time']); ?>
                        </div>
                    </td>
                    <td class="state-cell" rowspan="<?php echo count($order['products']); ?>">
                        <div class="td-cont">
                            <p class="js-order-state"><?php echo $order_status[$order['status']]; ?></p>
                            <?php if (in_array($order['status'], array(0, 1))) { ?>
                            <p>
                                <a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small js-cancel-order">取消订单</a>
                            </p>
                            <?php } ?>
                            <?php if ($order['is_supplier']) { ?>
                            <?php if ($order['status'] == 2) { ?>
                            <p>
                                <a href="javascript:;" class="btn btn-small js-express-goods js-express-goods-<?php echo $order['order_id']; ?>" data-id="<?php echo $order['order_id']; ?>">发&nbsp;&nbsp;货</a>
                            </p>
                            <?php } ?>
                            <?php if ($order['status'] == 3) { ?>
                            <p>
                                <a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small js-complate-order">交易完成</a>
                            </p>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </td>
                    <td class="pay-price-cell" rowspan="<?php echo count($order['products']); ?>">
                        <div class="td-cont text-center">
                            <div>
                                <span class="order-total"><?php echo $order['total']; ?></span>
                                <br>
                                <span class="c-gray">(含运费: <?php echo $order['postage']; ?>)</span>
                                <br>
                                <?php  if ($order['status'] == 0 || $order['status'] == 1) { ?>
                                <a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="js-change-price js-change-price-<?php echo $order['order_id']; ?>">修改价格</a>
                                <?php } ?>
                            </div>
                        </div>
                    </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            <?php if ($order['bak'] != '') { ?>
                <tr class="remark-row">
                    <td colspan="8">卖家备注：<?php echo $order['bak']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php } ?>