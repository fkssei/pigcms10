<script type="text/javascript">
    var comment_groups_json = '<?php echo $comment_groups_json; ?>';
</script>
<style type="text/css">
    .red {
        color: red;
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div>
            <h3 class="list-title js-goods-list-title">评价商品列表</h3>
            <div class="ui-block-head-help soldout-help js-soldout-help hide" style="display: block;">
                <a href="javascript:void(0);" class="js-help-notes" data-class="right"></a>
                <div class="js-notes-cont hide">
                    <p>当评价的商品未删除时，将会在下表中显示</p>
                </div>
            </div>
            <div class="js-list-tag-filter ui-chosen" style="width: 200px;">

            </div>
			<!--
            <div class="js-list-search ui-search-box">
                <input class="txt" type="text" placeholder="搜索" value="">
            </div>-->
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
            <?php if (!empty($comments)) { ?>
            <tr>
		
                <th class="checkbox cell-35" colspan="3" style="min-width: 200px; max-width: 200px;">
                    <label class="checkbox inline"><input type="checkbox" class="js-check-all">产品信息</label>
                   
                </th>
                <th class="cell-8 text-center" style="min-width: 68px; max-width: 68px;">
                    <a href="javascript:;" class="orderby" data-orderby="sort">客户信息<span class="orderby-arrow desc"></span></a>
                </th>					
                <th class="cell-10 text-center" style="min-width: 112px; max-width: 112px;">评论标签</th>
                <th class="cell-8 text-center" style="min-width: 200px; max-width: 200px;">
                    <a href="javascript:;" class="orderby" data-orderby="quantity">评论内容</a>
                </th>

                <th class="cell-12 text-center" style="min-width: 95px; max-width: 95px;">
                    <a href="javascript:;" class="orderby" data-orderby="date_added">评论时间</th>
               
			   <th class="cell-8 text-center" style="min-width: 80px; max-width: 80px;">
                    <a href="javascript:;" class="orderby" data-orderby="sales">审核状态</a>
                </th>
                <th class="cell-15 text-center" style="min-width: 95px; max-width: 95px;">操作</th>
            </tr>
            <?php } ?>
            </thead>
            <tbody class="js-list-body-region">
            <?php 
			if(is_array($comments)) {
			foreach ($comments['comment_list'] as $comment) { ?>
                <tr>
                    <td class="checkbox">
                        <input type="checkbox" class="js-check-toggle" value="<?php echo $comment['id']; ?>" />
                    </td>
					
					
                    <td>
                        <div> 
							商品id:<?php echo $comment['relation_id']; ?><br/>
							商品名称:<a href="javascript:void(0)"><?php echo $product_arr[$comment['relation_id']]['name']?></a>		
						</div>
                    </td>					

                    <td class="goods-meta">
                        <p class="goods-title">
                            <?php echo $comment['score']; ?>分
                            </a>
                        </p>
                        
                    </td>

					
                    <td class="goods-image-td">
                        <div class="goods-image js-goods-image ">
                          <img src="<?php echo $comments['user_list'][$comment['uid']]['avatar'] ?>" />
						  <?php echo $comments['user_list'][$comment['uid']]['nickname'] ?>(ID:<?php echo $comments['user_list'][$comment['uid']]['uid'] ?>)
                        </div>
                    </td>					
					
					
					
					
					
					
					
                    <td class="text-center">
						<ul>
							<?php if(is_array($comments['comment_tag_list'][$comment['id']])) {?>
								<?php foreach($comments['comment_tag_list'][$comment['id']] as $ks =>$v){ ?>
									<li> <?php echo $v['name'];?> </li>
								<?php }?>
							<?php }?>	
						</ul>
					
					
					
					
					</td>
                    <td class="text-center"><?php echo $comment['content'] ?></td>
                    
                    <td class="text-center">
                        <a class="js-change-nums" href="javascript:void(0);"><?php echo date('Y-m-d', $comment['dateline']); ?></a>
                        <input class="input-mini js-change-nums" type="number" min="0" maxlength="8" style="display: none;" data-id="<?php echo $comment['comment_id']; ?>" value="<?php echo $comment['sort']; ?>">
                    </td>
					<td class="">
						<a <?php if(option('config.is_allow_comment_control') == 1) { ?>class="js-change-num"<?php }?> href="javascript:void(0);">                 
							<?php if($comment['status'] == 1) {?>
								通过审核
							<?php } else {?>
								未通过审核
							<?php }?>	
							</a>
							<?php if(option('config.is_allow_comment_control') == 1) { ?>
							<select data="<?php echo $comment['id']; ?>" name="" class="js-input-num js-type-select" style="width:100px;height:26px;display:none">
								<option value="1">通过审核</option>
								<option value="2">未通过审核</option>
							 </select>
							<?php }?>
					</td>					
                    <td class="text-right">
                     <?php if(option('config.is_allow_comment_control') == 1) { ?>
					   <p>
                            <a href="javascript:void(0);" class="js-delete" data="<?php echo $comment['id']; ?>">删除</a><span></span>
                       </p>
					   <?php }else{?>
							不予删除
					   <?php }?>
                    </td>
                </tr>
            <?php } }?>
            </tbody>
        </table>
        <?php if (empty($comments)) { ?>
        <div class="js-list-empty-region"><div><div class="no-result">还没有相关数据。</div></div></div>
        <?php } ?>
    </div>
    <div class="js-list-footer-region ui-box">
        <?php if (!empty($comments)) { ?>
        <div>
            <div class="pull-left">
                <a href="javascript:;" class="ui-btn js-batch-delete">删除</a>
            </div>
            <div class="js-page-list ui-box pagenavi"><?php echo $page;?></div>
        </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('.js-help-notes').hover(function() {
            var content = $(this).next('.js-notes-cont').html();
            $('.popover-help-notes').remove();
            var html = '<div class="js-intro-popover popover popover-help-notes right" style="display: none; top: ' + ($(this).offset().top - 27) + 'px; left: ' + ($(this).offset().left + 16) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p>' + content + '</p> </div></div></div>';
            $('body').append(html);
            $('.popover-help-notes').show();
        }, function() {
            t = setTimeout('hide()', 200);
        })

        $('.popover-help-notes').live('hover', function(event){
            if (event.type == 'mouseenter') {
                clearTimeout(t);
            } else {
                clearTimeout(t);
                hide();
            }
        })
    })
    function hide() {
        $('.popover-help-notes').remove();
    }
	

</script>