<?php if (!defined('THINK_PATH')) exit();?><style>
select {
	width: auto !important;
	height: auto !important;
}

input {
	height: auto !important;
}
</style>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/shares/statics/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/shares/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/shares/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/shares/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}

	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/shares/statics/simpleboot/font-awesome/4.2.0/css/font-awesome-ie7.min.css">
	<![endif]-->
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/shares/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/shares/statics/js/jquery.js"></script>
    <script src="/shares/statics/js/wind.js"></script>
    <script src="/shares/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?><body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
	<ul class="nav nav-tabs">
		<li class="active"><a href="<?php echo U('Indexadmin/index');?>">会员列表</a></li>
	</ul>
	<form class="well form-search" method="post" action="<?php echo U('Indexadmin/index');?>">
		<div class="search_type cc mb10">
			<div class="mb10">
					<span class="mr20">&nbsp;&nbsp;
						时间：
						<input type="text" name="start_time" class="J_date" value="<?php echo ((isset($formget["start_time"]) && ($formget["start_time"] !== ""))?($formget["start_time"]):''); ?>" style="width: 80px;" autocomplete="off">-
						<input type="text" class="J_date" name="end_time" value="<?php echo ($formget["end_time"]); ?>" style="width: 80px;" autocomplete="off"> &nbsp; &nbsp;
						关键字：
						<input type="text" name="keyword" style="width: 200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="请输入关键字...">
						
						<select name="state">
							<option value="" <?php if($formget['state'] == '' and $formget['state'] != 0): ?>selected<?php endif; ?>>选择状态...</option>
							<?php if(is_array($ar_usertype)): $i = 0; $__LIST__ = $ar_usertype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($formget['state'] == $key): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
						<input type="submit" class="btn btn-primary" value="搜索" />
					</span>
			</div>
		</div>
	</form>
	<form class="J_ajaxForm" action="" method="post">
		<table class="table table-hover table-bordered table-list" id="menus-table" data-sort_field="<?php echo ($formget["sort_field"]); ?>" data-sort_by="<?php echo ($formget["sort_by"]); ?>"><!--在table-list里添加sort_field和sort_by字段，存放之前选择的值 -->
			<thead>
			<tr>
				<th width="15"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></th>
				<th class="J_table_sort" data-field="ou.id">ID</th>
				<th class="J_table_sort" data-field="ou.mobile">用户昵称</th>
				<th class="J_table_sort" data-field="ou.mobile">手机号码</th>
				<th class="J_table_sort" data-field="ou.zs_name">真实姓名</th>
				<th class="J_table_sort" data-field="ou.tjrr">推荐人员</th>
				<th class="J_table_sort" data-field="ou.tjrs">推荐人数</th>
				<!--<th>性别</th>-->
				<th class="J_table_sort" data-field="ou.score">当前资金</th>
				<!-- <th class="J_table_sort" data-field="ou.wfjf">未返积分</th>
				<th class="J_table_sort" data-field="ou.yfjf">已返积分</th> -->
				<!-- <th>商家积分</th>
				<th>代理积分</th> -->
				<th class="J_table_sort" data-field="ou.user_type">用户类型</th>
				<th class="J_table_sort" data-field="ou.user_status">会员状态</th>
				<th class="J_table_sort" data-field="ou.create_time">注册时间</th>
				<th>管理操作</th>
			</tr>
			</thead>
			<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>" title="ID:<?php echo ($vo["id"]); ?>"></td>
					<td><?php echo ($vo["id"]); ?></td>
					<td><?php echo ($vo["user_nicename"]); ?></td>
					<td><?php echo ($vo["mobile"]); ?></td>
					<td><?php echo ($vo["zs_name"]); ?></td>
					<td><?php echo ($vo["tjrr"]); ?></td>
					<td><?php if($vo['tjrs']): echo ($vo["tjrs"]); endif; ?></td>
					<!--<td><?php echo ($ar_sex[$vo[sex]]); ?></td>-->
					<td><?php echo ($vo["score"]); ?></td>
					<!-- <td><?php echo ($vo["wfjf"]); ?></td>
					<td><?php echo ($vo["yfjf"]); ?></td>
					<td><?php echo ($vo["sjscore"]); ?></td>
					<td><?php echo ($vo["dl_score"]); ?></td> -->
					<td><?php echo ($ar_usertype[$vo[user_type]]); ?></td>
					<td><?php echo ($ar_blur[$vo[user_status]]); ?></td>
					<td><?php echo (date("Y-m-d H:i",$vo["create_time"])); ?></td>
					<td>
						<a href="<?php echo U('Indexadmin/edit',array('id'=>$vo['id']));?>">修改</a> |
						<a href="<?php echo U('Indexadmin/delete',array('id'=>$vo['id']));?>" class="J_ajax_del" data-msg="你确定要删除吗？<BR>将删除用户消息、提现、积分明细、订单、店铺、代理">删除</a>
						<a href="<?php echo U('Indexadmin/enable',array('t'=>1,'id'=>$vo['id']));?>" class="J_ajax_dialog_btn" data-msg="你确定进行此操作吗？">启用</a>
						<a href="<?php echo U('Indexadmin/enable',array('t'=>0,'id'=>$vo['id']));?>" class="J_ajax_dialog_btn" data-msg="你确定进行此操作吗？">禁用</a>					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>

		</table>
		<div class="table-actions">
			<!--<button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Indexadmin/delete');?>" data-subcheck="true" data-msg="你确定删除吗？">删除</button> -->
			<button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Indexadmin/enable',array('t'=>1));?>" data-subcheck="true" >全部启用</button>
			<button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Indexadmin/enable',array('t'=>0));?>" data-subcheck="true" >取消启用</button>
		</div>
		<div class="pagination"><?php echo ($Page); ?></div>
	</form>
</div>
<script src="/shares/statics/js/common.js"></script>
<script>
	$(document).ready(function() {
		Wind.css('treeTable');
		Wind.use('treeTable', function() {
			$("#menus-table").treeTable({
				indent : 20
			});
		});
	});

	setInterval(function() {
		var refersh_time = getCookie('refersh_time_admin_menu_index');
		if (refersh_time == 1) {
			reloadPage(window);
		}
	}, 1000);
	setCookie('refersh_time_admin_menu_index', 0);
</script>
</body>
</html>