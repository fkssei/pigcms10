

/*距离*/
function getRange(range){
	range = parseInt(range);
	if(range < 1000){
		return range+'m';
	}else if(range<5000){
		return (range/1000).toFixed(2)+'km';
	}else if(range<10000){
		return (range/1000).toFixed(1)+'km';
	}else{
		return Math.floor(range/1000)+'km';
	}
}


// 去除空格
function trim(str){ //删除左右两端的空格
	 return str.replace(/(^s*)|(s*$)/g, "");
}

//检查手机号码
function checkMobile(mobile) {
	if (mobile.length != 11) {
		return false;
	}
	
	var regMobile = /^0?1[3|4|5|8|7][0-9]\d{8}$/;//手机
	
	if (regMobile.test(mobile)) {
		return true;
	} else {
		return false;
	}
}

// 添加收藏
function userCollect(id, type) {
	var url = "/index.php?c=collect&a=add&id=" + id + "&type=" + type;
	$.getJSON(url, function (data) {
		if (data.status == false) {
			try {
				if (data.data.error == 'login') {
					alertlogin();
					return false;
				}
			} catch (e) {
				
			}
		}

		showResponse(data);
		
		if (type == 1 && data.status == true) {
			try {
				var collect_number = $(".product_collect_" + id).html();
				collect_number = parseInt(trim(collect_number));
				$(".product_collect_" + id).html(collect_number + 1);
				
				$(".js_goods_collect").attr("onclick", "cancelCollect('" + id + "', '" + type + "')");
				$(".dt-collect-text").html("取消收藏");
			} catch(e) {
				
			}
		} else if (type == 2 && data.status == true) {
			try {
				var collect_number = $(".store_collect_" + id).html();
				collect_number = parseInt(trim(collect_number));
				$(".store_collect_" + id).html(collect_number + 1);
				
				$(".js_store_collect_icon").html('-')
				$(".js_store_collect_click").attr("onclick", "cancelCollect('" + id + "', '" + type + "')");
				$(".js_store_collect_text").html("取消收藏");
			} catch(e) {
				
			}
		}
	})
	
}


//关注商品
function userAttention(id, type) {
	var url = "/index.php?c=collect&a=attention&id=" + id + "&type=" + type;
	$.getJSON(url, function (data) {
		if (data.status == false) {
			try {
				if (data.data.error == 'login') {
					alertlogin();
					return false;
				}
			} catch (e) {
				
			}
		}

		showResponse(data);
		
		if (type == 1 && data.status == true) {
			try {
				var collect_number = $(".product_collect_" + id).html();
				collect_number = parseInt(trim(collect_number));
				$(".product_attention_" + id).html(collect_number + 1);
				
				$(".js_goods_collect").attr("onclick", "cancelCollect('" + id + "', '" + type + "')");
				$(".dt-collect-text").html("取消关注");
			} catch(e) {
				
			}
		} else if (type == 2 && data.status == true) {
			try {
				var collect_number = $(".store_attention_" + id).html();
				collect_number = parseInt(trim(collect_number));
				$(".store_attention_" + id).html(collect_number + 1);
				
				$(".js_store_collect_icon").html('-')
				$(".js_store_collect_click").attr("onclick", "cancelCollect('" + id + "', '" + type + "')");
				$(".js_store_collect_text").html("取消关注");
			} catch(e) {
				
			}
		}
	})
	
}


// 非个人中心中的取消收藏
function cancelCollect(id, type) {
	var title = '您真的要取消收藏此产品吗？';
	if (type == 2) {
		title = "您真的要取消收藏此店铺吗？";
	}
	if (!confirm(title)) {
		return;
	}
	
	var url = "/index.php?c=collect&a=cancel&id=" + id + "&type=" + type;
	$.getJSON(url, function (data) {
		if (data.status == false) {
			try {
				if (data.data.error == 'login') {
					alertlogin();
					return;
				}
			} catch (e) {
				
			}
		}
		
		if (data.msg != '') {
			tusi(data.msg);
		}
		
		if (type == 1 && data.status == true) {
			try {
				var collect_number = $(".product_collect_" + id).html();
				collect_number = parseInt(trim(collect_number));
				$(".product_collect_" + id).html(collect_number - 1);
				
				$(".js_goods_collect").attr("onclick", "userCollect('" + id + "', '" + type + "')");
				$(".dt-collect-text").html("收藏");
			} catch(e) {
				
			}
		} else if (type == 2 && data.status == true) {
			try {
				var collect_number = $(".store_collect_" + id).html();
				collect_number = parseInt(trim(collect_number));
				$(".store_collect_" + id).html(collect_number - 1);
				
				$(".js_store_collect_icon").html('+')
				$(".js_store_collect_click").attr("onclick", "userCollect('" + id + "', '" + type + "')");
				$(".js_store_collect_text").html("收藏店铺");
			} catch(e) {
				
			}
		}
		
	})
}


function attention_cancel(id, type) {
var url = "/index.php?c=collect&a=attention_cancel&id=" + id + "&type=" + type;
$.getJSON(url, function (data) {
	showResponse(data);
})
}

// 取消收藏
function userCancelCollect(id, type) {
	var url = "/index.php?c=collect&a=cancel&id=" + id + "&type=" + type;
	$.getJSON(url, function (data) {
		showResponse(data);
	})
}


//删除单条用户的优惠券
function deluserCoupon(id){
	var url = "/index.php?c=account&a=deluserCoupon&id=" + id;
	$.getJSON(url, function (data) {
		if (data.status == false) {
			try {
				if (data.msg == '请先登录') {
					alertlogin();
					return;
				}
			} catch (e) {

			}
		}
		showResponse(data);
		if ( data.status == true) {

		}else{


		}

	})
}

//领取优惠券
function addCoupon(couponid) {
	var url = "/index.php?c=store&a=addcoupon_by_storeid&couponid=" + couponid;
	$.getJSON(url, function (data) {

		if (data.status == false) {
			try {
				if (data.data.error == 'login') {
					alertlogin();
					return;
				}
			} catch (e) {

			}
		}
		showResponse(data);

		if ( data.status == true) {
			try {
				//返回js处理
			} catch(e) {

			}
		} else if (type == 2 && data.status == true) {
			try { //返回js处理
			} catch(e) {

			}
		}
	})

}


function showResponse(data) {
	if (data.status == true) {
		//当有信息提示时
		if (data.msg != '') {
			if (data.data.nexturl != '' && data.data.nexturl != 'undefined') {
				j_url = data.data.nexturl;
			}
			//refresh_vdcode();
			tusi(data.msg, 'jump');
		}
		return;
	} else {
		if (data.msg != '') {
			tusi(data.msg);
		}
	}
	return true;
}


function tusi(txt, fun) {
	$('.tusi').remove();
	//var div = $('<div class="tusi" style="background: url(/template/index/default/images/tusi.png);max-width: 85%;min-height: 77px;min-width: 270px;position: absolute;left: -1000px;top: -1000px;text-align: center;border-radius:10px;"><span style="color: #ffffff;line-height: 77px;font-size:20px;">' + txt + '</span></div>');
	var div = $('<div class="tusi" style="background: #5A5B5C;padding:0px 20px;min-height: 77px;min-width: 270px;position: absolute;left: -1000px;top: -1000px;text-align: center;border-radius:10px;"><span style="color: #ffffff;line-height: 77px;font-size:20px;">' + txt + '</span></div>');
	$('body').append(div);
	div.css('zIndex', 9999999);
	div.css('left', parseInt(($(window).width() - div.width()) / 2));
	var top = parseInt($(window).scrollTop() + ($(window).height() - div.height()) / 2);
	div.css('top', top);
	setTimeout(function () {
		div.remove();
		if (fun) {
			eval("(" + fun + "())");
		}
	}, 1500);
}

var j_url = '';
function jump() {
	if (j_url == 'refresh') {
		location.reload();
	} else if (j_url == 'no') {
		
	} else if (j_url == 'login') {
		alertlogin();
	} else if (j_url == 'dia_close') {
		parent.location.reload();
		art.dialog.close();
	} else if (j_url.length > 0) {
		location.href = j_url;
	}
}

$(document).ready(function () {
	if ($("#login").length > 0) {
		try {
			$('#login').ajaxForm({
				beforeSubmit: showRequest,
				success: loginRespone,
				dataType: 'json'
			});
		} catch(e) {


		}
	}
});
/*
function showRequest() {
	var phone = $("#phone").val();
	var password = $("#password").val();

	if (phone.length == 0 && password.length == 0) {
		tusi("请填写手机号和密码");
		//$("#msg").html("请填写用户和密码");
		return false;
	}

	if (!checkMobile(phone)) {
		tusi("请正确填写您的手机号");
		//$("#msg").html("请正确填写您的手机号");
		return false;
	}

	if (password.length < 6) {
		tusi("密码不能少于六位，请正确填写");
		//$("#msg").html("密码不能少于六位，请正确填写");
		return false;
	}

	return true;
}*/

function showResponse(data) {
	if (data.status == true) {
		//当有信息提示时
		if (data.msg != '') {
			if (data.data.nexturl != '' && data.data.nexturl != 'undefined') {
				j_url = data.data.nexturl;
			}
			//refresh_vdcode();
			tusi(data.msg, 'jump');
		}
		return;
	} else {
		if (data.msg != '') {
			tusi(data.msg);
		}
	}
	return true;
}

function showLogin() {
	$("#miniLogin-overlay").css("width", $(document).width() + "px");
	$("#miniLogin-overlay").css("height", $(window).height() + "px");
	
	$("#miniLogin-overlay").css("display", "block");
	$("#miniLogin").css("display", "block");
}

function loginRespone(data) {
	if (data.status == true) {
		var top_user_info = '<em>Hi，' + data.data.nickname + '</em><a target="_top" href="/index.php?c=account&a=logout" class="sn-register">退出</a>';
		
		$("#miniLogin").css("display", "none");
		$("#miniLogin-overlay").css("display", "none");
		$("#login-info").html(top_user_info);
		is_login = true;
		tusi("登录成功");
	} else {
		if (data.msg != '') {
			tusi(data.msg);
		}
	}
	return true;
}


/*网站顶部hover显示下拉*/
$(function(){
	$(".top-bar .dorpdown").mouseover(function(){
		$(this).find(".dorpdown-layer").show();
	}).mouseout(function(){
		$(this).find(".dorpdown-layer").hide();
	})
		var  wwidth1 = $(window).width();
		var  rights = (wwidth1-1210)/2-69;
	   // $("#leftsead").css("right",rights).show();
		//$("#leftsead").css("right",rights);
	
	//浮动返回顶部js
	var e = $("#leftsead"), t = $(document).scrollTop(), n, r, i = !0;
	$(window).scroll(function() {

		var  wwidth1 = $(window).width();
		if($("#leftsead:visible")) {$("#cartbottom").show();}else{$("#cartbottom").hide();}
		
		if($(window).scrollTop()>200){  //距顶部多少像素时，出现返回顶部按钮
			//$("#leftsead").fadeIn(600);
		}
		else{
		  //  $("#leftsead").fadeOut(600);
		}
	})

	if((getOs() == 'MSIE' && ieVersion() < 9) || $('.storeContact').attr('open-url') == ''){  //联系卖家
		var tel 	= $('.storeContact').attr('data-tel');
		$('.storeContact').html(tel);
	}else{
		$('.storeContact').html('<a class="item-first-shop-wx chat openWindow">联系卖家</a>');
	}

	$('.openWindow').live('click',function(){
		$.post('/index.php?c=public&a=checkLogin',{},function(res){
			if(res.err_msg == 'logined'){
				var url 	= $('.openWindow').parent('.storeContact').attr('open-url');
				openWin(url);
			}else{
				alertlogin();
			}
		});
	});


})

function openWin(url) { 
   var url=url;					 //转向网页的地址; 
   var name='联系卖家';					 //网页名称，可为空; 
   var iWidth=355;						  //弹出窗口的宽度; 
   var iHeight=520;						 //弹出窗口的高度; 
   //获得窗口的垂直位置 
   var iTop = (window.screen.availHeight - 30 - iHeight) / 2; 
   //获得窗口的水平位置 
   var iLeft = (window.screen.availWidth - 10 - iWidth) / 2; 
   window.open(url, name, 'height=' + iHeight + ',,innerHeight=' + iHeight + ',width=' + iWidth + ',innerWidth=' + iWidth + ',top=' + iTop + ',left=' + iLeft + ',status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=0,titlebar=no'); 
   // window.open("AddScfj.aspx", "newWindows", 'height=100,width=400,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no'); 
}



//
$(function(){
	try {
		//部分区域图片延迟加载
		$("img.lazy").lazyload();
	} catch (e) {
		
	}
});

//部分区域图片延迟加载

function lazyloadForPart(container) {
	container.find('img').each(function () {
		var original = $(this).attr("original");
		if (original) {
			$(this).attr('src', original).removeAttr('original');
		}
	});
}

function setContentTab(name, curr, n) {
	for (i = 1; i <= n; i++) {
		var menu = document.getElementById(name + i);
		var cont = document.getElementById("con_" + name + "_" + i);
		menu.className = i == curr ? "current" : "";
		if (i == curr) {
			cont.style.display = "block";
			lazyloadForPart($(cont));
		} else {
			cont.style.display = "none";
		}
	}
}


//等比例缩放
function AutoResizeImage(maxWidth,maxHeight,objImg) {
	var img = new Image();
	img.src = objImg.src;
	var hRatio;
	var wRatio;
	var Ratio = 1;
	var w = img.width;
	var h = img.height;
	wRatio = maxWidth / w;
	hRatio = maxHeight / h;
	if (maxWidth == 0 && maxHeight == 0) {
		Ratio = 1;
	} else if (maxWidth == 0) {//
		if (hRatio < 1) Ratio = hRatio;
	} else if (maxHeight == 0) {
		if (wRatio < 1) Ratio = wRatio;
	} else if (wRatio < 1 || hRatio < 1) {
		Ratio = (wRatio <= hRatio ? wRatio : hRatio);
	}
	if (Ratio < 1) {
		w = w * Ratio;
		h = h * Ratio;
	}
	objImg.height = h;
	objImg.width = w;
}

function getOs()  
{  
	var OsObject = "";  
   if(navigator.userAgent.indexOf("MSIE")>0) {  
		return "MSIE";  
   }  
   if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){  
		return "Firefox";  
   }  
   if(isSafari=navigator.userAgent.indexOf("Safari")>0) {  
		return "Safari";  
   }   
   if(isCamino=navigator.userAgent.indexOf("Camino")>0){  
		return "Camino";  
   }  
   if(isMozilla=navigator.userAgent.indexOf("Gecko/")>0){  
		return "Gecko";  
   }  
	
}


function ieVersion(){
	if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/6./i)=="6."){
		return  6;
	}
	else if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/7./i)=="7."){
		return  7;
	}
	else if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/8./i)=="8."){
		return  8;
	}
	else if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/9./i)=="9."){
		return 9;
	}
}



//网站公用 弹窗
function alertWin(title, msg, w, h){
	var titleheight = "25px";
	var bordercolor = "#b75bad";
	var titlecolor = "#FFFFFF";
	var titlebgcolor = "#666699";
	var bgcolor = "#FFFFFF";

	$("#alertbgid,#alertwinid").remove();
 //   $("html").css("overflow","hidden");
	$("select").css("display","none");

	var iWidth = document.documentElement.clientWidth;
	var iHeight = document.documentElement.clientHeight;
	var bgObj = document.createElement("div");
	bgObj.setAttribute("class", "alertbg");
	bgObj.setAttribute("id", "alertbgid");
	bgObj.style.cssText = "position:absolute;left:0px;top:0px;width:"+iWidth+"px;height:"+Math.max(document.body.clientHeight, iHeight)+"px;filter:Alpha(Opacity=30);opacity:0.3;background-color:#000000;z-index:100000;";
	document.body.appendChild(bgObj);

	if(document.body.scrollTop) {
		var scrollTop = document.body.scrollTop;
	} else {
		var scrollTop = document.documentElement.scrollTop;
	}

	var msgObj=document.createElement("div");
	msgObj.setAttribute("class", "alertwin");
	msgObj.setAttribute("id", "alertwinid");
   // msgObj.style.cssText = "position:fixed;top:"+((iHeight-h)/2 + scrollTop) +"px;left:"+(iWidth-w)/2+"px;z-index:100001;border:0px solid #b75bad;width:"+w+"px;color:#666;background:#fff; padding: 5px;";
	msgObj.style.cssText = "position:fixed;top:"+((iHeight-h)/2) +"px;left:"+(iWidth-w)/2+"px;z-index:100001;border:0px solid #b75bad;width:"+w+"px;color:#666;background:#fff; padding: 5px;";

	document.body.appendChild(msgObj);

	var table = document.createElement("table");
	msgObj.appendChild(table);
	table.style.cssText = "width:100%;height:100%;margin:0px;border:0px;padding:0px;";
	table.cellSpacing = 0;
	var tr = table.insertRow(-1);
	tr.setAttribute("class", "bs-header");

	var titleBar = tr.insertCell(-1);
	if (title) {
		tr.style.cssText = "cursor:move;background: none repeat scroll 0 0 #F63B3B;color: #FFFFFF; font-size: 14px; font-weight: 700; height: 50px; line-height: 30px; margin: 0 4px 4px; padding: 0 10px;";
	} else {
		titleBar.style.cssText = "cursor:move";
	}
	titleBar.style.paddingLeft = "10px";
	titleBar.innerHTML = title;

	var moveX = 0;
	var moveY = 0;
	var moveTop = 0;
	var moveLeft = 0;
	var moveable = false;
	var docMouseMoveEvent = document.onmousemove;
	var docMouseUpEvent = document.onmouseup;
	titleBar.onmousedown = function() {
		var evt = getEvent();
		moveable = true;
		moveX = evt.clientX;
		moveY = evt.clientY;
		moveTop = parseInt(msgObj.style.top);
		moveLeft = parseInt(msgObj.style.left);

		document.onmousemove = function() {
			if (moveable) {
				var evt = getEvent();
				var x = moveLeft + evt.clientX - moveX;
				var y = moveTop + evt.clientY - moveY;
				if ( x > 0 &&( x + w < iWidth) && y > 0 && (y + h < iHeight) ) {
					msgObj.style.left = x + "px";
					msgObj.style.top = y + "px";
				}
			}
		};
		document.onmouseup = function () {
			if (moveable) {
				document.onmousemove = docMouseMoveEvent;
				document.onmouseup = docMouseUpEvent;
				moveable = false;
				moveX = 0;
				moveY = 0;
				moveTop = 0;
				moveLeft = 0;
			}
		};
	}

	var closeBtn = tr.insertCell(-1);
	if(title) {
		closeBtn.style.cssText = "font: 10pt '宋体';width:40px;";
		closeBtn.innerHTML = '<a href="javascript:void(0);" class="J_downDialog-close close" style="color:#fff;font-size: 14px; font-weight: 700; width:40px;">&nbsp;</a>';
	}
	closeBtn.onclick = function(){
		document.body.removeChild(bgObj);
		document.body.removeChild(msgObj);
	}


	var msgBox = table.insertRow(-1).insertCell(-1);
	msgBox.style.cssText = "font:10pt '宋体';";
	msgBox.colSpan  = 2;
	msgBox.innerHTML = msg;

	$('.close').click(function () {
	   // $("html").css("overflow","");
		$("select").css("display","");
		document.body.removeChild(bgObj);
		document.body.removeChild(msgObj);
	});
	$(function(){
		$("input[class='login-inputa']").focus(function(){
			$(this).addClass("login-inputa2").removeClass("login-inputa");
		}).blur(function(){
			$(this).addClass("login-inputa").removeClass("login-inputa2");
		});
	})
	// 获得事件Event对象，用于兼容IE和FireFox
	function getEvent() {
		return window.event || arguments.callee.caller.arguments[0];
	}
}

function weidianAlert(title, msg, w, h) {

	msg = '<div class=""><p class="" style="padding: 15px 40px;height:20px;"><strong style="color:#A35C76" class="fl fs14">'+msg+'</strong></p><p style=" background: none repeat scroll 0 0 #E3E3E3; padding:5px;text-align: center;"><input type="submit" onclick="javascript:" class="close" value="确定" style="font-size: 14px;font-weight: 700;height: 30px;line-height: 30px;width: 100px;cursor: pointer;background: #F63B3B;color: #fff;"/>&#12288;</p></div>';
	alertWin(title, msg, w, h);
}

function alertlogin() {
	title="";
	w=370;
	h=460;
	msg="<iframe id='loginIframe' width='"+w+"' height='"+h+"' frameborder='0' src='/index.php?c=public&a=dologin'></iframe>";
	alertWin(title, msg, w, h);
}



//公用监听
/*
$(window).resize(function() {
	var wwidth = document.body.scrollWidth;
	var hhight = document.body.scrollHeight;

	if(document.body.scrollTop) {
		var scrollTop = document.body.scrollTop;
	} else {
		var scrollTop = document.documentElement.scrollTop;
	}
	//登陆 及 alertwin 弹窗 参数修改
   // if($('.alertbg').is(':visible')){$('.alertbg').css({width:wwidth,height:hhight});}
	//if($('.alertwin').is(":visible")) {
	 //   w = $(".alertwin").width();
	 //   h = $(".alertwin").height();
	 //   alert_left = (wwidth-w)/2;
	 //   alert_top = (hhight-h)/2 + scrollTop;
	  //  $(".alertwin").css({top:alert_top ,left:alert_left})
  //  }
})
*/



$(function(){
	//网站顶部搜索框
	$(".header_search_left_list li").click(function(){

		//切换当前选中的 项目
		var sleval = $(this).text();
		$(".header_search_left font").html(sleval);

		//设置隐藏域
		var stval = $(this).attr('listfor');
		//设置隐藏域的 value
		$('#searchType').val(stval);
	})

	$('.sub_search').click(function() {
		var keyword = $('.combobox-input').val();
		if(keyword == ''){
			alert('请输入搜索关键词');
		}else{
			var type = $("#searchType").val();
			if (type == 'product') {
				var url = "/index.php?c=search&a=goods&keyword=" + keyword;
			} else {
				var url = "/index.php?c=search&a=store&keyword=" + keyword;
			}

			location.href = url;
		}
	});



	//无cookie 显示弹层


})

/*
 *descrption:   读取用户登录后的 地理坐标
 *return:	object('long','lat')
 */
function getUserDistance() {
	
	if(getCookie("Web_user")) {
	var Cookie_web_user = getCookie("Web_user");
	
	var objj = eval("("+Cookie_web_user+")");
	
	} else {

		return false;
	}
	return objj;
}



function checkLoginStatus() {

	if(getCookie("Web_user"))
	{
		$(".chenpage").hide();  //弹出层
		$("body").removeClass("cheng_xianshi");
	} else {
		//没有cookie
		$(".chenpage").show();  //弹出层
		$("body").addClass("cheng_xianshi");

	}
}

//展示在页面上的距离
function show_distance(shoplat, shoplong, suffix) {
	var lat_long =  getUserDistance();

	if(lat_long) {
		document.write((getFlatternDistance(lat_long.lat,lat_long.long,shoplat,shoplong)/1000).toFixed(2)+suffix)
	} else {
		document.write("0" + suffix);
	}
}

// 计算物流时间
function expressTime(distance) {
	if (typeof distance == "undefined") {
		return '';
	}

	for(var i in distance_obj) {
		var qj = i.split('-');
		
		if (parseFloat(qj[0]) <= distance && parseFloat(qj[1]) >= distance) {
			return distance_obj[i];
		}
	}
}

//获取当前文件所在路径
function getDirectoryDir() {
	var js=document.scripts;
	var jsPath=js[js.length-1].src.substring(0,js[js.length-1].src.lastIndexOf("/")+1);
	return jsPath;
}

//计算物流时间
function expressTime2(lats, longs) {
	if (lats == ""|| longs=="" ) {
		return 'NO_STORE';
	}
	var lat_long = getUserDistance();
	
	if (!lat_long) {
		return 'NO_POSITION';
	}

	var distance = (getFlatternDistance(lat_long.lat, lat_long.long, lats, longs) / 1000).toFixed(2);
	return expressTime(parseFloat(distance));
}

// 直接输出到页面物流时间
function expressTimeWrite(lats, longs) {
	var t = expressTime2(lats, longs);
	if (t == "NO_STORE") {
		t = "商家未设置位置";
	} else if (t == "NO_POSITION") {
		t = "请设置您的位置";
	}
	document.write(t);
}

// 计算距离位置
function expressDistance(lats, longs) {
	var express = "请设置您的位置";
	var distance = "0";
	var lat_long = getUserDistance();
	
	if (lats == ""|| longs=="" ) {
		express = "商家未设置位置";
	} else if (lat_long) {
		distance = (getFlatternDistance(lat_long.lat, lat_long.long, lats, longs) / 1000).toFixed(2);
		express = expressTime(distance);
	}
	
	return {express : express, distance : distance};
}

// 直接输出距离到页面
function expressDistanceWrite(lats, longs) {
	var d = '';
	if (lats == ""|| longs == "") {
		document.write("0km");
		return;
	}
	var lat_long = getUserDistance();
	
	if (!lat_long) {
		document.write("0km");
		return;
	}

	d = (getFlatternDistance(lat_long.lat, lat_long.long, lats, longs) / 1000).toFixed(2);
	document.write(d + "km");
}


//读取cookies
function getCookie(objName){//获取指定名称的cookie的值
//alert(objName)
	var arrStr = document.cookie.split("; ");
	for(var i = 0;i < arrStr.length;i ++){
		var temp = arrStr[i].split("=");
		if(temp[0] == objName) return unescape(temp[1]);
	}
}


//写cookies
function addCookie(objName,objValue,objHours){//添加cookie
	var str = objName + "=" + escape(objValue);
	if(objHours > 0){//为0时不设定过期时间，浏览器关闭时cookie自动消失
		var date = new Date();
		var ms = objHours*3600*1000;
		date.setTime(date.getTime() + ms);
		str += "; expires=" + date.toGMTString();
	}
	document.cookie = str;
}

//删除cookies
function delCookie(name){//为了删除指定名称的cookie，可以将其过期时间设定为一个过去的时间
	var date = new Date();
	date.setTime(date.getTime() - 10000);
	document.cookie = name + "=a; expires=" + date.toGMTString();
}



/*获取位置距离*/
var EARTH_RADIUS = 6378137.0;	//单位M
var PI = Math.PI;

function getRad(d) {
	return d*PI/180.0;
}
/**
 * caculate the great circle distance
 * @param {Object} lat1
 * @param {Object} lng1
 * @param {Object} lat2
 * @param {Object} lng2
 */
function getGreatCircleDistance(lat1,lng1,lat2,lng2){
	var radLat1 = getRad(lat1);
	var radLat2 = getRad(lat2);

	var a = radLat1 - radLat2;
	var b = getRad(lng1) - getRad(lng2);

	var s = 2*Math.asin(Math.sqrt(Math.pow(Math.sin(a/2),2) + Math.cos(radLat1)*Math.cos(radLat2)*Math.pow(Math.sin(b/2),2)));
	s = s*EARTH_RADIUS;
	s = Math.round(s*10000)/10000.0;

	return s;
}

function getFlatternDistance(lat1,lng1,lat2,lng2){
	lat1 = parseFloat(lat1);
	lng1 = parseFloat(lng1);
	lat2 = parseFloat(lat2);
	lng2 = parseFloat(lng2);

	var f = getRad((lat1 + lat2)/2);
	var g = getRad((lat1 - lat2)/2);
	var l = getRad((lng1 - lng2)/2);

	var sg = Math.sin(g);
	var sl = Math.sin(l);
	var sf = Math.sin(f);

	var s,c,w,r,d,h1,h2;
	var a = EARTH_RADIUS;
	var fl = 1/298.257;

	sg = sg*sg;
	sl = sl*sl;
	sf = sf*sf;

	s = sg*(1-sl) + (1-sf)*sl;
	c = (1-sg)*(1-sl) + sf*sl;

	w = Math.atan(Math.sqrt(s/c));
	r = Math.sqrt(s*c)/w;
	d = 2*w*a;
	h1 = (3*r -1)/2/c;
	h2 = (3*r +1)/2/s;

	return d*(1 + fl*(h1*sf*(1-sg) - h2*(1-sf)*sg));
}




//活动弹窗
function show_activity_win(obj,type){
	//$("body").addClass("cheng_xianshi");
	
	//var title= "33标题";
	//var p1 = "11分销价格: <span> ￥365</span>";
	//var p2 = "22派送利润: <span> ￥66</span>";
	var descrption = "55利用节日营销，打造传播新方式。中秋微贺卡，支持商家定制祝福语、背景音乐、自定义上传logo。粉丝在接收到商家发出的微贺卡后，也可对祝福内容进行定制，并分享、转发。利用微贺卡，借助节日气氛，为商家带来爆炸式传播。”";
	
	var data_json = obj.attr("data-json");
	var sobj = eval('(' + data_json + ')');
	
	switch(type){
		
		case 'hqwz':
				$(".tankuang_content").hide();
				$(".chenpage").show();
				$(".hqwz").show();
				
			break;
		
		
		case 'huodong':
				

				
				/////////////////////////////////////////////////
				$(".tankuang_content").hide();
					$(".chenpage").show();
				var typename= sobj.typename;
				var wx_image = sobj.wx_image;
				var title = sobj.name;				
				var cyrs = sobj.cyrs;	
				var p1 = "参与人数：  <span> "+cyrs+"人</span>";
				var intro = sobj.intro;
				if(intro) var intro = intro.substr(0,55)+'..';
				
				$(".yydb").find(".songli").html(typename);		//类别
				$(".yydb").find(".tankuang_title").html(title);//标题
				$(".yydb").find(".tankuang_list .tankuang_txt").eq(0).html(p1);//参与人数
				$(".yydb").find(".tankuang_list .tankuang_txt").eq(1).html('');	  //空
				$(".yydb").find(".wx_image").attr("src",wx_image);				//二维码
				$(".tankuang_txt_txt").html(intro)
				
				$(".yydb").show();
				
				
			break;
			
		case 'wyfx':


			

			if(!sobj.type || sobj.type == "undefined") sobj.type = "product";
			var type="我要分销";	
			var wx_image = sobj.wx_image;
			var title = sobj.name;
			var fxlr = sobj.fxlr;
			
		
			switch(sobj.type) {
			
				case 'store':
					var zylm = sobj.zylm;
					var intro = sobj.intro;
					if(intro) var intro = intro.substr(0,55)+'..';
					
					if(zylm) var p1 = "主营类目：  <span> "+zylm+"</span>";
					if(intro) {
						var p2 = "店铺简介：  <span> "+intro.substr(0,55)+'..'+"</span>";
						
						
					};
					break;
					
					//商品
				default:	
					var pszlr = sobj.pszlr;
					var fxsl = sobj.fxsl;
					var p1 = "派送总利润： : <span> ￥"+pszlr+"</span>";
					var p2 = "分销数量: <span> "+fxsl+"</span>";
								
			}
	

			var p3 = "分销利润: <span> ￥"+fxlr+"</span>";	

			
			

			
			
			$(".tankuang_content").hide();
			
			$(".chenpage").show();
			
			$(".myfx").find(".songli").html(type);
			$(".myfx").find(".tankuang_title").html(title);
			//$tankuang_list
			$(".myfx").find(".tankuang_list .tankuang_txt").eq(0).html(p1);
			$(".myfx").find(".tankuang_list .tankuang_txt").eq(1).html(p2);
			$(".myfx").find(".tankuang_list .tankuang_txt").eq(2).html(p3);
			$(".myfx").find(" .wx_image").attr("src",wx_image);
			$(".myfx").find(".tankuang_list .tankuang_title").html(title);
			//$(".tankuang_txt_txt").html(descrption)
			
			
			$(".myfx").show();	
			
			
			
			break;	
			
			
			
		case 'rmhd':		//热门活动2
			/////////////////////////////////////////////////
			$(".tankuang_content").hide();
				$(".chenpage").show();
			var typename= sobj.typename;
			var wx_image = sobj.wx_image;
			var title = sobj.name;				
			var cyrs = sobj.cyrs;	
			var p1 = "参与人数：  <span> "+cyrs+"人</span>";
			var intro = sobj.intro;
			if(intro) var intro = intro.substr(0,55)+'..';
			
			$(".rmhd").find(".songli").html(typename);		//类别
			$(".rmhd").find(".tankuang_title").html(title);//标题
			$(".rmhd").find(".tankuang_list .tankuang_txt").eq(0).html(p1);//参与人数
			$(".rmhd").find(".tankuang_list .tankuang_txt").eq(1).html('');	  //空
			$(".rmhd").find(".wx_image").attr("src",wx_image);				//二维码
			$(".tankuang_txt_txt").html(intro)
			
			$(".rmhd").show();
			break;
	}
	

	}


$(function(){
	
	//一元夺宝
	$(".huodong").click(function(){
		//centerWindow(".tankuang_content");
		show_activity_win($(this),"huodong");
	})
	
	//我要分销
	$(".wyfx").click(function(){
		show_activity_win($(this),"wyfx");	
			
	})
	
		//热门活动
	$(".remenhuodong").click(function(){
		show_activity_win($(this),"rmhd");	
			
	})
	
	//获取地理位置
	$(".hq_location").click(function(){
		show_activity_win($(this),"hqwz");	
	})
	
	getUserDistance();
	
	//setting_distance();
})


$(function() {
    $(".popup1 .tankuang_button").click(function() {
    	if(locationInterval){
    		clearInterval(locationInterval);
    	}
		close_tankuang('popup1');
        //$(".tankuang4").hide();
		//$(".tankuang1").show();
      
    });
	    $(".popup2 .tanchuang_guanbi").click(function() {
	     close_tankuang('popup2');
      
    });
		$(".popup3 .tanchuang_guanbi").click(function() {
     	close_tankuang('popup3');
      
    });
	    $(".popup4 .tanchuang_guanbi").click(function() {
		//$("body").removeClass("cheng_xianshi");
  	    close_tankuang('popup4');

		
      
    });
	
	function close_tankuang(sClass1){
		//$("body").removeClass("cheng_xianshi");
		$('.'+sClass1).hide();
		$(".chenpage").hide();
		//$('.'+sClass2).show();
	}
});