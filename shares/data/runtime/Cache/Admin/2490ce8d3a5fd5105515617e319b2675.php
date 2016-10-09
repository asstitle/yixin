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
        <li class="active"><a href="javascript:;">经纪人列表</a></li>
    </ul>
    <form class="well form-search" method="post" action="<?php echo U('Account/index');?>">
        <div class="search_type cc mb10">
            <div class="mb10">
					<span class="mr20">
						<input type="text" name="keyword" style="width: 200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="请输入手机号码..."> &nbsp; &nbsp;
						<input type="text" name="keyword" style="width: 200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="经纪人姓名..."> &nbsp; &nbsp;
                       <select name="state">
                           <option>经纪人类别...</option>
                           <option></option>
                       </select>
						<input type="submit" class="btn btn-primary" value="搜索" />
					</span>
            </div>
        </div>
    </form>
    <form class="J_ajaxForm" action="" method="post">
        <table class="table table-hover table-bordered table-list" id="menus-table" data-sort_field="<?php echo ($formget["sort_field"]); ?>" data-sort_by="<?php echo ($formget["sort_by"]); ?>">
            <thead>
            <tr>
                <th>经纪人ID</th>
                <th>经纪人姓名</th>
                <th>级别</th>
                <th>手机号码</th>
            </tr>
            </thead>

            <tr>
                <td>经纪人ID</td>
                <td>经纪人姓名</td>
                <td>级别</td>
                <td>手机号码</td>
            </tr>

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