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
    .red {
        color:red;
    }
</style>
<div class="goods-list">
<div class="js-list-filter-region clearfix ui-box" style="position: relative;">
    <div class="widget-list-filter">
        <div class="market-filter-container">
            <div class="js-list-tag-filter ui-chosen market-filter">
                <div class="chosen-container chosen-container-single" style="width: 160px!important;" title=""><a
                        class="chosen-single" tabindex="-1"><span>所有类目</span>

                        <div><b></b></div>
                    </a>

                    <div class="chosen-drop">
                        <ul class="chosen-results">
                            <li class="active-result result-selected highlighted" data-option-array-index="0|0">所有类目</li>
                            <?php foreach ($categories as $category) { ?>
                            <li class="active-result" style="" data-option-array-index="<?php echo $category['cat_fid']; ?>|<?php echo $category['cat_id']; ?>"><?php if ($category['cat_level'] > 1) { ?><?php echo str_repeat('&nbsp;&nbsp;&nbsp;', $category['cat_level']) . '|-- ' . $category['cat_name']; ?><?php } else { ?><b><?php echo $category['cat_name'];?></b><?php } ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="js-list-search">
                <input class="js-keyword txt market-serach-input" type="text" placeholder="商品名称" value="<?php echo $_POST['keyword']; ?>" style="left: 185px!important;">
                <input type="button" class="market-search-btn ui-btn ui-btn-primary" value="搜索" style="left: 408px" />
            </div>
            <div class="search-result">共找到<?php echo $product_total; ?>件商品</div>
        </div>
    </div>
</div>
<div class="ui-box">
<table class="ui-table ui-table-list" style="padding: 0px;">
<?php if (!empty($products)) { ?>
<thead class="js-list-header-region tableFloatingHeaderOriginal">
<tr class="widget-list-header">
    <th class="checkbox cell-35" colspan="3">
        <label class="checkbox inline">
            <input type="checkbox" class="js-check-all">
            商品
        </label>
    </th>
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="fx_price">成本价</a></th>
    <th class="cell-10 text-right">建议零售价</th>
    <th class="cell-10 text-right">利润</th>
    <th class="cell-8 text-right"><a href="javascript:;" data-orderby="stock_num">库存</a></th>
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="sold_num">销量</a></th>
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="fx_count">人气</a></th>
    <th class="cell-15 text-right">操作</th>
</tr>
</thead>
<tbody class="js-list-body-region">
<?php foreach($products as $product) { ?>
<tr class="widget-list-item">
    <td class="checkbox">
        <input type="checkbox" class="js-check-toggle" <?php if (in_array($product['product_id'], $fx_products)) { ?>disabled="true" <?php } ?> value="<?php echo $product['product_id']; ?>" />
    </td>
    <td class="goods-image-td">
        <div class="goods-image js-goods-image">
            <img src="<?php echo $product['image']; ?>" />
        </div>
    </td>
    <td class="goods-meta">
        <p class="goods-title">
            <a href="<?php echo $config['wap_site_url']; ?>/good.php?id=<?php echo $product['product_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                <?php if (!empty($_POST['keyword'])) { ?>
                    <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $product['name']); ?>
                <?php } else { ?>
                <?php echo $product['name']; ?>
                <?php } ?>
            </a>
        </p>
        <?php if ($product['is_recommend']) { ?>
        <img class="js-help-notes" src="<?php echo TPL_URL; ?>/images/jian.png" alt="推荐" width="19" height="19" />
        <?php } ?>
    </td>
    <td class="text-right">
        <p>￥<?php echo $product['cost_price']; ?></p>
    </td>
    <td class="text-right">
        <p>￥<?php echo $product['min_fx_price']; ?></p>
        <p>- ￥<?php echo $product['max_fx_price']; ?></p>
    </td>
    <td class="text-right">

        <p>￥<?php echo number_format($product['min_fx_price'] - $product['cost_price'], 2, '.', ''); ?></p>

        <p>- ￥<?php echo number_format($product['max_fx_price'] - $product['cost_price'], 2, '.', ''); ?></p>

    </td>
    <td class="text-right">
        <p><?php echo $product['quantity']; ?></p>
    </td>
    <td class="text-right">
        <?php echo $product['sales']; ?>
    </td>
    <td class="text-right">
        <?php echo $product['pv']; ?>
    </td>
    <td class="text-right">
        <p class="js-opts">
            <?php if (in_array($product['product_id'], $fx_products)) { ?>
                已添加
            <?php } else { ?>
            <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" class="js-add-to-shop">添加到店铺</a>
            <?php } ?>
        </p>
    </td>
</tr>
<?php } ?>
</tbody>
<?php } ?>
</table>
    <div class="js-list-empty-region">
        <?php if (empty($products)) { ?>
        <div>
            <div class="no-result widget-list-empty">还没有相关数据。</div>
        </div>
        <?php } ?>
    </div>
</div>
<div class="js-list-footer-region ui-box">
    <?php if (!empty($products)) { ?>
    <div class="widget-list-footer">
        <div class="pull-left">
            <a href="javascript:;" class="ui-btn js-batch-add-to-shop">批量添加到店铺</a>
        </div>
        <div class="pagenavi"><?php echo $page; ?></div>
    </div>
    <?php } ?>
</div>
</div>