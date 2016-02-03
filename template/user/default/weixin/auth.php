<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title><?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/image_text.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/wx_settled.css"/>
		<style type="text/css">
		.popover{
			display: block;
		}
		</style>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<div class="">
				<div class="app">
					<div class="app-inner clearfix">
						<div class="app-init-container">
							<div class="wxsettled">
								<ul class="wxsettled-prompt">
									<p>温馨提示：</p>
									<li>一个微信公众号只能和一个店铺绑定</li>
									<li>账号绑定后不支持解除绑定</li>
									<li>如果本店只是您用来测试的，绑定时请慎重</li>
								</ul>
								
								<form class="form-horizontal form-side-line" style="margin-bottom: 0">
									<h3 class="wxsettled-main-title">绑定微信公众号，把店铺和微信打通</h3>
									<p class="wxsettled-sub-title">绑定后即可在这里管理您的公众号，微店提供比微信官方后台更强大的功能！</p>
									<div class="control-group" style="padding-bottom: 30px;">
										<a class="btn btn-success cert-setting-btn js-wxauth-btn" target="_blank" data-url="<?php echo $url;?>" href="<?php echo $url;?>">我有微信公众号，立即设置</a>
									</div>
									<fieldset class="js-manual-toggle hide">
										<div class="control-group">
											<label class="control-label" for="lb-weixin">微信公众号：</label>
											<div class="controls">
												<input type="text" id="lb-weixin" maxlength="20" name="weixin" placeholder="如：pigcms">
												<a href="javascript:;" target="_blank" style="margin-left: 20px" tabindex="-1">怎么看我的微信公众号?</a>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="lb-nickname">公众号昵称：</label>
											<div class="controls">
												<input type="text" id="lb-nickname" name="nickname" placeholder="如：小猪Pigcms">
											</div>
										</div>
										<div class="control-group">
											<div class="controls">
												<button class="js-btn-submit btn btn-large btn-primary" data-loading-text="正在提交...">下一步</button>
											</div>
										</div>
									</fieldset>
								</form>
								<hr>
								<h4 class="wxsettled-feature-line">微信给不同类型公众号提供不同的接口，微店能提供的功能也不相同：</h4>
								<table class="table table-bordered wxsettled-feature-list">
									<thead>
										<tr>
											<th></th>
											<th>未认证订阅号</th>
											<th>认证订阅号</th>
											<th>未认证服务号</th>
											<th>认证服务号</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>消息自动回复</td>
											<td class="tick"></td>
											<td class="tick"></td>
											<td class="tick"></td>
											<td class="tick"></td>
										</tr>
										<tr>
											<td>微信自定义菜单</td>
											<td></td>
											<td class="tick"></td>
											<td class="tick"></td>
											<td class="tick"></td>
										</tr>
										<tr>
											<td>群发</td>
											<td></td>
											<td class="tick"></td>
											<td></td>
											<td class="tick"></td>
										</tr>
										<!-- <tr>
											<td>高级客户管理</td>
											<td></td>
											<td>部分功能</td>
											<td></td>
											<td class="tick"></td>
										</tr> -->
										<tr>
											<td>可申请微信支付</td>
											<td></td>
											<td></td>
											<td></td>
											<td class="tick"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="notify-bar js-notify animated hinge hide"></div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<script type="text/javascript">
			$(document).ready(function(){
// 				$.get('user.php?c=weixin&a=get_url',function(response){
// 					if (response.err_code) {
// 						layer_tips(1, response.err_msg);
// 					} else {
// 						$('.js-wxauth-btn').attr('data-url', response.err_msg);
// 					}
// 				},'json');

				$('.js-wxauth-btn').click(function(){
					var url = $(this).attr('data-url');
// 					if(url == ''){
// 						layer_tips(1,'授权网址获取失败，请联系管理员！');
// 						return false;
// 					}
// 					window.open(url); 
					var html = '';
					html += '<div class="modal fade in" style="width: 400px; margin-left: -200px; margin-top: 0px;" aria-hidden="false"><div class="modal-header">';
					html += '<a class="close" data-dismiss="modal">×</a>提示</div>';
					html += '<div class="modal-body">';
					html += '<p>请在新窗口中完成微信公众号授权&nbsp;&nbsp;<a href="" target="_blank"></a></p>';
					html += '</div>';
					html += '<div class="modal-footer">';
					html += '<div style="text-align: center;">';
					html += '<button type="button" class="btn btn-success js-refresh">已成功设置</button>';
					html += '<a class="btn btn-default js-retry" href="'+url+'" target="_blank" data-loading-text="地址读取中..">授权失败，重试</a>';
					html += '</div>';
					html += '</div></div><div class="modal-backdrop fade in"></div>';
					$('body').append(html);
				});
				$('.close').live('click', function(){
					$(this).parents('.modal').remove();
					$('.modal-backdrop').remove();
				});
				$('.js-refresh').live('click', function(){
					location.reload();
				});
			});
		</script>
	</body>
</html>