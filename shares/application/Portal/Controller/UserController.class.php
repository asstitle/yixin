<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/8
 * Time: 17:17
 */

namespace Portal\Controller;


use Common\Controller\HomeBaseController;

class UserController extends HomeBaseController
{
    protected $itype;
    function _initialize() {
        parent::_initialize();
        //从微信模板推送连过来时 会获得openid 直接登录
        
        //http://cfb.woyii.com/index.php?g=&m=Agent&a=score&openid=4242424 index.php/a/dd/b/
        //2016-7-5 解决之前发送模板信息时，openid链接错误，
        //加上，让所有过来的链接都不使用openid的值
        
        //if($_GET['openid']){
        if($_GET['openid'] && ACTION_NAME != 'score'){
            $_SESSION['openid'] = $_GET['openid'];
        }
        //判断session登錄
        if(!sp_is_user_login()){
            //判断是否绑定账号 如绑定直接自动登录
            //file_put_contents('aabb.txt', print_r($_SESSION, true));
            $user = M("oauth_user")->where("openid='".$_SESSION['openid']."' and openid <> ''")->find();
            if($user){
                sp_update_current_user($user);
            }else{
                $this->error("请登录！",U("Index/login"));
            }
        }
        $this->itype = 1;
        $user = M("oauth_user")->find(sp_get_current_userid());
        sp_update_current_user($user);
        //是否禁用
        if($user['user_status']==0 && $user['id'] != 2){
            $this->error("您的账号被禁用！",U("Index/index"));
        }
        $this->assign("itype",$user['user_type']);
        $this->assign("menu","user");
        $this->assign('active','user');
    }
    //个人会员中心
    function index(){
        //查询信息
        $user = M("oauth_user")->find(sp_get_current_userid());
        $this->disarray($user); //自定义，数组处理，将数组foreach出来，依次this->assign
        //查询未读消息
        $messagenus = M("user_message")->where("userid=".sp_get_current_userid()." and is_read=0")->count();
        $this->assign("messagenum",$messagenus);
        $this->display();
    }
    //设置中心
    function setting(){
        //跟新并获取user信息
        $user = M("oauth_user")->find(sp_get_current_userid());
        sp_update_current_user($user);
        //处理银行卡信息
        $user['yhzh'] = substr($user['yhzh'],0,3) . "****" . substr($user['yhzh'],-4);
        //处理手机号
        $user['mobile'] = substr($user['mobile'],0,3) . "****" . substr($user['mobile'],-3);
        //查询使用中的收货地址
        $where = array(
            "userid"    =>  sp_get_current_userid(),
            "default"    =>  1
        );
        $address = M("user_address")->where($where)->find();
        if($address){
            $address['phone'] = substr($address['phone'],0,3) . "****" . substr($address['phone'],-3);
            $this->assign("address",$address);
        }
        $this->disarray($user);
        $this->display();
    }
    //设置昵称页面
    function setting_name(){
        //获取昵称
        $user = sp_get_current_user();
        $this->assign("username",$user['user_nicename']);
        $this->display();
    }
    
    //设置真实姓名页面
    function zs_name(){
        //获取昵称
        $user = sp_get_current_user();
        $this->assign("zs_name",$user['zs_name']);
        $this->display();
    }
    
    //设置昵称操作
    function dosetting_name(){
        $ar = array(
            "id"    =>  sp_get_current_userid(),
            "user_nicename"    =>  I("post.name")
        );
        M("oauth_user")->save($ar);
        $this->ajaxReturn(array("success"=>"操作成功！","url"=>U("User/setting")));
    }
    
    //设置真实姓名操作
    function dozs_name(){
        
        /* $ar = array(
            "id"    =>  sp_get_current_userid(),
            "zs_name"    =>  I("post.name")
        ); */
        $data['zs_name'] = I("post.name");
        $uid = sp_get_current_userid();
        //$this->ajaxReturn(array('success'=>$ar['zs_name']));
        $jg = M("oauth_user")->where(" id = '$uid' ")->save($data);
        
        if($jg){
            $this->ajaxReturn(array("success"=>"操作成功！","url"=>U("User/setting")));
        }else{
            $this->ajaxReturn(array("success"=>"操作失败！"));
        }
        
        
    }
    //设置银行卡页面
    function setting_bankcard(){
        //查询银行卡配置
        $option = $this->site_options;
        $option = explode("\n",$option['site_yhcard']);
        $this->assign("yinghang",$option);
        //获取开户姓名
        $user = M("oauth_user")->find(sp_get_current_userid());
        $this->assign("name",$user['khxm']);
        $this->display();
    }
    //设置银行卡操作
    function dosetting_bankcard(){
        $ar = array(
            "id"    =>  sp_get_current_userid(),
            "khyh"    =>  I("post.khyh"),
            "khzh"    =>  I("post.khzh"),
            "yhzh"    =>  I("post.yhzh"),
            "idcard"    =>  I("post.idcard"),
        );
        if(I("post.khxm")){
            $ar['khxm'] = I("post.khxm");
        }
        M("oauth_user")->save($ar);
        $this->ajaxReturn(array("success"=>"操作成功！","url"=>U("User/setting")));
    }
    //设置支付密码页面
    function setting_pass(){
        //请求页面
        $this->assign("url",$_SERVER['HTTP_REFERER']);
        //获取密码
        $user = sp_get_current_user();
        $this->assign("pass",$user['zfmm']);

        $this->display();
    }
    //设置支付密码操作
    function dosetting_pass(){
        //获取用户信息
        $user = sp_get_current_user();
        $pass = I("post.zfmmold")?sp_password(I("post.zfmmold")):I("post.zfmmold");
        if($user['zfmm']==$pass){
            $ar = array(
                "id"    =>  sp_get_current_userid(),
                "zfmm"    =>  sp_password(I("post.zfmmnew"))
            );
            M("oauth_user")->save($ar);
            $this->ajaxReturn(array("success"=>"修改成功！","url"=>$_POST['url']));
        }else{
            $this->ajaxReturn(array("error"=>"原密码输入错误！请重新输入"));
        }
    }
    //设置密码页面
    function setting_password(){
        //请求页面
        $this->assign("url",$_SERVER['HTTP_REFERER']);
        //获取密码
        $user = sp_get_current_user();
        $this->assign("pass",$user['password']);
        $this->display();
    }
    //设置支付密码操作
    function dosetting_password(){
        //获取用户信息
        $user = sp_get_current_user();
        $pass = I("post.zfmmold")?sp_password(I("post.zfmmold")):I("post.zfmmold");
        if($user['password']==$pass){
            $ar = array(
                "id"    =>  sp_get_current_userid(),
                "password"    =>  sp_password(I("post.zfmmnew"))
            );
            M("oauth_user")->save($ar);
            $this->ajaxReturn(array("success"=>"修改成功！","url"=>$_POST['url']));
        }else{
            $this->ajaxReturn(array("error"=>"原密码输入错误！请重新输入"));
        }
    }
    //设置收货地址页面
    function setting_address(){
        //接收是否来自订单页面
        unset($_GET['address']);
        $order = intval(I("get.order"));
        
        $this->assign("order",$order);
        //查询收货地址
        $list = M("user_address")->where("userid=".sp_get_current_userid())->order("id desc")->select();
        $this->assign("list",$list);

        //如获取id则为修改 否则添加
        if(I("get.id")){
            $ar = M("user_address")->find(I("get.id"));
            $this->assign("id",I("get.id"));
            $this->disarray($ar);
        }
        $this->assign("gets",$_GET);
        $this->display();
    }
    //设置收货地址操作
    function dosetting_address(){
        unset($_GET['address']);
        $gets = $_GET;
        if(I("post.id")==""){
            //添加
            //将其他当前地址的选中状态取消
            M("user_address")->where("userid=".sp_get_current_userid())->setField("default","0");
            $_POST['userid'] = sp_get_current_userid();
            $_POST['default'] = 1;
            if(M("user_address")->add($_POST)){
                $this->ajaxReturn(array("success"=>"添加成功！","url"=>U("User/setting_address",$gets)));
            }else{
                $this->ajaxReturn(array("error"=>"添加失败！请重新输入"));
            }
        }else{
            //修改
            if(M("user_address")->save(I("post."))){
                $this->ajaxReturn(array("success"=>"修改成功！","url"=>U("User/setting_address",$gets)));
            }else{
                $this->ajaxReturn(array("error"=>"修改失败！"));
            }
        }

    }
    //设置默认收货地址
    function setdfaddress(){
        //将其他当前地址的选中状态取消
        M("user_address")->where("userid=".sp_get_current_userid())->setField("default","0");
        //修改当前默认地址
        M("user_address")->where("id=".I("post.id"))->setField("default","1");
    }
    //删除收货地址
    function removeaddress(){
        
        //获取删除的地址信息
        $address = M("user_address")->find(I("get.id"));
        //执行删除
        M("user_address")->delete(I("get.id"));
        //判断删除的是否为当前使用地址
        if($address['default']==1){
            //在判断是否存在其他地址 如存在 将第一条改为默认地址
            $list = M("user_address")->where("userid=".sp_get_current_userid())->order("id desc")->find();
            if($list){
                $list['default'] = 1;
                M("user_address")->save($list);
            }
        }
        unset($_GET['id']);
        $gets = $_GET;
        $this->ajaxReturn(array("success"=>"删除成功！","url"=>U("User/setting_address", $gets)));
    }
    //积分
    function score(){
        //查询用户
        $user = sp_get_current_user();
        $where = array(
            "userid"        =>      sp_get_current_userid(),
            "itype"        =>      $this->itype,
            "op"            =>      array(array('neq',"shopping_xj"),array('neq',"shopping_wx"),"and")
        );
        if($this->itype==2){
            $ar = M("store")->where("uid=".sp_get_current_userid())->find();
            $user['score'] = $ar['score'];
            $user['user_img'] = $ar['logo'];
            
            $where['op'] = array(array("like","tixian"),array("like","declaration"),array("like","jifen_sk"),array("like","weixin_sk"),array("like","admin"),"or");
        }
        if($this->itype==3){
            $ar = M("user_dl")->where("uid=".sp_get_current_userid())->find();
            $user['score'] = $ar['dl_score'];
            $where['op'] = array(array("like","tixian"),array("like","fenyong"),array("like","fenyong_qy"),"or");
        }
        $this->disarray($user);
        if (!$_GET['ajax']) {
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
            if($val['op']=="declaration" || $val['op']=="tixian" || $val['op']=="shopping_jf" || $val['op']=="shopping_wx"){
                if($val['op']=="tixian"){
                    $list[$key]['integral_sj'] = $list[$key]['integral'];
                }
                $list[$key]['integral_sj'] = "-".$list[$key]['integral_sj'];
            }

            $list[$key]['date'] = date("Y-m-d",$val['date']);
        }
        ajax_list($list); //处理ajax
    }
    
    //订单
    function order(){
        //查询用户
        $where = array(
            "uid"        =>      sp_get_current_userid(),
        );
        $type  = intval(I('get.type'));
        
        if ($type) {
            $_GET['type'] = $type;
            $where['order_state'] = $type;
            $this->assign("type", $type);
        }
        $user = sp_get_current_user();
        $this->disarray($user);
        if (!$_GET['ajax']) {
            $this->display();
            exit;
        }
        
        
        $count = M("order")
            ->where($where)
            ->count();//获取条数

        $page = $this->page($count, 9,$_GET['p']);//设置分页信息

        $list = M("order")
            ->alias("o")
            ->join(C ( 'DB_PREFIX' )."curriculum c ON o.curriculum_id = c.id")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("o.id desc")
            ->select();
       
        foreach ($list as $keys => $values)
        {
            $order_date = date('Y-m-d H:i:s',$values['order_date']);
            $list[$keys]['order_date'] = $order_date;     
        }
        
        ajax_list($list); //处理ajax
    }
    //订单详情
    function orderdetails(){
        $id = intval(I("get.id"));
        $list = M("order")->where("id='$id'")->find();
        $list['view'] = M("order_goods")
        ->alias("a")
        ->join(C ( 'DB_PREFIX' )."goods b ON a.goods_id = b.id")
        ->join(C ( 'DB_PREFIX' )."goods_pic c ON a.goods_id = c.goods_id")
        ->where("a.order_id='$id'")
        ->field("a.*, b.spec_color spec_color_name, b.spec_size spec_size_name")
        ->select();
        $list['address'] = M("user_address")->where("id='$list[address_id]'")->find();
        $list['fhfs2'] = $list['fhfs'];
        unset($list['fhfs']);
        $this->assign($list);
        $this->display();
    }
    //提现记录
    function record_tx(){
        $where = array(
            "uid"        =>      sp_get_current_userid(),
            "itype"        =>      $this->itype
        );
        if (!$_GET['ajax']) {
            //累计提现
            $alltx = M("user_withdraw")->where($where)->field('sum(price) price')->find();
            $this->assign("alltx",sprintf("%.2f",$alltx['price']));
            $this->display();
            exit;
        }
        $count = M("user_withdraw")
            ->where($where)
            ->count();//获取条数

        $page = $this->page($count, 9,$_GET['p']);//设置分页信息

        $list = M("user_withdraw")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("id desc")
            ->select();
        foreach($list as $key => $val){
            $list[$key]['date'] = date("Y-m-d",$val['date']);
            $list[$key]['state'] = $val['state']==1?"待处理":"已处理";
        }
        ajax_list($list); //处理ajax
        $this->display();
    }
    //消息中心
    function message(){
        $where = array(
            "userid"        =>      sp_get_current_userid()
        );
        if (!$_GET['ajax']) {
            $this->display();
            exit;
        }
        $count = M("user_message")
            ->where($where)
            ->count();//获取条数

        $page = $this->page($count, 9,$_GET['p']);//设置分页信息

        $list = M("user_message")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("id desc")
            ->select();

        foreach($list as $key => $val){
            $list[$key]['date'] = date("Y-m-d H:i:s",$val['date']);//时间
            $list[$key]['url'] = U(CONTROLLER_NAME."/message_xq",array("id"=>$val['id']));//详情
            $list[$key]['delete'] = U(CONTROLLER_NAME."/message_delete",array("id"=>$val['id']));//删除
            //截取内容
            $list[$key]['content'] = mb_substr($val['content'],0,40,'utf-8');
        }
        ajax_list($list); //处理ajax
        $this->display();
    }
    //删除消息
    function message_delete(){
        if(M("user_message")->delete($_GET['id'])){
            $this->ajaxReturn(array("success"=>"删除成功！","url"=>U(CONTROLLER_NAME."/message")));
        }else{
            $this->ajaxReturn(array("error"=>"删除失败！"));
        }
    }
    //消息详情
    function message_xq(){
        $ar = M("user_message")->find($_GET['id']);
        //标为已读
        $ar['is_read'] = 1;
        M("user_message")->save($ar);
        $this->disarray($ar);
        $this->display();
    }
    //返现
    function rebates(){
       
        $uid = sp_get_current_userid();
        
        
        $count = M('rebate_list')
            ->alias("rl")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON rl.buy_uid = ou.id")
            ->where(" rl.get_uid = '$uid' ")
            ->count();
        
        $page = $this->page($count, 9,$_GET['p']);//设置分页信息
        
        $list = M('rebate_list')
            ->alias("rl")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON rl.buy_uid = ou.id")
            ->where(" rl.get_uid = '$uid' ")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        
        ajax_list($list); //处理ajax
        $this->display();
    }
    //我的邀请
    function invite(){
        //查询我的邀请
        $where = array(
            "tjrr"        =>      sp_get_current_userid()
        );
        if (!$_GET['ajax']) {
            //查询累计佣金
            $where = array(
                "userid"        =>      sp_get_current_userid(),
                "op"        =>      array(array("like","fenyong"),"or")
            );
            $allyj = M("user_integral")->where($where)->field("sum(`integral_sj`) price")->find();
            $this->assign("allyj",$allyj['price']);
            $this->display();
            exit;
        }
        $count = M("oauth_user")
            ->where($where)
            ->count();//获取条数

        $page = $this->page($count, 9,$_GET['p']);//设置分页信息

        $list = M("oauth_user")
            ->where($where)
            ->field("*,IF(user_nicename='', mobile,user_nicename) user_nicename, user_img, create_time")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("id desc")
            ->select();
        foreach($list as $key => $val){
            $list[$key]['create_time'] = date("Y-m-d",$val['create_time']);
            //统计每人提供的佣金
            $where = array(
                "get_uid"        =>      sp_get_current_userid(),
                "buy_uid"        =>      $val['id'],
                "op"        =>      array(array("like","fenyong"),"or")
            );
            $money = M("rebate_list")->where($where)->field("sum(`rebate_money`) price")->find();
            $list[$key]['yongjin'] = $money['price']?$money['price']:0;
        }
        ajax_list($list); //处理ajax
        $this->display();
    }
    //我要付款
    function payment(){

        //判断是否有支付密码 没有跳转
        $user = sp_get_current_user();
        if(!$user['zfmm']){
            $this->error("请先设置支付密码！",U('User/setting_pass'));
        }
        $user = sp_get_current_user();
        $this->assign("user",$user);

        //扫一扫
        $options = $this->site_options;
        $jssdk = new \Org\Util\Jssdk($options['site_AppId'], $options['site_AppSecret']);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign($signPackage);

        //若从店铺详情进入 获取商家账号
        $this->assign("userphone",I("get.phone"));

        $this->display();
    }
    //付款成功
    function payment_sc(){
        $this->assign($_GET);
        $this->display();
    }
    //二维码
    function code(){
        $this->display();
    }
    //账户消费
    function consumption(){
        if (!$_GET['ajax']) {
            //查询用户
            $user = sp_get_current_user();
            $this->disarray($user);
            $this->display();
            exit;
        }
        $where = "ui.userid = ".sp_get_current_userid()." and (ui.op = 'shopping_xj' or ui.op = 'shopping_wx' or (ui.op='declaration' and ui.is_fanxian=1))";
        $count = M("user_integral")
            ->alias("ui")//表别名
            ->join(C ( 'DB_PREFIX' )."store s ON s.id = ui.sellerid","LEFT")
            ->where($where)
            ->count();//获取条数

        $page = $this->page($count, 9,$_GET['p']);//设置分页信息

        $list = M("user_integral")
            ->alias("ui")//表别名
            ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ui.sellerid","LEFT")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->field("ui.*,s.name")
            ->order("ui.id desc")
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
    //提现申请
    function shenqing_tx(){
        //判断是否设置银行卡
        
        
        
        $user = M("oauth_user")->find(sp_get_current_userid());
        $this->assign($user);
        if(!$user['khyh'] || !$user['khzh']){
            $this->error("请设置银行卡",U("User/setting_bankcard"));
        }
        //根据身份 分别获取积分
        if($this->itype==1){
            $score = $user['score'];
        }
       /*  if($this->itype==2){
            $score = M("oauth_user")
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."store s ON ou.id = s.uid","LEFT")
                ->where("ou.id=".$user['id'])//条件
                ->field("s.*")//查询内容
                ->find();
            $score = $score['score'];

        }
        if($this->itype==3){
            $score = M("oauth_user")
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."user_dl dl ON ou.id = dl.uid","LEFT")
                ->where("ou.id=".$user['id'])//条件
                ->field("dl.*")//查询内容
                ->find();
            $score = $score['dl_score'];
        } */
        //处理银行卡
        
        
        $sx_options = $this->site_options;
        $sx_price = $sx_options['site_txhy'];
        $this->assign('sx_price',$sx_price);
        $yhk = substr($user['yhzh'],0,3) . "****" . substr($user['yhzh'],-4);
        $this->assign("itype",$this->itype);
        $this->assign("yhk",$yhk);
        $this->assign("score",$score);
        $this->display();
    }
    //提现申请
    function doshenqing(){
        $post = I("post.");

        if($post['price'] < 100) {
            $this->ajaxReturn(array("error"=>"提现金额最少100元！"));
        }
        //判断一天只能申请一次
        $where = " uid = " . sp_get_current_userid();
        $where .= " AND DATE_FORMAT(FROM_UNIXTIME(date),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')";
        $withdraw = M("user_withdraw")->where($where)->find();
        if($withdraw){
            //$this->ajaxReturn(array("error"=>"当天已经申请提现..."));
        }
        //判断密码
        $user = M("oauth_user")->find(sp_get_current_userid());

        if($user['zfmm']!=sp_password($post['zfmm'])){
            $this->ajaxReturn(array("error"=>"支付密码错误 ！请重新输入..."));
        }

        $_POST['itype'] = $post['itype'];
        $sxf = R("Index/txsxf");

        $sx_options = $this->site_options;
        $sx_price = $sx_options['site_txhy'];
        
        //扣除积分 分多种方式
        if($post['itype']==1){
            if($user['score']<$post['price']+$sx_price){
                $this->ajaxReturn(array("error"=>"余额不足！无法提现！"));
            }
            $user['score'] = $user['score'] - $post['price'];
            M("oauth_user")->save($user);
        }
       /*  if($post['itype']==2){
            $seller = M("oauth_user")
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."store s ON ou.id = s.uid","LEFT")
                ->where("ou.id=".$user['id'])//条件
                ->field("s.*")//查询内容
                ->find();
            if($seller['score']<$post['price']){
                $this->ajaxReturn(array("error"=>"积分不足！无法提现！"));
            }
            $ar = array(
                "id"        =>      $seller['id'],
                "score"        =>      $seller['score'] - $post['price']
            );
            M("store")->save($ar);
        }
        if($post['itype']==3){
            $dl = M("oauth_user")
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."user_dl ud ON ou.id = ud.uid","LEFT")
                ->where("ou.id=".$user['id'])//条件
                ->field("ud.*")//查询内容
                ->find();
            if($dl['dl_score']<$post['price']){
                $this->ajaxReturn(array("error"=>"积分不足！无法提现！"));
            }
            $ar = array(
                "id"        =>      $dl['id'],
                "dl_score"        =>      $dl['dl_score'] - $post['price']
            );
            M("user_dl")->save($ar);
        } */

        //提现记录
        $ar = array(
            "uid"       =>      sp_get_current_userid(),
            "itype"       =>      $post['itype'],
            "price"       =>      $post['price'],
            "fee"       =>      $sxf,
            "sjdz"       =>      $post['price']-$sxf,
            "state"       =>      1,
            "khyh"       =>      $user['khyh'],
            "khzh"       =>      $user['khzh'],
            "khxm"       =>      $user['khxm'],
            "yhzh"       =>      $user['yhzh'],
            "date"       =>      time()
        );
        M("user_withdraw")->add($ar);

        //明细记录
        $ar = array(
            "userid"        =>      sp_get_current_userid(),
            "sellerid"        =>      "",
            "op"        =>      "tixian",
            "itype"        =>      $post['itype'],
            "integral"        =>      $post['price'],
            "integral_sj"        =>      $post['price']-$sxf,
            "cur_integral"        =>      $user['score'],
            "remark"        =>      "您提出了提现申请 金额：".$post['price']." 手续费：".$sxf." 元,实际到账：".($post['price']-$sxf)." 元",
            "date"        =>      time(),
        );

        M("user_integral")->add($ar);

        $ar = array("price"=>$post['price']);

        $this->ajaxReturn(array("success"=>"提现成功!","url"=>U(CONTROLLER_NAME."/shenqing_sc",$ar)));
    }
    //申请成功页面
    function shenqing_sc(){
        $this->assign($_GET);
        $this->display();
    }
    //分享页面
    function share(){
        $uid = sp_get_current_userid();
        $jg = M('order')->where(" uid = '$uid' AND order_state = 1 ")->select();
        
        if(!$jg){
            $this->error("必须购买课程后方可分享");
        }
        
        //查询信息
        $user = M("oauth_user")->find($uid);
        $this->disarray($user);
        
        $this->display();
    }
    //退出登录
    function loginout(){
        //解除绑定
        $user = M("oauth_user")->find(sp_get_current_userid());
        $user['openid'] = "";
        M("oauth_user")->save($user);
        unset($_SESSION['user']);
        $this->ajaxReturn(array("success"=>"退出成功！","url"=>U("Index/index")));
    }

    //申请成为商家
   /*  function applyseller(){
        //查询是否申请过
        $where = array(
            "uid"           =>          sp_get_current_userid(),
            "op"            =>          "add",
            "status"        =>          0
        );
        $ar = M("store_xn")->where($where)->find();
        if($ar){
            $this->error("您已申请过了！ 请耐心等待管理员审核..");
        }
        $this->display();
    } */
    //申请商家操作
   /*  function doapplyseller(){
        $post = I("post.");
        $ar = array(
            "uid"       =>      sp_get_current_userid(),
            "name"      =>      $post['name'],
            "sheng"      =>      $post['sheng'],
            "shi"      =>      $post['shi'],
            "qu"      =>      $post['qu'],
            "address"      =>      $post['address'],
            "phone"      =>      $post['phone'],
            "rjxf"      =>      $post['rjxf'],
            "logo"      =>      $post['logo'],
            "about"      =>      $post['about'],
            "op"      =>      "add",
            "date"      =>      time(),
            "status"      =>      0
        );
        M("store_xn")->add($ar);
        $this->ajaxReturn(array("success"=>"申请成功！等待管理员审核..","url"=>U("User/index")));
    } */

    //支付操作
    function dopay(){
        //获取当前时间戳 当做订单号判断
        $date_now = time();

        $options = $this->site_options;
        $post = I("post.");
        //判断支付密码是否正确
        $user = M("oauth_user")->find(sp_get_current_userid());
//        if($user['zfmm']!=sp_password($post['zfmm'])){
//            $this->ajaxReturn(array("error"=>"支付密码输入错误!"));
//        }

        //判断30秒内只能提交一次
        $info = M("user_integral")->where("sellerid='".sp_get_current_userid()."' AND ({$date_now}-`date`) <= 30")->find();
        $info &&  $this->ajaxReturn(array("error"=>"请勿重复提交!"));
            
        //判断支付方式
        //1 微支付 2积分支付
        if($post['type']==2){
            //金额不足
            if($user['score']<$post['price']){
                $this->ajaxReturn(array("error"=>"您的积分余额不足!"));
            }

            //扣除积分
            $newscore  = $user['score'] - $post['price'];
            $user['score'] = $newscore;

            //计算实际操作积分
            $sjscore = R("Index/getprice");

            M("oauth_user")->save($user);

            //获取商家信息
            $where = array(
                "ou.mobile"		=>		$post['seller'],
                "ou.user_type"		=>		2,
                "s.status"		=>		1,
            );
            $seller = M("oauth_user")
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
                ->where($where)//条件
                ->field("ou.*,s.*,ou.id,s.id sid")//查询内容
                ->find();

            //手续费
            //用户用积分想商家支付 商家收到的款项会直接扣除平台手续费 二不会计算商家本身的赠送比例
            $sxf = $post['price'] * $options['site_xttc']/100;
            //修改商家积分
            $nowseller = M("store")->find($seller['sid']);
            $nowseller['score'] = $seller['score'] + ($post['price'] - $sxf);
            M("store")->save($nowseller);
            //添加明细
            //用户
            $ar = array(
                "userid"        =>      sp_get_current_userid(),
                "sellerid"        =>      $seller['id'],
                "op"        =>      "shopping_jf",
                "itype"        =>      1,
                "integral"        =>      $post['price'],
                "integral_sj"        =>      $post['price'],
                "cur_integral"        =>      $newscore,
                "remark"        =>      "您在".$seller['name']."消费了".$post['price']."积分",
                "date"        =>      $date_now,
                "is_fanxian"        =>      $seller['isreturn']
            );
            M("user_integral")->add($ar);

            $str = "";
            //判断商家是否开通返现 如开启 将手续费按比例返现到商家的会员积分里
            if($seller['isreturn'] == 1){
                //修改此商家的会员的未返积分
                $u = M("oauth_user")->find($seller['id']);
                $u['wfjf'] += $sxf;
                M("oauth_user")->save($u);
                $str = "获得未返积分".$sxf."元！";
            }

            //商家
            $ar = array(
                "userid"        =>      $seller['id'],
                "sellerid"        =>      sp_get_current_userid(),
                "op"        =>      "jifen_sk",
                "itype"        =>      2,
                "integral"        =>      $post['price'],
                "integral_sj"        =>      $post['price'] - $sxf,
                "cur_integral"        =>      $nowseller['score'],
                "remark"        =>      $user['user_nicename']."消费了".$post['price']."元,实际获得".($post['price'] - $sxf)."元，扣除手续费".$sxf."元。".$str,
                "date"        =>      $date_now,
                "is_fanxian"    =>      $seller['isreturn']
            );
            $lsid = M("user_integral")->add($ar);


            $ar = array(
                "price"     =>      $post['price'],
                "date"     =>      $date_now
            );

            //用户消息发送
            sendmessage($seller['id'],sp_get_current_userid(),"积分购物","您在".$seller['name']."消费了".$post['price']."积分",array(
                $user['openid'],
                "您在".$seller['name']."消费了".$post['price']."积分",
                ($user['user_nicename']?$user['user_nicename']:$user['mobile']),
                $date_now,
                "-".$post['price'],
                $newscore,
                "积分支付",
                "感谢您的使用！",
                U("User/score",array("openid"=>$user['openid']))
            ),1,$date_now);
            //商家消息发送
            sendmessage(sp_get_current_userid(),$seller['id'],"积分收款",($user['user_nicename']?$user['user_nicename']:$user['mobile'])."消费了".$post['price']."元,实际获得".($post['price'] - $sxf)."元，扣除手续费".$sxf."元。".$str,array(
                $seller['openid'],
                ($user['user_nicename']?$user['user_nicename']:$user['mobile'])."消费了".$post['price']."元,实际获得".($post['price'] - $sxf)."元，扣除手续费".$sxf."元。".$str,
                ($seller['user_nicename']?$seller['user_nicename']:$seller['mobile']),
                $date_now,
                $post['price'] - $sxf,
                $nowseller['score'],
                "积分收款",
                "感谢您的使用！",
                U("Seller/details_xq",array("id"=>$lsid,"openid"=>$user['openid']))
            ),1,$date_now);

            $this->ajaxReturn(array("success"=>"付款成功！","url"=>U("User/payment_sc",$ar)));
        }else{

        }
    }
    
    
    /**
     * -----------------------------------------------微信接口-------------------------------------
     * 
     **/

    public function js_api_call () {

        //$order_sn = I('get.order_sn', '');
        vendor('Weixinpay.WxPayPubHelper');
        //使用jsapi接口
        $jsApi = new \JsApi_pub();
        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        //$_GET['code'] = $_SESSION['user']['openid'];
        $seller = M("oauth_user")
            ->where("mobile='".$_POST['seller']."'")//条件
            ->find();
        $order_sn = time() . "_" .$seller['id']."_".sp_get_current_userid();
//        json_encode($_POST)
        $user = sp_get_current_user();
        $openid = $user['openid'];
        $res = array(
            'order_sn' => $order_sn,
            'order_amount' => $_POST['price'],
            //'order_amount' => 0.01,
        );
        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new \UnifiedOrder_pub();
        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        $total_fee = $res['order_amount']*100;
        //$total_fee = 1;
        $body = "订单支付{$res['order_sn']}";
        $unifiedOrder->setParameter("openid", "$openid");//用户标识
        $unifiedOrder->setParameter("body", $body);//商品描述
        //自定义订单号，此处仅作举例
        $out_trade_no = $res['order_sn'];
        $unifiedOrder->setParameter("out_trade_no", $out_trade_no);//商户订单号
        $unifiedOrder->setParameter("total_fee", $total_fee);//总金额
        //$unifiedOrder->setParameter("attach", "order_sn={$res['order_sn']}");//附加数据
        $unifiedOrder->setParameter("notify_url", $this->getsiteurl().'/index.php/portal/Pay/notify_url');//通知地址
        $unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
        //非必填参数，商户可根据实际情况选填
        //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
        //$unifiedOrder->setParameter("device_info","XXXX");//设备号
        //$unifiedOrder->setParameter("attach","XXXX");//附加数据
        //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
        //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
        //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
        //$unifiedOrder->setParameter("openid","XXXX");//用户标识
        //$unifiedOrder->setParameter("product_id","XXXX");//商品ID
        $prepay_id = $unifiedOrder->getPrepayId();
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);
        $jsApiParameters = $jsApi->getParameters();
        $wxconf = json_decode($jsApiParameters, true);
        if ($wxconf['package'] == 'prepay_id=') {
            $this->error('当前订单存在异常，不能使用支付');
        }
        echo $jsApiParameters;
//        $this->assign('res', $res);
//        $this->assign('jsApiParameters', $jsApiParameters);
        //file_put_contents("a.txt",$jsApiParameters);

	}
    
    //找回支付密码
	function zhzfmm(){
		$this->display();
	}
	//修改支付密码
	function dozhzfmm(){
		$post = I("post.");
		if($_SESSION['phone']!=$post['code']){
			$this->ajaxReturn(array("error"=>"验证码错误！","url"=>U("user/zhzfmm")));
		}
		//修改密码
		$user = M("oauth_user")->where("mobile='".$post['phone']."'")->find();
		$user['zfmm'] = sp_password($post['password']);
		M("oauth_user")->save($user);
		$this->ajaxReturn(array("success"=>"支付密码修改成功！","url"=>U("user/index")));
	}

}