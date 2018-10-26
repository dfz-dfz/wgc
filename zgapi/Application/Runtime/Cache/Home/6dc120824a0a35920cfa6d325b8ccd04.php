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
            //提交表单
    function tijiao(){
			$("#myregform").submit();	
    }
  //手机输入限制
  function ValidateNumber(e, pnumber){
          if (!/^\d+$/.test(pnumber)){
          $(e).val(/^[0-9][\d]+/.exec($(e).val()));
          }else{
            $(e).val(/^[0-9]\d{0,1}/.exec($(e).val()));
            if($(e).val().length>2){
              $(e).val(/^1\d{0,1}/.exec($(e).val()));
            }
            if($(e).val()>10){
            	$(e).val(10);
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
                url: "/manage/jingyi.php/Home/View/getveryfy",
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
                url: "/manage/jingyi.php/Home/View/veryfy",
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
        if(p1==""){
            alert("密码不能为空");
            $("#pck").val('err');
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
                url: "/manage/jingyi.php/Home/View/isemal",
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
                url: "/manage/jingyi.php/Home/View/checkname",
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
                url: "/manage/jingyi.php/Home/View/checktel",
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
 
</script>
</head>
<body>
<header class="aui-bar aui-bar-nav" style="background-color:#C25423;">
    <a class="aui-pull-left aui-btn"  onclick="goBack()">
        <span class="aui-iconfont aui-icon-left"></span>
    </a>
    <div class="aui-title">评价</div>
</header>
<form id="myregform" action="/manage/jingyi.php/Home/View/view" method="post">
<input type="hidden" name="data[sid]" value="<?php echo ($sid); ?>">
<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-form-list">
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                    态度：
                </div>
                <div class="aui-list-item-input">
                    <input type="number" name="data[taidu]" value='1' placeholder="态度分" min="1" max="10" onkeyup="return ValidateNumber($(this),value)">
                </div>
            </div>
        </li>
         <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                    工艺分：
                </div>
                <div class="aui-list-item-input">
                    <input type="number" name="data[shougong]" value='1' placeholder="工艺分" min="1" max="10" onkeyup="return ValidateNumber($(this),value)">
                </div>
            </div>
        </li>
         <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                    时效分:
                </div>
                <div class="aui-list-item-input">
                    <input type="number" name="data[shixiao]" value='1' placeholder="时效分" min="1" max="10" onkeyup="return ValidateNumber($(this),value)">
                </div>
            </div>
        </li>
         <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                    质量分：
                </div>
                <div class="aui-list-item-input">
                    <input type="number" name='data[zhiliang]' value='1' placeholder="质量分" min="1" max="10" onkeyup="return ValidateNumber($(this),value)">
                </div>
            </div>
        </li>
     
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                    评论内容：
                </div>
                <div class="aui-list-item-input">
                    <textarea name="data[content]" placeholder="评论内容"></textarea>
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                    施工前效果：
                </div>
                <div class="aui-list-item-input">
                    <textarea name="data[dobefore]" placeholder="评论前效果"></textarea>
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                    施工后效果：
                </div>
                <div class="aui-list-item-input">
                    <textarea name="data[doafter]" placeholder="评论后效果"></textarea>
                </div>
            </div>
        </li>
        <li class="aui-list-item">
            <div class="aui-list-item-inner aui-list-item-center aui-list-item-btn">
                <div class="aui-btn aui-btn-info aui-margin-r-5" onclick="tijiao()">提交</div>
                <div class="aui-btn aui-btn-danger aui-margin-l-5" onclick="goBack()">取消</div>
            </div>
        </li>
    </ul>
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