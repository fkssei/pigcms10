<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset={:C('DEFAULT_CHARSET')}" />
		<title>网站后台管理 Powered by pigcms.com</title>
		<script type="text/javascript">
			<!--if(self==top){window.top.location.href="<?php echo U('Index/index');?>";}-->
			var kind_editor=null,static_public="<?php echo ($static_public); ?>",static_path="<?php echo ($static_path); ?>",system_index="<?php echo U('Index/index');?>",choose_province="<?php echo U('Area/ajax_province');?>",choose_city="<?php echo U('Area/ajax_city');?>",choose_area="<?php echo U('Area/ajax_area');?>",choose_circle="<?php echo U('Area/ajax_circle');?>",choose_map="<?php echo U('Map/frame_map');?>",get_firstword="<?php echo U('Words/get_firstword');?>",frame_show=<?php if($_GET['frame_show']): ?>true<?php else: ?>false<?php endif; ?>;
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo C('JQUERY_FILE');?>"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/common.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/date.js"></script>
		</head>
		<body width="100%" 
		<?php if($bg_color): ?>style="background:<?php echo ($bg_color); ?>;"<?php endif; ?>
> 
    <style type="text/css">
        .frame_form th{
            border-left: 1px solid #e5e3e3!important;
            font-weight: bold;
            color:#ccc;
        }
        .frame_form td {
            vertical-align: middle;
        }
        .center {
            text-align: center!important;
        }
        .right-border {
            border-right: 1px solid #e5e3e3!important;
        }
    </style>
    <script type="text/javascript">
        $(function(){
            $('.status-enable > .cb-enable').click(function(){
                if (!$(this).hasClass('selected')) {
                    var store_id = $(this).data('id');
                    $.post("<?php echo U('Store/status'); ?>",{'status': 1, 'store_id': store_id}, function(data){})
                }
            })
            $('.status-disable > .cb-disable').click(function(){
                var store_id = $(this).data('id');
                if (!$(this).hasClass('selected')) {
                    $.post("<?php echo U('Store/status'); ?>",{'status': 0,  'store_id': store_id}, function(data){})
                }
            })
			$(".js-store_status").change(function () {
				var store_id = $(this).closest("td").data("id");
				var status = $(this).val();
				$.post("<?php echo U('Store/status'); ?>",{'status': status,  'store_id': store_id}, function(data){})
			});
            $('.approve-enable > .cb-enable').click(function(){
                if (!$(this).hasClass('selected')) {
                    var store_id = $(this).data('id');
                    $.post("<?php echo U('Store/approve'); ?>",{'approve': 1, 'store_id': store_id}, function(data){})
                }
            })
            $('.approve-disable > .cb-disable').click(function(){
                var store_id = $(this).data('id');
                if (!$(this).hasClass('selected')) {
                    $.post("<?php echo U('Store/approve'); ?>",{'approve': 0,  'store_id': store_id}, function(data){})
                }
            })
        })
    </script>
    <input type="hidden" name="id" value="<?php echo ($store["store_id"]); ?>"/>
    <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
        <tr>
            <th width="60" class="center">店铺LOGO</th>
            <td><div class="show"><img src="<?php echo ($store["logo"]); ?>" width="60" height="60" /></div></td>
            <th width="80" class="center">店铺名称</th>
            <td colspan="3" class="right-border"><?php echo ($store["name"]); ?></td>
        </tr>
        <tr>
            <th width="80" class="center">商户账号</th>
            <td><?php echo ($store["username"]); ?></td>
            <th class="center">商品名称</th>
            <td colspan="3" class="right-border"><?php echo ($store["nickname"]); ?></td>
        </tr>
        <tr>
            <th class="center">主营类目</th>
            <td><?php echo ($store["category"]); ?></td>
            <th class="center">创建时间</th>
            <td colspan="3" class="right-border"><?php echo (date('Y-m-d H:i:s', $store["date_added"])); ?></td>
        </tr>
        <tr>
            <th class="center">联系电话</th>
            <td><?php echo ($store["tel"]); ?></td>
            <th class="center">QQ号码</th>
            <td colspan="3" class="right-border"><?php echo ($store["qq"]); ?></td>
        </tr>
        <tr>
            <th class="center">店铺收入</th>
            <td align="right">￥<?php echo ($store["income"]); ?></td>
            <th class="center">可提现金额</th>
            <td align="right">￥<?php echo ($store["balance"]); ?></td>
            <th class="center">待结算金额</th>
            <td align="right" class="right-border">￥<?php echo ($store["unbalance"]); ?></td>
        </tr>
        <tr>
            <th class="center">上门自提</th>
            <td align="center"><?php if($store['buyer_selffetch'] == 1): ?>已启用<?php else: ?>未启用<?php endif; ?></td>
            <th class="center">找人代付</th>
            <td align="center" colspan="3" class="right-border"><?php if($store['pay_agent'] == 1): ?>已启用<?php else: ?>未启用<?php endif; ?></td>
        </tr>
        <tr>
            <th width="80" class="center">店铺状态</th>
            <td data-id="<?php echo $store['store_id']; ?>">
            	<select class="js-store_status" onchange="changeStatus()">
            		<option value="1" <?php if($store['status'] == 1): ?>selected="selected"<?php endif; ?>>正常</option>
            		<option value="2" <?php if($store['status'] == 2): ?>selected="selected"<?php endif; ?>>待审核</option>
            		<option value="3" <?php if($store['status'] == 3): ?>selected="selected"<?php endif; ?>>审核未通过</option>
            		<option value="4" <?php if($store['status'] == 4): ?>selected="selected"<?php endif; ?>>店铺关闭</option>
            		<?php  if ($store['drp_supplier_id']) { ?>
            			<option value="5" <?php if($store['status'] == 5): ?>selected="selected"<?php endif; ?>>供货商关闭</option>
            		<?php  } ?>
            	</select>
            </td>
            <th width="80" class="center">认证状态</th>
            <td colspan="3" class="right-border">
                <span class="cb-enable approve-enable"><label class="cb-enable <?php if($store['approve'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $store['store_id']; ?>"><span>认证</span><input type="radio" name="approve" value="1" <?php if($store['approve'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
                <span class="cb-disable approve-disable"><label class="cb-disable <?php if($store['approve'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $store['store_id']; ?>"><span>取消</span><input type="radio" name="approve" value="0" <?php if($store['approve'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
            </td>
        </tr>
        <tr>
            <th class="center">店铺描述</th>
            <td colspan="5" class="right-border"><?php echo ($store["intro"]); ?></td>
        </tr>
        <tr>
            <th class="center" colspan="6">提现账号</th>
        </tr>
        <tr>
            <th class="center">提现方式</th>
            <td><?php if($store['widthdrawal_type'] == 1): ?>对公银行账户<?php else: ?>对私银行账户<?php endif; ?></td>
            <th class="center">开户银行</th>
            <td colspan="3" class="right-border"><?php echo ($store["bank"]); ?></td>
        </tr>
        <tr>
            <th class="center">银行卡号</th>
            <td><?php echo ($store["bank_card"]); ?></td>
            <th class="center">开卡人姓名</th>
            <td colspan="3" class="right-border"><?php echo ($store["bank_card_user"]); ?></td>
        </tr>
    </table>
    <div class="btn hidden">
        <input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
        <input type="reset" value="取消" class="button" />
    </div>

	</body>
</html>