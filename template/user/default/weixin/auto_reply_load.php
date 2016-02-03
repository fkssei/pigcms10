<nav class="ui-nav">
	<ul>
		<li>
			<a href="/user.php?c=weixin&a=auto">关键词自动回复</a>
		</li>
		<li class="active">
			<a href="/user.php?c=weixin&a=auto_reply">关注后自动回复</a>
		</li>
		<!--li>
			<a href="">消息托管</a>
		</li-->
		<li>
			<a href="/user.php?c=weixin&a=tail">小尾巴</a>
		</li>
	</ul>
</nav>
<div class="ui-box" style="position: relative;">
	<!--a href="javascript:;" class="js-nav-add-rule btn btn-success"  data-id="0">新建自动回复</a>
	<div class="js-list-search form--search">
		<input class="txt" type="text" placeholder="搜索">
	</div-->
</div>
<div class="app-init">
	<div class="app__content">
		<div class="weixin-normal">
			<div id="js-rule-container" class="rule-group-container">
			
			<!-- list rule -->
				<div class="rule-group" data-id="<?php echo $list['pigcms_id'];?>">
					<div class="rule-meta">
						<h3>
							<em class="rule-id">规则：</em>
							<span class="rule-name" id="rule-name-<?php echo $list['pigcms_id'];?>"><?php echo $list['name']; ?></span>
							
						</h3>
					</div>
					<div class="rule-body">
						<div class="long-dashed"></div>
						<div class="rule-keywords">
							<div class="rule-inner">
								<h4>关键词：</h4>
								<div class="keyword-container">
									<?php if ($list['keylist']) {?>
									<div class="info"></div>
									<div class="keyword-list">
										<!-- list keyword -->
										<?php foreach ($list['keylist'] as $key) {?>
										<div class="keyword input-append" data-id="<?php echo $key['pigcms_id'];?>">
											<a href="javascript:;" class="close--circle" data-id="<?php echo $key['pigcms_id'];?>">×</a>
											<span class="value" id="keyword-value-<?php echo $key['pigcms_id'];?>" data-content="<?php echo $key['content'];?>"><?php echo $key['show_content'];?></span>
											<span class="add-on">全匹配</span>
										</div>
										<?php }?>
										<!-- list keyword -->
									</div>
									<?php } else {?>
									<div class="info">还没有任何关键字!</div>
									<div class="keyword-list"></div>
									<?php }?>
								</div>
								<hr class="dashed">
								<div class="opt">
									<a href="javascript:;" class="js-add-keyword" data-id="0">+ 添加关键词</a>
								</div>
							</div>
						</div>
						<div class="rule-replies">
							<div class="rule-inner">
								<h4>自动回复：
									<span class="send-method">随机发送</span>
								</h4>
								<div class="reply-container">
									<?php if ($list['vallist']) {?>
									<div class="info"></div>
									<ol class="reply-list">
										<?php foreach ($list['vallist'] as $v) {?>
										<li data-id="<?php echo $v['pigcms_id'];?>" id="reply-li-<?php echo $v['pigcms_id'];?>">
											<div class="reply-cont">
												<?php if ($v['reply_type'] == 0) {?>
												<div class="reply-summary" data-content="<?php echo $v['content'];?>" data-url="<?php echo $v['info_url'];?>">
													<span class="label label-success">文本</span>
													<?php echo $v['show_content'];?>
												</div>
												<?php } elseif ($v['reply_type'] == 1) {?>
												<div class="reply-summary" data-content="<?php echo $v['title'];?>" data-url="<?php echo $v['info_url'];?>">
													<span class="label label-success">图文</span>
													<a href="<?php echo $v['info_url'];?>" target="_blank"><?php echo $v['title'];?></a>
												</div>
												<?php } elseif ($v['reply_type'] == 3) {?>
												<div class="reply-summary" data-content="<?php echo $v['title'];?>" data-url="<?php echo $v['info_url'];?>">
													<span class="label label-success">商品</span>
													<a href="<?php echo $v['info_url'];?>" target="_blank"><?php echo $v['title'];?></a>
												</div>
												<?php } elseif ($v['reply_type'] == 4) {?>
												<div class="reply-summary" data-content="<?php echo $v['title'];?>" data-url="<?php echo $v['info_url'];?>">
													<span class="label label-success">商品分类</span>
													<a href="<?php echo $v['info_url'];?>" target="_blank"><?php echo $v['title'];?></a>
												</div>
												<?php } elseif ($v['reply_type'] == 5) {?>
												<div class="reply-summary" data-content="<?php echo $v['title'];?>" data-url="<?php echo $v['info_url'];?>">
													<span class="label label-success">微页面</span>
													<a href="<?php echo $v['info_url'];?>" target="_blank"><?php echo $v['title'];?></a>
												</div>
												<?php } elseif ($v['reply_type'] == 6) {?>
												<div class="reply-summary" data-content="<?php echo $v['title'];?>" data-url="<?php echo $v['info_url'];?>">
													<span class="label label-success">微页面分类</span>
													<a href="<?php echo $v['info_url'];?>" target="_blank"><?php echo $v['title'];?></a>
												</div>
												<?php } elseif ($v['reply_type'] == 7) {?>
												<div class="reply-summary" data-content="<?php echo $v['title'];?>" data-url="<?php echo $v['info_url'];?>">
													<span class="label label-success">店铺主页</span>
													<a href="<?php echo $v['info_url'];?>" target="_blank"><?php echo $v['title'];?></a>
												</div>
												<?php } elseif ($v['reply_type'] == 8) {?>
												<div class="reply-summary" data-content="<?php echo $v['title'];?>" data-url="<?php echo $v['info_url'];?>">
													<span class="label label-success">会员主页</span>
													<a href="<?php echo $v['info_url'];?>" target="_blank"><?php echo $v['title'];?></a>
												</div>
												<?php }?>
											</div>
											<div class="reply-opts">
												<a class="js-edit-it" href="javascript:;" data-id="<?php echo $v['reply_id'];?>" data-cid="<?php echo $v['cid'];?>" data-type="<?php echo $v['reply_type'];?>">编辑</a> - <a class="js-delete-it" href="javascript:;" data-id="<?php echo $v['reply_id'];?>">删除</a>
											</div>
										</li>
										<?php }?>
									</ol>
									<?php } else {?>
									<div class="info">还没有任何回复！</div>
									<ol class="reply-list"></ol>
									<?php }?>
								</div>
								<hr class="dashed">
								<div class="opt">
									<a class="js-add-reply add-reply-menu" href="javascript:;" data-id="0" data-type="0">+ 添加一条回复</a>
									<span class="disable-opt hide">最多十条回复</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- list rule -->
			</div>
		</div>
	</div>
</div>