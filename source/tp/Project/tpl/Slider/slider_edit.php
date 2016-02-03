<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Slider/slider_amend')}" enctype="multipart/form-data">
		<input type="hidden" name="id" value="{pigcms{$now_slider.id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">导航名称</th>
				<td><input type="text" class="input fl" name="name" value="{pigcms{$now_slider.name}" size="20" placeholder="请输入名称" validate="maxlength:20,required:true"/></td>
			</tr>
			<if condition="$now_slider['pic']">
				<tr>
					<th width="80">导航现图</th>
					<td><img src="{pigcms{$now_slider.pic}" style="width:80px;height:80px;" class="view_msg"/><span>&#29399;&#25169;&#28304;&#30721;&#31038;&#21306;&#45;&#98;&#98;&#115;&#46;&#103;&#111;&#112;&#101;&#46;&#99;&#110;</span>
</td>
				</tr>
			</if>
			<tr>
				<th width="80">导航图片</th>
				<td><input type="file" class="input fl" name="pic" style="width:200px;" placeholder="请上传图片" tips="不修改请不上传！上传新图片，老图片会被自动删除！"/></td>
			</tr>
			<tr>
				<th width="80">链接地址</th>
				<td><input type="text" class="input fl" name="url" value="{pigcms{$now_slider.url}" style="width:200px;" placeholder="请填写链接地址" validate="maxlength:200,required:true,url:true"/></td>
			</tr>
			<tr>
				<th width="80">导航状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable selected"><span>启用</span><input type="radio" name="status" value="1" checked="checked" /></label></span>
					<span class="cb-disable"><label class="cb-disable"><span>关闭</span><input type="radio" name="status" value="0" /></label></span>
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>