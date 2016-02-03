<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8" />
    <title>支付--购物</title>

</head>
<body class="bg-white">
<!DOCTYPE html>

<html lang="zh-cn"> <!--<![endif]-->
<head>
<title>支付--pig购物</title>
<style> body {
        background: #FFF
    }</style>
<style>
@charset "UTF-8";
html {
    color: #000;
    background: #eee;
}

body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, textarea, p, blockquote, th, td {
    margin: 0;
    padding: 0;
    font: 12px/1.5 "arial", "\5b8b\4f53", "SimHei", sans-serif;
}

button, input, select, textarea {
    font: 12px/1.5 "arial", "Microsoft YaHei", "SimHei", sans-serif;
}

table {
    border-collapse: collapse;
    border-spacing: 0;
}

fieldset, img {
    border: 0;
}

address, caption, cite, code, dfn, em, strong, th, var {
    font-style: normal;
    font-weight: normal;
}

li {
    list-style: none;
}

caption, th {
    text-align: left;
}

h1, h2, h3, h4, h5, h6 {
    font-size: 100%;
    font-weight: normal;
}

q:before, q:after {
    content: '';
}

abbr, acronym {
    border: 0;
    font-variant: normal;
}

sup {
    vertical-align: text-top;
}

sub {
    vertical-align: text-bottom;
}

input, textarea, select {
    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;
}

input, textarea, select {
    *font-size: 100%;
}

img {
    vertical-align: bottom;
}

.clearfix:after {
    content: ".";
    display: block;
    height: 0;
    clear: both;
    visibility: hidden;
}

* html .clearfix {
    height: 1%;
}

* + html .clearfix {
    height: 1%;
}

.orangeBtn {
    display: inline-block;
    *display: inline;
    *zoom: 1;
    padding: 0 17px;
    line-height: 28px;
    height: 28px;
    text-align: center;
    border-radius: 3px;
    font-size: 12px;
    border: 0;
    font-weight: normal;
    color: #fff;
    cursor: pointer;
    background: #fc4343;
    background: -webkit-gradient(linear, 0 0, 0 100%, from(#fc4343), to(#f63b3b));
    background-image: -ms-linear-gradient(top, #fc4343 0%, #f63b3b 100%);
    background-image: -moz-linear-gradient(top, #fc4343 0%, #f63b3b 100%);
    background-image: -o-linear-gradient(top, #fc4343 0%, #f63b3b 100%);
    background-image: -webkit-linear-gradient(top, #fc4343 0%, #f63b3b 100%);
    background-image: linear-gradient(to bottom, #fc4343 0%, #f63b3b 100%);
}

.orangeBtn:hover {
    color: #fff;
    background: #f63b3b;
    text-decoration: none;
}

.orangeBtn.large, .blueBtn.large {
    font-weight: bold;
    font-size: 15px;
    line-height: 39px;
    height: 39px;
    padding: 0 38px;
}

.orangeBtn.enabled {
    background: #a59894;
}

.pay-logo {
    border-bottom: 3px solid #666;
}

.pay-logo img {
    margin: 12px 0 12px 30px;
}

.pay-info {
    background: #fcffd4;
    padding: 20px 0 15px 25px;
}

.pay-type {
    padding: 25px 14px;
}

.pay-code {
    padding: 0px 14px;
}

.pay-active {
    padding-top: 25px;
}

body {
    width: 800px;
    margin: 0 auto;
}

.pay-info ul li {
    padding: 5px 0;
}

.pay-info ul li label {
    font-size: 16px;
    color: #7e7e7e;
    padding-right: 10px;
    font-family: '宋体';
    font-weight: bold;
}

h1 {
    font-size: 18px;
    font-weight: bold;
    border-bottom: 1px solid #ccc;
    padding: 0 0 3px 10px;
}

.pay-type-list {
    padding: 14px;
}

.pay-code-list {
    padding: 22px 0 22px 17px;
}

.pay-info .money {
    font-size: 28px;
    color: #d81700;
    font-weight: bold;
}

0
.pay-type .zhifubao {
    display: inline-block;
    margin: 0 15px;
    width: 115px;
    height: 49px;
    background-image: url(/cashier/htdocs/image/zhifubao.jpg);
    vertical-align: middle;
}

.pay-code .code {
    position: relative;
    padding-bottom: 30px;
    border-bottom: 1px solid #ccc;
}

.pay-code .txt {
    position: absolute;
    top: 30px;
    left: 125px;
    font-size: 18px;
    font-weight: bold;
    width: 200px;
}

.pay-active .icon {
    display: inline-block;
    background: #ff9900;
    width: 24px;
    height: 24px;
    margin-right: 5px;
    color: #FFF;
    font-size: 18px;
    font-weight: normal;
    text-align: center;
    border-radius: 50%;
    vertical-align: bottom;
}

.copyright {
    width: 100%;
    background: #eee;
    color: #666;
    text-align: center;
    padding: 15px 0;
}

.f14 {
    font-size: 14px;
}
</style>
</head>
<body>
<div class="pay-logo">
    <img src="<?php echo TPL_URL;?>images/logoa.png"/>
</div>
<div class="pay-info">
    <ul>
        <li><label>订单编号</label><span class="f14">1205962800</span></li>
        <li><label>商品名称</label><span class="f14">2015夏季短袖男士V领t恤韩版修身纯色..</span></li>
        <li style="padding: 0;"><label>应付总额</label><span class="money">&yen; 38.00</span></li>

    </ul>
</div>
<form id="cashierForm" name="cashierForm" method="POST" action="pcpay.htm">
    <div class="pay-type">
        <h1>第三方支付</h1>
        <ul class="pay-type-list">
            <li>
                <input type="radio" id="1308" name="payChannel" vaule=""  onclick="getValue('1308|ALIPAY');">
                <label for="1308" class="zhifubao" style=" display: inline-block; margin: 0 15px;width: 60px; height: 60px;background-image: url(<?php echo TPL_URL;?>images/ALIPAY.png);vertical-align: middle;"></label>
            </li>
            </li>
        </ul>
    </div>
    <div class="pay-code">
        <h1>扫码支付</h1>
        <ul class="pay-code-list">
            <li class="code">
                <img src="<?php echo TPL_URL;?>images/footer_03.png" width="114" height="112">
                <div class="txt">扫一扫<br>轻松完成支付</div>
            </li>
            <li class="pay-active">
                <button class="orangeBtn large" id="submitButton" type="button" onclick="next();">下一步</button>
                <div style="padding: 20px 0 0 0; color: #666;"><b class="icon">&yen;</b>如需改价，请联系卖家改价后再扫描验证码确认支付。</div>
            </li>
        </ul>
    </div>
    <input type="hidden" id="token" name="token" value="C132712827" />
    <input type="hidden" id="memberType" name="memberType" value="1" />
    <input type="hidden" id="thirdPay" name="thirdPay" />
</form>
<div class="copyright f14">
    版权所有 @2014-2015 微店
</div>
</body>
<script type="text/javascript">
    function next(){
        if ($('input[name="payChannel"]:checked').length < 1) {
            alert("请选择一个支付渠道！");
            return;
        }
        $('#cashierForm').submit();
    };

    function getValue(value){
        document.getElementById("thirdPay").value=value;
    };

    //轮询查询支付状态
    function fun() {
        var url  = "/result/checkPayResult.htm?notifyToken=$notifyToken";
        jQuery.getJSON(url, function(json) {
            if("OK"==json) {
                location.href  = "/result/payNotifyResult.htm?notifyToken=&memberType=1";
            }
        });
    }

    $(function(){
        // setInterval("fun()", 10000);
    });

</script>



</html>
</body>
</html>
