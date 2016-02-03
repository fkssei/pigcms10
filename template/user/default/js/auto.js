var faces = [[01, "/::)", "[微笑]"],[02, "/::~", "[撇嘴]"],[03, "/::B", "[色]"],[04, "/::|", "[发呆]"],[05, "/:8-)", "[得意]"],[06, "/::<", "[流泪]"],[07, "/::$", "[害羞]"],[08, "/::X", "[闭嘴]"],[09, "/::Z", "[睡]"],[10, "/::'(", "[大哭]"],[11, "/::-|", "[尴尬]"],[12, "/::@", "[发怒]"],[13, "/::P", "[调皮]"],[14, "/::D", "[呲牙]"],[15, "/::O", "[惊讶]"],[16, "/::(", "[难过]"],[17, "/::+", "[酷]"],[18, "/:--b", "[冷汗]"],[19, "/::Q", "[抓狂]"],[20, "/::T", "[吐]"],[21, "/:,@P", "[偷笑]"],[22, "/:,@-D", "[愉快]"],[23, "/::d", "[白眼]"],[24, "/:,@o", "[傲慢]"],[25, "/::g", "[饥饿]"],[26, "/:|-)", "[困]"],[27, "/::!", "[惊恐]"],[28, "/::L", "[流汗]"],[29, "/::>", "[憨笑]"],[30, "/::,@", "[悠闲]"],[31, "/:,@f", "[奋斗]"],[32, "/::-S", "[咒骂]"],[33, "/:?", "[疑问]"],[34, "/:,@x", "[嘘]"],[35, "/:,@@", "[晕]"],[36, "/::8", "[疯了]"],[37, "/:,@!", "[衰]"],[38, "/:!!!", "[骷髅]"],[39, "/:xx", "[敲打]"],[40, "/:bye", "[再见]"],[41, "/:wipe", "[擦汗]"],[42, "/:dig", "[抠鼻]"],[43, "/:handclap", "[鼓掌]"],[44, "/:&amp;-(", "[糗大了]"],[45, "/:B-)", "[坏笑]"],[46, "/:<@", "[左哼哼]"],[47, "/:@>", "[右哼哼]"],[48, "/::-O", "[哈欠]"],[49, "/:>-|", "[鄙视]"],[50, "/:P-(", "[委屈]"],[51, "/::'|", "[快哭了]"],[52, "/:X-)", "[阴险]"],[53, "/::*", "[亲亲]"],[54, "/:@x", "[吓]"],[55, "/:8*", "[可怜]"],[56, "/:pd", "[菜刀]"],[57, "/:<W>", "[西瓜]"],[58, "/:beer", "[啤酒]"],[59, "/:basketb", "[篮球]"],[60, "/:oo", "[乒乓]"],[61, "/:coffee", "[咖啡]"],[62, "/:eat", "[饭]"],[63, "/:pig", "[猪头]"],[64, "/:rose", "[玫瑰]"],[65, "/:fade", "[凋谢]"],[66, "/:showlove", "[嘴唇]"],[67, "/:heart", "[爱心]"],[68, "/:break", "[心碎]"],[69, "/:cake", "[蛋糕]"],[70, "/:li", "[闪电]"],[71, "/:bome", "[炸弹]"],[72, "/:kn", "[刀]"],[73, "/:footb", "[足球]"],[74, "/:ladybug", "[瓢虫]"],[75, "/:shit", "[便便]"],[76, "/:moon", "[月亮]"],[77, "/:sun", "[太阳]"],[78, "/:gift", "[礼物]"],[79, "/:hug", "[拥抱]"],[80, "/:strong", "[强]"],[81, "/:weak", "[弱]"],[82, "/:share", "[握手]"],[83, "/:v", "[胜利]"],[84, "/:@)", "[抱拳]"],[85, "/:jj", "[勾引]"],[86, "/:@@", "[拳头]"],[87, "/:bad", "[差劲]"],[88, "/:lvu", "[爱你]"],[89, "/:no", "[NO]"],[90, "/:ok", "[OK]"],[91, "/:love", "[爱情]"],[92, "/:<L>", "[飞吻]"],[93, "/:jump", "[跳跳]"],[94, "/:shake", "[发抖]"],[95, "/:<O>", "[怄火]"],[96, "/:circle", "[转圈]"],[97, "/:kotow", "[磕头]"],[98, "/:turn", "[回头]"],[99, "/:skip", "[跳绳]"],[100, "/:oY", "[投降]"],[101, "/:#-0", "[激动]"],[102, "/:hiphot", "[乱舞]"],[103, "/:kiss", "[献吻]"],[104, "/:<&amp;", "[左太极]"],[105, "/:&amp;>", "[右太极]"]];
$(function(){
	
	load_page('.app__content', load_url, {page:'index_content'}, '');
	

	//添加规则
	$('.js-nav-add-rule, .js-edit-rule').live('click', function(event){
		var pigcms_id = parseInt($(this).attr('data-id'));
		var name = '';
		if (pigcms_id > 0) {
			name = $('#rule-name-' + pigcms_id).html();
		}
		$('.popover').remove();
		var top = $(this).offset().top + $(this).height() + 5;
		var left = $(this).offset().left - $(this).width();
		var html = '<div class="popover bottom">' + 
			'<div class="arrow"></div>' + 
			'<div class="popover-inner popover-thin">' + 
				'<div class="popover-content">' + 
					'<div class="controls">' + 
						'<input class="js-txt" type="text" maxlength="15" placeholder="未命名规则" value="' + name + '">' + 
						'<input type="hidden" id="pigcms_id" value="' + pigcms_id + '">' + 
					'</div>' + 
					'<button class="js-btn-confirm btn btn-primary btn-save-rule">确定</button>　' + 
					'<button class="js-btn-cancel btn">取消</button>' + 
				'</div>' + 
			'</div>' + 
		'</div>';
		$('body').append(html);
		$('.popover').css({'display':'block', 'top':top+'px', 'left':left+'px'});
	});
	//保存规则
	$('.btn-save-rule').live('click', function(){
		var name = $('.js-txt').val(), obj = $(this), pigcms_id = $('#pigcms_id').val();
		$.post('/user.php?c=weixin&a=save_rule', {'name':name, 'pigcms_id':pigcms_id}, function(response){
			obj.parents('.popover').remove();
			golbal_tips(response.err_msg, response.err_code);
			if (response.err_code) {
				
			} else {
				if (pigcms_id == 0) {
					var len = $(".rule-group-container").find(".rule-group").length + 1;
					var rule_html = '<div class="rule-group" data-id="' + response.ruleid + '"><div class="rule-meta"><h3><em class="rule-id">' + response.ruleid + ')</em> <span class="rule-name" id="rule-name-' + response.ruleid + '">hgf</span><div class="rule-opts"><a href="javascript:;" class="js-edit-rule" data-id="' + response.ruleid + '">编辑</a><span>-</span><a href="javascript:;" class="js-delete-rule" data-id="' + response.ruleid + '">删除</a></div></h3></div><div class="rule-body"><div class="long-dashed"></div><div class="rule-keywords"><div class="rule-inner"><h4>关键词：</h4><div class="keyword-container"><div class="info"></div><div class="keyword-list" id="keyword-list-' + response.ruleid + '><div class="keyword input-append"><a href="javascript:;" class="close--circle">×</a><span class="value">hgf</span><span class="add-on">全匹配</span></div></div></div><hr class="dashed"/><div class="opt"><a href="javascript:;" class="js-add-keyword">+ 添加关键词</a></div></div><div class="rule-replies"><div class="rule-inner"><h4>自动回复：<span class="send-method">随机发送</span></h4><div class="reply-container"><div class="info">还没有任何回复！</div><ol class="reply-list"></ol></div><hr class="dashed"/><div class="opt"><a class="js-add-reply add-reply-menu" href="javascript:;">+ 添加一条回复</a><span class="disable-opt hide">最多十条回复</span></div></div></div></div></div>';
					$('.rule-group-container').prepend(rule_html);
					$('.no-result').remove();
				} else {
					$('#rule-name-' + pigcms_id).html(name);
				}
			}
		}, 'json');
	});
	//删除规则
	$('.js-delete-rule').live('click', function(){
		var rid = parseInt($(this).attr('data-id')), obj = $(this);
		$.get('/user.php?c=weixin&a=delete_rule', {'rid':rid}, function(response){
			golbal_tips(response.err_msg, response.err_code);
			if (response.err_code) {
			} else {
				obj.parents('.rule-group').remove();
			}
		}, 'json');
		
	});
	//增加关键词
	$('.js-add-keyword, .input-append').live('click', function(e){
		if ($(e.target).attr('class') == 'close--circle') return false;
		var kid = parseInt($(this).attr('data-id')), rid = parseInt($(this).parents('.rule-group').attr('data-id'));
		var content = '';
		if($(this).find('.value').html() != undefined) {
			content = $(this).find('.value').attr('data-content');
		}
		$('.popover').remove();
		var top = $(this).offset().top + $(this).height() + 5;
		var left = $(this).offset().left - $(this).width();
		
		var keyhtml = '<div class="popover bottom">';
		keyhtml += '<div class="arrow"></div>';
		keyhtml += '<div class="popover-inner popover-keyword">';
		keyhtml += '<div class="popover-content">';
		keyhtml += '<div class="form-horizontal">';
		keyhtml += '<div class="control-group">';
		keyhtml += '<label class="control-label" style="width: 80px;"><em class="required">*</em>关键词：</label>';
		keyhtml += '<div class="controls">';
		keyhtml += '<input placeholder="关键词最多支持15个字" class="js-txt" type="text" maxlength="15" value="' + content + '" id="content-keyword">';
		keyhtml += '<input type="hidden" value="' + kid + '" id="kid">';
		keyhtml += '<input type="hidden" value="' + rid + '" id="rid">';
		keyhtml += '<span class="help-block err-message" style="font-size: 12px; color: red"></span>';
		keyhtml += '<span class="js-emotion input-emotion-btn"></span>';
//		keyhtml += '<div class="emotion-wrapper">';
//		keyhtml += '<ul class="emotion-container clearfix">';
//		keyhtml += '<li><img src="./auto_files/01.gif" alt="/::)" title="/::)"></li>';
//		keyhtml += '</ul>';
//		keyhtml += '</div>';
		keyhtml += '</div>';
		keyhtml += '</div>';
//		keyhtml += '<div class="control-group">';
//		keyhtml += '<label class="control-label"><em class="required">*</em>规则：</label>';
//		keyhtml += '<div class="controls">';
//		keyhtml += '<div class="keyword-type-group ">';
//		keyhtml += '<label class="radio inline">';
//		keyhtml += '<input name="keyword_type" type="radio" checked="" value="1"> 全匹配';
//		keyhtml += '</label>';
//		keyhtml += '<label class="radio inline">';
//		keyhtml += '<input name="keyword_type" type="radio" value="2"> 模糊';
//		keyhtml += '</label>';
//		keyhtml += '</div>';
//		keyhtml += '</div>';
//		keyhtml += '</div>';
		keyhtml += '<div class="form-actions">';
		keyhtml += '<button class="js-btn-confirm btn btn-primary btn-save-keyword">确定</button>';
		keyhtml += '<button class="js-btn-cancel btn">取消</button>';
		keyhtml += '</div>';
		keyhtml += '</div>';
		keyhtml += '</div>';
		keyhtml += '</div>';
		keyhtml += '</div>';
		
		$('body').append(keyhtml);
		$('.popover').css({'display':'block', 'top':top+'px', 'left':left+'px'});
		
	});
	//保存关键词
	$('.btn-save-keyword').live('click', function(){
		var content = $('#content-keyword').val(), rid = $('#rid').val(), kid = $('#kid').val(), obj = $(this);
		$.post('/user.php?c=weixin&a=save_keyword', {'content':content, 'rid':rid, 'kid':kid}, function(response){
			obj.parents('.popover').remove();
			golbal_tips(response.err_msg, response.err_code);
			if (response.err_code == 0) {
				if (kid == 0) {
					var khtml = '<div class="keyword input-append" data-id="' + response.kid + '">';
					khtml += '<a href="javascript:;" class="close--circle" data-id="' + response.kid + '">×</a>';
					khtml += '<span class="value" id="keyword-value-' + response.kid + '" data-content="' + content + '">' + response.keyword + '</span>';
					khtml += '<span class="add-on">全匹配</span>';
					khtml += '</div>';
					$('#keyword-list-' + rid).append(khtml);
					
				} else {
					$('#keyword-value-' + kid).html(response.keyword);
				}
				$('#keyword-list-' + rid).parents('.keyword-container').find('.info').html('');
			}
		}, 'json');
	});
	//删除关键词
	$('.close--circle').live('click', function(){
		var kid = parseInt($(this).attr('data-id')), obj = $(this);
		if (obj.attr('class') == 'close--circle js-close') {
			obj.parent('.popover').remove();
			return false;
		}
		if (obj.attr('class') == 'close--circle js-delete-complex') {
			$('.js-complex-content').html('');
			$('.complex-backdrop').css('display', 'none');
			$('.modal-backdrop').css('display', 'none');
			$('#type').val(0);
			return false;
		}
		$.get('/user.php?c=weixin&a=delete_keyword', {'kid':kid}, function(response){
			golbal_tips(response.err_msg, response.err_code);
			if (response.err_code == 0) {
				if (obj.parents('.keyword-list').find('.input-append').length < 2) {
					obj.parents('.keyword-container').find('.info').html('还没有任何关键字!');
				}
				obj.parent('.input-append').remove();
			}
		}, 'json');
	});
	
	$('.js-list-search .txt').live('keydown', function(e){
		if (e.which == 13) {
			$('.app__content').load(load_url, {'keyword': $(this).val()}, function(){});
//			location.href = '/user.php?c=weixin&a=auto&keyword=' + $(this).val();
		}
	});
	//删除回复
	$('.js-delete-it').live('click', function(){
		var rid = parseInt($(this).parents('.rule-group').attr('data-id')), replyid = parseInt($(this).attr('data-id')), obj = $(this);
		if (obj.attr('class') == 'close--circle js-close') {
			obj.parent('.popover').remove();
			return false;
		}
		$.get('/user.php?c=weixin&a=delete_reply', {'rid':rid, 'replyid':replyid}, function(response){
			golbal_tips(response.err_msg, response.err_code);
			if (response.err_code == 0) {
				if (obj.parents('.reply-list').find('li').length < 2) {
					obj.parents('.reply-container').find('.info').html('还没有任何回复！');
				}
				$('#reply-li-' + replyid).remove();
			}
		}, 'json');
	});
	//增加回复
	$('.js-add-reply, .js-edit-it').live('click', function(){
		var rid = parseInt($(this).parents('.rule-group').attr('data-id')), replyid = parseInt($(this).attr('data-id')), sid = parseInt($(this).attr('data-cid'));
		var type = parseInt($(this).attr('data-type'));
		var content = '', note = '', url = '';
		if ($(this).attr('class') == 'js-edit-it') {
			content = $(this).parent('.reply-opts').prev('.reply-cont').children('.reply-summary').attr('data-content');
			url = $(this).parent('.reply-opts').prev('.reply-cont').children('.reply-summary').attr('data-url');
			note = $(this).parent('.reply-opts').prev('.reply-cont').children('.reply-summary').children('.label-success').text();
		}
		$('.popover').remove();
		var html = '<div class="popover">';
			html += '<div class="arrow"></div>';
			html += '<a href="javascript:;" class="close--circle js-close">×</a>';
			html += '<div class="popover-inner popover-reply">';
			html += '<div class="popover-content">';
			html += '<div class="form-horizontal">';
			html += '<div class="wb-sender">';
			html += '<div class="wb-sender__inner">';
			html += '<div class="wb-sender__input">';
			html += '<div class="misc top clearfix">';
			html += '<div class="content-actions clearfix">';
			html += '<div class="editor-module insert-emotion">';
			html += '<a class="js-open-wx_emotion" data-action-type="emotion" href="javascript:;">表情</a>';
			html += '<div class="emotion-wrapper">';
			html += '<ul class="emotion-container clearfix"></ul>';
			html += '</div>';
			html += '</div>';
			html += '<div class="editor-module insert-hyperlink">';
			html += '<a class="js-open-hyperlink" data-action-type="hyperlink" href="javascript:;">插入链接</a>';
			html += '<div class="hyperlink-wrapper" style="top: -50px; left: -129px;">';
			html += '<input class="js-txt input-large txt" type="text" placeholder="http://" id="link-url">';
			html += '<button class="js-btn-hyperlink btn btn-primary">确定</button>';
			html += '</div>';
			html += '</div>';
//			html += '<div class="editor-module insert-music">';
//			html += '<a class="js-open-music" data-action-type="music" href="javascript:;">音乐</a>';
//			html += '<div class="music-wrapper"></div>';
//			html += '</div>';
			html += '<div class="editor-module insert-articles">';
			html += '<a class="js-open-articles" data-action-type="articles" href="javascript:;">选择图文</a>';
			html += '<div class="articles-wrapper"></div>';
			html += '</div>';
			html += '<div class="editor-module">';
			html += '<div class="js-reply-menu dropdown hover add-reply-menu">';
			html += '<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">';
			html += '<span class="dropdown-current">其它</span>';
			html += '<i class="caret"></i>';
			html += '</a>';
			html += '<ul class="dropdown-menu">';
			html += '<li><a class="js-open-goods" data-type="goods" data-complex-mode="true" href="javascript:;">商品及分类</a></li>';
			html += '<li><a class="js-open-feature" data-type="feature" data-complex-mode="true" href="javascript:;">微页面及分类</a></li>';
			html += '<li><a class="js-open-homepage" data-type="homepage" data-alias="店铺主页" data-title="" data-url="'+home_url+'" data-complex-mode="true" href="javascript:;">店铺主页</a></li>';
			html += '<li><a class="js-open-usercenter" data-type="usercenter" data-alias="会员主页" data-title="" data-url="'+member_url+'" data-complex-mode="true" href="javascript:;">会员主页</a></li>';
			html += '</ul>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '<div class="content-wrapper">';
			html += '<textarea class="js-txta" cols="50" rows="4" id="reply-content">' + content + '</textarea>';
			html += '<div class="js-picture-container picture-container"></div>';
			
			html += '<div class="complex-backdrop" style="display: none;">';
			html += '<div class="js-complex-content complex-content">';
			
//			html += '<div class="ng ng-multiple-mini">';
//			html += '<a href="javascript:;" class="close--circle js-delete-complex">×</a>';
//			html += '<div class="ng-item">';
//			html += '<span class="label label-success">多条图文</span>';
//			html += '<div class="ng-title">';
//			html += '<a href="" target="_blank" class="new-window" title="微信">微信</a>';
//			html += '</div>';
//			html += '</div>';
//			html += '<div class="ng-item"></div>';
//			html += '</div>';
			
			html += '</div>';
			html += '</div>';
		
//			html += '<div class="complex-backdrop" style="display: none;"><div class="js-complex-content complex-content"></div></div>';
			
			html += '</div>';
			html += '<div class="misc clearfix">';
			html += '<div class="content-actions clearfix">';
//			html += '<div class="word-counter pull-right">还能输入 <i>300</i> 个字</div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '<div class="wb-sender__actions in-editor">';
			html += '<button class="js-btn-confirm btn btn-primary js-save-reply">确定</button>';
			
			html += '<input type="hidden" id="rid" value="' + rid + '" />';
			html += '<input type="hidden" id="sid" value="' + sid + '" />';
			html += '<input type="hidden" id="replyid" value="' + replyid + '" />';
			html += '<input type="hidden" id="type" value="' + type + '" />';
//			html += '<input type="hidden" id="content" value="" />';

			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			$('body').append(html);
			if (type >= 1) {
				$('#type').val(type);
				$('#sid').val(sid);
				var html = '';
				html += '<div class="ng ng-multiple-mini">';
				html += '<a href="javascript:;" class="close--circle js-delete-complex">×</a>';
				html += '<div class="ng-item">';
				html += '<span class="label label-success">' + note + '</span>';
				html += '<div class="ng-title">';
				html += '<a href="'+url+'" target="_blank" class="new-window" >' + content + '</a>';
				html += '</div>';
				html += '</div>';
				html += '<div class="ng-item"></div>';
				html += '</div>';
				$('.js-complex-content').html(html);
				$('.complex-backdrop').css('display', 'block');
				$('#reply-content').val('');
			}
			
			var top = $(this).offset().top - $('.popover').height()/2;
			
			if ($(this).attr('class') == 'js-edit-it') {
				var left = $(this).offset().left - $('.popover').width();
				$('.popover').removeClass('right').addClass('left');
			} else {
				var left = $(this).offset().left + $(this).width();
				$('.popover').removeClass('left').addClass('right');
			}
			
			$('.popover').css({'display':'block', 'top':top+'px', 'left':left+'px'});
	});
	//保存回复
	$('.js-save-reply').live('click', function(){
		var content = $('#reply-content').val(), rid = $('#rid').val(), replyid = $('#replyid').val(), obj = $(this), sid = $('#sid').val();
		var type = $('#type').val();
		
		$.post('/user.php?c=weixin&a=save_reply', {'content':content, 'rid':rid, 'replyid':replyid, 'type':type, 'sid':sid}, function(response){
			obj.parents('.popover').remove();
			golbal_tips(response.err_msg, response.err_code);
			if (response.err_code == 0) {
				if (replyid == 0) {
					var khtml = '<li data-id="' + response.replyid + '" id="reply-li-' + response.replyid + '">';
					khtml += '<div class="reply-cont">';
					if (type == 0) {
						khtml += '<div class="reply-summary" data-content="' + content + '" data-url="' + response.info_url + '">';
						khtml += '<span class="label label-success">文本</span> <a href="' + response.info_url + '" target="_blank">' + response.content + '</a>';
					} else {
						khtml += '<div class="reply-summary" data-content="' + response.content + '" data-url="' + response.info_url + '">';
						khtml += '<span class="label label-success"> ' + response.note + '</span> <a href="' + response.info_url + '" target="_blank">' + response.content + '</a>';
					}
					khtml += '</div>';
					khtml += '</div>';
					khtml += '<div class="reply-opts">';
					khtml += '<a class="js-edit-it" href="javascript:;" data-id="' + response.replyid + '"  data-cid="' + response.cid + '"  data-type="' + type + '">编辑</a> - <a class="js-delete-it" href="javascript:;" data-id="' + response.replyid + '">删除</a>';
					khtml += '</div>';
					khtml += '</li>';
					$('.reply-list').append(khtml);
					$('.reply-container').find('.info').html('')
				} else {
					var khtml = '';
					khtml += '<div class="reply-cont">';
					if (type == 0) {
						khtml += '<div class="reply-summary" data-content="' + content + '">';
						khtml += '<span class="label label-success">文本</span> ' + response.content;
					} else {
						khtml += '<div class="reply-summary" data-content="' + response.content + '" data-url="' + response.info_url + '">';
						khtml += '<span class="label label-success"> ' + response.note + '</span> <a href="' + response.info_url + '" target="_blank">' + response.content + '</a>';
					}
					khtml += '</div>';
					khtml += '</div>';
					khtml += '<div class="reply-opts">';
					khtml += '<a class="js-edit-it" href="javascript:;" data-id="' + response.replyid + '"  data-cid="' + response.cid + '"  data-type="' + type + '">编辑</a> - <a class="js-delete-it" href="javascript:;" data-id="' + response.replyid + '">删除</a>';
					khtml += '</div>';
					
//					if (type == 0) {
//						khtml += '<div class="reply-summary" data-content="' + content + '">';
//						khtml += '<span class="label label-success">文本</span> ' + response.content + '</div>';
//					} else {
//						khtml += '<div class="reply-summary" data-content="' + response.content + '">';
//						khtml += '<span class="label label-success"> ' + response.note + '</span> ' + response.content + '</div>';
//					}
					$('#reply-li-' + replyid).html(khtml);
//					$('#keyword-value-' + kid).html(content);
				}
			}
		}, 'json');
	});
	
	$('.js-btn-hyperlink').live('click', function(){
		var url = $('#link-url').val();
		if ($('#link-url').val().search(/http:\/\//) == -1) {
			url = 'http://' + $('#link-url').val();
		}
		if ($('#reply-content').val() != '') {
			$('#reply-content').val($('#reply-content').val() + ' ' + url);
		} else {
			$('#reply-content').val(url);
		}
		$('#link-url').val('');
		$('.hyperlink-wrapper').hide();
	});
	$('#reply-content').live('click', function(){
		$('.hyperlink-wrapper').hide();
	});
	$('.js-open-hyperlink').live('click', function(){
		$('.hyperlink-wrapper').show();
	});
	$('.js-btn-cancel').live('click', function(){
		$(this).parents('.popover').remove();
	});
	
	$('.js-open-wx_emotion, .input-emotion-btn').live('click', function(){
		var index = 2;
		if ($(this).attr('class') == 'js-emotion input-emotion-btn') {
			index = 1;
		}
		var face_html = '<div class="emotion-wrapper">';
		face_html += '<ul class="emotion-container clearfix">';
		for (fa in faces) {
			face_html += '<li><img src="/static/images/qq/' + faces[fa][0] + '.gif" alt="' + faces[fa][index] + '" title="' + faces[fa][index] + '"></li>';
		}
		face_html += '</ul>';
		face_html += '</div>';
		$('body').append(face_html);

		var top = $(this).offset().top - $('.emotion-wrapper').height()/2;
		var left = $(this).offset().left + $(this).width();
		$('.emotion-wrapper').css({'display':'block', 'top':top+'px', 'left':left+'px', 'z-index':7777});
	});
	
	$('.emotion-container>li>img').live('click', function(){
		if ($('#content-keyword').val() != undefined) {
			$('#content-keyword').val($('#content-keyword').val() + $(this).attr('title'));
		} else {
			$('#reply-content').val($('#reply-content').val() + ' ' + $(this).attr('title'));
		}
		$('.emotion-wrapper').hide();
	});
	$('.js-open-articles').live('click', function(){
		wentu_list(1);
	});
//	$('.fetch_page').live('click', function(){
//		wentu_list($(this).attr('data-page-num'));
//	});
	$('.js-news-modal-dismiss').live('click', function(){
		$(this).parents('.js-modal').remove();
		$('.modal-backdrop').remove();
	});
	
	
	//选择图文或商品等 TODO
	$('.js-choose').live('click', function(){
//		var data_type = $(this).attr('data-type');
		rich_text($(this).attr('data-alias'), $(this).attr('data-title'), $(this).attr('data-type'), parseInt($(this).attr('data-id')), $(this).attr('data-url'));
//		$('#sid').val(parseInt($(this).attr('data-id')));
//		var title = $(this).attr('data-title');
		$('.js-news-modal-dismiss').parents('.js-modal').remove();
	});
	
//	$('.js-choose').live('click', function(){
//		change_html($(this).attr('data-title'), $(this).attr('data-url'))
//		$('.js-news-modal-dismiss').parents('.js-modal').remove();
//		$('.modal-backdrop').css('display', 'none');
//	});
	

	//其他的选择
	$('.dropdown-menu a').live('click',function(){
		var type = $(this).attr('data-type');
		if ($(this).attr('data-type') == 'feature' || $(this).attr('data-type') == 'goods') {
			url_list(1, $(this).attr('data-type'));
		} else {
			rich_text($(this).attr('data-alias'), $(this).attr('data-title'), $(this).attr('data-type'), parseInt($(this).attr('data-id')), $(this).attr('data-url'));
		}
	});
	
	$('.js-modal-tab').live('click', function(){
		url_list(1, $(this).attr('data-type'));
	});
	$('.js-news-modal-dismiss').live('click', function(){
		$(this).parents('.js-modal').remove();
		$('.modal-backdrop').remove();
	});
	$('.fetch_page').live('click', function(){
		if ($(this).parents('.pagenavi').parent().attr('class') == 'rule-group-opts') {
			$('.app__content').load(load_url, {'p': parseInt($(this).attr('data-page-num'))}, function(){});
//			location.href = '/user.php?c=weixin&a=auto&p=' + parseInt($(this).attr('data-page-num'));
		} else if ($(this).parents('.pagenavi').parent().attr('class') == 'modal-footer wentu') {
			wentu_list($(this).attr('data-page-num'));
		} else {
			url_list($(this).attr('data-page-num'), $('.js-news-modal-dismiss').attr('data-type'));
		}
	});
});

function rich_text(alias, title, type, sid, url)
{
	//type [0:文本，1：图文，2：音乐，3：商品，4：商品分类，5：微页面，6：微页面分类，7：店铺主页，8：会员主页]
	$('#sid').val(sid);
	
	if (type == 'wentu') {
		$('#type').val(1);
	} else if (type == 'goods') {
		$('#type').val(3);
	} else if (type == 'tag') {
		$('#type').val(4);
	} else if (type == 'feature') {
		$('#type').val(5);
	} else if (type == 'category') {
		$('#type').val(6);
	} else if (type == 'homepage') {
		$('#type').val(7);
	} else if (type == 'usercenter') {
		$('#type').val(8);
	}
	
	
	var html = '';
	html += '<div class="ng ng-multiple-mini">';
	html += '<a href="javascript:;" class="close--circle js-delete-complex">×</a>';
	html += '<div class="ng-item">';
	html += '<span class="label label-success">' + alias + '</span>';
	if (title != '') {
		html += '<div class="ng-title">';
		html += '<a href="'+url+'" target="_blank" class="new-window" >' + title + '</a>';
		html += '</div>';
	}
	html += '</div>';
	if (type == 'homepage' || type == 'usercenter' || type == 'feature' || type == 'goods') {
		html += '<div class="ng-item view-more">';
		html += '<a href="'+url+'" target="_blank" class="clearfix new-window">';
		html += '<span class="pull-left">阅读全文</span>';
		html += '<span class="pull-right">&gt;</span>';
		html += '</a>';
		html += '</div>';
	} else {
		html += '<div class="ng-item"></div>';
	}
	html += '</div>';
	$('.js-complex-content').html(html);
	$('.complex-backdrop').css('display', 'block');
	$('.modal-backdrop').css('display', 'none');
	$('.js-news-modal-dismiss').parents('.js-modal').remove();
	
}
function wentu_list(p)
{
	$.post('/user.php?c=weixin&a=get_wentu', {'p':p}, function(response){
		$('.js-news-modal-dismiss').parents('.js-modal').remove();
		$('.modal-backdrop').remove();
		var html = '<div class="modal fade js-modal in" aria-hidden="false">';
			html += '<div class="modal-header">';
			html += '<a class="close js-news-modal-dismiss" data-dismiss="modal">×</a>';
			html += '<ul class="module-nav modal-tab">';
//			html += '<li class=""><a href="#js-module-news" data-type="news" class="js-modal-tab">高级图文</a> | </li>';
			html += '<li class="active"><a href="#js-module-mpNews" data-type="mpNews" class="js-modal-tab">微信图文</a> | </li>';
			html += '<li class="link-group link-group-1" style="display: inline-block;"><a href="/user.php?c=weixin&a=index" target="_blank" class="new_window">微信图文素材管理</a></li>';
			html += '</ul>';
			html += '</div>';
			html += '<div class="modal-body">';
			html += '<div class="tab-content">';
			
			html += '<div id="js-module-mpNews" class="tab-pane module-mpNews active">';
			html += '<table class="table">';
			html += '<colgroup>';
			html += '<col class="modal-col-title">';
			html += '<col class="modal-col-time" span="2">';
			html += '<col class="modal-col-action">';
			html += '</colgroup>';
			html += '<thead>';
			html += '<tr>';
			html += '<th class="title">';
			html += '<div class="td-cont">';
			html += '<span>标题</span> <a class="js-update" href="javascript:void(0);">刷新</a>';
			html += '</div>';
			html += '</th>';
			html += '<th class="time">';
			html += '<div class="td-cont">';
			html += '<span>创建时间</span>';
			html += '</div>';
			html += '</th>';
			html += '<th class="opts">';
//			html += '<div class="td-cont">';
//			html += '<form class="form-search">';
//			html += '<div class="input-append">';
//			html += '<input class="input-small js-modal-search-input" type="text"><a href="javascript:void(0);" class="btn js-fetch-page js-modal-search" data-action-type="search">搜</a>';
//			html += '</div>';
//			html += '</form>';
//			html += '</div>';
			html += '</th>';
			html += '</tr>';
			html += '</thead>';
			html += '<tbody>';
			for (var thisid in response.data) {
				html += '<tr>';
				html += '<td class="title">';
				html += '<div class="td-cont">';
				html += '<div class="ng ng-multiple">';
				var i = 0;
				var title = '', info_url = '';
				for (var imageid in response.data[thisid].list) {
					i ++;
					if (title == '') {
						title = response.data[thisid].list[imageid].title;
					}
					if (info_url == '') {
						info_url = response.data[thisid].list[imageid].info_url;
					}
					html += '<div class="ng-item">';
					if (response.data[thisid].list.length > 1) {
						html += '<span class="label label-success">图文' + i + '</span>';
					} else {
						html += '<span class="label label-success">图文</span>';
					}
					html += '<div class="ng-title">';
					html += '<a href="' + response.data[thisid].list[imageid].info_url + '" class="new_window" title="' + response.data[thisid].list[imageid].title + '">　' + response.data[thisid].list[imageid].title + '</a>';
					html += '</div>';
					html += '</div>';
				}

				html += '</div>';
				html += '</div>';
				html += '</td>';
				
				html += '<td class="time">';
				html += '<div class="td-cont">';
				html += '<span>'+response.data[thisid].dateline+'</span>';
				html += '</div>';
				html += '</td>';
				
				html += '<td class="opts">';
				html += '<div class="td-cont">';
				html += '<button class="btn js-choose" href="#" data-id="' + response.data[thisid].pigcms_id + '" data-url="'+info_url+'" data-type="wentu" data-title="' + title + '" data-alias="多条图文">选取</button>';
				html += '</div>';
				html += '</td>';
				
				html += '</tr>';
			}

			
			html += '</tbody>';
			html += '</table>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '<div class="modal-footer wentu">';
			html += '<div style="display: none;" class="js-confirm-choose pull-left">';
			html += '<input type="button" class="btn btn-primary" value="确定使用">';
			html += '</div>';
			html += '<div class="pagenavi">';
			html += '<span class="total">'+response.page+'</span>';
			html += '</div>';
			html += '</div>';
			html += '</div><div class="modal-backdrop fade in"></div>';
			$('body').append(html);
		}, 'json');
}
//商品（与分类），微页面（分类）
function url_list(p, type)
{
	//type [feature, category, goods, tag]
	$.post('/user.php?c=weixin&a=get_url_list', {'p':p, 'type':type}, function(response){
		$('.js-news-modal-dismiss').parents('.js-modal').remove();
		$('.modal-backdrop').remove();
		var html = '<div class="modal fade js-modal in" aria-hidden="false">';
			html += '<div class="modal-header">';
			html += '<a class="close js-news-modal-dismiss" data-dismiss="modal" data-type="' + type +'">×</a>';
			html += '<ul class="module-nav modal-tab">';
			if (type == 'feature' || type == 'category') {
				if (type == 'feature') {
					html += '<li class="active"><a href="#js-module-feature" data-type="feature" class="js-modal-tab">微页面</a> | </li>';
					html += '<li><a href="#js-module-category" data-type="category" class="js-modal-tab">微页面分类</a></li>';
				} else {
					html += '<li><a href="#js-module-feature" data-type="feature" class="js-modal-tab">微页面</a> | </li>';
					html += '<li class="active"><a href="#js-module-category" data-type="category" class="js-modal-tab">微页面分类</a></li>';
				}
			} else {
				if (type == 'goods') {
					html += '<li class="active"><a href="#js-module-goods" data-type="goods" class="js-modal-tab">已上架商品</a> | </li>';
					html += '<li><a href="#js-module-tag" data-type="tag" class="js-modal-tab">商品分组</a></li>';
				} else {
					html += '<li><a href="#js-module-goods" data-type="goods" class="js-modal-tab">已上架商品</a> | </li>';
					html += '<li class="active"><a href="#js-module-tag" data-type="tag" class="js-modal-tab">商品分组</a></li>';
				}
			}
			html += '</ul>';
			html += '</div>';
			html += '<div class="modal-body">';
			html += '<div class="tab-content">';
			
			html += '<div id="js-module-mpNews" class="tab-pane module-mpNews active">';
			html += '<table class="table">';
			html += '<colgroup>';
			html += '<col class="modal-col-title">';
			html += '<col class="modal-col-time" span="2">';
			html += '<col class="modal-col-action">';
			html += '</colgroup>';
			html += '<thead>';
			html += '<tr>';
			html += '<th class="title">';
			html += '<div class="td-cont">';
			html += '<span>标题</span> <a class="js-update" href="javascript:void(0);" onclick="url_list(' + p +', \'' + type +'\')">刷新</a>';
			html += '</div>';
			html += '</th>';
			html += '<th class="time">';
			html += '<div class="td-cont">';
			html += '<span>创建时间</span>';
			html += '</div>';
			html += '</th>';
			html += '<th class="opts">';
			html += '</th>';
			html += '</tr>';
			html += '</thead>';
			html += '<tbody>';
			for (var thisid in response.page_list) {
				html += '<tr>';
				html += '<td class="title">';
				html += '<div class="td-cont">';
				html += '<a target="_blank" class="new_window" href="'+response.page_list[thisid].url+'">'+response.page_list[thisid].page_name+'</a>';
				html += '</div>';
				html += '</td>';
				
				html += '<td class="time">';
				html += '<div class="td-cont">';
				html += '<span>'+response.page_list[thisid].add_time+'</span>';
				html += '</div>';
				html += '</td>';
				
				html += '<td class="opts">';
				html += '<div class="td-cont">';
				if (type == 'feature') {
					html += '<button class="btn js-choose" href="#" data-id="'+response.page_list[thisid].data_id+'" data-url="'+response.page_list[thisid].url+'" data-type="' + type + '" data-title="'+response.page_list[thisid].page_name+ '" data-alias="微页面">选取</button>';
				} else if (type == 'category') {
					html += '<button class="btn js-choose" href="#" data-id="'+response.page_list[thisid].data_id+'" data-url="'+response.page_list[thisid].url+'" data-type="' + type + '" data-title="'+response.page_list[thisid].page_name+ '" data-alias="微页面分类">选取</button>';
				} else if (type == 'goods') {
					html += '<button class="btn js-choose" href="#" data-id="'+response.page_list[thisid].data_id+'" data-url="'+response.page_list[thisid].url+'" data-type="' + type + '" data-title="'+response.page_list[thisid].page_name+ '" data-alias="商品">选取</button>';
				} else {
					html += '<button class="btn js-choose" href="#" data-id="'+response.page_list[thisid].data_id+'" data-url="'+response.page_list[thisid].url+'" data-type="' + type + '" data-title="'+response.page_list[thisid].page_name+ '" data-alias="商品分类">选取</button>';
				}
				
				html += '</div>';
				html += '</td>';
				html += '</tr>';
			}
			html += '</tbody>';
			html += '</table>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '<div class="modal-footer">';
			html += '<div style="display: none;" class="js-confirm-choose pull-left">';
			html += '<input type="button" class="btn btn-primary" value="确定使用">';
			html += '</div>';
			html += '<div class="pagenavi">';
			html += '<span class="total">'+response.page+'</span>';
			html += '</div>';
			html += '</div>';
			html += '</div><div class="modal-backdrop fade in"></div>';
			$('body').append(html);
		}, 'json');
}