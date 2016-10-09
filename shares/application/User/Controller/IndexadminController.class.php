<?php

/**
 * 会员
 */
namespace User\Controller;
use Common\Controller\AdminbaseController;
class IndexadminController extends AdminbaseController {
	function _initialize(){
		parent::_initialize();
		$this->table = M("oauth_user");
	}
    function index(){
        
        //默认排序
        !$_GET['sort_field'] && $_GET['sort_field'] = 'ou.score';
        !$_GET['sort_by'] && $_GET['sort_by'] = 'DESC';
        
		//条件搜索
		$fields=array(
			'start_time'=> array("field"=>"ou.create_time","operator"=>">"),
			'end_time'  => array("field"=>"ou.create_time","operator"=>"<"),
			'keyword'  => array("field"=>"ou.user_nicename,ou.zs_name,ou.mobile,ou.id,ou2.user_nicename,ou2.mobile","operator"=>"like"),
			'state'  => array("field"=>"ou.user_type","operator"=>"="),
		);
		$where = $this->search($fields);
		$count = $this->table
			->alias("ou")//表别名
			->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id","LEFT")
			->join(C ( 'DB_PREFIX' )."user_dl ud ON ud.uid = ou.id","LEFT")
			->join(C ( 'DB_PREFIX' )."oauth_user ou2 ON ou.tjrr = ou2.id","LEFT")
			->where($where)
			->count();//获取条数
		$page = $this->page($count, 20);//设置分页信息
		$list = $this->table
			->alias("ou")//表别名
			->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id","LEFT")
			->join(C ( 'DB_PREFIX' )."user_dl ud ON ud.uid = ou.id","LEFT")
			->join(C ( 'DB_PREFIX' )."oauth_user ou2 ON ou.tjrr = ou2.id","LEFT")
			->where($where)
			->field("ou.*, s.score sjscore, ud.dl_score, CONCAT(ou2.mobile, ' ', ou2.user_nicename) tjrr")
			->limit($page->firstRow . ',' . $page->listRows)
			->order("$_GET[sort_field] $_GET[sort_by], ou.id DESC")
			->select();
		$this->assign("Page", $page->show('Admin'));
		$this->assign("formget",$_GET);
		$this->assign("list",$list);
		$this->display(":index");
    }
	function edit_post(){
		if(I("post.zfmm")!=""){
			$_POST['zfmm'] = sp_password(I("post.zfmm"));
		}else{
			unset($_POST['zfmm']);
		}
		if(I("post.password")!=""){
			$_POST['password'] = sp_password(I("post.password"));
		}else{
			unset($_POST['password']);
		}
		parent::edit_post();
	}
	//启用
	function enable(){
		if(isset($_GET['id'])){
			$tid = intval(I("get.id"));
			if ($this->table->where("id=$tid")->setField("user_status",$_GET['t'])) {
				$this->success("启用成功！");
			} else {
				$this->error("已启用 无需再次启用！");
			}
		}
		if(isset($_POST['ids'])){
			$tids = join(",",$_POST['ids']);
			if ($this->table->where("id in ($tids)")->setField("user_status",$_GET['t'])) {
				$this->success("操作成功！");
			} else {
				$this->error("操作失败！");
			}
		}
	}
    
    function delete(){
        if(isset($_GET['id'])){
            $tid = intval(I("get.id"));

            //判断有没店铺
            $store = M('store')->where("uid=$tid AND isenable=1")->find();
            if ($store) {
                $this->error("用户有店铺己启用、需先禁用，删除失败！");
            }
            
            //判断有没代理
            $store = M('user_dl')->where("uid=$tid AND isenable=1")->find();
            if ($store) {
                $this->error("用户有代理启用、需先禁用，删除失败！");
            }
                            
            if ($this->table->where("id=$tid")->delete()) {
                                
                M('user_message')->where("userid IN($tid)")->delete(); //删除用户信息
                M('user_withdraw')->where("uid IN($tid)")->delete(); //删除用户提现
                M('user_integral')->where("userid IN($tid)")->delete(); //删除用户积分
                //M('dl_integral')->where("uid IN($tid)")->delete(); //删除用户返佣明细
                M('user_address')->where("userid IN($tid)")->delete(); //删除用户收货地址
                M('order')->where("uid IN($tid)")->delete(); //删除用户订单表
                M('user_buycar')->where("uid IN($tid)")->delete(); //删除用户购物车
                
                M('store')->where("uid IN($tid)")->delete(); //删除用户店铺
                M('user_dl')->where("uid IN($tid)")->delete(); //删除用户代理
                
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
        if(isset($_POST['ids'])){
            $tids = join(",",$_POST['ids']);
            if ($this->table->where("id in ($tids)")->delete()) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
    }    
}
