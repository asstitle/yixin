$(function(){
    

	
	
   public_add(); 
   file_pic();
//-------------------------------------------------------------------------------注册  Start----------------------------------------------------------------------------    
   //勾选协议
   $(".main_agree").on('click',function(){
        if (this.checked) {
            $(this).siblings(".agree").val("ok");
        } else {
            $(this).siblings(".agree").val("");
        }
   });
   
   //商家类型
   $("input[name=radio-button]").on('click',function(){
        if (this.checked) {
            $(this).parents("form").find("input[name=seller_type]").val($(this).val());
        }
   });
    
   //时事验证账号
   $(".public_yz").bind('input propertychange', function(){
        var _this = $(this);
        var name = $(this).attr("name");
        var values = $(this).val(); 
        $.post("index.php?g=user&m=register&a=doAjax", {name:name, values:values} ,function(data){
            if (data.error) {	
				_this.siblings(".error").html(data.error);
				return false;
			}
            if (data.success) {
                _this.siblings(".error").html("");
            }
        },"json");
   });
   
   //增加商品类型
   $(".jylx_add").on('click',function(){
   		//alert(template('jylx_add'));
        $(this).parents("table").find(".jylx:last").after(template('jylx_add'));
        
        $(".jylx_delete").on('click',function(){
            $(this).parents("tr").remove();
        });
   });
   
   //商家手机号时事验证账号
   $(".public_mobile").bind('input propertychange', function(){
        var _this = $(this);
        var name = $(this).attr("name");
        var values = $(this).val(); 
        $.post("index.php?g=user&m=register&a=seller_mobile", {name:name, values:values} ,function(data){
            if (data.error) {	
				_this.siblings(".error").html(data.error);
				return false;
			}
            if (data.success) {
                _this.siblings(".error").html("");
            }
        },"json");
   });
//-------------------------------------------------------------------------------注册  End----------------------------------------------------------------------------  

  
//-------------------------------------------------------------------------------商品管理  Start----------------------------------------------------------------------------
    //店内分类显示
    $(".sale").on('click',function(){
        var parentid = $(this).data("parentid");
        var url = $(this).data("url");
        if (!parentid) {
            parentid = 0;
        }
        $.post(url,{parentid:parentid},function(data){
            $(".first_seller").remove();
            $(".seller_class").append(template('seller_class',data))
        },'json');
    });
    
    //搜索商品分类
    search_seller();
    function search_seller () {
        $(".search_seller").live('click',function(){
            if (!$(this).parents(".fl").hasClass("end")) {
                $(".classid").val("");
            }
            var _this = $(this);
            
            var value = _this.siblings(".value1").val();
            //var parent_id = _this.parents(".fl").find("ul").find("li:first").data("parent_id");
            var parent_id = $(".classid").val();
            var url = _this.siblings(".url").val();
            
            $.post(url,{value:value,parent_id:parent_id},function(data){
                _this.parents(".fl").find("ul").find("li").remove();
                _this.parents(".fl").nextAll(".fl").find("ul").find("li").remove();
                _this.parents(".fl").find("ul").append(template('goods_class',data));
                $(".goods_jg").html("");
                $(".radius_2").attr("href","javascript:;;");
            },'json');
        });
    }
    
    //选择下一级商品分类
    $(".list1").live('click',function(){
        var _this1 = $(this);
        var id = _this1.data("id");
        //如果还有下一级
        if (_this1.parents(".fl").next(".fl").size() > 0) {
            
            
            var url_next = $(".url_next").val();
            $.post(url_next,{id:id},function(data){
                _this1.parents(".fl").nextAll(".fl").find("ul").find("li").remove();
                _this1.parents(".fl").next(".fl").find("ul").append(template('goods_class',data));
                $(".goods_jg").html("");
                $(".radius_2").attr("href","javascript:;;");
                $(".classid").val(data['content'][0]['parent_id']);
                //修改自动点击
                if ($(".class_id_se").val() && $(".second").find("li").length > 0 && $(".three").find("li").length == 0) {
                    $(".second").find("li").each(function(){
                        if ($(this).data("id") == $(".class_id_se").val()) {
                            $(this).trigger('click');
                            $(".class_id_se").val("");
                        }
                    });
                }
                if ($(".class_id_th").val() && $(".three").find("li").length > 0) {
                    $(".three").find("li").each(function(){
                        if ($(this).data("id") == $(".class_id_th").val()) {
                            $(this).trigger('click');
                            $(".class_id_th").val("");
                        }
                    });
                }
                
                
            },'json');
        } else {
            var result_url = $(".result_url").val();
            $.post(result_url,{id:id},function(data){
                $(".goods_jg").html(data.result);
                if (!$(".id").val()) {
                    $(".radius_2").attr("href","index.php?g=Portal&m=Prostatus&a=add_goods&sellerid="+data.goods_id+"&first_id="+data.first_id);
                } else {
                    $(".radius_2").attr("href","index.php?g=Portal&m=Prostatus&a=edit_goods&sellerid="+data.goods_id+"&first_id="+data.first_id+"&goods_id="+$(".id").val());
                }
                
            },'json');
        }
    });
    
    //增加商品规格
    $(".goods_gg_add").live('click',function(){
        $(this).parents("table").find(".goods_gg:last").after(template('goods_gg'));
    });
    
    //删除商品规格
    $(".standard").on('click',".goods_gg_delete",function(){
        $(this).parents(".goods_gg").remove();
    });
    
    //商品属性输入框传值
    /**
     * $(".sattr_id").focus(function(){
     *         var value = $(this).data("value");
     *         $(this).bind('input propertychange',function(){
     *             $(this).siblings(".sattr_id_text").val(value+$(this).val());
     *         });
     *     });
     */
     
     //下移商品规格
     $(".add_next").live("click",function(){
        var _this = $(this);
        if ($(this).parents(".goods_gg").next(".goods_gg").size()>0) {
            var goods_gg = _this.parents(".goods_gg");
            $(this).parents(".goods_gg").next(".goods_gg").after(goods_gg);
        }
     });
     
     //上移商品规格
     $(".add_prev").live("click",function(){
        var _this = $(this);
        if ($(this).parents(".goods_gg").prev(".goods_gg").size()>0) {
            var goods_gg = _this.parents(".goods_gg");
            $(this).parents(".goods_gg").prev(".goods_gg").before(goods_gg);
        }
     });
     
     //清空当前图片
     $(".images_delete").live('click',function(){
        $(this).parents(".del").find(".img_url").val("");
        $(this).parents(".del").find(".images_show").attr("src",$(this).parents(".del").find(".images_show").data("src"));
        $(this).parents(".del").find(".images_show").data("id",1);
     });
    
     
     //选择运费模板
     $(".logistics").change(function(){
        var id = $(this).val();
        var url = $(this).data("url");
        logistics(url,id);
     });
     
     //取运费模板数据
     function logistics (url,id) {
        $.post(url,{id:id},function(data){
            $(".logisticsAdd").remove();
            if (data.shipping == 1) {
               $(".logisticsser").after(template("logisticsAdd",data)); 
            } else {
               $(".logisticsser").after(template("logisticsAdd2",data));  
            }
            //table切换
            $('#book').find(".book_top").find('li').hover(function(){
                var index = $(this).index();
                $('#book').find(".book_top").find('li.current').removeClass('current').end().find('li:eq('+index+')').addClass('current');
                $('#book').find('ul.book_foot:visible').hide().end().find('ul.book_foot:eq('+index+')').show();    
            },jQuery.noop)
        });
     }
     
     //提交审核
     $(".goods_status").on('click',function(){
        var url = $(this).data("url");
        
        post_url(url);
     });
     
     //批量上架
     $(".public_status").on('click',function(){
        var publicid = $(this).parents(".public_parents").find(".public_dx_check_sum").val();
        var url = $(this).data("url");
        if (!publicid) {
            layer.msg("请至少选择一项");
            return false;
        }
        post_url(url,publicid);
     });
     
     //批量下架
     $(".public_down_status").on('click',function(){
        var publicid = $(this).parents(".public_parents").find(".public_dx_check_sum").val();
        var url = $(this).data("url");
        if (!publicid) {
            layer.msg("请至少选择一项");
            return false;
        }
        post_url(url,publicid);
     });
     
     //批量店铺首页
     $(".public_seller_index").on('click',function(){
        var publicid = $(this).parents(".public_parents").find(".public_dx_check_sum").val();
        var url = $(this).data("url");
        if (!publicid) {
            layer.msg("请至少选择一项");
            return false;
        }
        post_url(url,publicid);
     });
     
     //批量到店铺分类
     $(".public_seller_type").on('click',function(){
        var publicid = $(this).parents(".public_parents").find(".public_dx_check_sum").val();
        var url = $(this).data("url");
        if (!publicid) {
            layer.msg("请至少选择一项");
            return false;
        }
        $(".b_black").show();
        
        $(".edit_goods").on('click',function(){
            var public_type = $(this).parents(".public_parents").find(".public_dx_check_sum").val();
            post_url(url,publicid,public_type);
        });
     });
//-------------------------------------------------------------------------------商品管理  End---------------------------------------------------------------------------- 

//-------------------------------------------------------------------------------商品详情  Start----------------------------------------------------------------------------
    //点击颜色加载对应的规格
    $(".spec_color").on('click',function(){
        var _this = $(this);
        //如果取消当前选中颜色
        if (_this.hasClass("on")) {
            $(".send_specid").val("");
            $(".spec_size").remove();
            _this.removeClass("on");
        } else {
            _this.addClass("on");
            _this.siblings("li").removeClass("on");
            _this.siblings(".on").removeClass("on");//手机端
            var url = _this.parents(".sys_spec_text").data("url");
            var value = _this.find("a").attr("title");
            if (!value) {
                value = _this.attr("title");
            }
            $.post(url,{value:value},function(data){
                $(".spec_size").remove();
                if (_this.parents("dl").size() == 0 ) {
                    _this.parents(".sys_spec_text").siblings(".sys_spec_text").find(".select_size").append(template('spec_size',data));//手机端
                } else {
                    _this.parents("dl").siblings("dl").find(".sys_spec_text").append(template('spec_size',data));
                }
            },'json');
        }
    });
    
    //点击尺码获取当前信息
    $(".spec_size").live('touchend',function(){
        var _this = $(this);
        //如果取消当前选中尺码
        if (_this.hasClass("on")) {
            $(".goods_price").html($(".goods_price").data("price"));
            $(".goods_store").html($(".goods_store").data("store"));
            $(".send_specid").val("");
            _this.removeClass("on");
        } else {
            _this.addClass("on");
            _this.siblings("li").removeClass("on");
            _this.siblings(".on").removeClass("on");//手机端
            var url = _this.parents(".sys_spec_text").data("url");
            var id = _this.data("id");
            $.post(url,{id:id},function(data){
                
                $(".goods_price").html(data.price);
                $(".goods_store").html(data.stock);
                $(".send_specid").val(data.id);
            },'json');
        }
    });
    
    //立即购买
    $(".now_buy").live('click',function(){
        var type = 2;
        var num = $(".num").val();
        is_kc(num,type,'',"pf");
    });
    
    //加入购物车
    $(".add_car").live('click',function(){
        var type = 3;
        var num = $(".num").val();
        is_kc(num,type,'',"pf");
    });
    
    //判断库存
    function is_kc (num,type,num_txt,pf) {
        if ($(".send_specid").size() > 0){
            var size_id = $(".send_specid").val();
            if (!size_id) {
                layer.msg("请选择"+$(".send_specid").data("spec_size"));
                return false;
            }
        }
        
        var goods_id = $(".goods_id").val();
        $.post("index.php?g=&m=Proview&a=kucun&goods_id="+goods_id,{num:num,type:type,size_id:size_id,pf:pf},function(data){
            if (data.error) {
                layer.msg(data.error);
                if (data.error_url) {
                    setTimeout(function(){
                        location.href=data.error_url;
                    }, 3000);
                }
                return false;
            }
            //立即提交
            if (type == 2 && data.url) {
                location.href=data.url;
            }
            //加入购物车
            if (type == 3) {
                $.post($(".add_car").data("url"),{num:num,size_id:size_id},function(data2){
                    if (data2.error) {	
        				layer.msg(data2.error);
        				return false;
        			}
        			if (data2.success) {
        				layer.msg(data2.success);
                        setTimeout(function(){
                            if (data.url) {
                                location.href=data2.url;
                            } else {
                                reloadPage(window);
                            }
                        }, 3000);
        			}
                }, 'json');
            }
        }, 'json');
    }
    
    //收藏商品
    $(".sc_goods").on('click',function(){
        post_url($(this).data("url"),$(".goods_id").val(),'',$(this),"sc_goods");
    });
    
    //收藏店铺
    $(".sc_shop").on('click',function(){
        post_url($(this).data("url"),$(".goods_id").val(),'',$(this),"sc_shop");
    });
    

//-------------------------------------------------------------------------------商品详情  End---------------------------------------------------------------------------- 



//-------------------------------------------------------------------------------其他  Start---------------------------------------------------------------------------- 

    //搜索结果页地址选择
    $(".area-list").find("li").live('click',function(){
        var address_search = $(".address_search").attr("title");
        
        //商品列表页
        if (address_search) {
            var url = $(".address_search").data("url");
            location.href = url+"&address="+address_search;
        }
        
        //商品详情页
        var address_search_fee = $(".address_search_fee").attr("title");
        if (address_search_fee) {
            var url = $(".address_search_fee").data("url");
            $.post(url,{address:address_search_fee},function(data){
                $(".express_template_select").remove();
                $(".list_first").after(template('express_template',data));
            },'json');
        }
    });
    
    //商品筛选多选
    $(".multi_select").live("click",function(){
        $(this).hide();
        var _this = $(this);
        //点击多选加载多选
        _this.siblings(".attr_value_now").removeClass("current2");
        _this.after(template("search_ready"));
        //勾选如果有值，则显示确定
        var attr_values = '';
        _this.parents(".brand_c").find(".attr_value_now").on('click',function(){
            
            _this.parents(".brand_c").find(".attr_value_now").each(function(){
                if (this.checked) {
                    attr_values += $(this).val()+',';
                }
            });
            attr_values = attr_values.substring(0,attr_values.length-1);
            _this.parents(".brand_c").find(".attr_values").val(attr_values);
            //如果有值显示确定按钮
            if (attr_values) {
                if (_this.next(".ready").find(".current2").size() > 0) {
                    _this.next(".ready").find(".send_post").removeClass("current2");
                }
            } else {
                _this.next(".ready").find(".send_post").addClass("current2");
            }
            
            attr_values = '';
        });
    });
    
    //点击取消
    $(".delete_form").live("click",function(){
        $(".multi_select").show();
        $(this).parents(".brand_c").find(".attr_value_now").addClass("current2");
        $(this).parents(".brand_c").find(".attr_values").val("");
        $(this).parents(".ready").remove();
    });
    
    //删除当前选中的属性
    $(".delete_dh").live('click',function(){
        var url = $(this).data("url");
        var id = $(this).data("id");
        location.href=url+"&delete_attrid="+id;
    });

//-------------------------------------------------------------------------------其他  End---------------------------------------------------------------------------- 


//-------------------------------------------------------------------------------购物流程  Start----------------------------------------------------------------------------  
    
    //提交购物车
    $("body").on('click',".send_car",function(){
        var ids = $(".public_dx_check_sum").val();
        if (!ids) {
            layer.msg("请至少选择一个！");
            return false;
        }
        var _this = $(this);
        $.post($(this).data("fref"), {id:1}, function(data){
            if (data.error) {
                layer.msg(data.error);
                setTimeout(function(){
                    if (data.error_url) {
                        location.href=data.error_url;
                    }
                }, 3000);
                return false;
            } else {
                var url = _this.data("url")+"&ids="+ids;
                location.href=url;
            }
        });
        
        
        
        
    });
    
    var op_pd = $(".op_pd").val();
    
    //购物车商品数量增加
    $(".add").on('click',function(){
        var _this = $(this);
        var num = parseInt(_this.siblings(".num").val())+1;
        var url = _this.data("url");
        var size_id = 0;
        if (op_pd) {
            url = _this.data("dcurl");
            size_id = $(".dc_size_id").val();
        }
        
        
        var fee = 0;
        
        $.post(url,{num:num,op_pd:op_pd,size_id:size_id},function(data){
            
            if (data.error) {	
				layer.msg(data.error);
				return false;
			}
			if (data.success) {
                _this.siblings(".num").val(num);
                
                
                if (data['seller_cx']['is_pf_price']) {
                    _this.parents(".parents_car").find(".size_prices").html(data['seller_cx']['is_pf_price']);
                    _this.parents(".parents_car").find(".size_price").val(data['seller_cx']['is_pf_price']);
                    
                    _this.parents(".parents_car").find(".sm_pf").html("(批发)");
                }
                
                newAll = 0;//总价格
                $(".car_xj").each(function(){
                    var size_price = parseFloat($(this).parents(".parents_car").find(".size_price").val());
                    var num = parseInt($(this).parents(".parents_car").find(".num").val());
                    if (!size_price) {
                        size_price = 0;
                    }
                    
                    if (!num) {
                        num = 0;
                    }
                    newAll += size_price*num;
                    $(this).html(size_price*num);
                });
                $(".newAll").html(newAll.toFixed(2));
                
                nowALL = nowALL-fee;
                newAll = newAll-fee;
                if ($(".nowALL").size() > 0) {
                    $(".nowALL").html((newAll).toFixed(2));//确认订单页面
                } else {
                    $(".newAll").html((newAll).toFixed(2));
                }
                
                //重新加载运费模板
                if ($(".Radio_value").size() > 0) {
                    //减去已经选择了的物流费用
                    var express = parseFloat($(".express").html());
                    $(".express").html("0.00");
                    
                    var Radio_value = $(".Radio_value").val();
                    js_mb(_this.parents(".parents_seller"),Radio_value);
                }
                
            }
        },'json');
    });
    
    //购物车数量减少
    $(".less").on('click',function(){
        var _this = $(this);
        var num = parseInt(_this.siblings(".num").val())-1;
        
        var fee = 0;
        if (num > 0) {
            $.post(_this.data("url"),{num:num,op_pd:op_pd},function(data){
                if (data.error) {	
    				layer.msg(data.error);
    				return false;
    			}
    			if (data.success) {
                    _this.siblings(".num").val(num);
                    
                    
                    newAll = 0;//总价格
                    $(".car_xj").each(function(){
                        var size_price = parseFloat($(this).parents(".parents_car").find(".size_price").val());
                        var num = parseInt($(this).parents(".parents_car").find(".num").html());
                        if (!size_price) {
                            size_price = 0;
                        }
                        
                        if (!num) {
                            num = 0;
                        }
                        newAll += size_price*num;
                        $(this).html(size_price*num);
                    });
                    $(".newAll").html(newAll.toFixed(2));
                    
                    //减少的时候如果当前如果有优惠
                    var nowALL = 0;//当前店铺费用总价
                    
                    if ($(".nowALL").size() > 0) {
                        $(".nowALL").html((newAll-fee).toFixed(2));//确认订单页面
                    } else {
                        $(".newAll").html((newAll-fee).toFixed(2));
                    }
                    
                    //重新加载运费模板
                    if ($(".Radio_value").size() > 0) {
                        //减去已经选择了的物流费用
                        var express = parseFloat($(".express").html());
                        $(".express").html("0.00");
                        
                        var Radio_value = $(".Radio_value").val();
                        js_mb(_this.parents(".parents_seller"),Radio_value);
                    }
                }
            },'json');
        }
    });
    
    //点击编辑
    $(".edit_address").live('click',function(){
        $.post($(this).data("url"),{id:$(this).data("id")},function(data){
            //input传值
            $("input[name=name]").val(data.name);
            $("input[name=address]").val(data.address);
            $("input[name=zip]").val(data.zip);
            $("input[name=mobile]").val(data.mobile);
            $("input[name=tel]").val(data.tel);
            $("input[name=address_id]").val(data.id);
            
            var zone = data.zone.split(" ");
            _init_area(zone[0],zone[1],zone[2]);
            
        });
    });
    
    //确认订单添加编辑收货地址
    $(".order_address_post").live('click',function(){
        var _form = $(this).parents("form");
        
        if (!Validator.Validate(document.forms[_form.attr("name")],2)) {
			return false;
		}
        $.post(_form.prop("action"), _form.serialize(), function(data){
				if (data.error) {	
					layer.msg(data.error);
					return false;
				}
				if (data.success) {
                    $(".wares-popup").hide();
					if (data.content) {
					   $(".parents_address").remove();
                       $(".brs").after(template('address',data));
                       $(".Radio_value").val(data.default_id);//默认地址
                       
                       //清空表单
                       $(".is_default").attr("checked",false);
                       $(".delete_null").val("");
                       
                       //处理省市区
                       $("#s_province option:first").attr("selected","selected");
                       
                       $("#s_city option:first").attr("selected","selected");
                       $("#s_city option:first").nextAll("option").remove();
                       
                       $("#s_county option:first").attr("selected","selected");
                       $("#s_county option:first").nextAll("option").remove();
					}
				}
			},"json");
		return false; //防止表格submit类型按钮提交表单
    });
    
    //选择运送方式
    $(".xz_wl").on('change',function(){
        var yester = parseFloat($(".express").html());
        var express = 0.00;
        $(".xz_wl").each(function(){
            var newArray = $(this).val().split("@");
            if (newArray[1]) {
                express += parseFloat(newArray[1]);
            }
        });
        $(".express").html(express.toFixed(2));
        $(".nowALL").html((parseFloat($(".nowALL").html())+express-yester).toFixed(2));
    });
    
    //提交订单
    $(".order_post").on('click',function(){
        var _this = $(this);
        /*
        var Radio_value = $(".Radio_value").val();
        if (Radio_value!=0) {
            $(".address_id").val(Radio_value);//传递地址ID
        }
        
        var buy_id = $(".buy_id").val();
        if (buy_id!=0) {
            $(".buyfs").val(buy_id);//传递支付方式ID
        }
        
        
        $(".num").each(function(){
            $(this).siblings(".nums_now").val($(this).html());
        });
        */
        var _form = $(this).parents("form");
        if (!Validator.Validate(document.forms[_form.attr("name")],2)) {
			return false;
		}
        $.post(_form.prop("action"), _form.serialize(), function(data){
				if (data.error) {	
					layer.msg(data.error);
                    $(".verify_img").trigger('click');
					return false;
				}
				if (data.success) {
					layer.msg(data.success);
                    _this.prop("type","button");
                    _this.removeClass("order_post");
                    _this.hide();
                    
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }
                    }, 3000);
				}
			},"json");
		return false; //防止表格submit类型按钮提交表单
        
    });
    

//-------------------------------------------------------------------------------购物流程  End---------------------------------------------------------------------------- 
    
    
    
//-------------------------------------------------------------------------------Public  Start----------------------------------------------------------------------------  
    //调用计算运费方法
    function js_mb (_this,Radio_value) {
        var goods_idString = '';
        var numsString = '';
        var template_url = $(".template_url").val();
        
        //循环取出当前店铺内的商品ID以及数量
        _this.find(".goods_id").each(function(){
            if ($(this).val()) {
                goods_idString += parseInt($(this).val())+',';
                numsString += parseInt($(this).parents(".parents_car").find(".num").html())+',';
            }
        });
        goods_idString = goods_idString.substring(0,goods_idString.length-1);
        numsString = numsString.substring(0,numsString.length-1);
        $.post(template_url,{Radio_value:Radio_value,goods_idString:goods_idString,numsString:numsString},function(data){
            _this.find(".xz_wl").find("option").remove();
            _this.find(".xz_wl").append(template('express_template',data));
            
        });
    } 
    
    
    //提交
    function post_url (url,publicid,public_type,_this,_this_v) {
        
        $.post(url,{publicid:publicid, public_type:public_type},function(data){
            if (data.error) {	
				layer.msg(data.error);
				return false;
			}
			if (data.success) {
				layer.msg(data.success);
                _this.prop("type","button");
                _this.removeClass(_this_v);
                setTimeout(function(){
                    if (data.url) {
                        location.href=data.url;
                    } else {
                        reloadPage(window);
                    }
                }, 3000);
			}
        }, 'json');
        return false;
    }
    
    
    //设置单选
    $(".Radio").on('click',function(){
        if (this.checked) {
            $(this).parents(".public_Radio").find(".Radio_value").val($(this).val());
            $(this).siblings(".Radio").attr("checked",false);
            
            if ($(".is_default").size() > 0) {
                $(".is_default").attr("checked",false);
                $(".is_default").val(0);
            }
        }
    });
    
    
    //设置多选
   $(".public_dx_check").on('click',function(){
        choose_send_values($(this));
   });
   
   //设置全选
   $(".allcheck").click(function(){
        if(this.checked) {
            $(this).parents(".public_parents").find(".public_dx_check").attr("checked", true);
            choose_send_values($(this));
        }
        else{
            $(this).parents(".public_parents").find(".public_dx_check").attr("checked", false);
            choose_send_values($(this));
        }
    });
    
    //选择传值
    function choose_send_values (_this) {
        var public_dx_check_sum = '';
        _this.parents(".public_parents").find(".public_dx_check").each(function(){
            if (this.checked) {
                public_dx_check_sum += $(this).val()+',';
            }
        });
        public_dx_check_sum = public_dx_check_sum.substring(0,public_dx_check_sum.length-1);
        _this.parents(".public_parents").find(".public_dx_check_sum").val(public_dx_check_sum);
        
        if ($(".shop_id").size() > 0) {
            $(".shop_id").val(public_dx_check_sum);
        }
    }
    
    
    //判断on显示隐藏
    $(".subside-mod").find(".title").on('click',function(){
        var _this = $(this).parents("dl");
        if (_this.hasClass("on")) {
            _this.removeClass("on");
        } else {
            _this.addClass("on");
            _this.siblings("dl").removeClass("on");
        }
    })
      
    //上传图片
    function file_pic () {
        $("body").on('change',".file_box",function(){
            var _this = $(this);
            if (!_this.parents("form:first").hasClass("myupload")) {
                _this.wrap("<form action='index.php?g=Asset&m=asset&a=swfupload' class='myupload' method='post' enctype='multipart/form-data'></form>");
            }
            _this.parents(".myupload").ajaxSubmit({
    			success: function(data) {
    			     data_arr = data.split(',');
    			     
                     if (_this.parents(".del").find(".images_show").size()>0) {
                        _this.parents(".del").find(".img_url").val(data_arr[1]);
                        var src = _this.parents(".del").find(".images_show").attr("src");
                        
                        _this.parents(".del").find(".images_show").data("src",src);
                        _this.parents(".del").find(".images_show").attr("src",data_arr[1]);
                        _this.parents(".del").find(".images_show").data("id",2);
                     } else {
                        _this.parents("td").find(".img_url").val(data_arr[1]);
                     }
                     
                     $(this).resetForm();
    			},
    		});
             return false; // 阻止表单自动提交事件
        });
   }
    
    
    //公共提交表单
   function public_add () {
        $(".add_post").on('click', function(){
            var _this = $(this);
            var _form = $(this).parents("form");
            if (!Validator.Validate(document.forms[_form.attr("name")],2)) {
                $(".verify_img").trigger('click');
    			return false;
    		}
            $.post(_form.prop("action"), _form.serialize(), function(data){
    				if (data.error) {	
    					layer.msg(data.error);
                        $(".verify_img").trigger('click');
    					return false;
    				}
    				if (data.success) {
    					layer.msg(data.success);
                        _this.prop("type","button");
                        _this.removeClass("add_post");
                        setTimeout(function(){
                            if (data.url) {
                                location.href=data.url;
                            }
                        }, 3000);
    				}
    			},"json");
    		return false; //防止表格submit类型按钮提交表单
       });
   }
   
   
   //A链接不跳转执行操作
   $(".public_a").on('click',function(){
        var url = $(this).attr("href");
        $.post(url,{key:1},function(data){
            if (data.error) {
                layer.msg(data.error);
            }
            if (data.success) {
                layer.msg(data.success);
                setTimeout(function(){
                    if (data.url) {
                        location.href=data.url;
                    }
                }, 3000);
            }
        });
        return false;
   });

   //计算各单次费用总计
   $(".public_xf").focus(function(){
        $(this).bind('input propertychange',function(){
            var _this = $(this).parents("tr");
            public_all(_this);
        });
   });
   $(".public_wf").focus(function(){
        $(this).bind('input propertychange',function(){
            var _this = $(this).parents("tr");
            public_all(_this);
        });
   });
   //获取当前总费用
   function public_all (_this) {
        var public_xf = parseInt(_this.find(".public_xf").val());
        var public_wf = parseInt(_this.find(".public_wf").val());
        if (!public_xf) {
            public_xf = 0;
        }
        if (!public_wf) {
            public_wf = 0;
        }
        _this.find(".public_all").val(public_xf+public_wf);
   }
   
   
   //日期选择器
    var dateInput = $("input.J_date");
    if (dateInput.length) {
        Wind.use('datePicker', function () {
            dateInput.datePicker();
        });
    }
    //日期+时间选择器
    
    var dateTimeInput = $("input.J_datetime");
    if (dateTimeInput.length) {
        Wind.use('datePicker', function () {
            dateTimeInput.datePicker({
                time: true
            });
        });
    }
   
   //iframe页面f5刷新
    $(document).on('keydown', function (event) {
        var e = window.event || event;
        if (e.keyCode == 116) {
            e.keyCode = 0;

            var $doc = $(parent.window.document),
                id = $doc.find('#B_history .current').attr('data-id'),
                iframe = $doc.find('#iframe_' + id);
            try{
                if (iframe[0].contentWindow) {
                    //common.js
                    reloadPage(iframe[0].contentWindow);
                }
            }catch(err){}
            //!ie
            return false;
        }

    });
   
   //选中删除
   $(".public_delect").on('click',function(){
        var publicid = $(".public_dx_check_sum").val();
        var delete_url = $("input[name=delete_url]").val();

        if (!publicid) {
            layer.msg("请至少选择一项");
            return false;
        }
        post_url(delete_url,publicid);
   });
   
   //a标签ajax提交
   $(".public_okno").on('click', function(){
        var url = $(this).data("href");

        $.post(url, {okno:1}, function(data){
            if (data.error) {	
				layer.msg(data.error);
				return false;
			}
			if (data.success) {
				layer.msg(data.success);
                setTimeout(function(){
                    if (data.url) {
                        location.href=data.url;
                    }
                }, 3000);
			}
        }, 'json');
   });
   
   function dray (_this) {
        //可拖拽实现
       var _move=false;//移动标记  
       var _x,_y,_thiss;//鼠标离控件左上角的相对位置  
       _this.find(".drag").mousedown(function(e){ 
           _thiss = $(this).parents(".hide_customer");
            
           _move=true;  
           _x=e.pageX-parseInt(_thiss.css("left"));  
           _y=e.pageY-parseInt(_thiss.css("top"));  
           _thiss.fadeTo(20, 0.5);//点击后开始拖动并透明显示  
       });  
       $(document).mousemove(function(e){  
           if(_move){  
           var x=e.pageX-_x;//移动时根据鼠标位置计算控件左上角的绝对位置  
           var y=e.pageY-_y;  
           _thiss.css({top:y,left:x});//控件新位置  
           }  
       }).mouseup(function(){  
           _move=false;  
           _thiss.fadeTo(20, 1);//松开鼠标后停止移动并恢复成不透明  
       });
   }
   
   //所有的删除操作，删除数据后刷新页面
    if ($('a.J_ajax_del').length) {
        Wind.use('artDialog', function () {
            $('.J_ajax_del').on('click', function (e) {
                e.preventDefault();
                var $_this = this,
                    $this = $($_this),
                    href = $this.prop('href'),
                    msg = $this.data('msg');
                art.dialog({
                    title: false,
                    icon: 'question',
                    content: '确定要删除吗？',
                    follow: $_this,
                    close: function () {
                        $_this.focus();; //关闭时让触发弹窗的元素获取焦点
                        return true;
                    },
                    ok: function () {
                        $.getJSON(href).done(function (data) {
							
                            if (data.state === 'success') {
                                if (data.referer) {
                                    location.href = data.referer;
                                } else {
                                    reloadPage(window);
                                }
                            } else if (data.state === 'fail') {
                                //art.dialog.alert(data.info);
                            	alert(data.info);//暂时处理方案
                            }
                        });
                    },
                    cancelVal: '关闭',
                    cancel: true
                });
            });

        });
    } 
    
    //重新刷新页面，使用location.reload()有可能导致重新提交
    function reloadPage(win) {
        var location = win.location;
        location.href = location.pathname + location.search;
    }
    

});


//////--------------------------------------
!(function($){ 
	$.fn.set_imgsize = function(options){
        var opt = {
			chil_img :''	
		}
		var o = $.extend(opt, options);
        return this.each(function(){ 
        	var space = $(this), child_img = $(o.chil_img,space);
        	var obj = { 
        		init : function(){ 
        			_this = this;
        			space.css({"position":"relative",'text-align':'center'});
        			_this.load_img(child_img[0]['src']);
                    
        		},
        		load_img : function(src){ 
        			var img = new Image();
        			img.src = src;
					var check = function(){
					    if(img.width>0 || img.height>0 || img.complete){
							clearInterval(set);
							_this.load_size(img.height,img.width);
                            var height = img.height;
                            var width = img.width;
                            imgbox_h = space.height();
                            imgbox_w = space.width();                                                    
                            var mar_top = (imgbox_h-height)/2;                                             
                            if(height > imgbox_h || width > imgbox_w){                                     
                                height = (imgbox_w/width)*height;                                          
                                width = imgbox_w;                                                          
                                mar_top = (imgbox_h-height)/2;                                             
                                if(height > imgbox_h){                                                     
                                    width = (imgbox_h/height)*width;                                       
                                    height = imgbox_h;                                                     
                                    mar_top = 0;                                                           
                                }                                                                     
                            }                                                                 
                            child_img.css({'width':width+"px",'height':height+"px",'margin-top':mar_top+'px'}); 
					    }
					};
                    //child_img.css('height','10px');
					var set = setInterval(check,40);
                    
                    
        		},
        		load_size : function(height,width){
                      
        		}                    
        	}                       
                                 
        	obj.init();             
        })                       
    }                            
}(jQuery))                       
                                 
                                 
                                 
                                 
                                 

