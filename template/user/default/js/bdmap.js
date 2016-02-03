$(function(){
	var local = null,marker = null;
	$.getScript("http://api.map.baidu.com/getscript?v=2.0&ak=4c1bb2055e24296bbaef36574877b4e2",function(){
		var map = null;
		var oPoint = new BMap.Point(116.331398,39.897445);
		var setPoint = function(mk,b){
			var pt = mk.getPosition();
			(new BMap.Geocoder()).getLocation(pt,function(rs){
				addComp = rs.addressComponents;
				infoWindow = new BMap.InfoWindow('<div class="info-window"><p class="address">'+ addComp.city + addComp.district + addComp.street +'</p><div style="text-align:center;"><a class="ui-btn ui-btn-confirm js-confirm" onclick="setSelect(\''+pt.lat+'\',\''+pt.lng+'\')">确认位置</a></div></div>',{width:220,height:60,title:"",enableMessage:false,message:""});
				marker.openInfoWindow(infoWindow);
			});
		};
		
		map = new BMap.Map("cmmap",{"enableMapClick":false});
		map.enableScrollWheelZoom();

		map.centerAndZoom(oPoint, 15);
			
		if($('#map_long').val() != '' && $('#map_lat').val() != ''){
			marker = new BMap.Marker(new BMap.Point($('#map_long').val(),$('#map_lat').val()),{icon:new BMap.Icon("http://map.baidu.com/image/markers_new.png", new BMap.Size(25, 37), {anchor: new BMap.Size(12,15), imageOffset: new BMap.Size(0,-156)}),enableMassClear:false});
			map.addOverlay(marker);
			map.centerAndZoom(new BMap.Point($('#map_long').val(),$('#map_lat').val()), 19);
		}else{
			function myFun(result){
				oPoint = new BMap.Point(result.center['lng'],result.center['lat']);
				map.centerAndZoom(oPoint,15);
			}
			var myCity = new BMap.LocalCity();
			myCity.get(myFun);
		}
		
		map.addControl(new BMap.NavigationControl());
		map.enableScrollWheelZoom();
		
		map.addEventListener("click",function(e){
			if(!e.overlay){
				if(marker == null){
					marker = new BMap.Marker(new BMap.Point(e.point.lng,e.point.lat),{icon:new BMap.Icon("http://map.baidu.com/image/markers_new.png", new BMap.Size(25, 37), {anchor: new BMap.Size(12,15), imageOffset: new BMap.Size(0,-156)}),enableMassClear:false});
					map.addOverlay(marker);
				}else{
					marker.setPosition(new BMap.Point(e.point.lng,e.point.lat));
				}
				setPoint(marker);
			}
		});
		local = new BMap.LocalSearch(map,{
			pageCapacity:10,
			onSearchComplete:function(results){
				search_point = [];
				var search_count = results.getCurrentNumPois();
				if(search_count > 0){
					$('.shop-map-container > .left').removeClass('hide');
					var result_panel = '<ul class="place-list js-place-list">';
					for(var i=0;i<search_count;i++){
						var now_poi = results.getPoi(i);
						result_panel += '<li data-lng="'+now_poi.point.lng+'" data-lat="'+now_poi.point.lat+'" data-title="'+now_poi.title+'" data-content="'+now_poi.address+'"><i class="place-order">'+getWord(i)+'</i><h3>'+now_poi.title+'</h3><p class="place-adress">地址：'+now_poi.address+'</p>'+(now_poi.phoneNumber ?'<p class="place-phone">电话：'+now_poi.phoneNumber+'</p>' : '')+'</li>';					
						if(i == 0){
							map.centerAndZoom(new BMap.Point(now_poi.point.lng,now_poi.point.lat),17);
						}
						
						var search_marker = new BMap.Marker(new BMap.Point(now_poi.point.lng,now_poi.point.lat),{icon:new BMap.Icon("http://map.baidu.com/image/markers_new.png", new BMap.Size(19, 27), {anchor: new BMap.Size(10,9), imageOffset: new BMap.Size(i*-24,-199)})});
						search_point[i] = search_marker;
						map.addOverlay(search_marker);
					}
					result_panel += '</ul>';
					$('.shop-map-container > .left').html(result_panel);
					$('.js-map-container').removeClass('large');
					
					$.each(search_point,function(i,item){
						(function(){
							var index = i;
							search_point[i].addEventListener('click', function(){
								$('.shop-map-container .left .place-list li').eq(i).click();
							});    
						})();
					});
				}else{
					layer_tips(1,'搜索 " '+$('.js-address-input').val()+' " 无结果');
				}
			}
		});
		$('.shop-map-container .left .place-list li').live('mouseover mouseout click',function(e){			
			var nowDom = $(this);
			if(e.type == 'mouseover'){
				nowDom.addClass('active');
				var a = nowDom.index();
				$.each($('.shop-map-container .left .place-list li'),function(i,item){
					if(i == a){
						search_point[i].setIcon(new BMap.Icon("http://map.baidu.com/image/markers_new.png", new BMap.Size(26,36), {anchor: new BMap.Size(14,13), imageOffset: new BMap.Size(i*-34,-73)}));
						search_point[i].setZIndex(3);
					}else if($(item).data('is_selected') != 1){
						search_point[i].setIcon(new BMap.Icon("http://map.baidu.com/image/markers_new.png", new BMap.Size(19, 27), {anchor: new BMap.Size(10,9), imageOffset: new BMap.Size(i*-24,-199)}));
						search_point[i].setZIndex(1);
					}
				});			
			}else if(e.type == 'mouseout'){
				if(nowDom.data('is_selected') != 1){
					nowDom.removeClass('active');
				}
			}else{				
				$('.shop-map-container .left .place-list li').data('is_selected',0).removeClass('active');
				nowDom.data('is_selected',1).addClass('active').mouseover();
				var a = nowDom.index();
				var pt = search_point[a].getPosition();
				(new BMap.Geocoder()).getLocation(pt,function(rs){
					addComp = rs.addressComponents;
					infoWindow = new BMap.InfoWindow('<div class="info-window"><h3 style="font-size:14px;font-weight:bold;">'+nowDom.data('title')+'</h3><p class="address">'+ nowDom.data('content')+'</p><div style="text-align:center;"><a class="ui-btn ui-btn-confirm js-confirm" onclick="setSelect(\''+nowDom.data('lat')+'\',\''+nowDom.data('lng')+'\')">确认位置</a></div></div>',{width:220,height:(nowDom.data('title').length>15 ? 100 : 80),title : "",enableMessage:false,message:""});
					search_point[a].openInfoWindow(infoWindow);
				});
				map.panTo(search_point[a].getPosition());
				search_point[a].setZIndex(2);
			}
		});
		$('.js-search').click(function(){
			map.clearOverlays();
			if($('.js-address-input').val() != ''){
				var search_val = '';
				if($('#s1').val()){
					search_val = search_val + $('#s1 option:checked').text();
				}
				if($('#s2').val()){
					search_val = search_val + $('#s2 option:checked').text();
				}
				if($('#s3').val()){
					search_val = search_val + $('#s3 option:checked').text();
				}
				search_val = search_val+$('.js-address-input').val();
				local.search(search_val);
			}else{
				layer_tips(1,'请填写地址');
			}
			return false;
		});
	});
});

function getWord(num){
	var word = ['A','B','C','D','E','F','G','H','I','J'];
	return word[num];
}
function setSelect(lat,lng){
	layer_tips(-1,'地理位置已确认，不要忘记保存哦');
	$('.js-confirm').addClass('ui-btn-disabled').removeClass('ui-btn-confirm').html('位置已确认');
	$('#map_long').val(lng);
	$('#map_lat').val(lat);
}