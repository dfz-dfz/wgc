$(function(){
	$('#gotop').click(function(){
	  $('html,body').animate({scrollTop: '0px'}, 0);
   });
	
   $(".top-search li").click(function(){
	   $(".top-search li").each(function(){
		   $(this).removeClass("current");
	   });
	   $(this).addClass("current");
	   $(".top-search-box input[name='act']").val(this.id);
	   
	   if($.trim($(".top-search-box input[name='keyword']").val())==""){
		   $(".top-search-box input[name='keyword']").attr("class","");
		   $(".top-search-box input[name='keyword']").addClass(this.id+"_bj kw_bj keyword");
	   }
	   
	   
   }); 
   
   
   $(".top-search-box input[name='keyword']").focus(function(){
	   $(this).attr("class","keyword");
   }).blur(function(){
	   if($.trim($(this).val())=="") {
		   $(this).attr("class",$(this).parent().find("input[name='act']").val()+"_bj kw_bj keyword");
	   }
   });
     
   
   $(".top-search-box .submit").click(function(){
	   if($.trim($(this).parent().find("input[name='keyword']").val())=="") {
		   alert("请输入关键词");
		   return false;
	   }
   });   
   
})
 