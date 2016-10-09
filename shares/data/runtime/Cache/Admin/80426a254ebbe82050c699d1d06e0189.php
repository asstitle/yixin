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
			<li><a href="<?php echo U('menu/index');?>">后台菜单</a></li>
			<li class="active"><a href="<?php echo U('menu/add');?>">添加菜单</a></li>
		</ul>
		<div class="common-form">
			<form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('Menu/add_post');?>">
				<fieldset>
					<div class="control-group">
						<label class="control-label">上级:</label>
						<div class="controls">
							<select name="parentid" class="normal_select">
								<option value="0">作为一级菜单</option>
								<?php echo ($select_categorys); ?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">名称:</label>
						<div class="controls">
							<input type="text" class="input" name="name" value="">
							<span class="must_red">*</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">应用:</label>
						<div class="controls">
							<input type="text" class="input" name="app" id="app" value="">
							<span class="must_red">*</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">模块:</label>
						<div class="controls">
							<input type="text" class="input" name="model" id="model" value="">
							<span class="must_red">*</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">方法:</label>
						<div class="controls">
							<input type="text" class="input" name="action" id="action" value="">
							<span class="must_red">*</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">参数:</label>
						<div class="controls">
							<input type="text" class="input length_5" name="data" value="">
							例:id=3&amp;p=3
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">图标:</label>
						<div class="controls">
							<input type="text" class="input" name="icon" id="action" value="">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">备注:</label>
						<div class="controls">
							<textarea name="remark" rows="5" cols="57"></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">状态:</label>
						<div class="controls">
							<select name="status" class="normal_select">
								<option value="1">显示</option>
								<option value="0">隐藏</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">类型:</label>
						<div class="controls">
							<select name="type" class="normal_select">
								<option value="1" selected>权限认证+菜单</option>
								<option value="0">只作为菜单</option>
							</select>
							注意：“权限认证+菜单”表示加入后台权限管理，纯碎是菜单项请不要选择此项。
						</div>
					</div>
				</fieldset>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary btn_submit  J_ajax_submit_btn">添加</button>
					<a class="btn" href="/shares/index.php/admin/menu">返回</a>
				</div>
			</form>
		</div>
	</div>
	<script src="/shares/statics/js/common.js"></script>
</body>
</html>