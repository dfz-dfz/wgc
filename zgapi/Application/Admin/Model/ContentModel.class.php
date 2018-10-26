<?php
namespace Admin\Model;
use Think\Model;
class ContentModel extends Model {

	private $page = "";

	public function getList($pagesize=25){
		$where = ' 1 = 1 ';
		$tableName = $this->getTableName();
		if(!empty($_GET['sender_num'])){
			$where.= " and $tableName.`sender_num` = '".trim($_GET['sender_num'])."'";
		}
		if(!empty($_GET['receive_num'])){
			$where.= " and $tableName.`receive_num` = '".trim($_GET['receive_num'])."'";
		}
		if(!empty($_REQUEST['stime']) && !empty($_REQUEST['etime'])){
			$stime = strtotime($_REQUEST['stime']);
			$etime = strtotime($_REQUEST['etime']);
			if($stime > $etime){
				$where.= " and ($tableName.`sendtime` between {$etime} and {$stime})";
			}else{
				$where.= " and ($tableName.`sendtime` between {$stime} and {$etime})";
			}
			
		}elseif(!empty($_REQUEST['stime'])){
			$stime = strtotime($_REQUEST['stime']);
			$where.= " and $tableName.`sendtime` >= {$stime} ";
		}elseif(!empty($_REQUEST['etime'])){
			$etime = strtotime($_REQUEST['etime']);
			$where.= " and $tableName.`sendtime` <= {$etime} ";
		}
		$count = $this->where($where)->count();
    	$Page = new \Think\Page($count,$pagesize);
    	$this->page = $Page->show();
    	$limit = $Page->firstRow.','.$Page->listRows;
		return $this->query("select $tableName.* from $tableName  where $where order by $tableName.`msgid` desc limit $limit ");
	}

	public function getPage(){
		return $this->page;
	}
}