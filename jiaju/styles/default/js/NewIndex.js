$(function (){
	$('.new-sale-nav a:first').addClass('new-sale-current-a');
	$('.new-sale-nav a').click(function (){
		var now=$(this).index();
		$('.new-sale-nav a').removeClass('new-sale-current-a');
		$(this).addClass("new-sale-current-a");
		$('.new-sale-play-in').animate({left:-540*now});
	})
})



$(function (){
	$('#new_cat_but1 span:first').css('background','#D70000');
	var now=0;

	$('#new_cat_but1 span').click(function (){
		now=$(this).index()-1;
		$('#new_cat_but1 span').css('background','none');
		$(this).css('background','#D70000');
		$('#new-cat_play1').animate({left:-585*now});
	})

	function AutoPlay(){
		$('#new_cat_but1 span').css('background','none');
		if (now==$('#new-cat_play1 li').length-1) {
			now=0;
		}
		else
		{
			now++;
		}
		$('#new_cat_but1 span').eq(now).css('background','#D70000');
		$('#new-cat_play1').animate({left:-585*now});
	}

	setInterval(AutoPlay,5000);
})

$(function (){
	$('#new_cat_but2 span:first').css('background','#EC3D73');
	var now=0;

	$('#new_cat_but2 span').click(function (){
		now=$(this).index()-1;
		$('#new_cat_but2 span').css('background','none');
		$(this).css('background','#EC3D73');
		$('#new-cat_play2').animate({left:-585*now});
	})

	function AutoPlay(){
		$('#new_cat_but2 span').css('background','none');
		if (now==$('#new-cat_play2 li').length-1) {
			now=0;
		}
		else
		{
			now++;
		}
		$('#new_cat_but2 span').eq(now).css('background','#EC3D73');
		$('#new-cat_play2').animate({left:-585*now});
	}

	setInterval(AutoPlay,5000);
})

$(function (){
	$('#new_cat_but3 span:first').css('background','#EE8527');
	var now=0;

	$('#new_cat_but3 span').click(function (){
		now=$(this).index()-1;
		$('#new_cat_but3 span').css('background','none');
		$(this).css('background','#EE8527');
		$('#new-cat_play3').animate({left:-585*now});
	})

	function AutoPlay(){
		$('#new_cat_but3 span').css('background','none');
		if (now==$('#new-cat_play3 li').length-1) {
			now=0;
		}
		else
		{
			now++;
		}
		$('#new_cat_but3 span').eq(now).css('background','#EE8527');
		$('#new-cat_play3').animate({left:-585*now});
	}

	setInterval(AutoPlay,5000);
})

$(function (){
	$('#new_cat_but4 span:first').css('background','#177BEC');
	var now=0;

	$('#new_cat_but4 span').click(function (){
		now=$(this).index()-1;
		$('#new_cat_but4 span').css('background','none');
		$(this).css('background','#177BEC');
		$('#new-cat_play4').animate({left:-585*now});
	})

	function AutoPlay(){
		$('#new_cat_but4 span').css('background','none');
		if (now==$('#new-cat_play4 li').length-1) {
			now=0;
		}
		else
		{
			now++;
		}
		$('#new_cat_but4 span').eq(now).css('background','#177BEC');
		$('#new-cat_play4').animate({left:-585*now});
	}

	setInterval(AutoPlay,5000);
})

$(function (){
	$('#new_cat_but5 span:first').css('background','#FB4460');
	var now=0;

	$('#new_cat_but5 span').click(function (){
		now=$(this).index()-1;
		$('#new_cat_but5 span').css('background','none');
		$(this).css('background','#FB4460');
		$('#new-cat_play5').animate({left:-585*now});
	})

	function AutoPlay(){
		$('#new_cat_but5 span').css('background','none');
		if (now==$('#new-cat_play5 li').length-1) {
			now=0;
		}
		else
		{
			now++;
		}
		$('#new_cat_but5 span').eq(now).css('background','#FB4460');
		$('#new-cat_play5').animate({left:-585*now});
	}

	setInterval(AutoPlay,5000);
})

$(function (){
	$('#new_cat_but6 span:first').css('background','#0964A3');
	var now=0;

	$('#new_cat_but6 span').click(function (){
		now=$(this).index()-1;
		$('#new_cat_but6 span').css('background','none');
		$(this).css('background','#0964A3');
		$('#new-cat_play6').animate({left:-585*now});
	})

	function AutoPlay(){
		$('#new_cat_but6 span').css('background','none');
		if (now==$('#new-cat_play6 li').length-1) {
			now=0;
		}
		else
		{
			now++;
		}
		$('#new_cat_but6 span').eq(now).css('background','#0964A3');
		$('#new-cat_play6').animate({left:-585*now});
	}

	setInterval(AutoPlay,5000);
		
})
$(function (){
			var now=0;
	function AutoPlay(){
		
		if (now==$('#new-cat_play7 li').length-4) {
			now=0;
		}
		else
		{
			now++;
		}
		
		$('#new-cat_play7').animate({left:-170*now},6000);
		
	}
	setInterval(AutoPlay,6000);
	})
$(function (){
			var now=0;
	function AutoPlay1(){
		
		if (now==$('#new-gr_play8 li').length-4) {
			now=0;
		}
		else
		{
			now++;
		}
		
		$('#new-gr_play8').animate({left:-170*now},6000);
		
	}
	setInterval(AutoPlay1,6000);
	})