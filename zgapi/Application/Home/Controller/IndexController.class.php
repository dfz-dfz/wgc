<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller{
    public function index(){
      $params=array();
      $this->redirect('Admin/Index/index', $params, 0, ' ');die;
    }
   public function daohang(){
	   $this->display();
   }
   //手册
   public function te(){
	   //Alternative PHP Cache(可选PHP缓存)
	   //APC函数,要按章APC扩展文件
	   /*$arr='YYtt';
	   if(apc_add('te',$arr)){
		   echo apc_fetch('te');
	   }else{
		   echo 'none';
	   }*/
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   die;
   }
}