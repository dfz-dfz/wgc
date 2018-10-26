<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>工人求职信息填写</title>
    <link rel="stylesheet" type="text/css" href="/manage/Public/jobs/css/aui.2.0.css" />
    
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
                url: "/manage/jingyi.php/Home/Jymember/getveryfy",
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
                url: "/manage/jingyi.php/Home/Jymember/veryfy",
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
                url: "/manage/jingyi.php/Home/Jymember/isemal",
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
		var unname=$("#unname").val();
		//alert(user_name);
		if(user_name==""){
			$('#un').val('err');
		}else{
			$.ajax({
               type: "POST",
                url: "/manage/jingyi.php/Home/Jymember/checkname",
                data: "user_name="+user_name,
                success: function(msg){
						//alert(msg);
                        if(msg=='ok'){
                            $('#un').val('ok');
                            //alert('ok');
                        }else{
							//alert('err');
							if(unname==user_name){
								//alert('ok');
								  $('#un').val('ok');
							}else{
								 $('#un').val('err');
							}
                           
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
                url: "/manage/jingyi.php/Home/Jymember/checktel",
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
		var phone=$("#phone").val();
		if(phone_mob==phone){
			 $('#pm').val('ok');
		}
	}
     //提交表单
    function tijao(){
		var un=$('#un').val();
		//alert(un);
		var user_name=$("#user_name").val();
		var phone_mob=$("#phone_mob").val();
        if(user_name==""){
			alert("用户名必填");
		}else if(un=='err'){
			alert('用户名已存');
		}else if(phone_mob==""){
			alert('手机号必填');
		}else if(phone_mob.length!=11){
			alert('请输入11位的手机号');
		}else{
			//$("#myregform").submit();
			//ajax 提交表单  $("#myregform").submit();
			$.ajax({
				cache: true,
				type: "POST",
				url:"/manage/jingyi.php/Home/Jymember/qiuzhi",
				data:$("#myregform").serialize(),// 你的formid
				async: false,
				  error: function(request) {
					  alert("Connection error");
				  },
				  success: function(data) {
					//$("#commonLayout_appcreshi").parent().html(data);
					if(data=="uperr"){
						alert('更新失败');
					}else{
						//alert(data);
						var user_id=$("#user_id").val();
						//alert(user_id);
						window.location.href="/manage/jingyi.php/Home/Jymember/userinfo/user_id/"+user_id; 
					}
				   //alert(data);
				  }
			  });
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
    
</header>
<input type="hidden" id='vf' value="err">
<input type="hidden" id='pck' value="err">
<input type="hidden" id='pm' value="ok">
<input type="hidden" id='un' value="ok">
<input type="hidden" id='phone' value="<?php echo ($info["phone_mob"]); ?>">
<input type="hidden" id='unname' value="<?php echo ($info["user_name"]); ?>">
<form id='myregform' action="/manage/jingyi.php/Home/Jymember/upuinfo" method="post">
<input type='hidden' id="user_id" name="data[user_id]" value='<?php echo ($info["user_id"]); ?>'>
<div class="aui-content aui-margin-b-15">
     <ul class="aui-list aui-form-list">
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <input id="user_name" name='data[user_name]' value="<?php echo ($info["user_name"]); ?>" type="text" placeholder="|姓名" onblur="checkname()">
                </div>
            </div>
        </li>
		<li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <!--<input id="position" name='data[position]' type="text" placeholder="|职位" >-->
					<span style="color:#A9A9A9;">性别：</span>
					<input type="radio" value="0" name="data[gender]" checked="checked">男
					<input type="radio" value="1" name="data[gender]">女
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <input id="phone_mob" name='data[phone_mob]' value="<?php echo ($info["phone_mob"]); ?>" type="text" placeholder="|手机" onkeyup="return ValidateNumber($(this),value)" onblur="checktel()">
                </div>
            </div>
        </li>
		 <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <input id="age" name='data[age]' type="text" placeholder="|年龄" value="<?php echo ($info["age"]); ?>">
                </div>
            </div>
        </li>
		<li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <input id="huji" name='data[huji]' type="text" placeholder="|户籍" value="<?php echo ($info["huji"]); ?>">
                </div>
            </div>
        </li>
		<li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <input id="id_card" name='data[id_card]' type="text" placeholder="|身份证号" value="<?php echo ($info["id_card"]); ?>">
                </div>
            </div>
        </li>
		<li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
					工种：
					<select name='data[jobtype]' style="display:inline;width:30%;max-width:30%;">
					  <option value ="1" selected="selected">泥水工</option>
					  <option value ="3">电焊工</option>
					  <option value="4">扇灰工</option>
					  <option value="5">木工</option>
					  <option value="13">水电工</option>
					  <option value ="14">杂工</option>
					</select>
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <textarea id="job_exp" name='data[job_exp]' placeholder="|工作经验" ><?php echo ($info["job_exp"]); ?></textarea>
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <textarea id="job_live" name='data[job_live]' placeholder="|工作经历" ><?php echo ($info["job_live"]); ?></textarea>
                </div>
            </div>
        </li>
     </ul>
</div>
</form>
<div class="aui-content-padded">
    <p><div class="aui-btn aui-btn-primary aui-btn-block" onclick="tijao()">确认发布</div></p>
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