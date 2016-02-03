! function() {
    function t(t, r) {
        for (var e in r) t[e] = r[e];
        return t
    }
    var r = "xss@0.1.0/js/default.js",
        e = "xss@0.1.0/js/parser.js",
        n = "xss@0.1.0/js/xss.js",
        i = "xss@0.1.0/js/util.js",
        o = "xss@0.1.0/index.js",
        s = {},
        a = s;
    define(o, [r, e, n], function(t, r, e) {
        function n(t, r) {
            var e = new i(r);
            return e.process(t)
        }
        var i = (t("./js/default"), t("./js/parser"), t("./js/xss"));
        r = e.exports = n
    }, {
        main: !0,
        map: t({
            "./js/default": r,
            "./js/parser": e,
            "./js/xss": n
        }, a)
    }), define(r, [i], function(t, r) {
        function e() {}

        function n() {}

        function i() {}

        function o() {}

        function s(t) {
            return t.replace(x, "&lt;").replace(b, "&gt;")
        }

        function a(t, r, e) {
            if (e = p(e), "href" === r || "src" === r) {
                if (e = A.trim(e), "#" === e) return "#";
                if ("http://" !== e.substr(0, 7) && "https://" !== e.substr(0, 8) && "mailto:" !== e.substr(0, 7) && "/" !== e[0]) return ""
            } else if ("background" === r) {
                if (k.lastIndex = 0, k.test(e)) return ""
            } else if ("style" === r) {
                if (S.lastIndex = 0, S.test(e)) return "";
                if (B.lastIndex = 0, B.test(e)) return "";
                if (E.lastIndex = 0, E.test(e) && (k.lastIndex = 0, k.test(e))) return ""
            }
            return e = d(e)
        }

        function l(t) {
            return t.replace(w, "&quot;")
        }

        function u(t) {
            return t.replace(j, '"')
        }

        function c(t) {
            return t.replace(y, function(t, r) {
                return String.fromCharCode("x" === r[0] || "X" === r[0] ? parseInt(r.substr(1), 16) : parseInt(r, 10))
            })
        }

        function f(t) {
            return t.replace(C, ":").replace(O, " ")
        }

        function g(t) {
            for (var r = "", e = 0, n = t.length; n > e; e++) r += t.charCodeAt(e) < 32 ? " " : t.charAt(e);
            return A.trim(r)
        }

        function p(t) {
            return t = u(t), t = c(t), t = f(t), t = g(t)
        }

        function d(t) {
            return t = l(t), t = s(t)
        }

        function h() {
            return ""
        }

        function v(t, r) {
            function e(r) {
                return n ? !0 : -1 !== A.indexOf(t, r)
            }
            "function" != typeof r && (r = function() {});
            var n = !Array.isArray(t),
                i = [],
                o = !1;
            return {
                onIgnoreTag: function(t, n, s) {
                    if (e(t)) {
                        if (s.isClosing) {
                            var a = "[/removed]",
                                l = s.position + a.length;
                            return i.push([o !== !1 ? o : s.position, l]), o = !1, a
                        }
                        return o || (o = s.position), "[removed]"
                    }
                    return r(t, n, s)
                },
                remove: function(t) {
                    var r = "",
                        e = 0;
                    return A.forEach(i, function(n) {
                        r += t.slice(e, n[0]), e = n[1]
                    }), r += t.slice(e)
                }
            }
        }

        function m(t) {
            return t.replace(H, "")
        }

        function T(t) {
            var r = t.split("");
            return r = r.filter(function(t) {
                var r = t.charCodeAt(0);
                return 127 === r ? !1 : 31 >= r ? 10 === r || 13 === r ? !0 : !1 : !0
            }), r.join("")
        }
        var A = t("./util"),
            I = {
                a: ["target", "href", "title"],
                abbr: ["title"],
                address: [],
                area: ["shape", "coords", "href", "alt"],
                article: [],
                aside: [],
                audio: ["autoplay", "controls", "loop", "preload", "src"],
                b: [],
                bdi: ["dir"],
                bdo: ["dir"],
                big: [],
                blockquote: ["cite"],
                br: [],
                caption: [],
                center: [],
                cite: [],
                code: [],
                col: ["align", "valign", "span", "width"],
                colgroup: ["align", "valign", "span", "width"],
                dd: [],
                del: ["datetime"],
                details: ["open"],
                div: [],
                dl: [],
                dt: [],
                em: [],
                font: ["color", "size", "face"],
                footer: [],
                h1: [],
                h2: [],
                h3: [],
                h4: [],
                h5: [],
                h6: [],
                header: [],
                hr: [],
                i: [],
                img: ["src", "alt", "title", "width", "height"],
                ins: ["datetime"],
                li: [],
                mark: [],
                nav: [],
                ol: [],
                p: [],
                pre: [],
                s: [],
                section: [],
                small: [],
                span: [],
                sub: [],
                sup: [],
                strong: [],
                table: ["width", "border", "align", "valign"],
                tbody: ["align", "valign"],
                td: ["width", "colspan", "align", "valign"],
                tfoot: ["align", "valign"],
                th: ["width", "colspan", "align", "valign"],
                thead: ["align", "valign"],
                tr: ["rowspan", "align", "valign"],
                tt: [],
                u: [],
                ul: [],
                video: ["autoplay", "controls", "loop", "preload", "src", "height", "width"]
            },
            x = /</g,
            b = />/g,
            w = /"/g,
            j = /&quot;/g,
            y = /&#([a-zA-Z0-9]*);?/gim,
            C = /&colon;?/gim,
            O = /&newline;?/gim,
            S = /\/\*|\*\//gm,
            k = /((j\s*a\s*v\s*a|v\s*b|l\s*i\s*v\s*e)\s*s\s*c\s*r\s*i\s*p\s*t\s*|m\s*o\s*c\s*h\s*a)\:/gi,
            B = /e\s*x\s*p\s*r\s*e\s*s\s*s\s*i\s*o\s*n\s*\(.*/gi,
            E = /u\s*r\s*l\s*\(.*/gi,
            H = /<!--[\s\S]*?-->/g;
        r.whiteList = I, r.onTag = e, r.onIgnoreTag = n, r.onTagAttr = i, r.onIgnoreTagAttr = o, r.safeAttrValue = a, r.escapeHtml = s, r.escapeQuote = l, r.unescapeQuote = u, r.escapeHtmlEntities = c, r.escapeDangerHtml5Entities = f, r.clearNonPrintableCharacter = g, r.friendlyAttrValue = p, r.escapeAttrValue = d, r.onIgnoreTagStripAll = h, r.StripTagBody = v, r.stripCommentTag = m, r.stripBlankChar = T
    }, {
        map: t({
            "./util": i
        }, a)
    }), define(e, [i], function(t, r) {
        function e(t) {
            var r = t.indexOf(" ");
            if (-1 === r) var e = t.slice(1, -1);
            else var e = t.slice(1, r + 1);
            return e = s.trim(e).toLowerCase(), "/" === e[0] && (e = e.slice(1)), "/" === e[e.length - 1] && (e = e.slice(0, -1)), e
        }

        function n(t) {
            return "</" === t.slice(0, 2)
        }

        function i(t, r, i) {
            "user strict";
            var o = "",
                s = 0,
                a = !1,
                l = !1,
                u = 0,
                c = t.length,
                f = "",
                g = "";
            for (u = 0; c > u; u++) {
                var p = t.charAt(u);
                if (a === !1) {
                    if ("<" === p) {
                        a = u;
                        continue
                    }
                } else if (l === !1) {
                    if ("<" === p) {
                        o += i(t.slice(s, u)), a = u, s = u;
                        continue
                    }
                    if (">" === p) {
                        o += i(t.slice(s, a)), f = t.slice(a, u + 1), g = e(f), o += r(a, o.length, g, f, n(f)), s = u + 1, a = !1;
                        continue
                    }
                    if ('"' === p || "'" === p) {
                        l = p;
                        continue
                    }
                } else if (p === l) {
                    l = !1;
                    continue
                }
            }
            return s < t.length && (o += i(t.substr(s))), o
        }

        function o(t, r) {
            "user strict";

            function e(t, e) {
                t = s.trim(t), t = t.replace(a, "").toLowerCase(), t.length < 1 || i.push(r(t, e || ""))
            }
            for (var n = 0, i = [], o = !1, l = t.length, u = 0; l > u; u++) {
                var c, f = t.charAt(u);
                if (o !== !1 || "=" !== f)
                    if (o === !1 || u !== n || '"' !== f && "'" !== f) " " !== f || (c = s.trim(t.slice(n, u)), o === !1 ? e(c) : e(o, c), o = !1, n = u + 1);
                    else {
                        var g = t.indexOf(f, u + 1);
                        if (-1 === g) break;
                        c = s.trim(t.slice(n + 1, g)), e(o, c), o = !1, u = g, n = u + 1
                    } else o = t.slice(n, u), n = u + 1
            }
            return n < t.length && (o === !1 ? e(t.slice(n)) : e(o, t.slice(n))), s.trim(i.join(" "))
        }
        var s = t("./util"),
            a = /[^a-zA-Z0-9_:\.\-]/gim;
        r.parseTag = i, r.parseAttr = o
    }, {
        map: t({
            "./util": i
        }, a)
    }), define(n, [r, e, i], function(t, r, e) {
        function n(t) {
            return void 0 === t || null === t
        }

        function i(t) {
            var r = t.indexOf(" ");
            if (-1 === r) return {
                html: "",
                closing: "/" === t[t.length - 2]
            };
            t = c.trim(t.slice(r + 1, -1));
            var e = "/" === t[t.length - 1];
            return e && (t = c.trim(t.slice(0, -1))), {
                html: t,
                closing: e
            }
        }

        function o(t) {
            t = t || {}, t.stripIgnoreTag && (t.onIgnoreTag && console.error('Notes: cannot use these two options "stripIgnoreTag" and "onIgnoreTag" at the same time'), t.onIgnoreTag = s.onIgnoreTagStripAll), t.whiteList = t.whiteList || s.whiteList, t.onTag = t.onTag || s.onTag, t.onTagAttr = t.onTagAttr || s.onTagAttr, t.onIgnoreTag = t.onIgnoreTag || s.onIgnoreTag, t.onIgnoreTagAttr = t.onIgnoreTagAttr || s.onIgnoreTagAttr, t.safeAttrValue = t.safeAttrValue || s.safeAttrValue, t.escapeHtml = t.escapeHtml || s.escapeHtml, this.options = t
        }
        var s = t("./default"),
            a = t("./parser"),
            l = a.parseTag,
            u = a.parseAttr,
            c = t("./util");
        o.prototype.process = function(t) {
            if (t = t || "", t = t.toString(), !t) return "";
            var r = this,
                e = r.options,
                o = e.whiteList,
                a = e.onTag,
                f = e.onIgnoreTag,
                g = e.onTagAttr,
                p = e.onIgnoreTagAttr,
                d = e.safeAttrValue,
                h = e.escapeHtml;
            if (e.stripBlankChar && (t = s.stripBlankChar(t)), e.allowCommentTag || (t = s.stripCommentTag(t)), e.stripIgnoreTagBody) {
                var v = s.StripTagBody(e.stripIgnoreTagBody, f);
                f = v.onIgnoreTag
            } else v = !1;
            var m = l(t, function(t, r, e, s, l) {
                var v = {
                        sourcePosition: t,
                        position: r,
                        isClosing: l,
                        isWhite: e in o

                    },
                    m = a(e, s, v);
                if (!n(m)) return m;
                if (v.isWhite) {
                    if (v.isClosing) return "</" + e + ">";
                    var T = i(s),
                        A = o[e],
                        I = u(T.html, function(t, r) {
                            var i = -1 !== c.indexOf(A, t),
                                o = g(e, t, r, i);
                            if (!n(o)) return o;
                            if (i) return r = d(e, t, r), r ? t + '="' + r + '"' : t;
                            var o = p(e, t, r, i);
                            return n(o) ? void 0 : o
                        }),
                        s = "<" + e;
                    return I && (s += " " + I), T.closing && (s += " /"), s += ">"
                }
                var m = f(e, s, v);
                return n(m) ? h(s) : m
            }, h);
            return v && (m = v.remove(m)), m
        }, e.exports = o
    }, {
        map: t({
            "./default": r,
            "./parser": e,
            "./util": i
        }, a)
    }), define(i, [], function(t, r, e) {
        e.exports = {
            indexOf: function(t, r) {
                var e, n;
                if (Array.prototype.indexOf) return t.indexOf(r);
                for (e = 0, n = t.length; n > e; e++)
                    if (t[e] === r) return e;
                return -1
            },
            forEach: function(t, r, e) {
                var n, i;
                if (Array.prototype.forEach) return t.forEach(r, e);
                for (n = 0, i = t.length; i > n; n++) r.call(e, t[n], n, t)
            },
            trim: function(t) {
                return String.prototype.forEach ? t.trim() : t.replace(/(^\s*)|(\s*$)/g, "")
            }
        }
    }, {
        map: a
    })
}();