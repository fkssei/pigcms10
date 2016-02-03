<include file="Public:header"/>
<script>
	function aaa(obj){
		indexs = obj.index();
		$(".empty_addFilterAttr").eq(indexs).detach();}
	//产品分类 选择属性
	$(function(){
		/*** 新增一个筛选属性*/
		$(".addFilterAttr").click(function(){
			len = $(".empty_addFilterAttr").length;
			//新增之前先筛选
			$(this).closest("td").append('<div class="empty_addFilterAttr" style="padding-bottom: 5px"> <a href="javascript:aaa($(this))"    hrefs="javascript:void(0)">[-]</a>'+$(this).next('span').html()+'</div>');
		})
	})
	//-->
</script>
	<form id="myform" method="post" action="{pigcms{:U('Product_property/propertyValue_add')}" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
                <th width="80">所属商品属性</th>
                <td>
	                <select name="property_type_id" class="property_type_id" tips="" onchange="change_property_type($(this))">
		                <option value="">未选择</option>
		                <foreach name="property_type" item="propertytype" key="k">
			                <option value="{pigcms{$propertytype.type_id}" >{pigcms{$propertytype.type_name}</option>
		                </foreach>
	                </select>
					&#12288;
	                <select name="pid" class="pid" validate="required:true" >
		                <option value="">请选择属性</option>
	                </select>
                </td>
			</tr>
            <tr>
				<th width="80">属性值</th>
				<td>
					<textarea rows="5" cols="25" name="values" id="values" placeholder="一行为一条记录" validate="required:true"></textarea>
				</td>
			</tr>





		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<script>
	function change_property_type(obj){
		var propertytypeid = obj.val();
		var index_property  = $(".property_type").index(obj);
		var htmls="";
		$(".pid").eq(index_property).html("<option value=''>请选择属性</option>");
		$.post(
			"/admin.php?c=Product_property&a=getOnePropertyTypeValue",
			{'property_type_id':propertytypeid},
			function(obj){
				for(var i in  obj){
					htmls += "<option value='"+obj[i].pid+"'>"+obj[i].name+"</option>";
				}
				$(".pid").eq(index_property).append(htmls);
			},
			'json'
		)
	}

</script>
<include file="Public:footer"/>