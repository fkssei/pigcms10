<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="renderer" content="webkit">
		<title id="js-meta-title">创建店铺 | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		 <link rel="icon" href="./favicon.ico" />
		<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/base.css" />
		<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/app_team.css" />
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/area/area.min.js"></script>
		<script type="text/javascript">var has_company=<?php if($has_company) echo 'true';else echo 'false'; ?>, store_name_check="<?php dourl('store_name_check'); ?>";</script>
        <script type="text/javascript">
            var json_categories = '<?php echo $json_categories; ?>';
        </script>
		<script type="text/javascript" src="<?php echo TPL_URL; ?>js/create_store.js"></script>
	</head>
	<body>
		<div id="hd" class="wrap rel">
			<div class="wrap_1000 clearfix">
				<h1 id="hd_logo" class="abs" title="<?php echo $config['site_name'];?>">
					<?php if($config['pc_shopercenter_logo'] != ''){?>
						<a href="<?php dourl('store:select');?>">
							<img src="<?php echo $config['pc_shopercenter_logo'];?>" height="35" alt="<?php echo $config['site_name'];?>" style="height:35px;width:auto;max-width:none;"/>
						</a>
					<?php }?>
				</h1>
				<h2 class="tc hd_title">创建店铺</h2>
			</div>
		</div>
		<div class="container wrap_800" style="margin-top:60px;">
			<div class="content">
				<div class="app">
					<div class="app-init-container">
						<div class="team">
							<div class="wrapper-app">
								<div id="content" class="team-edit-create-shop">
									<div>
										<form class="form-horizontal" action="<?php dourl('create'); ?>" method="post">
											<fieldset>
												<?php if (!$has_company){ ?>
													<div class="control-group">
														<label class="control-label">公司名称：</label>
														<div class="controls">
															<input type="text" placeholder="如果没有公司，请填写自己的名字" name="company_name" class="company-name" value="" maxlength="30"/>
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">联系地址：</label>
														<div class="controls">
                                                            <span>
															<select id="s1" name="province" class="province">
																<option value="">选择省份</option>
															</select>
                                                            </span>
															<span>
                                                            <select id="s2" name="city" class="city">
																<option value="">选择城市</option>
															</select>
                                                            </span>
                                                            <span>
															<select id="s3" name="area" class="area">
																<option value="">选择地区</option>
															</select>
                                                            </span>
														</div>
													</div>
													<div class="control-group">
														<label class="control-label"></label>
														<div class="controls">
															<input type="text" placeholder="请填写具体地址" name="address" class="address" maxlength="50" value=""/>
														</div>
													</div>
												<?php } ?>
												<div class="control-group">
													<label class="control-label">店铺名称：</label>
													<div class="controls">
														<input type="text" name="store_name" class="store-name" value="" maxlength="30"/>
													</div>
												</div>
												<div class="control-group">
													<div class="controls">
														<div class="alert" style="margin:0;width:275px;">
															是买家直接看到的店铺的名字，认证后不可修改
														</div>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">主营类目：</label>
													<div class="controls">
														<div class="js-business">
															<div>
																<div class="widget-selectbox">
																	<span href="javascript:;" class="widget-selectbox-handle">
																		<span class="c-gray">请选择类目</span>
																	</span>
																	<ul class="widget-selectbox-content">
																		<?php foreach ($categories as $category) { ?>
																			<li data-id="2">
																				<label class="radio">
																					<input type="radio" name="sale_category_fid" class="sale-category" value="<?php echo $category['cat_id']; ?>" data="<?php echo $category['name']; ?>"/><?php echo $category['name']; ?>
																				</label>
																			</li>
																		<?php } ?>
																	</ul>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="control-group" style="display:none;">
													<div class="controls">
														<div class="alert" style="margin:0;width:275px;">
															店铺主营类目及类目细项，
															<a href="javascript:void(0);" target="_blank">请点此查看详情</a>
														</div>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">联系人姓名：</label>
													<div class="controls">
														<input type="text" name="contact_man" placeholder="请填写真实姓名" value="" class="contact-man"/>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">联系人手机号：</label>
													<div class="controls">
														<input type="text" class="js-mobile tel" name="tel" placeholder="请填写真实手机号，方便保持联系" value="" maxlength="11"/>
													</div>
												</div>
                                                <?php if ($is_check_mobile == 1) { ?>
													<div class="control-group">
														<label class="control-label">短信校验码：</label>
														<div class="controls">
															<div class="input-append">
																<input class="input-half sms-captcha" type="text" maxlength="6" name="sms_captcha"/><button type="button" class="btn js-fetch-sms btn-disabled" disabled="disabled">获取</button>
															</div>
														</div>
													</div>
                                                <?php } ?>
												<div class="control-group">
													<label class="control-label">联系人 QQ：</label>
													<div class="controls">
														<input type="text" placeholder="请填写您常用的QQ号码" name="qq" class="qq" value="" maxlength="15"/>
													</div>
												</div>
												<div class="control-group" style="margin-bottom:20px;">
													<div class="controls">
														<label class="checkbox readme">
															<input type="checkbox" class="js-readme" name="agreement">我已阅读并同意 <a href="<?php dourl('readme'); ?>" target="_blank"/><?php echo $readme_title; ?></a>
														</label>
													</div>
												</div>
												<div class="controls">
													<button class="btn btn-large btn-primary submit-btn" type="button" disabled=""><?php if (!$has_company){ ?>创建公司和店铺<?php }else{ ?>创建店铺<?php } ?></button>
												</div>
											</fieldset>
										</form>
									</div>
								</div>
								<div id="content-addition"></div>
							</div>
							<?php $show_footer_link = false; include display('public:footer');?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>