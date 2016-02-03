function getobj(id) {
    return document.getElementById(id);
}

function selecttab(obj, act, def, special, areaname) {
    var node = childs(obj.parentNode.parentNode.childNodes);
    for (var i = 0; i < node.length; i++) {
        if (node[i].className != special) {
            node[i].className = def;
            if (getobj(areaname + "_" + i))
                getobj(areaname + "_" + i).style.display = "none";
        }
    }
    obj.parentNode.className = act;
    for (var i = 0; i < node.length; i++) {
        if (node[i].className != special) {
            if (node[i].className == act) {
                if (getobj(areaname + "_" + i))
                    getobj(areaname + "_" + i).style.display = "";
            }
        }
    }
}

function childs(nodes) {
    if (!nodes.length)
        return [];
    var ret = [];
    for (var i = 0; i < nodes.length; i++) {
        if (nodes[i].nodeType != 1)
            continue;
        ret.push(nodes[i]);
    }
    return ret;
}

//验证码
function ChangeVerifyImgNew(url) {
    document.getElementById("verifyimg").src = url + 'member/verifyimg.aspx?d=' + Date();
}

function showIndex(areaname) {
    var obj = getobj("eplrightbg");
    var l = obj.childNodes.length;

    obj.childNodes[0].style.display = '';

    for (var i = 1; i < l; i++) {
        if (obj.childNodes[i].nodeType == 1) {
            obj.childNodes[i].style.display = 'none';
        }
    }
}

function thisfocus(obj, value, objcss) {
    if (value.length > 0) {
        if (obj.value == value) {
            obj.value = '';
        }
    }
    obj.className = 'thisfocus ' + objcss;
}
function ReMoveFocus(obj, objcss) {
    obj.className = objcss;
}

function showshopcontent() {
    var allText = document.getElementsByName("shopfen");
    for (var i = 0; i < allText.length; i++) {
        allText[i].value = "";
    }
    document.getElementById("shopcontent").style.display = "block";
}



function checkDel(act, link, id, message) {
    art.dialog({
        lock: true,
        title: '提示',
        content: message,
        yesText: "确定",
        drag: false,
        yesFn: function () {
            $.ajax({
                url: link,
                type: "get",
                data: { action: act, id: escape(id) },
                success: function (data) {
                    data = unescape(data);
                    var array = data.split("$");
                    if (array[0] == "true") {
                        return true;
                        window.location.reload();
                    }
                    else if (array[0] == "false") {
                        return false;
                    }

                }
            });
        },
        noText: "取消",
        noFn: function () {
            return true;
        }
    });
}



function ShowartDialogMessage(tit, con) {

    art.dialog({
        title: tit,
        content: con,
        width: '560px',
        height: '120px',
        yesText: "确定",
        yesFn: function () {
            return true;
        },
        drag: false,
        lock: true

    });
}
function ShowartMessage(tit, con, link) {
    art.dialog({
        title: tit,
        content: con,
        width: '200px',
        height: '40px',
        yesText: "确定",
        yesFn: function () {
            window.location.href = link;
        },
        drag: false,
        lock: true

    });

}

//注册协议
$(function () {
    $("#zhucexieyi").click(function () {
        art.dialog.open('treaty.html', {
            title: '注册协议',
            //            lock: true,
            //            opacity: 0.5,
            width: '800px',
            height: '600px'
        });
    });
});

function ShowMsg(msg) {
    $("#errerMsg").html(msg);
    $("#errerMsg").show(300, "linear");
    setTimeout(function () { $("#errerMsg").animate({ height: 'toggle', opacity: 'toggle' }, { duration: "slow" }) }, 3000);

}




//取得url参数
function request(paras) {
    var url = location.href;
    var paraString = url.substring(url.indexOf("?") + 1, url.length).split("&");
    var paraObj = {}
    for (i = 0; j = paraString[i]; i++) {
        paraObj[j.substring(0, j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=") + 1, j.length);
    }
    var returnValue = paraObj[paras.toLowerCase()];
    if (typeof (returnValue) == "undefined") {
        return "";
    } else {
        return returnValue;
    }
}


$(function () {
    $(document).on('click', ".close-input", function () {
        $(this).prev().val("");
        $(this).hide();
    });
    $(document).on('change', "input[type=text]", function () {
        if ($(this).parent().find("span").length == 0) {
            $(this).parent().append('  <span class="close-input"></span>');
        } else {
            $(this).parent().find("span").show();
        }
    });
    $(document).on('change', "input[type=password]", function () {
        if ($(this).parent().find("span").length == 0) {
            $(this).parent().append('  <span class="close-input"></span>');
        } else {
            $(this).parent().find("span").show();
        }
    });

})