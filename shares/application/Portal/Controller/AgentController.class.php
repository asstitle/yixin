<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/15
 * Time: 11:14
 */

namespace Portal\Controller;


use Common\Controller\HomeBaseController;

class AgentController extends UserController
{
    protected $itype;
    function _initialize() {
        parent::_initialize();
        //禁用
        $agent = M("oauth_user")
            ->alias("ou")//表别名
            ->join(C ( 'DB_PREFIX' )."user_dl ud ON ou.id = ud.uid","LEFT")
            ->where("ou.id=".sp_get_current_userid())//条件
            ->field("ou.*,ud.dl_score score,ud.isenable")//查询内容
            ->find();
        if($agent['isenable']==0){
            $this->error("您的代理商账户被禁用！");
        }
        //身份标示（代理商）
        $this->itype = 3;
        $this->assign("menu","agernt");
    }
    function index(){
        //查询信息
        $user = M("oauth_user")
            ->alias("ou")//表别名
            ->join(C ( 'DB_PREFIX' )."user_dl ud ON ou.id = ud.uid","LEFT")
            ->where("ou.id=".sp_get_current_userid())//条件
            ->field("ou.*,ud.dl_score score")//查询内容
            ->find();
        $this->disarray($user);
        //查询未读消息
        $messagenus = M("user_message")->where("userid=".sp_get_current_userid()." and is_read=0")->count();
        $this->assign("messagenum",$messagenus);
        $this->display();
    }
    //我要付款
    function payment(){
        $this->display();
    }
    //佣金明细
    function commission(){
        $where = array(
            "userid"        =>      sp_get_current_userid(),
            "op"        =>      array(array("like","fenyong"),array("like","fenyong_qy"),"or")
        );
        if (!$_GET['ajax']) {
            //获得累计佣金
            $allyj = M("user_integral")->where($where)->field('sum(integral_sj) allyj')->find();
            $this->assign("allyj",$allyj['allyj']);
            $this->display();
            exit;
        }

        $count = M("user_integral")
            ->where($where)
            ->count();//获取条数

        $page = $this->page($count, 9,$_GET['p']);//设置分页信息

        $list = M("user_integral")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("id desc")
            ->select();
        $zdy = $this->ar_zdy;
        $zdy = $zdy['ar_op'];
        foreach($list as $key => $val){
            $list[$key]['op'] = $zdy[$val['op']];
            $list[$key]['date'] = date("Y-m-d",$val['date']);
        }
        ajax_list($list); //处理ajax
        $this->display();
    }
}