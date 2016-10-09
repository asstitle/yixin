<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp.php 2010-6-21 23:15:43 jerry $
*/

//通用文件
include_once('./common.php');

//允许的方法
$dos = array('index', 'lostpass', 'login', 'logout', 'newreg',
			 'integral', 'exchange',  'exchange2', 'orders', 'profile',
			 'auth', 'intro', 'show', 'invite', 'phpqrcode',
             'subscribe'
			 );

//实现分享的，只传id=就行
($_GET['id'] && !$_GET['do']) && $_GET['do'] = 'share';

$do = (empty($_GET['do']) || !in_array($_GET['do'], $dos)) ? 'index' : $_GET['do'];
$op = empty($_GET['op']) ? '' : $_GET['op'];

//是否关闭站点
if(!in_array($ac, array('common', 'pm'))) {
	checkclose();
}
//echo "SELECT * FROM ".tname('members')." WHERE openid='".$_SESSION['weixin']['openid']."'";
//取出登录信息


if ($do != 'auth' && !$_SESSION['weixin']['subscribe']) {
    $do = 'subscribe';
}


if ($_SESSION['weixin']['openid']) {
	//取出会员的用户信息
	$userinfo   = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('members')." WHERE openid='".$_SESSION['weixin']['openid']."'");

	if (!$userinfo) {
		$username = getusername($_SESSION['weixin']['nickname']);
		$arr = array(
				'username'         => 	$username,
				'password'         => 	'',
				'usertype'         => 	1,
				'integral'		   =>   0,
				'lastvisit'        => 	0,
				'lastip'           => 	'',
				'lastactive'       => 	0,
				'times'            => 	0,
				'regip'            => 	getonlineip(),
				'regdate'          => 	$_TGLOBAL['timestamp'],
				'nums'             => 	0,
				'order_nums'       => 	0,
				'recomm_id'        => 	$_SESSION['weixin']['invite'],
				'name'             => 	$_SESSION['weixin']['nickname'],
				'address'          => 	$_SESSION['weixin']['province'].$_SESSION['weixin']['city'],
				'img'              => 	$_SESSION['weixin']['headimgurl'],
				'openid'		   =>   $_SESSION['weixin']['openid']
				);
		$uid = inserttable('members', $arr, 1);


		//如果有推荐人，则给推荐人赠送积分发送模板消息 start
		if ($_SESSION['weixin']['invite']) {			
			$remark = '推荐：'.$username;
			$remm = $_TGLOBAL['db']->getrow("SELECT uid, integral, openid FROM ".tname('members')." WHERE username='".$_SESSION['weixin']['invite']."'");
			//添加到记录表
			$arr = array( 'uid' => $remm['uid'],
						   'op' =>  'remm',
						   'integral' => 1,
						   'cur_integral' => $remm['integral'],
						   'remark' => 	$remark,
						  );
			add_member_integral($arr);

			//发送模板消息
			template_remmuser($remm['openid'], $_SESSION['weixin']['nickname']);


			//给注册的人赠送积分
			$arr = array( 'uid' => $uid,
						   'op' =>  'reg',
						   'integral' => 1,
						   'cur_integral' => 0,
						   'remark' => 	$_POST['remark'],
						  );
			add_member_integral($arr);
			$userinfo   = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('members')." WHERE uid='$uid'");
		}
		//如果有推荐人，则给推荐人赠送积分发送模板消息 end
		
	}
	$usertype = $userinfo['usertype']; //取得会员级别，由于模板里要使用此变量
	$gender   = $userinfo['gender'];

	if (!$userinfo['phone']) {
		$do = 'login';
	}
}
//var_dump($_SESSION);

//微信的推广二维码地址 state为用户的uid
$weixin_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $_TCONFIG['weixin_AppId'] . "&redirect_uri=http%3A%2F%2Fjr.woyii.com%2Findex.php%3Fdo%3Dauth&response_type=code&scope=snsapi_userinfo&state=".$userinfo['username']."#wechat_redirect";

require_once "source/jssdk.php";
$jssdk = new JSSDK($_TCONFIG['weixin_AppId'], $_TCONFIG['weixin_AppSecret']);
$signPackage = $jssdk->GetSignPackage();

include_once(S_ROOT.'./source/cp_'.$do.'.php');