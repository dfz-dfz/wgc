<?php
namespace Home\Controller;
use Think\Controller;
class ViewController extends Controller{
    public function te(){
		$this->display('gongzuoquan');
	}
	public function view(){
		if(IS_POST){
			$data=I('post.');
	 		$sid=$data['sid'];
			$user_id=$data['user_id'];
			if(empty($sid) || !isset($sid)){
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
			$view=D("View");
			$data['addtime']=time();
			$id=$view->add($data);
			if($id){
				$res=array();
				$res["status"]=200;
				$res["retMsg"]="success";
				$res["retData"]="评论成功";
				echo json_encode($res);die;
			}else{
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="评论失败";
				echo json_encode($res);die;
			}
	 	}else{
	 		$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="请post方式提交数据";
			echo json_encode($res);die;
	 	}
	
	}
	public function myview(){
		$view=D("View");
		//$uinfo=session('uinfo');
		//$user_id=$uinfo['user_id'];
		$user_id=trim($_GET['user_id']);
		if(empty($user_id) || !isset($user_id)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="用户尚未登录";
			echo json_encode($res);die;
		}
		
		$pjs=$view->getview(" AND `ecm_view`.`user_id` = {$user_id} ","","","");
		if(empty($pjs)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="暂无评论";
			echo json_encode($res);die;
		}else{
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]=$pjs;
			echo json_encode($res);die;
		}
		//$this->assign('pjs',$pjs);
		//$this->display('myview');
	}
	public function viewinfo(){
		//$v_id=trim($_GET['v_id']);
		//$user_id=trim($_GET['user_id']);
		$v_id=1;
		$user_id=1473403835;
		if(empty($user_id) || !isset($user_id)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="用户尚未登录";
			echo json_encode($res);die;
		}
		if(empty($v_id) || !isset($v_id)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="没有指定评论记录ID,无法查询";
			echo json_encode($res);die;
		}
		
		//$uinfo=session('uinfo');
		//$user_id=$uinfo['user_id'];
		$condition=" AND `ecm_view`.`user_id`={$user_id} ";
		
		$condition.=" AND `ecm_view`.`v_id`={$v_id} ";
		
		$view=D("View");
		//$uinfo=session('uinfo');
		//$user_id=$uinfo['user_id'];
		$pjs=$view->getview($condition,"","","");
		if(empty($pjs)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="评论不存在";
			echo json_encode($res);die;
		}else{
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]=$pjs;
			echo json_encode($res);die;
		}
		//$this->assign('pjs',$pjs);
		//echo '<pre>';
		//print_r($pjs);
		//echo '<pre>';die;
		//$this->display();
	}
}