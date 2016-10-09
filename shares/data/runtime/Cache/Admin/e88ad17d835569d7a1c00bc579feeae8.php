<?php if (!defined('THINK_PATH')) exit();?>
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
		<li class="active"><a href="<?php echo U('Rebate/index');?>">返佣明细列表</a></li>
	</ul>
	<form class="well form-search" method="post" action="<?php echo U('Rebate/index');?>">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
                       课程名： 
						<input type="text" name="keyword" style="width: 200px;"  placeholder="请输入关键字..."> &nbsp; &nbsp;
                       金额区间：
						<input type="text" name="start_price"  style="width: 80px;" autocomplete="off">-
						<input type="text" name="end_price"  style="width: 80px;" autocomplete="off"> &nbsp; &nbsp;
                        
	         返现时间：
						<input type="text" name="start_time" class="J_date"  style="width: 80px;" autocomplete="off">-
						<input type="text" name="end_time" class="J_date"  style="width: 80px;" autocomplete="off"> &nbsp; &nbsp;
                        &nbsp;
                        级别查找:
                       		<select name="rank">
                       		<option value="0">按级别查找</option>
                            <option value="1">1级返佣</option>
                            <option value="2">2级返佣</option>
                            <option value="3">3级返佣</option>
                            
                           
                        </select> &nbsp; &nbsp;
                        
						<input type="submit" class="btn btn-primary" value="搜索" />
					</span>
				</div>
			</div>
		</form>
	<form class="J_ajaxForm" action="" method="post">
		<table class="table table-hover table-bordered table-list" id="menus-table">
			<thead>
			<tr>
				<th width="30">ID</th>
				<th>购买用户</th>
				<th>获得用户</th>
				<th>课程名称</th>
				<th>对应等级</th>
				<th>获得金额</th>
				<th>返佣时间</th>
			</tr>
			</thead>
			<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><?php echo ($vo["id"]); ?></td>
					<td><?php echo ($vo["buy_name"]); ?> &nbsp;&nbsp;<?php echo ($vo["buy_mobile"]); ?></td>
					<td><span style="color:green;"><?php echo ($vo["get_name"]); ?>&nbsp;&nbsp;<?php echo ($vo["get_mobile"]); ?></span></td>
					<td><?php echo ($vo["curriculum_name"]); ?></td>
					<td><?php echo ($vo["rank"]); ?></td>
					<td>￥<?php echo ($vo["rebate_money"]); ?></td>
					<td><?php echo (date('Y-m-d H:i:s',$vo["rebate_date"])); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
			<tfoot>
			<tr>
				<th width="30">ID</th>
				<th>购买人</th>
				<th>获得人</th>
				<th>课程名</th>
				<th>对应等级</th>
				<th>获得金额</th>
				<th>返佣时间</th>
			</tr>
			</tfoot>
		</table>
		<div class="pagination"><?php echo ($Page); ?></div>
	</form>
</div>
<script src="/shares/statics/js/common.js"></script>

</body>
</html>