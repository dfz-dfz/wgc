<?php
namespace Home\Model;
use Think\Model;
class YuyueModel extends Model {
	//根据id获取预约信息
	public function getyueyu($order_id=""){
		if(empty($order_id)){
			return array();
		}else{
			return $this->where(array('order_id'=>$order_id))->find();
		}
		
	}
}