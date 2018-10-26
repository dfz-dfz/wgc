<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>59家居网</title>
    <link rel="stylesheet" type="text/css" href="/zgapi/Public/jobs/css/aui.2.0.css" />
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
                url: "/zgapi/jingyi.php/Home/Member/getveryfy",
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
  function myveryfy(e, pnumber){
    var veryfy=$(e).val();
              //判断手机是否已经注册
             $.ajax({
               type: "POST",
                url: "/zgapi/jingyi.php/Home/Member/veryfy",
                data: "veryfy="+veryfy,
                success: function(msg){
						//alert(msg);
                        if(msg=='ok'){
                            $("#vf").val('ok');
                        }else{
                            $("#vf").val('err');
                        }
                     }
                });    
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
                url: "/zgapi/jingyi.php/Home/Member/isemal",
                data: "email="+email,
                success: function(msg){
                        if(msg=='ok'){
							//alert('ok');
                            $('#em').val('ok');
                            //alert( $("#vf").val());
                        }else{
							//alert('err');
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
                url: "/zgapi/jingyi.php/Home/Member/checkname",
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
	//验证手机号码是否已经注册
	function checktel(){
		var phone_mob=$("#phone_mob").val();
		//alert(user_name);
		if(phone_mob==""){
			$('#pm').val('err');
		}else{
			$.ajax({
               type: "POST",
                url: "/zgapi/jingyi.php/Home/Member/checktel",
                data: "phone_mob="+phone_mob,
                success: function(msg){
						//alert(msg);
                        if(msg=='ok'){
                            $('#pm').val('ok');
                           //alert('ok');
                        }else{
							//alert('err');
                            $('#pm').val('err');
                        }
                     }
                }); 
		}
	}
     //提交表单
    function tijao(){
        var vf=$("#vf").val();
		var pm=$('#pm').val();
		var phone_mob=$('#phone_mob').val();
        if(phone_mob==""){
			alert("手机必填");
		}else if(phone_mob.length!=11){
            alert('请输入11位的手机号');
         }else if(pm=='err'){
			alert('手机号已经注册,请登录');
		}else if(vf=='err'){
            alert('验证码错误');
        }else{
			//提交表单注册信息
			$.ajax({
				cache: true,
				type: "POST",
				url:"/zgapi/jingyi.php/Home/Zhaojob/register",
				data:$("#myregform").serialize(),// 你的formid
				async: false,
				  error: function(request) {
					  alert("Connection error");
				  },
				  success: function(data) {
					//$("#commonLayout_appcreshi").parent().html(data);
					if(data=="regerr"){
						alert('注册失败');
					}else{
						//alert(data);
						window.location.href="/zgapi/jingyi.php/Home/Zhaojob/register/step/1/user_id/"+data; 
					}
				   //alert(data);
				  }
			  });
			//$("#myregform").submit();
		}
    }
</script>
<style type="text/css">
.aui-content-padded p{width:80%;max-width:80%;margin-left:auto;margin-right: auto;margin-bottom: 10px;background-color: #FE7113;}
</style>
</head>
<body>
<header class="aui-bar aui-bar-nav" style="background-color:#3BB3C3;">
    <a class="aui-pull-left aui-btn" onclick="goBack()">
        <span class="aui-iconfont aui-icon-left"></span>
    </a>
    <span style="color:#FFFFFF;float:left;" ><a onclick="goBack()" href="javascript:;"><span id='s_city'>返回</span></a></span>
    <div class="aui-title" ><span style="float:right;"><a href="/zgapi/jingyi.php/Home/Zhaojob/login">登录</a><span></div>
</header>
<div style="width:100%;max-width:100%;">
  <img width="100%" src="/zgapi/Public/jobs/img/reglogo.png">
</div>
<input type="hidden" id='vf' value="err">
<input type="hidden" id='pck' value="err">
<input type="hidden" id='pm' value="err">
<input type="hidden" id='un' value="err">
<form id='myregform' action="/zgapi/jingyi.php/Home/Zhaojob/register" method="post">
<?php if(($tuijian_id != '') or ($tuijian_id != null) ): ?><input type="hidden" name="data[tuijian_id]" value="<?php echo ($tuijian_id); ?>">
<input type="hidden" name="data[p_id]" value="<?php echo ($p_id); ?>">
<?php else: ?>
<div>.</div><?php endif; ?>
<input type="hidden" name="flag" value="reg">
<input type='hidden' name="data[types]" value='1'>
<div class="aui-content aui-margin-b-15">
     <ul class="aui-list aui-form-list">
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <input id='phone_mob' name='data[phone_mob]' type="text" placeholder="|请输入手机号码" onkeyup="return ValidateNumber($(this),value)" onblur="checktel()">
                </div>
            </div>
        </li>
        
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <input id="veryfy" name='veryfy' type="text" placeholder="|验证码" onkeyup="myveryfy($(this),value)">
                </div>
                <p style="margin:10px;"><div class="aui-btn aui-btn-info" onclick="getveryfy()">获取验证码</div></p>
            </div>
        </li>
     </ul>
</div>
</form>
<div class="aui-content-padded">
    <p><div class="aui-btn aui-btn-primary aui-btn-block" onclick="tijao()">下一步</div></p>
</div>
<div style="width:100%;max-width:100%;">
<img src="/zgapi/Public/jobs/img/regfoot.png" style="width:100%;" />
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