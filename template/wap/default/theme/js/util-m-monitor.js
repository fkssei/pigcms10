! function() {
    var t = "util-m-monitor@0.1.4/index.js",
        e = {},
        i = e;
    define(t, [], function(t, e, i) {
        "use strict";
        var o = 20002,
            n = "http://report.huatuo.qq.com/report.cgi",
            p = window.performance,
            s = function(t, e, i, s) {
                var r = this;
                if (this.speedFlag = t || [], this.autoReport = e || !0, this.appId = i || o, this.reportBase = s || n, p) {
                    this.speedparams = [];
                    for (var a = 1; a <= this.speedFlag.length; a++) this.speedparams.push("flag" + a + "=" + encodeURIComponent(this.speedFlag[a - 1]));
                    this.timepoints = [], this.timepoints[0] = 0, e && this.doReport(r.reportTiming)
                }
            };
        s.prototype.reportTiming = function(t, e) {
            var i = this,
                o = p.timing;
            i.timepoints[1] = o.unloadEventStart, i.timepoints[2] = o.unloadEventEnd, i.timepoints[3] = o.redirectStart, i.timepoints[4] = o.redirectEnd, i.timepoints[5] = o.fetchStart, i.timepoints[6] = o.domainLookupStart, i.timepoints[7] = o.domainLookupEnd, i.timepoints[8] = o.connectStart, i.timepoints[9] = o.connectEnd, i.timepoints[10] = o.requestStart, i.timepoints[11] = o.responseStart, i.timepoints[12] = o.responseEnd, i.timepoints[13] = o.domLoading, i.timepoints[14] = o.domInteractive, i.timepoints[15] = o.domContentLoadedEventStart, i.timepoints[16] = o.domContentLoadedEventEnd, i.timepoints[17] = o.domComplete, i.timepoints[18] = o.loadEventStart, i.timepoints[19] = o.loadEventEnd;
            for (var n = 1; n < i.timepoints.length; ++n) {
                var s = i.timepoints[n] || 0;
                s = Math.max(0, s - e), t.push(n + "=" + s)
            }
        }, s.prototype.doReport = function(t, e) {
            var i = this,
                o = p.timing.navigationStart,
                n = p.timing.loadEventEnd,
                s = this._copy(this.speedparams),
                r = setInterval(function() {
                    if (n = p.timing.loadEventEnd, n - o > 0) {
                        if (t) {
                            if ("function" == typeof t) t.call(i, s, o);
                            else if ("number" == typeof t && "number" == typeof e) {
                                i.timepoints[t] = e;
                                var a = i.timepoints[t] || 0;
                                a = Math.max(0, a - o), s.push(t + "=" + a)
                            }
                        } else
                            for (var m = 1; m < i.timepoints.length; ++m) {
                                var a = i.timepoints[m] || 0;
                                a = Math.max(0, a - o), s.push(m + "=" + a)
                            }
                        var d = "appid=" + i.appId + "&speedparams=" + encodeURIComponent(s.join("&")),
                            h = "http://report.huatuo.qq.com/report.cgi?" + d,
                            c = new Image;
                        c.src = h, clearInterval(r)
                    }
                }, 1e3)
        }, s.prototype._copy = function(t) {
            var e = [];
            return t && "object" == typeof t && t.length ? (t.forEach(function(t) {
                e.push(t)
            }), e) : e
        }, i.exports = s
    }, {
        main: !0,
        map: i
    })
}();