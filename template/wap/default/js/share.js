/*
 document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {

 WeixinJSBridge.on('menu:share:appmessage', function (argv) {
 var $body = $('body');

 WeixinJSBridge.invoke('sendAppMessage', {
 //'appid': 'kczxs88',
 'img_url': $('body').attr('wmall-icon'),
 'link': $('body').attr('wmall-link')+'#qq.com' || window.location.href,
 //'link': window.location.href,
 'desc': $('body').attr('wmall-desc') ||$('body').attr('wmall-link')||window.location.href,
 'title': $('body').attr('wmall-title'),
 //'appid':'wx4f5b0e21aec8a6dd'
 }, function (res) {
 // 返回res.err_msg,取值
 // share_timeline:cancel 用户取消
 // share_timeline:fail　发送失败
 // share_timeline:ok 发送成功

 });
 });

 WeixinJSBridge.on('menu:share:timeline', function(argv){

 WeixinJSBridge.invoke('shareTimeline',{
 'img_url': $('body').attr('wmall-icon'),
 'link': $('body').attr('wmall-link')+'#qq.com' || window.location.href,
 //'link': window.location.href,
 'desc': $('body').attr('wmall-desc') ||$('body').attr('wmall-link')||window.location.href,
 'title': $('body').attr('wmall-title'),
 //'appid':"wx4f5b0e21aec8a6dd"

 }, function(res) {

 });

 });
 });*/
$(document).ready(function(){
    jWeixin.error(function(res){
        if(_global.wechat_js_config['appId'] =='wx59c453d03acc9061'){
            //alert(res['errMsg']);
        }
    });
    jWeixin.config({
        debug: false,//_global.wechat_js_config['appId'] =='wx59c453d03acc9061' ? true : false,
        appId: _global.wechat_js_config['appId'],
        timestamp: _global.wechat_js_config['timestamp'],
        nonceStr: _global.wechat_js_config['nonceStr'],
        signature: _global.wechat_js_config['signature'],
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onRecordEnd',
            'playVoice',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard'
        ]
    });

    function setForward() {
        var $body = $('body'),
            title = $body.attr('wmall-title'),
            imgUrl = $body.attr('wmall-icon'),
            link = $body.attr('wmall-link') || window.location.href,
            desc = $body.attr('wmall-desc') || link;
        if (title && link) {
            jWeixin.onMenuShareAppMessage({
                title: title,
                desc: desc,
                link: link,
                imgUrl: imgUrl,
                success: function (res) {
                    /*                    $(document).trigger('wx_sendmessage_confirm');
                     $.ajax({
                     url : '/data/partner/share',
                     type : 'post',
                     dataType : 'json',
                     data : {},
                     success : function(result){
                     if( result.ret == 0 && result.data ){
                     var _url = window.location.href,
                     wxid = window.localStorage.getItem('WXID');
                     $.get(result.data, { url: _url, from: wxid } );
                     }
                     }
                     });*/
                },cancel: function (res) {
                    //alert('已取消');
                },
                fail: function (res) {
                    if(appId =='wx59c453d03acc9061'){
                        alert(JSON.stringify(res));
                    }
                }
            });

            jWeixin.onMenuShareTimeline({
                title: title,
                desc: desc,
                link: link,
                imgUrl: imgUrl
            });


            jWeixin.onMenuShareQQ({
                title: title,
                desc: desc,
                link: link,
                imgUrl: imgUrl
            });

            jWeixin.onMenuShareWeibo({
                title: title,
                desc: desc,
                link: link,
                imgUrl: imgUrl
            });
            return true;
        }
        else {
            return false;
        }
    }

    jWeixin.ready(function(){
        /*    $(document).trigger('bridgeready');

         var $body = $('body'),
         title = $body.attr('wmall-title'),
         imgUrl = $body.attr('wmall-icon'),
         link = $body.attr('wmall-link') || window.location.href,
         desc = $body.attr('wmall-desc') || link;*/
        /*    if (!setForward()) {
         $(document).bind('weibachanged', function () {*/
        setForward();
        /*        });
         }
         $.cardForward = function(){
         setForward();
         }*/

        $.imagePreview = function (urls, cur, elem) {
            if (!elem.parent().is('a')) {
                if ($.isArray(urls) && urls.length > 0) {
                    if ($.isNumeric(cur) && urls[cur]) {//如果是数字
                        cur = urls[cur];
                    } else if (!cur) {
                        cur = urls[0];
                    }
                    if (window.jWeixin) {
                        var params = {
                            'urls': urls,
                            'current': cur
                        };
                        jWeixin.previewImage(params);
                    }
                }
            }
        };
    });
});

