<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Portal\Controller;
use Common\Controller\HomeBaseController;
class ProcarController extends HomeBaseController{
	
	protected $goods;
    
	function _initialize(){
        parent::_initialize();
        $this->goods = M("goods");
    }
	
	public function index() {
	    $sessionid = session_id();//获取浏览器sessionid
		$uid = get_current_userid();
        $where = "";
        if (!$uid) {
           $where = " a.sessionid='$sessionid' "; 
        } else {
            $where = " a.uid='$uid' ";
        }
        
       
        //产品
        $user_buycar = M("user_buycar")
        ->alias("a")
        ->join(C ( 'DB_PREFIX' )."goods c ON a.goods_id = c.id")
        ->join(C ( 'DB_PREFIX' )."goods_pic d ON d.goods_id = c.id")
        ->where($where)
        ->order("a.id DESC")
        ->field("a.*, c.name goods_name, c.price size_price, c.id goods_id, d.imgurl, c.spec_color spec_color2, c.spec_size spec_size2, c.price_yp")
        ->select();
        foreach ($user_buycar as $k2=>$v2) {
            $size_id = intval($v2['size_id']);
            if ($size_id) {
                $goods_spec = M("goods_spec")->where("id='$size_id'")->field("price")->find();
                $user_buycar[$k2]['size_price'] = $goods_spec['price'];
            }
        }
        $list = $user_buycar;
        
        $this->assign("list",$list);
        
		$this->display();
	}
    
    //购物车增加商品
    public function add_post () {
        $sessionid = session_id();//获取浏览器sessionid
        $uid = get_current_userid();
        $where = "";
        if (!$uid) {
            $uid = 0;
            $where = " sessionid='$sessionid' "; 
        } else {
            $where = " uid='$uid' ";
        }
        
        $goods_id = intval(I("get.id"));
        $goods = $this->goods->where("id='$goods_id'")->field("store")->find();
        
        $size_id = intval(I("post.size_id"));
        $goods_spec = M("goods_spec")->where("id='$size_id'")->find();
        if (!$size_id) {
            //此时没有规格
            $goods_spec['stock'] = $goods['store'];
        }
        //购物车信息
        $arr = array(
            'uid'              => 	$uid,
            'goods_id'         => 	$goods_id,
            'spec_color'       => 	$goods_spec['spec_color'],
            'spec_size'        => 	$goods_spec['spec_size'],
            'nums'             => 	$_POST['num'],
            'date'             => 	time(),
            'size_id'          =>   $size_id,
            'sessionid'        =>   $sessionid,
        );
        $where .= " AND goods_id='$goods_id' AND size_id='$size_id' ";
        $user_buycar = M("user_buycar")->where($where)->find();
        if ($user_buycar) {
            $user_buycarid = $user_buycar['id'];
            $user_buycar_num = intval($user_buycar['nums'])+intval($_POST['num']);
            
            //存库
            if ($user_buycar_num > intval($goods_spec['stock'])) {
                $this->ajaxReturn(array('error'=>"库存不足!"));
                return false;
            }
            
            if (M("user_buycar")->where("id='$user_buycarid'")->save(array('nums'=>$user_buycar_num))) {
                $this->ajaxReturn(array('success'=>"加入成功"));
            } else {
                $this->ajaxReturn(array('error'=>"加入失败"));
            }
        } else {
            if (M("user_buycar")->add($arr)) {
                $this->ajaxReturn(array('success'=>"加入成功"));
            } else {
                $this->ajaxReturn(array('error'=>"加入失败"));
            }
        }
    }
    
    //删除购物车
    function delete () {
        $id = intval(I("get.id"));
        if (M("user_buycar")->where("id='$id'")->delete()) {
            $this->success("删除成功！");
		} else {
			$this->error("删除失败！");
        }
    }
    
    //购物车增加商品数量时判断库存
    public function add_num () {
        $num = intval(I("post.num"));
        $car_id = intval(I("get.id"));
        
        $pd = M("user_buycar")->where("id='$car_id'")->find();
        $user_buycar = array();
        if ($pd['size_id']) {
            $user_buycar = M("user_buycar")
            ->alias("a")
            ->join(C ( 'DB_PREFIX' )."goods_spec e ON a.size_id = e.id")
            ->where("a.id='$car_id'")
            ->field("e.stock,a.goods_id")
            ->find();
        } else {
            $user_buycar = M("user_buycar")
            ->alias("a")
            ->join(C ( 'DB_PREFIX' )."goods e ON a.goods_id = e.id")
            ->where("a.id='$car_id'")
            ->field("e.store stock,a.goods_id")
            ->find();
        }
        
        if ($num <= intval($user_buycar['stock'])) {
            M("user_buycar")->where("id='$car_id'")->save(array('nums'=>$num));
            
            $this->ajaxReturn(array('success'=>"ok"));
        } else {
            $this->ajaxReturn(array('error'=>"库存不足！"));
        }
    }
    
    //减少商品数量
    public function less_num () {
        $num = intval(I("post.num"));
        $car_id = intval(I("get.id"));
        $goods_id = intval(I("get.goods_id"));
        $size_id = intval(I("get.size_id"));
        
        
        //如果存在规格
        if ($size_id) {
            $goods_spec = M("goods_spec")->where("id='$size_id'")->field("price")->find();
            $seller_cx['is_pf_price'] = $goods_spec['price'];
            $seller_cx['is_pf'] = 0;
        } else {
            $goods = M("goods")->where("id='$goods_id'")->find();
            $seller_cx['is_pf_price'] = $goods['price'];
            $seller_cx['is_pf'] = 0;
        }
        
        if (M("user_buycar")->where("id='$car_id'")->save(array('nums'=>$num))) {
            $this->ajaxReturn(array('success'=>"ok"));
        } else {
            $this->ajaxReturn(array('error'=>"操作失败"));
        } 
    }
    
    
    
    
    
    
	
}