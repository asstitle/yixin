<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/3
 * Time: 21:33
 */

namespace Admin\Controller;


use Common\Controller\AdminbaseController;

class RebateController extends AdminbaseController
{
    function _initialize(){
        parent::_initialize();
    }
    function index(){
        
        $where_ands = array();
        $fields=array(
            'keyword'       => array("field"=>"c.curriculum_name","operator"=>"like"),//课程名编号
            'rank'    => array("field"=>"rl.rank","operator"=>"="),//返佣级别分类
        
            'start_price'   => array("field"=>"rl.rebate_money","operator"=>">="),//价格区间
            'end_price'     => array("field"=>"rl.rebate_money","operator"=>"<="),//价格区间
            'start_time'      => array("field"=>"rl.rebate_date","operator"=>">="),//下单区间
            'end_time'        => array("field"=>"rl.rebate_date","operator"=>"<="),//下单区间
        );
        $results = $this->public_search2($where_ands,$fields);
        $where = $results['where'];
        
        
        $count = M('rebate_list')
        ->alias("rl")
        ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = rl.buy_uid")
        ->join(C ( 'DB_PREFIX' )."oauth_user ou2 ON ou2.id = rl.get_uid")
        ->join(C ( 'DB_PREFIX' )."curriculum c ON c.id = rl.curriculum_id")
        ->where($where)
        ->field('rl.* , (ou.user_nicename) buy_name , ou.mobile buy_mobile , (ou2.user_nicename) get_name , ou2.mobile get_mobile, c.curriculum_name')
        ->count();
        
        $page = $this->page($count, 20);
        
        $list = M('rebate_list')
            ->alias("rl")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = rl.buy_uid")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou2 ON ou2.id = rl.get_uid")
            ->join(C ( 'DB_PREFIX' )."curriculum c ON c.id = rl.curriculum_id")
            ->where($where)
            ->field('rl.* , (ou.user_nicename) buy_name , ou.mobile buy_mobile , (ou2.user_nicename) get_name , ou2.mobile get_mobile, c.curriculum_name')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        
        $this->assign("Page", $page->show('Admin'));
        $this->assign('list',$list);
        $this->display();
    }
    
    
    //设置变量
    function setting(){
        $ar = I("post.");
        M("rebate")->where("id=1")->save($ar);
        echo 1;
    }

    //返现
    function dorebate(){
        $post = I("post.");
        
        if(!$post['date']){
            $this->error("请选择返现日期.");
        }

        //查询是否已经返现过
        $date = strtotime(date("Y-m-d",strtotime($post['date'])));
        $where = array(
            "fx_date"       =>      $date
        );
        $list = M("record_fx")->where($where)->find();
        if($list){
            $this->error("当天已经返现过！不能再进行返现操作..");
        }
        if($post['kefan']<=0){
            //暂没使用
            //可返积分
            //系统变量
            $option = get_site_options();
            //分佣变量
            $ar = M("rebate")->find(1);
            if($ar['fyje']<=0){
                //采用 营业额*分配比例
                //营业额
                $where = array(
                    "op"        =>      array(array("like","shopping_wx"),array("like","shopping_xj"),array("like","shopping_jf"),"or"),
                    "date"        =>      array('between',array(($date-1),($date+3600*24)))
                );
                $yye = M("user_integral")->where($where)->field("sum(`integral_sj`) price")->find();
                $yye = $yye['price'];
                $kfje = $yye * $option['site_fpbl'] / 100;
            }else{
                $kfje = $ar['fyje'];
            }
        }else{
            $kfje = $post['kefan'];//可返积分
        }                
        $this->backnow($kfje,$date);//返现操作
    }
}