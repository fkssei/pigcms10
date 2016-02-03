
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
								<div class="inner" id="mobile_name"><?php if($coupon['name']) {echo $coupon['name'];}else{echo "优惠券标题";} ?></div>
							</div>
							<div class="ump-coupon-body">
								<div class="inner">
									<div class="ump-coupon-value">
										<span>￥</span><i id="mobile_value"><?php if($coupon['face_money']) {echo $coupon['face_money'];}else{echo "0.00";} ?></i>
									</div>
								</div>
							</div>
							<div class="ump-coupon-footer">
								<div class="inner">
									<p class="ump-coupon-desc">有效日期：
										<span id="start_time"><?php if($coupon['start_time']) {echo date("Y-m-d H:i:s",$coupon['start_time']);}else{echo "20xx : 00 : 00";} ?></span> 至<br>
										<span id="end_time" style="padding-left:68px;"><?php if($coupon['end_time']) {echo date("Y-m-d H:i:s",$coupon['end_time']);}else{echo "20xx : 00 : 00";} ?></span>
									</p>
									<p class="ump-coupon-desc" >使用限制：
										<?php if($coupon['limit_money'] != '0'){?>
										<span id="is_at_least">订单满 <span id="jtje"><?php if($coupon['limit_money'] !='0') {?><?php echo $coupon['limit_money'];?><?php }else{?>xx<?php }?></span> 元 (含运费)</span>
										<?php }else{?>
											<span id="is_at_least">无限制</span>
										<?php }?>
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
							<input name="coupon_type" disabled type="radio" value="1" <?php if($coupon['type'] == '1'){?>checked="true" <?php }?>>
							优惠券

							<input name="coupon_type" disabled  style="margin-left:45px;float:none" type="radio" value="2" <?php if($coupon['type'] == '2'){?>checked="true" <?php }?>>
							赠送券
						</label>
					</div>
				</div>


				<div class="control-group">
					<label class="control-label"><em class="required">*</em>优惠券名称：</label>
					<div class="controls">
						<input type="text" name="name" value="<?php echo $coupon['name'] ?>"   placeholder="最多支持10个字">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label"><em class="required">*</em>面值：</label>
					<div class="controls">
						<div>
							<input type="text" readonly="readonly" name="value" value="<?php echo $coupon['face_money'] ?>" class="input-small">

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
							<input name="is_at_least" disabled  type="radio" value="" <?php if($coupon['limit_money']== '0' || $coupon['limit_money']== '0.00' ){?>checked="true" <?php }?>>
							不限制
						</label>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label class="radio inline">
							<input style="margin-top:6px;" disabled  name="is_at_least" type="radio" value="1" <?php if($coupon['limit_money'] > 0){?>checked="true" <?php }?>>满
							<input type="text" readonly="readonly"  name="at_least" value="<?php echo $coupon['limit_money'] ?>" class="input-small js-price" data-value-type="Number">
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
						<select name="quota" disabled data-value-type="Number">

							<option value="0" <?php if($coupon['most_have']=='0'){?>selected="" <?php }?>>不限张</option>

							<option value="1" <?php if($coupon['most_have']=='1'){?>selected="" <?php }?>>1张</option>

							<option value="2" <?php if($coupon['most_have']=='2'){?>selected="" <?php }?>>2张</option>

							<option value="3" <?php if($coupon['most_have']=='3'){?>selected="" <?php }?>>3张</option>

							<option value="4" <?php if($coupon['most_have']=='4'){?>selected="" <?php }?>>4张</option>

							<option value="5" <?php if($coupon['most_have']=='5'){?>selected="" <?php }?>>5张</option>

							<option value="10" <?php if($coupon['most_have']=='10'){?>selected="" <?php }?>>10张</option>

						</select>
					</div>
				</div>


				<div class="control-group ffzd">
					<label class="control-label"><em class="required">*</em>发放总量：</label>
					<div class="controls">
						<div class="input-append">
							<input type="text" name="total" value="<?php echo $coupon['total_amount'] ?>" class="input-small">
							<span class="add-on">张</span>
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label"><em class="required">*</em>生效时间：</label>
					<div class="controls">
						<input type="text" disabled name="start_at" value="<?php echo date("Y-m-d H:i:s",$coupon['start_time']); ?>" ass="js_start_time hasDatepicker" id="js_start_time">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label"><em class="required">*</em>过期时间：</label>
					<div class="controls">
						<input type="text" disabled name="end_at"  value="<?php echo date("Y-m-d H:i:s",$coupon['end_time']); ?>" ass="js_end_time hasDatepicker" id="js_end_time">
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
							<input type="checkbox" name="expire_notice" <?php if($coupon['is_expire_notice']=='1'){?> checked="" <?php }?>>到期前4天提醒一次
						</label>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">推广设置：</label>
					<div class="controls">
						<label class="checkbox inline">
							<input type="checkbox" name="is_share" <?php if($coupon['is_share']=='1'){?> checked="" <?php }?>> 允许分享领取链接
						</label>
					</div>
				</div>
				-->


				<div class="control-group">
					<label class="control-label"><em class="required">*</em>可使用商品：</label>
					<div class="controls">
						<label class="radio inline">
							<input name="range_type" type="radio" value="all" <?php if($coupon['is_all_product']=='0'){?>checked=""<?php }?>>全店通用
						</label>
						<label class="radio inline">
							<!-- range_type : single 兼容宝贝券数据 -->
							<input name="range_type" type="radio" value="part" <?php if($coupon['is_all_product']=='1'){?>checked=""<?php }?>>指定商品
						</label>
					</div>
				</div>

<!-----ADD 商品--------->
				<div class="control-group">
					<div class="controls">

						<input type="hidden" class="tips_is_product" value="<?php echo $coupon['is_all_product'];?>">

						<table class="assign-goods-list ui-table js-goods-lists js_add_goods_from_edit1" pid_arr="<?php echo $product_id_str;?>">
							<thead>
							<?php if($coupon['is_all_product']=='1'){?>
								<tr><th class="cell-30">商品名称</th> <th class="cell-50">商品名称</th> <th class="cell-20">操作</th></tr>
							</thead>
							<?php }?>
							<!-- 仅编辑状态下才展示 -->
							<tbody>
							<?php if($coupon['is_all_product']=='1'){?>
								<?php foreach ($coupon_product_list as $product) {	?>
								<tr class="sort" data-pid="<?php echo $product['product_id'];?>">
									<td><a classs="aaa" href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>" target="_blank">
											<img src="<?php echo $product['image'] ?>" alt="<?php echo htmlspecialchars($product['name']) ?>" title="1" width="50" height="50"></a></td>
									<td><a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>" class="aaa"><?php echo htmlspecialchars($product['name']) ?></a></td>
									<td><a class=" js-delete-goods" href="javascript:void(0)" data-id="<?php echo $product['product_id'];?>"
									       title="删除">×</a></td>
								</tr>
								<!-- 仅编辑状态下才展示 -->
								<?php	}?>
							<?php
							}
							?>
							</tbody>


						</table>

						<a href="javascript:void(0)" class="add-goods js_add_goods_from_edit" <?php if($coupon['is_all_product']!='1'){?>style="display: none"<?php }?>> + 添加商品</a>
						<input type="hidden" name="is_select_goods">
					</div>
				</div>
<!-----add end 商品------->
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label class="checkbox inline">
							<input type="checkbox" name="is_forbid_preference" <?php if($coupon['is_original_price']=='1'){?> checked=""<?php }?>>仅原价购买商品时可用
						</label>
					</div>
				</div>


				<div class="control-group">
					<label class="control-label">使用说明：</label>
					<div class="controls">
						<textarea name="description" style="width:260px;" cols="30" rows="3" placeholder="填写活动的详细说明，支持换行;"><?php echo $coupon['description']; ?></textarea>
					</div>
					<div class="controls controls_syzs" style="color:#333333;opacity:0.5;display:none">剩余<span id="syzs"></span>字</div>
				</div>

			</form>
		</div></div>
</div>
<div class="app-actions" style="bottom: 0px;">
	<div class="form-actions text-center">
		<input class="btn js-btn-quit" type="button" value="取 消">
		<input type="hidden" value="<?php echo $coupon['id']?>" id="couponid" >
		<input class="btn btn-primary  js-btn-edit-save" type="submit" value="保 存" data-loading-text="保 存...">
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