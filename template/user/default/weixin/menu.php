<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title><?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/jquery.sortable.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" charset="utf-8" src="./static/js/ueditor/ueditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="./static/js/ueditor/ueditor.all.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/menu.js"></script>
		<script type="text/javascript">var home_url = '<?php echo $home_url;?>', member_url = '<?php echo $member_url;?>', info_url = '<?php echo $info_url;?>';</script>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/image_text.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/app_weixin.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/app_shopmenu.css"/>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content">
							<div id="no-menu" class="no_result alert-pane hide">
								由于微信接口调整，您的公众号为订阅号，请先升级成服务号，方可使用自定义菜单！
								<a href="http://mp.weixin.qq.com/" target="_blank" class="new_window">去升级成服务号</a>
							</div>
							<div class="widget-app-board ui-box js-app-board hide" style="display:block;">
								<div class="widget-app-board-info">
									<h3>自定义菜单</h3>
									<div>
										<p>由于微信接口延迟，菜单修改后最长可能需要30分钟才会更新。如需即时查看，可先取消关注，再重新关注。</p>
									</div>
								</div>
							</div>
							<div class="app-design clearfix hide js-app-design" style="display: block;">
								<div class="app-preview">
									<div class="app-entry">
										<div class="app-header">
											<div class="app-field">
												<h5 class="title"><?php echo $weixin['nick_name']?></h5>
											</div>
										</div>
										<div class="app-fields">
											<div class="app-fields-inner js-show-list"></div>
										</div>
										<div class="app-footer nav-on-bottom style-2 js-show-nav">
											<input type="hidden" id="data_id"/>
											<div class="nav-menu clearfix has-menu-<?php echo count($lists);?>">
												<i class="menu-ico"></i>
												<?php
													if($lists){
														foreach ($lists as $l) {
												?>
													<div class="divide">&nbsp;</div>
													<div class="one" data-id="<?php echo $l['id'];?>">
														<a class="mainmenu js-mainmenu" href="javascript:void(0);">
															<?php if ($l['list']) {?>
															<i class="arrow-weixin"></i>
															<?php }?>
															<span class="mainmenu-txt" id="menu_<?php echo $l['id'];?>"><?php echo $l['title'];?></span>
														</a>
														<?php if ($l['list']) {?>
														<div class="submenu js-submenu">
															<span class="arrow before-arrow"></span>
															<span class="arrow after-arrow"></span>
															<ul>
																<?php foreach ($l['list'] as $k => $ll) {?>
																<?php if ($k) {?>
																<li class="line-divide"></li>
																<?php }?>
																<li id="menu_<?php echo $ll['id'];?>">
																	<a class="js-submneu-a" data-id="<?php echo $ll['id'];?>">
																	<?php echo $ll['title'];?>
																	</a>
																</li>
																<?php }?>
															</ul>
														</div>
														<?php }?>
													</div>
												<?php
														}
													}
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="app-sidebar">
									<div class="js-nav">
										<div class="js-first-nav-fields ui-sortable">
											<?php if ($lists) {?>
											<?php foreach ($lists as $lm) {?>
											<div class="nav-field js-first-field" data-id="<?php echo $lm['id'];?>">
												<div class="close-modal js-del-first" style="display: none;">×</div>
												<div class="field-wrap clearfix js-field-wrap">
													<div class="menu-titles">
														<div class="h4">一级菜单：</div>
														<ul class="first-nav-field">
															<li class="js-first-field-li js-menu-li clearfix <?php if(!(isset($lm['list']) && $lm['list'])) echo 'active';?>" data-id="<?php echo $lm['id'];?>" id="title_<?php echo $lm['id'];?>">
																<span class="h5"><?php echo $lm['title'];?></span>
																<span class="opts">
																<a href="javascript:void(0);" class="js-edit-first" data-title="<?php echo $lm['title'];?>">编辑</a>
																</span>
															</li>
														</ul>
														<div class="h4">二级菜单：</div>

														<ul class="sec-nav-field ui-sortable">
															<?php
															if(isset($lm['list']) && $lm['list']) {
																foreach ($lm['list'] as $i => $llm) {
															?>
															<li class="js-second-field js-menu-li clearfix <?php if (empty($i)) echo 'active';?>" data-id="<?php echo $llm['id'];?>" id="title_<?php echo $llm['id'];?>">
																<span class="h5"><?php echo $i + 1;?>. <?php echo $llm['title'];?></span>
																<span class="opts">
																<a href="javascript:void(0);" class="js-edit-second" data-title="<?php echo $llm['title'];?>">编辑</a> -
																<a href="javascript:void(0);" class="js-del-second">删除</a>
																</span>
															</li>
															<?php
																}
															}
															?>
														</ul>
														<div class="add-second-nav">
															<a href="javascript:void(0);" class="js-add-second">+ 添加二级菜单</a>
														</div>
													</div>
													<div class="menu-main">
														<div class="menu-content" style="min-height:<?php echo 80 + 38 * count($lm['list']);?>px">
															<div class="link-to js-link-to  <?php if(isset($lm['list']) && $lm['list']) echo 'hide';?>" data-id="<?php echo $lm['id'];?>" data-type="<?php echo $lm['type'];?>" id="content_<?php echo $lm['id'];?>">
																<?php if(isset($lm['list']) && $lm['list']) { ?>
																<span class="died-link-to" data-content="<?php echo $lm['content'];?>">使用二级菜单后主回复已失效。</span>
																<?php } else {?>
																	<?php if ($lm['type'] == 0) {?>
																	<?php echo $lm['content'];?>
																	<?php } elseif ($lm['type'] != 1) {?>
																	<a href="<?php echo $lm['url'];?>" target="_blank" class="new-window"><?php echo $lm['content'];?></a>
																	<?php
																		} else {
																			$contents = explode('|', $lm['content']);
																			if (count($contents) > 1) {
																	?>
																	<div class="ng ng-multiple">
																	<?php
																				foreach ($contents as $ii => $vv) {
																					$t = explode('#', $vv);
																	?>
																	<div class="ng-item">
																	<span class="label label-success">图文<?php echo $ii+1;?></span>
																	<div class="ng-title">
																	<a href="<?php echo $info_url . $t[0];?>" class="new_window" target="_blank"><?php echo $t[1];?></a>
																	</div>
																	</div>
																	<?php
																				}
																	?>
																	</div>
																	<?php
																			} else {
																				$t = explode('#', $contents[0]);
																	?>
																	<div class="ng ng-single">
																	<div class="ng-item">
																	<div class="ng-title">
																	<a href="<?php echo $info_url . $t[0];?>" target="_blank" class="new-window"><?php echo $t[1];?></a>
																	</div>
																	</div>
																	<div class="ng-item view-more">
																	<a href="<?php echo $info_url . $t[0];?>" target="_blank" class="clearfix new-window">
																	<span class="pull-left">阅读全文</span>
																	<span class="pull-right">&gt;</span>
																	</a>
																	</div>
																	</div>
																	<?php
																			}
																		}
																	}
																	?>
															</div>
															<?php
																$data_id = $lm['id'];
																if(isset($lm['list']) && $lm['list']) {
																	foreach ($lm['list'] as $index => $con) {
																		$index || $data_id = $con['id'];
															?>
															<div class="link-to js-link-to  <?php if ($index) { echo 'hide';}?>" data-id="<?php echo $con['id'];?>" data-type="<?php echo $con['type'];?>" id="content_<?php echo $con['id'];?>">
																<?php if ($con['type'] == 0) {?>
																<?php echo $con['content'];?>
																<?php } elseif ($con['type'] != 1) {?>
																<a href="<?php echo $con['url'];?>" target="_blank" class="new-window"><?php echo $con['content'];?></a>
																<?php
																	} else {
																		$contents = explode('|', $con['content']);
																		if (count($contents) > 1) {
																?>
																<div class="ng ng-multiple">
																<?php
																			foreach ($contents as $i => $v) {
																				$t = explode('#', $v);
																?>

																<div class="ng-item">
																<span class="label label-success">图文<?php echo $i+1;?></span>
																<div class="ng-title">
																<a href="<?php echo $info_url . $t[0];?>" class="new_window" target="_blank"><?php echo $t[1];?></a>
																</div>
																</div>

																<?php
																			}
																?>
																</div>
																<?php
																		} else {
																			$t = explode('#', $contents[0]);
																?>
																<div class="ng ng-single">
																<div class="ng-item">
																<div class="ng-title">
																<a href="<?php echo $info_url . $t[0];?>" target="_blank" class="new-window"><?php echo $t[1];?></a>
																</div>
																</div>
																<div class="ng-item view-more">
																<a href="<?php echo $info_url . $t[0];?>" target="_blank" class="clearfix new-window">
																<span class="pull-left">阅读全文</span>
																<span class="pull-right">&gt;</span>
																</a>
																</div>
																</div>
																<?php
																		}
																	}
																?>
															</div>
															<?php
																	}
																}
															?>
														</div>
														<div class="select-link js-select-link " data-id="<?php echo $data_id;?>">
															<span class="change-txt">回复内容：</span>
															<span class="main-link">
																<a class="js-modal-txt" data-type="txt" href="javascript:void(0);">一般信息</a> -
																<a class="js-modal-news" data-type="news" href="javascript:void(0);">图文素材</a> -
																<a class="js-modal-magazine" data-type="feature" href="javascript:void(0);">微页面</a> -
																<a class="js-modal-goods" data-type="goods" href="javascript:void(0);">商品</a> -
															</span>
															<div class="opts dropdown hover">
																<span class="dropdown-toggle" style="cursor:pointer;color:#434343">其他<i class="caret"></i></span>
																<ul class="dropdown-menu">
																	<li>
																		<a class="js-modal-homepage" data-type="homepage" data-alias="店铺主页" data-title="" data-url="<?php echo $home_url;?>" data-id="" href="javascript:void(0);">店铺主页</a>
																	</li>
																	<li>
																		<a class="js-modal-usercenter" data-type="usercenter" data-alias="会员主页" data-title="" data-url="<?php echo $member_url;?>" data-id="" href="javascript:void(0);">会员主页</a>
																	</li>
																	<li>
																		<a class="js-modal-links" data-type="link" href="javascript:void(0);">自定义外链</a>
																	</li>
																</ul>
															</div>
															<div class="editor-image js-editor-image"></div>
															<div class="hide editor-place js-editor-place"></div>
														</div>
													</div>
												</div>
											</div>
											<?php }?>
											<div class="add-first-nav">
												<a href="javascript:void(0);" class="js-add-first">+ 添加一级菜单</a>
											</div>
											<?php } else {?>
											<div class="add-first-nav no-data">
												 还没有设置任何菜单。<a href="javascript:void(0);" class="js-add-first">+ 添加一级菜单</a>
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="pin"></div>
								<div class="app-actions">
									<div style="position:relative;">
										<div class="form-actions text-center" style="position: static; bottom: 0px; width: 850px; box-sizing: border-box; z-index: 100;">
											<div>
												<input class="btn btn-primary js-submit" type="submit" value="提交修改" data-loading-text="请稍候...">
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
		<div class="hide editor-wrap js-editor-wrap" style="top:379px; left:1142.5px;">
		    <div id="js-editor" class="edui-default"></div>
		    <div class="btn-wrap" style="margin-top: 1px">
		        <input class="btn btn-primary js-btn-save" type="button" value="保 存">
		        <input class="btn js-btn-close" type="button" value="关 闭">
		    </div>
		</div>
	</body>
</html>