 <div class="app-preview">
 	<nav class="ui-nav">
        <ul>
            <li class="js-list-index active"><a href="javascript:void(0);">客服列表</a></li>
        </ul>
    </nav>
    <div class="js-list-filter-region clearfix ui-box" style="position:relative;">
        <div>
			<a href="javascript:void(0);" class="ui-btn ui-btn-primary bind_qrcode">添加客服</a>
        </div>
    </div>
    
    <div class="ui-box">
		<?php if($group_list['service_list']){ ?>
			<table class="ui-table ui-table-list" style="padding:0px;">
				<thead class="js-list-header-region tableFloatingHeaderOriginal">
					<tr>
						<th class="cell-15">绑定时间</th>
						<th class="cell-25">身份ID(openid)</th>
						<th class="cell-15">客服昵称</th>
						<th class="cell-15">联系方式</th>
						<th class="cell-15">真实名称</th>
						<th class="cell-25 text-right">操作</th>
					</tr>
				</thead>
				<tbody class="js-list-body-region">
					<?php foreach($group_list['service_list'] as $value){ ?>
						<tr service-id="<?php echo $value['service_id']?>">
							<td><?php echo date('Y-m-d',$value['add_time']);?></td>
							<td><?php echo $value['openid'];?></td>
							<td><?php echo $value['nickname'];?></td>
							<td><?php echo $value['tel'];?></td>
							<td><?php echo $value['truename'];?></td>
							<td class="text-right">
								<a href="#edit/<?php echo $value['service_id']?>">编辑资料</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js-delete" sid="<?php echo $value['service_id']?>">删除</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php }else{ ?>
			<div class="js-list-empty-region"></div>
		<?php } ?>
    </div>
    <div class="js-list-footer-region ui-box">
        <div>
            <div class="pagenavi js-page-list"><?php echo $group_list['page'];?></div>
        </div>
    </div>
</div>