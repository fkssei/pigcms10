<div>
	<form class="form-horizontal freight-add-form" onkeypress="return event.keyCode != 13;">
		<div class="control-group">
			<label class="control-label">
				模板名称：
			</label>
			<div class="controls">
				<input type="text" value="" name="name">
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
					</thead><tbody></tbody>
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