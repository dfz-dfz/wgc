<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    // public function index(){
    //   if(empty($_SESSION['fab_admin']['role_name'])){
    //     $rolename=M('role')->where(array('roleid'=>$_SESSION['fab_admin']['roleid']))->field('rolename')->find();
    //     $_SESSION['fab_admin']['role_name']=$rolename['rolename'];
    //   }
    //   $this->display();
    // }
    public function index(){
    	$this->display('index');
    }
}
?>