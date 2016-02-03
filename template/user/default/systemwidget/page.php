<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>微页面挂件</title>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript">
			$(function(){
				parent.art.dialog.list['widget-page'].size(650,$('body').height()+5);
				$('button.js-choose').live('click',function(){
					parent.main.widget_page_after('<?php echo $_GET['rand'];?>',$(this).data('id'),$(this).data('title'),'<?php echo $config['wap_site_url'];?>/page.php?id='+$(this).data('id'));
				});
				$('.js-page-list a').live('click',function(e){
					if(!$(this).hasClass('active')){
						var input_val = $('.js-modal-search-input').val();
						$('body').html('<div class="loading-more"><span></span></div>');
						$('body').load('<?php dourl('page');?>',{p:$(this).data('page-num'),'keyword':input_val},function(){
							parent.art.dialog.list['widget-page'].size(650,$('body').height()+5);
						});
					}
				});
				$('.js-modal-search').live('click',function(e){
					var input_val = $('.js-modal-search-input').val();
					$('body').html('<div class="loading-more"><span></span></div>');
					$('body').load('<?php dourl('page');?>',{'keyword':input_val},function(){
						parent.art.dialog.list['widget-page'].size(650,$('body').height()+5);
					});
					return false;
				});
			});
		</script>
	</head>
	<body style="background-color:#F3F3F3;">
		<div class="modal-body" style="padding:0 15px;">
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
									<div class="td-cont">
										<form class="form-search" onsubmit="return false;">
											<div class="input-append">
												<input class="input-small js-modal-search-input" type="text" placeholder="输入微页面标题搜索" style="width:120px;"/><a
													href="javascript:void(0);" class="btn js-fetch-page js-modal-search">搜</a>
											</div>
										</form>
									</div>
								</th>
							</tr>
						</thead>
						<!-- 表格数据区 -->
						<tbody>
							<?php foreach($wei_pages as $wei_page){ ?>
								<tr>
									<td class="title">
										<div class="td-cont">
											<a target="_blank" class="new_window" href="<?php echo $config['wap_site_url'];?>/page.php?id=<?php echo $wei_page['page_id'];?>"><?php echo $wei_page['page_name']; ?></a>
										</div>
									</td>
									<td class="time">
										<div class="td-cont">
											<span><?php echo date('Y-m-d H:i:s', $wei_page['add_time']); ?></span>
										</div>
									</td>
									<td class="opts">
										<div class="td-cont">
											<button class="btn js-choose" data-id="<?php echo $wei_page['page_id'];?>" data-title="<?php echo $wei_page['page_name']; ?>">选取</button>
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