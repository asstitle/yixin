// JavaScript Document
/*
 name : 'number_change'	
 version : '1.0'
 author : 'maodashu'
 desc : '通用'
*/
; (function($){
	
	$.fn.extend({ 
		
		"number_change":function (options){
			var defalet = {
				init_val : 1, //初始值
				change_size : 1, // 更变大小
				ipt_text: '.text', // 文本框
				add_btn : '.add_btn', // 增加
				reduce_btn : '.reduce_btn', // 减少
				max_num : "", //最大值
				min_num : 1 //最小值
			};
			var option = $.extend(defalet,options);
			this.each(function(){
				var scope = $(this),
					ipt_text = $(option.ipt_text,scope),
					add_btn = $(option.add_btn,scope),
					reduce_btn = $(option.reduce_btn,scope);
				var numberobj ={
					"init" : function(){
						var _this = this;
						ipt_text.val(option.init_val);
						add_btn.click(function(){
							_this.add();
						})
						reduce_btn.click(function(){
							_this.reduce();
						})
						
					},
					"add" : function (){
						var val = parseInt(ipt_text.val());
						if(val < option.max_num || option.max_num == "" ){
							ipt_text.val(val + option.change_size);
							console.log(option.change_size);
						}
						 console.log(option.change_size);
					},
					"reduce" : function (){
						var val = parseInt(ipt_text.val());
						if(ipt_text.val() > option.min_num && option.min_num != null ) ipt_text.val(val - option.change_size);
					}
					
				};
				numberobj.init();

			});
			return this; // 返回当前对象，用于链式调用
			
		}
		
	});
	
})(jQuery)