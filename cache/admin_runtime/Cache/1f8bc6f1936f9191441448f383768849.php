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
> 		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="<?php echo U('Home/other');?>" class="on">关键词回复列表</a>|					<a href="<?php echo U('Home/other_add');?>">添加关键词回复</a>				</ul>			</div>			<form name="myform" id="myform" action="" method="post">				<div class="table-list">					<table width="100%" cellspacing="0">						<colgroup><col> <col> <col><col>  <col width="180" align="center"> </colgroup>						<thead>							<tr>								<th>编号</th>								<th>关键词</th>								<th>回复标题</th>								<th>回复内容</th>								<th>回复图片</th>								<th>链接（URL）</th>								<th class="textcenter">操作</th>							</tr>						</thead>						<tbody>							<?php if(is_array($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>										<td><?php echo ($vo["id"]); ?></td>										<td><?php echo ($vo["key"]); ?></td>										<td><?php echo ($vo["title"]); ?></td>										<td><?php echo ($vo["info"]); ?></td>										<td><?php if($vo['pic']): ?><img src="<?php echo ($vo["pic"]); ?>" width="50" height="50"/><?php else: ?>无<?php endif; ?></td>										<td><?php echo ($vo["url"]); ?></td>										<td class="textcenter">											<a href="<?php echo U('Home/other_edit',array('id'=>$vo['id']));?>">编辑</a> | 											<a href="javascript:void(0);" class="delete_row" parameter="id=<?php echo ($vo["id"]); ?>" url="<?php echo U('Home/other_del');?>">删除</a>										</td>									</tr><?php endforeach; endif; else: echo "" ;endif; ?>							<?php else: ?>								<tr><td class="textcenter red" colspan="5">列表为空！</td></tr><?php endif; ?>						</tbody>					</table>				</div>			</form>		</div><script type="text/javascript">
$(document).ready(function(){});</script>	</body>
</html>