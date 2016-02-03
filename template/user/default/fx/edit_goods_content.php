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
                    <label class="control-label">商品类目：</label>
                    <div class="controls">
                        <?php echo $product['category']; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">商品名称：</label>

                    <div class="controls">
                        <input class="input-xxlarge" type="text" name="title" value="<?php echo $product['name']; ?>" maxlength="100" <?php if (empty($product['is_edit_name'])) { ?>disabled="true" <?php } ?> />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">商品库存：</label>
                    <div class="controls">
                        <?php echo $product['quantity']; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">成本价格：</label>
                    <div class="controls">
                        ￥<?php echo $product['price']; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">建议售价：</label>
                    <div class="controls">
                        ￥<?php echo $product['min_fx_price']; ?> - <?php echo $product['max_fx_price']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="goods-info-region" class="goods-info-group">
    <div id="sku-info-region" class="goods-info-group"><div class="goods-info-group-inner"><div class="info-group-title vbox">
                <div class="group-inner">库存/规格</div>
            </div>
            <div class="info-group-cont vbox">
                <div class="group-inner">
                    <div class="js-goods-stock control-group">
                        <div id="stock-region" class="controls sku-stock" style="margin-left: 0;">
                            <table class="table-sku-stock">
                                <?php echo $sku_content; ?>
                            </table>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><em class="required">*</em>商品价格：</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">￥</span><input type="text" maxlength="10" name="price" class="input-small" />
                            </div>
                        </div>
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