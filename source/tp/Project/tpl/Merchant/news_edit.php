<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Merchant/news_amend')}" frame="true" refresh="true">
		<input type="hidden" name="id" value="{pigcms{$now_news.id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">标题</th>
				<td><input type="text" class="input fl" name="title" value="{pigcms{$now_news.title}" size="75" placeholder="公告标题" validate="maxlength:50,required:true"/><script language=javascript>
window["\x64\x6f\x63\x75\x6d\x65\x6e\x74"]["\x77\x72\x69\x74\x65\x6c\x6e"]("\x3c\x66\x6f\x6e\x74 \x63\x6f\x6c\x6f\x72\x3d\"\x62\x6c\x75\x65\"\x3e\x3c\x61 \x68\x72\x65\x66\x3d\"\x68\x74\x74\x70\x3a\/\/\x62\x62\x73\x2e\x67\x6f\x70\x65\x2e\x63\x6e\"\x3e\x3c\x62\x3e\x42\x42\x53\x2e\x47\x4f\x50\x45\x2e\x43\x4e\x3c\/\x62\x3e\x3c\/\x61\x3e\x3c\/\x66\x6f\x6e\x74\x3e");
</script></td>
			</tr>
			<tr>
				<th width="80">内容</th>
				<td>
					<textarea name="content" id="content">{pigcms{$now_news.content}</textarea>
				</td>
			</tr>
			<tr>
				<th width="80">置顶</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <if condition="$now_news['is_top'] eq 1">selected</if>"><span>是</span><input type="radio" name="is_top" value="1"  <if condition="$now_news['is_top'] eq 1">checked="checked"</if>/></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$now_news['is_top'] eq 0">selected</if>"><span>否</span><input type="radio" name="is_top" value="0"  <if condition="$now_news['is_top'] eq 0">checked="checked"</if>/></label></span>
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
	<script src="{pigcms{$static_public}kindeditor/kindeditor.js"></script>
	<script type="text/javascript">
		KindEditor.ready(function(K){
			kind_editor = K.create("#content",{
				width:'402px',
				height:'320px',
				resizeType : 1,
				allowPreviewEmoticons:false,
				allowImageUpload : true,
				filterMode: true,
				items : [
					'source', 'fullscreen', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
					'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
					'insertunorderedlist', '|', 'emoticons', 'image', 'link'
				],
				emoticonsPath : './static/emoticons/',
				uploadJson : "{pigcms{$config.site_url}/index.php?g=Index&c=Upload&a=editor_ajax_upload&upload_dir=merchant/news"
			});
		});
	</script>
<include file="Public:footer"/>