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
				var data = $('#myform').serializeArray(),postData = {};
				if(data.length == 0){
					window.top.msg(0,'请先选中。。。');
					window.top.closeiframe();
					return false;
				}
				$.each(data,function(key,val){
					postData[key] = val.value;
				});
				$actType 	= $(this).attr('actType');
				$.post('?c=Store&a='+$actType,postData,function(re){
					if(re.status == 1){
						window.top.msg(1,re.msg);
						window.location.reload();
					}else{
						window.top.msg(0,re.msg);
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
				<a href="{pigcms{:U('Store/activityManage')}" class="on">推荐活动列表</a>
			</ul>
		</div>
		<table class="search_table" width="100%">
			<tr>
				<td>
					<form action="{pigcms{:U('Store/activityRecommend')}" method="get">
						<input type="hidden" name="c" value="Store"/>
						<input type="hidden" name="a" value="activityRecommend"/>
						筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}" />
						<select name="type">
							<option value="activity_id" <if condition="$_GET['type'] eq 'activity_id'">selected="selected"</if>>活动编号</option>
							<option value="activity_name" <if condition="$_GET['type'] eq 'activity_name'">selected="selected"</if>>活动名称</option>
							<option value="store_id" <if condition="$_GET['type'] eq 'store_id'">selected="selected"</if>>店铺编号</option>
							<option value="name" <if condition="$_GET['type'] eq 'name'">selected="selected"</if>>店铺名称</option>
							<option value="tel" <if condition="$_GET['type'] eq 'tel'">selected="selected"</if>>联系电话</option>
						</select>
                        &nbsp;&nbsp;活动类型：
                        <select name="activity_type">
							<option <if condition="$_GET['activity_type'] eq 999">selected="selected"</if> value="999">全部</option>
							<php>
								foreach($modelName as $key=>$val){
							</php>
								<option <if condition="$_GET['activity_type'] eq $key">selected="selected"</if> value="{pigcms{$key}">{pigcms{$val}</option>
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
					<colgroup><col> <col> <col> <col><col><col><col><col width="240" align="center"> </colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" class="choice-all" value="1" /></th>
							<th>编号</th>
							<th>标题</th>
                            <th>简介</th>
							<th class="textcenter">状态</th>
							<th>活动类型</th>
							<th>所属店铺</th>
							<th>封面图</th>
						</tr>
					</thead>
					<tbody>
						<if condition="is_array($activity)">
							<volist name="activity" id="activity" key="$key">
								<tr>
									<td><input type="checkbox" value="{pigcms{$activity.id}" name="id[]" class="choice"/></td>
									<td>{pigcms{$activity.id}</td>
									<td>{pigcms{$activity.title}</td>
                                   	<td>{pigcms{$activity.info}</td>
									<td>
										<if condition="$activity.is_rec eq 1">
											<font color="green">推荐</font>
										<else/>
											普通
										</if>
									</td>
									<td>{pigcms{$modelName[$activity['model']]}</td>
									<td>{pigcms{$storeNames[$activity['token']]}</td>
									<td><img src="{pigcms{$activity.image}" width="60" class="view_msg"></td>
                                </tr>
							</volist>
						</if>
					</tbody>
					 <tfoot>
                        <if condition="is_array($activity)">
                        <tr>
                            <td class="pagebar" colspan="8">
                                <div>
                                    <div style="float: left">
                                        <label style="cursor: pointer;color: #3865B8;" class="label-choice-all">全选</label> / <label style="cursor: pointer;color: #3865B8;" class="label-choice-cancel">取消</label>
										<button class="activityRecommend" actType="activityRecommendRecAdd" style="height:30px;width:100px;">添加热门推荐</button>
										<button class="activityRecommend" actType="activityRecommendRecDel" style="height:30px;width:100px;">取消热门推荐</button>
										　　
                                       	<button class="activityRecommend" actType="activityRecommendDel" style="height:30px;width:75px;">删除活动</button>
                                    </div>
                                    <div style="float: right">
                                        {pigcms{$page}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <else/>
                        <tr><td class="textcenter red" colspan="8">列表为空！</td></tr>
                        </if>
                    </tfoot>
				</table>
			</div>
		</form>
	</div>
<include file="Public:footer"/>