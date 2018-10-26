<?php
namespace Home\Model;
use Think\Model;
class CaigouModel extends Model {
	public function searchcglist($limit="",$condition=""){
		$sql="select * from ecm_caigou where 1=1 ";
		if(empty($limit)){
			$limit="0,200";
		}else{
			if(!empty($condition)){
				$sql.=$condition;
			}
		}
		
		$sql.=" ORDER BY id desc LIMIT ".$limit;
		return $this->query($sql);
	}
	//根据id获取信息
	public function getinfo($id=""){
		if(empty($id)){
			return array();
		}else{
			return $this->where(array('id'=>$id))->find();
		}
	}
	//获取品牌信息
	public function brand($condition=""){
			$sql="select * from ecm_brand";
		if(!empty($condition) && isset($condition)){
			$sql="select * from ecm_brand where 1=1 ".$condition;
		}
		
		return $this->query($sql);
	}
}