<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet">
<script type="text/javascript">
//延迟加载图片
		$(function(){
			return;
			$.get("/index.php?c=index&a=user", function (data) {
				try {
					if (data.status == true) {

						var login_info = '<li>Hi，<a href="<?php echo url('account:index') ?>" class="header_login_cur"><em>' + data.data.nickname + '</em></a></li>';
						login_info += '<li><a target="_top" href="index.php?c=account&a=logout" class="sn-register">退出</a></li>';


						$("#login-info").html(login_info);

						$("#header_cart_number").html(data.data.cart_number);
						$(".mui-mbar-tab-sup-bd").html(data.data.cart_number);
					}
				} catch (e) {

				}
			}, "json");
		})
</script>
<style>
.mui-mbar-tab-sup-bg { background-color: #c40000; border-radius: 10px; margin: -59px 37px; position: absolute; z-index: 1111111; }
.mui-mbar-tab-sup-bd, .mui-yuan { border-radius: 10px; font-size: 12px; height: 20px; line-height: 20px; min-width: 14px; padding: 0 3px; color: #fff; }
.right-red-radius { background-color: #cc0000; border-radius: 10px; }
#leftsead { /*display: none;*/ height: 290px; position: fixed; right: 0; top: 350px; width: 62px; z-index: 100; }
.orangeBtn { padding: 0 }
</style>
<div class="header">
	<div role="navigation" id="site-nav">
		<div id="sn-bg">
			<div class="sn-bg-right"></div>
		</div>
		<div id="sn-bd"> <b class="sn-edge"></b>
			<div class="sn-container">
				<p class="sn-back-home"> <i class="mui-global-iconfont"></i><a href="#"></a> </p>
				<p class="sn-login-info" id="login-info">
					<?php if(empty($user_session)){?>
					<em>Hi，欢迎来<?php echo option('config.site_name');?></em> <a target="_top"
						href="<?php echo url('account:login') ?>" class="sn-login">请登录</a> <a target="_top" href="<?php echo url('account:register') ?>"
						class="sn-register">免费注册</a>
					<?php }else{?>
					<em>Hi，<?php echo $user_session['nickname'];?></em> <a
						target="_top" href="<?php echo url('account:logout') ?>"
						class="sn-register">退出</a>
					<?php }?>
				</p>
				<ul class="sn-quick-menu">
					<li class="sn-cart mini-cart"><i class="mui-global-iconfont"></i> <a
						rel="nofollow" href="<?php echo url('cart:one') ?>"
						class="sn-cart-link" id="mc-menu-hd">购物车<span
							class="mc-count mc-pt3" id="header_cart_number">0</span>件 </a></li>
					<li class="sn-mobile"><a href="<?php echo url('account:order') ?>">我的订单</a> </li>
					<li class="sn-mytaobao menu-item j_MyTaobao">
						<div class="sn-menu"> <a rel="nofollow" target="_top"
								href="<?php echo url('account:index') ?>" class="menu-hd"
								tabindex="0" aria-haspopup="menu-2"
								aria-label="右键弹出菜单，tab键导航，esc关闭当前菜单">我的账户<b></b></a>
							<div class="menu-bd" role="menu" aria-hidden="true" id="menu-2">
								<div id="myTaobaoPanel" class="menu-bd-panel"> <a rel="nofollow" target="_top"
										href="<?php echo url('account:index') ?>">个人设置</a> <a
										rel="nofollow" target="_top"
										href="<?php echo url('account:password') ?>">修改密码</a> <a
										rel="nofollow" target="_top"
										href="<?php echo url('account:address') ?>">收货地址</a> </div>
							</div>
						</div>
					</li>
					<li class="sn-favorite menu-item">
						<div class="sn-menu"> <a rel="nofollow"
								href="<?php echo url('account:collect_store') ?>"
								class="menu-hd" tabindex="0">我的收藏<b></b></a>
							<div class="menu-bd" role="menu" aria-hidden="true" id="menu-4">
								<div class="menu-bd-panel"> <a rel="nofollow"
										href="<?php echo url('account:collect_goods') ?>">收藏的宝贝</a> <a
										rel="nofollow"
										href="<?php echo url('account:collect_store') ?>">收藏的店铺</a> </div>
							</div>
						</div>
					</li>
					<li class="sn-mobile"><a href="javascript:" class="sn-mobile-hover"> <i class="mui-global-iconfont-mobile"></i>微信版
						<div class="sn-qrcode">
							<div class="sn-qrcode-content"> <img src="<?php echo option('config.wechat_qrcode');?>"
										width="175px" height="175px"> </div>
							<p>扫一扫，定制我的微店！</p>
							<b></b> </div>
						</a></li>
					<li class="sn-separator"></li>
					<li class="sn-favorite menu-item">
						<div class="sn-menu"> <span rel="nofollow" href="javascript:void(0)" class="menu-hd"
								tabindex="0">卖家中心<b></b></span>
							<div class="menu-bd" role="menu" aria-hidden="true" id="menu-4">
								<div class="menu-bd-panel"> <a rel="nofollow" href="<?php echo url('user:store:select') ?>">我的店铺</a> <a rel="nofollow" href="<?php echo url('user:store:index') ?>">管理店铺</a> </div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="header_nav">
		<div class="header_logo cursor"
			onclick="javascript:location.href='<?php echo option('config.site_url');?>'"> <img src="<?php echo $config['site_logo'] ?>"> </div>
		<div class="header_search">
			<form class="pigSearch-form clearfix" onsubmit="return false"
				name="searchTop" action="" target="_top">
				<input type="hidden" name="st" id="searchType" value="product" />
				<div class="header_search_left"> <font>商品</font><span></span>
					<div class="header_search_left_list">
						<ul>
							<li listfor="product"
								<?php if(MODULE_NAME != 'search' && ACTION_NAME != 'store'){echo 'selected="selected"';}?>><a
								href="javascript:">商品</a></li>
							<li listfor="shops"
								<?php if(MODULE_NAME == 'search' && ACTION_NAME == 'store'){echo 'selected="selected"';}?>><a
								href="javascript:void(0)">店铺</a></li>
						</ul>
					</div>
				</div>
				<div class="header_search_input">
					<input class="combobox-input" name="" class="input" type="text"
						placeholder="请输入商品名、称地址等" value="<?php echo $searchKeyword;?>">
				</div>
				<div class="header_search_button sub_search">
					<button> <span></span> 搜索 </button>
				</div>
				<div style="clear: both"></div>
			</form>
			<ul class="header_search_list">
				<?php
			  if(count($search_hot)) {?>
				<?php foreach($search_hot as $k=>$v) {?>
				<li <?php if($v['type']){echo 'class="hotKeyword"';}?>><a
					href="<?php echo $v['url']?>"><?php echo $v['name'];?></a></li>
				<?php }?>
				<?php }?>
			</ul>
		</div>
		<div class="header_shop">
			<?php if(!empty($public_top_ad)){?>
			<a href="<?php echo $public_top_ad['url'];?>"><img
				src="<?php echo $public_top_ad['pic'];?>"></a>
			<?php } ?>
		</div>
	</div>
</div>
<div class="nav">
	<div class="nav_top">
		<div class="nav_nav">
			<div class="nav_nav_mian"> <span></span>所有商品分类<span class="xianshi"></span> </div>
			<ul class="nav_nav_mian_list">
				<?php foreach($categoryList as $v) {?>
				<li><a href="<?php echo url_rewrite('category:index',array('id'=>$v['cat_id']))?>">
						<span class="woman" style="background:url('<?php echo $v[cat_pc_pic]?>')"></span>
						<?php echo $v['cat_name']?>
					</a>
					<div class="nav_nav_subnav">
						<div class="nav_nav_mian_list_left">
							<dl>
								<dt> <a
										href="<?php echo url_rewrite('category:index',array('id'=>$v['cat_id']))?>"><?php echo $v['cat_name']; ?></a> </dt>
								<?php if($v['larray']){ ?>
								<?php foreach($v['larray'] as $k1=>$v1) { ?>
								<dd> <a
										href="<?php echo url_rewrite('category:index',array('id'=>$v1['cat_id']))?>"><?php echo $v1['cat_name']?></a> </dd>
								<?php } ?>
								<?php }?>
							</dl>
						</div>
					</div>
				</li>
				<?php } ?>
			</ul>
		</div>
		<ul class="nav_list">
			<li><a href="/">首页</a></li>
			<?php
			foreach($navList as $k => $v) {
				$class = '';
				$param = explode('/', $v['url']);
				
				if ($_GET['id'] == $param[count($param) - 1]) {
					$class = 'nav_list_curn';
				}
			?>
			<li>
				<a href="<?php echo $v['url'];?>" class="<?php echo $class ?>"><?php echo $v['name'] ?></a></li>
			<?php
			}
			?>
		</ul>
	</div>
</div>
