<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<table class="ui-table ui-table-list" style="padding: 0px;">
	<?php 
	if (!empty($product_list)) {
	?>
		<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr class="widget-list-header"><th class="checkbox"></th>
				<th colspan="2">商品信息</th>
				<th class="text-center cell-20">库存</th>
				<th class="text-center cell-20">操作</th>
			</tr>
		</thead>
		<tbody class="js-list-body-region js-product-list-add">
			<?php 
			foreach ($product_list as $product) {
			?>
				<tr class="widget-list-item" id="js-product-deteil-<?php echo $product['product_id'] ?>" data-product_id="<?php echo $product['product_id'] ?>">
					<td class="checkbox text-center">
						<input type="checkbox" class="js-check-toggle" />
					</td>
					<td class="goods-image-td text-center">
						<div class="goods-image js-goods-image">
							<img src="<?php echo $product['image'] ?>" style="max-width:80px; max-height:80px;" />
						</div>
					</td>
					<td class="goods-meta">
						<p class="goods-title">
							<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>" target="_blank" class="new-window" title="<?php echo htmlspecialchars($product['name']) ?>"><?php echo htmlspecialchars($product['name']) ?></a>
						</p>
						<p class="goods-price">￥<?php echo $product['price'] ?></p>
					</td>
					<td class="text-center"><?php echo $product['quantity'] ?></td>
					<td class="text-center">
						<?php 
						if ($product_exist == 'ALL' || in_array($product['product_id'], $product_exist_other)) {
						?>
							已参加其他满减送活动
						<?php
						} else if (in_array($product['product_id'], $product_exist_own)) {
						?>
							<a href="javascript:;" class="btn js-add-product" id="js-add-reward-<?php echo $product['product_id'] ?>" data-product_id="<?php echo $product['product_id'] ?>">已参加活动</a>
						<?php 
						} else {
						?>
							<a href="javascript:;" class="btn btn-primary js-add-product" id="js-add-reward-<?php echo $product['product_id'] ?>" data-product_id="<?php echo $product['product_id'] ?>">设置为参加活动</a>
						<?php
						}
						?>
					</td>
				</tr>
	<?php 
			}
	}
		if (empty($product_list)) {
	?>
			<tr class="widget-list-item">
				<td class="checkbox text-center" style="heigth:100px; line-height:100px; ">还没有相关数据。</td>
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
			<div class="pull-left">
				<label class="checkbox inline">
					<input type="checkbox" class="js-select-all">全选
				</label>
				<a href="javascript:;" class="ui-btn js-batch-add">批量参加</a>
			</div>
			<div class="pagenavi js-product_list_page">
				<span class="total"><?php echo $pages ?>&nbsp;</span>
			</div>
		</div>
	</div>
</div>