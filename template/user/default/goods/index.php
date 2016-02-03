<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>出售中的商品 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/goods.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="./static/js/area/area.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">var load_url="<?php dourl('goods_load');?>",add_url="<?php dourl('delivery_modify');?>",delete_url="<?php dourl('delivery_delete');?>",copy_url="<?php dourl('delivery_copy');?>",edit_url="<?php dourl('delivery_amend');?>", soldout_url="<?php dourl('soldout'); ?>", allow_discount_url="<?php dourl('allow_discount'); ?>", page_content="selling_content", goods_group_url="<?php dourl('category'); ?>", edit_group_url="<?php dourl('edit_group'); ?>", save_qrcode_activity_url="<?php dourl('save_qrcode_activity'); ?>", get_qrcode_activity_url="<?php dourl('get_qrcode_activity'); ?>", del_qcode_activity_url="<?php dourl('del_qrcode_activity'); ?>", copy_product_url="<?php dourl('copy_product'); ?>", del_product_url="<?php dourl('del_product'); ?>", sort_url="<?php dourl('set_sort'); ?>";</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/goods.js"></script>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content js-app-main"></div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>