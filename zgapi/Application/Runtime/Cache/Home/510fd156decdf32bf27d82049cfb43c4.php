<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>59家居网</title>
    <link rel="stylesheet" type="text/css" href="/zgapi/Public/jobs/css/aui.2.0.css" />
	<!--<link rel="stylesheet" type="text/css" href="/zgapi/Public/jobs/css/api.css" />-->
	<!--<link rel="stylesheet" type="text/css" href="/zgapi/Public/jobs/css/aui-skin.css" />-->
	<!--<link rel="stylesheet" type="text/css" href="/zgapi/Public/jobs/css/aui-pull-refresh.css" />-->
	<!--<link rel="stylesheet" type="text/css" href="/zgapi/Public/jobs/css/aui-skin-night.css" />-->
	<!--<link rel="stylesheet" type="text/css" href="/zgapi/Public/jobs/css/aui-slide.css" />-->
	<!--<script type="text/javascript" src="/zgapi/Public/jobs/script/api.js" ></script>-->
	<!--<script type="text/javascript" src="/zgapi/Public/jobs/script/aui-dialog.js" ></script>-->
	<!--<script type="text/javascript" src="/zgapi/Public/jobs/script/aui-popup.js" ></script>-->
	<!--<script type="text/javascript" src="/zgapi/Public/jobs/script/aui-pull-refresh.js" ></script>-->
	<!--<script type="text/javascript" src="/zgapi/Public/jobs/script/aui-range.js" ></script>-->
	<!--<script type="text/javascript" src="/zgapi/Public/jobs/script/aui-scroll.js" ></script>-->
	<!--<script type="text/javascript" src="/zgapi/Public/jobs/script/aui-skin.js" ></script>-->
	<!--<script type="text/javascript" src="/zgapi/Public/jobs/script/aui-slide.js" ></script>-->
	<!--<script type="text/javascript" src="/zgapi/Public/jobs/script/aui-tab.js" ></script>-->
	<!--<script type="text/javascript" src="/zgapi/Public/jobs/script/aui-toast.js" ></script>-->
	<script type="text/javascript" src="/zgapi/Public/jobs/script/jquery-1.7.2.min.js" ></script>
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
</script>
<style type="text/css">
.aui-content-padded p{width:80%;max-width:80%;margin-left:auto;margin-right: auto;margin-bottom: 10px;background-color: #FE7113;}
</style>
</head>
<body>
<header class="aui-bar aui-bar-nav" style="background-color:#FE7213;">
    <a class="aui-pull-left aui-btn" onclick="goBack()">
        <span class="aui-iconfont aui-icon-left"></span>
    </a>
	<span style="color:#FFFFFF;float:left;" ><a onclick="goBack()" href="javascript:;"><span id='s_city'>返回</span></a></span>
    <div class="aui-title" ><span style="float:right;"><a href="/zgapi/index.php/Home/Member/login">登录</a><span></div>
</header>
<div style="width:100%;max-width:100%;">
  <img width="100%" src="/zgapi/Public/jobs/img/reglogo.png">
</div>
<!--按钮-->
<!--<div class="aui-content-padded">
   <p style="background-color: #FE7113;"><div style="background-color: #FE7113;" class="aui-btn aui-btn-primary aui-btn-block aui-btn-outlined"><span style="width:100%;max-width:100%;background-color: #FE7113;color:#FFFFFF;"><a  href="/zgapi/index.php/Home/Member/ownreg">个人注册</a></span></div></p>
   <p style="background-color: #FE7113;"><div style="background-color: #FE7113;" class="aui-btn aui-btn-primary aui-btn-block aui-btn-outlined"><span style="width:100%;max-width:100%;background-color: #FE7113;color:#FFFFFF;">  <a href="/zgapi/index.php/Home/Member/gsreg">企业注册</a></span></div></p>
   <p><div class="aui-btn aui-btn-primary aui-btn-block aui-btn-outlined"><span style="width:100%;max-width:100%;background-color: #A9A9A9;color:#FFFFFF;">取消</span></div></p>
</div>-->
<div class="aui-content-padded">
    <p><div class="aui-btn aui-btn-warning aui-btn-block aui-btn-sm"><a href="/zgapi/index.php/Home/Member/ownreg">个人注册</a></div></p>
	<p><div class="aui-btn aui-btn-warning aui-btn-block aui-btn-sm"><a href="/zgapi/index.php/Home/Member/gsreg">企业注册</div></p>
	<p><div class="aui-btn aui-btn-warning aui-btn-block aui-btn-sm"><a href="javascript:;">取　消</a></div></p>
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