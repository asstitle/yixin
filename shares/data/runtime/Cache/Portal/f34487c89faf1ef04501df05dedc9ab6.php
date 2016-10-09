<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
	<html lang="en">
	<head>
		<title><?php echo ($site_name); ?>-跳转提示</title>

		<meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no maximum-scale=1.0"  />
		
		<style type="text/css">
		html {font-size:62.5%; }
		*{ padding: 0; margin: 0; }
		body{ background: #fff; font-family: "Arial","微软雅黑"; color: #333;  }
		.btn_red_a{font-size: 1.4rem; line-height: 4rem; text-decoration: none; color: #fff; background: #30b4ff; border-radius: .4rem; height: 4rem ;text-align: center; display: block; }
		.system-message{ padding: 2rem; text-align: center; }
		.system-message h1{ font-size: 1.8rem; font-weight: normal; line-height: 120px; margin-bottom: 12px; text-align: center;}
		.system-message .jump{ padding: 1rem 0; font-size: 1.4rem; line-height: 2rem;}
		.system-message .success,.system-message .error{ line-height: 2em; font-size: 1.6rem; }
		.system-message .detail{ font-size: 1.4rem; line-height: 2rem; margin-top: 12px; display:none}
		</style>
	</head>
<body class="body-white">
	
	<div class="system-message">
	<?php if(isset($message)): ?><p class="success"><?php echo($message); ?></p>
	<?php else: ?>
	<p class="error"><?php echo($error); ?></p><?php endif; ?>
	<p class="detail"></p>
	<p class="jump">
		页面跳转中，时间： <b id="wait"><?php echo($waitSecond); ?></b>
	</p>
	<p class="pad_1"><a id="href" class="btn_red_a" href="<?php echo($jumpUrl); ?>">立即跳转</a></p>
	</div>
	<script type="text/javascript">
	(function(){
	var wait = document.getElementById('wait'),href = document.getElementById('href').href;
	var interval = setInterval(function(){
		var time = --wait.innerHTML;
		if(time <= 0) {
			location.href = href;
			clearInterval(interval);
		};
	}, 1000);
	})();
	</script>

</body>
</html>