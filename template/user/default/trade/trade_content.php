<div class="widget-list trade-list">
    <div class="js-list-filter-region clearfix">
        <div class="widget-list-filter">
            <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                <div class="control-group">
					<label class="control-label">时间：</label>
                    <div class="controls">
                        <input type="text" name="stime" class="js-stime" id="js-stime" />
                        <span>至</span>
                        <input type="text" name="etime" class="js-etime" id="js-etime" />
                        <span class="date-quick-pick" data-days="7">最近7天</span>
                        <span class="date-quick-pick" data-days="30">最近30天</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">单号：</label>
                    <div class="controls">
                        <input type="text" name="order_no" class="span4" style="width: 283px;" placeholder="订单号/支付流水号" />
                        <span style="margin-left: 18px;">交易状态：</span>
                        <select name="status" class="js-state-select">
                            <option value="0">全部</option>
                            <?php foreach ($status as $id => $value) { ?>
                                <option value="<?php echo $id; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="ui-btn-group">
                            <button class="ui-btn ui-btn-primary js-filter" style="margin-left: 0;height: auto"
                                    data-loading-text="正在筛选...">筛选
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="trade-list-nav">
                <ul>
                    <li class="active status-0" data-id="0"><a href="#trade/0">全部</a></li>
                    <li data-id="1" class="status-1"><a href="#trade/1">进行中</a></li>
                    <li data-id="2" class="status-2"><a href="#trade/2">退款</a></li>
                    <li data-id="3" class="status-3"><a href="#trade/3">成功</a></li>
                    <li data-id="4" class="status-4"><a href="#trade/4">失败</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-trade" style="padding: 0px;">
            <?php if (!empty($records)) { ?>
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
            <tr class="widget-list-header">
                <th class="cell-12">时间</th>
                <th class="cell-15">订单号｜支付单号</th>
                <th class="cell-15 text-right">
                    <div class="row-money">金额｜明细</div>
                </th>
                <th class="cell-15">状态</th>
                <th class="cell-10">操作</th>
            </tr>
            </thead>
            <?php foreach ($records as $record) { ?>
            <tbody class="widget-list-item">
            <tr>
                <td rowspan="1">
                    <?php echo date('Y-m-d H:i:s', $record['add_time']); ?>
                </td>
                <td>
                    <?php echo $record['order_no']; ?>
                    <br>
                    <span class="c-gray"><?php echo $record['trade_no']; ?></span>
                </td>
                <td class="text-right">
                    <div class="row-money">
                        <?php if ($record['income'] > 0) { ?>
                        <span class="ui-money-income">+ <?php echo $record['income']; ?></span>
                        <?php } ?>
                        <?php if ($record['income'] < 0) { ?>
                        <span class="ui-money-outlay">- <?php echo number_format(abs($record['income']), 2, '.', ''); ?></span>
                        <?php } ?>
                    </div>
                </td>
                <td><?php echo $status_text[$record['status']]; ?></td>
                <td>
                    <a href="<?php dourl('order:detail', array('id' => $record['order_id'])); ?>" target="_blank">查看</a>
                </td>
            </tr>
            </tbody>
            <?php } ?>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($records)) { ?>
            <div>
                <div class="no-result widget-list-empty">还没有相关数据。</div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div class="widget-list-footer">
            <div class="pagenavi"><?php echo $page; ?></div>
        </div>
    </div>
</div>