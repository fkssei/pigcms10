<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Store/category_edit')}" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
                <th width="80">所属分类</th>
                <td>
                    <select name="parent_id">
                        <option value="0">顶级分类</option>
                        <volist name="categories" id="all_category">
                        <if condition="$all_category['cat_id'] neq $category['cat_id']">
                        <option value="{pigcms{$all_category.cat_id}" <if condition="$all_category['cat_id'] eq $category['parent_id']">selected</if>>{pigcms{$all_category.name}</option>
                        </if>
                        </volist>
                    </select>
                </td>
			</tr>
            <tr>
				<th width="80">分类名称</th>
				<td><input type="text" class="input fl" name="name" id="name" size="25" value="{pigcms{$category.name}" placeholder="" validate="maxlength:20,required:true" tips=""/></td>
			</tr>
			<if condition="$category['cat_pic']">
				<tr>
					<th width="80">分类现图</th>
					<td><img src="{pigcms{$category.cat_pic}" style="width:60px;height:60px;" class="view_msg"/></td>
				</tr>
			</if>
			<tr>
				<th width="80">分类图片</th>
				<td><input type="file" class="input fl" name="pic" style="width:175px;" placeholder="请上传图片" tips="不修改请不上传！上传新图片，老图片会被自动删除！二级分类建议上传"/></td>
			</tr>
			<tr>
				<th width="80">分类排序</th>
				<td><input type="text" class="input fl" name="order_by" value="{pigcms{$category.order_by}" size="10" placeholder="分类排序" validate="maxlength:6,number:true" tips="默认添加id排序！手动排序数值越小，排序越前。"/></td>
			</tr>

			<tr>
				<th width="80">分类状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <if condition='$category.status eq 1'>selected</if>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$category['status'] eq 1">checked="true"</if> /></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition='$category.status eq 0'>selected</if>"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$category['status'] eq 0">checked="true"</if> /></label></span>
				</td>
			</tr>
            <tr>
                <th width="80">分类描述</th>
                <td><textarea rows="3" style="width: 97%" class="fl" name="desc" id="desc">{pigcms{$category.desc}</textarea></td>
            </tr>
		</table>
		<div class="btn hidden">
            <input type="hidden" name="cat_id" value="{pigcms{$category.cat_id}" />
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>