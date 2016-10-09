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
class ExpressController extends AdminbaseController {
    
    
	function _initialize() {
		parent::_initialize();
		
	}
	function index(){
        //积分显示条件
        $where_ands = array();
        $fields=array(
				'keyword'       => array("field"=>"name","operator"=>"like"),//模板名称
		);
        $results = $this->public_search2($where_ands,$fields);
        $where = $results['where'];
        
        //数据
		$count = M("express")->where($where)->count();
		$page = $this->page($count, 10);
        
		$list = M("express")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("id DESC")->select();
       
        $this->assign("Page", $page->show('Admin'));
		$this->assign("formget",$results['get']);
		$this->assign("list",$list);
        
		$this->display();
	}
    
    //添加产品
    public function add () {
        $id = intval(I("get.id"));
        if ($id && $id!=0) {
            $goods = M("express")->where("id='$id'")->find();
            $goods['calculation1'] = unserialize($goods['calculation1']);
            $goods['calculation2'] = unserialize($goods['calculation2']);
            $goods['calculation3'] = unserialize($goods['calculation3']);
            $this->assign($goods);
        }
        
        $this->display();
    }
    
    //提交添加
    public function add_post () {
        $id = intval(I("post.id"));
        $post = I("post.post");
        $post['calculation1'] = serialize(I("post.calculation1"));
        $post['calculation2'] = serialize(I("post.calculation2"));
        $post['calculation3'] = serialize(I("post.calculation3"));
        
        $result = '';
        if ($id) {
            $result = M("express")->where("id='$id'")->save($post);
        } else {
            $post['isshow'] = 1;
            $result = M("express")->add($post);
        }
        
        if ($result) {
			$this->success("提交成功！");
		} else {
			$this->error("提交失败！");
		}
    }
    
    //删除产品
    public function delete () {
        if(isset($_GET['id'])){
			$id = intval(I("get.id"));
            
			if (M("express")->where("id=$id")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
        if(isset($_POST['ids'])){
			$ids=join(",",$_POST['ids']);
			if (M("express")->where("id in ($ids)")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
    }
    
    //推荐
    function check(){
		if(isset($_POST['ids']) && intval($_GET["check"])){
			$data["isshow"]=1;
			$ids=join(",",$_POST['ids']);
			if ( M("express")->where("id in ($ids)")->save($data)!==false) {
				$this->success("操作成功！");
			} else {
				$this->error("操作失败！");
			}
		}
		if(isset($_POST['ids']) && intval($_GET["uncheck"])){
			$data["isshow"]=0;
			$ids=join(",",$_POST['ids']);
			if ( M("express")->where("id in ($ids)")->save($data)) {
				$this->success("取消操作成功！");
			} else {
				$this->error("取消操作失败！");
			}
		}
	}
    
    
}