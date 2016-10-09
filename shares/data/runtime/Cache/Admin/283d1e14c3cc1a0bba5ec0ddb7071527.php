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
		<li class="active"><a href="<?php echo U('Withdrawall/index');?>">所有提现</a></li>
	</ul>
	<form action="<?php echo U('Withdrawall/index');?>" method="post" name="search" class="well form-search" id="search">
		<div class="search_type cc mb10">
			<div class="mb10">
					<span class="mr20">&nbsp;&nbsp;
						时间：
						<input type="text" name="start_time" class="J_date" value="<?php echo ((isset($formget["start_time"]) && ($formget["start_time"] !== ""))?($formget["start_time"]):''); ?>" style="width: 80px;" autocomplete="off">-
						<input type="text" class="J_date" name="end_time" value="<?php echo ($formget["end_time"]); ?>" style="width: 80px;" autocomplete="off"> &nbsp; &nbsp;
						关键字：
						<input type="text" name="keyword" style="width: 200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="请输入会员昵称、手机或提现id">
					&nbsp; &nbsp;
						<select name="state">
							<option value="" <?php if($formget['state'] == '' and $formget['state'] != 0): ?>selected<?php endif; ?>>提现状态...</option>
							<?php if(is_array($ar_txstatus)): $i = 0; $__LIST__ = $ar_txstatus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($formget['state'] == $key): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
						
						<!-- <select name="itype">
							<option value="" <?php if($formget['itype'] == '' and $formget['itype'] != 0): ?>selected<?php endif; ?>>提现类别...</option>
							<option value="1" <?php if($formget['itype'] == 1): ?>selected<?php endif; ?>>会员提现</option>
							<option value="2" <?php if($formget['itype'] == 2): ?>selected<?php endif; ?>>商家提现</option>
							<option value="3" <?php if($formget['itype'] == 3): ?>selected<?php endif; ?>>代理商提现</option>
						</select> -->
						<input type="submit" class="btn btn-primary" value="搜索" />
					</span>
					<span>合计提现：<?php echo ($alltx); ?></span>&nbsp;

			</div>
		</div>
  </form>
	<span><form action="<?php echo U('Withdrawall/dctx');?>" method="post" name="export" target="_blank" id="export">
		<input type="hidden" name="start_time" value="<?php echo ($formget["start_time"]); ?>">
		<input type="hidden"  name="end_time" value="<?php echo ($formget["end_time"]); ?>">
	    <input type="hidden"  name="keyword" value="<?php echo ($formget["keyword"]); ?>">
	    <input type="hidden"  name="state" value="<?php echo ($formget["state"]); ?>">
	    <input type="hidden"  name="itype" value="<?php echo ($formget["itype"]); ?>">
	  <input type="submit" value="导出Excel" class="btn btn-primary"></form></span>
	<form class="J_ajaxForm" action="" method="post">
		<table class="table table-hover table-bordered table-list" id="menus-table">
			<thead>
			<tr>
				<th width="15"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></th>
				<th>ID</th>
				<th>用户昵称</th>
				<th>用户手机</th>
				<th>提现类别</th>
				<th>提现金额</th>
				<th>手续费用</th>
				<th>实际到账</th>
				<th>开户银行</th>
				<th>开户支行</th>
				<th>开户姓名</th>
				<th>银行账号</th>
				<th>操作时间</th>
				<th>提现状态</th>
				<th>管理操作</th>
			</tr>
			</thead>
			<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>" title="ID:<?php echo ($vo["id"]); ?>"></td>
					<td><?php echo ($vo["id"]); ?></td>
					<td><?php echo ($vo["user_nicename"]); ?></td>
					<td><?php echo ($vo["mobile"]); ?></td>
					<td><?php echo ($ar_txtype[$vo[itype]]); ?></td>
					<td><?php echo ($vo["price"]); ?></td>
					<td><?php echo ($vo["fee"]); ?></td>
					<td><?php echo ($vo["sjdz"]); ?></td>
					<td><?php echo ($vo["khyh"]); ?></td>
					<td><?php echo ($vo["khzh"]); ?></td>
					<td><?php echo ($vo["khxm"]); ?></td>
					<td><?php echo ($vo["yhzh"]); ?></td>
					<td><?php echo (date('Y-m-d',$vo["date"])); ?></td>
					<td><?php echo ($ar_txstatus[$vo[state]]); ?></td>
					<td>
						<a href="<?php echo U('Withdrawall/enable',array('id'=>$vo['id'],'t'=>2));?>" class="J_ajax_dialog_btn" data-msg="你确定进行此操作吗？">已处理</a> |
						<a href="<?php echo U('Withdrawall/enable',array('id'=>$vo['id'],'t'=>1));?>" class="J_ajax_dialog_btn" data-msg="你确定进行此操作吗？">待处理</a>					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
			<tfoot>
			<tr>
				<th width="15"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></th>
				<th>ID</th>
				<th>用户昵称</th>
				<th>联系方式</th>
				<th>提现类别</th>
				<th>提现金额</th>
				<th>手续费用</th>
				<th>实际到账</th>
				<th>开户银行</th>
				<th>开户支行</th>
				<th>开户姓名</th>
				<th>银行账号</th>
				<th>操作时间</th>
				<th>提现状态</th>
				<th>管理操作</th>
			</tr>
			</tfoot>
		</table>
		<div class="table-actions">
			<button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Withdrawall/enable',array('t'=>2));?>" data-subcheck="true" data-msg="你确定进行此操作吗？">已处理</button>
			<button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Withdrawall/enable',array('t'=>1));?>" data-subcheck="true" data-msg="你确定进行此操作吗？">待处理</button>
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
	//提现记录
	function dcExcel(){
		$.post("<?php echo U('Withdrawall/dctx');?>",{},function(){});
	}
</script>
</body>
</html>