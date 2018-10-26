<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>我的级别-级别特权</title>
    <link rel="stylesheet" type="text/css" href="/zgapi/Public/jobs/css/api.css"/>
    <link rel="stylesheet" type="text/css" href="/zgapi/Public/jobs/css/aui.css" />
    <style>
    	html,body{
    		height:100%;
    	}
    </style>
</head>
<body>
	
	<div class="aui-tab" id="tab">
	    <div class="aui-tab-item"><a href="<?php echo U('Jymember/mygrade',array('type'=>1));?>">我拉的工友</a></div>
	    <div class="aui-tab-item aui-active"><a href="<?php echo U('Jymember/mygrade',array('type'=>2));?>">级别特权</a></div>
	    <div class="aui-tab-item"><a href="<?php echo U('Jymember/mygrade',array('type'=>3));?>">级别结构</a></div>
	</div>

	
	<div class="aui-content aui-margin-b-15">
        <ul class="aui-list aui-media-list">
            
            <li class="aui-list-item aui-list-item-middle">
                <div class="aui-media-list-item-inner">
                    <div class="aui-list-item-media" style="width: 3rem;">
                        <img src="/zgapi/Public/jobs/img/logo.png" class="aui-img-round aui-list-img-sm">
                    </div>
                    <div class="aui-list-item-inner aui-list-item">
                        <div class="aui-list-item-text">
                            <div class="aui-list-item-title aui-font-size-14"><?php echo ($info["real_name"]); ?></div>
                            <div class="aui-list-item-right aui-font-size-14">当前级别：<?php echo ($info["mygrade"]); ?></div>
                        </div>
                        <div class="aui-list-item-text">
                            <div class="aui-list-item-title aui-font-size-14">工种：<?php echo ($info["jobtypename"]); ?></div>
                            <div class="aui-list-item-right aui-font-size-14">工价次数：3次/月</div>
                        </div>
                        <div class="aui-list-item-text">
                            <div class="aui-list-item-title aui-font-size-14">需交押金：1500元</div>
                            <div class="aui-list-item-right aui-font-size-14">已交押金：<font style="color:#ff552e">1500元</font></div>
                        </div>
                    </div>
                </div>
            </li>   
        </ul>
    </div>
    
    
    <div class="aui-content aui-margin-b-15">
        <ul class="aui-list aui-list-in">
            <li class="aui-list-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-title">本月已发布工价次数：2次</div>
                </div>
            </li>
            <li class="aui-list-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-title">本月还可发布工价次数：1次</div>
                    <div class="aui-list-item-right">
                        <div class="aui-label aui-label-info"><a href="/zgapi/jingyi.php/Home/Jysearch/searchadd/user_id/<?php echo ($info["user_id"]); ?>" style="color:#FFF;">点击进入发布</a></div>
                    </div>
                </div>
            </li>
            <li class="aui-list-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-title">成长历程：</div>
                    
                    <div class="aui-list-item-right">已拉工友注册数<?php echo ($info["teams"]); ?>人
                        <div class="aui-label aui-label-warning"><a href="/zgapi/jingyi.php/Home/Jymember/erweima" style="color:#FFF;">拉工友</a></div>
                    </div>
                </div>
            </li>
        </ul>
      
        <p>
			 
			<?php if(($info['teams'] >= 3) AND ($info['teams'] < 6) ): ?><img src="/zgapi/Public/jobs/img/dengji2.jpg"style="width:100%;"/>
			<?php elseif(($info['teams'] >= 6) AND ($info['teams'] < 12) ): ?>
				 <img src="/zgapi/Public/jobs/img/dengji3.jpg"style="width:100%;"/>
			<?php elseif(($info['teams'] >= 12) AND ($info['teams'] < 24) ): ?>
				<img src="/zgapi/Public/jobs/img/dengji4.jpg"style="width:100%;"/>
			<?php elseif($info['teams'] >= 24 ): ?>
				<img src="/zgapi/Public/jobs/img/dengji5.jpg"style="width:100%;"/>
			<?php else: ?>
				<img src="/zgapi/Public/jobs/img/dengji1.jpg"style="width:100%;"/><?php endif; ?>
		</p>

    </div>
	
	<p style="color:#333;font-size:14px;padding: 5px;width: 95%;margin:20px auto;padding-bottom:44px;">
	
		级别特权：</br>
			1.普通级别只能够接活和发布找活。</br>
			2.组长级别不但可以接活和发布找活,还可以
			交一千五百元保证金(可以申请退回保证金）,
			每月3次发布工价推送给装饰公司及客户。</br>
			3.班长级别不但可以接活和发布找活,还可以
			交三千元保证金(可以申请退回保证金）,每
			月6次发布工价推送给装饰公司和客户。</br>
			4.排长级别不但可以接活和发布找活,还可以
			交六千元保证金(可以申请退回保证金）,每
			月12次发布工价推送给装饰公司和客户。</br>
			5.队长级别不但可以接活和发布找活,还可以
			交一万两千元保证金(可以申请退回保证金）,
			每月24次发布工价推送给装饰公司和客户。</br>
	
	</p>
	
</body>
<script type="text/javascript" src="/zgapi/Public/jobs/script/api.js"></script>
<!--Zepto.js,类似Jquery-->
<script type="text/javascript" src="/zgapi/Public/jobs/script/zepto.min.js"></script>
<script type="text/javascript" src="/zgapi/Public/jobs/script/winu-base.js" ></script>
<script type="text/javascript">
	
	apiready = function(){
		
		
	};
	
	
	
</script>
</html>