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

  </div>
</div>
<style>
	.ui-table-list .fans-box .fans-avatar {
		float: left;
		width: 60px;
		height: 60px;
		background: #eee;
		overflow: hidden;
	}
	.ui-table-list .fans-box .fans-avatar img {
		width: 60px;
		height: auto;
	}
	.ui-table-list .fans-box .fans-msg {
		float: left;
	}
	.ui-table-list .fans-box .fans-msg p {
		padding: 0 5px;
		text-align: left;
	}
</style>
<div class="ui-box">
	<?php
	if($person_list) {
		?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr class="widget-list-header"><th class="cell-20 text-left">
					粉丝
				</th>
				<!--
				<th class="cell-10">
					城市
				</th>-->
				<th class="cell-10">
					领取时间
				</th>
				<th class="cell-10">
					面额(元)
				</th>
				<th class="cell-10">
					使用时间
				</th>
				<th class="cell-10">
					订单详情
				</th>
				<th class="cell-10">
					状态
				</th>

			</tr>
			</thead>
			<tbody class="js-list-body-region">
			<?php foreach($person_list as $person){ ?>
				<tr class="widget-list-item">

					<td>
						<div class="fans-box clearfix">
							<div class="fans-avatar">
								<?php if(file_exists($person['avator'])) {?>
									<img src="<?php echo $person['avator']?>">
								<?php }else{?>
									<img src="./static/images/avatar.png">
								<?php }?>
							</div>
							<div class="fans-msg">

								<p><?php echo $person['nickname']?></p>
								<p class="gray"><?php echo $person['phone']?></p>

							</div>
						</div>
					</td>
					<!--
					<td>
						<span class="gray">-</span>
					</td>
					-->



					<td>
						<?php echo date("Y-m-d H:i:s",$person['timestamp'])?>
					</td>
					<td>
						<?php echo $person['face_money'];?>
					</td>
					<td>

						<span class="gary"><?php if($person['is_use']){?><?php echo date("Y-m-d H:i:s",$person['timestamp']);?><?php }else{?>-<?php }?></span>

					</td>
					<td>
						<?php if($person['give_order_id'] || $person['use_order_id']){?>
							<?php if($person['give_order_id']){?>
								<span class="gray">赠送的订单id:<?php echo $person['give_order_id'];?></span><br/>
							<?php }?>
							<?php if($person['use_order_id']){?>
								<span class="gray">使用的订单id:<?php echo $person['use_order_id'];?></span>
							<?php }?>
						<?php }else{?>
							<span class="gray">-</span>
						<?php }?>
					</td>
					<td>
						<?php if($person['is_use']){?>
						<p>已使用</p>
						><?php }else{?>
						<p>未使用</p>
						<?php }?>
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