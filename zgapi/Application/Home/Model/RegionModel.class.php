<?php
namespace Home\Model;
use Think\Model;
class RegionModel extends Model{
	/**
	*
	*获取上一级地区ID和名称
	*
	*/
	public function get_parent($region_id=0){
	    $region_id=intval($region_id);
	    if($region_id != 0){
	    	$p=$this->where(array('region_id' => $region_id))->field('parent_id')->find();
	    	if(!empty($p)){
	    		$p=$this->where(array('region_id' => $p['parent_id']))->field('region_id,region_name')->find();
	    		if(!empty($p)){
	    			return $p;
	    		}else{
	    			return 0;
	    		}
	    		
	    	}   
		}else{
			return 0;
		}
	}

	/**
	*
	*获取指定地区上n级地区的ID和名称
	*
	*/
	public function get_parents($region_id,$n=1){
	    $n=intval($n);
	    $region_id=intval($region_id);
	    $p=array();
	    if($n <= 1){
	       $p[]=$this->get_parent($region_id);
	    }else{
	        for($i=0;$i<$n;$i++){
	            $parent=$this->get_parent($region_id);
	            if($parent != 0){
	                $p[] = $parent;
	                $region_id=$parent['region_id'];
	            }else{
	                $p[] = $parent;
	                break;
	            }
	        }
	    }
	    foreach($p as $key => $val){
	            if($val == 0){
	                unset($p[$key]);
	            }
	        }
	     return $p;
	}

	/**
	*
	*获取下一级地区ID和名称
	*
	*/
	public function get_child($region_id=1){
	    $region_id=intval($region_id);
	    $chd=array();
	    	//parent_id=region_id and region_type=region_type+1
	    	$chd=$this->field('region_id,parent_id,region_name')->where(array('parent_id' => $region_id))->select();
	    	if(!empty($chd)){
	    		return $chd;
	    	}else{
	    		return array();
	    	} 
	}
	

	//获取二级地区信息
	public function getcitys(){
		$citys=$this->field('parent_id,region_id,region_name,PY')->where('region_type=2')->select();
		if(!empty($citys)){
			return $citys;
		}else{
			return 0;
		}
		return 0;
	}

	/**
	*
	*获取指定ID地址的信息
	*
	*/
	public function regionbyid($region_id){
		return $this->where(array('region_id'=>$region_id))->find();
	}
	/**
	*
	*获取指定地区名称获取地区的信息
	*
	*/
	public function regionbyname($region_name=""){
		return $this->where(array('region_name' => array('like','%'.$region_name.'%') ))->find();
	}
	public function te(){
		return 'ok';
	}
	
}