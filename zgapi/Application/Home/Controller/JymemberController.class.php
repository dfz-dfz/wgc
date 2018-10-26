<?php
namespace Home\Controller;
use Think\Controller;
class JymemberController extends Controller{
	public function te(){
		tuisong();
	}
	//根据用户ID获取member表utype和头像
	public function getUtImg(){
		if(!IS_POST){die('404');}
		$user_id=$_POST['uid'];
		if(empty($user_id)){
			die('404');
		}
		$info=M('member')->field('utype,userphoto')->where(array('user_id'=>$user_id))->find();
		$res=array();
		$res["status"]=200;
		$res["retMsg"]="success";
		$res["retData"]=$info;
		echo json_encode($res);die;
	}
	//根据用户ID和项目ID获取用户utype
	public function getUtypeByid(){
		if(!IS_POST){die('404');}
		$p_id=I('post.p_id');
		$user_id=I('post.user_id');
		//如果用户是项目的所有者，即为公司管理员
		$num=M('project')->where(array('user_id'=>$user_id,'prj_id'=>$p_id))->count();
		if($num>0){
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]=1;
			echo json_encode($res);die;
		}
		$utype=M('usertoproj')->where(array('user_id'=>$user_id,'p_id'=>$p_id))->getField('utype');
		$res=array();
		$res["status"]=200;
		$res["retMsg"]="success";
		$res["retData"]=$utype;
		echo json_encode($res);die;
	}
	//推荐工作给好友
	public function tuijian(){
		if(!IS_POST){die('404');}
		$user_name = $_POST['user_name']; 
		$t=time();
		$addtime =''.$t.'';
		$receiver = $_POST['receiver']; 
		unset($_POST['receiver']);
		$_POST['addtime']=$addtime;
		
		$sender = $user_name;
		$mtype ='1';
		$status ='0';
		
		
		//添加推荐
		$id=M('Recomjob')->add($_POST);
		if(id){
			//记录推荐消息
			$msg=array('p_id'=>$id,'mtype'=>$mtype,'sender'=>$sender,'receiver'=>$receiver,'status'=>$status,'addtime'=>$addtime);
			$mid=M('recmsg')->add($msg);
			if($mid){
				$res=array();
				$res["status"]=200;
				$res["retMsg"]="success";
				$res["retData"]="推荐成功";
				echo json_encode($res);die;
			}else{
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="推荐失败";
				echo json_encode($res);die;
			}
		}else{
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="推荐失败";
			echo json_encode($res);die;
		}
	}
	//根据用户名（手机号）获取接收到的推荐信息
	public function getrecmsg(){
		if(!IS_POST){die('404');}
		$user_name=$_POST['user_name'];
		if(empty($user_name)){
			die('404');
		}
		$type=intval($_GET['type']);
		$res="";
		switch($type){
			case 0:
				//未读取的
				$res=M('recmsg')->alias('m')->join('ecm_recomjob r ON m.p_id = r.recom_id')->field('m.id,m.sender,m.addtime,r.recom_id,r.name,r.user_name,r.prj_name,r.shijian,r.didian,r.reason,r.shixiao,r.ps,r.baojia')->where(array('m.receiver'=>"{$user_name}",'m.mtype'=>'1','m.status'=>'0'))->select();
				break;
			case 1:
				//已读取的
				$res=M('recmsg')->alias('m')->join('ecm_recomjob r ON m.p_id = r.recom_id')->field('m.id,m.sender,m.addtime,r.recom_id,r.name,r.user_name,r.prj_name,r.shijian,r.didian,r.reason,r.shixiao,r.ps,r.baojia')->where(array('m.receiver'=>"{$user_name}",'m.mtype'=>'1','m.status'=>'1'))->select();
				break;
			case 2:
				//全部
				$res=M('recmsg')->alias('m')->join('ecm_recomjob r ON m.p_id = r.recom_id')->field('m.id,m.sender,m.addtime,r.recom_id,r.name,r.user_name,r.prj_name,r.shijian,r.didian,r.reason,r.shixiao,r.ps,r.baojia')->where(array('m.receiver'=>"{$user_name}",'m.mtype'=>'1'))->select();
				break;
		}
		$r=array();
		$r["status"]=200;
		$r["retMsg"]="success";
		$r["retData"]=$res;
		echo json_encode($r);die;
	}
	//获取签到信息
	public function qiandao(){
		//获取用户名称和工种
		if(!IS_POST){die('404');}
		$user_id=trim($_POST['user_id']);
		$kid=intval($_POST['kid']);
		$Qiandao=D('Qiandao');
		$infos=$Qiandao->qiandaoinfo($user_id,$kid);
		if(empty($infos)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="暂无签到信息";
			echo json_encode($res);die;
		}
		
		
		//分割多个图像字串
		foreach($infos as $k=>$v){
			/*$userPhoto=trim($v['UserPhoto'],',');
			$imgarr=explode(",",$userPhoto);
			foreach($imgarr as $key=>$val){
				if(empty($val)){
					unset($imgarr[$key]);
				}
			}*/
			//获取用户名称及工种
			//根据用户ID获取
			$member=D('Member');
			$utype=$member->where(array('user_id'=>$v['uid']))->getField('utype');
			switch($utype){
				case 1:
					$sql="SELECT distinct  j.`jobtype_name`,m.`real_name`,g.`name` FROM `ecm_member` m JOIN `ecm_jobtype` j ON m.`jobtype`=j.`jobtype_id` JOIN `ecm_gongyingshang` g ON m.`user_id`=g.`user_id` WHERE m.`user_id`={$v['uid']}";
					$uinfs=$Qiandao->query($sql);
					$uinf=$uinfs[0];
					//$infos[$k]['img']=$imgarr;
					$infos[$k]['jobtype_name']=$uinf['jobtype_name'];
					$infos[$k]['name']=$uinf['name'];
					break;
				case 2:
					$sql="SELECT distinct  j.`jobtype_name`,m.`real_name`,b.`name` FROM `ecm_member` m JOIN `ecm_jobtype` j ON m.`jobtype`=j.`jobtype_id` JOIN `ecm_bangongrenyuan` b ON m.`user_id`=b.`user_id` WHERE m.`user_id`={$v['uid']}";
					$uinfs=$Qiandao->query($sql);
					$uinf=$uinfs[0];
					//$infos[$k]['img']=$imgarr;
					$infos[$k]['jobtype_name']=$uinf['jobtype_name'];
					$infos[$k]['name']=$uinf['name'];
					break;
				case 3:
					$sql="SELECT distinct  j.`jobtype_name`,m.`real_name`,g.`name` FROM `ecm_member` m JOIN `ecm_jobtype` j ON m.`jobtype`=j.`jobtype_id` JOIN `ecm_gongyingshang` g ON m.`user_id`=g.`user_id` WHERE m.`user_id`={$v['uid']}";
					$uinfs=$Qiandao->query($sql);
					$uinf=$uinfs[0];
					//$infos[$k]['img']=$imgarr;
					$infos[$k]['jobtype_name']=$uinf['jobtype_name'];
					$infos[$k]['name']=$uinf['name'];
					break;
			}
			$sql="SELECT distinct  j.`jobtype_name`,m.`real_name` FROM `ecm_member` m JOIN `ecm_jobtype` j ON m.`jobtype`=j.`jobtype_id` WHERE m.`user_id`={$v['uid']}";
			$uinfs=$Qiandao->query($sql);
			$uinf=$uinfs[0];
			//$infos[$k]['img']=$imgarr;
			$infos[$k]['jobtype_name']=$uinf['jobtype_name'];
			//$infos[$k]['real_name']=$uinf['real_name'];
		}
		
		
		//获取用户名称及工种
		$infos["status"]=200;
		$infos["retMsg"]="success";
		echo json_encode($infos);die;
	}
	
	
	//工程添加
	public function projectadd(){
		if(!IS_POST){die('404');}
		$data=I('post.');
		$Project=D("Project");
		$timsType=$data['timsType'];
		$data['addtime']=$timsType;
		$user_id=trim($data['user_id']);
		$prj_name=trim($data['prj_name']);
		$pre_price=trim($data['pre_price']);
		$prj_price=trim($data['prj_price']);
		$prj_quanty=trim($data['prj_quanty']);
		if(empty($user_id)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="用户ID为空";
			echo json_encode($res);die;
		}
		if(empty($prj_name)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="请输入项目名称";
			echo json_encode($res);die;
		}
		if(empty($pre_price)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="请输入工程预计报价";
			echo json_encode($res);die;
		}
		if(empty($prj_price)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="请输入工程款";
			echo json_encode($res);die;
		}
		if(empty($prj_quanty)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="请输入工程量";
			echo json_encode($res);die;
		}
		$status=intval($data['status']);
		switch($status){
			case 0:
				$data['status']='2';
				break;
			case 1:
				$data['status']='1';
				break;
			case 2:
				$data['status']='2';
				break;
			default:
				$data['status']='2';
		}
		//取出时间戳标示符，更新关联的成员表  项目图片表  $timsType
		unset($data['timsType']);
		$id=M('usertoproj')->where(array('addtime'=>$timsType))->getField('id');
		if($id){
			//添加工程
			$p_id=$Project->add($data);
			if($p_id){
				$d=array('p_id'=>$p_id);
				//更新成员表
				$r=M('usertoproj')->where(array('addtime'=>$timsType))->save($d);
				if($r){
					$res=array();
					$res["status"]=200;
					$res["retMsg"]="success";
					$res["retData"]="工程发布成功";
					echo json_encode($res);die;
				}else{
					$res=array();
					$res["status"]=202;
					$res["retMsg"]="err";
					$res["retData"]="关联成员失败";
					echo json_encode($res);die;
				}
				//更新图片表
				$tp=M('projimg')->where(array('addtime'=>$timsType))->save($d);
				if($tp){
					$res=array();
					$res["status"]=200;
					$res["retMsg"]="success";
					$res["retData"]="工程发布成功";
					echo json_encode($res);die;
				}else{
					$res=array();
					$res["status"]=202;
					$res["retMsg"]="err";
					$res["retData"]="图片更新失败";
					echo json_encode($res);die;
				}
			}else{
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="工程发布失败";
				echo json_encode($res);die;
			}
		
		}else{
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="工程人员不存在";
			echo json_encode($res);die;
		}
	
		
	}
	//工程项目成员关联表的记录操作   接口传参数  user_id  utype   addtime
	public function usertoproj(){
		//echo time();die;  
		if(!IS_POST){die('404');}
		$data=I('post.');
		//时间戳
		$addtime=$data['addtime'];
		$user_id_utype=trim($data['user_id_utype']);
		if(empty($user_id_utype) || !isset($user_id_utype)){
					die(404);
		}
		if($data['action']=='add'){
			//切割用户
			$users=explode(",", $user_id_utype);
			foreach($users as $key=>$user){
				$user=explode("|", $user);
				$user_id=$user[0];
				$utype=$user[1];
				//判断用户是否已经存在，存在跳过
				$num=M('usertoproj')->where(array('addtime'=>$addtime,'user_id'=>$user_id))->count('id');
				if($num>0){
					//存在跳过
				}else{
					$d=array('user_id'=>$user_id,'utype'=>$utype,'addtime'=>$addtime);
					$id=M('usertoproj')->add($d);
					if($id){
					}else{
						$res=array();
						$res["status"]=202;
						$res["retMsg"]="err";
						$res["retData"]="添加失败";
						echo json_encode($res);die;
					}
				}
			}
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]="添加成功";
			echo json_encode($res);die;
		}else{
			//切割用户
			$users=explode(",", $user_id_utype);
			foreach($users as $key=>$user){
				$user=explode("|", $user);
				$user_id=$user[0];
				$utype=$user[1];
				$num=M('usertoproj')->where(array('addtime'=>$addtime,'user_id'=>$user_id))->count('id');
				if($num>0){
					$r=M('usertoproj')->where(array('addtime'=>$addtime,'user_id'=>$user_id))->delete();
					if($r){
						
					}else{
						$res=array();
						$res["status"]=202;
						$res["retMsg"]="err";
						$res["retData"]="删除失败";
						echo json_encode($res);die;
					}
				}
			}
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]="删除成功";
			echo json_encode($res);die;
		}
	}
	//项目图片添加
	public function prjImg(){
		if(!IS_POST){die('404');}
		$addtime= I('post.addtime');
		$file = $_FILES['img'];
		if ($file['error'] != UPLOAD_ERR_OK)
		{
			echo '上传失败';
		}
		$info=upload($file);
		$pimg='./Uploads/'.$info['savepath'].$info['savename'];
		if(!$pimg && (empty($addtime) || !isset($addtime))){
			die('404');
		}
		$data=array('pimg'=>$pimg,'addtime'=>$addtime);
		$id=M('projimg')->add($data);
		if($id){
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]='图片添加成功';
			echo json_encode($res);die;
		}else{
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]='图片添加失败';
			echo json_encode($res);die;
		}		
	}
	//根据时间戳 或者 项目ID 获取项目图片
	public function getImgByti(){
		if(!IS_POST){die('404');}
		$p_id=I('post.p_id');
		$addtime=I('post.addtime');
		if((empty($p_id) || !isset($p_id)) && (empty($addtime) || !isset($addtime))){
			die('404');
		}
		if(!empty($p_id) && isset($p_id)){
			//根据项目ID获取图片
			$img=M('projimg')->where(array('p_id'=>$p_id))->select();
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]=$img;
			echo json_encode($res);die;
		}else{
			//根据时间戳获取图片
			$img=M('projimg')->where(array('addtime'=>$addtime))->select();
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]=$img;
			echo json_encode($res);die;
		}
	}
	//获取用户项目经纬度
	public function lonAndlat(){
		if(!IS_POST){die('404');}
		$user_id=$_POST['user_id'];
		$where['user_id']=array('eq',$user_id);
		$data=M('project')->where($where)->field('prj_id,jingdu,weidu')->select();
		$res=array();
		$res["status"]=200;
		$res["retMsg"]="success";
		$res["retData"]=$data;
		echo json_encode($res);die;
	}
	//获取项目的所有成员
	public function projUser(){
		if(!IS_POST){die('404');}
		$p_id=$_POST['p_id'];
		$where['p_id']=array('eq',$p_id);
		$uinfos=M('usertoproj')->where($where)->field('user_id')->select();
		foreach($uinfos as $key=>$val){
			$user_id=$val['user_id'];
			$name=M('bangongrenyuan')->where(array('user_id'=>$user_id))->getField('name');
			$userphoto=M('member')->where(array('user_id'=>$user_id))->getField('userphoto');
			$uinfos[$key]['name']=$name;
			$uinfos[$key]['userphoto']=$userphoto;
		}
		$res=array();
		$res["status"]=200;
		$res["retMsg"]="success";
		$res["retData"]=$uinfos;
		echo json_encode($res);die;
	}
	//获取工程关联成员
	public function userpdetail(){
		if(!IS_POST){die('404');}
		$addtime=I('post.addtime');
		//时间戳
		//$addtime=$data['addtime'];
		if(empty($addtime) || !isset($addtime)){
			die('404');
		}
		//根据时间戳获取用户列表
		$w1['addtime']= array('eq',$addtime);
		$w1['utype']= array('eq',1);
		$w2['addtime']= array('eq',$addtime);
		$w2['utype']= array('eq',2);
		$gl=M('usertoproj')->where($w1)->select();
		
		$pt=M('usertoproj')->where($w2)->select();
		foreach($gl as $key=>$val){
			$user_id=$val['user_id'];
			$name=M('bangongrenyuan')->where(array('user_id'=>$user_id))->getField('name');
			$userphoto=M('member')->where(array('user_id'=>$user_id))->getField('userphoto');
			$gl[$key]['name']=$name;
			$gl[$key]['userphoto']=$userphoto;
		}
		foreach($pt as $key=>$val){
			$user_id=$val['user_id'];
			$name=M('bangongrenyuan')->where(array('user_id'=>$user_id))->getField('name');
			$userphoto=M('member')->where(array('user_id'=>$user_id))->getField('userphoto');
			$pt[$key]['name']=$name;
			$pt[$key]['userphoto']=$userphoto;
		}
		$res=array();
		$res["status"]=200;
		$res["retMsg"]="success";
		$res["retData"]=array('mg'=>$gl,'cm'=>$pt);
		echo json_encode($res);die;
	}
	//根据用户ID获取用户项目完成情况，已完成，未完成
	public function projstatus(){
		if(!IS_POST){die('404');}
		$user_id=$_POST['user_id'];
		$utyp=$_POST['utype'];
		if($utyp>2){
			//还需家一个条件Utype
			$w1['status']=array('eq',1);
			$w1['uid']=array('eq',$user_id);
			//$w1['utype']='1';
			$w1['utype']=$utyp;
			
			$w2['status']=array('eq',2);
			$w2['uid']=array('eq',$user_id);
			//$w2['utype']='1';
			$w2['utype']=$utyp;
			
			$f = D('ProjectCountView')->where($w1) -> count();
			$w = D('ProjectCountView')->where($w2) -> count();
			$res = array("status"=>200,'show'=>$f,'hide'=>$w);
			echo json_encode($res);die;
			
		}else{
			//根据普通员工，获取项目ID（数组），再根据项目ID，获取已完成，未完成情况
			$p_ids1=M('usertoproj')->where(array('user_id'=>$user_id,'utype'=>1))->select();
			$p_ids2=M('usertoproj')->where(array('user_id'=>$user_id,'utype'=>2))->select();
			$f1=0;
			$n1=0;
			foreach($p_ids1 as $key=>$val){
				$stu=M('project')->where(array('prj_id'=>$val['p_id']))->getField('status');
				switch($stu){
					case 1:
						$f1++;
						break;
					case 2:
						$n1++;
						break;
				}
			}
			$f2=0;
			$n2=0;
			foreach($p_ids2 as $key=>$val){
				$stu=M('project')->where(array('prj_id'=>$val['p_id']))->getField('status');
				switch($stu){
					case 1:
						$f2++;
						break;
					case 2:
						$n2++;
						break;
				}
			}
			$res = array("status"=>200,'show'=>$f1+$f2,'hide'=>$n1+$n2);
			echo json_encode($res);die;
		}
		
		/*if($utyp > 2){
			M('project')->alias('p')->join('ecm_usertoproj u ON p.prj_id=u.p_id')->
		}else{
			
		}*/
		
	}
	/*//获取工程关联成员
	public function userpdetail(){
		if(!IS_POST){die('404');}
		$data=I('post.');
		//时间戳
		$addtime=trim($data['addtime']);
		if(empty($addtime) || !isset($addtime)){
			die(404);
		}
		//根据时间戳获取用户列表
		$gl=M('usertoproj')->where(array('addtime'=>$addtime,'utype'=>1))->select();
		$pt=M('usertoproj')->where(array('addtime'=>$addtime,'utype'=>2))->select();
		$res=array();
		$res["status"]=200;
		$res["retMsg"]="success";
		$res["retData"]=array('mg'=>$gl,'cm'=>$pt);
		echo json_encode($res);die;
	}*/
	//更新个人信息
	public function upuinfo(){
		if(!IS_POST){die('404');}
		$member=D('Member');
			$data=I('post.');
			//$data=$post['data'];
			$user_id=trim($data['user_id']);
			if(empty($user_id) || !isset($user_id)){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="用户尚未登录";
				echo json_encode($res);die;
			}
			$res=$member->save($data);
			if($res>=0){
				$res=array();
				$res["status"]=200;
				$res["retMsg"]="success";
				$res["retData"]="发布成功";
				echo json_encode($res);die;
				
			}else{
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="发布失败";
				echo json_encode($res);die;
			}
	}
	
	//充值提现
	public function moneydeal(){
		if(!IS_POST){die('404');}
		//
		$data=I('post.');
		$user_id=$data['user_id'];
		$capital_id="";
		$paycount=$data['paycount'];
		$order_id=$data['order_id'];
		$deal=$data['deal'];
		$paytype=$data['paytype'];
		$fenzhi=$data['fenzhi'];
		$cause="";
		$addtime=time();
		//获取用户账户ID
		$capital=D('Capital');
		$capital_id=$capital->getcid($user_id);
		if($capital_id){
			$data['capital_id']=$capital_id;
		}else{
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="用户不存在";
			echo json_encode($res);die;
		}
		//处理原因
		$deal=$data['deal'];
		switch($deal){
			case 1:
				$cause='充值';
				break;
			case 2:
				$cause='提现';
				break;
		}
		//积分金额的变动
		$kou=array();
		$kou['jifen']=intval($data['fenzhi']);
		$kou['user_id']=$user_id;
		
		//添加明细表
		$sql="INSERT INTO  `ecm_jfdetail` (`user_id`,`capital_id`,`paycount`,`order_id`,`deal`,`paytype`,`fenzhi`,`cause`,`addtime`) VALUES ({$user_id},{$capital_id},'{$paycount}','{$order_id}',{$deal},{$paytype},'{$fenzhi}','{$cause}',{$addtime})";
		$rs=$capital->execute($sql);
		if($rs){
			switch($deal){
				case 1:
					//$cause='充值';
					$kou['jifen']='+'.$kou['jifen'];
					$capital->addjifen($kou);
					$res=array();
					$res["status"]=200;
					$res["retMsg"]="success";
					$res["retData"]="充值成功";
					echo json_encode($res);die;
					break;
				case 2:
					//$cause='提现';
					$kou['jifen']='-'.$kou['jifen'];
					$r=$capital->reduce($kou);
					if($r==='bg'){
						$res=array();
						$res["status"]=202;
						$res["retMsg"]="err";
						$res["retData"]="用户积分不够";
						echo json_encode($res);die;
					}else if($r){
						$res=array();
						$res["status"]=200;
						$res["retMsg"]="success";
						$res["retData"]="提现成功";
						echo json_encode($res);die;
					}else{
						$res=array();
						$res["status"]=202;
						$res["retMsg"]="err";
						$res["retData"]="提现失败";
						echo json_encode($res);die;
					}	
					break;
			}
		}else{
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="添加记录有误";
			echo json_encode($res);die;
		}
	}
	//发布求职 user_id=1473403832;
	public function qiuzhi(){
		if(!IS_POST){die('404');}
		$member=D('Member');
			$data=I('post.');
			$user_id=trim($data['user_id']);
			if(empty($user_id) || !isset($user_id)){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="用户不存在";
				echo json_encode($res);die;
			}
			//扣积分
			//进行扣积分
			$capital=D('Capital');
			$kou=array();
			$kou['user_id']=$user_id;
			$kou['jifen']=10;
			$capital_id=$capital->getcid($user_id);
			$r=$capital->reduce($kou);
			if($r==='bg'){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="用户积分不够";
				echo json_encode($res);die;
			}elseif($r){
				$data['is_show']=1;
				$res=$member->save($data);
				if($res>=0){
					$t=time();
					$sql="INSERT INTO  `ecm_jfdetail` (`user_id`,`capital_id`,`fenzhi`,`cause`,`addtime`) VALUES ({$user_id},{$capital_id},'-10','发布求职',{$t})";
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
				echo json_encode($res);die;
			}else{
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="积分扣除失败";
				echo json_encode($res);die;
			}	
		
	}
	//发布求职 user_id=1473403832;
	//发布求职
	public function qiuzhi2(){
		if(IS_POST){
			$data=I('post.data');
			$user_id=trim($data['user_id']);
			if(empty($user_id) || !isset($user_id)){
				echo 'err';die;
			}
			//看看用户是否存在账户，没有自动为用户创建账户
			$capt=M('capital')->where(array('user_id'=>$user_id))->find();
			if(empty($capt)){
				$cp=array('user_id'=>$user_id,'hasmoney'=>100,'last_time'=>time());
				$cpid=M('capital')->add($cp);
				if($cpid){
					$jf=array('user_id'=>$user_id,'capital_id'=>$cpid,'fenzhi'=>'+10','cause'=>'注册','addtime'=>time());
					M('jfdetail')->add($jf);
				}
			}
			//扣积分
			//进行扣积分
			$capital=D('Capital');
			$kou=array();
			$kou['user_id']=$user_id;
			$kou['jifen']=10;
			$capital_id=$capital->getcid($user_id);
			$r=$capital->reduce($kou);
			if($r==='bg'){
				echo 'err';die;
			}elseif($r){
					$data['is_show']=1;
					$data['addtime']=time();
					$res=M('qiuzhi')->add($data);
					if($res){
						$t=time();
						/*$sql="INSERT INTO  `ecm_jfdetail` (`user_id`,`capital_id`,`fenzhi`,`cause`,`addtime`) VALUES ({$user_id},{$capital_id},'-10','发布求职',{$t})";
						$capital->query($sql);*/
						$jf=array('user_id'=>$user_id,'capital_id'=>$capital_id,'fenzhi'=>'-10','cause'=>'发布求职','addtime'=>$t);
						M('jfdetail')->add($jf);
						echo 'ok';die;
					}else{
						$capital->addjifen($kou);
						echo 'err';die;
					}
			}else{
				echo 'err';die;
			}
		}
		if(!empty($_GET['user_id']) && isset($_GET['user_id'])){
			$user_id=$_GET['user_id'];
			$uinfo=array('user_id'=>$user_id);
			
			$this->assign('info',$uinfo);
			
		}else{
			$uif=session('uinfo');
			if($uif['user_id']){
				$uinfo=array('user_id'=>$uif['user_id']);
				$this->assign('info',$uinfo);
			}
		}
		
		//获取所有工种
		$Jobtype=D("Jobtype");
		$types=$Jobtype->getname();
		$this->assign('types',$types);
		//工人求职发布
		//$this->display('cqiuzhi');
		//行业人员求职发布
		$this->display('hqiuzhi');
		
	}
	//根据user_id获取用户求职信息
	public function getqiuzhi(){
		if(!IS_POST){die('404');}
		$user_id=I('post.user_id');
		$info=M('qiuzhi')->field('id,user_id,job_exp,job_live,certificate,graduate,education,skill,intension')->where(array('user_id'=>$user_id))->find();
		$res=array();
		$res["status"]=200;
		$res["retData"]=$info;
		echo json_encode($res);die;
	}
	//转账
	public function zhuanzhang(){
		if(!IS_POST){die('404');}
		$data=I('post.');
		
		//$user_name=trim($data['user_name']);
		$orthor_name=trim($data['orthor_name']);
		$jifen=trim($data['jifen']);
		$ps=trim($data['ps']);
		
		//查询传来的用户是否存在
		$member=D('Member');
		//$wo=$member->where(array('user_name'=>array('like','%'.$user_name.'%')))->getField('user_id');
		$wo=$data['user_id'];
		$ta=$member->where(array('user_name'=>array('like','%'.$orthor_name.'%')))->getField('user_id');
		//根据用户ID获取capital_id
		$capital=D('Capital');
		$wocapital_id=$capital->getcid($wo);
		$tacapital_id=$capital->getcid($ta);
		
		if(empty($wo) && empty($wocapital_id)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="当前用户不存在";
			echo json_encode($res);die;
		}
		if(empty($ta) && empty($tacapital_id)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="对方账户不存在";
			echo json_encode($res);die;
		}
		
		$jifen=intval($jifen);
		if($jifen==0){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="转账积分必须大于1";
			echo json_encode($res);die;
		}
		//转账操作
		//积分金额的变动
		$wokou=array();
		$wokou['jifen']=$jifen;
		$wokou['user_id']=$wo;
		
		$takou=array();
		$takou['jifen']=$jifen;
		$takou['user_id']=$ta;
		
		$cause='转账';
		$r=$capital->reduce($wokou);
		if($r==='bg'){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="用户积分不够";
			echo json_encode($res);die;
		}else if($r){
			//添加对方账号积分
			$capital->addjifen($takou);
			$addtime=time();
			$fenzhi='-'.$jifen;
			//添加积分明细
			$wosql="INSERT INTO  `ecm_jfdetail` (`user_id`,`capital_id`,`fenzhi`,`cause`,`addtime`,`ps`) VALUES ({$wo},{$wocapital_id},'{$fenzhi}','{$cause}',{$addtime},'{$ps}')";
			$capital->execute($wosql);
			//对方明细
			$fenzhi='+'.$jifen;
			$tasql="INSERT INTO  `ecm_jfdetail` (`user_id`,`capital_id`,`fenzhi`,`cause`,`addtime`,`ps`) VALUES ({$ta},{$tacapital_id},'{$fenzhi}','{$cause}',{$addtime},'{$ps}')";
			$capital->execute($tasql);
			
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]="转账成功";
			echo json_encode($res);die;
		}else{
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="转账失败";
			echo json_encode($res);die;
		}
	}
	//积分明细
	public function jifeninfo(){
		if(!IS_POST){die('404');}
			$user_id=trim($_POST['user_id']);
			if(empty($user_id) || !isset($user_id)){
				$res=array();
				$res["status"]=202;
				$res["retMsg"]="err";
				$res["retData"]="用户尚未登录";
				echo json_encode($res);die;
			}
		$capital=D('Capital');
		$sql="select * from `ecm_jfdetail` where user_id = {$user_id} order by id desc";
		$infos=$capital->query($sql);
		if(empty($infos)){	
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="暂时没有积分明细";
			echo json_encode($res);die;
				
		}else{
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]=$infos;
			echo json_encode($res);die;
		}
		
	}
	
	//我的级别  输入用户user_id 
	public function mygrade(){
		if(!IS_POST){die('404');}
		 $user_id=$_POST['user_id'];
		if(empty($user_id) || !isset($user_id)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="用户尚未登录";
			echo json_encode($res);die;
		}
		 //$user_id=1473403835;
		 $member=D('Member');
		 $info=$member->getuserinfo($user_id);
		if(empty($info)){
			$res=array();
			$res["status"]=202;
			$res["retMsg"]="err";
			$res["retData"]="用户不存在";
			echo json_encode($res);die;
		}
		  //用户级别
		 $garde=$member->mygrade($user_id);
		 $mygrade=$garde['grade_name'];
		 if($mygrade){
			 $info['mygrade']=$mygrade;
		 }
		 //获取自己拉取的人数
		 $teams=$member->myteams($user_id);
		 $info['teams']=$teams;
		 //获取自己拉取的工友
		 $mygy=$member->myteamsinfo($user_id);
		 //未验证的
		 $nmygy=$member->nmyteamsinfo($user_id);
		  //设置工种名称
		  $sql="SELECT jobtype_name FROM ecm_jobtype WHERE jobtype_id = {$info['jobtype']}";
		 $jobtypename=$member->query($sql);
		 $jobtypename=$jobtypename[0]['jobtype_name'];
		 if($jobtypename){
			 $info['jobtypename']=$jobtypename;
		 }
		 //设置工种名称
		 foreach($mygy as $key=>$val){
			  $sql="SELECT jobtype_name FROM ecm_jobtype WHERE jobtype_id = {$val['jobtype']}";
				 $jobtypename=$member->query($sql);
				 $jobtypename=$jobtypename[0]['jobtype_name'];
				 if($jobtypename){
					 $mygy[$key]['jobtypename']=$jobtypename;
				 }
		 }
		 //$this->assign('mygy',$mygy);
		
		  //设置工种名称
		 foreach($nmygy as $key=>$val){
			  $sql="SELECT jobtype_name FROM ecm_jobtype WHERE jobtype_id = {$val['jobtype']}";
				 $jobtypename=$member->query($sql);
				 $jobtypename=$jobtypename[0]['jobtype_name'];
				 if($jobtypename){
					 $nmygy[$key]['jobtypename']=$jobtypename;
				 }
		 }
		 //$this->assign('nmygy',$nmygy);
		 if(!empty($mygy)){
			 $info['mygy']=$mygy;
		 }
		 if(!empty($nmygy)){
			 $info['nmygy']=$nmygy;
		 }
			$res=array();
			$res["status"]=200;
			$res["retMsg"]="success";
			$res["retData"]=$info;
			echo json_encode($res);die;
		  
	}

	
	//手机获取验证码
	//手机获取验证码
	public function getveryfy(){
		if(!IS_POST){die('404');}
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


}
?>