<include file="Public:header"/>

<script>
$(function(){

	$("input[name='store_name']").keyup(function(){
		var store_name = $(this).val();
		if(store_name) {

			$.post("<?php echo U('Store/search_store'); ?>", {'store_name': store_name}, function (obj) {
				var html="";
				$("select[name='store_id']").empty();

				for (var i in obj) {

					html += "<option value='"+obj[i].name+"' data-store_id='"+obj[i].store_id+"'>"+obj[i].name+"</option>";
					if(i == 0) {
						$("input[name='store_name']").val(obj[i].name);
						$("input[name='storeid']").val(obj[i].store_id);
						$("input[name='store_name']").data(obj[i].store_id);
					}
				}
					$("select[name='store_id']").html(html);
			},
			'json'
			)
		}
	})

	$("select[name='store_id']").change(function(){
		$("input[name='store_name']").data("");
		var select_store_name = $(this).val();
		var select_store_id = $("select[name='store_id']").find("option[value='"+select_store_name+"']").attr("data-store_id");

		$("input[name='store_name']").val(select_store_name);
		$("input[name='store_name']").data(select_store_id);
		$("input[name='storeid']").val(select_store_id);
	})
})
</script>

	<form id="myform" method="post" action="{pigcms{:U('Store/brand_add')}" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
                <th width="80">所属品牌分类</th>
                <td>
                    <select name="type_id" validate="required:true">
                        <option value="">顶级分类</option>
                        <volist name="brandtypes" id="brandtype">
                        <option value="{pigcms{$brandtype.type_id}">{pigcms{$brandtype.type_name}</option>
                        </volist>
                    </select>
                </td>
			</tr>
            <tr>
				<th width="80">品牌名称</th>
				<td><input type="text" class="input fl" name="name" id="name" size="25" placeholder="" validate="maxlength:20,required:true" tips=""/></td>
			</tr>
			<tr>
				<th width="80">品牌图片</th>
				<td><input validate="required:true"  type="file" class="input fl" name="pic" style="width:175px;" placeholder="请上传图片" tips="二级分类建议上传！用于网站的店铺列表。"/></td>
			</tr>
			<tr>
				<th width="80">所属品牌店铺</th>
				<td>
					<input type="hidden" class="input fl" name="storeid" validate="required:true">
					<input  type="text" class="input fl" name="store_name" >
					&nbsp;<select   name="store_id"  tips="填写检索店铺">
						<option data-store_id="" value="">请选择店铺</option>
					</select>
				</td>
			</tr>
			<tr>
				<th width="80">品牌排序</th>
				<td><input type="text" class="input fl" name="order_by" value="0" size="10" placeholder="分类排序" validate="maxlength:6,number:true" tips="默认添加id排序！手动排序数值越小，排序越前。"/></td>
			</tr>
			<tr>
				<th width="80">品牌状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable selected"><span>启用</span><input type="radio" name="status" value="1" checked="checked" /></label></span>
					<span class="cb-disable"><label class="cb-disable"><span>禁用</span><input type="radio" name="status" value="0" /></label></span>
				</td>
			</tr>
            <tr>
                <th width="80">品牌描述</th>
                <td><textarea rows="3" style="width: 97%" class="fl" name="desc" id="desc"></textarea></td>
            </tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>