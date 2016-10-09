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
    
    /**
     * -------------------------------调用微信接口----------------------------------------------------------------------
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
           ;
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
                //file_put_contents('_aaaaa.txt',print_r($parameter, true));
                
                   //$orderno = $parameter['out_trade_no'];
                    
                    $out_trade_no = explode('_', $parameter['out_trade_no']);
                    
                    $orderno = $out_trade_no[0];
                    
                    //file_put_contents('_bbbbb.txt',print_r($orderno, true));
                    $orderid = M('order')->where("orderno = '$orderno' ")->field('id')->find();
                    $orderid = $orderid['id'];
                    //file_put_contents('_ccccc.txt',print_r($orderid, true));
                    $data['order_state'] = 1;
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
                    
                    
                    //$this->ajaxReturn(array('success'=>"支付成功",'url'=>U('Portal/curriculum/result',array('orderid'=>$orderid))));
                    
                    //file_put_contents('result2.txt', $parameter);
                   /*  if (M("order")->where("id='$orderid'")->save(array('order_state'=>1,'pay_date'=>time()))) {
                
                        
                       //$this->ajaxReturn(array('success'=>"支付成功",'url'=>U('Portal/curriculum/result',array('orderid'=>$orderid))));
                       return true;
                    } else {
                        return false;
                        //$this->ajaxReturn(array('error'=>"支付失败！"));
                    } */
    
                echo 'success';
            }
        }
    }
    
    
    function rebate_top($active_uid,$money,$buy_uid,$curriculum_id,$rank){
    
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
    
         
    }
    

}