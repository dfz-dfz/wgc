<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>59家居网</title>
    <link rel="stylesheet" type="text/css" href="/manage/Public/jobs/css/aui.2.0.css" />

	<script type="text/javascript" src="/manage/Public/jobs/script/api.js" ></script>
	
<style type="text/css">
header ul,li,dl,dt,dd{display:block;list-style:none;}
.letter ul li a{text-decoration:none;outline:none;}
</style>
<link href="/manage/Public/jobs/css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/manage/Public/jobs/css/cityselect.css">
	<script type="text/javascript" src="/manage/Public/jobs/script/jquery-1.7.2.min.js" ></script>
	<script type="text/javascript">
		function goBack(){ 
		if ((navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)){
				// IE 
				if(history.length > 0){ 
					window.history.go( -1 ); 
				}else{
					window.opener=null;window.close(); 
				} 
			}else{ 
				//非IE浏览器 
				if (navigator.userAgent.indexOf('Firefox') >= 0 || navigator.userAgent.indexOf('Opera') >= 0 || navigator.userAgent.indexOf('Safari') >= 0 || navigator.userAgent.indexOf('Chrome') >= 0 || navigator.userAgent.indexOf('WebKit') >= 0){ 
					if(window.history.length > 1){ 
						window.history.go( -1 ); 
					}else{
						window.opener=null;window.close(); 
					} 
				}else{ 
					//未知的浏览器 
					window.history.go( -1 );
				} 
			} 
		}
		function selectcity(){
			$("#selProvince").click();
			//alert('ok');
		}
		function tijiaofrm(){
			$("#jobsfrm").submit();
		}
	</script>
</head>
<body>
<header class="aui-bar aui-bar-nav" style="background-color:#C25423;">
    <a class="aui-pull-left aui-btn" onclick="goBack()">
        <span class="aui-iconfont aui-icon-left"></span>
    </a>
	<!--<span style="color:#FFFFFF;float:left;" >&nbsp;<a onclick="selectcity()" href="javascript:;"><span id='s_city'>广州</span></a></span>-->
    <div class="aui-title">
			我的接活
	</div>
	
</header>
<script type="text/javascript" src="/manage/Public/jobs/js/zepto.js"></script>
<script type="text/javascript">

$('body').on('click', '.letter a', function () {
	var s = $(this).html();
	$(window).scrollTop($('#' + s + '1').offset().top);
});
</script>
<!--内容列表-->
<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-list-in">
		<?php if(is_array($jobs)): foreach($jobs as $key=>$job): ?><li class="aui-list-item aui-list-item-middle">
				<div class="aui-list-item-inner aui-list-item-arrow">
                <div class="aui-list-item-title"><a href="/manage/jingyi.php/Home/Jysearch/myjobinfo/id/<?php echo ($job["id"]); ?>"><span style="color:#FB9541;float:right;"><?php echo ($job["addtime"]); ?><br/>报价：<?php echo ($job["xinzi"]); ?></span><span>项目名称：<?php echo ($job["title"]); ?><br/><?php echo ($job["s_city"]); echo ($job["s_county"]); ?></span></a></div>
			</li><?php endforeach; endif; ?>
    </ul>
</div>
</body>

<script type="text/javascript">
    apiready = function(){
        api.parseTapmode();
    }
    function openWin(name){
        var delay = 0;
        if(api.systemType != 'ios'){
            delay = 300;
        }
        api.openWin({
            name: ''+name+'',
            url: ''+name+'.html',
            bounces:false,
            delay: delay,
            slidBackEnabled:true,
            vScrollBarEnabled:false
        });
    }

</script>
</html>