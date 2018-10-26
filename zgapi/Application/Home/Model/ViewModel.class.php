<?php
namespace Home\Model;
use Think\Model;
class ViewModel extends Model {
	//获取用户的评论信息 LIMIT 0 , 30  ORDER BY v_id desc  ``.``   GROUP BY
	public function getview($condition="",$group="",$order="",$limit=""){
		$sql="SELECT ecm_view.*,ecm_search.`title`,ecm_search.`gname`,ecm_search.`s_province`,ecm_search.`s_city`,ecm_search.`s_county`,ecm_search.`addtime` as fabutime ,ecm_search.`sender`,ecm_search.`xiangxi`  FROM  ecm_view JOIN ecm_search ON `ecm_view`.`sid` = `ecm_search`.`id` WHERE 1=1 ";
		if(!empty($condition)){
			$sql.=$condition;
		}
		if(!empty($group)){
			$sql.= " GROUP BY ".$group." ";
		}
		if(!empty($order)){
			$sql.= " ORDER BY ";
		}else{
			$sql.= " ORDER BY `ecm_view`.`v_id` desc ";
		}
		if(!empty($limit)){
			$sql.=" LIMIT ".$limit;
		}
		//echo $sql;die;
		return $this->query($sql);
	}
}