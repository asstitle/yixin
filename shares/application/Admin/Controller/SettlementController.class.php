<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/3
 * Time: 16:51
 */

namespace Admin\Controller;


use Common\Controller\AdminbaseController;

class SettlementController extends AdminbaseController
{
    /**
     * 机构结算
     */
    public function index(){
        $this->display();
    }

    /**
     * 经纪人结算
     */
    public function calculate(){
        $this->display();
    }

}