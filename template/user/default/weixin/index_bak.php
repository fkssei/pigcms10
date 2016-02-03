<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title><?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/pc.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/image_text.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/source_list.js"></script>
		
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
									<li id="js-nav-list-index" class="active">
										<a href="">图文</a>
									</li>
									<!--li>
										<a href="">高级图文</a>
									</li-->
								</ul>
							</nav>
							<div class="app__content js-app-main">
								<div>
									<div class="js-list-filter-region clearfix ui-box" style="position: relative;">
										<div>
											<a href="javascript:;" class="ui-btn ui-btn-primary js-create-template">新建图文</a>
										</div>
									</div>
									<div class="ui-box">
									    <table class="ui-table ui-table-list" style="padding: 0px;">
									        <thead class="js-list-header-region tableFloatingHeaderOriginal">
										        <tr>
											        <th class="cell-25">标题</th>
													<th class="cell-12"><a href="javascript:;" data-orderby="created_time">创建时间<span class="orderby-arrow desc"></span></a></th>
													<th class="cell-12"><a href="javascript:;" data-orderby="last_send_time">上次发送</a></th>
													<th class="cell-25 text-right">操作</th>
												</tr>
											</thead>
											<thead class="js-list-header-region tableFloatingHeader" style="display: none;">
												<tr>
													<th class="cell-25">标题</th>
													<th class="cell-12"><a href="javascript:;" data-orderby="created_time">创建时间<span class="orderby-arrow desc"></span></a></th>
													<th class="cell-12"><a href="javascript:;" data-orderby="last_send_time">上次发送</a></th>
													<th class="cell-25 text-right">操作</th>
												</tr>
											</thead>
									        <tbody class="js-list-body-region">
									        <?php foreach ($list as $key => $value) {?>
										        <tr>
											        <td>
														<div class="ng">
															<?php foreach ($value['list'] as $i => $v) {?>
															<div class="ng-item">
																<div class="td-cont with-label">
																	<span class="label label-success">图文</span>
																	<div class="text">
																		<a href="/alias=<?php echo $v['pigcms_id'];?>" target="_blank" class="new-window" title="<?php echo $v['title']?>"><?php echo $v['title']?></a>
																	</div>
																</div>
															</div>
															<?php 
																}
																if ($i < 1) {
															?>
															<div class="ng-item view-more">
																<a href="?alias=<?php echo $value[0]['pigcms_id'];?>" target="_blank" class="td-cont clearfix new-window">
																	<span class="pull-left">阅读全文</span>
																	<span class="pull-right">&gt;</span>
																</a>
															</div>
															<?php }?>
														</div>
													</td>
													<td><?php echo date('Y-m-d H:i:s', $value['dateline']);?></td>
													<td>无</td>
													<td class="text-right">
														<?php 
															if ($value['type']) {
														?>
														<a href="/user.php?c=weixin&a=multi&pigcms_id=<?php echo $key;?>">编辑</a>
														<?php  } else {?>
														<a href="/user.php?c=weixin&a=one&pigcms_id=<?php echo $key;?>">编辑</a>
														<?php } ?>
														<span>-</span>
														<a href="javascript:void(0);" class="js-delete" data-id="<?php echo $key;?>">删除</a>
													</td>
												</tr>
												<?php }?>
											</tbody>
										</table>
										<div class="js-list-empty-region"></div>
									</div>
									<div class="js-list-footer-region ui-box">
										<div>
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