<form class="form-horizontal">
    <fieldset>
        <div class="control-group">
            <label class="control-label">所属公司：</label>
            <div class="controls">
                <span class="sink"><?php echo $company['name']; ?></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">店铺名称：</label>
            <div class="controls">
                <?php if (empty($store['edit_name_count'])) { ?>
                <div class="hide js-team-name-input">
                    <input type="text" name="team_name" value="<?php echo $store['name']; ?>" data="<?php echo $store['name']; ?>" maxlength="30" />
                    <p class="help-block error-message">店铺名称只能修改一次，请您谨慎操作</p>
                </div>
                <?php } ?>
                <div class="js-team-name-text">
                    <span class="sink"><?php echo $store['name']; ?></span>
                    <?php if (empty($store['edit_name_count'])) { ?>
                    <a href="javascript:;" class="sink sink-minor js-team-name-edit">修改</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">主营类目：</label>
            <div class="controls">
                <span class="sink"><?php echo $sale_category; ?></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">创建日期：</label>
            <div class="controls">
                <span class="sink"><?php echo date('Y-m-d H:i:s', $store['date_added']); ?></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">店铺 Logo：</label>
            <div class="controls">
                <span class="avatar"><img class="avatar-img" <?php if (!empty($store['logo'])) { ?>src="<?php echo $store['logo']; ?>"<?php } else { ?>src="<?php echo TPL_URL;?>/images/logo.png"<?php } ?>/></span>
                <a href="javascript:;" class="upload-img js-add-picture">修改</a>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">店铺简介：</label>
            <div class="controls">
                <textarea name="intro" class="input-intro" cols="30" rows="3" maxlength="100"><?php echo $store['intro']; ?></textarea>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">联系人姓名：</label>
            <div class="controls">
                <input class="contact-name" type="text" name="contact_name" placeholder="请填写完整的真实姓名" value="<?php echo $store['linkman']; ?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">联系人 QQ：</label>
            <div class="controls">
                <input class="qq" type="text" placeholder="填写能联系到您的QQ号码" name="qq" value="<?php echo $store['qq']; ?>" maxlength="15" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">联系人手机号：</label>
            <div class="controls">
                <input class="mobile js-mobile" type="text" name="mobile" placeholder="填写准确的手机号码，便于及时联系" value="<?php echo $store['tel']; ?>" maxlength="11" />
            </div>
        </div>
        <?php if (!empty($_SESSION['sync_store'])) { ?>
		<div class="control-group">
                <label class="control-label">启用客服：</label>

                <div class="controls">
                    <input type="radio" value="0" name="open_service" class="open_service" <?php if($store['open_service'] == 0 || $store['open_service'] == ''){echo 'checked=true';} ?> />
					关闭
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" value="1" name="open_service" class="open_service" <?php if($store['open_service'] == 1){echo 'checked=true';} ?> />
					开启
                </div>
            </div>
			<div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="color:#f00;">
					客服使用对接平台上的“网页客服”功能
                </div>
            </div>
        <?php } ?>
    </fieldset>
    <div class="form-actions">
        <button class="ui-btn ui-btn-primary js-btn-submit" type="button" data-loading-text="正在保存...">保存</button>
    </div>
</form>