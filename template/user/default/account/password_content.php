<div>
    <form class="form-horizontal">
        <fieldset class="center-area">
            <div class="control-group">
                <label class="control-label">请输入旧密码：</label>
                <div class="controls">
                    <input type="password" name="old_password">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">请输入新密码：</label>
                <div class="controls">
                    <input type="password" name="new_password">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">重复新密码：</label>
                <div class="controls">
                    <input type="password" name="renew_password">
                </div>
            </div>
            <div class="control-group control-action">
                <div class="controls">
                    <button class="btn btn-large btn-primary js-btn-submit" type="button" data-loading-text="正在提交...">确定修改</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="<?php dourl('store:select'); ?>">取消</a>
                </div>
            </div>
        </fieldset>
    </form>


</div>