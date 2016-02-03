<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>支付订单</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script>
			$(function(){
				var orderData = <?php echo json_encode($orderData);?>;
				orderData = $.parseJSON(orderData);
				$.post('./saveorder.php',orderData,function(result){
					if(result.err_code){
						alert(result.err_msg);
						return false;
					}
					window.location.href = './pay.php?id='+result.err_msg+'&orderName=<?php echo $orderName; ?>&showwxpaytitle=1';
				},'json');
			})
		</script>
	</head>
	<body>
	</body>
</html>