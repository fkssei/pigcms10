<include file="Public:header"/>
        <style type="text/css">
            .c-gray {
                color: #999;
            }
            .table-list tfoot tr {
                height: 40px;
            }
            .green {
                color: green;
            }
            a, a:hover{
                text-decoration: none;
            }
        </style>
<script type="text/javascript">
	$(function() {
		$('.status-enable > .cb-enable').click(function(){
			if (!$(this).hasClass('selected') ) {
				var url = window.location.href;
				var pid = $(this).data('id');
				$.post("<?php echo U('Sys_product_property/property_status'); ?>",{'status': 1, 'pid': pid}, function(data){
					window.location.href = url;
				})

			}
			if (parseFloat($(this).data('status')) == 0) {
				$(this).removeClass('selected');
			}
			return false;
		})
		$('.status-disable > .cb-disable').click(function(){
			if (!$(this).hasClass('selected') && parseFloat($(this).data('status')) == 1) {
				var url = window.location.href;
				var pid = $(this).data('id');
				if (!$(this).hasClass('selected')) {
					$.post("<?php echo U('Sys_product_property/property_status'); ?>", {'status': 0, 'pid': pid}, function (data) {
						window.location.href = url;
					})
				}
			}
			return false;
		})
	})
</script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Sys_product_property/getOnePropertyValueList', array('pid' => $property['pid']))}" class="on" onclick="javascript:slidowns(1)">（商品属性：<b>{pigcms{$property.name}</b>）的值列表</a>|
                  <!--  <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Product_property/propertyValue_add')}','添加属性值操作',480,310,true,false,false,addbtn,'add',true);">添加属性值操作</a>
				-->
					<a href="javascript:void(0);" onclick="javascript:slidowns(2)">添加属性值操作</a>

				</ul>
			</div>
			<div id="add_property_values" style="display:none">
				<form id="myform" enctype="multipart/form-data" action="{pigcms{:U('Sys_product_property/propertyValue_add')}" method="post">
				<table width="100%" cellspacing="0" cellpadding="0" class="frame_form">
					<tbody><tr>
						<th width="80">当前商品属性</th>
						<td>
							<select   name="property_type_id">
									<option value="{pigcms{$property.type_id}">{pigcms{$property.type_name}</option>

							</select>
							&#12288;
							<select validate="required:true" class="pid" name="pid">
								<option value="{pigcms{$property.pid}">{pigcms{$property.name}</option>
							</select>

							


						<if condition="($property.pid eq '0') OR ($property.pid eq '')">
							<div style="display: inline-block;color:#cc0000">&nbsp; 无法添加，请前往：产品 【<a href="{pigcms{:U('Sys_product_property/propertyType')}">商品属性类别管理</a>】 或 【<a href="javascript:void(0)" onclick="parent.window.main.location.href ='{pigcms{:U('Sys_product_property/property')}'">商品属性管理</a>】 进行添加操作</div>
						</if>
						</td>
					</tr>
					<tr>
						<th width="80">属性值</th>
						<td>
							<textarea validate="required:true" placeholder="一行为一条记录" id="values" name="values" cols="25" rows="5"></textarea>
							</td>
					</tr>

					<tr>

						<td colspan="2"><input id="dosubmit" class="button" type="submit" value="提交" name="dosubmit">
							<input id="button" class="button" type="button" value="隐藏" onclick="javascript:$('#add_property_values').hide()" name="button">
						</td>
					</tr>


					</tbody></table>
				</form>

			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="{pigcms{:U('Sys_product_property/propertyValue')}" method="get">
							<input type="hidden" name="c" value="Property"/>
							<input type="hidden" name="a" value="propertyValue"/>

                            
						</form>
					</td>
				</tr>
			</table>

            <div class="table-list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>删除 | 修改</th>
                            <th>编号</th>
	                        <th>属性</th>
                            <th>属性值</th>
                            <th>状态</th>
                            <th class="textcenter" width="100">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <if condition="is_array($propertyValues)">
                            <volist name="propertyValues" id="propertyValue">
                                <tr>
                                    <td><a url="<?php echo U('Sys_product_property/propertyValue_del', array('vid' => $propertyValue['vid'])); ?>"  class="delete_row"><img src="{pigcms{$static_path}images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Product_property/propertyValue_edit', array('vid' => $propertyValue['vid']))}','修改商品属性值 - {pigcms{$property.name}',480,<if condition="$property['cat_pic']">390<else/>310</if>,true,false,false,editbtn,'edit',true);"><img src="{pigcms{$static_path}images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>
                                    <td>{pigcms{$propertyValue.vid}</td>
                                          <td><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Sys_product_property/property_edit', array('pid' => $propertyValue['pid']))}','修改属性值 - {pigcms{$propertyValue.name}',480,<if condition="$property['name']">390<else/>310</if>,true,false,false,editbtn,'edit',true);"><?php if ($property['cat_level'] > 1){ echo str_repeat('|——', $property['cat_level']); } ?> <span <?php if ($property['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>>{pigcms{$propertyValue.name}</span></a></td>

                                          <td><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Sys_product_property/propertyValue_edit', array('pid' => $propertyValue['vid']))}','修改属性值 - {pigcms{$propertyValue.value}',480,<if condition="$property['name']">390<else/>310</if>,true,false,false,editbtn,'edit',true);"><?php if ($property['cat_level'] > 1){ echo str_repeat('|——', $property['cat_level']); } ?> <span <?php if ($property['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>>{pigcms{$propertyValue.value}</span></a></td>

                                    <td>
                                        <if condition="$property['status'] eq 1"><span class="green">启用</span><else/><span class="red">禁用</span></if>
                                    </td>

                                    <td>
                                        <span class="cb-enable status-enable" data-id="<?php echo $property['pid']; ?>" ><label class="cb-enable <if condition="$property['status'] eq 1">selected</if>" data-id="<?php echo $property['pid']; ?>" data-status="{pigcms{$property.status}"><span>启用</span><input type="radio" name="status" value="1" <if condition="$property['status'] eq 1">checked="checked"</if> /></label></span>
                                        <span class="cb-disable status-disable" data-id="<?php echo $property['pid']; ?>" ><label class="cb-disable <if condition="$property['status'] eq 0">selected</if>" data-id="<?php echo $property['pid']; ?>"data-status="{pigcms{$property.status}"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$property['status'] eq 0">checked="checked"</if>/></label></span>
                                    </td>
                                </tr>
                            </volist>
                        </if>
                    </tbody>
                    <tfoot>
                        <if condition="is_array($propertyValues)">
                        <tr>
                            <td class="textcenter pagebar" colspan="7">{pigcms{$page}</td>
                        </tr>
                        <else/>
                        <tr><td class="textcenter red" colspan="7">列表为空！</td></tr>
                        </if>
                    </tfoot>
                </table>
            </div>
		</div>
        
        <script type="text/javascript">
        function slidowns(val) {
			var Tab1=$('#nav a').first();
			var Tab2=$('#nav a').last();
			if(val==1){
				Tab1.attr('class','on');
				Tab2.attr('class','');
			}else if(val==2){
				Tab1.attr('class','');
				Tab2.attr('class','on');
				$('#add_property_values').show();
			}
		}
        </script>
<include file="Public:footer"/>