<?php
namespace Home\Model;
use Think\Model;
class SearchModel extends Model {

	private $page = "";
	//获取列表
	public function getList($pagesize=25){
		$where = 'status=0 ';
		$tableName = $this->getTableName();
		if(!empty($_REQUEST['title'])){
			$where.= " and $tableName.`title` like '%".$_REQUEST['title']."%'";
		}
		if(!empty($_REQUEST['stime']) && !empty($_REQUEST['etime'])){
			$stime = strtotime($_REQUEST['stime']);
			$etime = strtotime($_REQUEST['etime']);
			if($stime > $etime){
				$where.= " and ($tableName.`addtime` between '{$_REQUEST['etime']}' and '{$_REQUEST['stime']}')";
			}else{
				$where.= " and ($tableName.`addtime` between '{$_REQUEST['stime']}' and '{$_REQUEST['etime']}')";
			}
			
		}elseif(!empty($_REQUEST['stime'])){
			//$stime = strtotime($_REQUEST['stime']);
			$where.= " and $tableName.`addtime` >= '{$_REQUEST['stime']}' ";
		}elseif(!empty($_REQUEST['etime'])){
			//$etime = strtotime($_REQUEST['etime']);
			$where.= " and $tableName.`addtime` <= '{$_REQUEST['etime']}' ";
		}
		$count = $this->where($where)->count();
    	$Page = new \Think\Page($count,$pagesize);
    	$this->page = $Page->show();
    	$limit = $Page->firstRow.','.$Page->listRows;
		return $this->query("select $tableName.*,jt.`jobtype_name` from $tableName join ecm_jobtype jt on $tableName.`jobtype`=jt.`jobtype_id` where $where order by $tableName.`id` desc limit $limit ");
	}
	//获取招聘列表
	public function searchjobs($limit='all',$condition="",$groupby=""){
		$sqls="";
		if(!empty($groupby)){
			if($limit=='all'){
				$limit="0,250";
				$sqls .= "select * from ecm_search s where status=0 ".$condition." group by ".$groupby." order by id desc LIMIT ".$limit;
			}else{
				$sqls .= "select * from ecm_search where status=0 ".$condition." group by ".$groupby." order by id desc LIMIT ".$limit;
			}
		}else{
			if($limit=='all'){
				$limit="0,250";
				$sqls .= "select * from ecm_search where status=0 ".$condition." order by id desc LIMIT ".$limit;
			}else{
				$sqls .= "select * from ecm_search where status=0 ".$condition." order by id desc LIMIT ".$limit;
			}
		}
		
		/*$rows=array();
		$res=mysql_query($sqls);
		while( $row  =  mysql_fetch_assoc ($res)){
			$rows[]=$row;
		}
		mysql_free_result($res);*/
		
		return $this->query($sqls);
	}
	//添加招聘信息
	public function searchadd($data=""){
		if(empty($data)){
			return false;
		}else{
			$num=$this->add($data);
			return $num;
		}
	}
	//获取招聘信息
	public function getjobinfo($id=""){
		if(empty($id)){
			return array();
		}else{
			$info=$this->where(array('id'=>$id))->find();
			switch($info['deal'])
			{
				case 0:
				  $info['dealname']="招工";
				  break;  
				case 2:
				  $info['dealname']="招标";
				  break;
				default:
				  $info['dealname']="招工";
			}
			//获取工种名称
			$jobtype_id=$info['jobtype'];
			$sqls="select jobtype_name from ecm_jobtype WHERE jobtype_id={$jobtype_id}";
			$gz=$this->query($sqls);
			$info['jobtypename']=$gz[0]['jobtype_name'];
			return $info;
		}
	}
	//获取公司信息
	public function getcompany($user_id="",$id=""){
		if(empty($user_id)){
			return array();
		}else{
			$query="select s.*, c.`id` as cpid ,c.`jianjie`, c.`fanwei`,c.`gtype`  from ecm_search s left join ecm_company c on s.`userid`=c.`user_id` where  s.`userid` = {$user_id} and s.`id` = {$id}";
			$rows=$this->query($query);
			$info=$rows[0];
			switch($info['deal'])
			{
				case 0:
				  $info['dealname']="招工";
				  break;  
				case 2:
				  $info['dealname']="招标";
				  break;
				default:
				  $info['dealname']="招工";
			}
			//获取工种名称
			$jobtype_id=$info['jobtype'];
			$sqls="select jobtype_name from ecm_jobtype WHERE jobtype_id={$jobtype_id}";
			$gz=$this->query($sqls);
			$info['jobtypename']=$gz[0]['jobtype_name'];
			return $info;
		}
	}
	public function getPage(){
		return $this->page;
	}
}