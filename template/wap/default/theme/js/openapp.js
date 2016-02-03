define("openapp@0.1.7/index", [], function(i, n, o) {
    var e = navigator.userAgent,
        a = e.match(/android/i),
        t = e.match(/(ipad|iphone|ipod).*os\s([\d_]+)/i),
        d = e.match(/(ipad).*os\s([\d_]+)/i),
        r = function(i, n) {
            d && -1 == i.indexOf("dianpinghd:") && (i = "dianpinghd://homepage");
            var o = +new Date,
                r = function() {
                    var i = a && n.androidDownloadUrl ? n.androidDownloadUrl : t && n.iosDownloadUrl ? n.iosDownloadUrl : n.downloadUrl;
                    i && (location.href = i)
                },
                l = function() {
                    n.onFail && n.onFail(a ? "android" : t ? "ios" : ""), r()
                };
            if (a)
                if (e.match(/android 4.4/i) && e.match(/huawei/i)) r();
                else {
                    if (e.match(/Chrome/) || e.match(/Firefox/)) location.href = i;
                    else {
                        var c = document.createElement("div");
                        c.style.visibility = "hidden", c.innerHTML = '<iframe src="' + i + '" scrolling="no" width="1" height="1"></iframe>', document.body.appendChild(c)
                    }
                    setTimeout(function() {
                        var i = +new Date - o;
                        1e3 > i && (/^mtt_sdk/i.test(navigator.userAgent) ? r() : l())
                    }, 800)
                } else t ? (setTimeout(function() {
                var i = +new Date - o;
                1e3 > i && l()
            }, 800), window.location = i) : r()
        };
    o.exports = r
}, {
    main: !0
});