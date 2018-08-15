/*  (function (config) {
	var bigExt = config.bigSRC.substring(config.bigSRC.lastIndexOf(".")).toLowerCase();
	var smallExt = config.smallSRC.substring(config.smallSRC.lastIndexOf(".")).toLowerCase();
	var bigHtml, smallHtml, activityHtml = "",smallActiHtml = "";
	if (bigExt != ".swf") {
		for (var i = 0; i < config.activity.length; i++) {
			if(config.activity[i].src){
				activityHtml += "<area shape=\"rect\" coords=\""+config.activity[i].coords+"\" href =\""+config.activity[i].src+"\" alt=\""+config.activity[i].alt+"\" />";
			}
		};
		if(!activityHtml){
			bigHtml = "<a href=\"" + config.bigURL + "\" target=\"_blank\"><img src=\"" + config.bigSRC + "\" border=\"0\" width=\"" + config.bigWidth + "\" height=\"" + config.bigHeight + "\"></a>";
		}else{
			bigHtml = "<img src=\"" + config.bigSRC + "\" border=\"0\" width=\"" + config.bigWidth + "\" height=\"" + config.bigHeight + "\" usemap=\"#activity\" /><map name=\"activity\" id=\"activity\">"+activityHtml+"</map>";
		}
	}
	else {
		bigHtml = "<embed src=\"" + config.bigSRC + "\" quality=\"high\" width=\"" + config.bigWidth + "\" height=\"" + config.bigHeight + "\" wmode=\"opaque\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\">";
	}
	if (smallExt != ".swf") {
		for (var i = 0; i < config.smActivity.length; i++) {
			if(config.smActivity[i].src){
				smallActiHtml += "<area shape=\"rect\" coords=\""+config.smActivity[i].coords+"\" href =\""+config.smActivity[i].src+"\" alt=\""+config.smActivity[i].alt+"\" />";
			}
		};
		smallHtml = config.smallURL ? "<a href=\"" + config.smallURL + "\" target=\"_blank\"><img src=\"" + config.smallSRC + "\" border=\"0\" width=\"" + config.smallWidth + "\" height=\"" + config.smallHeight + "\"></a>":"<img src=\"" + config.smallSRC + "\" border=\"0\" width=\"" + config.smallWidth + "\" height=\"" + config.smallHeight + "\" usemap=\"#smActivity\" /><map name=\"smActivity\" id=\"smActivity\">"+smallActiHtml+"</map>";
	}
	else {
		smallHtml = "<embed src=\"" + config.smallSRC + "\" quality=\"high\" width=\"" + config.smallWidth + "\" height=\"" + config.smallHeight + "\" wmode=\"opaque\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\">";
	}
	if (config.bigSRC){
		document.write("<div style=\"clear:both;\"><div id=\"fullBar_" + config.id + "_small\" style=\"width:" + config.smallWidth + "px;height:" + config.smallHeight + "px;\">" + smallHtml + "</div><div id=\"fullBar_" + config.id + "_big\" style=\"width:" + config.bigWidth + "px;height:" + config.bigHeight + "px;display:none;\">" + bigHtml + "</div></div>");
		var b2s = function () {
			$("#fullBar_" + config.id + "_big").slideUp(1000, function () {
				$("#fullBar_" + config.id + "_small").slideDown(1000);
			});
		}
		var s2b = function () {
			$("#fullBar_" + config.id + "_small").slideUp(1000, function(){
				$("#fullBar_" + config.id + "_big").slideDown(1000);
				window.setTimeout(b2s, 10000);
			});
		}
		window.setTimeout(s2b, 2000);
	}else{
		document.write("<div style=\"clear:both;\"><div id=\"fullBar_" + config.id + "_small\" style=\"width:" + config.smallWidth + "px;height:" + config.smallHeight + "px;\">" + smallHtml + "</div></div>")
	}
})({
	"id": "sc",
	"smallSRC": "http://news.jiaju.com/images/2013/0922/U6077P1187DT20130922142717.jpg",//小图地址
	"smallURL": "",//小图链接
	"smallWidth": 990,
	"smallHeight": 90,
	"bigSRC": "http://news.jiaju.com/images/2013/0826/U6077P1187DT20130826115434.jpg",//大图地址
	"bigURL": "",//大图链接
	"bigWidth": 990,
	"bigHeight": 450,
	"smActivity":[{
		"src":"http://news.jiaju.com/zt/piaoliang.shtml",//小图热点链接1
		"alt":"非常女人之爱漂亮",//小图热点文本1
		"coords":"522,0,740,90"
	},{
		"src":"http://www.jiaju.com/zt/xiahenshou/",
		"alt":"非常男人之下狠手",
		"coords":"740,0,990,90"
	}],
	"activity":[{
		"src":"http://www.jiaju.com/zt/Prettylady1/",//大图热点链接1
		"alt":"非常女人之爱便宜",//大图热点文本1
		"coords":"50,324,199,373"
	},{
		"src":"http://www.jiaju.com/zt/superman/",
		"alt":"非常男人之重品质",
		"coords":"50,390,234,437"
	},{
		"src":"http://news.jiaju.com/zt/airenao9.6.shtml",
		"alt":"非常女人之爱热闹",
		"coords":"272,324,439,373"
	},{
		"src":"http://news.jiaju.com/zt/yezonghui.shtml",
		"alt":"非常男人之图省时",
		"coords":"272,390,484,437"
	},{
		"src":"http://news.jiaju.com/zt/prettygirl.shtml?utm_zn=zt_focus_prettygirl",
		"alt":"非常女人之爱吐槽",
		"coords":"524,324,708,373"
	},{
		"src":"http://www.jiaju.com/zt/easyway/?utm_zn=zt_focus_/easyway/",
		"alt":"非常男人之爱省事",
		"coords":"524,390,702,437"
	},{
		"src":"http://news.jiaju.com/zt/piaoliang.shtml",
		"alt":"非常女人之爱漂亮",
		"coords":"744,324,938,373"
	},{
		"src":"http://www.jiaju.com/zt/xiahenshou/",
		"alt":"非常男人之下狠手",
		"coords":"744,390,918,437"
	}]

}); */