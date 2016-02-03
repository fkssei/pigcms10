<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
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
										<input class="input-small js-modal-search-input" type="text" value="<?php echo $_POST['keyword'];?>" placeholder="输入微页面标题搜索" style="width:120px;"/><a
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