<?php
namespace Home\Controller;
use Think\Controller;
class CompanyController extends CommController{
  	//行业列表
    public function index(){
		$this->display();
	}
	//导航块
	public function daohang(){
		$this->display();
	}
	//获取某一行业的所有公司
	public function morestore(){
		$company=D('Company');
		$cps=$company->onetypecomp();
		$this->assign('cps',$cps);
		
		//$list=array('san'=>'gg','yi'=>'nn','er'=>'qq','si'=>'hh','wu'=>'tt','liu'=>'bb','qi'=>'qi','ba'=>'ba','jiu'=>'k','shi'=>'s');
		//$this->assign('list',$list);
		
		$this->display();
	}
	//获取公司信息
	public function storeinfo(){
		//获取公司信息
		$company=D('Company');
		$info=$company->getinfo();
		$this->assign('info',$info);
		$this->display();
	}
	//788
	public function cpinfoqbb(){
		//预约处理
		$order_id="";
		$yuyue=D('Yuyue');
		if(IS_POST){
			$post=I('post.');
			$data=$post['data'];
			$uinfo=session('uinfo');
			$data['user_id']=$uinfo['user_id'];
			$data['isnew']=$post['isnew'][0];
			$data['huxing']=$post['shi'].'室'.$post['ting'].'厅'.$post['wei'].'卫';
			$data['addtime']=time();
			$order_id=$post['order_id'];
			if($order_id){
				//更新
				$data['order_id']=$order_id;
				$yuyue->save($data);
				$this->assign('order_id',$order_id);
			}else{
				//添加预约
				$order_id=$yuyue->add($data);
				$this->assign('order_id',$order_id);
			}
		}
		$info=$yuyue->getyueyu($order_id);
		$this->assign('info',$info);
		$this->display();
	}
	//428
	public function cpinfoszb(){
		//预约处理
		$order_id="";
		$yuyue=D('Yuyue');
		if(IS_POST){
			$post=I('post.');
			$data=$post['data'];
			$uinfo=session('uinfo');
			$data['user_id']=$uinfo['user_id'];
			$data['isnew']=$post['isnew'][0];
			$data['huxing']=$post['shi'].'室'.$post['ting'].'厅'.$post['wei'].'卫';
			$data['addtime']=time();
			$order_id=$post['order_id'];
			if($order_id){
				//更新
				$data['order_id']=$order_id;
				$yuyue->save($data);
				$this->assign('order_id',$order_id);
			}else{
				//添加预约
				$order_id=$yuyue->add($data);
				$this->assign('order_id',$order_id);
			}
		}
		$info=$yuyue->getyueyu($order_id);
		$this->assign('info',$info);
		$this->display();
	}
	
	//材料合作留言
	public function hz(){
		$msg_id="";
		if(IS_POST){
			$leavemsg=D("Leavemsg");
			$post=I('post.');
			$data=$post['data'];
			$msg_id=$post['msg_id'];
			if($msg_id){
				//更新
				$data['msg_id']=$msg_id;
				$leavemsg->save($data);
				$this->assign('msg_id',$msg_id);
			}else{
				//添加
				$uinfo=session('uinfo');
				$data['user_id']=$uinfo['user_id'];
				$msg_id=$leavemsg->add($data);
				$this->assign('msg_id',$msg_id);
			}
			$info=$leavemsg->getmsg($msg_id);
			$this->assign('info',$info);
		}
		$this->display('hz');
	}
	//关于我们
	public function forus(){
		$this->display();
	}
	//加盟
	public function jiameng(){
		$this->display();
	}
}
?>