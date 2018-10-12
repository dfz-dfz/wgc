// JavaScript Document

var jq2=jQuery.noConflict();
jq2(document).ready(function(e) {
	//图片滑动效果
	jq2(".zs_li").hover(function(){
		var $height = jq2(this).find('div').height();
		     $height = $height/2 - $height;
		jq2(this).find('div').stop().animate({top:$height});	
	},function(){
		jq2(this).find('div').stop().animate({top:"0"});
	});
	
	//8免选项卡按钮切换
	jq2(".mian8_button").hover(function(){
		var Pointer=jq2(this).attr("id");		
		var Pointer=Pointer.split("_")[2];		
		jq2(this).parent(".sub").css("background-image","url(statics/images/mianfei8_sub_bg"+Pointer+".png)");
	},function(){
		jq2(this).parent(".sub").css("background-image","url(statics/images/mianfei8_sub_bg0.png)");
	});
	
	//16不限列表默认样式设置
	var arr=jq2(".buxian16_con").find("li");
	var lens=arr.length;
	//alert(lens);
	for(var x=1;x<=lens;x+=2){
		arr[x].className="li1";
	}
	
	//16不限列表鼠标事件样式设置
	jq2(".buxian16_con").find("li").hover(function(){		
		jq2(this).css("color","#fff");
	},function(){
		jq2(this).css("color","#f5b89a");
	});
	
	jq2(".fz_tu").hover(function(){
		jq2(this).find(".fz_tit").animate({top:"200px"});
	},function(){
		jq2(this).find(".fz_tit").animate({top:"300px"});
	});
});


//图片翻转
function fz(id,x,y){
	var num=document.getElementById(id).getElementsByTagName("li").length;	
	for(v=1;v<=num;v++){
		if(x==v){
			if(document.getElementById(id+"-sub"+v)){
				document.getElementById(id+"-sub"+v).className="dd2";
			}
			document.getElementById(id+"-zs"+v).style.display="block";
		}else{
			if(document.getElementById(id+"-sub"+v)){
				document.getElementById(id+"-sub"+v).className="dd1";
			}
			document.getElementById(id+"-zs"+v).style.display="none";
		}
	}
}
function switch1(id,x){	
	var num=document.getElementById(id).getElementsByTagName("li").length;
	for(a=1;a<=num;a++){
		var style1=document.getElementById(id+"-zs"+a).style.display;
		if(style1=="block"){
			var c=a+x;
			if(c<1){
				fz(id,num,2);
				break;
			}else if(c>num){
				fz(id,1,2);
				break;
			}else{
				fz(id,c,2);
				break;
			}
		}
	}
}


//选项卡切换
function select_1(id){
	var arr_1=id.split("-");
	var sel_x=arr_1[0];
	var sel_xuan=arr_1[1];
	var sel_a=document.getElementById(sel_x);
	var sel_b=sel_a.getElementsByTagName("li");
	var sel_num=sel_b.length;
	for(var mm=1;mm<=sel_num;mm++){
		if(mm==sel_xuan){
			document.getElementById(sel_x+"-"+mm).className="li1";
			document.getElementById(sel_x+"-con"+mm).style.display='block';
		}else{
			document.getElementById(sel_x+"-"+mm).className="";
			document.getElementById(sel_x+"-con"+mm).style.display='none';	
		}
	}
	
}


