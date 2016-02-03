<div>
    <div class="js-list-filter-region clearfix ui-box" style="position:relative;">
        <div>
			<a href="#create" class="ui-btn ui-btn-primary">新建微页面分类</a>
            <div class="js-list-search ui-search-box">
                <input class="txt" type="text" placeholder="搜索" value=""/>
            </div>
        </div>
    </div>
    <div class="ui-box">
		<?php if($cat_list['cat_list']){ ?>
			<table class="ui-table ui-table-list" style="padding:0px;">
				<thead class="js-list-header-region tableFloatingHeaderOriginal">
					<tr>
						<th class="cell-40">标题</th>
						<th class="cell-20"><a href="javascript:;" data-orderby="feature_count">微页面数</a></th>
						<th class="cell-25"><a href="javascript:;" data-orderby="created_time">创建时间<span class="orderby-arrow desc"></span></a></th>
						<th class="text-right">操作</th>
					</tr>
				</thead>
				<tbody class="js-list-body-region">
					<?php foreach($cat_list['cat_list'] as $value){ ?>
						<tr cat-id="<?php echo $value['cat_id']?>">
							<td>
								<a href="#" target="_blank" class="new-window"><?php echo $value['cat_name'];?></a>
							</td>
							<td><?php echo $value['page_count'];?></td>
							<td><?php echo date('Y-m-d H:i:s',$value['add_time'])?></td>
							<td class="text-right">
								<a href="#edit/<?php echo $value['cat_id']?>">编辑</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js-delete">删除</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js-copy-link">链接</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php }else{ ?>
			<div class="js-list-empty-region"></div>
		<?php } ?>
    </div>
    <div class="js-list-footer-region ui-box">
        <div>
            <div class="pagenavi js-page-list"><?php echo $cat_list['page'];?></div>
        </div>
    </div>
</div>