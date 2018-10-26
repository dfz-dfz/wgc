<?php
namespace Home\Controller;
use Think\Controller;
class SearchController extends CommController{

	 //获取招聘信息
	 public function jobslist(){
		 $search=D("Search");
		 $more=$_GET['more'];
		 if($more){
			 $limit='all';
		 }else{
			 $limit='0,11';
		 }
		 $jobs=$search->searchjobs($limit);
		 $this->assign('jobs',$jobs);
		 $this->display('joblist');
	 }
	//查看职位详细信息
	public function jobinfo(){
		$id=$_GET['id'];
		$search=D('Search');
		 $flag="zw";
		 $this->assign('flag',$flag);
		$info=$search->getjobinfo($id);
		$this->assign('info',$info);
		$this->display();
	}
	public function getcompinfo(){
		$user_id=$_GET['user_id'];
		$id=$_GET['id'];
		$search=D('Search');
		$cpinfo=$search->getcompany($user_id,$id);
		$this->assign('cpinfo',$cpinfo);
		 $flag="cp";
		 $this->assign('flag',$flag);
		$this->display('compinfo');
	}
}
?>