<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no maximum-scale=1.0"  />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo ($site_name); ?></title>
<meta name="keywords" content="<?php echo ($site_seo_keywords); ?>" />
<meta name="description" content="<?php echo ($site_seo_description); ?>">
<link rel="stylesheet" type="text/css" href="/shares/tpl/simplebootx_mobile/Public/style/base.css" />
<link rel="stylesheet" type="text/css" href="/shares/tpl/simplebootx_mobile/Public/style/skins/all.css" />
<link rel="stylesheet" type="text/css" href="/shares/tpl/simplebootx_mobile/Public/style/style.css" />
<link rel="stylesheet" type="text/css" href="/shares/tpl/simplebootx_mobile/Public/style/member.css">
<link rel="stylesheet" href="/shares/tpl/simplebootx_mobile/Public/style/font-awesome.min.css">
<link rel="stylesheet" href="/shares/tpl/simplebootx_mobile/Public/style/swiper.css">
<script type="text/javascript" src="/shares/tpl/simplebootx_mobile/Public/js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="/shares/tpl/simplebootx_mobile/Public/js/swiper.jquery.min.js"></script>
<script type="text/javascript" src="/shares/tpl/simplebootx_mobile/Public/js/touchScroll.js"></script>
<script type="text/javascript" src="/shares/tpl/simplebootx_mobile/Public/js/icheck.min.js"></script>
<script type="text/javascript" src="/shares/tpl/simplebootx_mobile/Public/js/city.js"></script>
<script type="text/javascript" src="/shares/tpl/simplebootx_mobile/Public/js/area.js"></script>
<script type="text/javascript" src="/shares/tpl/simplebootx_mobile/Public/js/js.js"></script>
<script type="text/javascript" src="/shares/statics/js/zt/js_zt.js"></script>
<!--统计代码-->
<?php  ?>
</head>
<body class="f0 reg">
	<form action="<?php echo U('Index/updatepass');?>" method="post">
		<div class="itme_3 clr">
			<span class="fl">手机号码</span>
			<div class="fr"><input type="tel" placeholder="请输入手机号码"  id="phone" name="phone" datatype="m" nullmsg="请输入手机号！" errormsg="手机号不正确！"></div>
		</div>
		<div class="itme_3 clr">
			<span class="fl">验证码</span>
			<div class="fr"><input type="tel" name="code" datatype="*" nullmsg="请填写验证码" placeholder="填写验证码" data-width="100"><span class="get_code phone_validate">获取验证码</span></div>
		</div>
		<div class="itme_3 clr">
			<span class="fl">输入新密码</span>
			<div class="fr"><input type="password" placeholder="请输入新密码" name="password" datatype="s6-16" nullmsg="请输入新密码" errormsg="密码长度6-16位"></div>
		</div>
		<div class="itme_3 clr">
			<span class="fl">确认新密码</span>
			<div class="fr"><input type="password" placeholder="再次输入新密码"  datatype="*" recheck="password" nullmsg="请确认密码" errormsg="您两次输入的账号密码不一致"></div>
		</div>
		<div class="btn1">
			<input type="submit" class="zt_ajax_form" value="确认修改">
		</div>
	</form>
	<script>
		//获取验证码
		$(".phone_validate").on('click', function(){
			if($(".phone_validate").attr("issend")==1){
				return false;
			}
			var telephone = $("input[name=phone]").val();
			//alert(telephone);
			var regexp = /^1[3,5,7,8]\d{9}$/;
			if (!regexp.test(telephone)) {
				layer.msg("请输入手机号码！"); //, {time:0}
				return false;
			}
			$.post("<?php echo U('Index/sms_send');?>", {phone: telephone},function(data){
				if (data == "1") {
					layer.msg("发送成功!");
					nulls = setInterval(re_send, 1000);
				}
			},"json");
		});
		$(function(){
			//验证码倒计时
			$(".phone_validate").attr("issend", 2);
		})
		var rnd_n = 300;
		function re_send() {
			rnd_n--;
			if(rnd_n == 0) {
				$(".phone_validate").attr("issend", 2);
				$(".phone_validate").html("获取验证码");
				rnd_n = 300;
				clearInterval(nulls);
				return false;
			}
			$(".phone_validate").attr("issend", 1);
			$(".phone_validate").html(rnd_n+"S");
			//setTimeout(re_send(),1000);
		}
	</script>
	<footer class="footer-menu">
	<ul class="bot-nav">
        <li  <?php if($active == 'index' ): ?>class="cur"<?php endif; ?> ><a href="<?php echo U('Index/index');?>"><i class="iconfont">&#xe62d;</i><span>首页</span></a></li>
        <!-- <li <?php if($active == 'sxy' ): ?>class="cur"<?php endif; ?>><a href="#"><i class="iconfont">&#xe62e;</i><span>商学院</span></a></li> -->
        <li <?php if($active == 'gywm' ): ?>class="cur"<?php endif; ?>><a href="<?php echo U('Index/gywm');?>" ><i class="iconfont">&#xe630;</i><span>关于我们</span></a></li>
        <li <?php if($active == 'user' ): ?>class="cur"<?php endif; ?>><a href="<?php echo U('User/index');?>" ><i class="iconfont">&#xe62f;</i><span>会员</span></a></li>
    </ul>
    <!-- <ul>
        <li class="cur">
            <a href="<?php echo U('Index/index');?>" class="home"><p>首页</p></a>
        </li>
        <li class="">
            <a href="<?php echo U('Index/article',array('id'=>8,'regis'=>$toregis));?>" class="type"><p>企业简介</p></a>
        </li>
        
        <li class="">
            <a href="<?php echo U('portal/Index/article_list',array('id'=>3));?>" class="cart"><p>公司活动</p></a>
        </li>
       
        <li class="">
            <a href="<?php echo U('Index/article',array('id'=>2,'regis'=>$toregis));?>" class="my"><p>联系我们</p></a>
        </li>
    </ul>  -->
</footer>
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    /*
     * 注意：
     * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
     * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
     * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
     *
     * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
     * 邮箱地址：weixin-open@qq.com
     * 邮件主题：【微信JS-SDK反馈】具体问题
     * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
     */
    wx.config({
        debug: false,
        appId: '<?php echo ($site_AppId); ?>',
        timestamp: '<?php echo ($signPackage1["timestamp"]); ?>',
        nonceStr: '<?php echo ($signPackage1["nonceStr"]); ?>',
        signature: '<?php echo ($signPackage1["signature"]); ?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            'onMenuShareAppMessage', 'onMenuShareTimeline', 'scanQRCode'
        ]
    });
    wx.ready(function () {
        // 在这里调用 API

        wx.onMenuShareAppMessage({
            title: '<?php echo ($site_name); ?>', // 分享标题
            desc: '<?php echo ($site_seo_description); ?>', // 分享描述
            link: '<?php echo ($weixin_url); ?>', // 分享链接
            imgUrl: 'http://yixin.woyii.com//shares/tpl/simplebootx_mobile/Public/image/wx_logo.png', // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
                //layer.msg('分享成功了');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
                //layer.msg('分享取消了');
            }
        });

        wx.onMenuShareTimeline({
            title: '<?php echo ($site_name); ?>', // 分享标题
            link: '<?php echo ($weixin_url); ?>', // 分享链接
            imgUrl: 'http://yixin.woyii.com//shares/tpl/simplebootx_mobile/Public/image/wx_logo.png', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
                //layer.msg('分享成功了');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
                //layer.msg('分享取消了');
            }
        });

/* 2016-07-14 注释，此只有在附近商铺里调用，因此不做为通用
        wx.getLocation({
            success: function (res) {
                var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
//                    //返回坐标

                $("#zuobiao").val(latitude+","+longitude);
                if ($(".view_list_box").size() > 0) {
                    if($(".view_list_box").hasClass('on')) {
                        var page = 1;
                        var IsNext = true;
                        $(document).ready(function () {
                            $(window).scroll(function () {
                                var tops = parseFloat($(window).height()) + parseFloat($(window).scrollTop()) + 380; //380
                                var h = $(document).height();
                                //h = $(document.body).height()*page;
                                var w = tops - h;
                                if (IsNext && w >= 0) {
                                    if (IsNext) page++;
                                    foodlist(page);
                                }
                            });
                            foodlist(1);//第二个参数是坐标地址 其他项目可删掉
                        });
                    }
                }
            },
            cancel: function (res) {
                alert('用户拒绝授权获取地理位置');
            }
        });
*/
    });


    $(function(){
	//获取当前地理位置
	$("#getLocation").click(function() {
		getuserlocation();
	});

        function getuserlocation() {
            wx.getLocation({
                success: function (res) {
                    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                    var speed = res.speed; // 速度，以米/每秒计
                    var accuracy = res.accuracy; // 位置精度
//                    //返回坐标
//                    return JSON.stringify(res);
                },
                cancel: function (res) {
                    alert('用户拒绝授权获取地理位置');
                }
            });
        }

        //点击扫描按钮，扫描二维码并返回结果
        $("#scanQRCode").click(function() {
            wx.scanQRCode({
                needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res) {
                    //扫码后获取结果参数:htpp://xxx.com/c/?6123，截取到url中的防伪码后，赋值给Input
                    var url = res.resultStr;
                    //var tempArray = url.split('?');
                    //var tempNum = tempArray[1];
                    $("#seller").val(url);
                    $("#user").val(url);
                    hd();//调用不同页面的验证
                }
            });
        });
    });

</script>
</body>
</html>