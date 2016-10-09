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
/**
 * 商品列表
 */
class ProlistController extends HomeBaseController {
	protected $goods;
    protected $goods_class;
    protected $goods_class_attr;
    protected $goods_class_value;
    
	function _initialize(){
        parent::_initialize();
        $this->goods_class = M("goods_class");
        $this->goods_class_attr = M("goods_class_attr");
        $this->goods_class_value = M("goods_class_value");
        $this->goods = M("goods");
    }
    //商品列表
	public function index() {
        $where = " a.state=2 ";//限制商品条件
        $priceArray = array('1'=>"100—500",'2'=>"500—1000",'3'=>"1000—2000",'4'=>"2000—5000",'5'=>"5000以上");
        //获取分类
        $class_id = empty($_POST['class_id']) ? intval(I("get.class_id")) : intval(I("post.class_id"));
        $id = $class_id;
        $goods_class = M("goods_class")->where("parent_id='$class_id'")->select();
        if (!$goods_class) {
            $goods_class = M("goods_class")->where("id='$class_id'")->find();
            $parent_id   = $goods_class['parent_id'];
            
            $goods_class = M("goods_class")->where("parent_id='$parent_id'")->select();
        }
        
        //品牌传递ID
        $pp_id = intval(I("get.pp_id"));
        $goods_brand_get = M("goods_brand")->where("id='$pp_id'")->find();
        $goods_brand_get && $class_id = intval($goods_brand_get['class_id']);
        $goods_brand_get && $id = intval($goods_brand_get['class_id']);
        //此时产生对商品的限制
        $goods_brand_get && $where .= " AND a.brand_id='$pp_id'";
        
        //根据当前分类取第二级ids
        if ($class_id) {
            $goods_class_idString = $this->search_three($class_id);
            $goods_class_idString && $where .= " AND a.class_id in ($goods_class_idString) ";
            $_GET['class_id'] = $class_id;
        }
        
        //价格
        $price_id = intval(I("get.price_id"));
        //$price = $priceArray[$price_id];
        if ($price_id) {
            if($price_id==5){
                $where .= " AND a.price > 5000";
            }else{
                $ar = explode("—",$priceArray[$price_id]);
                $where .= " AND a.price BETWEEN ".$ar[0]." AND ".$ar[1];
            }
            $_GET['price_id'] = $price_id;
        }
        //关键字
        $keyword = I("request.keyword");
        if($keyword){
            $where .= "AND a.name like '%".$keyword."%'";
        }
        /**
         * 4.排序/选取条件处理------------------------------------------------------------------------------------------
         **/
        
        //排序
        $orderlist = $_GET['orderlist'];
        $px = I("get.px");
        if (!$orderlist) {
            $_GET['orderlist'] = 'readno';
            $orderlist = 'readno';
        }
        if (!$px) {
            $_GET['px'] = 'DESC';
            $px = 'DESC';
        }
        $orderlists = "a.".$orderlist." ".$px;
        
        
        //品牌
        $first_id = 0;//一级ID
        //循环取层级
        for ($n = 0; $n <999; $n++) {
            $list = M("goods_class")->where("id='$id'")->field("id,name,parent_id")->find();
            $result .= $list['name'].",";
            $id = $list['parent_id'];
            if ($id == 0) {
                if ($list['id']) {
                    $first_id = $list['id'];
                }
                break;
            }
        }
        $goods_brand = M("goods_brand")->where("class_id='$first_id' AND is_show=1")->order("id DESC")->select();
        //如果传了单个品牌
        $goods_brand_get && $goods_brand = array('0'=>$goods_brand_get); 
        $this->assign("goods_brand",$goods_brand);
        
        //商品
        $goods_list = $this->goods_list($where,$orderlists);
        
        $this->assign("goods_list",$goods_list);
        $this->assign("goods_class",$goods_class);
        
        //$this->assign("id",$id);
        //$this->assign("first_id",$first_id);
        $this->assign("get",$_GET);
        $this->assign("post",$post);
        $this->assign("orderlist",$orderlist);
        $this->assign("px",$px);
        $this->assign('priceArray',$priceArray);
        
    	$this->display();
    }   
    
    //商品列表显示
    public function goods_list ($where,$orderlists) {
		$goods_list=$this->goods
        ->alias("a")
		->join(C ( 'DB_PREFIX' )."goods_class b ON a.class_id = b.id")
        ->join(C ( 'DB_PREFIX' )."goods_pic c ON a.id = c.goods_id")
        ->where($where)
        ->order("$orderlists")
        ->field("a.*, b.name class_name, c.imgurl")
        ->select();
        
        
        return $goods_list;
    }
}


