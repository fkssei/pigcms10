<?php if(!defined( 'PIGCMS_PATH')) exit( 'deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>  <?php echo $config[ 'site_name'];?> </title>
    <meta name="Keywords" content="小猪CMS">
    <meta name="description" content="小猪CMS微店程序">
    <link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/public.css">
    <link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/cart.css" />
</head>

<body>
<!--
<div id="J_floatLayer" class="float-layer">
    <a id="J_goTop" class="go-top" title="回到顶部">回到顶部</a>
</div>
-->
<!-- mod-mini-nav Begin -->
<?php include display( 'public:cart_header');?>
<!-- mod-mini-nav End -->

<div class="b-wrapper" style="min-height:500px">
<div class="cart-wrapper clearf">
<table class="order-table" id="J_OrderTable">
<colgroup>
    <col class="baobei">
    <col class="status">
    <col class="price">
    <col class="quantity">
    <col class="amount">
    <col class="operate">
</colgroup>
<thead>
<tr>
    <th class="first">宝贝信息</th>
    <th> 型号</th>
    <th> 单价</th>
    <th> 数量</th>
    <th> 小计 </th>
    <th class="last">  操作 </th>
</tr>
</thead>



<tbody>
<tr class="sep-row">
    <td colspan="6"> </td>
</tr>
<tr class="order-hd order-hd-nobg bright">
    <td colspan="6">
        <div class="shop-detail-top-attrs">
                 <span class="shop-detail-title"> <a href="" target="_blank">  佐佑潮流阁 </a> </span>
                 <span class="shop-detail-tag danbao" title="微店官方担保">  担保交易 </span>
                 <span class="shop-detail-tag qitian" title="七天无理由退换货"> 七天退货 </span>
                  <span class="j_weiChatDiv">   752533009</span>
        </div>
    </td>

</tr>
<tr class="order-bd">
    <td class="baobei">
        <label class="cart-chk"> <input type="checkbox" name="cartItem" class="j_cartItem" /> </label>
        <a target="_blank" title="查看宝贝详情" href="/vtem?itemId=vdian858970018" class="pic">
            <img src="http://img.geilicdn.com/SBBSKn7nU4dBCxuUgcMW3CdI5XM58dFeyXMB-VmLqoerdQ=_640x640.jpg"   width="50">
        </a>
        <div class="desc">
            <p>
                <a class="cart-title" target="_blank" title="  " href="/vtem?itemId=vdian858970018">
                    2015夏季短袖男士V领t恤韩版修身纯色圆领半袖打底衫新款男装 </a>
            </p>
        </div>
    </td>
    <td class="status" rowspan="1"> <p>185/105(XXL)-白色 </p></td>
    <td class="price">  <i>  38.0 </i> </td>
    <td class="quantity">
          <span class="buyNum">
              <span class="reduce" id="reduce"> </span>
              <span class="add" id="add"> </span>
              <input type="text" class="buyNumInput" id="buyNumInput" name="amout" value="1"  maxlength="8" />
              <span class="j_numError num_error">  ！超出购买上限 </span>
          </span>
    </td>
    <td class="ammout" rowspan="1">
        <b class="orange yen">  &yen;</b>
        <b class="orange j_itemTotal">   38.0  </b>
        <!--common.formatPrice-->
    </td>
    <td class="operate" rowspan="1">   <a href="javascript:;" class="j_cartDel">   删除  </a> </td>
</tr>
<tr class="order-hd">
    <td colspan="6" class="heji">
                                        <span> <label class="cart-chk-not"> <input type="checkbox" class="j_cartAll" /> </label>全选 </span>
                                        <span> <a class="cart-del j_cartDelAll" href="javascript:;"> 删除选中商品  </a>  </span>
        <div class="order-hd-bottom">
               <span>共 <b class="cart-nums"> 0</b>  件 </span>
                 <span> 合计 <i> ( 不含运费 ) </i>  ： </span>
                <span class="cart-allPrice">  &yen; 0.00 </span>
            <a href="javascript:;" class="cart-go j_cartGo">    结算   </a>
        </div>
    </td>
</tr>
</tbody>







</table>
</div>
<!-- 宝贝横幅广告 -->
<!--E footer-->
</div>
<?php include display( 'public:footer');?>
</body>

</html>