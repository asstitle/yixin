<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head lang="en">
    
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
<meta content="telephone=no" name="format-detection"/>
<meta name="format-detection" content="email=no"/>
<title>易信金融</title>
<link href="/shares/statics/xyh/images/favicon.ico" rel="SHORTCUT ICON"/>
<link rel="stylesheet" href="/shares/statics/xyh/style/global.css" type="text/css">
<link rel="stylesheet" href="/shares/statics/xyh/style/idangerous.swiper.css" type="text/css">
<link rel="stylesheet" href="/shares/statics/xyh/style/yxStyle.css" type="text/css">
<script src="/shares/statics/xyh/js/jquery-1.12.3.min.js"></script>
<script src="/shares/statics/xyh/js/idangerous.swiper.min.js"></script>
<script src="/shares/statics/xyh/js/idangerous.swiper.scrollbar-2.1.js"></script>
<script src="/shares/statics/xyh/js/yx.js"></script>
<script type="text/javascript" src="/shares/statics/js/zt/js_zt.js"></script>

</head>

<body>

<main>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php if(is_array($banner_list)): foreach($banner_list as $key=>$vo): ?><div class="swiper-slide">
                <a href="<?php echo ($vo["slide_url"]); ?>" ><img src="<?php echo ($vo["slide_pic"]); ?>"></a>
            	</div><?php endforeach; endif; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</main>

<section class="sec-detail-nav cc">
    <ul>
        <li><a href="#" data-id="sec-content"  class="active">课程详情</a></li>
        <li><a href="#" data-id="sec-catlog">课程目录</a></li>
        <li><a href="#" data-id="sec-course">相关课程</a></li>
    </ul>
</section>

<div class="sec-detail-wrapper">
    <section class="sec-detail sec-content cc active">
     
		<div>
			<?php $curriculum_content = htmlspecialchars_decode($curriculum['curriculum_content']); ?>
            <h3><?php echo ($curriculum_content); ?></h3>
            <ul>
                <li>报名人数 <span><?php echo ($curriculum["sold_number"]); ?></span></li>
                <li>价格：<i><?php echo ($curriculum["curriculum_money"]); ?></i>元</li>
            </ul>
        </div>
		
        <div class="sec-index sec-detail-teacher cc">
			
            <h2>老师介绍</h2>
            <div class="te-wrapper">
                <div class="pos">
                    <img src="<?php echo ($curriculum["teacher_pic"]); ?>">
                    <dl>
                        <dd><?php echo ($curriculum["teacher_name"]); ?></dd>
                        <dd>课程数：<i><?php echo ($curriculum["curriculum_number"]); ?></i>课</dd>
                        <dd>学生数：<span><?php echo ($curriculum["student_number"]); ?></span>人</dd>
                    </dl>
                </div>
                <p><?php echo ($curriculum["teacher_content"]); ?></p>
            </div>
        </div>
       
        	
        
    </section>
    <section class="sec-index sec-detail sec-catlog cc">
        <h2>课程目录</h2>
        	<ul class="catlog">
        	<?php $ks_list = json_decode($curriculum['ks_list']); ?>
    		
    		<?php foreach($ks_list as $keys => $values) { ?>
        				<!-- <li><a href="<?php echo ($values); ?>"><?php echo ($keys); ?></a></li> -->
        				<li><a href="<?php echo ($values); ?>"><i class="iconfont">&#xe609;</i><b><?php echo ($keys); ?></b></a></li><br/>
        			<?php } ?>
        	</ul>
        
    </section>
    <!--推荐课程-->
    <section class="sec-index  sec-course sec-detail cc">
        <h2>易信商学院</h2>
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
           <!--  <li>
                <a href="#">
                    <div class="img-wrapper">
                        <img src="/shares/statics/xyh/images/c_05.png">
                        <div class="overlay">
                            易信金融（共18节）
                        </div>
                    </div>
                    <span>易信金融培训课程初级班易信金融培训课程初级班易信金融培训课程初级班易信金融培训课程初级班</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <div class="img-wrapper">
                        <img src="/shares/statics/xyh/images/c_07.jpg">
                        <div class="overlay">
                            <p>易信金融（共18节）</p>
                        </div>
                    </div>
                    <span>易信金融培训课程初级班</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <div class="img-wrapper">
                        <img src="/shares/statics/xyh/images/c_11.jpg">
                        <div class="overlay">
                            <p>易信金融（共18节）</p>
                        </div>
                    </div>
                    <span>易信金融培训课程初级班</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <div class="img-wrapper">
                        <img src="/shares/statics/xyh/images/c_13.jpg">
                        <div class="overlay">
                            <p>易信金融（共18节）</p>
                        </div>
                    </div>
                    <span>易信金融培训课程初级班</span>
                </a>
            </li> -->
        </ul>
    </section>
</div>







<div class="clear-pos"></div>
<!--底部导航-->
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