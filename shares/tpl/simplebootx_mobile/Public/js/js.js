// JavaScript Document

$(function(){

	$('.l_check input.iCheck').iCheck({
		checkboxClass: 'iradio_square-red',
		increaseArea: '5%'
	});
	$('.ps_fun input.iCheck,.recheange_select input.iCheck,.addres_list ._tle input.iCheck').iCheck({
		radioClass: 'iradio_square-red',
		increaseArea: '5%'
	});
	$('.reg input.iCheck').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
	});
	$('.ps_fun input.iCheck').on('ifChanged',function(){

	})

	var swiper = new Swiper('.swiper-container', {
		pagination: '.swiper-pagination',
        autoplay:3000,
        speed : 500
	});

	$(window).on('scroll',function(){
		if($(window).scrollTop() > ($('.beaner').height() - 40)) add_top();
		else remove_top();
	})
	function add_top(){
		$('header > div').addClass('on');
	}
	function remove_top(){
		$('header > div').removeClass('on');
	}

	var t1=new TouchScroll({id:'class_l','width':0,'opacity':0.5,color:'#666',minLength:100});
	var t2=new TouchScroll({id:'class_r','width':3,'opacity':0.6,color:'#555',minLength:100});
	/*
	$('.class_l li').on('touchstart',function(){ 
		$(this).addClass('on').siblings().removeClass('on')
		$('.class_r li').eq($(this).index()).addClass('on').siblings().removeClass('on')
	})
	*/
	$('.class_l li').on('click',function(){ 
		$(this).addClass('on').siblings().removeClass('on')
		$('.class_r li').eq($(this).index()).addClass('on').siblings().removeClass('on')
	})
	$('.car_top .car_menu').on('touchstart',function(){ 
		
		$('.car_nav').stop(true).slideToggle("300");
	})

	var c=document.getElementById("back");
	if(c){
		var ctx=c.getContext("2d");
		var ctx_width =c.width;
		var ctx_height =c.height;
		//var grd=ctx.createRadialGradient(ctx_width*0.2,ctx_height*0.2,(ctx_width*ctx_width + ctx_height*ctx_height)/2,90,60,100);
		var grd=ctx.createRadialGradient(0,ctx_height,1,ctx_width*0.5,ctx_height*0.5,ctx_width);
		grd.addColorStop(0,"#f2302e");
		grd.addColorStop(1,"#f3927d");
		ctx.fillStyle=grd;
		ctx.fillRect(0,0,ctx_width,ctx_height);
	}
	function class_top(){
		var	set_select;
		var pop = { 
			Index : 0,
			_top : $('.class_top').offset().top + $('.class_top').height(),
			_height : $(window).height() - ($('.class_top').offset().top + $('.class_top').height()),
			init : function(){
				$('.pop').css({'height':this._height+'px','margin-top':this._top+'px'});
				this.out();
			},
			show : function(_index){
				this.Index = _index;
					this.creat_Swiper($('.pop .box').eq(_index).find('.swiper-container1'),$('.pop .box').eq(_index).find('.swiper-container1').find('.swiper-scrollbar'));

				$('.pop').fadeIn(100);
				$('html').css({'overflow':'hidden'});
				this.hide($('.pop .box').eq(_index).siblings('.box'));
				$('.pop .box').eq(_index).animate({top:0},300);

			},
			hide : function(dom,fun,out_time){ 
				var _this = this;
				var dom = typeof dom == 'undefined' ? $('.pop .box') : dom;
				var out_time = typeof out_time == 'undefined' ? 0 : out_time;
				dom.each(function(){
					$(this).animate({top:-$(window).height()/2},out_time,fun);
				})
			},
			out : function(time){ 
				$('html').css({'overflow':'auto'});
				this.hide($('.pop .box'),function(){
					$('.pop').fadeOut(100)
				},time);
				this.remove_swiper()
			},
			creat_Swiper : function(swiper_container,swiper_scrollbar){
			 set_select = new Swiper(swiper_container, {
			 scrollbar: swiper_scrollbar,
			 direction: 'vertical',
			 slidesPerView: 'auto',
			 mousewheelControl: true,
			 freeMode: true,
			 watchSlidesProgress : true,
			 setWrapperSize :true,
			 observer:true,
			 observeParents:true
			 });
				console.log(set_select);
			 },
			remove_swiper : function (){ 
				//set_select.destroy();
			}

		}
		pop.init();

		$('.pop .box ul li').click(function(){ 
			//console.log(pop.Index);
			//console.log($('.class_top .item em').eq(pop.Index).html());
			//console.log($(this).html());
			//$('.class_top .item em').eq(pop.Index).html($(this).html());
		})
		$('.class_top .item').click(function(){ 
			pop.show($(this).index());
		})
		$('.pop .box > ul._list1 li,.pop .box.saix .botm_btn em.submit').click(function(){ 
			pop.out(300);
		})

		$('.pop').click(function(event){ 
			var _this = $(this);
			if($(event.target).hasClass('pop')){ 
				pop.out(300);
			}
		})
		$('.pop .box').each(function(_index){ 
			//$(this).hasClass('now_on') ? $('.class_top .item em').eq(pop.Index).html($(this).children('a').html() || $(this).html()) : '';
			//console.log(_index,$(this).children('li.now_on').html())
			$('.class_top .item').eq(_index).children('em').html($(this).find('li.now_on a').html())
			
		})
		$('.addres_pre li').click(function(){ 
			$('.pop .box .addres > div ul.add2 .addres_child').eq($(this).index()).show().siblings().hide();
		})
	}
	if($('.class_top').size()) class_top();

	$('.sys').click(function(){ 
		$('.sys_img').fadeIn(300);
		$('.sys_img').click(function(){ 
			$(this).fadeOut(300);
		})
	})


	var swiper3 = new Swiper('._list1', {
		scrollbar: '.swiper-scrollbar',
		direction: 'vertical',
		slidesPerView: 'auto',
		mousewheelControl: true,
		freeMode: true,
		// watchSlidesProgress : true,

	});
	console.log(swiper3);


	var swiper1,swiper2

	swiper2 = new Swiper('.addres ul.add2', {
        scrollbar: '.swiper-scrollbar2',
        direction: 'vertical',
        slidesPerView: 'auto',
        mousewheelControl: true,
        freeMode: true
    });
    //console.log(dsy);
    //console.log();
	if($(".addres_pre").length > 0 ) {
		$('.addres_pre').append("<li>所有省份</li>");
		var o = dsy['Items']['0'];
		$.each(o, function (i, n) {
			if (i == o.length - 1 || i == o.length - 2 || i == o.length - 3) return;
			$('.addres_pre').append("<li data-index='" + i + "'>" + n + "</li>");
		})
	}


	swiper1 = new Swiper('.addres ul.add1', {
		scrollbar: '.swiper-scrollbar1',
		direction: 'vertical',
		slidesPerView: 'auto',
		mousewheelControl: true,
		freeMode: true
	});
	$('.addres_pre li').click(function(){

		if(!$(this).data('index') && $(this).data('index')!=0){
			window.location.href = $("#address").val() + "所有省份";
			return ;
		}
		swiper2.destroy(false);
		$('.addres_child').children().remove();
		$('.addres_child').append("<li>所有城市</li>");
		var i = $(this).data('index');
		$.each(dsy['Items']['0_'+i],function(i, n){
			$('.addres_child').append("<li>"+n+"</li>")
		})

		/*
		$.each(provinceList[i],function(i, n){
			if(typeof n == 'object'){
				if(n.length > 1){
					$.each(n,function(i, n){
						$('.addres_child').append("<li>"+n.name+"</li>")
					})
				}else{
					$('.addres_child').append("<li>"+n[0].name+"</li>")
				}

			}
		})
		*/

		swiper2 = new Swiper('.addres ul.add2', {
	        scrollbar: '.swiper-scrollbar2',
	        direction: 'vertical',
	        slidesPerView: 'auto',
	        mousewheelControl: true,
	        freeMode: true
	    });
		$('.addres_child li').click(function(){
			var sheng = dsy['Items']['0'][i];
			var shi = "";
			if($(this).html()=="所有城市"){
				shi = "";
			}else{
				shi = "-" + $(this).html();
			}
			var chengs = sheng + shi;
			var url = $("#address").val() + chengs;
			window.location.href = url;
		})

	})

	//搜索框
	$('.search i').click(function(e){
		$('.search').addClass('on');
		$('.search input[type=text]').blur(function(){
			$('.search').removeClass('on');
		});
	})


//微信
	$(".back_000").click(function(){$(this).hide();})
	$(".share .friend_btn").click(function(){$(".back_000").show();})

	$(function(){
		if($(".back").length>0){
			$(".back").attr("href","javascript:window.history.go(-1)");
		}
	})
});