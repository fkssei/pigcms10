<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta class="foundation-data-attribute-namespace">
    <meta class="foundation-mq-xxlarge">
    <meta class="foundation-mq-xlarge">
    <meta class="foundation-mq-large">
    <meta class="foundation-mq-medium">
    <meta class="foundation-mq-small">
    <title>申请分销 - <?php echo option('config.site_name'); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css">
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css">
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css">
    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_foundation.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_foundation.reveal.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_func.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_common.js"></script>
    <script type="text/javascript">
        var open_drp_approve = Boolean("<?php echo $open_drp_approve; ?>");
    </script>
    <style type="text/css">
        .motify {
            text-align: center;
            position: fixed;
            top: 35%;
            left: 50%;
            width: 220px;
            padding: 5px;
            margin: 0 0 0 -110px;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            font-size: 14px;
            line-height: 1.5em;
            border-radius: 6px;
            -webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body class="body-gray">
<div data-alert="" class="alert-box alert" style="display: none;" id="errerMsg">请输入微店名！<a href="#" class="close">×</a></div>
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a onclick="window.history.go(-1)" class="menu-icon"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">设置店铺</h1>
        </section>
        <section class="right-small right-small-text3">
            <a href="javascript:void(0)" class="button [radius round] top-button" id="nextBtn"><?php if (empty($open_drp_approve)) { ?>下一步<?php } else { ?>保存<?php } ?></a>
        </section>
    </nav>
</div>
<ul class="breadcrumbs step-store" id="ul">
    <li class="first current" id="settitle"><a href="javascript:void(0)"><i class="step-number">1</i>设置店铺信息</a></li>
    <li class="second" id="setproduct"><a href="javascript:void(0)"><i class="step-number">2</i>选择分销商品</a></li>
    <li class="third"><a href="javascript:void(0)"><i class="step-number">3</i>完成</a></li>
</ul>
<form id="form1" class="setstroe-form">
    <div class="row">
        <div class="large-12 columns">
            <label>
                店铺名称
                <input type="text" placeholder="请输入店铺名称" id="title" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label>
                <?php if (!$has_password) { ?>管理账号(手机号)<?php } else { ?>联系人手机<?php } ?>
                <input type="text" placeholder="请输入手机号" id="phone" value="<?php echo !empty($userinfo['phone']) ? $userinfo['phone'] : ''; ?>" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label>
                联系人姓名
                <input type="text" placeholder="请输入真实名称" id="name" value="<?php echo $nickname; ?>" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label>
                联系人QQ
                <input type="text" placeholder="请输入QQ号" id="qq" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <input type="checkbox" style="height: auto;line-height: normal" class="agreement-checked" value="1" /> 我已阅读并同意<a href="javascript:;" class="agreement">分销协议</a>
            <textarea readonly="true" style="resize: none;font-size: 14px;line-height: 25px;height: 200px;display: none" class="agreement-info"><?php echo $agreement; ?></textarea>
        </div>
    </div>
</form>
<div class="ml-15" id="form2" style="display: none;">
    <h6>选择分销商品</h6>
    <div class="tip-means mb-20 mr-15">
        <h2 class="tip-means-title"><i class="icon-light"></i><span>温馨提示</span><i class="icon-close" onclick="tip_means_close(this)"></i></h2>
        <div class="tip-means-c">
            <span>亲，选择分销商品后，可在微店平台设置分销商品的分销价格。</span>
            <ul class="tip-means-ol">
                <li>访问地址：<?php echo $admin_url; ?></li>
                <?php if (!$has_password) { ?>
                <li>登录密码和管理账号相同都为手机号</li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php if ($product_count > 0) { ?>
    <div class="row catselect">
        <div class="large-12 columns pl0">
            <input id="checkbox1" type="checkbox" onclick="checkAll(this)"><label for="checkbox1">全选</label>
        </div>
    </div>
    <?php } ?>
    <div id="device" class="category"></div>
    <div style="text-align: center">
        <a class="more" id="show_more" page="2" style="display: none;" href="javascript:void(0);">加载更多</a>
        <input type="hidden" id="canScroll" value="1">
        <input type="hidden" id="haspassword" value="<?php echo $has_password; ?>" />
    </div>
</div>

<script src="<?php echo TPL_URL; ?>js/jquery.grid-a-licious.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#form2").hide();
        $('.agreement').click(function () {
            $('.agreement-info').removeClass('hide');
            $('.agreement-info').slideDown(300);
        })
    });
</script>


<script type="text/javascript">
    var title = "";
    var name = "";
    var phone = "";
    var qq = '';
    var pids = new Array();
    var pidcount = $("div [name='columns']").length;
    var password = '';

    $("#nextBtn").click(function () {
        name = $("#name").val().trim();
        phone = $("#phone").val().trim();
        qq = $('#qq').val().trim();
        if ($('#password').length > 0) {
            password = $('#password').val().trim();
        }
        //手机11位
        var reg = /^\d{11}$/;
        var reg2 = /^[1-9]\d{4,14}$/;
        var tempbl = false;
        var tempbl2 = false;
        var tempid = $(".current").attr("id");
        if (tempid == "settitle") {
            title = $("#title").val().trim();
            if (title == "") {
                ShowMsg("店铺名称不可为空");
                return;
            } else if (phone == "") {
                ShowMsg("手机号码不可为空");
                return;
            } else if (!reg.test(phone)) {
                ShowMsg("请输入正确的手机号码");
                return;
            } else if (name == "") {
                ShowMsg("联系人姓名不可为空");
                return;
            } else if (qq == "") {
                ShowMsg("联系人QQ不能为空");
                return;
            } else if (!reg2.test(qq)) {
                ShowMsg("请输入正确的QQ");
                return;
            } else if (!$('.agreement-checked:checked').val()) {
                ShowMsg("不同意分销协议无法继续下一步");
                return;
            } else {
                $.ajax({
                    url: "./drp_register.php",
                    data: {"name": title, 'type': 'check_store'},
                    async: false,
                    cache: false,
                    type: 'POST',
                    success: function (res) {
                        tempbl = res;
                    }
                })
                if ($('#haspassword').val() == '' || $('#haspassword').val() ==  null) {
                    $.ajax({
                        url: "./drp_register.php",
                        data: {"phone": phone, 'type': 'check_phone'},
                        async: false,
                        cache: false,
                        type: 'POST',
                        success: function (res) {
                            tempbl2 = res;
                        }
                    })
                }
            }
            if (tempbl != true) {
                ShowMsg("店铺名称已存在");
                return;
            }
            if ($('#haspassword').val() == '' || $('#haspassword').val() ==  null) {
                if (tempbl2 != true) {
                    ShowMsg("手机号码已存在");
                    return;
                }
            }

            if (open_drp_approve) {
                //添加分销商和店铺
                $('.motify').remove();
                $('body').append('<div class="motify"><div class="motify-inner">店铺保存中...</div></div>');
                $.post('./drp_store.php', {'store_id': '<?php echo $_GET['id']?>', "name": title, "pids": '', "truename": name, "tel": phone, 'qq': qq, 'type': 'add', 'open_drp_approve': true}, function(data){
                    if(data.err_code == 0) {
                        window.location.href = data.err_msg;
                    } else {
                        ShowMsg('店铺创建失败');
                        return;
                    }
                })
                return true;
            } else {
                $('.motify').remove();
                $('body').append('<div class="motify"><div class="motify-inner">分销商品读取中...</div></div>');
            }

            $("#ul li").removeClass("current");
            $("#setproduct").addClass("current");
            $("#form1").hide();
            $("#form2").show();

            //获取可以分销的商品
            $.post("./drp_products.php", {'store_id': '<?php echo $_GET['id']?>', 'type': 'get'}, function (data) {
                if (data != '') {
                    $('#device').html(data);
                    $("#device").gridalicious({
                        gutter: 10,
                        width: 150,
                        animationOptions: {
                            speed: 150,
                            duration: 400,
                            complete: null
                        }
                    });
                } else {
                    ShowMsg('没有可以分销的商品');
                    return;
                }
                $('.motify').remove();
            })
            $("#checkbox1").click();
            $("#nextBtn").text("保存");
            $("#nextBtn").parent().removeClass("right-small-text3").addClass("right-small-text2");
            more_products();
        } else if ($('#device').html() == '') {
            ShowMsg('请选择要分销的商品');
            return;
        } else if (tempid == "setproduct") {
            if ($('#nextBtn').hasClass('disabled')) {
                return false;
            }
            $('#nextBtn').addClass('disabled');
            var haspassword = $('#haspassword').val();
            $('.motify').remove();
            $('body').append('<div class="motify"><div class="motify-inner">店铺保存中...</div></div>');
            //添加分销商和店铺
            $.post('./drp_store.php', {'store_id': '<?php echo $_GET['id']?>', "name": title, "pids": pids.toString(), "truename": name, "tel": phone, 'qq': qq, 'haspassword': haspassword, 'type': 'add'}, function(data){
                if(data.err_code == 0) {
                    $('body > .motify').remove();
                    window.location.href = data.err_msg;
                } else {
                    $('body > .motify').remove();
                    $('#nextBtn').removeClass('disabled');
                    ShowMsg('店铺创建失败');
                    return;
                }
            })
        }
    })

    function checkAll(obj) {
        if (obj.checked) {
            $("div[name=columns]").each(function () {
                $(this).addClass("current");
            })
            pids = new Array();
        } else {
            pids = new Array();
            $("div[name=columns]").each(function () {
                $(this).removeClass("current");
                pids.push($(this).attr("pid"));
            })
        }
    }


    $(document).on('click', "div[name=columns]", function () {
        pidcount = $("div [name='columns']").length;
        if (!$(this).hasClass('current')) {
            pids.splice(pids.indexOf($(this).attr('pid')), 1);
            $(this).addClass("current");
        } else {
            pids.push($(this).attr('pid'));
            $(this).removeClass("current");
        }
        if (pids.length > 0) {
            document.getElementById("checkbox1").checked = false;
        } else {
            document.getElementById("checkbox1").checked = true;
        }
    });
    function more_products() {
        /*---------------------加载更多--------------------*/
        var total = parseInt(<?php echo $product_count; ?>), pagesize = 20, pages = Math.ceil(total / pagesize);
        if (pages > 1) {
            var _page = $('#show_more').attr('page');
            var flag =  false;
            $(window).bind("scroll", function () {
                if ($(document).scrollTop() + $(window).height() >= $(document).height() && flag == false) {
                    $('#show_more').show().html('加载中...');
                    if (_page > pages) {
                        $('#show_more').show().html('没有更多了').delay(2300).slideUp(300);
                        flag = true;
                        return;
                    }
                    if ($('#canScroll').val() == 0) {//不要重复加载
                        return;
                    }
                    $('#canScroll').attr('value', 0);
                    $.post("./drp_products.php", {
                        'store_id': '<?php echo $_GET['id']?>',
                        'p': _page,
                        'pagesize': pagesize,
                        'type': 'get'
                    }, function (data) {
                        $('#canScroll').attr('value', 1);
                        $('#show_more').hide().html('加载更多');
                        if (data) {
                            $('#show_more').attr('page', parseInt(_page) + 1);
                        }
                        _page = $('#show_more').attr('page');
                        if (data != '' && data != undefined) {
                            $('#device').append(data);
                            $("#device").gridalicious({
                                gutter: 10,
                                width: 150,
                                animationOptions: {
                                    speed: 150,
                                    duration: 400,
                                    complete: null
                                }
                            });
                        }
                    })
                } else {
                    flag = false;
                }
            })
        }
    }


</script>

</body>
</html>