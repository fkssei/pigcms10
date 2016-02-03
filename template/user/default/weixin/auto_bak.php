<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title><?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/image_text.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript">var load_url="<?php dourl('load');?>";</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/auto.js"></script>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/bootstrap.css">
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/global.css">
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/app_weixin.css">
		<style type="text/css">
		.popover{
			display: block;
		}
		</style>
	</head>
	<body class="theme theme--blue">
		<?php include display('public:header');?>
		<div class="container">
			<div class="">
				<div class="app">
					<div class="app-inner clearfix">
						<div class="app-init-container">
							<nav class="ui-nav">
								<ul>
									<li class="active">
										<a href="/user.php?c=weixin&a=auto">关键词自动回复</a>
									</li>
									<li>
										<a href="/user.php?c=weixin&a=auto_reply">关注后自动回复</a>
									</li>
									<!--li>
										<a href="">消息托管</a>
									</li-->
									<li>
										<a href="/user.php?c=weixin&a=tail">小尾巴</a>
									</li>
								</ul>
							</nav>
							<div class="ui-box" style="position: relative;">
								<a href="javascript:;" class="js-nav-add-rule btn btn-success"  data-id="0">新建自动回复</a>
								<div class="js-list-search form--search">
									<input class="txt" type="text" placeholder="搜索" value="<?php echo $keyword;?>">
								</div>
							</div>
							<div class="app-init">
								<div class="app__content">
									<div class="weixin-normal">
										<div id="js-rule-container" class="rule-group-container">
										
										<!-- list rule -->
										<?php if($list) {?>
										<?php foreach ($list as $i => $value) {?>
											<div class="rule-group" data-id="<?php echo $value['pigcms_id'];?>">
												<div class="rule-meta">
													<h3>
														<em class="rule-id"><?php echo count($list) - $i;?>)</em>
														<span class="rule-name" id="rule-name-<?php echo $value['pigcms_id'];?>"><?php echo $value['name']; ?></span>
														<div class="rule-opts">
															<a href="javascript:;" class="js-edit-rule" data-id="<?php echo $value['pigcms_id'];?>">编辑</a>   
															<span>-</span>
															<a href="javascript:;" class="js-delete-rule" data-id="<?php echo $value['pigcms_id'];?>">删除</a>
														</div>
													</h3>
												</div>
												<div class="rule-body">
													<div class="long-dashed"></div>
													<div class="rule-keywords">
														<div class="rule-inner">
															<h4>关键词：</h4>
															<div class="keyword-container">
																<?php if ($value['keylist']) {?>
																<div class="info"></div>
																<div class="keyword-list">
																	<!-- list keyword -->
																	<?php foreach ($value['keylist'] as $key) {?>
																	<div class="keyword input-append" data-id="<?php echo $key['pigcms_id'];?>">
																		<a href="javascript:;" class="close--circle" data-id="<?php echo $key['pigcms_id'];?>">×</a>
																		<span class="value" id="keyword-value-<?php echo $key['pigcms_id'];?>" data-content="<?php echo $key['content'];?>"><?php echo $key['show_content'];?></span>
																		<span class="add-on">全匹配</span>
																	</div>
																	<?php }?>
																	<!-- list keyword -->
																</div>
																<?php } else {?>
																<div class="info">还没有任何关键字!</div>
																<div class="keyword-list"></div>
																<?php }?>
															</div>
															<hr class="dashed">
															<div class="opt">
																<a href="javascript:;" class="js-add-keyword" data-id="0">+ 添加关键词</a>
															</div>
														</div>
													</div>
													<div class="rule-replies">
														<div class="rule-inner">
															<h4>自动回复：
																<span class="send-method">随机发送</span>
															</h4>
															<div class="reply-container">
																<?php if ($value['vallist']) {?>
																<div class="info"></div>
																<ol class="reply-list">
																	<?php foreach ($value['vallist'] as $v) {?>
																	<li data-id="<?php echo $v['reply_id'];?>" id="reply-li-<?php echo $v['reply_id'];?>">
																		<div class="reply-cont">
																			<?php if ($v['reply_type'] == 0) {?>
																			<div class="reply-summary" data-content="<?php echo $v['content'];?>">
																				<span class="label label-success">文本</span>
																				<?php echo $v['show_content'];?>
																			</div>
																			<?php } elseif ($v['reply_type'] == 1) {?>
																			<div class="reply-summary" data-content="<?php echo $v['title'];?>">
																				<span class="label label-success">图文</span>
																				<?php echo $v['title'];?>
																			</div>
																			<?php } elseif ($v['reply_type'] == 3) {?>
																			<div class="reply-summary" data-content="<?php echo $v['title'];?>">
																				<span class="label label-success">商品</span>
																				<?php echo $v['title'];?>
																			</div>
																			<?php } elseif ($v['reply_type'] == 4) {?>
																			<div class="reply-summary" data-content="<?php echo $v['title'];?>">
																				<span class="label label-success">商品分类</span>
																				<?php echo $v['title'];?>
																			</div>
																			<?php } elseif ($v['reply_type'] == 5) {?>
																			<div class="reply-summary" data-content="<?php echo $v['title'];?>">
																				<span class="label label-success">微页面</span>
																				<?php echo $v['title'];?>
																			</div>
																			<?php } elseif ($v['reply_type'] == 6) {?>
																			<div class="reply-summary" data-content="<?php echo $v['title'];?>">
																				<span class="label label-success">微页面分类</span>
																				<?php echo $v['title'];?>
																			</div>
																			<?php } elseif ($v['reply_type'] == 7) {?>
																			<div class="reply-summary" data-content="<?php echo $v['title'];?>">
																				<span class="label label-success">店铺主页</span>
																				<?php echo $v['title'];?>
																			</div>
																			<?php } elseif ($v['reply_type'] == 8) {?>
																			<div class="reply-summary" data-content="<?php echo $v['title'];?>">
																				<span class="label label-success">会员主页</span>
																				<?php echo $v['title'];?>
																			</div>
																			<?php }?>
																		</div>
																		<div class="reply-opts">
																			<a class="js-edit-it" href="javascript:;" data-id="<?php echo $v['reply_id'];?>" data-cid="<?php echo $v['cid'];?>" data-type="<?php echo $v['reply_type'];?>">编辑</a> - <a class="js-delete-it" href="javascript:;" data-id="<?php echo $v['reply_id'];?>">删除</a>
																		</div>
																	</li>
																	<?php }?>
																</ol>
																<?php } else {?>
																<div class="info">还没有任何回复！</div>
																<ol class="reply-list"></ol>
																<?php }?>
															</div>
															<hr class="dashed">
															<div class="opt">
																<a class="js-add-reply add-reply-menu" href="javascript:;" data-id="0" data-type="0">+ 添加一条回复</a>
																<span class="disable-opt hide">最多十条回复</span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php }?>
											<?php } else {?>
											<div class="no-result">还没有自动回复，请点击新建。</div>
											<?php }?>
											<!-- list rule -->
										</div>
										<div class="rule-group-opts">
											<div class="pagenavi">
												<span class="total"><?php echo $page;?></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="notify-bar js-notify animated hinge hide"></div>
					</div>
				</div>
				<?php include display('sidebar');?>
			</div>
		</div>
	</body>
</html>