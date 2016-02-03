<style>
.error-message {color:#b94a48;}
.hide {display:none;}
.error{color:#b94a48;}
</style>
<nav class="ui-nav clearfix">
	<ul class="pull-left">
		<li id="js-list-nav-all" class="active">
			<a href="javascript:">编辑满减/送详情</a>
		</li>
	</ul>
</nav>
<div class="app-design-wrap">
	<div class="page-present clearfix">
		<div class="app-present app-reward">
			<form class="form-horizontal" id="myformaaaaaaa">
				<div class="present-info">
					<div class="js-basic-info-region">
						<h3 class="present-sub-title">活动信息</h3>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>活动名称：
							</label>
							<div class="controls">
								<input type="text" name="name" value="<?php echo htmlspecialchars($reward['name']) ?>" id="name" placeholder="请填写活动名称" validate="required:true" class="validate[required]" />
								<em class="error-message"></em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>生效时间：
							</label>
							<div class="controls">
								<input type="text" name="start_time" value="<?php echo date('Y-m-d H:i:s', $reward['start_time']) ?>" class="js-start-time Wdate" id="js-start-time" readonly="readonly" style="cursor:default; background-color:white" />
								<span>至 </span>
								<input type="text" name="end_time" value="<?php echo date('Y-m-d H:i:s', $reward['end_time']) ?>" class="js-end-time Wdate" id="js-end-time" readonly="readonly" style="cursor:default; background-color:white" />
							</div>
						</div>
						<h3 class="present-sub-title">优惠设置 </h3>
						<div class="control-group">
							<label class="control-label"><em class="required">*</em>优惠方式：</label>
							<div class="controls">
								<label class="radio inline">
									<input name="type" type="radio" value="1" <?php echo $reward['type'] == 1 ? 'checked="checked"' : '' ?> />
									<span class="label-text">普通优惠</span>
								</label>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<label class="radio inline">
									<input name="type" type="radio" value="2"  <?php echo $reward['type'] == 2 ? 'checked="checked"' : '' ?> />
									<span class="label-text">多级优惠<span class="gray">（每级优惠不累积叠加）</span></span>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label">优惠条件：</label>
						</div>
					</div>
					
					<div class="control-group">
						<div class="reward-table-wrap">
							<table class="reward-table">
								<thead>
									<tr>
										<th width="10%">层级</th>
										<th width="25%">优惠门槛</th>
										<th width="55%" class="pl100">优惠方式</th>
										<th width="10%">操作</th>
									</tr>
								</thead>
								<!-- 默认的优惠条件，增加层级用 -->
								<tr class="js-default-reward-condition" style="display:none;">
									<td align="center" class="center_tds">1</td>
									<td align="center">
										<div class="control-group">
											<div class="controls" style="margin:0;">
												<span>满</span>
												<input type="text" name="money" class="span1" value="" validate="required:true,number:true" />
												<span>元</span><br />
												<em class="error-message" style="height:16px; line-height:16px;">&nbsp;</em>
											</div>
										</div>
									</td>
									<td>
										<div class="control-group reward-setting first-reward">
											<div class="controls">
												<label class="checkbox inline reward-label js-trigger-label">
													<input type="checkbox" class="checked-status js-cash" name="cash_required" />
													<span class="origin-status ">减现金</span>
													<span class="replace-status js-response-label ">
														减 <input type="text" name="cash" value="" class="span1 js-valid-input" /> 元
														<em class="error-message"></em>
													</span>
												</label>
											</div>
										</div>
										<!-- <div class="control-group reward-setting">
											<div class="controls">
												<label class="checkbox inline reward-label">
													<input type="checkbox" class="checked-status js-postage" name="postage" />
													<span class="origin-status">免邮</span>
												</label>
											</div>
										</div> -->
										<div class="control-group reward-setting">
											<div class="controls">
												<label class="checkbox inline reward-label js-trigger-label">
													<input type="checkbox" class="checked-status js-score" name="score_required" />
													<span class="origin-status ">送积分</span>
													<span class="replace-status js-response-label ">
														送 <input type="text" name="score" value="" class="span1 js-valid-input" /> 积分
													</span>
												</label>
											</div>
										</div>
										<div class="control-group reward-setting">
											<div class="controls">
												<label class="checkbox inline reward-label js-trigger-label">
													<input type="checkbox" class="checked-status" name="coupon_required" />
													<span class="origin-status ">送优惠</span>
													<span class="replace-status js-response-label ">
														送
														<select class="js-reward-coupon" name="coupon" style="width: 180px;">
															<?php 
															foreach ($coupon_list as $coupon) {
															?>
																<option value="<?php echo $coupon['id'] ?>"><?php echo htmlspecialchars($coupon['name']) ?></option>
															<?php 
															}
															if (empty($coupon_list)) {
															?>
																<option value="0">您还未创建优惠券</option>
															<?php
															}
															?>
														</select>
														<a href="javascript:;" class="js-refresh-coupon">刷新</a>
														<span class="c-gray">|</span>
														<a href="<?php dourl('preferential:coupon') ?>#create" class="new-window" target="_blank">新建</a>
													</span>
												</label>
											</div>
										</div>
										<div class="control-group reward-setting last-reward">
											<div class="controls">
												<label class="checkbox inline reward-label js-trigger-label">
													<input type="checkbox" class="checked-status" name="present_required" />
													<span class="origin-status ">送赠品</span>
													<span class="replace-status js-present-label">
														送
														<select class="js-reward-present" name="present" style="width: 180px;">
															<?php 
															foreach ($present_list as $present) {
															?>
																<option value="<?php echo $present['id'] ?>"><?php echo htmlspecialchars($present['name']) ?></option>
															<?php 
															}
															if (empty($present_list)) {
															?>
																<option value="0">您还未创建赠品</option>
															<?php
															}
															?>
														</select>
														<a href="javascript:;" class="js-refresh-present">刷新</a>
														<span class="c-gray">|</span>
														<a href="<?php dourl('appmarket:present') ?>#create" class="new-window" target="_blank">新建</a>
													</span>
												</label>
											</div>
										</div>
										<div class="control-group reward-need-one">
											<div class="controls">
												<input type="hidden" name="needOne" />
											</div>
										</div>
									</td>
									<td align="center" class="js-delete-td">
										
									</td>
								</tr>
								<tbody id="reward-condition">
									<?php 
									foreach ($reward_condition_list as $key => $reward_condition) {
									?>
										<tr>
											<td align="center" class="center_tds"><?php echo $key + 1 ?></td>
											<td align="center">
												<div class="control-group">
													<div class="controls" style="margin:0;">
														<span>满</span>
														<input type="text" name="money" class="span1" value="<?php echo $reward_condition['money'] ?>" validate="required:true,number:true" />
														<span>元</span><br />
														<em class="error-message" style="height:16px; line-height:16px;">&nbsp;</em>
													</div>
												</div>
											</td>
											<td>
												<div class="control-group reward-setting first-reward">
													<div class="controls">
														<label class="checkbox inline reward-label js-trigger-label">
															<input type="checkbox" class="checked-status js-cash" name="cash_required" <?php echo $reward_condition['cash'] > 0 ? 'checked="checked"' : '' ?> />
															<span class="origin-status" <?php echo $reward_condition['cash'] > 0 ? 'style="display:none;"' : '' ?>>减现金</span>
															<span class="replace-status js-response-label " <?php echo $reward_condition['cash'] > 0 ? 'style="display:block;"' : '' ?>>
																减 <input type="text" name="cash" value="<?php echo $reward_condition['cash'] > 0 ? $reward_condition['cash'] : '' ?>" class="span1 js-valid-input" /> 元
																<em class="error-message"></em>
															</span>
														</label>
													</div>
												</div>
												<!-- <div class="control-group reward-setting">
													<div class="controls">
														<label class="checkbox inline reward-label">
															<input type="checkbox" class="checked-status js-postage" name="postage" <?php echo $reward_condition['postage'] > 0 ? 'checked="checked"' : '' ?> />
															<span class="origin-status">免邮</span>
														</label>
													</div>
												</div> -->
												<div class="control-group reward-setting">
													<div class="controls">
														<label class="checkbox inline reward-label js-trigger-label">
															<input type="checkbox" class="checked-status js-score" name="score_required" <?php echo $reward_condition['score'] > 0 ? 'checked="checked"' : '' ?> />
															<span class="origin-status " <?php echo $reward_condition['score'] > 0 ? 'style="display:none;"' : '' ?>>送积分</span>
															<span class="replace-status js-response-label " <?php echo $reward_condition['score'] > 0 ? 'style="display:block;"' : '' ?>>
																送 <input type="text" name="score" value="<?php echo $reward_condition['score'] > 0 ? $reward_condition['score'] : '' ?>" class="span1 js-valid-input" /> 积分
															</span>
														</label>
													</div>
												</div>
												<div class="control-group reward-setting">
													<div class="controls">
														<label class="checkbox inline reward-label js-trigger-label">
															<input type="checkbox" class="checked-status" name="coupon_required" <?php echo $reward_condition['coupon'] > 0 ? 'checked="checked"' : '' ?> />
															<span class="origin-status " <?php echo $reward_condition['coupon'] > 0 ? 'style="display:none;"' : '' ?>>送优惠</span>
															<span class="replace-status js-response-label " <?php echo $reward_condition['coupon'] > 0 ? 'style="display:block;"' : '' ?>>
																送
																<select class="js-reward-coupon" name="coupon" style="width: 180px;">
																	<?php 
																	foreach ($coupon_list as $coupon) {
																		$selected = '';
																		if ($coupon['id'] == $reward_condition['coupon']) {
																			$selected = 'selected="selected"';
																		}
																	?>
																		<option value="<?php echo $coupon['id'] ?>" <?php echo $selected ?>><?php echo htmlspecialchars($coupon['name']) ?></option>
																	<?php 
																	}
																	if (empty($coupon_list)) {
																	?>
																		<option value="0">您还未创建赠品</option>
																	<?php
																	}
																	?>
																</select>
																</select>
																<a href="javascript:;" class="js-refresh-coupon">刷新</a>
																<span class="c-gray">|</span>
																<a href="<?php dourl('preferential:coupon') ?>#create" class="new-window" target="_blank">新建</a>
															</span>
														</label>
													</div>
												</div>
												<div class="control-group reward-setting last-reward">
													<div class="controls">
														<label class="checkbox inline reward-label js-trigger-label">
															<input type="checkbox" class="checked-status" name="present_required" <?php echo $reward_condition['present'] > 0 ? 'checked="checked"' : '' ?> />
															<span class="origin-status " <?php echo $reward_condition['present'] > 0 ? 'style="display:none;"' : '' ?>>送赠品</span>
															<span class="replace-status js-present-label" <?php echo $reward_condition['present'] > 0 ? 'style="display:block;"' : '' ?>>
																送
																<select class="js-reward-present" name="present" style="width: 180px;">
																	<?php 
																	foreach ($present_list as $present) {
																		$selected = '';
																		if ($present['id'] == $reward_condition['present']) {
																			$selected = 'selected="selected"';
																		}
																	?>
																		<option value="<?php echo $present['id'] ?>" <?php echo $selected ?>><?php echo htmlspecialchars($present['name']) ?></option>
																	<?php 
																	}
																	if (empty($present_list)) {
																	?>
																		<option value="0">您还未创建赠品</option>
																	<?php
																	}
																	?>
																</select>
																<a href="javascript:;" class="js-refresh-present">刷新</a>
																<span class="c-gray">|</span>
																<a href="<?php dourl('appmarket:present') ?>#create" class="new-window" target="_blank">新建</a>
															</span>
														</label>
													</div>
												</div>
												<div class="control-group reward-need-one">
													<div class="controls">
														<input type="hidden" name="needOne" />
													</div>
												</div>
											</td>
											<td align="center" class="js-delete-td">
												<?php 
												if ($key != 0) {
												?>
													<a href="javascript:" class="js-delete-condition">删除</a>
												<?php 
												}
												?>
											</td>
										</tr>
									<?php 
									}
									?>
								</tbody>
								<tfoot class="add-reward-toolbar" <?php echo $reward['type'] == 2 ? 'style="display:table-footer-group;"' : '' ?>>
									<tr>
										<td colspan="4">
											<div class="reward-controls">
												<a href="javascript:void(0)" class="js-add-reward" <?php echo count($reward_condition_list) >= 5 ? 'style="display:none;"' : '' ?>>+新增一级优惠</a>
												<span class="gray pl20">最多可设置五个层级</span>
											</div>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<h3 class="present-sub-title">选择活动商品 <span class="gray">(只支持赠送自营商品，不支持分销商品)</span></h3>
					<div class="control-group">
						<label class="control-label"><em class="required">*</em>活动商品：</label>
						<div class="controls">
							<label class="radio inline">
								<input class="js-select-all" type="radio" name="range_type" value="all" <?php echo $reward['is_all'] != 2 ? 'checked="checked"' : '' ?> />
								<span class="label-text">全部商品参与</span>
								<span class="gray">(只支持赠送自营商品，不支持分销商品)</span>
							</label>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<label class="radio inline">
								<input class="js-select-part" type="radio" name="range_type" value="part" <?php echo $reward['is_all'] == 2 ? 'checked="checked"' : '' ?> />
								<span class="label-text">部分商品参与</span>
								<span class="gray">已选商品( <b class="js-amount"><?php echo count($product_list) ?></b> )个</span>
							</label>
						</div>
					</div>
					<div class="js-goods-box" <?php echo $reward['is_all'] != 1 ? 'style="display:block"' : '' ?>>
						<div class="ump-select-tab">
							<ul class="ui-nav-tab">
								<li class="js-tab"><a href="javascript:void(0);">选择商品</a></li>
								<li class="js-tab active"><a href="javascript:void(0);">已选商品</a></li>
							</ul>
						</div>
						<div class="goods-list-wrap">
							<!--筛选产品开始-->
							<div class="js-goods-list-region js-goods-list-tab" style="display: none;">
								<div class="widget-list">
									<div class="ump-select-box js-select-goods-list">
										<div class="ump-goods-wrap">
											<div class="ump-waitting-select ump-goods-list">
												<div class="js-list-filter-region clearfix">
													<div class="widget-list-filter">
														<div class="ump-select-search">
															<form class="js-goods-filter-form" onsubmit="return false;">
																<select name="tag" class="js-goods-group">
																	<option value="0">所有分组</option>
																	<?php 
																	foreach ($product_group_list as $product_group) {
																	?>
																		<option value="<?php echo $product_group['group_id'] ?>"><?php echo htmlspecialchars($product_group['group_name']) ?></option>
																	<?php 
																	}
																	?>
																</select>
																<select name="keyword_type" class="js-search-type">
																	<option value="title">商品标题</option>
																	<option value="no">商品编码</option>
																</select>
																<input class="js-input js-title" type="text" name="keyword" placeholder="请输入商品名称" data-goods-title="请输入商品名称" data-goods-no="请输入商品编码" value="" />
																<a href="javascript:;" class="btn btn-primary js-search">搜索</a>
															</form>
														</div>
													</div>
												</div>
												<div class="ump-select-goods js_select_goods_loading">
													
												</div>
												
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--筛选产品结束-->
							<!--已选产品开始-->
							<div class="js-selected-goods-list-region js-goods-list-tab" style="display: block;">
								<div class="widget-list">
									<div class="ump-select-box js-select-goods-list">
										<div class="ump-goods-wrap">
											<div class="ump-select-goods ump-waitting-select ump-goods-list">
												<div class=" loading">
													<table class="ui-table ui-table-list" style="padding: 0px;">
														<thead class="js-list-header-region tableFloatingHeaderOriginal">
															<tr class="widget-list-header"><th class="checkbox"></th>
																<th colspan="2">商品信息</th>
																<th class="text-center cell-20">库存</th>
																<th class="text-center cell-20">操作</th>
															</tr>
														</thead>
														<tbody class="js-product-list-selected">
															<?php 
															foreach ($product_list as $product) {
															?>
																<tr class="widget-list-item js-product-detail-<?php echo $product['product_id'] ?>" data-product_id="<?php echo $product['product_id'] ?>">
																	<td class="checkbox text-center">
																		<input type="checkbox" class="js-check-toggle">
																	</td>
																	<td class="goods-image-td text-center">
																		<div class="goods-image js-goods-image">
																			<img src="<?php echo $product['image'] ?>" style="max-width:80px; max-height:80px;">
																		</div>
																	</td>
																	<td class="goods-meta">
																		<p class="goods-title">
																			<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>" target="_blank" class="new-window" title="<?php echo htmlspecialchars($product['name']) ?>"><?php echo htmlspecialchars($product['name']) ?></a>
																		</p>
																		<p class="goods-price">￥<?php echo $product['price'] ?></p>
																	</td>
																	<td class="text-center"><?php echo $product['quantity'] ?></td>
																	<td class="text-center">
																		<a href="javascript:;" class="btn btn-primary js-add-product js-delete-product" data-product_id="<?php echo $product['product_id'] ?>">取消参加活动</a>
																	</td>
																</tr>
															<?php 
															}
															if (empty($product_list)) {
															?>
																<tr class="js-no-data">
																	<td colspan="5" style="text-align:center; height:100px;">还没有相关数据。</td>
																</tr>
															<?php 
															}
															?>
														</tbody>
													</table>
													<div class="js-list-empty-region"></div>
												</div>
												<div class="js-list-footer-region ui-box">
														<div class="widget-list-footer">
															<div class="ump-select-footer">
																<div class="pull-left">
																	<label class="checkbox inline">
																		<input type="checkbox" class="js-select-all">全选
																	</label>
																	<a href="javascript:;" class="ui-btn js-batch-delete">批量取消</a>
																</div>
																<div class="pagenavi">
																	<span class="total">&nbsp;</span>
																</div>
															</div>
														</div>
													</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--已选产品结束-->
						</div>
					</div>
				</div>
			</form>

			<div class="app-design">
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn js-btn-quit" type="button" value="取 消" />
						<input type="hidden" name="rid" id="rid" value="<?php echo $reward['id'] ?>" />
						<input class="btn btn-primary js-btn-save" type="button" value="保 存" data-loading-text="保 存..." />
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
$(function() {
	$('.js-help-notes').hover(function() {
		var content = $(this).next('.js-notes-cont').html();
		$('.popover-help-notes').remove();
		var html = '<div class="js-intro-popover popover popover-help-notes right" style="display: none; top: ' + ($(this).offset().top - 27) + 'px; left: ' + ($(this).offset().left + 16) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p>' + content + '</p> </div></div></div>';
		$('body').append(html);
		$('.popover-help-notes').show();
	},
	function() {
		t = setTimeout('hide()', 200);
	})
	$('.popover-help-notes').live('hover', function(event) {
		if (event.type == 'mouseenter') {
			clearTimeout(t);
		} else {
			clearTimeout(t);
			hide();
		}
	})
})
function hide() {
	$('.popover-help-notes').remove();
}
</script>