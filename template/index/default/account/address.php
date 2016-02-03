<?php include display( 'public:person_header');?>
<script src="<?php echo $config['site_url'];?>/static/js/area/area.min.js"></script>
<script src="<?php echo TPL_URL;?>js/address.js"></script>
<script>
    $(document).ready(function () {
    	$('#address').ajaxForm({
    		beforeSubmit: showRequest,
    		success: showResponse,
    		dataType: 'json'
    	});

    	$("#old_password").focus();
    });

   
	function showRequest() {
		var name = $("#name").val();
		var tel = $("#tel").val();
		var province = $("#provinceId_m").val();
		var city = $("#cityId_m").val();
		var area = $("#areaId_m").val();
		var address = $("#jiedao").val();

		if (name.length == 0) {
			tusi("请填写收货人姓名");
			$("#name").focus();
			return false;
		}

		if (tel.length == 0) {
			tusi('请填写手机号码');
			$("#tel").focus();
			return false;
		}

		if (!checkMobile(tel)) {
			tusi("手机号码格式不正确");
			$("#tel").focus();
			return false;
		}

		if (province.length <= 0) {
			tusi("请选择省份");
			$("#provinceId_m").focus();
			return false;
		}

		if (city.length <= 0) {
			tusi("请选择城市");
			$("#cityId_m").focus();
			return false;
		}

		if (area.length <= 0) {
			tusi("请选择地区");
			$("#areaId_m").focus();
			return false;
		}

		if (address.length < 10) {
			tusi('街道地址不能少于10个字');
			("#jiedao").focus();
			return false;
		}

		if (address.length　> 120) {
			tusi('街道地址不能多于120个字');
			("#jiedao").focus();
			return false;
		}
		
		return true;
	}

	function deleteAddress(id) {
		if (confirm('您确认要删除些收货地址？')) {
			var url = '<?php echo url('account:delete_address') ?>&id=' + id;
			$.getJSON(url, function (data) {
				showResponse(data);
			});
		}
	}

	function setDefault(id) {
		var url = '<?php echo url('account:default_address') ?>&id=' + id;
		$.getJSON(url, function (data) {
			showResponse(data);
		});
	}
    </script>
<style type="text/css">
.order_tianjia_form .order_tianjian_form_select select { color: #000 }
</style>
<div id="con_one_5"> 
	<!-----------------收货地址--------------------------->
	<div class="danye_content_title">
		<div class="danye_suoyou"><a href="###"><span>收货地址</span></a></div>
	</div>
	<div class="order_add_list">
		<ul class="order_add_list_ul">
			<?php 
                    foreach ($address_list as $tmp) {
                    ?>
			<li><span class="e-modify" data_id="<?php echo $tmp['address_id'] ?>" data_name="<?php echo htmlspecialchars($tmp['name']) ?>" data_province="<?php echo $tmp['province'] ?>" data_city="<?php echo $tmp['city'] ?>" data_area="<?php echo $tmp['area'] ?>" data_tel="<?php echo $tmp['tel'] ?>" data_address="<?php echo htmlspecialchars($tmp['address']) ?>" data_default="<?php echo $tmp['default'] ?>"></span>
				<div class="order_add_add"><?php echo $tmp['province_txt']?><?php echo $tmp['city_txt'] ?><?php echo $tmp['area_txt'] ?><?php echo htmlspecialchars($tmp['address']) ?></div>
				<div class="order_add_name"><?php echo htmlspecialchars($tmp['name']) ?></div>
				<div class="order_add_shouji"><?php echo $tmp['tel'] ?></div>
				<div class="order_add_caozuo"><a href="javascript:void(0)" class="e-modify" data_id="<?php echo $tmp['address_id'] ?>" data_name="<?php echo htmlspecialchars($tmp['name']) ?>" data_province="<?php echo $tmp['province'] ?>" data_city="<?php echo $tmp['city'] ?>" data_area="<?php echo $tmp['area'] ?>" data_tel="<?php echo $tmp['tel'] ?>" data_address="<?php echo htmlspecialchars($tmp['address']) ?>" data_default="<?php echo $tmp['default'] ?>"><i>修改</i></a>|<a href="javascript:deleteAddress('<?php echo $tmp['address_id'] ?>')" class="e-delete"><i>删除</i></a></div>
			</li>
			<?php 
                            	}
                                ?>
			<li  id="order_tianjian"><span class="order_curn"></span>填写新地址</li>
		</ul>
		<div class="order_tianjia_form">
			<form name="address" id="address" method="post">
				<ul>
					<li>
						<div class="order_tianjian_form_left"><span></span>所在地:</div>
						<div class="order_tianjian_form_select">
							<select name="province" id="provinceId_m" data-province="">
								<option>省份</option>
							</select>
						</div>
						<div class="order_tianjian_form_select">
							<select name="city" id="cityId_m" data-city="">
								<option>城市</option>
							</select>
						</div>
						<div class="order_tianjian_form_select">
							<select name="area" id="areaId_m" data-area="">
								<option>区县</option>
							</select>
						</div>
					</li>
					<li>
						<div class="order_tianjian_form_left"><span></span>所在街道:</div>
						<div class="order_tianjian_form_right order_input">
							<input id="jiedao" class="jiedao inputText" placeholder="不需要重复填写省市区，必须大于10个字，小于120个字" maxlength="120" name="address"/>
						</div>
					</li>
					<li>
						<div class="order_tianjian_form_left"><span></span>收件人:</div>
						<div class="order_tianjian_form_right">
							<input id="name" class="inputText" type="text" maxlength="12" name="name" />
						</div>
					</li>
					<li>
						<div class="order_tianjian_form_left"><span></span>联系电话:</div>
						<div class="order_tianjian_form_right">
							<input id="tel" class="inputText" type="text" maxlength="11" name="tel">
						</div>
					</li>
					<li>
						<button class="order_add_queren">确认提交</button>
						<input type="hidden" name="保存" id="add" />
						<input type="hidden" name="address_id" id="address_id" value="" />
					</li>
				</ul>
			</form>
		</div>
	</div>
	
	<!-----------------收货地址---------------------------> 
</div>
<script type="text/javascript">
					$('.order_add_list_ul>li>span').click(function(){
						var aSpan=$('.order_add_list_ul li span');
						aSpan.each(function(){
							$(this).removeClass();
						});
						$(this).attr('class','order_curn');
					  });
					  
					  $('#order_tianjian span').click(function(){
						 	$('#jiedao').val(''); 
							$('#name').val(''); 
							$('#tel').val('');
							$('#cityId_m').html('<option>城市</option>');
							$('#areaId_m').html('<option>区县</option>');
							$('#address_id').val('');
						});
				</script>
<?php include display( 'public:person_footer');?>

