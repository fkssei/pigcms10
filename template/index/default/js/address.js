$(function(){
	if($('#add').size()>0){
		getProvinces('provinceId_m','','省份');
		$('#provinceId_m').change(function(){
			if($(this).val() != ''){
				getCitys('cityId_m','provinceId_m','','城市');
			}else{
				$('#cityId_m').html('<option value="">城市</option>');
			}
			$('#areaId_m').html('<option value="">区县</option>');
		});
		$('#cityId_m').change(function(){
			if($(this).val() != ''){
				getAreas('areaId_m','cityId_m','','区县');
			}else{
				$('#areaId_m').html('<option value="">区县</option>');
			}
		});
	}
	
	
	$(".e-modify").click(function () {
		var address_id = $(this).attr("data_id");
		var name = $(this).attr("data_name");
		var province = $(this).attr("data_province");
		var city = $(this).attr("data_city");
		var area = $(this).attr("data_area");
		var tel = $(this).attr("data_tel");
		var address = $(this).attr('data_address');
		var moren = $(this).attr("data_default");
		
		$("#J_Title").html('修改收货人信息');
		$("#name").val(name);
		$("#tel").val(tel);
		$("#provinceId_m").attr("data-province", province);
		$("#cityId_m").attr("data-city", city);
		$("#areaId_m").attr("data-area", area);
		$("#jiedao").val(address);
		$("#address_id").val(address_id);
		
		if (moren == '1') {
			$("#isDefault").attr("checked", true);
		}
		
		changeArea();
	});
});


function changeArea() {
	getProvinces('provinceId_m',$('#provinceId_m').attr('data-province'),'省份');
	getCitys('cityId_m','provinceId_m',$('#cityId_m').attr('data-city'),'城市');
	getAreas('areaId_m','cityId_m',$('#areaId_m').attr('data-area'),'区县');
	$('#provinceId_m').change(function(){
		if($(this).val() != ''){
			getCitys('cityId_m','provinceId_m','','城市');
		}else{
			$('#cityId_m').html('<option value="">城市</option>');
		}
		$('#areaId_m').html('<option value="">区县</option>');
	});
	$('#cityId_m').change(function(){
		if($(this).val() != ''){
			getAreas('areaId_m','cityId_m','','区县');
		}else{
			$('#areaId_m').html('<option value="">区县</option>');
		}
	});
}

