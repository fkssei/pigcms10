			<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
            <aside class="ui-sidebar sidebar" style="min-height: 500px;">
                <nav>
                    <ul><li><h4>我是分销商</h4></li></ul>
                    <ul>
                        <li <?php if ($select_sidebar == 'index') { ?>class="active"<?php } ?>><a href="<?php dourl('index'); ?>">分销概况</a></li>
                        <li <?php if ($select_sidebar == 'market') { ?>class="active"<?php } ?>><a href="<?php dourl('market'); ?>">商品市场</a></li>
                        <li <?php if ($select_sidebar == 'goods') { ?>class="active"<?php } ?>><a href="<?php dourl('goods'); ?>">已分销商品</a></li>
                        <li <?php if ($select_sidebar == 'orders') { ?>class="active"<?php } ?>><a href="<?php dourl('orders'); ?>">采购清单</a></li>
                        <li <?php if ($select_sidebar == 'supplier') { ?>class="active"<?php } ?>><a href="<?php dourl('supplier'); ?>">我的供货商</a></li>
                    </ul>
                    <?php if ($is_supplier) { ?>
                    <ul>
                        <li><h4>我是供货商</h4></li>
                    </ul>
                    <ul>
                        <li <?php if ($select_sidebar == 'supplier_goods') { ?>class="active"<?php } ?>><a href="<?php dourl('supplier_goods'); ?>">我的商品</a></li>
                        <li <?php if ($select_sidebar == 'supplier_market') { ?>class="active"<?php } ?>><a href="<?php dourl('supplier_market'); ?>">商品市场</a></li>
                        <li <?php if ($select_sidebar == 'seller') { ?>class="active"<?php } ?>><a href="<?php dourl('seller'); ?>">我的分销商</a></li>
                        <li <?php if ($select_sidebar == 'setting') { ?>class="active"<?php } ?>><a href="<?php dourl('setting'); ?>">分销配置</a></li>
                    </ul>
                    <?php } ?>
                </nav>
            </aside>