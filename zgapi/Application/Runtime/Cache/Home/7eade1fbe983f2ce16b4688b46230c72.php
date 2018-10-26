<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>59家居网</title>
    <link rel="stylesheet" type="text/css" href="/manage/Public/jobs/css/aui.2.0.css" />
	<!--<link rel="stylesheet" type="text/css" href="/manage/Public/jobs/css/api.css" />-->
	<!--<link rel="stylesheet" type="text/css" href="/manage/Public/jobs/css/aui-skin.css" />-->
	<!--<link rel="stylesheet" type="text/css" href="/manage/Public/jobs/css/aui-pull-refresh.css" />-->
	<!--<link rel="stylesheet" type="text/css" href="/manage/Public/jobs/css/aui-skin-night.css" />-->
	<!--<link rel="stylesheet" type="text/css" href="/manage/Public/jobs/css/aui-slide.css" />-->
	<script type="text/javascript" src="/manage/Public/jobs/script/api.js" ></script>
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
					window.history.go(-1);
				} 
			} 
		}
        function jiehuo(){
            //alert('ok');
            //ajax无刷新动态提交数据
            $.post(
                '/manage/jingyi.php/Home/Jysearch/jiehuo',
                'id='+<?php echo ($info["id"]); ?>,
                function (msg) {       
                    alert(msg);
                }
            );
        }
		function pinjia(){
			window.location.href="http://59jiaju.com/manage/jingyi.php/Home/View/view/id/<?php echo ($info["id"]); ?>"; 
		}
	</script>
</head>
<body>
<header class="aui-bar aui-bar-nav" style="background-color:#D84E43;">
    <a class="aui-pull-left aui-btn" onclick="goBack()">
        <span class="aui-iconfont aui-icon-left"></span>
    </a>
    <!--<span style="color:#FFFFFF;float:left;" >&nbsp;<a onclick="selectcity()" href="javascript:;"><span id='s_city'>广州</span></a></span>-->
    <div class="aui-title">
            接活详情
    </div>
    
</header>
<div style="width:100%;max-width:100%;">
	<img style="width:100%;" src="/manage/Public/jobs/img/headertop.png"> 
</div>
<div style="width:100%;max-width:100%;text-align:center;">
	<span style="font-size:30px;"><?php echo ($info["xinzi"]); ?>元/天</span><br/>
	<span style="font-size:20px;">工种：<?php echo ($info["jobtypename"]); ?></span><br/>
	<span style="font-size:15px;">人数：<?php if(($job['renshu'] == '') or ($job['renshu'] == null )): ?>若干<?php else: echo ($job["renshu"]); endif; ?></span>
</div>
<!--详细列表-->
<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-list-in">
		<li class="aui-list-item">
            <div class="aui-list-item-inner">
				<div class="aui-list-item-title"><span style="color:#B4B4B4;">联系人：<?php echo ($info["lianxiren"]); ?></span></div>
            </div>
        </li>
		<li class="aui-list-item">
            <div class="aui-list-item-inner">
				<div class="aui-list-item-title"><span style="color:#B4B4B4;">联系电话：<?php echo ($info["dianhua"]); ?></span></div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-title"><span style="color:#B4B4B4;">项目名称：<?php echo ($info["title"]); ?></span></div>
            </div>
        </li>
		 <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-title"><span style="color:#B4B4B4;">报修故障：<?php echo ($info["content"]); ?></span></div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-title"><span style="color:#B4B4B4;">时　间：<?php echo ($info["addtime"]); ?></span></div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-title"><span style="color:#B4B4B4;">地　点：<?php echo ($info["xiangxi"]); ?></span></div>
            </div>
        </li>
    </ul>
</div>
<!--<div class="aui-content-padded" style="text-align:center;">
 <p><div class="aui-btn aui-btn-warning" onclick="jiehuo()">提交接活</div></p>
</div>-->
<div class="aui-content-padded">
 <p><div class="aui-btn aui-btn-warning aui-btn-block aui-btn-outlined" onclick="pinjia()">评价</div></p>
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