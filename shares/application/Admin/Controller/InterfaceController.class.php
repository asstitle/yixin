<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class InterfaceController extends AdminbaseController{
	
	
	
	function _initialize() {
		parent::_initialize();
		
		
	}
	
	function index(){
	   
	    $fields = array(
	        'start_money'=> array("field"=>"curriculum_money","operator"=>">="),
	        'end_money'  => array("field"=>"curriculum_money","operator"=>"<"),
	        'start_xl'=> array("field"=>"sold_number","operator"=>">="),
	        'end_xl'  => array("field"=>"sold_number","operator"=>"<"),
	        'keyword'  => array("field"=>"curriculum_name , zs_name","operator"=>"like"),
	    );
	    
	    $where = $this->search($fields);
	    
	    $count =  M('interface_list')
	       ->alias("i")
	       ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = i.uid")
	       ->join(C ( 'DB_PREFIX' )."curriculum c ON c.id = i.curriculum_id")
	       ->join(C ( 'DB_PREFIX' )."users u ON u.id = i.operation_id")
	       ->where($where)
	       ->order('i.add_date DESC')
	       ->count();
	    
	    $page = $this->page($count, 20);
	    
	    $list = M('interface_list')
	       ->alias("i")
	       ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = i.uid")
	       ->join(C ( 'DB_PREFIX' )."curriculum c ON c.id = i.curriculum_id")
	       ->join(C ( 'DB_PREFIX' )."users u ON u.id = i.operation_id")
	       ->order('i.add_date DESC')
	       ->field("i.* , ou.zs_name , ou.mobile, c.curriculum_name ,u.user_nicename")
	       ->where($where)
	       ->limit($page->firstRow . ',' . $page->listRows)
	       ->select();
	    
		$this->assign('list',$list);
	    $this->assign("page", $page->show('Admin'));
		$this->display();
	}
	
	function add(){
	    $this->display();
	}
	
	function add_post(){
	   
	    $curriculum_name = I('post.curriculum_name');
	    $uid = I('post.uid');
	    $interface_bz = I('post.interface_bz');
	    
	    if(!$curriculum_name || !$uid ){
	        $this->error('参数有误');
	    }
	    
	    $curriculum = M('curriculum')->where(" curriculum_name = '$curriculum_name' ")->find();
	    if(!$curriculum){
	        $this->error("课程不存在");
	    }
	    
	    $user = M('oauth_user')->find($uid);
	    if(!$user){
	        $this->error("用户不存在");
	    }
	    
	    $cid = $curriculum['id'];
	    
	    $jg = M('order')->where("curriculum_id = '$cid' AND uid = '$uid' ")->find();
	    
	    
	    //判断该用户已经下单了的情况
	    if($jg){
	        if($jg['order_state'] == 1){
	            $this->error("该会员已购买了该课程");
	        }else{
	            $oid = $jg['id'];
	            $data['order_state'] = 1 ;
	            $data['pay_date'] = time();
	            $result = M('order')->where("id = '$oid' ")->save($data);
	            if($result){
	                $Interface_date = array(
	                    'order_id' => $oid,
	                    'uid'      => $uid,
	                    'curriculum_id' => $cid,
	                    'interface_bz'  => $interface_bz,
	                    'add_date'      => time(),
	                    'operation_id' => $_SESSION['adminlogin']
	                );
	                
	                $jg2 = M('interface_list')->add($Interface_date);
	                if($jg2){
	                    $this->success("添加成功");
	                }else{
	                    $this->error("添加失败");
	                }
	            }
	           
	        }
	    }else{
	        
	        $data['uid'] = $uid;
	        $data['order_state'] = 1;
	        $data['order_date'] = time();
	        $data['pay_date'] = time();
	        $data['curriculum_id'] = $cid;
	        $data['order_money'] = $curriculum['curriculum_money'];
	        $result = M('order')->add($data);
	        
	        if($result){
	            $new_order = M('order')->where(" uid = '$uid' AND curriculum_id = '$cid' AND order_state = 1 ")->find();
	            $Interface_date = array(
	                'order_id' => $new_order['id'],
	                'uid'      => $uid,
	                'curriculum_id' => $cid,
	                'interface_bz'  => $interface_bz,
	                'add_date'      => time(),
	                'operation_id' => $_SESSION['adminlogin']
	            );
	            
	            $jg2 = M('interface_list')->add($Interface_date);
	            if($jg2){
	                $this->success("添加成功");
	            }else{
	                $this->error("添加失败");
	            }
	            
	        }
  
	    }
	    
	    
	  
	}
	
	
	
}