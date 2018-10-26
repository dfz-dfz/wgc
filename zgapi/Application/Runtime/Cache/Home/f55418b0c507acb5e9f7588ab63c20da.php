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
		//申请
		function shenqing(){
			//sqform
			//alert('ok');
			$.ajax({
				cache: true,
				type: "POST",
				url:"/manage/index.php/Home/Zhaopin/shenqing",
				data:$("#sqform").serialize(),// 你的formid
				async: false,
				  error: function(request) {
					  alert("Connection error");
				  },
				  success: function(data) {
					//$("#commonLayout_appcreshi").parent().html(data);
					if(data=="errr"){
						alert('你已经申请过');
					}else if(data=="err"){
						alert("申请失败");
					}else{
						alert('申请成功');
					}
				   //alert(data);
				  }
			  });
		}
		//关注
		function care(){
			//gzform
			//alert('ok');
			$.ajax({
				cache: true,
				type: "POST",
				url:"/manage/index.php/Home/Zhaopin/care",
				data:$("#sqform").serialize(),// 你的formid
				async: false,
				  error: function(request) {
					  alert("Connection error");
				  },
				  success: function(data) {
					//$("#commonLayout_appcreshi").parent().html(data);
					if(data=="errr"){
						alert('你已经关注过');
					}else if(data=="err"){
						alert("关注失败");
					}else{
						alert('关注成功');
					}
				   //alert(data);
				  }
			  });
		}
	</script>
</head>
<body>
<!--切换-->
<div class="aui-tab" id="tab" style="background-color:#FE7213;text-align:center;" >
	<div style="width: 30%;max-width:30%;">
		<div class="aui-col-xs-3">
            <i onclick="goBack()" class="aui-iconfont aui-icon-left"></i>
        </div>
	</div>
	<?php if($flag == 'zw'): ?><div style="width: 20%;max-width:20%;height: 2.2rem;line-height: 2.2rem;display:inline;background-color:#FFFFFF;border:2px solid #FFFFFF;"><span style="width:100%;height:100%;color:#F56E12;"><a href="/manage/index.php/Home/Zhaopin/jobinfo/id/<?php echo ($info["id"]); ?>">职位信息</a></span></div>
		<div style="width: 20%;max-width:20%;height: 2.2rem;line-height: 2.2rem;display:inline;background-color:#FE7213;border:2px solid #FFFFFF;"><span style="width:100%;height:100%;color:#FFFFFF;"><a href="/manage/index.php/Home/Zhaopin/getcompinfo/user_id/<?php echo ($info["uid"]); ?>/zid/<?php echo ($info["id"]); ?>">公司信息</a></span></div>
	<?php else: ?> 
		<div style="width: 20%;max-width:20%;height: 2.2rem;line-height: 2.2rem;display:inline;background-color:#FE7213;border:2px solid #FFFFFF;"><span style="width:100%;height:100%;color:#FFFFFF;"><a href="/manage/index.php/Home/Zhaopin/jobinfo/id/<?php echo ($info["id"]); ?>">职位信息</a></span></div>
		<div style="width: 20%;max-width:20%;height: 2.2rem;line-height: 2.2rem;display:inline;background-color:#FFFFFF;border:2px solid #FFFFFF;"><span style="width:100%;height:100%;color:#F56E12;"><a href="/manage/index.php/Home/Zhaopin/getcompinfo/user_id/<?php echo ($info["uid"]); ?>/zid/<?php echo ($info["id"]); ?>">公司信息</a></span></div><?php endif; ?>
	<div style="width: 30%;max-width:30%;"></div>
</div>
<!--详细列表-->
<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-list-in">
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-title"><?php echo ($info["title"]); ?></div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-title"><span style="color:#FFBE7A;"><?php echo ($info["xinzi"]); ?>元/月</span><br/><?php echo ($info["gname"]); ?></div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-title">
					<table style="width:100%;max-width:100%;">
						<tr style="width:100%;max-width:100%;">
							<td style="width:10%;max-width:25%;"><span style="color:#B4B4B4;">性质</span></td>
							<td style="width:40%;max-width:25%;"><?php echo ($info["xingzhi"]); ?></td>
							<td style="width:10%;max-width:25%;"><span style="color:#B4B4B4;">规模</span></td>
							<td style="width:40%;max-width:25%;"><?php echo ($info["guimo"]); ?></td>
						</tr>
						<tr>
							<td><span style="color:#B4B4B4;">发布</span></td>
							<td ><?php echo ($info["addtime"]); ?></td>
							<td ><span style="color:#B4B4B4;">人数</span></td>
							<td >若干</td>
						</tr>
						<tr>
							<td ><span style="color:#B4B4B4;">地区</span></td>
							<td colspan='3'><?php echo ($info["s_province"]); ?> <?php echo ($info["s_city"]); ?> <?php echo ($info["s_county"]); ?> </td>
							
						</tr>
					</table>
				</div>
            </div>
        </li>
    </ul>
</div>
<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-list-in">
        <li class="aui-list-item aui-list-item-middle">
            <div class="aui-list-item-inner aui-list-item-arrow">
                <div class="aui-list-item-title"><span style="color:#B4B4B4;">上班地址</span>　<?php echo ($info["xiangxi"]); ?></div>
			</div>
        </li>
    </ul>
</div>
<div style="width:100%;max-width:100%;height:5px;background-color:#E8F1F0;"></div>
<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-list-in">
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
				<div class="aui-list-item-title"><span style="color:#B4B4B4;">薪资福利</span><br/>五险一金　免费班车　员工旅游　 绩效奖金<br/>年终奖金　产品福利　包吃</div>
            </div>
			
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
				<div class="aui-list-item-title"><span style="color:#B4B4B4;">职位标签</span> <br/>产品主管　化妆品　产品策划　市场调研</div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
				 <div class="aui-list-item-title"><span style="color:#B4B4B4;">职位描述：</span><br/><?php echo ($info["guimo"]); ?><br/><?php echo ($info["content"]); ?></div>
            </div>
        </li>
    </ul>
</div>
<!--申请-->
<form id="sqform" action="/manage/index.php/Home/Zhaopin/shenqing" method="post" id="shenqing">
	<input type="hidden" name="zp_id" value="<?php echo ($info["id"]); ?>">
</form>
<!--关注-->
<form id="gzform" action="/manage/index.php/Home/Zhaopin/care" method="post" id="care">
	<input type="hidden" name="zp_id" value="<?php echo ($info["id"]); ?>">
</form>
<footer class="aui-bar aui-bar-tab" id="footer">
    <div class="aui-bar-tab-item aui-active" tapmode>
        <i class="aui-iconfont aui-icon-back" onclick="goBack()"></i>
        <div class="aui-bar-tab-label"><span onclick="goBack()">返回</span></div>
    </div>
	<div class="aui-bar-tab-item aui-active" tapmode>
        <i class="aui-iconfont aui-icon-pencil" onclick="shenqing()" ></i>
        <div class="aui-bar-tab-label"><span onclick="shenqing()">申请</span></div>
    </div>
    <div class="aui-bar-tab-item" tapmode>
        <i class="aui-iconfont aui-icon-star" onclick="care()"></i>
        <div class="aui-bar-tab-label"><span onclick="care()">收藏</span></div>
    </div>
</footer>
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