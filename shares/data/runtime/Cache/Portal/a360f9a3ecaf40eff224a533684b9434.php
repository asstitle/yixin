<?php if (!defined('THINK_PATH')) exit();?><style>
select {
	width: auto !important;
	height: auto !important;
}

input {
	height: auto !important;
}
</style>

</head>
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
			<li class="active"><a href="javascript:;">订单列表</a></li>
		</ul>
		<form class="well form-search" method="post" action="<?php echo U('Orderdcl/index');?>">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
                        
						真实姓名/电话/订单编号：
						<input type="text" name="keyword" style="width: 200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="请输入关键字..."> &nbsp; &nbsp;
                        价格区间：
						<input type="text" name="start_price" value="<?php echo ($formget["start_price"]); ?>" style="width: 80px;" autocomplete="off">-
						<input type="text" name="end_price" value="<?php echo ($formget["end_price"]); ?>" style="width: 80px;" autocomplete="off"> &nbsp; &nbsp;
                        
						下单时间：
						<input type="text" name="start_time" class="J_date" value="<?php echo ($formget["start_time"]); ?>" style="width: 80px;" autocomplete="off">-
						<input type="text" name="end_time" class="J_date" value="<?php echo ($formget["end_time"]); ?>" style="width: 80px;" autocomplete="off"> &nbsp; &nbsp;
                        &nbsp;
                        <select name="order_state">
                            <option value="0">订单状态...</option>
                            <option>待付款</option>
                            <option value="1">已付款</option>
                            
                            <!-- <?php if(is_array($order_type)): foreach($order_type as $ko=>$vo): ?><option value="<?php echo ($ko); ?>" <?php if($formget['order_types'] == $ko): ?>selected<?php endif; ?> ><?php echo ($vo); ?></option><?php endforeach; endif; ?> -->
                        </select> &nbsp; &nbsp;
                        
						<input type="submit" class="btn btn-primary" value="搜索" />
					</span>
				</div>
			</div>
		</form>
		<form class="J_ajaxForm" action="" method="post">
			<table class="table table-hover table-bordered table-list" id="menus-table" data-sort_field="<?php echo ($formget["sort_field"]); ?>" data-sort_by="<?php echo ($formget["sort_by"]); ?>">
				<thead>
					<tr>
						<th><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></th>
                        <th>会员昵称</th>
                        
                        <th>手机</th>
                        <th>真实姓名</th>
                        <th>课程</th>
                        
                        <th>订单编号</th>
						<th>实付金额</th>
                        <th>状态</th>
                        <th class="J_table_sort" data-field="order_date">下单时间</th>
                        <th class="J_table_sort" data-field="pay_date">支付时间</th>
						<th>操作</th>
					</tr>
				</thead>
				<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
					<td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>" title="ID:<?php echo ($vo["id"]); ?>"></td>
					<td><?php echo ($vo["user_nicename"]); ?></td>
					<td><?php echo ($vo["mobile"]); ?></td>
					<td><?php echo ($vo["zs_name"]); ?></td>
					<td><?php echo ($vo["curriculum_name"]); ?></td>
					
                    <td><?php echo ($vo["orderno"]); ?></td>
                    <td><?php echo ($vo["order_money"]); ?></td>
                    <td>
                    	<?php if($vo["order_state"] == 1): ?><span style="color:green;">已支付</span>
                    	<?php else: ?>
                    		<span style="color:red;">待付款</span><?php endif; ?>
                    </td>
                    <td>
                        <?php if($vo['order_date']): echo (date("Y-m-d H:i",$vo["order_date"])); ?>
                        <?php else: ?>
                            --<?php endif; ?>
                    </td>
                    <td>
                        <?php if($vo['pay_date']): echo (date("Y-m-d H:i",$vo["pay_date"])); ?>
                        <?php else: ?>
                            --<?php endif; ?>
                    </td>
                    <td>
						<a href="<?php echo U('Orderdcl/order_view',array('id'=>$vo['id']));?>">订单详情</a>
                    </td>
				</tr><?php endforeach; endif; ?>
				
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