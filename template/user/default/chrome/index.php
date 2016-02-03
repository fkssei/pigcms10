<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>您需要下载Chrome浏览器来管理店铺</title>
<style type="text/css">
html { overflow-y:scroll; }
body { margin:0; padding:0 0; font:12px/1 \5b8b\4f53, Arial, sans-serif; background:#e0e0e3; }
div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, form, fieldset, input, textarea, blockquote, p { padding:0; margin:0; }
ol, ul { list-style:none; }
li { list-style-type:none; }
.box { width:503px; height:629px; overflow:hidden; margin:10px auto auto; background:url(<?php echo TPL_URL;?>images/chrome_bg.jpg) 0 0 no-repeat; }
.contenter { padding:17px 55px 17px 15px; text-align:center; }
.b_title { width:236px; height:236px; background:url(<?php echo TPL_URL;?>images/chrome_oops.png) 0 0 no-repeat; margin:0 auto; text-indent:-99em; overflow:hidden; }
.b_content { margin:15px 30px; padding:18px 15px; background-color:#daeaf8; }
.chrome_d { line-height:1.8; font:bold 14px/1.8 arial, '微软雅黑'; color:#000; }
.chrome_btn { width:205px; height:36px; font:normal 14px/36px arial, '微软雅黑'; display:block; background-color:#1574f9; border-radius:3px; color:#fff; text-decoration:none; margin:10px auto; }
.chrome_btn:hover {color: #fff;}
.step { font-size:12px;text-align:left; margin:5px auto 0; width:320px;}
.step dt { color:#1574f9; font:bold 13px/1.8 arial, '微软雅黑'; }
.step dd { color:#555; line-height:1.6; }
.case { margin-top:8px; }
.case .tips { color:#c53800; font:bold 14px/1.8 arial, '微软雅黑'; margin-bottom:5px; }
.case .content{text-align:left;line-height:1.8;}
</style>
<script>
window.GLOBAL_CONFIG = {
    isDownloadChromePage: true
}
</script>
<script>
	if(navigator.userAgent.indexOf("Chrome") !== -1){
		location.href = '<?php dourl('store:select');?>';
	}
</script>
</head>
<body>
    <div class="box">
        <div class="contenter">
            <h1 class="b_title">完成最后一步，请使用Chrome浏览器来管理您的微店</h1>
            <div class="b_content">
                <div class="chrome_d">如果还没有Chrome浏览器请直接点击下方链接</div>
                <a href="https://www.baidu.com/s?ie=utf-8&wd=%E8%B0%B7%E6%AD%8C%E6%B5%8F%E8%A7%88%E5%99%A8" target="_blank" class="chrome_btn">Chrome浏览器 安全下载</a>
                <dl class="step">
                    <dt>您的店铺正等待您来经营，紧接着请：</dt>
                    <dd>第 1 步：搜索下载 Chrome 安装包并安装</dd>
                    <dd>第 2 步：启动 Chrome 浏览器，访问 网站</dd>
                    <dd>第 3 步：开始创建、装修、管理您的店铺</dd>
                </dl>
				<div class="case">
                    <div class="tips">为什么要使用 Chrome 浏览器</div>
                    <div class="content">因为拖拽式布局来装修页面，需要和手机达到一致效果才最好！<br/>Andriod、IOS系统手机浏览器恰恰使用了Chrome的浏览器内核！<br/><br/></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
