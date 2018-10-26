<?php if (!defined('THINK_PATH')) exit();?><!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<LINK rel="Bookmark" href="/Public/admin//favicon.ico" >
<LINK rel="Shortcut Icon" href="/Public/admin//favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/admin/lib/html5.js"></script>
<script type="text/javascript" src="/Public/admin/lib/respond.min.js"></script>
<script type="text/javascript" src="/Public/admin/lib/PIE_IE678.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/Public/admin/lib/Hui-iconfont/1.0.7/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/Public/admin/lib/icheck/icheck.css" />
<link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->

<title>短信发送</title>
<meta name="keywords" content="短信发送">
<meta name="description" content="短信发送">
</head>
<body>
<article class="page-container">
	<form action="/index.php/Admin/Content/contentadd" method="post" class="form form-horizontal" id="form-content-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>接收号码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="号码间用英文逗号(,)隔开" id="receive_num" name="receive_num" datatype="*4-16" nullmsg="号码不能为空">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>短信内容：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<!--<input type="text" class="input-text" placeholder="短信内容" id="content" name="content" datatype="*4-16" nullmsg="短信内容不能为空">-->
				<textarea  class="input-text" rows="17" cols="150" placeholder="短信内容" id="content" name="content" datatype="*4-16" nullmsg="短信内容不能为空"></textarea>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<button type="submit" class="btn btn-success radius" onclick="return tijiao()"><i class="icon-ok"></i> 发送</button>
			</div>
			<!--<input type="submit" value="确定" onclick="return tijiao()">-->
			
		</div>
	</form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/admin/lib/layer/2.1/layer.js"></script> 
<script type="text/javascript" src="/Public/admin/lib/icheck/jquery.icheck.min.js"></script> 
 
<script type="text/javascript" src="/Public/admin/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/admin/static/h-ui.admin/js/H-ui.admin.js"></script> 
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
		url:"/index.php/Admin/Content/contentadd",
		data:$("#form-content-add").serialize(),// 你的formid
		async: false,
		  error: function(request) {
			  alert("Connection error");
		  },
		  success: function(data) {
			if(data == 'ok'){
			//alert("添加成功");
			layer.msg('发送成功',{icon:1,time:1500});
			}
			if(data == 'err'){
			//alert("添加成功");
			layer.msg('发送失败',{icon:1,time:1500});
			}
			if(data == 'nc'){
			//alert("添加失败");
			layer.msg('短信内容不能为空',{icon:1,time:1500});
			}
			if(data == 'np'){
			//alert("手机号不能为空，请输入！");
			layer.msg('手机号不能为空',{icon:1,time:1500});
			}
			if(data == 'no'){
			//alert('输入不能为空');
			layer.msg('输入不能为空',{icon:1,time:1500});
			}
		  }
	  });
		return false;
	}
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>