<style type="text/css">
    input[type="radio"], input[type="checkbox"] {
        margin:0
    }
</style>
<div class="goods-edit-area">
<ul class="ui-nav-tab">
    <li data-next-step="2" class="js-switch-step js-step-2 active"><a href="javascript:;">分销商品设置</a></li>
</ul>
<div id="step-content-region">
<form class="form-horizontal fm-goods-info">



<div id="step-2" class="js-step">
<div id="base-info-region" class="goods-info-group">
    <div class="goods-info-group-inner">
        <div class="info-group-title vbox">
            <div class="group-inner">商品信息</div>
        </div>
        <div class="info-group-cont vbox">
            <div class="group-inner">
                <div class="control-group">
                    <label class="control-label">商品图片：</label>
                    <div class="controls">
                        <img src="<?php echo $product['image']; ?>" width="100" height="100" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">商品类目：</label>
                    <div class="controls">
                        <?php echo $product['category']; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">商品名称：</label>

                    <div class="controls">
                        <?php echo $product['name']; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">商品库存：</label>
                    <div class="controls">
                        <?php echo $product['quantity']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="goods-info-region" class="goods-info-group">
    <div class="goods-info-group-inner">
        <div class="info-group-title vbox">
            <div class="group-inner">分销设置</div>
        </div>
        <div class="info-group-cont vbox">
            <div class="group-inner">
                <div class="control-group">
                    <label class="control-label">商家推荐：</label>
                    <div class="controls">
                        <input type="checkbox" name="is_recommend" value="1" <?php if ($product['is_recommend']) { ?>checked="true"<?php } ?> /> 是 <span class="gray">(全网最低价格、新品、热卖商品)</span>
                    </div>
                </div>
                <?php if (empty($product['source_product_id'])) { ?>
                <div class="control-group">
                    <label class="control-label">分销限制：</label>
                    <div class="controls">
                        <input type="radio" name="drp_limit" value="1" checked="true" /> 只允许排他（<span style="color:#bbb">只有排他分销市场能看到此商品</span>）<br/>
                        <input type="radio" name="drp_limit" value="2" /> 只允许全网（<span style="color:#bbb">只有全网分销市场能看到此商品</span>）<br/>
                        <input type="radio" name="drp_limit" value="3" /> 只允许下级分销商和全网（<span style="color:#bbb">只有下级分销商和全网分销市场能看到此商品</span>）<br/>
                        <input type="radio" name="drp_limit" value="4" /> 不限制（<span style="color:#bbb">所有人能看到此商品</span>）<br/>
                    </div>
                </div>
                <?php } ?>
                <div class="control-group">
                    <label class="control-label">分销价格：</label>
                    <?php if (empty($product['source_product_id'])) { ?>
                    <div class="controls">
                        <input type="radio" name="unified_price_setting" class="unified-price-setting" id="unified-price-setting-0" value="0" checked="true" /> <label for="unified-price-setting-0" style="display: inline-block">自由定价（<span style="color:#bbb">由分销商为商品自行设置分销价格</span>）</label><br/>
                        <input type="radio" name="unified_price_setting" class="unified-price-setting" id="unified-price-setting-1" value="1" /> <label for="unified-price-setting-1" style="display: inline-block">统一定价（<span style="color:#bbb">由供货商为商品统一设置分销价格</span>）</label><br/>
                    </div>
                    <?php } else if (!empty($product['unified_price_setting'])) { ?>
                    <div class="controls">
                        <input type="radio" name="unified_price_setting" class="unified-price-setting" id="unified-price-setting-1" value="1" checked="true" disabled="true" /> <label for="unified-price-setting-1" style="display: inline-block">统一定价（<span style="color:#bbb">由供货商为商品统一设置分销价格</span>）</label><br/>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div id="sku-info-region" class="goods-info-group"><div class="goods-info-group-inner"><div class="info-group-title vbox">
                <div class="group-inner">库存/规格</div>
            </div>
            <div class="info-group-cont vbox">
                <div class="group-inner">
                    <?php if (!empty($sku_content)) { ?>
                    <div class="js-goods-stock control-group">
                        <div id="stock-region" class="controls sku-stock" style="margin-left: 0;">
                            <div class="sku-price-0">
                                <table class="table-sku-stock">
                                    <?php echo $sku_content; ?>
                                </table>
                            </div>
                            <?php if (empty($product['source_product_id'])) { ?>
                            <div class="sku-price-1 hide">
                                <?php if (empty($drp_level)) { ?>
                                <br/>
                                <b style="color: #0000ff">一级分销商定价</b>
                                <table class="table-sku-stock table-sku-stock-1" data-level="1">
                                    <?php echo $sku_content2; ?>
                                </table>
                                <br/>
                                <b style="color: #0000ff">二级分销商定价</b>
                                <table class="table-sku-stock table-sku-stock-2" data-level="2">
                                    <?php echo $sku_content2; ?>
                                </table>
                                <br/>
                                <b style="color: #0000ff">三级分销商定价</b>
                                <table class="table-sku-stock table-sku-stock-3" data-level="3">
                                    <?php echo $sku_content2; ?>
                                </table>
                                <?php } else if ($drp_level == 1) { ?>
                                <br/>
                                <b style="color: #0000ff">二级分销商定价</b>
                                <table class="table-sku-stock table-sku-stock-2" data-level="2">
                                    <?php echo $sku_content2; ?>
                                </table>
                                <br/>
                                <b style="color: #0000ff">三级分销商定价</b>
                                <table class="table-sku-stock table-sku-stock-3" data-level="3">
                                    <?php echo $sku_content2; ?>
                                </table>
                                <?php } else if ($drp_level == 2) { ?>
                                <br/>
                                <b style="color: #0000ff">三级分销商定价</b>
                                <table class="table-sku-stock table-sku-stock-3" data-level="3">
                                    <?php echo $sku_content2; ?>
                                </table>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="control-group">
                        <?php if (!empty($product['unified_price_setting']) && !empty($product['source_product_id'])) { ?>
                            <label class="control-label">成本价格：</label>
                            <div class="cost-price-0">
                                <div class="controls">
                                    ￥<?php echo $cost_price; ?>
                                    <input type="hidden" maxlength="10" name="cost_price" class="input-small" value="<?php echo $cost_price; ?>" />
                                </div>
                            </div>
                        <?php } else { ?>
                            <label class="control-label"><em class="required">*</em>成本价格：</label>
                            <div class="cost-price-0">
                                <div class="controls">
                                    <div class="input-prepend">
                                        <span class="add-on">￥</span><input type="text" maxlength="10" name="cost_price" class="input-small" <?php if (!$is_supplier) { ?>value="<?php echo $cost_price; ?>"<?php } ?> />
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (empty($product['source_product_id'])) { ?>
                            <div class="cost-price-1 hide">
                                <?php if (empty($drp_level)) { ?>
                                    <div class="controls">
                                        <b style="color: #0000ff">一级分销商</b>
                                        <div class="input-prepend">
                                            <span class="add-on">￥</span><input type="text" maxlength="10" name="cost_price" class="cost-price-1 input-small" />
                                        </div>
                                    </div>
                                    <div class="controls">
                                        <b style="color: #0000ff">二级分销商</b>
                                        <div class="input-prepend">
                                            <span class="add-on">￥</span><input type="text" maxlength="10" name="cost_price" class="cost-price-2 input-small" />
                                        </div>
                                    </div>
                                    <div class="controls">
                                        <b style="color: #0000ff">三级分销商</b>
                                        <div class="input-prepend">
                                            <span class="add-on">￥</span><input type="text" maxlength="10" name="cost_price" class="cost-price-3 input-small" />
                                        </div>
                                    </div>
                                <?php } else if ($drp_level == 1) { ?>
                                    <div class="controls">
                                        <b style="color: #0000ff">二级分销商</b>
                                        <div class="input-prepend">
                                            <span class="add-on">￥</span><input type="text" maxlength="10" name="cost_price" class="cost-price-2 input-small" />
                                        </div>
                                    </div>
                                    <div class="controls">
                                        <b style="color: #0000ff">三级分销商</b>
                                        <div class="input-prepend">
                                            <span class="add-on">￥</span><input type="text" maxlength="10" name="cost_price" class="cost-price-3 input-small" />
                                        </div>
                                    </div>
                                <?php } else if ($drp_level == 2) { ?>
                                    <div class="controls">
                                        <b style="color: #0000ff">三级分销商</b>
                                        <div class="input-prepend">
                                            <span class="add-on">￥</span><input type="text" maxlength="10" name="cost_price" class="cost-price-3 input-small" />
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>


                    <div class="control-group">
                        <?php if (!empty($product['unified_price_setting']) && !empty($product['source_product_id'])) { ?>
                        <label class="control-label">建议售价：</label>
                        <div class="price-0">
                            <div class="controls">
                                ￥<?php echo $min_fx_price; ?>
                                <input type="hidden" maxlength="10" name="fx-min-price" class="input-small" value="<?php echo $min_fx_price; ?>" />
                                <input type="hidden" maxlength="10" name="fx-max-price" class="input-small" value="<?php echo $max_fx_price; ?>" />
                            </div>
                        </div>
                        <?php } else { ?>
                        <label class="control-label"><em class="required">*</em>建议售价：</label>
                        <div class="price-0">
                            <div class="controls">
                                <div class="input-prepend">
                                    <span class="add-on">￥</span><input type="text" maxlength="10" name="fx-min-price" class="input-small" <?php if (!$is_supplier) { ?><?php if ($min_fx_price > 0) { ?>data-min-price="<?php echo $min_fx_price; ?>" value="<?php echo $min_fx_price; ?>"<?php } ?><?php } ?> /> - <span class="add-on">￥</span><input type="text" maxlength="10" name="fx-max-price" class="input-small" <?php if (!$is_supplier) { ?><?php if ($max_fx_price > 0) { ?>data-max-price="<?php echo $max_fx_price; ?>" value="<?php echo $max_fx_price; ?>"<?php } ?><?php } ?> />
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if (empty($product['source_product_id'])) { ?>
                        <div class="price-1 hide">
                            <?php if (empty($drp_level)) { ?>
                            <div class="controls">
                                <b style="color:#0000ff">一级分销商</b>
                                <div class="input-prepend">
                                    <span class="add-on">￥</span><input type="text" maxlength="10" name="fx-price" class="fx-price-1 input-small" />
                                </div>
                            </div>
                            <div class="controls">
                                <b style="color:#0000ff">二级分销商</b>
                                <div class="input-prepend">
                                    <span class="add-on">￥</span><input type="text" maxlength="10" name="fx-price" class="fx-price-2 input-small" />
                                </div>
                            </div>
                            <div class="controls">
                                <b style="color:#0000ff">三级分销商</b>
                                <div class="input-prepend">
                                    <span class="add-on">￥</span><input type="text" maxlength="10" name="fx-price" class="fx-price-3 input-small" />
                                </div>
                            </div>
                            <?php } else if ($drp_level == 1) { ?>
                            <div class="controls">
                                <b style="color:#0000ff">二级分销商</b>
                                <div class="input-prepend">
                                    <span class="add-on">￥</span><input type="text" maxlength="10" name="fx-price" class="fx-price-2 input-small" />
                                </div>
                            </div>
                            <div class="controls">
                                <b style="color:#0000ff">三级分销商</b>
                                <div class="input-prepend">
                                    <span class="add-on">￥</span><input type="text" maxlength="10" name="fx-price" class="fx-price-3 input-small" />
                                </div>
                            </div>
                            <?php } else if ($drp_level == 2) { ?>
                            <div class="controls">
                                <b style="color:#0000ff">三级分销商</b>
                                <div class="input-prepend">
                                    <span class="add-on">￥</span><input type="text" maxlength="10" name="fx-price" class="fx-price-3 input-small" />
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</form>
</div>
</div>
<style type="text/css">
    .app-actions {
        position: fixed;
        bottom: 0;
        width: 850px;
        padding-top: 20px;
        clear: both;
        text-align: center;
        z-index: 2;
    }
    .app-actions .form-actions {
        padding: 10px;
        margin: 0;
    }
</style>
<div class="app-actions" style="bottom: 0px;">
    <div class="form-actions text-center">
        <input class="btn btn-primary js-btn-load js-btn-save" type="button" value="保存" data-product-id="<?php echo $product['product_id']; ?>" data-loading-text="保存...">
        <input class="btn js-btn-unload js-btn-cancel" type="button" value="取消" data-product-id="<?php echo $product['product_id']; ?>" data-loading-text="取消...">
    </div>
</div>