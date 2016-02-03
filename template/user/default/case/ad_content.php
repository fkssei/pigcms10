<div class="app-design clearfix">
    <div class="widget-app-board ui-box">
        <div class="widget-app-board-info">
            <h3>公共广告</h3>
            <div>
                <p>公共广告是帮助你快速的在你的微网站各个栏目中统一设置广告，以便及时更新。</p>
            </div>
        </div>
        <div class="widget-app-board-control">
            <label class="js-switch ui-switch pull-right <?php if ($store['open_ad']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
        </div>
    </div>

    <div class="app-preview">
        <div class="app-header"></div>
        <div class="app-entry">
            <div class="app-config js-config-region">
                <div class="app-field clearfix editing"><h1><span>[页面标题]</span></h1></div>
            </div>
            <div class="app-fields js-fields-region">
                <div class="app-fields ui-sortable"></div>
            </div>
        </div>
    </div>
    <div class="app-sidebar" style="margin-top: 71px;">
        <div class="arrow"></div>
        <div class="app-sidebar-inner js-sidebar-region"></div>
    </div>
    <div class="app-actions" style="display: block; bottom: 0px;">
        <div class="form-actions text-center">
            <input class="btn btn-primary btn-save" type="submit" value="保存" data-loading-text="保存...">
        </div>
    </div>
</div>