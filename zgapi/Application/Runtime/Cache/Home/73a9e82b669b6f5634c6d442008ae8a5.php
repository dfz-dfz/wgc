<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>59家居网</title>
    <link rel="stylesheet" type="text/css" href="/manage/Public/jobs/css/aui.2.0.css" />
    <script type="text/javascript" src="/manage/Public/jobs/script/jquery-1.7.2.min.js" ></script>
<script type="text/javascript"> 
onload=function(){ 
	setTimeout(go, 2000);
}; 
function go(){ 
location.href="http://59jiaju.com/manage/jingyi.php/Home/Jymember/userinfo"; 
} 
</script>
<style type="text/css">
.aui-content-padded p{width:80%;max-width:80%;margin-left:auto;margin-right: auto;margin-bottom: 10px;background-color: #FE7113;}
</style>
</head>
<body>
<header class="aui-bar aui-bar-nav" style="background-color:#EA8615;">系统审核</header>
<div style="width:100%;height:100%;">
	<div style="width:100%;text-align:center;margin-top:50px;">
		<span>恭喜您已经通过系统审核，<br/>系统已自动赠送您100积分</span>
	</div>
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