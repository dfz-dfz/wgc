<?php
namespace Home\Model;
use Think\Model;
class ZhaopinModel extends Model {
	//招聘列表
	function joblist($limit='0,11',$condition=""){
			//$s_county=$_GET['s_county'];
			//$s_county=urlencode($_GET['s_county']);
			//$s_county=urldecode($s_county);
			//$s_county=mb_substr($s_county, 0, -1, 'utf-8'); 
			//$s_county=urldecode($s_county);
			//$s_county=iconv("utf-8","gbk",$_GET['s_county']);
			//echo $s_county;die;
			$s_county=$_COOKIE['s_county'];
			if($s_county=='all'){
				$s_county="";
			}
			$s_city = city();
			$cate_id = $_GET['cate_id'];
			//$title = $_GET['title'];
			$query="select * from ecm_zhaopin where status=0    ";
			if(empty($_GET['cate_id']) || !isset($_GET['cate_id'])){
				if(!empty($s_city) && isset($s_city)){
					if(!empty($_GET['s_county']) && isset($_GET['s_county'])){
						$query="select * from ecm_zhaopin where status=0   and s_city like '%{$s_city}%' and s_county like '%{$s_county}%' "; //定义sql
					}else{
						$query="select * from ecm_zhaopin where status=0   and s_city like '%{$s_city}%' ";
					}
				}else{
					if(!empty($_GET['s_county']) && isset($_GET['s_county'])){
						$query="select * from ecm_zhaopin where status=0   and s_county like '%{$s_county}%' "; //定义sql
					}else{
						$query="select * from ecm_zhaopin where status=0   ";
					}
				}
				
			}else{
				$query="select * from ecm_zhaopin where status=0  and hangye='{$cate_id}'  "; //定义sql
				if(!empty($s_city) && isset($s_city)){
					if(!empty($_GET['s_county']) && isset($_GET['s_county'])){
						$query="select * from ecm_zhaopin where status=0 and hangye='{$cate_id}'   and s_city like '%{$s_city}%'  and s_county like '%{$s_county}%' "; //定义sql
					}else{
					$query="select * from ecm_zhaopin where status=0 and hangye='{$cate_id}'   and s_city like '%{$s_city}%'  ";
					}
				}else{
					if(!empty($_GET['s_county']) && isset($_GET['s_county'])){
						$query="select * from ecm_zhaopin where status=0 and hangye='{$cate_id}'   and s_county like '%{$s_county}%' "; //定义sql
					}else{
						$query="select * from ecm_zhaopin where status=0 and hangye='{$cate_id}'   ";
					}
				}
				
			}
			//传入条件
			if(!empty($condition)){
				$query.=" ".$condition." ";			
			}
			//排序和限制记录数
			$query.=" order by id desc LIMIT {$limit}";
			//echo $query;die;
			$rows=$this->query($query);
			foreach($rows as $key=>$row){
				$rows[$key]['xinzi']= $row['xinzi'] > 0 ? $row['xinzi'] : '面议';
			}
			return $rows;
		
	}
	//获取招聘详细信息
	public function getinfo($id=""){
		$id=trim($id);
		if(empty($id)){
			return array();
		}else{
			$query="select * from ecm_zhaopin where status=0 and id = {$id}";
			$rows=$this->query($query);
			return $rows[0];
		}
	}
	//获取公司相关信息
	public function getcompany($user_id="",$zid=""){
		if(empty($user_id)){
			return array();
		}else{
			$query="select z.`id`,z.`uid`,z.`gname`, z.`xingzhi`, z.`guimo`,z.`s_province`,z.`s_city`,z.`s_county`, z.`xiangxi`, c.`jianjie`, c.`fanwei`  from ecm_zhaopin z left join ecm_company c on z.`uid`=c.`user_id` where z.`status`=0 and z.`uid` = {$user_id} and z.`id` = {$zid}";
			$rows=$this->query($query);
			return $rows[0];
		}
	}
	//获取所在城市地区
	public function getdq(){
		$region=D("Region");
		$region_name=city();
		$region_info=$region->regionbyname($region_name);
		$region_id=$region_info['region_id'];
		$s_countys=$region->get_child($region_id);
		
		return $s_countys;
	}
}