<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<table class="ui-table ui-table-list" style="padding: 0px;">
	<?php 
	if (!empty($product_list)) {
	?>
		<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr class="widget-list-header">
				<th class="checkbox"></th>
				<th class="text-center" colspan="2">商品信息</th>
				<th class="text-center cell-20">库存</th>
				<th class="text-center cell-20">操作</th>
			</tr>
		</thead>
		<tbody class="js-list-body-region">
			<?php 
			foreach ($product_list as $product) {
			?>
				<tr class="widget-list-item">
					<td class="checkbox text-center"></td>
					<td class="goods-image-td text-center">
						<div class="goods-image js-goods-image">
							<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>" target="_blank" class="current-present-img"><img src="<?php echo $product['image'] ?>" style="max-height:80px; max-width:80px;" /></a>
						</div>
					</td>
					<td class="goods-meta">
						<p class="goods-title">
							<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>" target="_blank" class="new-window" title="<?php echo htmlspecialchars($product['name'])?>">
								<?php echo htmlspecialchars($product['name']) ?>
							</a>
						</p>
						<p class="goods-price">￥<?php echo $product['price'] ?></p>
					</td>
					<td class="text-center js-quantity"><?php echo $product['quantity'] ?></td>
					<td class="text-center">
						<a href="javascript:;" class="btn btn-primary js-add-reward" id="js-add-reward-<?php echo $product['product_id'] ?>" data-product_id="<?php echo $product['product_id'] ?>">设置为赠品</a>
					</td>
				</tr>
		<?php 
			}
		}
		if (empty($product_list)) {
		?>
			<tr class="widget-list-item">
				<td class="checkbox text-center">还没有相关数据。</td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>
<div class="js-list-empty-region"></div>
<div class="js-list-footer-region ui-box">
	<div class="widget-list-footer">
		<div class="ump-select-footer">
			<div class="pagenavi js-product_list_page">
				<span class="total">
					<?php echo $pages ?>
				</span>
			</div>
		</div>
	</div>
</div>