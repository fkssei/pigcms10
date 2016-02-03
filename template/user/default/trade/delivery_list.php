<div class="freight-list">
	<div class="freight-head">
		<a href="#add" class="btn btn-success">新建运费模板</a>
	</div>
	<div class="freight-content">
		<?php if($postage_list['tpl_list']){ ?>
			<div class="freight-template-list-wrap">
				<ul>
					<?php foreach($postage_list['tpl_list'] as $key=>$value){ ?>
					<li class="freight-template-item">
						<h4 class="freight-template-title">
							<b><?php echo $value['tpl_name'];?><?php if($value['copy_id']) echo ' '.date('YmdHis',$value['last_time']);?></b>  
							<div class="right">
								<span class="c-gray">最后编辑时间 <?php echo date('Y-m-d H:i',$value['last_time']);?></span>&nbsp;&nbsp;
								<a href="javascript:;" class="js-freight-copy" tpl-id="<?php echo $value['tpl_id'];?>">复制模板</a> -
								<a href="javascript:;" class="js-freight-edit" tpl-id="<?php echo $value['tpl_id'];?>">修改</a> -
								<a href="javascript:;" class="js-freight-delete" tpl-id="<?php echo $value['tpl_id'];?>">删除</a>
								<a href="javascript:;" class="js-freight-extend-toggle freight-extend-toggle freight-extend-toggle-extend"></a>
							</div>
						</h4>
						<table class="freight-template-table hide">
							<thead class="js-freight-cost-list-header">
								<tr>
									<th>可配送至</th>
									<th>首重(克)</th>
									<th>运费(元)</th>
									<th>续重(克)</th>
									<th>续费(元)</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($value['area_list'] as $k=>$v){ ?>
									<tr>
										<td class="text-depth-td" area-ids="<?php echo $v[0];?>"></td>
										<td><?php echo $v[1];?></td>
										<td><?php echo $v[2];?></td>
										<td><?php echo $v[3];?></td>
										<td><?php echo $v[4];?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</li>
					<?php } ?>
				</ul>
			</div>
		<?php }else{ ?>
			<div class="no-result" style="margin-top:15px;">还没有运费模板</div>
		<?php } ?>
	</div>
	<div class="js-page-list ui-box pagenavi"><?php echo $postage_list['page'];?></div>
</div>