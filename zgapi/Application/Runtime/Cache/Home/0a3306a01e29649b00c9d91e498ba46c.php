<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>59家居网</title>
    <link rel="stylesheet" type="text/css" href="/zgapi/Public/jobs/css/aui.2.0.css" />
	<script type="text/javascript" src="/zgapi/Public/jobs/script/api.js"></script>
</head>
<body>
<link rel="stylesheet" type="text/css" href="/zgapi/Public/jobs/css/aui-slide.css" />
<div id="aui-slide">
    <div class="aui-slide-wrap" >
        <div class="aui-slide-node bg-dark">
            <img src="/zgapi/Public/jobs/img/top2.png" />
        </div>
        <div class="aui-slide-node bg-dark">
            <img src="/zgapi/Public/jobs/img/top2.png" />
        </div>
        <div class="aui-slide-node bg-dark">
            <img src="/zgapi/Public/jobs/img/top2.png" />
        </div>
    </div>
    <div class="aui-slide-page-wrap"><!--分页容器--></div>
</div>
<section class="aui-grid aui-margin-b-15">
    <div class="aui-row">
        <div class="aui-col-xs-4" style='width:50%;'>
            <img src='/zgapi/Public/jobs/img/ckmsg.png' />
            <div class="aui-grid-label">查看项目消息</div>
        </div>
        <div class="aui-col-xs-4" style='width:50%;'>
            <img src='/zgapi/Public/jobs/img/ckfb.png' />
            <div class="aui-grid-label">查看项目分布</div>
        </div>
        <div class="aui-col-xs-4" style='width:50%;'>
            <img src='/zgapi/Public/jobs/img/clscx.png' />
            <div class="aui-grid-label">材料供应商查询</div>
        </div>
        <div class="aui-col-xs-4" style='width:50%;'>
            <img src='/zgapi/Public/jobs/img/newprj.png' />
            <div class="aui-grid-label">新建项目</div>
        </div>
    </div>
</section>
<div class="aui-content aui-margin-b-15"  >
        <ul class="aui-list aui-list-in">
            <li class="aui-list-item">
                <div class="aui-list-item-inner">
					<div class="aui-list-item-title" ><img src='/zgapi/Public/jobs/img/wdxm2.png' style='float:left;' /><span style='font-size:20px;'>我的项目(1)</span></div>
                    <div class="aui-list-item-right">
                        <div class="aui-bar aui-bar-btn aui-bar-btn-sm" style="width:60%;float:right">
                            <div style='border:1px solid #DDDDDD;border-radius: 20px;padding:4px;'></div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
</div>
<div style='width:100%;max-width:100%;'>
	<span style='font-size:10px;color:#BDBDC1;'>天河城麦当劳维修 </span>
</div>
<div class="aui-content aui-margin-b-15">
        <ul class="aui-list aui-media-list">
           
            <li class="aui-list-item">
                <div class="aui-media-list-item-inner">
                    <div class="aui-list-item-media">
                        <img src="/zgapi/Public/jobs/img/dt.png">
                    </div>
                    <div class="aui-list-item-inner">
                        <div class="aui-list-item-text">
                            <div class="aui-list-item-title">水电班(3)</div>
        					<div class="aui-list-item-right"></div>
                        </div>
                        <div class="aui-list-item-text">
                            王生[图片]
                        </div>
                    </div>
                </div>
            </li>
            
        </ul>
</div>
<div style='width:80%;margin-left:auto;margin-right:auto;height:50px;line-height:50px;'>
	<span style='font-size:15px;color:#BDBDC1;'>已关闭的班组/项目组(4)</span>
</div>
<script type="text/javascript" src="/zgapi/Public/jobs/script/aui-slide.js"></script>
<script type="text/javascript">
    var slide = new auiSlide({
        container:document.getElementById("aui-slide"),
        // "width":300,
        "height":100,
        "speed":300,
		"autoPlay": 2000, //自动播放
        "pageShow":true,
        "pageStyle":'dot',
        "loop":true,
        'dotPosition':'center',
        currentPage:currentFun
    })

    function currentFun(index) {
        console.log(index);
    }
    var slide2 = new auiSlide({
        container:document.getElementById("aui-slide2"),
        // "width":300,
        "height":240,
        "speed":300,
        "autoPlay": 3000, //自动播放
        "pageShow":true,
        "loop":true,
        "pageStyle":'dot',
        'dotPosition':'center'
    })
    var slide3 = new auiSlide({
        container:document.getElementById("aui-slide3"),
        // "width":300,
        "height":240,
        "speed":500,
        "autoPlay": 3000, //自动播放
        "loop":true,
        "pageShow":true,
        "pageStyle":'line',
        'dotPosition':'center'
    })
    console.log(slide3.pageCount());
</script>
</body>

</html>