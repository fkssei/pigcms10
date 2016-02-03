<include file="Public:header" />
<style type="text/css">
    table,th,td {
        font: 400 12px/18px "microsoft yahei",Arial;
        color: #434343;
    }
    .ui-box {
        margin-bottom: 15px;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
    }
    .ui-table {
        width: 100%;
        font-size: 12px;
        text-align: left;
        margin-bottom: 0;
        border: 1px solid #e5e5e5;
    }
    .ui-table.ui-table-list {
        border: none;
    }
    thead {
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
    }
    caption, th, td {
        font-weight: normal;
        vertical-align: middle;
    }
    .ui-table th {
        background: #f8f8f8;
    }
    .ui-table th, .ui-table td {
        padding: 10px;
        border-bottom: 1px solid #e5e5e5;
        vertical-align: top;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        line-height: 18px;
    }
    .ui-table th.ui-table-text-right, .ui-table th.text-right, .ui-table th.ui-table-opts, .ui-table td.ui-table-text-right, .ui-table td.text-right, .ui-table td.ui-table-opts {
        text-align: right;
        padding-right: 8px;
        padding-left: 0px;
    }
    .ui-table tbody tr:last-of-type {
        border-bottom: none;
    }
    .c-gray {
        color: #999;
    }
    .ui-money, .ui-money-income, .ui-money-outlay {
        font-weight: bold;
        color: #333;
    }
    .ui-money-income {
        color: #55BD47;
    }
    .ui-money-outlay {
        color: #f00;
    }
</style>
<div class="ui-box">
    <table class="ui-table ui-table-list" style="padding: 0px;">
        <thead class="js-list-header-region tableFloatingHeaderOriginal">
        <tr class="widget-list-header">
            <th class="cell-15">时间</th>
            <th class="cell-20">类型 | 收支流水号</th>
            <th class="cell-10 text-right">收入(元) </th>
            <th class="cell-10 text-right">支出(元)</th>
            <th class="cell-10 text-right">余额(元)</th>
            <th class="cell-25">支付渠道 | 单号</th>
        </tr>
        </thead>
        <tbody class="js-list-body-region">
        <if condition="$records neq ''">
        <volist name="records" id="record">
        <tr class="widget-list-item">
            <td>{pigcms{$record['add_time']|date='Y-m-d H:i:s', ###}</td>
            <td>
                <span>{pigcms{$record_types[$record['type']]}</span>
                <br>
                <span class="c-gray">{pigcms{$record['order_no']}</span>
            </td>
            <td class="text-right ui-money ui-money-income"><?php if ($record['income'] > 0) { ?>+ <?php echo $record['income']; ?><?php } ?></td>
            <td class="text-right ui-money ui-money-outlay"><?php if ($record['income'] < 0) { ?>- <?php echo number_format(abs($record['income']), 2, '.', ''); ?><?php } ?></td>
            <td class="text-right">{pigcms{$record['balance']}</td>
            <td>
                {pigcms{$payment_methods[$record['payment_method']]}<br>
                <span class="c-gray">{pigcms{$record['trade_no']}</span>
            </td>
        </tr>
        </volist>
        <tr>
            <td colspan="6" align="right" class="pagebar">{pigcms{$page}</td>
        </tr>
        <else />
            <td colspan="6" align="center" class="red">没有记录</td>
        </if>
        </tbody>
    </table>
</div>

<include file="Public:footer"/>