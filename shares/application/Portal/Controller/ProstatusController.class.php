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
class ProstatusController extends AdminbaseController {
    
    protected $goods_class;
	function _initialize() {
		parent::_initialize();
        $this->goods = M("goods");
		
	}
	function index(){
	    $is_statusArr = array('1'=>'未上架','2'=>'已上架');
        $this->assign("is_statusArr",$is_statusArr);
        
        
        //商品显示条件
        $where_ands = array();
        $fields=array(
				'keyword'       => array("field"=>"a.name","operator"=>"like"),//名称
                'keyword2'      => array("field"=>"a.goods_bh","operator"=>"like"),//编号
                
                'goods_type'    => array("field"=>"a.class_id","operator"=>"in"),//商品分类
                
                'start_price'   => array("field"=>"a.price","operator"=>">="),//价格区间
				'end_price'     => array("field"=>"a.price","operator"=>"<="),//价格区间
                'start_xl'      => array("field"=>"a.saleno","operator"=>">="),//销量区间
				'end_xl'        => array("field"=>"a.saleno","operator"=>"<="),//销量区间
                
                'is_status'     => array("field"=>"a.is_status","operator"=>"="),//是否上架
		);
		$results = $this->public_search2($where_ands,$fields);
        $where = $results['where'];
        //数据
		$count=$this->goods
        ->alias("a")
		->join(C ( 'DB_PREFIX' )."goods_class b ON a.class_id = b.id")
        ->join(C ( 'DB_PREFIX' )."goods_pic c ON a.id = c.goods_id")
        ->where($where)
        ->count();
        
		$page = $this->page($count, 10);
        
		$list=$this->goods
        ->alias("a")
		->join(C ( 'DB_PREFIX' )."goods_class b ON a.class_id = b.id")
        ->join(C ( 'DB_PREFIX' )."goods_pic c ON a.id = c.goods_id")
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("a.listorder DESC,a.id DESC")
        ->field("a.*, b.name class_name, c.imgurl")
        ->select();
       
        $this->assign("Page", $page->show('Admin'));
		$this->assign("formget",$results['get']);
		$this->assign("list",$list);
        
		$this->display();
	}
    
    //编辑商品
    public function edit () {
        $id = intval(I("get.id"));
        $goods = M("goods")->where("id='$id'")->find();
        $this->assign($goods);
        
        $this->display();
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
    
    function delete(){
        if(isset($_GET['id'])){
			$id = intval(I("get.id"));
            
			if ($this->goods->where("id=$id")->delete()) {
			     M("goods_attr")->where("goods_id='$id'")->delete();
                 M("goods_spec")->where("goods_id='$id'")->delete();
                 M("goods_pic")->where("goods_id='$id'")->delete();
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
        if(isset($_POST['ids'])){
			$ids=join(",",$_POST['ids']);
			if ($this->goods->where("id in ($ids)")->delete()) {
			    M("goods_attr")->where("goods_id in ($id)")->delete();
                M("goods_spec")->where("goods_id in ($id)")->delete();
                M("goods_pic")->where("goods_id in ($id)")->delete(); 
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
    }
    
    //推荐首页
    function is_index () {
		if(isset($_POST['ids']) && intval($_GET["check"])){
			$data["is_index"]=1;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods->where("id in ($ids)")->save($data)!==false) {
				$this->success("操作成功！");
			} else {
				$this->error("操作失败！");
			}
		}
		if(isset($_POST['ids']) && intval($_GET["uncheck"])){
			$data["is_index"]=0;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods->where("id in ($ids)")->save($data)) {
				$this->success("取消操作成功！");
			} else {
				$this->error("取消操作失败！");
			}
		}
	}
    
    //推荐搜索结果页
    function is_search () {
		if(isset($_POST['ids']) && intval($_GET["check"])){
			$data["is_tg"]=1;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods->where("id in ($ids)")->save($data)!==false) {
				$this->success("操作成功！");
			} else {
				$this->error("操作失败！");
			}
		}
		if(isset($_POST['ids']) && intval($_GET["uncheck"])){
			$data["is_tg"]=0;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods->where("id in ($ids)")->save($data)) {
				$this->success("取消操作成功！");
			} else {
				$this->error("取消操作失败！");
			}
		}
	}
    
    //审核
    function check(){
		if(isset($_POST['ids']) && intval($_GET["check"])){
			$data["state"] = 2;
            $data["sj_date"] = time();
            $data["is_status"] = 2;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods->where("id in ($ids)")->save($data)!==false) {
				$this->success("操作成功！");
			} else {
				$this->error("操作失败！");
			}
		}
		if(isset($_POST['ids']) && intval($_GET["uncheck"])){
			$data["state"]=1;
             $data["sj_date"] = "";
             $data["is_status"] = 1;
			$ids=join(",",$_POST['ids']);
			if ( $this->goods->where("id in ($ids)")->save($data)) {
				$this->success("取消操作成功！");
			} else {
				$this->error("取消操作失败！");
			}
		}
	}
    
    
    /**
     * 发布商品-----------------------------------------------
    **/
    public function release () {
        //显示第一列
        $list = M("goods_class")->where("parent_id=0")->order("listorder DESC")->field("id,name,parent_id")->select();
        $this->assign("list",$list);
        $this -> display();
    }
    
    
    //商品类别搜索
    public function release_search () {
        $value = I("post.value");
        $parent_id = I("post.parent_id");
        $where = "";
        $where .= " parent_id='$parent_id' ";
        $value && $where .= " AND ( name like '%$value%' OR first like '%$value%')";
        //var_dump($where);
        if ($where) {
            $list = M("goods_class")->where($where)->order("listorder DESC")->field("id,name,parent_id")->select();
            $this->ajaxreturn(array('content'=>$list));
        }
    }
    
    //搜索下一个商品分类
    public function nextgoods_search () {
        $id = I("post.id");
        $list = M("goods_class")->where("parent_id='$id'")->order("listorder DESC")->field("id,name,parent_id")->select();
        $this->ajaxreturn(array('content'=>$list));
    }
     
    //显示选择结果
    public function resultgoods_search () {
        $id = I("post.id");
        $bl_id = $id;
        $result = "";
        $first_id = 0;//一级ID
        //循环取层级
        for ($n = 0; $n <999; $n++) {
            $list = M("goods_class")->where("id='$id'")->field("id,name,parent_id")->find();
            $result .= $list['name'].",";
            $id = $list['parent_id'];
            if ($id == 0) {
                $first_id = $list['id'];
                break;
            }
        }
        $result = explode(',',substr($result,0,strlen($result)-1));
        krsort($result);//逆向排序
        $result = implode(' > ',$result);
        $this->ajaxreturn(array('result'=>$result,'goods_id'=>$bl_id,'first_id'=>$first_id));
    }
    
    //显示添加商品页面
    public function add_goods () {
        $this->information();
        
        $this -> display();
    }
    
    //提交商品
    public function add_goods_post () {
        $post = I("post.post");
        $goods_bh = $this->goods_bg();
        $post['state']  = 1;
        $post['describe'] = htmlspecialchars_decode($_POST['describe']);
        $post['date'] = time();
        $post['goods_bh'] = $goods_bh;
        $post['is_status'] = 1;
        
        $goods_id = M("goods")->add($post);
        if ($goods_id) {
            //存商品图片
            $imgurl = serialize($_POST['imgurl']);
            M("goods_pic")->add(array('goods_id'=>$goods_id,'imgurl'=>$imgurl));
            
            //存扩展信息
            $attr_id = $_POST['attr_id'];
            $sattr_id = $_POST['sattr_id'];
            foreach ($attr_id as $k=>$v) {
                if ($sattr_id[$k]) {
                    M("goods_attr")->add(array('goods_id'=>$goods_id,'attr_id'=>$v,'val'=>trim($sattr_id[$k])));
                }
            }
            
            //规格信息
            $spec_color = $_POST['spec_color'];
            foreach ($spec_color as $k=>$v) {
                $arr = array(
                    'goods_id'      =>  $goods_id,
                    'spec_color'    =>  $v,
                    'spec_size'     =>  $_POST['spec_size'][$k],
                    'price'         =>  $_POST['price'][$k],
                    'stock'         =>  $_POST['stock'][$k],
                    'itemno'        =>  $_POST['itemno'][$k],
                );
                M("goods_spec")->add($arr);
            }
            $this->success("添加成功");
		} else {
			$this->error("添加失败");
		}
    }
    
    //搜索运费模板详情
    public function logisticsser () {
        $transport_types = array('1'=>"快递",'2'=>"EMS",'3'=>"平邮");
        $valuation_type = array('1'=>"件",'2'=>"kg",'3'=>"m³");
        $id = intval(I("post.id"));
        $data = array();
        
        $express_template = M("express")->where("id='$id'")->find();
        
        //卖家是否包邮
        if ($express_template['shipping'] == 1) {
            $data['shipping'] = 1;
            
            $transport_type = explode(',',$express_template['transport_type']);
            foreach ($transport_type as $k=>$v) {
                $data['name'][] = $transport_types[$v];
            }
            
            //如果有选择快递
            if (in_array(1,$transport_type)) {
                $data['calculation1'] = unserialize($express_template['calculation1']);
            }
            
            //如果有选择EMS
            if (in_array(2,$transport_type)) {
                $data['calculation2'] = unserialize($express_template['calculation2']);
            }
            
            //如果有选择平邮
            if (in_array(3,$transport_type)) {
                $data['calculation3'] = unserialize($express_template['calculation3']);
            }
            $data['valuation_type'] = $valuation_type[$express_template['valuation_type']];
            
        } else {
            //卖家包邮
            $data['shipping'] = 2;
        }
        
        $this->ajaxreturn($data);
    }
    
    
    /**
     * 商品修改
     * 
     **/
    //分类显示 
    public function edit_release () {
        $id = intval(I("get.id"));
        $class_id = M("goods")->where("id='$id'")->field("class_id")->find();
        $class_id = $class_id['class_id'];
        
        $class_id_fi = M("goods_class")->where("id='$class_id'")->field("parent_id")->find();
        $class_id_fi = $class_id_fi['parent_id'];
        //显示第一列
        $list = M("goods_class")->where("parent_id=0")->order("listorder DESC")->field("id,name,parent_id")->select();
        $this->assign("list",$list);
        
        //第一、二、三id 
        $this->assign("class_id_fi",$class_id_fi);
        $this->assign("class_id_se",$class_id);
        $this->assign("id",$id);
        
        $this->display();
    }
    
    
    //显示商品信息修改
    public function edit_goods () {
        $this->information();
        
        //查询已存商品信息
        $goods_id = intval(I("get.goods_id"));
        $goods = M("goods")->where("id='$goods_id'")->find();
        $this->assign("goods",$goods);
        $this->assign("goods_id",$goods_id);
        
        $this -> display();
    }
    
    
    
    //提交修改
    public function edit_goods_post () {
        $post = I("post.post");
        //$post['state']  = 0;
        $post['describe'] = htmlspecialchars_decode($_POST['describe']);
        //$post['is_status'] = 1;
        
        $goods_id = intval(I("post.goods_id"));
        if (M("goods")->where("id='$goods_id'")->save($post)) {
            //存商品图片
            M("goods_pic")->where("goods_id='$goods_id'")->delete();
            $imgurl = serialize($_POST['imgurl']);
            M("goods_pic")->add(array('goods_id'=>$goods_id,'imgurl'=>$imgurl));
            
            //存扩展信息
            M("goods_attr")->where("goods_id='$goods_id'")->delete();
            $attr_id = $_POST['attr_id'];
            $sattr_id = $_POST['sattr_id'];
            foreach ($attr_id as $k=>$v) {
                M("goods_attr")->add(array('goods_id'=>$goods_id,'attr_id'=>$v,'val'=>trim($sattr_id[$k])));
            }
            
            //规格信息
            M("goods_spec")->where("goods_id='$goods_id'")->delete();
            $spec_color = $_POST['spec_color'];
            foreach ($spec_color as $k=>$v) {
                $arr = array(
                    'goods_id'      =>  $goods_id,
                    'spec_color'    =>  $v,
                    'spec_size'     =>  $_POST['spec_size'][$k],
                    'price'         =>  $_POST['price'][$k],
                    'stock'         =>  $_POST['stock'][$k],
                    'itemno'        =>  $_POST['itemno'][$k],
                );
                M("goods_spec")->add($arr);
            }
            
            $this->success("修改成功");
		} else {
			$this->error("修改失败");
		}
    }
    
    
    //商品公用信息
    function information () {
        $uid = get_current_userid();
        $sellerid = intval(I("get.sellerid"));
        $first_id = intval(I("get.first_id"));
        
        //当前商品分类品牌
        $goods_brand = M("goods_brand")->where("class_id='$first_id'")->select();
        $this->assign("goods_brand",$goods_brand);
        //当前商品分类属性
        $list=M("goods_class_attr")
        ->where("class_id='$first_id' AND is_show=1 ")
        ->order("id DESC")
        ->select();
        
        //取值
        foreach ($list as $k=>$v) {
            $attr_id = $v['id'];
            $class_value =M("goods_class_value")->where("attr_id='$attr_id'")->order("id ASC")->select();
            $list[$k]['value'] = $class_value;
        }
        $this->assign("sellerid",$sellerid);
        $this->assign("list",$list);
        
        //获取物流模板
        
        $express_template = M("express")->where("1=1")->select();
        $this->assign("express_template",$express_template);
        
    } 
    
    
    //排序
	public function listorders() {
	   $status = array();
        $ids = I("post.ids");
        $listorders = I("post.listorders");
        
        foreach ($ids as $k=>$v) {
            $status[] = M("goods")->where("id='$v'")->save(array('listorder'=>$listorders[$v]));
        }
        
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
}