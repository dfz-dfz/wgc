<?php
namespace Home\Model;
use Think\Model;
class MemberModel extends Model {
	//获取用户个人信息
	public function getuserinfo($user_id=""){
		if(empty($user_id)){
			return array();
		}else{
			return $this->where(array('user_id'=>$user_id))->find();
		}
	}
	//获取用户以及注册公司的信息
	public function getuacpinfo($user_id="",$cpid=""){
		if(empty($user_id) || empty($cpid)){
			return array();
		}else{
			return $this->alias('m')->join('ecm_company cp ON m.user_id = cp.user_id')->field('m.user_id,m.user_name,m.email,m.phone_mob,m.position,m.position_desc,cp.id as cpid,cp.gname,cp.fanwei,cp.weburl,cp.s_province, cp.s_city, cp.s_county,cp.xiangxi')->where(array('m.user_id'=>$user_id,'cp.id'=>$cpid))->find();
		}
	}
	//获取用户已经拉取工友的人数
	public function myteams($user_id="",$jobtype=""){
		if(empty($jobtype)){
			if(empty($user_id)){
				return 0;
			}else{
				return $this->where(array('tuijian_id'=>$user_id))->count("user_id");
			}
		}else{
			if(empty($user_id)){
				return 0;
			}else{
				return $this->where(array('tuijian_id'=>$user_id,'jobtype'=>$jobtype))->count("user_id");
			}
		}
	}
	//获取用户级别
	public function mygrade($user_id=""){
		if(empty($user_id)){
			return "";
		}
		//所有
		$teams=$this->myteams($user_id);
		//泥水工1  电焊工3 木工5 扇灰工4 杂工14 水电工13
		$jobtype=1;
		$teams1=$this->myteams($user_id,$jobtype);
		$jobtype=3;
		$teams2=$this->myteams($user_id,$jobtype);
		$jobtype=4;
		$teams3=$this->myteams($user_id,$jobtype);
		$jobtype=5;
		$teams4=$this->myteams($user_id,$jobtype);
		$jobtype=13;
		$teams5=$this->myteams($user_id,$jobtype);
		$jobtype=14;
		$teams6=$this->myteams($user_id,$jobtype);
		//级别
		$grade=array();
		//($teams1>=3 && $teams1<10) && ($teams2>=3 && $teams2<10) && ($teams3>=3 && $teams3<10) && ($teams4>=3 && $teams4<10) && ($teams5>=3 && $teams5<10) && ($teams6>=3 && $teams6<10)
		//($teams1>=10 && $teams1<20) && ($teams2>=10 && $teams2<20) && ($teams3>=10 && $teams3<20) && ($teams4>=10 && $teams4<20) && ($teams5>=10 && $teams5<20) && ($teams6>=10 && $teams6<20)
		//($teams1>=20 && $teams1<40) && ($teams2>=20 && $teams2<40) && ($teams3>=20 && $teams3<40) && ($teams4>=20 && $teams4<40) && ($teams5>=20 && $teams5<40) && ($teams6>=20 && $teams6<40)
		//($teams1>=40) && ($teams2>=40) && ($teams3>=40) && ($teams4>=40) && ($teams5>=40) && ($teams6>=40)
		if(($teams1>=3 && $teams1<10) && ($teams2>=3 && $teams2<10) && ($teams3>=3 && $teams3<10) && ($teams4>=3 && $teams4<10) && ($teams5>=3 && $teams5<10) && ($teams6>=3 && $teams6<10)){
			$grade['grade_name']="项目经理A级";
			$grade['grade_id']=6;
		}elseif(($teams1>=10 && $teams1<20) && ($teams2>=10 && $teams2<20) && ($teams3>=10 && $teams3<20) && ($teams4>=10 && $teams4<20) && ($teams5>=10 && $teams5<20) && ($teams6>=10 && $teams6<20)){
			$grade['grade_name']="项目经理B级";
			$grade['grade_id']=7;
		}elseif(($teams1>=20 && $teams1<40) && ($teams2>=20 && $teams2<40) && ($teams3>=20 && $teams3<40) && ($teams4>=20 && $teams4<40) && ($teams5>=20 && $teams5<40) && ($teams6>=20 && $teams6<40)){
			$grade['grade_name']="项目经理C级";
			$grade['grade_id']=8;
		}elseif(($teams1>=40) && ($teams2>=40) && ($teams3>=40) && ($teams4>=40) && ($teams5>=40) && ($teams6>=40)){
			$grade['grade_name']="项目经理D级";
			$grade['grade_id']=9;
		}elseif($teams<3){
			$grade['grade_name']="普通用户";
			$grade['grade_id']=1;
		}elseif($teams>=3 && $teams<10){
			$grade['grade_name']="组长";
			$grade['grade_id']=2;
		}elseif($teams>=10 && $teams<20){
			$grade['grade_name']="班长";
			$grade['grade_id']=3;
		}elseif($teams>=20 && $teams<40){
			$grade['grade_name']="工长";
			$grade['grade_id']=4;
		}elseif($teams>=40){
			$grade['grade_name']="队长";
			$grade['grade_id']=5;
		}
		return $grade;
	}
	//根据用户级别id获取权限信息
	public function getpower($grade_id=""){
		if(empty($grade_id)){
			return array();
		}else{
			$sql="SELECT * FROM ecm_power WHERE grade_id={$grade_id}";
			return $this->query($sql);
		}
	}
	//获取自己拉取的工友（详情）
	public function myteamsinfo($user_id=""){
		if(empty($user_id)){
			return array();
		}else{
			return $this->where(array('tuijian_id'=>$user_id,'p_id'=>0))->select();
		}
	}
	//获取自己拉取的工友（详情）
	public function nmyteamsinfo($user_id=""){
		if(empty($user_id)){
			return array();
		}else{
			return $this->where(array('tuijian_id'=>$user_id,'p_id'=>$user_id))->select();
		}
	}
	//获取自己的个人积分
	public function getjifen($user_id=""){
		if(empty($user_id)){
			return 0;
		}else{
			$sql="SELECT * FROM ecm_capital WHERE user_id={$user_id}";
			$info=$this->query($sql);
			return $info[0]['hasmoney'];
		}
	}
}