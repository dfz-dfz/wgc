<?php

/**
 *    Desc
 *
 *    @author    Garbin
 *    @usage    none
 */
 define('MAX_LAYER', 4);
 
class MemberApp extends MemberbaseApp
{
	var $_gcategory_mod;
    var $_feed_enabled = false;
    function __construct()
    {
        $this->MemberApp();
    }

    function MemberApp()
    {
        parent::__construct();
        $ms =& ms();
        $this->_feed_enabled = $ms->feed->feed_enabled();
        $this->assign('feed_enabled', $this->_feed_enabled);
		$this->_gcategory_mod =& bm('gcategory', array('_store_id' => 0));
    }

    function goods_edi_messages(){

        

        $store_id = $_SESSION['user_info']['store_id'];

        $i=0;
        
        $sql="select messages from `ecm_goods` where messages=1 and store_id='$store_id';";
        $res=mysql_query($sql);
        $str="";
        while($rows=mysql_fetch_assoc($res)){
          $str.=$rows['messages']."---<hr />";
          $i++;
        }

        if($_REQUEST['i']==1){
           $sql="update `ecm_goods` set messages=0 where messages=1 and store_id='$store_id';";
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
	
	function dels(){
		$id = $_GET['id'];
		
		//$img = $_GET['img'];
		$sql=mysql_query("delete from `ecm_dianpu_img`  where id='$id'");
		if($sql){
			//@unlink($img);
			header('Location:index.php?app=member');
		}else{
			 echo"<script>alert('删除失败');history.go(-1);</script>";  
		}
	}
	function clc(){
	
		if($_POST['clc']){
			
			$id = $_POST['id'];
			$cailiaocheng = mysql_query("SELECT * from `ecm_cailiaocheng` where s_county='$id'");
			while($cailiaochengs = @mysql_fetch_array($cailiaocheng)){
				$clc_name = $cailiaochengs['name'];
				$list .= '<option value="'.$clc_name.'">'.$clc_name.'</option>';
			}
			
			echo json_encode($list);//返回json格式数据
			exit;
		}
			
	}
    function _index()
    {	
		
		$user_id = $_SESSION['user_info']['user_id'];
		$query="select status from ecm_store_user where uid='$user_id' and status<1"; //定义sql
        $result=mysql_query($query); //发送sql查询
		
		$rows=@mysql_fetch_row($result);
		
		
		
		if(empty($rows) || $rows[0] == 1){
			$store_user = @mysql_fetch_array(mysql_query("SELECT * from `ecm_store_user` where uid='$user_id'"));
			$types_user = @mysql_fetch_array(mysql_query("SELECT types,cls_logo from `ecm_member` where user_id='$user_id'"));
            
			
			if($types_user['types'] > 1){
				
				//$gcategories = $this->_gcategory_mod->get_list(0);
				$sql2 = "SELECT * FROM `ecm_gcategory` where if_show=1";
				$query = mysql_query($sql2);
				$i=0;
				while($row=mysql_fetch_assoc($query)){
					$huhu[$i]['cate_id']=$row['cate_id'];
					$huhu[$i]['cate_name']=$row['cate_name'];
					$huhu[$i]['parent_id']=$row['parent_id'];
					$huhu[$i]['store_id']=$row['store_id'];
					$huhu[$i]['sort_order']=$row['sort_order'];
					$i++;
				}
				
				$pics = "select * from ecm_dianpu_img where uid=$user_id";
			
			
			$rs = mysql_query($pics);
		
			
			while($listss = @mysql_fetch_array($rs)){
				
				$pic .= '<li style="width:100px;height:126px;float:left;margin:5px;"id="'.$listss['id'].'">';
				$pic .= '<img src="'.$listss['img'].'" style="width:100px;height:100px;"/>';
				$pic .= '<p onclick="del('.$listss['id'].')"style="cursor:pointer;width:100%;height:25px;line-height:25px;text-align:center;border-bottom:1px solid #ccc"title="删除">删除</p>';
				$pic .= '</li>';
				
			}
            
				$this->assign('pic', $pic);
				
				
				$this->assign('huhu', $huhu);
			
				$this->assign('user_id', $user_id);
				$this->assign('types', $types_user);
				$this->assign('store_user', $store_user);
				$this->display('member.status.html');exit;
			}
			
		}
		
        
        /* 清除新短消息缓存 */
        $cache_server =& cache_server();
        $cache_server->delete('new_pm_of_user_' . $this->visitor->get('user_id'));

        $user = $this->visitor->get();
        $user_mod =& m('member');
        $info = $user_mod->get_info($user['user_id']);
        $user['portrait'] = portrait($user['user_id'], $info['portrait'], 'middle');
        $this->assign('user', $user);

        /* 店铺信用和好评率 */
        if ($user['has_store'])
        {
            $store_mod =& m('store');
            $store = $store_mod->get_info($user['has_store']);
            $step = intval(Conf::get('upgrade_required'));
            $step < 1 && $step = 5;
            $store['credit_image'] = $this->_view->res_base . '/images/' . $store_mod->compute_credit($store['credit_value'], $step);
            $this->assign('store', $store);
            $this->assign('store_closed', STORE_CLOSED);
        }
        $goodsqa_mod = & m('goodsqa');
        $groupbuy_mod = & m('groupbuy');
        /* 买家提醒：待付款、待确认、待评价订单数 */
        $order_mod =& m('order');
        $sql1 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE buyer_id = '{$user['user_id']}' AND status = '" . ORDER_PENDING . "'";
        $sql2 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE buyer_id = '{$user['user_id']}' AND status = '" . ORDER_SHIPPED . "'";
        $sql3 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE buyer_id = '{$user['user_id']}' AND status = '" . ORDER_FINISHED . "' AND evaluation_status = 0";
        $sql4 = "SELECT COUNT(*) FROM {$goodsqa_mod->table} WHERE user_id = '{$user['user_id']}' AND reply_content !='' AND if_new = '1' ";
        $sql5 = "SELECT COUNT(*) FROM " . DB_PREFIX ."groupbuy_log AS log LEFT JOIN {$groupbuy_mod->table} AS gb ON gb.group_id = log.group_id WHERE log.user_id='{$user['user_id']}' AND gb.state = " .GROUP_CANCELED;
        $sql6 = "SELECT COUNT(*) FROM " . DB_PREFIX ."groupbuy_log AS log LEFT JOIN {$groupbuy_mod->table} AS gb ON gb.group_id = log.group_id WHERE log.user_id='{$user['user_id']}' AND gb.state = " .GROUP_FINISHED;
        $buyer_stat = array(
            'pending'  => $order_mod->getOne($sql1),
            'shipped'  => $order_mod->getOne($sql2),
            'finished' => $order_mod->getOne($sql3),
            'my_question' => $goodsqa_mod->getOne($sql4),
            'groupbuy_canceled' => $groupbuy_mod->getOne($sql5),
            'groupbuy_finished' => $groupbuy_mod->getOne($sql6),
        );
        $sum = array_sum($buyer_stat);
        $buyer_stat['sum'] = $sum;
        $this->assign('buyer_stat', $buyer_stat);

        /* 卖家提醒：待处理订单和待发货订单 */
        if ($user['has_store'])
        {

            $sql7 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE seller_id = '{$user['user_id']}' AND status = '" . ORDER_SUBMITTED . "'";
            $sql8 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE seller_id = '{$user['user_id']}' AND status = '" . ORDER_ACCEPTED . "'";
            $sql9 = "SELECT COUNT(*) FROM {$goodsqa_mod->table} WHERE store_id = '{$user['user_id']}' AND reply_content ='' ";
            $sql10 = "SELECT COUNT(*) FROM {$groupbuy_mod->table} WHERE store_id='{$user['user_id']}' AND state = " .GROUP_END;
            $seller_stat = array(
                'submitted' => $order_mod->getOne($sql7),
                'accepted'  => $order_mod->getOne($sql8),
                'replied'   => $goodsqa_mod->getOne($sql9),
                'groupbuy_end'   => $goodsqa_mod->getOne($sql10),
            );

            $this->assign('seller_stat', $seller_stat);
        }
        /* 卖家提醒： 店铺等级、有效期、商品数、空间 */
        if ($user['has_store'])
        {
            $store_mod =& m('store');
            $store = $store_mod->get_info($user['has_store']);

            $grade_mod = & m('sgrade');
            $grade = $grade_mod->get_info($store['sgrade']);

            $goods_mod = &m('goods');
            $goods_num = $goods_mod->get_count_of_store($user['has_store']);
            $uploadedfile_mod = &m('uploadedfile');
            $space_num = $uploadedfile_mod->get_file_size($user['has_store']);
            $sgrade = array(
                'grade_name' => $grade['grade_name'],
                'add_time' => empty($store['end_time']) ? 0 : sprintf('%.2f', ($store['end_time'] - gmtime())/86400),
                'goods' => array(
                    'used' => $goods_num,
                    'total' => $grade['goods_limit']),
                'space' => array(
                    'used' => sprintf("%.2f", floatval($space_num)/(1024 * 1024)),
                    'total' => $grade['space_limit']),
                    );
            $this->assign('sgrade', $sgrade);

        }

        /* 待审核提醒 */
        if ($user['state'] != '' && $user['state'] == STORE_APPLYING)
        {
            $this->assign('applying', 1);
        }
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),    url('app=member'),
                         LANG::get('overview'));

        /* 当前用户中心菜单 */
        $this->_curitem('overview');
        $this->_config_seo('title', Lang::get('member_center'));
        $this->display('member.index.html');
    }
	function searchjobs(){
			$userid = $_SESSION['user_info']['user_id'];
			$id = $_GET['id'];   
			if(IS_POST){
				  header("Content-Type: text/html; charset=utf-8");
				  $timezone="Asia/Shanghai";
				  date_default_timezone_set($timezone); //北京时间
				  $addtime = date('Y-m-d H:i:s',time());
				  $title = $_POST["title"];
				  $deal = $_POST["deal"];
				  $unit = $_POST["unit"];
				  $jobtype = $_POST["jobtype"];
				  $jobs = $_POST["jobs"];
				  $renshu = $_POST["renshu"];
				  $livetime = $_POST["livetime"];
				  $gname=$_POST['gname'];
				  $num = $_POST["num"];
				  $xinzi = $_POST["xinzi"];
				  $lianxiren =  $_POST["lianxiren"];
				  $dianhua = $_POST["dianhua"];
				  $email = $_POST["email"];
				  $s_province =  $_POST["s_province"];
				  $s_city = $_POST["s_city"];
				  $s_county = $_POST["s_county"];
				  $xiangxi = $_POST["xiangxi"];
				  $content =  $_POST["content"];
				  $id=$_POST['id'];
				 if(empty($_POST['id'])){				
					$sql = "INSERT INTO `zt55o1_db`.`ecm_search` ( `userid`,`title`,`gname`,`deal`, `jobtype`, `jobs`, `num`, `unit`,`renshu`,`livetime`, `xinzi`, `lianxiren`, `dianhua`, `email`,`s_province`, `s_city`, `s_county`, `xiangxi`, `content`, `addtime`) VALUES ( '$userid','$title','$gname',$deal, $jobtype, '$jobs', $num, '$unit','$renshu','$livetime', $xinzi, '$lianxiren', '$dianhua', '$email','$s_province', '$s_city', '$s_county', '$xiangxi', '$content', '$addtime');";
				}else{
					$id = $_POST['id'];
					if($s_province=="请选择"){
						$sql="update ecm_search set `deal`=$deal,`title`='$title', `gname`='$gname', `jobtype`=$jobtype, `jobs`='$jobs', `num`=$num, `unit`='$unit', `renshu`='$renshu',`livetime`='$livetime',`xinzi`=$xinzi, `lianxiren`='$lianxiren', `dianhua`='$dianhua', `email`='$email',`xiangxi`='$xiangxi', `content`='$content', `addtime`='$addtime' where id='$id'";
					}else{
						$sql="update ecm_search set `deal`=$deal,`title`='$title', `gname`='$gname', `jobtype`=$jobtype, `jobs`='$jobs', `num`=$num, `unit`='$unit', `renshu`='$renshu',`livetime`='$livetime',`xinzi`=$xinzi, `lianxiren`='$lianxiren', `dianhua`='$dianhua', `email`='$email', `s_province`='$s_province', `s_city`='$s_city', `s_county`='$s_county', `xiangxi`='$xiangxi', `content`='$content', `addtime`='$addtime' where id='$id'";
					}
				}
				if (mysql_query($sql)){
					$res=mysql_insert_id();
					if($res>0){
						$id=$res;
					}
					
				}else {
					
					echo "修改失败，SQL:$sql错误：".mysql_error();die;
			
				}
			}
		//获取相应id记录数据	  
		$sqls = "select * from ecm_search where userid='$userid' and id='$id'";
		$rest=mysql_query($sqls);
		$r = mysql_fetch_array($rest);
		mysql_free_result ($rest);
		//获取所有工种
		$sql="select jobtype_id,jobtype_name from ecm_jobtype ";
		$rest2=mysql_query($sql);
		$types=array();
		 while ( $row  =  mysql_fetch_array($rest2 , MYSQL_ASSOC)){
			 $types[]=$row;
		}
		mysql_free_result ($rest2);
		$this->assign('types',$types);
		$this->assign('list', $r);
		$this->assign('id',$id);		   
		$this->display('member.searchjobs.html');
	}
	//通过ajax获取某一工种的详细清单信息
	public function ajax_type(){
		$jobtype_id=$_GET['jobtype_id'];
		//$jobtype_id=0;
		if($jobtype_id){
		$sql="select bill_name from ecm_typebill WHERE jobtype_id = {$jobtype_id}";
			$rest2=mysql_query($sql);
			$names=array();
			 while ( $row  =  mysql_fetch_array($rest2 , MYSQL_ASSOC)){
				 $names[]=$row;
			}
			mysql_free_result ($rest2);
			//echo '<pre>';
			//print_r($names);
			//echo '</pre>';die;
			echo json_encode($names);die;
		}else{
			$res=array(array('bill_name'=>'没有清单数据'));
			echo json_encode($res);die;
		}
	}
	function te(){
		$r=searchjobs('0,8');
		echo '<pre>';
		print_r($r);
		echo '</pre>';die;
	}
    function zhaopin_list(){
		
		header("Content-Type: text/html; charset=utf-8");
		$timezone="Asia/Shanghai";
		date_default_timezone_set($timezone); //北京时间

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_order'), 'index.php?app=buyer_order',
                         LANG::get('order_list'));

        /* 当前用户中心菜单 */
        $this->_curitem('my_order');
        $this->_curmenu('order_list');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_order'));
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));


            $user_id = $_SESSION['user_info']['user_id'];
             
  

            $sqls = "select * from ecm_zhaopin where uid=$user_id order by id desc";
			
			
			$r = mysql_query($sqls);
		
			
			while($lists = @mysql_fetch_array($r)){
				
				$list .= "<div class='foot' style='width:100%'>";
				$list .= "	<p style='text-align:center;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:250px;float:left'>{$lists['title']}</p>";
				$list .= "	<p style='text-align:center;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:150px;float:left'>{$lists['gname']}</p>";
				
				$list .= "	<p style='text-align:center;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:200px;float:left'>{$lists['addtime']}<p>";	
				$list .= "	<p class='handle'style='text-align:center;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:100px;float:left'>";
				if($lists['status']==1){
					$list .= "&nbsp;未审核";
				}else{
					$list .= "&nbsp;已审核";
				}
				
				$list .= "	</p>";
				$list .= "	<p style='text-align:center;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:120px;float:left'>";
				$list .= "	<a href='index.php?app=member&act=zhaopin&id=".$lists['id']."'>编辑</a>";
				$list .= "	<a href='index.php?app=member&act=zhaopin_del&id=".$lists['id']."'>删除</a>";
				$list .= "	</p>";
				$list .= "</div>";
			}
            
			$this->assign('list', $list);
			$this->display('member.zhaopin_list.html');
            
    }
	//删除招聘信息
	function zhaopin_del(){
		$id = $_GET['id'];
		$sql="delete from ecm_zhaopin where id='$id'";
		if (mysql_query($sql)){
                
                header('Location:index.php?app=member&act=zhaopin_list');
                
            }else {
                
                echo "修改失败，SQL:$sql错误：".mysql_error();
        
            }

            exit;
	}
	function caigou(){
	
		$user_id = $_SESSION['user_info']['user_id'];
        $id = $_GET['id'];     
        $sqls = "select * from ecm_caigou where uid='$user_id' and id='$id'";
		
		$r = mysql_fetch_array(mysql_query($sqls));
		
		$this->assign('list', $r);
		$this->display('member.caigou.html');
	}
	//采购招标
	function caigou_list(){
		
		header("Content-Type: text/html; charset=utf-8");
		$timezone="Asia/Shanghai";
		date_default_timezone_set($timezone); //北京时间

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_order'), 'index.php?app=buyer_order',
                         LANG::get('order_list'));

        /* 当前用户中心菜单 */
        $this->_curitem('my_order');
        $this->_curmenu('order_list');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_order'));
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));


            $user_id = $_SESSION['user_info']['user_id'];
             
  

            $sqls = "select * from ecm_caigou where uid=$user_id order by id desc";
			
			
			$r = mysql_query($sqls);
		
			
			while($lists = @mysql_fetch_array($r)){
				
				$list .= "<div class='foot' style='width:100%'>";
				$list .= "	<p style='overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:150px;float:left'>{$lists['gname']}</p>";
				$list .= "	<p style='overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:200px;float:left'>{$lists['title']}</p>";
				$list .= "	<p style='overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:80px;float:left'>{$lists['lianxiren']}</p>";
				$list .= "	<p style='overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:100px;float:left'>{$lists['dianhua']}</p>";
				$list .= "	<p style='overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:150px;float:left'>{$lists['addtime']}<p>";	
				$list .= "	<p class='handle'style='overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:100px;float:left'>";
				if($lists['status']==1){
					$list .= "&nbsp;未审核";
				}else{
					$list .= "&nbsp;已审核";
				}
				
				$list .= "	</p>";
				$list .= "	<p style='overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:120px;float:left'>";
				$list .= "	<a href='index.php?app=member&act=caigou&id=".$lists['id']."'>编辑</a>|";
				$list .= "	<a href='index.php?app=member&act=caigou_del&id=".$lists['id']."'>删除</a>|";
				$list .= "	<a href='index.php?app=member&act=caigou_liuyan_list&id=".$lists['id']."'>留言</a>";
				$list .= "	</p>";
				$list .= "</div>";
			}
            
			
			$this->assign('list', $list);
			$this->display('member.caigou_list.html');
            
    }
	
	//采购招标-留言
	function caigou_liuyan_list(){
		
		header("Content-Type: text/html; charset=utf-8");
		$timezone="Asia/Shanghai";
		date_default_timezone_set($timezone); //北京时间

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_order'), 'index.php?app=buyer_order',
                         LANG::get('order_list'));

        /* 当前用户中心菜单 */
        $this->_curitem('my_order');
        $this->_curmenu('order_list');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_order'));
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));


            $user_id = $_SESSION['user_info']['user_id'];
            $id = $_GET['id'];
  

            $sqls = "select * from ecm_zhaobiao_pinlun where uid=$user_id and pid=$id order by id desc";
			
			
			$r = mysql_query($sqls);
		
			
			while($lists = @mysql_fetch_array($r)){
				
				$list .= "<div class='foot' style='width:100%'>";
				$list .= "	<p style='text-align:center;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:150px;float:left'>{$lists['uname']}</p>";
				$list .= "	<p style='text-align:center;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:400px;float:left'>{$lists['content']}</p>";
				$list .= "	<p style='text-align:center;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:150px;float:left'>{$lists['addtime']}</p>";
				$list .= "	<p style='text-align:center;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:150px;float:left'>";
				$list .= "	<a href='index.php?app=member&act=caigou_liuyan_del&id=".$lists['id']."'>删除</a>";
				$list .= "	<a href='index.php?app=member&act=caigou_liuyan_content&id=".$lists['id']."'>查看</a>";
				$list .= "	</p>";
				$list .= "</div>";
			}
            
			
			$this->assign('list', $list);
			$this->display('member.caigou_liuyan_list.html');
            
    }
	
	//招标留言详细
	function caigou_liuyan_content(){
	
		$user_id = $_SESSION['user_info']['user_id'];
        $id = $_GET['id'];     
        $sqls = "select * from ecm_zhaobiao_pinlun where uid='$user_id' and id='$id'";
		
		$r = mysql_fetch_array(mysql_query($sqls));
		
		$this->assign('list', $r);
		$this->display('member.caigou_liuyan_content.html');
	}
	//删除招标留言信息
	function caigou_liuyan_del(){
		$id = $_GET['id'];
		$sql="delete from ecm_zhaobiao_pinlun where id='$id'";
		if (mysql_query($sql)){
                
                header('Location:'.$_SERVER['HTTP_REFERER']);
                
            }else {
                
                echo "删除失败，SQL:$sql错误：".mysql_error();
        
            }

            exit;
	}
	
	function addcaigou(){

		
			header("Content-Type: text/html; charset=utf-8");
			$timezone="Asia/Shanghai";
			date_default_timezone_set($timezone); //北京时间
			
              $company = $_POST["company"];
			  
			  $title = $_POST["title"];

              $gname = $_POST["gname"];

              $hangye = $_POST["hangye"];

             $xingzhi = $_POST["xingzhi"];

              $guimo = $_POST["guimo"];

              $lianxiren = $_POST["lianxiren"];

              $dianhua = $_POST["dianhua"];

              $email = $_POST["email"];

             $s_province =  $_POST["s_province"];

              $s_city = $_POST["s_city"];

              $s_county = $_POST["s_county"];

              $xiangxi = $_POST["xiangxi"];

             $content =  $_POST["content"];

             $user_id = $_SESSION['user_info']['user_id'];
             $addtime = $_POST["addtime"];
			 $andtime = $_POST["andtime"];
  
			if(empty($_POST['id'])){
				
				$sql = "INSERT INTO `zt55o1_db`.`ecm_caigou` ( `andtime`,`title`,`uid`, `gname`, `company`, `hangye`, `xingzhi`, `guimo`, `lianxiren`, `dianhua`, `email`, `s_province`, `s_city`, `s_county`, `xiangxi`, `content`, `addtime`) VALUES ('$andtime','$title','$user_id', '$gname', '$company', '$hangye', '$xingzhi', '$guimo', '$lianxiren', '$dianhua', '$email', '$s_province', '$s_city', '$s_county', '$xiangxi', '$content', '$addtime');";

			}else{
			
				$id = $_POST['id'];
				$sql="update ecm_caigou set `andtime`='$andtime',`title`='$title', `gname`='$gname', `company`='$company', `hangye`='$hangye', `xingzhi`='$xingzhi', `guimo`='$guimo', `lianxiren`='$lianxiren', `dianhua`='$dianhua', `email`='$email', `s_province`='$s_province', `s_city`='$s_city', `s_county`='$s_county', `xiangxi`='$xiangxi', `content`='$content', `addtime`='$addtime' where id='$id'";
				
			}
            if (mysql_query($sql)){
                
                header('Location:index.php?app=member&act=caigou_list');
                
            }else {
                
                echo "修改失败，SQL:$sql错误：".mysql_error();
        
            }

            exit;
    }
	
	//删除招标信息
	function caigou_del(){
		$id = $_GET['id'];
		$sql="delete from ecm_caigou where id='$id'";
		if (mysql_query($sql)){
                
                header('Location:index.php?app=member&act=caigou_list');
                
            }else {
                
                echo "修改失败，SQL:$sql错误：".mysql_error();
        
            }

            exit;
	}
	function addzhaopin(){

				header("Content-Type: text/html; charset=utf-8");
				$timezone="Asia/Shanghai";
				date_default_timezone_set($timezone); //北京时间
              $company = $_POST["company"];
			  
			  $title = $_POST["title"];

              $gname = $_POST["gname"];

              $hangye = $_POST["hangye"];

             $xinzi = $_POST["xinzi"];

              $guimo = $_POST["guimo"];

              $lianxiren = $_POST["lianxiren"];

              $dianhua = $_POST["dianhua"];

              $email = $_POST["email"];

             $s_province =  $_POST["s_province"];

              $s_city = $_POST["s_city"];

              $s_county = $_POST["s_county"];

              $xiangxi = $_POST["xiangxi"];

             $content =  $_POST["content"];
			 
			 $xinzi =  $_POST["xinzi"];

             $user_id = $_SESSION['user_info']['user_id'];
             $addtime = date('Y-m-d H:i:s',time());
  

            

			
			if(empty($_POST['id'])){
				
				$sql = "INSERT INTO `zt55o1_db`.`ecm_zhaopin` ( `xinzi`,`title`,`uid`, `gname`, `company`, `hangye`, `xinzi`, `guimo`, `lianxiren`, `dianhua`, `email`, `s_province`, `s_city`, `s_county`, `xiangxi`, `content`, `addtime`) VALUES ('$xinzi','$title','$user_id', '$gname', '$company', '$hangye', '$xinzi', '$guimo', '$lianxiren', '$dianhua', '$email', '$s_province', '$s_city', '$s_county', '$xiangxi', '$content', '$addtime');";

			}else{
				$id = $_POST['id'];
				$sql="update ecm_zhaopin set `xinzi`='$xinzi',`title`='$title', `gname`='$gname', `company`='$company', `hangye`='$hangye', `xinzi`='$xinzi', `guimo`='$guimo', `lianxiren`='$lianxiren', `dianhua`='$dianhua', `email`='$email', `s_province`='$s_province', `s_city`='$s_city', `s_county`='$s_county', `xiangxi`='$xiangxi', `content`='$content', `addtime`='$addtime' where id='$id'";
				
			}
			
			
            if (mysql_query($sql)){
                
                header('Location:index.php?app=member&act=zhaopin_list');
                
            }else {
                
                echo "修改失败，SQL:$sql错误：".mysql_error();
        
            }

            exit;
    }
	
	
	//批量上传文件
	function fileupload(){
	
		/**
		 * upload.php
		 *
		 * Copyright 2013, Moxiecode Systems AB
		 * Released under GPL License.
		 *
		 * License: http://www.plupload.com/license
		 * Contributing: http://www.plupload.com/contributing
		 */

		#!! IMPORTANT:
		#!! this file is just an example, it doesn't incorporate any security checks and
		#!! is not recommended to be used in production environment as it is. Be sure to
		#!! revise it and customize to your needs.


		// Make sure file is not cached (as it happens for example on iOS devices)
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");


		// Support CORS
		// header("Access-Control-Allow-Origin: *");
		// other CORS headers if any...
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			exit; // finish preflight CORS requests here
		}


		if ( !empty($_REQUEST[ 'debug' ]) ) {
			$random = rand(0, intval($_REQUEST[ 'debug' ]) );
			if ( $random === 0 ) {
				header("HTTP/1.0 500 Internal Server Error");
				exit;
			}
		}

		// header("HTTP/1.0 500 Internal Server Error");
		// exit;


		// 5 minutes execution time
		@set_time_limit(5 * 60);

		// Uncomment this one to fake upload time
		usleep(5000);

		// Settings
		// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
		$targetDir = 'upload_tmp';
		$uploadDir = 'upload';

		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds


		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

		// Create target dir
		if (!file_exists($uploadDir)) {
			@mkdir($uploadDir);
		}

		// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}
		
		
		$fileName = rand(1111111111,9999999999).time().rand(rand(time(),time()),rand(1111111111,9999999999)).'.jpg';
		
	
		
		$md5File = @file('md5list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$md5File = $md5File ? $md5File : array();

		if (isset($_REQUEST["md5"]) && array_search($_REQUEST["md5"], $md5File ) !== FALSE ) {
			die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "exist": 1}');
		}

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		$uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


		// Remove old temp files
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}

			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
					continue;
				}

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}


		// Open temp file
		if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

		$index = 0;
		$done = true;
		for( $index = 0; $index < $chunks; $index++ ) {
			if ( !file_exists("{$filePath}_{$index}.part") ) {
				$done = false;
				break;
			}
		}
		if ( $done ) {
			if (!$out = @fopen($uploadPath, "wb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			}

			if ( flock($out, LOCK_EX) ) {
				for( $index = 0; $index < $chunks; $index++ ) {
					if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
						break;
					}

					while ($buff = fread($in, 4096)) {
						fwrite($out, $buff);
					}

					@fclose($in);
					@unlink("{$filePath}_{$index}.part");
				}

				flock($out, LOCK_UN);
			}
			@fclose($out);
		}

		$arr = '/'.$uploadDir.'/'.$fileName;
		
		die($arr);
	
		
	
	}
	
	function ziliao_add(){
	
			
			 //var_dump($_POST);exit;
              $name = $_POST["name"];
			  $user_id = $_POST["user_id"];
			  $s_province = $_POST["s_province"];

              $s_city = $_POST["s_city"];

              $s_county = $_POST["s_county"];
			  $cailiaocheng = $_POST["cailiaocheng"];
			  
			  $tel = $_POST["tel"];

             $xiangxi = $_POST["xiangxi"];
			 
			 $brand = $_POST["brand"];
			 
			 $mobe = $_POST["mobe"];
			 
			 $email = $_POST["email"];

			if(!empty($_POST['pics'])){
				foreach($_POST['pics'] as $v){
					$time = time();
					
					mysql_query("INSERT INTO `ecm_dianpu_img` ( `uid`,`img`,`timedate`) VALUES ('$user_id','$v',$time);");
				
				}
			}
			
			 if($_POST['zx'] == 'ok'){
				$cate_id = $_POST["cate_id"];
			 }else{
				 
				 if(is_array($_POST["cate_id"])){
					 $cate_id = implode(',',$_POST["cate_id"]);
				 }else{
					 $cate_id = $_POST["cate_id"];
				 }
				 
			 }
              
	
			
              
			  
			  if(!empty($_FILES['portrait']['name'])){
				  $zhizhao = $this->_upload_portraitzz($user_id);
			  }else{
				  $zhizhao = $_POST["zhizhao"];
			  }
			  
			  //品牌logo
			  if(!empty($_FILES['cls_logo']['name'])){
				  $cls_logo = $this->_upload_portraitlogo($user_id);
				  
				  $sql = mysql_query("UPDATE `ecm_member` SET `cls_logo`='$cls_logo' WHERE `user_id` ='$user_id'");
			  }
			  
			  if(!empty($brand)){
				  
				  
				  $sql = mysql_query("UPDATE `ecm_member` SET `cls_brand`='$brand' WHERE `user_id` ='$user_id'");
			  }

	
			
			$store_user = @mysql_fetch_array(mysql_query("SELECT count('id') from `ecm_store_user` where uid='$user_id'"));
             
             if($store_user == false || empty($store_user) || $store_user[0] < 1){
	
				 $sql = "INSERT INTO `ecm_store_user` ( `email`,`mobe`,`tel`,`uid`,`zhizhao`, `name`, `s_province`, `s_city`, `s_county`,`cailiaocheng`, `xiangxi`, `cate_id`) VALUES ('$email','$mobe','$tel','$user_id','$zhizhao', '$name', '$s_province', '$s_city', '$s_county','$cailiaocheng', '$xiangxi', '$cate_id');";
			 
			 }else{
			
				 $sql = "UPDATE `ecm_store_user` SET `email`='$email',`mobe`='$mobe',`tel`='$tel',`zhizhao` = '$zhizhao',`name`='$name',`s_province`='$s_province',`s_city`='$s_city',`s_county`='$s_county',`cailiaocheng`='$cailiaocheng',`xiangxi`='$xiangxi',`cate_id`='$cate_id',`status` = '1' WHERE `uid` ='$user_id'";
				 
			 }
  

          

            if (mysql_query($sql)){
                
                header('Location:index.php?app=member');
                
            }else {
                
                echo "修改失败，SQL:$sql错误：".mysql_error();
        
            }

            exit;
    }
	function showcate(){
		header("Content-Type:text/html;charset=" . CHARSET);
			/* 取得商品分类 */
			if($_GET['xia']){
				$list = $this->_get_mgcategory_options($_GET['id']);
				echo json_encode($list);//返回json格式数据
				exit;
				 
			}else if($_GET['pin']){
				
				$brand = $this->_brand_mod->find('cate_id = ' . $_GET['id']);
				$brand = current($brand);
				//获取关联品牌
				$id = $_GET['id'];
				$brands = mysql_query("SELECT brand_name from `ecm_brand` where cate_id='$id'");
				while($brandss = @mysql_fetch_array($brands)){
					$brand_name = $brandss['brand_name'];
					$branda .= '<span onclick="addpinpai(this)"title="点击选择该品牌"id="'.$brand_name.'"style="padding:3px 10px;background:green;color:#fff;margin:5px;cursor:pointer">'.$brand_name.'</span>';
				}
				
				echo json_encode($branda);//返回json格式数据
				exit;
			
			}else{
				$this->assign('mgcategories', $this->_get_mgcategory_options(0)); // 商城分类第一级
			}
	}
	
	function _upload_logo($brand_id)
    {
        $file = $_FILES['brand_logo'];
        if ($file['error'] == UPLOAD_ERR_NO_FILE || !isset($_FILES['brand_logo'])) // 没有文件被上传
        {
            return '';
        }
        import('uploader.lib');             //导入上传类
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE); //限制文件类型
        $uploader->addFile($_FILES['brand_logo']);//上传logo
        if (!$uploader->file_info())
        {
            $this->pop_warning($uploader->get_error());
            if (ACT == 'brand_apply')
            {
                $m_brand = &m('brand');
                $m_brand->drop($brand_id);
            }            
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
	
	function ziliao(){
		
		
		if (IS_POST)
        {
			$brand_name = trim($_POST['brand_name']);
            if (empty($brand_name))
            {
                $this->pop_warning("brand_name_required");
                exit;
            }

			$brand_name = $_POST['brand_name'];
			$brand_logo = $logo = $this->_upload_logo($brand_id);
			$tag 		= $_POST['tag'];
			$cate_id 	= $_POST['cate_id'];
			
            $strsql = "insert into ecm_brand(brand_name,brand_logo,store_id,if_show,tag,cate_id) values('$brand_name','$brand_logo','0','0','$tag','$cate_id')";
			$result = @mysql_query($strsql);
			
            

           
            $this->pop_warning('ok','member', 'index.php?app=member');
			exit;
		}
		
		if($_GET['pin']){
			
			$id = $_GET['id'];
				
			//获取二级分类ID
			$sql2 = "SELECT cate_id FROM `ecm_gcategory` where parent_id='$id'";
			$query = mysql_query($sql2);
			$i=0;
			while($row=mysql_fetch_assoc($query)){
				$huhu[$i]=$row['cate_id'];
				
				$i++;
			}
			$parent_id1 = implode(',',$huhu); //二级分类ID
			
			//获取三级分类ID
			$sql3 = "SELECT cate_id FROM `ecm_gcategory` where parent_id in($parent_id1)";
			$query3 = mysql_query($sql3);
			$r=0;
			while($row3=mysql_fetch_assoc($query3)){
				$huhu3[$r]=$row3['cate_id'];
				
				$r++;
			}
			
			
			$parent_id2 = implode(',',$huhu3); //三级分类ID
			
			
			
			//获取关联品牌
			
			
			
			$brands = mysql_query("SELECT brand_name from `ecm_brand` where cate_id in($parent_id1) or cate_id in($parent_id2) group by cate_id");
			
			while($brandss = @mysql_fetch_array($brands)){
				$brand_name = $brandss['brand_name'];
				$branda .= '<span onclick="addpinpai(this)"title="点击选择该品牌"id="'.$brand_name.'"style="padding:3px 10px;background:green;color:#fff;margin:5px;cursor:pointer">'.$brand_name.'</span>';
			}
			if(!empty($branda)){
				echo $branda;//返回json格式数据
			}else{
				echo '暂无品牌';//返回json格式数据
			}
			
			
			exit;
		
		}
              /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_order'), 'index.php?app=buyer_order',
                         LANG::get('order_list'));

        /* 当前用户中心菜单 */
        $this->_curitem('my_order');
        $this->_curmenu('order_list');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_order'));
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));


            $user_id = $_SESSION['user_info']['user_id'];
             
			$store_user = @mysql_fetch_array(mysql_query("SELECT * from `ecm_store_user` where uid='$user_id'"));
			$types_user = @mysql_fetch_array(mysql_query("SELECT types,cls_logo from `ecm_member` where user_id='$user_id'"));
            $this->assign('mgcategories', $this->_get_mgcategory_options(0)); // 商城分类第一级
			$this->assign('user_id', $user_id);
			$this->assign('types', $types_user);
			$this->assign('store_user', $store_user);
			$this->display('member.ziliao.html');
    }

	/* 取得商城商品分类，指定parent_id */
    function _get_mgcategory_options($parent_id = 0)
    {
        $res = array();
        $mod =& bm('gcategory', array('_store_id' => 0));
        $gcategories = $mod->get_list($parent_id, true);
        foreach ($gcategories as $gcategory)
        {
                  $res[$gcategory['cate_id']] = $gcategory['cate_name'];
        }
        return $res;
    }
	
	
    function zhaopin()
    {
        
        /* 清除新短消息缓存 */
        $cache_server =& cache_server();
        $cache_server->delete('new_pm_of_user_' . $this->visitor->get('user_id'));

        $user = $this->visitor->get();
        $user_mod =& m('member');
        $info = $user_mod->get_info($user['user_id']);
        $user['portrait'] = portrait($user['user_id'], $info['portrait'], 'middle');
		
        $this->assign('user', $user);

        /* 店铺信用和好评率 */
        if ($user['has_store'])
        {
            $store_mod =& m('store');
            $store = $store_mod->get_info($user['has_store']);
            $step = intval(Conf::get('upgrade_required'));
            $step < 1 && $step = 5;
            $store['credit_image'] = $this->_view->res_base . '/images/' . $store_mod->compute_credit($store['credit_value'], $step);
            $this->assign('store', $store);
            $this->assign('store_closed', STORE_CLOSED);
        }
		//echo '<pre>';
		//print_r($user);
		//echo '</pre>';die;
        $goodsqa_mod = & m('goodsqa');
        $groupbuy_mod = & m('groupbuy');
        /* 买家提醒：待付款、待确认、待评价订单数 */
        $order_mod =& m('order');
        $sql1 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE buyer_id = '{$user['user_id']}' AND status = '" . ORDER_PENDING . "'";
        $sql2 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE buyer_id = '{$user['user_id']}' AND status = '" . ORDER_SHIPPED . "'";
        $sql3 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE buyer_id = '{$user['user_id']}' AND status = '" . ORDER_FINISHED . "' AND evaluation_status = 0";
        $sql4 = "SELECT COUNT(*) FROM {$goodsqa_mod->table} WHERE user_id = '{$user['user_id']}' AND reply_content !='' AND if_new = '1' ";
        $sql5 = "SELECT COUNT(*) FROM " . DB_PREFIX ."groupbuy_log AS log LEFT JOIN {$groupbuy_mod->table} AS gb ON gb.group_id = log.group_id WHERE log.user_id='{$user['user_id']}' AND gb.state = " .GROUP_CANCELED;
        $sql6 = "SELECT COUNT(*) FROM " . DB_PREFIX ."groupbuy_log AS log LEFT JOIN {$groupbuy_mod->table} AS gb ON gb.group_id = log.group_id WHERE log.user_id='{$user['user_id']}' AND gb.state = " .GROUP_FINISHED;
        $buyer_stat = array(
            'pending'  => $order_mod->getOne($sql1),
            'shipped'  => $order_mod->getOne($sql2),
            'finished' => $order_mod->getOne($sql3),
            'my_question' => $goodsqa_mod->getOne($sql4),
            'groupbuy_canceled' => $groupbuy_mod->getOne($sql5),
            'groupbuy_finished' => $groupbuy_mod->getOne($sql6),
        );
        $sum = array_sum($buyer_stat);
        $buyer_stat['sum'] = $sum;
        $this->assign('buyer_stat', $buyer_stat);

        /* 卖家提醒：待处理订单和待发货订单 */
        if ($user['has_store'])
        {

            $sql7 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE seller_id = '{$user['user_id']}' AND status = '" . ORDER_SUBMITTED . "'";
            $sql8 = "SELECT COUNT(*) FROM {$order_mod->table} WHERE seller_id = '{$user['user_id']}' AND status = '" . ORDER_ACCEPTED . "'";
            $sql9 = "SELECT COUNT(*) FROM {$goodsqa_mod->table} WHERE store_id = '{$user['user_id']}' AND reply_content ='' ";
            $sql10 = "SELECT COUNT(*) FROM {$groupbuy_mod->table} WHERE store_id='{$user['user_id']}' AND state = " .GROUP_END;
            $seller_stat = array(
                'submitted' => $order_mod->getOne($sql7),
                'accepted'  => $order_mod->getOne($sql8),
                'replied'   => $goodsqa_mod->getOne($sql9),
                'groupbuy_end'   => $goodsqa_mod->getOne($sql10),
            );

            $this->assign('seller_stat', $seller_stat);
        }
        /* 卖家提醒： 店铺等级、有效期、商品数、空间 */
        if ($user['has_store'])
        {
            $store_mod =& m('store');
            $store = $store_mod->get_info($user['has_store']);

            $grade_mod = & m('sgrade');
            $grade = $grade_mod->get_info($store['sgrade']);

            $goods_mod = &m('goods');
            $goods_num = $goods_mod->get_count_of_store($user['has_store']);
            $uploadedfile_mod = &m('uploadedfile');
            $space_num = $uploadedfile_mod->get_file_size($user['has_store']);
            $sgrade = array(
                'grade_name' => $grade['grade_name'],
                'add_time' => empty($store['end_time']) ? 0 : sprintf('%.2f', ($store['end_time'] - gmtime())/86400),
                'goods' => array(
                    'used' => $goods_num,
                    'total' => $grade['goods_limit']),
                'space' => array(
                    'used' => sprintf("%.2f", floatval($space_num)/(1024 * 1024)),
                    'total' => $grade['space_limit']),
                    );
            $this->assign('sgrade', $sgrade);

        }

        /* 待审核提醒 */
        if ($user['state'] != '' && $user['state'] == STORE_APPLYING)
        {
            $this->assign('applying', 1);
        }
        /* 当前位置 */
        $this->_curlocal(
		LANG::get('member_center'),    
		url('app=member'),
		LANG::get('overview'));

        /* 当前用户中心菜单 */
        $this->_curitem('overview');
        $this->_config_seo('title', Lang::get('member_center'));
		
		
		$user_id = $_SESSION['user_info']['user_id'];
        $id = $_GET['id'];     
        $sqls = "select * from ecm_zhaopin where uid='$user_id' and id='$id'";
		
		$r = mysql_fetch_array(mysql_query($sqls));
		//echo '<pre>';
		//print_r($r);
		//echo '</pre>';die;
		$this->assign('list', $r);
		
		
		
        $this->display('member.zhaopin.html');
    }
	
	function reg()
    {
       
        $this->display('reg.html');
    }

    /**
     *    注册一个新用户
     *
     *    @author    Garbin
     *    @return    void
     */
    function register()
    {
       if(intval($_GET['types']) > 7 || intval($_GET['types']) < 1){
		   die('404');
	   }
        if ($this->visitor->has_login)
        {
            $this->show_warning('has_login');

            return;
        }
        if (!IS_POST)
        {
            if (!empty($_GET['ret_url']))
            {
                $ret_url = trim($_GET['ret_url']);
            }
            else
            {
                if (isset($_SERVER['HTTP_REFERER']))
                {
                    $ret_url = $_SERVER['HTTP_REFERER'];
                }
                else
                {
                    $ret_url = SITE_URL . '/index.php';
                }
            }
			$this->assign('types', $_GET['types']);
            $this->assign('type', $_GET['ret_url']);
            $this->assign('ret_url', rawurlencode($ret_url));
            $this->_curlocal(LANG::get('user_register'));
            $this->_config_seo('title', Lang::get('user_register') . ' - ' . Conf::get('site_title'));

            if (Conf::get('captcha_status.register'))
            {
                $this->assign('captcha', 1);
            }

            /* 导入jQuery的表单验证插件 */
            $this->import_resource('jquery.plugins/jquery.validate.js');
			//echo "here..................";
            $this->display('member.register.html');
        }
        else
        {   
            if (!$_POST['agree'])
            {
                $this->show_warning('agree_first');

                return;
            }
            if (Conf::get('captcha_status.register') && base64_decode($_SESSION['captcha']) != strtolower($_POST['captcha']))
            {
                $this->show_warning('captcha_failed');
                return;
            }
            if ($_POST['password'] != $_POST['password_confirm'])
            {
                /* 两次输入的密码不一致 */
                $this->show_warning('inconsistent_password');
                return;
            }

            /* 注册并登陆 */
            $user_name      = trim($_POST['user_name']);
            $password       = md5($_POST['password']);
            $email          = trim($_POST['email']);
            $s_province    = $_POST['s_province'];
            $s_city        = $_POST['s_city'];
			//$phone_mob		=$_POST['phone'];
			$phone_mob		=$user_name;
			$types			=$_POST['types'];
            $s_county    = $_POST['s_county'];

            $xiangxi    = $_POST['xiangxi'];
            $types    = $_POST['types'];
			$reg_time = time();

            $strsql = "insert into ecm_member(reg_time,user_name,phone_mob,email,password,s_province,s_city,s_county,xiangxi,types) values('$reg_time','$user_name ','$phone_mob','$email','$password','$s_province','$s_city','$s_county','$xiangxi','$types')";
            $result = @mysql_query($strsql);

            if($result){
				$r = mysql_query("select *from ecm_member where user_name='$user_name'");
				$s = mysql_fetch_array($r);
					$user_info = array(
						"user_id"=> $s['user_id'],
						"user_name"=> $user_name,
						"reg_time"=> time(),
						"last_login"=>NULL,
						"last_ip"=>NULL,
						"store_id"=>NULL,
					);			
				Session_Start();
				
                $user_id=$s['user_id'];

				$_SESSION["user_info"]=$user_info;
				  
				$this->_hook('after_register', array('user_id' => $user_id));
				//登录
				$this->_do_login($user_id);
				
				setcookie("lai_username",$user_name);
				$mobiles=array('18922273466');
				if($types==1){
					$content="用户手机号为:".$phone_mob." 注册成功!";
					foreach($mobiles as $key=>$mobe){
						send($mobe,$content);
					}	
				}else{
					$content="用户手机号为:".$phone_mob." 开店成功!";
					foreach($mobiles as $key=>$mobe){
						send($mobe,$content);
					}
				}
                echo '<script type="text/javascript">alert("注册成功");window.location.href="index.php?app=member";</script>';exit;

            }else{
                
                  
                echo '<script type="text/javascript">alert("出错了");window.history.go(-1);</script>';exit;

            }

            /*$ms =& ms(); //连接用户中心
            $user_id = $ms->user->register($user_name, $password, $email);

            if (!$user_id)
            {
                $this->show_warning($ms->user->get_error());

                return;
            }

            $this->_hook('after_register', array('user_id' => $user_id));
            //登录
            $this->_do_login($user_id);
			
			setcookie("lai_username",$user_name);
            
            /* 同步登陆外部系统 */
           // $synlogin = $ms->user->synlogin($user_id);
			

            #TODO 可能还会发送欢迎邮件

            /*$this->show_message(Lang::get('register_successed') . $synlogin,
                'back_before_register', 'index.php?app=member', rawurldecode($_POST['ret_url']),
                'enter_member_center',
                'apply_store', 'index.php?app=apply'
            );*/
        }
    }


    /**
     *    检查用户是否存在
     *
     *    @author    Garbin
     *    @return    void
     */
    function check_user()
    {
        $user_name = empty($_GET['user_name']) ? null : trim($_GET['user_name']);
        if (!$user_name)
        {
            echo ecm_json_encode(false);

            return;
        }
        $ms =& ms();

        echo ecm_json_encode($ms->user->check_username($user_name));
    }

    /**
     *    修改基本信息
     *
     *    @author    Hyber
     *    @usage    none
     */
    function profile(){

        $user_id = $this->visitor->get('user_id');
        if (!IS_POST)
        {
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'),  'index.php?app=member',
                             LANG::get('basic_information'));

            /* 当前用户中心菜单 */
            $this->_curitem('my_profile');

            /* 当前所处子菜单 */
            $this->_curmenu('basic_information');

            $ms =& ms();    //连接用户系统
            $edit_avatar = $ms->user->set_avatar($this->visitor->get('user_id')); //获取头像设置方式

            $model_user =& m('member');
            $profile    = $model_user->get_info(intval($user_id));
            $profile['portrait'] = portrait($profile['user_id'], $profile['portrait'], 'middle');
            $this->assign('profile',$profile);
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js',
            ));
            $this->assign('edit_avatar', $edit_avatar);
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_profile'));
            $this->display('member.profile.html');
        }
        else
        {
			//echo '<pre>';
			//print_r($_POST);
			//echo '</pre>';die;
            $data = array(
                'real_name' => $_POST['real_name'],
                'gender'    => $_POST['gender'],
                'birthday'  => $_POST['birthday'],
                'im_msn'    => $_POST['im_msn'],
                'im_qq'     => $_POST['im_qq'],
            );

            if (!empty($_FILES['portrait']))
            {
                $portrait = $this->_upload_portrait($user_id);
                if ($portrait === false)
                {
                    return;
                }
                $data['portrait'] = $portrait;
            }

            $model_user =& m('member');
            $model_user->edit($user_id , $data);
            if ($model_user->has_error())
            {
                $this->show_warning($model_user->get_error());

                return;
            }

            $this->show_message('edit_profile_successed');
        }
    }
    /**
     *    修改密码
     *
     *    @author    Hyber
     *    @usage    none
     */
    function password(){
        $user_id = $this->visitor->get('user_id');
        if (!IS_POST)
        {
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'),  'index.php?app=member',
                             LANG::get('edit_password'));

            /* 当前用户中心菜单 */
            $this->_curitem('my_profile');

            /* 当前所处子菜单 */
            $this->_curmenu('edit_password');
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js',
            ));
            $this->_config_seo('title', Lang::get('user_center') . ' - ' . Lang::get('edit_password'));
            $this->display('member.password.html');
        }
        else
        {
            /* 两次密码输入必须相同 */
            $orig_password      = $_POST['orig_password'];
            $new_password       = $_POST['new_password'];
            $confirm_password   = $_POST['confirm_password'];
            if ($new_password != $confirm_password)
            {
                $this->show_warning('twice_pass_not_match');

                return;
            }
            if (!$new_password)
            {
                $this->show_warning('no_new_pass');

                return;
            }
            $passlen = strlen($new_password);
            if ($passlen < 6 || $passlen > 20)
            {
                $this->show_warning('password_length_error');

                return;
            }

            /* 修改密码 */
            $ms =& ms();    //连接用户系统
            $result = $ms->user->edit($this->visitor->get('user_id'), $orig_password, array(
                'password'  => $new_password
            ));
            if (!$result)
            {
                /* 修改不成功，显示原因 */
                $this->show_warning($ms->user->get_error());

                return;
            }

            $this->show_message('edit_password_successed');
        }
    }
    /**
     *    修改电子邮箱
     *
     *    @author    Hyber
     *    @usage    none
     */
    function email(){
        $user_id = $this->visitor->get('user_id');
        if (!IS_POST)
        {
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'),  'index.php?app=member',
                             LANG::get('edit_email'));

            /* 当前用户中心菜单 */
            $this->_curitem('my_profile');

            /* 当前所处子菜单 */
            $this->_curmenu('edit_email');
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js',
            ));
            $this->_config_seo('title', Lang::get('user_center') . ' - ' . Lang::get('edit_email'));
            $this->display('member.email.html');
        }
        else
        {
            $orig_password  = $_POST['orig_password'];
            $email          = isset($_POST['email']) ? trim($_POST['email']) : '';
            if (!$email)
            {
                $this->show_warning('email_required');

                return;
            }
            if (!is_email($email))
            {
                $this->show_warning('email_error');

                return;
            }

            $ms =& ms();    //连接用户系统
            $result = $ms->user->edit($this->visitor->get('user_id'), $orig_password, array(
                'email' => $email
            ));
            if (!$result)
            {
                $this->show_warning($ms->user->get_error());

                return;
            }

            $this->show_message('edit_email_successed');
        }
    }

    /**
     * Feed设置
     *
     * @author Garbin
     * @param
     * @return void
     **/
    function feed_settings()
    {
        if (!$this->_feed_enabled)
        {
            $this->show_warning('feed_disabled');
            return;
        }
        if (!IS_POST)
        {
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'),  'index.php?app=member',
                             LANG::get('feed_settings'));

            /* 当前用户中心菜单 */
            $this->_curitem('my_profile');

            /* 当前所处子菜单 */
            $this->_curmenu('feed_settings');
            $this->_config_seo('title', Lang::get('user_center') . ' - ' . Lang::get('feed_settings'));

            $user_feed_config = $this->visitor->get('feed_config');
            $default_feed_config = Conf::get('default_feed_config');
            $feed_config = !$user_feed_config ? $default_feed_config : unserialize($user_feed_config);

            $buyer_feed_items = array(
                'store_created' => Lang::get('feed_store_created.name'),
                'order_created' => Lang::get('feed_order_created.name'),
                'goods_collected' => Lang::get('feed_goods_collected.name'),
                'store_collected' => Lang::get('feed_store_collected.name'),
                'goods_evaluated' => Lang::get('feed_goods_evaluated.name'),
                'groupbuy_joined' => Lang::get('feed_groupbuy_joined.name')
            );
            $seller_feed_items = array(
                'goods_created' => Lang::get('feed_goods_created.name'),
                'groupbuy_created' => Lang::get('feed_groupbuy_created.name'),
            );
            $feed_items = $buyer_feed_items;
            if ($this->visitor->get('manage_store'))
            {
                $feed_items = array_merge($feed_items, $seller_feed_items);
            }
            $this->assign('feed_items', $feed_items);
            $this->assign('feed_config', $feed_config);
            $this->display('member.feed_settings.html');
        }
        else
        {
            $feed_settings = serialize($_POST['feed_config']);
            $m_member = &m('member');
            $m_member->edit($this->visitor->get('user_id'), array(
                'feed_config' => $feed_settings,
            ));
            $this->show_message('feed_settings_successfully');
        }
    }

     /**
     *    三级菜单
     *
     *    @author    Hyber
     *    @return    void
     */
    function _get_member_submenu()
    {
        $submenus =  array(
            array(
                'name'  => 'basic_information',
                'url'   => 'index.php?app=member&amp;act=profile',
            ),
            array(
                'name'  => 'edit_password',
                'url'   => 'index.php?app=member&amp;act=password',
            ),
            array(
                'name'  => 'edit_email',
                'url'   => 'index.php?app=member&amp;act=email',
            ),
        );
        if ($this->_feed_enabled)
        {
            $submenus[] = array(
                'name'  => 'feed_settings',
                'url'   => 'index.php?app=member&amp;act=feed_settings',
            );
        }

        return $submenus;
    }

    /**
     * 商家上传营业执照或者名片
     *
     * @param int $user_id
     * @return mix false表示上传失败,空串表示没有上传,string表示上传文件地址
     */
    function _upload_portraitzz($user_id)
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
            $this->show_warning($uploader->get_error(), 'go_back', 'index.php?app=member&amp;act=profile');
            return false;
        }
        $uploader->root_dir(ROOT_PATH);
        return $uploader->save('data/files/mall/zhizhao/' . ceil($user_id / 500), $user_id);
    }
	/**
     * 材料商品牌logo
     *
     * @param int $user_id
     * @return mix false表示上传失败,空串表示没有上传,string表示上传文件地址
     */
    function _upload_portraitlogo($user_id)
    {
        $file = $_FILES['cls_logo'];
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
            $this->show_warning($uploader->get_error(), 'go_back', 'index.php?app=member&amp;act=profile');
            return false;
        }
        $uploader->root_dir(ROOT_PATH);
        return $uploader->save('data/files/mall/user_logo/' . ceil($user_id / 500), $user_id);
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
            $this->show_warning($uploader->get_error(), 'go_back', 'index.php?app=member&amp;act=profile');
            return false;
        }
        $uploader->root_dir(ROOT_PATH);
        return $uploader->save('data/files/mall/portrait/' . ceil($user_id / 500), $user_id);
    }
}

?>
