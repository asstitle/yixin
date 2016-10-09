<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/24
 * Time: 19:30
 */

namespace Admin\Controller;


use Common\Controller\AdminbaseController;

class StoreController extends AdminbaseController
{
    function _initialize() {
        parent::_initialize();
        $this->table = M("oauth_user");
    }
    function index(){
        
        //默认排序
        !$_GET['sort_field'] && $_GET['sort_field'] = 'ou.id';
        !$_GET['sort_by'] && $_GET['sort_by'] = 'DESC';  
        
        //条件搜索
        $fields=array(
            'start_time'=> array("field"=>"ou.create_time","operator"=>">"),
            'end_time'  => array("field"=>"ou.create_time","operator"=>"<"),
            'keyword'  => array("field"=>"ou.user_nicename,ou.mobile,ou.id,s.name,s.address,s.id, ou2.mobile, ou2.user_nicename","operator"=>"like"),
            'state'  => array("field"=>"s.status","operator"=>"="),
            'class'  => array("field"=>"s.cid","operator"=>"="),
            'sheng'  => array("field"=>"s.sheng","operator"=>"="),
            'shi'  => array("field"=>"s.shi","operator"=>"="),
            'qu'  => array("field"=>"s.qu","operator"=>"="),
            'isfh'  => array("field"=>"s.isreturn","operator"=>"="),
            'isjy'  => array("field"=>"s.isenable","operator"=>"="),
        );
        if(I("post.sheng")=="请选择省份"){
            unset($_REQUEST['sheng']);
        }
        if(I("post.shi")=="请选择市"){
            unset($_REQUEST['shi']);
        }
        if(I("post.qu")=="请选择区|县"){
            unset($_REQUEST['qu']);
        }
        $where = $this->search($fields,"ou.user_type = 2 AND s.uid=ou.id"); //2016-7-18 此处限制会员和商家都存在，防止用户删除了，但商家还存在

        $count = $this->table
            ->alias("ou")
            ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id","LEFT")
            ->join(C ( 'DB_PREFIX' )."store_class sc ON sc.id = s.cid","LEFT")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou2 ON ou.tjrr=ou2.id","LEFT")
            ->join(C ( 'DB_PREFIX' )."user_integral ui ON ou.id = ui.userid AND  (ui.op = 'jifen_sk' OR ui.op = 'weixin_sk' OR ui.op = 'declaration' ) ","LEFT")
            ->where($where)
            ->group('ou.id')
            ->count();//获取条数
        $page = $this->page($count, 20);//设置分页信息
        $list = $this->table
            ->alias("ou")
            ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id","LEFT")
            ->join(C ( 'DB_PREFIX' )."store_class sc ON sc.id = s.cid","LEFT")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou2 ON ou.tjrr=ou2.id","LEFT")
            ->join(C ( 'DB_PREFIX' )."user_integral ui ON ou.id = ui.userid AND  (ui.op = 'jifen_sk' OR ui.op = 'weixin_sk' OR ui.op = 'declaration' )","LEFT")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("$_GET[sort_field] $_GET[sort_by]")
            ->field("ou.mobile,SUM(ui.integral) yye, CONCAT(ou.mobile, ' ', ou.user_nicename) user_nicename, ou.id userid,ou.create_time,s.*,sc.name typename, CONCAT(ou2.mobile, ' ', ou2.user_nicename) tjrr,ou.tjrs,s.isenable")//查询内容
            ->group("ou.id")
            ->select();
        //show_bug($list[0]);
        
       /*  foreach($list as $key => $val){
            //查询上级推荐人
            //$name = $this->table->find($val['tjrr']);
            //$list[$key]['tjrr'] = $name['user_nicename']?$name['user_nicename']:$name['mobile'];

            //查询营业额
           
            $where1 = array(
                "userid"    =>      $val['userid'],
                "op"        =>      array(array("like","jifen_sk"),array("like","weixin_sk"),array("like","declaration"),"or")
            );
            $yye = M("user_integral")->where($where1)->field("sum(`integral`) price")->find();
            $list[$key]['yye']  = $yye['price'];
        } */
        $this->assign("Page", $page->show('Admin'));
        $this->assign("formget",$_GET);
        $this->assign("list",$list);

        //查询商家积分合计
        $jf = $this->table
            ->alias("ou")
            ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id","LEFT")
            ->join(C ( 'DB_PREFIX' )."store_class sc ON sc.id = s.cid","LEFT")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou2 ON ou.tjrr=ou2.id","LEFT")
            ->where($where)
            ->field("sum(s.score) allprice")
            ->find();
        $this->assign("allprice",$jf['allprice']);

        //获取商家分类
        $class = M("store_class")->select();
        $this->assign("class",$class);

        $this->display();
    }
    
    function edit(){
        $list = $this->table
            ->alias("ou")
            ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id","LEFT")
            ->join(C ( 'DB_PREFIX' )."store_class sc ON sc.id = s.cid","LEFT")
            ->where("ou.id=".I("get.id"))
            ->order("ou.id DESC")
            ->field("ou.mobile,ou.user_nicename,ou.create_time,ou.id userid,s.*")//查询内容
            ->find();
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
            M("store")->save($_POST['store']);
        }else{
            M("store")->add($_POST['store']);
        }
        $this->success("修改成功!",U(CONTROLLER_NAME."/index"));
    }
    
    //审核
    function enable(){
        if(isset($_GET['id'])){
            $tid = intval(I("get.id"));
            if (M("store")->where("uid=$tid")->setField("status",$_GET['t'])) {
                $this->success("审核成功！");
            } else {
                $this->error("已审核！");
            }
        }
        if(isset($_POST['ids'])){
            $tids = join(",",$_POST['ids']);
            if (M("store")->where("id in ($tids)")->setField("status",$_GET['t'])) {
                $this->success("操作成功！");
            } else {
                $this->error("操作失败！");
            }
        }
    }
    
    //启用
    function qiyong(){
        if(isset($_GET['id'])){
            $tid = intval(I("get.id"));
            $re = $this->table
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
                ->where("ou.id=$tid")
                ->field("s.*")
                ->find();
            $re['isenable'] = $_GET['t'];
            M("store")->save($re);
            if ($re) {
                $this->success("启用成功！");
            } else {
                $this->error("已启用 无需再次启用！");
            }
        }
        if(isset($_POST['ids'])){
            $tids = join(",",$_POST['ids']);
            $re = $this->table
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
                ->where("ou.id in ($tids)")
                ->field("s.*")
                ->select();
            foreach($re as $key => $val){
                $val['isenable'] = $_GET['t'];
                M("store")->save($val);
            }
            if ($re) {
                $this->success("操作成功！");
            } else {
                $this->error("操作失败！");
            }
        }
    }
    
    //返现
    function fanxian(){
        if(isset($_GET['id'])){
            $tid = intval(I("get.id"));
            $re = $this->table
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
                ->where("ou.id=$tid")
                ->field("s.*")
                ->find();
            $re['isreturn'] = $_GET['t'];
            M("store")->save($re);
            if ($re) {
                $this->success("启用成功！");
            } else {
                $this->error("已启用 无需再次启用！");
            }
        }
        if(isset($_POST['ids'])){
            $tids = join(",",$_POST['ids']);
            $re = $this->table
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
                ->where("ou.id in ($tids)")
                ->field("s.*")
                ->select();
            foreach($re as $key => $val){
                $val['isreturn'] = $_GET['t'];
                M("store")->save($val);
            }
            if ($re) {
                $this->success("操作成功！");
            } else {
                $this->error("操作失败！");
            }
        }
    }
    
    //管理员操作积分
    function addscore(){
        //获取此商家信息
        $seller = M("oauth_user")
            ->alias("ou")//表别名
            ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
            ->where("ou.id=".I("get.id"))//条件
            ->field("s.*")//查询内容
            ->find();
        $this->assign($seller);
        $this->assign("userid",I("get.id"));
        $this->display();
    }
    //添加积分操作
    function addscore_post(){
        $_POST['remark'] = $_POST['remark']?$_POST['remark']:"管理员操作";
        $post = I("post.");
        //查询此商家的商家账户
        $seller = M("store")->find($_POST['id']);
        //查询此商家的会员账户
        $user = M("oauth_user")->find($post['userid']);

        $op = I("post.op");
        if(is_numeric($op)){
            //修改商家积分
            $seller['score'] += $op;
            M("store")->save($seller);

            //添加明细
            $ar = array(
                "userid"        =>      $post['userid'],
                "sellerid"        =>      sp_get_current_admin_id(),
                "op"        =>      "admin",
                "itype"        =>      2,
                "integral"        =>      $op,
                "integral_sj"        =>      $op,
                "cur_integral"        =>      $seller['score'],
                "remark"        =>      $post['remark'],
                "date"        =>      time(),
                "is_fanxian"    =>  0
            );
            M("user_integral")->add($ar);

            //发送消息
            sendmessage(sp_get_current_admin_id(),$post['userid'],"管理员操作",$post['remark'],array(
                $user['openid'],
                $post['remark'],
                $seller['name'],
                time(),
                $op,
                $seller['score'],
                "管理员操作",
                "感谢您的使用！",
                U("Portal/Seller/index",array("openid"=>$user['openid']))
            ),1,time());

            $this->success("修改成功！",U("Store/index"));
        }else{
            $this->error("参数错误！");
        }
    }
}