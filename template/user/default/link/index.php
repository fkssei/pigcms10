<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>功能库</title>
<meta http-equiv="MSThemeCompatible" content="Yes" />
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script src="./static/js/layer/layer.min.js" type="text/javascript"></script>
<link href="<?php echo TPL_URL;?>css/link_style_2_common.css?BPm" rel="stylesheet" type="text/css" />
<link href="<?php echo TPL_URL;?>css/link_style.css" rel="stylesheet" type="text/css" />
<style>
body{line-height:180%;}
ul.modules {float:left;	width:33%;}
ul.modules li{padding:4px;margin:4px;background:#efefef;float:left;width:92%;}
ul.modules li div.mleft{float:left;width:40%}
ul.modules li div.mright{float:right;width:55%;text-align:right;}
ul.modules li.first {font-weight:bold;background:#D4D4D4;color:#fff}
</style>
</head>
<body style="background:#fff;padding:20px 20px;">
<div style="background:#fefbe4;border:1px solid #f3ecb9;color:#993300;padding:10px;margin-bottom:5px;">使用方法：点击“选中”直接返回对应模块外链代码，或者点击“详细”选择具体的内容外链</div>
<h4>请选择模块：</h4>
<ul class="modules">
<?php foreach($data[0] as $key=>$m){?>
	<?php if(!is_array($m)){ ?>
		<li class="first"><?php echo $m;?></li>
	<?php }else{ ?>
		<li>
			<div class="mleft"><?php echo $m['name'];?></div>
			<div class="mright">
				<?php if($m['sub']){ ?>
					<a href="?c=link&a=detailed&module=<?php if (!$m['linkurl']){ echo $m['module']; }else{ echo $m['linkurl']['a'];?>&method=<?php echo $m['linkurl']['module']; } ?>">详细</a>
				<?php } ?>
				<?php if($m['canselected']){ ?>
					<a href="###" onclick="returnHomepage('<?php echo $m['linkcode']; ?>')" style="margin-left:14px;">选中</a>
					<?php } ?>
			</div>
			<div style="clear:both"></div>
		</li>
	<?php }?>
<?php }?>
<div style="clear:both"></div>
</ul>

<ul class="modules">
<?php foreach($data[1] as $key=>$m){?>
	<?php if(!is_array($m)){ ?>
		<li class="first"><?php echo $m;?></li>
	<?php }else{ ?>
		<li>
			<div class="mleft"><?php echo $m['name'];?></div>
			<div class="mright">
				<?php if($m['sub']){ ?>
					<a href="?c=link&a=detailed&module=<?php if (!$m['linkurl']){ echo $m['module']; }else{ echo $m['linkurl']['a'];?>&method=<?php echo $m['linkurl']['module']; } ?>">详细</a>
				<?php } ?>
				<?php if($m['canselected']){ ?>
					<a href="###" onclick="returnHomepage('<?php echo $m['linkcode']; ?>')" style="margin-left:14px;">选中</a>
					<?php } ?>
			</div>
			<div style="clear:both"></div>
		</li>
	<?php }?>
<?php }?>
<div style="clear:both"></div>
</ul>

<ul class="modules">
<?php foreach($data[2] as $key=>$m){?>
	<?php if(!is_array($m)){ ?>
		<li class="first"><?php echo $m;?></li>
	<?php }else{ ?>
		<li>
			<div class="mleft"><?php echo $m['name'];?></div>
			<div class="mright">
				<?php if($m['sub']){ ?>
					<a href="?c=link&a=detailed&module=<?php if (!$m['linkurl']){ echo $m['module']; }else{ echo $m['linkurl']['a'];?>&method=<?php echo $m['linkurl']['module']; } ?>">详细</a>
				<?php } ?>
				<?php if($m['canselected']){ ?>
					<a href="###" onclick="returnHomepage('<?php echo $m['linkcode']; ?>')" style="margin-left:14px;">选中</a>
					<?php } ?>
			</div>
			<div style="clear:both"></div>
		</li>
	<?php }?>
<?php }?>
<div style="clear:both"></div>
</ul>
<script>
	function returnHomepage(url){
		$('.js-link-placeholder', parent.document).val(url).keyup();
		parent.layer.close(parent.layer.getFrameIndex(window.name));
	}
</script>
</body>
</html>