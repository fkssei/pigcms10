<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
  <ul class="pull-left">
      <li id="js-list-nav-all" class="active">
          <a href="http://koudaitong.com/v2/ump/reward#list">所有促销</a>
      </li>
      <li id="js-list-nav-future">
          <a href="http://koudaitong.com/v2/ump/reward#list&type=future">未开始</a>
      </li>
      <li id="js-list-nav-on">
          <a href="http://koudaitong.com/v2/ump/reward#list&type=on">进行中</a>
      </li>
      <li id="js-list-nav-end">
          <a href="http://koudaitong.com/v2/ump/reward#list&type=end">已结束</a>
      </li>
  </ul>
</nav>

<div class="widget-list">
  <div class="js-list-filter-region clearfix ui-box" style="position:relative;">
      <div>
          <a href="#create" class="ui-btn ui-btn-primary">新建满减满送</a>
          <div class="js-list-search ui-search-box">
              <input class="txt" type="text" placeholder="搜索" value=""/>
          </div>
      </div>
  </div>
</div>

<div class="ui-box">
  <?php if($group_list['service_list']){ ?>
    <table class="ui-table ui-table-list" style="padding:0px;">
      <thead class="js-list-header-region tableFloatingHeaderOriginal">
        <tr>
          <th class="cell-15">绑定时间</th>
          <th class="cell-25">身份ID(openid)</th>
          <th class="cell-15">客服昵称</th>
          <th class="cell-15">联系方式</th>
          <th class="cell-15">真实名称</th>
          <th class="cell-25 text-right">操作</th>
        </tr>
      </thead>
      <tbody class="js-list-body-region">
        <?php foreach($group_list['service_list'] as $value){ ?>
          <tr service-id="<?php echo $value['service_id']?>">
            <td><?php echo date('Y-m-d',$value['add_time']);?></td>
            <td><?php echo $value['openid'];?></td>
            <td><?php echo $value['nickname'];?></td>
            <td><?php echo $value['tel'];?></td>
            <td><?php echo $value['truename'];?></td>
            <td class="text-right">
              <a href="#edit/<?php echo $value['service_id']?>">编辑资料</a>
              <span>-</span>
              <a href="javascript:void(0);" class="js-delete" sid="<?php echo $value['service_id']?>">删除</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php }else{ ?>
    <div class="js-list-empty-region">
      <div>
        <div class="no-result widget-list-empty">还没有相关数据。</div>
      </div>
    </div>
  <?php } ?>
</div>

<div class="js-list-footer-region ui-box"></div>