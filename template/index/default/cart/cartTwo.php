<?php if(!defined( 'PIGCMS_PATH')) exit( 'deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="zh-cn">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        <?php echo $config[ 'site_name'];?>
    </title>
    <meta name="Keywords" content="小猪CMS">
    <meta name="description" content="小猪CMS微店程序">
    <link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/public.css">
    <link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/cart.css" />
</head>

<body>
<!-- mod-mini-nav Begin -->
<?php include display( 'public:cart_header');?>
<!-- mod-mini-nav End -->




<div id="fmx_tags" style="position:absolute;left:-9999px;"></div>
<div class="main">
<div class="main-body clearf">



<form method="post" action="" id="form">
<input type="hidden" id="J_OrderIdMarkForGA" name="ga_order_rs" value="" />
<div class="buyer-info" id="buyerInfo">
    <div id="J_AddressListContainer"  >
        <p class="title">
            <b>选择收货人信息</b>
        </p>
        <table class="address-table" id="J_AddressTable">
            <colgroup>
                <col class="name" />
                <col class="address" />
                <col class="phone" />
                <col class="operate" />
            </colgroup>
            <tbody id="J_AddressList">

            <tr data='{"phone":"13257089190","provinceID":"1","townName":"","zipcode":"","cityID":"2","cityName":"海淀区","provinceName":"北京","townID":"0","id":"11543258","districtName":"五环到六环之间","isDefault":1,"address":"1111111111111","districtID":"11","name":"其他"}'  class="current" >
                <td class="name"><input type="radio" name="defaultRadio"  checked="checked"  /> 其他</td>
                <td class="address">北京 海淀区 五环到六环之间 1111111111111</td>
                <td>13257089190</td>
                <td>
                    <a href="javascript:void(0)" class="e-modify">修改</a><span class="cut">|</span><a href="javascript:void(0)" class="e-delete">删除</a>
                </td>
            </tr>

            </tbody>
            <tr class="add-address">
                <td class="name">
                    <input type="radio" name="defaultRadio" />
                    使用新地址
                </td>
                <td class="special" colspan="3">
                </td>
            </tr>
        </table>
    </div>
    <div id="J_AddressEditContainer"  class="none" >
        <p class="title">
            <b id="J_Title">收货人信息</b>
            <span class="e-remark">(注：<span class="red">*</span> 为必填项) </span>
            <span class="modifyBtn" id="editBuyerInfo">[修改]</span>
        </p>
        <table id="buyerInfoTable">
            <tr>
                <td style="padding-right: 20px;"><span class="red">*</span> 收货人姓名：</td>
                <td>
                    <input name="name" id="buyerName" class="inputText" type="text" maxlength="12" data-validator='{"required":1,"messages":{"required":"请输入收货人姓名"}}'/>
                    <span class="v_error"></span>
                </td>
            </tr>
            <tr>
                <td><span class="red">*</span> 手 机 号 码：</td>
                <td>
                    <input name="phone" id="buyerPhone" class="inputText" type="text" data-validator='{"required":1,"match":1,"messages":{"required":"请输入手机号码","phoneNo":"手机号码格式错误"}}' maxlength="11"/>
                    <span class="v_error"></span>
                    <span class="none" id="J_PhoneTips">请填写您的常用手机号码，将同时作为您的登陆账号！</span>
                </td>
            </tr>
            <tr>
                <td><span class="red">*</span> 地<span style="margin-left: 43px;">区</span>：</td>
                <td>
                    <div id="addressPanel">
                        <select name="provinceID" id="province">
                            <option>--省份--</option>
                        </select>
                        <select name="cityID" id="city">
                            <option>--城市--</option>
                        </select>
                        <select name="districtID" id="district">
                            <option>--区县--</option>
                        </select>
                        <span class="v_error"></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td><span class="red">*</span> 街 道 地 址：</td>
                <td class="jiedaodizhi">
                    <textarea id="jiedao" name="address" maxlength="120" class="jiedao inputText" data-validator='{"required":1,"match":"^.{10,120}$","messages":{"required":"请输入街道地址","match":"请输入10-120位字符"}}' placeholder="不需要重复填写省市区，必须大于10个字，小于120个字"></textarea>
                    <span class="v_error"></span>
                </td>
            </tr>
            <tr>
                <td class="col1"></td>
                <td>
                    <input id="isDefault" name="default" checked="checked" type="checkbox" /> <label for="isDefault">设置为默认地址</label>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <a class="orangeBtn large" style="margin-right:30px;margin-top: 25px;width:120px;" href="javascript:void(0)" id="checkBuyerInfo">保       存</a>
                    <span id="errorBuyerInfoTable" class="v_error">请确认收货人信息并保存</span>
                    <input type="hidden" id="addressId" value="" />
                </td>
            </tr>
        </table>
    </div>
</div>







<div class="order-type-list">
    <p class="title"><b>在线支付</b></p>
    <div class="order-type clearfix" id="J_OrderType">


        <div class="pay-method-list pay-method-checked" style="border:0;">
            <label class="t1">
                <input type="radio" value="0" name="order_type" checked/>担保交易
            </label>
                                    <span class="inlineBlock pay-method-txt">
                                        微店提供担保，确认收货后才会打款给卖家。
                                        <b class="inlineBlock pay-method-tj">推荐</b>
                                    </span>
        </div>
        <!--
        <div class="pay-method-list">
        <label class="t2" data-text="请在收货确认时付款，收货后如需退款换货，请与卖家联系，微店不介入交易纠纷处理">
        <input type="radio" value="1" name="order_type" />货到付款
        </label>
        </div>
        -->











    </div>




















</div>


<div class="item-info">
    <p  class="title"><strong>商品信息</strong></p>
    <table style="width: 905px;" class="tableBorder">
        <thead>
        <tr style="background: #e9e9e9;">
            <td width="30%">商 品</td>
            <td width="18%">型 号</td>
            <td width="18%">单价（元）</td>
            <td width="18%">数 量</td>
            <td style="text-align: right;padding-right: 20px;">小 计（元）</td>
        </tr>
        </thead>
        <tbody id="J_itemTbody">

        </tbody>
        <tfoot>
        <tr>
            <td colspan="4" style="text-align: left">
                备  注：<input type="text" class="inputText" name="buyer_comment" maxlength="1024" style="width: 400px;" placeholder="给卖家留言"/>
            </td>
            <td style="text-align: right;padding-right: 20px;" id="J_expressFeeTd">

            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right">
                <span>验证码：</span>
                <input class="inputText" id="validCode" name="validCode" type="text" maxlength="6" style="width: 50px;">
                <img alt="点击更换图形验证码" style="cursor:pointer;margin-left:5px;width:80px;height:30px;" id="imgCode">
                <span class="v_error"></span>
            </td>
        </tr>
        </tfoot>
    </table>
</div>
<!--1.4.15兼容单品下单-->







<div class="pay-total">
    应付总额：<strong style="color: #dd0f18;font-weight: bold" id="payTotal"> &yen; <span id="J_payTotalFee"></span>元</strong>
    <span class="orangeBtn large enabled" style="margin:7px 10px 0 30px;" id="payButton">提交订单</span>
</div>
<!--1.4.15兼容单品下单-->








<input type="hidden" name="itemId" id="itemId"/>
<input type="hidden" name="vsku_id" id="vsku_id"/>
<input type="hidden" name="w" id="www"/>
<input type="hidden" name="category" value="home"/>
<input type="hidden" name="reqId" value=""/>
<input type="hidden" name="provinceName" />
<input type="hidden" name="cityName" />
<input type="hidden" name="districtName" />
<input type="hidden" name="cartIds" value="27130414" />
</form>


<div class="help-info">
    <p class="title" style="border-bottom: dashed 1px #ccc;padding-bottom: 20px;"><b>帮助与说明</b></p>
    <p class="ask">问：什么是担保交易？</p>
    <p class="answer">
        答：通俗的说，就是买家发起交易并且付款后，由微店官方作为中介代为保管；待买家收货确认交易后，微店官方再将货款给卖家。这种交易形式被称为“担保交易”。
    </p>
    <p class="ask">问：什么是直接到账？</p>
    <p class="answer">
        答：买家付款后，资金直接转入店主账户。如需要退换货，请及时与店主联系。微店官方不介入交易纠纷处理！
    </p>

</div>

</div>
</div>


<script type="text/javascript">
    require(["kd/Buy",'area'], function (Buy) {
        var itemData = [{"vtemDetail":{"itemID":"vdian858970018","itemName":"2015夏季短袖男士V领t恤韩版修身纯色圆领半袖打底衫新款男装<br />\n","stock":"1590","price":"38.00","sold":"10","seller_id":163894128,"thumbImgs":["http://wd.geilicdn.com/vshop161247402-1409655355-451568.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753553-109704.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753554-245902.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753554-625560.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753555-278936.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753555-590209.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753555-748879.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753555-927291.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753556-128009.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753557-689954.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753557-893856.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753558-277233.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753558-589114.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753558-926665.jpg?w=110&h=110&cp=1","http://wd.geilicdn.com/vshop163894128-1420753562-345805.jpg?w=110&h=110&cp=1"],"itemLogo":"http://wd.geilicdn.com/vshop161247402-1409655355-451568.jpg?w=480&h=360&cp=1","titles":["","","","","","","","","","","","","","",""],"sku":[{"title":"170/90(M)-灰色","stock":100,"price":"38.00","id":2266403988,"sold":0},{"title":"175/95(L)-灰色","stock":100,"price":"38.00","id":2266403990,"sold":0},{"title":"180/100(XL)-灰色","stock":100,"price":"38.00","id":2266403992,"sold":0},{"title":"185/105(XXL)-灰色","stock":100,"price":"38.00","id":2266403994,"sold":0},{"title":"170/90(M)-白色","stock":97,"price":"38.00","id":2266403996,"sold":3},{"title":"175/95(L)-白色","stock":96,"price":"38.00","id":2266403998,"sold":4},{"title":"180/100(XL)-白色","stock":100,"price":"38.00","id":2266404000,"sold":0},{"title":"185/105(XXL)-白色","stock":99,"price":"38.00","id":2266404002,"sold":1},{"title":"170/90(M)-宝蓝色","stock":100,"price":"38.00","id":2266404004,"sold":0},{"title":"175/95(L)-宝蓝色","stock":100,"price":"38.00","id":2266404006,"sold":0},{"title":"180/100(XL)-宝蓝色","stock":100,"price":"38.00","id":2266404008,"sold":0},{"title":"185/105(XXL)-宝蓝色","stock":100,"price":"38.00","id":2266404010,"sold":0},{"title":"170/90(M)-黑色","stock":98,"price":"38.00","id":2266404012,"sold":2},{"title":"175/95(L)-黑色","stock":100,"price":"38.00","id":2266404014,"sold":0},{"title":"180/100(XL)-黑色","stock":100,"price":"38.00","id":2266404016,"sold":0},{"title":"185/105(XXL)-黑色","stock":100,"price":"38.00","id":2266404018,"sold":0}],"free_delivery":1,"remote_free_delivery":0,"extend":{"total_number":0,"total_score":0,"score":0},"buy_stock":1600,"remote_area":"海外、港、澳、台、新疆、西藏、内蒙、青海、甘肃、宁夏","collectCount":91,"isClose":"0","is_active":0,"is_active_limit":0,"seckill_or_discount":0,"isDelete":0,"Imgs":["http://wd.geilicdn.com/vshop161247402-1409655355-451568.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753553-109704.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753554-245902.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753554-625560.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753555-278936.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753555-590209.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753555-748879.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753555-927291.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753556-128009.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753557-689954.jpg?w=480&h=0"],"next_page":1,"is_fx":0,"is_liutao":0,"discount_price":null,"sf_cod":0,"sf_cod_rate":"","shop_logo":"<?php echo TPL_URL;?>images/default.png","front_cover":"","rate":"","is_kdpay":1,"is_warrant":1,"is_COD":0,"express_fee":0,"shop_name":"佐佑潮流阁","shop_url":"http://weidian.com/s/163894128","shop_img":"http://wd.geilicdn.com/vshop-default-front-cover3.jpg?w=640&h=330&cp=1","voice":{"url":"","seconds":0},"discount":"","is_score":1,"allowAddCart":1},"vshopDetail":{},"itemDetails":{"item":{"product_id":"SBBSKn7nU4dBCxG0AQ9fck1L3Lntea7dcF1BVCI6i432cc=","pcid":"vdian858970018","name":"2015夏季短袖男士V领t恤韩版修身纯色圆领半袖打底衫新款男装\n","price":38,"pricemsrp":38,"takeprice":-1,"price_currency":"￥","price_weidian":"38.00","discount":9.9,"timeleft":0,"image_620":"http://wd.geilicdn.com/vshop161247402-1409655355-451568.jpg?w=230&h=172","comment_amount":0,"comment_star":5,"soldout":10,"stock":1590,"inventory":"","shop_name":"微店","favorite_amount":91,"favorite_status":0,"img_description":["http://wd.geilicdn.com/vshop161247402-1409655355-451568.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753553-109704.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753554-245902.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753554-625560.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753555-278936.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753555-590209.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753555-748879.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753555-927291.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753556-128009.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753557-689954.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753557-893856.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753558-277233.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753558-589114.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753558-926665.jpg?w=480&h=0","http://wd.geilicdn.com/vshop163894128-1420753562-345805.jpg?w=480&h=0"],"item_timestamp":0,"app_id":"","combine_app_id":"","image_ratio":"0.75","is_on_line":true,"time":"","weight":"","type":"","token":"","tv_url":"","rank":0,"is_preference":false,"shopLite":{"original_app_name":"163894128_佐佑潮流阁","shop_id":16389412824000001,"third_platform_logo":"http://img.geilicdn.com/shop_vdian.png","shop_service":"","entrance_name":"佐佑潮流阁","app_id":"vdian_186965e88d3ba635221731d220bf9699","isSelf":0,"third_platform_small_logo":"http://img.geilicdn.com/lshop_vdian.png","shop_type":"微店","shop_grade":3,"logo_url":"http://wd.geilicdn.com/vshop163894128-1408336476.jpeg?w=640&h=640","seller_locus":"泉州市"},"is_new":false,"is_discount":false,"is_direct_purchase":true,"is_price_down":false,"price_dowm_timestamp":0,"dig_text":"","recommend_text":"","recommend_reason":"","tag_text":"","dig_tag":"","store_category":50000436,"keyword_label":[],"is_adProduct":false,"distance":0,"cpsrate":0,"is_seller_recom":false,"is_move_weidian":false,"weidian_product_id":"","isCheckCode":false,"checkCode":0,"limitCount":0,"preferenceId":0,"vdianActivityId":0,"wfr":"","discountType":0,"wdseller_recom":false,"tag":null,"recomm_res":"","similar_cluster":null,"update_time":"","sku":[{"price":38,"stock":100,"property":[{"value":"170/90(M)-灰色","key":""}],"sku_id":"2266403988"},{"price":38,"stock":100,"property":[{"value":"175/95(L)-灰色","key":""}],"sku_id":"2266403990"},{"price":38,"stock":100,"property":[{"value":"180/100(XL)-灰色","key":""}],"sku_id":"2266403992"},{"price":38,"stock":100,"property":[{"value":"185/105(XXL)-灰色","key":""}],"sku_id":"2266403994"},{"price":38,"stock":97,"property":[{"value":"170/90(M)-白色","key":""}],"sku_id":"2266403996"},{"price":38,"stock":96,"property":[{"value":"175/95(L)-白色","key":""}],"sku_id":"2266403998"},{"price":38,"stock":100,"property":[{"value":"180/100(XL)-白色","key":""}],"sku_id":"2266404000"},{"price":38,"stock":99,"property":[{"value":"185/105(XXL)-白色","key":""}],"sku_id":"2266404002"},{"price":38,"stock":100,"property":[{"value":"170/90(M)-宝蓝色","key":""}],"sku_id":"2266404004"},{"price":38,"stock":100,"property":[{"value":"175/95(L)-宝蓝色","key":""}],"sku_id":"2266404006"},{"price":38,"stock":100,"property":[{"value":"180/100(XL)-宝蓝色","key":""}],"sku_id":"2266404008"},{"price":38,"stock":100,"property":[{"value":"185/105(XXL)-宝蓝色","key":""}],"sku_id":"2266404010"},{"price":38,"stock":98,"property":[{"value":"170/90(M)-黑色","key":""}],"sku_id":"2266404012"},{"price":38,"stock":100,"property":[{"value":"175/95(L)-黑色","key":""}],"sku_id":"2266404014"},{"price":38,"stock":100,"property":[{"value":"180/100(XL)-黑色","key":""}],"sku_id":"2266404016"},{"price":38,"stock":100,"property":[{"value":"185/105(XXL)-黑色","key":""}],"sku_id":"2266404018"}],"rightUpperIcon":null,"voice":{"url":"","seconds":0},"qrCode":0,"product_id_ori":"vdian858970018","banjiaItemStatus":0,"discount_desc":"9.9折","text_description":"&nbsp;","is_collected":false},"comment":[],"shop":{"app_id":"vdian_186965e88d3ba635221731d220bf9699","entrance_name":"佐佑潮流阁","original_app_name":"163894128_佐佑潮流阁","item_url":"http://wd.koudai.com/vshop/1/H5/index.html?userid=163894128","product_amount":64,"favorite_amount":0,"rate":"97.69%","description":"","imgurl":"http://wd.geilicdn.com/vshop163894128-1408336476.jpeg?w=640&h=640","remarks":"","shop_id":"16389412824000001","shop_grade":3,"shop_service":"","update_time":0,"seller_user_id":"","desc_score":"4.7","service_score":"4.8","send_score":"4.8","desc_rate":"-0.56%","service_rate":"13.72%","send_rate":"23.75%","seller_locus":"泉州市","shop_type":"微店","third_platform":"微店","third_platform_logo":"http://img.geilicdn.com/shop_vdian.png","third_platform_small_logo":"http://img.geilicdn.com/lshop_vdian.png","service":[],"sellerDef":{"notice":"","timeStamp":1417363200000,"imgLink":[]},"isSelf":0,"distance":-1,"wechat_id":"752533009","seller_recom_text":"","service_imgurl":"http://img.geilicdn.com/iPhone_taobao-danbao.jpg","service_skipurl":"","service_imgurl_ratio":0.1,"cpsrate":0,"soldout":64,"cpsSoldout":0,"danbaojiaoyi":true,"qitiantuihuo":true,"huodaofukuan":false,"taobaobanjia":true,"supportIM":true,"seller_id":"163894128","original_shop_type":"","cid":"","bonusStatus":false,"shop_logo":"http://wd.geilicdn.com/vshop-default-front-cover3.jpg?w=640&h=330&cp=1","voice":{"url":"","seconds":0},"shop_medal_id":1,"distanceUnit":null,"brand_official":false,"brand_licensing":false,"overseas_purchasing":false,"brand_official_url":"","brand_licensing_url":"","overseas_purchasing_url":"","address":null},"preference":{},"pairup":{"items":[],"groupItems":[],"productIds":[]},"buyLink":"http://tbtz.mitao.cn/showTaobaoPage.do?itemId=vdian858970018&userId=320094491"},"amout":"1","vsku_id":"2266404002"}],
            category = 'home',
            addressList=[{"phone":"13257089190","provinceID":"1","townName":"","zipcode":"","cityID":"2","cityName":"海淀区","provinceName":"北京","townID":"0","id":"11543258","districtName":"五环到六环之间","isDefault":1,"address":"1111111111111","districtID":"11","name":"其他"}],
            imgExtend = 0,
            cart = 'true';

        new Buy({
            "itemData": itemData,
            "addressList":addressList,
            "category": category,
            "imgExtend": imgExtend,
            "cart": cart
        });
    });
</script>







<?php include display( 'public:footer');?>

</body>
</html>