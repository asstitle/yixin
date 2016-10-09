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
		<li class="active"><a href="<?php echo U('Usermx/index');?>">用户明细</a></li>
	</ul>
	<form action="<?php echo U('Usermx/index');?>" method="post" name="search" class="well form-search" id="search">
		<div class="search_type cc mb10">
			<div class="mb10">
					<span class="mr20">&nbsp;&nbsp;
						时间：
						<input type="text" name="start_time" class="J_date" value="<?php echo ((isset($formget["start_time"]) && ($formget["start_time"] !== ""))?($formget["start_time"]):''); ?>" autocomplete="off">-
						<input type="text" class="J_date" name="end_time" value="<?php echo ($formget["end_time"]); ?>" autocomplete="off"> &nbsp; &nbsp;
						关键字：
						<input type="text" name="keyword" style="width: 200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="请输入用户昵称、id或手机">
                        
                        <select name="op">
                                <option value="">操作类型...</option>
                            <?php if(is_array($op)): $i = 0; $__LIST__ = $op;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>  
                        </select>
                        <input type="submit" class="btn btn-primary" value="搜索" />
					</span>

			</div>
		</div>
  </form>
	<span><form action="<?php echo U('Usermx/dctx');?>" method="post" name="export" target="_blank" id="export">
		<input type="hidden" name="start_time" value="<?php echo ($formget["start_time"]); ?>">
		<input type="hidden"  name="end_time" value="<?php echo ($formget["end_time"]); ?>">
	    <input type="hidden"  name="keyword" value="<?php echo ($formget["keyword"]); ?>">
	    <input type="hidden"  name="op" value="<?php echo ($formget["op"]); ?>">
	    <input type="submit" value="导出Excel" class="btn btn-primary"></form></span>
	<form class="J_ajaxForm" action="" method="post">
		<table class="table table-hover table-bordered table-list" id="menus-table" data-sort_field="<?php echo ($formget["sort_field"]); ?>" data-sort_by="<?php echo ($formget["sort_by"]); ?>"><!--在table-list里添加sort_field和sort_by字段，存放之前选择的值 -->
			<thead>
			<tr>
				<th class="J_table_sort" data-field="ui.id">ID</th>
				<th class="J_table_sort" data-field="ou.user_nicename">用户名称</th>
                <th class="J_table_sort" data-field="ou.mobile">手机号码</th>
                <th class="J_table_sort" data-field="ou.user_type">用户类型</th>
                <th class="J_table_sort" data-field="ui.op">操作</th>
				<th class="J_table_sort" data-field="ui.integral">操作资金 <?php echo ($allprice["integral"]); ?></th>
				<th class="J_table_sort" data-field="ui.integral_sj">实际资金 <?php echo ($allprice["integral_sj"]); ?></th>
				<th class="J_table_sort" data-field="ui.is_fanxian">是否返现</th>
				<th class="J_table_sort" data-field="ui.cur_integral">余额</th>
				<th class="J_table_sort" data-field="ui.remark">备注</th>
				<th class="J_table_sort" data-field="ui.date">时间</th>
			</tr>
			</thead>
			<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><?php echo ($vo["id"]); ?></td>
					<td><?php echo ($vo["user_nicename"]); ?></td>
                    <td><?php echo ($vo["mobile"]); ?></td>
                    <td><?php echo ($ar_usertype[$vo[user_type]]); ?></td>
                    <td><?php echo $op[$vo[op]] ?></td>
					<td><?php echo ($vo["integral"]); ?></td>
					<td><?php echo ($vo["integral_sj"]); ?></td>
					<td><?php if($vo['is_fanxian'] == 1): ?><font color="red">√</font><?php endif; ?></td>
					<td><?php echo ($vo["cur_integral"]); ?></td>
					<td><?php echo ($vo["remark"]); ?></td>
					<td><?php echo (date("Y-m-d H:i",$vo["date"])); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
			<tfoot>
			<tr>
				<th>ID</th>
				<th>会员名称</th>
                <th>手机号码</th>
                <th>用户类型</th>
                <th>操作</th>
				<th>操作资金</th>
				<th>实际资金</th>
				<th>是否返现</th>
				<th>余额</th>
				<th>备注</th>
				<th>时间</th>
			</tr>
			</tfoot>
		</table>
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