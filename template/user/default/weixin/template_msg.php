<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>公众号信息 - <?php echo $config['site_name'];?></title>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/common.js"></script>
		<script src="/static/js/cart/jscolor.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.form.min.js"></script>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/sendall.css" rel="stylesheet" type="text/css"/>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="nav-wrapper--app"></div>
						<div class="app__content page-setting-weixin">
							<div>
								<div style="background:#fefbe4;border:1px solid #f3ecb9;color:#993300;padding:10px;margin-bottom:5px;font-size:12px;margin-top:5px;">温馨提示：此功能仅限于已开通微信支付功能的公众号使用。<br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 必须填写【模板ID】才能【开启】模板消息推送状态。<br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;【模板ID】请到 <a href="http://mp.weixin.qq.com" target="_blank" style="color:#029700">微信公众平台</a> &gt;&gt; 模板消息 &gt;&gt; 模板库 选择对应【模板编号】的模板，然后获取【模板ID】填写到此处。 <br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 以下所有模板均属于“IT科技/互联网|电子商务。
								</div>
								<form name="myform" id="myform" action="<?php dourl('weixin:templateMsg');?>" method="post" refresh="true">
									<table class="ui-table ui-table-list" width="100%" cellspacing="0">
										<colgroup><col> <col> <col><col>  <col width="180" align="center"> </colgroup>
										<thead>
											<tr>
												<th>模板编号</th>
												<th>模板名</th>
												<th>回复内容</th>
<!-- 												<th>头部颜色</th>
<th>文字颜色</th> -->
												<th>状态</th>
												<th>模板ID</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($list as $key=>$val){?>
							                    <tr>
							                      <td><input type="hidden" name="tempkey[]" value="<?php echo $val['tempkey'];?>" /><?php echo $val['tempkey'];?></td>
							                      <td><input type="hidden" name="name[]" value="<?php echo $val['name'];?>" /><?php echo $val['name'];?></td>
							                      <td><input type="hidden" name="content[]" value="<?php echo $val['content'];?>" /><pre><?php echo $val['content'];?></pre></td>
							                      <td style="display:none;"><input type="text" name="topcolor[]" value="<?php echo $val['topcolor'];?>" class="px color" style="width: 55px; background:<?php echo $val['topcolor'];?>; color: rgb(255, 255, 255);"</td>
							                      <td style="display:none;">
							                        <input type="text" name="textcolor[]" value="<?php echo $val['textcolor'];?>" class="px color" style="width: 55px; background:<?php echo $val['textcolor'];?>; color: rgb(255, 255, 255);" />
							                      </td>
							                      <td>
							                          <select name="status[]" style="width:70px;">
							                            <option value="0" <?php if($val['status'] == 0){echo 'selected';}?>>关闭</option>
							                            <option value="1" <?php if($val['status'] == 1){echo 'selected';}?>>开启</option>
							                          <select>
							                      </td>
							                      <td class="norightborder"><input type="text" class="input-text" name="tempid[]" value="<?php echo $val['tempid'];?>" /></td>
							                    </tr>
							                  <?php }?>
							                  <tr>
							                    <td colspan="7" align="center"><input type="submit" name="dosubmit" value="保存" class="ui-btn ui-btn-primary"/></td>
							                  </tr>
										</tbody>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include display('sidebar');?>
		</div>
		<?php include display('public:footer');?>
		<script>
			$(function(){
				$('#myform').ajaxForm({
					beforeSubmit: showRequest,
					success: showResponse,
					dataType: 'json'
				});
				function showRequest(){

				}
				function showResponse(res){
					tusi(res.err_msg);
					if(res.err_code == 0){
						setTimeout(function(){
							location.reload();
						},1500);
					}
				}
			});	
		</script>
	</body>
</html>