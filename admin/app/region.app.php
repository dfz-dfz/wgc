<?php
define('MAX_LAYER', 4);

/* 地区控制器 */
class RegionApp extends BackendApp
{
    var $_region_mod;

    function __construct()
    {
        $this->RegionApp();
    }

    function RegionApp()
    {
        parent::__construct();
        $this->_region_mod =& m('region');
    }

	//首页管理
	function edit_index(){
		$this->display('region.edit_index.html');
	}
	
	
	//首页管理编辑
	function edit_index_save(){
	
		$id = $_GET['id'];
		$type = $_GET['type'];
		$query="select * from ecm_lunbo where city='$id' and types='$type'";
		$result=mysql_query($query);
		
		if(@mysql_num_rows($result)>0){
			while($myrow=@mysql_fetch_array($result)){
			
				$con .= '<tr class="tatr2" id="content"> <td></td><td>';
				$con .= '	<a rel="example_group" href="/'.$myrow['path'].'" title="查看大图"><img src="/'.$myrow['path'].'" style="width:300px;height:100px;"/>';
				$con .= '</td>';
				$con .= '<td>';
				$con .= '	<a href="index.php?app=region&act=edit_index_del&id='.$myrow['id'].'" title="删除">删除</a>';																  
				$con .= '</td></tr>';
			}
			
		}else{
			
			$con .= '<td>暂无数据</td>';
		
		}
	
		
		$this->assign('con', $con);
		$this->display('region.edit_index_save.html');
	}
	
	//头部客服电话编辑
	function edit_index_dianhua(){
	
		$id = $_GET['id'];
		$type = $_GET['type'];
		$query="select * from ecm_dianhua where city='$id' and types='$type'";
		$result=mysql_query($query);
		$myrow=@mysql_fetch_array($result);
		if(@mysql_num_rows($result)>0){
			
			
				$con .= '<tr class="tatr2" id="content"> <td></td><td style="text-align:center">';
				$con .= '<span style="font-size:22px;color:red">'.$myrow['text'].'</span>';
				$con .= '</td>';														  
				$con .= '</tr>';
				$ids .= $myrow['id'];
		
			
		}else{
			$ids .= 0;
			$con .= '<td>未设置</td>';
		
		}
	
		$this->assign('id', $ids);
		$this->assign('con', $con);
		$this->display('region.edit_index_dianhua.html');
	}
	
	//删除首页管理
	
	function edit_index_del(){
		$id = $_GET['id'];
		mysql_query("delete from ecm_lunbo where id='$id'");
		header('Location:'.$_SERVER['HTTP_REFERER']);
		exit;
		
	}
	
	//首页管理轮播上传处理
	function edit_index_lunbo(){
	
		$rand = rand(111111111,999999999);
		
		$city  = $_POST['city'];
		$types = $_POST['type'];
		$id = $_POST['id'];
		$text = $_POST['text'];
		
		
		//轮播图
		
		if($types != 'dianhua'){
		
			$lunbo = $_FILES['lunbo'];
			$path = $this->_upload_portrait($rand,$lunbo);
			$query1="insert into ecm_lunbo (path,city,types) values('$path','$city','$types')";
			mysql_query($query1);
			header('Location:'.$_SERVER['HTTP_REFERER']);
			exit;
		}else{
		
			if($id < 1){
				$query1="insert into ecm_dianhua (text,city,types) values('$text','$city','$types')";
				mysql_query($query1);
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit;
			}else{
				$sql="update ecm_dianhua set text='$text' where id='$id'";
				mysql_query($sql);
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit;
			}
		}	
		
		
	
	}
	
    /* 管理 */
    function index()
    {
        /* 取得地区 */
        $regions = $this->_region_mod->get_list(0);
        foreach ($regions as $key => $val)
        {
            $regions[$key]['switchs'] = 0;
            if ($this->_region_mod->get_list($val['region_id']))
            {
                $regions[$key]['switchs'] = 1;
            }
        }
        $this->assign('regions', $regions);

        $this->assign('max_layer', MAX_LAYER);

        $this->import_resource(array(
            'script' => 'inline_edit.js,jqtreetable.js',
            'style' => 'res:style/jqtreetable.css'
        ));
        $this->display('region.index.html');
    }

    /* 新增 */
    function add()
    {
        if (!IS_POST)
        {
            /* 参数 */
            $pid = empty($_GET['pid']) ? 0 : intval($_GET['pid']);
            $region = array('parent_id' => $pid, 'sort_order' => 255);
            $this->assign('region', $region);

            $this->assign('parents', $this->_get_options());
            $this->display('region.form.html');
        }
        else
        {
            $data = array(
                'region_name' => $_POST['region_name'],
                'parent_id' => $_POST['parent_id'],
                'sort_order' => $_POST['sort_order'],
            );

            /* 检查名称是否已存在 */
            if (!$this->_region_mod->unique(trim($data['region_name']), $data['parent_id']))
            {
                $this->show_warning('name_exist');
                return;
            }

            /* 保存 */
            $region_id = $this->_region_mod->add($data);
            if (!$region_id)
            {
                $this->show_warning($this->_region_mod->get_error());
                return;
            }

            $this->show_message('add_ok',
                'back_list',    'index.php?app=region',
                'continue_add', 'index.php?app=region&amp;act=add&amp;pid=' . $data['parent_id']
                );
        }
    }

    /* 编辑 */
    function edit()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!IS_POST)
        {
            /* 是否存在 */
            $region = $this->_region_mod->get_info($id);
            if (!$region)
            {
                $this->show_warning('region_empty');
                return;
            }
            $this->assign('region', $region);

            $this->assign('parents', $this->_get_options($id));
            $this->display('region.form.html');
        }
        else
        {
            $region = $this->_region_mod->get_info($id);
            if (empty($region))
            {
                $this->show_warning('no_such_region');

                return;
            }

            $data = array(
                'region_name' => $_POST['region_name'],
                'parent_id'   => $_POST['parent_id'],
                'sort_order'  => $_POST['sort_order'],
            );

            /* 检查名称是否已存在 */
            if (!$this->_region_mod->unique(trim($data['region_name']), $data['parent_id'], $id))
            {
                $this->show_warning('name_exist');
                return;
            }

            /* 当移动节点时检查移动后的结构是否合法 */
            if ($region['parent_id'] != $data['parent_id'])
            {
                /* 获取新的节点信息 */
                $all_children = $this->_region_mod->get_descendant($id);
                $all_parents  = $this->_region_mod->get_parents($data['parent_id']);
                $new_regions = $this->_region_mod->find(array('conditions' => array_merge($all_children, $all_parents)));
                $new_regions[$id]['parent_id'] = $data['parent_id'];

                /* 判断深度是否合法 */
                $tree = &$this->_tree($new_regions);
                if (max($tree->layer) > MAX_LAYER)
                {
                    $this->show_warning('path_depth_error');

                    return;
                }
            }

            /* 保存 */
            $rows = $this->_region_mod->edit($id, $data);
            if ($this->_region_mod->has_error())
            {
                $this->show_warning($this->_region_mod->get_error());
                return;
            }

            $this->show_message('edit_ok',
                'back_list',    'index.php?app=region',
                'edit_again',   'index.php?app=region&amp;act=edit&amp;id=' . $id
            );
        }
    }

     //异步修改数据
   function ajax_col()
   {
       $id     = empty($_GET['id']) ? 0 : intval($_GET['id']);
       $column = empty($_GET['column']) ? '' : trim($_GET['column']);
       $value  = isset($_GET['value']) ? trim($_GET['value']) : '';
       $data   = array();

       if (in_array($column ,array( 'sort_order')))
       {
           $data[$column] = $value;
           $this->_region_mod->edit($id, $data);
           if(!$this->_region_mod->has_error())
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

    /* 异步取下一级地区  */
    function ajax_cate()
    {
        if(!isset($_GET['id']) || empty($_GET['id']))
        {
            echo ecm_json_encode(false);
            return;
        }
        $cate = $this->_region_mod->get_list($_GET['id']);
        foreach ($cate as $key => $val)
        {
            $child = $this->_region_mod->get_list($val['region_id']);
            if (!$child || empty($child))
            {
                $cate[$key]['switchs'] = 0;
            }
            else
            {
                $cate[$key]['switchs'] = 1;
            }
        }
        header("Content-Type:text/html;charset=" . CHARSET);
        echo ecm_json_encode(array_values($cate));
        //$this->json_result($cate);
        return ;
    }

    /* 删除 */
    function drop()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('no_region_to_drop');
            return;
        }

        $ids = explode(',', $id);
        if (!$this->_region_mod->drop($ids))
        {
            $this->show_warning($this->_region_mod->get_error());
            return;
        }

        $this->show_message('drop_ok');
    }

    /* 更新排序 */
    function update_order()
    {
        if (empty($_GET['id']))
        {
            $this->show_warning('Hacking Attempt');
            return;
        }

        $ids = explode(',', $_GET['id']);
        $sort_orders = explode(',', $_GET['sort_order']);
        foreach ($ids as $key => $id)
        {
            $this->_region_mod->edit($id, array('sort_order' => $sort_orders[$key]));
        }

        $this->show_message('update_order_ok');
    }

    /* 导出数据 */
    function export()
    {
        // 目标编码
        $to_charset = (CHARSET == 'utf-8') ? substr(LANG, 0, 2) == 'sc' ? 'gbk' : 'big5' : '';

        if (!IS_POST)
        {
            if (CHARSET == 'utf-8')
            {
                $this->assign('note_for_export', sprintf(LANG::get('note_for_export'), $to_charset));
                $this->display('common.export.html');

                return;
            }
        }
        else
        {
            if (!$_POST['if_convert'])
            {
                $to_charset = '';
            }
        }

        $regions = $this->_region_mod->get_list();
        $tree =& $this->_tree($regions);
        $csv_data = $tree->getCSVData(0, 'sort_order');
        $this->export_to_csv($csv_data, 'region', $to_charset);
    }

    /* 导入数据 */
    function import()
    {
        if (!IS_POST)
        {
            $this->assign('note_for_import', sprintf(LANG::get('note_for_import'), CHARSET));
            $this->display('common.import.html');
        }
        else
        {
            $file = $_FILES['csv'];
            if ($file['error'] != UPLOAD_ERR_OK)
            {
                $this->show_warning('select_file');
                return;
            }
            if ($file['name'] == basename($file['name'],'.csv'))
            {
                $this->show_warning('not_csv_file');
                return;
            }

            $data = $this->import_from_csv($file['tmp_name'], false, $_POST['charset'], CHARSET);
            $parents = array(0 => 0); // 存放layer的parent的数组
            $fileds = array_intersect($data[0],array('region_name', 'sort_order')); //第一行含有的字段
            $start_col = intval(array_search('region_name', $fileds)); //主数据区开始列号
            foreach ($data as $row)
            {
                $layer = -1;
                 if(array_intersect($row,array('region_name', 'sort_order')))
                {
                    continue;
                }
                $sort_order_col = array_search('sort_order', $fileds); //从表头得到sort_order的列号
                $sort_order = is_numeric($sort_order_col) && isset($row[$sort_order_col]) ? $row[$sort_order_col] : 255;
                for ($i = $start_col; $i < count($row); $i++)
                {
                    if (trim($row[$i]))
                    {
                        $layer = $i - $start_col;
                        $region_name  = trim($row[$i]);
                        break;
                    }
                }

                // 没数据
                if ($layer < 0)
                {
                    continue;
                }

                // 只处理有上级的
                if (isset($parents[$layer]))
                {
                    $region = $this->_region_mod->get("region_name = '$region_name' AND parent_id = '$parents[$layer]'");
                    if (!$region)
                    {
                        // 不存在
                        $id = $this->_region_mod->add(array(
                            'region_name'   => $region_name,
                            'parent_id'     => $parents[$layer],
                            'sort_order'    => $sort_order,
                        ));
                        $parents[$layer + 1] = $id;
                    }
                    else
                    {
                        // 已存在
                        $parents[$layer + 1] = $region['region_id'];
                    }
                }
            }

            $this->show_message('import_ok',
                'back_list', 'index.php?app=region');
        }
    }

	
	/**
     * 上传
     *
     * @param int $user_id
     * @return mix false表示上传失败,空串表示没有上传,string表示上传文件地址
     */
    function _upload_portrait($user_id,$_name)
    {
        $file = $_name;
        if ($file['error'] != UPLOAD_ERR_OK)
        {
            return '';
        }

        import('uploader.lib');
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE);
        $uploader->addFile($file);
        if ($uploader->file_info() === false)
        {
            header('Location:'.$_SERVER['HTTP_REFERER']);
            return false;
        }

        $uploader->root_dir(ROOT_PATH);
        return $uploader->save('data/files/mall/portrait/' . ceil($user_id / 500), $user_id);
    }
	
    /* 构造并返回树 */
    function &_tree($regions)
    {
        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($regions, 'region_id', 'parent_id', 'region_name');
        return $tree;
    }

    /* 取得可以作为上级的地区数据 */
    function _get_options($except = NULL)
    {
        $regions = $this->_region_mod->get_list();
        $tree =& $this->_tree($regions);
        return $tree->getOptions(MAX_LAYER - 1, 0, $except);
    }
}

?>
