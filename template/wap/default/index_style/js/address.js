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
		$('#add').click(function(){
			if($('#name').val() == ''){
				alert('请填写收货人名字');
			}else if(!/^0[0-9\-]{10,13}$/.test($('#mobile').val()) && !/^((\+86)|(86))?(1)\d{10}$/.test($('#mobile').val())){
				alert('请填写正确的手机号码或电话号码');
			}else if($('#provinceId_m').val() == ''){
				alert('请选择省份');
			}else if($('#cityId_m').val() == ''){
				alert('请选择城市');
			}else if($('#areaId_m').val() == ''){
				alert('请选择区县');
			}else if($('#adinfo').val() == ''){
				alert('请填写详细地址');
			}else{
				$('#wxloading').show();
				$.post('./index_ajax.php?action=address_add',{name:$('#name').val(),tel:$('#mobile').val(),province:$('#provinceId_m').val(),city:$('#cityId_m').val(),area:$('#areaId_m').val(),address:$('#adinfo').val()},function(result){
					if(result.err_code){
						$('#wxloading').hide();
						alert(result.err_msg);
					}else{
						location.href = './my_address.php';
					}
				});
			}
		});
	}else if($('#edit').size()>0){
		getProvinces('provinceId_m',$('#provinceId_m').data('province'),'省份');
		getCitys('cityId_m','provinceId_m',$('#cityId_m').data('city'),'城市');
		getAreas('areaId_m','cityId_m',$('#areaId_m').data('area'),'区县');
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
		$('#edit').click(function(){
			if($('#name').val() == ''){
				alert('请填写收货人名字');
			}else if(!/^0[0-9\-]{10,13}$/.test($('#mobile').val()) && !/^((\+86)|(86))?(1)\d{10}$/.test($('#mobile').val())){
				alert('请填写正确的手机号码或电话号码');
			}else if($('#provinceId_m').val() == ''){
				alert('请选择省份');
			}else if($('#cityId_m').val() == ''){
				alert('请选择城市');
			}else if($('#areaId_m').val() == ''){
				alert('请选择区县');
			}else if($('#adinfo').val() == ''){
				alert('请填写详细地址');
			}else{
				$('#wxloading').show();
				$.post('./index_ajax.php?action=address_save',{address_id:$('#address_id').val(),name:$('#name').val(),tel:$('#mobile').val(),province:$('#provinceId_m').val(),city:$('#cityId_m').val(),area:$('#areaId_m').val(),address:$('#adinfo').val()},function(result){
					if(result.err_code){
						$('#wxloading').hide();
						alert(result.err_msg);
					}else{
						location.href = './my_address.php';
					}
				});
			}
		});
	}else{
		$('#addressList .edit').click(function(){
			location.href = './my_address.php?action=edit&id='+$(this).data('id');
		});
		$('#addressList .del').click(function(){
			var nowDom = $(this).closest('.act');
			if(confirm('您确定要删除该地址吗？')){
				$('#wxloading').show();
				$.post('./index_ajax.php?action=address_del',{'address_id':nowDom.data('id')},function(result){
					if(result.err_code){
						alert(result.err_msg);
					}else{
						$('#wxloading').hide();
						nowDom.closest('.address').remove();
					}
				});
			}
		});
	}
});