<?php
namespace Home\Model;
use Think\Model;
class CareModel extends Model {

	//判定自己是否已经关注过此票
	public function is_care($zp_id="",$user_id=""){
		if(!empty($zp_id) && !empty($user_id) ){
			$where=array('zp_id'=>$zp_id,'user_id'=>$user_id);
			$num=$this->where($where)->count('care_id');
			return $num;
		}else{
			false;
		}
		
	}
	//添加关注
	public function care($data=""){
		if(empty($data)){
			return false;
		}else{
			$id=$this->add($data);
			if($id){
				return $id;
			}else{
				return false;
			}
		}
	}

}
?>