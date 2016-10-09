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
class TestController extends HomeBaseController {
	


	//联盟商家
	function index(){
	   //$_GET['zb'] = '30.673794,104.108086';
		$aryzb = explode(",", $_GET['zb']);//将json转化为数组
		//$zb = convertbaidumap($aryzb[0], $aryzb[1]);//将微信坐标转化为百度坐标
        
        if ($aryzb[0] && $aryzb[1]) {
            $zb = Convert_GCJ02_To_BD09($aryzb[0], $aryzb[1]);//转换腾讯坐标到百度坐标
        }

		if($zb){
			$str = ",round(6378.138*2*asin(sqrt(pow(sin( (".$zb['lat']."*pi()/180-s.lat*pi()/180)/2),2)+cos(".$zb['lat']."*pi()/180)*cos(s.lat*pi()/180)* pow(sin( (".$zb['lng']."*pi()/180-s.lng*pi()/180)/2),2)))*1000) juli2";
		} else {
  		    $str = ", id juli2";
		}
		$where = "s.status = 1 AND s.isenable= 1 AND ou.user_type=2 AND s.name<>''";

		$order = "juli2 asc";
		$formart = "";
		//分类
		if($_GET['cid']){
			$where .= " and s.cid=".$_GET['cid'];
			//获取分类信息
			$class = M("store_class")->find($_GET['cid']);
			$this->assign("class_now",$class);//页面展示当前分类
			$formart .= "&cid=".$_GET['cid'];//滑动附带参数
		}
		//排序
		if($_GET['ord']){
			if($_GET['ord']==1){
				//赠送比例
				$order = "s.fybl desc";
				$this->assign("pxname","赠送比例");
			}else if($_GET['ord']==2){
				//人均消费
				$order = "s.rjxf desc";
				$this->assign("pxname","人均消费");
			}else if($_GET['ord']==3){
				//距离
				if($zb){
					$order = "juli2 asc";
					$this->assign("pxname","距离");
				}
			}
			$formart .= "&ord=".$_GET['ord'];
		}
		//地区
		if($_GET['address']){
			if($_GET['address']!="所有省份"){
				$formart .= "&address=".$_GET['address'];
				$address = explode("-",$_GET['address']);

				$where .= " and s.sheng='".$address[0]."'";
				if($address[1]){
					$where .= " and s.shi='".$address[1]."'";
				}
			}
			$this->assign("address",$_GET['address']);
		}
		//关键词
		$keyword = I("request.keyword1");

		if($keyword){
			$where .= " and s.name like '%".$keyword."%'";
			$this->assign("ssname",$keyword);//页面展示当前搜索
			$formart .= "&keyword1=".$keyword;//滑动附带参数
		}
		if (!$_GET['ajax']) {
			//查询分类
			$class = M("store_class")->order("orderid desc")->select();
			$this->assign("formart",$formart);
			$this->assign("class",$class);
			$this->assign("banner",$this->index_banner('sellerlist'));//banner

			$this->display();
			exit;
		}
		$count = M("store")
			->alias("s")
			->join(C ( 'DB_PREFIX' )."store_class sc ON s.cid = sc.id","LEFT")
			->join(C ( 'DB_PREFIX' )."oauth_user ou ON s.uid = ou.id","LEFT")
			->where($where)
			->count();//获取条数

		$page = $this->page($count, 9,$_GET['p']);//设置分页信息

		$list = M("store")
			->alias("s")
			->join(C ( 'DB_PREFIX' )."store_class sc ON s.cid = sc.id","LEFT")
			->join(C ( 'DB_PREFIX' )."oauth_user ou ON s.uid = ou.id","LEFT")
			->where($where)
			->limit($page->firstRow . ',' . $page->listRows)
			->field("s.*".$str)
			->order($order)
			->select();
		foreach($list as $key => $val){
			if(mb_strlen($val['name'],"utf-8")>9){
				$list[$key]['name'] = mb_substr($val['name'], 0, 9, 'utf-8') . "...";
			}else{
				$list[$key]['name'] = mb_substr($val['name'], 0, mb_strlen($val['name'],"utf-8"), 'utf-8');
			}
			if(mb_strlen($val['about'],"utf-8")>30){
				$list[$key]['about'] = mb_substr($val['about'], 0, 30, 'utf-8') . "...";
			}else{
				$list[$key]['about'] = mb_substr($val['about'], 0, mb_strlen($val['about'],"utf-8"), 'utf-8');
			}

			$list[$key]['url'] = U('Index/sellerlist_xq',array('id'=>$val['id']));

			//循环获取此坐标的
			if($_GET['zb']) {
				//获取2点距离
                //$juli = GetDistance($val['lat'], $val['lng'], $zb['lat'], $zb['lng']);//得出距离
				$list[$key]['juli'] = mToKm($val['juli2']); //由于sql语句里已经计算出距离，因此不用再计算
			}

			if ($list[$key]['juli']) {
				$len = 9;
			}else{
				$len = 14;
			}
			if(mb_strlen($val['address'],"utf-8")>$len){
				$list[$key]['address'] = mb_substr($val['address'], 0, $len, 'utf-8') . "...";
			}else{
				$list[$key]['address'] = mb_substr($val['address'], 0, mb_strlen($val['address'],"utf-8"), 'utf-8');
			}


		}
		ajax_list($list); //处理ajax
		$this->display();
	}
    
}


