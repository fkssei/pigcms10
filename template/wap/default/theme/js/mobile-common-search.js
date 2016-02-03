! function() {
    var t = "xss@~0.1.0",
        e = "zepto@^1.2.1",
        s = "mobile-common-search@0.5.1/index.js",
        i = {},
        o = i;
    define(s, [t, e], function(t, e, s) {
        var i = t("xss"),
            o = function(t, e) {
                for (var s in e) e.hasOwnProperty(s) && (t[s] = e[s]);
                return t
            },
            r = function(t, e) {
                return "function" == typeof t && (t = t(e)), t.replace(/{([^{}]*)}/g, function(t, s) {
                    return s in e ? e[s] : ""
                })
            },
            n = function() {
                var t = window.localStorage && null != window.localStorage,
                    e = "local_test";
                if (t) try {
                    localStorage.setItem(e, 1), localStorage.removeItem(e)
                } catch (s) {
                    return !1
                }
                return t
            },
            a = t("zepto"),
            c = '<div class="J_search_container search_container" style="display:none ;"> <form class="J_form" method="post">  <div class="head_cnt"> <div class="head_cnt_input"> <input type="text" name="keyword" class="search J_search_input" autocomplete="off"> <input type="submit"> </div> <a class="cancel J_cancel" href="javascript:;">取消</a> </div>  <div class="J_key_list key_list Fix"> </div> <div class="J_history_list key_list Fix"> </div> <a class="J_history_clear link-btn" href="javascript:;">清除历史记录</a> <ul class="J_suggest_list suggest_list"> </ul> </form> </div>',
            h = function(t, e, s) {
                t && a(t).length && (this.trigger = t = a(t), this.searchContainer = s = a(s || c), this.searchContainer.appendTo(document.body), this.options = o({
                    triggerEvent: "focus",
                    suggestPostKey: "keyword",
                    suggestEncode: !1,
                    suggestUrl: "",
                    suggestItemTemplate: '<li><a href="javascript:;">{keyword}<span class="number">约{num}个结果</span></a></li>',
                    getSuggestList: function(t) {
                        return t.message.result
                    },
                    suggestOnclick: function(t) {
                        this.search(t.keyword)
                    },
                    localStorageKey: "searchstorage",
                    historyItemTemplate: '<a href="javascript:void(0)" data-id="{index}">{keyword}</a>',
                    historyOnclick: function(t) {
                        this.search(t)
                    },
                    historyLength: 20,
                    method: "post",
                    ajaxType: "json",
                    onHistoryShow: function() {},
                    onKeywordShow: function() {},
                    validate: function() {
                        return !0
                    }
                }, e), this.searchInput = s.find(".J_search_input"), this.form = s.find(".J_form"), this.cancelBtn = s.find(".J_cancel"), this.keyList = s.find(".J_key_list"), this.historyList = s.find(".J_history_list"), this.suggestList = s.find(".J_suggest_list"), this.historyClearBtn = s.find(".J_history_clear"), this.currentKey = this.searchInput.val() || "", this.currentSuggestId = 0, this._initEvent())
            };
        h.prototype._initEvent = function() {
            var t = this;
            this.trigger.on(this.options.triggerEvent || "focus", function(e) {
                e.preventDefault(), t.show(), t.searchInput.get(0).focus(), t.showKeywordOrHistory()
            }), this.cancelBtn.on("click", function() {
                t.hide()
            }), this.searchInput.on("focus", function() {
                t.timer = setInterval(function() {
                    t.suggest()
                }, 500)
            }), this.searchInput.on("blur", function() {
                clearInterval(t.timer)
            }), this.form.on("submit", function(e) {
                var s = t.searchInput.val().trim();
                return t.options.validate(s) ? void t.addHistory(s) : void e.preventDefault()
            }), this.historyClearBtn.on("click", function() {
                t.clearHistory()
            })
        }, h.prototype.show = function() {
            window.scrollTo(0, 0), this.searchContainer.css({
                top: 0,
                height: a(document).height()
            }).show()
        }, h.prototype.hide = function() {
            var t = this.searchContainer;
            t.animate({
                top: "100%"
            }, 300, "ease-out", function() {
                t.hide()
            })
        }, h.prototype.showHistory = function() {
            if (n()) {
                var t = this.options,
                    e = this,
                    s = this._historyParse();
                e.historyList.empty().show(), s.length ? e.historyClearBtn.show() : e.historyClearBtn.hide(), s.forEach(function(s, i) {
                    a(r(t.historyItemTemplate, {
                        keyword: s
                    })).prependTo(e.historyList).on("click", function() {
                        t.historyOnclick.call(e, s, i)
                    })
                })
            }
        }, h.prototype.addHistory = function(t) {
            if (t) {
                var e = this._historyParse(),
                    s = e.indexOf(t); - 1 !== s && e.splice(s, 1), e.push(i(t)), this._historyStringify(e)
            }
        }, h.prototype.clearHistory = function() {
            n() && localStorage.setItem(this.options.localStorageKey, ""), this.historyList.empty(), this.historyClearBtn.hide()
        }, h.prototype._historyParse = function() {
            if (n()) {
                var t = localStorage.getItem(this.options.localStorageKey);
                return t ? t.split(",").reverse().slice(0, this.options.historyLength).reverse() : []
            }
            return []
        }, h.prototype._historyStringify = function(t) {
            if (n()) {
                var e = t.reverse().slice(0, this.options.historyLength).reverse();
                localStorage.setItem(this.options.localStorageKey, e.join(","))
            }
        }, h.prototype.suggest = function() {
            var t = this.searchInput,
                e = t.val().trim(),
                s = {},
                i = this,
                o = i.options;
            s[o.suggestPostKey] = o.suggestEncode ? encodeURIComponent(e) : e;
            var n = ++this.currentSuggestId;
            return "" === e ? (i.suggestList.hide(), void(this.currentKey = "")) : (i.keyList.hide(), i.historyList.hide(), i.historyClearBtn.hide(), i.suggestList.show(), void(e !== this.currentKey && (this.currentKey = e, i.suggestList.empty(), o.suggestUrl && a.ajax({
                url: o.suggestUrl,
                data: s,
                dataType: o.ajaxType,
                type: o.method,
                success: function(t) {
                    if (n === i.currentSuggestId && 200 === t.code) {
                        var e = o.getSuggestList(t) || [];
                        e.forEach(function(t, e) {
                            a(r(o.suggestItemTemplate, t)).appendTo(i.suggestList).on("click", function() {
                                o.suggestOnclick.call(i, t, e, a(this))
                            })
                        })
                    }
                }
            }))))
        }, h.prototype.showKeywordOrHistory = function() {
            var t = this;
            t.keyList.length && t.keyList.children().length ? (t.keyList.show(), t.historyClearBtn.hide(), t.options.onKeywordShow()) : (t.keyList.hide(), t.showHistory(), t.options.onHistoryShow())
        }, h.prototype.search = function(t) {
            this.options.validate(t) && (this.searchInput.val(t), this.addHistory(t), this.form.get(0).submit())
        }, s.exports = h
    }, {
        main: !0,
        map: o
    })
}();