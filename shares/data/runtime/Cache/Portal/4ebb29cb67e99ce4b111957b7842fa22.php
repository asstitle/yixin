<?php if (!defined('THINK_PATH')) exit();?>

<!DOCTYPE html>
<html lang="zh-cn">
<head lang="en">
    
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
<meta content="telephone=no" name="format-detection"/>
<meta name="format-detection" content="email=no"/>
<title>易信金融</title>
<link href="/easecredit/statics/xyh/images/favicon.ico" rel="SHORTCUT ICON"/>
<link rel="stylesheet" href="/easecredit/statics/xyh/style/global.css" type="text/css">
<link rel="stylesheet" href="/easecredit/statics/xyh/style/idangerous.swiper.css" type="text/css">
<link rel="stylesheet" href="/easecredit/statics/xyh/style/yxStyle.css" type="text/css">
<script src="/easecredit/statics/xyh/js/jquery-1.12.3.min.js"></script>
<script src="/easecredit/statics/xyh/js/idangerous.swiper.min.js"></script>
<script src="/easecredit/statics/xyh/js/idangerous.swiper.scrollbar-2.1.js"></script>
<script src="/easecredit/statics/xyh/js/yx.js"></script>
<script type="text/javascript" src="/easecredit/statics/js/zt/js_zt.js"></script>

	<link rel="stylesheet" href="../../../../statics/xyh/style/yxStyle.css">
</head>

<body>
<!--轮播-->
<main>
    <div class="swiper-container">
        <div class="swiper-wrapper">
        	<?php if(is_array($banner_list)): foreach($banner_list as $key=>$vo): ?><div class="swiper-slide">
                <a href="<?php echo ($vo["slide_url"]); ?>" ><img src="<?php echo ($vo["slide_pic"]); ?>"></a>
            	</div><?php endforeach; endif; ?>
            <!-- <div class="swiper-slide">
                <a href="#" ><img src="/easecredit/statics/xyh/images/banner_02.gif"></a>
            </div>
            <div class="swiper-slide">
                <a href="#" ><img src="/easecredit/statics/xyh/images/banner_02.gif"></a>
            </div> -->
        </div>
        <div class="swiper-pagination"></div>
    </div>
</main>

<!--我的信息-->
<section class="sec-index sec-info cc">
    <h2>我的信息</h2>
    <ul>
        <li><a href="<?php echo U('User/score');?>">我的钱包</a></li>
        <li><a href="<?php echo U('User/rebates');?>">我的奖励</a></li>
    </ul>
</section>




<!--易信商学院-->
<section class="sec-index sec-school cc">
    <h2>易信商学院</h2>
    <ul>
    	
    	<?php if(is_array($posts_list)): foreach($posts_list as $key=>$vo): $curriculum_pic1 = json_decode($vo['curriculum_pic']); ?>
    		<li><a href="<?php echo U('Curriculum/index');?>&id=<?php echo ($vo["id"]); ?>"><img src="<?php echo ($curriculum_pic1[0]); ?>"></a></li><?php endforeach; endif; ?>
        <!-- <li><a href="#"><img src="/easecredit/statics/xyh/images/s_03.jpg"></a></li>
        <li><a href="#"><img src="/easecredit/statics/xyh/images/s_05.jpg"></a></li>
        <li><a href="#"><img src="/easecredit/statics/xyh/images/s_09.jpg"></a></li>
        <li><a href="#"><img src="/easecredit/statics/xyh/images/s_11.jpg"></a></li> -->
    </ul>
</section>

<!--推荐课程-->
<section class="sec-index sec-course cc">
    <h2>推荐课程</h2>
    <ul>
    	<?php if(is_array($curriculum_list)): foreach($curriculum_list as $key=>$vo): $curriculum_pic = json_decode($vo['curriculum_pic']); $ks_list = json_decode($vo['ks_list']); $count = 0; foreach($ks_list as $keys=>$values) { $count ++; } ?>
			<li>
	            <a href="<?php echo U('Curriculum/tjkc');?>&id=<?php echo ($vo["id"]); ?>">
	                <div class="img-wrapper">
	                    <img  src="<?php echo ($curriculum_pic[0]); ?>">
	                    <div class="overlay">
	                        <p>共<?php echo ($count); ?>节</p>
	                    </div>
	                </div>
	                <span><?php echo ($vo["curriculum_name"]); ?></span>
	            </a>
	        </li><?php endforeach; endif; ?>
        
    </ul>
</section>
<!--寻师问诊-->
<section class="sec-index sec-look cc">
    <h2>寻师问诊</h2>
    <ul>
        <li><a href="#"><img src="/easecredit/statics/xyh/images/z_1.png"><span>金融医院</span></a></li>
        <li><a href="#"><img src="/easecredit/statics/xyh/images/z_2.png"><span>我要借钱</span></a></li>
        <li><a href="#"><img src="/easecredit/statics/xyh/images/z_3.png"><span>我要办卡</span></a></li>
        <li><a href="#"><img src="/easecredit/statics/xyh/images/z_4.png"><span>我要投资</span></a></li>
    </ul>
</section>

<div class="clear-pos"></div>
	<!--底部导航-->
<nav>
    <ul class="bot-nav">
        <li><a href="<?php echo U('Index/index');?>" <?php if($active == 'index' ): ?>class="active"<?php endif; ?> ><i class="iconfont">&#xe62d;</i><span>首页</span></a></li>
        <!-- <li><a href="#" <?php if($active == 'sxy' ): ?>class="active"<?php endif; ?> ><i class="iconfont">&#xe62e;</i><span>商学院</span></a></li>  -->
        <li><a href="<?php echo U('Index/gywm');?>" <?php if($active == 'gywm' ): ?>class="active"<?php endif; ?>><i class="iconfont">&#xe630;</i><span>关于我们</span></a></li>
        <li><a href="<?php echo U('Index/gywm');?>" <?php if($active == 'gywm' ): ?>class="active"<?php endif; ?>><i class="iconfont">&#xe630;</i><span>使用教程</span></a></li>
        <li><a href="<?php echo U('User/index');?>" <?php if($active == 'user' ): ?>class="active"<?php endif; ?>><i class="iconfont">&#xe62f;</i><span>会员</span></a></li>
    </ul>
</nav>
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
            imgUrl: 'http://yixin.woyii.com//easecredit/tpl/simplebootx_mobile/Public/image/wx_logo.png', // 分享图标
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
            imgUrl: 'http://yixin.woyii.com//easecredit/tpl/simplebootx_mobile/Public/image/wx_logo.png', // 分享图标
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