<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/24
 * Time: 19:30
 */

namespace Admin\Controller;


use Common\Controller\AdminbaseController;

class StoretypeController extends AdminbaseController
{
    function _initialize() {
        parent::_initialize();
        $this->table = M("store_class");
    }
    function index(){
        $count = $this->table->count();
        $page = $this->page($count, 20);
        $list = $this->table->limit($page->firstRow . ',' . $page->listRows)->order("orderid desc,id desc")->select();
        $this->assign("Page", $page->show('Admin'));
        $this->assign("formget",$_GET);
        $this->assign("list",$list);
        $this->display();
    }
}