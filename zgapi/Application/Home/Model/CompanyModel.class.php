<?php
namespace Home\Model;
use Think\Model;
class CompanyModel extends Model {
	//获取某一类的公司列表
	public function onetypecomp(){
		$gtype=trim($_GET['gtype']);
		$gtype=base64url_decode($gtype);
		//echo $gtype;die;
		$sql="";
		if(!empty($gtype) && isset($gtype)){
			$sql="SELECT * FROM  ecm_company  WHERE  gtype  LIKE  '%{$gtype}%'";
			return $this->query($sql);
			
			//return $this->where(array('gtype'=>array('like',"%".$gtype."%")))->select();
			//return $this->where(" gtype like '%{$gtype}%'")->select();
			//return $this->select();
		}else{
			return array();
		}
	}
	//获取公司详细信息
	public function getinfo(){
		$id=$_GET['id'];
		return $this->where(array('id'=>$id))->find();
	}
	
}