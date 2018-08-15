function async_topMenu(object) {
    //避免鼠标触发时，前面的ajax尚未执行完毕
    $(object).children("div").html('<img src="/images/default/icon_loading.gif" title="数据加载中" style="width:32px; height:32px; padding:20px 0 20px 240px;">');
    if (running) {
        return false;
    }
    running = true;
    //var obj = obj;
    $.ajax({
        type: "GET",
        url : "/async_topMenu.php",
        dataType :"json",
        success: function(cateList){
            if(cateList) {
                //把数据innerHTML到所有标签内
                $("div.nav > ul > li").each(function(i,obj){
                    var key = $(obj).attr('id');
                    if(key == 'lastSelected') {
                        //有key的标签切换，无则是所有分类
                        var innerHTML = innerAll(cateList['all']);
                    }else{
                        var innerHTML = innerTag(cateList['tag'][i]);
                    }
                    $(obj).children("div").html(innerHTML);
                });
            }
        }
    });
}

//获取数据，并赋予html
function innerTag(cateList)
{
    //左边html
    var innerHTML = '<div class="subcate">';
	//分类
	if(cateList.category)
	{
		innerHTML += '<ul>';
		var flagMore = 0;
		var subList = cateList.category;
		for(var skey in subList)
		{							
			if(subList[skey].attributes.hidden != "yes" && flagMore < 12)
			{
				innerHTML += '<li>';
				innerHTML += '<a  href="'+subList[skey].url+'"';
				if(subList[skey].attributes.nofollow == "yes")
				{
					innerHTML += ' rel="nofollow"';
				}
				innerHTML += '>';
				
				if(subList[skey].attributes.strong == "yes")
				{
					innerHTML += '<strong>'+subList[skey].name+'</strong>';
				}else{
					innerHTML += subList[skey].name;
				}
				innerHTML += '</a>';
				innerHTML += '</li>';
				flagMore ++;
			}
		}
		innerHTML += '</ul>';
	}
	innerHTML += '</div>';

    //右边html
    innerHTML += '<div class="colright">';
    //推荐品牌
    innerHTML += '<div class="featuredbrand">';
    innerHTML += '<h3>推荐品牌</h3>';
    //推荐品牌，只取6个
    if (cateList.BrandList) {
        var brandList = cateList.BrandList;
        innerHTML += '<ul>';
		for(var bkey in brandList) {
			if(bkey < 6) {
				
			    innerHTML += '<li>';
				innerHTML += '<a href="'+brandList[bkey].Url+'" title="'+brandList[bkey].BrandName+'"><img src="'+brandList[bkey].ImageUrl+'" alt="'+brandList[bkey].BrandName+'" /></a>';
				innerHTML += '</li>';
			}
		}
		innerHTML += '</ul>';
        innerHTML += '<div class="cl"></div>';
	}
    innerHTML += '</div>';
    //推荐商家
    innerHTML += '<div class="merchantpromotion">';
	innerHTML += '<h3>推荐商家</h3>';

	if(cateList.MerList) {
		var merList = cateList.MerList;
		innerHTML += '<ul>';
		for(var mkey in merList)
		{
			innerHTML += '<li><a href="'+merList[mkey].Url+'" title="'+merList[mkey].MerchantName+'">'+merList[mkey].MerchantName+'</a></li>';
		}
		innerHTML += '</ul>';
	}
	innerHTML += '</div>';

	innerHTML += '</div>';//colright end
	innerHTML += '<div class="cl"></div>';
    innerHTML += '</div>';
    return innerHTML;
}

function innerAll(cateList)
{
	var innerHTML = '<div class="subcate"><ul>';
	for(var key in cateList)
	{
		innerHTML  += '<li><a href='+key+' title='+cateList[key]+'>'+cateList[key]+'</a></li>';
	}
	innerHTML  += '</ul></div>';
	return innerHTML;
}

var running = false;//是否在运行中
var delay = 200;
var allCateTimer = null;

//当菜单html刚载入完成开始监控菜单是否展示
$('div#nav:not(.homenav)').hover(
    function(){
        var $this = this;
        allCateTimer = setTimeout(function() { 
            $($this).find('div.allcate > a').addClass('hover');
            $($this).children('ul').removeClass('disn');
        }, delay);
    },
    function(){
        var $this = this
        allCateTimer = setTimeout(function() {
            $($this).find('div.allcate > a').removeClass('hover');
            $($this).children('ul').addClass('disn');
            //兼容IE6显示所有select 元素
            $("select.menuVisible").each(function() {
              if ($(this).css("visibility") == 'hidden') {
                $(this).removeClass('menuVisible').css('visibility', 'visible');
              }
            });
        }, delay);
    }
);

$('div#nav > ul > li').hover(
    function(ev){
        var $this = this;
        allCateTimer = setTimeout(function() {
            var bottomHeight = document.documentElement.clientHeight - ev.clientY;
            
            if (bottomHeight <= 250) {
                $($this).addClass('over').find('div.submenubox').addClass('submenuboxBottom').removeClass('disn');
            } else {
                $($this).addClass('over').find('div.submenubox').removeClass('submenuboxBottom').removeClass('disn');
            }
            //兼容IE6隐藏所有select 元素
            $("select").each(function() {
              if ($(this).css('visibility') != 'hidden') {
                $(this).addClass('menuVisible').css('visibility', 'hidden');
              }
            });
            if ($($this).find("div.subcate").size()<= 0) {
                async_topMenu($this);
            }
        }, delay);
    },
    function(){
        var $this = this;
        if (allCateTimer) {
            clearTimeout(allCateTimer);
        }
        allCateTimer = setTimeout(function() { 
            $($this).removeClass('over').find('div.submenubox').addClass('disn');}, delay);
    }
);

/*代码整理：www.97zzw.com - 97站长网*/