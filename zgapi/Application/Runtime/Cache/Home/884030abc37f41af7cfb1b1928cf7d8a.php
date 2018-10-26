<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>59家居网</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/manage/Public/jobs/css/main.css">
<link rel="stylesheet" type="text/css" href="/manage/Public/jobs/css/endpic.css">
<script type="text/javascript" src="/manage/Public/jobs/script/offline.js"></script>
<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">
</head>
<body>
<!--<div style="width:100%;max-width:100%;">
<img style="width:100%;" src="/manage/Public/jobs/img/sm41.png">
<img style="width:100%;" src="/manage/Public/jobs/img/sm42.png">
</div>-->
<link rel="stylesheet" type="text/css" href="/manage/Public/jobs/css/aui-slide.css" />
<div id="aui-slide3">
    <div class="aui-slide-wrap" >
        <div class="aui-slide-node bg-dark">
            <img src="/manage/Public/jobs/img/sm41.png" />
        </div>
        <div class="aui-slide-node bg-dark">
            <img src="/manage/Public/jobs/img/sm42.png" />
        </div>
    </div>
    <div class="aui-slide-page-wrap"><!--分页容器--></div>
</div>
<script type="text/javascript" src="/manage/Public/jobs/script/aui-slide.js"></script>
<script type="text/javascript">
    var slide = new auiSlide({
        container:document.getElementById("aui-slide"),
        // "width":300,
        "height":1200,
        "speed":300,
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
        "height":1200,
        "speed":300,
        "autoPlay": 0, //自动播放
        "pageShow":true,
        "loop":true,
        "pageStyle":'dot',
        'dotPosition':'center'
    })
    var slide3 = new auiSlide({
        container:document.getElementById("aui-slide3"),
        // "width":300,
        "height":1200,
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