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
	<!--<script type="text/javascript" src="/manage/Public/jobs/script/aui-dialog.js" ></script>-->
	<!--<script type="text/javascript" src="/manage/Public/jobs/script/aui-popup.js" ></script>-->
	<!--<script type="text/javascript" src="/manage/Public/jobs/script/aui-pull-refresh.js" ></script>-->
	<!--<script type="text/javascript" src="/manage/Public/jobs/script/aui-range.js" ></script>-->
	<!--<script type="text/javascript" src="/manage/Public/jobs/script/aui-scroll.js" ></script>-->
	<!--<script type="text/javascript" src="/manage/Public/jobs/script/aui-skin.js" ></script>-->
	<!--<script type="text/javascript" src="/manage/Public/jobs/script/aui-slide.js" ></script>-->
	<!--<script type="text/javascript" src="/manage/Public/jobs/script/aui-tab.js" ></script>-->
	<!--<script type="text/javascript" src="/manage/Public/jobs/script/aui-toast.js" ></script>-->
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
</head>
<body>
<header class="aui-bar aui-bar-nav" style="background-color:#FE7213;">
    <a class="aui-pull-left aui-btn" onclick="goBack()">
        <span class="aui-iconfont aui-icon-left"></span>
    </a>
	<span style="color:#FFFFFF;float:left;" ><a onclick="goBack()" href="javascript:;"><span id='s_city'>返回</span></a></span>
    <div class="aui-title">59家居行业装饰平台</div>
</header>
<div style="width:100%;max-width:100%;">
	<img src="/manage/Public/jobs/img/cailiaohz.png" style="width:100%;">
	<img src="/manage/Public/jobs/img/cailiaohz2.png" style="width:100%;">
</div>
<form action="/manage/index.php/Home/Company/hz" method="post">
<input type="hidden" name="msg_id" value="<?php echo ($info["msg_id"]); ?>">
<div style="width:100%;max-width:100%;">
	<div style="width:20;display:inline;">公司名称：</div><div style="width:75%;display:inline;"><input value="<?php echo ($info["gname"]); ?>" name="data[gname]" type="text" style="width:60%;max-width:60%;display:inline;" placeholder="请输入"></div>
</div>
<div style="width:100%;max-width:100%;">
	<div style="width:20;display:inline;">联 系 人：</div><div style="width:75%;display:inline;"><input value="<?php echo ($info["lianxiren"]); ?>" name="data[lianxiren]" type="text" style="width:60%;max-width:60%;display:inline;border-bottom:1px solid #C0C0C4;border-top:1px solid #C0C0C4;" placeholder="请输入"></div>
</div>
<div style="width:100%;max-width:100%;">
	<div style="width:20;display:inline;">联系电话：</div><div style="width:75%;display:inline;"><input value="<?php echo ($info["dianhua"]); ?>" name="data[dianhua]" type="text" style="width:60%;max-width:60%;display:inline;" placeholder="请输入"></div>
</div>
<div style="width:100%;max-width:100%;">
	<div style="width:20;display:inline;">电子邮箱：</div><div style="width:75%;display:inline;"><input value="<?php echo ($info["email"]); ?>" name="data[email]" type="text" style="width:60%;max-width:60%;display:inline;border-top:1px solid #C0C0C4;border-bottom:1px solid #C0C0C4;" placeholder="请输入"></div>
</div>
<div style="width:100%;max-width:100%;">
	<div style="width:20;display:inline;">留言主题：</div><div style="width:75%;display:inline;"><input value="<?php echo ($info["zhuti"]); ?>" name="data[zhuti]" type="text" style="width:60%;max-width:60%;display:inline;" placeholder="请输入"></div>
</div>
<div style="width:100%;max-width:100%;" >
	<div style="width:20;display:inline;"><span style="color:#FFFFFF;">留言内容：</span></div><div style="width:75%;display:inline;"><textarea name="data[content]" style="width:60%;max-width:60%;display:inline;border:1px solid #C0C0C4;" placeholder="请输入留言内容" cols="30" rows="8"><?php echo ($info["content"]); ?></textarea></div>
</div>
<div style="width:100%;max-width:100%;text-align:center;" >
	<input style="with:20%;max-width:20%;background-color:#E67817;" type="submit" value="提交">
</div>
</form>
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