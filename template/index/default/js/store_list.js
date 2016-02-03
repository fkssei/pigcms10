$(function(){
	var  location_href= location.href;
	var  location_search = window.location.search;
	var location_search_arr = [];
	var store_list = "index.php?c=store&a=store_list";

	$(".menu_list .more").click(function(){
		if($(this).closest(".menu_list").data("tip")) {
			$(this).removeClass("less");
			$(this).closest(".menu-store").removeClass("menu-store-more");
			$(this).find("a").html("更多<span></span>");
			$(this).closest(".menu_list").data("tip",0);
		} else {
			$(this).closest(".menu_list").data("tip",1);
			$(this).removeClass("less").addClass("less");
			$(this).closest(".menu-store").addClass("menu-store-more");
			$(this).find("a").html("收起<span></span>");
		}
	})


	//点击关闭类目属性
	/*
	$(".menu_content .condition li span, .menu_content .condition .menu_clear a").click(function(){
	   var dataid =  $(this).attr("data-id");
		  location.href=store_list;
	})
	*/
	
	//统一计算距离与物流时间
	$(".js-express").each(function () {
		var lat = $(this).data("lat");
		var long = $(this).data("long");
		
		var express_distance = expressDistance(lat, long);
		
		$(this).find(".content_list_day").html(express_distance.express);
		$(this).find(".content_list_add").html("<span></span>" + express_distance.distance + "km");
	});
})
