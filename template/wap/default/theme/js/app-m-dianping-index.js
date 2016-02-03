! function() {
    function t(t, e) {
        for (var n in e) t[n] = e[n];
        return t
    }
    var e = "zepto@^1.2.1",
        n = "mobile-common-search@~0.5.0",
        i = "mobile-common@~0.2.0",
        a = "swipe@^2.0.0",
        o = "util-m-monitor@~0.1.4",
        r = "app-m-dianping-index@0.5.1/js/timelimit.js",
        c = "app-m-dianping-index@0.5.1/js/loadrec.js",
        s = "cookie@~0.2.0",
        l = "app-m-dianping-index@0.5.1/index.js",
        m = {},
        d = m;
    define(l, [e, n, i, a, o, r, c], function(t, e) {
        var n = t("zepto"),
            i = t("mobile-common-search"),
            a = t("mobile-common"),
            o = t("swipe"),
            r = t("util-m-monitor"),
            c = function() {
                var t = [];
                return function(e, n) {
                    t[e] || (_hip.push(["mv", {
                        module: "5_shouye_slide",
                        action: "roll",
                        index: e,
                        content: n
                    }]), t[e] = !0)
                }
            }();
        e.init = function(e) {
            n(function() {
                {
                    var s = [1514, 1, 1],
                        l = !0;
                    new r(s, l)
                }
                if (n("#J_slider .page").length > 1) {
                    var m = n(".index-category .circles .circle");
                    new o(document.getElementById("J_slider"), {
                        speed: 300,
                        continuous: !0,
                        disableScroll: !0,
                        stopPropagation: !1,
                        auto: 1e4,
                        transitionEnd: function(t) {
                            m.removeClass("on").eq(t % m.length).addClass("on"), c(t % m.length + 1, m.length)
                        }
                    })
                }
                var d = new i(n(".J_search"), {
                        suggestUrl: "/ssnew",
                        suggestItemTemplate: function(t) {
                            return t.tuan ? '<li><a class="tuan" href="javascript:;"><i></i>{keyword}<span class="number">约{num}个结果</span></a></li>' : '<li><a href="javascript:;">{keyword}<span class="number">约{num}个结果</span></a></li>'
                        },
                        suggestOnclick: function(t, e) {
                            try {
                                _hip.push(["mv", {
                                    module: "2_search_suggest",
                                    action: "click",
                                    index: 1 + e,
                                    keyword: t.keyword
                                }])
                            } catch (n) {}
                            t.tuan ? (this.form.attr("action", "/tuan/search"), t.keyword = t.keyword.replace("团购", "").trim()) : this.form.attr("action", p), this.search(t.keyword)
                        },
                        onKeywordShow: function() {
                            try {
                                _hip.push(["mv", {
                                    module: "5_rec_search",
                                    action: "browse"
                                }])
                            } catch (t) {}
                        },
                        onHistoryShow: function() {
                            try {
                                _hip.push(["mv", {
                                    module: "5_his_search",
                                    action: "browse"
                                }])
                            } catch (t) {}
                        },
                        historyOnclick: function(t, e) {
                            try {
                                _hip.push(["mv", {
                                    module: "5_his_search",
                                    action: "click",
                                    index: e + 1
                                }])
                            } catch (n) {}
                            this.search(t)
                        },
                        triggerEvent: "click"
                    }, n(".J_search_container")),
                    p = d.form.attr("action");
                "电影" == n(".J_search_input").attr("placeholder") && d.form.on("submit", function(t) {
                    "" == n(".J_search_input").val() && (t.preventDefault(), location.href = "/movie?utm_source=search")
                }), a.Locate(e.cityId), t("./js/timelimit")();
                var u = t("./js/loadrec");
                u(e)
            })
        }
    }, {
        main: !0,
        map: t({
            "./js/timelimit": r,
            "./js/loadrec": c
        }, d)
    }), define(r, [e], function(t, e, n) {
        var i = t("zepto");
        n.exports = function() {
            i(function() {
                var t = i(".timelimit");
                if (t.length > 0) {
                    var e = t.attr("data-time"),
                        n = e.split(";")[0],
                        o = e.split(";")[1],
                        r = e.split(";")[2],
                        c = function() {
                            i(t).find(".tip").html("0" === n ? "距离开始还有：" : "距离结束还有：");
                            var e = parseInt(o / 3600),
                                c = parseInt((o - 3600 * e) / 60),
                                s = o % 60;
                            i(t).find(".hour").html(a(e)), i(t).find(".min").html(a(c)), i(t).find(".second").html(a(s)), o--, 0 === o && ("0" === n ? (n = "1", o = 3600 * (24 - r)) : (n = "0", o = 3600 * r))
                        };
                    setInterval(function() {
                        c()
                    }, 1e3)
                } else if (i(".block1").length > 0) {
                    var e = i(".block1").attr("data-time"),
                        n = e.split(";")[0],
                        o = e.split(";")[1],
                        r = e.split(";")[2];
                    i(".dp_bg").addClass("0" === n ? "dp_bg1" : "dp_bg2");
                    var c = function() {
                        var t = (i(".time-limit-1"), parseInt(o / 3600)),
                            e = parseInt((o - 3600 * t) / 60),
                            c = o % 60,
                            s = parseInt(a(t) / 10),
                            l = a(t) % 10,
                            m = parseInt(a(e) / 10),
                            d = a(e) % 10,
                            p = parseInt(a(c) / 10),
                            u = a(c) % 10;
                        i(".time_block").eq(0).html(s), i(".time_block").eq(1).html(l), i(".time_block").eq(2).html(m), i(".time_block").eq(3).html(d), i(".time_block").eq(4).html(p), i(".time_block").eq(5).html(u), o--, 0 === o && ("0" === n ? (n = "1", o = 3600 * (24 - r), i(".dp_bg").removeClass("dp_bg1"), i(".dp_bg").addClass("dp_bg2")) : (n = "0", o = 3600 * r, i(".dp_bg").removeClass("dp_bg2"), i(".dp_bg").addClass("dp_bg1")))
                    };
                    setInterval(function() {
                        c()
                    }, 1e3)
                }
            })
        };
        var a = function(t) {
            return 1 === String(t).length && (t = "0" + t), t
        }
    }, {
        map: d
    }), define(c, [i, e, s], function(t, e, n) {
        var i = t("mobile-common"),
            a = t("zepto"),
            o = t("cookie");
        n.exports = function(t) {
            var e = a(".J_reclist");
            e.length && (o("locallat") || i.Geo(function() {
                a.ajax({
                    url: "/home/ajax/rectuan",
                    dataType: "html",
                    data: {
                        cityId: t.cityId
                    },
                    success: function(t) {
                        a(e).find(".home-tuan-list").html(t), i.LazyLoad(e.find("img"))
                    }
                })
            }, function() {}))
        }
    }, {
        map: d
    })
}();