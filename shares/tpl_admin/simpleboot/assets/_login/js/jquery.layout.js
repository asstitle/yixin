// JavaScript Document
/*
 name : 'layout'	
 version : '1.0'
 author : 'maodashu'
 desc : '通用'
*/
; (function($){
	
	$.fn.extend({ 
		"toggle_class" : function (options){
			var defalet = {
				list : '', //子节点
				tle_class : 'on', // 更变class
				trigger_way : 'click' //更变方法 click , mouseover ;
				
			};
			var option = $.extend(defalet,options);
			if ( option.list == "" ) return this;
			this.each(function(){
				var scope = $(this),
					scope_list = $(option.list,scope);
				switch(option.trigger_way){
					case "click":
					scope_list.click(function(){ 
						$(this).addClass(option.tle_class).siblings(option.sli_class).removeClass(option.tle_class);
					});
					break;
					case "mouseover":
					scope_list.mouseover(function(){ 
						$(this).addClass(option.tle_class).siblings(option.sli_class).removeClass(option.tle_class);
					});
					break;
				}

			});
			
			//console.log(this);
			return this; // 返回当前对象，用于链式调用
		},
		"slide" : function (options){
			var defalet = {
				slide_time : '3000', //滚动间隔时间
				slide_speed : '300', //滚动执行时间
				img_box : '.img_box', //包裹img的class
				par_box : '.par_box', //最外层，控制大小
				btn : '.btn', //按钮
				btn_class : 'on' //当前按钮class
			};
			var option = $.extend(defalet,options);
			
			this.each(function(){
				var scope = $(this),
					img_box = $(option.img_box,scope),
					img_length = img_box.find('img').length,
					btn = $(option.btn,scope),
					img = img_box.find('img'),
					par_box = $(option.par_box,scope),
					i = 0;
				
				var slideobj = {
					"init" : function (){
						var _this = this;
						par_box.css({overflow:"hidden"});
						img_box.css({width:par_box.width()*img_length, height:par_box.height()});
						console.log(img_box)
						//img.css({width:par_box.width(),height:par_box.height(),display:"inline",display:"inline-table",zoom:"1"});
						img.css({width:par_box.width(),height:par_box.height(),float:"left"});
						
						btn.hover(function(){
							_this.clear_time();
							i = $(this).index();
							_this.roll();
						},function(){
							_this.set_time();
						});
						par_box.hover(function(){_this.clear_time();},function(){_this.set_time();});
						this.roll();
						this.set_time();
					},
					"roll" : function (){
						img_box.stop().animate({marginLeft:-i*par_box.width()},option.slide_speed);
						btn.eq(i).addClass(option.btn_class).siblings(option.btn).removeClass(option.btn_class);
					},
					"show_time" : function (){
						i = ++i % img_length;
						this.roll();
					},
					"set_time" : function(){
						var _this = this;
						this.timeobj = setInterval(function(){_this.show_time()},option.slide_time);
					},
					"clear_time" : function(){
						clearInterval(this.timeobj);
						delete this.timeobj;
					}
				};
				slideobj.init();
				
			});
			
			//console.log(this);
			return this; // 返回当前对象，用于链式调用
		}
		
	});
	
})(jQuery)