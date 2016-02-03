<include file="Public:header"/>
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
    <input type="hidden" name="id" value="{pigcms{$store.store_id}"/>
    <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
        <tr>
            <th width="60" class="center">店铺LOGO</th>
            <td><div class="show"><img src="{pigcms{$store.logo}" width="60" height="60" /></div></td>
            <th width="80" class="center">店铺名称</th>
            <td colspan="3" class="right-border">{pigcms{$store.name}</td>
        </tr>
        <tr>
            <th width="80" class="center">商户账号</th>
            <td>{pigcms{$store.username}</td>
            <th class="center">商品名称</th>
            <td colspan="3" class="right-border">{pigcms{$store.nickname}</td>
        </tr>
        <tr>
            <th class="center">主营类目</th>
            <td>{pigcms{$store.category}</td>
            <th class="center">创建时间</th>
            <td colspan="3" class="right-border">{pigcms{$store.date_added|date='Y-m-d H:i:s', ###}</td>
        </tr>
        <tr>
            <th class="center">联系电话</th>
            <td>{pigcms{$store.tel}</td>
            <th class="center">QQ号码</th>
            <td colspan="3" class="right-border">{pigcms{$store.qq}</td>
        </tr>
        <tr>
            <th class="center">店铺收入</th>
            <td align="right">￥{pigcms{$store.income}</td>
            <th class="center">可提现金额</th>
            <td align="right">￥{pigcms{$store.balance}</td>
            <th class="center">待结算金额</th>
            <td align="right" class="right-border">￥{pigcms{$store.unbalance}</td>
        </tr>
        <tr>
            <th class="center">上门自提</th>
            <td align="center"><if condition="$store['buyer_selffetch'] eq 1">已启用<else/>未启用</if></td>
            <th class="center">找人代付</th>
            <td align="center" colspan="3" class="right-border"><if condition="$store['pay_agent'] eq 1">已启用<else/>未启用</if></td>
        </tr>
        <tr>
            <th width="80" class="center">店铺状态</th>
            <td data-id="<?php echo $store['store_id']; ?>">
            	<select class="js-store_status" onchange="changeStatus()">
            		<option value="1" <if condition="$store['status'] eq 1">selected="selected"</if>>正常</option>
            		<option value="2" <if condition="$store['status'] eq 2">selected="selected"</if>>待审核</option>
            		<option value="3" <if condition="$store['status'] eq 3">selected="selected"</if>>审核未通过</option>
            		<option value="4" <if condition="$store['status'] eq 4">selected="selected"</if>>店铺关闭</option>
            		<?php 
            		if ($store['drp_supplier_id']) {
            		?>
            			<option value="5" <if condition="$store['status'] eq 5">selected="selected"</if>>供货商关闭</option>
            		<?php 
            		}
            		?>
            	</select>
            </td>
            <th width="80" class="center">认证状态</th>
            <td colspan="3" class="right-border">
                <span class="cb-enable approve-enable"><label class="cb-enable <if condition="$store['approve'] eq 1">selected</if>" data-id="<?php echo $store['store_id']; ?>"><span>认证</span><input type="radio" name="approve" value="1" <if condition="$store['approve'] eq 1">checked="checked"</if> /></label></span>
                <span class="cb-disable approve-disable"><label class="cb-disable <if condition="$store['approve'] eq 0">selected</if>" data-id="<?php echo $store['store_id']; ?>"><span>取消</span><input type="radio" name="approve" value="0" <if condition="$store['approve'] eq 0">checked="checked"</if>/></label></span>
            </td>
        </tr>
        <tr>
            <th class="center">店铺描述</th>
            <td colspan="5" class="right-border">{pigcms{$store.intro}</td>
        </tr>
        <tr>
            <th class="center" colspan="6">提现账号</th>
        </tr>
        <tr>
            <th class="center">提现方式</th>
            <td><if condition="$store['widthdrawal_type'] eq 1">对公银行账户<else/>对私银行账户</if></td>
            <th class="center">开户银行</th>
            <td colspan="3" class="right-border">{pigcms{$store.bank}</td>
        </tr>
        <tr>
            <th class="center">银行卡号</th>
            <td>{pigcms{$store.bank_card}</td>
            <th class="center">开卡人姓名</th>
            <td colspan="3" class="right-border">{pigcms{$store.bank_card_user}</td>
        </tr>
    </table>
    <div class="btn hidden">
        <input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
        <input type="reset" value="取消" class="button" />
    </div>

<include file="Public:footer"/>