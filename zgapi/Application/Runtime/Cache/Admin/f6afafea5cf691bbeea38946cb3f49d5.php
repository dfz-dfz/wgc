<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-Type" Content="text/html;charset=utf-8" />
<script type="text/javascript" src="/duanxin/Public/quyu/js/jquery.js"></script>
<script type="text/javascript" src="/duanxin/Public/quyu/js/jquery.cityselect.js"></script>
<script type="text/javascript" src="/duanxin/Public/quyu/js/city.min.js"></script>
<script type="text/javascript">
			$(function(){
				$("#city_1").citySelect({
					nodata:"none",
					required:false
				}); 
			});
		</script>
</head>
<body>
<div id="city_1">
	<select class="prov"></select> 
	<select class="city" disabled="disabled"></select>
</div>
</body>
</html>