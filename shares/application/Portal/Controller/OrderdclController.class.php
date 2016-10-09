<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tuolaji <479923197@qq.com>
// +----------------------------------------------------------------------
namespace Portal\Controller;
use Common\Controller\AdminbaseController;
class OrderdclController extends AdminbaseController {
    
    protected $order;
    
	function _initialize() {
		parent::_initialize();
		$this->order = M("order");
	}
	function index(){
        //商品显示条件
        $where_ands = array();
		!$_GET['sort_field'] && $_GET['sort_field'] = 'ou.id';
		!$_GET['sort_by'] && $_GET['sort_by'] = 'DESC';
		//默认排序
        $fields=array(
				'keyword'       => array("field"=>"ou.mobile , ou.zs_name,orderno","operator"=>"like"),//订单编号
                'order_state'    => array("field"=>"order_state","operator"=>"="),//订单分类
                
                'start_price'   => array("field"=>"order_money","operator"=>">="),//价格区间
				'end_price'     => array("field"=>"order_money","operator"=>"<="),//价格区间
                'start_time'      => array("field"=>"order_date","operator"=>">="),//下单区间
				'end_time'        => array("field"=>"order_date","operator"=>"<="),//下单区间
		);
        $results = $this->public_search2($where_ands,$fields);
        $where = $results['where'];
        
        //数据
		$count = $this->order
		      ->alias("o")
		      ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = o.uid")
		      ->join(C ( 'DB_PREFIX' )."curriculum c ON c.id = o.curriculum_id")
		      ->where($where)
		      ->limit($page->firstRow . ',' . $page->listRows)
		      ->field('o.* , ou.user_nicename , ou.mobile, c.curriculum_name ,ou.zs_name')
		      ->order("$_GET[sort_field] $_GET[sort_by],o.id DESC")
		      ->count();
		$page = $this->page($count, 10);
		$list = $this->order
		      ->alias("o")
		      ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = o.uid")
		      ->join(C ( 'DB_PREFIX' )."curriculum c ON c.id = o.curriculum_id")
		      ->where($where)
		      ->limit($page->firstRow . ',' . $page->listRows)
		      ->field('o.* , ou.user_nicename , ou.mobile, c.curriculum_name ,ou.zs_name')
		      ->order("$_GET[sort_field] $_GET[sort_by],o.id DESC")
		      ->select();
       
        $this->assign("Page", $page->show('Admin'));
		$this->assign("formget",$results['get']);
		$this->assign("list",$list);
        
		$this->display();
	}
    
    //订单详情
    public function order_view () {
        $id = intval(I("get.id"));
        $order = M("order")
            ->alias("o")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = o.uid")
            ->join(C ( 'DB_PREFIX' )."curriculum c ON c.id = o.curriculum_id")
            ->where("o.id='$id'")
            ->field('o.* , ou.user_nicename , ou.mobile, ou.zs_name, c.*')
            ->find();
       
        $this->assign("order",$order);
        
        $this->display();
    }
    
    //发货
    public function add_post () {
        $id = intval(I("post.order_id"));
        $post = I("post.post");
        $post['order_state'] = 10;
        if (M("order")->where("id='$id'")->save($post)) {
			$this->success("保存成功！");
		} else {
			$this->error("保存失败！");
		}
    }
    
    
    //提交编辑
    public function edit_post () {
        $post = $_POST['post'];
        $id = intval(I("post.id"));
        $result = M("goods")->where("id = '$id'")->save($post);
		if ($result !== false) {
			$this->success("保存成功！");
		} else {
			$this->error("保存失败！");
		}
    }
    
}