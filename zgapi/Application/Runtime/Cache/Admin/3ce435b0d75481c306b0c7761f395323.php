<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-type" Content="text/html;charset=utf-8" />
<script type="text/javascript" src="/Public/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
function daoru(){
	$.get("demo_ajax_load.txt", function(result){
		$("div").html(result);
	});
}
</script>
</head>
<body>
<select name="tels"  multiple="multiple">
		<!--<option value ="1" selected = "selected">默认值</option>-->
		<?php if(is_array($mobes)): foreach($mobes as $key=>$mobe): ?><option value ="<?php echo ($mobe["mobes"]); ?>"><?php echo ($mobe["name"]); ?></option><?php endforeach; endif; ?>
</select>
<input type="text" width="800px;" placeholder="号码" />
<span><a onclick="daoru" href="javascript:;">导入通讯录</a></span>
</body>
</html>