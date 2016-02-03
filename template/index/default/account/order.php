<?php include display( 'public:person_header');?>
<script>
$(function () {
	$("#pages a").click(function () {
		var page = $(this).attr("data-page-num");
		location.href = "<?php echo url('account:order') ?>&page=" + page;
	});

	$(".cancl_order").click(function () {
		if (confirm('真的要取消此订单吗？')) {
			var order_id = $(this).attr('data-id');
			$.getJSON("<?php echo url('account:cancl_order') ?>&order_id=" + order_id, function (data) {
				showResponse(data);
			});
		}
	});
	
	// 确认收货
	$(".over_order").click(function () {
		if (confirm('您确定已经收到货了？')) {
			var order_id = $(this).attr('data-id');
			$.getJSON("<?php echo url('account:over_order') ?>&order_id=" + order_id, function (data) {
				showResponse(data);
			});
		}
	});
});	
</script>
<div class="menudiv">
	<div id="con_one_1" style="display: block;">
		<div class="danye_content_title">
			<div class="danye_suoyou"><a href="###"><span>所有订单</span></a></div>
		</div>
		<ul class="order_list_head clearfix">
			<li class="head_1">宝贝信息</li>
			<li class="head_2"> 单价(元) </li>
			<li class="head_3">数量</li>
			<li class="head_4">合计</li>
			<li class="head_5"> 交易状态 </li>
			<li class="head_6">操作</li>
		</ul>
		
		<?php 
		foreach ($order_list as $order) {
		?>
		<div class="order_list">
			<div class="order_list_title">
				<span class="mr20">订单编号：<a href="###"><?php echo option('config.orderid_prefix') . $order['order_no'] ?></a></span>
				<span class="mr20">预订时间：<?php echo date('Y-m-d H:i:s', $order['add_time']) ?></span>
				<span>支付方式：<?php echo $order['payment_method'] == 'codpay' ? '货到付款' : '在线支付' ?></span>
			</div>
				
			<?php
			if(count($order['product_list']) > 1) {
			?>
				<ul class="order_list_list">
					<?php 
					foreach ($order['product_list'] as $key => $product) {
					?>
						<li class="head_1">
							<dl>
								<dd>
									<div class="order_list_img"><img src="<?php echo $product['image'] ?>"></div>
									<div class="order_list_txt">
										<a href="##">
										<?php echo htmlspecialchars($product['name']) ?></a>
										<?php 
										if ($product['is_present']) {
											echo '<span style="color:#f60;">赠品</span>';
										}
										?>
									</div>
								</dd>
							</dl>
						</li>
						<li class="head_2"> <?php echo $product['pro_price'] ?> </li>
						<li class="head_3"><?php echo $product['pro_num'] ?></li>
						
						<?php
						if(!$key) {
						?>
							<li class="head_4">
							<?php 
							if (!empty($order['total'])) {
							?>
								¥<?php echo $order['total'] ?>
							<?php 
							} else {
							?>
								¥<?php echo $order['sub_total'] ?>
							<?php
							}
							?>
							</li>
							<li class="head_5">
								<span>
									<?php
									if ($order['status'] < 2) {
										echo '未支付';
									} else if ($order['status'] == 2) {
										echo '未发货';
									} else if ($order['status'] == 3) {
										echo '已发货';
									} else if ($order['status'] == 4) {
										echo '已完成';
									} else if ($order['status'] == 5) {
										echo '已取消';
									} else if ($order['status'] == 6) {
										echo '退款中';
									}
									?>
								</span>
							</li>
							<li class="head_6">
								<?php 
								if ($order['status'] < 2) {
								?>
									<p><a target="_blank" href="<?php echo url('order:pay&order_id=' . option('config.orderid_prefix') . $order['order_no']) ?>">付款</a></p>
									<p><a href="javascript:" data-id="<?php echo option('config.orderid_prefix') . $order['order_no'] ?>" class="cancl_order">取消订单</a></p>
								<?php
								} else if (0 && $order['status'] == 3) {
								?>
									<p><a href="javascript:" data-id="<?php echo option('config.orderid_prefix') . $order['order_no'] ?>" class="over_order">确认收货</a></p>
								<?php
								}
								?>
								<p><a target="_blank" href="<?php echo url('order:detail&order_id=' . option('config.orderid_prefix') . $order['order_no']) ?>">查看详情</a></p>
							</li>
					<?php
						}
					}
					?>
				</ul>
			<?php
			} else {
				foreach ($order['product_list'] as $key => $product) {
			?>
					<ul class="order_list_list" style="border-bottom:0;">
						<li class="head_1">
							<div class="order_list_img"><img src="<?php echo $product['image'] ?>"></div>
							<div class="order_list_txt">
								<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>" target="_blank">
									<?php echo htmlspecialchars($product['name']) ?>
								</a>
								<?php 
								if (!empty($product['sku_data_arr'])) {
									echo '<br />';
									foreach ($product['sku_data_arr'] as $sku) {
										echo $sku['name'] . ':' . $sku['value'] . '&nbsp;&nbsp;';
									}
								}
								?>
							</div>
						</li>
						<li class="head_2"> <?php echo $product['pro_price'] ?> </li>
						<li class="head_3"><?php echo $product['pro_num'] ?></li>
						<li class="head_4">
							<?php 
							if (!empty($order['total'])) {
							?>
								¥<?php echo $order['total'] ?>
							<?php 
							} else {
							?>
								¥<?php echo $order['sub_total'] ?>
							<?php
							}
							?>
						</li>
						<li class="head_5">
							<span>
								<?php
								if ($order['status'] < 2) {
									echo '未支付';
								} else if ($order['status'] == 2) {
									echo '未发货';
								} else if ($order['status'] == 3) {
									echo '已发货';
								} else if ($order['status'] == 4) {
									echo '已完成';
								} else if ($order['status'] == 5) {
									echo '已取消';
								} else if ($order['status'] == 6) {
									echo '退款中';
								}
								?>
							</span>
						</li>
						<li class="head_6">
							<?php 
							if ($order['status'] < 2) {
							?>
								<p><a target="_blank" href="<?php echo url('order:pay&order_id=' . option('config.orderid_prefix') . $order['order_no']) ?>">付款</a></p>
								<p><a href="javascript:" data-id="<?php echo option('config.orderid_prefix') . $order['order_no'] ?>" class="cancl_order">取消订单</a></p>
							<?php
							} else if (0 && $order['status'] == 3) {
							?>
								<p><a href="javascript:" data-id="<?php echo option('config.orderid_prefix') . $order['order_no'] ?>" class="over_order">确认收货</a></p>
							<?php
							}
							?>
							<p><a target="_blank" href="<?php echo url('order:detail&order_id=' . option('config.orderid_prefix') . $order['order_no']) ?>">查看详情</a></p>
						</li>
					</ul>
			<?php
				}
			}
			?>
		</div>
		<?php
		}if ($pages) {
		?>
			<div class="page_list" id="pages">
				<dl>
					<?php echo $pages ?>
				</dl>
			</div>
		<?php 
		}
		?>
	</div>
	<div id="con_one_2" style="display: none;">
		<section class="server">
			<div class="section_title">
				<div class="section_txt">商家动态</div>
				<div class="section_border"> </div>
				<div style="clear:both"></div>
			</div>
		</section>
	</div>
	<div id="con_one_3" style="display: none;">
		<section class="server">
			<div class="section_title">
				<div class="section_txt">市场活动</div>
				<div class="section_border"> </div>
				<div style="clear:both"></div>
			</div>
		</section>
	</div>
	
	<div id="con_one_5" style="display: none;">
		<section class="server">
			<div class="section_title">
				<div class="section_txt">公司新闻</div>
				<div class="section_border"> </div>
				<div style="clear:both"></div>
			</div>
		</section>
	</div>
</div>
			
<?php include display( 'public:person_footer');?>
				