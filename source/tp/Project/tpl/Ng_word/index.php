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
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Ng_word/index')}" class="on">敏感词列表</a>|
					<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Ng_word/add')}','添加商城TAG',680,310,true,false,false,addbtn,'add',true);">添加敏感词</a>
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
							<th>编号</th>
							<th>敏感词</th>
							<th>替换</th>
							<th class="textcenter" width="100">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if (count($ng_word_list) > 0) {
							foreach ($ng_word_list as $ng_word) {
						?>
								<tr class="propertys_tr">
									<td><?php echo $ng_word['id'] ?></td>
									<td><?php echo htmlspecialchars($ng_word['ng_word']) ?></td>
									<td><?php echo htmlspecialchars($ng_word['replace_word']) ?></td>
									<td class="end_td">
										<a href="javascript:" onclick="window.top.artiframe('{pigcms{:U('Ng_word/edit', array('id' => $ng_word['id']))}', '编辑敏感词',400,200,true,false,false,false,'add',true);">修改</a>
										<a href="javascript:" url="<?php echo U('Ng_word/delete', array('id' => $ng_word['id'])) ?>" class="delete_row">删除</a>
									</td>
								</tr>
						<?php 
							}
						}
						?>
					</tbody>
					<tfoot>
						<if condition="is_array($ng_word_list)">
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
<include file="Public:footer"/>