<div class="js-selffetch">
    <div class="js-selffetch-board">
		<div class="widget-app-board ui-box">
			<div class="widget-app-board-info">
				<h3>买家<?php echo $store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '上门自提' ?>功能</h3>
				<div>
					<p>启用<?php echo $store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '上门自提' ?>功能后，买家可以就近选择你的门店进行自提或消费等。</p>
				</div>
			</div>
			<div class="widget-app-board-control">
				<label class="js-switch js-selffetch_payment ui-switch <?php if ($selfFetchStatus) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?> right"></label>
			</div>
		</div>
	</div>
	<div class="js-selffetch-list">
		<div class="ui-box">
			<?php echo $store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '上门自提' ?>前台显示名：<input type="text" name="buyer_selffetch_name" value="<?php echo htmlspecialchars($store['buyer_selffetch_name']) ?>" placeholder="例如：上门自提、到店消费" />
			<div class="ui-btn ui-btn-success js-buyer_selffetch_name">修改</div>
		</div>
		<div class="ui-box">
			<div class="ui-btn ui-btn-success"><a href="<?php dourl('setting:store') ?>#physical_store">新增门店</a></div>
		</div>
		<?php if(!empty($store_physical)){ ?>
			<table class="ui-table ui-table-list physical_list">
				<thead class="js-list-header-region tableFloatingHeaderOriginal">
					<tr class="widget-list-header">
						<th class="cell-12">门店名</th>
						<th class="cell-20">联系地址</th>
						<th class="cell-12">联系电话</th>
						<th class="cell-12">营业时间</th>
						<th class="cell-10">操作</th>
					</tr>
				</thead>
				<tbody class="js-list-body-region">
					<?php foreach($store_physical as $value){ ?>
						<tr class="widget-list-item">
							<td><?php echo $value['name'];?></td>
							<td><?php echo $value['address'];?></td>
							<td><?php if($value['phone1']){ echo $value['phone1'].'-';}?><?php echo $value['phone2'];?></td>
							<td><?php echo $value['business_hours'];?></td>
							<td class="dianpu">
								<a href="<?php dourl('setting:store') ?>#physical_store_edit/<?php echo $value['pigcms_id'];?>">编辑</a>
							</td>

						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php }else{ ?>
			<div class="js-list-empty-region">
				<div>
					<div class="no-result widget-list-empty">还没有相关数据。</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>