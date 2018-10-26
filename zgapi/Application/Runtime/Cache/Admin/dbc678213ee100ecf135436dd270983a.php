<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<script type="text/javascript" src="lib/PIE_IE678.js"></script>
<![endif]-->
<link href="/manage/Public/admin/assets/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="/manage/Public/admin/assets/css/font-awesome.min.css" />
<link rel="stylesheet" href="/manage/Public/admin/assets/css/ace.min.css" />
<link rel="stylesheet" href="/manage/Public/admin/assets/css/ace-rtl.min.css" />
<link rel="stylesheet" href="/manage/Public/admin/assets/css/ace-skins.min.css" />
<link rel="stylesheet" href="/manage/Public/admin/assets/css/page.css" />
<script type="text/javascript" src="/manage/Public/admin/lib/jquery/1.9.1/jquery.js"></script> 
<script src="/manage/Public/admin/assets/js/ace-extra.min.js"></script>
<script type="text/javascript" src="/manage/Public/admin/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="/manage/Public/admin/lib/layer/2.1/layer.js"></script> 
<script type="text/javascript" src="/manage/Public/admin/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript" src="/manage/Public/admin/assets/js/My97DatePicker/WdatePicker.js"></script>
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>意见反馈</title>
</head>
<body>
<div class="main-container" id="main-container">
	<!--<script type="text/javascript">
		try{ace.settings.check('main-container' , 'fixed')}catch(e){}
	</script>-->

	<div class="main-container-inner">
		<div>
			<div class="breadcrumbs" id="breadcrumbs">
				<!--<script type="text/javascript">
					try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
				</script>-->
				<ul class="breadcrumb">
					<li>
						<!--<i class="icon-home home-icon"></i>-->
						首页 -》手机管理 -》
					</li>
					手机类型　　　　
					<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px;" href="javascript:location.replace(location.href);" title="刷新" >刷新</a>
				</ul>
			</div>
			<div class="page-content" >
				<div class="page-header" style="width:100%;height:45px;padding-top:12px;">
					<form action="/manage/index.php/Admin/Type/typelist" method="get" >
						号码类型：<input  type="text" name="typename" placeholder="号码类型" value="<?php echo ($_GET['typename']); ?>" />
								&nbsp;&nbsp;
						时间：
						<?php if(!empty($_GET['stime']) && !empty($_GET['etime'])){echo $_GET['stime'].' 至 '.$_GET['etime'];} ?>
						<input type="text"  onClick="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="stime"/>-至-<input type="text" onClick="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="etime"/>
						<button type="submit" class="btn btn-xs btn-primary">搜索</button>　　　<span style="background-color:#428BCA;font-size:17px;margin-bottom:0px;"><a href="javascript:;" style="color:#FFFFFF;" onclick="type_add('添加类型','/manage/index.php/Admin/Type/typeadd','800')">添加</a></span>
					</form>
				</div><!-- /.page-header -->
				<div class="row">
					<form action="<?php echo U('Admin/Type/typedel');?>" method="post" id="formids">
					<table id="sample-table-1" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th class="center">
									<label>
										<input type="checkbox"  />
										<!--<span class="lbl"></span>-->
									</label>
								</th>
								<th>号码类型id</th>
								<th>号码类型</th>
								<th>创建时间</th>
								<th>操作</th>
							</tr>
						</thead>

						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
								<td class="center" width="80px">
									<label>
										<input type="checkbox"  name="typeid[]" value="<?php echo ($v["typeid"]); ?>"/>
										<!--<span class="lbl"></span>-->
									</label>
								</td>

								<th><?php echo ($v["typeid"]); ?></th>
								<th><?php echo ($v["typename"]); ?></th>
								<th><?php echo (date("Y-m-d H:i:s",$v["addtime"])); ?></th>
								<td width="100px">
									<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
										<!-- <a class="green" href="<?php echo U('Admin/Console/menu_add',array('parentid'=>$v['menuid']));?>">
											<i class="icon-plus bigger-130"></i>
										</a> -->
											
										<a class="blue" onClick="type_edit('编辑','<?php echo U('Admin/Type/typeupdate',array('typeid'=>$v['typeid']));?>','800')" href="javascript:;">
											<!--<i class="icon-edit bigger-130"></i>-->编辑
										</a>

										<a class="red" onclick="return type_del('<?php echo U('Admin/Type/typedel',array('typeid'=>$v['typeid']));?>')" href="javascript:;">
											<!--<i class="icon-trash bigger-130"></i>-->删除
										</a>
									</div>
								</td>
							</tr><?php endforeach; endif; ?>
							<tr>
								<td colspan="2">
									<input type="button" value="删除" onclick="return type_delmall('<?php echo U('Admin/Type/typedel');?>')" style="background-color:#F70808;" />
								</td>
								<td colspan="7">
									<div class="dataTables_paginate paging_bootstrap page">
									<?php echo ($page); ?>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
/*类型-添加*/
function type_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*类型-编辑*/
function type_edit(title,url,w,h){
	layer_show(title,url,w,h);
}
/*类型-删除*/
function type_del(lujing){
	layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.ajax({
			url:lujing,
			type: "GET",
		dataType: "text",
		success: function(result){  
			if(result == 'ok'){
				layer.msg('删除成功!',{icon:1,time:1500});
			}
			if(result == 'err'){
				layer.msg('删除失败!',{icon:1,time:1500});
			}
			
			}
		});
	});
}
function type_delmall(lujing){
	$.ajax({
		cache: true,
		type: "POST",
		url:lujing,
		data:$("#formids").serialize(),// 你的formid
		async: false,
		  error: function(request) {
			  alert("Connection error");
		  },
		  success: function(data) {
			if(data == 'ok'){
				layer.msg('删除成功!',{icon:1,time:1500});
			}
			if(data == 'err'){
				layer.msg('删除失败!',{icon:1,time:1500});
			}
		  
		  }
	  });
}
</script>
</body>
</html>