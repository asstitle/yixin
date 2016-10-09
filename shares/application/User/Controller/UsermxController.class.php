<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/3
 * Time: 20:40
 */

namespace User\Controller;


use Common\Controller\AdminbaseController;

class UsermxController extends AdminbaseController
{
    function index(){
        
        //默认排序
        !$_GET['sort_field'] && $_GET['sort_field'] = 'ui.id';
        !$_GET['sort_by'] && $_GET['sort_by'] = 'DESC';        
		
        $fields=array(
            'start_time'=> array("field"=>"ui.date","operator"=>">"),
            'end_time'  => array("field"=>"ui.date","operator"=>"<"),
            'keyword'  => array("field"=>"ou.user_nicename,ou.id,ou.mobile","operator"=>"like"),
            "op"        =>  array("field"=>"ui.op","operator"=>"="),
        );
        $where = $this->search($fields);
        $count = M("user_integral")
            ->alias("ui")//表别名
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = ui.userid")
            ->where($where)
            ->count();//获取条数

        $page = $this->page($count, 20,$_GET['p']);//设置分页信息

        $list = M("user_integral")
            ->alias("ui")//表别名
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = ui.userid")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->field("ui.*, ou.user_nicename, ou.mobile, ou.user_type")
            ->order("$_GET[sort_field] $_GET[sort_by]")
            ->select();
        $zdy = $this->ar_zdy;
        $this->assign("op",$zdy['ar_op']);

        $this->assign("list",$list);
        

        //查询所有合计
        $list = M("user_integral")
            ->alias("ui")//表别名
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = ui.userid")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->field("SUM(`integral_sj`) integral_sj, SUM(`integral`) integral")
            ->order("ui.id desc")
            ->find();
        $this->assign("allprice", $list);
                
        
        $this->assign("Page", $page->show('Admin'));
        $this->display();
    }
    //导出提现
    function dctx(){
        $zdy = $this->ar_zdy;
        $fields=array(
            'start_time'=> array("field"=>"ui.date","operator"=>">"),
            'end_time'  => array("field"=>"ui.date","operator"=>"<"),
            'keyword'  => array("field"=>"ou.user_nicename,ou.id,ou.mobile","operator"=>"like"),
            "op"        =>  array("field"=>"ui.op","operator"=>"="),
        );
        $where = $this->search($fields);
        $list = M("user_integral")
            ->alias("ui")//表别名
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = ui.userid")
            ->where($where)
            ->field("ui.*, ou.user_nicename, ou.mobile, ou.user_type")
            ->order("ui.id desc")
            ->select();
        $ar = array();
        foreach($list as $key => $val){
            $ar[$key]['id'] = $val['id'];
            $ar[$key]['user_nicename'] = $val['user_nicename'];
            $ar[$key]['mobile'] = $val['mobile'];
            $ar[$key]['op'] = $zdy['ar_op'][$val['op']];
            $ar[$key]['user_type'] = strip_tags($this->ar_zdy['ar_usertype'][$val['user_type']]);
            $ar[$key]['integral'] = $val['integral'];
            $ar[$key]['integral_sj'] = $val['integral_sj'];
            $ar[$key]['cur_integral'] = $val['cur_integral'];
            $ar[$key]['remark'] = $val['remark'];
            $ar[$key]['date'] = date("Y-m-d H:i",$val['date']);
        }
        //如果点击导出
        $arytitle = array(
            array('id','序号','A', '5'),
            array('user_nicename','用户名称','B', '20'),
            array('mobile','手机号码','C', '15'),
            array('user_type','用户级别','D', '12'),
            array('op','操作','E', '20'),
            array('integral','操作积分','F', '20'),
            array('integral_sj','实际积分','G', '15'),
            array('cur_integral','当前余额','H', '15'),
            array('remark','备注','I', '100'),
            array('date','时间','J', '20'),
        );
        $filename = '用户明细记录';
        $this->exportExcel($filename, $arytitle, $ar); //文件名，标题数组，数据数组
    }
}