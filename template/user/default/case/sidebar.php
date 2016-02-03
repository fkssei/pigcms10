			<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
			<aside class="ui-sidebar sidebar">
				<nav>
					<ul>
						<li><a href="<?php dourl('store:index'); ?>">微店铺概况</a></li>
					</ul>
					<h4>页面管理</h4>
					<ul>
						<li><a href="<?php dourl('store:wei_page'); ?>">微页面/杂志</a></li>
						<li><a href="<?php dourl('store:wei_page_category'); ?>">微页面分类</a></li>
						<li><a href="<?php dourl('store:ucenter'); ?>">会员主页</a></li>
						<li><a href="<?php dourl('store:storenav'); ?>">店铺导航</a></li>
					</ul>
					<h4>通用模块</h4>
					<ul>
						<li <?php if($select_sidebar == 'ad') echo 'class="active"';?>>
							<a href="<?php dourl('ad'); ?>">公共广告设置</a>
						</li>
						<li <?php if($select_sidebar == 'page') echo 'class="active"';?>>
							<a href="<?php dourl('page'); ?>">自定义页面模块</a>
						</li>
						<li <?php if($select_sidebar == 'attachment') echo 'class="active"';?>>
							<a href="<?php dourl('attachment');?>">我的文件</a>
						</li>
					</ul>
					<?php if (empty($_SESSION['sync_store'])) { ?>
					<h4>店铺服务</h4>
					<ul>
						<li <?php if ($select_sidebar == 'service') { ?>class="active"<?php } ?>><a href="<?php dourl('store:service'); ?>">客服列表</a></li>
					</ul>
					<?php } ?>
					<h4>店铺信息</h4>
					<ul class="dianpu_left">
						<li class="<?php if ($select_sidebar == 'store') { ?>active<?php } ?> info"><a href="<?php dourl('setting:store'); ?>#info">店铺信息</a></li>
						<li class="<?php if ($select_sidebar == 'store') { ?>active<?php } ?> contact"><a href="<?php dourl('setting:store'); ?>#contact">联系我们</a></li>
						<li class="<?php if ($select_sidebar == 'store') { ?>active<?php } ?> list"><a href="<?php dourl('setting:store'); ?>#list">门店管理</a></li>
						<li <?php if ($select_sidebar == 'config') { ?>class="active"<?php } ?>><a href="<?php dourl('setting:config'); ?>">物流配置</a></li>
					</ul>
				</nav>
			</aside>