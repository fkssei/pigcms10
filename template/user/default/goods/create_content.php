<div class="goods-edit-area">
<ul class="ui-nav-tab">
    <li data-next-step="1" class="js-switch-step js-step-1 active"><a href="javascript:;">1.选择商品品类</a></li>
    <li data-next-step="2" class="js-switch-step js-step-2"><a href="javascript:;">2.编辑基本信息</a></li>
    <li data-next-step="3" class="js-switch-step js-step-3"><a href="javascript:;">3.编辑商品详情</a></li>
</ul>
<div id="step-content-region">
<form class="form-horizontal fm-goods-info">
<div id="step-1" class="js-step">
    <div class="clearfix ui-box" style="display:none;">
        <div class="right">
            <span class="help-icon"></span>
            商品类目及类目细项，
            <a href="#" class="new-window">请点此查看详情</a>
        </div>
    </div>
    <div id="class-info-region" class="goods-info-group">
        <div>
            <div class="class-block">
                <div class="js-class-block control-group">
                    <div class="controls">
                        <div class="js-goods-klass">
                            <div>
                                <div class="widget-goods-klass">
                                    <?php foreach ($cat_list as $value) { ?>
                                        <div
                                            class="widget-goods-klass-item<?php if (!empty($value['cat_list'])) echo ' has-children'; ?>"
                                            data-id="<?php echo $value['cat_id']; ?>"
                                            data-name="<?php echo $value['cat_name']; ?>">
                                            <span
                                                class="widget-goods-klass-name"><?php echo $value['cat_name']; ?></span>
                                            <?php if (!empty($value['cat_list'])) { ?>
                                                <ul class="widget-goods-klass-children">
                                                    <?php foreach ($value['cat_list'] as $v) { ?>
                                                        <li data-id="<?php echo $value['cat_id']; ?>-<?php echo $v['cat_id']; ?>">
                                                            <label class="radio">
                                                                <input type="radio" name="goods-class-2"/>
                                                                <?php echo $v['cat_name']; ?>
                                                            </label>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="app-actions">
        <div class="form-actions text-center">
            <button data-next-step="2" class="btn btn-primary js-switch-step">下一步</button>
        </div>
    </div>
</div>
<div id="step-2" style="display:none;" class="js-step">
<div id="base-info-region" class="goods-info-group">
    <div class="goods-info-group-inner">
        <div class="info-group-title vbox">
            <div class="group-inner">基本信息</div>
        </div>
        <div class="info-group-cont vbox">
            <div class="group-inner">
                <div class="control-group">
                    <label class="control-label">商品类目：</label>
                    <div class="controls">
                        <div class="js-goods-class static-value"></div>
                        <input type="hidden" class="input-medium" name="class_ids" value="0"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">购买方式：</label>

                    <div class="controls">
                        <label class="radio inline">
                            <input type="radio" name="shop_method" value="1" checked="">在商城购买
                        </label>
                        <label class="radio inline">
                            <input type="radio" name="shop_method" value="0">链接到外部购买
                            <span class="js-outbuy-tip hide">(每家店铺仅支持50个外部购买商品)</span>
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">商品分组：</label>
                    <div class="controls">
                        <div class="chosen-container chosen-container-multi" style="width:200px;">
                            <ul class="chosen-choices">
                                <li class="search-field">
                                    <input type="text" value="选择商品分组" class="default" autocomplete="off" style="width:103px;cursor:text;" disabled="disabled"/>
                                </li>
                            </ul>
                            <div class="chosen-drop">
                                <ul class="chosen-results"></ul>
                            </div>
                        </div>
                        <p class="help-inline">
                            &nbsp;&nbsp;&nbsp;<a class="js-refresh-tag" href="javascript:;">刷新</a>
                            <span>|</span>
                            <a class="new_window" target="_blank" href="<?php dourl('category');?>#create">新建分组</a>
                        </p>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <?php if (empty($_SESSION['sync_store'])) { ?>
<!-----start-->
	<div class="goods-info-group-inner sxsx">

		<div class="info-group-title vbox">
			<div class="group-inner">点击选择筛选的属性</div>
		</div>
		<div class="info-group-cont vbox">
			<div class="group-inner group-inner2">

			</div>
		</div>
	</div>
    <?php } ?>
	<!--end-->
</div>
<!--
<div id="sku-info-region" class="goods-info-group">
    <div class="goods-info-group-inner">
        <div class="info-group-title vbox">
            <div class="group-inner">库存/规格</div>
        </div>
        <div class="info-group-cont vbox">
            <div class="group-inner">
                <div class="js-goods-sku control-group">
                    <label class="control-label">商品规格：</label>
                    <div id="sku-region" class="controls">
                        <div class="sku-group">
                            <div class="js-sku-list-container"></div>
                            <div class="js-sku-group-opts sku-sub-group">
                                <h3 class="sku-group-title">
                                    <button type="button" class="js-add-sku-group btn">添加规格项目</button>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="js-goods-stock control-group" style="display: none;">
                    <label class="control-label">商品库存：</label>
                    <div id="stock-region" class="controls sku-stock">
                        <table class="table-sku-stock"></table>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><em class="required">*</em>总库存：</label>
                    <div class="controls">
                        <input type="text" maxlength="9" class="input-small" name="total_stock" value="0"/>&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="checkbox inline"><input type="checkbox" name="hide_stock" value="0"/>页面不显示商品库存</label>
                        <p class="help-desc">总库存为 0 时，将不在商品列表中显示</p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">商家编码：</label>
                    <div class="controls">
                        <input type="text" class="input-small" name="goods_no" value=""/>
                        <a style="display:none;" href="javascript:;" class="js-help-notes circle-help">?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->
<!------>
<div id="sku-info-region" class="goods-info-group">
	<div class="goods-info-group-inner">
		<div class="info-group-title vbox">
			<div class="group-inner">库存/规格</div>
		</div>
		<div class="info-group-cont vbox">
			<div class="group-inner">
				<div class="js-goods-sku control-group">
					<label class="control-label">商品属性：</label>
					<div id="sku-region" class="controls">
						<div class="sku-group">
							<div class="js-sku-list-container">
								<div class="sku-sub-group">
								</div>

							</div>
							<div class="js-sku-group-opts sku-sub-group">
								<h3 class="sku-group-title">
									<button type="button" class="js-add-sku-group btn">添加规格项目</button>
								</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="js-goods-stock control-group" style="display: none;">
					<label class="control-label">商品库存：</label>
					<div id="stock-region" class="controls sku-stock">
						<table class="table-sku-stock"></table>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><em class="required">*</em>总库存：</label>
					<div class="controls">
						<input type="text" maxlength="9" class="input-small" name="total_stock" value="0"/>&nbsp;&nbsp;&nbsp;&nbsp;
						<label class="checkbox inline"><input type="checkbox" name="hide_stock" value="0"/>页面不显示商品库存</label>
						<p class="help-desc">总库存为 0 时，将不在商品列表中显示</p>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">商家编码：</label>
					<div class="controls">
						<input type="text" class="input-small" name="goods_no" value=""/>
						<a style="display:none;" href="javascript:;" class="js-help-notes circle-help">?</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!------>
<div id="goods-info-region" class="goods-info-group">
    <div class="goods-info-group-inner">
        <div class="info-group-title vbox">
            <div class="group-inner">商品信息</div>
        </div>
        <div class="info-group-cont vbox">
            <div class="group-inner">
                <div class="control-group">
                    <label class="control-label"><em class="required">*</em>商品名：</label>
                    <div class="controls">
                        <input class="input-xxlarge" type="text" name="title" value="" maxlength="100"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><em class="required">*</em>价格：</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">￥</span><input type="text" maxlength="10" name="price" value="0.00" class="input-small"/>
                        </div>
                        <input type="text" class="input-small" placeholder="原价：" name="origin" value=""/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"><em class="required">*</em>商品图：</label>
                    <div class="controls">
                        <input type="hidden" name="picture">
                        <div class="picture-list ui-sortable">
                            <ul class="js-picture-list app-image-list clearfix">
                                <li>
                                    <a href="javascript:;" class="add-goods js-add-picture">+加图</a>
                                </li>
                            </ul>
                        </div>
                        <p class="help-desc">建议尺寸：640 x 640 像素，最多可上传8张图片，您可以拖拽图片调整图片顺序。</p>
                    </div>
                </div>
                <div class="js-buy-url-group control-group hide">
                    <label class="control-label"><em class="required">*</em>外部购买地址：</label>
                    <div class="controls">
                        <input type="text" name="buy_url" placeholder="http://" class="input-xxlarge js-buy-url"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="other-info-region" class="goods-info-group">
    <div class="goods-info-group-inner">
        <div class="info-group-title vbox">
            <div class="group-inner">物流/其它</div>
        </div>
        <div class="info-group-cont vbox">
            <div class="group-inner">
                <div class="control-group">
                    <label class="control-label">运费设置：</label>

                    <div class="controls">
                        <label class="radio" style="padding-top:0px;">
                            <input id="js-unified-postage" type="radio" name="delivery" value="0" checked="" style="margin-top:7px;"/>统一邮费
                            <div class="input-prepend">
                                <span class="add-on">￥</span><input type="text" name="postage" class="input-small js-postage" value="0.00" />
                            </div>
                        </label>
                        <label class="radio mat10">
                            <input id="js-use-delivery" disabled="" type="radio" name="delivery" value="1" style="margin-top:5px;"/>运费模版
                            <div class="delivery-template" style="display: inline-block;">
                                <div class="select2-container js-delivery-template" id="s2id_autogen1" style="width: 200px;"><a href="javascript:void(0)" onclick="return false;" class="select2-choice select2-default" tabindex="-1">
                                        <span class="select2-chosen">请选择运费模版...</span><abbr class="select2-search-choice-close"></abbr> <span class="select2-arrow"><b></b></span></a><input class="select2-focusser select2-offscreen" type="text" id="s2id_autogen2">

                                    <div class="select2-drop select2-display-none select2-with-searchbox">
                                        <div class="select2-search">
                                            <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" maxlength="12">
                                        </div>
                                        <ul class="select2-results"></ul>
                                    </div>
                                </div>
                                <input type="hidden" name="delivery_template_id" value=""
                                       class="js-delivery-template select2-offscreen" tabindex="-1">
                                <a class="js-refresh-delivery" href="javascript:;">刷新</a>
                                <a href="<?php dourl('trade:delivery'); ?>" target="_blank" class="new-window">+新建</a>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">重量：</label>
                    <div class="controls">
                        <input type="text" name="weight" value="0" class="input-small js-weight" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" />
                        <span class="gray">单位：克</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">每人限购：</label>
                    <div class="controls">
                        <input type="text" name="quota" value="0" class="input-small js-quota"/>
                        <span class="gray">0 代表不限购</span>

                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">要求留言：</label>

                    <div class="controls">
                        <input type="hidden" name="messages" />
                        <div id="messages-region">
                            <div>
                                <div class="js-message-container message-container"></div>
                                <div class="message-add">
                                    <a href="javascript:;" class="js-add-message control-action">+ 添加字段</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">开售时间：</label>

                    <div class="controls">
                        <label class="radio">
                            <input type="radio" name="sold_time" value="0" checked="" />立即开售
                        </label>
                        <label class="radio mat5" for="sold_time">
                            <input type="radio" id="sold_time" name="sold_time" value="1" style="margin-top:7px;"/>定时开售
                            <input id="start_sold_time" name="start_sold_time" readonly="readonly" class="input-medium js-sold-time v-hide" type="text" value=""/>
                        </label>
                    </div>
                </div>
                <!--
                <div class="js-level-discount control-group control-group-notes-wrap">
                    <label class="control-label">会员折扣：</label>

                    <div class="controls">
                        <label class="checkbox inline">
                            <input type="checkbox" name="join_level_discount" value="1" checked=""/>参加会员折扣
                        </label>
                    </div>
                    <div class="block-help ">
                        <a href="javascript:void(0);" class="js-help-notes" data-class="right"></a>
                        <div class="js-notes-cont hide">
                            <p>1、设置会员等级折扣（仅限认证服务号）</p>
                            <p>2、设置商品时开启会员折扣</p>
                            <p>3、相应等级会员在购买该商品时就能享受该折扣</p>
                        </div>
                    </div>
                </div>
                -->

				<div class="control-group">
                    <label class="control-label">推荐：</label>
                    <div class="controls">
                        <label class="checkbox inline">
                            <input type="checkbox" name="is_recommend" value="1" /> 参加推荐商品
                        </label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">发票：</label>
                    <div class="controls">
                        <label class="radio inline">
                            <input type="radio" name="invoice" value="0" checked=""/>无
                        </label>
                        <label class="radio inline">
                            <input type="radio" name="invoice" value="1"/>有
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">保修：</label>
                    <div class="controls">
                        <label class="radio inline">
                            <input type="radio" name="warranty" value="0" checked="">无
                        </label>
                        <label class="radio inline">
                            <input type="radio" name="warranty" value="1">有
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="app-actions">
    <div class="form-actions text-center">
        <button data-next-step="3" class="btn btn-primary js-switch-step">下一步</button>
    </div>
</div>
</div>
<div id="step-3" style="display:none;" class="js-step">
    <div class="app-design clearfix">
        <div class="app-preview">
            <div class="app-header"></div>
            <div class="app-entry">
                <div class="app-config">
                    <div class="app-field" style="cursor: default;">
                        <h1><span></span></h1>
                        <div class="goods-details-block">
                            <h4>基本信息区</h4>
                            <p>固定样式，显示商品主图、价格等信息</p>
                        </div>
                    </div>
                    <div class="js-config-region">
                        <div class="app-field clearfix editing">
                            <div class="control-group"><div class="goods-details-block" style="background:#fff;"><h4>商品详情区</h4><p>点击进行编辑</p></div></div>
                            <div class="actions">
                                <div class="actions-wrap">
                                    <span class="action edit">编辑</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-fields js-fields-region"><div class="app-fields ui-sortable"></div></div>
            </div>
        </div>
        <div class="app-sidebar" style="margin-top: 243px;">
			<div class="app-sidebar-inner goods-sidebar-sub-title js-goods-sidebar-sub-title">
				<p class="" style="color:#333">商品简介(选填)</p>
				<textarea rows="2" name="intro" class="js-sub-title input-sub-title"></textarea>
			</div>
            <div class="arrow"></div>
            <div class="app-sidebar-inner js-sidebar-region"></div>
        </div>
        <div class="app-actions" style="bottom: 0px;">
            <div class="form-actions text-center">
                <button class="btn js-switch-step" data-next-step="2">上一步</button>
                <input class="btn btn-primary js-btn-load js-btn-save" type="button" data="putaway" value="上架" data-loading-text="上架...">
                <input class="btn js-btn-unload js-btn-save" type="button" data="soldout" value="下架" data-loading-text="下架...">
                <input class="btn js-btn-preview js-btn-save" type="button" value="预览" data="preview" data-loading-text="预览效果...">
            </div>
        </div>
    </div>
</div>
</form>
</div>
</div>