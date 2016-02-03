
<!--顶部 bar start-->
<div id="site-nav" role="navigation">
    <div id="sn-bg">
        <div class="sn-bg-right"></div>
    </div>
    <div id="sn-bd">
        <b class="sn-edge"></b>
        <div class="sn-container">
            <p class="sn-back-home"><i class="mui-global-iconfont"></i><a href="###"></a></p>
            <p class="sn-login-info" id="login-info">
                <?php if(empty($user_session)){?>
                    <em>Hi，欢迎来联动生活</em>
                    <a target="_top" href="<?php echo url('account:login') ?>" class="sn-login">请登录</a>
                    <a target="_top" href="<?php echo url('account:register') ?>" class="sn-register">免费注册</a>
                <?php }else{?>
                    <em>Hi，<?php echo $user_session['nickname'];?></em>
                    <a target="_top" href="<?php echo url('account:logout') ?>" class="sn-register">退出</a>
                <?php }?>
            </p>
            <ul class="sn-quick-menu">
                <li class="sn-cart mini-cart menu"><i class="mui-global-iconfont"></i>
                    <a rel="nofollow" href="<?php echo url('cart:one') ?>" class="sn-cart-link" id="mc-menu-hd">购物车<span class="mc-count mc-pt3"><?php echo $cart_number + 0 ?></span>件</a>
                </li>
                <li class="sn-mobile">
                    <a href="<?php echo url('account:order') ?>">我的订单</a>
                </li>
                <li class="sn-mytaobao menu-item j_MyTaobao">
                    <div class="sn-menu">
                        <a rel="nofollow" target="_top" href="" class="menu-hd"aria-haspopup="menu-2" aria-label="右键弹出菜单，tab键导航，esc关闭当前菜单">我的账户<b></b></a>
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
                        <a rel="nofollow" href="<?php echo url('account:collect_store') ?>" class="menu-hd">我的收藏<b></b></a>
                        <div class="menu-bd" role="menu" aria-hidden="true" id="menu-4">
                            <div class="menu-bd-panel">
                                <a rel="nofollow"  href="<?php echo url('account:collect_goods') ?>">收藏的宝贝</a>
                                <a rel="nofollow" href="<?php echo url('account:collect_store') ?>">收藏的店铺</a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="sn-separator"></li>
                <li class="sn-favorite menu-item">
                    <div class="sn-menu">
                        <a rel="nofollow" href="" class="menu-hd" >卖家中心<b></b></a>
                        <div class="menu-bd" role="menu" aria-hidden="true" id="menu-4">
                            <div class="menu-bd-panel">
                                <a rel="nofollow"  href="#">我的店铺</a>
                                <a rel="nofollow" href="#">管理店铺</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="sn-mobile">
                    <a href="#">服务帮助</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--顶部 bar end-->

<!--head-->
<!--头部header start-->
<div id="header"><div style="position: absolute;width: 100%;"></div>
    <div class="headerLayout">
        <div class="headerCon">



            <div class="cart-header">
                <div class="cart-logo">
                    <a href="<?php echo option('config.site_url');?>" title="返回首页"><img style="margin:30px auto" src="<?php echo $config['site_logo'];?>" width=""/></a>
                </div>
                <div class="cart-line">

                    <ul class="order-header order-cart-header">
                        <li>
                            <span class="order-step">1</span>
                            <p class="order-step-text">立即购买</p>
                            <p class="order-step-time"></p>
                        </li>
                        <li class="order-current-step">
                            <span class="order-step">2</span>
                            <p class="order-step-text">确认收货地址信息</p>
                            <p class="order-step-time"></p>
                        </li>
                        <li>
                            <span class="order-step">3</span>
                            <p class="order-step-text">成功提交订单</p>
                            <p class="order-step-time"></p>
                        </li>



                    </ul>



                </div>
            </div>





        </div>
    </div>
</div>
<!--头部header end-->
<!--head-->