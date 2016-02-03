<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有券</a>
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
          <a href="#create" class="ui-btn ui-btn-primary">新建优惠券</a>
          <div class="js-list-search ui-search-box">
              <input class="txt js-coupon-keyword" type="text"  placeholder="搜索" value="<?php if($keyword) echo $keyword;?>"/>
          </div>
      </div>
  </div>
</div>

<div class="ui-box">
	<?php
	if($coupon_list) {
		?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr>
				<th class="cell-15">券名称</th>
				<th class="cell-25">有效时间</th>
				<th class="cell-25">领取限制</th>
				<th class="cell-25">券类型</th>
				<th class="cell-15">活动状态</th>
				<th class="cell-15">领取人/次</th>
				<th class="cell-15">已使用</th>
				<th class="cell-25 text-right">操作</th>
			</tr>
			</thead>
			<tbody class="js-list-body-region">
			<?php foreach($coupon_list as $coupon){ ?>
				<tr class="js-present-detail" service_id="<?php echo $coupon['id']?>">
					<td><?php echo htmlspecialchars($coupon['name']) ?></td>
					<td>
						<p class="text-left"><?php echo date('Y-m-d H:i:s', $coupon['start_time']) ?> 至</p>
						<p class="text-left"><?php echo date('Y-m-d H:i:s', $coupon['end_time']) ?></p>



					</td>
					<td><?php if($coupon['most_have'] > 0) {?>一人<?php echo$coupon['most_have']?>张<?php }else {?>不限张数
							<?php }?><p class="gray">库存：<?php echo ($coupon['total_amount']-$coupon['number']);?></p></td>
					<td><?php if($coupon['type']==1){echo "优惠券";}elseif($coupon['type']=='2'){echo "赠送券";}?></td>
					<td><?php echo $coupon['status'] ? getTimeType($coupon['start_time'], $coupon['end_time']) : '已结束' ?></td>
					<td><?php  if($person_num = $unique_person_have[$coupon['id']]['counts']){?>
							<a href="#fetchlist/<?php echo $coupon['id'];?>" class="info_detail_person"><?php echo $person_num;?></a>
						<?php }else{echo '0';};?>/<?php echo $coupon['number'];?></td>
					<td><?php echo $coupon['used_number'];?>份</td>
					<td class="text-right js-operate" data-coupon_id="<?php echo $coupon['id'] ?>">
						<a href="javascript:"  class="js-link">链接</a>-
						<?php
						if ($coupon['status']) {
							?>
							<a href="#edit/<?php echo $coupon['id']?>" class="js-edit">编辑资料</a>
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
			<?php } ?>
			</tbody>
		</table>


		<div class="js-list-footer-region ui-box">
			<div>
				<div class="pagenavi js-page-list"><?php echo $pages;?></div>
			</div>
		</div>
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