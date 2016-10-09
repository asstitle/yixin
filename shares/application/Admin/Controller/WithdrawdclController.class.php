<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/24
 * Time: 19:30
 */

namespace Admin\Controller;


use Common\Controller\AdminbaseController;

class WithdrawdclController extends AdminbaseController
{
    function _initialize() {
        parent::_initialize();
        $this->table = M("user_withdraw");
    }
    function index(){
        $fields=array(
            'start_time'=> array("field"=>"uw.date","operator"=>">"),
            'end_time'  => array("field"=>"uw.date","operator"=>"<"),
            'keyword'  => array("field"=>"ou.user_nicename,ou.mobile,uw.id","operator"=>"like"),
            'itype'  => array("field"=>"uw.itype","operator"=>"="),
        );
        $where = $this->search($fields,"uw.state=1");
        $count = $this->table
            ->alias("uw")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON uw.uid = ou.id")
            ->where($where)
            ->count();//获取条数
        $page = $this->page($count, 20);//设置分页信息
        $list = $this->table
            ->alias("uw")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON uw.uid = ou.id")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->field("uw.*,ou.user_nicename,ou.mobile, IF(uw.khzh, uw.khzh, ou.khzh) khzh")//查询内容
            ->order("id DESC")
            ->select();
        $this->assign("Page", $page->show('Admin'));
        $this->assign("formget",$_GET);
        $this->assign("list",$list);

        //统计提现
        $alltx = $this->table
            ->alias("uw")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON uw.uid = ou.id")
            ->where($where)
            ->field('sum(sjdz) price')
            ->find();
        $this->assign("alltx",sprintf("%.2f",$alltx['price']));

        $this->display();
    }
    //状态
    function enable(){
        if(isset($_GET['id'])){
            $tid = intval(I("get.id"));
            if (M("user_withdraw")->where("id=$tid")->setField("state",$_GET['t'])) {
                $this->success("审核成功！");
            } else {
                $this->error("已审核！");
            }
        }
        if(isset($_POST['ids'])){
            $tids = join(",",$_POST['ids']);
            if (M("user_withdraw")->where("id in ($tids)")->setField("state",$_GET['t'])) {
                $this->success("操作成功！");
            } else {
                $this->error("操作失败！");
            }
        }
    }
    //导出提现
    function dctx(){
        $list = $this->table
            ->alias("uw")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON uw.uid = ou.id")
            ->where("uw.state=1")
            ->field("uw.*,ou.user_nicename,ou.mobile, IF(uw.khzh, uw.khzh, ou.khzh) khzh")//查询内容
            ->order("id DESC")
            ->select();
        $newArray = array();
        $ar = array();
        foreach($list as $key => $val){
            $ar[$key]['id'] = $key+1;
            $ar[$key]['name'] = "\t".$val['user_nicename'];
            $ar[$key]['mobile'] = "\t".$val['mobile'];
            if($val['itype']==1){
                $ar[$key]['itype'] = "会员提现";
            }else if($val['itype']==2){
                $ar[$key]['itype'] = "商家提现";
            }else{
                $ar[$key]['itype'] = "代理商提现";
            }
            $ar[$key]['price'] = floatval($val['price']);
            $ar[$key]['fee'] = $val['fee'];
            $ar[$key]['sjdz'] = $val['sjdz'];
            $ar[$key]['khyh'] = $val['khyh'];
            $ar[$key]['khzh'] = $val['khzh'];
            $ar[$key]['khxm'] = $val['khxm'];
            $ar[$key]['yhzh'] = "\t".$val['yhzh'];
            $ar[$key]['date'] = date("Y-m-d H:i",$val['date']);
            if($val['state']==1){
                $ar[$key]['state'] = "待处理";
            }else{
                $ar[$key]['state'] = "已处理";
            }
            //$newArray[] = array('id'=>$key+1,'name'=>$val["user_nicename"],'mobile'=>$val["mobile"],'itype'=>$val["itype"],'price'=>$val["price"],'fee'=>$val["fee"],'sjdz'=>$val["sjdz"],'khyh'=>$val["khyh"],'khxm'=>$val["khxm"],'yhzh'=>$val["yhzh"],'date'=>$val["date"],'khyh'=>$ar[$key]['state']);
        }
        //如果点击导出
        $arytitle = array(
            array('id','序号','A', '5'),
            array('name','用户名','B', '10'),
            array('mobile','用户手机','C', '20'),
            array('itype','提现类别','D', '20'),
            array('price','提现金额','E', '15'),
            array('fee','手续费','F', '15'),
            array('sjdz','实际到账','G', '20'),
            array('khyh','开户银行','H', '20'),
            array('khzh','开户支行','I', '20'),
            array('khxm','开户姓名','J', '20'),
            array('yhzh','银行账号','K', '20'),
            array('date','申请时间','L', '20'),
            array('state','提现状态','M', '20'),
        );
        $filename = '提现记录';
        $this->exportExcel($filename, $arytitle, $ar); //文件名，标题数组，数据数组
    }
}