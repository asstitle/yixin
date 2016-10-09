<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/5
 * Time: 10:09
 */

namespace Admin\Controller;


use Common\Controller\AdminbaseController;

class AccountController extends AdminbaseController
{

    /**
     *经纪人列表
     */
    public function index(){
        $this->display();
    }
}