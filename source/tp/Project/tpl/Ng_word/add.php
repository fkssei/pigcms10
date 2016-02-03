<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Ng_word/add')}" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">敏感词</th>
				<td>
					<textarea rows="8" cols="30" placeholder="一行一条记录" name="ng_word" validate="required:true" tips=""></textarea>
				</td>
				<th width="80">替换</th>
				<td>
					<textarea rows="8" cols="30" placeholder="一行一条记录" name="replace_word"></textarea>
					与敏感词对应，如果不对应，少的部分将替换为*号
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>

<include file="Public:footer"/>