! function() {
    var n = "hippo@1.2.8/lib/hippo3.js",
        t = {},
        e = t;
    define(n, [], function(n, t, e) {
        ! function() {
            function n(n) {
                if (A) return n();
                if (S) return void R.push(n);
                S = !0, R.push(n);
                var t = m.DPApp && m.DPApp.callback,
                    e = {
                        _callbacks: {},
                        callback: function(n, e) {
                            var o = this._callbacks[n];
                            o && o.call(this, e), o || t && t(n, e)
                        },
                        dequeue: function() {},
                        getRequestId: function(n) {
                            function t() {
                                r.onload = r.onerror = null, r.parentNode && r.parentNode.removeChild(r)
                            }
                            var e = n.success;
                            this._callbacks[-1] = function(n) {
                                e && e(n)
                            };
                            var o = "js://_?method=getRequestId&args=%7B%7D&callbackId=-1",
                                r = document.createElement("iframe");
                            r.style.display = "none", r.onload = r.onerror = t, setTimeout(t, 5e3), r.src = o, document.body.appendChild(r)
                        }
                    };
                if (m.DPApp) {
                    if (!m.DPApp.getRequestId)
                        for (var o in e) m.DPApp[o] = e[o]
                } else m.DPApp = e;
                _(function() {
                    DPApp.getRequestId({
                        success: function(n) {
                            et.reqid = A = n.requestId, R.forEach(function(n) {
                                n()
                            }), S = !1
                        }
                    })
                })
            }

            function t(e, r, i, c) {
                if (/dp\/com\.pigcms/.test(navigator.userAgent) && !A) return et.appname = "dianping", void n(function() {
                    t(e, r, i, c)
                });
                var u = H + W(e, r, i);
                if (c) return void a(u);
                var f = setTimeout(function() {
                    O[f] = !1;
                    var n = new Image(1, 1);
                    j.push(n), o(n), n.src = u, u = null
                }, 0);
                O[f] = u
            }

            function o(n) {
                ["onload", "onerror", "onabort"].forEach(function(t) {
                    n[t] = function() {
                        try {
                            n.onload = n.onerror = n.onabort = null
                        } catch (e) {}
                        "onabort" === t && n.src && a(n.src), r(n, j)
                    }
                })
            }

            function r(n, t) {
                for (var e, o = 0, r = t.length; r > o; o++)
                    if (e = t[o], e === n) {
                        t.splice(o, 1);
                        break
                    }
            }

            function i() {
                return new XMLHttpRequest
            }

            function a(n) {
                var t = C();
                /^evt|h5/.test(location.host) || (n = n.replace(X, "")), t.open("GET", n, !1), t.send()
            }

            function c(n) {
                var t, e, o = encodeURIComponent,
                    r = [];
                for (t in n) e = n[t], Object(e) !== e && r.push(t + "=" + o(e || ""));
                return r.join("&")
            }

            function u(n, t, e) {
                var o;
                if (t) {
                    for (o in t) e && o in n || (n[o] = t[o]);
                    return n
                }
            }

            function f(n, t) {
                return "string" == typeof n && Object(t) !== t
            }

            function s(n) {
                return tt._setPageId(n), s
            }

            function p(n, t) {
                et[n] = t
            }

            function d(n) {
                t(z, [], n || Y), Y = {}
            }

            function l(n, t) {
                return n > 0 ? n : t
            }

            function h() {
                ot = +new Date
            }

            function v() {
                var n, t = m.performance,
                    e = t && t.timing,
                    o = ot - rt,
                    r = +new Date - rt,
                    i = {
                        r_pagetiming: 1,
                        r_ready: o,
                        r_load: r
                    };
                e && u(i, {
                    r_conn: e.connectEnd - e.connectStart,
                    r_recev: e.responseEnd - e.responseStart,
                    r_ready: l(e.domInteractive - e.domLoading, o),
                    r_wait: e.responseStart - e.requestStart,
                    r_load: l(e.loadEventStart - e.domLoading, r)
                }), ((n = Z) || (n = m.DP && DP.data && DP.data("hippo_perf_version"))) && (i.test = n), tt.mv(i), it(m, "load", v)
            }

            function _(n) {
                if ("complete" === y.readyState) return n();
                var t = y.documentElement.doScroll,
                    e = t ? "readystatechange" : "DOMContentLoaded",
                    o = function() {
                        it(y, e, o), it(m, "load", o), n()
                    };
                if (T(y, e, o), T(m, "load", o), t) {
                    var r = function() {
                            try {
                                t("left"), o()
                            } catch (n) {
                                setTimeout(r, 10)
                            }
                        },
                        i = !1;
                    try {
                        i = null == m.frameElement
                    } catch (a) {}
                    i && r()
                }
            }
            var m = window,
                g = m._hip,
                y = m.document,
                b = y.location,
                D = y.referrer,
                P = b.href,
                I = m.screen,
                E = y.createElement("div"),
                q = "addEventListener",
                w = "removeEventListener",
                T = E[q] ? function(n, t, e, o) {
                    n[q](t, e, !!o)
                } : function(n, t, e) {
                    n.attachEvent("on" + t, e)
                };
            if (g || (g = m._hip = []), !g.loaded) {
                g.loaded = !0;
                var j = [];
                g.queue = j;
                var A, S, O = {},
                    R = [],
                    C = m.ActiveXObject ? function() {
                        if (m.XMLHttpRequest) try {
                            return i()
                        } catch (n) {}
                        try {
                            return new m.ActiveXObject("Microsoft.XMLHTTP")
                        } catch (n) {}
                    } : i,
                    L = !1;
                m.onbeforeunload = m.onunload = function() {
                    if (!L) {
                        L = !0;
                        var n, t;
                        for (n in O) t = O[n], t && (clearTimeout(Number(n)), a(t))
                    }
                };
                var k = 0,
                    x = 0,
                    V = 0,
                    M = "www.pigcms.com",
                    N = function() {},
                    X = "http://hls." + (/51ping/.test(y.domain) ? "51ping" : "dianping") + ".com",
                    H = X + "/hippo.gif?",
                    G = "__hsr",
                    J = "__hsc",
                    B = "__hlh",
                    U = "__hlr",
                    z = "__pv",
                    F = "__mv",
                    K = function() {
                        return m.JSON && JSON.stringify || function(n) {
                            var t, e, o = [];
                            for (t in n) e = n[t], Object(e) !== e && o.push('"' + t + '":"' + ("" + e).replace(/"/g, '\\"') + '"');
                            return "{" + o.join(",") + "}"
                        }
                    }(),
                    Q = Array.prototype;
                Q.forEach || (Q.forEach = function(n, t) {
                    for (var e = 0, o = this.length; o > e; e++) e in this && n.call(t, this[e], e, this)
                });
                var W = function() {
                        var n, t, e, o, r = {};
                        return (e = I) && (n = e.height, t = e.width, n && t && (r[G] = t + "x" + n), (o = e.colorDepth) && (r[J] = o + "bit")),
                            function(n, t, e) {
                                e = e || {}, u(e, et, !1);
                                var o = {
                                    __hlt: M,
                                    __ppp: k,
                                    __had: K(e),
                                    force: +new Date
                                };
                                return u(o, r), P && (o[B] = P), D && (o[U] = D), t.push(V + "|" + x), o[n] = t.join("|"), c(o)
                            }
                    }(),
                    Y = {};
                u(s, {
                    ext: function(n, t) {
                        var e;
                        if (Object(n) === n)
                            for (e in n) s.ext(e, n[e]);
                        else f(n, t) && (Y[n] = t);
                        return s
                    },
                    rxt: function(n) {
                        return "string" == typeof n ? delete Y[n] : arguments.length || (Y = {}), s
                    },
                    pv: function(n, t) {
                        return tt._setCityId(n), tt._setShopType(t), tt._setPVInitData(Y), s
                    },
                    mv: function(n, t) {
                        return f(n, t) && (Y[n] = t, tt.mv(Y)), s
                    }
                }), document.hippo = s;
                var Z, $ = !0,
                    nt = !0,
                    tt = {
                        _setPageId: function(n) {
                            k = n >>> 0
                        },
                        _setCityId: function(n) {
                            V = n >>> 0
                        },
                        _setShopType: function(n) {
                            x = n >>> 0
                        },
                        _setPVInitData: function(n) {
                            tt._setPVInitData = N, setTimeout(function() {
                                d(n)
                            }, 0)
                        },
                        _autoPV: function(n) {
                            $ = n
                        },
                        _autoPageTiming: function(n) {
                            nt = n
                        },
                        _setPageTimingVer: function(n) {
                            Z = n
                        },
                        _setReferrer: function(n) {
                            D = n
                        },
                        _setHref: function(n) {
                            P = n
                        },
                        _setRequestId: function(n) {
                            p("reqid", n)
                        },
                        _setGuid: function(n) {
                            p("serverguid", n)
                        },
                        _setCustomConst: p,
                        mv: function(n, e) {
                            t(F, ["", ""], n || Y, e), Y = {}
                        },
                        pv: function(n) {
                            d(n)
                        }
                    },
                    et = {};
                g.push = function(n) {
                    var t, e;
                    n && (t = n.shift(), e = tt[t], e && e.apply(null, n))
                }, g.forEach(function(n) {
                    g.push(n)
                }), $ && g.push(["_setPVInitData"]), g.length = 0;
                var ot, rt = m.G_rtop,
                    it = E[w] ? function(n, t, e, o) {
                        n[w](t, e, !!o)
                    } : function(n, t, e) {
                        n.detachEvent("on" + t, e)
                    };
                nt && (_(h), T(m, "load", v)), "undefined" != typeof e && e.exports && (e.exports = g)
            }
        }()
    }, {
        main: !0,
        map: e
    })
}();

define("cookie@0.2.0/cookie", [], function(e, n, r) {
    function o(e) {
        return f.raw ? e : encodeURIComponent(e)
    }

    function t(e) {
        return f.raw ? e : decodeURIComponent(e)
    }

    function i(e) {
        return o(f.json ? JSON.stringify(e) : String(e))
    }

    function c(e) {
        0 === e.indexOf('"') && (e = e.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\"));
        try {
            return e = decodeURIComponent(e.replace(l, " ")), f.json ? JSON.parse(e) : e
        } catch (n) {}
    }

    function u(e, n) {
        var r = f.raw ? e : c(e);
        return s(n) ? n(r) : r
    }
    var a, f, p, s = function(e) {
            return "[object Function]" == Object.prototype.toString.call(e)
        },
        d = function(e) {
            return Array.prototype.slice.call(arguments, 1).forEach(function(n) {
                if (n)
                    for (var r in n) e[r] = n[r]
            }), e
        },
        l = /\+/g;
    f = a = function(e, n, r) {
        if (void 0 !== n && !s(n)) {
            if (r = d({}, f.defaults, r), "number" == typeof r.expires) {
                var c = r.expires,
                    a = r.expires = new Date;
                a.setTime(+a + 864e5 * c)
            }
            return document.cookie = [o(e), "=", i(n), r.expires ? "; expires=" + r.expires.toUTCString() : "", r.path ? "; path=" + r.path : "", r.domain ? "; domain=" + r.domain : "", r.secure ? "; secure" : ""].join("")
        }
        for (var p = e ? void 0 : {}, l = document.cookie ? document.cookie.split("; ") : [], m = 0, v = l.length; v > m; m++) {
            var g = l[m].split("="),
                x = t(g.shift()),
                h = g.join("=");
            if (e && e === x) {
                p = u(h, n);
                break
            }
            e || void 0 === (h = u(h)) || (p[x] = h)
        }
        return p
    }, f.defaults = {}, p = function(e, n) {
        return void 0 === a(e) ? !1 : (a(e, "", d({}, n, {
            expires: -1
        })), !a(e))
    }, a.remove = p, r.exports = a
}, {
    main: !0
});

define("cookie@0.1.2/cookie", [], function(e, n, r) {
    function o(e) {
        return f.raw ? e : encodeURIComponent(e)
    }

    function t(e) {
        return f.raw ? e : decodeURIComponent(e)
    }

    function i(e) {
        return o(f.json ? JSON.stringify(e) : String(e))
    }

    function c(e) {
        0 === e.indexOf('"') && (e = e.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\"));
        try {
            return e = decodeURIComponent(e.replace(l, " ")), f.json ? JSON.parse(e) : e
        } catch (n) {}
    }

    function u(e, n) {
        var r = f.raw ? e : c(e);
        return s(n) ? n(r) : r
    }
    var a, f, p, s = function(e) {
            return "[object Function]" == Object.prototype.toString.call(e)
        },
        d = function(e) {
            return Array.prototype.slice.call(arguments, 1).forEach(function(n) {
                if (n)
                    for (var r in n) e[r] = n[r]
            }), e
        },
        l = /\+/g;
    f = a = function(e, n, r) {
        if (void 0 !== n && !s(n)) {
            if (r = d({}, f.defaults, r), "number" == typeof r.expires) {
                var c = r.expires,
                    a = r.expires = new Date;
                a.setTime(+a + 864e5 * c)
            }
            return document.cookie = [o(e), "=", i(n), r.expires ? "; expires=" + r.expires.toUTCString() : "", r.path ? "; path=" + r.path : "", r.domain ? "; domain=" + r.domain : "", r.secure ? "; secure" : ""].join("")
        }
        for (var p = e ? void 0 : {}, l = document.cookie ? document.cookie.split("; ") : [], m = 0, v = l.length; v > m; m++) {
            var g = l[m].split("="),
                x = t(g.shift()),
                h = g.join("=");
            if (e && e === x) {
                p = u(h, n);
                break
            }
            e || void 0 === (h = u(h)) || (p[x] = h)
        }
        return p
    }, f.defaults = {}, p = function(e, n) {
        return void 0 === a(e) ? !1 : (a(e, "", d({}, n, {
            expires: -1
        })), !a(e))
    }, a.remove = p, r.exports = a
}, {
    main: !0
});