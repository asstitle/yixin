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
     <li class="active"><a href="<?php echo U('Admin/backup/restore');?>">数据还原</a></li>
  </ul>
  <div class="common-form">
    <form action="<?php echo U('Admin/backup/import');?>" method="post">
    	<div class="table_list">
    	<table width="100%" cellspacing="0" class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th align="left">备份名称</th>
                    <th>文件大小</th>
                    <th>备份时间</th>
                    <th>管理操作</th>
                </tr>
            </thead>
        	<tbody>
            <?php if(is_array($backups)): $i = 0; $__LIST__ = $backups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr class="collapsed">
                <td>
                    <span style="padding-left: 20px" name="<?php echo ($val["name"]); ?>" class="expander"></span>
                    <?php echo ($val["name"]); ?>
                </td>
                <td><?php echo ($val["total_size"]); ?>kb</td>
                <td><?php echo ($val["date_str"]); ?></td>
                <td>
                    <a href="<?php echo u('Admin/backup/del_backup', array('backup'=>$val['name']));?>"  class="J_ajax_del">删除</a> | 
                    <a href="<?php echo u('Admin/backup/import', array('backup'=>$val['name']));?>" class="J_ajax_dialog_btn" data-msg="确定恢复吗？">恢复</a>
                </td>
            </tr>
            <?php if(is_array($val['vols'])): $i = 0; $__LIST__ = $val['vols'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr parent="<?php echo ($val["name"]); ?>" class="hide">
                <td><?php echo ($vol["file"]); ?></td>
                <td><?php echo ($vol["size"]); ?>kb</td>
                <td><?php echo ($val["date_str"]); ?></td>
                <td>
                    <a href="<?php echo u('Admin/backup/download', array('backup'=>$val['name'], 'file'=>$vol['file']));?>">下载</a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
        	</tbody>
        </table>
        </div>
    </form>
    </div> 
</div>
<style type="text/css">
.hide{display:none;}
.table_list tr.expanded td .expander{
	background: url(/shares/tpl_admin/simpleboot/assets/images/tv-collapsable.gif) center center no-repeat;
}
.table_list tr.collapsed td .expander{
	background: url(/shares/tpl_admin/simpleboot/assets/images/tv-expandable.gif) center center no-repeat;
}
</style>
<script src="/shares/statics/js/common.js"></script>
<script>
$(function(){
    $(".show_sub").click(function(){
        $(this).attr("src",function(){
            if(this.src == '/shares/tpl_admin/simpleboot/assets/images/tv-expandable.gif'){
                return '/shares/tpl_admin/simpleboot/assets/images/tv-collapsable.gif';
            } else {
                return '/shares/tpl_admin/simpleboot/assets/images/tv-expandable.gif';
            }
        });
        var sub_id = $(this).attr('sub');
        $("tr[parent='"+sub_id+"']").toggle();
    });
    $('.expander').toggle(function(){
        $(this).parent().parent().removeClass('collapsed').addClass('expanded');
        $('tr[parent="'+$(this).attr('name')+'"]').show();
    },function(){
        $(this).parent().parent().removeClass('expanded').addClass('collapsed');
        $('tr[parent="'+$(this).attr('name')+'"]').hide();
    });
});
</script>
</body>
</html>