! function() {
    var n = "hippo@~1.2.2",
        t = "nugget-mobile@0.1.3/index.js",
        e = {},
        i = e;
    define(t, [n], function(n, t, e) {
        "use strict";
        n("hippo");
        var i = 1,
            o = function(n, t) {
                var e = ["webkit", "ms"],
                    i = null;
                if (!n) return !1;
                if (e.forEach(function(t) {
                        var e = t + "MatchesSelector";
                        n[e] && (i = e)
                    }), !i) throw "MatchesSelector is not supported";
                return n[i](t)
            },
            r = {
                $: function(n) {
                    var t = document.querySelectorAll(n);
                    return Array.prototype.slice.apply(t)
                },
                sub: function(n, t) {
                    return ("" + n).replace(/\\?\{([^{}]+)\}/g, function(n, e) {
                        return "\\" === n.charAt(0) ? n.slice(1) : null !== t[e] ? t[e] : ""
                    })
                },
                mix: function(n, t) {
                    for (var e in t) n[e] = t[e];
                    return n
                },
                toElem: function(n) {
                    return n
                },
                live: function(n, t, e) {
                    document.querySelector("body").addEventListener(n, function(n) {
                        for (var i = n.target; i && i != document.body;) o(i, t) && e.call(i), i = i.parentElement
                    })
                },
                getJSON: function(n) {
                    n(JSON)
                },
                jsonp: function(n, t) {
                    var e = document.createElement("script"),
                        o = "jsonp_callback_" + i;
                    e.src = n + "&callback=" + o;
                    var r = document.getElementsByTagName("head")[0];
                    r.appendChild(e), i++, window[o] = t, e.addEventListener("load", function() {
                        window[o] = null
                    })
                },
                ready: function(n) {
                    n()
                }
            };
        ! function(n) {
            function t(n) {
                return !!n.offsetParent
            }

            function i() {
                for (var n = document.scripts, t = null, e = 0, i = n.length; i > e; e++) {
                    var o = n[e],
                        r = o.innerHTML;
                    r.match(/_setPageId/) && (t = r)
                }
                var c = new Function(t + "\nreturn _hip"),
                    u = c(),
                    a = u.filter(function(n) {
                        return "_setPageId" == n[0]
                    })[0][1];
                return a
            }

            function o(n) {
                _gaq.push(["_trackPageview", n || ""])
            }

            function r(n, t, e, i) {
                function o(n) {
                    var t = "";
                    if (n) {
                        for (; n !== document.body && !(t = n.getAttribute("href") || "");) n = n.parentNode;
                        return t
                    }
                    return ""
                }

                function r(n) {
                    return n && (n.getAttribute("title") || n.innerText || n.textContent)
                }

                function c(n, t) {
                    var e = 500,
                        i = 2048,
                        o = i - e;
                    m(function(e) {
                        function i(n) {
                            return encodeURIComponent(e.stringify(n)).length
                        }
                        var r = [n],
                            c = i(n),
                            u = n.content.split("|"),
                            a = n.title.split("|"),
                            f = (n.index + "").split("|");
                        c > o && (r = u.map(function(t, e) {
                            var i = l({}, n);
                            return l(i, {
                                content: u[e],
                                title: a[e],
                                index: f[e]
                            }), i
                        })), t(r)
                    })
                }
                e = e || {}; {
                    var u = "number" == typeof this.length && this.slice;
                    Object.keys(e).filter(function(n) {
                        return 0 === n.indexOf("hippo-")
                    }).forEach(function(n) {
                        e[n.split("hippo-")[1]] = e[n], delete e[n]
                    })
                }
                if (!u || this.length) {
                    var a = u ? this.map(o).join("|") : o(this),
                        f = u ? this.map(r).join("|") : r(this);
                    u && (e.index = this.map(function(n, t) {
                        return t + 1
                    }).join("|"));
                    var s = l({
                        module: n,
                        action: "show" == t ? "browse" : t,
                        content: a,
                        title: f
                    }, e);
                    c(s, function(n) {
                        n.forEach(function(n) {
                            _hip.push(["mv", n, i])
                        })
                    })
                }
            }

            function c(n, t) {
                t = t || "data-";
                for (var e, i = {}, o = [], r = 0, c = n.attributes, u = c.length; u > r; r++) e = c.item(r).nodeName, 0 === e.indexOf(t) && o.push(e);
                return o.forEach(function(e) {
                    i[e.split(t)[1]] = n.getAttribute(e)
                }), i
            }

            function u(n, e) {
                function i(t) {
                    var i, r = s(u),
                        a = d(r).indexOf(this) + 1,
                        f = c(this),
                        h = c(this, "data-" + e + "-"),
                        g = {
                            index: a
                        };
                    l(g, w), l(g, f), l(g, h), i = p(n.key, g), o.call(this, p(i, {
                        n: a
                    }), t, g, n.isSync)
                }
                var o = y[e],
                    r = (n.key, n.actions),
                    u = n.selector;
                r.forEach(function(e) {
                    "show" == e ? v(function() {
                        o.call(d(s(u)).filter(t), n.key, e, {})
                    }) : (e = "hover" === e ? "mouseenter" : e, g(e, u, function() {
                        i.call(this, e)
                    }))
                })
            }

            function a(n) {
                var t = ["hippo", "ga"][n.type];
                n.configInfo.forEach(function(n) {
                    u({
                        selector: "body" == n.parent ? n.selector : n.parent ? [n.parent, n.selector].join(" ") : n.selector,
                        key: n.moduleId,
                        actions: n.actions
                    }, t)
                })
            }

            function f(n, t) {
                function e(n) {
                    window.console && console.warn(n)
                }
                if (window.nuggetInited) return void e("nugget is already initiated");
                window.nuggetInited = !0, t && (n = c(document.getElementById("nugget")));
                var o = i();
                if (l(w, n), !o) return void e("nugget:pageId not specified");
                var r = location.host.match(".pigcms.com") ? "nugget.pigcms.com" : "192.168.215.64";
                h("http://" + r + "/jsonp/loggingconfig?pageId=" + o, function(n) {
                    n.success ? n.result.forEach(a) : e(n.message)
                })
            }
            var s = n.$,
                l = n.mix,
                d = n.toElem,
                p = n.sub,
                h = n.jsonp,
                g = n.live,
                m = n.getJSON,
                v = n.ready;
            window.nuggetLoaded = !0;
            var y = {
                    ga: o,
                    hippo: r
                },
                w = {
                    n: "{n}"
                };
            e.exports = {
                init: f
            }
        }(r)
    }, {
        main: !0,
        map: i
    })
}();