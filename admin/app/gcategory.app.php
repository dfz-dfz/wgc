<?php

define('MAX_LAYER', 4);

/* 商品分类控制器 */
class GcategoryApp extends BackendApp
{
    var $_gcategory_mod;

    /**
     * 构造函数
     */
    function __construct()
    {
        $this->GcategoryApp();
    }
    function GcategoryApp()
    {
        parent::__construct();

        $this->_gcategory_mod =& bm('gcategory', array('_store_id' => 0));
    }

    /* 管理 */
    function index()
    {
        /* 取得商品分类 */
        $gcategories = $this->_gcategory_mod->get_list(0);
        $tree =& $this->_tree($gcategories);

        /* 先根排序 */
        foreach ($gcategories as $key => $val)
        {
            $gcategories[$key]['switchs'] = 0;
            if ($this->_gcategory_mod->get_list($val['cate_id']))
            {
               $gcategories[$key]['switchs'] = 1;
            }
        }
        $this->assign('gcategories', $gcategories);
        /* 构造映射表（每个结点的父结点对应的行，从1开始） */

        $this->assign('max_layer', MAX_LAYER);

        /* 导入jQuery的表单验证插件 */
        $this->import_resource(array(
            'script' => 'jqtable.js,inline_edit.js',
            'style'  => 'res:style/jqtreetable.css'
        ));
        $this->display('gcategory.index.html');
    }

    /* 异步去商品分类子元素 */
    function ajax_cate()
    {
        if(!isset($_GET['id']) || empty($_GET['id']))
        {
            echo ecm_json_encode(false);
            return;
        }
        $this->_gcategory_mod =& bm('gcategory');
        $cate = $this->_gcategory_mod->get_list($_GET['id']);
        foreach ($cate as $key => $val)
        {
            $child = $this->_gcategory_mod->get_list($val['cate_id']);
            $lay = $this->_gcategory_mod->get_layer($val['cate_id']);
            if ($lay >= MAX_LAYER)
            {
                $cate[$key]['add_child'] = 0;
            }
            else 
            {
                $cate[$key]['add_child'] = 1;
            }
            if (!$child || empty($child) )
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
        return ;
    }

    /* 新增 */
    function add()
    {
        if (!IS_POST)
        {
            /* 参数 */
            $pid = empty($_GET['pid']) ? 0 : intval($_GET['pid']);
            $gcategory = array('parent_id' => $pid, 'sort_order' => 255, 'if_show' => 1);
            $this->assign('gcategory', $gcategory);

            $this->assign('parents', $this->_get_options());
            /* 导入jQuery的表单验证插件 */
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
            $this->display('gcategory.form.html');
        }
        else
        {
            $data = array(
                'cate_name'  => $_POST['cate_name'],
                'parent_id'  => $_POST['parent_id'],
                'sort_order' => $_POST['sort_order'],
                'if_show'    => $_POST['if_show'],
            );

            /* 检查名称是否已存在 */
            if (!$this->_gcategory_mod->unique(trim($data['cate_name']), $data['parent_id']))
            {
                $this->show_warning('name_exist');
                return;
            }

            /* 检查级数 */
            $ancestor = $this->_gcategory_mod->get_ancestor($data['parent_id']);
            if (count($ancestor) >= MAX_LAYER)
            {
                $this->show_warning('max_layer_error');
                return;
            }

            /* 保存 */
            $cate_id = $this->_gcategory_mod->add($data);
            if (!$cate_id)
            {
                $this->show_warning($this->_gcategory_mod->get_error());
                return;
            }

            $this->show_message('add_ok',
                'back_list',    'index.php?app=gcategory',
                'continue_add', 'index.php?app=gcategory&amp;act=add&amp;pid=' . $data['parent_id']
            );
        }
    }

    /* 检查分类名的唯一*/
    function check_gcategory ()
    {
        $cate_name = empty($_GET['cate_name']) ? '' : trim($_GET['cate_name']);
        $parent_id = empty($_GET['parent_id']) ? 0  : intval($_GET['parent_id']);
        $cate_id   = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$cate_name)
        {
            echo ecm_json_encode(true);
            return ;
        }
        if ($this->_gcategory_mod->unique($cate_name, $parent_id, $cate_id))
        {
            echo ecm_json_encode(true);
        }
        else
        {
            echo ecm_json_encode(false);
        }
        return ;
    }
	
	//商品价格编辑
	
	function goods_edit(){
		
		
		
		$sql = "SELECT goods_id,price,yk_price,cs_price,cha_price,xmjj_price,hybgry_price,sjs_price,zx_price,open,status FROM `ecm_goods` WHERE goods_id =" . $_GET['id'];
        $cate_ids = mysql_fetch_assoc(mysql_query($sql));

        
        if($cate_ids['open'] == 1){
            $open = '<input type="radio" checked="checked" name="open" value="1"/> 不开启  <input type="radio" name="open" value="2"/> 开启 ';
        }else{
            $open = '<input type="radio" name="open" value="1"/> 不开启  <input type="radio" checked="checked" name="open" value="2"/> 开启 ';
        }
    
        if($cate_ids['status'] == '待审核'){
            $status = '<input type="radio" checked="checked" name="status" value="待审核"/> 待审核  <input type="radio" name="status" value="已审核"/> 已审核 　<input type="radio" name="status" value="审核失败"/> 审核失败';
        }else if($cate_ids['status'] == '已审核'){
            $status = '<input type="radio" name="status" value="待审核"/> 待审核  <input type="radio" name="status"checked="checked" value="已审核"/> 已审核 　<input type="radio" name="status" value="审核失败"/> 审核失败';
        }else{
            $status = '<input type="radio" name="status" value="待审核"/> 待审核  <input type="radio" name="status" value="已审核"/> 已审核 　<input type="radio" checked="checked" name="status" value="审核失败"/> 审核失败';
        }
		
		
		$sql2 = "SELECT * FROM `ecm_goods_spec` WHERE goods_id =" . $_GET['id'];
        $query = mysql_query($sql2);
		$i=0;
		while($row=mysql_fetch_assoc($query)){
			$huhu[$i]['price']=$row['price'];
			$huhu[$i]['yk_price']=$row['yk_price'];
			$huhu[$i]['cs_price']=$row['cs_price'];
			$huhu[$i]['xmjj_price']=$row['xmjj_price'];
			$huhu[$i]['hybgry_price']=$row['hybgry_price'];
			$huhu[$i]['zx_price']=$row['zx_price'];
			$huhu[$i]['sjs_price']=$row['sjs_price'];
			$huhu[$i]['cha_price']=$row['cha_price'];
			$huhu[$i]['spec_1']=$row['spec_1'];
			$huhu[$i]['spec_2']=$row['spec_2'];
			$huhu[$i]['spec_id']=$row['spec_id'];
			$i++;
		}
		
        $this->assign('huhu', $huhu);
		$this->assign('goods_id', $cate_ids['goods_id']);
		$this->assign('price', $cate_ids['price']);
		$this->assign('yk_price', $cate_ids['yk_price']);
		$this->assign('cs_price', $cate_ids['cs_price']);
		$this->assign('xmjj_price', $cate_ids['xmjj_price']);
		
		$this->assign('hybgry_price', $cate_ids['hybgry_price']);
		$this->assign('zx_price', $cate_ids['zx_price']);
		$this->assign('sjs_price', $cate_ids['sjs_price']);
		
        $this->assign('cha_price', $cate_ids['cha_price']);
        
        
        $this->assign('open', $open);
        $this->assign('status', $status);





		$this->display('goods_edit.html');
		exit;
	}
	
	//商品价格编辑
	
	function goods_edit_save(){
		
		
		if($_POST){

			$goods_id = $_POST['goods_id'];
			

            $price = $_POST['price'];  //原价
            $cha_price = $_POST['cha_price'];  //差价

            $open = $_POST['open'];   //开启自定义价格
            $status = $_POST['status'];   //开启自定义价格

            if($open == 1){
                $yk_price = $_POST['yk_price'];
                $cs_price = $_POST['cs_price'];
                $xmjj_price = $_POST['xmjj_price'];
                $sjs_price = $_POST['sjs_price'];
				$hybgry_price = $_POST['hybgry_price'];
				$zx_price = $_POST['zx_price'];
				$pifashang = $_POST['pifashang'];
				
            }else{

				
				
				
				$hybgry_price = $price/$cha_price; //生产厂家
				$pifashang = $hybgry_price/$cha_price; //批发商
				$cs_price = $pifashang/$cha_price; //五金店
				 
                $xmjj_price = $hybgry_price/$cha_price; //项目经理
                $sjs_price = $hybgry_price/$cha_price;//设计师
				$zx_price = $hybgry_price/$cha_price;//装修公司
				 
				$yk_price = $cs_price/$cha_price; //游客
               
				
				
				
				
            }
			$num = sizeof($_POST['id']);
			for($i=0;$i<$num;$i++){
				$pri = $_POST['pri'][$i];  //原价
				$cha_p = $_POST['cha_p'][$i]; 
				$id= $_POST['id'][$i];
				 if($open == 1){
					$yk_p = $_POST['yk_p'][$i];
					$cs_p = $_POST['cs_p'][$i];
					$xmjj_p = $_POST['xmjj_p'][$i];
					$sjs_p = $_POST['sjs_p'][$i];
					$hybgry_p = $_POST['hybgry_p'][$i];
					$zx_p = $_POST['zx_p'][$i];
				}else{
					$zx_p = $pri+($cha_p*6);
					$yk_p = $pri+($cha_p*5);
					$cs_p = $pri+($cha_p*4);
					$hybgry_p = $pri+($cha_p*3);
					$xmjj_p = $pri+($cha_p*2);
					$sjs_p = $pri+($cha_p*1);
				}
				
			
				
				
				$sql555="update `ecm_goods_spec` set pifashang='$pifashang',price='$price',zx_price='$zx_p',hybgry_price='$hybgry_p',cha_price='$cha_p',yk_price='$yk_p',cs_price='$cs_p',xmjj_price='$xmjj_p',sjs_price='$sjs_p' where spec_id='$id'";
				if(mysql_query($sql555)){
					echo "OK";
				}
				echo $sql555;
			}

           
		
			$sql="update `ecm_goods` set pifashang='$pifashang',price='$price',messages=0,status='$status',zx_price='$zx_price',hybgry_price='$hybgry_price',cha_price='$cha_price',open='$open',yk_price='$yk_price',cs_price='$cs_price',xmjj_price='$xmjj_price',sjs_price='$sjs_price' where goods_id='$goods_id'";
			

            if (mysql_query($sql)){
				
				//header('Location:'.$_SERVER['HTTP_REFERER']);
				echo"<script>history.go(-2);</script>";exit;
				
			}else {
				
				echo "修改失败，SQL:$sql错误：".mysql_error();
		
			}
			
			
			
			exit;
			
		}
		
		
		
	}


    function goods_edi_messages(){

        $i=0;
        
        $sql="select messages from `ecm_goods` where messages=1;";
        $res=mysql_query($sql);
        $str="";
        while($rows=mysql_fetch_assoc($res)){
          $str.=$rows['messages']."---<hr />";
          $i++;
        }

        if($_REQUEST['i']==1){
           $sql="update `ecm_goods` set messages=0 where messages=1;";
           $rr=mysql_query($sql);
           if($rr){echo $str;}
        }else{

            if($i != 0){
                echo $i;
            }else{
                echo 0;
            }
        }

    }

    /* 编辑 */
    function edit()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!IS_POST)
        {
            /* 是否存在 */
            $gcategory = $this->_gcategory_mod->get_info($id);
            if (!$gcategory)
            {
                $this->show_warning('gcategory_empty');
                return;
            }
            $this->assign('gcategory', $gcategory);
            /* 导入jQuery的表单验证插件 */
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
            $this->assign('parents', $this->_get_options($id));
            $this->display('gcategory.form.html');
        }
        else
        {
            $data = array(
                'cate_name'  => $_POST['cate_name'],
                'parent_id'  => $_POST['parent_id'],
                'sort_order' => $_POST['sort_order'],
                'if_show'    => $_POST['if_show'],
            );

            /* 检查名称是否已存在 */
            if (!$this->_gcategory_mod->unique(trim($data['cate_name']), $data['parent_id'], $id))
            {
                $this->show_warning('name_exist');
                return;
            }

            /* 检查级数 */
            $depth    = $this->_gcategory_mod->get_depth($id);
            $ancestor = $this->_gcategory_mod->get_ancestor($data['parent_id']);
            if ($depth + count($ancestor) > MAX_LAYER)
            {
                $this->show_warning('max_layer_error');
                return;
            }

            /* 保存 */
            $old_data = $this->_gcategory_mod->get_info($id); // 保存前的数据
            $rows = $this->_gcategory_mod->edit($id, $data);
            if ($this->_gcategory_mod->has_error())
            {
                $this->show_warning($this->_gcategory_mod->get_error());
                return;
            }

            /* 如果改变了上级分类，更新商品表中相应记录的cate_id_1到cate_id_4 */
            if ($old_data['parent_id'] != $data['parent_id'])
            {
                // 执行时间可能比较长，所以不限制了
                _at(set_time_limit, 0);

                // 清除商城商品分类缓存
                $cache_server =& cache_server();
                $cache_server->delete('goods_category_0');

                // 取得当前分类的所有子孙分类（包括自身）
                $cids = $this->_gcategory_mod->get_descendant_ids($id, true);

                // 找出这些分类中有商品的分类
                $mod_goods =& m('goods');
                $mod_gcate =& $this->_gcategory_mod;
                $sql = "SELECT DISTINCT cate_id FROM {$mod_goods->table} WHERE cate_id " . db_create_in($cids);
                $cate_ids = $mod_goods->getCol($sql);

                // 循环更新每个分类的cate_id_1到cate_id_4
                foreach ($cate_ids as $cate_id)
                {
                    $cate_id_n = array(0,0,0,0);
                    $ancestor = $mod_gcate->get_ancestor($cate_id, true);
                    for ($i = 0; $i < 4; $i++)
                    {
                        isset($ancestor[$i]) && $cate_id_n[$i] = $ancestor[$i]['cate_id'];
                    }
                    $sql = "UPDATE {$mod_goods->table} " .
                            "SET cate_id_1 = '{$cate_id_n[0]}', cate_id_2 = '{$cate_id_n[1]}', cate_id_3 = '{$cate_id_n[2]}', cate_id_4 = '{$cate_id_n[3]}' " .
                            "WHERE cate_id = '$cate_id'";
                    $mod_goods->db->query($sql);
                }
            }

            $this->show_message('edit_ok',
                'back_list',    'index.php?app=gcategory',
                'edit_again',   'index.php?app=gcategory&amp;act=edit&amp;id=' . $id
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
       if (in_array($column ,array('cate_name', 'if_show', 'sort_order')))
       {
           $data[$column] = $value;
           if($column == 'cate_name')
           {
               $gcategory = $this->_gcategory_mod->get_info($id);
               if (!$this->_gcategory_mod->unique($value, $gcategory['parent_id'], $id))
               {
                   echo ecm_json_encode(false);
                   return ;
               }
           }
           $this->_gcategory_mod->edit($id, $data);
           if(!$this->_gcategory_mod->has_error())
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

    /* 批量编辑 */
    function batch_edit()
    {
        if (!IS_POST)
        {
            $this->display('gcategory.batch.html');
        }
        else
        {
            $id = isset($_POST['id']) ? trim($_POST['id']) : '';
            if (!$id)
            {
                $this->show_warning('Hacking Attempt');
                return;
            }

            $ids = explode(',', $id);
            if ($_POST['if_show'] >= 0)
            {
                $data = array('if_show' => $_POST['if_show'] ? 1 : 0);
                $this->_gcategory_mod->edit($ids, $data);
            }

            $this->show_message('batch_edit_ok',
                'back_list', 'index.php?app=gcategory');
        }
    }

    /* 删除 */
    function drop()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('no_gcategory_to_drop');
            return;
        }

        $ids = explode(',', $id);
        if (!$this->_gcategory_mod->drop($ids))
        {
            $this->show_warning($this->_gcategory_mod->get_error());
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
            $this->_gcategory_mod->edit($id, array('sort_order' => $sort_orders[$key]));
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

        $gcategories = $this->_gcategory_mod->get_list();
        $tree =& $this->_tree($gcategories);
        $csv_data = $tree->getCSVData(0, array('sort_order', 'if_show'));
        $this->export_to_csv($csv_data, 'gcategory', $to_charset);
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
            $fileds = array_intersect($data[0],array('cate_name', 'sort_order', 'if_show')); //第一行含有的字段
            $start_col = intval(array_search('cate_name', $fileds)); //主数据区开始列号
            foreach ($data as $row)
            {
                $layer = -1;
                if(array_intersect($row,array('cate_name', 'sort_order', 'if_show')))
                {
                    continue;
                }
                $if_show_col = array_search('if_show', $fileds); //从表头得到if_show的列号
                $if_show = is_numeric($if_show_col) && isset($row[$if_show_col]) ? $row[$if_show_col] : 1;
                $sort_order_col = array_search('sort_order', $fileds); //从表头得到sort_order的列号
                $sort_order = is_numeric($sort_order_col) && isset($row[$sort_order_col]) ? $row[$sort_order_col] : 255;
                for ($i = $start_col; $i < count($row); $i++)
                {
                    if (trim($row[$i]))
                    {
                        $layer = $i - $start_col;
                        $cate_name  = trim($row[$i]);
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
                    $gcategory = $this->_gcategory_mod->get("cate_name = '$cate_name' AND parent_id = '$parents[$layer]'");
                    if (!$gcategory)
                    {
                        // 不存在
                        $id = $this->_gcategory_mod->add(array(
                            'cate_name'     => $cate_name,
                            'parent_id'     => $parents[$layer],
                            'sort_order'    => $sort_order,
                            'if_show'       => $if_show,
                        ));
                        $parents[$layer + 1] = $id;
                    }
                    else
                    {
                        // 已存在
                        $parents[$layer + 1] = $gcategory['cate_id'];
                    }
                }
            }

            $this->show_message('import_ok',
                'back_list', 'index.php?app=gcategory');
        }
    }

    /* 构造并返回树 */
    function &_tree($gcategories)
    {
        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name');
        return $tree;
    }

    /* 取得可以作为上级的商品分类数据 */
    function _get_options($except = NULL)
    {
        $gcategories = $this->_gcategory_mod->get_list();
        $tree =& $this->_tree($gcategories);

        return $tree->getOptions(MAX_LAYER - 1, 0, $except);
    }
}

?>