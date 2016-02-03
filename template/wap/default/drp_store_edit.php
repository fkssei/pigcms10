<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>编辑微店 - <?php echo $store['name']; ?></title>
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
    <script src="<?php echo TPL_URL; ?>js/drp_func.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_common.js"></script>
</head>

<body class="body-gray">
<div data-alert="" class="alert-box alert" style="display: none;" id="errerMsg">请输入微店名！<a href="#" class="close">×</a></div>
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small"><a class="menu-icon" href="javascript:window.history.go(-1);"><span></span></a></section>
        <section class="middle tab-bar-section"><h1 class="title">编辑微店</h1></section>
        <section class="right-small right-small-text2" id="saveBtn"><a href="javascript:void(0)" onclick="btnSave()" class="button [radius round] top-button">保存</a></section>
    </nav>
</div>

<div class="storeedit mlr-15">
    <form>
        <div class="row">
            <div class="large-12 columns">
                <label>
                    微店名称<input type="text" id="title" placeholder="微店名称" old="<?php echo $store['name']; ?>" value="<?php echo $store['name']; ?>" <?php if (!empty($store['edit_name_count'])) { ?>readonly="true"<?php } ?> />
                </label>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <label>
                    微店描述<textarea style="resize: none;" name="intro" id="intro" placeholder="微店描述"><?php echo $store['intro']; ?></textarea>
                </label>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="row">
                <div class="large-12 columns">
                    <label>&nbsp;</label>
                </div>
            </div>

            <div class="tip-means mb-20 <!--mr-15-->">
                <h2 class="tip-means-title"><i class="icon-light"></i><span>温馨提示</span><i class="icon-close" onclick="tip_means_close(this)"></i></h2>
                <div class="tip-means-c">
                    <p>店铺名称只能修改一次，请您谨慎操作</p>
                    <span>亲，选择分销商品后，可在微店平台设置分销商品的分销价格。</span>
                    <ul class="tip-means-ol">
                        <li>访问地址：<?php echo $admin_url; ?></li>
                    </ul>
                </div>
            </div>
            <div class="row"></div>
            <div id="device" class="category gridalicious"></div>
            <div style="text-align: center">
                <a class="more" id="show_more" page="2" style="display: none;" href="javascript:void(0);">加载更多</a>
                <input type="hidden" id="canScroll" value="1"/>
            </div>
    </form>
</div>


<script src="<?php echo TPL_URL; ?>js/jquery.grid-a-licious.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $("#device").gridalicious({
            gutter: 10,
            width: 150,
            animationOptions: {
                speed: 150,
                duration: 400,
                complete: null
            }
        });


        //获取可以分销的商品
        $.post("./drp_products.php", {'store_id': '<?php echo $store['drp_supplier_id']; ?>', 'type': 'get'}, function (data) {
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
        })
    });
</script>


<script type="text/javascript">
    $(function () {
        $(document).on('click', "div[name=columns]", function () {
            if (!$(this).hasClass('current')) { //设置分销
                $(this).addClass("current");
                $.post("./drp_products.php", {'type': 'set_drp', 'product_id': $(this).attr('pid')}, function (data) {
                    if (data == '' || data == undefined) {
                        $(this).removeClass("current");
                        ShowMsg('商品分销失败');
                        return;
                    }
                    if (data.err_code != 0) {
                        $(this).removeClass("current");
                        ShowMsg(data.err_msg);
                        return;
                    }
                })
            } else { //取消分销
                $(this).removeClass("current");
                $.post("./drp_products.php", {'type': 'cancel_drp', 'product_id': $(this).attr('pid')}, function (data) {

                })
            }
        });

    })

    function btnSave() {
        var title = $("#title").val().trim();
        var intro = $('#intro').val().trim();
        var tempbl = false;
        if (title == "") {
            ShowMsg("店铺名称不可为空");
            return;
        } else {
            if (title == $("#title").attr("old").trim()) {
                tempbl = true;
            } else {
                //检测店铺名称是否已存在
                $.ajax({
                    url: "./drp_store.php",
                    data: {"name": title, 'type': 'check_store'},
                    async: false,
                    cache: false,
                    type: 'POST',
                    success: function (res) {
                        tempbl = res;
                    }
                })
            }
        }
        if (!tempbl) {
            ShowMsg("店铺名称已存在");
            return;
        } else {
            $.post('./drp_store.php', {'type': 'edit', "name": title, 'intro': intro}, function(data){
                if (data == undefined || data == '') {
                    ShowMsg("店铺编辑失败");
                    return;
                } else if (data.err_code == 0 || data.err_code == 1000) {
                    window.location.href = data.err_msg;
                } else {
                    ShowMsg(data.err_msg);
                    return;
                }
            })
        }

    }

    /*---------------------加载更多--------------------*/
    var total = parseInt(<?php echo $product_count; ?>), pagesize = 20, pages = Math.ceil(total / pagesize);
    if (pages > 1) {
        var _page = $('#show_more').attr('page');
        var flag =  false;
        $(window).bind("scroll", function () {
            if ($(document).scrollTop() + $(window).height() >= $(document).height() && flag == false) {
                $('#show_more').show().html('加载中...');
                if (_page > pages) {
                    $('#show_more').show().html('没有更多了').delay(2300).slideUp(1600);
                    flag = true;
                    return;
                }
                if ($('#canScroll').val() == 0) {//不要重复加载
                    return;
                }
                $('#canScroll').attr('value', 0);
                $.post("./drp_products.php", {
                    'store_id': '<?php echo $store['drp_supplier_id']; ?>',
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
                })
            } else {
                flag = false;
            }
        })
    }
</script>

<?php echo $shareData;?>
</body>
</html>