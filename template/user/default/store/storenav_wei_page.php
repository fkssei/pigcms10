<div class="modal-header">
    <a class="close js-news-modal-dismiss" data-dismiss="modal">×</a>
    <!-- 顶部tab -->
    <ul class="module-nav modal-tab">
        <li class="active"><a href="#js-module-feature" data-type="feature" class="js-modal-tab">微页面</a> |</li>
        <li class=""><a href="#js-module-category" data-type="category" class="js-modal-tab">微页面分类</a> |</li>
        <li class="link-group link-group-0" style="display:inline-block;"><a href="<?php dourl('wei_page'); ?>#create" target="_blank" class="new_window">新建微页面</a></li>
        <li class="link-group link-group-1" style="display:none;"><a href="<?php dourl('wei_page'); ?>" target="_blank" class="new_window">分类管理</a>
        </li>
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
								<span>标题</span> <a class="js-update" href="javascript:void(0);">刷新</a>
							</div>
						</th>
						<th class="time">
							<div class="td-cont">
								<span>创建时间</span>
							</div>
						</th>
						<th class="opts">
							<div class="td-cont">
								<form class="form-search">
									<div class="input-append">
										<input class="input-small js-modal-search-input" type="text"><a
											href="javascript:void(0);" class="btn js-fetch-page js-modal-search"
											data-action-type="search">搜</a>
									</div>
								</form>
							</div>
						</th>
					</tr>
				</thead>
				<!-- 表格数据区 -->
				<tbody>
					<?php foreach ($wei_pages as $wei_page) { ?>
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
									<button class="btn js-choose" href="<?php echo $config['wap_site_url'];?>/page.php?id=<?php echo $wei_page['page_id'];?>" data-id="<?php echo $wei_page['page_id'];?>" data-url="#" data-page-type="feature" data-title="<?php echo $wei_page['page_name']; ?>" data-alias="<?php echo $wei_page['page_id']; ?>">选取
									</button>
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
    <div class="pagenavi"><span class="total"><?php echo $page; ?></span></div>
</div>
