<include file="Public:header"/>
<style type="text/css">
#cate_menu .select2-search-choice { padding: 3px 18px 3px 5px; margin: 3px 0 3px 5px; position: relative; line-height: 13px; color: #333; border: 1px solid #aaaaaa; border-radius: 3px; -webkit-box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0, 0, 0, 0.05); box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0, 0, 0, 0.05); background-clip: padding-box; -webkit-touch-callout: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-color: #e4e4e4; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#eeeeee', endColorstr='#f4f4f4', GradientType=0);
background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(20%, #f4f4f4), color-stop(50%, #f0f0f0), color-stop(52%, #e8e8e8), color-stop(100%, #eee)); background-image: -webkit-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%); background-image: -moz-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%); background-image: -webkit-gradient(linear, left top, left bottom, from(top), color-stop(20%, #f4f4f4), color-stop(50%, #f0f0f0), color-stop(52%, #e8e8e8), to(#eee)); background-image: linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%); font-size: 12px; }
.select2-search-choice-close { display: block; width: 12px; height: 13px; position: absolute; right: 3px; top: 4px; font-size: 1px; outline: none; background: url(./source/tp/Project/tpl/Static/css/img/select2.png) right top no-repeat; position: absolute }
.select2-container-multi .select2-search-choice-close { right: 3px; }
#cate_menu span { cursor: pointer }
<!--
#cate_menu span { float: left; background: red; color: #fff; margin-left: 5px; }
-->

.cate_menu .select2-search-choice { padding: 3px 18px 3px 5px; margin: 3px 0 3px 5px; position: relative; line-height: 13px; color: #333; border: 1px solid #aaaaaa; border-radius: 3px; -webkit-box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0, 0, 0, 0.05); box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0, 0, 0, 0.05); background-clip: padding-box; -webkit-touch-callout: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-color: #e4e4e4; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#eeeeee', endColorstr='#f4f4f4', GradientType=0);
background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(20%, #f4f4f4), color-stop(50%, #f0f0f0), color-stop(52%, #e8e8e8), color-stop(100%, #eee)); background-image: -webkit-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%); background-image: -moz-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%); background-image: -webkit-gradient(linear, left top, left bottom, from(top), color-stop(20%, #f4f4f4), color-stop(50%, #f0f0f0), color-stop(52%, #e8e8e8), to(#eee)); background-image: linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%); font-size: 12px; }
.select2-search-choice-close { display: block; width: 12px; height: 13px; position: absolute; right: 3px; top: 4px; font-size: 1px; outline: none; background: url(./source/tp/Project/tpl/Static/css/img/select2.png) right top no-repeat; position: absolute }
.select2-container-multi .select2-search-choice-close { right: 3px; }
.cate_menu span { cursor: pointer }
<!--
.cate_menu span { float: left; background: red; color: #fff; margin-left: 5px; }
-->
</style>
<script>
var system_tag = <?php echo $tag_str ?>;
	function aaa(obj){
		indexs = obj.index();
		$(".empty_addFilterAttr").eq(indexs).detach();}
	//产品分类 选择属性
	$(function(){
		/*** 新增一个筛选属性*/
		$(".addFilterAttr").click(function(){
			len = $(".empty_addFilterAttr").length;
			//新增之前先筛选
			$(this).closest("td").append('<div class="empty_addFilterAttr" style="padding-bottom: 5px"> <a href="javascript:aaa($(this))"	hrefs="javascript:void(0)">[-]</a>'+$(this).next('span').html()+'</div>');
		})
	})
	//-->
</script>
	<form id="myform" method="post" action="{pigcms{:U('Product/category_add')}" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">所属分类</th>
				<td>
					<select name="parent_id">
						<option value="0">顶级分类</option>
						<volist name="categories" id="category">
						<option value="{pigcms{$category.cat_id}">{pigcms{$category.cat_name}</option>
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
				<td><input type="file" class="input fl" name="pic" style="width:175px;" placeholder="请上传图片" tips="二级分类建议上传！用于网站的商品分类列表。"/></td>
			</tr>
			<tr>
				<th width="80">分类排序</th>
				<td><input type="text" class="input fl" name="order_by" value="0" size="10" placeholder="分类排序" validate="maxlength:6,number:true" tips="默认添加id排序！手动排序数值越小，排序越前。"/></td>
			</tr>
			<tr>
				<th width="80">分类属性</th>
				<td>
					<div style="padding-bottom: 5px" > 
						<span>
							<select name="property_type[]" class="property_type" onchange="change_property_type($(this))">
								<option value="0">顶级分类</option>
								<?php 
								foreach ($property_type as $tmp) {
								?>
									<option value="<?php echo $tmp['type_id'] ?>"><?php echo $tmp['type_name'] ?></option>
								<?php
								}
								?>
							</select>
							<select name="property[]" class="property" id="cate_menu_select">
								<option value="0">请选择属性</option>
							</select>
						</span>
					</div>
					<div id="cate_menu"></div>
					<input type="hidden" name="property" id="cate_menu_val" />
				</td>
			</tr>
			<tr>
				<th width="80">评论TAG</th>
				<td>
					<div style="padding-bottom: 5px">
						<span>
							<select name="tag_property_type" onchange="changeSystemTag()">
								<option value="-1">不选择筛选条件</option>
								<?php 
								foreach ($property_type as $tmp) {
								?>
									<option value="<?php echo $tmp['type_id'] ?>"><?php echo $tmp['type_name'] ?></option>
								<?php
								}
								?>
								<option value="0">其它公用TAG</option>
							</select>
							<select id="select_add_tag" onchange="addTag()">
								<option value='0'>请选择</option>
							</select>
						</span>
					</div>
					<div class="cate_menu js-cate-menu">
						<?php 
						if ($tag_list) {
							foreach ($tag_list as $tmp) {
						?>
								<span class="select2-search-choice js-tag" id="tag_<?php echo $tmp['id'] ?>" value="<?php echo $tmp['id'] ?>"><?php echo $tmp['name'] ?><a href="javascript:" class="select2-search-choice-close" tabindex="-1" onclick="deleteTag('<?php echo $tmp['id'] ?>')"></a><input type="hidden" name="tag[]" value="<?php echo $tmp['id'] ?>" /></span>
						<?php
							}
						}
						?>
					</div>
				</td>
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
<script>
$(function () {
	createAddTag();
});

function changeSystemTag() {
	createAddTag();
}

// 添加到系统TAG
function addTag() {
	var txt = $("#select_add_tag").find("option:selected").text();
	var val = $("#select_add_tag").find("option:selected").val();

	if (val == "0") {
		return;
	}
	var str = '<span class="select2-search-choice js-tag" id="tag_' + val + '" value="' + val + '">' + txt + '<a href="javascript:" class="select2-search-choice-close" tabindex="-1" onclick="deleteTag(\'' + val + '\')"></a><input type="hidden" name="tag[]" value="' + val + '" /></span>'
	$(".js-cate-menu").append(str);

	$("#select_add_tag option[value='" + val + "']").remove();
}

// 删除TAG
function deleteTag(val) {
	$("#tag_" + val).remove();
	createAddTag();
}

// 生成ID为select_add_tag的option选项
function createAddTag() {
	var tag_property_type_val = $("select[name='tag_property_type']").val();
	if (typeof system_tag[tag_property_type_val] == "undefined" && tag_property_type_val == "-1") {
		var option = "<option value='0'>请选择</option>";
		for(var i in system_tag) {
			for (var j in system_tag[i]) {
				// 判断是否已经被选择了，被选择将不出现
				if ($("#tag_" + j).length > 0) {
					continue;
				}
				option += "<option value='" + j + "'>" + system_tag[i][j] + "</option>" ;
			}
		}
		$("#select_add_tag").html(option);
	} else {
		var option = "<option value='0'>请选择</option>";
		for(var i in system_tag[tag_property_type_val]) {
			// 判断是否已经被选择了，被选择将不出现
			if ($("#tag_" + i).length > 0) {
				continue;
			}

			option += "<option value='" + i + "'>" + system_tag[tag_property_type_val][i] + "</option>" ;
		}

		$("#select_add_tag").html(option);
	}
}

function change_property_type(obj){
	$('#cate_menu>span').remove();
	censusAct();
	
	var propertytypeid = obj.val();
	var index_property  = $(".property_type").index(obj);
	var htmls="";
	$(".property").eq(index_property).html("<option value='0'>请选择属性</option>");
	$.post(
		"/admin.php?c=Sys_product_property&a=get_type_value",
		{'property_type_id':propertytypeid},
		function(obj){
			for(var i in  obj){
				 htmls += "<option value='"+obj[i].pid+"'>"+obj[i].name+"</option>";
			}
			$(".property").eq(index_property).append(htmls);
		},
		'json'
	)
}





menu_select_act();
$('#cate_menu_select').change(function(){
	menu_select_act();
})

function menu_select_act(){		
		for(var i=0;i<$('#cate_menu span').length;i++){
			var val_1=$('#cate_menu span:eq('+i+')').attr('value');
			for(var j=1;j<$('#cate_menu_select option').length;j++){
				var val_2=$('#cate_menu_select option:eq('+j+')').attr('value');
				if(val_1==val_2){
					$('#cate_menu_select option:eq('+j+')').remove();
				}
			}
		}
		
		for(var j=0;j<$('#cate_menu_select option:selected').length;j++){
				var chk_attr=$('#cate_menu_select option:selected');
				if(chk_attr.attr('value')!=0){
					$('#cate_menu').append('<span class="select2-search-choice" value="'+chk_attr.attr('value')+'">'+chk_attr.html()+'<a href="#" class="select2-search-choice-close" tabindex="-1" onclick="$(this).closest("li").remove();$(".popover-chosen .select2-input").focus();"></a></span>');
					chk_attr.remove();
				}
		}
		
		
		option_add();
		censusAct();
}

function option_add(){
	var aSpan=$('#cate_menu span');
		for(var i=0;i<aSpan.length;i++){
			aSpan[i].onclick=function(){
				console.log($(this).attr('value'));
				this.remove();
				$('#cate_menu_select').append('<option value="'+$(this).attr('value')+'">'+this.textContent+'</option>');
				censusAct();
			}
		}
}

function censusAct(){
	
	var sId='';
	if($('#cate_menu span').length==0){
		$('#cate_menu_val').val('');
	}else{
		for(var i=0;i<$('#cate_menu span').length;i++){

			sId+=$('#cate_menu span:eq('+i+')').attr('value')+',';
			$('#cate_menu_val').val(sId.substring(0,sId.length-1));
		}
	}
}


</script>
<include file="Public:footer"/>