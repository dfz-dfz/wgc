<?php
namespace Home\Controller;
use Think\Controller;
class ZhaopinController extends JyController{
	//获取招聘列表
    public function getjobs(){
		$zhaopin=D('Zhaopin');
		$limit='0,11';
		if(!empty($_GET['more']) && isset($_GET['more'])){
			$limit='0,100';
		}
		$jobs=$zhaopin->joblist($limit);
		$this->assign('jobs',$jobs);
		$this->display('joblist');
	}
	//获取附加条件的招聘列表
	public function searchjobs(){
		$zhaopin=D('Zhaopin');
		$title=$_GET['title'];
		$xinzi=$_GET['xinzi'];
		$condition="";
		//(1)招聘标题
		if(!empty($title) && isset($title)){
			$condition.=" AND title LIKE '%{$title}%' ";
		}
		//招聘薪资范围
		$xinzi=$_GET['xinzi'];
		if(!empty($xinzi) && isset($xinzi)){
			if($xinzi=='all'){
				$xinzi="";
			}else{
				switch ($xinzi)
					{
					 case 100://面议 and xinzi < 100
					  $condition.=" AND xinzi < 100 ";
					  break;
					 case 1000://以下 and xinzi < 1000
					  $condition.=" AND xinzi >= 100 AND xinzi < 1000 ";
					  break;
					 case 2000://1000-2000 and xinzi <
					  $condition.=" AND xinzi >= 1000 AND xinzi < 2000 ";
					  break;
					 case 3000://2000-3000
					  $condition.=" AND xinzi >= 2000 AND xinzi < 3000 ";
					  break;
					 case 5000://3000-5000
					  $condition.=" AND xinzi >= 3000 AND xinzi < 5000 ";
					  break;
					 case 8000://5000-8000
					  $condition.=" AND xinzi >= 5000 AND xinzi < 8000 ";
					  break;
					 case 12000://8000-12000
					  $condition.=" AND xinzi >= 8000 AND xinzi < 12000 ";
					  break;
					 case 20000://12000-20000
					  $condition.=" AND xinzi >= 12000 AND xinzi < 20000 ";
					  break;
					 case 20001://大于20000
					  $condition.=" AND xinzi >= 20000 ";
					  break;
					}
			}
		}
		$jobs=$zhaopin->joblist('0,100',$condition);
		$num=count($jobs);
		$this->assign('num',$num);
		$this->assign('jobs',$jobs);
		
		//(2)获取当前城市的所有地区
		$s_countys=$zhaopin->getdq();
		$this->assign('s_countys',$s_countys);
		
		//(3)当前区域和薪资
		$s_county=$_GET['s_county'];
		$this->assign('s_county',$s_county);
		$this->assign('xinzi',$xinzi);
		//echo '<pre>';
		//print_r(getUrlvalues());
		//echo '</pre>';die;
		$this->display('searchlist');
	}
	//ajax,城市切换
	public function ajax_city(){
		//$city=iconv('GB2312','UTF-8',$_GET['city']);
		$city=$_POST['city'];
		//$city=trim($city,'市');
		//$city=substr($city,0,strlen($city)-1); 
		$city=mb_substr($city, 0, -1, 'utf-8'); 
		
		//$city="广州";
		if(!empty($city) && isset($city)){
			//$_SESSION['city'] = $city;
			session('city',$city);  
			echo $city;die;
		}else{
			echo 'err';die;
		}
	}
	//获取招聘详情
	public function jobinfo(){
		$zhaopin=D('Zhaopin');
		$id=$_GET['id'];
		$info=$zhaopin->getinfo($id);
		$this->assign('flag','zw');
		$this->assign('info',$info);
		$this->display();
	}
	//获取公司信息
	public function getcompinfo(){
		$zhaopin=D('Zhaopin');
		$user_id=$_GET['user_id'];
		$zid=$_GET['zid'];
		$cpinfo=$zhaopin->getcompany($user_id,$zid);
		$this->assign('flag','cp');
		$this->assign('cpinfo',$cpinfo);
		$this->display('compinfo');
	}
	//关注招聘
	public function care(){
		$care=D('Care');
		if(IS_POST){
			$post=I('post.');
			$zp_id=$post['zp_id'];
			$uinfo=session('uinfo');
			$user_id=$uinfo['user_id'];
			if($care->is_care($zp_id,$user_id)){
				echo 'errr';die;
			}else{
				$data=array('zp_id'=>$zp_id,'user_id'=>$user_id);
				$res=$care->care($data);
				if($res){
					echo 'ok';die;
				}else{
					echo 'err';die;
				}
				
			}
		}else{
			echo 'err';die;
		}
		
		
	}
	//申请职位
	public function shenqing(){
		$Shenqing=D('Shenqing');
		if(IS_POST){
			$post=I('post.');
			$zp_id=$post['zp_id'];
			$uinfo=session('uinfo');
			$user_id=$uinfo['user_id'];
			if($Shenqing->is_sq($zp_id,$user_id)){
				echo 'errr';die;
			}else{
				$data=array('zp_id'=>$zp_id,'user_id'=>$user_id);
				$res=$Shenqing->shenqing($data);
				if($res){
					echo 'ok';die;
				}else{
					echo 'err';die;
				}
				echo 'ok';die;
				
			}
		}else{
			echo 'err';die;
		}
	}
	//测试
	public function te(){
		//注册开始
		//$this->display('register');
		//个人注册
		//$this->display('ownreg');
		//公司注册
		$this->display('gsreg');
	}
}
?>