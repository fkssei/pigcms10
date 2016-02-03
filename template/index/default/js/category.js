var lat_long =  getUserDistance();
$(function () {
	// 统一计算距离与物流时间
	$(".js-express").each(function () {
		var lat = $(this).data("lat");
		var long = $(this).data("long");
		
		var express_distance = expressDistance(lat, long);
		
		$(this).find(".content_list_day").html(express_distance.express);
		$(this).find(".content_list_add").html("<span></span>" + express_distance.distance + "km");
	});
	
	$(".property_value").click(function () {
		$(this).closest("dd").siblings().find("a").removeClass("property-value-current");
		$(this).addClass("property-value-current");
		
		prop_location();
	});
	
	$("#condition_content span").click(function () {
		$("#property_value_" + $(this).closest("li").data("property_id")).removeClass("property-value-current");
		$(this).closest("li").remove();
		prop_location();
	});
	
	$(".menu_right .more").click(function() {
		var li_obj = $(this).closest("li");
		if (li_obj.attr("tip") == "1") {
			li_obj.removeClass("prop_show_more");
			$(this).find("a").html("更多<span></span>");
			li_obj.attr("tip", "0");
		} else {
			li_obj.addClass("prop_show_more");
			$(this).find("a").html("收起<span></span>");
			li_obj.attr("tip", "1");
		}
	})
});

function prop_location() {
	var property_value = '';
	$(".js-property-detail").each(function () {
		if ($(this).find(".property-value-current").length > 0) {
			if (property_value.length == 0) {
				property_value = $(this).find(".property-value-current").data("property_value");
			} else {
				property_value += "_" + $(this).find(".property-value-current").data("property_value");
			}
		} 
	});
	
	var tmp_url = url;
	if (property_value) {
		tmp_url = url + "/prop_" + property_value;
	}
	
	location.href = tmp_url;
}