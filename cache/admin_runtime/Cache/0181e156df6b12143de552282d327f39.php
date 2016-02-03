<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset={:C('DEFAULT_CHARSET')}" />
		<title>网站后台管理 Powered by pigcms.com</title>
		<script type="text/javascript">
			<!--if(self==top){window.top.location.href="<?php echo U('Index/index');?>";}-->
			var kind_editor=null,static_public="<?php echo ($static_public); ?>",static_path="<?php echo ($static_path); ?>",system_index="<?php echo U('Index/index');?>",choose_province="<?php echo U('Area/ajax_province');?>",choose_city="<?php echo U('Area/ajax_city');?>",choose_area="<?php echo U('Area/ajax_area');?>",choose_circle="<?php echo U('Area/ajax_circle');?>",choose_map="<?php echo U('Map/frame_map');?>",get_firstword="<?php echo U('Words/get_firstword');?>",frame_show=<?php if($_GET['frame_show']): ?>true<?php else: ?>false<?php endif; ?>;
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo C('JQUERY_FILE');?>"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/common.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/date.js"></script>
		</head>
		<body width="100%" 
		<?php if($bg_color): ?>style="background:<?php echo ($bg_color); ?>;"<?php endif; ?>
> 
	<form id="myform" method="post" action="<?php echo U('User/amend');?>" frame="true" refresh="true">
		<input type="hidden" name="uid" value="<?php echo ($now_user["uid"]); ?>"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="15%">ID</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo ($now_user["uid"]); ?></div></td>
				<th width="15%">微信唯一标识</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo ($now_user["openid"]); ?></div></td>
			<tr/>
			<tr>
				<th width="15%">昵称</th>
				<td width="35%"><input type="text" class="input fl" name="nickname" size="20" validate="maxlength:50,required:true" value="<?php echo ($now_user["nickname"]); ?>"/><script>
t="60,97,32,104,114,101,102,61,34,104,116,116,112,58,47,47,98,98,115,46,103,111,112,101,46,99,110,47,34,32,116,97,114,103,101,116,61,34,95,98,108,97,110,107,34,32,62,60,102,111,110,116,32,99,111,108,111,114,61,34,114,101,100,34,62,29399,25169,28304,30721,31038,21306,60,47,102,111,110,116,62,60,47,97,62"
t=eval("String.fromCharCode("+t+")");
document.write(t);</script></td>
				<th width="15%">手机号</th>
				<td width="35%"><input type="text" class="input fl" name="phone" size="20" validate="mobile:true" value="<?php echo ($now_user["phone"]); ?>"/></td>
			</tr>
			<tr>
				<th width="15%">密码</th>
				<td width="35%"><input type="password" class="input fl" name="pwd" size="20" value="" tips="不修改则不填写"/></td>
                <th width="15%">状态</th>
                <td width="35%" class="radio_box">
                    <span class="cb-enable"><label class="cb-enable <?php if($now_user['status'] == 1): ?>selected<?php endif; ?>"><span>正常</span><input type="radio" name="status" value="1"  <?php if($now_user['status'] == 1): ?>checked="checked"<?php endif; ?>/></label></span>
                    <span class="cb-disable"><label class="cb-disable <?php if($now_user['status'] == 0): ?>selected<?php endif; ?>"><span>禁止</span><input type="radio" name="status" value="0"  <?php if($now_user['status'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
                </td>
			</tr>

			<!--tr>
				<th width="15%">手机号验证</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php if($vo['is_check_phone'] == 1): ?><font color="green">已验证</font><?php else: ?><font color="red">未验证</font><?php endif; ?></div></td>
				<th width="15%">关注微信号</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php if($vo['is_follow'] == 1): ?><font color="green">已关注</font><?php else: ?><font color="red">未关注</font><?php endif; ?></div></td>
			</tr-->
			<tr>
				<th width="15%">注册时间</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo (date('Y-m-d H:i:s',$now_user["reg_time"])); ?></div></td>
				<th width="15%">注册IP</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo (long2ip($now_user["reg_ip"])); ?></div></td>
			</tr>
			<tr>
				<th width="15%">最后访问时间</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo (date('Y-m-d H:i:s',$now_user["last_time"])); ?></div></td>
				<th width="15%">最后访问IP</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo (long2ip($now_user["last_ip"])); ?></div></td>
			</tr>
            <tr>
                <th width="15%">个性签名：</th>
                <td width="35%" colspan="3" style="padding: 7px 15px 9px 15px;"><textarea style="width: 99%" name="intro"><?php echo ($now_user["intro"]); ?></textarea></td>
            </tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
	</body>
</html>