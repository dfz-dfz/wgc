<?php
namespace Home\Controller;
use Think\Controller;
class ZhaojobController extends Controller{
    public function index(){
		echo 'zhaojob'.__CONTROLLER__;die;
		$this->display('register');
	}
	//注册,全部是ajax提交
	public function register(){
		if(IS_POST){
			$member=D('Member');
			$post=I('post.');
			//判断是注册还是完善注册
			$flag=$post['flag'];
			if($flag){
				//注册新用户 reg_time
				$data=$post['data'];
				$data['reg_time']=time();
				$pid=$data['p_id'];
				$data['p_id']=$data['tuijian_id'];
				if(!isset($data['p_id'])){
					$data['p_id']=0;
				}
				if(!isset($data['tuijian_id'])){
					$data['tuijian_id']=0;
				}
				$user_id=$member->add($data);
				if($user_id){
					//注册成功后为用户生成个人积分账户
					$capital=D('Capital');
					$data2['user_id']=$user_id;
					$data2['hasmoney']=100;
					$data2['last_time']=time();
					$cid=$capital->addcount($data2);
					//判断是否是推荐注册，如果是，把推荐人的积分+10
					$tuijian_id=$data['tuijian_id'];
					if($tuijian_id){
						if($pid!=0){
							$da=array();
							$da['user_id']=$pid;
							$da['jifen']=10;
							$capital=D('Capital');
							$capital->addjifen($da);
							
							$da2=array();
							$da2['p_id']=0;
							$member->where(array('user_id'=>$tuijian_id))->save($da2);
						}
						
					}
					echo $user_id;die;
				}else{
					echo 'regerr';die;
				}
			}else{
				//更新用户信息
				$data=$post['data'];
				$user_id=$data['user_id'];
				if(!empty($data['password']) && isset($data['password'])){
					$data['password']=md5($data['password']);
				}
				$res=$member->save($data);
				if($res>=0){
					echo $user_id;die;
				}else{
					echo 'uperr';die;
				}
			}
		}
		if(!empty($_GET['user_id']) && isset($_GET['user_id'])){
			$user_id=$_GET['user_id'];
			$step=$_GET['step'];
			if($step=='1'){
				$this->assign('user_id',$user_id);
				$this->display('jobreg1');
			}else if($step=='2'){
				$this->assign('user_id',$user_id);
				$this->display('jobreg2');
			}else if($step=='3'){
				$this->assign('user_id',$user_id);
				$this->display('jobreg3');
			}else if($step=='ok'){
				$this->assign('user_id',$user_id);
				$member=D('Member');
				$uinfo=$member->field('user_id,user_name,phone_mob')->where(array('user_id'=>$user_id))->find();
				session('uinfo',$uinfo);
				$this->display('regok');
			}
		}else{
			$tuijian_id=$_GET['id'];
			$p_id=$_GET['p_id'];
			if($tuijian_id){
				$this->assign('tuijian_id',$tuijian_id);
				$this->assign('p_id',$p_id);
			}
			$this->display('jobreg');
		}
		
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
				$this->redirect('Jymember/userinfo', $params, 0, '你已经登录');die;
			}
		}
		$this->display();
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
			redirect(U('Home/Zhaojob/login'), 0,'请登录...');die;
		}
		$this->display('setpwd');
	}
	//导航
	public function daohang(){
		$this->display();
	}
	//关于我们
	public function forus(){
		$this->display();
	}
	//使用说明
	public function useinfo(){
		$this->display();
	}
	public function useinfo1(){
		$this->display('useinfo1');
	}
	public function useinfo2(){
		$this->display('useinfo2');
	}
	public function useinfo3(){
		$this->display('useinfo3');
	}
	public function useinfo4(){
		$this->display('useinfo4');
	}
	public function useinfo5(){
		$this->display('useinfo5');
	}
	public function useinfo6(){
		$this->display('useinfo6');
	}
	public function te(){
		$mem=D('Member');
		$user_id=1473403832;
		//echo $mem->myteams($user_id);die;
		$info=$mem->myteamsinfo($user_id);
		echo '<pre>';
		print_r($info);
		echo '</pre>';die;
		$this->display('regok');
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
	
	//手机获取验证码
	public function getveryfy(){
		$mobile=$_POST['phone_mob'];
		$rand=mt_rand(111111,999999);
		session('yanzhengma',$rand);
		$content="【59家居网】您的验证码是:{$rand}，打死都不要告诉任何人，10分钟内有效";  //发送内容3s
		$time='';     //发送时间，为空时是即时发送
		$res = send($mobile,$content);
		echo 'ok';die;
	}
	//验证验证码
	public function veryfy(){
		$veryfy=trim($_POST['veryfy']);
		$veryfy2=session('yanzhengma');
		//echo 'ok';die;
		if($veryfy==$veryfy2){
			echo 'ok';die;
		}else{
			echo 'err';die;
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