<div class="goods-list">
    <div class="js-list-filter-region clearfix">
        <div class="widget-list-filter">
            <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                <div class="clearfix">
                    <div class="filter-groups">
                        <div class="control-group">
                            <label class="control-label">买家订单号：</label>
                            <div class="controls">
                                <input type="text" name="buyer_order_no" value="<?php echo !empty($_POST['order_no']) ? $_POST['order_no'] : ''; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">采购单号：</label>
                            <div class="controls">
                                <input type="text" name="seller_order_no" value="<?php echo !empty($_POST['fx_order_no']) ? $_POST['fx_order_no'] : ''; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">收货人姓名：</label>
                            <div class="controls">
                                <input type="text" name="customer_name" value="<?php echo !empty($_POST['delivery_user']) ? $_POST['delivery_user'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="pull-left">
                        <div class="time-filter-groups clearfix">
                            <div class="control-group">
                                <label class="control-label">下单时间：</label>
                                <div class="controls">
                                    <input type="text" name="start_time" id="js-start-time" class="js-start-time" value="<?php echo !empty($_POST['start_time']) ? date('Y-m-d H:i:s', $_POST['start_time']) : ''?>" />
                                    <span>至</span>
                                    <input type="text" name="end_time" id="js-end-time" class="js-end-time" value="<?php echo !empty($_POST['stop_time']) ? date('Y-m-d H:i:s', $_POST['stop_time']) : ''?>" />
                                    <span class="date-quick-pick" data-days="7">最近7天</span>
                                    <span class="date-quick-pick" data-days="30">最近30天</span>
                                </div>
                            </div>
                        </div>
                        <div class="filter-groups">
                            <div class="control-group">
                                <label class="control-label">供货商：</label>
                                <div class="controls">
                                    <select class="supplier-select js-supplier-select" name="supplier_id">
                                        <option value="0">所有供货商</option>
                                        <?php foreach ($suppliers as $suppliler) { ?>
                                        <option value="<?php echo $suppliler['supplier_id']; ?>" <?php if (!empty($_POST['supplier_id']) && $_POST['supplier_id'] == $suppliler['supplier_id']) { ?>selected="true"<?php } ?>><?php echo $suppliler['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">收货人手机：</label>
                                <div class="controls">
                                    <input type="text" name="customer_mobile" value="<?php echo !empty($_POST['delivery_tel']) ? $_POST['delivery_tel'] : ''; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="filter-groups">
                            <div class="control-group">
                                <label class="control-label">采购单状态：</label>
                                <div class="controls">
                                    <select class="state-select js-state-select" name="state">
                                        <option value="0" selected="">全部状态</option>
                                        <?php foreach ($status as $id => $value) { ?>
                                        <option value="<?php echo $id; ?>" <?php if (!empty($_POST['status']) && $_POST['status'] == $id) { ?>selected="true"<?php } ?>><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="ui-btn-group">
                            <a href="javascript:;" class="ui-btn ui-btn-primary js-filter" data-loading-text="正在筛选...">筛选</a>
                        </div>
                    </div>
                </div>
            </form>
        </div></div>
<div class="ui-box order-list-ui-box">
    <table class="ui-table-order" style="padding: 0px;">
        <?php if (!empty($orders)) { ?>
        <thead class="js-list-header-region tableFloatingHeaderOriginal">
        <tr class="widget-list-header">
            <th class="checkbox cell-35" colspan="3">
                <label class="checkbox inline order-list">
                    <input type="checkbox" class="js-check-all">
                    商品
                </label>
            </th>
            <th class="cell-12 text-center">单价/数量</th>
            <th class="cell-12 text-center">买家</th>
            <th class="cell-12 text-center">成交额</th>
            <th class="cell-12 text-center">状态</th>
            <th class="cell-12 text-center">创建时间</th>
            <th class="cell-15 text-center">操作</th>
        </tr>
        </thead>
        <tbody class="widget-list-item">
        <tr class="separation-row">
            <td colspan="8"></td>
        </tr>
        <?php foreach ($orders as $order) { ?>
        <tr class="header-row">
            <td colspan="5">
                <div>
                    <label>
                        <input type="checkbox" class="js-check-toggle checkbox-order" <?php if ($order['status_id'] != 1) { ?>disabled="true"<?php } ?> value="<?php echo $order['fx_order_id']; ?>" data-supplier-id="<?php echo $order['supplier_id']; ?>" />
                        订单号: <?php echo $order['fx_order_no']; ?>
                        <span class="c-gray">
                            供货商：<?php echo $order['supplier']; ?>
                        </span>
                    </label>
                </div>
            </td>
            <td colspan="4">买家订单号: <?php echo $order['order_no']; ?></td>
        </tr>
        <?php foreach ($order['products'] as $key => $product) { ?>
        <tr class="content-row">
            <td class="image-cell">
                <img src="<?php echo $product['image']; ?>" />
            </td>
            <td></td>
            <td class="title-cell">
                <p class="goods-title">
                    <a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                        <?php echo $product['name']; ?>
                    </a>
                </p>
                <p></p>
                <p></p>
            </td>
            <td class="price-cell">
                <div class="price-container">
                    <span>￥</span>
                    <p class="goods-price"><?php echo $product['cost_price']; ?></p>
                </div>
                <div class="num-cotainer"><p class="goods-price">(<?php echo $product['quantity']; ?>件)</p></div>
            </td>
            <?php if (count($order['products']) > 0 && $key == 0) { ?>
            <td class="aftermarket-cell" rowspan="<?php echo count($order['products']); ?>">
                <p><?php echo $order['delivery_user']; ?></p>
                <p><?php echo $order['delivery_tel']; ?></p>
            </td>
            <td class="customer-cell" rowspan="<?php echo count($order['products']); ?>">
                <div class="price-container">
                    <span>￥</span>
                    <p class="goods-price"><?php echo $order['total']; ?></p>
                </div>
            </td>
            <td class="state-cell" rowspan="<?php echo count($order['products']); ?>">
                <div class="td-cont">
                    <p class="js-order-state"><?php echo $order['status']; ?></p>
                </div>
            </td>
            <td class="time-cell" rowspan="<?php echo count($order['products']); ?>">
                <div class="td-cont">
                    <?php echo $order['add_time']; ?>
                </div>
            </td>
            <td class="pay-price-cell" rowspan="<?php echo count($order['products']); ?>">
                <div class="td-cont text-center">
                    <div>
                        <?php if ($order['status_id'] == 1) { ?>
                        <a href="javascript:;" data-id="<?php echo $order['fx_order_id']; ?>" class="js-pay-btn">付款</a>
                        <?php } else { ?>
                        <a href="<?php dourl('order_detail', array('id' => $order['fx_order_id'])); ?>">查看</a>
                        <?php } ?>
                    </div>
                </div>
            </td>
            <?php } ?>
        </tr>
        <?php } ?>
        <?php } ?>
        </tbody>
        <?php } ?>
    </table>
    <div class="js-list-empty-region">
        <?php if (empty($orders)) { ?>
        <div>
            <div class="no-result widget-list-empty">还没有相关数据。</div>
        </div>
        <?php } ?>
    </div>
</div>
<div class="js-list-footer-region ui-box">
    <?php if (!empty($orders)) { ?>
    <div class="widget-list-footer">
        <div class="pull-left">
            <a href="javascript:;" class="ui-btn js-batch-pay">合并付款</a>
        </div>
        <div class="pagenavi"><?php echo $page; ?></div>
    </div>
    <?php } ?>
</div>
</div>