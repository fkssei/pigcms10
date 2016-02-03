<div>
    <div class="js-list-filter-region clearfix">
        <div>
        <?php include display('_search'); ?>

        <div class="ui-nav">
            <ul>
                <li><a href="javascript:;" class="all" data="*">全部 (不包含临时单)</a></li>
                <li><a href="javascript:;" class="wait-paid status-1" data="1">待付款</a></li>
                <li><a href="javascript:;" class="wait-send status-2" data="2">待发货</a></li>
                <li><a href="javascript:;" class="shipped status-3" data="3">已发货</a></li>
                <li><a href="javascript:;" class="success status-4" data="4">已完成</a></li>
                <li><a href="javascript:;" class="canceled status-5" data="5">已关闭</a></li>
                <li><a href="javascript:;" class="refunding status-6" data="6">退款中</a></li>
                <li><a href="javascript:" class="temp status-0" data="0">临时单</a></li>
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