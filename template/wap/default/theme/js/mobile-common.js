! function() {
    function n(n, t) {
        for (var o in t) n[o] = t[o];
        return n
    }
    var t = "whereami@~0.1.1",
        o = "mobile-common@0.2.2/js/locate.js",
        e = "mobile-common@0.2.2/js/lazyload.js",
        i = "mobile-common@0.2.2/js/util.js",
        c = "cookie@~0.1.0",
        a = "zepto@^1.2.1",
        r = "mobile-common@0.2.2/index.js",
        u = {},
        l = u;
    define(r, [t, o, e, i], function(n, t) {
        var o = n("whereami");
        o.config({
            wxAutoConfig: !0,
            debug: !1
        }), t.Geo = n("whereami"), t.Locate = n("./js/locate"), t.LazyLoad = n("./js/lazyload"), t.Util = n("./js/util")
    }, {
        main: !0,
        map: n({
            "./js/locate": o,
            "./js/lazyload": e,
            "./js/util": i
        }, l)
    }), define(o, [c, a, t], function(n, t, o) {
        var e = n("cookie"),
            i = n("zepto"),
            c = n("whereami"),
            a = -1 != location.href.indexOf("pigcms.com") ? ".pigcms.com" : ".pigcms.com",
            r = function(n) {
                return {
                    expires: n || .25 / 24,
                    path: "/",
                    domain: a
                }
            },
            u = function() {
                e("visitflag", 1, r(365))
            };
        o.exports = function(n, t, o) {
            function a(n, t) {
                c(function(o) {
                    var e = o.lat,
                        c = o.lng,
                        a = -1 != location.href.indexOf("51ping.com") ? "m.51ping.com" : "m.pigcms.com";
                    i.ajax({
                        url: "http://" + a + "/getlocalcityid",
                        data: {
                            lat: e,
                            lng: c
                        },
                        dataType: "jsonp",
                        success: function(o) {
                            200 === o.code ? n(o.message) : t()
                        },
                        error: function() {
                            t()
                        }
                    })
                }, t, o)
            }

            function l() {
                if (!e("switchcityflashtoast")) {
                    var n = i("#J_toast");
                    n.removeClass("Hide"), setTimeout(function() {
                        n.addClass("Hide")
                    }, 3e3), e("switchcityflashtoast", "1", r(365))
                }
            }
            var s = e("cityid") || n,
                f = function(n, o, i) {
                    !e("noswitchcity") && s && n && n != s && o && i && (confirm("您目前定位是在:" + o + ",是否切换?") ? setTimeout(function() {
                        document.location.href = t ? t(n, i, o) : "/" + i
                    }, 200) : e("noswitchcity", "1", r()))
                },
                m = function() {
                    var n = -1 != location.href.indexOf("51ping.com") ? "m.51ping.com" : "m.pigcms.com";
                    _hip.push(["mv", {
                        module: "Home_Call_MapcenterService_All",
                        action: "browse"
                    }]), i.ajax({
                        url: "http://" + n + "/ajax/getLocationInfo",
                        data: {},
                        dataType: "jsonp",
                        success: function(n) {
                            if (200 === n.code) {
                                _hip.push(["mv", {
                                    module: "Home_Call_MapcenterService_Success",
                                    action: "browse"
                                }]);
                                var t = n.message,
                                    o = t.cityId,
                                    e = t.cityName,
                                    i = t.cityPinyin;
                                u(), f(o, e, i)
                            }
                            404 === n.code && l()
                        },
                        error: function() {
                            l()
                        }
                    })
                },
                d = function(n) {
                    var t = n.cityid,
                        o = n.citypinyin,
                        e = n.cityname;
                    f(t, e, o)
                },
                p = function() {
                    m()
                };
            a(d, p)
        }
    }, {
        map: l
    }), define(e, [], function(n, t, o) {
        function e(n, t) {
            return n.getAttribute(t)
        }

        function i(n) {
            return n.filter(function(n) {
                return !!e(n, c)
            })
        }
        var c = "lazy-src",
            a = function(n) {
                var t = i(n.get()),
                    o = function() {
                        t.forEach(function(n) {
                            var t = n.getBoundingClientRect().top,
                                o = e(n, c);
                            o && t && t < window.innerHeight && (n.setAttribute("src", o), n.removeAttribute(c))
                        }), t = i(t), t.length <= 0 && window.removeEventListener("scroll", o, !1)
                    };
                window.addEventListener("load", o, !1), window.addEventListener("scroll", o, !1), o()
            };
        o.exports = a
    }, {
        map: l
    }), define(i, [], function(n, t) {
        t.extend = function(n, t) {
            if (t) {
                for (var o in t) t.hasOwnProperty(o) && (n[o] = t[o]);
                return n
            }
        }, t.supportLocalStorage = function() {
            var n = window.localStorage && null != window.localStorage,
                t = "local_test";
            if (n) try {
                localStorage.setItem(t, 1), localStorage.removeItem(t)
            } catch (o) {
                return !1
            }
            return n
        }, t.supportGeo = function() {
            return !!navigator.geolocation
        }, t.tpl = function(n, t) {
            return n.replace(/{([^{}]*)}/g, function(n, o) {
                return o in t ? t[o] : ""
            })
        }
    }, {
        map: l
    })
}();