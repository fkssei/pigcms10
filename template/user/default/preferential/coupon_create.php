
<div class="app-design-wrap">
<div class="app-design clearfix without-add-region"><div class="page-tradeincard">
<h2 class="ump-title">设置店铺优惠券</h2>
<div class="app-preview">
	<div class="app-header"></div>
	<div class="app-entry">
		<div class="app-config js-config-region"><div class="app-field clearfix editing"><h1><span>优惠券</span></h1>
				<div class="app-field-wrap editing">


					<div class="ump-coupon-detail-wrap">
						<div class="ump-coupon-detail">
							<div class="ump-coupon-header">
								<div class="inner" id="mobile_name">优惠券标题</div>
							</div>
							<div class="ump-coupon-body">
								<div class="inner">
									<div class="ump-coupon-value">
										<span>￥</span><i id="mobile_value">0.00</i>
									</div>
								</div>
							</div>
							<div class="ump-coupon-footer">
								<div class="inner">
									<p class="ump-coupon-desc">有效日期：
										<span id="start_time">20xx : 00 : 00</span> 至<br>
										<span id="end_time" style="padding-left:68px;">20xx : 00 : 00</span>
									</p>
									<p class="ump-coupon-desc" >使用限制：

										<span id="is_at_least">订单满 <span id="jtje">xx</span> 元 (含运费)</span>

									</p>

								</div>
							</div>
							<div class="ump-coupon-action take-coupon-success">
								<div class="inner">
									<div class="links">
										<a class="ump-coupon-item-button" href="javascript:;">立即使用</a>
										<a href="javascript:;">查看我的奖品</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div></div>
		<div class="app-fields js-fields-region"><div class="app-fields ui-sortable"></div></div>
	</div>
	<div class="js-add-region"><div></div></div>
</div>
<div class="app-sidebar" style="margin-top: 71px;">
	<div class="arrow"></div>
	<div class="app-sidebar-inner js-sidebar-region"><div>
			<form class="form-horizontal" novalidate="">
				<h1 class="config-title">优惠券基础信息</h1>

				<div class="control-group">
					<label class="control-label"><em class="required">*</em>券类型：</label>
					<div class="controls">
						<label class="radio inline">
							<input name="coupon_type" type="radio" value="1" <?php if($coupon['coupon_type'] == '1'){?>checked="true" <?php }?>>
							优惠券

							<input name="coupon_type" style="margin-left:45px;float:none" type="radio" value="2" <?php if($coupon['coupon_type'] == '2'){?>checked="true" <?php }?>>
							赠送券
						</label>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label"><em class="required">*</em>优惠券名称：</label>
					<div class="controls">
						<input type="text" name="name" value=""   placeholder="最多支持10个字">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label"><em class="required">*</em>面值：</label>
					<div class="controls">
						<div>
							<input type="text" name="value" value="" class="input-small">

							<span class="js-random">至<input type="text" name="value_random_to" value="" class="input-small"> </span>
<!--
							<label class="checkbox inline js-is-random is-random">
								<input type="checkbox" name="is_random" value="1">随机
							</label>
-->
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label"><em class="required">*</em>订单金额：</label>
					<div class="controls">
						<label class="radio inline">
							<input name="is_at_least" type="radio" value="0">
							不限制
						</label>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label class="radio inline">
							<input style="margin-top:6px;"  checked=""  name="is_at_least" type="radio" value="1" >满
							<input type="text" name="at_least" value="" class="input-small js-price" data-value-type="Number">
							元可使用
						</label>
					</div>
				</div>





				<h1 class="config-title">基本规则</h1>
<!--
				<div class="control-group">
					<label class="control-label"><em class="required">*</em>会员等级：</label>
					<div class="controls">
						<select name="user_level" data-value-type="Number">

							<option value="" selected="">所有会员等级</option>

							<option value="7310489">VIP会员</option>

							<option value="7310488">高级会员</option>

						</select> 可领取
					</div>
				</div>
-->

				<div class="control-group">
					<label class="control-label"><em class="required">*</em>每人限领：</label>
					<div class="controls">
						<select name="quota" data-value-type="Number">

							<option value="0" selected="">不限张</option>

							<option value="1">1张</option>

							<option value="2">2张</option>

							<option value="3">3张</option>

							<option value="4">4张</option>

							<option value="5">5张</option>

							<option value="10">10张</option>

						</select>
					</div>
				</div>


				<div class="control-group ffzd">
					<label class="control-label"><em class="required">*</em>发放总量：</label>
					<div class="controls">
						<div class="input-append">
							<input type="text" name="total" value="" class="input-small">
							<span class="add-on">张</span>
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label"><em class="required">*</em>生效时间：</label>
					<div class="controls">
						<input type="text" readonly="cursor:default; background-color:white" style="" name="start_at" value="" ass="js_start_time" id="js_start_time">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label"><em class="required">*</em>过期时间：</label>
					<div class="controls">
						<input type="text" readonly="" name="end_at" value="" ass="js_end_time hasDatepicker" id="js_end_time">
					</div>
				</div>
				<!--
				<div class="control-group">
					<label class="control-label">同步打标签：</label>
					<div class="controls ">
						<select name="fans_tag" multiple="" class="js-fans-tag-select" style="width: 220px;">
						</select>

						<a href="javascript:;" class="js-refresh-fans-tag"> 刷新</a> |
						<a href="http://koudaitong.com/v2/fans/tag/add" class="new-window" target="_blank">新建</a>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">到期提醒：</label>
					<div class="controls">
						<label class="checkbox inline">
							<input type="checkbox" name="expire_notice">到期前4天提醒一次
						</label>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">推广设置：</label>
					<div class="controls">
						<label class="checkbox inline">
							<input type="checkbox" name="is_share" checked=""> 允许分享领取链接
						</label>
					</div>
				</div>
				-->


				<div class="control-group">
					<label class="control-label"><em class="required">*</em>可使用商品：</label>
					<div class="controls">
						<label class="radio inline">
							<input name="range_type" type="radio" value="all" checked="">全店通用
						</label>
						<label class="radio inline">
							<!-- range_type : single 兼容宝贝券数据 -->
							<input name="range_type" type="radio" value="part">指定商品
						</label>
					</div>
				</div>

<!-----ADD 商品--------->
				<div class="control-group">
					<div class="controls">



						<table class="assign-goods-list ui-table js-goods-list">
							<thead>

							</thead>
						</table>





						<a href="javascript:void(0)" class="add-goods js-add-goods" style="display: none"> + 添加商品</a>
						<input type="hidden" name="is_select_goods">
					</div>
				</div>
<!-----add end 商品------->
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label class="checkbox inline">
							<input type="checkbox" name="is_forbid_preference">仅原价购买商品时可用
						</label>
					</div>
				</div>


				<div class="control-group">
					<label class="control-label">使用说明：</label>
					<div class="controls">
						<textarea name="description" style="width:260px;" cols="30" rows="3" placeholder="填写活动的详细说明，支持换行;"></textarea>
					</div>
					<div class="controls controls_syzs" style="color:#333333;opacity:0.5;display:none">剩余<span id="syzs"></span>字</div>
				</div>

			</form>
		</div></div>
</div>
<div class="app-actions" style="bottom: 0px;">
	<div class="form-actions text-center">
		<input class="btn js-btn-quit" type="button" value="取 消">
		<input class="btn btn-primary js-btn-save" type="submit" value="保 存" data-loading-text="保 存...">
	</div>
</div>
</div>




</div>


            </form>
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