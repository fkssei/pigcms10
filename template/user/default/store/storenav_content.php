<div class="app-design clearfix without-add-region">
    <div class="widget-app-board ui-box">
        <div class="widget-app-board-info">
            <h3>店铺导航</h3>
            <div>
                <p>店铺的各个页面可以通过导航串联起来。通过精心设置的导航，方便买家在栏目间快速切换，引导买家前往您期望的页面。</p>
            </div>
        </div>
        <div class="widget-app-board-control">
            <label class="js-switch ui-switch pull-right <?php if ($store['open_nav']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
        </div>
    </div>
    <div class="app-preview">
        <div class="app-header"></div>
        <div class="app-entry">
            <div class="app-config js-config-region">
                <div class="app-field clearfix editing">
                    <h1><span>[页面标题]</span></h1>
                    <div class="preview-nav-menu">
                        <div class="js-navmenu <?php if ($style_id == 3) { ?>js-nav-preview-region<?php } ?> nav-show nav-menu-<?php echo $style_id; ?> nav-menu has-menu-<?php echo $style_id == 3 ? count($nav_menus) - 1 : count($nav_menus); ?>" <?php if ($style_id != 1) { ?>style="background: <?php echo !empty($nav['bgcolor']) ? $nav['bgcolor'] : '#2b2d30'; ?>" <?php } ?>>
                            <?php if ($style_id == 1) { ?>
                            <div class="nav-special-item nav-item">
                                <a href="javascript:;" class="home">主页</a>
                            </div>
                            <div class="js-nav-preview-region nav-items-wrap">
                                <div class="nav-items">
                                    <?php if (!empty($nav_menus)) { ?>
                                    <?php foreach ($nav_menus as $menu) { ?>
                                    <div class="nav-item-www">
                                        <a class="mainmenu" <?php if (strpos($menu['url'], 'http') === false) { ?>href="javascript:;"<?php } else { ?>href="<?php echo $menu['url']; ?>"<?php } ?> target="_blank">
                                            <?php if (!empty($menu['submenu'])) { ?>
                                                <i class="arrow-weixin"></i>
                                            <?php } ?>
                                            <span class="mainmenu-txt"><?php echo $menu['name']; ?></span>
                                        </a>
                                        <div class="submenu js-submenu" style="display:none;">
                                            <span class="arrow before-arrow" style="left:63px;right:auto;"></span>
                                            <span class="arrow after-arrow" style="left:63px;right:auto;"></span>
                                            <div class="js-nav-2nd-region">
                                                <ul>
                                                    <?php if (!empty($menu['submenu'])) { ?>
                                                    <?php foreach ($menu['submenu'] as $submenu) { ?>
                                                    <li><a <?php if (strpos($submenu['url'], 'http') === false) { ?>href="javascript:;"<?php } else { ?>href="<?php echo $submenu['url']; ?>"<?php } ?> target="_blank"><?php echo $submenu['name']; ?></a></li>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } else if ($style_id == 2) { ?>
                                <div class="js-nav-preview-region">
                                    <ul class="nav-pop-sub">
                                        <?php if (!empty($nav_menus)) { ?>
                                        <?php foreach ($nav_menus as $key => $menu) { ?>
                                        <li class="nav-item nav-pop-sub-item">
                                            <a <?php if (strpos($menu['url'], 'http') !== false) { ?>href="<?php echo $menu['url']; ?>" target="_blank" <?php } else { ?>href="javascript:;"<?php } ?> style="background-image: url(<?php echo $menu['image1']; ?>);background-size: 64px 50px"></a>
                                        </li>
                                        <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } else if ($style_id == 3) { ?>
                                <ul class="nav-pop-sub">
                                    <?php foreach ($nav_menus as $key => $menu) { ?>
                                    <?php if($key > 0) { ?>
                                    <li class="nav-item nav-pop-sub-item">
                                        <a <?php if (strpos($menu['url'], 'http') !== false) { ?>href="<?php echo $menu['url']; ?>" target="_blank" <?php } else { ?>href="javascript:;"<?php } ?> style="background-image: url(<?php echo $menu['image1']; ?>);"></a>
                                    </li>
                                    <?php } ?>
                                    <?php if (count($nav_menus) == 1) { ?>
                                    <li class="nav-item nav-pop-sub-item"><a href="javascript:;"></a></li>
                                    <?php } ?>
                                    <?php if (($key == 0 && count($nav_menus) == 1) || ($key == 2 && count($nav_menus) > 3) || ($key == 1 && count($nav_menus) == 2) || ($key == 1 && count($nav_menus) == 3)) { ?>
                                    <li class="nav-special-item nav-item js-nav-preview-mainIcon-region">
                                        <div>
                                            <ul>
                                                <li class=""><a <?php if (strpos($nav_menus[0]['url'], 'http') !== false) { ?>href="<?php echo $nav_menus[0]['url']; ?>" target="_blank" <?php } else { ?>href="javascript:;"<?php } ?> style="background-image: url(<?php echo $nav_menus[0]['image1']; ?>);border-color: <?php echo $nav['bgcolor']; ?>;"></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <?php } ?>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-fields js-fields-region">
                <div class="app-fields ui-sortable"></div>
            </div>
        </div>
        <div class="js-add-region">
            <div></div>
        </div>
    </div>
    <div class="app-sidebar" style="margin-top: 140px;">
        <div class="arrow"></div>
        <div class="app-sidebar-inner js-sidebar-region">
            <div>
                <form class="form-horizontal edit-shopnav" novalidate="">
                    <div class="edit-shopnav-on-page">
                        <div>将导航应用在以下页面：</div>
                        <div>
                            <label class="checkbox inline"><input type="checkbox" name="use_nav_page" value="1" <?php if (!empty($use_nav_pages)) { ?><?php if (in_array(1, $use_nav_pages)) { ?>checked="true"<?php } ?><?php } else { ?>checked="true"<?php } ?> />店铺主页</label>
                            <label class="checkbox inline"><input type="checkbox" name="use_nav_page" value="2" <?php if (in_array(2, $use_nav_pages)) { ?>checked="true"<?php } ?> />会员主页</label>
                            <label class="checkbox inline"><input type="checkbox" name="use_nav_page" value="3" <?php if (in_array(3, $use_nav_pages)) { ?>checked="true"<?php } ?> />微页面及分类</label>
                            <label class="checkbox inline"><input type="checkbox" name="use_nav_page" value="4" <?php if (in_array(4, $use_nav_pages)) { ?>checked="true"<?php } ?> />商品分组</label>
                        </div>
                        <div>
                            <label class="checkbox inline"><input type="checkbox" name="use_nav_page" value="5" <?php if (in_array(5, $use_nav_pages)) { ?>checked="true"<?php } ?> />商品搜索</label>
                        </div>
                    </div>

                    <div class="edit-shopnav-header clearfix">
                        <span>当前模板：</span>
                        <span class="shopnav-style-name"><?php echo $style; ?></span>
                        <a href="javascript:;" class="ui-btn ui-btn-primary pull-right js-select-nav-style">修改模板</a>
                        <input type="hidden" name="shopnav_style_id" class="shopnav-style-id" value="<?php echo $style_id; ?>" />
                    </div>
                    <?php if ($style_id > 1) { ?>
                    <div class="shopnav-background-color">
                        <span>底色：</span>
                        <span>
                        <input type="color" name="background_color" class="span2" value="<?php if (!empty($nav['bgcolor'])) { ?><?php echo $nav['bgcolor']; ?><?php } else { ?>#2B2D30<?php } ?>" />
                        <a href="javascript:;" class="btn js-reset-background-color">重置</a>
                        </span>
                    </div>
                    <?php } ?>
                    <?php if ($style_id == 3) { ?>
                    <p class="shop-nav-class">添加中间主图标</p>
                    <?php } ?>
                    <div class="js-main-icon-setting main-icon-setting">
                        <?php if ($style_id == 3) { ?>
                        <ul class="choices ui-sortable">
                            <li class="choice">
                                <div class="app-nav">
                                    <div class="actions">
                                        <span class="action delete close-modal" title="删除">×</span>
                                    </div>
                                    <div class="app-nav-image-group clearfix">
                                        <div class="app-nav-image-normal pull-left">
                                            <p>普通：</p>
                                            <div class="app-nav-image-box" style="background-color: <?php if (!empty($nav['bgcolor'])) { ?><?php echo $nav['bgcolor']; ?><?php } else { ?>#2B2D30<?php } ?>">
                                                <div class="app-nav-image" data-image="<?php echo $nav_menus[0]['image1']; ?>" style="background-image: url(<?php echo $nav_menus[0]['image1']; ?>);background-size: 64px 50px;"></div>
                                                <?php if (!empty($nav_menus[0]['image1'])) { ?>
                                                <a href="javascript:;" class="js-trigger-actived-image">修改</a>
                                                <?php } else { ?>
                                                <a href="javascript:;" class="js-trigger-image">选择</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="app-nav-image-active-box pull-left">
                                            <p>高亮（可选）：</p>
                                            <div class="app-nav-image-box" style="background-color: <?php if (!empty($nav['bgcolor'])) { ?><?php echo $nav['bgcolor']; ?><?php } else { ?>#2B2D30<?php } ?>">
                                                <div class="app-nav-image" data-image="<?php echo $nav_menus[0]['image1']; ?>" style="background-image: url(<?php echo $nav_menus[0]['image2']; ?>);background-size: 64px 50px;"></div>
                                                <?php if (!empty($nav_menus[0]['image2'])) { ?>
                                                <a href="javascript:;" class="js-trigger-actived-image">修改</a>
                                                <?php } else { ?>
                                                <a href="javascript:;" class="js-trigger-image">选择</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls" style="margin-left: 0;"></div>
                                    </div>
                                    <p class="c-gray">图片尺寸要求：不大于128*100像素，支持PNG格式</p>
                                    <div class="split-line"></div>
                                    <div class="control-group control-group-link">
                                        <label class="control-label">链接：</label>
                                        <?php if (!empty($nav_menus[0]['text'])) { ?>
                                            <div class="controls">
                                                <div class=" clearfix">
                                                    <div class="pull-left js-link-to link-to">
                                                        <?php if (strpos($nav_menus[0]['url'], 'http') !== false) { ?>
                                                        <a href="<?php echo $nav_menus[0]['url']; ?>" target="_blank" class="new-window link-to-title"><?php echo $nav_menus[0]['text']; ?></a>
                                                        <?php } else { ?>
                                                        <span class="link-to-title"><?php echo $nav_menus[0]['text']; ?></span>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="dropdown hover pull-right">
                                                        <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li>
                                                            <li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li>
                                                            <li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li>
                                                            <li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>
                                                            <?php if ($allow_store_drp == 1) { ?>
                                                            <li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li>
                                                            <?php } ?>
                                                            <li><a class="js-modal-cart" data-type="cart" href="javascript:;">购物车</a></li>
                                                            <li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                        <div class="controls">
                                            <div class="dropdown hover">
                                                <a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li>
                                                    <li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li>
                                                    <li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li>
                                                    <li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>
                                                    <?php if ($allow_store_drp == 1) { ?>
                                                    <li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li>
                                                    <?php } ?>
                                                    <li><a class="js-modal-cart" data-type="cart" href="javascript:;">购物车</a></li>
                                                    <li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <?php } ?>
                    </div>
                    <?php if ($style_id == 3) { ?>
                    <p class="shop-nav-class">添加两侧图标</p>
                    <p class="shop-nav-icon-tips">此导航模板建议您用两个或者四个自定义图标效果图最佳哦！</p>
                    <?php } ?>
                    <div class="js-nav-region clearfix">
                        <ul class="choices ui-sortable">
                            <?php if (!empty($nav_menus) && $style_id == 1) { ?>
                            <?php foreach ($nav_menus as $menu) { ?>
                            <li class="choice">
                                <div class="first-nav">
                                    <h3>一级导航</h3>
                                    <div class="js-first-nav-item-meta-region">
                                        <div>
                                            <div class="shopnav-item">
                                                <div class="shopnav-item-title">
                                                    <span><?php echo $menu['name']; ?></span>
                                                </div>
                                                <div class="shopnav-item-link">
                                                    <a href="javascript:;" class="pull-left shopnav-item-action js-edit-title">编辑</a>
                                                    <span class="pull-left shopnav-item-split">|</span>
                                                    <?php if (!empty($menu['submenu'])) { ?>
                                                        <span class="pull-left c-gray">使用二级导航后主链接已失效。</span>
                                                    <?php } else { ?>
                                                    <span class="pull-left">链接：</span>
                                                    <?php if (!empty($menu['text'])) { ?>
                                                    <div class="pull-left">
                                                        <div class="clearfix">
                                                            <div class="pull-left js-link-to link-to">
                                                                <?php if (strpos($menu['url'], 'http') === false) { ?><span class="link-to-title"><?php echo $menu['text']; ?></span><?php } else { ?><a href="<?php echo $menu['url']; ?>" target="_blank" class="new-window link-to-title"><?php echo $menu['text']; ?></a><?php } ?>
                                                            </div>
                                                            <div class="dropdown hover pull-right">
                                                                <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a>
                                                                <ul class="dropdown-menu" style="display: none;">
                                                                    <li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li>
                                                                    <li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li>
                                                                    <li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li>
                                                                    <li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>
                                                                    <?php if ($allow_store_drp == 1) { ?>
                                                                    <li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li>
                                                                    <?php } ?>
                                                                    <li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } else { ?>
                                                    <div class="pull-left">
                                                        <div class="dropdown hover">
                                                            <a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li>
                                                                <li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li>
                                                                <li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li>
                                                                <li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>
                                                                <?php if ($allow_store_drp == 1) { ?>
                                                                <li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li>
                                                                <?php } ?>
                                                                <li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="second-nav" data-first-nav-index="0">
                                    <h4>二级导航</h4>
                                    <div class="actions">
                                        <span class="action delete close-modal" title="删除">×</span>
                                    </div>
                                    <div class="js-second-nav-region">
                                        <ul class="choices ui-sortable">
                                            <?php if (!empty($menu['submenu'])) { ?>
                                            <?php foreach ($menu['submenu'] as $submenu) { ?>
                                            <li class="choice">
                                                <div class="shopnav-item">
                                                    <div class="actions" style="display: none;"><span class="action delete close-modal" title="删除">×</span></div>
                                                    <div class="shopnav-item-title"><span><?php echo $submenu['name']; ?></span></div>
                                                    <div class="shopnav-item-link">
                                                        <a href="javascript:;" class="pull-left shopnav-item-action js-edit-title">编辑</a>
                                                        <span class="pull-left shopnav-item-split">|</span>
                                                        <span class="pull-left">链接：</span>
                                                        <?php if (!empty($submenu['text'])) { ?>
                                                            <div class="pull-left">
                                                                <div class="clearfix">
                                                                    <div class="pull-left js-link-to link-to"><?php if (strpos($submenu['url'], 'http') === false) { ?><span class="link-to-title"><?php echo $submenu['text']; ?></span><?php } else { ?><a href="<?php echo $submenu['url']; ?>" target="_blank" class="new-window link-to-title"><?php echo $submenu['text']; ?></a><?php } ?></div>
                                                                    <div class="dropdown hover pull-right">
                                                                        <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a>
                                                                        <ul class="dropdown-menu" style="display: none;">
                                                                            <li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li>
                                                                            <li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li>
                                                                            <li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li>
                                                                            <li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>
                                                                            <?php if ($allow_store_drp == 1) { ?>
                                                                                <li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li>
                                                                            <?php } ?>
                                                                            <li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } else { ?>
                                                        <div class="pull-left">
                                                            <div class="dropdown hover">
                                                                <a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a>
                                                                <ul class="dropdown-menu" style="display: none;">
                                                                    <li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li>
                                                                    <li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li>
                                                                    <li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li>
                                                                    <li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>
                                                                    <?php if ($allow_store_drp == 1) { ?>
                                                                        <li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li>
                                                                    <?php } ?>
                                                                    <li> <a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php } ?>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <p class="add-shopnav add-second-shopnav js-add-second-nav hide" <?php if (count($menu['submenu']) < 5) { ?>style="display: block;"<?php } else { ?>style="display: none"<?php } ?>>+ 添加二级导航</p>
                                </div>
                            </li>
                            <?php } ?>
                            <?php } else if (!empty($nav_menus) && $style_id == 2) { ?>
                                <?php foreach ($nav_menus as $menu) { ?>
                                <li class="choice">
                                    <div class="app-nav">
                                        <div class="actions" style="display: none;">
                                            <span class="action delete close-modal" title="删除">×</span>
                                        </div>
                                        <div class="app-nav-image-group clearfix">
                                            <div class="app-nav-image-normal pull-left">
                                                <p>普通：</p>
                                                <div class="app-nav-image-box" style="background-color: <?php if (!empty($nav['bgcolor'])) { ?><?php echo $nav['bgcolor']; ?><?php } else { ?>#2B2D30<?php } ?>">
                                                    <div class="app-nav-image" data-image="<?php echo $menu['image1']; ?>" style="background-image: url(<?php echo $menu['image1']; ?>);background-size: 64px 50px;"></div>
                                                    <?php if (!empty($menu['image1'])) { ?>
                                                        <a href="javascript:;" class="js-trigger-image">修改</a>
                                                    <?php } else { ?>
                                                        <a href="javascript:;" class="js-trigger-actived-image">选择</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="app-nav-image-active-box pull-left">
                                                <p>高亮（可选）：</p>
                                                <div class="app-nav-image-box" style="background-color: <?php if (!empty($nav['bgcolor'])) { ?><?php echo $nav['bgcolor']; ?><?php } else { ?>#2B2D30<?php } ?>">
                                                    <div class="app-nav-image" data-image="<?php echo $menu['image2']; ?>" style="background-image: url(<?php echo $menu['image2']; ?>);background-size: 64px 50px;"></div>
                                                    <?php if (!empty($menu['image2'])) { ?>
                                                    <a href="javascript:;" class="js-trigger-actived-image">修改</a>
                                                    <div class="actions">
                                                        <span class="action js-delete-actived-image close-modal" title="删除">×</span>
                                                    </div>
                                                    <?php } else { ?>
                                                    <a href="javascript:;" class="js-trigger-image">选择</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls" style="margin-left: 0;"></div>
                                        </div>
                                        <p class="c-gray">图片尺寸要求：不大于128*100像素，支持PNG格式</p>
                                        <div class="split-line"></div>
                                        <div class="control-group control-group-link">
                                            <label class="control-label">链接：</label>
                                            <?php if (!empty($menu['text'])) { ?>
                                                <div class="controls">
                                                    <div class="clearfix">
                                                        <div class="pull-left js-link-to link-to">
                                                            <?php if (strpos($menu['url'], 'http') === false) { ?><span class="link-to-title"><?php echo $menu['text']; ?></span><?php } else { ?><a href="<?php echo $menu['url']; ?>" target="_blank" class="new-window link-to-title"><?php echo $menu['text']; ?></a><?php } ?>
                                                        </div>
                                                        <div class="dropdown hover pull-right">
                                                            <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li>
                                                                <li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li>
                                                                <li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li>
                                                                <li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>
                                                                <?php if ($allow_store_drp == 1) { ?>
                                                                    <li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li>
                                                                <?php } ?>
                                                                <li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                            <div class="controls">
                                                <div class="dropdown hover">
                                                    <a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li>
                                                        <li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li>
                                                        <li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li>
                                                        <li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>
                                                        <?php if ($allow_store_drp == 1) { ?>
                                                            <li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li>
                                                        <?php } ?>
                                                        <li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li>
                                                    </ul>
                                                </div>
                                                <input type="hidden" name="link_url">
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </li>
                                <?php } ?>
                                <?php } else if (!empty($nav_menus) && $style_id == 3) { ?>
                                <?php foreach ($nav_menus as $key => $menu) { ?>
                                <?php if ($key > 0) { ?>
                                <li class="choice">
                                    <div class="app-nav">
                                        <div class="actions">
                                            <span class="action delete close-modal" title="删除">×</span>
                                        </div>
                                        <div class="app-nav-image-group clearfix">
                                            <div class="app-nav-image-normal pull-left">
                                                <p>普通：</p>
                                                <div class="app-nav-image-box" style="background-color: <?php if (!empty($nav['bgcolor'])) { ?><?php echo $nav['bgcolor']; ?><?php } else { ?>#2B2D30<?php } ?>">
                                                    <div class="app-nav-image" data-image="<?php echo $menu['image1']; ?>" style="background-image: url(<?php echo $menu['image1']; ?>);background-size: 60px 54px;">
                                                    </div>
                                                    <?php if (!empty($menu['image1'])) { ?>
                                                    <a href="javascript:;" class="js-trigger-actived-image">修改</a>
                                                    <?php } else { ?>
                                                    <a href="javascript:;" class="js-trigger-image">选择</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="app-nav-image-active-box pull-left">
                                                <p>高亮（可选）：</p>
                                                <div class="app-nav-image-box" style="background-color: <?php if (!empty($nav['bgcolor'])) { ?><?php echo $nav['bgcolor']; ?><?php } else { ?>#2B2D30<?php } ?>">
                                                    <div class="app-nav-image" data-image="<?php echo $menu['image2']; ?>" style="background-image: url(<?php echo $menu['image2']; ?>);background-size: 60px 54px;"></div>
                                                    <?php if (empty($menu['image2'])) { ?>
                                                    <a href="javascript:;" class="js-trigger-image">选择</a>
                                                    <?php } else { ?>
                                                    <a href="javascript:;" class="js-trigger-actived-image">修改</a>
                                                    <div class="actions">
                                                        <span class="action js-delete-actived-image close-modal" title="删除">×</span>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls" style="margin-left: 0;">

                                            </div>
                                        </div>
                                        <p class="c-gray">图片尺寸要求：不大于128*100像素，支持PNG格式</p>
                                        <div class="split-line"></div>

                                        <div class="control-group control-group-link">
                                            <label class="control-label">链接：</label>
                                            <?php if (!empty($menu['text'])) { ?>
                                            <div class="controls">
                                                <div class=" clearfix">
                                                    <div class="pull-left js-link-to link-to">
                                                        <?php if (strpos($menu['url'], 'http') !== false) { ?>
                                                        <a href="<?php echo $menu['url']; ?>" target="_blank" class="new-window link-to-title"><?php echo $menu['text']; ?></a>
                                                        <?php } else { ?>
                                                        <span class="link-to-title"><?php echo $menu['text']; ?></span>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="dropdown hover pull-right">
                                                        <a class="dropdown-toggle shopnav-item-action" href="javascript:;">修改</a>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li>
                                                            <li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li>
                                                            <li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li>
                                                            <li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>
                                                            <?php if ($allow_store_drp == 1) { ?>
                                                                <li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li>
                                                            <?php } ?>
                                                            <li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } else { ?>
                                            <div class="controls">
                                                <div class="dropdown hover">
                                                    <a class="dropdown-toggle js-link-to" href="javascript:;;">选择链接页面</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="js-modal-magazine" data-type="feature" href="javascript:;">微页面及分类</a></li>
                                                        <li><a class="js-modal-goods" data-type="goods" href="javascript:;">商品及分类</a></li>
                                                        <li><a class="js-modal-homepage" data-type="homepage" href="javascript:;">店铺主页</a></li>
                                                        <li><a class="js-modal-usercenter" data-type="usercenter" href="javascript:;">会员主页</a></li>
                                                        <?php if ($allow_store_drp == 1) { ?>
                                                            <li><a class="js-modal-drp" data-type="drp" href="javascript:;">我要分销</a></li>
                                                        <?php } ?>
                                                        <li><a class="js-modal-links" data-type="link" href="javascript:;">自定义外链</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>

                    <p class="add-shopnav js-add-nav" <?php if (count($nav_menus) > $shopnav_limit[$style_id]) { ?>style="display: none"<?php } ?>>+ <?php if ($style_id == 1) { ?>添加一级导航<?php } else { ?>添加导航<?php } ?></p>
                </form>
            </div>
        </div>
    </div>
    <div class="app-actions" style="display: block; bottom: 0px;">
        <div class="form-actions text-center">
            <input class="btn btn-primary btn-save" type="submit" value="保 存" data-loading-text="保存...">
        </div>
    </div>
</div>
<script type="text/javascript">
    var t = '';
    $(function () {
        $('.dropdown-toggle').live('mouseover', function () {
            $(this).next('.dropdown-menu').show();
        });
        $('.dropdown-toggle').live('mouseleave', function () {
            t = setTimeout('dropdown_hide()', 200);
        });
        $('.dropdown-menu').live('mouseover', function () {
            clearTimeout(t);
        })
        $('.dropdown-menu').live('mouseleave', function () {
            clearTimeout(t);
            dropdown_hide();
        })
        $('.dropdown-menu > li').hover(function () {

        }, function () {

        })
    })
    function dropdown_hide() {
        $('.dropdown-menu').hide();
    }
</script>