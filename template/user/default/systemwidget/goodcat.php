<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>商品分组挂件</title>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('.js-modal iframe',parent.document).height($('body').height());
				$('.modal-header .close').click(function(){
					parent.login_box_close();
				});
				$('button.js-choose').click(function(){
					<?php if(empty($_GET['only'])){ ?>
						parent.login_box_after('<?php echo $_GET['number'];?>','goodcat',$(this).data('title'),'<?php echo $config['wap_site_url'];?>/goodcat.php?id='+$(this).data('id'));
					<?php }else{ ?>
						parent.login_box_after('<?php echo $_GET['number'];?>','goodcat',[$(this).data('id'),$(this).data('title')],'<?php echo $config['wap_site_url'];?>/goodcat.php?id='+$(this).data('id'));
					<?php } ?>
				});
			});
		</script>
	</head>
	<body style="background-color:#ffffff;">
		<div class="modal-header">
			<a class="close js-news-modal-dismiss">×</a>
			<!-- 顶部tab -->
			<ul class="module-nav modal-tab">
				<?php if(empty($_GET['only'])){ ?><li><a href="<?php dourl('good',array('number'=>$_GET['number']));?>">已上架商品</a> |</li><?php } ?>
				<li class="active"><a href="javascript:void(0);">商品分组</a> |</li>
				<li><a href="<?php dourl('goods:category'); ?>" target="_blank">分组管理</a></li>
			</ul>
		</div>
		<div class="modal-body">
			<div class="tab-content">
				<div id="js-module-feature" class="tab-pane module-feature active">
					<table class="table">
						<colgroup>
							<col class="modal-col-title">
							<col class="modal-col-time" span="2">
							<col class="modal-col-action">
						</colgroup>
						<!-- 表格头部 -->
						<thead>
							<tr>
								<th class="title">
									<div class="td-cont">
										<span>标题</span> <a class="js-update" href="javascript:window.location.reload();">刷新</a>
									</div>
								</th>
								<th class="time">
									<div class="td-cont">
										<span>创建时间</span>
									</div>
								</th>
								<th class="opts">
									<!--div class="td-cont">
										<form class="form-search">
											<div class="input-append">
												<input class="input-small js-modal-search-input" type="text"><a
													href="javascript:void(0);" class="btn js-fetch-page js-modal-search"
													data-action-type="search">搜</a>
											</div>
										</form>
									</div-->
								</th>
							</tr>
						</thead>
						<!-- 表格数据区 -->
						<tbody>
							<?php foreach($product_groups as $group){ ?>
								<tr>
									<td class="title">
										<div class="td-cont">
											<a target="_blank" class="new_window" href="<?php echo $config['wap_site_url'];?>/goodcat.php?id=<?php echo $group['group_id'];?>"><?php echo $group['group_name']; ?></a>
										</div>
									</td>
									<td class="time">
										<div class="td-cont">
											<span><?php echo date('Y-m-d H:i:s', $group['add_time']); ?></span>
										</div>
									</td>
									<td class="opts">
										<div class="td-cont">
											<button class="btn js-choose" data-id="<?php echo $group['group_id'];?>" data-title="<?php echo $group['group_name']; ?>">选取</button>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div style="display:none;" class="js-confirm-choose pull-left">
				<input type="button" class="btn btn-primary" value="确定使用">
			</div>
			<div class="pagenavi" style="margin-top:0;"><?php echo $page; ?></div>
		</div>
	</body>
</html>