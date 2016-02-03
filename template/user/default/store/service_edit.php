<div class="app-preview">
	<nav class="ui-nav">
        <ul>
            <li id="js-nav-list-index" class="active">
                <a href="<?php dourl('store:service'); ?>">编辑客服信息</a>
            </li>
        </ul>
    </nav>
	<div class="" style="background: #fff;border:1px solid #ccc;padding:10px 0;">
		<form class="form-horizontal" action="<?php dourl('create'); ?>" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label">头像预览：</label>
					<div class="controls">
						<img src="<?php if($info['avatar']){echo $info['avatar'];}else{ echo option('config.site_url').'/upload/images/default_shop.png';}?>" class="avatar_show" width="90px" height="90px">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">客服头像：</label>
					<div class="controls">
						<input type="text" placeholder="请上传客服头像" name="avatar" class="input-xxlarge avatar" value="<?php echo $info['avatar'];?>"/>
						<a class="js-choose-bg control-action" href="javascript: void(0);">修改头像</a>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">客服昵称：</label>
					<div class="controls">
						<input type="text" placeholder="请填写客服昵称" name="nickname" class="input-xxlarge nickname" value="<?php echo $info['nickname'];?>" maxlength="30"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">真实姓名：</label>
					<div class="controls">
						<input type="text" placeholder="请填写客服真实姓名" name="truename" class="input-xxlarge truename" maxlength="11" value="<?php echo $info['truename'];?>"/>
					</div>
				</div>
		
				<div class="control-group">
					<label class="control-label">联系电话：</label>
					<div class="controls">
						<input type="text" placeholder="请填写联系电话" name="tel" class="input-xxlarge tel" maxlength="11" value="<?php echo $info['tel'];?>"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">联系人 QQ：</label>
					<div class="controls">
						<input type="text" placeholder="请填写您常用的QQ号码" name="qq" class="input-xxlarge qq" value="<?php echo $info['qq'];?>" maxlength="15"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">邮箱：</label>
					<div class="controls">
						<input type="text" placeholder="请填写客服邮箱" name="email" class="input-xxlarge email" maxlength="50" value="<?php echo $info['email'];?>"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">客服简介：</label>
					<div class="controls">
						<textarea rows="" cols="" name="intro" class="input-xxlarge intro"><?php echo $info['intro'];?></textarea>
					</div>
				</div>
				<div class="controls">
					<input type="hidden" name="service_id" class="service_id" value="<?php echo $info['service_id'];?>">
					<button class="btn btn-large btn-primary submit-btn" type="button">添加客服</button>
				</div>
			</fieldset>
		</form>

    <div class="js-list-footer-region ui-box">
        <div>
            <div class="pagenavi js-page-list"><?php echo $group_list['page'];?></div>
        </div>
    </div>
</div>