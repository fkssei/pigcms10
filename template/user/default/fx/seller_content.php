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
                    分销商名称：<input class="filter-box-search js-search" type="text" placeholder="搜索" />&nbsp;&nbsp;&nbsp;&nbsp;
                    审核状态：
                    <select class="js-search-drp-approve" style="margin-bottom: 0px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
                        <option value="*">审核状态</option>
                        <option value="0">未审核</option>
                        <option value="1">已审核</option>
                    </select>
                    <input type="button" class="ui-btn ui-btn-primary js-search-btn" value="搜索">
                </div>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($sellers)) { ?>
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
            <tr class="widget-list-header">
                <th colspan="2">分销商</th>
                <th>客服电话</th>
                <th>客服 QQ</th>
                <th>客服微信</th>
                <th>状态</th>
                <th style="text-align: right">销售额(元)</th>
                <th style="text-align: right">佣金(元)</th>
                <th style="text-align: center">操作</th>
            </tr>
            </thead>
            <tbody class="js-list-body-region">
            <?php foreach ($sellers as $seller) { ?>
            <tr class="widget-list-item">
                <td class="goods-image-td">
                    <div class="goods-image">
                        <a href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $seller['store_id']; ?>" target="_blank"><img src="<?php if ($seller['logo'] == '' || $seller['logo'] == './upload/images/') { ?><?php echo TPL_URL; ?>/images/logo.png<?php } else { ?><?php echo $seller['logo']; ?><?php } ?>" /></a>
                    </div>
                </td>
                <td class="goods-meta">
                    <a class="new-window" href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $seller['store_id']; ?>" target="_blank">
                        <?php if (isset($_POST['keyword']) && $_POST['keyword'] != '') { ?>
                            <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $seller['name']); ?>
                        <?php } else { ?>
                            <?php echo $seller['name']; ?>
                        <?php } ?>
                    </a>
                </td>
                <td>
                    <?php echo $seller['service_tel']; ?>
                </td>
                <td>
                    <?php if (!empty($seller['service_qq'])) { ?>
                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $seller['service_qq']; ?>&amp;site=qq&amp;menu=yes"><img src="<?php echo TPL_URL; ?>/images/qq.png" /></a>
                    <?php } else { ?>
                        <img src="<?php echo TPL_URL; ?>/images/unqq.png" />
                    <?php } ?>
                </td>
                <td>
                    <?php echo $seller['service_weixin']; ?>
                </td>
                <td>
                    <?php if ($seller['status'] == 0) { ?><span style="color:gray">已禁用</span><?php } else if (!empty($seller['drp_approve'])) { ?><span style="color:green">已审核</span><?php } else { ?><span style="color:red">未审核</span><?php } ?>
                </td>
                <td style="text-align: right"><a href="<?php dourl('statistics', array('store_id' => $seller['store_id']));?>"><?php echo $seller['sales']; ?></a></td>
                <td style="text-align: right"><a href="<?php dourl('statistics', array('store_id' => $seller['store_id']));?>"><?php echo $seller['profit']; ?></a></td>
                <td style="text-align: center">
                    <?php if (!empty($seller['drp_approve'])) { ?>
                        <span class="gray" style="cursor: no-drop">审核</span>
                    <?php } else { ?>
                        <a href="javascript:;" class="js-drp-approve" data-id="<?php echo $seller['store_id']; ?>">审核</a>
                    <?php } ?>
                    <span>-</span>
                    <a href="javascript:;" class="<?php if ($seller['status'] == 1) { ?>js-drp-disabled<?php } else if ($seller['status'] == 0) { ?>js-drp-enabled<?php } ?>" data-id="<?php echo $seller['store_id']; ?>"><?php if ($seller['status'] == 1) { ?>禁用<?php } else if ($seller['status'] == 0) { ?>启用<?php } ?></a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($sellers)) { ?>
            <div>
                <div class="no-result widget-list-empty">还没有相关数据。</div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div>
            <div class="js-page-list pagenavi ui-box"><?php echo $page; ?></div>
        </div>
    </div>
</div>