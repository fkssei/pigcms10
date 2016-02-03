<style type="text/css">
    .red {
        color:red;
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <div class="filter-box">
                <div class="js-list-search">
                    供货商名称：<input class="filter-box-search js-search" type="text" placeholder="搜索" value="">
                    <input type="button" class="ui-btn ui-btn-primary js-search-btn" value="搜索">
                </div>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($suppliers)) { ?>
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
            <tr class="widget-list-header">
                <th colspan="2">供货商</th>
                <th>客服电话</th>
                <th>客服 QQ</th>
                <th>客服微信</th>
            </tr>
            </thead>
            <tbody class="js-list-body-region">
            <?php foreach ($suppliers as $supplier) { ?>
            <tr class="widget-list-item">
                <td class="goods-image-td">
                    <div class="goods-image">
                        <a href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $supplier['store_id']; ?>" target="_blank"><img src="<?php if ($supplier['logo'] == './upload/images/' || $supplier['logo'] == '') { ?><?php echo TPL_URL; ?>/images/logo.png<?php } else { ?><?php echo $supplier['logo']; ?><?php } ?>" alt="<?php echo $supplier['name']; ?>" /></a>
                    </div>
                </td>
                <td class="goods-meta">
                    <a class="new-window" href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $supplier['store_id']; ?>" target="_blank">
                        <?php if (!empty($_POST['keyword'])) { ?>
                        <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $supplier['name']); ?>
                        <?php } else { ?>
                        <?php echo $supplier['name']; ?>
                        <?php } ?>
                    </a>
                </td>
                <td>
                    <?php echo $supplier['service_tel']; ?>
                </td>
                <td>
                    <?php if (!empty($supplier['service_qq'])) { ?>
                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $supplier['service_qq']; ?>&amp;site=qq&amp;menu=yes"><img src="<?php echo TPL_URL; ?>/images/qq.png" /></a>
                    <?php } else { ?>
                        <img src="<?php echo TPL_URL; ?>/images/unqq.png" />
                    <?php } ?>
                </td>
                <td>
                    <?php echo $supplier['service_weixin']; ?>
                </td>
            </tr>
            <?php } ?>
            </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($suppliers)) { ?>
            <div>
                <div class="no-result widget-list-empty">还没有相关数据。</div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div class="widget-list-footer">
            <div class="pull-left">
            </div>

            <div class="pagenavi ui-box"><?php echo $page; ?></div>
        </div>
    </div>
</div>