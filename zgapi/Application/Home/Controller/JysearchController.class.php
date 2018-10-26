<?php
namespace Home\Controller;
use Think\Controller;
class JysearchController extends Controller{
	

	
	 //获取自己发布的活
	 public function myfabu(){
		 if(!IS_POST){die('404');}
		$search=D('Search');
		$condition="";
		$user_id=$_POST['user_id'];
		if(empty($user_id) || !isset($user_id)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="用户尚未登录";
			echo json_encode($res);die;
		}
		
		$condition.=" AND userid={$user_id} ";
		$jobs=$search->searchjobs("0,500",$condition);
		$jobs=$search->query($sql);
		if(empty($jobs)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="尚未发布活";
			echo json_encode($res);die;
		}else{
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]=$jobs;
			echo json_encode($res);die;
		}
	 }
	//抢工
	public function qg(){
		if(!IS_POST){die('404');}
	 		$id=$_POST['id'];
			$user_id=$_POST['user_id'];
			if(empty($id) || !isset($id)){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="缺失项目ID";
				echo json_encode($res);die;
			}
			if(empty($user_id) || !isset($user_id)){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="用户尚未登录";
				echo json_encode($res);die;
			}
			//扣分处理
			//扣积分
			//进行扣积分
			$capital=D('Capital');
			$kou=array();
			$kou['user_id']=$user_id;
			$kou['jifen']=10;
			$r=$capital->reduce($kou);
			if($r==='bg'){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="用户积分不够";
				echo json_encode($res);die;
			}elseif($r){
				//处理接活活的状态设置为3，并添加接活表
				$shenqing=D('Shenqing');
				$data=array();
				$data['user_id']=$user_id;
				$data['zp_id']=$id;
				$data['xingzhi']=1;//表示抢工
				$data['addtime']=time();
				$sq_id=$shenqing->add($data);
				//接活成功，设置状态
				if($sq_id){
					$sql="update ecm_search set status=3 where id={$id} ";
					$shenqing->query($sql);
					$t=time();
					$sql="INSERT INTO  `ecm_jfdetail` (`user_id`,`fenzhi`,`cause`,`addtime`) VALUES ({$data['user_id']},'-10','抢工',{$t})";
					$capital->query($sql);
					$res=array();
					$res["status"]=200;
					$res["retMsg"]="success";
					$res["retData"]="抢工成功";
					echo json_encode($res);die;
				}else{
					$res=array();
					$res["status"]=202;
					$res["retMsg"]="err";
					$res["retData"]="抢工失败";
					echo json_encode($res);die;
				}
			}else{
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="积分扣除失败";
				echo json_encode($res);die;
			}
	}
	//我的抢工信息详情
	public function myqginfo(){
		if(!IS_POST){die('404');}
		$id=trim($_POST['id']);
		if(empty($id) || !isset($id)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="缺失项目ID";
			echo json_encode($res);die;
		}
		$search=D('Search');
		$info=$search->getjobinfo($id);
		if(empty($info)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="项目不存在";
			echo json_encode($res);die;
		}else{
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]=$info;
			echo json_encode($res);die;
		}
	}
	 //接活
	 public function jiehuo(){
		if(!IS_POST){die('404');}
	 		$id=$_POST['id'];
			$user_id=$_POST['user_id'];
			if(empty($id) || !isset($id)){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="缺失项目ID";
				echo json_encode($res);die;
			}
			if(empty($user_id) || !isset($user_id)){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="用户尚未登录";
				echo json_encode($res);die;
			}
			//扣分处理
			//扣积分
			//进行扣积分
			$capital=D('Capital');
			$kou=array();
			$kou['user_id']=$user_id;
			$kou['jifen']=10;
			$r=$capital->reduce($kou);
			if($r==='bg'){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="用户积分不够";
				echo json_encode($res);die;
			}elseif($r){
				//处理接活活的状态设置为3，并添加接活表
				$shenqing=D('Shenqing');
				$data=array();
				$data['user_id']=$user_id;
				$data['zp_id']=$id;
				$data['xingzhi']=0;
				$data['addtime']=time();
				$sq_id=$shenqing->add($data);
				//接活成功，设置状态
				if($sq_id){
					$sql="update ecm_search set status=3 where id={$id} ";
					$shenqing->query($sql);
					$t=time();
					$sql="INSERT INTO  `ecm_jfdetail` (`user_id`,`fenzhi`,`cause`,`addtime`) VALUES ({$data['user_id']},'-10','接活',{$t})";
					$capital->query($sql);
					$res=array();
					$res["status"]=200;
					$res["retMsg"]="success";
					$res["retData"]="接活成功";
					echo json_encode($res);die;
				}else{
					$res=array();
					$res["status"]=202;
					$res["retMsg"]="err";
					$res["retData"]="接活失败";
					echo json_encode($res);die;
				}
			}else{
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="积分扣除失败";
				echo json_encode($res);die;
			}
	 }
	 //我的抢工
	 public function myqg(){
		 //if(!IS_POST){die('404');}
		  $search=D('Search');
		//$user_id=trim($_POST['user_id']);
		$user_id=1473403835;
		if(empty($user_id) || !isset($user_id)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="用户尚未登录";
			echo json_encode($res);die;
		}
		 $sql="select * from ecm_search where id in (select zp_id as id from ecm_shenqing where user_id={$user_id} and xingzhi=1)";
		 //echo $sql;die;
		 $jobs=$search->query($sql);
		 if(empty($jobs)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="暂无抢工";
			echo json_encode($res);die;
		}else{
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]=$jobs;
			echo json_encode($res);die;
		}
	 }
	 //我的接活
	 public function myjiehuo(){
		 if(!IS_POST){die('404');}
		 $search=D('Search');
		 $user_id=$_POST['user_id'];
		  if(empty($user_id) || !isset($user_id)){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="用户尚未登录";
				echo json_encode($res);die;
			}
		 $sql="select * from ecm_search where id in (select zp_id as id from ecm_shenqing where user_id={$user_id} and xingzhi=0)";
		 $jobs=$search->query($sql);
		  if(empty($jobs)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="暂无接活";
			echo json_encode($res);die;
		}else{
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]=$jobs;
			echo json_encode($res);die;
		}
	 }
	
	 //发布工价 ajax 提交
	 public function searchadd(){
		 if(!IS_POST){die('404');}
			 $data=I('post.');
			$user_id=$data['user_id'];
			if(empty($user_id) || !isset($user_id)){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="用户尚未登录";
				echo json_encode($res);die;
			}
			//扣分处理
			//扣积分
			//进行扣积分
			$capital=D('Capital');
			$kou=array();
			$kou['user_id']=$user_id;
			$kou['jifen']=10;
			$r=$capital->reduce($kou);
			if($r==='bg'){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="用户积分不够";
				echo json_encode($res);die;
			}elseif($r){
				$data['addtime']=date("Y-m-d" );
				$data['status']=1;//审核状态设为1未审核
				 $id=$search->searchadd($data);
				 if($id){
				 	$t=time();
					$sql="INSERT INTO  `ecm_jfdetail` (`user_id`,`fenzhi`,`cause`,`addtime`) VALUES ({$user_id},'-10','发布工价',{$t})";
					$capital->query($sql);
					$res=array();
					$res["status"]=200;
					$res["retMsg"]="success";
					$res["retData"]="发布成功";
					echo json_encode($res);die;
				 }else{
					$capital->addjifen($kou);
					$res=array();
					$res["status"]=202;
					$res["retMsg"]="err";
					$res["retData"]="发布失败";
					echo json_encode($res);die;
				 }
			}else{
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="积分扣除失败";
				echo json_encode($res);die;
			}
	 }
	//查看我的职位详情
	public function jobinfo(){
		 //if(!IS_POST){die('404');}
		//$id=trim($_POST['id']);
		$id=80;
		if(empty($id) || !isset($id)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="缺失项目ID";
			echo json_encode($res);die;
		}
		$search=D('Search');
		$info=$search->getjobinfo($id);
		if(empty($info)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="项目不存在";
			echo json_encode($res);die;
		}else{
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]=$info;
			echo json_encode($res);die;
		}
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