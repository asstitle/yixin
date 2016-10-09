<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/15
 * Time: 10:45
 */

namespace Portal\Controller;


use Common\Controller\HomeBaseController;

class SellerController extends UserController
{

    protected $itype;
    function _initialize() {
        parent::_initialize();
        //禁用
        $seller = M("oauth_user")
            ->alias("ou")//表别名
            ->join(C ( 'DB_PREFIX' )."store s ON ou.id = s.uid","LEFT")
            ->where("ou.id=".sp_get_current_userid())//条件
            ->field("ou.*,s.score,s.logo,s.name,s.isenable")//查询内容
            ->find();
        if($seller['isenable']==0){
            $this->error("您的商家账户被禁用！");
        }
        //身份标示（商家）
        $this->itype = 2;
        $this->assign("menu","seller");
    }

    function index(){
        //查询信息
        $user = M("oauth_user")
            ->alias("ou")//表别名
            ->join(C ( 'DB_PREFIX' )."store s ON ou.id = s.uid","LEFT")
            ->where("ou.id=".sp_get_current_userid())//条件
            ->field("ou.*,s.score,s.logo,s.name")//查询内容
            ->find();
        //查询未读消息
        $messagenus = M("user_message")->where("userid=".sp_get_current_userid()." and is_read=0")->count();
        $this->assign("messagenum",$messagenus);

        $this->disarray($user);
        $this->display();
    }
    //商家收款
    function payable(){
        //判断是否有支付密码 没有跳转
        $user = sp_get_current_user();
        if(!$user['zfmm']){
            $this->error("请先设置支付密码！",U('User/setting_pass'));
        }

        //扫一扫
        $options = $this->site_options;
        $jssdk = new \Org\Util\Jssdk($options['site_AppId'], $options['site_AppSecret']);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign($signPackage);

        $this->display();
    }
    //商家流水
    function details(){
        if (!$_GET['ajax']) {
            //查询店铺信息
            $user = M("oauth_user")
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."store s ON ou.id = s.uid","LEFT")
                ->where("ou.id=".sp_get_current_userid())//条件
                ->field("ou.*,s.score,s.logo img,s.name")//查询内容
                ->find();
            $this->assign($user);
            //总积分收款
            $where = array(
                "userid"       =>      sp_get_current_userid(),
                "itype"       =>      2,
                "op"       =>      "jifen_sk"
            );
            $alljf = M("user_integral")->where($where)->field("sum(`integral`) alljf")->find();
            $alljf = $alljf['alljf'];
            //总现金收款
            $where['op'] = "declaration";
            $allxj = M("user_integral")->where($where)->field("sum(`integral`) allxj")->find();
            $allxj = abs($allxj['allxj']);
            //总微信收款
            $where['op'] = "weixin_sk";
            $allwx = M("user_integral")->where($where)->field("sum(`integral`) allwx")->find();
            $allwx = abs($allwx['allwx']);

            //总收款 = 总积分收款 + 总现金收款 + 总微信收款
            $allsk = $alljf + $allxj + $allwx;
            $this->assign("allsk",$allsk);
            $this->display();
            exit;
        }
        $where = array(
            "ui.userid"        =>      sp_get_current_userid(),
            "ui.itype"        =>      $this->itype,
            "ui.op"        =>      array(array("like","jifen_sk"),array("like","declaration"),array("like","weixin_sk"),"or")
        );

        $count = M("user_integral")
            ->alias("ui")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ui.userid = ou.id")
            ->where($where)
            ->count();//获取条数
        $page = $this->page($count, 9,$_GET['p']);//设置分页信息
        $list = M("user_integral")
            ->alias("ui")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ui.userid = ou.id")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->field("ui.*,ou.user_nicename name, IF(ui.op = 'declaration', (ui.integral - ui.integral_sj), ui.integral_sj) integral_sj")
            ->order("ui.id desc")
            ->select();
        foreach($list as $key => $val){
            $list[$key]['date'] = date("Y-m-d H:i:s",$val['date']);
            $list[$key]['url'] = U('Seller/details_xq',array('id'=>$val['id']));
            //查询消费用户账号
            $ar = M("oauth_user")->find($val['sellerid']);
            $list[$key]['mobile'] = substr($ar['mobile'],0,3) . "****" .substr($ar['mobile'],strlen($ar['mobile'])-3);
        }
        ajax_list($list); //处理ajax
        $this->display();
    }
    //商家流水详情
    function details_xq(){
        $list = M("user_integral")
            ->alias("ui")
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ui.userid = ou.id")
            ->where("ui.id=".I("get.id"))
            ->field("ui.*,ou.user_nicename name,ou.mobile mobile")
            ->find();
        //查询消费用户账号
        $ar = M("oauth_user")->find($list['sellerid']);
        $list['mobile'] = substr($ar['mobile'],0,3) . "****" .substr($ar['mobile'],strlen($ar['mobile'])-3);
        $this->disarray($list);
        $this->display();
    }
    //分享页面
    function share(){
        $this->display();
    }
    //店铺管理
    function setting(){
        $user = M("oauth_user")
            ->alias("ou")//表别名
            ->join(C ( 'DB_PREFIX' )."store s ON ou.id = s.uid","LEFT")
            ->where("ou.id=".sp_get_current_userid())//条件
            ->field("s.*")//查询内容
            ->find();
        $this->disarray($user);
        $this->display();
    }
    //修改店铺
    function dosetting(){
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
            "op"      =>      "save",
            "date"      =>      time(),
            "status"      =>      0
        );
        M("store_xn")->add($ar);

        $this->ajaxReturn(array("success"=>"修改成功！等待管理员审核..","url"=>U("Seller/index")));
    }
    //支付操作
    function dopay(){
        //获取当前时间戳 当做订单号判断
        $date_now = time();

        //判断30秒内只能提交一次
        $info = M("user_integral")->where("sellerid='".sp_get_current_userid()."' AND ({$date_now}-`date`) <= 30")->find();
        $info &&  $this->ajaxReturn(array("error"=>"请勿重复提交!"));        
        
        $options = $this->site_options;
        $post = I("post.");
        //判断支付密码是否正确
        $user_seller = M("oauth_user")
            ->alias("ou")//表别名
            ->join(C ( 'DB_PREFIX' )."store s ON ou.id = s.uid","LEFT")
            ->where("ou.id=".sp_get_current_userid())//条件
            ->field("ou.*,s.score,s.isreturn")//查询内容
            ->find();
        if($user_seller['zfmm']!=sp_password($post['zfmm'])){
            $this->ajaxReturn(array("error"=>"支付密码输入错误!"));
        }
        //判断支付方式
        //1 微支付 2现金支付
        if($post['type']==2){
            //计算手续费
            $sxf = R("Index/getsxf");
            //金额不足
            if($user_seller['score']<$sxf['sxf']){
                $this->ajaxReturn(array("error"=>"您的积分余额不足!"));
            }

            //扣除积分
            $seller = M("store")->where("uid=".sp_get_current_userid())->find();
            $newscore  = $seller['score'] - $sxf['sxf'];
            $seller['score'] = $newscore;
            M("store")->save($seller);

            //判断商家是否开通返现 如开启 将手续费按比例返现到商家的会员积分里
            if($user_seller['isreturn'] == 1){
                $ar = array(
                    "wfjf"      =>      $user_seller['wfjf'] + $sxf['sxf'],
                    "id"        =>      $user_seller['id']
                );
                //修改此商家的会员的未返积分
                M("oauth_user")->save($ar);
                $str = "获得未返积分".$sxf['sxf']."分！";
            }

            //获取用户
            $where = array(
                "mobile"		=>		$post['user'],
                "user_status"		=>		1,
            );
            $user = M("oauth_user")
                ->where($where)//条件
                ->find();

            //增加用户未返积分
            $user['wfjf'] = $user['wfjf'] + $sxf['price'];
            M("oauth_user")->save($user);
            
            //添加明细
            //用户
            $ar = array(
                "userid"        =>      $user['id'],
                "sellerid"        =>      sp_get_current_userid(),
                "op"        =>      "shopping_xj",
                "itype"        =>      1,
                "integral"        =>      $post['price'],
                "integral_sj"        =>      $sxf['price'],
                "cur_integral"        =>      $user['score'],
                "remark"        =>      "您在".$seller['name']."消费了".$post['price']."元！获得 ".$sxf['price']." 未返积分",
                "date"        =>      $date_now,
                "is_fanxian"    =>  $user_seller['isreturn']
            );
            M("user_integral")->add($ar);

            //用户上级提成
            $this->pubtc(1,$user['id'],$user['tjrr'],$sxf['price'],$date_now);
            //商家
            $ar = array(
                "userid"        =>      sp_get_current_userid(),
                "sellerid"        =>      $user['id'],
                "op"        =>      "declaration",
                "itype"        =>      2,
                "integral"        =>      $post['price'],
                "integral_sj"        =>      $sxf['sxf'],
                "cur_integral"        =>      $newscore,
                "remark"        =>      ($user['user_nicename']?$user['user_nicename']:$user['mobile'])."现金消费了".$post['price']."元,扣除手续费".$sxf['sxf']."元。".$str,
                "date"        =>      $date_now,
                "is_fanxian"        =>      $user_seller['isreturn']
            );
            $lsid = M("user_integral")->add($ar);
            
            //商家上级提成
            $this->pubtc(2,$user_seller['id'],$user_seller['tjrr'],$sxf['price'],$date_now);
            //用户消息发送
            sendmessage(sp_get_current_userid(),$user['id'],"现金购物","您在".$seller['name']."消费了".$post['price']."元！获得 ".$sxf['price']." 未返积分",array(
                $user['openid'],
                "您在".$seller['name']."消费了".$post['price']."元！获得 ".$sxf['price']." 未返积分",
                ($user['user_nicename']?$user['user_nicename']:$user['mobile']),
                $date_now,
                0,
                $user['score'],
                "现金支付",
                "感谢您的使用！",
                U("User/score",array("openid"=>$user['openid']))
            ),1,$date_now);
            //商家消息发送
            sendmessage($user['id'],sp_get_current_userid(),"商家报单",($user['user_nicename']?$user['user_nicename']:$user['mobile'])."现金消费了".$post['price']."元,扣除手续费".$sxf['sxf']."元。".$str,array(
                $user_seller['openid'],
                ($user['user_nicename']?$user['user_nicename']:$user['mobile'])."现金消费了".$post['price']."元,扣除手续费".$sxf['sxf']."元。".$str,
                ($user_seller['user_nicename']?$user_seller['user_nicename']:$user_seller['mobile']),
                $date_now,
                "-".$sxf['sxf'],
                $newscore,
                "支付手续费",
                "感谢您的使用！",
                U("Seller/details_xq",array("id"=>$lsid,"openid"=>$user_seller['openid']))
            ),1,$date_now);
            
            $ar = array(
                "price"     =>      $post['price'],
                "date"     =>      $date_now
            );
            $this->ajaxReturn(array("success"=>"付款成功！","url"=>U("Seller/payment_sc",$ar)));
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
        $user = M("oauth_user")
            ->where("mobile=".$_POST['user'])//条件
            ->find();
        $seller = M("oauth_user")
            ->alias("ou")//表别名
            ->join(C ( 'DB_PREFIX' )."store s ON ou.id = s.uid","LEFT")
            ->where("ou.id=".sp_get_current_userid())//条件
            ->field("s.*")//查询内容
            ->find();
        $order_sn = time() . "_" .$seller['id']."_".$user['id']."_".$_POST['price'];
//        json_encode($_POST)
        $openid = $_SESSION['openid'];
        //计算手续费
        $options = $this->site_options;
        $seller_jf = $_POST['price']*($options['site_xttc']*$seller['fybl']/100)/100;
        $res = array(
            'order_sn' => $order_sn,
            'order_amount' => $seller_jf,
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
        $unifiedOrder->setParameter("notify_url", $this->getsiteurl().'/index.php/portal/Pay/notify_url2');//通知地址
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
}