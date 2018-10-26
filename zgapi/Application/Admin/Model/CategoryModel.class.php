<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model {
	public $list;

	public function get_category($type = 'group')
	{
		if($type == 'list')
			return $this->list_category();
		elseif($type == 'group')
			return $this->group_category();
		else
			return false;
	}

	//把栏目排序，排序后依然是一维数组
	public function list_category($id = 0,$level = 0)
	{
		$list = $this->get_list();
		$tmp = array();
		$f = false;
		foreach($list as $v){
			if($v['parent_id'] == $id){
				$f = true;
				$v['level'] = $level;
				$tmp[] = $v;
				$childs = $this->list_category($v['category_id'],$level + 1);
				if($childs){
					$tmp = array_merge($tmp,$childs);
				}
			}
		}
		if($f){
			return $tmp;
		}else{
			return $f;
		}
	}

	//把栏目分组，以多维数组形式
	public function group_category($id = 0)
	{
		$list = $this->get_list();
		$tmp = array();
		foreach($list as $v){
			if($v['parent_id'] == $id){
				$v['childs'] = $this->group_category($v['category_id']);
				$tmp[] = $v;
			}
		}
		return $tmp;
	}
	//获取所有栏目
	public function get_list()
	{
		if(empty($this->list))
			$this->list = $this->order('listorder asc')->select();
		return $this->list;
	}

	//获取所有子栏目id
	function get_child($id = 0)
	{
		$list = $this->get_list();
		$f = false;
		$data = array();
		foreach($list as $v)
		{
			if($v['parent_id'] == $id)
			{
				$f = true;
				$data[] = $v['category_id'];
				$res = $this->get_child($v['category_id']);
				if($res){
					$data = array_merge($data,$res);
				}
			}
		}
		if($f){
			return $data;
		}else{
			return $f;
		}
	}
	//获取所有子栏目id和名称,以及是否显示操作
	function get_childinfo($id = 0)
	{
		$list = $this->get_list();
		$f = false;
		$data = array();
		foreach($list as $v)
		{
			if($v['parent_id'] == $id)
			{
				$f = true;
				$arr=array('category_id'=>$v['category_id'],'category_name'=>$v['category_name'],'display'=>$v['display']);
				$data[] = $arr;
				$res = $this->get_childinfo($v['category_id']);
				if($res){
					$data = array_merge($data,$res);
				}
			}
		}
		if($f){
			return $data;
		}else{
			return $f;
		}
	}

	//排序
	function update_list($ids)
	{
		$list = $this->get_list();
		$res = 0;
		foreach($list as $v){
			if($v['listorder'] != $ids[$v['category_id']]){
				$this->where('category_id = %d',$v['category_id'])->save(array('listorder'=>$ids[$v['category_id']]));
				$res++;
			}
		}
		return $res;
	}

	//获取一二级栏目
	public function get_cats($n=1){
		$list = $this->get_list();
		$cats=array();
		if(!empty($list)){
			if($n<=1){
				foreach($list as $row){
					if($row['parent_id']==0){
						$cats[]=$row;
					}
				}
			}else{
				foreach($list as $row){
					if($row['parent_id']!=0){
						$cats[]=$row;
					}
				}
			}
			
		}
		return $cats;
	}
	//获取栏目信息
	public function get_cat_info($category_id){
		return $this->where(array('category_id'=>$category_id))->find();
	}
}
