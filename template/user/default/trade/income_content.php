<div>
    <div class="page-settlement">
        <div class="ui-box settlement-info">
            <div class="account-info">
                <img src="<?php echo $store['logo']; ?>" class="logo" />

                <div class="account-info-meta">
                    <div class="info-item">
                        <label>店铺名称：</label>
                        <span><?php echo $store['name']; ?></span>
                    </div>
                    <div class="info-item">
                        <label>收款账户：</label>
                        <span><?php if (!empty($store['bank_card_user'])) { ?><?php echo $store['bank_card_user']; ?><?php } else { ?>未填写<?php } ?></span>
                    </div>
                    <div class="info-item">
                        <label>银行卡号：</label>
                        <span><?php if (!empty($store['bank_card'])) { ?><?php echo $store['bank_card']; ?><?php } else { ?>未填写<?php } ?></span>
                        <?php if (!empty($store['bank_card'])) { ?>
                        <a href="javascript:;" class="js-setup-account">修改提现账号</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="balance">
                <div class="balance-info" style="border-left: none;">
                    <div class="balance-title">7天收入<span>（截至昨日）</span></div>
                    <div class="balance-content">
                        <span class="money"><?php echo $day_7_income; ?></span>
                        <span class="unit">元</span>
                        <a href="#inoutdetail" class="pull-right inoutdetail">收支明细</a>
                    </div>
                </div>
                <div class="balance-info">
                    <div class="balance-title">待结算<span>（担保交易）</span></div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['unbalance']; ?></span>
                        <span class="unit">元</span>
                    </div>
                </div>
                <div class="balance-info">
                    <div class="balance-title">账户余额

                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['balance']; ?></span>
                        <span class="unit">元</span>
                        <!--<a href="javascript:;" class="ui-btn ui-btn-primary pull-right ui-btn-disabled js-goto" data-goto="renzheng" disabled="disabled">提现</a>-->
                        <a href="<?php if ($store['balance'] <= 0) { ?>javascript:;<?php } else { ?>#<?php if ($bind_bank_card) { ?>applywithdrawal<?php } else { ?>settingwithdrawal<?php } ?><?php } ?>" class="ui-btn ui-btn-primary pull-right <?php if ($store['balance'] <= 0) { ?>ui-btn-disabled<?php } else { ?>js-goto<?php } ?>" data-goto="renzheng">提现</a>
                    </div>
                </div>
                <div style="clear: both"></div>
            </div>

        </div>

        <!--<div class="ui-box ui-title">
            <h3>支付方式</h3>
            <a href="#">设置</a>
        </div>

        <div class="ui-box">
            <ul class="pay-mode-list clearfix">
                <li class="pay-mode-item">
                    <div class="pay-mode-icon pay-mode-icon-wxpay"></div>
                    <div class="pay-mode-meta">
                        <h4 class="pay-mode-name">
                            <i class="pay-mode-enable"></i>
                            微信支付 - 代销
                        </h4>

                        <p class="pay-mode-description">
                            微店不收取任何交易、提现手续费（微信支付产生的交易手续费由微店全部补贴）
                        </p>
                    </div>
                </li>
                <li class="pay-mode-item">
                    <div class="pay-mode-icon pay-mode-icon-unionpay"></div>
                    <div class="pay-mode-meta">
                        <h4 class="pay-mode-name">
                            <i class="pay-mode-enable"></i>
                            银行卡支付 - 联动U付
                        </h4>

                        <p class="pay-mode-description">
                            微店不收取任何交易、提现手续费（银行扣取的交易手续费，由微店全额补贴）
                        </p>
                    </div>
                </li>
                <li class="pay-mode-item">
                    <div class="pay-mode-icon pay-mode-icon-bdpay"></div>
                    <div class="pay-mode-meta">
                        <h4 class="pay-mode-name">
                            <i class="pay-mode-enable"></i>
                            银行卡支付 - 百度钱包
                        </h4>

                        <p class="pay-mode-description">
                            微店不收取任何交易、提现手续费（银行扣取的交易手续费，由微店全额补贴）
                        </p>
                    </div>
                </li>
                <li class="pay-mode-item">
                    <div class="pay-mode-icon pay-mode-icon-alipay"></div>
                    <div class="pay-mode-meta">
                        <h4 class="pay-mode-name">
                            <i class="pay-mode-disable"></i>
                            支付宝支付
                        </h4>

                        <p class="pay-mode-description">
                            支付宝实时扣除每笔交易手续费2.5%～2%，每次提现支付宝将扣除0.5%（单笔最低手续费1元，最高25元）
                        </p>
                    </div>
                </li>
            </ul>
        </div>-->

    </div>
</div>