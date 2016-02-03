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
			.click_show{color: #498CD0;}
		</style>
<script type="text/javascript">
	$(function() {
		$('.status-enable > .cb-enable').click(function(){
			if (!$(this).hasClass('selected') ) {
				var url = window.location.href;
				var id = $(this).data('id');
				$.post("<?php echo U('Tag/status'); ?>",{'status': 1, 'id': id}, function(data){
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
				var id = $(this).data('id');
				if (!$(this).hasClass('selected')) {
					$.post("<?php echo U('Tag/status'); ?>", {'status': 0, 'id': id}, function (data) {
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
					<a href="{pigcms{:U('Tag/index')}" class="on">商城TAG列表</a>|
					<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Tag/add')}','添加商城TAG',480,310,true,false,false,addbtn,'add',true);">添加商城TAG</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="{pigcms{:U('Tag/index')}" method="get">
							<input type="hidden" name="c" value="Property"/>
							<input type="hidden" name="a" value="property"/>
						</form>
					</td>
				</tr>
			</table>

			<div class="table-list">
				<table width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>修改</th>
							<th>编号</th>
							<th>属性类别</th>
							<th>属性名称</th>
							<th>状态</th>
							<th class="textcenter" width="100">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if (count($tag_list) > 0) {
							foreach ($tag_list as $tag) {
						?>
								<tr class="propertys_tr">
									<td class="first_td">
										<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Tag/edit', array('id' => $tag['id']))}','修改TAG - {pigcms{$tag.name}',480,310,true,false,false,editbtn,'edit',true);"><img src="{pigcms{$static_path}images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>
									<td><?php echo $tag['id'] ?></td>
									<td><?php echo $tag['type_name'] ?></td>
									<td>
										<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Tag/edit', array('id' => $tag['id']))}','修改TAG - {pigcms{$tag.name}',480,310,true,false,false,editbtn,'edit',true);"><?php echo $tag['name'] ?></a>
									</td>
									<td>
										<if condition="$tag['status'] eq 1"><span class="green">启用</span><else/><span class="red">禁用</span></if>
									</td>
									<td class="end_td">
										<span class="cb-enable status-enable" data-id="<?php echo $tag['id'] ?>" ><label class="cb-enable <if condition="$tag['status'] eq 1">selected</if>" data-id="<?php echo $tag['id']; ?>" data-status="<?php echo $tag['status'] ?>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$tag['status'] eq 1">checked="checked"</if> /></label></span>
										<span class="cb-disable status-disable" data-id="<?php echo $tag['id'] ?>" ><label class="cb-disable <if condition="$tag['status'] eq 0">selected</if>" data-id="<?php echo $tag['id']; ?>"data-status="<?php echo $tag['status'] ?>"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$tag['status'] eq 0">checked="checked"</if>/></label></span>
									</td>
								</tr>
						<?php 
							}
						}
						?>
					</tbody>
					<tfoot>
						<if condition="is_array($tag_list)">
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

<style>
.select-property-tr{  background-color:#3a6ea5;  }
.table-list  .select-property-tr td{padding-left:0px;}
.select-property td{border-top:3px solid #CC5522;background:#e2d7ea}
.select-property .first_td{border-left:3px solid #cc5522}
.select-property .end_td{border-right:3px solid #cc5522}
.property_value th,.property_value td{text-align: center}
.table-list .property_value  tbody td{float:none;text-align: center}
</style>
<script>
$(".show_value").click(function(){
	var property_index = $(".show_value").index($(this));
	//每次点击初始化
	$(".property_value").removeClass("select-property-tr");
	$(".propertys_tr").removeClass("select-property");
	$(".property_value").hide();



	//每次点击new效果
	$(".propertys_tr").eq(property_index).addClass("select-property");

	$(".property_value").eq(property_index).addClass("select-property-tr");


	$(".property_value").eq(property_index).show();
})
</script>
<include file="Public:footer"/>