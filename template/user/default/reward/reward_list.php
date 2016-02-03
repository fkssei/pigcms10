<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
	<ul class="pull-left">
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有促销</a>
		</li>
		<li id="js-list-nav-future" <?php echo $type == 'future' ? 'class="active"' : '' ?>>
			<a href="#future">未开始</a>
		</li>
		<li id="js-list-nav-on" <?php echo $type == 'on' ? 'class="active"' : '' ?>>
			<a href="#on">进行中</a>
		</li>
		<li id="js-list-nav-end" <?php echo $type == 'end' ? 'class="active"' : '' ?>>
			<a href="#end">已结束</a>
		</li>
	</ul>
</nav>

<div class="widget-list">
	<div class="js-list-filter-region clearfix ui-box" style="position:relative;">
		<div>
			<a href="#create" class="ui-btn ui-btn-primary">新建满减满送</a>
			<div class="js-list-search ui-search-box">
				<input class="txt js-reward-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>
			</div>
		</div>
	</div>
</div>

<div class="ui-box">
	<?php
	if($reward_list){
	?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">活动名称</th>
					<th class="cell-25">有效时间</th>
					<th class="cell-15">活动状态</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php
				foreach($reward_list as $value){
				?>
					<tr>
						<td><?php echo $value['name']?></td>
						<td><?php echo date('Y-m-d H:i:s', $value['start_time']) ?>至<?php echo date('Y-m-d H:i:s', $value['end_time']) ?></td>
						<td><?php echo $value['status'] ? getTimeType($value['start_time'], $value['end_time']) : '已结束' ?></td>
						<td class="text-right js-operate" data-reward_id="<?php echo $value['id'] ?>">
							<?php 
							if ($value['status']) {
							?>
								<a href="#edit/<?php echo $value['id']?>" class="js-edit">编辑资料</a>
								<span>-</span>
								<a href="javascript:" class="js-disabled">使失效</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js-delete">删除</a>
							<?php 
							} else {
							?>
								已失效
							<?php
							}
							?>
						</td>
					</tr>
				<?php
				}
				if ($pages) {
				?>
					<thead class="js-list-header-region tableFloatingHeaderOriginal">
						<tr>
							<td colspan="4">
								<div class="pagenavi js-reward_list_page">
									<span class="total"><?php echo $pages ?></span>
								</div>
							</td>
						</tr>
					</thead>
				<?php
				}
				?>
			</tbody>
		</table>
	<?php
	}else{
	?>
		<div class="js-list-empty-region">
			<div>
				<div class="no-result widget-list-empty">还没有相关数据。</div>
			</div>
		</div>
	<?php
	}
	?>
</div>
<div class="js-list-footer-region ui-box"></div>