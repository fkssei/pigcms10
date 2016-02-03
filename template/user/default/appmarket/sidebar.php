<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
<aside class="ui-sidebar sidebar">
	<nav>
		<ul>
			<li <?php if(in_array($select_sidebar,array('dashboard','statistics'))) echo 'class="active"';?>>
				<a class="ui-btn" href="<?php dourl('dashboard');?>">应用营销概况</a>
			</li>
        </ul>
        <h4>基础应用</h4>
		<ul>
			<li  <?php if(in_array($select_sidebar,array('present','statistics'))) echo 'class="active"';?>>
				<a href="<?php dourl('present');?>" >赠品</a>
			</li>
			<li <?php if(in_array($select_sidebar,array('reward','statistics'))) echo 'class="active"';?>>
				<a href="<?php dourl('reward');?>">满减/送</a>
			</li>
		</ul>
	</nav>
</aside>