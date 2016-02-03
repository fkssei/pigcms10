<style type="text/css">
    .get-web-img-input {
        height: 30px!important;
    }
</style>
<div>
    <form class="form-horizontal">
        <fieldset>
            <?php if (!empty($user['phone'])) { ?>
            <div class="control-group">
                <label class="control-label">账号：</label>

                <div class="controls controls-account">
                    <div class="show-text"><?php echo $user['phone']; ?></div>
                    <?php if (empty($_SESSION['sync_store'])) { ?>
                    <a href="<?php dourl('password'); ?>" class="js-change-pw">修改密码</a>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            <div class="control-group">
                <label class="control-label">昵称：</label>

                <div class="controls">
                    <input type="text" value="<?php echo $user['nickname']; ?>" name="nickname" maxlength="15" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">头像：</label>

                <div class="controls">
                    <div class="file-wrapper">
                        <div class="display-image" data-url="<?php if (!empty($user['avatar'])) { ?><?php echo $user['avatar']; ?><?php } else { ?><?php echo TPL_URL;?>/images/avatar.png<?php } ?>">
                            <span class="avatar" style="background-image: url(<?php if (!empty($user['avatar'])) { ?><?php echo $user['avatar']; ?><?php } else { ?><?php echo TPL_URL;?>/images/avatar.png<?php } ?>)"></span>
                        </div>
                        <a href="javascript:;" class="js-trigger-image" name="avatar">修改</a>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">个人签名：</label>

                <div class="controls">
                    <textarea rows="8" name="intro" class="input-xxlarge" maxlength="200" placeholder="最多200字"><?php echo $user['intro']; ?></textarea>
                </div>
            </div>
            <div class="control-group control-action">
                <div class="controls">
                    <button class="btn btn-large btn-primary js-btn-submit" type="button" data-loading-text="正在提交...">
                        确认修改
                    </button>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="<?php dourl('store:select'); ?>">取消</a>
                </div>
            </div>

        </fieldset>
    </form>
</div>