<div><div class="page-settlement">
        <div class="ui-box settingWithdrawal-region">
            <div class="header">设置提现账号</div>

            <form class="form-horizontal">
                <fieldset>
                    <div class="form-top-info">
                        <div class="control-group">
                            <label class="control-label">店铺名称：</label>
                            <div class="controls">
                                <p class="info-row"><?php echo $store['name']; ?></p>
                            </div>
                        </div>

                        <div class="control-group type-wrap">
                            <label class="control-label"><em class="required">*</em>可提现方式：</label>
                            <div class="controls">
                                <div class="type-item">
                                    <input class="js-chose" id="type0" type="radio" value="0" name="type" checked="true" />
                                    <label for="type0">
                                        <h4 class="type-item-title">对私银行账户</h4>
                                        <p class="type-item-content">支持提现至个人银行借记卡</p>
                                    </label>
                                </div>
                                <div class="type-item">
                                    <input class="js-chose" id="type1" type="radio" value="1" name="type" />
                                    <label for="type1">
                                        <h4 class="type-item-title">对公银行账户</h4>
                                        <p class="type-item-content">支持提现至公司银行卡</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="type-content">
                        <div class="js-type-0 js-type">
                            <div class="alert">
                                1. 请仔细填写账户信息，如果由于您填写错误导致资金流失，平台概不负责；
                                <br>
                                2. 只支持提现到银行借记卡，<span class="text-strong">不支持信用卡和存折</span>。提现审核周期为3个工作日；
                            </div>

                            <div class="control-group">
                                <label class="control-label"><em class="required">*</em>发卡银行：</label>
                                <div class="controls bank-map js-bank-map-region">
                                    <select class="bank" name="bank">
                                        <?php foreach ($banks as $bank) { ?>
                                        <option value="<?php echo $bank['bank_id']; ?>"><?php echo $bank['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><em class="required">*</em>开户银行：</label>
                                <div class="controls">
                                    <input type="text" placeholder="准确填写银行卡开户银行，否则无法提现；" name="opening_bank" class="js_opening_bank" value="<?php echo $opening_bank; ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><em class="required">*</em>银行卡卡号：</label>
                                <div class="controls">
                                    <div class="widget-account-pretty">
                                        <div class="widget-account-pretty-input">
                                            <input type="text" placeholder="只支持提现至借记卡，不支持信用卡和存折；" name="bank_card" class="js_bank_card" />
                                            <div class="widget-account-pretty-text js-account-pretty"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">

                                <label class="control-label"><em class="required">*</em>开卡人姓名：</label>
                                <div class="controls">
                                    <input type="text" placeholder="准确填写银行卡开卡人姓名，否则无法提现；" name="bank_card_user" class="js_bank_card_user" />
                                </div>

                            </div>
                            <div class="control-group">
                                <label class="control-label"><em class="required">*</em>短信验证码：</label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input class="sms js_verify_code" type="text" maxlength="6" name="verify_code" />
                                        <button type="button" class="btn sms-btn js-fetch-sms" data-loading-text="正在获取...">获取</button>
                                    </div>
                                    <input type="hidden" class="js-mobile" value="<?php echo $store['tel']; ?>" />
                                    <p class="c-gray">验证短信将发送到您绑定的手机：<?php echo $store['tel']; ?>，请注意查收</p>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button class="btn btn-primary js-submit-btn" type="button" data-loading-text="保存中...">保存</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>