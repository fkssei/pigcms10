<include file="Public:header"/>
    <script type="text/javascript">
        $(function(){
            $('span > .cb-enable').click(function(){
                if (!$(this).hasClass('selected')) {
                    var store_id = $(this).data('id');
                    $.post("<?php echo U('Store/status'); ?>",{'status': 1, 'store_id': store_id}, function(data){})
                }
            })
            $('span > .cb-disable').click(function(){
                var store_id = $(this).data('id');
                if (!$(this).hasClass('selected')) {
                    $.post("<?php echo U('Store/status'); ?>",{'status': 0,  'store_id': store_id}, function(data){})
                }
            })
        })
    </script>
    <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
        <tr>
            <th><b>Logo</b></th>
            <th><b>店铺名称</b></th>
            <th><b>主营类目</b></th>
            <th style="text-align: right"><b>收入</b></th>
            <th style="text-align: right"><b>可提现余额</b></th>
            <th style="text-align: right"><b>待结算余额</b></th>
            <th style="text-align: center"><b>操作</b></th>
        </tr>
        <volist name="stores" id="store">
        <tr>
            <th><img src="{pigcms{$store.logo}" width="60" height="60" /></th>
            <th>{pigcms{$store.name}</th>
            <th>{pigcms{$store.sale_category}</th>
            <th style="text-align: right">{pigcms{$store.income}</th>
            <th style="text-align: right">{pigcms{$store.balance}</th>
            <th style="text-align: right">{pigcms{$store.unbalance}</th>
            <th style="text-align: center;width:90px">
                <span class="cb-enable">
                    <label class="cb-enable <?php if (!empty($store['status'])) { ?>selected<?php } ?>" data-id="<?php echo $store['store_id']; ?>"><span>开启</span><input type="radio" name="status" value="1" <?php if (!empty($store['status'])) { ?>checked="checked"<?php } ?>></label>
                </span>
                <span class="cb-disable">
                    <label class="cb-disable <?php if (empty($store['status'])) { ?>selected<?php } ?>" data-id="<?php echo $store['store_id']; ?>"><span>关闭</span><input type="radio" name="status" value="0" <?php if (empty($store['status'])) { ?>checked="true" <?php } ?> /></label>
                </span>
            </th>
        <tr/>
        </volist>
    </table>
<include file="Public:footer"/>