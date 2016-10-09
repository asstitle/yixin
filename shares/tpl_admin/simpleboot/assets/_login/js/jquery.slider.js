// JavaScript Document
/*
 name : 'slider'	
 version : '1.0'
 author : 'maodashu'
 desc : '图片淡入淡出切换'
*/
; (function($){
	
	$.fn.extend({ 
		"slider" : function (options){
			var opt = {
				loop_time : '3000', // 切换间隔时间 默认3000毫秒一次
				speed : '300', // 切换速度 默认500毫秒
				img_dom : '.img', // 切换图片指定节点 默认指定class＝"img"
				btn_dom : '.btn', // 切换按钮指定节点 默认指定class＝"btn"
				btn_class : 'on' // 按钮变化class  默认指定class＝"on"
				
			}
			var opts = $.extend(opt, options); // 用于调用时输入的参数覆盖默认参数
			//console.log(this);
			this.each(function(){
				var scope = $(this),
					img = $(opts.img_dom,scope),
					btn = $(opts.btn_dom,scope),
					img_length = $(opts.img_dom,scope).length,
					is_add = false,
					i = 0;
				var sliderobj = {
					"init" : function(){
						var _this = this;
						btn.hover(function (){
							// 清除定时器
							clearInterval(_this.setinterval);
							delete _this.setinterval;
							is_add = false;
							var a = $(this).index();
							_this.loop(a);
						},function(){
							is_add = true;
							// 重设定时器
							_this.setinterval = setInterval (function (){_this.loop()},opts.loop_time);
						})
						this.showpic(); 
						is_add = true;
						this.setinterval = setInterval (function (){_this.loop()},opts.loop_time); // 设置定时器，间隔时间为loop_time
					},
					"loop" : function (index){ 
						if(is_add && opts.loop_time != 0){
							i = ++i % img_length;
						}else{
							i = index;
						}
						img.eq(i).fadeIn(opts.speed).siblings(opts.img_dom).fadeOut(opts.speed);
						btn.eq(i).addClass(opts.btn_class).siblings(opts.btn_dom).removeClass(opts.btn_class);
					},
					"showpic" : function (){
						this.loop(0);
					}
					
				}
				sliderobj.init();
			})
			//console.log(this);
			return this; // 返回当前对象，用于链式调用
		}
	});
	
})(jQuery)