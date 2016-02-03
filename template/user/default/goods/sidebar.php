			<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
			<aside class="ui-sidebar sidebar">
				<nav>
					<ul>
						<li>
							<a class="ui-btn ui-btn-success" href="<?php dourl('create');?>">发布商品</a>
						</li>
					</ul>

					<h4>商品管理</h4>
					<ul>
						<li <?php if($select_sidebar == 'index') echo 'class="active"';?>>
							<a href="<?php dourl('index');?>">出售中的商品</a>
						</li>
						<li <?php if($select_sidebar == 'stockout') echo 'class="active"';?>>
							<a href="<?php dourl('stockout'); ?>">已售罄的商品</a>
						</li>
						<li <?php if($select_sidebar == 'soldout') echo 'class="active"';?>>
							<a href="<?php dourl('soldout'); ?>">仓库中的商品</a>
						</li>
						<li <?php if($select_sidebar == 'category') echo 'class="active"';?>>
							<a href="<?php dourl('category'); ?>">商品分组</a>
						</li>
				
					</ul>
					
					
					<h4>评论管理</h4>
					<ul>
						<li <?php if($select_sidebar == 'product_comment') echo 'class="active"';?>>
							<a href="<?php dourl('product_comment');?>">商品评价</a>
						</li>
						<li <?php if($select_sidebar == 'store_comment') echo 'class="active"';?>>
							<a href="<?php dourl('store_comment'); ?>">店铺评价</a>
						</li>
				
					</ul>					
					
				</nav>
			</aside>