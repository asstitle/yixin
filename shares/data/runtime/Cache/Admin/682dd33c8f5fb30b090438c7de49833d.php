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
        <li class="active"><a href="javascript:;">出入金列表</a></li>
    </ul>
    <form class="well form-search" method="post" action="<?php echo U('Gold/index');?>">
        <div class="search_type cc mb10">
            <div class="mb10">
					<span class="mr20">
                        
						昵称：
						<input type="text" name="keyword" style="width: 200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="请输入关键字..."> &nbsp; &nbsp;
                        手机号码：
						<input type="text" name="keyword" style="width: 200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="请输入关键字..."> &nbsp; &nbsp;
						时间：
						<input type="text" name="start_time" class="J_date" value="<?php echo ($formget["start_time"]); ?>" style="width: 80px;" autocomplete="off">-
						<input type="text" name="end_time" class="J_date" value="<?php echo ($formget["end_time"]); ?>" style="width: 80px;" autocomplete="off"> &nbsp; &nbsp;
                        <select name="order_state">
                            <option value="0">类型筛选</option>
                            <option value="1">充值</option>
                            <option value="2">提现</option>
                            <option value="3">划转</option>
                        </select> &nbsp; &nbsp;
                            <select name="order_state">
                                <option value="0">渠道筛选</option>
                                <option value="1">微信</option>
                                <option value="2">划转</option>
                            </select> &nbsp; &nbsp;
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
                <th>订单号</th>
                <th>昵称</th>
                <th>手机号码</th>
                <th>类型</th>
                <th>渠道</th>
                <th>金额</th>
                <th>余额</th>
                <th>手续费</th>
                <th>状态</th>
                <th>提交时间</th>
            </tr>
            </thead>

                <tr>
                    <td>订单号</td>
                    <td>昵称</td>
                    <td>手机号码</td>
                    <td>类型</td>
                    <td>渠道</td>
                    <td>金额</td>
                    <td>余额</td>
                    <td>手续费</td>
                    <td>状态</td>
                    <td>提交时间</td>
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