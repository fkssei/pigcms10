<style type="text/css">
    .dash-bar .info-group {
        float: left;
        width: 25.33%;
        padding-top: 18px;
    }
    .widget .chart-body {
        height: 345px;
    }
    .form-horizontal input {
        width: 206px!important;
    }
    .form-actions input {
        width: auto!important;
        height: auto;
    }
</style>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>分销审核</h3>
        <div>
            <p>店铺粉丝申请成为分销商是否需要通过审核，如果需要请开启审核，默认为未启用。</p>
        </div>
    </div>
    <div class="widget-app-board-control approve">
        <label class="js-switch ui-switch pull-right <?php if ($open_drp_approve) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>引导分销</h3>
        <div>
            <p>在店铺首页添加引导分销提醒，在商品页面显示分销利润，引导粉丝注册成为分销商</p>
        </div>
    </div>
    <div class="widget-app-board-control guidance">
        <label class="js-switch ui-switch pull-right <?php if ($open_drp_guidance) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>分销限制</h3>
        <div>
            <p>设置粉丝申请分销商的门槛，为商家筛选优质分销商</p><br/>
            <div style="float: left">
                <b style="color: #07d">消费满</b> <input type="text" style="width: 80px" name="drp_limit_buy" class="drp-limit-buy" value="<?php echo $drp_limit_buy; ?>" /> <b style="color: #07d">元</b><br/>
                <!--<input type="radio" name="drp_limit_condition" class="drp-limit-condition" value="0" <?php /*if (empty($drp_limit_condition)) { */?>checked="true"<?php /*} */?> /> 或 / <input type="radio" name="drp_limit_condition" class="drp-limit-condition" value="1" <?php /*if (!empty($drp_limit_condition)) { */?>checked="true"<?php /*} */?> /> 和<br/>-->
                <!--<b style="color: #07d;display:inline-block;margin-top:20px">分享满</b> <input type="text" name="drp_limit_share" class="drp-limit-share" style="width: 80px" value="<?php /*echo $drp_limit_share; */?>" /> <b style="color: #07d">次</b>-->
            </div>
            <div style="border-right: 1px dashed lightgray;float: left;height: 30px;margin-left: 20px">&nbsp;</div>
            <div style="float: left;padding-top: 0px">
                <input type="button" class="ui-btn ui-btn-primary save-btn" value="保 存" style="margin-left: 30px" />
            </div>
        </div>
    </div>
    <div class="widget-app-board-control limit">
        <label class="js-switch ui-switch pull-right <?php if ($open_drp_limit) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>