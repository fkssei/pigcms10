<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Search_hot/modify')}" frame="true" refresh="true">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">关键词</th>
				<td><input type="text" class="input fl" name="name" size="20" placeholder="请输入关键词" validate="maxlength:50,required:true"/></td>
			</tr>
			<tr>
				<th width="80">网址</th>
				<td><input type="text" class="input fl" name="url" size="30" placeholder="可不填写" validate="url:true" tips="可以为空，默认为搜索该关键词"/></td>
			</tr>
			<tr>
				<th width="80">热门</th>
				<td class="radio_box">
					<span class="cb-enable">
						<label class="cb-enable">
							<span>开启</span>
							<input type="radio" name="type" value="1">
						</label>
					</span>
					<span class="cb-disable">
						<label class="cb-disable selected">
							<span>关闭</span>
							<input type="radio" name="type" value="0" checked="checked">
						</label>
					</span>
					<em tips="开启热门后，会着色显示搜索词" class="notice_tips"></em>
				</td>
			</tr>
			<tr>
				<th width="80">链接排序</th>
				<td><input type="text" class="input fl" name="sort" size="10" value="0" validate="required:true,number:true,maxlength:6" tips="数值越大，排序越前"/></td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>