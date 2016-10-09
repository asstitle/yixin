<?php if (!defined('THINK_PATH')) exit();?><style>
select {
	width: auto !important;
	height: auto !important;
}

input {
	height: auto !important;
}
table {
	text-align:center;
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
			<li  class="active"><a href="<?php echo U('Userrank/index');?>">关系调整记录</a></li>
			<li><a href="<?php echo U('Userrank/chage');?>">用户关系调整 </a></li>
		</ul>
		<form class="well form-search" method="post" action="<?php echo U('Userrank/index');?>">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
                        
						<input type="text" name="keyword" style="width: 300px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="会员昵称/手机/真实姓名关键字..."> &nbsp; &nbsp;
                       <!--  价格：
						<input type="text" name="start_money" value="<?php echo ($formget["start_price"]); ?>" style="width: 100px;" autocomplete="off">-
						<input type="text" name="end_money" value="<?php echo ($formget["end_price"]); ?>" style="width: 100px;" autocomplete="off"> &nbsp; &nbsp; -->
                        
                        &nbsp;
                       
                      <!--   已售数量：
						<input type="text" name="start_xl" value="<?php echo ($formget["start_xl"]); ?>" style="width: 100px;" autocomplete="off">-
						<input type="text" name="end_xl" value="<?php echo ($formget["end_xl"]); ?>" style="width: 100px;" autocomplete="off"> &nbsp;  -->
						<input type="submit" class="btn btn-primary" value="搜索" />
					</span>
				</div>
			</div>
		</form>
		<form class="J_ajaxForm" action="" method="post">
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						
                        <th>变更用户</th>
                        <th>变更用户ID</th>
                        <th>变更会员真实姓名</th>
						<th>上级用户</th>
						<th>上级用户ID</th>
                        <th>上级用户真实姓名</th>
                        <th>变更时间</th>
                        <th>备注</th>
						<th>操作人</th>
					</tr>
				</thead>
				<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
					
                    
					<td><?php echo ($vo["au_nicename"]); ?> | <?php echo ($vo["au_mobile"]); ?></td>
                    <td><?php echo ($vo["active_uid"]); ?></td>
                    <td><?php echo ($vo["au_name"]); ?></td>
                    <td><?php echo ($vo["uu_nicename"]); ?> | <?php echo ($vo["uu_mobile"]); ?></td>
                    <td>
                    	<?php if($vo["up_uid"] == 0): ?>变更为一级用户
                    	<?php else: ?>
                    	<?php echo ($vo["up_uid"]); endif; ?>
                    	
                    </td>
                    <td><?php echo ($vo["uu_name"]); ?></td>
                    <td><?php echo (date('Y-m-d H:i:s',$vo["chage_date"])); ?></td>
                    <td><?php echo ($vo["chage_bz"]); ?></td>
                    <td><?php echo ($vo["ad_user"]); ?></td>
                    
				</tr><?php endforeach; endif; ?>
				
			</table>
			
			<div class="pagination"><?php echo ($Page); ?></div>
		</form>
	</div>
	<script src="/shares/statics/js/common.js"></script>
	<script src="/shares/statics/js/jquery-1.8.2.min.js"></script>
	<script src="/shares/statics/js/layer/layer.js"></script>
	<script src="/shares/statics/js/zt/js_zt.js"></script>
	
</body>
</html>