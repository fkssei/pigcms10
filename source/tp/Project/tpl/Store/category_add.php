<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Store/category_add')}" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
                <th width="80">所属分类</th>
                <td>
                    <select name="parent_id">
                        <option value="0">顶级分类</option>
                        <volist name="categories" id="category">
                        <option value="{pigcms{$category.cat_id}">{pigcms{$category.name}</option>
                        </volist>
                    </select>
                </td>
			</tr>
            <tr>
				<th width="80">分类名称</th>
				<td><input type="text" class="input fl" name="name" id="name" size="25" placeholder="" validate="maxlength:20,required:true" tips=""/></td>
			</tr>
			<tr>
				<th width="80">分类图片</th>
				<td><input type="file" class="input fl" name="pic" style="width:175px;" placeholder="请上传图片" tips="二级分类建议上传！用于网站的店铺列表。"/></td>
			</tr>
			<tr>
				<th width="80">分类排序</th>
				<td><input type="text" class="input fl" name="order_by" value="0" size="10" placeholder="分类排序" validate="maxlength:6,number:true" tips="默认添加id排序！手动排序数值越小，排序越前。"/></td>
			</tr>
			<tr>
				<th width="80">分类状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable selected"><span>启用</span><input type="radio" name="status" value="1" checked="checked" /></label></span>
					<span class="cb-disable"><label class="cb-disable"><span>禁用</span><input type="radio" name="status" value="0" /></label></span>
				</td>
			</tr>
            <tr>
                <th width="80">分类描述</th>
                <td><textarea rows="3" style="width: 97%" class="fl" name="desc" id="desc"></textarea></td>
            </tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>