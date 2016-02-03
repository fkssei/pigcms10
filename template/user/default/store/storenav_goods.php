<div class="modal-header">
    <a class="close js-news-modal-dismiss" data-dismiss="modal">×</a>
    <!-- 顶部tab -->
    <ul class="module-nav modal-tab">

        <li class="active">
            <a href="#js-module-goods" data-type="goods" class="js-modal-tab">已上架商品</a> |
        </li>
        <li><a href="#js-module-tag" data-type="goods_group" class="js-modal-tab">商品分组</a> |
        </li>
        <li class="link-group link-group-0" style="display: inline-block;">
            <a href="<?php dourl('goods:create'); ?>" target="_blank" class="new_window">新建商品</a></li>
        </li>
    </ul>
</div>
<div class="modal-body">
<div class="tab-content">

<div id="js-module-goods" class="tab-pane module-goods active">
    <table class="table">

        <colgroup>
            <col class="modal-col-title">
            <col class="modal-col-time" span="2">
            <col class="modal-col-action">
        </colgroup>

        <!-- 表格头部 -->
        <thead>
        <tr>
            <th class="title">
                <div class="td-cont">
                    <span>标题</span> <a class="js-update" href="javascript:void(0);">刷新</a>
                </div>
            </th>
            <th class="time">
                <div class="td-cont">
                    <span>创建时间</span>
                </div>
            </th>
            <th class="opts">
                <div class="td-cont">
                    <form class="form-search">
                        <div class="input-append">
                            <input class="input-small js-modal-search-input" type="text" /><a href="javascript:void(0);" class="btn js-fetch-page js-modal-search" data-action-type="search">搜</a>
                        </div>
                    </form>
                </div>
            </th>
        </tr>

        </thead>
        <!-- 表格数据区 -->
        <tbody>
        <?php foreach ($products as $product) { ?>
        <tr>
            <td class="title">
                <div class="td-cont">
                    <a target="_blank" class="new_window" href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>"><?php echo $product['name']; ?></a>
                </div>
            </td>
            <td class="time">
                <div class="td-cont">
                    <span><?php echo date('Y-m-d H:i:s', $product['date_added']); ?></span>
                </div>
            </td>
            <td class="opts">
                <div class="td-cont">
                    <button class="btn js-choose" href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>" data-id="<?php echo $product['product_id']; ?>" data-url="#" data-page-type="goods" data-cover-attachment-id="" data-cover-attachment-url="" data-title="<?php echo $product['name']; ?>" data-alias="<?php echo $product['product_id']; ?>">选取
                    </button>
                </div>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>

</div>
</div>
</div>
<div class="modal-footer">
    <div class="pagenavi"><span class="total"><?php echo $page; ?></span></div>
</div>
