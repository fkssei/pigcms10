<div>
    <div class="js-list-filter-region clearfix">
        <div>
            <?php include display('_search'); ?>

            <div class="ui-nav">
                <ul>
                    <li><a href="javascript:;" class="all" data="*">全部</a></li>
                    <li><a href="javascript:;" class="wait-send status-2" data="2">待发货</a></li>
                    <li><a href="javascript:;" class="canceled status-3" data="3">已发货</a></li>
                    <li><a href="javascript:;" class="shipped status-4" data="4">已完成</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="ui-box orders">
        <?php include display('_list'); ?>
        <?php if (empty($orders)) { ?>
            <?php include display('_empty'); ?>
        <?php } ?>
    </div>
    <div class="js-list-footer-region ui-box"><div><div class="pagenavi"><?php echo $page; ?></div></div></div></div>