<style>
.attachment_detail {width:100px; height:100px; border:1px solid gray; float:left; margin-right:10px;}
.attachment_detail img {cursor:pointer;}
</style>
<div class="appraise_li-list">
	<dl>
		<?php 
		foreach ($comment_list as $comment) {
		?>
			<dd>
				<div class="appraise_li-list_img">
					<div class="appraise_li-list_icon"><img src="<?php echo $user_list[$comment['uid']]['avatar'] ?>" /></div>
					<p><?php echo anonymous(htmlspecialchars($user_list[$comment['uid']]['nickname'])) ?></p>
				</div>
				<div class="appraise_li-list_right" >
					<div class="appraise_li-list_top">
						<div class="appraise_li-list_top_icon <?php echo $comment['score'] >= 4 ? 'manyi' : ($comment['score'] == 3 ? 'yiban' : 'bumanyi') ?>">
							<span><?php echo $comment['score'] >= 4 ? '满意' : ($comment['score'] == 3 ? '一般' : '不满意') ?></span>
						</div>
						<?php 
						if (isset($comment_tag_list[$comment['id']])) {
							foreach ($comment_tag_list[$comment['id']] as $comment_tag) {
						?>
								<div class="list_top_txt"><?php echo $comment_tag['name'] ?></div>
						<?php
							}
						}
						?>
					</div>
					<div class="appraise_li-list_txt"><?php echo nl2br(htmlspecialchars($comment['content'])) ?></div>
					<div class="appraise_li-list_data"><?php echo date('Y-m-d', $comment['dateline']) ?></div>
					<div style="width:100%; height:auto; clear:both;" class="attachment_list" data-rel="group_<?php echo $tab ?>_<?php echo $comment['id'] ?>">
						<?php 
						foreach ($comment['attachment_list'] as $attachment) {
						?>
							<div class="attachment_detail">
								<table>
									<tr>
										<td style="width:98px; height:98px;">
											<a href="<?php echo $attachment['file'] ?>" rel="group_<?php echo $tab ?>_<?php echo $comment['id'] ?>" title="发布时间：<?php echo date('Y-m-d H:i', $comment['dateline']) ?>">
												<img src="<?php echo $attachment['file'] ?>" style="max-width:98px; max-height:98px;" alt="" />
											</a>
										</td>
									</tr>
								</table>
							</div>
						<?php 
						}
						?>
					</div>
				</div>
			</dd>
		<?php 
		}
		?>
	</dl>
</div>
<?php 
if ($pages) {
?>
	<style>
	.page_list .active{margin-right:5px; width:auto; padding:0 12px; height:36px; border:1px solid #00bb88; cursor:pointer; background:#00bb88;display:inline-block; color:white}
	.page_list .fetch_page {margin-right:5px; width:auto; padding:0 15px; height:36px;border:1px solid #00bb88; cursor:pointer;display:inline-block;}
	.page_list .fetch_page:hover {background:#00bb88; color:white;}
	</style>
	<div class="page_list">
		<dl>
			<?php echo $pages ?>
			<?php 
			if ($total_pages > 1) {
			?>
				<dt>
					<form onsubmit="return false;">
						<span>跳转到:</span>
						<input name="page" class="js-jump-page" value="" />
						<button class="js-jump-page-btn">GO</button>
					</form>
				</dt>
			<?php 
			}
			?>
		</dl>
	</div>
<?php 
}
?>