//图片加载
	function openImg(obj,num){
		var boxWidth = parseInt(num*800)+'px';
		$('#listBox').css('width', boxWidth);
		$('#mo').css('display','block');
	}

	function uppage(){
		var boxLength = $('#listBox').css('width');
		var leftWidth =  $('#listBox').css('left');
		var nextWidth = parseInt(leftWidth);
		nextWidth = nextWidth+800;
		$('#listBox').css('left',nextWidth+'px');
		var leavWidth = parseInt(leftWidth)+1600;
		var theEnd = -parseInt(boxLength)+800;
		if(leavWidth>0){
			$('#listBox').css('left',theEnd);
		}
	}
	function nextpage(){
		var boxLength = $('#listBox').css('width');
		var leftWidth =  $('#listBox').css('left');
		var nextWidth = parseInt(leftWidth);
		nextWidth = nextWidth-800;
		$('#listBox').css('left',nextWidth+'px');
		var leavWidth = Math.abs(parseInt(leftWidth));
		var boxWidth = Math.abs(parseInt(boxLength))-1600;
		if(leavWidth>boxWidth){
			$('#listBox').css('left','0');
		}
	}
	function closes(){
		$("#mo").hide();
		$('#listBox').css('left','0');
	}