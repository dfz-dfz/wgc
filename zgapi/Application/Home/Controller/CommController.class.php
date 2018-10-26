<?php
namespace Home\Controller;
use Think\Controller;
class CommController extends Controller {

	//判断用户是否已经登录
 public function _initialize(){
	 //存在cookie，不存在session，赋值session
	 $uinfo=session('uinfo');
	if(!$uinfo['user_id']){
		redirect(U('Home/Member/index'), 0,'请注册...');die;
		//redirect(U('Home/Index/index'), 0,'请稍后...');
	}
 }

}
?>