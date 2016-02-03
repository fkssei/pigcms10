<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>功能库选择</title>
<meta http-equiv="MSThemeCompatible" content="Yes" />
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script src="./static/js/layer/layer.min.js" type="text/javascript"></script>
<link href="<?php echo TPL_URL;?>css/link_style_2_common.css?BPm" rel="stylesheet" type="text/css" />
<link href="<?php echo TPL_URL;?>css/link_style.css" rel="stylesheet" type="text/css" />
<style>
body{line-height:180%;}
ul.modules li{padding:4px 10px;margin:4px;background:#efefef;float:left;width:27%;}
ul.modules li div.mleft{float:left;width:40%}
ul.modules li div.mright{float:right;width:55%;text-align:right;}
</style>
</head>
<body style="background:#fff;padding:20px 20px;">
<div style="background:#fefbe4;border:1px solid #f3ecb9;color:#993300;padding:10px;margin-bottom:5px;">使用方法：点击对应内容后面的“选中”即可。<a href="?c=link&a=index">点击这里返回模块选择</a></div>
<?php echo $content; ?>
<script>
	function returnHomepage(url){
		$('.js-link-placeholder', parent.document).val(url).keyup();
		parent.layer.close(parent.layer.getFrameIndex(window.name));
	}
/*
	function returnHomepage(url){
		var elements = getElementsByClassName(parent.document, 'externalLink');
		for (var i = 0; i < elements.length; i++) {
     		var e = elements[i];
			e.value = url;
  		}
		parent.layer.close(parent.layer.getFrameIndex(window.name));
	}
	function getElementsByClassName(node,classname) {
 		if (node.getElementsByClassName) { // use native implementation if available
    		return node.getElementsByClassName(classname);
  		} else {
  			return (function getElementsByClass(searchClass,node) {
        		if ( node == null )
        			node = document;
        			var classElements = [],
            		els = node.getElementsByTagName("*"),
            		elsLen = els.length,
            		pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)"), i, j;

        			for (i = 0, j = 0; i < elsLen; i++) {
        				if ( pattern.test(els[i].className) ) {
              				classElements[j] = els[i];
              				j++;
          				}
        			}
  	      			return classElements;
  	  		})(classname, node);
  		}	
	}
*/
</script>
</body>
</html>