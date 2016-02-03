<include file="Public:header"/>
<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
	<tr>
		<th width="180">菜品名称</th>
		<th>单价</th>
		<th>数量</th>
	</tr>
	<volist name="order['info']" id="vo">
	<tr>
		<th width="180">{pigcms{$vo['name']}</th>
		<th>{pigcms{$vo['price']}</th>
		<th>{pigcms{$vo['num']}</th>
	</tr>
	</volist>
</table>
<include file="Public:footer"/>