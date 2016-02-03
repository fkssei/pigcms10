<div id="J_PopSearch" class="searchbox" style="display: none; background-color: rgb(255, 255, 255);">
	<div class="sb-search">
		<form action="" onsubmit="return false">
			<div id="s-combobox-199" class="s-combobox s-combobox-hover">
				<div class="s-combobox-input-wrap">
					<input type="search" id="topSearchTxt" name="keyword" value="" class="s-combobox-input"  placeholder="请输入搜索文字">
				</div>
			</div>
			<input type="submit"><input type="reset" class="j_PopSearchClear"><input type="hidden" name="type" value="p">
		</form>
		<button class="close j_CloseSearchBox"></button>
	</div>
</div>
<div id="ks-component" class="s-popupmenu s-menu s-popupmenu-hidden s-menu-hidden s-popupmenu-hover s-menu-hover" role="menu" style="display:none;-webkit-user-select: none; left: 37px; top: 44px; width: 535.799999237061px; visibility: visible; overflow: hidden;" aria-pressed="false">
	<div id="ks-content-ks-component" class="s-popupmenu-content s-menu-content" style="-webkit-transition: -webkit-transform 0ms; transition: -webkit-transform 0ms; -webkit-transform-origin: 0px 0px; -webkit-transform: translate3d(0px, 0px, 0px);">
		<?php if($hot_keyword && false){ ?>
		<div id="ks-component2187" class="s-hqHd-menuitem ks-component-child310" role="menuitem" style="-webkit-user-select: none;">
			<div class="s-mi-hqHd">
				<i class="sh"></i><span>热门搜索</span>
			</div>
			<?php foreach ($hot_keyword as  $value) { ?>
			<div class="s-mi-hq j_h5Suggest <?php if($value['type'] == 1){echo 'is_hot';}?>">
				<span class="s-mi-cont-key"><em><a href="<?php echo $value['url'];?>" title="<?php echo $value['name'];?>"><?php echo $value['name'];?></a></em></span>
			</div>
			<?php  } ?>
		</div>
		<?php  } ?>
	</div>
</div>