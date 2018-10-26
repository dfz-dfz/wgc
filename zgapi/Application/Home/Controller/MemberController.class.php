<?php
namespace Home\Controller;
use Think\Controller;
class MemberController extends Controller{
  
    public function index(){
		$this->display('register');
	}
	//用户登录
	public function login(){
		if(IS_POST){
			$member=D('Member');
			$post=I('post.');
			$data=$post['data'];
			//查看此用户是否存在
			$phone_mob=$data['phone_mob'];
			$password=md5($data['password']);
			$num=$member->where(array('phone_mob'=>array('like',$phone_mob),'password'=>array('like',$password)))->count('user_id');
			if($num==0){
				$this->display();die;
			}else{
				//获取用户信息
				$uinfo=$member->field('user_id,user_name,phone_mob')->where(array(array('phone_mob'=>array('like',$phone_mob),'password'=>array('like',$password))))->find();
				session('uinfo',$uinfo);
				//cookie('uinfo',$uinfo,30*24*3600);
				//header("Location:".site_url());die;
				$this->redirect('Member/userinfo', $params, 0, '你已经登录');die;
			}
		}
		$this->display();
	}
	//个人注册
	public function ownreg(){
		if(IS_POST){
			$member=D('Member');
			$post=I('post.');
			$data=$post['data'];
			$data['password']=md5($data['password']);
			$data['user_name']= trim($data['user_name']);
            $data['email']= trim($data['email']);
			$res=$member->add($data);
			if($res){
				//echo 'ok';die;
				//跳转到个人信息页面
				//$this->success('注册成功','/Home/Member/ownreg',2);die;
				//个人信息保存session
				$member=D('Member');
				$uinfo=$member->field('user_id,user_name,phone_mob')->where(array('user_id'=>$res))->find();
				session('uinfo',$uinfo);
				$params=array('user_id'=>$res);
				$this->redirect('Member/userinfo', $params, 0, '注册成功');die;
			}else{
				//echo 'err';die;
				//回到注册页面
				//$this->redirect('/Home/Member/ownreg', 2, '注册失败...');die;
				//回到注册页面
				$params=array();
				$this->redirect('Member/ownreg', $params, 1, '注册失败');die;
				
			}
		}
		$this->display('ownreg');
	} 
	//公司注册，会员和公司一起注册
	public function gsreg(){
		if(IS_POST){
			$post=I('post.');
			$member=D('Member');
			$data=$post['data'];
			$data['reg_time']=time();
			$data['password']=md5($data['password']);
			$data['user_name']= trim($data['user_name']);
            $data['email']= trim($data['email']);
			$id=$member->add($data);
			if($id){
				//注册公司
				$company=D('Company');
				$cpdata=$post['cp'];
				$cpdata['user_id']=$id;
				$cpdata['addtime']=time();
				$cpdata['gname']=trim($cpdata['gname']);
				$cpdata['gtype']=trim($cpdata['gtype']);
				$cpdata['xiangxi']=trim($cpdata['xiangxi']);
				$cpdata['weburl']=trim($cpdata['weburl']);
				$cpdata['fanwei']=trim($cpdata['fanwei']);
				$id2=$company->add($cpdata);
				if($id2){
					//echo 'ok';die;
					//个人信息保存session
					$member=D('Member');
					$uinfo=$member->field('user_id,user_name,phone_mob')->where(array('user_id'=>$id))->find();
					session('uinfo',$uinfo);
					//跳转到个人信息页面
					$params=array('user_id'=>$id,'id'=>$id2);
					$this->redirect('Member/uacpinfo', $params, 0, '注册成功');die;
				}else{
					$member->delete($id);
					//echo 'err';die;
					//回到注册页面
					$params=array();
					$this->redirect('Member/gsreg', $params, 1, '注册失败');die;
					
				}
				
			}else{
				
				//回到注册页面
				$params=array();
				$this->redirect('Member/gsreg', $params, 1, '注册失败');die;
			}
		}
		$this->display('gsreg');
	}
	//忘记密码，密码修改
	public function setpwd(){
		if(IS_POST){
			$post=I('post.');
			$data=$post['data'];
			$data['password']=md5($data['password']);
			$member=D('Member');
			$member->where(array('phone_mob'=>array('like','%'.$data['phone_mob'].'%')))->save($data);
			$uinfo=session('uinfo');
			if($uinfo){
				session('uinfo',null);
			}
			redirect(U('Home/Member/login'), 0,'请登录...');die;
		}
		$this->display('setpwd');
	}
	//个人信息展示
	public function userinfo(){
		$uinfo=session('uinfo');
		if(!$uinfo['user_id']){
			redirect(U('Home/Member/index'), 0,'请注册...');die;
			//redirect(U('Home/Index/index'), 0,'请稍后...');
		}
		$user_id=$uinfo['user_id'];
		if($user_id){
			
		}else{
			$user_id=$_GET['user_id'];
		}
		$member=D('Member');
		$info=$member->getuserinfo($user_id);
		$this->assign('info',$info);
		$this->display('uinfo');
	}
	//个人和公司信息一起展示
	public function uacpinfo(){
		$uinfo=session('uinfo');
		if(!$uinfo['user_id']){
			redirect(U('Home/Member/index'), 0,'请注册...');die;
			//redirect(U('Home/Index/index'), 0,'请稍后...');
		}
		$member=D('Member');
		$user_id=$_GET['user_id'];
		$cpid=$_GET['id'];
		$info=$member->getuacpinfo($user_id,$cpid);
		$this->assign('info',$info);
		$this->display();
	}
	//更新个人信息
	public function upuser(){
		if(IS_POST){
			$member=D('Member');
			$post=I('post.');
			$data=$post['data'];
			$res=$member->save($data);
			if($res>=0){
				$params=array('user_id'=>$data['user_id']);
				$this->redirect('Member/userinfo', $params, 0, ' ');die;
			}
		}
	}
	//更新个人及注册公司信息
	public function upuacpinfo(){
		if(IS_POST){
			$member=D('Member');
			$company=D('Company');
			$post=I("post.");
			$data=$post['data'];
			$cpdata=$post['cp'];
			$res=$member->save($data);
			$res2=$company->save($cpdata);
			if($res>=0 && $res2>=0){
				$params=array('user_id'=>$data['user_id'],'id'=>$cpdata['id']);
				$this->redirect('Member/uacpinfo', $params, 0, ' ');die;
			}else{
				$params=array('user_id'=>$data['user_id'],'id'=>$cpdata['id']);
				$this->redirect('Member/uacpinfo', $params, 0, ' ');die;
			}
		}
	}
	//信息788、428
	public function getmsg(){
		$this->display('msg');
	}
	//手机获取验证码
	public function getveryfy(){
		$mobile=$_POST['phone_mob'];
		if(empty($mobile) || !isset($mobile)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="请输入手机号码";
			echo json_encode($res);die;
		}
		$rand=mt_rand(111111,999999);
		session('yanzhengma',$rand);
		$content="【59家居网】您的验证码是:{$rand}，打死都不要告诉任何人，10分钟内有效";  //发送内容3s
		$time='';     //发送时间，为空时是即时发送
		$res = send($mobile,$content);
		$res=array();
		$res["status"]=200;
		$res["retMsg"]="success";
		$res["retData"]=$rand;
		echo json_encode($res);die;
		
	}
	//验证验证码
	public function veryfy(){
		$veryfy=trim($_POST['veryfy']);
		$veryfy2=session('yanzhengma');
		if(empty($veryfy) || !isset($veryfy)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="请输验证码";
			echo json_encode($res);die;
		}
		//echo 'ok';die;
		if($veryfy==$veryfy2){
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]="验证成功";
			echo json_encode($res);die;
		}else{
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="验证码错误";
			echo json_encode($res);die;
		}
	}
	//验证电子邮箱格式
	public function isemal(){
		$email=$_POST['email'];
		if(is_email($email)){
			echo 'ok';die;
		}else{
			echo 'err';die;
		}
	}
	//验证用户唯一性
	public function checkname(){
		$member=D('Member');
		$user_name=trim($_POST['user_name']);
		$num=$member->where(array('user_name'=>array('like','%'.$user_name.'%')))->count('user_id');
		//echo $num;die;
		if($num>0){
			echo 'err';die;
		}else{
			echo 'ok';die;
		}
	}
	//验证手机用户的唯一性
	public function checktel(){
		$member=D('Member');
		$phone_mob=trim($_POST['phone_mob']);
		$num=$member->where(array('phone_mob'=>array('like','%'.$phone_mob.'%')))->count('user_id');
		//echo $num;die;
		if($num>0){
			echo 'err';die;
		}else{
			echo 'ok';die;
		}
	}
}
?>