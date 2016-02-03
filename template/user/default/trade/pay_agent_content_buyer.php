<table class="ui-table">
    <thead>
    <tr>
        <th>
            <div class="page-help-notes-wrap">

                <div>发起人的求助</div>
                <div class="ui-block-head-help">
                    <a href="javascript:void(0);" class="js-help-notes" data-class="right"></a>

                    <div class="js-notes-cont hide">
                        <p>商家根据产品、活动特点，配置10条随机显示的发起人求助话术，从而引导代付人付款。发起人也可在发起代付页面自行修改求助话术。</p>
                    </div>
                </div>
            </div>
        </th>
        <th class="ui-table-opts">操作</th>
    </tr>
    </thead>
    <tbody class="js-tbody">
        <?php foreach ($helps as $help) { ?>
        <tr>
            <td class="content-<?php echo $help['agent_id']; ?>"><?php echo $help['content']; ?></td>
            <td class="ui-table-text-right"><a href="javascript:;" class="js-edit-buyer" data="<?php echo $help['agent_id']; ?>">编辑</a> - <a href="javascript:;" class="js-delete" data="<?php echo $help['agent_id']; ?>">删除</a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<script type="text/javascript">
    var t;
    $(function(){
        $('.js-help-notes').hover(function(){
            $('.popover-help-notes').remove();
            var html = '<div class="js-intro-popover popover popover-help-notes right" style="display: none; top: ' + ($(this).offset().top - 30) + 'px; left: ' + ($(this).offset().left + 15) + 'px;"><div class="arrow"></div> <div class="popover-inner"><div class="popover-content"> <p>商家根据产品、活动特点，配置10条随机显示的发起人求助话术，从而引导代付人付款。发起人也可在发起代付页面自行修改求助话术。</p></div></div></div>';
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