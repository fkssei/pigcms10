<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title><?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<script type="text/javascript">var load_url="<?php dourl('load');?>";</script>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/wxpay.js"></script>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/image_text.css" type="text/css" rel="stylesheet"/>
		<style type="text/css">
		.popover{
			display: block;
		}
		</style>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app" style="margin-top:15px;">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content js-app-main">
							<div>
								<div class="page-payment">
									<div class="payment-block-wrap js-payment-block-wrap js-wxpay-region open">
										<div>
											<div class="payment-block">
												<div class="payment-block-header js-wxpay-header-region">
													<h3>微信支付</h3>
													<label class="ui-switcher ui-switcher-small js-switch pull-right ui-switcher-<?php if($wxpay){?>on<?php }else{ ?>off<?php } ?>"></label>
												</div>
												<div class="payment-block-body js-wxpay-body-region">
													<div>
														<form id="wx_form">
															<h4>设置自有微信支付，买家使用微信支付付款购买商品时，货款将直接进入您微信支付对应的财付通账户。</h4>
															<div class="form-horizontal">
																<div class="control-group">
																	<div class="controls">
																		<p class="ui-message-warning pay-test-status">
																			注意：使用自有微信支付，货款直接入账至您的财付通账户，由财付通自动扣除每笔0.6%交易手续费。
																			订单如需退款，请自行通过财务通后台手动完成退款操作，并在订单中做“标记退款”。
																		</p>
																	</div>
																</div>
																<div class="control-group">
																	<label class="control-label"><em class="required">*</em>商户号：</label>
																	<div class="controls">
																		<input class="span4" type="text" name="wxpay_mchid" value="<?php echo $weixin_bind_info['wxpay_mchid']?>" maxlength="10"/>
																	</div>
																</div>
																<div class="control-group">
																	<label class="control-label"><em class="required">*</em>密钥：</label>
																	<div class="controls">
																		<input class="span4" type="text" name="wxpay_key" value="<?php echo $weixin_bind_info['wxpay_key']?>" maxlength="32"/>
																	</div>
																</div>
																<div class="control-group">
																	<label class="control-label">微信支付状态：</label>
																	<div class="controls">
																		<label class="radio inline">
																			<input type="radio" name="wxpay_test" value="0" <?php if($weixin_bind_info['wxpay_test'] == 0){ ?>checked="checked"<?php } ?>/>全网支付已发布
																		</label>
																		<label class="radio inline">
																			<input type="radio" name="wxpay_test" value="1" <?php if($weixin_bind_info['wxpay_test'] == 1){ ?>checked="checked"<?php } ?>/>测试支付中
																		</label>
																		<p class="ui-message-warning pay-test-status js-pay-all">																	由于微信支付流程限制，该选项需由您进行设置。如您的微信支付已通过微信的审核并开通，请选择“全网支付已发布”状态，以保证粉丝能够在你的店铺正常使用微信支付进行交易。否则，请选择“测试支付中”；
																		</p>
																	</div>
																</div>
																<div class="control-group">
																	<label class="control-label">微信网页授权：</label>
																	<div class="controls">
																		<label class="checkbox inline">
																			<input name="wx_domain_auth" value="1" type="checkbox" checked=""/>授权回调页面域名已设置为 “<?php echo getUrlDomain($config['site_url']);?>”
																		</label>
																	</div>
																</div>
																<div class="control-group">
																	<div class="controls">
																		<a href="javascript:;" class="ui-btn ui-btn-primary js-save">保存</a>
																	</div>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
	</body>
</html>