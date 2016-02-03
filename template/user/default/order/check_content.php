<div>
    <div class="js-list-filter-region clearfix">
        <div>
         <?php include display('_search'); ?>
        <div class="ui-nav ulnav">
            <ul>
               <!-- <li><a href="#all" class="all check" data="0">全部 </a></li>-->
                <!--
				<li class="active"><a href="#uncheck" class="wait-paid status-1 wdz" data="1">未对帐</a></li>
                <li><a href="#check" class="wait-send status-2" data="2">已对账</a></li>
				-->
				
                <li><a href="javascript:;" class="all" data="0">全部</a></li>
                <li><a href="javascript:;" class="wait-paid status-1" data="1">未对帐</a></li>
                <li><a href="javascript:;" class="wait-send status-2" data="2">已对账</a></li>				
            </ul>
        </div>
    </div>
</div>
<div class="ui-box orders">
    <?php include display('_checklist'); ?>
    <?php if (empty($orders)) { ?>
    <?php include display('_empty'); ?>
    <?php } ?>
</div>
<div class="js-list-footer-region ui-box"><div><div class="pagenavi"><?php echo $page; ?></div></div></div></div>