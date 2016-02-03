<include file="Public:header"/>



	<form id="myform" method="post" action="{pigcms{:U('Sys_product_property/propertyValue_edit')}" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">

            <tr>
				<th width="80">属性值</th>
				<td><input type="text" class="input fl" name="value" id="value" size="25" value="{pigcms{$propertyvalue.value}"   placeholder="" validate="maxlength:20,required:true" tips=""/></td>
			</tr>




		</table>
		<div class="btn hidden">
			<input type="hidden" name="vid" value="{pigcms{$propertyvalue.vid}" />
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>



<include file="Public:footer"/>