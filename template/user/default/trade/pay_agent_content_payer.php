<table class="ui-table">
    <thead>
    <tr>
        <th>代付人的昵称</th>
        <th>
            <div class="page-help-notes-wrap">
                <div>代付人的留言</div>
                <div class="ui-block-head-help">
                    <a href="javascript:void(0);" class="js-payer-help-notes" data-class="right"></a>
                    <div class="js-notes-cont hide">
                        <p>商家根据产品、活动特点，配置10条随机显示的代付人随机昵称、留言，与发起人形成互动。代付人也可在代付页面自行修改昵称、留言。</p>
                    </div>
                </div>
            </div>
        </th>
        <th class="ui-table-opts">操作</th>
    </tr>
    </thead>
    <tbody class="js-tbody">
    <?php foreach ($comments as $comment) { ?>
    <tr>
        <td class="nickname-<?php echo $comment['agent_id']; ?>"><?php echo $comment['nickname']; ?></td>
        <td class="content-<?php echo $comment['agent_id']; ?>"><?php echo $comment['content']; ?></td>
        <td class="ui-table-text-right">
            <a href="javascript:;" class="js-edit-payer" data="<?php echo $comment['agent_id']; ?>">编辑</a>
            <span> - </span>
            <a href="javascript:;" class="js-delete" data="<?php echo $comment['agent_id']; ?>">删除</a>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<script type="text/javascript">
    var t;
    $(function(){
        $('.js-payer-help-notes').hover(function(){
            $('.popover-help-notes').remove();
            var html = '<div class="js-intro-popover popover popover-help-notes right" style="display: none; top: ' + ($('.js-payer-help-notes').offset().top - 30) + 'px; left: ' + ($('.js-payer-help-notes').offset().left + 15) + 'px;"><div class="arrow"></div> <div class="popover-inner"><div class="popover-content"> <p>商家根据产品、活动特点，配置10条随机显示的代付人随机昵称、留言，与发起人形成互动。代付人也可在代付页面自行修改昵称、留言。</p></div></div></div>';
            $('body').append(html);
            $('.popover-help-notes').show();

        }, function(){
            t = setTimeout('hide()', 200);
        })

        $('.popover-help-notes').live('mouseleave', function(){
            clearTimeout(t);
            hide();
        })
        $('.popover-help-notes').live('mouseover', function(){
            clearTimeout(t);
        })
    })

    function hide() {
        $('.popover-help-notes').remove();
    }
</script>