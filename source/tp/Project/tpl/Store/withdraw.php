<include file="Public:header" />
<style type="text/css">
    table,th,td {
        font: 400 12px/18px "microsoft yahei",Arial!important;
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
    .caret {
        display: inline-block;
        width: 0;
        height: 0;
        vertical-align: top;
        border-top: 4px solid #000000;
        border-right: 4px solid transparent;
        border-left: 4px solid transparent;
        content: "";
    }
    .caret {
        margin-top: 7px;
        margin-left: 5px;
    }
    .popover {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1010;
        padding: 5px;
        background-color: transparent;
        border: none;
        -webkit-box-shadow: none;
        box-shadow: none;
        max-width: none;
    }
    .popover.bottom {
        margin-top: 5px;
    }
    .popover .arrow {
        border-width: 11px;
    }
    .popover .arrow, .popover .arrow:after {
        position: absolute;
        display: block;
        width: 0;
        height: 0;
        border-color: transparent;
        border-style: solid;
    }
    .popover.bottom .arrow {
        top: 0;
        left: 50%;
        margin-left: -5px;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid #000000;
        border-top-width: 0;
    }
    .popover .arrow:after {
        border-width: 10px;
        content: "";
    }
    .popover.bottom .arrow:after {
        top: 1px;
        margin-left: -10px;
        border-bottom-color: #ffffff;
        border-top-width: 0;
    }
    .popover-inner {
        padding: 3px;
        width: 280px;
        overflow: hidden;
        background: #000000;
        background: rgba(0, 0, 0, 0.8);
        border-radius: 4px;
        -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
        box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    }
    .popover-delete, .popover-confirm {
        width: 250px;
    }
    .popover-content {
        padding: 10px;
        background-color: #ffffff;
        border-radius: 3px;
        background-clip: padding-box;
    }
    .popover-content > .js-content {
        font-size: 12px;
    }
    em, h1, h2, h3, h4, input, li, ol, p, span, textarea, ul {
        margin: 0;
        padding: 0;
        list-style: none;
        font-style: normal;
    }
    p, li {
        line-height: 1.5em;
        font: 400 12px/18px "microsoft yahei",Arial!important;
    }
</style>
<script type="text/javascript">
    $(function(){
        $('.caret').live('click', function(){
            var bank = $(this).data('bank');
            var opening_bank = $(this).data('opening-bank');
            var bank_account = $(this).data('bank-account');
            var bank_card = $(this).data('bank-card');
            $('body > .popover').remove();
            $('body').append('<div class="popover center-bottom bottom" style="display: block; top: ' + ($(this).offset().top) + 'px; left: ' + ($(this).offset().left - 129) + 'px;"><div class="arrow"></div><div class="popover-inner popover-delete"><div class="popover-content"><div class="js-content"><div><p>收款银行：' + bank + '</p><p>开户银行：' + opening_bank + '<p>银行帐户：' + bank_card + '</p><p>帐户名称：' + bank_account + '</p></div></div></div></div></div>');
        })

        $(document).live('click', function(e){
            var _con = $('.popover');   // 设置目标区域
            var _con2 = $('.caret');
            if((!_con.is(e.target) && _con.has(e.target).length === 0) && (!_con2.is(e.target) && _con2.has(e.target).length === 0)){ // Mark 1
                $('.popover').remove();
            }
        })
    })
</script>
<div class="ui-box">
    <table class="ui-table ui-table-list" style="padding: 0px;">
        <thead class="js-list-header-region tableFloatingHeaderOriginal">
        <tr class="widget-list-header">
            <th class="cell-10">申请时间</th>
            <th class="cell-22">提现银行 | 编号</th>
            <th class="cell-12 text-right">提现金额(元)</th>
            <th class="cell-12">处理完成时间</th>
            <th class="cell-12">状态</th>
            <th class="cell-15">申请人</th>
        </tr>
        </thead>
        <tbody class="js-list-body-region">
        <if condition="$withdrawals neq ''">
        <volist name="withdrawals" id="withdrawal">
        <tr class="widget-list-item">
            <td width="90">{pigcms{$withdrawal.add_time|date='Y-m-d H:i:s', ###}</td>
            <td width="195">
                <if condition="$withdrawal['withdrawal_type'] eq 0">个人账户<else/>公司账户</if> |
                <span class="js-bank-detail" style="cursor: pointer;"><?php echo mb_substr($withdrawal['bank'], 0, 4, 'UTF-8'); ?>...<?php echo substr($withdrawal['bank_card'], -4); ?><b class="caret" data-bank="{pigcms{$withdrawal.bank}" data-opening-bank="{pigcms{$withdrawal.opening_bank}" data-bank-card="{pigcms{$withdrawal.bank_card}" data-bank-account="{pigcms{$withdrawal.bank_card_user}"></b></span>
                <br>
                <span class="c-gray">{pigcms{$withdrawal.trade_no}</span>
            </td>
            <td class="text-right ui-money-outlay">{pigcms{$withdrawal.amount}</td>
            <td><?php if (!empty($withdrawal['complate_time'])) { ?><?php echo date('Y-m-d H:i:s', $withdrawal['complate_time']); ?><?php } ?></td>
            <td class="">{pigcms{$status[$withdrawal['status']]}</td>
            <td>
                {pigcms{$withdrawal.nickname}<br>
                <span class="c-gray">{pigcms{$withdrawal.tel}</span>
            </td>
        </tr>
        </volist>
        <tr>
            <td colspan="6" align="right" class="pagebar">{pigcms{$page}</td>
        </tr>
        <else/>
            <td colspan="6" align="center" class="red">没有记录</td>
        </if>
        </if>
        </tbody>
    </table>
</div>