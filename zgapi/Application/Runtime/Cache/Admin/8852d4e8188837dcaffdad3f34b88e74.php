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

<title>新建网站角色 - 管理员管理 - H-ui.admin v2.3</title>
<meta name="keywords" content="H-ui.admin v2.3,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v2.3，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container">
	<form action="/index.php/Admin/Mobile/mobileupdate" method="post" class="form form-horizontal" id="form-mobe-up">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>号码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($mobeinfo["mobe"]); ?>" placeholder="号码" id="mobe" name="mobe" datatype="*4-16" nullmsg="号码不能为空">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>昵称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo ($mobeinfo["name"]); ?>" placeholder="昵称" id="name" name="name" datatype="*4-16" nullmsg="昵称不能为空">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>号码类型：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<!--<input type="text" class="input-text" value="<?php echo ($mobeinfo["typeid"]); ?>" placeholder="号码类型" id="typeid" name="typeid" datatype="*4-16" nullmsg="号码类型不能为空">-->
				<select name="typeid">
					<option value ="1">默认值</option>
					<?php if(is_array($types)): foreach($types as $key=>$type): ?><option value ="<?php echo ($type["typeid"]); ?>" <?php if($type["typeid"] == $mobeinfo["typeid"] ): ?>selected = "selected"<?php else: endif; ?> ><?php echo ($type["typename"]); ?></option><?php endforeach; endif; ?>
				</select>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>区域：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<!--<input type="text" class="input-text" value="<?php echo ($mobeinfo["area"]); ?>" placeholder="区域" id="area" name="area" datatype="*4-16" nullmsg="区域不能为空">-->
				<select id="selProvince"  name="province">  
				</select> -
				<select id="selCity"  name="city">  
				</select> -
				 <select id="selDist" name="area">  
				</select><span>当前区域：<?php echo ($mobeinfo["area"]); ?></span>
			</div>
		</div>
		<input type="hidden" name="mobeid" value="<?php echo ($mobeid); ?>" />
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<button type="submit" class="btn btn-success radius" onclick="return tijiao()"><i class="icon-ok"></i> 编辑</button>
			</div>
			<!--<input type="submit" value="确定" onclick="return tijiao()">-->
			
		</div>
	</form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/admin/lib/layer/2.1/layer.js"></script> 
<script type="text/javascript" src="/Public/admin/lib/icheck/jquery.icheck.min.js"></script> 
<script type="text/javascript" src="/Public/quyu/js/region.js"></script>
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
		url:"/index.php/Admin/Mobile/mobileupdate",
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