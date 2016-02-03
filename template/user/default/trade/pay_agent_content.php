<div class="js-app">
    <div class="js-app-board">
        <div class="widget-app-board ui-box">
            <div class="widget-app-board-info">
                <h3>找人代付</h3>
                <div>
                    <p>启用代付功能后，代付发起人（买家）下单后，可将订单分享给小伙伴（朋友圈、微信群、微信好友），请他帮忙付款。</p>
                    <p>注意：代送订单有效期15天，逾期后未完成，进入全额退款流程；若有超额支付，则超付部分进入退款流程；</p>
                </div>
            </div>
            <div class="widget-app-board-control">
                <label class="js-switch ui-switch <?php if ($payAgentStatus) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?> right" data-is-open="0"></label>
            </div>
        </div>
    </div>
    <div class="js-app-tab">
        <div class="ui-nav">
            <ul>
                <li class="js-tab-buyer active"><a href="javascript:;">发起人配置</a></li>
                <li class="js-tab-peerpay"><a href="javascript:;">代付人配置</a></li>
            </ul>
        </div>
        <div class="ui-box"><div class="ui-btn ui-btn-success js-add-buyer">新建</div></div>
    </div>
    <div class="js-app-list"></div>
    <div class="js-modal modal fade hide"></div>
</div>
<script type="text/javascript">
    $(function(){
        $('.js-app-list').load(pay_agent_content_buyer_url);
    })
</script>