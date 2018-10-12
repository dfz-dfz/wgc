<?php

$con=mysql_connect('localhost','root','jy0304103') or die("Unable to connect to the MySQL!");
mysql_query("SET NAMES UTF8");
mysql_query("set character_set_client=utf8"); 
mysql_query("set character_set_results=utf8");
$db = mysql_select_db('zt55o1_db',$con);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商城首页 - 59家居商城</title>
	<meta name="description" content="59，59家居，59家居商城，装修、材料、家具、饰品一站式服务，让装修更简单，价格更透明！！" />
	<meta name="keywords" content="59，59家居，家居商城，59家居商城，59家居装修商城，办公室装修，写字楼装修，材料，装修材料，家居，办公家具，家居，家具，装修，装饰" />
<link type="text/css" href="/themes/mall/jiaju/styles/style/style/style.css" rel="stylesheet"  />
<script type="text/javascript" src="http://www.59jiaju.com/themes/mall/jiaju/styles/default/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
	$(function (){
		$('#open-change-city-window').click(function (){
			$('.change-city-window').slideDown();
			
		})
		$('#close-change-city-window').click(function (){
			$('.change-city-window').slideUp();
		})
	})
</script>
</head>

<body>
	<div id="site-nav" class="w-full">

  
  <div class="shoptop w clearfix">

    	<div class="login_info">
		<?php
		
			
			if(empty($_SESSION['user_info']))
			{
				echo '您好 游客&nbsp;&nbsp;&nbsp;';
				echo '<a href="index.php?

app=member&amp;act=login&amp;ret_url=">登录</a>
						<a href=" 

http://www.59jiaju.com/gx/reg.html">注册</a>';
			}
			else
			{
				echo '您好，<a href="index.php?app=member" 

style="color:#0000ff;">'.$_SESSION['user_info']["user_name"].'</a>&nbsp;&nbsp;&nbsp;';
				echo '<a href="index.php?app=member&amp;act=logout">退

出</a>&nbsp;&nbsp;&nbsp;';
				echo '<a href="index.php?app=message&amp;act=newpm">站

内消息</a>';
			}
		?>
      </div>

	

      <ul class="quick-menu">

         

         

         <li class="service">

            <a href="index.php?app=article&amp;code=help">帮助中心</a>         
		</li>

        

         <li class="service">

            <a hidefocus="true"  target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=461666210&site=qq&menu=yes">在线客服</a>         
		</li>

         <li class="item">

            <div class="menu favorite">

               <a class="menu-hd" href="index.php?app=my_favorite">收藏夹<b></b></a>

               <div class="menu-bd">

                  <div class="menu-bd-panel">

                     <div>

                       <p><a href="index.php?app=my_favorite">收藏的宝贝</a></p>

                       <p><a href="index.php?app=my_favorite&amp;type=store">收藏的店铺

</a></p>
                    </div>
                 </div>
               </div>
           </div>
         </li>

         <li class="item" style="background:none">

            <div class="menu sites">

               <a class="menu-hd" href="javascript:;">网站导航<b></b></a>

               <div class="menu-bd padding10">

              </div>
            </div>
        </li>
     </ul>

   </div>

<style type="text/css">

.fixed-top /* 头部固定 */{position:fixed;bottom:auto;top:200px;}

.fixed-bottom /* 底部固定 */{position:fixed;bottom:0px;top:auto;}

.fixed-left /* 左侧固定 */{position:fixed;right:auto;left:0px; z-index:1000;}

.fixed-right /* 右侧固定 */{position:fixed;right:0px;left:auto;}

/* 上面的是除了IE6的主流浏览器通用的方法 */

* html,* html body /* 修正IE6振动bug */{background-image:url(about:blank);background-

attachment:fixed;}

* html .fixed-top /* IE6 头部固定 */{position:absolute;bottom:auto;top:expression(eval

(document.documentElement.scrollTop)+200);}

* html .fixed-right /* IE6 右侧固定 */ {position:absolute;right:auto;left:expression

(eval(document.documentElement.scrollLeft+document.documentElement.clientWidth-

this.offsetWidth)-(parseInt(this.currentStyle.marginLeft,10)||0)-(parseInt

(this.currentStyle.marginRight,10)||0));}

* html .fixed-bottom /* IE6 底部固定  */{position:absolute;bottom:auto;top:expression

(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-

this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt

(this.currentStyle.marginBottom,10)||0)));}

* html .fixed-left /* IE6 左侧固定 */{position:absolute;right:auto;left:expression

(eval(document.documentElement.scrollLeft));}

</style>
  
  
  
  
  
  
  
  
  
  
<div id="header" class="w-full">
    <div class="shop-t w clearfix" style="padding:10px 0;position: relative;height: 70px;">
      	<div class="logo">
        	 <a style="overflow:hidden; margin-top:20px;" href="/"  title="59家居商城">
      <img alt="59家居商城" src='http://www.59jiaju.com/data/files/mall/settings/site_logo.png' />
      </a>
            <div style=" width:137px; float:right;padding-top: 30px;" class="change-city">
            <span style=" font-family:'微软雅黑'; font-size:14px; color:#f00; margin:0 5px;">广州站</span><span style="padding:3px; background:#f3f3f3;">
              <a id="open-change-city-window">【切换城市】</a>
            </span>
          <div class="change-city-window">
            <div class="">
              <span id="close-change-city-window">关闭</span>
            </div>
            <div>
              <a href="http://www.59jiaju.com/shenzhen/">深圳</a>
              <a href="http://www.59jiaju.com/wuhan/">武汉</a>
              <a href="http://www.59jiaju.com/shanghai/">上海</a>
              <a href="http://www.59jiaju.com/beijing/">北京</a>
            </div>
          </div>
        </div>
      	</div>
      	
		<div class="top-search">
	        <div class="top-search-box">
	           	<form method="GET" action="index.php?app=search">
					<input type="hidden" name="app" value="search">
	               <input type="hidden" name="act" value="index">
				   
	              <input type="text" name="keyword" value="search"   onfocus="if(this.value == 'search') this.value = ''" onblur="if(this.value =='') this.value = 'search'" class="top-search-text" />
	               <input type="submit" value="搜索" class="submit" hidefocus="true" />
	           	</form>
				
				
	              <div class="alist">
	                 <a href="index.php?app=search&cate_id=6431">螺丝刀</a>
	                 <a href="index.php?app=search&cate_id=6489">扳手</a>
	                 <a href="index.php?app=search&cate_id=6490">钢丝钳</a>
	              </div>
	        </div>
      	</div>
		<?php
		
		$row11=mysql_num_rows(mysql_query("SELECT user_id FROM ecm_member where types=2"));
		$row12=mysql_num_rows(mysql_query("SELECT user_id FROM ecm_member where types=3"));
		
		?>
        <div class='erweima'>
           <p>材料商会员：<span class="textred" style="color: red;">00000<?php //echo user_num(2);?></span></p>
           <p>装修公司会员：<span class="textred" style="color: red;">00000<?php //echo user_num(3);?></span></p>
        </div>
   	</div>
	<div class="mainnav w-full">
		<div class="menu">
			<ul>
        <li class="total">所有分类<i><img src="/themes/mall/jiaju/styles/style/images/updown.png"></i></li>
				<li class="line"><a href="http://www.59jiaju.com/">首页</a></li>
        <li class="line"><a href="http://www.59jiaju.com/">材料城</a></li>
        <li class="line"><a href="http://www.59jiaju.com/index.php?app=search&act=zhaopin">行业招聘</a></li>
        <li class="line"><a href="http://www.59jiaju.com/index.php?app=search&act=zx">热门公司</a></li>
        <li class="line"><a href="http://www.59jiaju.com/index.php?app=article&act=view&article_id=28">关于我们</a></li>
        <li class="line"><a href="http://www.59jiaju.com/gx/reg.html">会员注册</a></li>
			</ul>
		</div>
	</div>
</div>

<div style="width: 1200px;margin: 10px auto">
	<img src="http://www.59jiaju.com/themes/mall/jiaju/images/zhaopin11.gif">
</div>
<div style="width: 1200px;margin: 10px auto">
	<img src="http://www.59jiaju.com/themes/mall/jiaju/images/zhaopin12.gif">
</div>
<div style="width: 1200px;margin: 10px auto">
	<img src="http://www.59jiaju.com/themes/mall/jiaju/images/zhaopin13.gif">
</div>
<div id="footer" class="center auto mt10 w-full">

   <div class="foot-service w auto clearfix">

      <dl>

         <dt class="fts-1"></dt>

         <dd><a href="http://www.59jiaju.com/index.php?

app=article&amp;act=view&amp;article_id=28">七天无理由退货</a></dd>

         <dd><a href="http://www.59jiaju.com/index.php?

app=article&amp;act=view&amp;article_id=13">体贴的售后服务</a></dd>
      </dl>

<dl>

         <dt class="fts-2"></dt>

         <dd><a href="http://www.59jiaju.com/index.php?

app=article&amp;act=view&amp;article_id=15">购物流程</a></dd>

      <dd><a href="http://www.59jiaju.com/index.php?

app=article&amp;act=view&amp;article_id=12">商品退货保障</a></dd>
     </dl>

   <dl>

         <dt class="fts-3"></dt>

         <dd>客服专线：400-1012-668</dd>

         <dd>厂家入驻：020-86295019</dd>

     </dl>


      <dl>

         <dt class="fts-4"></dt>

         <dd><a href="http://www.59jiaju.com/index.php?

app=article&amp;act=view&amp;article_id=11">顾客必读</a></dd>

         <dd><a href="http://www.59jiaju.com/index.php?

app=article&amp;act=view&amp;article_id=14">免责条款</a>
        
         </dd>
      </dl>

  </div>

<div class="foot-nav w-full auto">
  <p><a href="http://www.59jiaju.com/index.php?app=article&amp;act=view&amp;article_id=28" target="_blank">关于本站</a>
	    
	      
	    
	   
	    
	   
	   
</p></div>
<div class="foot-group">

	<a href="#" target="_blank">亚马逊商城</a> | <a href="www.jd.com" target="_blank">京东商城</a> | <a href="www.yihaodian.com" target="_blank">一号店</a> |

	<a href="http://www.hao123.com/" target="_blank">好123导航</a> |

	<a href="http://www.jyboo.com/" target="_blank">经艺装饰</a> |

	<a href="http://www.taobao.com/" target="_blank">淘宝商城</a> |

	<a href="http://www.tmall.com/" target="_blank">天猫商城</a> |

    <a href="http://china.alibaba.com/" target="_blank">阿里巴巴</a> |

	<a href="http://www.59jiaju.com/xiduo/" target="_blank">喜多装饰</a> |
    
    <a href="http://www.59jiaju.com/gs/index.php?

m=content&amp;c=index&amp;a=show&amp;catid=13&amp;id=9" target="_blank">超凡装饰</a> |

	<a href="http://www.dangdang.com/" target="_blank">当当网</a>   
</div>

  <div class="copyright"><a href="http://netadreg.gzaic.gov.cn/ntmm/WebSear/WebLogoPub.aspx?

logo=440115115022013051700026"><img alt="" src="http://netadreg.gzaic.gov.cn/ntmm/default/images/logo_down.jpg" style="width:19px;height: 20px"></a> &nbsp;Copyright © 2010-2014 我购家居商城 版

权所有 <a href="http://www.miitbeian.gov.cn">粤ICP备09031901号-1</a> 广州市我购家居用品

有限公司</div>

</div>