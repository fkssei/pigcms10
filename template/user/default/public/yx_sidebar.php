<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
<aside class="ui-sidebar sidebar">
	<nav>
		<ul>
			<li <?php if(in_array($select_sidebar,array('dashboard','statistics'))) echo 'class="active"';?>>
				<a class="ui-btn" href="<?php dourl('appmarket:dashboard');?>">应用营销概况</a>
			</li>
        </ul>
        <h4>基础应用</h4>
		<ul>
			<li  <?php if(in_array($select_sidebar,array('present','statistics'))) echo 'class="active"';?>>
				<a href="<?php dourl('appmarket:present');?>" >赠品</a>
			</li>
			<li <?php if(in_array($select_sidebar,array('reward_index','statistics'))) echo 'class="active"';?>>
				<a href="<?php dourl('reward:reward_index');?>">满减/送</a>
			</li>
			<li <?php if(in_array($select_sidebar,array('coupon','statistics'))) echo 'class="active"';?>>
				<a href="<?php dourl('preferential:coupon');?>">优惠券</a>
			</li>
		</ul>
		<h4>营销功能</h4>
		<ul>
			<li <?php if($_GET['act'] == 'bargain') echo 'class="active"';?>>
				<a href="<?php dourl('wxapp:api',array('act'=>'bargain'));?>">砍价</a>
			</li>
			<li <?php if($_GET['act'] == 'seckill') echo 'class="active"';?>>
				<a href="<?php dourl('wxapp:api',array('act'=>'seckill'));?>">秒杀</a>
			</li>
			<li <?php if($_GET['act'] == 'crowdfunding') echo 'class="active"';?>>
				<a href="<?php dourl('wxapp:api',array('act'=>'crowdfunding'));?>">众筹</a>
			</li>
			<li <?php if($_GET['act'] == 'unitary') echo 'class="active"';?>>
				<a href="<?php dourl('wxapp:api',array('act'=>'unitary'));?>" >一元夺宝</a>
			</li>
			<li <?php if($_GET['act'] == 'cutprice') echo 'class="active"';?>>
				<a href="<?php dourl('wxapp:api',array('act'=>'cutprice'));?>" >降价拍</a>
			</li>
			<li <?php if($_GET['act'] == 'red_packet') echo 'class="active"';?>>
				<a href="<?php dourl('wxapp:api',array('act'=>'red_packet'));?>" >微信红包</a>
			</li>
			<!--li <?php if($_GET['act'] == 'present') echo 'class="active"';?>>
				<a href="<?php dourl('wxapp:api',array('act'=>'present'));?>" >我要送礼</a>
			</li-->
			<li <?php if($_GET['act'] == 'lottery') echo 'class="active"';?>>
				<a href="<?php dourl('wxapp:api',array('act'=>'lottery'));?>" >大转盘</a>
			</li>
			<li <?php if($_GET['act'] == 'guajiang') echo 'class="active"';?>>
				<a href="<?php dourl('wxapp:api',array('act'=>'guajiang'));?>" >刮刮卡</a>
			</li>
			<li <?php if($_GET['act'] == 'jiugong') echo 'class="active"';?>>
				<a href="<?php dourl('wxapp:api',array('act'=>'jiugong'));?>" >九宫格</a>
			</li>
			<li <?php if($_GET['act'] == 'luckyFruit') echo 'class="active"';?>>
				<a href="<?php dourl('wxapp:api',array('act'=>'luckyFruit'));?>" >幸运水果机</a>
			</li>
			<li <?php if($_GET['act'] == 'goldenEgg') echo 'class="active"';?>>
				<a href="<?php dourl('wxapp:api',array('act'=>'goldenEgg'));?>" >砸金蛋</a>
			</li>
		</ul>
	</nav>
</aside>