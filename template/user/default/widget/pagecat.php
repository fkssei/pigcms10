<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>微页面分类挂件</title>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('.js-modal iframe',parent.document).height($('body').height());
				$('.modal-header .close').live('click',function(){
					parent.login_box_close();
				});
				$('button.js-choose').live('click',function(){
					<?php if(empty($_GET['only'])){ ?>
						parent.login_box_after('<?php echo $_GET['number'];?>','pagecat',$(this).data('title'),'<?php echo $config['wap_site_url'];?>/pagecat.php?id='+$(this).data('id'));
					<?php }else{ ?>
						parent.login_box_after('<?php echo $_GET['number'];?>','pagecat',[$(this).data('id'),$(this).data('title')],'<?php echo $config['wap_site_url'];?>/pagecat.php?id='+$(this).data('id'));
					<?php } ?>
				});
				$('.js-page-list a').live('click',function(e){
					if(!$(this).hasClass('active')){
						var input_val = $('.js-modal-search-input').val();
						$('body').html('<div class="loading-more"><span></span></div>');
						$('body').load('<?php dourl('pagecat');?>',{p:$(this).data('page-num'),'keyword':input_val},function(){
							$('.js-modal iframe',parent.document).height($('body').height());
						});
					}
				});
				$('.js-modal-search').live('click',function(e){
					var input_val = $('.js-modal-search-input').val();
					$('body').html('<div class="loading-more"><span></span></div>');
					$('body').load('<?php dourl('pagecat');?>',{'keyword':input_val},function(){
						$('.js-modal iframe',parent.document).height($('body').height());
					});
					return false;
				});
			});
		</script>
	</head>
	<body style="background-color:#ffffff;">
		<div class="modal-header">
			<a class="close js-news-modal-dismiss">×</a>
			<!-- 顶部tab -->
			<ul class="module-nav modal-tab">
				<?php if(empty($_GET['only'])){ ?><li><a href="<?php dourl('page',array('number'=>$_GET['number']));?>">微页面</a> |</li><?php } ?>
				<li class="active"><a href="javascript:void(0);">微页面分类</a> |</li>
				<li><a href="<?php dourl('store:wei_page_category'); ?>" target="_blank" class="new_window">分类管理</a></li>
			</ul>
		</div>
		<div class="modal-body">
			<div class="tab-content">
				<div id="js-module-feature" class="tab-pane module-feature active">
					<?php if($is_system){ ?>
					<div style="font-size:12px;margin-bottom:15px;">您登录了管理员帐号，已显示网站所有列表。（如需只显示该店铺，请在后台退出后再点击下方的“刷新”按钮。<a href="./admin.php" target="_blank" style="color:blue;">后台链接</a>）</div>
					<?php } ?>
					<table class="table">
						<colgroup>
							<col class="modal-col-title">
							<col class="modal-col-time" span="2">
							<col class="modal-col-action">
						</colgroup>
						<!-- 表格头部 -->
						<thead>
							<tr>
								<th class="title" style="background-color:#f5f5f5;">
									<div class="td-cont">
										<span>标题</span> <a class="js-update" href="javascript:window.location.reload();">刷新</a>
									</div>
								</th>
								<th class="time" style="background-color:#f5f5f5;">
									<div class="td-cont">
										<span>创建时间</span>
									</div>
								</th>
								<th class="opts" style="background-color:#f5f5f5;">
									<div class="td-cont" style="padding:7px 0 3px 10px;">
										<form class="form-search" onsubmit="return false;">
											<div class="input-append">
												<input class="input-small js-modal-search-input" type="text"/><a href="javascript:void(0);" class="btn js-fetch-page js-modal-search">搜</a>
											</div>
										</form>
									</div>
								</th>
							</tr>
						</thead>
						<!-- 表格数据区 -->
						<tbody>
							<?php foreach($wei_page_categories as $wei_page_category){ ?>
								<tr>
									<td class="title" style="max-width:300px;">
										<div class="td-cont">
											<a target="_blank" class="new_window" href="<?php echo $config['wap_site_url'];?>/pagecat.php?id=<?php echo $wei_page_category['cat_id'];?>"><?php echo $wei_page_category['cat_name']; ?></a>
										</div>
									</td>
									<td class="time">
										<div class="td-cont">
											<span><?php echo date('Y-m-d H:i:s', $wei_page_category['add_time']); ?></span>
										</div>
									</td>
									<td class="opts">
										<div class="td-cont">
											<button class="btn js-choose" data-id="<?php echo $wei_page_category['cat_id'];?>" data-title="<?php echo $wei_page_category['cat_name']; ?>">选取</button>
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
			<div class="pagenavi js-page-list" style="margin-top:0;"><?php echo $page; ?></div>
		</div>
	</body>
</html>