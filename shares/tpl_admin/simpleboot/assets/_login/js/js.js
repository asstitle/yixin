// JavaScript Document

$(function(){
    
    var sousuo_u = $(".sousuo_u").val();
	//alert($.browser.version);
	//if($.browser.version != 7.0 && $.browser.version != 8.0 && !$.browser.mozilla){
	$(".custom_box ._top td:even").css("text-align","right");
	//}
	$(window).scroll(function(){
		var scrol=$(window).scrollTop();
		right_navstop(scrol);
	})
	//设置到达底部停止
	function right_navstop(_scrol){
		var doc_hei = $(document).height(),win_hei = $(window).height(),obj;
		obj= doc_hei - win_hei - 320
		if(_scrol > obj){
			$(".right_nav").css("bottom",_scrol - obj);
		}
	}
	//右侧导航设置到left值
	if($(".right_nav").length > 0) $(".right_nav").css({marginLeft:$(".right_nav").data("left")});
	
	$("input").each(function(){
		if($(this).data("width")) $(this).css({width:$(this).data("width")});
	})
	//返回顶部
	function scrollTop(){
		$("html,body").stop().animate({scrollTop: "0px"},500);
	}
	$(".footer .right .top_btn").click(function(){
		scrollTop();
	})
	$(".right_nav .box.top").click(function(){
		scrollTop();
	})
	
	//pop弹出框top距离
	if($(".pop_box .cont").length > 0){
		$(".pop_box .cont").each(function(){
			$(this).css("margin-top",-$(this).outerHeight(true)/2);
		})
	}
	//pop关闭
	$(".pop_box .cont .clear_btn").click(function(){
		$(this).parents(".pop_box").hide();
	})
	//商品详情图片src切换
	$(".goods_top .show_listimg li").click(function(){
		$(this).addClass("on").siblings().removeClass("on");
		$(".goods_top .show_img img").attr("src",$(this).find("img").attr("src"));
	})
	
	//首页cont
	$(".cont_box").hover(function(){
		var _this = $(this);
		_this.css({background:"#"+$(this).data("back")});
		_this.addClass("on");
		var img_src = _this.find(".img").attr("src");
		_this.find(".img").attr("src",$(this).find(".img").data("src"));
		_this.find(".img").data("src",img_src);
	},function(){
		var _this = $(this);
		_this.css({background:"#f5f5f5"});
		_this.removeClass("on");
		var img_src = _this.find(".img").attr("src");
		_this.find(".img").attr("src",$(this).find(".img").data("src"));
		_this.find(".img").data("src",img_src);
	})
	
	//自定义下拉
	$(".select_box .icon-caret-down").click(function(){
		$(this).siblings("ul").slideToggle(50);
	})
	$(".select_box ul li").click(function(){
		$(this).parent().siblings("p").html($(this).html());
		$(this).parent().siblings("input").val($(this).data("id"));
		$(this).parent().slideToggle(50);
	})
	
	//添加表格
	$(".pers_table h3 .add").click(function(){
		var _html =$(this).parent().siblings("table").find("tr:eq(1)").html();
		$(this).parent().siblings("table").append("<tr>"+_html+"</tr>");
	})
    
    
    //搜索判断
    if ($(".top_cearch div").data("id")==1) {
        $(".top_cearch div").parent("form").attr("action",sousuo_u+"/index.php?g=Portal&m=Iproduct&a=index&id=17");
    } else {
        $(".top_cearch div").parent("form").attr("action",sousuo_u+"/index.php?g=Portal&m=Iplan&a=index&id=17");
    }
    
	$(".top_cearch div").click(function(){
		var _html = $(this).html();
        var id = $(this).data("id");
        
        $(this).data("id", $(this).data("id2"));
        $(this).data("id2", id);
		$(this).html($(this).data("text"));
		$(this).data("text",_html);
        

        if ($(this).data("id")==1) {
            $(this).parent("form").attr("action",sousuo_u+"/index.php?g=Portal&m=Iproduct&a=index&id=17");
        } else {
            $(this).parent("form").attr("action",sousuo_u+"/index.php?g=Portal&m=Iplan&a=index&id=17");
        }

	})
    //列表获取更多
    if ($(".list_screened .lists").find("span").hasClass("on")) {
        $(".list_screened .lists .on").each(function(){
            if ($(this).data("id") > 7) {
                $(this).parent(".lists").addClass('on');
                $(this).parents(".cont").next(".more").val("收起");
            } 
        });
    }
   
    $(".list_screened .more").click(function(){
        //var _this = $(this);
        if (!$(this).siblings('.cont').children('.lists').hasClass("on")) {
            $(this).siblings('.cont').children('.lists').addClass('on');
            $(this).siblings('.cont').next(".more").val("收起");
        } else {
            $(this).siblings('.cont').children('.lists').removeClass('on');
            $(this).siblings('.cont').next(".more").val("更多");
        }
    });	
});

























