<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>发表评论</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link href="<?php echo TPL_URL;?>css/comment_add.css" type="text/css" rel="stylesheet" />
<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script src="<?php echo $config['site_url'];?>/static/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/comment_add.js"></script>
<style>
.motify{display:none;position:fixed;top:35%;left:50%;width:220px;padding:0;margin:0 0 0 -110px;z-index:9999;background:rgba(0, 0, 0, 0.8);color:#fff;font-size:14px;line-height:1.5em;border-radius:6px;-webkit-box-shadow:0px 1px 2px rgba(0, 0, 0, 0.2);box-shadow:0px 1px 2px rgba(0, 0, 0, 0.2);@-webkit-animation-duration 0.15s;@-moz-animation-duration 0.15s;@-ms-animation-duration 0.15s;@-o-animation-duration 0.15s;@animation-duration 0.15s;@-webkit-animation-fill-mode both;@-moz-animation-fill-mode both;@-ms-animation-fill-mode both;@-o-animation-fill-mode both;@animation-fill-mode both;}
.motify .motify-inner{padding:10px 10px;text-align:center;word-wrap:break-word;}
.motify p{margin:0 0 5px;}.motify p:last-of-type{margin-bottom:0;}
</style>
<script>
</script>
</head>
<body>
<div class="shop_pingjia">  
	<div class="shop_pinjiga_title">发表评价</div>
		<div class="shop_pinjgia_form">
			<div class="shop_pingjia_form_list  appraise_li-list_top ">
				<div class="shop_pingjia_form_list_zong">总体评价:</div>
				<ul>
					<li class="red">
						<div class="appraise_li-list_top_icon manyi">
							<input type="radio" class="ui-checkbox" id="refund-reason00" value="5" name="manyi" />
							<label for="refund-reason00"><span>满意</span></label>
						</div>
					</li>
					<li class="yellow">
						<div class="appraise_li-list_top_icon yiban">
							<input type="radio" class="ui-checkbox" id="refund-reason001" value="3" name="manyi" />
							<label for="refund-reason001"><span>一般</span></label>
						</div>
					</li>
					<li class="gray">
						<div class="appraise_li-list_top_icon bumanyi">
							<input type="radio" class="ui-checkbox" id="refund-reason002" value="1" name="manyi" />
							<label for="refund-reason002"><span>不满意</span></label>
						</div>
					</li>
					<div style="clear:both"></div>
				</ul>
			</div>
			<?php 
			if ($type == 'PRODUCT') {
			?>
				<div class="shop_pingjia_form_list  appraise_li-list_top ">
					<div class="shop_pingjia_form_list_zong">标签:</div>
					<ul class="biaoqian">
						<?php 
						foreach ($tag_list as $key => $tag) {
						?>
						<li>
							<input type="checkbox" class="ui-checkbox js-tag" id="tag_<?php echo $key ?>" value="<?php echo $key ?>" />
							<label for="tag_<?php echo $key ?>"><?php echo htmlspecialchars($tag) ?></label>
						</li>
						<?php 
						}
						?>
					</ul>
				</div>
			<?php 
			}
			?>
			<div class="textarea">
				<textarea name="content" cols="" rows="" class="form_textarea"></textarea>
			</div>
			<div class="shop_pingjia_form_list  appraise_li-list_top " style="border:0;">
				<div class="shop_pingjia_form_list_zong">图片:</div>
				<!--图片上传-->
				<div class="shop_pingjia_list">
					<ul>
						<li id="shop_add">
							<form enctype="multipart/form-data" id="upload_image_form" target="iframe_upload_image" method="post" action="comment_attachment.php">
								<div class="updat_pic"> <a href="javascript:" id="upload_message"><img src="<?php echo TPL_URL;?>images/jiahao.png" /></a>
									<input type="file" class="ehdel_upload" id="upload_image" name="file" />
									<p style="z-index:-1">0/10</p>
								</div>
							</form>
						</li>
					</ul>
				</div>
				<iframe name="iframe_upload_image" style="width:0px; height:0px; display:none;"></iframe>
				<!--图片上传--> 
			</div>
		</div>
		<div class="button">
			<div class="button_txt">
				<span>文明上网</span>
				<span>礼貌发帖</span>
				<span></span>
				<span class="js-word-number">0/300</span>
				<input type="hidden" name="id" value="<?php echo $id ?>" />
				<input type="hidden" name="type" value="<?php echo $type ?>" />
			</div>
			<button class="form_button js_save">提交</button>
			<div style="clear:both"></div>
		</div>
</div>
</body>
</html>
