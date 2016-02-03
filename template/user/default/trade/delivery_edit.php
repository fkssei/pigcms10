<div>
	<form class="form-horizontal freight-add-form" onkeypress="return event.keyCode != 13;" tpl-id="<?php echo $postage['tpl_id']?>">
		<div class="control-group">
			<label class="control-label">
				模板名称：
			</label>
			<div class="controls">
				<input type="text" value="<?php echo $postage['tpl_name']?>" name="name" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">
				配送区域：
			</label>
			<div class="controls">
				<table class="freight-template-table freight-template-item">
					<thead class="js-freight-cost-header freight-template-title">
						<tr>
							<th>可配送区域</th>
							<th>首重（克）</th>
							<th>运费（元）</th>
							<th>续重（克）</th>
							<th>续费（元）</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($postage['area_list'] as $key=>$value){ ?>
							<tr>
								<td class="text-depth-td" area-ids="<?php echo $value[0];?>">
									<div class="right">
										<a href="javascript:;" class="js-edit-cost-item">编辑</a>
										<a href="javascript:;" class="js-delete-cost-item">删除</a>
									</div>
								</td>
								<td><input type="text" value="<?php echo $value[1];?>" class="cost-input js-input-number" name="first_amount" data-default="0" maxlength="5"/></td>
								<td><input type="text" value="<?php echo $value[2];?>" class="cost-input js-input-currency" name="first_fee" maxlength="8"/></td>
								<td><input type="text" value="<?php echo $value[3];?>" class="cost-input js-input-number" name="additional_amount" data-default="0" maxlength="5"/></td>
								<td><input type="text" value="<?php echo $value[4];?>" class="cost-input js-input-currency" name="additional_fee" maxlength="7"/></td>
							</tr>
						<?php } ?>
					</tbody>
					<tfoot class="js-freight-tablefoot" style="display:table-footer-group;">
						<tr>
							<td><a href="javascript:;" class="js-assign-cost">指定可配送区域和运费</a></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="button" class="btn btn-primary btn-wide js-save-btn">保存</button>&nbsp;&nbsp;<a href="#" class="btn btn-default btn-wide">返回</a>
			</div>
		</div>
	</form>
</div>