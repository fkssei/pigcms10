<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>小猪cms微店</title>
<meta name="keywords" content="微店">
<meta name="description" content="微店">
<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/index_person.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css">
<script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
<script src="<?php echo TPL_URL;?>js/jquery.nav.js"></script>
<script src="<?php echo TPL_URL;?>js/index_person.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="js/DD_belatedPNG_0.0.8a.js" mce_src="js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<style type="text/css"> 
body{ behavior:url("csshover.htc");}
</style>
<![endif]-->

</head>
<body>
<div class="header">
    <div role="navigation" id="site-nav">
		    <div id="sn-bg">
			    <div class="sn-bg-right"></div>
		    </div>
		    <div id="sn-bd">
			    <b class="sn-edge"></b>
			    <div class="sn-container">
				    <p class="sn-back-home"><i class="mui-global-iconfont"></i><a href="###"></a></p>
				    <p class="sn-login-info" id="login-info">
					    <em>Hi，欢迎来小猪微店</em>
					    <a target="_top" href="<?php echo url('account:login') ?>" class="sn-login">请登录</a>
					    <a target="_top" href="<?php echo url('account:register') ?>" class="sn-register">免费注册</a>
				    </p>
				    <ul class="sn-quick-menu">
					    <li class="sn-cart mini-cart"><i class="mui-global-iconfont"></i>
						    <a rel="nofollow" href="<?php echo url('cart:one') ?>" class="sn-cart-link" id="mc-menu-hd">购物车<span class="mc-count mc-pt3" id="header_cart_number">0</span>件</a>
					    </li>
					    <li class="sn-mobile">
						    <a href="<?php echo url('account:order') ?>">我的订单</a>
					    </li>
					    <li class="sn-mytaobao menu-item j_MyTaobao">
						    <div class="sn-menu">
							    <a rel="nofollow" target="_top" href="<?php echo url('account:index') ?>" class="menu-hd" tabindex="0" aria-haspopup="menu-2" aria-label="右键弹出菜单，tab键导航，esc关闭当前菜单">我的账户<b></b></a>
							    <div class="menu-bd" role="menu" aria-hidden="true" id="menu-2">
								    <div id="myTaobaoPanel" class="menu-bd-panel">
									    <a rel="nofollow" target="_top" href="<?php echo url('account:index') ?>">个人设置</a>
									    <a rel="nofollow" target="_top" href="<?php echo url('account:password') ?>">修改密码</a>
									    <a rel="nofollow" target="_top" href="<?php echo url('account:address') ?>">收货地址</a>
								    </div>
							    </div>
						    </div>
					    </li>
					    <li class="sn-favorite menu-item">
						    <div class="sn-menu">
							    <a rel="nofollow" href="<?php echo url('account:collect_store') ?>" class="menu-hd" tabindex="0" >我的收藏<b></b></a>
							    <div class="menu-bd" role="menu" aria-hidden="true" id="menu-4">
								    <div class="menu-bd-panel">
									    <a rel="nofollow"  href="<?php echo url('account:collect_goods') ?>">收藏的宝贝</a>
									    <a rel="nofollow" href="<?php echo url('account:collect_store') ?>">收藏的店铺</a>
								    </div>
							    </div>
						    </div>
					    </li>

					    <li class="sn-mobile">
						    <a href="javascript:" class="sn-mobile-hover" >
							    <i class="mui-global-iconfont-mobile"></i>微信版
							    <div class="sn-qrcode"><div class="sn-qrcode-content"><img src="<?php echo option('config.wechat_qrcode');?>" width="175px" height="175px"></div>
								    <p>扫一扫，定制我的小猪！</p><b></b>
							    </div>
						    </a>
					    </li>
					    <!--
					<li class="sn-seller menu-item">
						<div class="sn-menu J_DirectPromo">
							<a target="_top" href="" class="menu-hd" tabindex="0">商家支持<b></b></a>
							<div class="menu-bd sn-seller-lazy" role="menu" aria-hidden="true" id="menu-6">
								<ul>  <li>
										<h3>商家：</h3>
										<a href=""target="_top">商家中心</a>
										<a href=""target="_top" class="sitemap-right">商家入驻</a>
										<a href=""target="_top">运营服务</a>
										<a href=""target="_top" class="sitemap-right">商家品控</a>
										<a href=""target="_top">商家工具</a>
										<a href=""target="_top" class="sitemap-right">商家规则</a>
										<a href=""target="_top">小猪智库</a>
										<a href=""target="_top" class="sitemap-right">喵言喵语</a>
									</li>
									<li>
										<h3>帮助：</h3>
										<a href=""target="_top">帮助中心</a>
									</li>
								</ul>
							</div>
						</div>
					</li>-->
					    <!------------------------------->
					    <li class="sn-separator"></li>
					    <li class="sn-favorite menu-item">
						    <div class="sn-menu">
							    <span rel="nofollow" href="javascript:void(0)" class="menu-hd" tabindex="0" >卖家中心<b></b></span>
							    <div class="menu-bd" role="menu" aria-hidden="true" id="menu-4">
								    <div class="menu-bd-panel">
									    <a rel="nofollow"  href="<?php echo url('user:store:select') ?>">我的店铺</a>
									    <a rel="nofollow" href="<?php echo url('user:store:index') ?>">管理店铺</a>
								    </div>
							    </div>
						    </div>
					    </li>
					    <!-- <li class="sn-mobile">
						<a href="#">服务帮助</a>
					</li> -->
				    </ul>
			    </div>
		    </div>
	    </div>
</div>
<div class="danye_menu">
    <ul>
        <li class="danye_index"><a href="###"><img src="<?php echo TPL_URL;?>images/shouye_06.png"></a></li>
        <li class="danye_list"><a href="###">会员首页</a></li>
        <li class="danye_list"><a href="###">个人资料</a></li>
        <li class="fanhui"><a href="###">返回首页<span></span></a></li>
    </ul>
</div>
<div class="danye_content">
    <div class="tab1" id="tab1">
        <div class="menu">
            <div class="danye_title order"><span></span>订单中心<i></i></div>
            <ul>
                <li id="one1" onClick="setTab('one',1)" class="off">我的订单</li>
                <li id="one2" onClick="setTab('one',2)" >优惠券</li>
            </ul>
            <div class="danye_title geren"><span></span>个人中心<i></i></div>
            <ul>
                <li id="one3" onClick="setTab('one',3)" class="">收货地址</li>
                <li id="one4" onClick="setTab('one',4)" class="">修改密码</li>
                <li id="one5" onClick="setTab('one',5)" class="">个人资料</li>
            </ul>
        </div>
        <div class="danye_content_right">
            <div id="userinfo" class="m m3">
                <div class="user">
                    <div class="u-icon picture">
                        <div class="hide" id="modifyheader" style="display: none;">
                            <div class="upper fore" id="modUserImgbox"></div>
                            <a class="fore" href="###">修改头像</a> </div>
                        <img alt="用户头像" src="<?php echo TPL_URL;?>images/touxiang.png" id="userImg"> </div>
                    
                </div>
                <!--user-->
                <div id="i-userinfo">
                    <div class="username">
                        <div id="userinfodisp" class="fl ftx-03"><strong>6830876876</strong>，欢迎您！</div>
                        <div id="jdTask" class="extra"></div>
                    </div>
                    <div class="account">
                        <div class="member" id="memberInfo">
                            <p><span class="col_s">会员等级：</span>
                                <input type="hidden" id="ga" value="0">
                                <a href="#" class="cgreen" title="注册会员">注册会员</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="###" target="_blank" class="cgreen">会员等级说明</a> </p>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="menudiv">
                <div id="con_one_1" style="display: block;">
                    <div class="danye_content_title">
                        <div class="danye_suoyou"><a href="###"><span>所有订单</span></a></div>
                    </div>
                    <ul class="order_list_head clearfix">
                        <li class="head_1">宝贝信息</li>
                        <li class="head_2"> 单间(元) </li>
                        <li class="head_3">数量</li>
                        <li class="head_4">合计</li>
                        <li class="head_5"> 交易状态 </li>
                        <li class="head_6">操作</li>
                    </ul>
                    <div class="order_list">
                        <div class="order_list_title"> <span class="mr20">订单编号：<a href="###">13669777</a> </span><span>预订时间：2015-07-08 08:55:02</span> </div>
                        <ul class="order_list_list">
                            <li class="head_1">
                            <dl>
                            <dd><div class="order_list_img"><img src="<?php echo TPL_URL;?>images/12.jpg"></div>
                                <div class="order_list_txt"> <a href="##">
                                    &lt;马尔代夫阿里度岛J Resort Alidhoo4晚自助游&gt;
                                    上海出发</a></div></dd>
                            <dd style="border:0;"><div class="order_list_img"><img src="<?php echo TPL_URL;?>images/12.jpg"></div>
                                <div class="order_list_txt"> <a href="##">
                                    &lt;马尔代夫阿里度岛J Resort Alidhoo4晚自助游&gt;
                                    上海出发</a></div></dd>
                            
                            </dl>
                                
                            </li>
                            <li class="head_2"> 1266.00) </li>
                            <li class="head_3">1</li>
                            <li class="head_4">¥22668</li>
                            <li class="head_5"><span>未支付</span> </li>
                            <li class="head_6">
                                <p><a href="###">付款</a></p>
                                <p><a href="###">取消订单</a></p>
                                <p><a href="###">查看详情</a></p>
                            </li>
                        </ul>
                        <ul class="order_list_list" style="border-bottom:0;">
                            <li class="head_1">
                                <div class="order_list_img"><img src="<?php echo TPL_URL;?>images/12.jpg"></div>
                                <div class="order_list_txt"> <a href="##">
                                    &lt;马尔代夫阿里度岛J Resort Alidhoo4晚自助游&gt;
                                    上海出发</a></div>
                            </li>
                            <li class="head_2"> 1266.00) </li>
                            <li class="head_3">1</li>
                            <li class="head_4">¥22668</li>
                            <li class="head_5"><span>未支付</span> </li>
                            <li class="head_6">
                                <p><a href="###">付款</a></p>
                                <p><a href="###">取消订单</a></p>
                                <p><a href="###">查看详情</a></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="con_one_2" style="display: none;">
                    <section class="server">
                        <div class="section_title">
                            <div class="section_txt">商家动态</div>
                            <div class="section_border"> </div>
                            <div style="clear:both"></div>
                        </div>
                    </section>
                </div>
                <div id="con_one_3" style="display: none;">
                    <section class="server">
                        <div class="section_title">
                            <div class="section_txt">市场活动</div>
                            <div class="section_border"> </div>
                            <div style="clear:both"></div>
                        </div>
                    </section>
                </div>
                <div id="con_one_4" style="display: none;">
                    <div class="danye_content_title">
                        <div class="danye_suoyou"><a href="###"><span>修改密码</span></a></div>
                    </div>
                    <div class="common_div">
                        <table cellspacing="0" cellpadding="0" border="0" class="form-table">
                            <tbody>
                                <tr>
                                    <td width="85" align="right">当前密码：</td>
                                    <td width="200"><input type="password" class="txt-m txt-grey" onBlur="check_oldpwd();" name="old_pwd" id="old_pwd" tabindex="1" placeholder="请输入当前使用密码" style="color: rgb(102, 102, 102);"></td>
                                    <td><div id="oldpwd-tip" class="input-tip err">
                                            <div class="input-tip-inner" style="display: block;"><span></span>
                                                <p>请输入原密码</p>
                                            </div>
                                        </div></td>
                                </tr>
                                <tr>
                                    <td height="50" align="right">新密码：</td>
                                    <td height="50"><input type="password" class="txt-m" style="ime-mode:disabled;" onBlur="check_password();" name="password" tabindex="2" id="password" maxlength="16"></td>
                                    <td height="50"><div id="password-tip" class="input-tip err">
                                            <div class="input-tip-inner err" style="display: block;"><span></span>
                                                <p>请输入密码</p>
                                            </div>
                                        </div>
                                        
                                        <!-- <div id="password-strength"><div id="password-strength-inner"></div></div><span id="rating-msg"></span></div> -->
                                        
                                        <div id="pass_tip" class="pass_tip"> <span class="page_icon icon_pass_tip"><i></i>如何设置安全密码</span>
                                            <div class="icon_pass_tip_con">建议采用数字和字母混合<br>
                                                避免使用有规律的数字和字母<br>
                                                避免与账户名、手机号、生日等部分或完全相同 <span class="z">◆</span> <span class="y">◆</span> </div>
                                        </div></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2"><div class="password-state" id="password-state"> 
                                            <!-- <div class="input-tip-inner"><span class="reg_mes mes_pass_in"></span></div> -->
                                            <div class="password-state-inner txt-grey"><span>由字母、数字或符号组成的6-16位半角字符，区分大小写</span></div>
                                        </div></td>
                                </tr>
                                <tr>
                                    <td align="right">确认密码：</td>
                                    <td><input type="password" class="txt-m txt-grey" onBlur="check_passwordagain();" id="passwordagain" name="passwordagain" tabindex="3" placeholder="请再次输入新密码" style="color: rgb(102, 102, 102);"></td>
                                    <td><div id="passwordagain-tip" class="input-tip err">
                                            <div class="input-tip-inner" style="display: block;"><span></span>
                                                <p>请输入确认密码</p>
                                            </div>
                                        </div></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="button" class="yellow_btn mt10" onClick="change_pwd();" value="确认">
                                        <span style="color:#ff6600; position:relative; top:1px; display:none;" id="tel_submit_ing">&nbsp;&nbsp;提交中 <img src="/css/images/userchangepassword/movie.gif"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="con_one_5" style="display: none;">
                    <section class="server">
                        <div class="section_title">
                            <div class="section_txt">公司新闻</div>
                            <div class="section_border"> </div>
                            <div style="clear:both"></div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

//延迟加载图片
		$(function(){
			//$("img.lazy").show().lazyload();

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
</body></html>