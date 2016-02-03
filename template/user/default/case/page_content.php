<div>
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div>
            <a href="<?php dourl('page#create'); ?>" class="ui-btn ui-btn-primary js-add-btn">新建自定义页面模块</a>
            <div class="js-list-search ui-search-box">
                <input class="txt" type="text" placeholder="搜索" value="" />
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
            <?php if (!empty($custom_pages)) { ?>
            <tr>
                <th class="cell-30">名称</th>
                <th class="text-right">操作</th>
            </tr>
            <?php } ?>
            </thead>
            <tbody class="js-list-body-region">
            <?php if (!empty($custom_pages)) { ?>
            <?php foreach ($custom_pages as $custom_page) { ?>
            <tr>
                <td><a href="#" target="_blank" class="new-window"><?php echo $custom_page['name']; ?></a></td>
                <td class="text-right">
                    <a href="#edit/<?php echo $custom_page['page_id']; ?>" class="js-edit">编辑</a>
                    <span>-</span>
                    <a href="javascript:void(0);" class="js-delete" data-id="<?php echo $custom_page['page_id']; ?>">删除</a>
                    <span>-</span>
                    <a href="javascript:void(0);" class="js-rename" data-id="<?php echo $custom_page['page_id']; ?>">改名</a>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
            </tbody>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($custom_pages)) { ?>
            <div class="no-result">还没有相关数据。</div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div>
            <div class="pagenavi"><?php echo $page; ?></div>
        </div>
    </div>
</div>