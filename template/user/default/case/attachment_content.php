<style type="text/css">
    .new_window {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="js-list-wrap list-wrap">
    <table class="table js-list-table list-table ui-box" style="padding:0px;">
        <thead class="tableFloatingHeaderOriginal">
            <tr>
				<th class="tb-pic">
					<div class="td-cont">
						<label class="checkbox inline th-check-all"><input type="checkbox" id="js-check-all"></label><span class="th-check-title">预览</span>
					</div>
				</th>
				<th class="tb-title">
					<div class="td-cont">文件名</div>
				</th>
				<th class="tb-time">
					<div class="td-cont">创建时间</div>
				</th>
				<th class="tb-opts opts">
					<div class="td-cont">操作</div>
				</th>
			</tr>
        </thead>
        <tbody>
			<?php foreach($get_result['attachment_list'] as $value){ ?>
				<tr pigcms-id="<?php echo $value['pigcms_id'];?>">
					<td class="tb-pic">
						<div class="td-cont">
							<label class="list-item-select">
								<input type="checkbox" class="js-check-toggle"/>
							</label>
							<?php if($value['type'] == 0){ ?>
								<a href="<?php echo $value['file'];?>" target="_blank">
									<img src="<?php echo $value['file'];?>">
								</a>
							<?php }else{ ?>
								<div class="voice-wrapper" data-voice-src="<?php echo $value['file'];?>">
									<span class="voice-player">
										<span class="arrow"></span>
										<span class="stop">点击播放</span>
										<span class="second"></span>
										<i class="play" style="display:none;"></i>
									</span>
								</div>
							<?php } ?>
						</div>
					</td>
					<td class="tb-title">
						<div class="td-cont">
							<a href="<?php echo $value['file'];?>" target="_blank" class="new_window" title="<?php echo $value['name'];?>"><?php echo $value['name'];?></a>
						</div>
					</td>
					<td class="tb-time">
						<div class="td-cont"><?php echo date('Y-m-d H:i:s',$value['add_time']);?></div>
					</td>
					<td class="tb-opts opts">
						<div class="td-cont">
							<a href="javascript:void(0)" class="js-copy-link">链接</a>
							<span>-</span>
							<a href="javascript:void(0)" class="js-rename">改名</a>
							<span>-</span>
							<a href="javascript:void(0);" class="js-delete">删除</a>
						</div>
					</td>
				</tr>
			<?php } ?>
		</tbody>
    </table>
	<div class="js-batch multi-ops left">
        <a href="javascript:void(0)" class="js-batch-btn btn">批量删除</a>
    </div>
    <div class="js-page-list pagenavi" style="margin-top:0px;"><?php echo $get_result['page'];?></div>
</div>