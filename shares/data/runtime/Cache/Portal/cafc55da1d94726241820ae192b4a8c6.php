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

</head>

<body>

<section class="sec-intro-nav cc">
    <ul>
        <li><a href="<?php echo U('Index/index');?>"><img src="/easecredit/statics/xyh/images/logo_y.png"><i>易信</i><b>中国信用管理专业品牌</b></a></li>
        <li>
        	<?php if($user_nicename): ?><a href="<?php echo U('User/index');?>"><?php echo ($user_nicename); ?></a>
        	<?php else: ?>
        		<a href="<?php echo U('Index/login');?>">登录</a><?php endif; ?>
        	
        </li>
    </ul>
</section>

<section class="sec-intro-content">
    <img src="/easecredit/statics/xyh/images/intro_02.gif">
    <h3>易信公司简介</h3>
    <p>1、玛雅/易信合作商内部工作人员；</p>
    <p>2、玛雅/易信合作商推荐人员；</p>
    <p>3、认可玛雅/易信价值理念，愿为会员提供服务的会员；</p>
    <p>4、有能力缴纳5800元学习费用的会员。</p>
    <img src="/easecredit/statics/xyh/images/intro_04.gif">
    <p>凡不属于上述前三项其中一项和第四项的会员，无权报名参加实操内训班的学习。实操内训班实操内容：</p>
    <p>1、打造融资规划师； </p>
    <p>2、通过手机获得最高50万的授信  </p>
    <p>3、打造自己融资资本，如何获得100万的储备银行；  </p>
    <p>4、.教你信用卡规划和使用，让额度快速提升2-10倍  </p>
    <p>5、研究银行习性，发现银行授信的密码，让银行主动为你授信。  </p>
    <p>6、如何做到买房买车不花钱还倒拿钱，轻松实现一年给自己配置两套房；  </p>
    <p>7、轻资产人群如何三到六个月打造20—50万的授信；  </p>
    <p>8、加入全国投融资平台  </p>
</section>

<div class="clear-pos"></div>
	<!--底部导航-->
<nav>
    <ul class="bot-nav">
        <li><a href="<?php echo U('Index/index');?>" <?php if($active == 'index' ): ?>class="active"<?php endif; ?> ><i class="iconfont">&#xe62d;</i><span>首页</span></a></li>
        <!-- <li><a href="#" <?php if($active == 'sxy' ): ?>class="active"<?php endif; ?> ><i class="iconfont">&#xe62e;</i><span>商学院</span></a></li>  -->
        <li><a href="<?php echo U('Index/gywm');?>" <?php if($active == 'gywm' ): ?>class="active"<?php endif; ?>><i class="iconfont">&#xe630;</i><span>关于我们</span></a></li>
        <li><a href="<?php echo U('User/index');?>" <?php if($active == 'user' ): ?>class="active"<?php endif; ?>><i class="iconfont">&#xe62f;</i><span>会员</span></a></li>
    </ul>
</nav>
</body>
</html>