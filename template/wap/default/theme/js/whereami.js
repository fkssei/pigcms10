! function() {
    function e(e, n) {
        for (var t in n) e[t] = n[t];
        return e
    }
    var n = "dpapp@^1.1.11",
        t = "whereami@0.1.2/lib/config.js",
        i = "whereami@0.1.2/lib/geos/cache.js",
        o = "whereami@0.1.2/lib/request.js",
        a = "whereami@0.1.2/lib/log.js",
        c = "whereami@0.1.2/lib/geos/url.js",
        r = "whereami@0.1.2/lib/geos/weixin.js",
        s = "whereami@0.1.2/lib/geos/qqbrowser.js",
        l = "whereami@0.1.2/lib/geos/app.js",
        u = "whereami@0.1.2/lib/geos/html.js",
        p = "cookie@~0.2.0",
        f = "whereami@0.1.2/lib/util.js",
        g = "whereami@0.1.2/index.js",
        d = [n],
        m = {
            dpapp: n
        },
        h = m;
    define(g, [t, i, o, a, c, r, s, l, u], function(e, n, t) {
        function i(e, n) {
            for (var t = 0, i = e.length; i > t; t++) e.shift().apply(this, n || [])
        }
        var o = e("./lib/config"),
            a = e("./lib/geos/cache"),
            c = e("./lib/request"),
            r = e("./lib/log"),
            s = [e("./lib/geos/url"), a, e("./lib/geos/weixin"), e("./lib/geos/qqbrowser"), e("./lib/geos/app"), e("./lib/geos/html")],
            l = [],
            u = [],
            p = !1,
            f = ~location.href.indexOf("debug:whereami");
        t.exports = function(e, n) {
            if (e && l.push(e), n && u.push(n), !p) {
                p = !0;
                var t, g, d = !1,
                    m = o.get("timeout"),
                    h = o.get("disables"),
                    w = +new Date,
                    b = f || o.get("debug"),
                    y = function(e) {
                        clearTimeout(t), p = !1, d || (b && alert(JSON.stringify(e)), r(w, g, !0), o.get("city") ? c({
                            url: "://m.pigcms.com/getlocalcityid",
                            data: {
                                lat: e.lat,
                                lng: e.lng
                            },
                            onSuc: function(n) {
                                200 == n.code && n.message && (e.city = n.message), i(l, [e])
                            }
                        }) : i(l, [e]), "cache" !== e.type && h && !~h.indexOf("cache") && a.set(e.lat, e.lng))
                    },
                    x = function(e) {
                        if (clearTimeout(t), p = !1, r(w, g, !1),  e && e.code) switch (e.code) {
                            case 1:
                                break;
                            case 2:
                            case 3:
                        }
                        i(u)
                    };
                m && (t = setTimeout(function() {
                    d = !0, x()
                }, m));
                var v = -1;
                ! function j() {
                    v++, s[v] ? (g = s[v].type, h && ~h.indexOf(g) ? j() : (b , s[v](function(e) {
                        e.type = g, y(e)
                    }, x, j))) : x()
                }()
            }
        }, t.exports.config = o.config
    }, {
        asyncDeps: d,
        main: !0,
        map: e({
            "./lib/config": t,
            "./lib/geos/cache": i,
            "./lib/request": o,
            "./lib/log": a,
            "./lib/geos/url": c,
            "./lib/geos/weixin": r,
            "./lib/geos/qqbrowser": s,
            "./lib/geos/app": l,
            "./lib/geos/html": u
        }, h)
    }), define(t, [], function(e, n) {
        var t = {
            timeout: 1e4,
            disables: [],
            urlParamNames: ["latitude", "longitude"],
            cacheType: "cookie",
            cookieNames: ["locallat", "locallng"],
            storageName: "geoinfo",
            wxAutoConfig: !1,
            city: !1,
            debug: !1
        };
        n.get = function(e) {
            return t[e]
        }, n.set = function(e, n) {
            t[e] = n
        }, n.config = function(e) {
            Object.keys(e).forEach(function(n) {
                t[n] = e[n]
            })
        }
    }, {
        asyncDeps: d,
        map: h
    }), define(i, [p, t], function(e, n, t) {
        var i = e("cookie"),
            o = e("../config"),
            a = o.get("cookieNames"),
            c = o.get("cacheType"),
            r = a[0],
            s = a[1];
        t.exports = function(e, n, t) {
            if (c)
                if ("cookie" == c) {
                    var o = i(r),
                        a = i(s);
                    o && a ? e({
                        lat: o,
                        lng: a
                    }) : t()
                } else "storage" == c || t();
            else t()
        }, t.exports.type = "cache", t.exports.set = function(e, n) {
            if (c && "cookie" == c) {
                var t = {
                    expires: .25 / 24,
                    path: "/"
                };
                i(r, e, t), i(s, n, t)
            }
        }
    }, {
        asyncDeps: d,
        map: e({
            "../config": t
        }, h)
    }), define(o, [], function(e, n, t) {
        var i = 0,
            o = function(e, n) {
                if (!n) return e;
                var t = [];
                for (var i in n) n.hasOwnProperty(i) && t.push(i + "=" + n[i]);
                return ~e.indexOf("?") ? e + t.join("&") : e + "?" + t.join("&")
            };
        t.exports = function(e) {
            if (!e.url) throw new Error("url request!");
            var n = e.data || {},
                t = e.onSuc || function() {},
                a = n.callback = "WhereAmI" + ++i,
                c = document.createElement("script");
            c.src = o(e.url, n), window[a] = function(e) {
                delete window[a], c.parentNode.removeChild(c), t(e)
            }, document.getElementsByTagName("head")[0].appendChild(c)
        }
    }, {
        asyncDeps: d,
        map: h
    }), define(a, [], function(e, n, t) {
        t.exports = function(e, n, t) {
            var o = "whereami-type-all",
                a = "whereami-type-" + n,
                c = {
                    v: 1,
                    ts: +new Date,
                    tu: o,
                    d: +new Date - e,
                    hs: t ? 200 : 500,
                    ec: ""
                };
            i(c), c.tu = a, i(c)
        };
        var i = function(e) {
            var n = [];
            for (var t in e) e.hasOwnProperty(t) && n.push(t + "=" + e[t]);
            var i = new Image;
            i.src = "http://114.80.165.63/broker-service/api/single?" + n.join("&")
        }
    }, {
        asyncDeps: d,
        map: h
    }), define(c, [t], function(e, n, t) {
        var i = e("../config"),
            o = i.get("urlParamNames"),
            a = o[0],
            c = o[1],
            r = new RegExp(a + "=([^$&]+)"),
            s = new RegExp(c + "=([^$&]+)");
        t.exports = function(e, n, t) {
            var i = location.search,
                o = i.match(r),
                a = i.match(s);
            o && a ? e({
                lat: o[1],
                lng: a[1]
            }) : t()
        }, t.exports.type = "url"
    }, {
        asyncDeps: d,
        map: e({
            "../config": t
        }, h)
    }), define(r, [t, f], function(e, n, t) {
        var i = e("../config"),
            o = e("../util"),
            a = function() {
                return /MicroMessenger/.test(navigator.userAgent)
            };
        t.exports = function(e, n, t) {
            if (a()) {
                var c = function() {
                    return "undefined" == typeof wx ? void t() : void wx.ready(function() {
                        wx.checkJsApi({
                            jsApiList: ["getLocation"],
                            success: function(i) {
                                i.checkResult && i.checkResult.getLocation ? wx.getLocation({
                                    type: "wgs84",
                                    success: function(n) {
                                        e({
                                            lat: n.latitude,
                                            lng: n.longitude
                                        })
                                    },
                                    fail: n
                                }) : t()
                            },
                            fail: t
                        })
                    })
                };
                i.get("wxAutoConfig") ? o.loadScript("http://res.wx.qq.com/open/js/jweixin-1.0.0.js", function() {
                    o.loadScript("http://" + (~location.hostname.indexOf("51ping.com") ? "tcps.51ping.com" : "cps.pigcms.com") + "/weixin/config.js?debug=false&apis=checkJsApi,getLocation", c)
                }) : c()
            } else t()
        }, t.exports.type = "weixin"
    }, {
        asyncDeps: d,
        map: e({
            "../config": t,
            "../util": f
        }, h)
    }), define(s, [f], function(e, n, t) {
        var i = e("../util"),
            o = function() {
                return ~navigator.userAgent.indexOf("MQQBrowser")
            };
        t.exports = function(e, n, t) {
            o() ? i.loadScript("http://jsapi.qq.com/get?api=app.getGeoLocation", function() {
                try {
                    browser.app.getGeoLocation(function(t) {
                        "true" === t.ret ? e({
                            lat: t.latitude,
                            lng: t.longitude
                        }) : n()
                    }, n)
                } catch (i) {
                    t()
                }
            }) : t()
        }, t.exports.type = "qqbrowser"
    }, {
        asyncDeps: d,
        map: e({
            "../util": f
        }, h)
    }), define(l, [], function(e, n, t) {
        var i = function() {
            return ~navigator.userAgent.indexOf("dianping")
        };
        t.exports = function(n, t, o) {
            i() ? e.async("dpapp", function(e) {
                e.ready(function() {
                    e.getLocation({
                        success: function(e) {
                            n({
                                lat: e.lat,
                                lng: e.lng
                            })
                        },
                        fail: t
                    })
                })
            }) : o()
        }, t.exports.type = "app"
    }, {
        asyncDeps: d,
        map: h
    }), define(u, [], function(e, n, t) {
        var i = function() {
            return !!navigator.geolocation
        };
        t.exports = function(e, n, t) {
            i() ? navigator.geolocation.getCurrentPosition(function(n) {
                e({
                    lat: n.coords.latitude,
                    lng: n.coords.longitude
                })
            }, n, {
                enableHighAccuracy: !0,
                maximumAge: 3e4,
                timeout: 1e4
            }) : t()
        }, t.exports.type = "html"
    }, {
        asyncDeps: d,
        map: h
    }), define(f, [], function(e, n) {
        n.loadScript = function(e, n) {
            var t = document.createElement("script");
            t.src = e, t.onload = n, document.getElementsByTagName("head")[0].appendChild(t)
        }
    }, {
        asyncDeps: d,
        map: h
    })
}();