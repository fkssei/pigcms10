<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <title>个人资料修改</title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>


    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_foundation.js"></script>
    <meta class="foundation-data-attribute-namespace"/>
    <meta class="foundation-mq-xxlarge"/>
    <meta class="foundation-mq-xlarge"/>
    <meta class="foundation-mq-large"/>
    <meta class="foundation-mq-medium"/>
    <meta class="foundation-mq-small"/>
    <script src="<?php echo TPL_URL; ?>js/foundation.alert.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_common.js"></script>
</head>

<body>
<div data-alert="" class="alert-box alert" style="display: none;" id="errerMsg"><a href="#" class="close">×</a></div>
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a class="menu-icon" href="./drp_ucenter.php?a=personal"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title" id="title">个人资料</h1>
        </section>
        <section class="right-small right-small-text2" id="saveBtn" style="display: none">
            <a href="javascript:void(0)" onclick="btnsave()" class="button [radius round] top-button">保存</a>
        </section>
    </nav>
</div>

<div class="personal-complete">
    <div class="personal-complete-tip" id="personaltip">以下信息请务必认真填写。</div>
    <div class="personal-center" id="divInfo">
        <ul class="side-nav" id="list">
            <li isnew="False">
                <a href="javascript:void(0)"><span class="user-tip-text"><i class="arrow-l"></i>此账号用于系统登录，填写后不可修改。</span>
                    <div class="title  user-position"><i class="icon-name"></i><span class="text" tage="loginname">会员账号</span></div>
                    <div class="cont-value"><span class="value"><?php echo $user['phone']; ?></span></div>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)">
                    <div class="title"><i class="icon-clock"></i><span class="text" tage="password">密码</span></div>
                    <div class="cont-value"><i class="arrow"></i><span class="value">&nbsp;</span></div>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)">
                    <div class="title"><i class="icon-tname"></i><span class="text" tage="truename">真实姓名</span></div>
                    <div class="cont-value"><i class="arrow"></i><span class="value" id="truename"><?php echo $user['nickname']; ?></span>
                    </div>
                </a>
            </li>
            <!--<li>
                <a href="javascript:void(0)">
                    <div class="title"><i class="icon-tname"></i><span class="text" tage="qqno">QQ号</span></div>
                    <div class="cont-value"><i class="arrow"></i><span class="value" id="qqno"><?php /*echo $user['qq']; */?></span></div>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)">
                    <div class="title"><i class="icon-tname"></i><span class="text" tage="wxno">微信号</span></div>
                    <div class="cont-value"><i class="arrow"></i><span class="value" id="wxno"><?php /*echo $user['nickname']; */?></span>
                    </div>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)">
                    <div class="title"><i class="icon-mobile"></i><span class="text" tage="mobilephone">手机</span></div>
                    <div class="cont-value"><i class="arrow"></i><span class="value" id="mobilephone"><?php /*echo $user['phone']; */?></span></div>
                </a>
            </li>

            <li>
                <a href="javascript:void(0)">
                    <div class="title"><i class="icon-address"></i><span class="text" tage="address">收货地址</span></div>
                    <div class="cont-value"><i class="arrow"></i><span class="value long-text">&nbsp;</span></div>
                </a>
            </li>-->
            <li>
                <a href="javascript:void(0)">
                    <div class="title"><i class="icon-account-line"></i><span class="text" tage="ExtractAccount">提现账号</span></div>
                    <div class="cont-value">
                        <i class="arrow"></i><span class="value long-text"><span></span><br><span></span></span>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <div class="button-exit" id="exit"><a href="./drp_store.php?a=logout" class="button [radius red round]" style="color: white;">退出登陆</a></div>

</div>

<form class="mt-55 mlr-15" id="edit" style="display: none">
    <div class="panel callout radius formstyle">
        <div class="row">
            <div class="large-12 columns">
                <input type="text" id="value" value="" class="last">
                <span class="close-input" style="display: none;"></span>
            </div>
        </div>
    </div>
</form>
<form class="mt-55 mlr-15" id="editpassword" style="display: none">
    <div class="panel callout radius formstyle editpw">
        <div class="row collapse">
            <div class="small-12 large-12 columns">
                <input type="password" placeholder="原密码" id="oldpassword">
                <span class="close-input" style="display: none;"></span>
            </div>
        </div>
        <div class="row collapse">
            <div class="small-12 large-12 columns">
                <input type="password" placeholder="新密码" id="newpassword">
                <span class="close-input" style="display: none;"></span>
            </div>
        </div>
        <div class="row collapse">
            <div class="small-12 large-12 columns">
                <input type="password" placeholder="确认密码" class="last" id="newpassword2">
                <span class="close-input" style="display: none;"></span>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).foundation().foundation('joyride', 'start');
</script>

<script type="text/javascript">
var title = "";
var value = "";
var type = "";
$(function () {
    $('.menu-icon').click(function(){
        if ($(this).hasClass('active')) {
            $('#title').html('个人资料');
            $('.personal-complete-tip').show();
            $("#saveBtn").toggle();
            $("#divInfo").toggle();
            $("#exit").toggle();
            $("#edit").hide();
            $("#editpassword").hide();
            $(this).removeClass('active')
            return false;
        }
    })

    $("#list li").click(function () {

        var titleTag = this.children[0].children[0].children[1];
        if (titleTag == undefined) {
            titleTag = this.children[0].children[1].children[1];
        }
        title = titleTag.innerHTML;
        if (title == "收货地址") {

            window.location.href = "/index.php?g=Wap&m=DrpUcenter&a=shipping_address";
        } else if (title == "提现账号") {
            window.location.href = "./drp_commission.php?a=withdraw_account";
        } else {
            type = $(titleTag).attr("tage");
            value = this.children[0].children[1].children[1];
            if (value == undefined) {
                value = this.children[0].children[2].children[1]
            }
            value = value.innerHTML;

            value = value.replace("&nbsp;", "");
            $("#value").attr("placeholder", "");

            $("#personaltip").toggle()
            if (title == "会员账号") {
                if ($(this).attr("isnew") == "False") {
                    return;
                } else {
                    $("#value").attr("placeholder", "请输入会员名");
                    $("#title").html(title);
                    $("#saveBtn").toggle();
                    $("#divInfo").toggle();
                    $("#exit").toggle();
                    $("#edit").toggle();
                    return;
                }
            }

            if (title == "密码") {
                $("#oldpassword").val('');
                $("#newpassword").val('');
                $("#newpassword2").val('');
                $("#personaltip").hide()
                $("#title").html("修改密码");
                $("#saveBtn").toggle();
                $("#divInfo").toggle();
                $("#exit").toggle();
                $("#editpassword").toggle();
                $('.menu-icon').addClass('active');
            } else {
                $("#personaltip").hide()
                $("#title").html(title);
                $("#value").val(value);
                $("#saveBtn").toggle();
                $("#divInfo").toggle();
                $("#exit").toggle();
                $("#edit").toggle();
                $('.menu-icon').addClass('active');
            }
        }

    })
});

function backPage() {
    $("#title").html("个人资料");
    if ($("#saveBtn").is(":hidden")) {
        window.history.go(-1);
    } else {
        $("#saveBtn").hide();
        $("#divInfo").toggle();
        $("#exit").toggle();
        $("#personaltip").toggle();
        $("#edit").hide();
        $("#editpassword").hide();
    }
}
function btnsave() {
    var url = "./drp_ucenter.php?&a=profile";
    var value = "";
    switch (type) {
        case "password":
            //密码(6-16)位
            var oldpassword = $("#oldpassword").val();
            var newpassword = $("#newpassword").val();
            var newpassword2 = $("#newpassword2").val();
            ;
            var reg = /^[\@A-Za-z0-9\!\#\$\%\^\&\*\.\~]{6,16}$/;
            if (oldpassword == '') {
                ShowMsg("原密码不能为空");
                return;
            } else {
                var flag = true;
                $.ajaxSetup({async: false});
                $.post("./drp_ucenter.php", {"type": "check_pwd","password": oldpassword}, function (data) {
                    if (data != 0) {
                        flag = false;
                        ShowMsg("原密码输入不正确");
                        return;
                    }
                })
                if (!flag) {
                    return;
                }
            }
            if (!reg.test(newpassword)) {
                ShowMsg("新密码不符合要求");
                return;
            }
            if (newpassword != newpassword2) {
                ShowMsg("两次密码输入不一致");
                return;
            }
            $.post(url, {'type': 'password', 'newpassword': newpassword}, function(data){
                if (data == 0) {
                    backPage();
                } else {
                    ShowMsg("密码修改失败");
                }
            })
            break;
        case "truename":
            var truename = $("#truename").text().trim();
            value = $("#value").val().trim();
            if (value == "") {
                ShowMsg("真实姓名不能为空");
                return;
            }
            if (truename == value) {
                ShowMsg("与原真实姓名一致,无需修改");
                return;
            }
            $.post(url, {'type': 'truename', 'truename': value}, function(data){
                if (data == 0) {
                    backPage();
                    $("#truename").text(value);
                } else {
                    ShowMsg("真实姓名修改失败");
                }
            })
            break;
    }
}
</script>

<?php echo $shareData;?>
</body>
</html>