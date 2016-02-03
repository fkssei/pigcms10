<div class="widget-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <div class="js-list-filter-region clearfix">
                <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                <div class="control-group">
                    <label class="control-label">订单号：</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="order_no" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">起止时间：</label>
                    <div class="controls">
                        <input type="text" name="stime" class="js-stime" id="js-stime" />
                        <span>&nbsp;&nbsp;至&nbsp;&nbsp;</span>
                        <input type="text" name="etime" class="js-etime" id="js-etime" />
                        <span class="date-quick-pick" data-days="7">最近7天</span>
                        <span class="date-quick-pick" data-days="30">最近30天</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">类型：</label>
                    <div class="controls">
                        <select name="type" class="js-type-select">
                            <option value="0" selected="true">全部</option>
                            <option value="1">订单入账</option>
                            <option value="2">提现</option>
                            <option value="3">退款</option>
                            <option value="4">系统退款</option>
                        </select>
                        <a href="javascript:;" class="ui-btn ui-btn-primary js-filter" data-loading-text="正在查询...">查询</a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <?php if (!empty($records)) { ?>
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th class="cell-15">时间</th>
                    <th class="cell-20">类型 | 收支流水号</th>
                    <th class="cell-10 text-right">收入(元) </th>
                    <th class="cell-10 text-right">支出(元)</th>
                    <th class="cell-10 text-right">余额(元)</th>
                    <th class="cell-25">支付渠道 | 单号</th>
                    <th class="cell-10">操作</th>
                </tr>
            </thead>
            <tbody class="js-list-body-region">
                <?php foreach ($records as $record) { ?>
                <tr class="widget-list-item">
                    <td><?php echo date('Y-m-d H:i:s', $record['add_time']); ?></td>
                    <td>
                        <span><?php echo $record_types[$record['type']]; ?></span>
                        <br>
                        <span class="c-gray"><?php echo $record['order_no']; ?></span>
                    </td>
                    <td class="text-right ui-money ui-money-income"><?php if ($record['income'] > 0) { ?>+ <?php echo $record['income']; ?><?php } ?></td>
                    <td class="text-right ui-money ui-money-outlay"><?php if ($record['income'] < 0) { ?>- <?php echo number_format(abs($record['income']), 2, '.', ''); ?><?php } ?></td>
                    <td class="text-right"><?php echo $record['balance']; ?></td>
                    <td>
                        <?php echo $payment_methods[$record['payment_method']]; ?><?php if($record['storeOwnPay']){ echo ' <span style="color:#999;">(自有支付)</span>';}?>
                        <br>
                        <span class="c-gray"><?php echo $record['trade_no']; ?></span>
                    </td>
                    <td>
                        <a href="<?php echo dourl('order:detail', array('id' => $record['order_id'])); ?>" target="_blank">详情</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
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