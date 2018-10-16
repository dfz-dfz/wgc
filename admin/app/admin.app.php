<?php

/* 管理员控制器 */
class AdminApp extends BackendApp
{
    var $_admin_mod;
    var $_user_mod;

    function __construct()
    {
        $this->AdminApp();
    }

    function AdminApp()
    {
        parent::__construct();
        $this->_admin_mod = & m('userpriv');
        $this->_user_mod = & m('member');
    }
    function index()
    {
        $conditions = ' AND store_id = 0';
        //更新排序
        $sort  = 'userpriv.user_id';
        $order = 'asc';
        $page = $this->_get_page();
        $admin_info = $this->_admin_mod->find(array(
            'conditions' => '1=1' . $conditions,
            'join' => 'mall_be_manage',
            'limit' => $page['limit'],
            'order' => "$sort $order",
            'count' => true,
        ));
        $page['item_count'] = $this->_admin_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info',$page);
        $this->assign('admins',$admin_info);
        $this->display('admin.index.html');
    }
	function user_index()
    {
        $sqls = "select * from ecm_store_user ";
			
			
			$r = mysql_query($sqls);
		
			
			while($lists = @mysql_fetch_array($r)){
				
				
				$list .= "<tr class='tatr2'>";
				$list .= "  <td class='firstCell'><input class='checkitem' value='4' type='checkbox'></td>";
				$list .= "  <td>{$lists['name']}</td>";
				$list .= "  <td><a href=\"/{$lists['zhizhao']}\"target='_blank'><img src=\"/{$lists['zhizhao']}\"style='width:100px;height:80px;'/></td>";
				$list .= "  <td>{$lists['s_province']}{$lists['s_city ']}{$lists['s_county ']}{$lists['xiangxi']}<br>";
				$list .= "	</td>";
				$list .= "  <td>2016-07-04<br>";
				$list .= "	113.109.75.101</td>";
				$list .= "  <td>1230</td>";
				if($lists['status']==1){
					$list .= "<td>&nbsp;未审核</td>";
				}else{
					$list .= "<td>&nbsp;已审核</td>";
				}
				$list .= " <td class='handler'>";
				$list .= "		<span style='width: 120px'>";
				$list .= "  <a href='index.php?app=admin&amp;act=edit&amp;id=4'>通过</a> | <a href='javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=admin&amp;act=drop&amp;id=4');'>删除</a>";
				$list .= "  </span>";
				$list .= "  </td>";
				$list .= "</tr>";
				
				
				
				
				
				$list .= "	</div>";
				$list .= "</div>";
			}
            var_dump($list);
		$this->assign('list', $list);
        $this->display('admin.user_index.html');
    }
    function drop()
    {
        $id = (isset($_GET['id']) && $_GET['id'] !='') ? trim($_GET['id']) : '';
        //判断是否选择管理员
        $ids = explode(',',$id);
        if (!$id||$this->_admin_mod->check_admin($id))
        {
            $this->show_warning('choose_admin');
            return;
        }
        //判断是否是系统初始管理员
        if ($this->_admin_mod->check_system_manager($id))
        {
            $this->show_warning('system_admin_drop');
            return;
         }
         //删除管理员
        $conditions = "store_id = 0 AND user_id " . db_create_in($ids);
        if (!$res = $this->_admin_mod->drop($conditions))
        {
            $this->show_warning('drop_failed');
            return;
        }
        $this->show_message('drop_ok', 'admin_list', 'index.php?app=admin');
    }
    function edit()
    {
        $id = (isset($_GET['id']) && $_GET['id'] !='') ? intval($_GET['id']) : '';
        //判断是否选择了管理员
        if (!$id || $this->_admin_mod->check_admin($id))
        {
            $this->show_warning('choose_admin');
            return;
        }
        //判断是否是系统初始管理员
         if ($this->_admin_mod->check_system_manager($id))
        {
            $this->show_warning('system_admin_edit');
            return;
        }
        if (!IS_POST)
        {
            //获取当前管理员权限
            $privs = $this->_admin_mod->get(array(
                'conditions' => '1=1 AND  store_id =0 AND user_id = '.$id,
                'fields' => 'privs',
            ));
           $admins = $this->_user_mod->get(array(
                    'conditions' => '1=1 AND user_id ='.$id,
                    'fields' => 'user_name,real_name',
                ));
            $priv=explode(',', $privs['privs']);
            include(ROOT_PATH.'/admin/includes/priv.inc.php');
            $act = 'edit';
            $this->assign('act',$act);
            $this->assign('admin',$admins);
            $this->assign('checked_priv',$priv);
            $this->assign('priv',$menu_data);
            $this->display('admin.form.html');
        }
        else
        {
            //更新管理员权限
            $privs = (isset($_POST['priv']) && $_POST['priv']!='priv') ? $_POST['priv']: '';
            $priv = '';
            if ($privs == '')
            {
                $this->show_warning('add_priv');
                return;
            }
            else
            {
                $priv = implode(',', $privs);
            }
            $data = array(
                    'user_id' => $id,
                    'store_id' => '0',
                    'privs' => $priv,
               );
            $this->_admin_mod->edit($id, $data);
            if($this->_admin_mod->has_error())
            {
                 $this->show_warning($this->_admin_mod->get_error());
                 return;
             }
             else
            {
                $this->show_message('edit_admin_ok');
                return true;
             }
        }
    }
    function add()
    {
        $id = (isset($_GET['id']) && $_GET['id'] != '') ? intval($_GET['id']) : '';
        if (empty($_POST['priv']))
        {
           if ($id != '')
           {
                $condition = ' AND  user_id = '.$id;
                $admin = $this->_user_mod->get(array(
                    'conditions' => '1=1' . $condition,
                    'fields' => 'user_name,real_name',
                ));
                //查询是否是管理员
                if (!$admin)
                {
                    $this->show_warning('choose_admin');
                    return;
                }
                //查询是否已是管理员
                if (!$this->_admin_mod->check_admin($id))
                {
                    $this->show_warning('already_admin');
                    return;
                }
                $this->assign('admin',$admin);
                include(ROOT_PATH.'/admin/includes/priv.inc.php');
                $this->assign('priv', $menu_data);
                $this->display('admin.form.html');
            }
            else
            {
                if(!IS_POST)
                {
                    $this->display('admin.test.html');
                }
                else
                {
                    $user_name = (isset($_POST['user_name'])&&$_POST['user_name']!='') ? $_POST['user_name']:'';

                    /* 连接用户系统 */
                    $ms =& ms();
                    $info = $ms->user->get($user_name, true);
                    if (empty($info))
                    {
                        $this->show_message('add_member', 'go_back', 'index.php?app=admin&amp;act=add', 'to_add_member', 'index.php?app=user&amp;act=add');
                        return;
                    }
                    else
                    {
                        $id = $info['user_id'];
                        header("Location: index.php?app=admin&act=add&id=".$id." ");
                     }
                }
            }
        }
        else
        {
            //获取权限并处理
            $privs = (isset($_POST['priv']) && $_POST['priv'] != 'priv') ? $_POST['priv'] : '';
            $priv = 'default|all,';
            if ($privs == '')
            {
                $this->show_warning('add_priv');
                return;
            }
            else
            {
                $priv .= implode(',', $privs);
            }
             //判断是否已是管理员
             if (!$this->_admin_mod->check_admin($id))
                {
                    $this->show_warning('already_admin');
                    return;
                }
             $data = array(
                    'user_id' => $id,
                    'store_id' => '0',
                    'privs' => $priv,
                );
             if ($this->_admin_mod->add($data) === fasle)
             {
                 $this->show_warning($this->_admin_mod->get_error());
                 return;
             }
             else
            {
                $this->show_message('add_admin_ok', 'admin_list', 'index.php?app=admin', 'user_list', 'index.php?app=user');
             }
        }
    }
}

?>
