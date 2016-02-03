			<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
            <aside class="ui-sidebar sidebar" style="min-height: 500px;">
                <nav>
                    <ul>
                        <li <?php if ($select_sidebar == 'store') { ?>class="active"<?php } ?>><a href="<?php dourl('store'); ?>">店铺信息</a></li>
                    </ul>
                </nav>
            </aside>