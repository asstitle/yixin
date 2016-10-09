<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class CurriculumController extends AdminbaseController{
	
	protected $curriculum;
	
	function _initialize() {
		parent::_initialize();
		$this->curriculum = M("curriculum");
		
	}
	
	function index(){
	    
	    $fields = array(
	        'start_money'=> array("field"=>"curriculum_money","operator"=>">="),
	        'end_money'  => array("field"=>"curriculum_money","operator"=>"<"),
	        'start_xl'=> array("field"=>"sold_number","operator"=>">="),
	        'end_xl'  => array("field"=>"sold_number","operator"=>"<"),
	        'keyword'  => array("field"=>"curriculum_name","operator"=>"like"),
	    );
	     
	    $where = $this->search($fields);
	    
	    $count = $this->curriculum
	       ->where($where)
	       ->order('listorder ASC')
	       ->count();
	    
	    $page = $this->page($count, 20);
	    
	    $list = $this->curriculum
	       ->where($where)
	       ->limit($page->firstRow . ',' . $page->listRows)
	       ->order('listorder ASC')
	       ->select();
	    
	    $this->assign('list',$list);
	    $this->assign("page", $page->show('Admin'));
		$this->display();
	}
	
	function add(){
	    $this->display();
	}
	
	function add_post(){
	   $data['curriculum_money'] = I('post.curriculum_money');
	   $data['curriculum_name'] = I('post.curriculum_name');
	   $data['one_level'] = I('post.one_level');
	   $data['two_level'] = I('post.two_level');
	   $data['three_level'] = I('post.three_level');
	   $data['sold_number'] = I('post.sold_number');
	   $data['curriculum_status'] = I('post.curriculum_status');
	   $data['curriculum_content'] = I('post.curriculum_content');
	   $imgurl = I('post.imgurl');
	   $ksname = I('post.ksname');
	   $kslink = I('post.kslink');
	   
	   $data['teacher_name'] = I('post.teacher_name');
	   $data['curriculum_number'] = I('post.curriculum_number');
	   $data['student_number'] = I('student_number');
	   $data['teacher_pic'] = I('post.teacher_pic');
	   $data['teacher_content'] = I('post.teacher_content');
	   
	   if(strlen($curriculum_name)>30){
	       //echo '课程名过长';
	      $this->ajaxReturn(array('error'=>'课程名过长'));
	   }
	   
	   if(!is_numeric($data['curriculum_money'])){
	      // echo '课程价格格式有误';
	      $this->ajaxReturn(array('error'=>'课程价格格式有误'));
	   }
	   if(!is_numeric($data['one_level'])){
	       //echo '一级分佣价格格式有误';
	      $this->ajaxReturn(array('error'=>'一级分佣价格格式有误'));
	   }
	   if(!is_numeric($data['two_level'])){
	       //echo '二级分佣价格格式有误';
	       $this->ajaxReturn(array('error'=>'二级分佣价格格式有误'));
	   }
	   if(!is_numeric($data['three_level'])){
	       //echo '三级分佣价格格式有误';
	       $this->ajaxReturn(array('error'=>'三级分佣价格格式有误'));
	   }
	   if(!$data['sold_number']){
	       $data['sold_number'] = 0; 
	   }else{
	       if(!is_numeric($data['sold_number'])){
	           //echo  '已售出数量格式有误';
	           $this->ajaxReturn(array('error'=>'已售出数量格式有误'));
	       }
	   }
	   
	   $ks_list = array();
	   
	   foreach ($ksname as $keys => $vo){
	       if($vo){
	           $ks_list[$vo] = $kslink[$keys];
	       }   
	   }
	   $data['ks_list'] = json_encode($ks_list);
	   $data['curriculum_pic'] = json_encode($imgurl);
        
	   
	   $jg = $this->curriculum->add($data);
	   if($jg){
	       $this->success('添加成功', U("Curriculum/index"));
	   }else{
	       $this->error('添加失败');
	   }
	  
	}
	
	function edit(){
		$id = I('get.id');
		
		if(!is_numeric($id)){
		    
		    $this->error('参数错误');
		}
		
		$curriculum_active = $this->curriculum->where("id = '$id' ")->find();
		
		$this->assign('curriculum_active',$curriculum_active);
		
		$this->display();
	}
	
	function edit_post(){
		
	    $id = I('post.id');
	    $data['curriculum_money'] = I('post.curriculum_money');
	    $data['curriculum_name'] = I('post.curriculum_name');
	    $data['one_level'] = I('post.one_level');
	    $data['two_level'] = I('post.two_level');
	    $data['three_level'] = I('post.three_level');
	    $data['sold_number'] = I('post.sold_number');
	    $data['curriculum_status'] = I('post.curriculum_status');
	    $data['curriculum_content'] = I('post.curriculum_content');
	    $imgurl = I('post.imgurl');
	    $ksname = I('post.ksname');
	    $kslink = I('post.kslink');
	    
	    $data['teacher_name'] = I('post.teacher_name');
	    $data['curriculum_number'] = I('post.curriculum_number');
	    $data['student_number'] = I('student_number');
	    if(I('post.teacher_pic')){
	        $data['teacher_pic'] = I('post.teacher_pic');
	    }
	   
	    $data['teacher_content'] = I('post.teacher_content');
	    
	   //$this->ajaxReturn(array('error'=>$imgurl));
	   
	    if(strlen($curriculum_name)>30){
	        echo '课程名过长';
	        //$this->ajaxReturn(array('error'=>'课程名过长'));
	    }
	    
	    if(!is_numeric($data['curriculum_money'])){
	        // echo '课程价格格式有误';
	        $this->ajaxReturn(array('error'=>'课程价格格式有误'));
	    }
	    if(!is_numeric($data['one_level'])){
	        //echo '一级分佣价格格式有误';
	        $this->ajaxReturn(array('error'=>'一级分佣价格格式有误'));
	    }
	    if(!is_numeric($data['two_level'])){
	        //echo '二级分佣价格格式有误';
	        $this->ajaxReturn(array('error'=>'二级分佣价格格式有误'));
	    }
	    if(!is_numeric($data['three_level'])){
	        //echo '三级分佣价格格式有误';
	        $this->ajaxReturn(array('error'=>'三级分佣价格格式有误'));
	    }
	    if(!$data['sold_number']){
	        $data['sold_number'] = 0;
	    }else{
	        if(!is_numeric($data['sold_number'])){
	            //echo  '已售出数量格式有误';
	            $this->ajaxReturn(array('error'=>'已售出数量格式有误'));
	        }
	    }
	    
	    $ks_list = array();
	    
	    foreach ($ksname as $keys => $vo){
	        if($vo){
	            $ks_list[$vo] = $kslink[$keys];
	        }
	    }
	    $data['ks_list'] = json_encode($ks_list);
	    $data['curriculum_pic'] = json_encode($imgurl);
	    
	    $jg = $this->curriculum->where("id = '$id' ")->save($data);
	    if($jg){
	        $this->success('修改成功', U("Curriculum/index"));
	    }else{
	        $this->error('修改失败');
	    }
	    
	}
	
	function delete(){
		if(isset($_POST['ids'])){

			$ids = implode(",", $_POST['ids']);
			if ($this->curriculum->where("id in ($ids)")->delete()!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}else{
			$id = intval(I("get.id"));
			if ($this->curriculum->delete($id)!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
		
	}
	
	public function status(){
	    $id = I('post.id');
	    $data['curriculum_status'] = I('post.value');
	    if(!is_numeric($id) || !is_numeric($data['curriculum_status'])){
	        $this->ajaxReturn(array('error'=>'数据有误！'));
	    }
	    
	    $jg = $this->curriculum->where("id = '$id' ")->save($data);
	    
	    if($jg){
	        $this->ajaxReturn(array('success'=>'操作成功','f5_active'=>'1111'));
	    }else{
	        $this->ajaxReturn(array('error'=>'操作失败','f5_active'=>'1111'));
	    }
	    
	}
	
	//排序
	public function listorders() {
		$status = parent::_listorders($this->curriculum);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
}