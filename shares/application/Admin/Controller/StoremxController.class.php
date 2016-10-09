<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/24
 * Time: 19:30
 */

namespace Admin\Controller;


use Common\Controller\AdminbaseController;

class StoremxController extends AdminbaseController
{
    function index(){
        
        //默认排序
        !$_GET['sort_field'] && $_GET['sort_field'] = 'ui.id';
        !$_GET['sort_by'] && $_GET['sort_by'] = 'DESC';   
        
        $fields=array(
            'start_time'=> array("field"=>"ui.date","operator"=>">"),
            'end_time'  => array("field"=>"ui.date","operator"=>"<"),
            'keyword'  => array("field"=>"s.name","operator"=>"like"),
            'op'  => array("field"=>"ui.op","operator"=>"like"),
        );
        $where = $this->search($fields,"(ui.op = 'jifen_sk' or ui.op='declaration' or ui.op='weixin_sk' or ui.op='admin')");
        $count = M("user_integral")
            ->alias("ui")//表别名
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = ui.userid")
            ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
            ->where($where)
            ->count();//获取条数

        $page = $this->page($count, 20,$_GET['p']);//设置分页信息

        $list = M("user_integral")
            ->alias("ui")//表别名
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = ui.userid")
            ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->field("ui.*,s.name")
            ->order("$_GET[sort_field] $_GET[sort_by]")
            ->select();

        //计算合计
        $allhj = M("user_integral")
            ->alias("ui")//表别名
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = ui.userid")
            ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
            ->where($where)
            ->field('sum(integral_sj) price')
            ->find();
        $this->assign("allhj",$allhj['price']);

        $this->assign("list",$list);
        $this->assign("Page", $page->show('Admin'));
        $this->display();
    }
}