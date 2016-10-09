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
class ProbuyController extends HomeBaseController{
	
	protected $goods;
    
	function _initialize(){
        parent::_initialize();
        //$this->goods = M("goods");
    }
    
    
    //检查登陆
    public function check_logins () {
        $uid = get_current_userid();
        if (!$uid) {
            $this->ajaxReturn(array('error'=>"请先登录!",'error_url'=>U('Portal/index/login')));
            return false;
        }
    }
	
	public function index() {
		$uid = get_current_userid();
        $list = array();
        switch (I("get.op")) {
            //立即提交
            
            case 'dc':
                $goods_id = intval(I("get.ids"));
                $num = intval(I("get.num"));
                $size_id = intval(I("get.size_id"));
                $seller = array();
                if ($size_id) {
                    $seller = $this->goods
                    ->alias("a")
                    ->join(C ( 'DB_PREFIX' )."goods_pic d ON d.goods_id = a.id")
                    ->join(C ( 'DB_PREFIX' )."goods_spec e ON e.goods_id = a.id")
                    ->where("a.id='$goods_id' AND e.id='$size_id'")
                    ->field("a.*, d.imgurl, e.price size_price,e.id size_id")
                    ->find();
                    $seller['nums'] = $num;
                    $this->assign("size_id",$size_id);
                } else {
                    $seller = $this->goods
                    ->alias("a")
                    ->join(C ( 'DB_PREFIX' )."goods_pic d ON d.goods_id = a.id")
                    ->where("a.id='$goods_id'")
                    ->field("a.*, a.price size_price, d.imgurl")
                    ->find();
                    $seller['nums'] = $num;
                }
                $list[] = $seller;
                break;
            
            //购物车提交
            case 'car':
                $id = I("get.ids");
                if ($id) {
                    
                    //再查产品
                    //产品
                    $user_buycar = M("user_buycar")
                    ->alias("a")
                    ->join(C ( 'DB_PREFIX' )."goods c ON a.goods_id = c.id")
                    ->join(C ( 'DB_PREFIX' )."goods_pic d ON d.goods_id = c.id")
                    ->where("a.uid='$uid' AND a.id in ($id)")
                    ->order("a.id DESC")
                    ->field("a.nums, a.id cay_id, c.*, d.imgurl, c.price size_price, a.size_id")
                    ->select();
                    
                    foreach ($user_buycar as $k2=>$v2) {
                        //再确认对应规格价格
                        $size_id = intval($v2['size_id']);
                        if ($size_id) {
                            $goods_spec = M("goods_spec")->where("id='$size_id'")->field("price")->find();
                            $user_buycar[$k2]['size_price'] = $goods_spec['price'];
                        }
                    }
                    $list = $user_buycar;
                }
                break;
        }
        $this->assign("list",$list);
        
        if (!$list) {
            header("Location:".__ROOT__);
        }
        //会员默认收货地址是否存在
        $adressid = intval(I("get.address"));
        $where = '';
        if ($adressid) {
            $where = "id='$adressid'";
        } else {
            $where = " userid='$uid' AND `default`=1";
        }
        $user_address = M("user_address")->where($where)->find();
        $this->assign("user_address",$user_address);
        
        
        //物流模板
        $express = $this->express_template($this->deal_array($list,"id"),$this->deal_array($list,"nums"));
        $this->assign("express",$express);
        $_GET['order'] = 1;
        
        unset($_GET['address']);
        unset($_GET['id']);
        $this->assign("gets",$_GET);
        
		$this->display();
	}
    
    
    //提交订单
    public function order_post () {
        $order_state = 1;
        $result = array();
        
        //存订单ID
        $orderidArray = array();
        
        $uid = get_current_userid();
        $users = M("oauth_user")->where("id='$uid'")->find();
        
        $post = I("post.");
        
        //收货信息
        $address_id = intval($post['address_id']);
        $user_address = M("user_address")->where("id='$address_id'")->find();
        
        $buyfs = intval($post['buyfs']);
        
        
            //订单编号
            $orderno = $this->orderno();
            
            //取当前店铺中商品ID
            $goods_idArray = $post["goods_id"];
            //取当前店铺中商品数量
            $numsArray = $post["nums"];
            //取当前店铺中商品规格ID
            $size_idAarray = $post["size_id"];
            //取当前店铺中备注
            $remark_buy = $post["remark_buy"];
            //取当前店铺中运送方式--运费
            $fhfsArray = explode('@',$post["fhfs"]);
            
            //查第一个商品信息
            $goods_idfirst = $goods_idArray[0];
            $size_idfirst = $size_idAarray[0];
            
            $goods_first = array();
            if ($size_idfirst) {
                $goods_first = $this->goods
                ->alias("a")
                ->join(C ( 'DB_PREFIX' )."goods_pic d ON d.goods_id = a.id")
                ->join(C ( 'DB_PREFIX' )."goods_spec e ON e.goods_id = a.id")
                ->where("a.id='$goods_idfirst' AND e.id='$size_idfirst'")
                ->field("a.*, d.imgurl, e.price size_price,e.id size_id")
                ->find();
            } else {
                $goods_first = $this->goods
                ->alias("a")
                ->join(C ( 'DB_PREFIX' )."goods_pic d ON d.goods_id = a.id")
                ->where("a.id='$goods_idfirst'")
                ->field("a.*, a.price size_price, d.imgurl")
                ->find();
            }
            
            $img_first = unserialize($goods_first['imgurl']);
            
            //计算当前商品实际付款
            $all_price = 0;
            foreach ($goods_idArray as $k_goodsid=>$v_goodsid) {
                $goods_price = $this->sj_price($v_goodsid,$numsArray[$k_goodsid],$size_idAarray[$k_goodsid],$v_seller);
                
                $all_price += $goods_price['size_price']*intval($numsArray[$k_goodsid]);
            }
            
            
            //订单表
            $orderArray = array(
                'uid'           =>     $uid,
                'orderno'       =>     $orderno,
                'order_state'   =>     1,
                'order_date'    =>     time(),
                'address_id'    =>     $address_id,
                'fee'           =>     $fhfsArray[1],
                'remark_buy'    =>     $remark_buy,
                'show_img'      =>     $img_first[0],
                'goods_title'   =>     $goods_first['name'],
                'seller_user'   =>     $users['mobile'],
                'user_nikename' =>     $user_address['name'],
                'user_name'     =>     $users['user_nicename'],
                
                'pay'           =>     $all_price+$fhfsArray[1],
                
                'fhfs'          =>     $fhfsArray[0],
                //'buyfs'         =>     $post['buyfs'],
                //'psfs'          =>     $psfs,
                'shsj'          =>     $post['shsj'],         
            );
            file_put_contents('result2.txt', $parameter);
            //存入订单表
            $order_id = M("order")->add($orderArray);
            $orderidArray[] = $order_id;
            if ($order_id) {
                
                //存订单明细
                foreach ($goods_idArray as $k_goodsid=>$v_goodsid) {
                    $goods = M("goods")->where("id='$v_goodsid'")->find();
                    $goods_price = $this->sj_price($v_goodsid,$numsArray[$k_goodsid],$size_idAarray[$k_goodsid],$v_seller);
                    //规格信息
                    $size_id = $size_idAarray[$k_goodsid];
                    $goods_spec = M("goods_spec")->where("id='$size_id'")->find();
                    //明细数据
                    $goods_pic = M("goods_pic")->where("goods_id='$v_goodsid'")->find();
                    $imgurl = unserialize($goods_pic['imgurl']);
                    $order_goodsArray = array(
                        'uid'              =>   $uid,
                        'order_id'         => 	$order_id,
                        'orderno'          => 	$orderno,
                        'goods_id'         => 	$v_goodsid,
                        'goods_name'       => 	$goods['name'],
                        'spec_color'       => 	$goods_spec['spec_color'],
                        'spec_size'        => 	$goods_spec['spec_size'],
                        'nums'             => 	$numsArray[$k_goodsid],
                        'price'            => 	$goods_price['size_price'],
                        'imgs'             =>   $imgurl[0],
                    );
                    $result[] = M("order_goods")->add($order_goodsArray);
                }
            }  
                
        if ($result) {
            $car_id = implode(',',$post['car_id']);
            $orderString = implode(',',$orderidArray);
            if ($car_id) {
                M("user_buycar")->where("id in ($car_id)")->delete();
            }
            $this->ajaxReturn(array('success'=>"提交成功",'url'=>U('Probuy/order_buy',array('order_ids'=>$orderString))));
            
        } else {
            $this->ajaxReturn(array('error'=>"提交失败"));
        }
    }
    
    //计算当前商品实际费用
    function sj_price ($goods_id,$nums,$size_id,$seller_id) {
        $goods = array();
        if ($size_id) {
            $goods = $this->goods
            ->alias("a")
            ->join(C ( 'DB_PREFIX' )."goods_spec e ON e.goods_id = a.id")
            ->where("a.id='$goods_id' AND e.id='$size_id'")
            ->field("e.price size_price")
            ->find();
        } else {
            
            $goods = $this->goods
            ->alias("a")
            ->where("a.id='$goods_id'")
            ->field("a.price size_price")
            ->find();
            if ($price_pf != 0) {
                $goods['size_price'] = $price_pf;
            }
        }
        
        return $goods;
    }
    
    //订单编号随机数
    public function orderno () {
        $rands = $this->getrandstr();
        $orderno = date("YmdHis", time()).$rands;
        while (M("order")->where("orderno='$orderno'")->find()) {
            $rands = $this->getrandstr();
            $orderno = date("YmdHis", time()).$rands;
        }
        return $orderno;
    }
    
    //发货编号随机数
    public function deliverno () {
        $rands = $this->getrandstr();
        $deliverno = date("YmdHis", time()).$rands;
        while (M("order_deliver")->where("deliverno='$deliverno'")->find()) {
            $rands = $this->getrandstr();
            $deliverno = date("YmdHis", time()).$rands;
        }
        return $deliverno;
    }
    
    //产生随机数
    function getrandstr(){
        $str='1234567890';
        $randStr = str_shuffle($str);//打乱字符串
        $rands= substr($randStr,0,3);//substr(string,start,length);返回字符串的一部分
        return $rands;
    }
    
    
    function order_buy () {
        $order_ids = I("get.order_ids");
        if ($order_ids) {
            $list = M("order")->where("id in ($order_ids)")->select();
            $this->assign("list",$list[0]);
            //支付方式
            $this->assign("buyfs",$list[0]['buyfs']);
            //用户积分
            $uid = get_current_userid();
            $users = M("oauth_user")->where("id='$uid'")->find();
            $this->assign("users",$users);
            
            $this->js_api_call($list[0]['orderno'], $list[0]['pay'], $order_ids);
            
        } else {
            header("Location:".__ROOT__);
        }
        $this->display();
    }
    
    function buy_ok () {
        //用户积分
        $uid = get_current_userid();
        $users = M("oauth_user")->where("id='$uid'")->find();
        //订单ID
        $orderid        =   intval(I("post.orderid"));
        //各订单价格
        $order = M("order")->where("id='$orderid'")->find();
        $pay_all = floatval($order['pay']);
        
        
        if ($orderid && $pay_all) {
            $zffs = intval(I("post.zffs"));
            switch ($zffs) {
                case 1://微支付
                    
                    
                    exit;
                break;
                
                case 2://积分支付
                    $score = floatval($users['score']);
                    if ($score < $pay_all) {
                        $this->ajaxReturn(array('error'=>"积分不足！"));
                        return false;
                    }
                    
                    //存入当前积分
                    M("oauth_user")->where("id='$uid'")->save(array('score'=>$score-$pay_all));
                    //存入会员积分明细
                    $integralArray = array(
                        'userid'        =>  $uid,
                        //'op'            =>  ,
                        'integral'      =>  -$pay_all,
                        'cur_integral'  =>  $score-$pay_all,
                        'remark'        =>  '',
                        'date'          =>  time(),
                        'storeid'       =>  '',
                    );
                    M("integral")->add($integralArray);
                break;
                
            }
            if (M("order")->where("id='$orderid'")->save(array('order_state'=>5,'pay_date'=>time()))) {
                $this->ajaxReturn(array('success'=>"支付成功",'url'=>U('Portal/probuy/result',array('orderid'=>$orderid))));
            } else {
                $this->ajaxReturn(array('error'=>"支付失败！"));
            }
            
        } else {
            $this->ajaxReturn(array('error'=>"数据不存在！"));
        }
    }
    
    //结果页
    public function result () {
        $orderid = intval(I("get.orderid"));
        $order   = M("order")->where("id='$orderid'")->find();
        $this->assign("order",$order);
        
        $this->display();
    }
    
    
    
    
    //计算运费模板
    public function template () {
        $result = $this->express_template(I("post.goods_idString"), I("post.numsString"), intval(I("post.Radio_value")));
        $this->ajaxReturn(array('content'=>$result));
    }
    
    /**
     * -----------------------------------------------微信接口-------------------------------------
     * 
     **/
    public function js_api_call ($order_sn, $order_amount, $order_ids) {
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
            'order_sn' => $order_sn.'_'.$order_ids,
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
        $unifiedOrder->setParameter("notify_url", $this->getsiteurl().'/index.php/portal/Probuy/notify_url');//通知地址 
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
	public function notify_url() {
		vendor('Weixinpay.WxPayPubHelper');
	    //使用通用通知接口
		$notify = new \Notify_pub();
		//存储微信的回调
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];	
		$notify->saveData($xml);
		//验证签名，并回应微信。
		//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		//尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if($notify->checkSign() == FALSE){
			$notify->setReturnParameter("return_code", "FAIL");//返回状态码
			$notify->setReturnParameter("return_msg", "签名失败");//返回信息
		}else{
			$notify->setReturnParameter("return_code", "SUCCESS");//设置返回码
		}
		$returnXml = $notify->returnXml();
		//==商户根据实际情况设置相应的处理流程，此处仅作举例=======
		//以log文件形式记录回调信息
		//$log_name = "notify_url.log";//log文件路径
		//$this->log_result($log_name, "【接收到的notify通知】:\n".$xml."\n");
        $parameter = $notify->xmlToArray($xml);
        //$this->log_result($log_name, "【接收到的notify通知】:\n".$parameter."\n");
		if($notify->checkSign() == TRUE){
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
	} 
    
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
        $out_trade_no = explode('_', $parameter['out_trade_no']);
        $total_fee = $parameter['total_fee'];
        $orderid = $out_trade_no[1];//file_put_contents('result2.txt', $parameter);
        if (M("order")->where("id='$orderid'")->save(array('order_state'=>5,'pay_date'=>time()))) {
            $this->ajaxReturn(array('success'=>"支付成功",'url'=>U('Portal/probuy/result',array('orderid'=>$orderid))));
        } else {
            $this->ajaxReturn(array('error'=>"支付失败！"));
        }
        return true;
    }
    
	
}