<?php
namespace Home\Model;
use Think\Model;
class LeavemsgModel extends Model {
	//根据id获取留言信息
	public function getmsg($msg_id=""){
		if(empty($msg_id)){
			return array();
		}else{
			return $this->where(array('msg_id'=>$msg_id))->find();
		}
	}
}