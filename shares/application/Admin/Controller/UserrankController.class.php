<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class UserrankController extends AdminbaseController{
	
	
	
	function _initialize() {
		parent::_initialize();
		
		
	}
	
	function index(){
	   
	    $fields = array(
	        'start_money'=> array("field"=>"curriculum_money","operator"=>">="),
	        'end_money'  => array("field"=>"curriculum_money","operator"=>"<"),
	        'start_xl'=> array("field"=>"sold_number","operator"=>">="),
	        'end_xl'  => array("field"=>"sold_number","operator"=>"<"),
	        'keyword'  => array("field"=>"au.user_nicename , au.mobile ,  au.zs_name","operator"=>"like"),
	    );
	    
	    $where = $this->search($fields);
	    
	    $count =  M('userrank_chage')
	       ->alias("uc")
	       ->join(C ( 'DB_PREFIX' )."oauth_user au ON au.id = uc.active_uid")
	       ->join(C ( 'DB_PREFIX' )."oauth_user uu ON uu.id = uc.up_uid",'left')
	       ->join(C ( 'DB_PREFIX' )."users u ON u.id = uc.operation_id")
	       ->order('uc.chage_date DESC')
	       ->field("uc.* , (au.user_nicename) au_nicename , (au.mobile) au_mobile, (au.zs_name) au_name ,(uu.user_nicename) uu_nicename, (uu.mobile) uu_mobile, (uu.zs_name) uu_name")
	       ->where($where)
	       ->count();
	    
	    $page = $this->page($count, 20);
	    
	    $list = M('userrank_chage')
	       ->alias("uc")
	       ->join(C ( 'DB_PREFIX' )."oauth_user au ON au.id = uc.active_uid")
	       ->join(C ( 'DB_PREFIX' )."oauth_user uu ON uu.id = uc.up_uid",'left')
	       ->join(C ( 'DB_PREFIX' )."users u ON u.id = uc.operation_id")
	       ->order('uc.chage_date DESC')
	       ->field("uc.* , (au.user_nicename) au_nicename , (au.mobile) au_mobile, (au.zs_name) au_name ,(uu.user_nicename) uu_nicename, (uu.mobile) uu_mobile, (uu.zs_name) uu_name, (u.user_nicename) ad_user")
	       ->where($where)
	       ->limit($page->firstRow . ',' . $page->listRows)
	       ->select();
	    
	    //show_bug($list);
	    
		$this->assign('list',$list);
	    $this->assign("page", $page->show('Admin'));
		$this->display();
	}
	
	function chage(){
	    $this->display();
	}
	
	function chage_post(){
	    
	    $active_mobile = I('post.active_mobile');
	    $up_mobile = I('post.up_mobile');
	    $chage_bz = I('post.chage_bz');
	    if(!$active_mobile){
	        $this->error("数据格式有误");
	    }
	    
	    $jg = M('oauth_user')->where(" mobile = '$active_mobile' ")->find();
	    if(!$jg){
	        
	        $this->error("您输入的当前用户不存在");
	        
	    }else {
	        
	        $active_uid = $jg['id'];
	        
	    }
	    
	    if($up_mobile != 0){
	        
	        $jg2 = M('oauth_user')->where(" mobile = '$up_mobile' ")->find();
	        if(!jg2){
	            $this->error("您输入的上级用户不存在");
	        }
	        
	        $up_uid = $jg2['id'];
	        
	    }else{
	        
	        $up_uid = 0;
	        
	    }
	    
	   
	    
	    
	    $data['tjrr'] = $up_uid;
	    $result = M('oauth_user')->where(" id = '$active_uid' ")->save($data);
	    
	    if($result){
	        $chage_date['active_uid'] = $active_uid;
	        $chage_date['up_uid'] = $up_uid;
	        $chage_date['chage_date'] = time();
	        $chage_date['chage_bz'] = $chage_bz;
	        $chage_date['operation_id'] = $_SESSION['adminlogin'];
	        $result2 = M('userrank_chage')->add($chage_date);
	    }
	    
	    
	    if($result2){
	        $this->success("变更成功");
	    }else{
	        $this->error("变更失败");
	    }
	    
	    
	}
	
	
	
	
	
}