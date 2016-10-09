$(function(){

    //管理员登录
    $(".login_post").on('click', function(){
        
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
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }
                    }, 3000);
				}
			},"json");
		return false; //防止表格submit类型按钮提交表单
   });
   
   //切换
   $('.itab').find('ul').find('li').find('a').on('click',function(){
        
        var index = $(this).parent('li').index();
        if (index == 0) {
            $(".add").html("添加角色");
        }
        $('.itab').find('ul').find('li>a.selected').removeClass('selected').end().find('li>a:eq('+index+')').addClass('selected');
        $('.tabson:visible').hide().end().find('.tabson:eq('+index+')').show();    
    });
    
    //选择禁用
    $(".isshow").on('click',function(){
        $("input[name=isshow]").val($(this).val());
        $(this).parent('label').siblings('.inline').find('input').attr('checked',false);
    });
    
    //加添
    $("body").on('click', ".add_post", function(){
        var _this = $(this);
        var _form = $(this).parents("form");
        if (!Validator.Validate(document.forms[_form.attr("name")],2)) {
			return false;
		}
        
        //导管安排行程天数
        if (_form.find(".car_table").find(".tr")) {
            _form.find(".car_table").find(".tr").each(function(){
                var public_dx = '';
                $(this).find(".public_dx").each(function(){
                    if (this.checked) {
                        public_dx += $(this).val()+',';
                    }
                });
                $(this).find(".public_xcap").val(public_dx.substring(0,public_dx.length-1));
                
            });
        }
        
        $.post(_form.prop("action"), _form.serialize(), function(data){
                
				if (data.error) {	
					layer.msg(data.error);
					return false;
				}
				if (data.success) {
				    _this.prop("type","button");
                    _this.removeClass("add_post");
					layer.msg(data.success);
                    
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }
                    }, 3000);
				}
			},"json");
		return false; //防止表格submit类型按钮提交表单
        
   });
   
   //修改角色
   $(".role_edit").on('click',function(){
        var roleid = $(this).parents('tr').find("input[name=roleid]").val();
        $.post("index.php?g=portal&m=admin&a=role_edit", {roleid:roleid},function(data){
            $(".add").trigger('click');
            $("input[name=name]").val(data.name);
            $("textarea[name=remark]").html(data.remark);
            $("input[name=isshow]").val(data.isshow);
            $("input[name=sfcz]").val(data.id);
            $(".add_post").val("修改");
            $(".add").html("修改角色");
            if (data.isshow == 0) {
                $("#active_false").attr('checked',true);
                $("#active_true").attr('checked',false);
            }
        },'json');
   });
   
   //全选功能
    $(".allcheck").click(function(){
        if(this.checked) {
            $("input[name=roleid]").attr("checked", true);
        }
        else{
            $("input[name=roleid]").attr("checked", false);
        }
    });
   //授权
   $(".authorize_post").on('click',function(){
        var power = '';
        var id = $("input[name=id]").val();
        $("input[name=authorize]").each(function(){
            if($(this).is(':checked') == true ) {
                power += $(this).val()+',';
            }
        });
        $.post("index.php?g=portal&m=admin&a=authorize_post", {power:power,id:id}, function(data){
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
			},"json");
		return false; //防止表格submit类型按钮提交表单
   });
   
   //当前用户不能操作自己的
   $(".nouse").find("a").each(function(){
        $(this).removeClass("stop_user");
        $(this).removeClass("start_user");
        $(this).removeClass("role_edit");
        $(this).removeClass("J_ajax_del");
        $(this).attr("href","javascript:;;");
   });
   
   
   //禁用管理员
   $(".stop_user").on('click', function(){
        var uid = $(this).parents('tr').find("input[name=uid]").val();
        
        $.post("index.php?g=portal&m=admin&a=stop_user", {uid:uid}, function(data){
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
   //启用管理员
   $(".start_user").on('click', function(){
        var uid = $(this).parents('tr').find("input[name=uid]").val();
        
        $.post("index.php?g=portal&m=admin&a=start_user", {uid:uid}, function(data){
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
   
   //禁用司机
   $(".stop_car").on('click', function(){
        var uid = $(this).parents('tr').find("input[name=uid]").val();
        
        $.post("index.php?g=portal&m=Teamcar&a=stop_user", {uid:uid}, function(data){
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
   //启用司机
   $(".start_car").on('click', function(){
        var uid = $(this).parents('tr').find("input[name=uid]").val();
        
        $.post("index.php?g=portal&m=Teamcar&a=start_user", {uid:uid}, function(data){
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
   
   //禁用导游
   $(".stop_dy").on('click', function(){
        var uid = $(this).parents('tr').find("input[name=uid]").val();
        
        $.post("index.php?g=portal&m=Teamdg&a=stop_user", {uid:uid}, function(data){
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
   //启用导游
   $(".start_dy").on('click', function(){
        var uid = $(this).parents('tr').find("input[name=uid]").val();
        
        $.post("index.php?g=portal&m=Teamdg&a=start_user", {uid:uid}, function(data){
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
   
   //设置单选
   $(".role").on('click', function(){
        $("input[name=roleid]").val($(this).val());
        $(this).siblings(".role").attr("checked", false);
   });
   
   //增加购物点返佣信息
   $(".add_rate").on('click',function(){
        $(".forminfo").find(".shopf").last(".shopf").after(template('shopping'));
        //删除增加的购物点返佣信息
       $(".delect_rate").on('click',function(){
            $(this).parents(".shopf").remove();
       });
   });
   
   
   
   //----------------------------------------------------------------------------------------------------------------------------
   
   //是否显示传值
   $(".isshow").on('click',function(){
        if(this.checked) {
            $("input[name=isshow]").val(1);
        } else {
            $("input[name=isshow]").val(0);
        }
   });

   //路线全选删除
   $(".line_delect").on('click',function(){
        var lineid = '';
        $("input[name=roleid]").each(function(){
            if(this.checked) {
                lineid += $(this).val()+',';
            }
        });
        if (!lineid) {
            layer.msg("请至少选择一项");
            return false;
        }
        $.post("index.php?g=portal&m=line&a=line_delect",{lineid:lineid},function(data){
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
        return false;
   });
   //路线选中显示
   $(".line_show").on('click',function(){
        var lineid = '';
        $("input[name=roleid]").each(function(){
            if(this.checked) {
                lineid += $(this).val()+',';
            }
        });
        if (!lineid) {
            layer.msg("请至少选择一项");
            return false;
        }
        $.post("index.php?g=portal&m=line&a=line_show",{lineid:lineid},function(data){
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
        return false;
   });
   //路线选中取消显示
   $(".line_hide").on('click',function(){
        var lineid = '';
        $("input[name=roleid]").each(function(){
            if(this.checked) {
                lineid += $(this).val()+',';
            }
        });
        if (!lineid) {
            layer.msg("请至少选择一项");
            return false;
        }
        $.post("index.php?g=portal&m=line&a=line_hide",{lineid:lineid},function(data){
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
        return false;
   });
   //---------------------------------------------投诉-------------------------------------
   //搜索团队
   
    
   $(".add_seartch").on('click',function(){

        var start_date = $("input[name=start_date]").val();
        var end_date = $("input[name=end_date]").val();
        
        $.post("index.php?g=portal&m=complain&a=team_choose",{start_date:start_date,end_date:end_date},function(data){
			$(".values").remove();
            $(".seartch_team").append(template('teams',data));
            
        }, 'json');
   });
   
   
   
   //------------------------------------------------------------团队-----------------------
   
    //设置单选
   $(".publics").on('click', function(){
        $(this).parents("li").find(".valueid").val($(this).val());
        $(this).siblings(".type").attr("checked", false);
        
        $(this).parent(".pljt").siblings(".pljt").find(".type").attr("checked", false);
   });
   
   //选择门店
   $(".choose_sto").each(function(){
        if(this.checked) {
            $(this).siblings("input").attr("disabled",false);
            $(this).siblings("input").attr("Require",true);
        } else {
            $(this).siblings("input").attr("disabled",true);
            $(this).siblings("input").attr("Require",false);
        }
   });
   
   $(".choose_sto").on('click',function(){
        if(this.checked) {
            $(this).siblings("input").attr("disabled",false);
            $(this).siblings("input").attr("Require",true);
        } else {
            $(this).siblings("input").attr("disabled",true);
            $(this).siblings("input").attr("Require",false);
        }
   });
   
   
   
   //是否全陪
   $(".isqp").on('click',function(){
        if(this.checked) {
            $("input[name=isqp]").val(1);
        } else {
            $("input[name=isqp]").val(0);
        }
   });
   //是否联系人
   $(".islx").on('click',function(){
        if(this.checked) {
            $("input[name=islx]").val(1);
        } else {
            $("input[name=islx]").val(0);
        }
   });
   //选择路线
   
    
   $("#line").change(function(){
        line=$(this).val();
        $.post("index.php?g=portal&m=team&a=team_choose_line",{line:line},function(data){
			$(".values").remove();
            $("#data_tem").append(template('lines',data));
            $("input[name=lineid]").val(data['content']['0']['id']);
            
            $("#data_tem").change(function(){
                $("input[name=lineid]").val($(this).val());
            });
        }, 'json');
   });
   
    //团队全选删除
   $(".team_delect").on('click',function(){
        var teamid = '';
        $("input[name=roleid]").each(function(){
            if(this.checked) {
                teamid += $(this).val()+',';
            }
        });
        if (!teamid) {
            layer.msg("请至少选择一项");
            return false;
        }
        $.post("index.php?g=portal&m=team&a=team_delect",{teamid:teamid},function(data){
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
        return false;
   });
   //路线选中显示
   $(".team_show").on('click',function(){
        var teamid = '';
        $("input[name=roleid]").each(function(){
            if(this.checked) {
                teamid += $(this).val()+',';
            }
        });
        if (!teamid) {
            layer.msg("请至少选择一项");
            return false;
        }
        $.post("index.php?g=portal&m=team&a=team_show",{teamid:teamid},function(data){
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
        return false;
   });
   //路线选中取消显示
   $(".team_hide").on('click',function(){
        var teamid = '';
        $("input[name=roleid]").each(function(){
            if(this.checked) {
                teamid += $(this).val()+',';
            }
        });
        if (!teamid) {
            layer.msg("请至少选择一项");
            return false;
        }
        $.post("index.php?g=portal&m=team&a=team_hide",{teamid:teamid},function(data){
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
        return false;
   });
   
   //选择团队编号
   $(".team_bh").on('click', function(){
        var _this = $(this);
        var team_bh = _this.val();
        var cf_date = _this.parents("li").siblings("li").find("input[name=date]").val();//出发时间
		
		if (!cf_date) {
			layer.msg("请先选择出团时间");
			_this.attr("checked", false);
			return false;
		}
        //传值获取
        $.post(_this.data("url"), {team_bh:team_bh,cf_date:cf_date}, function(data){
            if (data.tdbh) {
                _this.parents("li").find(".ztbh").val(team_bh);
                _this.parents("li").find(".value").val(data.tdbh);
                _this.siblings(".type").attr("checked", false);
            }
        },'json');
    
   });
   
   
   //--------------------------------------------------------门店管理---------------------------------------------------
   //门店全选删除
   $(".store_delect").on('click',function(){
        var storeid = '';
        $("input[name=roleid]").each(function(){
            if(this.checked) {
                storeid += $(this).val()+',';
            }
        });
        if (!storeid) {
            layer.msg("请至少选择一项");
            return false;
        }
        $.post("index.php?g=portal&m=store&a=store_delect",{storeid:storeid},function(data){
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
        return false;
   });
   
   //------------------------------------------------------------------------------------------------------------------------------
   
   //得到焦点实时监听搜索内容
   $(".public_for").children("#dyfy").focus(function(){
        
        var _this = $(this).parents(".public_for");
        _this.find(".public_book").show();
        //滚动条
        $(".public_book").niceScroll({ 
            cursorcolor:"#1d3f9f",  
            cursoropacitymax:1,  
            touchbehavior:false,  
            cursorwidth:"5px",  
            cursorborder:"1",  
            cursorborderradius:"5px"  
        });
        //默认取所有值
        var hall_url = _this.find("#hall_url").val();
        var hall_value = $(this).val();
        
        $.post(hall_url,{hall_value:hall_value},function(data){
        
            _this.find(".public_book").find("i").html(data.content.length);
            _this.find(".public_book").find(".hall_delect").remove();
            _this.find(".public_book").find("ul").append(template('hall',data));
            
            save_values();
        }, 'json');
        
        //监听
        _this.children("#dyfy").bind('input propertychange',function(){
            hall_value = $(this).val();
            
            $.post(hall_url,{hall_value:hall_value},function(data){

                _this.find(".public_book").find("i").html(data.content.length);
                _this.find(".public_book").find(".hall_delect").remove();
                _this.find(".public_book").find("ul").append(template('hall',data));
                
                save_values();
                
            }, 'json');
        });
        
        
   });
   //传值
   function save_values() {
        $(".hall_delect").on('click',function(){
            var id = $(this).find("input").val();
            var name = $(this).find("span").html();
            
            $(this).parents(".public_for").find("#dyfy").val(name);
            $(this).parents(".public_for").find("#public_now_id").val(id);
            
            $(this).parents(".public_book").hide();
        });
   }
   
   //增加值
   $(".add_public").on('click',function(){
        var _this = $(this).parents("li").find("#public_addbook").find("table").find("tbody");
        var id = $(this).siblings("#public_now_id").val();
        var value_url = $(this).parents("li").find("#public_addbook").find(".value_url").val();
        var value_template = $(this).parents("li").find("#public_addbook").find(".value_template").val();
        
        //行程天数
        var xcts_car = 0;
        if ($(this).siblings(".xcts_car").val()) {
            xcts_car = $(this).siblings(".xcts_car").val();
        } 
        if (!id) {
            layer.msg("请选择一个");
            return false;
        }
        $.post(value_url,{id:id,xcts_car:xcts_car},function(data){
            _this.append(template(value_template,data));
            
            //移除本行
            _this.find(".value_delect").on('click',function(){
                $(this).parents("tr").remove();
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
           
           apdy_public();
           
           hall_all();
           
           //scenic_all();
           
           car_all();
        });
   });
   
   //失去焦点时
   $(".public_for").children("#dyfy").blur(function(){
        //$(this).parents(".public_for").find(".public_book").hide();
   });
   
   $(".value_delect").on('click',function(){
        $(this).parents("tr").remove();
    });
   
   //移上去消失
   $(".public_book").mouseleave(function(){
        $(this).hide();
        //$("#null").trigger('click');
        $(this).siblings("#dyfy").blur().trigger("blur");
   });
   
   //需求编辑酒店
   $(".add_jdhotel").on('click',function(){
        $(this).parents("li").append(template('showlists'));
        
         var _this = $(this).parents("li").find(".public_hotel:last");
         var eara = _this.children(".province").val()+"/"+_this.children(".city").val();
         var star = _this.children(".star").val();
         var teamid = $("input[name=teamid]").val();
         var xcts = _this.find(".xcts").val();
        
         $.post("index.php?g=portal&m=demand&a=hotel_ser",{zone:eara,star:star,teamid:teamid,xcts:xcts},function(data){
            _this.children(".hotel_name").remove();
            if (data) {
                _this.children(".hotelid").append(template('showlist',data));
            }
         }, 'json');
         
        $(".public_sear").change(function(){
             var _this = $(this);
             var eara = $(this).parents(".public_for").find(".province").val()+"/"+$(this).parents(".public_for").find(".city").val();
             var star = $(this).parents(".public_for").find(".star").val();
             $.post("index.php?g=portal&m=demand&a=hotel_ser",{zone:eara,star:star},function(data){
                _this.parents(".public_for").find(".hotel_name").remove();
                _this.parents(".public_for").find(".hotelid").append(template('showlist',data));
    
             }, 'json');
        });
        
         //删除
        $(".delete_jdhotel").on('click',function(){
            $(this).parents(".public_for").remove();
        });
   });
   
    //删除
    $(".delete_jdhotel").on('click',function(){
        $(this).parents(".public_for").remove();
    });
    
    
    //需求编辑餐厅
    hall_all();
    function hall_all () {
        $(".hall_rs").focus(function(){
            $(this).bind('input propertychange',function(){
                
                var rs = parseFloat($(this).parents(".demand_js").find(".rs").val());
                if (!rs) {
                    rs = 0;
                }
                
                var cb = parseInt($(this).parents(".demand_js").find(".cb").val());
                if (!cb) {
                    cb = 0;
                }
                $(this).parents(".demand_js").find(".hall_all").val(rs*cb);
                
                $(".demand_dx").on('click',function(){
                    var hall_all = parseFloat($(this).parents(".demand_js").find(".hall_all").val());
                    if (this.checked) {
                      $(this).siblings(".public_xf").val("");
                      $(this).siblings(".demand_dx").attr("checked",false);
                      $(this).next(".public_xf").val(hall_all);
                    }
                });
            });
        });
    }
    $(".demand_dx").on('click',function(){
        var hall_all = parseFloat($(this).parents(".demand_js").find(".hall_all").val());
        if (this.checked) {
          $(this).siblings(".public_xf").val("");
          $(this).siblings(".demand_dx").attr("checked",false);
          $(this).next(".public_xf").val(hall_all);
        }
    });
    
    
    //需求编辑门票
    /**
 * scenic_all();
 *     function scenic_all () {
 *         $(".scenic_rs").focus(function(){
 *             $(this).bind('input propertychange',function(){
 *                 var rs = parseFloat($(this).parents("tr").find(".rs").val());
 *                 if (!rs) {
 *                     rs = 0;
 *                 }
 *                 
 *                 var cb = parseInt($(this).parents("tr").find(".cb").val());
 *                 if (!cb) {
 *                     cb = 0;
 *                 }
 *                 $(this).parents("tr").find(".scenic_all").val(rs*cb);
 *                 
 *                 $(this).parents("tr").find(".scenic").bind('input propertychange',function(){
 *                     $(this).siblings(".scenic").val(0);
 *                 });
 *             });
 *         });
 *     }
 *     $(".scenic").bind('input propertychange',function(){
 *         $(this).siblings(".scenic").val(0);
 *     });
 */
    
    //车调团队车辆
    car_all();
    function car_all () {
        $(".car_price").focus(function(){
            $(this).bind('input propertychange',function(){
                var public_all = parseInt($(this).parents("tr").find(".public_all").val());
                
                var car_price = parseInt($(this).val());
                
                if (!car_price) {
                    car_price = 0;
                }
                
                var pre_car_price = parseInt($(this).prev(".car_price").val());
                if (!pre_car_price) {
                    pre_car_price = 0;
                }
                
                if (public_all-car_price-pre_car_price < 0) {
                    layer.msg("请正确输入！");
                    $(this).val("");
                    return false;
                }
                $(this).nextAll(".car_gz").val(public_all-car_price-pre_car_price);
                
            });
        });
    }
   //-----------------------------------------------------------------------------------------------------------
   
   //房调
   $(".sum_hotel").focus(function(){
        $(this).bind('input propertychange',function(){
            sum_hotel = parseFloat($(this).parents(".information").find(".hotel_room_sum").val());
            price_hotel = parseFloat($(this).parents(".information").find(".price_hotel").val());
            var hotel_xj = parseFloat($(this).parents("td").siblings("td").find(".hotel_xj").val());
            if (!hotel_xj) {
                hotel_xj=0;
            }
            price_hotel_xj = sum_hotel*price_hotel;
            if (!price_hotel_xj) {
                price_hotel_xj = 0;
            }
            //合计
            $(this).parents("td").siblings("td").find(".hotel_xj").val(price_hotel_xj);
            //总计
            var price_hotel_all = parseFloat($(this).parents(".hotel").find(".hj").find(".price_all").val());
            if (!price_hotel_all) {
                price_hotel_all = 0;
            }
            $(this).parents(".hotel").find(".hj").find(".price_all").val(price_hotel_xj+price_hotel_all-hotel_xj);
                
        });
   });
   
   //---------------------------------------------------------------------------------------------------------
   
   //车调
   $(".car_add").on('click',function(){
        var _this   = $(this).parents("td").siblings("td");
        var _this2  = $(this).parents("li").siblings("li").find("#public_addbook").find(".car_table").find("tbody");
        var xcts    = _this.find(".xcts").val();
        var clph    = _this.find(".clph").val();
        var contact = _this.find(".contact").val();
        var company = _this.find(".company").val();
        var phone   = _this.find(".phone").val();
        var remark  = _this.find(".remark").val();
        
        var arr = {
            clph:clph,
            contact:contact,
            company:company,
            phone:phone,
            remark:remark,
        };
        if (!clph || !contact || !company || !phone) {
            layer.msg("请输入有效信息");
            return false;
        }
        $.post("index.php?g=portal&m=Teamcar&a=add_car",{arr:arr,xcts:xcts},function(data){
            _this2.append(template('one_hall',data));
            //同时清空此表单

            //移除本行
            $(".value_delect").on('click',function(){
                $(this).parents("tr").remove();
            });
        }, 'json');
    
        
   });
   
   //行程天数多选
   $(".public_cdxc").on('click', function(){
        var public_cdxcap = '';
        $(this).parents(".public_for").find(".public_cdxc").each(function(){
            if (this.checked) {
                public_cdxcap += $(this).val()+',';
            }
        });
        public_cdxcap = public_cdxcap.substring(0,public_cdxcap.length-1);
        $(this).parents(".public_for").find(".xcts_car").val(public_cdxcap);
   });
   
   //行程天数多选
   $(".public_cdxc2").on('click', function(){
    
        var public_cdxcap = '';
        $(this).parents("td").find(".public_cdxc2").each(function(){
            if (this.checked) {
                public_cdxcap += $(this).val()+',';
            }
        });
        public_cdxcap = public_cdxcap.substring(0,public_cdxcap.length-1);
        $(this).parents("td").find(".xcts_car2").val(public_cdxcap);
   });
   
   //------------------------------------------------------------------------------------------------------------
   
   //财务拨款
   $(".ready_bk").on('click',function(){
        var _this = $(this); 
        var allotid = $(this).parents("tr").find("input[name=allotid]").val();
        var cwbk = $(this).parents("tr").find("input[name=cwbk]").val();
        var xcts = $(this).parents("tr").find("input[name=xcts]").val();
        if (!cwbk) {
            layer.msg("请输入拨款数量");
            return false;
        }
        $.post("index.php?g=portal&m=Finance&a=finance_bk_post",{allotid:allotid,cwbk:cwbk,xcts:xcts},function(data){
            if (data.error) {	
				layer.msg(data.error);
				return false;
			}
			if (data.success) {
				layer.msg(data.success);
                _this.prop("type","button");
                _this.removeClass("ready_bk");
                setTimeout(function(){
                    if (data.url) {
                        location.href=data.url;
                    }
                }, 3000);
			}
        }, 'json');
        return false;
   });
   
   //财务确认回团
   $(".ready_return_team").on('click',function(){
        var _this = $(this);
        layer.confirm("确认回团后将无法继续操作团！",function(index){
            $.post(_this.data("url"),{key:1},function(data){
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
   });
   
   //------------------------------------------------------------------------------------------------------------
   //接送安排
   
   //所有列表显示
   
   $(".xuanze_sj").on('click',function(){
        var carid = $(this).siblings("#public_now_id").val();//司机id
        $(this).siblings(".hide_customer").find("#hide_customer_center").niceScroll({ 
            cursorcolor:"#ffffff",  
            cursoropacitymax:1,  
            touchbehavior:false,  
            cursorwidth:"5px",  
            cursorborder:"1",  
            cursorborderradius:"5px"  
        });
        $(this).siblings(".hide_customer").show();
        
        //调用拖拽
        var _this = $(this).siblings(".hide_customer");
        //dray(_this);
   });
   
   //隐藏
   $(".hide_customer_top_img").on('click',function(){
        $(this).parents(".hide_customer").hide();
   });
   
   
    //加入游客
    $(".hide_customer_add").on('click',function(){
        var _this = $(this).parents(".public_for").siblings("#public_addbook").find(".car_table").find("tbody");
        var _this2 = $(this).parents(".hide_customer_foot").siblings(".hide_customer_center").find(".customerid");
        var _this3 = $(this).parents(".public_for").siblings("#public_addbook");
        var customerid = '';
        var public_now_id = $(this).parents(".public_for").find("#public_now_id").val();
        $(this).parents(".hide_customer_foot").siblings(".hide_customer_center").find("table").find("tr").find(".customerid").each(function(){
            if (this.checked) {
                customerid +=$(this).val()+',';
            }
        });
        if (!customerid) {
            layer.msg("请至少选择一个");
            return false;
        } else {
            customerid=customerid.substring(0,customerid.length-1);
        }
        if (!public_now_id) {
            layer.msg("请先选择司机");
            return false;
        }
        
        //根据司机ID传值
        var car_url = $(this).siblings(".car_url").val();
        $.post(car_url,{customerid:customerid,public_now_id:public_now_id},function(data){
            
            _this.append(template(_this3.find(".value_template").val(),data));
            
            _this2.attr("checked",false);
            //调用时间插件
            dateTimeInput = $("input.J_datetime");
            if (dateTimeInput.length) {
                Wind.use('datePicker', function () {
                    dateTimeInput.datePicker({
                        time: true
                    });
                });
            }
            
            $(".value_delect").on('click',function(){
                $(this).parents("tr").remove();
            });
            
            //查看团员信息
            $(".look_customer").on('click',function(){
                var uids = $(this).siblings(".uids").val();
                var _look_this = $(this);
                var look_customer_url = $(this).siblings(".look_customer_url").val();

                _look_this.parents(".car_table").siblings(".hide_customer2").show();
                //滚动条
                $(this).parents(".car_table").siblings(".hide_customer2").find("#hide_customer_center").niceScroll({ 
                    cursorcolor:"#ffffff",  
                    cursoropacitymax:1,  
                    touchbehavior:false,  
                    cursorwidth:"5px",  
                    cursorborder:"1",  
                    cursorborderradius:"5px"  
                });
                $.post("index.php?g=portal&m=teamcar&a=look_customer",{uids:uids},function(data){
                    _look_this.parents(".car_table").siblings(".hide_customer2").find(".hide_customer_center").find("table").find(".look_customer_delete").remove();
                    _look_this.parents(".car_table").siblings(".hide_customer2").find(".hide_customer_center").find("table").append(template(look_customer_url,data));
                    $(".hide_customer_top_img").on('click',function(){
                        $(this).parents(".hide_customer2").hide();
                    });
                },'json');
            });
            
        },'json');
    });
    
    //查看团员信息
    $("body").on('click',".look_customer",function(){
        var uids = $(this).siblings(".uids").val();
        var _look_this = $(this);
        var look_customer_url = $(this).siblings(".look_customer_url").val();

        _look_this.parents(".car_table").siblings(".hide_customer2").show();
        //滚动条
        $(this).parents(".car_table").siblings(".hide_customer2").find("#hide_customer_center").niceScroll({ 
            cursorcolor:"#ffffff",  
            cursoropacitymax:1,  
            touchbehavior:false,  
            cursorwidth:"5px",  
            cursorborder:"1",  
            cursorborderradius:"5px"  
        });
        $.post("index.php?g=portal&m=teamcar&a=look_customer",{uids:uids},function(data){
            _look_this.parents(".car_table").siblings(".hide_customer2").find(".hide_customer_center").find("table").find(".look_customer_delete").remove();
            _look_this.parents(".car_table").siblings(".hide_customer2").find(".hide_customer_center").find("table").append(template(look_customer_url,data));
            $(".hide_customer_top_img").on('click',function(){
                $(this).parents(".hide_customer2").hide();
            });
        },'json');
    });
   
   //--------------------------------------------------------------------------------------------------------------
   
   //导管
   $(".clap").on('click',function(){

        var clap = '';
        var fy_all = 0;
        var xf_all = 0;
        var wf_all = 0;
        $(this).parents("table").find("tr").find(".clap").each(function(){
            if(this.checked){
                clap += $(this).val()+',';
                fy_all += parseInt($(this).parents("tr").find(".dg_price").val());
                xf_all += parseInt($(this).parents("tr").find(".dg_xfxf").val());
                wf_all += parseInt($(this).parents("tr").find(".dg_wfwf").val());
            }
        });
        $(this).parents("li").find("input[name=clap]").val(clap.substring(0,clap.length-1));
        $("input[name=fy_all]").val(fy_all);
        $("input[name=xf_all]").val(xf_all);
        $("input[name=wf_all]").val(wf_all);
   });
   
   //购物点选择
   $(".public_shop").on('click',function(){
        var shopid = '';
        $(this).parents("p").find(".public_shop").each(function(){
           
            if (this.checked) {
                shopid += $(this).val()+',';
            }
        });
        $(this).parents("p").find(".shopid").val(shopid.substring(0,shopid.length-1));
   });
   
   //------------------------------------------------------------------------------------------------------------
   //导管
   $(".dg_add_public").on('click',function(){
        var _this = $(this).parents("li").find("#public_addbook").find("table").find("tbody");
        var dg_team_scenicid = parseInt($(this).parents("li").find(".dg_team_scenicid").val());
        var xcap = parseInt($(this).parents("li").find(".xcts_car").val());
        var value_template = $(this).parents("li").find("#public_addbook").find(".value_template").val();
        $.post("index.php?g=&m=teamdg&a=dg_scenic_ser",{dg_team_scenicid:dg_team_scenicid,xcap:xcap},function(data){
            
             _this.append(template(value_template,data));
            
            //移除本行
            _this.find(".value_delect").on('click',function(){
                $(this).parents("tr").remove();
            });
        });
   });
   
   //------------------------------------------------------------------------------------------------------------
   
    
   //-----------------------------------------------------------------------------------------------------------
   //设置多选
   $(".public_dx_check").on('click',function(){
        var public_dx_check_sum = '';
        $(this).parents(".public_parents").find(".public_dx_check").each(function(){
            if (this.checked) {
                public_dx_check_sum += $(this).val()+',';
            }
        });
        public_dx_check_sum = public_dx_check_sum.substring(0,public_dx_check_sum.length-1);
        $(this).parents(".public_parents").find(".public_dx_check_sum").val(public_dx_check_sum);
   });
   
   
   
   //已读消息
   $(".message_select").on('click',function(){
        var id = $(this).data("id");
        $.post("index.php?g=portal&m=index&a=message_post",{id:id},function(){
            
        },'json');
   });
   
   
   
   
   //移上去显示
   $(".button_pz").mouseover(function(){
        $(this).siblings(".pj_pz").show();
        
        $(this).siblings(".pj_pz").on('click',function(){
            $(this).hide();
        });
        
   });
   
   //传值状态
   $(".click_post_status").on('click',function(){
        var _this = $(this);
        if (this.checked) {
            _this.parents("h2").siblings("h2").find(".click_post_status").attr("checked",false);
            _this.parents("form").find(".status_public").val($(this).val());
            if (parseInt(_this.val()) == 5) {
                _this.parents("h2").siblings("textarea").attr("readonly",false);
            } else {
               _this.parents("h2").siblings("textarea").attr("readonly",true); 
            }
        }
   });
   
   //判断当天是否已经安排导游
   apdy_public();
   function apdy_public () {
        $(".public_dx").on('click',function(){
            if (this.checked) {
                var _this = $(this);
                var public_dx = $(this).val();
                var teamid = $("input[name=teamid]").val();
                $.post("index.php?g=&m=teamdg&a=apdy_public",{public_dx:public_dx,teamid:teamid},function(data){
                    if (data.error) {
                        layer.msg(data.error);
                        _this.attr("checked",false);
                    }
                    public_add();
                },'json');
            }
        });
   }
   
   //公共提交表单
   function public_add () {
        $(".add_post").on('click', function(){
            var _this = $(this);
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
        var public_xf = parseFloat(_this.find(".public_xf").val());
        var public_wf = parseFloat(_this.find(".public_wf").val());
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
   
   //批量加入时间
   $(".submit_pl_add").on('click',function(){
        var publicid = '';
        var delete_url = $(".pl_url").val();
        var teamid = $("input[name=teamid]").val();
        $("input[name=roleid]").each(function(){
            if(this.checked) {
                publicid += $(this).val()+',';
            }
        });
        if (!publicid) {
            layer.msg("请至少选择一项");
            return false;
        }
        $(".pl_add").show();
        $(".hide_customer_top_img").on('click',function(){
            $(this).parents(".pl_add").hide();
        });
        publicid = publicid.substring(0,publicid.length-1);
        
        $(".pl_date_adds").on('click',function(){
            var arr = {
                jtlb:$(".jtlb").val(),
                dgxx:$("input[name=dgxx]").val(),
                date_d:$("input[name=date_d]").val(),
                lgxx:$("input[name=lgxx]").val(),
                date_l:$("input[name=date_l]").val(),
            };
            if (!$("input[name=dgxx]").val() || !$("input[name=date_d]").val() || !$("input[name=lgxx]").val() || !$("input[name=date_l]").val()) {
                layer.msg("请填写完数据");
                return false;
            }
            $.post(delete_url,{publicid:publicid,arr:arr,teamid:teamid},function(data){
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
            return false;
        });
        
        return false;
   });
   
   //选中删除
   $(".public_delect").on('click',function(){
        var publicid = '';
        var delete_url = $("input[name=delete_url]").val();

        $("input[name=roleid]").each(function(){
            if(this.checked) {
                publicid += $(this).val()+',';
            }
        });
        if (!publicid) {
            layer.msg("请至少选择一项");
            return false;
        }
        $.post(delete_url,{publicid:publicid},function(data){
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
        return false;
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
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
})