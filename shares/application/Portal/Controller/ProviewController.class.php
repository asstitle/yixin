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
 * 商品详情
 */
class ProviewController extends HomeBaseController {
	
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
        $id = intval(I("get.id"));
        $goods = $this->goods->where("id='$id'")->find();
        $this->assign("goods",$goods);
        
        //处理图片
        $goods_id = intval($goods['id']);
        $goods_pic = M("goods_pic")->where("goods_id='$goods_id'")->find();
        $imgurl = unserialize($goods_pic['imgurl']);
        $this->assign("imgurl",$imgurl);
        
        //处理规格
        //颜色分组
        $goods_spec = M("goods_spec")->where("goods_id='$goods_id'")->order("id ASC")->group("spec_color")->field("spec_color")->select();
        $this->assign("goods_spec",$goods_spec);
        //默认第一个颜色
        $spec_color = $goods_spec[0]['spec_color'];
        $spec_size = M("goods_spec")->where("goods_id='$goods_id' AND spec_color='$spec_color'")->order("id ASC")->field("spec_size,id")->select();
        $this->assign("spec_size",$spec_size);
        
        //商品人气
        $this->goods->where("id='$id'")->save(array('readno'=>intval($goods['readno']+1)));
        
    	$this->display();
    }
    
    //通过颜色搜索尺码
    public function search_gg () {
        $goods_id = intval(I("get.id"));
        $spec_color = trim(I("post.value"));
        $spec_size = M("goods_spec")->where("goods_id='$goods_id' AND spec_color='$spec_color'")->order("id ASC")->field("spec_size,id")->select();
        $this->ajaxReturn(array('content'=>$spec_size));
    }
    
    //通过尺码搜索所属商品信息
    public function search_goods () {
        $id = intval(I("post.id"));
        $spec_size = M("goods_spec")->where("id='$id'")->find();
        $this->ajaxReturn($spec_size);
    }
    
    
    //库存判断
    function kucun () {
        $type = intval(I("post.type"));
        $num = intval(I("post.num"));
        $size_id = intval(I("post.size_id"));
        $id = intval(I("get.goods_id"));
        $goods = M("goods")->where("id='$id'")->find();
        
        $stock = 0;
        if ($size_id) {
           $spec_size = M("goods_spec")->where("id='$size_id'")->find();
           $stock = intval($spec_size['stock']); 
        }
        
        if (!$stock) {
            $stock = intval($goods['store']);
        }
        
        if ($num > $stock) {
            $this->ajaxReturn(array('error'=>"库存不足"));
            return false;
        }
        
        //是否登录
        $uid = get_current_userid();
        
        //立即购买
        if ($type == 2) {
            if (!$uid) {
                $this->ajaxReturn(array('error'=>"请先登录!",'error_url'=>U('portal/index/login')));
                return false;
            }
            $this->ajaxReturn(array('url'=>U('Probuy/index',array('ids'=>$id,'num'=>$num,'size_id'=>$size_id,'op'=>'dc'))));        
        }
        
        //加入购物车
        if ($type == 3) {
            $this->ajaxReturn(array('success'=>"ok"));
        }
    }   

	
}


