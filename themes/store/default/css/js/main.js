
TouchSlide({
    slideCell:"#scrollBox",
    titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
    effect:"leftLoop",
    autoPage:true, //自动分页
    switchLoad:"_src" //切换加载，真实图片路径为"_src"
});

TouchSlide({
    slideCell:"#slideBox",
    titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
    mainCell:".bd ul",
    effect:"leftLoop",
    autoPage:true,//自动分页
    autoPlay:true //自动播放
});

TouchSlide({
    slideCell:"#scrollBox1",
    titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
    effect:"leftLoop",
    autoPage:true, //自动分页
    switchLoad:"_src" //切换加载，真实图片路径为"_src"
});
TouchSlide( { slideCell:"#tabBox1",

    endFun:function(i){ //高度自适应
        var bd = document.getElementById("tabBox1-bd");
        bd.parentNode.style.height = bd.children[i].children[0].offsetHeight+"px";
        if(i>0)bd.parentNode.style.transition="200ms";//添加动画效果
    }

} );

$(function(){
    $(".subNav").click(function(){
        $(this).toggleClass("currentDd").siblings(".subNav").removeClass("currentDd")
        $(this).toggleClass("currentDt").siblings(".subNav").removeClass("currentDt")

        // 修改数字控制速度， slideUp(500)控制卷起速度
        $(this).next(".navContent").slideToggle(500).siblings(".navContent").slideUp(500);
    })
})

$(function(){
    $(".index-big").height($(".index-shop").height());
    $(".inBox .inHd").height($(".join2").height());
});



$("#top").click(function(){$("body,html").animate({scrollTop:0},1000)});