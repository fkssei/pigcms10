<style type="text/css">
    .select2-container .select2-choice {
        border-radius:0;
    }
    .select2-container .select2-choice {
        background-image: none;
    }
    .select2-container .select2-choice .select2-arrow {
        border-left: none;
        background: none;
        background-image: none;
    }
    .select2-drop {
        border-radius: 0;
    }
    .js-cancel-to-fx {
        color: red!important;
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter"><h3 class="list-title js-list-title">分销中的商品</h3>

            <div class="ui-block-head-help soldout-help js-soldout-help hide">
                <a href="javascript:void(0);" class="js-help-notes" data-class="right"></a>

                <div class="js-notes-cont hide">
                    <p>当商品的所有规格或者某一个规格的库存变为0时，将显示在已售罄的商品列表中</p>
                </div>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
            <?php if (!empty($products)) { ?>
            <tr class="widget-list-header">
                <th class="cell-25" colspan="2">
                    商品
                </th>
                <th class="cell-12 text-right">成本价</th>
                <th class="cell-12">供货商</th>
                <th class="cell-12">物流方式</th>
                <th class="cell-15 text-right">操作</th>
            </tr>
            <?php } ?>
            </thead>
            <tbody class="js-list-body-region">
            <?php if (!empty($products)) { ?>
            <?php foreach ($products as $product) { ?>
            <tr class="widget-list-item">
                <td class="goods-image-td">
                    <div class="goods-image js-goods-image">
                        <img src="<?php echo $product['image']; ?>" />
                    </div>
                </td>
                <td class="goods-meta">
                    <p class="goods-title">
                        <a href="wap/good.php?id=<?php echo $product['product_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                            <?php echo $product['name']; ?>
                        </a>
                    </p>
                </td>
                <td class="text-right">
                    <p class="goods-price"><span>￥</span><?php echo $product['cost_price']; ?></p>
                </td>
                <td>
                    <?php echo $product['supplier']; ?>
                </td>
                <td>
                    <p></p>
                    <p><?php echo $product['delivery_address']; ?></p>
                </td>
                <td class="text-right">
                    <p>
                        <a href="<?php dourl('goods:edit', array('id' => $product['product_id'], 'referer' => 'fx_goods')); ?>">编辑商品</a>
                    </p>
                    <?php if ($fx_again) { ?>
                        <br/>
                    <p>
                        <?php if (empty($product['is_fx_setting'])) { ?>
                            <a href="<?php echo dourl('goods_fx_setting', array('id' => $product['product_id'], 'role' => 'seller')); ?>">设置分销</a>
                        <?php } else { ?>
                            <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" class="js-cancel-to-fx">取消分销</a>
                        <?php } ?>
                    </p>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
            </tbody>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($products)) { ?>
                <div><div class="no-result">还没有相关数据。</div></div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div class="widget-list-footer">
            <?php if (!empty($products)) { ?>
            <div class="pagenavi"><?php echo $page; ?></div>
            <?php } ?>
        </div>
    </div>
</div>