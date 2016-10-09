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
class ProtypeController extends AdminbaseController {
    
    protected $goods_class;
	function _initialize() {
		parent::_initialize();
        $this->goods_class =  M("goods_class");
        $this->itypes = array('1' => '下拉框', '5' => '多选框', '10'=>'输入框');
        $this->goods_class_attr = M("goods_class_attr");
        $this->goods_class_value = M("goods_class_value");
		
	}
	function index(){
	    //父级ID
        $parent_id = empty($_POST['parent_id'])?intval(I("get.parent_id")):intval($_POST['parent_id']);
        $_GET['parent_id'] = $parent_id;
        
        //根据父级ID判断层次级别，限制三级
        $now_cen = $this->search_three($parent_id);
        $this->assign("now_cen",$now_cen);   
        
        //返回上级
        if ($parent_id != 0 ) {
            $parent = $this->goods_class->where("id='$parent_id'")->find();
            $parentsid = $parent['parent_id'];
            $this->assign("parentsid",$parentsid);
        }
        
        //条件
		$where_ands=array('0' => "parent_id='$parent_id'");
		$fields=array(
				'keyword'  => array("field"=>"name,`describe`","operator"=>"like"),
		);
		$results = $this->public_search($where_ands,$fields);
        $where = $results['where'];
        
        
        //数据
		$count=$this->goods_class->where($where)->count();
		$page = $this->page($count, 10);
        
		$list=$this->goods_class
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("listorder DESC, id ASC")
        ->select();
        
        $parent_name = $this->parent($parent_id);
        $this->assign("parent_name",$parent_name);
        $this->assign("parent_id",$parent_id);
        
		$this->assign("Page", $page->show('Admin'));
		$this->assign("formget",$results['get']);
		$this->assign("list",$list);
        
		$this->display();
	}
    
    //增加类别
    function add () {
        $parent_id = intval(I("get.parent_id"));
        $parent_name = '';
        $parent_name = $this->parent($parent_id);
        $this->assign("parent_name",$parent_name);
        $this->assign("parent_id",$parent_id);
        
		$this->display();
    }
    
    function add_post () {
        $post = $_POST['post'];
        $post['img'] = $_POST['smeta']['thumb'];
        $post['first'] = strtoupper($post['first']);
        
        if ($this->goods_class->add($post)) {
			$this->success("添加成功！");
		} else {
			$this->error("添加失败！");
		}
    }
    
    //修改
    public function edit(){
		$id        =  intval(I("get.id"));
        $parent_id =  intval(I("get.parent_id"));
		$list=$this->goods_class->where("id=$id")->find();
        
        $parent_id = $list['parent_id'];
        $parent_name = $this->parent($parent_id);
        $list['parent_name'] = $parent_name;

		$this->assign($list);
		$this->display();
	}
	
	public function edit_post(){
		if (IS_POST) {
			$post_id = $_POST['id'];
            
			$post = $_POST['post'];
            $post['img'] = $_POST['smeta']['thumb'];
            $post['first'] = strtoupper($post['first']);
			$result = $this->goods_class->where("id = '$post_id'")->save($post);
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
            if ($this->goods_class->where("parent_id=$id")->select()) {
				$this->error("请先删除子类");
                return false;
			}
			if ($this->goods_class->where("id=$id")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
        if(isset($_POST['ids'])){
			$ids=join(",",$_POST['ids']);
            if ($this->goods_class->where("parent_id in ($ids)")->select()) {
				$this->error("请先删除子类");
                return false;
			}
			if ($this->goods_class->where("id in ($ids)")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
    }
    
    //显示
    function check(){
		if(isset($_POST['ids']) && intval($_GET["check"])){
			$data["is_index"]=1;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods_class->where("id in ($ids)")->save($data)!==false) {
				$this->success("审核成功！");
			} else {
				$this->error("审核失败！");
			}
		}
		if(isset($_POST['ids']) && intval($_GET["uncheck"])){
			$data["is_index"]=0;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods_class->where("id in ($ids)")->save($data)) {
				$this->success("取消审核成功！");
			} else {
				$this->error("取消审核失败！");
			}
		}
	}
    
    function parent ($parent_id) {
        //父级
        $parent_name = '';
        if ($parent_id == 0) {
            $parent_name = '此为一级';
        } else {
            $parent = $this->goods_class->where("id='$parent_id'")->find();
            $parent_name = $parent['name'];
        }
        return $parent_name;
    }
    
    /**
     * 商品属性及其扩展
     **/ 
    public function class_attr () {
        $class_id = empty($_POST['class_id'])?intval(I("get.class_id")):intval($_POST['class_id']);
        $this->assign("class_id",$class_id);
        
        //条件
		$where_ands=array('0' => "class_id='$class_id'");
		$fields=array(
				'keyword'  => array("field"=>"name","operator"=>"like"),
		);
		$results = $this->public_search($where_ands,$fields);
        $where = $results['where'];

        //数据
		$count=$this->goods_class_attr->where($where)->count();
		$page = $this->page($count, 10);
        
		$list=$this->goods_class_attr
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("id DESC")
        ->select();
        
        //取值
        foreach ($list as $k=>$v) {
            $parent = $this->goods_class->where("id='$class_id'")->find();
            $list[$k]['class_name'] = $parent['name'];
            
            $attr_id = $v['id'];
            $class_value = $this->goods_class_value->where("attr_id='$attr_id'")->field("name")->order("id ASC")->select();
            $class_values = implode('/',$this->deal_key_array($class_value));
            $list[$k]['value'] = $class_values;
        }
        
        $this->assign("list",$list);
        $this->assign("itypes",$this->itypes);
        $this->assign("Page", $page->show('Admin'));
		$this->assign("formget",$results['get']);
        
        $this->display();
    }
    
    //添加商品属性
    public function class_attr_add () {
        $class_id = intval(I("get.class_id"));
        //找类别
        $parent = $this->goods_class->where("id='$class_id'")->find();
        $parent_name = $parent['name'];
        $this->assign("parent_name",$parent_name);
        $this->assign("class_id",$class_id);
        
        $this->assign("itypes",$this->itypes);
        
        $this->display();
    }
    
    //提交增加
    public function class_attr_add_post () {
        $post = $_POST['post'];
        $value = explode("\r",$_POST['value']);
        $id = $this->goods_class_attr->add($post);
        if ($id) {
            foreach ($value as $k=>$v) {
                $this->goods_class_value->add(array('attr_id'=>$id,'name'=>$v));
            }
			$this->success("添加成功！");
		} else {
			$this->error("添加失败！");
		}
    }
    
    //处理数组键
    function deal_key_array($arr) {
        $result = array();
        foreach ($arr as $k0=>$v0) {
            $result[] = $v0['name'];
        }
        return $result;
    }
    
    //删除数据
    public function class_attr_delete () {
        if(isset($_GET['id'])){
			$id = intval(I("get.id"));
			if ($this->goods_class_attr->where("id=$id")->delete()) {
                $this->goods_class_value->where("attr_id=$id")->delete();
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
        if(isset($_POST['ids'])){
			$ids=join(",",$_POST['ids']);
			if ($this->goods_class_attr->where("id in ($ids)")->delete()) {
                $this->goods_class_value->where("attr_id in ($ids)")->delete();
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
    }
    
    //显示
    public function class_attr_check () {
        if(isset($_POST['ids']) && intval($_GET["check"])){
			$data["is_show"]=1;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods_class_attr->where("id in ($ids)")->save($data)!==false) {
				$this->success("操作成功！");
			} else {
				$this->error("操作失败！");
			}
		}
		if(isset($_POST['ids']) && intval($_GET["uncheck"])){
			$data["is_show"]=0;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods_class_attr->where("id in ($ids)")->save($data)) {
				$this->success("取消操作成功！");
			} else {
				$this->error("取消操作失败！");
			}
		}
    }
    
    //搜搜
    public function class_attr_search () {
        if(isset($_POST['ids']) && intval($_GET["check"])){
			$data["is_search"]=1;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods_class_attr->where("id in ($ids)")->save($data)!==false) {
				$this->success("操作成功！");
			} else {
				$this->error("操作失败！");
			}
		}
		if(isset($_POST['ids']) && intval($_GET["uncheck"])){
			$data["is_search"]=0;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods_class_attr->where("id in ($ids)")->save($data)) {
				$this->success("取消操作成功！");
			} else {
				$this->error("取消操作失败！");
			}
		}
    }
    
    //修改
    public function class_attr_edit () {
        $id        =  intval(I("get.id"));
		$list=$this->goods_class_attr->where("id=$id")->find();
        
        $attr_id = $list['id'];
        $class_value = $this->goods_class_value->where("attr_id='$attr_id'")->field("name")->select();
        $class_values = implode("\r",$this->deal_key_array($class_value));
        $list['value'] = $class_values;
        $class_id = $list['class_id'];
        //找类别
        $parent = $this->goods_class->where("id='$class_id'")->find();
        $this->assign("parent_name",$parent['name']);
		$this->assign($list);
        $this->assign("itypes",$this->itypes);
        
		$this->display();
    }
    
    public function class_attr_edit_post () {
        $post = $_POST['post'];
        $id = intval($_POST['id']);
        $value = explode("\r",$_POST['value']);
        $this->goods_class_attr->where("id='$id'")->save($post);
        
        $result[] = $this->goods_class_value->where("attr_id=$id")->delete();
        foreach ($value as $k=>$v) {
            $result[] = $this->goods_class_value->add(array('attr_id'=>$id,'name'=>$v));
        }
		if ($result) {
			$this->success("保存成功！");
		} else {
			$this->error("保存失败！");
		}
		
    }
	
}