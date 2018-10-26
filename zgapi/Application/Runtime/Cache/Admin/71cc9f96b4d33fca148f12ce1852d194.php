<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>省市区三级联动(jQuery+Json)</title>
<!--<script type="text/javascript" src="http://img.pccoo.cn/js/jquery.js"></script>-->
<script type="text/javascript" src="/Public/quyu/js/city.js"></script>
<script type="text/javascript" src="/Public/quyu/js/china_area.js"></script>
<script type="text/javascript">
$(function() {
    $.each(provinceJson, function(k, p) {
        var option = "<option value='" + p.id + "'>" + p.province + "</option>";
        $("#selProvince").append(option);
    });
    $("#selProvince").change(function() {
        var selValue = $(this).val();
        $("#selCity option:gt(0)").remove();
        $.each(cityJson, function(k, p) {
            // 直辖市处理.|| p.parent == selValue，直辖市为当前自己
            if (p.id == selValue || p.parent == selValue) {
                var option = "<option value='" + p.id + "'>" + p.city + "</option>";
                $("#selCity").append(option);
            }
        });
    });
    $("#selCity").change(function() {
        var selValue = $(this).val();
        $("#selDistrict option:gt(0)").remove();
        $.each(countyJson, function(k, p) {
            if (p.parent == selValue) {
                var option = "<option value='" + p.id + "'>" + p.county + "</option>";
                $("#selDistrict").append(option);
            }
        });
    });
});
</script>
</head>
<body>
<form method="post" action="/index.php/Admin/Type/te">
	<select id="selProvince">
	  <option value="0" name="sheng">--请选择省份--</option>
	</select>
	<select id="selCity" name="city">
	  <option value="0">--请选择城市--</option>
	</select>
	<select id="selDistrict" name="qu">
	  <option value="0">--请选择区/县--</option>
	</select>
	<br/>
	<input type="submit" value="ok" />
</form>
</body>
</html>