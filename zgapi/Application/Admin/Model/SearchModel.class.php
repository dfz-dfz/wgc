<?php
namespace Admin\Model;
use Think\Model;
class SearchModel extends Model {

	private $page = "";
	//获取列表
	public function getList($pagesize=25){
		$where = '1 = 1 ';
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
	public function getPage(){
		return $this->page;
	}
}