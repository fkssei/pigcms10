<include file="Public:header"/>
	<form id="myform" method="post" action="<?php echo U('Ng_word/edit', array('id' => $ng_word['id'])) ?>" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">敏感词</th>
				<td>
					<input type="text" name="ng_word" value="<?php echo $ng_word['ng_word'] ?>" />
				</td>
			</tr>
			<tr>
				<th width="80">替换</th>
				<td>
					<input type="text" name="replace_word" value="<?php echo $ng_word['replace_word'] ?>" />
				</td>
			</tr>
		</table>
		<div class="btn ">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>

<include file="Public:footer"/>