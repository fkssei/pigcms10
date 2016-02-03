<include file="Public:header"/>



	<form id="myform" method="post" action="{pigcms{:U('Product_property/property_edit')}" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">

            <tr>
				<th width="80">属性名称</th>
				<td><input type="text" class="input fl" name="name" id="name" size="25" value="{pigcms{$property.name}"   placeholder="" validate="maxlength:20,required:true" tips=""/></td>
			</tr>

			<tr>
				<th width="80">排序</th>
				<td><input type="text" class="input fl" name="sort" id="sort"  value="{pigcms{$property.sort}" size="10" placeholder="分类排序" validate="maxlength:6,number:true" tips="默认添加id排序！手动排序数值越小，排序越前。"/></td>
			</tr>
			<tr>
				<th width="80">分类状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <if condition='$property.status eq 1'>selected</if>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$property['status'] eq 1">checked="true"</if> /></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition='$property.status eq 0'>selected</if>"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$property['status'] eq 0">checked="true"</if> /></label></span>
				</td>
			</tr>

		</table>
		<div class="btn hidden">
			<input type="hidden" name="pid" value="{pigcms{$property.pid}" />
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>



<include file="Public:footer"/>