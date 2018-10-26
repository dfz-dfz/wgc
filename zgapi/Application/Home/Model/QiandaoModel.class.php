<?php
namespace Home\Model;
use Think\Model;
class QiandaoModel extends Model{
	//根据用户传入的用户user_id获取所有的签到信息
	public function qiandaoinfo($user_id=""){
		if(empty($user_id) || !isset($user_id)){
			return array();
		}else{
			$user_id=trim($user_id);
			$infos=$this->where(array('uid'=>array('like','%'.$user_id.'%')))->select();
			if(empty($infos) || !isset($infos)){
				return array();
			}else{
				return $infos;
			}
		}
	}
}