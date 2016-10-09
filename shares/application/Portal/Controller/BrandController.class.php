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
class BrandController extends AdminbaseController {
    
    protected $goods_class;
	function _initialize() {
		parent::_initialize();
        $this->goods_class = M("goods_class");
        $this->goods_brand = M("goods_brand");
		
	}
	function index(){
	    
        //条件
		$where_ands=array();
		$fields=array(
				'keyword'  => array("field"=>"a.name,a.intro,a.first,b.name","operator"=>"like"),
		);
		$results = $this->public_search($where_ands,$fields);
        $where = $results['where'];
        
        
        //数据
		$count=$this->goods_brand
        ->alias("a")
		->join(C ( 'DB_PREFIX' )."goods_class b ON a.class_id = b.id")
        ->where($where)
        ->count();
        
		$page = $this->page($count, 10);
        
		$list=$this->goods_brand
        ->alias("a")
		->join(C ( 'DB_PREFIX' )."goods_class b ON a.class_id = b.id")
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("a.id DESC")
        ->field("a.*,b.name parent_name")
        ->select();
        
		$this->assign("Page", $page->show('Admin'));
		$this->assign("formget",$results['get']);
		$this->assign("list",$list);
        
		$this->display();
	}
    
    //增加商品品牌
    function add () {
        $list = $this->goods_class->where("parent_id=0")->field("id,name")->select();
        $this->assign("list",$list);
        
		$this->display();
    }
    
    function add_post () {
        $post = $_POST['post'];
        $post['logo'] = $_POST['smeta']['thumb'];
        $post['first'] = strtoupper($post['first']);
        
        if ($this->goods_brand->add($post)) {
			$this->success("添加成功！");
		} else {
			$this->error("添加失败！");
		}
    }
    
    //修改
    public function edit(){
        $list_class = $this->goods_class->where("parent_id=0")->field("id,name")->select();
        $this->assign("list_class",$list_class);
        
		$id        =  intval(I("get.id"));
		$list=$this->goods_brand->where("id=$id")->find();
		$this->assign($list);
        
		$this->display();
	}
	
	public function edit_post(){
		if (IS_POST) {
			$post_id = $_POST['id'];
            
			$post = $_POST['post'];
            $post['logo'] = $_POST['smeta']['thumb'];
            $post['first'] = strtoupper($post['first']);
			$result = $this->goods_brand->where("id = '$post_id'")->save($post);
			if ($result !== false) {
				$this->success("保存成功！");
			} else {
				$this->error("保存失败！");
			}
		}
	}
    
    function delete(){
        if(isset($_GET['id'])){
			$id = intval(I("get.id"));
            
			if ($this->goods_brand->where("id=$id")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
        if(isset($_POST['ids'])){
			$ids=join(",",$_POST['ids']);
			if ($this->goods_brand->where("id in ($ids)")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
    }
    
    //推荐
    function is_index(){
		if(isset($_POST['ids']) && intval($_GET["check"])){
			$data["is_index"]=1;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods_brand->where("id in ($ids)")->save($data)!==false) {
				$this->success("操作成功！");
			} else {
				$this->error("操作失败！");
			}
		}
		if(isset($_POST['ids']) && intval($_GET["uncheck"])){
			$data["is_index"]=0;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods_brand->where("id in ($ids)")->save($data)) {
				$this->success("取消操作成功！");
			} else {
				$this->error("取消操作失败！");
			}
		}
	}
    
    //推荐
    function check(){
		if(isset($_POST['ids']) && intval($_GET["check"])){
			$data["is_show"]=1;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods_brand->where("id in ($ids)")->save($data)!==false) {
				$this->success("操作成功！");
			} else {
				$this->error("操作失败！");
			}
		}
		if(isset($_POST['ids']) && intval($_GET["uncheck"])){
			$data["is_show"]=0;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods_brand->where("id in ($ids)")->save($data)) {
				$this->success("取消操作成功！");
			} else {
				$this->error("取消操作失败！");
			}
		}
	}
    
}