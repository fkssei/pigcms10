! function() {
    function i(i, n) {
        for (var e in n) i[e] = n[e];
        return i
    }
    var n = "zepto@^1.2.1",
        e = "openapp@~0.1.0",
        o = "mobile-download-banner@~0.3.0",
        d = "mobile-common@~0.2.0",
        a = "app-m-main-common@0.2.1/js/module/weixinshare.js",
        m = "app-m-main-common@0.2.1/index.js",
        t = {},
        r = t;
    define(m, [n, e, o, d, a], function(i, n) {
        var e = i("zepto"),
            o = i("openapp"),
            d = i("mobile-download-banner");
        document.addEventListener("touchstart", function() {}, !1);
        var a = !1;
        n.init = function(n) {
            a || (a = !0, e(function() {
                e("#F_download").on("click", function() {
                    o("pigcms://home", {
                        downloadUrl: "http://m.api.pigcms.com/downloadlink?redirect=3259"
                    })
                }), n.hideApp || d.init(), i("mobile-common").LazyLoad(e("img"))
            }), n.weixin && i("./js/module/weixinshare").config(n.weixin), /dianping_android_novalhd/.test(navigator.userAgent) && e(".footer-fix").hide(), e("#j-computer").on("click", function() {
                document.cookie = "vmod=pc;domain=dianping.com;path=/;"
            }), e(".shop-more").on("click", function() {
                e(".hideGroupon").removeClass("Hide"), e(".shop-more").addClass("Hide"), e(".hide-more").removeClass("Hide")
            }), e(".hide-more").on("click", function() {
                e(".hideGroupon").addClass("Hide"), e(".hide-more").addClass("Hide"), e(".shop-more").removeClass("Hide")
            }))
        }
    }, {
        main: !0,
        map: i({
            "./js/module/weixinshare": a
        }, r)
    }), define(a, [d], function(i, n) {
        var e = {
                img_width: 640,
                img_height: 640,
                appid: "wx841a97238d9e17b2"
            },
            o = function() {
                WeixinJSBridge.on("menu:share:appmessage", function() {
                    WeixinJSBridge.invoke("sendAppMessage", e, function() {})
                }), WeixinJSBridge.on("menu:share:timeline", function() {
                    WeixinJSBridge.invoke("shareTimeline", e, function() {})
                })
            };
        window.WeixinJSBridge ? o() : document.addEventListener("WeixinJSBridgeReady", o, !1), n.config = function(n) {
            i("mobile-common").Util.extend(e, n)
        }
    }, {
        map: r
    })
}();