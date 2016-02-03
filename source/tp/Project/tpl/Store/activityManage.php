<include file="Public:header"/>
	<style>
		.table-list tfoot tr {
            height: 40px;
        }
	</style>
	<script type="text/javascript">
        $(function(){
			var activityModel = '{pigcms{$selectModel}';
            $('.choice-all').live('click', function(){
                if ($(this).is(':checked')) {
                    $('.choice').attr('checked', true);
                    $('.disabled').attr('checked', false);
                    $("select[name='batch_edit_status']").attr('disabled', false);
                    $("select[name='batch_edit_status']").css('background-color', 'white');
                } else {
                    $('.choice').attr('checked', false);
                    $("select[name='batch_edit_status']").attr('disabled', true);
                    $("select[name='batch_edit_status']").css('background-color', '#ddd');
                }
            })
			$('.label-choice-all').live('click', function(){
				$('.choice-all').attr('checked', true);
				$('.choice').attr('checked', true);
				$('.disabled').attr('checked', false);
				$("select[name='batch_edit_status']").attr('disabled', false);
				$("select[name='batch_edit_status']").css('background-color', 'white');
			})

			$('.label-choice-cancel').live('click', function(){
				$('.choice-all').attr('checked', false);
				$('.choice').attr('checked', false);
				$("select[name='batch_edit_status']").attr('disabled', true);
				$("select[name='batch_edit_status']").css('background-color', '#ddd');
			})
			$('.activityRecommend').click(function(){
				var data = $('#myform').serializeArray(),activityData = $.parseJSON($('#activity-tmpl').html()),postData = {};
				if(data.length == 0){
					window.top.msg(0,'请先选中。。。');
					window.top.closeiframe();
					return false;
				}
				$.each(data,function(key,val){
					postData[key] = activityData[val.value];
					postData[key].model = activityModel;
				});
				$.post('?c=Store&a=activityRecommendAdd',postData,function(re){
					if(re.status == 1){
						window.top.msg(1,re.msg);
						window.top.closeiframe();
					}
				},'json');
				return false;
			});
		})
    </script>
	<div class="mainbox">
		<div id="nav" class="mainnav_title">
			<ul>
				<a href="{pigcms{:U('Store/activityManage')}" class="on">店铺活动列表</a>
			</ul>
		</div>
		<table class="search_table" width="100%">
			<tr>
				<td>
					<form action="{pigcms{:U('Store/activityManage')}" method="get">
						<input type="hidden" name="c" value="Store"/>
						<input type="hidden" name="a" value="activityManage"/>
						筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}" />
						<select name="type">
							<option value="store_id" <if condition="$_GET['type'] eq 'store_id'">selected="selected"</if>>店铺编号</option>
							<option value="name" <if condition="$_GET['type'] eq 'name'">selected="selected"</if>>店铺名称</option>
							<option value="tel" <if condition="$_GET['type'] eq 'tel'">selected="selected"</if>>联系电话</option>
						</select>
                        &nbsp;&nbsp;活动类型：
                        <select name="activity_type">
							<php>
								foreach($modelName as $key=>$val){
							</php>
								<option <if condition="$selectModel eq $key">selected="selected"</if> value="{pigcms{$key}">{pigcms{$val}</option>
							<php>
								}
							</php>
                        </select>
						<input type="submit" value="查询" class="button"/>
					</form>
				</td>
			</tr>
		</table>
		<form name="myform" id="myform" action="" method="post">
			<div class="table-list">
				<table width="100%" cellspacing="0">
					<colgroup><col> <col> <col> <col><col><col width="240" align="center"> </colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" class="choice-all" value="1" /></th>
							<th>标题</th>
                            <th>简介</th>
							<th>活动类型</th>
							<th>所属店铺</th>
							<th>封面图</th>
						</tr>
					</thead>
					<tbody>
						<if condition="is_array($activityList)">
							<volist name="activityList" id="activity" key="$key">
								<tr>
									<td><input type="checkbox" value="{pigcms{$key}" name="id[]" class="choice"/></td>
									<td>{pigcms{$activity.title}</td>
                                   	<td>{pigcms{$activity.info}</td>
									<td>{pigcms{$activityName}</td>
									<td>{pigcms{$storeNames[$activity['token']]}</td>
									<td><img src="{pigcms{$activity.image}" width="60" class="view_msg"></td>
                                </tr>
							</volist>
						</if>
					</tbody>
					 <tfoot>
                        <if condition="is_array($activityList)">
                        <tr>
                            <td class="pagebar" colspan="6">
                                <div>
                                    <div style="float: left">
                                        <label style="cursor: pointer;color: #3865B8;" class="label-choice-all">全选</label> / <label style="cursor: pointer;color: #3865B8;" class="label-choice-cancel">取消</label>
                                       	<button class="activityRecommend" style="height:30px;width:100px;">加入营销活动展示</button>
                                    </div>
                                    <div style="float: right">
                                        {pigcms{$page}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <else/>
                        <tr><td class="textcenter red" colspan="6">列表为空！</td></tr>
                        </if>
                    </tfoot>
				</table>
			</div>
		</form>
	</div>
	<script type="text/template" id="activity-tmpl">
		{pigcms{$activityList|json_encode}
	</script>
<include file="Public:footer"/>