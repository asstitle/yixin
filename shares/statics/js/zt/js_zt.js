/**
 * 公共引入
 */
//document.write('<script src="./statics/js/zt/jquery-1.9.1.js"><\/script>');
//ajax表单提交JS
document.write('<script src="./statics/js/zt/ajaxForm.js"><\/script>');
//正则验证
document.write('<script src="./statics/js/zt/reg.js"><\/script>');
//验证框架
document.write('<script src="./statics/js/zt/Validform/Validform_v5.3.2.js"><\/script>');
//弹出框
document.write('<script src="./statics/js/zt/layer/layer.js"><\/script>');
//验证框架css
document.write('<link href="./statics/js/zt/Validform/Validform_v5.3.2/demo/css/style.css" type="text/css" media="all" rel="stylesheet" />');
//地区联动
document.write('<script src="./statics/js/zt/area.js"><\/script>');
//自定义css
document.write('<link href="./statics/js/zt/zt.css" type="text/css" media="all" rel="stylesheet" />');
//前端ajax加载页面模板（方便ajax读取数据后生成页面）
document.write('<script src="./statics/js/zt/template.js"><\/script>');
$(function(){

    //表单ajax提交方法
    $(".zt_ajax_form").click(function(){
        var _form = $(this).parents("form");
        _form.Validform({
            ajaxPost:true,
            beforeSubmit:function(curform){//验证通过 提交前执行
                $(".zt_ajax_form").attr("disabled",true);//锁定提交按钮
                if(typeof zt_ck!='undefined'&&zt_ck instanceof Function){//调用自定义验证
                    if(!zt_ck()){
                        $(".zt_ajax_form").removeAttr("disabled");//恢复提交按钮
                        return zt_ck();
                    }
                }
            },
            callback:function(data){
                $.Hidemsg();//取消等待提示
                if (data.success) {
                    layer.msg(data.success);
                }
                if (data.error) {
                    layer.msg(data.error);
                }
                if (data.url) {
                    setTimeout(function(){
                        location.href=data.url;
                    }, 3000);
                }else{
                    $(".zt_ajax_form").removeAttr("disabled");//恢复提交按钮
                }
            }
        });
    })
    //表单普通提交方法
    
    $(".curriculum_status").click(function(){
		
		var url = $(this).data("url");
		var msg = $(this).data("msg");
		var id = $(this).data("id");
		var value = $(this).data('value');
		
		if(msg!=undefined){
            layer.confirm(msg, {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post(url,{id:id,value:value},function(data){
                	
                    if (data.success) {
                        layer.msg(data.success);
                    }
                    if (data.error) {
                        layer.msg(data.error);
                    }
                    if (data.url) {
                        setTimeout(function(){
                            location.href=data.url;
                        }, 1000);
                    }
                    if(data.f5_active){
                   	 window.location.reload();
                    }
                });
            });
        }else{
            $.post(url,{id:id,value:value},function(data){
            	
                if (data.success) {
                    layer.msg(data.success);
                }
                if (data.error) {
					layer.msg(data.error);		
				}
                if (data.url) {
                    setTimeout(function(){
                        location.href=data.url;
                    }, 1000);
                }
                if(data.f5_active){
               	 window.location.reload();
                }
            });
        }

		
	});
	
    
    $(".zt_post_form").click(function(){
        var _form = $(this).parents("form");
        _form.Validform({
            callback:function(data){
                //默认验证方法zt_ck() return false表示为未通过验证
                if(typeof zt_ck!='undefined'&&zt_ck instanceof Function){
                    return zt_ck();
                }
            }
        });
    })
    //控件点击提交方法
    $(".zt_click_post").click(function(){
        var msg = $(this).data("msg");
        var url = $(this).data("url");
        if(msg!=undefined){
            layer.confirm(msg, {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post(url,{},function(data){
                    if (data.success) {
                        layer.msg(data.success);
                    }
                    if (data.error) {
                        layer.msg(data.error);
                    }
                    if (data.url) {
                        setTimeout(function(){
                            location.href=data.url;
                        }, 3000);
                    }
                });
            });
        }else{
            $.post(url,{},function(data){
                if (data.success) {
                    layer.msg(data.success);
                }
                if (data.error) {
                    layer.msg(data.error);
                }
                if (data.url) {
                    setTimeout(function(){
                        location.href=data.url;
                    }, 3000);
                }
            });
        }
    })
    /**
     * 实时上传头像
     * 需要配合控制器和前台
     */
    $(".zt_ajax_sub").change(function(){
        $(this).parents("form").ajaxSubmit({
            type: "post", // 提交方式 get/post
            url: $(".zt_ajax_sub").data("url"), // 需要提交的 url
            //resetForm: true,//重置表单
            success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                $("#"+$(".zt_ajax_sub").data("img")).attr("src",data);//取点击控件的data-img 数据 为ID
                if($(".zt_ajax_sub").data("hid")){
                    $("#"+$(".zt_ajax_sub").data("hid")).val(data);//取点击控件的data-hid 数据 为ID
                }
            }
        });
    })
    /**
     * 手机端 滑动加载
     */
    if ($(".view_list_box").size() > 0)  {
        //此判断只在获取商家地理位置时使用 其他项目可删了
        if(!$(".view_list_box").hasClass('on')){
            var page = 1;
            var IsNext = true;
            $(document).ready(function () {
                $(window).scroll(function () {
                    var tops = parseFloat($(window).height()) + parseFloat($(window).scrollTop()) + 380; //380
                    var h = $(document).height();
                    //h = $(document.body).height()*page;
                    var w = tops - h;
                    if (IsNext && w >= 0) {
                        if (IsNext) page++;
                        foodlist(page);
                    }
                });
                foodlist(1);
            });
        }
    }
})
//滑动翻页 函数
//zb 从微信底部传入 做距离排序用
function foodlist(Page) {
    var str = "";
    var zb = $("#zuobiao").val();
    if(zb != "" && zb != 'undefined'){
        str = "&zb="+zb;//坐标
    }
    IsNext = false;
    $(".load_more").html("正在加载更多...").show(); //<span><img src=\"image/load.gif\"></span>
    var url = $(".view_list_box").data('url');
    url = url != undefined ? url : window.location.href;
    var url = url + "&ajax=1&p=" + Page + str + $(".list_parameter").val();
    $.ajax(
        { type: "post",
            dataType: "json",
            url: url ,
            data: {},
            async: true,
            timeout: 10000,
            success: function (msg) {
                var list = eval(msg);
                var foodtemp = "";
                if (list['list'].length != 0) {
                    var html = template('showlist',msg);
                    $(".view_list_box").append(html);
                    IsNext = true;
                    $(".load_more").hide();
                } else {
                    $(".load_more").html("无更多信息").show();
                    IsNext = false;
                }
            }, error: function(XMLHttpRequest, textStatus, errorThrown) {
            $(".load_more").html("读取数据超时，请刷新本页面").show();
        }
        });
}

