<include file="Public:header"/>
<style type="text/css">
    .c-gray {
        color: #999;
    }
    .table-list tfoot tr {
        height: 40px;
    }
    .green {
        color: green;
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
    .date-quick-pick {
        display: inline-block;
        color: #07d;
        cursor: pointer;
        padding: 2px 4px;
        border: 1px solid transparent;
        margin-left: 12px;
        border-radius: 4px;
        line-height: normal;
    }
    .date-quick-pick.current {
        background: #fff;
        border-color: #07d!important;
    }
    .date-quick-pick:hover{border-color:#ccc;text-decoration:none}
</style>
<if condition="$withdrawal_count gt 0">
    <script type="text/javascript">
        $(function(){
          //  $('#nav_12 > dd:last-child > span', parent.document).html('提现记录 <label style="color:red">(' + {pigcms{$withdrawal_count} + ')</label>')
		   $('#nav_12 > dd > #leftmenu_Store_withdraw', parent.document).html('提现记录 <label style="color:red">(' + {pigcms{$withdrawal_count} + ')</label>')
        })
    </script>
    <else/>
    <script type="text/javascript">
        $(function(){
             $('#nav_12 > dd > #leftmenu_Store_withdraw', parent.document).html('提现记录');
        })
    </script>
</if>

<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="{pigcms{:U('Store/inoutdetail')}" class="on">提现记录</a>
        </ul>
    </div>
    <table class="search_table" width="100%">
        <tr>
            <td>
                <form action="{pigcms{:U('Store/inoutdetail')}" method="get">
                    <input type="hidden" name="c" value="Store"/>
                    <input type="hidden" name="a" value="inoutdetail"/>
                    筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}" />
                    <select name="type">
                        <option value="order_no" <if condition="$_GET['type'] eq 'order_no'">selected="selected"</if>>收支流水号</option>
                        <option value="trade_no" <if condition="$_GET['type'] eq 'trade_no'">selected="selected"</if>>交易单号</option>
                        <option value="store" <if condition="$_GET['type'] eq 'store'">selected="selected"</if>>店铺名称</option>
                    </select>
                    &nbsp;&nbsp;
                    类型：
                    <select name="record_type">
                        <option value="0">类型</option>
                        <volist name="record_types" id="type">
                        <option value="{pigcms{$key}" <if condition="$Think.get.record_type eq $key">selected="true"</if>>{pigcms{$type}</option>
                        </volist>
                    </select>
                    &nbsp;&nbsp;支付方式：
                    <select name="payment_method">
                        <option value="0">支付方式</option>
                        <volist name="payment_methods" id="payment_method">
                            <option value="{pigcms{$key}" <if condition="$Think.get.payment_method eq $key">selected</if>>{pigcms{$payment_method}</option>
                        </volist>
                    </select>
                    &nbsp;&nbsp;时间：
                    <input type="text" name="start_time" id="js-start-time" class="input-text Wdate" style="width: 150px" value="{pigcms{$Think.get.start_time}" />- <input type="text" name="end_time" id="js-end-time" style="width: 150px" class="input-text Wdate" value="{pigcms{$Think.get.end_time}" />
                    <span class="date-quick-pick" data-days="7">最近7天</span>
                    <span class="date-quick-pick" data-days="30">最近30天</span>
                    <input type="submit" value="查询" class="button"/>
                </form>
            </td>
        </tr>
    </table>

    <div class="table-list">
        <table width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>收支流水号</th>
                <th>类型</th>
                <th>店铺名称</th>
                <th>收入(元)</th>
                <th>支出(元)</th>
                <th>余额(元)</th>
                <th>支付渠道</th>
                <th>交易单号</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            <if condition="is_array($records)">
                <volist name="records" id="record">
                    <tr>
                        <td><span class="c-gray">{pigcms{$record.order_no}</span></td>
                        <td>{pigcms{$record_types[$record['type']]}</td>
                        <td>{pigcms{$record.store}</td>
                        <td><span class="ui-money-income"><if condition="$record['income'] gt 0">+ {pigcms{$record.income}</if></span></td>
                        <td><if condition="$record['income'] lt 0"><span class="ui-money-outlay">- {pigcms{$record.income|abs|number_format=###, 2, '.', ''}</span></if></td>
                        <td>{pigcms{$record.balance}</td>
                        <td>{pigcms{$payment_methods[$record['payment_method']]}</td>
                        <td>{pigcms{$record.trade_no}</td>
                        <td>{pigcms{$record.add_time|date='Y-m-d H:i:s', ###}</td>
                    </tr>
                </volist>
            </if>
            </tbody>
            <tfoot>
            <if condition="is_array($records)">
                <tr>
                    <td class="textcenter pagebar" colspan="14">{pigcms{$page}</td>
                </tr>
                <else/>
                <tr><td class="textcenter red" colspan="14">列表为空！</td></tr>
            </if>
            </tfoot>
        </table>
    </div>

</div>
<include file="Public:footer"/>