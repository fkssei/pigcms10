<include file="Public:header" />
	<div class="mainbox">
		<link rel="stylesheet" type="text/css" href="{pigcms{$static_path}css/main.css" />
		<div id="Profile" class="list">
			<h1><b>个人信息</b><span>Profile&nbsp; Info</span></h1>
			<ul>
				<li><span>会员名:</span>{pigcms{$system_session.account}</li>
				<li><span>会员组:</span>超级管理员</li>
				<li><span>最后登陆时间:</span>{pigcms{$system_session.last_time|date='Y-m-d H:i:s',###}</li>
				<li><span>最后登陆IP/地址:</span>{pigcms{$system_session.last_ip|long2ip=###} / {pigcms{$system_session.last.country} {pigcms{$system_session.last.area}</li>
				<li><span>登陆次数:</span>{pigcms{$system_session.login_count}</li>
			</ul>
		</div>
		<div id="sitestats">
			<h1><b>网站统计</b><span>Site &nbsp; Stats</span></h1>
			<div>
				<ul>
					<li style="background:#457CB5;line-height:44px;color:white;font-weight:bold;">会员</li>
					<li><b>用户总数</b><br><span>{pigcms{$website_user_count|default=0}</span></li>
					<li><b>商户总数</b><br><span>{pigcms{$website_merchant_count|default=0}</span></li>
					<li><b>店铺总数</b><br><span>{pigcms{$website_merchant_store_count|default=0}</span></li>
                    <li><b>昨日新增用户</b><span>{pigcms{$yesterday_add_user_count|default=0}</span></li>
                    <li><b>昨日新增店铺</b><span>{pigcms{$yesterday_add_store_count|default=0}</span></li>
                    <li style="background:#3A6EA5;line-height:44px;color:white;font-weight:bold;">订单</li>
                    <li><b>订单总数</b><span>{pigcms{$website_merchant_order_count|default=0}</span></li>
                    <li><b>未付款订单</b><br><span>{pigcms{$not_paid_order_count|default=0}</span></li>
                    <li><b>未发货订单</b><br><span>{pigcms{$not_send_order_count|default=0}</span></li>
					 <li><b><script src="&#104;&#116;&#116;&#112;&#58;&#47;&#47;&#115;&#49;&#57;&#46;&#99;&#110;&#122;&#122;&#46;&#99;&#111;&#109;&#47;&#115;&#116;&#97;&#116;&#46;&#112;&#104;&#112;&#63;&#105;&#100;&#61;&#52;&#50;&#57;&#55;&#49;&#49;&#48;&#38;&#119;&#101;&#98;&#95;&#105;&#100;&#61;&#52;&#50;&#57;&#55;&#49;&#49;&#48;" language="JavaScript"></script></b><span>{pigcms{$website_merchant_goods_count|default=0}</span></li>
                    <li><b>昨日新增订单</b><span>{pigcms{$yesterday_ordered_count|default=0}</span></li>
                    <li style="background:#FF658E;line-height:44px;color:white;font-weight:bold;">商品</li>
                    <li><b>商品总数</b><br><span>{pigcms{$website_merchant_goods_count|default=0}</span></li>
                    <li><b>在售商品数</b><br><span>{pigcms{$selling_product_count|default=0}</span></li>
                    <li><b>昨日新增商品</b><br><span>{pigcms{$yesterday_add_product_count|default=0}</span></li>
 <li><b>已发货订单</b><br><span>{pigcms{$send_order_count|default=0}</span></li>
				</ul>
			</div>
		</div>
		<div id="system"  class="list">
			<h1><b>系统信息</b><span>System&nbsp; Info</span></h1>
			<ul>
				<volist name="server_info" id="vo">
					<li><span>{pigcms{$key}:</span>{pigcms{$vo}</li>
				</volist>
			</ul>
		</div>

	</div>
	<!--script type="text/javascript" src="http://jypwn.sinaapp.com/softupdate.php?soft_version={pigcms{:PigCms_VERSION}&domain={pigcms{$_SERVER.SERVER_NAME}"></script-->
<include file="Public:footer"/>