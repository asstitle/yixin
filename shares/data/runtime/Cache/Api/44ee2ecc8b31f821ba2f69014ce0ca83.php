<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
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
	</style><?php endif; ?>
<body class="J_scroll_fixed">
	<div class="wrap jj">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('guestbookadmin/index');?>">所有留言</a></li>
		</ul>
		<form method="post" class="J_ajaxForm" action="#">
			<div class="table_list">
				<table width="100%" class="table table-hover table-bordered">
					<thead>
						<tr>
							<th width="50">ID</th>
							<th width="100">姓名</th>
							<th width="150">邮箱</th>
							<th style="min-width: 60px;">留言标题</th>
							<th>留言内容</th>
							<th width="120">留言时间</th>
							<th width="120">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($guestmsgs)): foreach($guestmsgs as $key=>$vo): ?><tr>
							<td><?php echo ($vo["id"]); ?></td>
							<td><?php echo ($vo["full_name"]); ?></td>
							<td><?php echo ($vo["email"]); ?></td>
							<td><?php echo ($vo["title"]); ?></td>
							<td><?php echo ($vo["msg"]); ?></td>
							<td><?php echo ($vo["createtime"]); ?></td>
							<td>
								<a href="<?php echo U('guestbookadmin/delete',array('id'=>$vo['id']));?>" class="J_ajax_del">删除</a>
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
				<div class="pagination"><?php echo ($Page); ?></div>
			</div>
		</form>
	</div>
	<script src="/shares/statics/js/common.js?"></script>
</body>
</html>