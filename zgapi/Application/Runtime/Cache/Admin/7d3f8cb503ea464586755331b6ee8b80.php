<?php if (!defined('THINK_PATH')) exit();?><!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<LINK rel="Bookmark" href="/manage/Public/admin//favicon.ico" >
<LINK rel="Shortcut Icon" href="/manage/Public/admin//favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/manage/Public/admin/lib/html5.js"></script>
<script type="text/javascript" src="/manage/Public/admin/lib/respond.min.js"></script>
<script type="text/javascript" src="/manage/Public/admin/lib/PIE_IE678.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/manage/Public/admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/manage/Public/admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/manage/Public/admin/lib/Hui-iconfont/1.0.7/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/manage/Public/admin/lib/icheck/icheck.css" />
<link rel="stylesheet" type="text/css" href="/manage/Public/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/manage/Public/admin/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->

<title>新建网站角色 - 管理员管理 - H-ui.admin v2.3</title>
<meta name="keywords" content="H-ui.admin v2.3,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v2.3，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<link type="text/css" href="http://59jiaju.com/themes/mall/jiaju/styles/default/css/css/style.css" rel="stylesheet"  />
<link type="text/css" href="http://59jiaju.com/themes/mall/jiaju/styles/default/css/css/demo.css" rel="stylesheet"  />
<script type="text/javascript" src="http://59jiaju.com/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="http://59jiaju.com/ueditor/ueditor.all.js"></script>
<script type="text/javascript" src="/manage/Public/admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/manage/Public/admin/lib/icheck/jquery.icheck.min.js"></script> 
<script type="text/javascript" src="/manage/Public/admin/lib/layer/2.1/layer.js"></script> 
<script type="text/javascript">
    var editor = new UE.ui.Editor();
    editor.render("myEditor");
    //1.2.4以后可以使用一下代码实例化编辑器
    //UE.getEditor('myEditor')	
    var rok=$("#uk").val();
    if(rok == 'ok'){
    	layer.msg('更新成功!',{icon:1,time:1500});
    }
    if(rok == 'err'){
    	layer.msg('更新失败!',{icon:1,time:1500});
    }
</script>
<script type="text/JavaScript">
       function gradeChange(){
			var deal=$("#deal").val();
			if(deal==2){
				$("#xinzi").val('0.00');
				$("#xinzi").attr("readOnly","true");
				$("#num").removeAttr("readOnly");
			}else if(deal==1){
				$("#num").val('0.00');
				$("#num").attr("readOnly","true");
				$("#xinzi").removeAttr("readOnly");
			}else{
				$("#xinzi").val('');
				$("#num").val('');
				$("#xinzi").removeAttr("readOnly");
				$("#num").removeAttr("readOnly");
			}
       }
	   function gradeChange2(){
			var jobtypeid=$("#jobtype").val();
				$.ajax({
					url:"http://59jiaju.com/index.php?app=member&act=ajax_type&jobtype_id="+jobtypeid,
						type: "GET",
					dataType: "json",
					success: function(result){  
							//alert(result);
							var str="";
							var dataArray=eval(result);
							//alert(dataArray);
							for(var i in dataArray)
							{
								 //alert(dataArray[i]['bill_name']);
								str=str+dataArray[i]['bill_name']+', ';
							} 
							$("#jobs").val(str);
						}
					});
			
       }
</script>
<input type="hidden" id="uk" value="<?php echo ($upok); ?>" />
<article class="page-container">
	<div class="fubu_wrap">
            <p class="fu_text">招聘修改</p>
            <form action="/manage/index.php/Admin/Search/searchupdate" method="post">
				<input type="hidden" value="<?php echo ($list["id"]); ?>" name="id">
                <table>
                    <tbody>
						
						<tr>
                            <td class='w100'><span>*</span>标题：</td>
                            <td class='w600'>
                                <input style="border:1px solid #666666" value="<?php echo ($list["title"]); ?>" type="text" class="w400" name="title">
                            </td>
                        </tr>
						
						<tr>
                            <td class='w100'><span>*</span>招聘性质：</td>
                            <td class='w600'>
								<select id="deal" name="deal" onchange="gradeChange()">
								  <option value ="0">招工</option>
								  <option value="2">招标</option>
								</select>
								<!--<option value ="1">找工</option>-->
                            </td>
                        </tr>
						
						<!--<tr>
                            <td class='w100'><span>*</span>公司身份：</td>
                            <td class='w600'>
								
                                <label><input style="border:1px solid #666666" name="company" checked="checked"  type="radio" value="公司直招" />公司直招 </label> 
                                <label><input style="border:1px solid #666666" name="company" type="radio" value="职业代招" />职业代招<i>（职业招聘或者是劳务公司）</i> </label> 
                            </td>
                        </tr>-->
						
						<tr>
                            <td class='w100'><span>*</span>公司名称：</td>
                            <td class='w600'>
                                <input style="border:1px solid #666666" value="<?php echo ($list["gname"]); ?>" type="text" class="w400" name="gname">
                            </td>
                        </tr>
						
						
						
                        <tr>
                            <td class='w100'><span>*</span>工种：</td>
                            <td class='w600'>
								<!--<select name="jobtype">
								  <option value ="0">泥水工</option>
								  <option value ="1">木工</option>
								  <option value="2">水电工</option>
								  <option value="3">抹灰工</option>
								  <option value="4">装修工</option>
								  <option value="5">电焊工</option>  onchange="gradeChange2()"
								</select>-->
								<select id="jobtype" name="jobtype" >
									<option value ="0">请选择工种</option>
									<?php if(is_array($types)): foreach($types as $key=>$type): ?><option value ="<?php echo ($type["jobtype_id"]); ?>"><?php echo ($type["jobtype_name"]); ?></option><br><?php endforeach; endif; ?>
								</select>
                            </td>
                        </tr>
						
						<tr>
                            <td class='w100'><span>*</span>需要人数：</td>
                            <td class='w600'>
                                <input style="border:1px solid #666666" value="<?php echo ($list["renshu"]); ?>" placeholder="预计需要人数" type="text"  name="renshu">人　&nbsp;完成周期：<input style="border:1px solid #666666" value="<?php echo ($list["livetime"]); ?>" placeholder="预计完成时间" type="text"  name="livetime">天
                            </td>
                        </tr>
						
						<tr>
                            <td class='w100'><span>*</span>项目清单：</td>
                            <td class='w600'>
								<textarea id="jobs" name="jobs" rows="10" cols="80" placeholder="项目清单："><?php echo ($list["jobs"]); ?></textarea>
                            </td>
                        </tr>
						
						<tr>
                            <td class='w100'><span>*</span>数量：</td>
                            <td class='w600'>
								<input type="text" id="num" name="num" value="<?php echo ($list["num"]); ?>" placeholder="数量" />　&nbsp;单位:<input type="text" name="unit"  placeholder="㎡/平方米..." value="<?php echo ($list["unit"]); ?>" />
                            </td>
                        </tr>
						

                        <tr>
                            <td class='w100'><span>*</span>单价：</td>
                            <td class='w600'>
                                <input id="xinzi" style="border:1px solid #666666" value="<?php echo ($list["xinzi"]); ?>" type="text" name="xinzi" class="w200"  />
                            </td>
                        </tr>
                        
                        <!--<tr>
                            <td class='w100'><span>*</span>联系人：</td>
                            <td class='w600'>
                                <input style="border:1px solid #666666" value="<?php echo ($list["lianxiren"]); ?>" type="text" name="lianxiren" class="w200">
                            </td>
                        </tr>-->
						<input type="hidden" name="lianxiren" value="59家居" />
                        <tr>
                            <td class='w100'><span>*</span>客服电话：</td>
                            <td class='w600'>
                               <div class="w600 fu_ipone"><input style="border:1px solid #666666" value="18922273466" readOnly='true' name="dianhua" type="text" class="w200"></div>
                                
                            </td>
                        </tr>
						<input type="hidden" name="email" value="59jiaju@qq.com" />
                        <!--<tr>
                            <td class='w100'><span>*</span>邮箱：</td>
                            <td class='w600'>
                                <input style="border:1px solid #666666"value="<?php echo ($list["email"]); ?>" type="text" name="email" class="w400">
                            </td>
                        </tr>-->
                        

                        <tr>
                            <td class='w100'><span>*</span>地址：</td>
                            <td class='w600'>
                                <select id="s_province" name="s_province"style="border:1px solid #666666"></select>  
                                <select id="s_city" name="s_city"style="border:1px solid #666666" ></select>  
                                <select id="s_county" name="s_county"style="border:1px solid #666666"></select>
                                <script class="resources library" src="/themes/mall/jiaju/styles/default/js/area.js" type="text/javascript"></script>
                        
                                <script type="text/javascript">_init_area();</script> 
                            </td>
                        </tr>

                        <tr>
                            <td class='w100'><span>*</span>详细地址：</td>
                            <td class='w600'>
                                <input style="border:1px solid #666666" value="<?php echo ($list["xiangxi"]); ?>" type="text" name="xiangxi" class="w400">
                            </td>
                        </tr>

                     <tr>
                            <td class='w100'><span>*</span>工艺说明：</td>
                            <td class='w600'>
                                <textarea style="border:1px solid #666666" name="content" id="myEditor"><?php echo ($list["content"]); ?></textarea>
                            </td>
                        </tr>
						
						<!--<tr>
                            <td class='w100'><span>*</span>工艺说明：</td>
                            <td class='w600'>
								<textarea name="content" rows="10" cols="80"  placeholder="说明"><?php echo ($list["content"]); ?></textarea>
                            </td>
                        </tr>-->
                                    
                </table>
				<input type="hidden" name="id" value="<?php echo ($id); ?>" />
                <div class=""><input type="submit" class="save_btn_fabu"></div>         
            </form>
        </div>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/manage/Public/admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/manage/Public/admin/lib/layer/2.1/layer.js"></script> 
<script type="text/javascript" src="/manage/Public/admin/lib/icheck/jquery.icheck.min.js"></script> 
<script type="text/javascript" src="/manage/Public/quyu/js/region.js"></script>
<script type="text/javascript" src="/manage/Public/admin/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="/manage/Public/admin/static/h-ui.admin/js/H-ui.admin.js"></script> 
<!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
function te(res){
alert(res);
}
function tijiao(){
		$.ajax({
		cache: true,
		type: "POST",
		url:"/manage/index.php/Admin/Search/mobileupdate",
		data:$("#form-mobe-up").serialize(),// 你的formid
		async: false,
		  error: function(request) {
			  alert("Connection error");
		  },
		  success: function(data) {
			if(data == 'ok'){
			//alert("更新成功");
			layer.msg('更新成功!',{icon:1,time:1500});
			}
			if(data == 'err'){
			//alert("更新失败");
			layer.msg('更新失败!',{icon:1,time:1500});
			}
			if(data == 'no'){
			//alert("手机号不能为空，请输入！");
			layer.msg('手机号不能为空，请输入！',{icon:1,time:1500});
			}
			if(data == 'has'){
			//alert('手机号已经存在请重新输入！');
			layer.msg('手机号已经存',{icon:1,time:1500});
			}
		  }
	  });
		return false;
	}
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>