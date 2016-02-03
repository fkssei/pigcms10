<form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
    <div class="clearfix">
        <div class="filter-groups">
            <div class="control-group">
                <label class="control-label">订单号：</label>
                <div class="controls">
                    <input type="text" name="order_no" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">交易号：</label>
                <div class="controls">
                    <input type="text" name="trade_no" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">收货人姓名：</label>
                <div class="controls">
                    <input type="text" name="user" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">收货人手机：</label>
                <div class="controls">
                    <input type="text" name="tel" />
                </div>
            </div>
        </div>
        <div class="pull-left">
            <div class="time-filter-groups clearfix">
                <div class="control-group">
                    <label class="control-label select">
                        <select name="time_type">
                            <option value="add_time">下单时间</option>
                            <option value="paid_time">付款时间</option>
                            <option value="sent_time">发货时间</option>
                            <option value="complate_time">签收时间</option>
                            <option value="cancel_time">关闭时间</option>
                            <option value="refund_time">退款时间</option>
                        </select>
                    </label>

                    <div class="controls">
                        <input type="text" name="start_time" value="" class="js-start-time" id="js-start-time" />
                        <span>至</span>
                        <input type="text" name="end_time" value="" class="js-end-time" id="js-end-time" />
                        <span class="date-quick-pick" data-days="7">最近7天</span>
                        <span class="date-quick-pick" data-days="30">最近30天</span>
                    </div>
                </div>
            </div>
            <div class="filter-groups">
                <div class="control-group">
                    <label class="control-label">订单类型：</label>
                    <div class="controls">
                        <select name="type" class="js-type-select">
                            <option value="*">全部</option>
                            <option value="0">普通订单</option>
                            <option value="1">代付订单</option>
                            <option value="3">分销订单</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">订单状态：</label>
                    <div class="controls">
                        <select name="status" class="js-state-select">
                            <option value="*">全部 (不包含临时单)</option>
                            <option value="1">待付款</option>
                            <option value="2">待发货</option>
                            <option value="3">已发货</option>
                            <option value="4">已完成</option>
                            <option value="5">已关闭</option>
                            <option value="6">退款中</option>
                            <option value="0">临时单</option>
                        </select>
                    </div>
                </div>
                <!--<div class="control-group">
                    <label class="control-label">微信昵称：</label>
                    <div class="controls">
                        <input type="text" name="weixin_user" />
                    </div>
                </div>-->
            </div>
            <div class="filter-groups">

                <div class="control-group">
                    <label class="control-label">付款方式：</label>
                    <div class="controls">
                        <select name="payment_method">
                            <option value="">全部</option>
                            <option value="weixin">微信安全支付</option>
                            <option value="alipay">支付宝支付</option>
                            <option value="CardPay">会员卡支付</option>
                            <option value="umpay">银行卡付款</option>
                            <option value="balance">余额支付</option>
                            <option value="codpay">货到付款/到店付款</option>
                            <option value="peerpay">找人代付</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">物流方式：</label>
                    <div class="controls">
                        <select name="shipping_method">
                            <option value="">全部</option>
                            <option value="express">快递发货</option>
                            <option value="selffetch">上门自提</option>
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