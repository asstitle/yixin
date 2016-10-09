<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/24
 * Time: 19:30
 */

namespace Admin\Controller;


use Common\Controller\AdminbaseController;

class StoreshController extends AdminbaseController
{
    function _initialize() {
        parent::_initialize();
        $this->table = M("store_xn");
    }
    
    function index(){
        //条件搜索
        $fields=array(
            'start_time'=> array("field"=>"date","operator"=>">"),
            'end_time'  => array("field"=>"date","operator"=>"<"),
            'keyword'  => array("field"=>"ou.user_nicename,ou.mobile,ou.id,s.name,s.id, ou2.user_nicename, ou2.mobile","operator"=>"like"),
            'state'  => array("field"=>"s.status","operator"=>"="),
        );
        $where = $this->search($fields,"s.status=0");
        $count = $this->table
            ->alias("s")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON s.uid = ou.id","LEFT")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou2 ON ou.tjrr = ou2.id","LEFT")
            ->where($where)
            ->count();//获取条数
        $page = $this->page($count, 20);//设置分页信息
        $list = $this->table
            ->alias("s")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON s.uid = ou.id","LEFT")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou2 ON ou.tjrr = ou2.id","LEFT")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("s.id DESC")
            ->field("ou.mobile,ou.user_nicename,s.*, CONCAT(ou2.mobile, ' ' , ou2.user_nicename) recomm")//查询内容
            ->select();
        $this->assign("Page", $page->show('Admin'));
        $this->assign("formget",$_GET);
        $this->assign("list",$list);
        $this->display();
    }
    
    function edit(){
        $list = M("oauth_user")
            ->alias("ou")
            ->join(C ( 'DB_PREFIX' )."store_xn s ON s.uid = ou.id","LEFT")
            ->where("ou.id=".I("get.id"))
            ->order("ou.id DESC")
            ->field("ou.mobile,CONCAT(ou.mobile, ' ', ou.user_nicename) user_nicename, ou.create_time,ou.id userid,s.*")//查询内容
            ->find();//dump($list);
        $this->disarray($list);

        //查询等级
        $level = M("store_class")->select();
        $this->assign("level",$level);

        $this->display();
    }
    
    function edit_post(){
        //修改普通会员信息
        M("oauth_user")->save($_POST['user']);
        //修改商家会员信息 如为存在则添加
        //处理图片
        $_POST['store']['banner'] = implode(",",$_POST['imgs']);
        //如未填写返佣不理 则采用数据库默认
        if(!$_POST['store']['fybl']){
            $_POST['store']['fybl'] = 100;
        }
        if($_POST['store']['id']){
            M("store_xn")->save($_POST['store']);
        }else{
            M("store_xn")->add($_POST['store']);
        }
        $this->success("修改成功!",U(CONTROLLER_NAME."/index"));
    }
    
    //审核
    function enable(){
        if(isset($_GET['id'])){
            $tid = intval(I("get.id"));
            $ar = M("store_xn")->find($tid);
            //删掉不要的数据
            $id = $ar['id'];
            $op = $ar['op'];
            unset($ar['id']);
            unset($ar['op']);
            unset($ar['status']);
            unset($ar['date']);
            if($op=="add"){
                //如果选择为不通过 则提示并跳出
                if($_GET['t']==2){
                    //提示并跳出IF
                    //未定 暂不处理
                }else{
                    //如为添加 先判断正式表是否存在数据
                    $list = M("store")->where("uid=".$ar['uid'])->find();
                    if($list){
                        //存在则修改
                        $ar = array_merge($list,$ar);
                        M("store")->save($ar);
                    }else{
                        $ar['cid'] = '';
                        $ar['score'] = 0;
                        $ar['fybl'] = 100;
                        $ar['remark'] = '';
                        //$ar['lng'] = '';
                        //$ar['lat'] = '';
                        $ar['content'] = '';
                        $ar['banner'] = '';
                        $ar['status'] = 1;
                        $ar['isreturn'] = 0;
                        $ar['isenable'] = 1;
                        M("store")->add($ar);
                        //修改会员状态
                        M("oauth_user")->where("id=".$ar['uid'])->setField("user_type",2);
                    }
                }
            }else{
                $list = M("store")->where("uid=".$ar['uid'])->find();
                
                $ar = array_merge($list,$ar);
                
                //当商家通过平台前端 修改信息 提交审核后 ，我们后台同意修改， 这家店的定位就会被清零，并且排到第一位。
                unset($ar['lng']);
                unset($ar['lat']);
                
                M("store")->save($ar);
            }
            //删除此虚拟数据
            M("store_xn")->delete($id);

            $this->success("操作成功！");
        }
        if(isset($_POST['ids'])){
            foreach($_POST['ids'] as $key => $val){
                $tid = intval($val);
                $ar = M("store_xn")->find($tid);
                //删掉不要的数据
                $id = $ar['id'];
                $op = $ar['op'];
                unset($ar['id']);
                unset($ar['op']);
                unset($ar['status']);
                unset($ar['date']);
                if($op=="add"){
                    //如为添加 先判断正式表是否存在数据
                    $list = M("store")->where("uid=".$ar['uid'])->find();
                    if($list){
                        //存在则修改
                        $ar = array_merge($list,$ar);
                        M("store")->save($ar);
                    }else{
                        $ar['cid'] = '';
                        $ar['score'] = 0;
                        $ar['fybl'] = 100;
                        $ar['remark'] = '';
                        $ar['lng'] = '';
                        $ar['lat'] = '';
                        $ar['content'] = '';
                        $ar['banner'] = '';
                        $ar['status'] = 1;
                        $ar['isreturn'] = 0;
                        $ar['isenable'] = 1;
                        M("store")->add($ar);
                    }
                }else{
                    $list = M("store")->where("uid=".$ar['uid'])->find();
                    $ar = array_merge($list,$ar);
                    M("store")->save($ar);
                }
                //删除此虚拟数据
                M("store_xn")->delete($id);

                //修改会员状态
                M("oauth_user")->where("id=".$ar['uid'])->setField("user_type",2);
            }
            $this->success("审核成功！");
        }
    }
}