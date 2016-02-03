<div>
    <form class="form-horizontal">
        <fieldset>
            <div class="control-group">
                <label class="control-label">公司名称：</label>
                <div class="controls">
                    <input class="company-name" type="text" placeholder="公司名称长度在 1 到 30 字之间" name="company_name" value="<?php echo $company['name']; ?>" style="width: 325px" maxlength="30/">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">公司地址：</label>

                <div class="controls">
                    <span>
                    <select id="s1" name="province" class="province">
                        <option value="">选择省份</option>
                    </select>
                    </span>
                    <span>
                    <select id="s2" name="city" class="city">
                        <option value="">选择城市</option>
                    </select>
                    </span>
                    <span>
                    <select id="s3" name="area" class="area">
                        <option value="">选择地区</option>
                    </select>
                    </span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <input class="address" type="text" placeholder="请填写具体地址" name="address" maxlength="50" value="<?php echo $company['address']; ?>" style="width: 325px" />
                </div>
            </div>

            <div class="controls">
                <button class="btn btn-large btn-primary submit-btn" type="button" data-loading-text="正在提交...">确认修改
                </button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?php dourl('select'); ?>">取消</a>
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
    getProvinces('s1', "<?php echo $company['province_code']; ?>");
    $('#s1').change(function(){
        $('#s2').html('<option>选择城市</option>');
        if($(this).val() != ''){
            getCitys('s2','s1',"<?php echo $company['city_code']; ?>");
        }
        $('#s3').html('<option>选择地区</option>');
    }).trigger('change');
    $('#s2').change(function () {
        getAreas('s3', 's2', "<?php echo $company['area_code']; ?>");
    }).trigger('change');
</script>