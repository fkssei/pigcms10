<div class="widget-list">
	<div class="ui-box">
		<div class="js-list-filter-region clearfix">
			<div class="widget-list-filter">
				<div class="ui-box dianpu">
					<a class="ui-btn ui-btn-success" href="#physical_store">新建</a>    
				</div>
			</div>
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
								<a href="#physical_store_edit/<?php echo $value['pigcms_id'];?>" class="js-edit">编辑</a> - <a href="javascript:;" class="js-delete" data-id="<?php echo $value['pigcms_id'];?>">删除</a>
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
	<div class="js-list-footer-region ui-box"></div>
</div>