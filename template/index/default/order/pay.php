<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>付款-<?php echo $config[ 'site_name'];?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/style.css" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/index.css" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/cart.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $config['site_url'] ?>/static/css/jquery.ui.css" />
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script src="<?php echo TPL_URL;?>js/index2.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="js/DD_belatedPNG_0.0.8a.js" mce_src="js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<style type="text/css"> 
body{ behavior:url("csshover.htc");}
</style>
<![endif]-->

</head>
<body>
<?php include display( 'public:header_order');?>
<div class="order_content">
	<div class="Breadcrumbs"> 您的位置：<a href="/">首页</a> &gt; <a href="<?php echo url('account:index') ?>">会员中心</a> &gt; <a href="<?php echo url('account:order') ?>" class="current">我的订单</a> </div>
	<div class="steps six_steps">
		<ul class="part2">
			<li class="first"><hr></li>
			<li class="icon"><span class="yellow_30_30"></span></li>
			<li class="cur_last"><hr></li>
			<li class="cur_last "><hr></li>
			<li class="icon"><span class="yellow_30_30"></span></li>
			<li class="cur_last "><hr></li>
			<li class="cur_last "><hr></li>
			<li class="icon"><span class="yellow_30_30"></span></li>
			<li class="cur_last"><hr></li>
		</ul>
		<ul class="part3">
			<li>
				<span>购物车</span><br>
			</li>
			<li>
				<span class="no_rea"><span>确认收货地址</span><br></span>
			</li>
			<li>
				<span class="no_rea"><span>支付</span><br></span>
			</li>
		</ul>
	</div>
	<div class="zhifu_content">
		<div class="pay-info">
			<ul>
				<li>
					<label>订单编号</label>
					<span class="f14"><?php echo $order['order_no_txt'] ?></span>
				</li>
				<?php 
				if ($order['payment_method'] == 'codpay') {
					if ($order['shipping_method'] == 'selffetch') {
				?>
					<li style="padding:0;">
						<label>货到付款</label>
						<span class="f14">
							此订单为货到付款，请<?php echo $store['buyer_selffetch_name'] ? $store['buyer_selffetch_name'] : '到店自提' ?>后，进行付款。
						</span>
					</li>
				<?php 
					} else {
				?>
						<li style="padding:0;">
							<label>货到付款</label>
							<span class="f14">
								此订单为货到付款，请收到货时，直接将货款付给送货员。
							</span>
						</li>
				<?php
					}
				}
				?>
				<li style="padding:0;">
					<label>应付总额</label>
					<span class="money">
						¥ 
						<?php
						$order['total'] = $order['total'] + 0;
						if (!empty($order['total'])) {
							echo $order['total'];
						} else {
							echo $order['sub_total'];
						}?>
					</span>
				</li>
			</ul>
		</div>
		<?php 
		if ($order['payment_method'] != 'codpay') {
		?>
			<div class="pay-code">
				<h1>扫码支付</h1>
				<ul class="pay-code-list">
					<li class="code">
						<img  src="<?php echo $config['site_url'];?>/static/images/blank.gif"class="qrcode_img">
						<div class="txt">
							微信扫一扫<br>
							轻松完成支付
						</div>
						<div class="loading"></div>
					</li>
					<li class="pay-active">
						<button class="orangeBtn large" id="submitButton" type="button">下一步</button>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="checkPayTxt"></span>
						<div style="padding:50px 0 0 0;color:#666;"><b class="icon">¥</b>如需改价，请联系卖家改价后再扫描二维码确认支付。</div>
					</li>
				</ul>
			</div>
		<?php 
		}
		?>
	</div>
</div>
<?php include display( 'public:footer');?>
<?php 
if ($order['payment_method'] != 'codpay') {
?>
	<script type="text/javascript">
		$(function(){
			getPayUrl();
		});
		function getPayUrl(){
			$('.pay-code .code .loading').html('二维码正在加载中，请稍候...');
			$.post('<?php dourl('recognition:see_tmp_qrcode',array('qrcode_id'=>300000000+$order['order_id']));?>',function(result){
				if(result.err_code != 0){
					$('.pay-code .code .loading').html('<a href="javascript:getPayUrl();" style="color:red;text-decoration:none;">点击重新获取二维码</a>');
					alert(result.err_msg+'\r\n请点击重新获取二维码');
				}else{
					if(result.err_msg.error_code != 0){
						$('.pay-code .code .loading').html('<a href="javascript:getPayUrl();" style="color:red;text-decoration:none;">点击重新获取二维码</a>');
						alert(result.err_msg+'\r\n请点击重新获取二维码');
					}else{
						$('.pay-code .code .loading').html('');
						$('.pay-code .code .qrcode_img').attr('src',result.err_msg.ticket);
					}
				}
			});
			setInterval("checkPay(0)", 10000);
			$('#submitButton').click(function(){
				$('#checkPayTxt').html('正在检测订单是否已付款，请稍等...');
				//checkPay(1);
			});
		}
		function next(){
			if ($('input[name="payChannel"]:checked').length < 1) {
				alert("请选择一个支付渠道！");
				return;
			}
			$('#cashierForm').submit();
		};
	
		//轮询查询支付状态
		checkPayNow = false;
		function checkPay(type){
			if(type == 1){
				checkPayNow = true;
				$('#checkPayTxt').html('正在检测订单是否已付款，请稍等...');
			}
			if(checkPayNow == false){
				$.getJSON("<?php dourl('order:check',array('order_id'=>$order['order_no_txt']));?>",function(result){
					checkPayNow = false;
					if(result.err_msg == 'ok'){
						window.location.href = "<?php dourl('order:detail',array('order_id'=>$order['order_no_txt']));?>";
					}
				});
			}
		}
	</script>
<?php 
}
?>
</body>
</html>
