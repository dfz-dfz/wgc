$(function(){

	function sc(){
		if($(this).scrollTop() == 0){
			$(".suspension, .suspension2").fadeOut();
		}else{
			$(".suspension, .suspension2").fadeIn();
		}
	}
	$(document).scroll(function(){
		sc();
	});
	sc();

	$(".suspension .suspension_close").click(function(){
		$(".suspension, .suspension2").hide();
	})

})