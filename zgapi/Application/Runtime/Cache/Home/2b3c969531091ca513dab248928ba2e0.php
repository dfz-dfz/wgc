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
		
		
		window.onpopstate = function (event) {  
     // alert("location: " + document.location + ", state: " + JSON.stringify(event.state));  
     // alert("page: " + getQueryString('page') + ", result: " + JSON.stringify(event.state));  
  
      if (getQueryString('page') == "20") {  
        if (JSON.stringify(event.state) == '{"page":20}') {  
          //alert('ok');  
          window.location.reload();  
        }  
        
      }  
    };  
    //绑定事件处理函数.    
    history.pushState({ page: 1 }, "title 1", "?page=1");    //添加并激活一个历史记录条目 http://example.com/example.html?page=1,条目索引为1    
    history.pushState({ page: 2 }, "title 2", "?page=2");    //添加并激活一个历史记录条目 http://example.com/example.html?page=2,条目索引为2    
    history.replaceState({ page: 3 }, "title 3", "?page=3"); //修改当前激活的历史记录条目 http://ex..?page=2 变为 http://ex..?page=3,条目索引为2    
	
	history.back(); // 弹出 "location: http://example.com/example.html?page=1, state: {"page":1}"    
	history.back(); // 弹出 "location: http://example.com/example.html?page=1, state: {"page":1}" 
    history.back(); // 弹出 "location: http://example.com/example.html, state: null    
    history.go(19);  // 弹出 "location: http://example.com/example.html?page=3, state: {"page":3}   
  
  
  
function getQueryString(name) {  
      // 如果链接没有参数，或者链接中不存在我们要获取的参数，直接返回空  
      if (location.href.indexOf("?") == -1 || location.href.indexOf(name + '=') == -1) {  
	  window.location.href="http://www.59jiaju.com/manage/index.php/Home/Index/daohang";
        //return '';  
      }  
      // 获取链接中参数部分  
      var queryString = location.href.substring(location.href.indexOf("?") + 1);  
  
      // 分离参数对 ?key=value&key2=value2  
      var parameters = queryString.split("&");  
  
      var pos, paraName, paraValue;  
      for (var i = 0; i < parameters.length; i++) {  
        // 获取等号位置  
        pos = parameters[i].indexOf('=');  
        if (pos == -1) { continue; }  
  
        // 获取name 和 value  
        paraName = parameters[i].substring(0, pos);  
        paraValue = parameters[i].substring(pos + 1);  
  
        // 如果查询的name等于当前name，就返回当前值，同时，将链接中的+号还原成空格  
        if (paraName == name && paraValue) {  
          return decodeURI(paraValue.replace(/\+/g, " "));  
        }  
      }  
      return '';  
    }
		function goBack(){ 
			window.location.href="http://www.59jiaju.com/manage/index.php/Home/Index/daohang";
         } 
  //手机输入限制
  function ValidateNumber(e, pnumber){
      if (!/^\d+$/.test(pnumber)){
      $(e).val(/^1[\d]+/.exec($(e).val()));
      }else{
        $(e).val(/^1\d{0,10}/.exec($(e).val()));
        if($("#phone_mob").val().length>11){
          $(e).val(/^1\d{0,10}/.exec($(e).val()));
        }
      }
      return false;
    }
    //获取验证码
    function getveryfy(){
    var phonenum=$("#phone_mob").val();
        if(phonenum==""){
            alert("手机号不能为空");
          }else if(phonenum.length!=11){
            alert('请输入11位的手机号');
          }else{
              //判断手机是否已经注册
             $.ajax({
               type: "POST",
                url: "/manage/index.php/Home/Member/getveryfy",
                data: "phone_mob="+phonenum,
                success: function(msg){
                        if(msg=='ok'){
                            alert('已发送，请注意查收');
                        }
                     }
                }); 
            }    
          }
  //验证验证码
  function myveryfy(){
    var veryfy=$("#veryfy").val();
        if(veryfy==""){
            //alert("手机号不能为空");
          }else{
              //判断手机是否已经注册
             $.ajax({
               type: "POST",
                url: "/manage/index.php/Home/Member/veryfy",
                data: "veryfy="+veryfy,
                success: function(msg){
                        if(msg=='ok'){
                            $("#vf").val('ok'); 
                        }else{
                            $("#vf").val('err');
                        }
                     }
                }); 
            }    
          }
    //两次密码验证
    function checkpwd(){
        var p1=$("#p1").val();
        var p2=$("#p2").val();
        if(p1==""){
            alert("密码不能为空");
            $("#pck").val('err');
        }else if(p2==""){
            alert("密码不能为空");
            $("#pck").val('err');
        }else if(p1==p2){
            $("#pck").val('ok');
        }else{
            $("#pck").val('err');
            alert("两次密码不一致");
        }
    }
	//验证电子邮件格式
	function checkemail(){
		var email=$("#isemal").val();
		if(email==""){
			$('#em').val('err');
		}else{
			$.ajax({
               type: "POST",
                url: "/manage/index.php/Home/Member/isemal",
                data: "email="+email,
                success: function(msg){
                        if(msg=='ok'){
                            $('#em').val('ok');
                            //alert( $("#vf").val());
                        }else{
                            $('#em').val('err');
                        }
                     }
                }); 
		}
	}
	//验证用户名是否已经被占用
	function checkname(){
		var user_name=$("#user_name").val();
		//alert(user_name);
		if(user_name==""){
			$('#un').val('err');
		}else{
			$.ajax({
               type: "POST",
                url: "/manage/index.php/Home/Member/checkname",
                data: "user_name="+user_name,
                success: function(msg){
						//alert(msg);
                        if(msg=='ok'){
                            $('#un').val('ok');
                           // alert('ok');
                        }else{
							//alert('err');
                            $('#un').val('err');
                        }
                     }
                }); 
		}
	}
    //提交表单
    function tijao(){
       var phonenum=$("#phone_mob").val();
        if(phonenum==""){
            alert("手机号不能为空");
          }else if(phonenum.length!=11){
            alert('请输入11位的手机号');
          }else{
			$("#myregform").submit();
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
    <div class="aui-title">59家居行业装饰平台</div>
</header>
<form id="myregform" action="/manage/index.php/Home/Member/upuser" method="post">
<input type="hidden" name="data[user_id]" value="<?php echo ($info["user_id"]); ?>">
<div class="aui-content aui-margin-b-15" style="width:100%;max-width:100%;">
	 <ul class="aui-list aui-form-list" style="width:100%;max-width:100%;">
        <li class="aui-list-item" style="width:100%;max-width:100%;">
            <div class="aui-list-item-inner" style="width:100%;max-width:100%;">
                <div class="aui-list-item-input" style="width:100%;max-width:100%;">
                    <div style="display:inline;width:25%;max-width:25%;float:left;"><img style="width:100%;height:100%;" src="/manage/Public/jobs/img/uinfo.png"></div>
					<div style="display:inline;width:75%;max-width:75%;float:left;">
						<div style="display:inline;width:100%;">　姓名：<input type="text" name="data[user_name]" value="<?php echo ($info["user_name"]); ?>" style="width:40%;display:inline;"></div><br/>
						<div style="display:inline;width:100%;">　手机：<input id="phone_mob" type="text" name="data[phone_mob]" value="<?php echo ($info["phone_mob"]); ?>" style="width:40%;display:inline;" onkeyup="return ValidateNumber($(this),value)"></div><br/>
						<div style="display:inline;width:100%;">　职位：<input type="text" name="data[position]" value="<?php echo ($info["position"]); ?>" style="width:40%;display:inline;"></div>
					</div>
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <span><a href="/manage/index.php/Home/Member/getmsg" style="color:#212121;">|消息(1)</a></span>
                </div>
            </div>
        </li>
		<!--<li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <span>|推荐给朋友</span>
                </div>
            </div>
        </li>-->
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
					<textarea id="position_desc" name='data[position_desc]' placeholder="|职位描述"><?php echo ($info["position_desc"]); ?></textarea>
                </div>
            </div>
        </li>
		
     </ul>
</div>
</form>
<div class="aui-content-padded">
 	<p><div  class="aui-btn aui-btn-warning aui-btn-block" onclick="tijao()">确认保存</div></p>
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