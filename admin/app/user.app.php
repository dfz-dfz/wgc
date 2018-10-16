<?php

/* 会员控制器 */
class UserApp extends BackendApp
{
    var $_user_mod;

    function __construct()
    {
        $this->UserApp();
    }

    function UserApp()
    {
        parent::__construct();
        $this->_user_mod =& m('member');
    }

    function index()
    {
         $conditions = $this->_get_query_conditions(array(
            array(
                'field' => $_GET['field_name'],
                'name'  => 'field_value',
                'equal' => 'like',
            ),
        ));
        //更新排序
        if (isset($_GET['sort']) && !empty($_GET['order']))
        {
            $sort  = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order,array('asc','desc')))
            {
             $sort  = 'reg_time';
             $order = 'asc';
            }
        }
        else
        {
            if (isset($_GET['sort']) && empty($_GET['order']))
            {
                $sort  = strtolower(trim($_GET['sort']));
                $order = "";
            }
            else
            {
                $sort  = 'reg_time';
                $order = 'asc';
            }
        }
        $page = $this->_get_page();
       // echo '<pre>';
        //print_r($page);
       // echo '</pre>';
        $users =$this->_user_mod->get_list($conditions,$page['limit'],$sort,$order);
        // echo '<pre>';
        // print_r($users);
        // echo '</pre>';die;
        foreach ($users as $key => $val)
        {
            if ($val['priv_store_id'] == 0 && $val['privs'] != '')
            {
                $users[$key]['if_admin'] = true;
            }
        }
        $this->assign('users', $users);
        $sql="select count(*) from {$this->_user_mod->table} where '1=1 ' {$conditions}";
        $page['item_count'] = $this->_user_mod->getOne($sql);
       // echo  $page['item_count'];
        $this->_format_page($page);
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);
        //echo '<pre>';
        //print_r($page);
        //echo '</pre>';
         $curr_page=$page['curr_page'];
 		$now_url="http://59jiaju.com/admin/".$page['page_links'][$curr_page]."&act=daochu";
 		//echo $now_url;
 		$this->assign('now_url',$now_url);
        /* 导入jQuery的表单验证插件 */
        $this->import_resource(array(
            'script' => 'jqtreetable.js,inline_edit.js',
            'style'  => 'res:style/jqtreetable.css'
        ));
        $this->assign('query_fields', array(
            'user_name' => LANG::get('user_name'),
            'email'     => LANG::get('email'),
            'real_name' => LANG::get('real_name'),
//            'phone_tel' => LANG::get('phone_tel'),
//            'phone_mob' => LANG::get('phone_mob'),
        ));
        $this->assign('sort_options', array(
            'reg_time DESC'   => LANG::get('reg_time'),
            'last_login DESC' => LANG::get('last_login'),
            'logins DESC'     => LANG::get('logins'),
        ));
        $this->display('user.index.html');
    }
	function daochu(){
    	header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename="."daochu".time().".xls");
		$conditions = $this->_get_query_conditions(array(
            array(
                'field' => $_GET['field_name'],
                'name'  => 'field_value',
                'equal' => 'like',
            ),
        ));
        //更新排序
        if (isset($_GET['sort']) && !empty($_GET['order']))
        {
            $sort  = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order,array('asc','desc')))
            {
             $sort  = 'reg_time';
             $order = 'asc';
            }
        }
        else
        {
            if (isset($_GET['sort']) && empty($_GET['order']))
            {
                $sort  = strtolower(trim($_GET['sort']));
                $order = "";
            }
            else
            {
                $sort  = 'reg_time';
                $order = 'asc';
            }
        }
        $page = $this->_get_page();
        $users =$this->_user_mod->get_list($conditions,$page['limit'],$sort,$order);
        foreach ($users as $key => $val)
        {
            if ($val['priv_store_id'] == 0 && $val['privs'] != '')
            {
                $users[$key]['if_admin'] = true;
            }
        }
        $data="会员ID"."\t" . "会员名称". "\t" . "会员电子邮箱". "\t" . "会员密码". "\t" . "会员真实姓名". "\t". "性别". "\t" . "生日". "\t" . "座机号码". "\t" . "手机号码". "\t" . "QQ号". "\t" . "MSN号". "\t" .  "SKYPE号". "\t" .  "YAHOO号". "\t" . "ALIWW号". "\t" .  "注册时间". "\t" . "最后登录时间". "\t" . "最后登录IP". "\t" . "登录次数". "\t" . "是否升级". "\t" . "头像照片地址". "\t" .  "外部ID". "\t" . "是否激活". "\t" . "推送事件配置". "\t" . "省". "\t" . "市". "\t" . "区". "\t" . "详细地址". "\t" ."材料商". "\t" . "材料商LOGO". "\t" . "品牌". "\t" . "用户类型". "\t" . "内部账号"."商户id". "\t" ."包含的相关权限". "\t" ."联系方式". "\t" . "\r\n";    
		$data=iconv(CHARSET, 'utf-8', $data);
    	foreach($users as $key=>$val){
    		$data.=$val['user_id']. "\t" . $val['user_name']. "\t" . $val['email']. "\t" . $val['password']. "\t" . $val['real_name']. "\t" . $val['gender']. "\t" . $val['birthday']. "\t" . $val['phone_tel']. "\t" . $val['phone_mob']. "\t" . $val['im_qq']. "\t" . $val['im_msn']. "\t" . $val['im_skype']. "\t" .  $val['im_yahoo']. "\t" . $val['im_aliww']. "\t" . $val['reg_time']. "\t" . $val['last_login']. "\t" . $val['last_ip']. "\t" . $val['logins']. "\t" . $val['ugrade']. "\t" . $val['portrait']. "\t" . $val['outer_id']. "\t" . $val['activation']. "\t" . $val['feed_config']. "\t" . $val['s_province']. "\t" . $val['s_city']. "\t" . $val['s_county']. "\t" . $val['xiangxi']. "\t" . $val['cailiaocheng']. "\t" . $val['cls_logo']. "\t" . $val['brand']. "\t" . $val['types']. "\t" . $val['nb_user']. $val['priv_store_id']. "\t" .$val['privs']. "\t" .$val['mobe']. "\t" ."\r\n";
    	}
    	echo $data=iconv(CHARSET, 'utf-8', $data);
    	die;
    } 
	function types()
    {
		date_default_timezone_set('PRC');
		$id = $_GET['id'];
		$perNumber=10; //每页显示的记录数
		$page=$_GET['page']; //获得当前的页面值
       mysql_query("SET NAMES UTF8");
		mysql_query("set character_set_client=utf8"); 
		mysql_query("set character_set_results=utf8");
		
		
		
		//取得记录总数$rs，计算总页
		$rs=mysql_query("SELECT count(*) FROM `ecm_member` WHERE `types` ='$id'");
		$myrow = mysql_fetch_array($rs);
		$totalNumber=$myrow[0];
		$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
		
		if (!isset($page)) {
			$page=1;
		} //如果没有值,则赋值
		$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的
		
		$qres=mysql_query("SELECT *FROM `ecm_member` WHERE `types` ='$id' order by user_id desc limit $startCount,$perNumber");
	   while($user = @mysql_fetch_array($qres)){
		   
		   
			  
			  
				
			  $users .= "<tr class='tatr2'>";
			  $users .= "<td class='firstCell'><input type='checkbox' class='checkitem' value='".$user['user_id']."' /></td>";
			  $users .= "<td>".$user['user_name']." | ".$user['real_name']."</td>";
			  $users .= "<td>".$user['email']."</td>";
			  $users .= "<td>".date('Y-m-d H:i:s',$user['reg_time'])."</td>";
			  //$users .= "<td>".$user['reg_time']."</td>";
			  $users .= "<td>".$user['last_login']."<br />".$user['last_ip']."</td>";
			  $users .= "<td>".$user['logins']."</td>";
			  
				if($user['types'] == 1){
					$users .= "<td>普通用户</td>";
				}else if($user['types'] == 2){
					$users .= "<td>材料商</td>";
				}else if($user['types'] == 3){
					$users .= "<td>装修公司</td>";
				}else if($user['types'] == 4){
					$users .= "<td>项目经理</td>";
				}else if($user['types'] == 5){
					$users .= "<td>设计师</td>";
				}else if($user['types'] == 6){
					$users .= "<td>行业办公人员</td>";
				}else if($user['types'] == 7){
					$users .= "<td>生产厂商</td>";
				}
				
				$user_id = $user['user_id'];
			    $qress=mysql_query("SELECT * FROM `ecm_store_user` WHERE `uid` ='$user_id'");
				
				//$userss = @mysql_fetch_array($qress);
				//var_dump($userss);
				//if(!empty($userss)){
					while($usersss = @mysql_fetch_array($qress)){
						
						if(!empty($usersss)){
						
							if($usersss['status'] == 1){
								
								$users .= "<td><span style='color:red;'>待审核</color></td>";
							
							}else{
						
								$users .= "<td><span style='color:green;'>通过</color></td>";
							}
							
						}else{
							$users .= "<td><span style='color:#ccc;'>未上传资料</color></td>";
						}
					}
			
				  
				//}else{
					
				//	$users .= "<td><span style='color:#999999;'>未上传资料</color></td>";
					
				//}
			  $users .= "<td class='handler'>";
			  $users .= "<span style='width: 100px'>";
			  $users .= "<a href='index.php?app=user&amp;act=edit&amp;id={$user['user_id']}'>审核</a> | <a  href=\"javascript:drop_confirm('你确定要删除它吗？该操作不会删除ucenter及其他整合应用中的用户', 'index.php?app=user&amp;act=drop&amp;id={$user['user_id']}');\">删除</a></span>";
			  $users .= "</td>";
			  $users .= "</tr>";
	   }
	  
		
		$limit = '<div class="digg"><span style="font-size:12px;color:#999;margin-right:10px;">总共:<b  style="font-size:12px;color:red">'.$totalNumber.'</b></span>'. $this->showPage($page,$totalNumber,10,'index.php',$params,$id).'</div>';
	   $this->assign('limits', $limit);
	   $this->assign('users', $users);
        $this->display('user.types.html');
    }
	
	
	/**
  * createPage 生成分页跳转链接
  * @param
  * $page  当前页
  * $rowCount 总条目数
  * $pagesize  每页显示最大条数
  * $params    页数后面的参数
  * $front   前面显示几个页码
  * $end    后面显示几个页码
  */
 function createPage($page,$rowCount,$pagesize,$pager,$params,$front=5,$end=5,$id) {
  $count_page = ceil($rowCount/$pagesize);
  if($page > $count_page){
   $page = $count_page;
  }
  $page1 = $page;
  $page2 = $page;

     for ($i = 0; $i < $end+1; $i++) {
         if ($page1 > $count_page) {
          break;
         }
          $rs1[] = $page1;
          $page1++;

        }
     for ($i = 0; $i < $front+1; $i++) {
         $page2--;
         if ($page2 == 0) {
          break;
         }
         $rs2[] = $page2;
        }
  //$rs[] = '首页';
        //$rs[] = '上一页';
     @sort($rs2);
        if($rs2){
        foreach($rs2 as $value){
			$rs[] = $value;
        }
        }
     if($rs1){
        foreach($rs1 as $value){
         $rs[] = $value;
        }
        }
        //$rs[] = '下一页';
        //$rs[] = '尾页';
  $re_pages = array(
   'firstPage'=>'1',
   'lastPage'=>$count_page,
   'middles'=>$rs,
   'currentPage'=>$page,
   'countPage'=>$count_page
  );

  return $re_pages;
 }
    /**
    * 分页类
    * 描述：用于数据分页显示链接
    * @param int  rowCount 表示数据总数量
    * @param int  pagesize 每页显示的数量
    * @param sting  $pager
    * @param params 表示页码的超链中除了page参数之外的其它参数
    * @return string  表示分页的字符串
    */
    public function showPage($page,$rowCount,$pagesize,$pager,$params,$id){
        //TODO: 数据分页显示
  $count_page = ceil($rowCount/$pagesize);
     if($page > $count_page){
   $page = $count_page;
  }
  $page1 = $page;
  $page2 = $page;
  /*循环出页数*/
        for ($i = 0; $i < 6; $i++) {
            if ($page1 > $count_page) {
          break;
         }
         if ($page1 == $page) {
          $rs1[] = $page1;
          $page1++;
         }else{
    $rs1[] = '<a href="index.php?app=user&act=types&id='.$id.'&page='.$page1.$params.'">'.$page1.'</a>';
          $page1++;
         }

        }
        for ($i = 0; $i < 5; $i++) {
            if ($page2 > $count_page) {
          break;
         }
         $page2--;
         if ($page2 == 0) {
          break;
         }
         $rs2[] = '<a href="index.php?app=user&act=types&id='.$id.'&page='.$page2.$params.'">'.$page2.'</a>';
        }
        /*判断是否是第一页*/
            if ($page == '1') {
          $rs[] = '首页';
          $rs[] = '上一页';
         }else{
			  $rs[] = '<a href="index.php?app=user&act=types&id='.$id.'&page= $params">首页</a>';
			  $rs[] = '<a href="index.php?app=user&act=types&id='.$id.'&page='.($page-1).$params.'">上一页</a>';
         }
        @sort($rs2);
        if($rs2){
        foreach($rs2 as $value){
   $rs[] = $value;
        }
        }

        if($rs1){
        foreach($rs1 as $value){
         $rs[] = $value;
        }
        }
        /*判断是否是最后一页*/
        if ($page == $count_page) {
         $rs[] = '下一页';
         $rs[] = '尾页';
        }else{
        $rs[] = '<a href="index.php?app=user&act=types&id='.$id.'&page='.($page+1).$params.'">下一页</a>';
        $rs[] = '<a href="index.php?app=user&act=types&id='.$id.'&page='.$count_page .''.$params.'">尾页</a>';
        }

        foreach($rs as $value){
         $str .= $value.' ';
        }
     return $str;

}
	
    function add()
    {
        if (!IS_POST)
        {
            $this->assign('user', array(
                'gender' => 0,
            ));
            /* 导入jQuery的表单验证插件 */
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
            $ms =& ms();
            $this->assign('set_avatar', $ms->user->set_avatar());
            $this->display('user.form.html');
        }
        else
        {
            $user_name = trim($_POST['user_name']);
            $password  = trim($_POST['password']);
            $email     = trim($_POST['email']);
            $real_name = trim($_POST['real_name']);
            $gender    = trim($_POST['gender']);
            $im_qq     = trim($_POST['im_qq']);
            $im_msn    = trim($_POST['im_msn']);
			$nb_user    = trim($_POST['nb_user']);

            if (strlen($user_name) < 3 || strlen($user_name) > 25)
            {
                $this->show_warning('user_name_length_error');

                return;
            }

            if (strlen($password) < 6 || strlen($password) > 20)
            {
                $this->show_warning('password_length_error');

                return;
            }

            if (!is_email($email))
            {
                $this->show_warning('email_error');

                return;
            }

            /* 连接用户系统 */
            $ms =& ms();

            /* 检查名称是否已存在 */
            if (!$ms->user->check_username($user_name))
            {
                $this->show_warning($ms->user->get_error());

                return;
            }

            /* 保存本地资料 */
            $data = array(
                'real_name' => $_POST['real_name'],
                'gender'    => $_POST['gender'],
//                'phone_tel' => join('-', $_POST['phone_tel']),
//                'phone_mob' => $_POST['phone_mob'],
                'im_qq'     => $_POST['im_qq'],
                'im_msn'    => $_POST['im_msn'],
				'nb_user'    => $_POST['nb_user'],
//                'im_skype'  => $_POST['im_skype'],
//                'im_yahoo'  => $_POST['im_yahoo'],
//                'im_aliww'  => $_POST['im_aliww'],
                'reg_time'  => gmtime(),
            );

            /* 到用户系统中注册 */
            $user_id = $ms->user->register($user_name, $password, $email, $data);
            if (!$user_id)
            {
                $this->show_warning($ms->user->get_error());

                return;
            }

            if (!empty($_FILES['portrait']))
            {
                $portrait = $this->_upload_portrait($user_id);
                if ($portrait === false)
                {
                    return;
                }

                $portrait && $this->_user_mod->edit($user_id, array('portrait' => $portrait));
            }
			//发送邮件通知其已经注册成功
			$content="你已经成功注册59家具会员，会员名是：{$user_name}  ,密码(请保护好)：{$password}";
			$title="你已经成功注册59家具会员";
			sendMail($email, $title, $content);
            $this->show_message('add_ok',
                'back_list',    'index.php?app=user',
                'continue_add', 'index.php?app=user&amp;act=add'
            );
        }
    }

    /*检查会员名称的唯一性*/
    function  check_user()
    {
          $user_name = empty($_GET['user_name']) ? null : trim($_GET['user_name']);
          if (!$user_name)
          {
              echo ecm_json_encode(false);
              return ;
          }

          /* 连接到用户系统 */
          $ms =& ms();
          echo ecm_json_encode($ms->user->check_username($user_name));
    }

    function edit()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!IS_POST)
        {
            /* 是否存在 */
            $user = $this->_user_mod->get_info($id);
            if (!$user)
            {
                $this->show_warning('user_empty');
                return;
            }

            $ms =& ms();
            $this->assign('set_avatar', $ms->user->set_avatar($id));
            $this->assign('user', $user);
            $this->assign('phone_tel', explode('-', $user['phone_tel']));
            /* 导入jQuery的表单验证插件 */
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
			
			$query="select status from `ecm_store_user` where `uid`='$id'"; 
			
			$result=mysql_query($query); //发送sql查询
			
			$s= @mysql_fetch_row($result);
				
			if(!empty($s)){
				
				
				if($s[0] == '1'){
					$status = '<input name="status" type="radio" checked="checked" value="1"/>待审核 <input name="status" type="radio" value="0"/>已审核<input name="status" type="radio" value="2"/>拒绝审核';
				}else if($s[0] == '0'){
					$status = '<input name="status" type="radio" value="1"/>待审核 <input name="status" checked="checked" type="radio" value="0"/>已审核<input name="status" type="radio" value="2"/>拒绝审核';
				}else{
					$status = '<input name="status" type="radio" value="1"/>待审核 <input name="status" checked="checked" type="radio" value="0"/>已审核<input name="status" type="radio" value="2"/>拒绝审核';
				}
				
				
			}else{
				$status = '暂未提交资料';
			}
			$this->assign('status', $status);
            $this->display('user.form.html');
        }
        else
        {
			$status = $_POST['status'];
			$yuanyin = $_POST['yuanyin'];
			mysql_query("UPDATE `ecm_store_user` SET `status` = '$status',`yuanyin` = '$yuanyin' WHERE `uid` ='$id'");
            $data = array(
                'real_name' => $_POST['real_name'],
                'gender'    => $_POST['gender'],
//                'phone_tel' => join('-', $_POST['phone_tel']),
//                'phone_mob' => $_POST['phone_mob'],
                'im_qq'     => $_POST['im_qq'],
                'im_msn'    => $_POST['im_msn'],
//                'im_skype'  => $_POST['im_skype'],
//                'im_yahoo'  => $_POST['im_yahoo'],
//                'im_aliww'  => $_POST['im_aliww'],
            );
            if (!empty($_POST['password']))
            {
                $password = trim($_POST['password']);
                if (strlen($password) < 6 || strlen($password) > 20)
                {
                    $this->show_warning('password_length_error');

                    return;
                }
            }
            if (!is_email(trim($_POST['email'])))
            {
                $this->show_warning('email_error');

                return;
            }

            if (!empty($_FILES['portrait']))
            {
                $portrait = $this->_upload_portrait($id);
                if ($portrait === false)
                {
                    return;
                }
                $data['portrait'] = $portrait;
            }

            /* 修改本地数据 */
            $this->_user_mod->edit($id, $data);

            /* 修改用户系统数据 */
            $user_data = array();
            !empty($_POST['password']) && $user_data['password'] = trim($_POST['password']);
            !empty($_POST['email'])    && $user_data['email']    = trim($_POST['email']);
            if (!empty($user_data))
            {
                $ms =& ms();
                $ms->user->edit($id, '', $user_data, true);
            }

            $this->show_message('edit_ok',
                'back_list',    'index.php?app=user',
                'edit_again',   'index.php?app=user&amp;act=edit&amp;id=' . $id
            );
        }
    }

    function drop()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('no_user_to_drop');
            return;
        }
        $admin_mod =& m('userpriv');
        if(!$admin_mod->check_admin($id))
        {
            $this->show_message('cannot_drop_admin',
                'drop_admin', 'index.php?app=admin');
            return;
        }

        $ids = explode(',', $id);

        /* 连接用户系统，从用户系统中删除会员 */
        $ms =& ms();
        if (!$ms->user->drop($ids))
        {
            $this->show_warning($ms->user->get_error());

            return;
        }

        $this->show_message('drop_ok');
    }

    /**
     * 上传头像
     *
     * @param int $user_id
     * @return mix false表示上传失败,空串表示没有上传,string表示上传文件地址
     */
    function _upload_portrait($user_id)
    {
        $file = $_FILES['portrait'];
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
            $this->show_warning($uploader->get_error(), 'go_back', 'index.php?app=user&amp;act=edit&amp;id=' . $user_id);
            return false;
        }

        $uploader->root_dir(ROOT_PATH);
        return $uploader->save('data/files/mall/portrait/' . ceil($user_id / 500), $user_id);
    }
}

?>
