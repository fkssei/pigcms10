! function() {
    function n(n, e) {
        for (var r in e) n[r] = e[r];
        return n
    }
    var e = "m-performance@0.1.1/send.js",
        r = "m-performance@0.1.1/index.js",
        a = {},
        i = a;
    define(r, [e], function(n, e) {
        function r() {
            return window.performance && window.performance.timing
        }
        var a, i = {},
            o = n("./send"),
            t = function() {
                var n = performance.timing;
                i.onload = n.loadEventStart - n.navigationStart, window.P_FirstScreenTime && o(a, "fs", window.P_FirstScreenTime - n.navigationStart), o(a, "onload", i.onload)
            },
            c = function(n) {
                r() && (n && n.pageName && (a = n.pageName), "complete" == document.readyState ? t() : window.addEventListener("load", t, !1))
            };
        e.init = c
    }, {
        main: !0,
        map: n({
            "./send": e
        }, i)
    }), define(e, [], function(n, e, r) {
        r.exports = function(n, e, r) {
            if (n && e) {
                var a = {
                        v: 1,
                        ts: +new Date,
                        tu: "m-performance-" + n + "-" + e,
                        d: r,
                        hs: 200,
                        ec: ""
                    },
                    i = [];
                for (var o in a) a.hasOwnProperty(o) && i.push(o + "=" + a[o]);
                var t = new Image;
                t.src = "http://114.80.165.63/broker-service/api/single?" + i.join("&")
            }
        }
    }, {
        map: i
    })
}();