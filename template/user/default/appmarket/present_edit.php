<nav class="ui-nav clearfix">
	<ul class="pull-left">
		<li id="js-list-nav-all" class="active">
			<a href="#">
				编辑赠品详情
			</a>
		</li>
	</ul>
</nav>
<div class="app-design-wrap">
	<div class="page-present clearfix">
		<div class="app-present">
			<form class="form-horizontal">
				<div class="present-info">
					<div class="js-basic-info-region">
						<h3 class="present-sub-title">活动信息</h3>
						<div class="control-group">
							<label class="control-label">
								<em class="required">*</em>赠品名称：
							</label>
							<div class="controls">
								<input type="text" name="name" id="name" value="<?php echo $present['name'] ?>" placeholder="请填写活动名称" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required">*</em>赠品有效期：
							</label>
							<div class="controls">
								<input type="text" name="start_time" value="<?php echo date('Y-m-d H:i:s', $present['start_time']) ?>" class="js-start-time Wdate" id="js-start-time" readonly="readonly" id="" style="cursor:default; background-color:white" />
								<span>至</span>
								<input type="text" name="end_time" value="<?php echo date('Y-m-d H:i:s', $present['end_time']) ?>" class="js-end-time Wdate" id="js-end-time" readonly="readonly" id="" style="cursor:default; background-color:white" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>领取有效期：
							</label>
							<div class="controls">
								<input type="text" name="expire_date" id="expire_date" class="js-start-percent w30" value="<?php echo $present['expire_date'] ?>" />
								<span>天</span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>领取限制：
							</label>
							<div class="controls">
								<input type="text" name="expire_number" id="expire_number" class="js-start-percent w30" value="<?php echo $present['expire_number'] ?>" />
								<span>次/人</span>
							</div>
							<div class="ui-block-head-help soldout-help js-soldout-help hide" style="display: display;">
								<a href="javascript:void(0);" class="js-help-notes" data-class="right"></a>
								<div class="js-notes-cont hide">
									<p>该功能仅用于 刮刮卡、幸运大转盘 、疯狂猜猜猜、生肖翻翻看</p>
								</div>
							</div>
						</div>
						<h3 class="present-sub-title">
							选择商品
							<span class="gray">
								(只支持赠送自营商品，不支持分销商品)
							</span>
						</h3>
						<div class="control-group">
							<div class="controls" style="margin-left:50px;">
								<a class="ui-btn ui-btn-success add-present js-add-present" href="javascript:void(0)">添加赠品</a>
								<a class="ui-btn ui-btn-success add-present" target="_blank" href="<?php dourl('goods:create') ?>">创建商品</a>
							</div>
						</div>
						<style>
						.current-present{padding:10px; border:1px dashed #CCC;}
						.current-present-img {display: block; float: left; width: 50px; height: 50px; overflow: hidden;}
						.current-present-tips {float: left; padding-left: 10px;}
						.modify-present {float: right;}
						.edit-group  .controls{width:790px;margin:10px 25px;display:inline-block;clear:both}
						</style>
						<div class="control-group edit-group">
							<div class="controls show-present js-show-present">
							<!-- 仅编辑状态下才展示 -->
								<?php 
								foreach ($present_product_list as $product) {
								?>
								<div class="current-present clearfix" data-product_id="<?php echo $product['product_id'] ?>">
									<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>" target="_blank" class="current-present-img">
										<img src="<?php echo $product['image'] ?>" alt="<?php echo htmlspecialchars($product['name']) ?>" style="max-width:50px; max-height:50px;">
									</a>
									<div class="current-present-tips">
										<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>" target="_blank"><?php echo htmlspecialchars($present['name']) ?></a>
										<p>库存： <?php echo $product['quantity'] ?></p>
									</div>
									<a class="ui-btn ui-btn-success add-present modify-present js-modify-present" href="javascript:void(0)">删除此赠品</a>
								</div>
								<?php 
								}
								?>
							<!-- 商品被删除时给出提示 -->
							</div>
						</div>
					</div>
					
					<div class="ump-select-box js-select-goods-list" style="display:none;">
						<div class="ump-goods-wrap">
							<div class="widget-list-filter">
								<div class="ump-select-search">
									<select name="tag" class="js-goods-group">
										<option value="0">所有分组</option>
										<?php 
										foreach ($product_group_list as $tmp) {
										?>
											<option value="<?php echo $tmp['group_id'] ?>"><?php echo $tmp['group_name'] ?></option>
										<?php 
										}
										?>
									</select>
									<select name="type" class="js-search-type">
										<option value="title">商品名称</option>
										<option value="no">商品编码</option>
									</select>
									<input class="js-input js-title" type="text" name="keyword" placeholder="请输入商品名称" data-goods-title="请输入商品名称" data-goods-no="请输入商品编码" value="" />
									<a href="javascript:;" class="btn btn-primary js-search">
										搜索
									</a>
								</div>
							</div>
						</div>
						<div class="ump-select-goods loading js_select_goods_loading" data-product-id="">
							<!-- 搜索产品列表 -->
						</div>
					</div>
				</div>
			</form>
			<div class="app-design">
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn js-btn-quit" type="button" value="取 消" />
						<input type="hidden" id="present_id" value="<?php echo $present['id'] ?>" />
						<input class="btn btn-primary js-btn-edit-save" type="button" value="保 存" data-loading-text="保 存..." />
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
}) $('.popover-help-notes').live('hover',
function(event) {
if (event.type == 'mouseenter') {
clearTimeout(t);
} else {
clearTimeout(t);
hide();
}
})
}) function hide() {
$('.popover-help-notes').remove();
}
</script>