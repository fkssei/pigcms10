<!DOCTYPE html>
<!-- saved from url=(0046)http://koudaitong.com/v2/account/team/solution -->
<html class="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1" /> -->
<meta name="keywords" content=",微信商城,粉丝营销,微信商城运营">
<meta name="description" content="是帮助商家在微信上搭建微信商城的平台，提供店铺、商品、订单、物流、消息和客户的管理模块，同时还提供丰富的营销应用和活动插件。">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<!-- ▼ Common CSS -->
<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/bootstrap_140705.css" onerror="_cdnFallback(this)">
<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/base.css" />
<!-- ▲ Common CSS -->

<!-- ▼ App CSS -->
<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/settled_41279c7313.css" onerror="_cdnFallback(this)">
<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/solution_dcd0e15e05.css" onerror="_cdnFallback(this)">
<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/team_08dfa528ef.css" onerror="_cdnFallback(this)">
<script type="text/javascript" src="./static/js/jquery.min.js"></script>

<!-- ▲ Common config -->
<style>
#BDBridgeWrap { display: none !important; }
.team #header .header-title{ margin:0; border:none}
.solution-item-meta p{ word-break:break-all}
</style>

</head>

<body class="theme theme--blue">
<div id="hd" class="wrap rel">
		<div class="wrap_1000 clearfix">
			<h1 id="hd_logo" class="abs" title="<?php echo $config['site_name'];?>">
				<?php if($config['pc_shopercenter_logo'] != ''){?>
					<a href="<?php dourl('store:select');?>">
						<img src="<?php echo $config['pc_shopercenter_logo'];?>" height="35" alt="<?php echo $config['site_name'];?>" style="height:35px;width:auto;max-width:none;"/>
					</a>
				<?php }?>
			</h1>
			<h2 class="tc hd_title">
                选择模板类型
            </h2>
		</div>
	</div>
<div class="js-notifications notifications"></div>
<!-- ▼ Main header --> 

<!-- ▲ Main header --> 

<!-- ▼ Main container -->
<div class="container">
	<div class="content" role="main">
		<div class="app">
			<div class="app-init-container">
				<div class="team">
					<div class="wrapper-app">
						<div id="header">
							<div class="header-title-wrap clearfix">

								<div class="header-title">选择推荐模版</div>
							</div>
							
						</div>
						<?php if($cate_list){?>
						<div id="content" class="page-team-solution">
							<div>
								<div class="solution-desc">
									<h4>已为您准备了多种行业模板，请根据实际情况任选一种：</h4>
									<p>每个行业模板，都已经默认配置和启用了合适的功能，便于您能够快速的开店；</p>
									<p>当然，您也可以根据自身情况，重新进行自定义设置的操作，满足你的日常经营；</p>
								</div>
								<ul class="solution-list clearfix js-solution-list">
								<?php foreach($cate_list as $k=>$v){ ?>
									<li class="solution-item <?php if($k==0){?>active<?php } ?>" data-id="<?php echo $v['cat_id']; ?>" page-id="<?php echo $v['page_id']?>">
										<div class="solution-item-screenshot"><img src="<?php echo $v['cover_img']?>" width="230" height="150" /></div>
										<div class="solution-item-meta">
											<h3><?php echo $v['cat_name']; ?></h3>
											<p><?php echo $v['cat_desc']?></p>
										</div>
										<div class="solution-item-example">
											<div class="solution-item-qr-code"><img src="./source/qrcode.php?type=page&id=<?php echo $v['page_id']; ?>" alt=""></div>
										</div>
									</li>
								<?php } ?>
								</ul>
								<div class="solution-action">
									<button class="btn btn-large btn-primary js-save" type="button" data-loading-text="正在提交...">确定</button>
								</div>
							</div>
						</div>
						<?php }else{?>
						
						<div id="content" class="page-team-solution">
							<div>
								<center>暂无模板，请先添加行业模板</center>
							</div>
						</div>
						
						<?php } ?>
						<div id="content-addition"></div>
					</div>
				</div>
			</div>
			<div class="notify-bar js-notify animated hinge hide"> </div>
		</div>
	</div>
</div>

<script type="text/javascript">
$('.solution-item').each(function(){
	$(this).click(function(i){
		$('.solution-item').each(function(){
			$(this).removeClass('active');
		});
		$(this).addClass('active');
	});
});

$('.js-save').click(function(){
	var cat_id=$('.active').attr('data-id');
	var store_id=<?php echo $_GET['store_id']?>;
	var page_id=$('.active').attr('page-id');
	var url='<?php dourl('store:select_template') ?>';
	
	<?php if($_GET['page_id']) {?>
	$.post(url,{'cat_id':cat_id,'store_id':store_id,'page_id':page_id,'new_page_id':<?php echo $_GET['page_id']; ?>},function(data){
		alert('添加成功！');
			location.href='<?php dourl('store:select')?>';
	});
	<?php }else{ ?>
	$.post(url,{'cat_id':cat_id,'store_id':store_id,'page_id':page_id},function(data){
		//alert('添加成功！');
			//location.href='<?php dourl('store:select')?>';
	});
	<?php } ?>
});
</script>
</body>
</html>