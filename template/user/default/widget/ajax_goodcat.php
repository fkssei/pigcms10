<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
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
										<input class="input-small js-modal-search-input" type="text" style="border-radius:4px 0px 0px 4px;" value="<?php echo $_POST['keyword']?>"/><a href="javascript:void(0);" class="btn js-fetch-page js-modal-search" style="border-radius:0 4px 4px 0;margin-left:0px;">搜</a>
									</div>
								</form>
							</div>
						</th>
					</tr>
				</thead>
				<!-- 表格数据区 -->
				<tbody>
					<?php foreach($product_groups as $group){ ?>
						<tr>
							<td class="title" style="max-width:300px;">
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
	<div class="pagenavi js-page-list" style="margin-top:0;"><?php echo $page; ?></div>
</div>