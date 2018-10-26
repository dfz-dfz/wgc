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
    //提交表单
    function tijao(){
        var vf=$("#vf").val();
		var p1=$('#p1').val();
		var phone_mob=$('#phone_mob').val();
       if(phone_mob==""){
            alert("手机号不能为空");
          }else if(phone_mob.length!=11){
            alert('请输入11位的手机号');
          }else if(p1==""){
			alert('密码必填');
		}else if(vf=='err'){
            alert('验证码错误');
        }else{
			$("#myregform").submit();
		}
    }
</script>
</head>
<body>
<header class="aui-bar aui-bar-nav" style="background-color:#C25423;">
    <a class="aui-pull-left aui-btn"  onclick="goBack()">
        <span class="aui-iconfont aui-icon-left"></span>
    </a>
    <div class="aui-title">我的评价</div>
</header>
<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-list-in">
		<?php if(is_array($pjs)): foreach($pjs as $key=>$pj): ?><li class="aui-list-item">
				<div class="aui-list-item-inner">
					<div class="aui-list-item-title">
						<span>
							<span style="font-size:30px;"><a href="/manage/jingyi.php/Home/View/viewinfo/v_id/<?php echo ($pj["v_id"]); ?>"><?php echo ($pj["title"]); ?></a></span><br/>
						</span>
						<p><img style="width:100%;" src="/manage/Public/jobs/img/xxpj.png"></p>
						<span>地址：<?php echo ($pj["s_province"]); echo ($pj["s_city"]); echo ($pj["s_county"]); echo ($pj["xiangxi"]); ?></span>
						<span style="float:right;margin-bottom:5px;">综合评价</span>
					</div>
				</div>
			</li>
			<li class="aui-list-item">
				<div class="aui-list-item-inner">
					<div class="aui-list-item-title">
						<p><span style="color:#C7C7C7;">填写评价可以获得10积分</span></p>
					</div>
				</div>
			</li>
			<li class="aui-list-item">
				<div class="aui-list-item-inner">
					<div class="aui-list-item-title">
						<p>服务态度：
							<?php $__FOR_START_10576__=1;$__FOR_END_10576__=$pj['taidu']+1;for($i=$__FOR_START_10576__;$i < $__FOR_END_10576__;$i+=1){ switch($i): case "1": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>   
									<?php case "2": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?> 
									<?php case "3": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "4": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php case "5": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "6": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php case "7": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "8": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php case "9": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "10": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php default: ?>
									default<?php endswitch; } ?>
							<?php $__FOR_START_26634__=$pj['taidu']+1;$__FOR_END_26634__=11;for($i=$__FOR_START_26634__;$i < $__FOR_END_26634__;$i+=1){ switch($i): case "1": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>   
									<?php case "2": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?> 
									<?php case "3": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "4": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php case "5": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "6": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php case "7": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "8": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php case "9": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "10": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php default: ?>
									default<?php endswitch; } ?>
						</p>
						<p>手工工艺：
							<?php $__FOR_START_27566__=1;$__FOR_END_27566__=$pj['shougong']+1;for($i=$__FOR_START_27566__;$i < $__FOR_END_27566__;$i+=1){ switch($i): case "1": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>   
									<?php case "2": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?> 
									<?php case "3": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "4": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php case "5": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "6": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php case "7": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "8": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php case "9": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "10": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php default: ?>
									default<?php endswitch; } ?>
							<?php $__FOR_START_2232__=$pj['shougong']+1;$__FOR_END_2232__=11;for($i=$__FOR_START_2232__;$i < $__FOR_END_2232__;$i+=1){ switch($i): case "1": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>   
									<?php case "2": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?> 
									<?php case "3": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "4": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php case "5": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "6": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php case "7": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "8": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php case "9": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "10": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php default: ?>
									default<?php endswitch; } ?>
						</p>
						<p>维修时效：
							<?php $__FOR_START_17255__=1;$__FOR_END_17255__=$pj['shixiao']+1;for($i=$__FOR_START_17255__;$i < $__FOR_END_17255__;$i+=1){ switch($i): case "1": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>   
									<?php case "2": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?> 
									<?php case "3": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "4": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php case "5": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "6": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php case "7": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "8": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php case "9": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "10": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php default: ?>
									default<?php endswitch; } ?>
							<?php $__FOR_START_230__=$pj['shixiao']+1;$__FOR_END_230__=11;for($i=$__FOR_START_230__;$i < $__FOR_END_230__;$i+=1){ switch($i): case "1": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>   
									<?php case "2": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?> 
									<?php case "3": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "4": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php case "5": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "6": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php case "7": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "8": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php case "9": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "10": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php default: ?>
									default<?php endswitch; } ?>
						</p>
						<p>维修质量：
							<?php $__FOR_START_22261__=1;$__FOR_END_22261__=$pj['zhiliang']+1;for($i=$__FOR_START_22261__;$i < $__FOR_END_22261__;$i+=1){ switch($i): case "1": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>   
									<?php case "2": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?> 
									<?php case "3": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "4": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php case "5": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "6": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php case "7": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "8": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php case "9": ?><img src="/manage/Public/jobs/img/rank_1.gif"><?php break;?>  
									<?php case "10": ?><img src="/manage/Public/jobs/img/rank_2.gif"><?php break;?>  
									<?php default: ?>
									&nbsp;<?php endswitch; } ?>
							<?php $__FOR_START_25493__=$pj['zhiliang']+1;$__FOR_END_25493__=11;for($i=$__FOR_START_25493__;$i < $__FOR_END_25493__;$i+=1){ switch($i): case "1": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>   
									<?php case "2": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?> 
									<?php case "3": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "4": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php case "5": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "6": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php case "7": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "8": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php case "9": ?><img src="/manage/Public/jobs/img/rank_3.gif"><?php break;?>  
									<?php case "10": ?><img src="/manage/Public/jobs/img/rank_4.gif"><?php break;?>  
									<?php default: ?>
									&nbsp;<?php endswitch; } ?>
						</p>
					</div>
				</div>
			</li>
			<li class="aui-list-item">
				<div class="aui-list-item-inner">
					<div class="aui-list-item-title">
						<p><span style="color:#C7C7C7;">分享维修前后:</span></p>
						<p><span><?php echo ($pj["content"]); ?></span></p>
						<div style="width:50%;display:inline;float:left;text-align:center;">
							<?php echo ($pj["dobefore"]); ?><br/>
							<span style="color:#C7C7C7;">维修前</span>
						</div>
						<div style="width:50%;display:inline;float:left;text-align:center;">
							<?php echo ($pj["doafter"]); ?><br/>
							<span style="color:#C7C7C7;">维修后</span>
						</div>
					</div>
				</div>
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