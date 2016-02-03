<div class="col-menu">
    <h3 class="open_shop"><a href="<?php echo url('user:store:index') ?>">我要开店</a></h3>
    <dl>
        <dt>订单中心</dt>
        <dd>
            <a href="<?php echo url('account:order') ?>" <?php if($_GET['a'] == 'order'){ echo 'class="current"';} ?>>我的订单</a>
        </dd>

        <dt>我的收藏</dt>
        <dd>
            <a href="<?php echo url('account:collect_goods') ?>" <?php if($_GET['a'] == 'collect_goods'){ echo 'class="current"';} ?>>商品收藏</a>
        </dd>
        <dd>
            <a href="<?php echo url('account:collect_store') ?>" <?php if($_GET['a'] == 'collect_store'){ echo 'class="current"';} ?>>店铺收藏</a>
        </dd>


        <dt>个人设置</dt>
        <dd>
            <a href="<?php echo url('account:index') ?>" <?php if($_GET['a'] == 'index'){ echo 'class="current"';} ?>>个人设置</a>
        </dd>
        <dd>
            <a href="<?php echo url('account:password') ?>" <?php if($_GET['a'] == 'password'){ echo 'class="current"';} ?>>修改密码</a>
        </dd>
        <dd>
            <a href="<?php echo url('account:address') ?>" <?php if($_GET['a'] == 'address'){ echo 'class="current"';} ?>>收货地址</a>
        </dd>





    </dl>
</div>