<?php
	if(C('LAYOUT_ON')) {
		echo '{__NOLAYOUT__}';
	}
?>
<if condition="MODULE_NAME eq 'Admin'">
		<style type="text/css">
			*{ padding: 0; margin: 0; }
			body{ background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px; }
			.system-message{ padding: 124px 48px 24px;min-height: 400px; }
			.system-message{margin:0 auto;width:1024px;text-align:center;}
			.system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
			.system-message .jump{ padding-top: 10px}
			.system-message .jump a{ color: #333;}
			.system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px }
			.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
		</style>
		<body data-spy="scroll" data-target="#navbar" data-offset="0">
			<div class="system-message">
					<?php if(isset($message)) {?>
						<br/><br/><br/>
						<p class="success"><?php echo($message); ?></p>
					<?php }else{?>
						<br/><br/><br/>
						<p class="error"><?php echo($error); ?></p>
					<?php }?>
					<p class="detail"></p>
					<p class="jump">
					页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
					</p>
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

<else />

		<!-- Home操作跳转 -->
		<include file="Public/head"/>
		<style type="text/css">
			.system-message{ padding: 124px 48px 24px;min-height: 400px; }
			.system-message{margin:0 auto;width:1024px;text-align:center;}
			.system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
			.system-message .jump{ padding-top: 10px}
			.system-message .jump a{ color: #333;}
			.system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px }
			.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
		</style>
		<!-- Adaptive -->
		<script type="text/javascript" src="__PUBLIC__/site/js/jquery-1.7.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/site/css/style.css">
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/site/css/swiper.css">
		<!-- Adaptive -->
		<script type="text/javascript" src="__PUBLIC__/site/js/base.js"></script>
		<!-- 焦点图 -->
		<link type="text/css" href="__PUBLIC__/site/css/style2.css" rel="stylesheet"/>
	</head>
	<body>
		<div class="system-message">
		<?php if(isset($message)) {?>
		<br/><br/><br/>
		<p class="success"><?php echo($message); ?></p>
		<?php }else{?>
		<br/><br/><br/>
		<p class="error"><?php echo($error); ?></p>
		<?php }?>
		<p class="detail"></p>
		<p class="jump">
		页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
		</p>
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
		<include file="Public/wei"/>
	</body>
	</html>
</if>
