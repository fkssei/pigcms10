<include file="Public:header"/>
<if condition="$withdrawal_count gt 0"> 
	<script type="text/javascript">
    $(function(){
	    $('#nav_12 > dd > #leftmenu_Store_withdraw', parent.document).html('提现记录 <label style="color:red">(' + {pigcms{$withdrawal_count} + ')</label>')
    })
</script>
	<else/>
	<script type="text/javascript">
        $(function(){
           // $('#nav_12 > dd:last-child > span', parent.document).html('提现记录');

	        $('#nav_12 > dd > #leftmenu_Store_withdraw', parent.document).html('提现记录');

        })
    </script> 
</if>
<div class="mainbox">
	<form name="myform" id="myform" action="" method="post">
		<div class="table-list">
			<table width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>编号</th>
						<th>店铺名称</th>
						<th>商户帐号</th>
						<th>商户名称</th>
						<th>联系电话</th>
						<th>主营类目</th>
					</tr>
				</thead>
				<tbody>
					<if condition="is_array($stores)">
						<volist name="stores" id="store">
							<tr>
								<td>{pigcms{$store.store_id}</td>
								<td>{pigcms{$store.name}</td>
								<td>{pigcms{$store.username}</td>
								<td>{pigcms{$store.nickname}</td>
								<td>{pigcms{$store.tel}</td>
								<td>{pigcms{$store.category}</td>
							</tr>
						</volist>
						<tr>
							<td class="textcenter pagebar" colspan="6">{pigcms{$page}</td>
						</tr>
						<else/>
						<tr>
							<td class="textcenter red" colspan="6">列表为空！</td>
						</tr>
					</if>
				</tbody>
			</table>
		</div>
	</form>
</div>
<include file="Public:footer"/>