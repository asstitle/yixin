<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tuolaji <479923197@qq.com>
// +----------------------------------------------------------------------
/**
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class LmsgController extends AdminbaseController {
	public function index(){
		$count = M('msg')->count();
		$page = $this->page($count, 20);

		$list = M('msg')
		->limit($page->firstRow . ',' . $page->listRows)
		->order('time DESC')
		->select();

		foreach($list as $k => $v){
			$list[$k]['time'] = date("Y-m-d H:i:s", $v['time']);
		}
		$this->assign('Page', $page->show('Admin'));
		$this->assign('list', $list);
		$this->display();
	}

	public function delete(){
		if(isset($_GET['id'])){
			$id = intval(I("get.id"));
            
			if (M("msg")->where("id=$id")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
        if(isset($_POST['ids'])){
			$ids=join(",",$_POST['ids']);
			if (M("msg")->where("id in ($ids)")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	}

	public function check(){
		if(isset($_POST['ids']) && intval($_GET["check"])){
			$data["status"]=1;
			$ids=join(",",$_POST['ids']);
			if ( M("msg")->where("id in ($ids)")->save($data)!==false) {
				$this->success("操作成功！");
			} else {
				$this->error("操作失败！");
			}
		}
		if(isset($_POST['ids']) && intval($_GET["uncheck"])){
			$data["status"]=0;
			$ids=join(",",$_POST['ids']);
			if ( M("msg")->where("id in ($ids)")->save($data)) {
				$this->success("取消操作成功！");
			} else {
				$this->error("取消操作失败！");
			}
		}
	}
}