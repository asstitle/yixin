<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: openid.php 2010-6-28 11:04:54 jerry $
*/
session_start();
error_reporting(0);

$base_url = 'http://yixin.woyii.com/';
$appid = 'wx9a68aff48ed92184';
$secret = '6c63227dbed3f62cfe52846cf0817207';

//当用户登录存在，则不获取信息
if ($_SESSION['openid']) {
    //header("Location: index.php");
    //exit;
}

$code = $_GET["code"];
$tc = $base_url."openid.php";
$base = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid;
$base .="&redirect_uri=" . urlencode($tc) . "&response_type=code&scope=snsapi_userinfo&state=".$_REQUEST['state']."#wechat_redirect"; //snsapi_userinfo   snsapi_base

if ($code == NULL) {
    header("Location: $base");
    exit;
}

/**
 * 获取信息
 * @param type $url
 * @return type
 */
function getRespons($url) {
    $ret = file_get_contents($url);
    return json_decode($ret, true);
}
  
$accTokenUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid;
$accTokenUrl.="&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
$resToken = getRespons($accTokenUrl);




if ($resToken["openid"] == NULL || $resToken["access_token"] == NULL) {
    //echo "OPENID NULL\r\n";
    //exit;
}


//当上面为snsapi_base时，如果未关注，则只能获取openid，这里注册，
//注册后，可以强制用户关注，然后用户登录时，然后财调用此接口就可以获取用户信息
//var_dump($resToken);exit;


$usinfo = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $resToken["access_token"];
$usinfo.="&openid=" . $resToken["openid"] . "&lang=zh_CN";

//var_dump(getRespons($usinfo));exit;

$u = getRespons($usinfo);

$_SESSION['openid'] = $resToken["openid"] ;

$_SESSION['member'] = $u;

//file_put_contents($_SESSION['openid'].'_1.txt', print_r($base, true));
//file_put_contents($_SESSION['openid'].'_2.txt', print_r($accTokenUrl, true));
//file_put_contents($_SESSION['openid'].'_3.txt', print_r($resToken, true));
//file_put_contents($_SESSION['openid'].'_4.txt', print_r($_SESSION, true));

//跳转到用户登录或注册页
//$_SESSION['member']['invite'] = $_REQUEST['state'];

//当有此值，表示是推荐注册的
if ($_REQUEST['state']) {
    
    //此表示为直接扫描用户的分享二维码注册的，则直接跳至注册页面
    if (substr($_REQUEST['state'], 0, 3) == 'reg') {
        $regid = substr($_REQUEST['state'], 3);
        header("Location: index.php?g=Portal&m=Index&a=register&id=".$regid);
        exit;
    }
    
    
    header("Location: index.php?g=Portal&m=Index&a=register&id=".$regid); //以前id为4一元创业页面，现在8为企业介绍
    exit;
}
//更新用户信息
/*
$arr = array(
		//'CusName'          => 	$_SESSION['member']['nickname'],
		//'Sex'              => 	$_SESSION['member']['sex'],
		//'zone'             => 	$_SESSION['member']['province'].$_SESSION['userinfo']['city'],
		'img'			   => $_SESSION['member']['headimgurl'],
		);
updatetable('members',$arr, array('Openid' => $_SESSION['member']['openid']));
*/
header("Location: index.php?openid=".$u['openid']);

