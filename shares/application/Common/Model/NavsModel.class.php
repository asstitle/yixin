<?php
namespace Common\Model;
class NavsModel{
    
    
    //订单状态
    public $order_type = array(
        '1'     =>  '待付款',
        '5'     =>  '待发货',
        '10'    =>  '已发货',
        '15'    =>  '交易完成',
    );
    
    //送货方式
    public $shsj = array(
        '0'     =>  '任意时间',
        '1'     =>  '周一到周五',
        '2'     =>  '周末及节假日',
    );
    
    //发货方式
    public $fhfs = array(
        '1'     =>  '快递',
        '2'     =>  'EMS',
        '3'     =>  '平邮',
    );
    
    
    
}
