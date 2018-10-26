<?php
namespace Home\Controller;
use Think\Controller;
class JyController extends Controller {

//判断用户是否已经登录
 public function _initialize(){
	$uinfo=session('uinfo');
	if(!$uinfo['user_id']){
		redirect(U('Home/Zhaojob/register'), 0,'请注册...');die;
		//redirect(U('Home/Zhaojob/index'), 0,'请稍后...');
	 }
 }

}
?>