<?php if(MODULE_NAME == 'account' && ACTION_NAME == 'login'){return ;}?>
<div  class="chenpage" style="display:none">

<?php  

if(!empty($location_qrcode)){
?>
<script>

var time_flag=1;
var locationInterval;
	
<?php if(MODULE_NAME == 'index'){ ?>
	$(function(){
	<?php 
		if(!$_SESSION['user'] ) {
			if(MODULE_NAME == 'index'){?>
			setting_location();	
	<?php
			}
		}
	?>
	
		locationInterval = window.setInterval(function(){
		check_location_status();
			time_flag++;
		},3000);
	})
<?php }?>


function check_location_status(){
	$.getJSON("<?php echo url('wxlocation:check_status');?>",{qrcode_id:'<?php echo $location_qrcode[id];?>'},function(res){
		//alert(res.errmsg);
		if(res.errmsg == 'scan_ok'){
			$('.tankuang_txt_left').html('您已经扫码二维码，请发送您的<br/>位置！');
		}else if(res.errmsg == 'location_ok'){
			$('.tankuang_txt_left').html('获取位置并登录成功,<br/>页面正在跳转！');
			clearInterval(locationInterval);
			location.reload();
		}else if(res.errmsg == 'false'){
			clearInterval(locationInterval);
		}
	});
}

function setting_location() {

	$(".tankuang_content").hide();
	$(".chenpage").show();
	$(".tankuang4").show();
}
</script>

<?php
}
?>
<style>.tankuang1 .tanchuang_guanbi{bottom:215px;}

.tankuang1 .tankuang_title {
    color: #feed61;
    font-size: 30px;
    line-height: 33px;
    margin-bottom: 30px;
}
</style>


<script>
$(window).resize(function(){
	centerWindow($(".tankuang_content"));
})
</script>


<div class="tankuang_content tankuang4 popup1 hqwz" style="display:none">
		<div class="shouji animated bounceInDown"><img src="<?php echo TPL_URL;?>images/tankuang_4_20.png">
			<div class="tankuang_erweima animated zoomIn"><img src="<?php echo TPL_URL;?>images/wx.gif"></div>
		</div>
		<div class="shaoma animated fudong2 "><img src="<?php echo TPL_URL;?>images/tankuang_4_09.png"></div>
		<div class="tankuang_txt animated zoomInLeft">
			<div class="tankuang_txt_title">”获取我的位置“</div>
			<p>
			<div class="tankuang_txt_left">获取位置后可以查看离你<span>最近</span>的<br/>店铺和商品</div>
			<p>
			<!-- 
			<div class="tankuang_txt_left">参与人数：</div>
			<div class="tankuang_txt_right"><span>76人</span></div> -->
		</div>
		<div class="tankuang_button animated bounceInUp"><img src="<?php echo TPL_URL;?>images/tankuang1_03.png" /></div>
		<div class="dizuo "><img src="<?php echo TPL_URL;?>images/tankuang_4_49.png"></div>
		<div  class="xiaoren  animated slideInRight"><img src="<?php echo TPL_URL;?>images/tankuang_4_30.png"></div>
	</div>

	<div class="tankuang_content tankuang1 tankuang_button_xianshi myfx popup2">
		<div class="shouji animated fadeInDown"><img src="<?php echo TPL_URL;?>images/tankuang1_06.png">
			<div class="erweima animated rotateIn"><img class="wx_image" src="<?php echo TPL_URL;?>images/tankuang_1_06.png"></div>
			<div class="shaoma animated fadeIn">扫描二维码即可分销</div>
		</div>
		<div class="dizuo animated fadeInUp"><img src="<?php echo TPL_URL;?>images/tankuang_1_19.png"></div>
		<div class="tankuang_list animated lightSpeedIn">
			<div class="tankuang_title"></div>
			<div class="tankuang_txt"></div>
			<div class="tankuang_txt"></div>
			<div class="tankuang_txt"></div>
		</div>
		<div class="tanchuang_guanbi animated bounceIn"><img src="<?php echo TPL_URL;?>images/tankuang_1_14.png" /></div>
	</div>

 
		<div class="tankuang_content tankuang2 tankuang_button_xianshi popup3 rmhd">
			<div class="shouji"><img src="<?php echo TPL_URL;?>images/tankuang_2_18.png" class="animated flipInY" />
				<div class="erweima animated zoomIn "><img class="wx_image" src="<?php echo TPL_URL;?>images/tankuang_1_06.png"></div>
				<div class="shaoma animated fadeInUp ">扫描二维码参与</div>
				<div class="niao1"><img src="<?php echo TPL_URL;?>images/tankuang_2_20.png"></div>
				<div class="niao2"><img src="<?php echo TPL_URL;?>images/tankuang_2_26.png"></div>
				<div class="niao3"><img src="<?php echo TPL_URL;?>images/tankuang_2_47.png"></div>
				<div class="yun1 animated fudong "><img src="<?php echo TPL_URL;?>images/tankuang_2_14.png"></div>
				<div class="yun2 animated fudong1"><img src="<?php echo TPL_URL;?>images/tankuang_2_33.png"></div>
			</div>
			<div class="dizuo animated fadeInLeft "><img src="<?php echo TPL_URL;?>images/tankuang_2_42.png"></div>
			<div class="tanchuang_guanbi animated bounceInDown "><img src="<?php echo TPL_URL;?>images/tankuang_2_55.png" /></div>
			<div  class="songli animated rollIn">我要送礼</div>
			<div class="tankuang_list animated fadeInUp ">
				<div class="tankuang_title">爱丽丝不睡觉</div>
				<div class="tankuang_txt">分销价格: <span> ￥365</span></div>
				<div class="tankuang_txt">派送利润: <span> ￥35</span></div>
				<div class="tankuang_txt_txt">利用节日营销，打造传播新方式。中秋微贺卡，支持商家定制祝福语、背景音乐、自定义上传logo。粉丝在接收到商家发出的微贺卡后，也可对祝福内容进行定制，并分享、转发。利用微贺卡，借助节日气氛，为商家带来爆炸式传播。”</div>
			</div>
		</div>

		<div class="tankuang_content tankuang3 tankuang_button_xianshi yydb popup4">
			<div class="shouji animated zoomIn"><img src="<?php echo TPL_URL;?>images/tankuang3_18.png">
				<div class="erweima animated rubberBand"><img class="wx_image" src="<?php echo TPL_URL;?>images/tankuang_1_06.png"></div>
				<div class="shaoma animated bounceInUp">扫描二维码参与</div>
			</div>
			<div class="dizuo animated fadeInLeft"><img src="<?php echo TPL_URL;?>images/tankuang_3_57.png"></div>
			<div  class="songli animated bounceInDown">一元夺宝</div>
			<div class="tankuang_list animated fadeIn ">
				<div class="tankuang_title">爱丽丝不睡觉</div>
				<div class="tankuang_txt">分销价格: <span> ￥365</span></div>
				<div class="tankuang_txt">派送利润: <span> ￥35</span></div>
				<div class="tankuang_txt_txt">每个用户最低只需1元就有机会获得一件奖品。每个奖品分配对应数量的号码，每个号码价值1元，当一件奖品所有号码售出后，根据既定的算法计算出一个幸运号码，持有该号码的用户，直接获得该奖品。”</div>
			</div>
			<div class="tanchuang_guanbi animated bounceInUp  "><img src="<?php echo TPL_URL;?>images/tuankuang3_56.png" /></div>
		</div>
		

</div>	
