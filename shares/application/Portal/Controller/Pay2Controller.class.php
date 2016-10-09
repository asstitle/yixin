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
class PayController extends HomeBaseController{
	
    
	function _initialize(){
        parent::_initialize();
    }
    
    /**
     * -------------------------------调用支付宝接口----------------------------------------------------------------------
    */
    
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
    function process($parameter='') {
        //此处应该更新一下订单状态，商户自行增删操作
        /*
        * 返回的数据最少有以下几个
        * $parameter = array(
            'out_trade_no' => xxx,//商户订单号
            'total_fee' => XXXX,//支付金额
            'openid' => XXxxx,//付款的用户ID
        );
        */

		//判断是否处理
		$handle = M("user_integral")->where("out_trade_no='".$parameter['out_trade_no']."'")->find();
		if($handle){
			return false;
		}
		//时间最开始获取 保证这个操作里的时间都是同一时间 其他地方当做参数来对应
		$date_now = time();
		$options = $this->site_options;
		//$parameter['out_trade_no'] = "1464707153_35_58"; //6代表商家ID 4代表付款用户ID
        $out_trade_no = explode('_', $parameter['out_trade_no']);
		$parameter['total_fee'] = $parameter['total_fee']/100;
		//$parameter['total_fee'] = 2000;

		$price = $parameter['total_fee'];//交易金额

		//获取商家赠送比例
		$seller = M("store")
			->alias("s")//表别名
			->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = s.uid")
			->where("s.uid=".$out_trade_no[1])
			->field("s.*,ou.id seuid, ou.openid, ou.tjrr")
			->find();
		$user = M("oauth_user")->find($out_trade_no[2]);//付款用户

		//计算赠送积分
		$zsjf = $price * $seller['fybl']/100;

		//修改用户未返积分
		$user['wfjf'] = $user['wfjf'] + $zsjf;
		M("oauth_user")->save($user);

		//用户明细
		$ar = array(
			"userid"        =>      $user['id'],
			"sellerid"        =>      $seller['seuid'],
			"op"        =>      "shopping_wx",
			"itype"        =>      1, //1表示userid对应的用户 2表示userid对应的商家 3表示userid对应的代理商
			"integral"        =>      $price,
			"integral_sj"        =>      $zsjf,
			"cur_integral"        =>      $user['score'],
			"remark"        =>      "您在".$seller['name']."微信消费了".$price."元",
			"date"        =>      $date_now,
			"out_trade_no"        =>      $parameter['out_trade_no']
		);
		M("user_integral")->add($ar);

		//用户消息发送
		sendmessage($seller['seuid'],$user['id'],"微信购物","您在".$seller['name']."微信消费了".$price."元",array(
			$user['openid'],
			"您在".$seller['name']."微信消费了".$price."元",
			($user['user_nicename']?$user['user_nicename']:$user['mobile']),
			$date_now,
			0,
			$user['score'],
			"微信支付",
			"感谢您的使用！",
			U("User/score",array("openid"=>$user['openid']))
		),1,$date_now);

		//用户上级提成
		$this->pubtc(1,$user['id'],$user['tjrr'],$price,$date_now);

		//商家增加积分
		//手续费
		$sxf = $price * $options['site_xttc']/100 * $seller['fybl']/100;
		$seller['score'] += $price - $sxf;
		M("store")->save($seller);

		$str = "";
		//判断商家是否开通返现 如开启 将手续费按比例返现到商家的会员积分里
		if($seller['isreturn'] == 1){

			$user_seller = M("oauth_user")->find($seller['seuid']);
			$ar = array(
				"wfjf"      =>      $user_seller['wfjf'] + $sxf,
				"id"        =>      $user_seller['id']
			);
			//修改此商家的会员的未返积分
			M("oauth_user")->save($ar);
			$str = "获得未返积分".$sxf."分！";
		}

		//商家
		$ar = array(
			"userid"        =>      $seller['seuid'], //商家用户id
			"sellerid"        =>      $user['id'],
			"op"        =>      "weixin_sk",
			"itype"        =>      2,
			"integral"        =>      $price,
			"integral_sj"        =>      $price - $sxf,
			"cur_integral"        =>      $seller['score'],
			"remark"        =>      ($user['user_nicename']?$user['user_nicename']:$user['mobile'])."微信消费了".$price."元,扣除手续费".$sxf."元。".$str,
			"date"        =>      $date_now,
			"is_fanxian"        =>      $str?1:null,
			"out_trade_no"        =>      $parameter['out_trade_no']
		);
		$lsid = M("user_integral")->add($ar);

		//商家消息发送
		sendmessage($user['id'],$seller['seuid'],"微信收款",($user['user_nicename']?$user['user_nicename']:$user['mobile'])."微信消费了".$price."元,扣除手续费".$sxf."元。".$str,array(
			$seller['openid'],
			($user['user_nicename']?$user['user_nicename']:$user['mobile'])."现金消费了".$price."元,扣除手续费".$sxf."元。".$str,
			($seller['user_nicename']?$seller['user_nicename']:$seller['mobile']),
			$date_now,
			($price - $sxf),
			$seller['score'],
			"微信收款",
			"感谢您的使用！",
			U("Seller/details_xq",array("id"=>$lsid,"openid"=>$seller['openid']))
		),1,$date_now);

		//商家上级提成
		$this->pubtc(2,$seller['seuid'],$seller['tjrr'],$sxf,$date_now);

        return true;
    } 
    
    //------------------------------------------------------------------------------------------------------
   //商家收款
	//异步通知url，商户根据实际开发过程设定
	public function notify_url2() {
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
				if ($this->process2($parameter)) {
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
	function process2($parameter="") {
		//此处应该更新一下订单状态，商户自行增删操作
		/*
        * 返回的数据最少有以下几个
        * $parameter = array(
            'out_trade_no' => xxx,//商户订单号
            'total_fee' => XXXX,//支付金额
            'openid' => XXxxx,//付款的用户ID
        );
        */

		//判断是否处理
		$handle = M("user_integral")->where("out_trade_no='".$parameter['out_trade_no']."'")->find();
		if($handle){
			return false;
		}
		$date_now = time();

		$options = $this->site_options;
		//$parameter['out_trade_no'] = "209483204_6_4_3000";
		$out_trade_no = explode('_', $parameter['out_trade_no']);
		$parameter['total_fee'] = $parameter['total_fee']/100;
		//$parameter['total_fee'] = 1000;

		$price = $out_trade_no[3];//实际操作费用
		$sxf = $parameter['total_fee'];//手续费


		//商家用户账号
		$seller = M("oauth_user")
			->alias("ou")//表别名
			->join(C ( 'DB_PREFIX' )."store s ON ou.id = s.uid","LEFT")
			->where("s.id=".$out_trade_no[1])//条件
			->field("s.*,ou.id seuid,ou.tjrr,ou.openid,ou.user_nicename,ou.mobile")//查询内容
			->find();

		//用户账号
		$user = M("oauth_user")->find($out_trade_no[2]);

		//判断商家是否开通返现 如开启 将手续费按比例返现到商家的会员积分里
		if($seller['isreturn'] == 1){
			$ar = array(
				"wfjf"      =>      $seller['wfjf'] + $sxf,
				"id"        =>      $seller['id']
			);
			//修改此商家的会员的未返积分
			M("oauth_user")->save($ar);
			$str = "获得未返积分".$sxf."分！";
		}

		//增加用户未返积分
		//实际赠送
		$zs = $price * $seller['fybl']/100;

		$user['wfjf'] = $user['wfjf'] + $zs;
		M("oauth_user")->save($user);

		//添加明细
		//用户
		$ar = array(
			"userid"        =>      $user['id'],
			"sellerid"        =>      $seller['seuid'],
			"op"        =>      "shopping_xj",
			"itype"        =>      1,
			"integral"        =>      $price,
			"integral_sj"        =>      $zs,
			"cur_integral"        =>      $user['score'],
			"remark"        =>      "您在".$seller['name']."现金消费了".$price."元！获得 ".$zs." 未返积分",
			"date"        =>      $date_now,
			"out_trade_no"	=>	$parameter['out_trade_no']
		);
		M("user_integral")->add($ar);

		//用户上级提成
		$this->pubtc(1,$user['id'],$user['tjrr'],$zs,$date_now);
		//商家
		$ar = array(
			"userid"        =>      $seller['seuid'],
			"sellerid"        =>      $user['id'],
			"op"        =>      "declaration_wx",
			"itype"        =>      2,
			"integral"        =>      $price,
			"integral_sj"        =>      $price - $sxf,
			"cur_integral"        =>      $seller['score'],
			"remark"        =>      ($user['user_nicename']?$user['user_nicename']:$user['mobile'])."微信消费了".$price."元,扣除手续费".$sxf."元。".$str,
			"date"        =>      $date_now,
			"is_fanxian"        =>      $seller['isreturn'],
			"out_trade_no"	=>	$parameter['out_trade_no']
		);
		$lsid = M("user_integral")->add($ar);
		//商家上级提成
		$this->pubtc(2,$seller['id'],$seller['tjrr'],$zs,$date_now);
		//用户消息发送
		sendmessage($seller['seuid'],$user['id'],"微信购物","您在".$seller['name']."现金消费了".$price."元！获得 ".$zs." 未返积分",array(
			$user['openid'],
			"您在".$seller['name']."现金消费了".$price."元！获得 ".$zs." 未返积分",
			($user['user_nicename']?$user['user_nicename']:$user['mobile']),
			$date_now,
			0,
			$user['score'],
			"现金支付",
			"感谢您的使用！",
			U("User/score",array("openid"=>$user['openid']))
		),1,$date_now);
		//商家消息发送
		sendmessage($user['id'],$seller['seuid'],"微信报单",($user['user_nicename']?$user['user_nicename']:$user['mobile'])."微信消费了".$price."元,扣除手续费".$sxf."元。".$str,array(
			$seller['openid'],
			($user['user_nicename']?$user['user_nicename']:$user['mobile'])."微信消费了".$price."元,扣除手续费".$sxf."元。".$str,
			($seller['user_nicename']?$seller['user_nicename']:$seller['mobile']),
			$date_now,
			0,
			$seller['score'],
			"支付手续费",
			"感谢您的使用！",
			U("Seller/details_xq",array("id"=>$lsid,"openid"=>$seller['openid']))
		),1,$date_now);
		return true;
	}

}