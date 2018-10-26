<?php
namespace Home\Controller;
use Think\Controller;
class CaigouController extends CommController{

	//根据条件获取采购列表
	public function getlist(){
		$caigou=D("Caigou");
		if($_GET['more']){
			$limit="0,120";
		}else{
			$limit="0,11";
		}
		$condition="";
		if($_GET['title']){
			$condition=" AND title like '%".$_GET['title']."%' ";
		}
		$infos=$caigou->searchcglist($limit,$condition);
		$this->assign('infos',$infos);
		$this->display('cglist');
	}
	//获取采购的详细信息
	public function cginfo(){
		$caigou=D('Caigou');
		$id=$_GET['id'];
		$info=$caigou->getinfo($id);
		$this->assign('info',$info);
		$this->display();
	}
	//获取品牌 信息
	public function getbrand(){
		$brand_name=$_GET['brand_name'];
		if($brand_name){
			$condition=" AND brand_name like '%{$brand_name}%' ";
		}
		$caigou=D('Caigou');
		$infos=$caigou->brand($condition);
		$this->assign('infos',$infos);
		$this->display('brands');
	}
}
?>