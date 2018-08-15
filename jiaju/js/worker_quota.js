// 页面切换
$('.list').click(function() {
	$('.wages_custom').css({
		display: 'none'
	});
	$('.wages_list').css({
		display: 'block'
	});
	$('.list').removeClass('current');
	$('.custom').addClass('current');
});

$('.custom').click(function() {
	$('.wages_list').css({
		display: 'none'
	});
	$('.wages_custom').css({
		display: 'block'
	});
	$('.custom').removeClass('current');
	$('.list').addClass('current');
});
// 页面切换 end

// 弹窗控制
$('.share_btn').click(function() {
	$('.confirm').css({
		display: 'block'
	});
});
$('.confirm').click(function() {
	$('.confirm').css({
		display: 'none'
	});
});
$('.confirm_').click(function() {
	return false;
});
// 弹窗控制 end

// 分页设置
$('.page_num').click(function(event) {
	$('.page_num').removeClass('current');
	$(this).toggleClass('current');
});
// 分页设置 end