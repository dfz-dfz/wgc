<?php
namespace Home\Model;
use Think\Model;
class CapitalModel extends Model{
	//注册的时候添加用户账户
	public function addcount($data=""){
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
	//抢工，发布扣积分
	/*
	*返回-1，表示可用积分不够
	*/
	public function reduce($data=array()){
		if(empty($data)){
			return false;
		}else{
			//用户可用积分必须足够
			$user_id=$data['user_id'];
			$row=$this->field('hasmoney')->where(array('user_id'=>$user_id))->find();
			$hasmoney=$row['hasmoney'];
			if($hasmoney>=$data['jifen']){
				$hasmoney=$hasmoney-$data['jifen'];
				$data2=array();
				$data2['hasmoney']=$hasmoney;
				$data2['user_id']=$user_id;
				$res=$this->where(array('user_id'=>$user_id))->save($data2);
				if($res>=0){
					return true;
				}else{
					return false;
				}
			}else{
				return 'bg';
			}
		}
	}
	//加积分
	public function addjifen($data=array()){
		if(empty($data)){
			return false;
		}else{
			//用户可用积分必须足够
			$user_id=$data['user_id'];
			$row=$this->field('hasmoney')->where(array('user_id'=>$user_id))->find();
			$hasmoney=$row['hasmoney'];
				$hasmoney=$hasmoney+$data['jifen'];
				$data2=array();
				$data2['hasmoney']=$hasmoney;
				$data2['user_id']=$user_id;
				$res=$this->where(array('user_id'=>$user_id))->save($data2);
				if($res>=0){
					return true;
				}else{
					return false;
				}
			
		}
	}
	//根据用户ID获取账户ID
	public function getcid($user_id=""){
		if(empty($user_id) || !isset($user_id)){
			return false;
		}else{
			$info=$this->where(array('user_id'=>$user_id))->find();
			if(empty($info)){
				return false;
			}else{
				return $info['capital_id'];
			}
		}
	}
}