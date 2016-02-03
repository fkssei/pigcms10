<div class="goods-edit-area">
<ul class="ui-nav-tab">
    <li data-next-step="1" class="js-switch-step js-step-1"><a href="javascript:;">1.选择商品品类</a></li>
    <li data-next-step="2" class="js-switch-step js-step-2 active"><a href="javascript:;">2.编辑基本信息</a></li>
    <li data-next-step="3" class="js-switch-step js-step-3"><a href="javascript:;">3.编辑商品详情</a></li>
</ul>
<div id="step-content-region">
<form class="form-horizontal fm-goods-info">
<div id="step-1" style="display:none;" class="js-step">
    <div class="clearfix ui-box">
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
                                        <?php if (!empty($parent_category) && $parent_category['cat_id'] == $value['cat_id']) { ?>
                                        <div class="widget-goods-klass-item<?php if (!empty($value['cat_list'])) echo ' has-children'; ?> <?php if ($category_id == $category['cat_id']) { ?>current<?php } ?>" data-id="<?php echo $category['cat_id']; ?>" data-name="<?php echo $parent_category['cat_name']; ?>">
                                            <span class="widget-goods-klass-name"><?php echo $category['cat_name']; ?></span>
                                        <?php } else { ?>
                                            <div class="widget-goods-klass-item<?php if (!empty($value['cat_list'])) echo ' has-children'; ?> <?php if ($category_id == $value['cat_id']) { ?>current<?php } ?>" data-id="<?php echo $value['cat_id']; ?>" data-name="<?php echo $value['cat_name']; ?>">
                                                <span class="widget-goods-klass-name"><?php echo $value['cat_name']; ?></span>
                                        <?php } ?>
                                            <?php if (!empty($value['cat_list'])) { ?>
                                                <ul class="widget-goods-klass-children">
                                                    <?php foreach ($value['cat_list'] as $v) { ?>
                                                        <li data-id="<?php echo $value['cat_id']; ?>-<?php echo $v['cat_id']; ?>">
                                                            <label class="radio">
                                                                <input type="radio" value="<?php echo $v['cat_id']; ?>" name="goods-class-2"
                                                                       <?php if ($category_id == $v['cat_id']) { ?>checked="true" <?php } ?> />
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
<div id="step-2" class="js-step">
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
                        <div class="js-goods-class static-value"><?php echo $category_name; ?></div>
                        <input type="hidden" class="input-medium" name="class_ids" value="0"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">购买方式：</label>

                    <div class="controls">
                        <label class="radio inline">
                            <input type="radio" name="shop_method" value="1" <?php if (!empty($product['buy_way'])) { ?>checked="true"<?php } ?>>在商城购买
                        </label>
                        <label class="radio inline">
                            <input type="radio" name="shop_method" value="0" <?php if (empty($product['buy_way'])) { ?>checked="true"<?php } ?>>链接到外部购买
                            <span class="js-outbuy-tip hide">(每家店铺仅支持50个外部购买商品)</span>
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">商品分组：</label>
                    <div class="controls">
                        <select class="js-tag chosen-select" name="tag" multiple="" data-placeholder="选择商品分组" style="display:none;"></select>
                        <div class="chosen-container chosen-container-multi" style="width:200px;">
                            <ul class="chosen-choices">
								<?php if($group_groups){ ?>
									<?php foreach($group_groups as $value){ ?>
										<li class="search-choice" data-id="<?php echo $value['group_id'];?>"><span><?php echo $value['group_name'];?></span><a class="search-choice-close"></a></li>
									<?php } ?>
									<li class="search-field">
										<input type="text" value="选择商品分组" class="default" autocomplete="off" style="cursor:text;width:25px;" readonly="readonly"/>
									</li>
								<?php }else{ ?>
									<li class="search-field">
										<input type="text" value="选择商品分组" class="default" autocomplete="off" style="cursor:text;width:103px;" readonly="readonly"/>
									</li>
								<?php } ?>
                                
                            </ul>
                            <div class="chosen-drop">
                                <ul class="chosen-results"></ul>
                            </div>
                        </div>
                        <p class="help-inline">
                            <a class="js-refresh-tag" href="javascript:;">刷新</a>
                            <span>|</span>
                            <a class="new_window" target="_blank" href="<?php dourl('category');?>#create">新建分组</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


	<!-----start-->
	<input type="hidden" id="is_fenxiao" value="<?php echo $product['supplier_id'];?>">
    <?php if (empty($_SESSION['sync_store'])) { ?>
	<div class="goods-info-group-inner sxsx">

		<div class="info-group-title vbox">
			<div class="group-inner">点击选择筛选的属性</div>
		</div>
		<div class="info-group-cont vbox">
			<div class="group-inner group-inner2"></div>
		</div>
	</div>
    <?php } ?>
</div>



<!--end-->

<div id="sku-info-region" class="goods-info-group" <?php if (empty($product['buy_way'])) { ?>style="display: none;"<?php } ?>>
    <div class="goods-info-group-inner">
        <div class="info-group-title vbox">
            <div class="group-inner">库存/规格</div>
        </div>
        <div class="info-group-cont vbox">
            <div class="group-inner">
                <div class="js-goods-sku control-group">
                    <label class="control-label">商品规格：</label>

                    <div id="sku-region" class="controls">
                        <span style="color:orangered">商品规格暂不支持修改</span>
                    </div>
                </div>
                <div class="js-goods-stock control-group" <?php if (empty($sku_content)) { ?>style="display: none;"<?php } ?>>

                    <div id="stock-region" style="margin-left: 40px;" class="controls sku-stock">
                        <table class="table-sku-stock">
                            <?php echo $sku_content; ?>
                        </table>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><em class="required">*</em>总库存：</label>

                    <div class="controls">
                        <input type="text" maxlength="9" class="input-small" name="total_stock" value="<?php echo $product['quantity']; ?>" <?php if ($product['has_property'] || !empty($product['supplier_id'])) { ?>readonly="true"<?php } ?> />&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="checkbox inline"><input type="checkbox" name="hide_stock" value="0"
                                                              <?php if (!$product['show_sku']) { ?>checked="true" <?php } ?> />页面不显示商品库存</label>

                        <p class="help-desc">总库存为 0 时，将不在商品列表中显示</p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">商家编码：</label>

                    <div class="controls">
                        <input type="text" class="input-small" name="goods_no" value="<?php echo $product['code']; ?>"/>
                        <a style="display:none;" href="javascript:;" class="js-help-notes circle-help">?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                        <input class="input-xxlarge" type="text" name="title" value="<?php echo $product['name']; ?>" maxlength="100"/>
                    </div>
                </div>
                <?php if (empty($product['unified_price_setting']) || empty($product['supplier_id'])) { //供货商统一定价?>
                <div class="control-group">
                    <label class="control-label"><em class="required">*</em>价格：</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">￥</span><input type="text" maxlength="10" name="price" value="<?php echo $product['price']; ?>" class="input-small" <?php if ($product['has_property']) { ?>readonly="true"<?php } ?> <?php if (!empty($product['supplier_id'])) { ?>data-min-price="<?php echo $product['min_fx_price']; ?>" data-max-price="<?php echo $product['max_fx_price']; ?>"<?php } ?> />
                        </div>
                        <input type="text" class="input-small" placeholder="原价：" name="origin" <?php if ($product['original_price'] > 0) { ?>value="<?php echo $product['original_price']; ?>"<?php } ?> />
                    </div>
                </div>
                <?php } else { ?>
                <div class="control-group">
                    <label class="control-label">价格：</label>
                    <div class="controls">
                        <input type="hidden" name="price" value="<?php echo $product['price']; ?>" />
                        <span class="price" style="color: #f60;font-weight: bold;font-size: 14px">￥<?php echo $product['price']; ?></span>&nbsp;&nbsp;
                        <div class="input-prepend">
                            <span class="add-on">￥</span><input type="text" class="input-small" placeholder="原价：" name="origin" <?php if ($product['original_price'] > 0) { ?>value="<?php echo $product['original_price']; ?>"<?php } ?> />
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="control-group">
                    <label class="control-label"><em class="required">*</em>商品图：</label>
                    <div class="controls">
                        <input type="hidden" name="picture">

                        <div class="picture-list ui-sortable">
                            <ul class="js-picture-list app-image-list clearfix">
                                <?php foreach ($images as $image) { ?>
                                    <li class="sort">
                                        <a href="<?php echo $image['image']; ?>" target="_blank">
                                            <img src="<?php echo $image['image']; ?>"/>
                                        </a>
                                        <a class="js-delete-picture close-modal small hide">×</a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <a href="javascript:;" class="add-goods js-add-picture">+加图</a>
                                </li>
                            </ul>
                        </div>
                        <p class="help-desc">建议尺寸：640 x 640 像素，最多可上传8张图片，您可以拖拽图片调整图片顺序。</p>
                    </div>
                </div>
                <div class="js-buy-url-group control-group <?php if (!empty($product['buy_way'])) { ?>hide<?php } ?>">
                    <label class="control-label"><em class="required">*</em>外部购买地址：</label>
                    <div class="controls">
                        <input type="text" name="buy_url" placeholder="http://" <?php if ($product['buy_url']) { ?>value="<?php echo $product['buy_url']; ?>"<?php } ?> class="input-xxlarge js-buy-url"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="other-info-region" class="goods-info-group" <?php if (empty($product['buy_way'])) { ?>style="display: none;"<?php } ?>>
    <div class="goods-info-group-inner">
        <div class="info-group-title vbox">
            <div class="group-inner">物流/其它</div>
        </div>
        <div class="info-group-cont vbox">
            <div class="group-inner">
                <div class="control-group">
                    <label class="control-label">运费设置：</label>
                    <?php if (empty($product['supplier_id'])) { ?>
                    <div class="controls">
                        <label class="radio" style="padding-top:0px;">
                            <input id="js-unified-postage" type="radio" name="delivery" value="0" style="margin-top:7px;" <?php if (empty($product['postage_type'])) { ?>checked="true"<?php } ?> />统一邮费
                            <div class="input-prepend">
                                <span class="add-on">￥</span><input type="text" name="postage" class="input-small js-postage" <?php if (empty($product['postage_type'])) { ?>value="<?php echo $product['postage'] > 0 ? $product['postage'] : '0.00'; ?>"<?php } else { ?>value="0.00"<?php } ?> />
                            </div>
                        </label>
                        <label class="radio mat10">
                            <input id="js-use-delivery" disabled="" type="radio" name="delivery" value="1" style="margin-top:5px;" <?php if (!empty($product['postage_type'])) { ?>checked="true"<?php } ?> />运费模版
                            <div class="delivery-template" style="display: inline-block;">
                                <div class="select2-container js-delivery-template" id="s2id_autogen1" style="width: 200px;"><a href="javascript:void(0)" onclick="return false;" class="select2-choice select2-default" tabindex="-1">
                                        <span class="select2-chosen"><?php if (!empty($postage_template)) { ?><?php echo $postage_template['tpl_name']; ?><?php } else { ?>请选择运费模版...<?php } ?></span>
                                        <abbr class="select2-search-choice-close"></abbr>
                                        <span class="select2-arrow"><b></b></span></a><input
                                        class="select2-focusser select2-offscreen" type="text" id="s2id_autogen2">

                                    <div class="select2-drop select2-display-none select2-with-searchbox">
                                        <div class="select2-search">
                                            <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" maxlength="12">
                                        </div>
                                        <ul class="select2-results"></ul>
                                    </div>
                                </div>
                                <input type="hidden" name="delivery_template_id" value="<?php echo $product['postage_template_id']; ?>" class="js-delivery-template select2-offscreen" tabindex="-1">
                                <a class="js-refresh-delivery" href="javascript:;">刷新</a>
                                <a href="<?php dourl('trade:delivery'); ?>" target="_blank" class="new-window">+新建</a>
                            </div>
                        </label>
                    </div>
                    <?php } else { ?>
                    <div class="controls" style="color:orangered">
                        该商品为分销商品，暂不支持修改运费、配送信息
                    </div>
                    <?php } ?>
                </div>
                <div class="control-group">
                    <label class="control-label">重量：</label>
                    <div class="controls">
                        <input type="text" name="weight" value="<?php echo $product['weight'] + 0 ?>" class="input-small js-weight" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" />
                        <span class="gray">单位：克</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">每人限购：</label>
                    <div class="controls">
                        <input type="text" name="quota" value="<?php echo !empty($product['buyer_quota']) ? $product['buyer_quota'] : 0; ?>" class="input-small js-quota"/>
                        <span class="gray">0 代表不限购</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">要求留言：</label>
                    <div class="controls">
                        <input type="hidden" name="messages"/>
                        <div id="messages-region">
                            <div>
                                <div class="js-message-container message-container">
                                    <?php foreach ($fields as $field) { ?>
                                        <div class="message-item">
                                            <input type="text" name="field_name" value="<?php echo $field['field_name']; ?>" class="input-mini message-input field-name" maxlength="5" /><select class="input-small message-input" name="field-type">
                                                <option value="text" <?php if ($field['field_type'] == 'text') { ?>selected="true"<?php } ?>>文本格式</option>
                                                <option value="number" <?php if ($field['field_type'] == 'number') { ?>selected="true"<?php } ?>>数字格式</option>
                                                <option value="email" <?php if ($field['field_type'] == 'email') { ?>selected="true"<?php } ?>>邮件格式</option>
                                                <option value="date" <?php if ($field['field_type'] == 'date') { ?>selected="true"<?php } ?>>日期</option>
                                                <option value="time" <?php if ($field['field_type'] == 'time') { ?>selected="true"<?php } ?>>时间</option>
                                                <option value="id_no" <?php if ($field['field_type'] == 'id_no') { ?>selected="true"<?php } ?>>身份证号码</option>
                                                <option value="image" <?php if ($field['field_type'] == 'image') { ?>selected="true"<?php } ?>>图片</option>
                                            </select><label class="checkbox inline message-input">
                                                <input type="checkbox" name="multi_rows" class="multi-rows" value="1" <?php if ($field['multi_rows']) { ?>checked="true"<?php } ?> />多行
                                            </label><label class="checkbox inline message-input">
                                                <input type="checkbox" name="required" class="required" value="1" <?php if ($field['required']) { ?>checked="true"<?php } ?> />必填
                                            </label>
                                            <a href="javascript:;" class="js-remove-message remove-message">删除</a>
                                        </div>
                                    <?php } ?>
                                </div>
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
                            <input type="radio" name="sold_time" value="0" <?php if (empty($product['sold_time'])) { ?>checked="true"<?php } ?> />立即开售
                        </label>
                        <label class="radio mat5" for="sold_time">
                            <input type="radio" id="sold_time" name="sold_time" value="1" style="margin-top:7px;" <?php if (!empty($product['sold_time'])) { ?>checked="true"<?php } ?> />定时开售
                            <input id="start_sold_time" name="start_sold_time" readonly="readonly" class="input-medium js-sold-time v-hide" type="text" <?php if ($product['sold_time']) { ?>value="<?php echo date('Y-m-d H:i:s', $product['sold_time']); ?>"<?php } ?> />
                        </label>
                    </div>
                </div>
                <!--
                <div class="js-level-discount control-group control-group-notes-wrap">
                    <label class="control-label">会员折扣：</label>

                    <div class="controls">
                        <label class="checkbox inline">
                            <input type="checkbox" name="join_level_discount" value="1" <?php if ($product['allow_discount']) { ?>checked="true"<?php } ?> />参加会员折扣
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
                            <input type="checkbox" name="is_recommend" value="1" <?php if ($product['is_recommend']) { echo 'checked="true"';} ?> /> 参加推荐商品
                        </label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">发票：</label>

                    <div class="controls">
                        <label class="radio inline">
                            <input type="radio" name="invoice" value="0"
                                   <?php if (!$product['invoice']) { ?>checked="true"<?php } ?> />无
                        </label>
                        <label class="radio inline">
                            <input type="radio" name="invoice" value="1"
                                   <?php if ($product['invoice']) { ?>checked="true"<?php } ?> />有
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">保修：</label>

                    <div class="controls">
                        <label class="radio inline">
                            <input type="radio" name="warranty" value="0"
                                   <?php if (!$product['warranty']) { ?>checked="true"<?php } ?> />无
                        </label>
                        <label class="radio inline">
                            <input type="radio" name="warranty" value="1"
                                   <?php if ($product['warranty']) { ?>checked="true"<?php } ?> />有
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
                <div class="app-config ">
                    <div class="app-field" style="cursor: default;">
                        <h1><span></span></h1>
                        <div class="goods-details-block">
                            <h4>基本信息区</h4>
                            <p>固定样式，显示商品主图、价格等信息</p>
                        </div>
                    </div>
                    <div class="js-config-region">
                        <div class="app-field clearfix editing">
                            <div class="control-group">
                                <div class="custom-richtext"><?php echo $product['info'];?></div>
                            </div>
                            <div class="actions">
                                <div class="actions-wrap">
                                    <span class="action edit">编辑</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-fields js-fields-region">
                    <div class="app-fields ui-sortable"></div>
                </div>
            </div>
        </div>
        <div class="app-sidebar" style="margin-top: 243px;">
            <div class="app-sidebar-inner goods-sidebar-sub-title js-goods-sidebar-sub-title hide"
                 style="display: block;">
                <p class="" style="color: #333">商品简介(选填)</p>
                <textarea rows="2" name="intro" class="js-sub-title input-sub-title"><?php echo $product['intro']; ?></textarea>
            </div>
            <div class="arrow"></div>
            <div class="app-sidebar-inner js-sidebar-region">
                <div>
                    <div class="control-group">
                        <div class="js-editor edui-default" style="">
                            <textarea rows="2" name="info" class="js-sub-info input-sub-info" style="width: 440px"><?php echo $product['info']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-actions" style="bottom: 0px;">
            <div class="form-actions text-center">
                <button class="btn js-switch-step" data-next-step="2">上一步</button>
                <input class="btn btn-primary js-btn-load js-btn-edit" type="button" data="putaway" value="上架" data-product-id="<?php echo $product['product_id']; ?>" data-loading-text="上架..." />
                <input class="btn js-btn-unload js-btn-edit" type="button" data="soldout" value="下架" data-product-id="<?php echo $product['product_id']; ?>" data-loading-text="下架..." />
                <input class="btn js-btn-preview js-btn-edit" type="button" value="预览" data="preview" data-product-id="<?php echo $product['product_id']; ?>" data-loading-text="预览效果..." />
            </div>
        </div>
    </div>
</div>
</form>
</div>
</div>
<div style="display:none;" id="edit_custom" custom-field='<?php echo $customField;?>'></div>