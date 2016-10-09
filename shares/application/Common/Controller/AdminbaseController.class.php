<?php

/**
 * 后台Controller
 */
//定义是后台
namespace Common\Controller;
use Common\Controller\AppframeController;

class AdminbaseController extends AppframeController {
	protected $order_types;
    protected $shsjs;
    protected $fhfss;
    
	public function __construct() {
		$admintpl_path=C("SP_ADMIN_TMPL_PATH").C("SP_ADMIN_DEFAULT_THEME")."/";
		C("TMPL_ACTION_SUCCESS",$admintpl_path.C("SP_ADMIN_TMPL_ACTION_SUCCESS"));
		C("TMPL_ACTION_ERROR",$admintpl_path.C("SP_ADMIN_TMPL_ACTION_ERROR"));
		parent::__construct();
		$time=time();
		$this->assign("js_debug",APP_DEBUG?"?v=$time":"");
	}

    function _initialize(){
       parent::_initialize();
    	if(isset($_SESSION['ADMIN_ID'])){
    		$users_obj= M("Users");
    		$id=$_SESSION['ADMIN_ID'];
    		$user=$users_obj->where("id=$id")->find();
    		if(!$this->check_access($id)){
    			$this->error("您没有访问权限！");
    			exit();
    		}
    		$this->assign("admin",$user);
    	}else{
    		//$this->error("您还没有登录！",U("admin/public/login"));
    		if(IS_AJAX){
    			$this->error("您还没有登录！",U("admin/public/login"));
    		}else{
    			header("Location:".U("admin/public/login"));
    			exit();
    		}
    		
    	}
        
        $this->order_types = D("Common/Navs")->order_type;//订单状态
        $this->assign('order_type', $this->order_types);
        
        $this->shsjs = D("Common/Navs")->shsj;//送货方式
        $this->assign('shsj', $this->shsjs);
        
        $this->fhfss = D("Common/Navs")->fhfs;//发货方式
        $this->assign('fhfs', $this->fhfss);
        
    }

    /**
     * 消息提示
     * @param type $message
     * @param type $jumpUrl
     * @param type $ajax 
     */
    public function success($message = '', $jumpUrl = '', $ajax = false) {
        parent::success($message, $jumpUrl, $ajax);
    }

    /**
     * 模板显示
     * @param type $templateFile 指定要调用的模板文件
     * @param type $charset 输出编码
     * @param type $contentType 输出类型
     * @param string $content 输出内容
     * 此方法作用在于实现后台模板直接存放在各自项目目录下。例如Admin项目的后台模板，直接存放在Admin/Tpl/目录下
     */
    public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
        parent::display($this->parseTemplate($templateFile), $charset, $contentType);
    }
    
    
    /**
     * 自动定位模板文件
     * @access protected
     * @param string $template 模板文件规则
     * @return string
     */
    public function parseTemplate($template='') {
    	$tmpl_path=C("SP_ADMIN_TMPL_PATH");
		// 获取当前主题名称
		$theme      =    C('SP_ADMIN_DEFAULT_THEME');
		
		if(is_file($template)) {
			// 获取当前主题的模版路径
			define('THEME_PATH',   $tmpl_path.$theme."/");
			return $template;
		}
		$depr       =   C('TMPL_FILE_DEPR');
		$template   =   str_replace(':', $depr, $template);
		
		// 获取当前模块
		$module   =  MODULE_NAME."/";
		if(strpos($template,'@')){ // 跨模块调用模版文件
			list($module,$template)  =   explode('@',$template);
		}
		// 获取当前主题的模版路径
		define('THEME_PATH',   $tmpl_path.$theme."/");
		
		// 分析模板文件规则
		if('' == $template) {
			// 如果模板文件名为空 按照默认规则定位
			$template = CONTROLLER_NAME . $depr . ACTION_NAME;
		}elseif(false === strpos($template, '/')){
			$template = CONTROLLER_NAME . $depr . $template;
		}
		
		C("TMPL_PARSE_STRING.__TMPL__",__ROOT__."/".THEME_PATH);
		
		C('SP_VIEW_PATH',$tmpl_path);
		C('DEFAULT_THEME',$theme);
		
		$file=THEME_PATH.$module.$template.C('TMPL_TEMPLATE_SUFFIX');
		if(!is_file($file)) E(L('_TEMPLATE_NOT_EXIST_').':'.$file);
		return $file;
    }


    /**
     * 初始化后台菜单
     */
    public function initMenu() {
        $Menu = F("Menu");
        if (!$Menu) {
            $Menu=D("Common/Menu")->menu_cache();
        }
        return $Menu;
    }

    /**
     *  排序 排序字段为listorders数组 POST 排序字段为：listorder
     */
    protected function _listorders($model) {
        if (!is_object($model)) {
            return false;
        }
        $pk = $model->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        $this->ajaxReturn($ids);
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $result=$model->where(array($pk => $key))->save($data);
        }
        return $result;
    }

    protected function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE) {
        import('Page');
        if ($Page_Size == 0) {
            $Page_Size = C("PAGE_LISTROWS");
        }
        if (empty($PageParam)) {
            $PageParam = C("VAR_PAGE");
        }
        $Page = new \Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
        $Page->SetPager('Admin', '<span>总记录：{recordcount} 条</span> {first}{prev}&nbsp;{liststart}{list}{listend}&nbsp;{next}{last}', array("listlong" => "9", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
        return $Page;
    }

    private function check_access($uid){
    	
    	//如果用户角色是1，则无需判断
    	if($uid == 1){
    		return true;
    	}
    	if(MODULE_NAME.CONTROLLER_NAME.ACTION_NAME!="AdminIndexindex"){
    		return sp_auth_check($uid);
    	}else{
    		return true;
    	}
    }
    
    
    function public_search ($where_ands,$fields) {
        if(IS_POST){
			foreach ($fields as $param =>$val){
				if (isset($_POST[$param]) && !empty($_POST[$param])) {
					$operator=$val['operator'];
					$field   =$val['field'];
					
                    if ($param=="keyword") {
                        $get=$_POST[$param];
                        $_GET[$param]=$get;
                        $field = explode(',',$field);
                    } elseif ($param=="start_time" || $param=="end_time")  {
                        $get=strtotime($_POST[$param]);
                        $_GET[$param]=date("Y-m-d H:i:s", $get);
                    } else {
                        $get=($_POST[$param]);
                        $_GET[$param]=$get;
                    }
                    if (is_array($field)) {
                        $key_where = '';
                        foreach ($field as $k=>$v) {
                            if($operator=="like"){
        						$get1="%$get%";
                                $key_where .= " $v $operator '$get1' OR";
        					}	
                        }
                        $key_where = '('.substr($key_where,0,strlen($key_where)-2).')';
                        array_push($where_ands, $key_where);
                    } else {
                        array_push($where_ands, " $field $operator '$get' ");
                    }
				}
			}
		}else{
			foreach ($fields as $param =>$val){
				if (isset($_GET[$param]) && !empty($_GET[$param])) {

					$operator=$val['operator'];
					$field   =$val['field'];

                    if ($param=="keyword") {
                        $get=$_GET[$param];
                        $_GET[$param]=$get;
                        $field = explode(',',$field);
                    } elseif ($param=="start_time" || $param=="end_time") {
                        $get=strtotime($_GET[$param]);
                        $_GET[$param]=date("Y-m-d H:i:s", $get);
                    } else {
                        $get=($_GET[$param]);
                        $_GET[$param]=$get;
                    }
					if (is_array($field)) {
                        $key_where = '';
                        foreach ($field as $k=>$v) {
                            if($operator=="like"){
        						$get1="%$get%";
                                $key_where .= " $v $operator '$get1' OR";
        					}	
                        }
                        $key_where = '('.substr($key_where,0,strlen($key_where)-2).')';
                        array_push($where_ands, $key_where);
                    } else {
                        array_push($where_ands, " $field $operator '$get' ");
                    }
				}
			}
		}

		$where= join(" and ", $where_ands);
        return $results = array('where'=>$where,'get'=>$_GET);
    }
    
    
    function public_search2 ($where_ands,$fields) {
        if(IS_POST){
			foreach ($fields as $param =>$val){
				if (isset($_POST[$param]) && !empty($_POST[$param])) {
					$operator=$val['operator'];
					$field   =$val['field'];
					
                    if ($param=="keyword" || $param=="keyword2") {
                        $get=$_POST[$param];
                        $_GET[$param]=$get;
                        
                        $field = explode(',',$field);
                    } elseif ($param=="start_time" || $param=="end_time")  {
                        $get=strtotime($_POST[$param]);
                        $_GET[$param]=date("Y-m-d H:i:s", $get);
                    } elseif ($param=="goods_type") {
                        //商品分类
                        $get_parents=$_POST[$param];
                        $get = '';
                        $goods_class1 = M("goods_class")->where("parent_id='$get_parents'")->select();
                        foreach ($goods_class1 as $k=>$v) {
                            $parentids = $v['id'];
                            $goods_class2 = M("goods_class")->where("parent_id='$parentids'")->select();
                            foreach ($goods_class2 as $k2=>$v2) {
                                $get .= $v2['id'].',';
                            }
                        }
                        $get = substr($get,0,strlen($get)-1);
                        
                        $_GET[$param]=$get_parents;
                        
                    } elseif ($param=="seller_type") {
                        //店内分类
                        $get_parents=$_POST[$param];
                        $get = '';
                        $seller_class = M("seller_class")->where("parent_id='$get_parents'")->select();
                        if ($seller_class) {
                            foreach ($seller_class as $k2=>$v2) {
                                $get .= $v2['id'].',';
                            }
                        } else {
                            $get .= $get_parents.',';
                        }
                        $get = substr($get,0,strlen($get)-1);
                        $_GET[$param]=$get_parents;
                    } else {
                        $get=$_POST[$param];
                        $_GET[$param]=$get;
                    }
                    if (is_array($field)) {
                        $key_where = '';
                        foreach ($field as $k=>$v) {
                            if($operator=="like"){
        						$get1="%$get%";
                                $key_where .= " $v $operator '$get1' OR";
        					}	
                        }
                        $key_where = '('.substr($key_where,0,strlen($key_where)-2).')';
                        
                        array_push($where_ands, $key_where);
                    } elseif ($param=="goods_type") {
                        if ($get) {
                            array_push($where_ands, " $field $operator ($get) ");
                        }
                        
                    } elseif ($param=="seller_type") {
                        $get = explode(',',$get);
                        $key_where = '';
                        foreach ($get as $k=>$v) {
                            if ($k==0) {
                                $key_where .= " FIND_IN_SET('$v',$field) ";
                            } else {
                                $key_where .= " OR FIND_IN_SET('$v',$field) ";
                            }
                        }
                        $key_where = '('.$key_where.')';
                        array_push($where_ands, $key_where);
                    } else {
                        array_push($where_ands, " $field $operator '$get' ");
                    }
				}
			}
		}else{
			foreach ($fields as $param =>$val){
				if (isset($_GET[$param]) && !empty($_GET[$param])) {

					$operator=$val['operator'];
					$field   =$val['field'];

                    if ($param=="keyword" || $param=="keyword2") {
                        $get=$_GET[$param];
                        $_GET[$param]=$get;
                        $field = explode(',',$field);
                    } elseif ($param=="start_time" || $param=="end_time") {
                        $get=strtotime($_GET[$param]);
                        $_GET[$param]=date("Y-m-d H:i:s", $get);
                    } elseif ($param=="goods_type") {
                        //商品分类
                        $get_parents=$_GET[$param];
                        $get = '';
                        $goods_class1 = M("goods_class")->where("parent_id='$get_parents'")->select();
                        foreach ($goods_class1 as $k=>$v) {
                            $parentids = $v['id'];
                            $goods_class2 = M("goods_class")->where("parent_id='$parentids'")->select();
                            foreach ($goods_class2 as $k2=>$v2) {
                                $get .= $v2['id'].',';
                            }
                        }
                        $get = substr($get,0,strlen($get)-1); 
                        $_GET[$param]=$get_parents;
                        
                    } elseif ($param=="seller_type") {
                        //店内分类
                        $get_parents=$_GET[$param];
                        $get = '';
                        $seller_class = M("seller_class")->where("parent_id='$get_parents'")->select();
                        if ($seller_class) {
                            foreach ($seller_class as $k2=>$v2) {
                                $get .= $v2['id'].',';
                            }
                        } else {
                            $get .= $get_parents.',';
                        }
                        $get = substr($get,0,strlen($get)-1);
                        $_GET[$param]=$get_parents;
                    } else {
                        $get=($_GET[$param]);
                        $_GET[$param]=$get;
                    }
					if (is_array($field)) {
                        $key_where = '';
                        foreach ($field as $k=>$v) {
                            if($operator=="like"){
        						$get1="%$get%";
                                $key_where .= " $v $operator '$get1' OR";
        					}	
                        }
                        $key_where = '('.substr($key_where,0,strlen($key_where)-2).')';
                        array_push($where_ands, $key_where);
                    } elseif ($param=="goods_type") {
                        array_push($where_ands, " $field $operator ('$get') ");
                    } elseif ($param=="seller_type") {
                        $get = explode(',',$get);
                        $key_where = '';
                        foreach ($get as $k=>$v) {
                            if ($k==0) {
                                $key_where .= " FIND_IN_SET('$v',$field) ";
                            } else {
                                $key_where .= " OR FIND_IN_SET('$v',$field) ";
                            }
                        }
                        $key_where = '('.$key_where.')';
                        array_push($where_ands, $key_where);
                    } else {
                        array_push($where_ands, " $field $operator '$get' ");
                    }
				}
			}
		}

		$where= join(" and ", $where_ands);
        return $results = array('where'=>$where,'get'=>$_GET);
    }
    
    //根据当前分类ID取第三级分类id集
    public function search_three ($id) {
        $now_cen = 1;//当前层级
        
        for ($n = 1; $n <999; $n++) {
            $list = M("goods_class")->where("id='$id'")->field("id,name,parent_id")->find();
            $id = $list['parent_id'];
            if ($id == 0) {
                $now_cen = $n;
                break;
            }
        }
        return $now_cen;
    }
    
    /**
     * 商品编号规则
     * 
     **/
    public function goods_bg () {
        $uid = get_current_userid();
        $class_id = '';
        $class_id = "PT".date("Ymd",time());
        /*
        $users = M("users")->where("id='$uid'")->field("user_type")->find();
        if ($users['user_type'] == 1) {
            $class_id = "PT".date("Ymd",time());
        } else {
            $class_id = "SJ".date("Ymd",time());
        }
        */
        $where = "goods_bh LIKE '".$class_id."____'";
        $count = M("goods")->where($where)->max("goods_bh");
        
    	$class_id2 = substr($count, -4, 5);
    	$class_id = $class_id . substr($class_id2 + 1 + 10000, -4, 5);
        return $class_id;
    }
    //自定义
    function add() {
        $this->display("edit");
    }
    function edit() {
        $list = $this->table->find($_GET['id']);
        $this->disarray($list);
        $this->assign("isedit",1);
        $this->display();
    }
    function edit_post(){
        $_POST['id'] = !$_POST['id']?"":$_POST['id'];
        if(!$_POST['id']){
            if($this->table->add($_POST)){
                $this->success("添加成功!",U(CONTROLLER_NAME."/index"));
            }else{
                $this->error("添加失败");
            }
        }else{
            if($this->table->save($_POST)){
                $this->success("修改成功!",U(CONTROLLER_NAME."/index"));
            }else{
                $this->error("修改失败或未改变任何参数！");
            }
        }
    }
    function delete(){
        if(isset($_GET['id'])){
            $tid = intval(I("get.id"));
            if ($this->table->where("id=$tid")->delete()) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
        if(isset($_POST['ids'])){
            $tids = join(",",$_POST['ids']);
            if ($this->table->where("id in ($tids)")->delete()) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
    }
//    //导出excel
//    public function download($ar,$title,$name)
//    {
//        vendor("PHPExcel.PHPExcel");
//        $objPHPExcel = new \PHPExcel();
//        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
//            ->setLastModifiedBy("Maarten Balliauw")
//            ->setTitle("Office 2007 XLSX Test Document")
//            ->setSubject("Office 2007 XLSX Test Document")
//            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
//            ->setKeywords("office 2007 openxml php")
//            ->setCategory("Test result file");
//        $i=2;
//        foreach($title as $key => $val){
//            $objPHPExcel->setActiveSheetIndex(0)
//                ->setCellValue($key, $val);
//        }
////        $objPHPExcel->setActiveSheetIndex(0)
////            ->setCellValue('A1', '姓名')
////            ->setCellValue('B1', '年龄')
////            ->setCellValue('C1', '性别')
////            ->setCellValue('D1', '身份证号码')
////            ->setCellValue('E1', '国籍')
////            ->setCellValue('F1', '民族')
////            ->setCellValue('G1', '详细地址');
//        $objPHPExcel->setActiveSheetIndex(0);
//        foreach($ar as $k=>$v){
//            $objPHPExcel->setActiveSheetIndex(0)
//                ->setCellValue('A'.$i, $v['id'])
//                ->setCellValue('B'.$i, $v['name'])
//                ->setCellValue('C'.$i, $v['mobile'])
//                ->setCellValue('D'.$i, $v['itype'])
//                ->setCellValue('E'.$i, $v['price'])
//                ->setCellValue('F'.$i, $v['fee'])
//                ->setCellValue('G'.$i, $v['sjdz'])
//                ->setCellValue('H'.$i, $v['khyh'])
//                ->setCellValue('I'.$i, $v['khxm'])
//                ->setCellValue('J'.$i, $v['yhzh'])
//                ->setCellValue('K'.$i, $v['date'])
//                ->setCellValue('L'.$i, $v['state']);
//            $i++;
//        }
//        $objPHPExcel->getActiveSheet()->setTitle('student');//设置sheet标签的名称
//        $objPHPExcel->setActiveSheetIndex(0);
//        ob_end_clean();  //清空缓存
//        header("Pragma: public");
//        header("Expires: 0");
//        header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
//        header("Content-Type:application/force-download");
//        header("Content-Type:application/vnd.ms-execl");
//        header("Content-Type:application/octet-stream");
//        header("Content-Type:application/download");
//        header('Content-Disposition:attachment;filename='.$name.'.xls');//设置文件的名称
//        header("Content-Transfer-Encoding:binary");
//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//        $objWriter->save('php://output');
//        exit;
//    }
//thinkphp (PHPexcel)导出excel格式
    public function exportExcel($expTitle,$expCellName,$expTableData){

        //设置字体
        $styleArray1 = array(
            'font' => array(
                'bold' => true,
                'color'=>array(
                    'argb' => '00000000',
                ),
            ),
        );

        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $xlsTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel.PHPExcel");

        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle);
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
            $objPHPExcel->getActiveSheet()->getColumnDimension($expCellName[$i][2])->setWidth($expCellName[$i][3]);//设置宽度

            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);//设置高度

        }
        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }
        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);
        //$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    //处理搜索
    //$fields=array(
    //'start_time'=> array("field"=>"date","operator"=>">"),
    //'end_time'  => array("field"=>"date","operator"=>"<"),
    //'keyword'  => array("field"=>"name,tel,address","operator"=>"like"),
    //'status'  => array("field"=>"status","operator"=>"="),
    //'type'  => array("field"=>"type","operator"=>"="),
    //
    //$where2 = "1=1" 额外条件 自动拼接
    //);
    function search($fields,$where2=""){
        $where_ands=array();
        foreach ($fields as $param =>$val){
            if (isset($_REQUEST[$param]) && $_REQUEST[$param]!=="") {
                $operator = $val['operator'];
                $field = $val['field'];
                if($_REQUEST[$param]!==""){
                   if ($param=="keyword") {
                        $get = $_REQUEST[$param];
                        $_GET[$param] = $get;
                        if($operator=="like"){
                            $get = "%$get%";
                        }
                        $ar = array();
                        $zd = explode(",",$val['field']);
                        foreach($zd as $key => $val){
                            array_push($ar,"$val $operator '$get'");
                        }
                        $str = join(" or ", $ar);
                        array_push($where_ands, "(" . $str . ")");
    
                    }else if($param=="start_time" or $param=="end_time"){
                        $get = strtotime($_REQUEST[$param]);
                        $_GET[$param] = date("Y-m-d H:i:s", $get);
                        if($operator=="like"){
                            $get="%$get%";
                        }
                        array_push($where_ands, "$field $operator '$get'");
                    }else {
                        $get = $_REQUEST[$param];
                        $_GET[$param] = $get;
                        array_push($where_ands, "$field $operator '$get'");
                    } 
                }
            }
        }
        $where = join(" and ", $where_ands);
        $op = "";
        if($where!=""&&$where2!=""){
            $op .= " and ";
        }
        $where = $where . $op . $where2;
        $this->assign("formget",$_GET);
        return $where;
    }
}