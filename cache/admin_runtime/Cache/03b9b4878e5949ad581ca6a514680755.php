<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset={:C('DEFAULT_CHARSET')}" />
		<title>网站后台管理 Powered by pigcms.com</title>
		<script type="text/javascript">
			<!--if(self==top){window.top.location.href="<?php echo U('Index/index');?>";}-->
			var kind_editor=null,static_public="<?php echo ($static_public); ?>",static_path="<?php echo ($static_path); ?>",system_index="<?php echo U('Index/index');?>",choose_province="<?php echo U('Area/ajax_province');?>",choose_city="<?php echo U('Area/ajax_city');?>",choose_area="<?php echo U('Area/ajax_area');?>",choose_circle="<?php echo U('Area/ajax_circle');?>",choose_map="<?php echo U('Map/frame_map');?>",get_firstword="<?php echo U('Words/get_firstword');?>",frame_show=<?php if($_GET['frame_show']): ?>true<?php else: ?>false<?php endif; ?>;
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo C('JQUERY_FILE');?>"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/common.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/date.js"></script>
		</head>
		<body width="100%" 
		<?php if($bg_color): ?>style="background:<?php echo ($bg_color); ?>;"<?php endif; ?>
> 
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<?php if(is_array($group_list)): $i = 0; $__LIST__ = $group_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Config/index',array('gid'=>$vo['gid']));?>" <?php if($gid == $vo['gid']): ?>class="on"<?php endif; ?>><?php echo ($vo["gname"]); ?></a>|<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<form id="myform" method="post" action="<?php echo U('Config/amend');?>" refresh="true">
				<?php echo ($config_tab_html); ?>
				<?php echo ($config_html); ?>
				<div class="btn" style="margin-top:20px;">
					<input TYPE="submit"  name="dosubmit" value="提交" class="button" />
					<input type="reset"  value="取消" class="button" />
					<input type="button"  value="获取及时聊天的key" class="button" id="im_key"/>
					<input type="button"  value="微信API接口填写信息" class="button" onclick="window.top.artiframe('<?php echo U('Config/show',array('id'=>$vo['id']));?>','API接口信息',560,100,true,false,false,'','add',true);"/>
				</div>
			</form>
		</div>
        <script type="text/javascript">
            $(function() {
                $('.table_form:eq(0)').show();

                $('.tab_ul li a').click(function(){
                    $(this).closest('li').addClass('active').siblings('li').removeClass('active');
                    $($(this).attr('href')).show().siblings('.table_form').hide();
                });
		$('#im_key').click(function(){
			$.get("<?php echo U('Config/im');?>",function(data){
				alert(data.msg)					
			},'json');
		});
	    });	
	</script>
        <?php if($has_salt_btn): ?><script type="text/javascript">
			$(function(){
                $('.generate-salt').live('click', function() {
                    $.post("<?php echo U('Config/ajax_generate_salt');?>", "", function(data){
                        $('#config_weidian_key').val(data);
                    })
                })
			});
		</script><?php endif; ?>
		<?php if($has_image_btn): ?><script type="text/javascript" src="<?php echo ($static_public); ?>js/webuploader/webuploader.js"></script>
			<script>
				$(function(){
					var upload_image_btn = null;
					if(!WebUploader.Uploader.support()){
						alert( '您的浏览器不支持上传功能！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
						$('.widget-image,.modal-backdrop').remove();
					}				
					var uploader = WebUploader.create({
						auto: true,
						swf: '<?php echo ($static_public); ?>js/Uploader.swf',
						server: "<?php echo U('Config/ajax_upload_pic');?>",
						pick: {
							id: '.config_upload_image_btn',
							multiple:false
						},
						fileNumLimit: 1, 
						accept: {
							title: 'Images',
							extensions: 'gif,jpg,jpeg,png',
							mimeTypes: 'image/*'
						},
						fileSingleSizeLimit: 3 * 1024 * 1024,
						duplicate:true
					});
					uploader.on('uploadSuccess',function(file,response){
						if(response['result'].error_code == '0'){
							upload_image_btn.siblings('.input-image').val(response['result'].url);
							alert('上传成功');
						}else{
							alert(response['result'].err_msg);
						}
					});

					uploader.on('uploadError', function(file,reason){
						alert('上传失败！请重试。');
					});
					$('.config_upload_image_btn').click(function(){
						upload_image_btn = $(this);
					});
				});			
			</script><?php endif; ?>
		<?php if($has_page_btn): ?><script>
				var widget_link_save_box = {};
				$('.config_select_page_btn').click(function(){
					var randNum = getRandNumber();
					widget_link_save_box[randNum] = $(this).closest('td').find('.input-widget-page');
					window.top.artiframe('/user.php?c=systemwidget&a=page&rand='+randNum,'选择微页面',650,470,true,false,false,'','widget-page',true);
				});
				function widget_page_after(randNum,id,title,href){
					window.top.closeiframe();
					widget_link_save_box[randNum].val(id);
					
				}
				function getRandNumber(){
					var myDate=new Date();
					return myDate.getTime() + '' + Math.floor(Math.random()*10000);
				}
			</script><?php endif; ?>
		<link rel="stylesheet" href="<?php echo ($static_public); ?>kindeditor/themes/default/default.css">
		<script src="<?php echo ($static_public); ?>kindeditor/kindeditor.js"></script>
		<script src="<?php echo ($static_public); ?>kindeditor/lang/zh_CN.js"></script>
		<script type="text/javascript">
			KindEditor.ready(function(K){
				var site_url = "<?php echo ($config["site_url"]); ?>";
				var editor = K.editor({
					allowFileManager : true
				});
				$('.config_upload_image_btn').click(function(){
					var upload_file_btn = $(this);
					editor.uploadJson = "<?php echo U('Config/ajax_upload_pic');?>";
					editor.loadPlugin('image', function(){
						editor.plugin.imageDialog({
							showRemote : false,
							clickFn : function(url, title, width, height, border, align) {
								upload_file_btn.siblings('.input-image').val(site_url+url);
								editor.hideDialog();
							}
						});
					});
				});
				$('.config_upload_file_btn').click(function(){
					var upload_file_btn = $(this);
					editor.uploadJson = "<?php echo U('Config/ajax_upload_file');?>&name="+upload_file_btn.siblings('.input-file').attr('name');
					editor.loadPlugin('insertfile', function(){
						editor.plugin.fileDialog({
							showRemote : false,
							clickFn : function(url, title, width, height, border, align) {
								upload_file_btn.siblings('.input-file').val(url);
								editor.hideDialog();
							}
						});
					});
				});
			});
		</script>
		<style>
			.table_form{border:1px solid #ddd;}
			.tab_ul{margin-top:10px;border-color:#C5D0DC;margin-bottom:0!important;margin-left:0;position:relative;top:1px;border-bottom:1px solid #ddd;padding-left:0;list-style:none;}
			.tab_ul>li{position:relative;display:block;float:left;margin-bottom:-1px;}
			.tab_ul>li>a {
				position: relative;
				display: block;
				padding: 10px 15px;
				margin-right: 2px;
				line-height: 1.42857143;
				border: 1px solid transparent;
				border-radius: 4px 4px 0 0;
				padding: 7px 12px 8px;
				min-width: 100px;
				text-align: center;
				}
				.tab_ul>li>a, .tab_ul>li>a:focus {
				border-radius: 0!important;
				border-color: #c5d0dc;
				background-color: #F9F9F9;
				color: #999;
				margin-right: -1px;
				line-height: 18px;
				position: relative;
				}
				.tab_ul>li>a:focus, .tab_ul>li>a:hover {
				text-decoration: none;
				background-color: #eee;
				}
				.tab_ul>li>a:hover {
				border-color: #eee #eee #ddd;
				}
				.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {
				color: #555;
				background-color: #fff;
				border: 1px solid #ddd;
				border-bottom-color: transparent;
				cursor: default;
				}
				.tab_ul>li>a:hover {
				background-color: #FFF;
				color: #4c8fbd;
				border-color: #c5d0dc;
				}
				.tab_ul>li:first-child>a {
				margin-left: 0;
				}
				.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {
				color: #576373;
				border-color: #c5d0dc #c5d0dc transparent;
				border-top: 2px solid #4c8fbd;
				background-color: #FFF;
				z-index: 1;
				line-height: 18px;
				margin-top: -1px;
				box-shadow: 0 -2px 3px 0 rgba(0,0,0,.15);
				}
				.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {
				color: #555;
				background-color: #fff;
				border: 1px solid #ddd;
				border-bottom-color: transparent;
				cursor: default;
				}
				.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {
				color: #576373;
				border-color: #c5d0dc #c5d0dc transparent;
				border-top: 2px solid #4c8fbd;
				background-color: #FFF;
				z-index: 1;
				line-height: 18px;
				margin-top: -1px;
				box-shadow: 0 -2px 3px 0 rgba(0,0,0,.15);
				}
				.tab_ul:before,.tab_ul:after{
				content: " ";
				display: table;
				}
				.tab_ul:after{
				clear: both;
				}
			</style>
	</body>
</html>