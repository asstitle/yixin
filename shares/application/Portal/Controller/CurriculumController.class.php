<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Portal\Controller;
use Common\Controller\HomeBaseController; 
/**
 * 首页
 */
class CurriculumController extends HomeBaseController {
	
    function _initialize() {
        parent::_initialize();
        $this->assign('active','sxy');
    }

    
    public function test()
    {
        $xml='<xml><appid><![CDATA[wx9a68aff48ed92184]]></appid>
<bank_type><![CDATA[CFT]]></bank_type>
<cash_fee><![CDATA[1]]></cash_fee>
<fee_type><![CDATA[CNY]]></fee_type>
<is_subscribe><![CDATA[Y]]></is_subscribe>
<mch_id><![CDATA[1385272202]]></mch_id>
<nonce_str><![CDATA[8b73jak2wvtyziyzbqwv6atgrx6kbq0w]]></nonce_str>
<openid><![CDATA[oh7RlwtqWQYNJ50dBeUL_9tAavbw]]></openid>
<out_trade_no><![CDATA[16090514730709132227]]></out_trade_no>
<result_code><![CDATA[SUCCESS]]></result_code>
<return_code><![CDATA[SUCCESS]]></return_code>
<sign><![CDATA[B7F1641240E7DAEA7C91324E3F749864]]></sign>
<time_end><![CDATA[20160905182213]]></time_end>
<total_fee>1</total_fee>
<trade_type><![CDATA[JSAPI]]></trade_type>
<transaction_id><![CDATA[4001892001201609053186351986]]></transaction_id>
</xml>';
        //将XML转为array
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        show_bug($array_data) ;
    }
    
    public function index(){
       $curriculum_id = I('get.id');
       
       if(!is_numeric($curriculum_id)){
           
           $this->redirect('Index/index');
           
       }
       
       $banner_list = M('slide')->where('slide_status = 1')->select();
       $this->assign('banner_list',$banner_list);
       
       $curriculum = M('curriculum')->find($curriculum_id);       
       $curriculum_list = M('curriculum')->where('curriculum_status = 1 AND curriculum_money <> 0')->limit(0,4)->select();
       $pd = 2;
       if(sp_get_current_userid()){
           $uid = sp_get_current_userid();
           $pd_puy = M('order')->where(" uid = '$uid' AND curriculum_id = '$curriculum_id' AND order_state = 1 ")->find();
           
           if($pd_puy){
              $pd = 1;
           }
       }
       
       
       
       $this->assign('curriculum_list',$curriculum_list);
       //$this->assign('ks_list',$ks_list);
       $this->assign('pd',$pd);
       $this->assign('curriculum',$curriculum);
       $this->display();
       
    }
    
    public function tjkc(){
        $curriculum_id = I('get.id');
         
        if(!is_numeric($curriculum_id)){
             
            $this->redirect('Index/index');
        }
        
        $banner_list = M('slide')->where('slide_status = 1')->select();
        $this->assign('banner_list',$banner_list);
        
        $curriculum = M('curriculum')->find($curriculum_id);
        $curriculum_list = M('curriculum')->where('curriculum_status = 1 AND curriculum_money = 0')->limit(0,4)->select();
        $this->assign('curriculum_list',$curriculum_list);
        
        $this->assign('curriculum',$curriculum);
        $this->display();
        
    }
    
    public function curriculum_pay()
    {
        if(!sp_get_current_userid())
        {
              $this->error("请登录！",U("Index/login"));
        }
        
        $uid = sp_get_current_userid();
        $curriculum_id = I('post.id');
        
        if(!is_numeric($curriculum_id)){
            $this->error("非法操作！",U("Index/index"));
        }
        
        $zs_name = M('oauth_user')->where("id = '$uid' ")->find();
        
        if(!$zs_name['zs_name']){
            
            $this->error("请先设置真实姓名",U('User/zs_name'));
            
        }
        
        //$this->js_api_call('xyh000003',0.01,300);
        
        $cx = M('order')->where("uid = '$uid' AND curriculum_id = '$curriculum_id' ")->find();
        
        if($cx){
            
            if($cx['order_state'] == 1){
                $this->error('您已经购买过该课程了！');
            }
            
            $orderno = $cx['orderno'];
            $orderid = $cx['id'];
            $order_money = $cx['order_money'];
            
            $this->assign('order_id',$orderid);
            $this->assign('orderno',$orderno);
            $this->assign('order_money',$order_money);
            
        }else{
            
            $curriculum_money = M('curriculum')->find($curriculum_id);
            
           
            
            $data['order_money'] = $curriculum_money['curriculum_money'];
            $data['orderno'] = makeordernumber();
            $data['uid'] = $uid;
            $data['order_state'] = 0;
            $data['order_date'] = time();
            $data['curriculum_id'] = $curriculum_id;
            
            $jg = M('order')->add($data);
            
            //show_bug($jg);
            
            $orderno = $data['orderno'];
            $orderid = $jg;
            $order_money = $data['order_money'];
            
            $this->assign('order_id',$orderid);
            $this->assign('orderno',$data['orderno']);
            $this->assign('order_money',$data['order_money']);
        }
        
        //生成订单
        $time = time();
        
        if($uid == 2){
            $this->js_api_call($orderno."_".$time,0.01);
        }else{
            $this->js_api_call($orderno."_".$time,$order_money);
        }
        
       
        //$this->js_api_call($orderno,0.01);
        
        $this->display();
        
    }
    
    
    /**
     * -----------------------------------------------微信接口-------------------------------------
     *
     **/
    public function js_api_call ($order_sn, $order_amount) {
        
        //$order_sn = I('get.order_sn', '');
        if (empty($order_sn)) {
            header('location:'.__ROOT__.'/');
        }
        vendor('Weixinpay.WxPayPubHelper');
        //使用jsapi接口
        $jsApi = new \JsApi_pub();
        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        //$_GET['code'] = $_SESSION['user']['openid'];
        $openid = $_SESSION['openid'];
        $res = array(
            'order_sn' => $order_sn,
            'order_amount' => $order_amount
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
        //$unifiedOrder->setParameter("notify_url", $this->getsiteurl().'/index.php/portal/Curriculum/notify_url');//通知地址
        $unifiedOrder->setParameter("notify_url", 'http://yixin.woyii.com/index.php/portal/Pay/notify_url');//通知地址
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
        $this->assign('res', $res);
        $this->assign('jsApiParameters', $jsApiParameters);
        //file_put_contents("a.txt",$jsApiParameters);
    
    }
    
    
    //异步通知url，商户根据实际开发过程设定
   /*  public function notify_url() {
        file_put_contents('_1.txt',time());
        vendor('Weixinpay.WxPayPubHelper');
        //使用通用通知接口
        $parameter = new \Notify_pub();
        //存储微信的回调
        file_put_contents('_11.txt',time());
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        file_put_contents('_111.txt',time());
        $notify->saveData($xml);
        file_put_contents('_1111.txt',$xml);exit();
        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if($notify->checkSign() == FALSE){
            file_put_contents('_0000.txt',time());
            $notify->setReturnParameter("return_code", "FAIL");//返回状态码
            $notify->setReturnParameter("return_msg", "签名失败");//返回信息
        }else{
            file_put_contents('_2.txt',time());
            $notify->setReturnParameter("return_code", "SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        //==商户根据实际情况设置相应的处理流程，此处仅作举例=======
        //以log文件形式记录回调信息
        //$log_name = "notify_url.log";//log文件路径
        //$this->log_result($log_name, "【接收到的notify通知】:\n".$xml."\n");
        $parameter = $notify->xmlToArray($xml);
        //$this->log_result($log_name, "【接收到的notify通知】:\n".$parameter."\n");
        file_put_contents('_3.txt',print_r($parameter, true));
        if($notify->checkSign() == TRUE){
            file_put_contents('_4.txt',time());
            if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                //$this->log_result($log_name, "【通信出错】:\n".$xml."\n");
                //更新订单数据【通信出错】设为无效订单
                echo 'error';
            }
            else if($notify->data["result_code"] == "FAIL"){
                //此处应该更新一下订单状态，商户自行增删操作
                //$this->log_result($log_name, "【业务出错】:\n".$xml."\n");
                //更新订单数据【通信出错】设为无效订单
                echo 'error';
            }
            else{
                file_put_contents('_5.txt',time());
                //$this->log_result($log_name, "【支付成功】:\n".$xml."\n");
                //我这里用到一个process方法，成功返回数据后处理，返回地数据具体可以参考微信的文档
                if ($this->process($parameter)) {
                    //处理成功后输出success，微信就不会再下发请求了
                    echo 'success';
                }else {
                    //没有处理成功，微信会间隔的发送请求
                    echo 'error';
                }
            }
        }
    } */
    
    //订单处理
    private function process($parameter) {
        //此处应该更新一下订单状态，商户自行增删操作
        /*
         * 返回的数据最少有以下几个
         * $parameter = array(
         'out_trade_no' => xxx,//商户订单号
         'total_fee' => XXXX,//支付金额
         'openid' => XXxxx,//付款的用户ID
         );
         */
        //$out_trade_no = explode('_', $parameter['out_trade_no']);
        //$total_fee = $parameter['total_fee'];
        //$orderid = $out_trade_no[1];
        
        
        
    }
    
    //结果页
    public function result () {
        $orderid = intval(I("get.orderid"));

        $order   = M("order")->where("id='$orderid'")->find();
        
        /* $data['order_state'] = 1;
        $data['pay_date'] = time();
        M('order')->where("id = '$orderid' ")->save($data);
        
        $order   = M("order")->where("id='$orderid'")->find();
        
        //分佣
        
        $curriculum_id = intval($order['curriculum_id']);
        $curriculum = M('curriculum')->find($curriculum_id);
        
        $buy_uid = $order['uid'];
        
        if($curriculum['one_level']){
        
            $uid = $order['uid'];
            $money = $curriculum['one_level'];
            $one_uid = $this->rebate_top($uid,$money,$buy_uid,$curriculum_id,1);
        
        }
        
        if($curriculum['two_level'] && $one_uid){
        
            $money = $curriculum['two_level'];
            $two_uid = $this->rebate_top($one_uid,$money,$buy_uid,$curriculum_id,2);
        
        }
        
        if($curriculum['three_level'] && $two_uid){
        
            $money = $curriculum['three_level'];
            $three_uid = $this->rebate_top($two_uid,$money,$buy_uid,$curriculum_id,3);
        
        }
         */
        
        $this->assign("order",$order);
        $this->display();
    }
    
    //给上级加钱,添加明细，同时返回再上一级的ID
    /* function rebate_top($active_uid,$money,$buy_uid,$curriculum_id,$rank){
        
        if(!$active_uid || !$money || !$buy_uid || !$curriculum_id || !$rank){
            return false;
        }
        
        $top_user = M('oauth_user')
            ->alias("ou")
            ->join(C ( 'DB_PREFIX' )."oauth_user o ON o.id = ou.tjrr")
            ->where("ou.id = '$active_uid' ")
            ->field('o.*')
            ->find();
        
        $top_uid = $top_user['id'];
        
        
        $rebate_data['buy_uid'] = $buy_uid;
        $rebate_data['get_uid'] = $top_uid;
        $rebate_data['curriculum_id'] = $curriculum_id;
        $rebate_data['rank'] = $rank;
        $rebate_data['rebate_money'] = $money;
        
        
        $add_jg = M("rebate_list")->where($rebate_data)->find();
        //$user = M('oauth_user')->find($uid);

        if($add_jg){
            return false;
        }
        $rebate_data['rebate_date'] = time();
        $jg =  M('rebate_list')->add($rebate_data);
        
       
        $data['score'] = $top_user['score'] + $money;
        M('oauth_user')->where("id = '$top_uid' ")->save($data);
        
        
        return $top_uid;
            
       
    } */
    
    
    
}


