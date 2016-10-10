<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/3
 * Time: 16:30
 */

namespace Admin\Controller;


use Common\Controller\AdminbaseController;

class CloseController extends AdminbaseController
{
    function _initialize() {
        parent::_initialize();
        $this->table = M("warehouse");
    }
    public function index(){

        $fields = array(
            'start_time'=> array("field"=>"w.flat_time","operator"=>">"),
            'end_time'  => array("field"=>"w.flat_time","operator"=>"<"),
            'keyword'  => array("field"=>"ou.user_nicename","operator"=>"like"),
            'keyword1'  => array("field"=>"ou.mobile","operator"=>"like"),
            'keyword2'  => array("field"=>"w.goods_name","operator"=>"like"),
        );

        $where = $this->search($fields);
        $count = $this->table
            ->alias("w")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON w.user_id = ou.id")
            ->where($where)
            ->count();//获取条数
        $page = $this->page($count, 20);//设置分页信息
        $list = $this->table
            ->alias("w")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON w.user_id = ou.id")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->field("w.*,ou.user_nicename,ou.mobile")//查询内容
            ->order("id DESC")
            ->select();

        $this->assign("Page", $page->show('Admin'));
        $this->assign("list",$list);
        $this->display();
    }
}