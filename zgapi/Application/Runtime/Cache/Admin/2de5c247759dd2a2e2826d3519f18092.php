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
						首页 -》招聘模板 -》
					</li>
					招聘信息　　　
					<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px;" href="javascript:location.replace(location.href);" title="刷新" >刷新</a>
				</ul>
			</div>
			<div class="page-content" >
				<div class="page-header" style="width:100%;height:45px;padding-top:12px;">
					<form action="/manage/index.php/Admin/Search/searchlist" method="get" >
						招工标题：<input  type="text" name="title" placeholder="招工标题" value="<?php echo ($_GET['title']); ?>" />
								&nbsp;&nbsp;
						时间：
						<?php if(!empty($_GET['stime']) && !empty($_GET['etime'])){echo $_GET['stime'].' 至 '.$_GET['etime'];} ?>
						<input type="text"  onClick="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="stime"/>-至-<input type="text" onClick="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="etime"/>
						<button type="submit" class="btn btn-xs btn-primary">搜索</button>　　　<span style="background-color:#428BCA;font-size:17px;margin-bottom:0px;"><!--<a href="javascript:;" style="color:#FFFFFF;" onclick="mobile_add('添加','/manage/index.php/Admin/Search/mobileadd','800')">添加</a>--></span>
					</form>
				</div><!-- /.page-header -->
				<div class="row">
					<form action="<?php echo U('Admin/Search/searchdel');?>" method="post" id="formids">
					<table id="sample-table-1" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th class="center">
									<label>
										<input type="checkbox"  />
										<!--<span class="lbl"></span>-->
									</label>
								</th>
								<th>标题</th>
								<th>公司名称</th>
								<th>工种</th>
								<th>工价</th>
								<th>预计人数</th>
								<th>完成周期</th>
								<th>审核状态</th>
								<th>操作</th>
							</tr>
						</thead>

						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
								<td class="center" width="80px">
									<label>
										<input type="checkbox"  name="id[]" value="<?php echo ($v["id"]); ?>"/>
										<!--<span class="lbl"></span>-->
									</label>
								</td>

								<th><?php echo ($v["title"]); ?></th>
								<th><?php echo ($v["gname"]); ?></th>
								<th><?php echo ($v["jobtype"]); ?>(<?php echo ($v["jobtype_name"]); ?>)</th>
								<th><?php echo ($v["xinzi"]); ?></th>
								<th><?php echo ($v["renshu"]); ?>人</th>
								<th><?php echo ($v["livetime"]); ?>天</th>
								<th><?php echo ($v["status"]); ?></th>
								<td width="100px">
									<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
										<!-- <a class="green" href="<?php echo U('Admin/Console/menu_add',array('parentid'=>$v['menuid']));?>">
											<i class="icon-plus bigger-130"></i>
										</a> -->
											
										<a class="blue" onClick="title_edit('编辑','<?php echo U('Admin/Search/searchupdate',array('id'=>$v['id']));?>','800')" href="javascript:;">
											<!--<i class="icon-edit bigger-130"></i>-->编辑
										</a>

										<a class="red" onclick="return title_del('<?php echo U('Admin/Search/searchdel',array('id'=>$v['id']));?>')" href="javascript:;">
											<!--<i class="icon-trash bigger-130"></i>-->删除
										</a>
									</div>
								</td>
							</tr><?php endforeach; endif; ?>
							<tr>
								<td colspan="2">
									<input type="button" value="删除" onclick="return title_delmall('<?php echo U('Admin/Search/searchdel');?>')" style="background-color:#F70808;" />
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
function mobile_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*类型-编辑*/
function title_edit(title,url,w,h){
	layer_show(title,url,w,h);
}
/*类型-删除*/
function title_del(lujing){
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
function title_delmall(lujing){
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