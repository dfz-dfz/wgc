<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model {

	private $page = "";
	private $countNum = "";
	public function saleList($pagesize=10){
		//p($_GET);
		$where = 'g.`deal` = 1 ';
		$tableName = $this->getTableName();

		if(!empty($_GET['xishi']) && !empty($_GET['tiaozao']))
		{
			$where.= " and (g.`ownership` = ".intval($_GET['xishi'])." or g.`ownership` = ".intval($_GET['xishi']).") ";
		}else{
			if(!empty($_GET['xishi'])){
				$where.= " and g.`ownership` = ".intval($_GET['xishi']);
			}
			if(!empty($_GET['tiaozao'])){
			$where.= " and g.`ownership` = ".intval($_GET['tiaozao']);
			}
		}
		
		if(!empty($_GET['mohu'])){
			$where.= " and (g.`participant` like '%".$_GET['mohu']."%' or g.`goods_title` like '%".$_GET['mohu']."%')";
		}
		if(!empty($_GET['stime']) && !empty($_GET['etime'])){
			$stime = strtotime($_GET['stime']);
			$etime = strtotime($_GET['etime']) + 24*60*60;
			$where.= " and (t.start_time between '$stime' and '$etime')";
		}else{
			//获取有效的售票数据
			// $now=time();
			// $where.=" and t.start_time > {$now} ";
			//p($where);
		}
		
		
		
		$count = $this->alias('g')->join('fab_time t ON g.goods_id=t.goods_id')->where($where)->count();
    	$Page = new \Think\Page($count,$pagesize);
    	$this->countNum=$count;
    	$this->page = $Page->show();
    	$limit = $Page->firstRow.','.$Page->listRows;
		return $this->query("select g.*,t.time_id,t.start_time from $tableName g JOIN fab_time t ON g.goods_id=t.goods_id where $where order by t.start_time limit $limit ");
	}

	//求票
	public function getList($pagesize=10){
		//p($_GET);
		$where = " g.`ownership` = 2  and  g.`deal` = 2 ";
		$tableName = $this->getTableName();
		
		if(!empty($_GET['mohu'])){
			$where.= " and (g.`participant` like '%".$_GET['mohu']."%' or g.`goods_title` like '%".$_GET['mohu']."%')";
		}
		if(!empty($_GET['stime']) && !empty($_GET['etime'])){
			$stime = strtotime($_GET['stime']);
			$etime = strtotime($_GET['etime']) + 24*60*60;
			$where.= " and (t.start_time between '$stime' and '$etime')";
		}else{
			//获取有效的售票数据
			// $now=time();
			// $where.=" and t.start_time > {$now} ";
			//p($where);
		}
		
		
		
		$count = $this->alias('g')->join('fab_time t ON g.goods_id=t.goods_id')->where($where)->count();
    	$Page = new \Think\Page($count,$pagesize);
    	$this->countNum=$count;
    	$this->page = $Page->show();
    	$limit = $Page->firstRow.','.$Page->listRows;
		return $this->query("select g.*,t.time_id,t.start_time from $tableName g JOIN fab_time t ON g.goods_id=t.goods_id where $where order by t.start_time limit $limit ");
	}

	//取出指定ID和timeID的详细信息
	public function getgoodsinfo($goods_id="",$time_id=""){
		$info=array();
		if(!empty($goods_id) && empty($time_id)){
			$info=$this->alias('g')->field('g.*,t.time_id,t.look_num,t.start_time,t.number')->join('fab_time t ON g.goods_id=t.goods_id')->where(array('g.goods_id'=>$goods_id))->select();
		}
		if(!empty($goods_id) && !empty($time_id)){
			$info=$this->alias('g')->field('g.*,t.time_id,t.look_num,t.start_time,t.number')->join('fab_time t ON g.goods_id=t.goods_id')->where(array('g.goods_id'=>$goods_id,'t.time_id'=>$time_id))->select();	
		}
		return $info;
	}

	public function getPage(){
		return $this->page;
	}

	//获取有效的票务数
	public function getCountNum()
	{
		return $this->countNum;
	}

}