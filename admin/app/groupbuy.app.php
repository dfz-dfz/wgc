<?php
/**
 * 后台团购管理控制器
 *
 */

class GroupbuyApp extends BackendApp
{
    var $_groupbuy_mod;

    function __construct()
    {
        $this->GroupbuyApp();
    }

    function GroupbuyApp()
    {
        parent::BackendApp();
        $this->_groupbuy_mod =& m('groupbuy');
    }

    function index()
    {
        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => 'gb.group_name',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'group_name',
                'type'  => 'string',
            ),
            array(
                'field' => 'gb.state',
                'name'  => 'type',
                'assoc' => 'AND',
                'handler' => 'groupbuy_state_translator',
            ),
        ));
        $page = $this->_get_page(10);
        $groupbuys_list = $this->_groupbuy_mod->find(array(
            'conditions' => "1 = 1" . $conditions,
            'join'  => 'belong_store',
            'fields'=> 'this.*,s.store_name',
            'limit' => $page['limit'],
            'order' => 'group_id DESC',
            'count' => true
        ));
        $groupbuys = array();
        if ($ids = array_keys($groupbuys_list))
        {
            $quantity = $this->_groupbuy_mod->db->getAllWithIndex("SELECT group_id, sum(quantity) as quantity FROM ". DB_PREFIX ."groupbuy_log  WHERE group_id " . db_create_in($ids) . "GROUP BY group_id", array('group_id'));
        }
        foreach ($groupbuys_list as $key => $val)
        {
            $groupbuys[$key] = $val;
            $groupbuys[$key]['count'] = empty($quantity[$key]['quantity']) ? 0 : $quantity[$key]['quantity'];
        }
        $page['item_count'] = $this->_groupbuy_mod->getCount();
        $this->_format_page($page);
        $this->assign('types', array(
            'all'       => Lang::get('group_all'),
            'pending'   => Lang::get('group_pending'),
            'on'        => Lang::get('group_on'),
            'end'       => Lang::get('group_end'),
            'finished'  => Lang::get('group_finished'),
            'canceled'  => Lang::get('group_canceled')
        ));
        $this->import_resource(array(
            'script' => 'inline_edit.js',
        ));
        $this->assign('type', $_GET['type']);
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('groupbuys', $groupbuys);
        $this->display('groupbuy.index.html');
    }

    function recommended()
    {
        $id = trim($_GET['id']);
        $ids = explode(',', $id);
        $this->_groupbuy_mod->edit(db_create_in($ids, 'group_id') . ' AND state = ' . GROUP_ON, array('recommended' => 1));
        if ($this->_groupbuy_mod->has_error())
        {
            $this->show_warning($this->_groupbuy_mod->get_error());
            exit;
        }
        $this->show_warning('recommended_success', 'back_list' , 'index.php?app=groupbuy');
    }
	
	//新增材料城视图
	
	function clc(){
		$id = $_GET['id'];
		if($id){
			
			$query="select * from ecm_cailiaocheng where id='$id'"; //定义sql
	
			$result=mysql_query($query); //发送sql查询
			
			$rows=@mysql_fetch_array($result);
			
			
			$this->assign('name', $rows['name']);
			$this->assign('id', $rows['id']);
			
			
		}
		$this->display('groupbuy.clc.html');
	
	}
	
	//材料城列表视图
	
	function clc_list(){
	
		$query="select * from ecm_cailiaocheng order by id desc"; //定义sql
        $result=mysql_query($query); //发送sql查询
		//$con = array();
		if($result != false){
			while($rows=@mysql_fetch_array($result)){
				$con .="<tr class='tatr2'>";
				$con .="	<td class='firstCell'><input value='{$rows['id']}' class='checkitem' type='checkbox' /></td>";
				$con .="	<td style='text-align:center'>{$rows['name']}</td>";
				$con .="	<td style='text-align:center'>{$rows['xiangxi']}</td>";
				$con .="	<td style='text-align:center'>{$rows['addtime']}</td>";
				$con .="	<td style='text-align:center'><a href='index.php?app=groupbuy&act=clc&id={$rows['id']}'>编辑</a> | <a name='drop' href=\"javascript:drop_confirm('确定要删除吗？', 'index.php?app=groupbuy&act=clc_del&id={$rows['id']}');\">删除</a> </td>";
				$con .="</tr>";
			}
			
			
			
		}else{
		
			$con .= '<div style="height:300px;line-height:200px;text-align:center;font-size:12px;color:#ccc">暂无数据</div>';
		}
		
		$this->assign('con', $con);
		$this->display('groupbuy.clc_list.html');
	
	}
	
	//新增材料城控制器
	
	function clc_form(){
	
		if($_POST){
			$id 		= $_POST['id'];
			$name 		= htmlspecialchars($_POST['name']);
			$s_province = htmlspecialchars($_POST['s_province']);
			$s_city 	= htmlspecialchars($_POST['s_city']);
			$s_county 	= htmlspecialchars($_POST['s_county']);
			$xiangxi 	= $s_province.$s_city.$s_county;
			
			$addtime 	= date('Y-m-d H:i:s',time());
			
			
			if($id == 0 || empty($id)){
				$sql = "INSERT INTO ecm_cailiaocheng(name,s_province,s_city, s_county, xiangxi,addtime)VALUES('$name','$s_province', '$s_city','$s_county', '$xiangxi','$addtime')";
				
				if(!mysql_query($sql)){
					die("添加数据失败：".mysql_error());
				} else {
					header('Location:index.php?app=groupbuy&act=clc_list');exit;
				}
			}else{
			
				$sql="update ecm_cailiaocheng set name='$name',s_province='$s_province',s_city='$s_city',s_county='$s_county',xiangxi='$xiangxi',addtime='$addtime' where id='$id'";
			
				if(!mysql_query($sql)){
					die("修改数据失败：".mysql_error());
				} else {
					header('Location:index.php?app=groupbuy&act=clc_list');exit;
				}
			
			}
			
		}
	
	}
	//材料城删除
	function clc_del()
    {
		header("Content-type:text/html;charset=utf-8");
		
		if($_GET){
			$id 		= intval($_GET['id']);
			
			
			if($id > 0){
				
				$sql="delete from ecm_cailiaocheng where id='".$id."'";

				if(!mysql_query($sql)){
					
					exit("删除数据失败：".mysql_error());
					
				} else {
				
					header('Location:'.$_SERVER['HTTP_REFERER']);exit;
				}
			}
			
			
			
		}
        
		
		
    }
	function taocan_show()
    {
		
		
		if(empty($_GET['tid'])){
			$tid = $_GET['id'];
			$query="select * from ecm_taocan_mes where tid='$tid' order by id desc"; //定义sql
			$result=mysql_query($query); //发送sql查询
			//$con = array();
			if($result != false){
				while($rows=@mysql_fetch_array($result)){
					$con .="<tr class='tatr2'>";
					$con .="	<td class='firstCell'><input value='{$rows['id']}' class='checkitem' type='checkbox' /></td>";
					$con .="	<td style='text-align:center'>{$rows['name']}</td>";
					$con .="	<td style='text-align:center'>{$rows['tel']}</td>";
					$con .="	<td style='text-align:center'>{$rows['dis']}</td>";
					$con .="	<td style='text-align:center'>{$rows['txt']}</td>";

					$con .="	<td style='text-align:center'>{$rows['addtime']}</td>";
					$con .="	<td style='text-align:center'> <a name='drop' href=\"javascript:drop_confirm('确定要删除吗？', 'index.php?app=groupbuy&act=taocan_show&tid={$rows['id']}');\">删除</a> </td>";
					$con .="</tr>";
				}
				
				
				
			}else{
				$con .= '<div style="height:300px;line-height:200px;text-align:center;font-size:12px;color:#ccc">暂无数据</div>';
			}
			
			$this->assign('con', $con);
			
			$this->display('groupbuy.taocan_show.html');exit;
			
		}else{
			
			header("Content-type:text/html;charset=utf-8");
		
			
				
			$id 		= intval($_GET['tid']);
			
			if($id > 0){
				
				$sql="delete from ecm_taocan_mes where id='".$id."'";

				if(!mysql_query($sql)){
					
					exit("删除数据失败：".mysql_error());
				} else {
					header('Location:http://www.59jiaju.com/admin/index.php?app=groupbuy&act=taocan_show&id='.$id);exit;
				}
			}
			
				
				
			
		}
    }
	
	function taocan()
    {
		
		$query="select * from ecm_taocan order by id desc"; //定义sql
        $result=mysql_query($query); //发送sql查询
		//$con = array();
		if($result != false){
			while($rows=@mysql_fetch_array($result)){
				$con .="<tr class='tatr2'>";
				$con .="	<td class='firstCell'>{$rows['id']}</td>";
				$con .="	<td style='text-align:center'>{$rows['title']}</td>";
				$con .="	<td style='text-align:center'>{$rows['city']}</td>";
				
				$con .="	<td style='text-align:center'><div title='".$rows['hzpp']."'style='width:300px;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;'>{$rows['hzpp']}</div></td>";
				$con .="	<td style='text-align:center'><div title='".$rows['kzgs']."'style='width:300px;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;'>{$rows['kzgs']}</div></td>";
				
				
				
				if($rows['status'] == 1){
					$con .="	<td style='text-align:center;color:red'>已关闭</td>";
				}else{
					$con .="	<td style='text-align:center'>已开启</td>";
				}
				
				$con .="	<td style='text-align:center'>{$rows['addtime']}</td>";
				
				$con .="	<td style='text-align:center'><a href='index.php?app=groupbuy&act=taocan_add&id={$rows['id']}'>编辑</a> | <a href='index.php?app=groupbuy&act=taocan_show&id={$rows['id']}' target='_blank'>查看留言</a> | <a name='drop' href=\"javascript:drop_confirm('确定要删除吗？', 'index.php?app=groupbuy&act=taocan_del&id={$rows['id']}');\">删除</a> </td>";
				$con .="</tr>";
			}
			
			
			
		}else{
			$con .= '<div style="height:300px;line-height:200px;text-align:center;font-size:12px;color:#ccc">暂无数据</div>';
		}
		
		$this->assign('con', $con);
		
		$this->display('groupbuy.taocan.html');
    }
	function taocan_add()
    {
		header("Content-type:text/html;charset=utf-8");
		
		if($_POST){
			$id 		= $_POST['id'];
			$title 		= htmlspecialchars($_POST['title']);
			$s_province = htmlspecialchars($_POST['s_province']);
			$city 		= htmlspecialchars($_POST['city']);
			$jianjie 	= htmlspecialchars($_POST['jianjie']);
			$liangdian 	= htmlspecialchars($_POST['liangdian']);
			$shuoming 	= htmlspecialchars($_POST['shuoming']);
			$gnqu 		= htmlspecialchars($_POST['gnqu']);
			$fengge 	= htmlspecialchars($_POST['fengge']);
			$hzpp 		= htmlspecialchars($_POST['hzpp']);
			$kzgs 		= htmlspecialchars($_POST['kzgs']);
			$time 		= date('Y-m-d H:i:s',time());
			
			/* 处理上传的图片 */
            $logo       =   $this->_upload_logo($brand_id);
            if ($logo === false)
            {
                return;
            }
			
			if($id == 0 || empty($id)){
				$sql = "INSERT INTO ecm_taocan(s_province,city,hzpp,kzgs,title, logo,jianjie, liangdian, shuoming,gnqu,fengge,addtime)VALUES('$s_province','$city','$hzpp','$kzgs','$title','$logo', '$jianjie','$liangdian', '$shuoming','$gnqu','$fengge','$time')";
				

				if(!mysql_query($sql)){
					die("添加数据失败：".mysql_error());
				} else {
					header('Location:http://www.59jiaju.com/admin/index.php?app=groupbuy&act=taocan');exit;
				}
			}else{
				//如果
				
				if(!empty($_FILES['logo']['name'])){
					$sql="update ecm_taocan set s_province='$s_province',city='$city',hzpp='$hzpp',kzgs='$kzgs',title='$title',logo='$logo',jianjie='$jianjie',liangdian='$liangdian',shuoming='$shuoming',gnqu='$gnqu',fengge='$fengge',addtime='$time' where id='$id'";
				}else{
					$sql="update ecm_taocan set s_province='$s_province',city='$city',hzpp='$hzpp',kzgs='$kzgs',title='$title',jianjie='$jianjie',liangdian='$liangdian',shuoming='$shuoming',gnqu='$gnqu',fengge='$fengge',addtime='$time' where id='$id'";
				}
				
				if(!mysql_query($sql)){
					die("修改数据失败：".mysql_error());
				} else {
					header('Location:http://www.59jiaju.com/admin/index.php?app=groupbuy&act=taocan');exit;
				}
			
			}
			
			
			
		}else{
			
			$id = $_GET['id'];
			if($id){
				
				$query="select * from ecm_taocan where id='$id'"; //定义sql
		
				$result=mysql_query($query); //发送sql查询
				
				$rows=@mysql_fetch_array($result);
				
				$this->assign('logo', $rows['logo']);
				$this->assign('hzpp', $rows['hzpp']);
				$this->assign('kzgs', $rows['kzgs']);
				$this->assign('jianjie', $rows['jianjie']);
				$this->assign('liangdian', $rows['liangdian']);
				$this->assign('shuoming', $rows['shuoming']);
				$this->assign('gnqu', $rows['gnqu']);
				$this->assign('fengge', $rows['fengge']);
				$this->assign('user', $rows);
				
			}
			
			
			$this->display('groupbuy.taocan_add.html');
		}
        
		
		
    }
	
	    /**
     *    处理上传标志
     *
     *    @author    Hyber
     *    @param     int $brand_id
     *    @return    string
     */
    function _upload_logo($brand_id)
    {
        $file = $_FILES['logo'];
        if ($file['error'] == UPLOAD_ERR_NO_FILE) // 没有文件被上传
        {
            return '';
        }
        import('uploader.lib');             //导入上传类
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE); //限制文件类型
        $uploader->addFile($_FILES['logo']);//上传logo
        if (!$uploader->file_info())
        {
            $this->show_warning($uploader->get_error() , 'go_back', 'index.php?app=brand&amp;act=edit&amp;id=' . $brand_id);
            return false;
        }
        /* 指定保存位置的根目录 */
        $uploader->root_dir(ROOT_PATH);

        /* 上传 */
        if ($file_path = $uploader->save('data/files/mall/brand', $brand_id))   //保存到指定目录，并以指定文件名$brand_id存储
        {
            return $file_path;
        }
        else
        {
            return false;
        }
    }


	//删除
	function taocan_del()
    {
		header("Content-type:text/html;charset=utf-8");
		
		if($_GET){
			$id 		= intval($_GET['id']);
			
			
			if($id > 0){
				
				$sql="delete from ecm_taocan where id='".$id."'";

				if(!mysql_query($sql)){
					
					exit("删除数据失败：".mysql_error());
				} else {
					header('Location:http://www.59jiaju.com/admin/index.php?app=groupbuy&act=taocan');exit;
				}
			}
			
			
			
		}
        
		
		
    }

    function drop()
    {
        $id = trim($_GET['id']);
        $ids = explode(',', $id);
        if (empty($ids))
        {
            $this->show_warning("no_valid_data");
            exit;
        }
        $this->_groupbuy_mod->drop(db_create_in($ids, 'group_id'));
        if ($this->_groupbuy_mod->has_error())
        {
            $this->show_warning($this->_groupbuy_mod->get_error());
            exit;
        }
        $this->show_warning('drop_success',
            'back_list' , 'index.php?app=groupbuy');
    }

   function ajax_col()
   {
       $id     = empty($_GET['id']) ? 0 : intval($_GET['id']);
       $column = empty($_GET['column']) ? '' : trim($_GET['column']);
       $value  = isset($_GET['value']) ? trim($_GET['value']) : '';
       $data   = array();

       if (in_array($column ,array('recommended')))
       {
           $data[$column] = $value;
           $this->_groupbuy_mod->edit("group_id = " . $id . " AND state = " . GROUP_ON, $data);
           if(!$this->_groupbuy_mod->has_error())
           {
               echo ecm_json_encode(true);
           }
       }
       else
       {
           return ;
       }
       return ;
   }
}



?>