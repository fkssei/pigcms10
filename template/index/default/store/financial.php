<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<div class="fenxiao" style="border:0px; border-bottom:1px; ">
	<ul>
		<?php 
		foreach ($financial_record_list as $financial_record) {
		?>
			<li>
				<div class="fenxiao_img"> <img src="<?php echo $financial_record['logo'] ?>" /> </div>
				<div class="fenxiao_txt">
					<div class="fenxiao_top"><?php echo $financial_record['name'] ?></div>
					<div class="fenxiao_bottom">
						<div class="fenxiao_lirun">分销获得<?php echo $financial_record['profit'] ?>元利润</div>
						<div class="fenxiao_time"><?php echo date('Y-m-d H:i:s', $financial_record['add_time']) ?></div>
					</div>
				</div>
			</li>
		<?php 
		}
		?>
	</ul>
	<?php 
	if ($pages) {
	?>
		<style>
		.page_list .active{margin-right:5px; width:auto; padding:0 12px; height:36px; border:1px solid #00bb88; cursor:pointer; background:#00bb88;display:inline-block; color:white}
		.page_list .fetch_page {margin-right:5px; width:auto; padding:0 15px; height:36px;border:1px solid #00bb88; cursor:pointer;display:inline-block;}
		.page_list .fetch_page:hover {background:#00bb88; color:white;}
		</style>
		<div class="page_list js-financial-page">
			<dl>
				<?php echo $pages ?>
				<?php 
				if ($total_pages > 1) {
				?>
					<dt>
						<form onsubmit="return false;">
							<span>跳转到:</span>
							<input name="page" class="js-jump-page" value="" />
							<button class="js-jump-financial-page-btn">GO</button>
						</form>
					</dt>
				<?php 
				}
				?>
				&nbsp;&nbsp;
			</dl>
		</div>
	<?php 
	}
	?>
</div>