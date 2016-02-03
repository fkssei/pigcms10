<include file="Public:header"/>
	<form id="myform" method="post" action="<?php echo U('Tag/edit', array('id' => $system_tag['id'])) ?>" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">商城分类属性类型</th>
				<td>
					<select name="property_type_id" class="property_type" tips="">
						<option value="">未选择</option>
						<foreach name="system_property_type_list" item="propertytype" key="k">
							<option value="{pigcms{$propertytype.type_id}" <if condition="$propertytype['type_id'] eq $system_tag['tid']">selected</if>>{pigcms{$propertytype.type_name}</option>
						</foreach>
					</select>
				</td>
			</tr>
			<tr>
				<th width="80">属性名</th>
				<td>
					<input type="text" name="tag" class="input fl" value="<?php echo htmlspecialchars($system_tag['name']) ?>" validate="required:true" tips="" />
				</td>
			</tr>
			<tr>
				<th width="80">分类状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <?php echo $system_tag['status'] == 1 ? 'selected' : '' ?>"><span>启用</span><input type="radio" name="status" value="1" <?php echo $system_tag['status'] == 1 ? 'checked="checked"' : '' ?> /></label></span>
					<span class="cb-disable"><label class="cb-disable <?php echo $system_tag['status'] == 0 ? 'selected' : '' ?>"><span>禁用</span><input type="radio" name="status" value="0" <?php echo $system_tag['status'] == 0 ? 'checked="checked"' : '' ?> /></label></span>
				</td>
			</tr>

		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>

<include file="Public:footer"/>