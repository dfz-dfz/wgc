<?php
session_start(); 
/* 定义like语句转换为in语句的条件 */
define('MAX_ID_NUM_OF_IN', 10000); // IN语句的最大ID数
define('MAX_HIT_RATE', 0.05);      // 最大命中率（满足条件的记录数除以总记录数）
define('MAX_STAT_PRICE', 10000);   // 最大统计价格
define('PRICE_INTERVAL_NUM', 5);   // 价格区间个数
define('MIN_STAT_STEP', 50);       // 价格区间最小间隔
define('NUM_PER_PAGE', 16);        // 每页显示数量
define('ENABLE_SEARCH_CACHE', true); // 启用商品搜索缓存
define('SEARCH_CACHE_TTL', 3600);  // 商品搜索缓存时间

class SearchApp extends MallbaseApp
{
	
	
	//发送手机验证码
	function send(){
		$mobile = trim($_POST['phone']);
		$code = mt_rand(100000,999999);
		$_SESSION['code'] = array('mobile'=>$mobile,'code'=>$code);
		
		
		//判断手机号是否被注册
		//$user=& m('member');
		//$sql="select zhizhao from ecm_store_user where mobe='{$mobile}' ";
		$sql="select * from ecm_member where phone_tel like '{$mobile}' OR  phone_mob like '{$mobile}' limit 0,1 ";
		$myquery=mysql_query($sql);
		$c=mysql_num_rows($myquery);
		//$c=count($res);
		if($c ==1){
			 echo $c;
			 exit;
		}
		
		$content="【59家居网】您的验证码是:{$code}，打死都不要告诉任何人，10分钟内有效";  //发送内容3s
		$time='';     //发送时间，为空时是即时发送
		$res = send($mobile,$content);
		echo "已将验证码发送至您你手机";
	}
	
	
	
	//服务条款
	function tiaokuan()
    {
		$this->display('store.tiaokuan.html');
		
	}
	//预算报价（首页）
	function baojia()
    {
		$this->display('baojia.html');
		
	}
	//个人用户中心工人定额
	function user_worker_dinge()
    {
		$this->display('user_worker_dinge.html');
		
	}
	//个人中心主材定额
	function user_zhucai_dingjia(){
		$this->display('user_zhucai_dingjia.html');
	}
	//个人中心通讯录
	function user_tel(){
		$this->display('user_tel.html');
	}
	//个人中心个人信息
	function user_baseinfo(){
		$this->display('user_baseinfo.html');
	}
	//个人中心个人消息
	function user_message(){
		$this->display('user_message.html');
	}
	//个人中心个人积分
	function user_vip(){
		$this->display('user_vip.html');
	}
	//个人中心个人认证
	function user_resure(){
		$this->display('user_resure.html');
	}
	//个人中心个人工人查询
	function user_worker_search(){
		$this->display('user_worker_search.html');
	}
	//个人中心个人工人查询
	function user_worker_xunjia(){
		$this->display('user_worker_xunjia.html');
	}
	//个人中心个人辅材定额
	function user_fucai_dingjia(){
		$this->display('user_fucai_dingjia.html');
	}
	//个人中心个人预算
	function user_yusuan(){
		$this->display('user_yusuan.html');
	}
	//个人中心个人材料采购
	function user_material_purchase(){
		$this->display('user_material_purchase.html');
	}
	//个人中心个人业务信息
	function user_customer_message(){
		$this->display('user_customer_message.html');
	}
	//个人中心个人维修管理
	function user_repair(){
		$this->display('user_repair.html');
	}
	//个人中心个人项目管理
	function user_project(){
		$this->display('user_project.html');
	}//个人中心个人发布招聘
	function user_employ(){
		$this->display('user_employ.html');
	}//个人中心维修报价
	function user_baojia(){
		$this->display('user_baojia.html');
	}//个人中心个人发布集采
	function user_collection(){
		$this->display('user_collection.html');
	}//个人中心个人发布列表
	function user_show_list(){
		$this->display('user_show_list.html');
	}//个人中心个人创建简历
	function user_resume(){
		$this->display('user_resume.html');
	}//个人中心个人编辑简历
	function user_editresume(){
		$this->display('user_editresume.html');
	}//个人中心个人我的简历
	function user_myresume(){
		$this->display('user_myresume.html');
	}
	function companycenter(){
		$this->display('companycenter.html');
	}
	function user_projectFB(){
		$this->display('user_projectFB.html');
	}//个人中心项目分包
	function user_design(){
		$this->display('user_design.html');
	}//个人中心设计分包
	
       //企业中心
	//公司信息
	function company_baseinfo(){
		$this->display('company_baseinfo.html');
	}
	//通讯录
	function company_tel(){
		$this->display('company_tel.html');
	}
	//消息
	function company_message(){
		$this->display('company_message.html');
	}
	//积分
	function company_vip(){
		$this->display('company_vip.html');
	}
	//认证
	function company_resure(){
		$this->display('company_resure.html');
	}
	//工人定额
	function company_worker_dinge(){
		$this->display('company_worker_dinge.html');
	}
	//工人查询
	function company_worker_search(){
		$this->display('company_worker_search.html');
	}
	//工人询价
	function company_worker_xunjia(){
		$this->display('company_worker_xunjia.html');
	}
	//主材定价
	function company_zhucai_dingjia(){
		$this->display('company_zhucai_dingjia.html');
	}
	//辅材定价
	function fucaidinge(){
		$this->display('fucaidinge.html');
	}
	//预算定价
	function yusuan(){
		$this->display('yusuan.html');
	}
		// 预算报价-->人工定额
		function regong(){
			$this->display('regong.html');
		}
			//预算报价->数据定额
			function regong_datalist(){
				$this->display('regong_datalist.html');
			}
		//预算报价->主材定额
		function zhucaidinge(){
			$this->display('zhucaidinge.html');
		}
			//预算报价->数据定额
			function zhucai_datalist(){
				$this->display('zhucai_datalist.html');
			}
		//预算报价->辅材定额
		function fucaitable(){
			$this->display('fucaitable.html');
		}
			// 预算报价->数据定额
			function fucai_datalist(){
				$this->display('fucai_datalist.html');
			}
	//材料采购
	function company_repair(){
		$this->display('company_repair.html');
	}
	//业务信息
	function company_projecr(){
		$this->display('company_projecr.html');
	}
	//维修项目
	function company_employ(){
		$this->display('company_employ.html');
	}
	//项目管理
	function company_collection(){
		$this->display('company_collection.html');
	}
	//发布招聘
	function company_showlist(){
		$this->display('company_showlist.html');
	}
	//发布集采
	function resume_show(){
		$this->display('resume_show.html');
	}
	//发布列表
	function company_material_purchase(){
		$this->display('company_material_purchase.html');
	}
	//简历1
	function company_customer_message(){
		$this->display('company_customer_message.html');
	}
	//维修报价详情
	function weixiu_details(){
		$this->display('weixiu_details.html');
	}
	// APP下载
	function downapp(){
		$this->display('downapp.html');
	}
	//登陆
	function sessions()
    {	
			//var_dump(7777);
		$data['user_id'] = $_GET['user_id'];
		$data['user_name'] = $_GET['user_name'];
		$data['userphoto'] = $_GET['userphoto'];
		$data['regtime'] = $_GET['regtime'];
		$data['utype'] = $_GET['utype'];
		$_SESSION["user_info"] = $data;
	
		header('location:index.php?app=search&act=user_baseinfo');
	}
	
	//获取选择城市
	function sessions_city(){
		
		$city = $_GET['city'];
		$_SESSION["city"] = $city;
		
		header('location:'.$_SERVER['HTTP_REFERER'].'');
	}
	
	//个人中心
	function users(){
		//var_dump($_SESSION);
		$this->display('member.index.html');
	}
	
	
	
	function zhaopin(){

			
		if($_POST){
			$cate_id = $_POST['cate_id'];
			$key = $_POST['key'];
			
			if($_POST['cate_id'] == '全部'){
				
				$query="select * from ecm_zhaopin where status=0 and title like '%$key%' order by id desc limit 41,200"; //定义sql
				
			}else{
				
				$query="select * from ecm_zhaopin where status=0 and hangye='$cate_id' and title like '%$key%' order by id desc limit 41,200"; //定义sql
			}
			$query1="select * from ecm_zhaopin where status=0 order by id desc limit 0,200"; //定义sql
			
			$this->assign('key', $key);
			$this->assign('cate_id', $cate_id);
		}else{
			
			$cate_id = $_GET['cate_id'];
			
			if(empty($_GET['cate_id']) || !isset($_GET['cate_id'])){
				$query="select * from ecm_zhaopin where status=0 order by id desc limit 41,40"; //定义sql
			}else{
				$query="select * from ecm_zhaopin where status=0 and hangye='$cate_id' order by id desc limit 41,40"; //定义sql
			}
			
			
			$query1="select * from ecm_zhaopin where status=0 order by id desc limit 0,200"; //定义sql
			
		}
		
		$result=mysql_query($query); //发送sql查询
		$result1=mysql_query($query1); //发送sql查询
		//$con = array();
		/*if($result != false){
			while($rows=@mysql_fetch_array($result)){
				$xinzi= $rows['xinzi']>0 ? $rows['xinzi'] : '面议';
				$con .="<ul>";
				$con .="	<a href=\"index.php?app=search&act=content&id={$rows['id']}\"> ";
				$con .="		<li style='height:50px;line-height:50px;padding:0;text-align:center;width: 200px;'><i><img src='/themes/mall/jiaju/styles/style/zp/images/index_07.jpg'></i>{$rows['title']}</li>";
				$con .="		<li style='height:50px;line-height:50px;padding:0;text-align:center;width: 330px;'>{$rows['gname']}</li>";
				$con .="		<li style='height:50px;line-height:50px;padding:0;text-align:center;width: 100px;'>{$xinzi}</li>";
				$con .="		<li style='height:50px;line-height:50px;padding:0;text-align:center;width: 200px;'>{$rows['s_province']}{$rows['s_city']}{$rows['s_county']}</li>";
				$con .="		<li style='height:50px;line-height:50px;padding:0;text-align:center;width: 200px;'>".date('Y-m-d',strtotime($rows['addtime']))."</li>";
				$con .="		<div class='clear'></div>";
				$con .="	</a>";
				$con .="</ul>";
			}
		}else{
			$con .= '<div style="height:300px;line-height:200px;text-align:center;font-size:12px;color:#ccc">暂无数据</div>';
		}*/
		
		if(mysql_num_rows($result) > 0){
			while($rows=@mysql_fetch_array($result)){

	
				$con .="<a style='margin:5px 10px;' href=\"index.php?app=search&act=content&id={$rows['id']}\"style='overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;max-width:120px'> {$rows['title']}</a>";
			}
			
		}else{
			$con = '<div style="height:195px;line-height:100px;text-align:center;font-size:16px;color:#ccc">暂无相关职位！</div>';
		}
		while($rows1=@mysql_fetch_array($result1)){

			$xinzi= $rows1['xinzi']>0 ? $rows1['xinzi'] : '面议';
			$con1 .="<ul class='list-ul'>";
			$con1 .="		<li>";
			$con1 .="		<p class='title'><a href=\"index.php?app=search&act=content&id={$rows1['id']}\">{$rows1['title']}</a></p>";
			$con1 .="		<p class='gname'><a href=\"index.php?app=search&act=content&id={$rows1['id']}\">{$rows1['gname']}</a></p>";
			$con1 .="		<p class='xinzi'>{$xinzi}</p>";
			//$con1 .="		<p class='time'>".date('Y-m-d',$rows['addtime'])."</p>";
			$con1 .="		<p class='time'>".date('Y-m-d',time())."</p>";
			$con1 .="</li></ul>";
	
			//$con1 .="	<a href=\"index.php?app=search&act=content&id={$rows1['id']}\"style='overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;max-width:120px'> {$rows1['title']}</a>";
		}
		
		$this->assign('con', $con);
		$this->assign('con1', $con1);
		$this->display('search.zhaopin.html');
	
	}
	
	function zhaopin_search(){

		$key = $_POST['key'];	
		if($_POST){
			
			$query1="select * from ecm_zhaopin where status=0 and title like '%$key%' order by id desc limit 0,200"; //定义sql
		
		}	
		$result1=mysql_query($query1); //发送sql查询
		
		if(@mysql_num_rows($result1) > 0){
			
			$this->assign('num', mysql_num_rows($result1));
			$this->assign('key', $key);
		
			while($rows1=@mysql_fetch_array($result1)){

				$xinzi= $rows1['xinzi']>0 ? $rows1['xinzi'] : '面议';
				$con1 .="<ul class='list-ul'>";
				$con1 .="		<li>";
				$con1 .="		<p class='title'><a href=\"index.php?app=search&act=content&id={$rows1['id']}\">{$rows1['title']}</a></p>";
				$con1 .="		<p class='gname'><a href=\"index.php?app=search&act=content&id={$rows1['id']}\">{$rows1['gname']}</a></p>";
				$con1 .="		<p class='xinzi'>{$xinzi}</p>";
				//$con1 .="		<p class='time'>".date('Y-m-d',$rows['addtime'])."</p>";
				$con1 .="		<p class='time'>".date('Y-m-d',time())."</p>";
				$con1 .="</li></ul>";
		
				//$con1 .="	<a href=\"index.php?app=search&act=content&id={$rows1['id']}\"style='overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;max-width:120px'> {$rows1['title']}</a>";
			}
		
		}else{
			$this->assign('num', count($num));
			$this->assign('key', $key);
			$con1 = '<div style="height:195px;line-height:100px;text-align:center;font-size:16px;color:#ccc">暂无相关职位！</div>';
			
		}
		
		$this->assign('con1', $con1);
		$this->display('search.zhaopin_search.html');
	
	}
	
	function zhaopin_list(){
		if($_POST){
			$cate_id = $_POST['cate_id'];
			$key = $_POST['key'];
			
			if($_POST['cate_id'] == '全部'){
				
				$query="select * from ecm_zhaopin where status=0 and s_city='$s_city' and title like '%$key%' order by id desc "; //定义sql
				
			}else{
				
				$query="select * from ecm_zhaopin where status=0 and s_city='$s_city' and hangye='$cate_id' and title like '%$key%' order by id desc"; //定义sql
			}
			$this->assign('key', $key);
			$this->assign('cate_id', $cate_id);
		}else{
		
			$s_city = $_SESSION['city'];
			$cate_id = $_GET['cate_id'];
			
			if(empty($_GET['cate_id']) || !isset($_GET['cate_id'])){
				$query="select * from ecm_zhaopin where status=0 and s_city='$s_city' order by id desc"; //定义sql
			}else{
				$query="select * from ecm_zhaopin where status=0 and s_city='$s_city' and hangye='$cate_id' order by id desc"; //定义sql
			}
		}
		
		
		
		$result=mysql_query($query); //发送sql查询
		//$con = array();
		if($result != false){
			while($rows=@mysql_fetch_array($result)){
				$xinzi= $rows['xinzi']>0 ? $rows['xinzi'] : '面议';
				$con .="<ul>";
				$con .="	<a href=\"index.php?app=search&act=content&id={$rows['id']}\"> ";
				$con .="		<li style='height:50px;line-height:50px;padding:0;text-align:center;width: 200px;'><i><img src='/themes/mall/jiaju/styles/style/zp/images/index_07.jpg'></i>{$rows['title']}</li>";
				$con .="		<li style='height:50px;line-height:50px;padding:0;text-align:center;width: 330px;'>{$rows['gname']}</li>";
				$con .="		<li style='height:50px;line-height:50px;padding:0;text-align:center;width: 100px;'>{$xinzi}</li>";
				$con .="		<li style='height:50px;line-height:50px;padding:0;text-align:center;width: 200px;'>{$rows['s_province']}{$rows['s_city']}{$rows['s_county']}</li>";
				$con .="		<li style='height:50px;line-height:50px;padding:0;text-align:center;width: 200px;'>".date('Y-m-d',strtotime($rows['addtime']))."</li>";
				$con .="		<div class='clear'></div>";
				$con .="	</a>";
				$con .="</ul>";
			}
		}else{
			$con .= '<div style="height:300px;line-height:200px;text-align:center;font-size:12px;color:#ccc">暂无数据</div>';
		}
		
		$this->assign('con', $con);
		
		$this->display('search.zhaopin_list.html');
	
	}
	//招聘详细
	function content(){
		header("Content-Type: text/html; charset=utf-8");
		$timezone="Asia/Shanghai";
		date_default_timezone_set($timezone); //北京时间
		
		
		$id = $_GET['id'];
		
		
		if($_POST){
			
			$userid = $_SESSION['user_info']['user_id'];
			
			if(empty($userid)){
				echo"<script>alert('请先登录！');history.go(-1);</script>";  exit;
			}
			
			$user_name = $_SESSION['user_info']['user_name'];
			$content = $_POST['content'];
			$id = $_POST['pid'];
			
			if($_POST['zhaobiao'] == 'zhaobiao'){
			
				$sql = "INSERT INTO `ecm_zhaobiao_pinlun` (`pid`, `uid`, `uname`, `content`, `addtime`) VALUES ('" . $id . "', '" . $userid . "',  '" . $user_name . "',  '" . $content . "',  '" . date('Y-m-d H:i:s',time()) . "');";
			
			}else{
			
				$sql = "INSERT INTO `ecm_zhaopin_pinlun` (`pid`, `uid`, `uname`, `content`, `addtime`) VALUES ('" . $id . "', '" . $userid . "',  '" . $user_name . "',  '" . $content . "',  '" . date('Y-m-d H:i:s',time()) . "');";
			
			}
			
			
			
			if(mysql_query($sql)){
				header('Location:'.$_SERVER['HTTP_REFERER']);exit;
			}else{
				
				echo "<script>alert('操作失败'); history.go(-1); </script>";
			}
			
			exit;
			
		}	
		
		$query="select * from ecm_zhaopin where status=0 and id='$id'"; //定义sql
		
		
		
		
		$result=mysql_query($query); //发送sql查询
		
		$rows=@mysql_fetch_array($result);
		
		
		$this->assign('id', $_GET['id']);
		
		$this->display('search.content.html');
	
	}
	function storeadd(){
		$user_id = $_SESSION['user_info']['user_id'];
		if(IS_POST){
			$gslogourl=$_POST['gslogourl'];
			$teamurl=trim($_POST['teamurl'],',');
			$hburl=$_POST['hburl'];
			$jdurl=trim($_POST['jdurl'],',');
			$gname=$_POST['gname'];
			$gtype=$_POST['gtype'];
			$lianxiren=$_POST['lianxiren'];
			$weixin=$_POST['weixin'];
			$phone=$_POST['phone'];
			$email=$_POST['email'];
			$tel=$_POST['tel'];
			$weburl=$_POST['weburl'];
			$qq=$_POST['qq'];
			$s_province=$_POST['s_province'];
			$s_city=$_POST['s_city'];
			$s_county=$_POST['s_county'];
			$xiangxi=$_POST['xiangxi'];
			$jianjie=$_POST['jianjie'];
			$fanwei=$_POST['fanwei'];
			$addtime=time();
			/*if(!empty($gslogourl)){
				$gslogourl='<img src="'.$gslogourl.'" >';
			}
			if(!empty($hburl)){
				$hburl='<img src="'.$hburl.'" >';
			}
			if(!empty($teamurl)){
				$arr=explode(",",$teamurl);
				foreach($arr as $key=>$val){
					if(empty($val)){
						unset($arr[$key]);
					}
				}
				$teamurl="";
				foreach($arr as $key=>$val){
					$teamurl.='<img src="'.$val.'" >';
				}	
			}
			if(!empty($jdurl)){
				$arr=explode(",",$jdurl);
				foreach($arr as $key=>$val){
					if(empty($val)){
						unset($arr[$key]);
					}
				}
				$jdurl="";
				foreach($arr as $key=>$val){
					$jdurl.='<img src="'.$val.'" >';
				}	
			}*/
			if(!empty($teamurl)){
				$arr=explode(",",$teamurl);
				foreach($arr as $key=>$val){
					if(empty($val)){
						unset($arr[$key]);
					}
				}
				$teamurl="";
				foreach($arr as $key=>$val){
					$teamurl.=$val.',';
				}	
			}
			if(!empty($jdurl)){
				$arr=explode(",",$jdurl);
				foreach($arr as $key=>$val){
					if(empty($val)){
						unset($arr[$key]);
					}
				}
				$jdurl="";
				foreach($arr as $key=>$val){
					$jdurl.=$val.',';
				}	
			}
			/*echo '<pre>';
			print_r($_POST);
			echo '</pre>';die;*/
			if(empty($_POST['id']) && !isset($_POST['id'])){
				if($user_id){
					$sql = "INSERT INTO `ecm_company` (`user_id`, `gname`, `gtype`, `gslogourl`, `jianjie`, `fanwei`, `lianxiren`, `phone`, `tel`, `weixin`, `qq`, `email`, `weburl`, `s_province`, `s_city`, `s_county`, `xiangxi`, `hburl`, `teamurl`, `jdurl`, `addtime`) VALUES ($user_id, '$gname', '$gtype', $gslogourl', '$jianjie', '$fanwei', '$lianxiren', '$phone', '$tel', '$weixin', '$qq', '$email', '$weburl', '$s_province', '$s_city', '$s_county', '$xiangxi', '$hburl', '$teamurl', '$jdurl', $addtime);";
					$result=mysql_query($sql); //发送sql查询
					$insertid=mysql_insert_id();
					if($insertid){
						header('Location:http://59jiaju.com/index.php?app=goods&act=storeinfo&id='.$insertid);exit;
					}
				  }
			}else{
				if($user_id){
					$sql = "UPDATE `ecm_company` SET  `gname`='$gname', `gtype`='$gtype', `gslogourl`='$gslogourl', `jianjie`='$jianjie', `fanwei`='$fanwei', `lianxiren`='$lianxiren', `phone`='$phone', `tel`='$tel', `weixin`='$weixin', `qq`='$qq', `email`='$email', `weburl`='$weburl', `s_province`='$s_province', `s_city`='$s_city', `s_county`='$s_county', `xiangxi`='$xiangxi', `hburl`='$hburl', `teamurl`='$teamurl', `jdurl`='$jdurl' WHERE `id`={$_POST['id']} and `user_id`={$user_id} ;";
					if($_POST['s_province']=='请选择'){
						$sql = "UPDATE `ecm_company` SET  `gname`='$gname', `gtype`='$gtype', `gslogourl`='$gslogourl', `jianjie`='$jianjie', `fanwei`='$fanwei', `lianxiren`='$lianxiren', `phone`='$phone', `tel`='$tel', `weixin`='$weixin', `qq`='$qq', `email`='$email', `weburl`='$weburl', `xiangxi`='$xiangxi', `hburl`='$hburl', `teamurl`='$teamurl', `jdurl`='$jdurl' WHERE `id`={$_POST['id']} and `user_id`={$user_id} ;";
					}elseif($_POST['s_city']=='请选择'){
						$sql = "UPDATE `ecm_company` SET  `gname`='$gname', `gtype`='$gtype', `gslogourl`='$gslogourl', `jianjie`='$jianjie', `fanwei`='$fanwei', `lianxiren`='$lianxiren', `phone`='$phone', `tel`='$tel', `weixin`='$weixin', `qq`='$qq', `email`='$email', `weburl`='$weburl', `s_province`='$s_province', `xiangxi`='$xiangxi', `hburl`='$hburl', `teamurl`='$teamurl', `jdurl`='$jdurl' WHERE `id`={$_POST['id']} and `user_id`={$user_id} ;";
					}elseif($_POST['s_county']=='请选择'){
						$sql = "UPDATE `ecm_company` SET  `gname`='$gname', `gtype`='$gtype', `gslogourl`='$gslogourl', `jianjie`='$jianjie', `fanwei`='$fanwei', `lianxiren`='$lianxiren', `phone`='$phone', `tel`='$tel', `weixin`='$weixin', `qq`='$qq', `email`='$email', `weburl`='$weburl', `s_province`='$s_province', `s_city`='$s_city', `xiangxi`='$xiangxi', `hburl`='$hburl', `teamurl`='$teamurl', `jdurl`='$jdurl' WHERE `id`={$_POST['id']} and `user_id`={$user_id} ;";
					}
					//echo $sql;die;
					$result=mysql_query($sql); //发送sql查询
					$affected_rows=mysql_affected_rows();
					if($affected_rows>=0){
						header('Location:http://59jiaju.com/index.php?app=goods&act=storeinfo&id='.$_POST['id']);exit;
					}
			  }
			}
		}
		if($user_id){
				$query="select * from ecm_company where user_id = {$user_id}";
				$result=mysql_query($query); //发送sql查询
				if($result != false){
					$list=@mysql_fetch_assoc($result);
				}
				if(!empty($list)){
					if(!empty($list['teamurl'])){
						$teamurl=$list['teamurl'];
						$arr1=explode(",",$teamurl);
						foreach($arr1 as $key=>$val){
							$val=trim($val);
							if(empty($val)){
								unset($arr1[$key]);
							}
						}
						$list['teamurl2']=$arr1;
					}
					if(!empty($list['jdurl'])){
						$jdurl=$list['jdurl'];
						$arr2=explode(",",$jdurl);
						foreach($arr2 as $key=>$val){
							$val=trim($val);
							if(empty($val)){
								unset($arr2[$key]);
							}
						}
						$list['jdurl2']=$arr2;
					}
					
				}
				$this->assign('list',$list);
				$this->assign('id',$list['id']);
		  }
		$this->display('storeadd.html');
	}
	function picture_addmore(){
		
		  //公司logo
		  if(!empty($_FILES['gslogo']['name'])){
			  $userid = $_SESSION['user_info']['user_id'];
			  if($userid){
				   $gslogourl = $this->_upload_gongsilogo($userid);
				   $img='<img src="'.$gslogourl.'" style="width:100%;height:100%;">';
				   echo "<script type='text/javascript'>parent.show_img('{$img}');parent.set_gslgpicurl('{$gslogourl}');</script>";
			  }else{
				  echo '上传失败,请登录';die;
			  }
			 
		  }
		  //上传公司团队
		   if(!empty($_FILES['teamlogo']['name'])){
			  $userid = $_SESSION['user_info']['user_id'];
			  if($userid){
				   $teamlogourl = $this->_upload_teamlogo($userid);
				   $img='<img onclick="closed($(this))" src="'.$teamlogourl.'" style="width:30%;">';
				   echo "<script type='text/javascript'>parent.show_img3('{$img}');parent.set_teampicurl('{$teamlogourl}');</script>";
			  }else{
				  echo '上传失败,请登录';die;
			  }
			 
		  }
		  //上传公司海报图gsgd
		   if(!empty($_FILES['gsgd']['name'])){
			  $userid = $_SESSION['user_info']['user_id'];
			  if($userid){
				   $hblogourl = $this->_upload_haibao($userid);
				   $img='<img src="'.$hblogourl.'" style="width:30%;">';
				   echo "<script type='text/javascript'>parent.show_img2('{$img}');parent.set_hbpicurl('{$hblogourl}');</script>";
			  }else{
				  echo '上传失败,请登录';die;
			  }
			 
		  }
		  //上传经典案例
		   if(!empty($_FILES['jddemo']['name'])){
			  $userid = $_SESSION['user_info']['user_id'];
			  if($userid){
				   $jdlogourl = $this->_upload_jddemo($userid);
				   $img='<img onclick="closed2($(this))" src="'.$jdlogourl.'" style="width:30%;">';
				   echo "<script type='text/javascript'>parent.show_img4('{$img}');parent.set_jdpicurl('{$jdlogourl}');</script>";
			  }else{
				  echo '上传失败,请登录';die;
			  }
			 
		  }
	}
	function picture_del(){
		$url=trim($_GET['url']);
		if(!empty($url)){
			$path="http://59jiaju.com/".$url;
			unlink($path);
			echo 'ok';die;
		}else{
			echo 'err';die;
		}
		
	}
	/**
     * 上传公司logo
     *
     * @param int $user_id
     * @return mix false表示上传失败,空串表示没有上传,string表示上传文件地址
     */
    function _upload_gongsilogo($user_id)
    {
        $file = $_FILES['gslogo'];
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
        return $uploader->save('data/files/mall/gongsiinfo/'.ceil($user_id / 500).'gslg', time().rand(1000,9999).$user_id);
    }
	//上传团队照片_upload_teamlogo
	function _upload_teamlogo($user_id)
    {
        $file = $_FILES['teamlogo'];
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
        return $uploader->save('data/files/mall/gongsiinfo/'.ceil($user_id / 500).'tlg', time().rand(1000,9999).$user_id);
    }
	//公司海报图gsgd
	function _upload_haibao($user_id)
    {
        $file = $_FILES['gsgd'];
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
        return $uploader->save('data/files/mall/gongsiinfo/'.ceil($user_id / 500).'haib', time().rand(1000,9999).$user_id);
    }
	//上传经典案例 _upload_jddemo
	function _upload_jddemo($user_id)
    {
        $file = $_FILES['jddemo'];
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
        return $uploader->save('data/files/mall/gongsiinfo/'.ceil($user_id / 500).'jddemo',time().rand(1000,9999).$user_id);
    }

	//招聘列表
	function joblist(){
		header("Content-Type: text/html; charset=utf-8");//防止界面乱码
		$arr=array(
			'1' => '施工队长',
			'2' => '水电工长',
			'3' => '空调安装工长',
			'4' => '空调安装工',
			'5' => '泥水工',
			'6' => '水电工',
			'7' => '电焊工',
			'8' => '家具安装工',
			'9' => '木工',
			'10' => '扇灰工',
			'11' => '保洁工',
			'12' => '杂工',
			'13' => '设计师',
			'14' => '预算员',
			'15' => '其它',
			'16' => '维修工',
			'17' => '网络维修',
			'18' => '实习预结算员',
			'19' => '室内设计师',
			'20' => '工程经理',
			'21' => '机电工程师',
			'22' => '暖通设计师',
			'23' => '采购经理',
			'24' => '文案',
			'25' => '平面设计',
			'26' => '效果图设计师',
			'27' => '客服专员',
			'28' => '行政助理',
			'29' => '软件销售经理',
			'30' => '业务员',
			'31' => '项目经理',
			'32' => '水电维修',
			'33' => '空调维修',
			'34' => '装饰维修',
			'35' => '设备维修',
		);
		$con=mysql_connect('localhost','root','Hll72xiwr43p0ia5padma');//数据库用户名，密码
		if(!$con){
			die('connect failed!');
		}
		mysql_select_db("wgc_db", $con);
		mysql_query("SET NAMES utf8");//解决数据库中有汉字时显示在前台出现乱码问题

		if(!empty($_GET['page'])){
			 $pageType   = $_GET['pageType'];
			 //上一页
			 if($pageType == 'uppage'){
			 	if($_GET['page']>1){
			 		$pageNum = $_GET['page']-1;
			 		$limit = $pageNum*20;
			 		$page = "limit ".$limit.",20";

			 	}else{
			 		$pageNum = 2;
			 		$page = "limit 1,20";
			 	}
			 	
			 }
			 //下一页
			 if($pageType == 'nextpage'){
			 	$pageNum = $_GET['page']+1;
			 	$limit = $pageNum*20;
			 	$page = "limit ".$limit.",20";
			 }
			 
		}else{
			//默认页码
			$pageNum = 2;
			$page = "limit 1,20";
		}

 		//echo $pageNum;
		//echo "<pre>";
		//var_dump($_GET);
		if(!empty($_POST['key'])){

			$key = $_POST['key'];
			$zhiwei = array_search($key,$arr);
			var_dump($zhiwei);
			$query="select id,today,xinzi,company_name,zhiwei from ecm_recruit where zhiwei like'%".$arr[$zhiwei]."%' or company_name like'%".$key."%' or xinzi like'%".$key."%' order by id desc ".$page.""; //定义sql

			
		}else{
			if(!empty($_GET['typeid'])){
				$typeid = $arr[$_GET['typeid']];
				$query="select id,today,xinzi,company_name,zhiwei from ecm_recruit where zhiwei='".$typeid."' order by id desc ".$page.""; //定义sql
			}else{
				$query="select id,today,xinzi,company_name,zhiwei from ecm_recruit order by id desc ".$page.""; //定义sql
			}
		}

		
		
		$result=mysql_query($query);

		$dataNum = array();
		while ($row = mysql_fetch_array($result)) {
		  	$dataNum[] = $row;

		    $data .= '<ul class="list-ul">';
				$data .= '<li>';	
					$data .= '<p class="title"><a href="index.php?app=search&amp;act=content&amp;id='.$row['id'].'">'.$row['zhiwei'].'</a></p>';
					$data .= '<p class="gname"><a href="index.php?app=search&amp;act=content&amp;id='.$row['id'].'">'.$row['company_name'].'</a></p>';
					$data .= '<p class="xinzi">'.$row['xinzi'].'/元</p>';
					$data .= '<p class="time">'.$row['today'].'</p>';
				$data .= '</li>';
			$data .= '</ul>';
		}
		
		

		$type = '';
		foreach($arr as $k => $v){
			$type .= '<a href="index.php?app=search&act=joblist&typeid='.$k.'" style="margin: 5px 10px;">'.$v.'</a>';
		}

		$dataPage .= '<a style="padding:3px 10px;background:red;color:#fff;width: 50px;border:1px solid red;margin-right: 50px;cursor: pointer;" href="/index.php?app=search&act=joblist&pageType=uppage&page='.$pageNum.'">上一页</a>';
		if(count($dataNum) >= 20){
			$dataPage .= '<a style="padding:3px 10px;background:red;color:#fff;width: 50px;border:1px solid red;cursor: pointer;" href="/index.php?app=search&act=joblist&pageType=nextpage&page='.$pageNum.'">下一页</a>';
		}
		//关闭数据库
		mysql_close($con);
		$this->assign('type',$type);
		$this->assign('data',$data);
		$this->assign('key',$key);
		$this->assign('dataPage',$dataPage);
		$this->assign('dataNum',count($dataNum));
		$this->display('zhaopinsearch.html');
	}

	//维修报价列表
	function weixiulist(){
		$this->display('weixiusearch.html');	
	}

	// 设计分包列表
	function shejifenbao(){
		$this->display('shejifenbao_list.html');
	}

	//设计分包详情
	function shejifenbao_details(){
		$this->display('shejifenbao_details.html');
	}

	//项目分包
	function xiangmu(){
		$this->display('xiangmu_list.html');
	}

	//项目分包详情
	function xiangmu_details(){
		$this->display('xiangmu_details.html');
	}

	function te(){
		$this->display('te.html');
	}
	//材料合作商申请
	function cailiaoshangshenqing(){
		
		$this->display('cailiaoshangshenqing.html');
	}
	//集采合作供应商
	function gongyingshang(){
		
		$this->display('gongyingshang.html');
	}
	
	//集采合作供应商-详情
	function content_gongyingshang(){
		$this->assign('id', $_GET["id"]);
		$this->display('content_gongyingshang.html');
	}

	// 材料推广
	function cailiaotuiguang(){
		$this->display('cailiaotuiguang_list.html');
	}

	// 材料推广详情
	function cailiaotuiguang_content(){
		$this->display('cailiaotuiguang_details.html');
	}

	//工价询价
	function gongjiaxunjia(){
		$this->display('gongjiaxunjia_list.html');
	}

	//工价询价详情
	function gongjiaxunjia_content(){
		$this->display('gongjiaxunjia_details.html');
	}
	
	//工价
	function gongjia(){
		
		$this->display('gongjia.html');
	}
	//工价详情
	function gongjia_content(){
		$this->assign('id', $_GET['id']);
		$this->display('gongjia_content.html');
	}
	//APP下载
	function xiazai(){
		
		$this->display('xiazai.html');
	}
	
	//装饰企业集采报名
	function jicaibaoming(){
		
		$this->display('jicaibaoming.html');
	}
	
	//行业资讯
	function news(){
		
		$this->display('news.html');
	}

	//项目合作
	function xiangmuhezuo(){
		$this->display('xiangmuhezuo.html');
	}

	//区域合作
	function quyuhezuo(){
		$this->display('quyuhezuo.html');
	}
	
	//行业资讯详情
	function news_content(){
		$this->assign('id', $_GET['id']);
		$this->assign('title', $_GET['title']);
		$this->display('news_content.html');
	}
	
	//招工、找工列表--分类
	function joblist3(){
		$this->assign('type', $_GET['type']);
		$this->display('zhaopinsearch3.html');
	}
	//招工、找工列表-用户
	function joblist3_content(){
		$type = $_GET['type'];
		$name = $_GET['name'];
		$this->assign('name', $name);
		$this->assign('type', $type);
		$this->display('joblist3_content.html');
	}
	//招工、找工列表-用户
	function joblist3_content_user(){
		$id   = $_GET['id'];
		$name = $_GET['name'];
		$this->assign('id', $id);
		$this->assign('name', $name);
		$this->display('joblist3_content_user.html');
	}
	//招工、找工列表
	function joblist2(){
		//选中定位标志
		if(empty($_SESSION['qb']) || !isset($_SESSION['qb']) || ($_GET['dqlimit']=='y')){
			$_SESSION['qb']='n';
		}else{
			$_SESSION['qb']=$_GET['s_county'];
		}
		if(empty($_SESSION['xb']) || !isset($_SESSION['xb']) || ($_GET['xinzilimit']=='y')){
			$_SESSION['xb']='n';
		}else{
			$_SESSION['xb']=$_GET['xinzi'];
		}
			$s_county=$_GET['s_county'];
			$s_city = city();
			$cate_id = $_GET['cate_id'];
			$title = trim($_GET['title']);
			$jobtype=$_GET['jobtype'];
			if(!empty($title)){
				if($jobtype){
					$query=" AND status=0  AND ( title like '%{$title}%'  "." OR jobtype=".$jobtype." ) ";
				}else{
					$query=" AND status=0  AND title like '%{$title}%'  ";
				}
			}else{
				if($jobtype){
					$query=" AND status=0 "."AND jobtype=".$jobtype;
				}else{
					$query=" AND status=0  ";
				}
			}
			
			if(empty($_GET['cate_id']) || !isset($_GET['cate_id'])){
				if(!empty($s_city) && isset($s_city)){
					if(!empty($_GET['s_county']) || isset($_GET['s_county'])){
						$query.="  AND s_city like '%$s_city%' AND s_county like '%$s_county%' "; //定义sql
					}else{
						$query.=" AND s_city like '%$s_city%' ";
					}
				}else{
					if(!empty($_GET['s_county']) || isset($_GET['s_county'])){
						$query.=" AND s_county like '%$s_county%' "; //定义sql
					}
				}
				
			}else{
				if(!empty($s_city) && isset($s_city)){
					if(!empty($_GET['s_county']) || isset($_GET['s_county'])){
						$query.="  AND hangye='{$cate_id}'   AND s_city like '%$s_city%'  AND s_county like '%$s_county%' "; //定义sql
					}else{
						$query.="  AND hangye='{$cate_id}'   AND s_city like '%$s_city%'  ";
					}
				}else{
					if(!empty($_GET['s_county']) || isset($_GET['s_county'])){
						$query.="  AND hangye='{$cate_id}'   AND s_county like '%$s_county%' "; //定义sql
					}else{
						$query.="  AND hangye='{$cate_id}'   ";
					}
				}
				
			}
			
			//
			$jobs=searchjobs('0,50',$query);
			foreach($jobs as $key=>$row){
				$jobtype_id=$row['jobtype'];
				//获取工种
				$query="select jobtype_name from ecm_jobtype WHERE jobtype_id={$jobtype_id} ";
				$result=mysql_query($query); //发送sql查询
				if($result != false){
					$rows=@mysql_fetch_assoc($result);
						$jobs[$key]['jobtype_name']=$rows['jobtype_name'];
				}else{
					echo "查询出错：".$query;die;
				}
			}
			
			
			$dq=provinceyu2();
			$dqlimit=no_dqlimit_url();
			$xinzilimit=no_xinzilimit_url();
			// echo $dqlimit.'<br/>';
			// echo $xinzilimit.'<br/>';
			$this->assign('dqlimit',$dqlimit);
			$this->assign('xinzilimit',$xinzilimit);
			$this->assign('dq',$dq);
			$this->assign('jobs', $jobs);
			$this->display('zhaopinsearch2.html');
		
	}
	//找/招jobs详细内容
	function jobsdetail(){
		$id=$_GET['id'];
		$condition=" AND id={$id} ";
		$jobs=searchjobs('0,50',$condition);
		$job=$jobs[0];
		switch($job['deal'])
		{
			case 0:
			  $job['dealname']="招工";
			  break;  
			case 2:
			  $job['dealname']="招标";
			  break;
			default:
			  $job['dealname']="招工";
		}
		//获取工种名称
		$jobtype_id=$job['jobtype'];
		$sqls="select jobtype_name from ecm_jobtype WHERE jobtype_id={$jobtype_id}";
		$res=mysql_query($sqls);
		$row  =  mysql_fetch_assoc($res);
		$job['jobtypename']=$row['jobtype_name'];
		mysql_free_result($res);

		
		
		$this->assign('job',$job);
		$this->display('search.jobdetail.html');
	}
	//采购详细
	function content_caigou(){
		header("Content-Type: text/html; charset=utf-8");
		$timezone="Asia/Shanghai";
		date_default_timezone_set($timezone); //北京时间
		
		
		$id = $_GET['id'];
		$cai_type = $_GET['cai_type'];
		
		/*if($_POST){
			$userid = $_SESSION['user_info']['user_id'];
			$user_name = $_SESSION['user_info']['user_name'];
			$content = $_POST['content'];
			$id = $_POST['pid'];
			
			$sql = "INSERT INTO `ecm_zhaobiao_pinlun` (`pid`, `uid`, `uname`, `content`, `addtime`) VALUES ('" . $id . "', '" . $userid . "',  '" . $user_name . "',  '" . $content . "',  '" . date('Y-m-d H:i:s',time()) . "');";
			if(mysql_query($sql)){
				header('Location:'.$_SERVER['HTTP_REFERER']);exit;
			}else{
				
				echo "<script>alert('操作失败'); history.go(-1); </script>";
			}
			
			exit;
			
		}	|*/
		
		$query="select * from ecm_caigou where status=0 and id='$id'"; //定义sql
		
		
		
		
		$result=mysql_query($query); //发送sql查询
		
		$rows=@mysql_fetch_array($result);
		
		
		$this->assign('id', $id);
		$this->assign('cai_type', $cai_type);
		$this->display('search.content_caigou.html');
	
	}
	//材料城列表
	function cailiaocheng(){
		$this->display('search.cailiaocheng.html');
	}
	
	
	
	//发送邮件
	function email(){
		
		
		
		$arr = explode(",",$_POST['email']);
		
			$i=1;
			foreach($arr as $k){
				SendMail($k,$_POST['title'],$_POST['content']);
				echo '正在发送第'.$i.'条邮件！';
				$i++;
			}
			
			
			
			header('Location:'.$_SERVER['HTTP_REFERER']);
			exit;
			
		
		
	}
	//城市切换
	//材料城列表
	function city(){
		$this->display('search.city.html');
	}
	
	function dianpu_content(){
	
		$id = $_GET['id'];
		
		$store_query="SELECT *FROM `ecm_store_user` where uid='$id'"; 
		$store_result = @mysql_fetch_array(mysql_query($store_query));
		
		$user="SELECT *FROM `ecm_member` where user_id='$id'"; 
		$user_result = @mysql_fetch_array(mysql_query($user));
		
		//var_dump($user_result);
		$this->assign('user', $user_result);
		$this->assign('store', $store_result);
		$this->display('search.dianpu_content.html');
	}
	
	//采购主题页
	function caigou(){
	
		$thisTime = date('Y-m-d H:i:s',time());
		$key = trim($_POST['key']);
		//一
		if($_POST){
			$query="select * from ecm_caigou where (status=0 and andtime >='$thisTime') and title like '%$key%' order by id desc limit 0,20"; //定义sql
			$result=mysql_query($query); 		

			if(@mysql_num_rows($result) >= 1){
				while($rows=@mysql_fetch_array($result)){
					$con .='<li><img src="/themes/mall/jiaju/images/zhaobiao/bglist.png"style="display: inline;float:left;margin: 5px;height:15px;width:15px;"/><p class="tle"><a href="index.php?app=search&act=content_caigou&id='.$rows['id'].'">'.$rows['title'].'</a></p><p class="time">'.date('Y-m-d H:i:s',strtotime($rows['addtime'])).'</p></li>';
				}
				
			}else{
				$con .= '<div style="height:300px;line-height:200px;text-align:center;font-size:12px;color:#ccc">暂无数据</div>';
			}
		}else{
			$query="select * from ecm_caigou where status=0 and andtime >='$thisTime' and xingzhi='工程采购' order by id desc limit 0,20"; //定义sql
			$result=mysql_query($query); 		

			if(@mysql_num_rows($result) >= 1){
				while($rows=@mysql_fetch_array($result)){
					$con .='<li>';
					$con .='<img src="/themes/mall/jiaju/images/zhaobiao/bglist.png"style="display: inline;float:left;margin: 5px;height:15px;width:15px;"/>';
					$con .='<p class="tle">';
					$con .='<a href="index.php?app=search&act=content_caigou&id='.$rows['id'].'">'.$rows['title'].'</a>';
					
					$con .='</p>';
					$con .='<span class="gname">'.$rows['gname'].'</span>';
					$con .='<p class="time">'.date('Y-m-d H:i:s',strtotime($rows['addtime'])).'</p>';
					$con .='</li>';
				}
				
			}else{
				$con .= '<div style="height:300px;line-height:200px;text-align:center;font-size:12px;color:#ccc">暂无数据</div>';
			}
		}
		
		
		
		$this->assign('con', $con);
		$this->assign('key', $key);
		$this->display('search.caigou.html');
	}
	
	function caigou_list(){
		
		
		if($_POST){
		
			$cate_id = $_POST['cate_id'];
			$key = $_POST['title'];
			$gname = $_POST['gname'];
			$s_county = $_POST['s_county'];
			$addtime = $_POST['addtime'];
			$andtime = $_POST['andtime'];
			
			$this->assign('key', $key);
			$this->assign('gname', $gname);
			$this->assign('s_county', $s_county);
			$this->assign('addtime', $addtime);
			$this->assign('andtime', $andtime);
			
			if($s_county == ''){	
				$query="select * from ecm_caigou where status=0 and andtime >='$thisTime' and gname like '%$gname%' and title like '%$key%' order by id desc"; //定义sql
			}else{
				$query="select * from ecm_caigou where status=0 and andtime >='$thisTime' and s_county ='$s_county' and gname like '%$gname%' and title like '%$key%' order by id desc"; //定义sql
			}
				
			
			
			
		}else{
			
			$thisTime = date('Y-m-d H:i:s',time());
			$cate = $_GET['cate'];
			
			if(empty($cate)){
				$query="select * from ecm_caigou where status=0 and andtime >='$thisTime' order by id desc"; //定义sql
			}else{
				$query="select * from ecm_caigou where status=0 and andtime >='$thisTime' and hangye='$cate' order by id desc"; //定义sql
			}
		}
		
		
		
		$result=mysql_query($query); //发送sql查询
		
		if(@mysql_num_rows($result) >= 1){
			while($rows=@mysql_fetch_array($result)){
				$con .='<li>';
				$con .='	<div class="ico"><i><img src="/themes/mall/jiaju/styles/css/ico_03.png"></i></div>';
				$con .='	<div class="bodys-content">';
				$con .='		<p class="list-titles"><a href="index.php?app=search&act=content_caigou&id='.$rows['id'].'">'.$rows['title'].'</a></p>';
				$con .='		<p class="list-ptype"><span>'.$rows['gname']."/".$rows['lianxiren']."/".$rows['dianhua'].'</span></p>';
				$con .='		<p class="list-pmess">';
				$con .='		   <span class="pstitle">发布时间：</span>';
				$con .='		   <span class="pscontent">'.$rows['addtime'].'</span>';
				$con .='			&nbsp;&nbsp;';
				$con .='			<span class="pstitle">过期时间：</span>';
				$con .='			<span class="pscontent">'.$rows['andtime'].'</span>';
				$con .='	   </p>';
				$con .='	</div>';	
				$con .='	<div class="chakan"><a href="index.php?app=search&act=content_caigou&id='.$rows['id'].'">查看</a></div>';	
				$con .='</li>';
			}
			
		}else{
			$con .= '<div style="height:300px;line-height:200px;text-align:center;font-size:12px;color:#ccc">暂无数据</div>';
		}
		
		
		
		$this->assign('con', $con);
		
		$this->display('search.caigou_list.html');
	
	}
	//套餐详细
	function taocan(){
		
		$user_id = $_SESSION['user_info']['user_id'];
		
		
		//获取装修公司身份
		$zsquery="select types from ecm_member where user_id='$user_id'"; //定义sql
		
		$zsresult=mysql_query($zsquery); //发送sql查询
				
		$zsrows=@mysql_fetch_array($zsresult);
				
		
		
		
		$id = $_GET['id'];
			if($id){
				
				$query="select * from ecm_taocan where id='$id'"; //定义sql
		
				$result=mysql_query($query); //发送sql查询
				
				$rows=@mysql_fetch_array($result);
				
				
				$this->assign('jianjie', html_entity_decode($rows['jianjie']));
				$this->assign('liangdian', html_entity_decode($rows['liangdian']));
				$this->assign('shuoming', html_entity_decode($rows['shuoming']));
				$this->assign('gnqu', html_entity_decode($rows['gnqu']));
				$this->assign('fengge', html_entity_decode($rows['fengge']));
				$this->assign('tid', $rows['id']);
				$this->assign('user', $rows);
				$this->assign('types', $zsrows['types']);
				
			}
		
		$this->display('search.taocan.html');
	
	}
	
	function taocan_mes()
    {
		header("Content-type:text/html;charset=utf-8");
		
		if($_POST){
			$id 	= $_POST['id'];
			$name 	= htmlspecialchars($_POST['name']);
			$tel 	= htmlspecialchars($_POST['tel']);
			$dis 	= htmlspecialchars($_POST['dis']);
			$txt 	= htmlspecialchars($_POST['txt']);
			
			$time 	= date('Y-m-d H:i:s',time());
			
			
				$sql = "INSERT INTO ecm_taocan_mes(tid,name, tel, dis, txt,addtime)VALUES('$id', '$name','$tel', '$dis','$txt','$time')";
				

				if(!mysql_query($sql)){
					die("提交数据失败：".mysql_error());
				} else {
					header('Location:http://www.59jiaju.com/index.php?app=search&act=taocan&id='.$id);exit;
				}
			
			
			
			
		}
        
		
		
    }
	
	
	//购买地址
	function weizhi(){
		
		
		
		
		
		$store = $_GET['store'];
		$goods_id = $_GET['gid'];
		
		$query="SELECT *FROM `ecm_goods` where goods_id='$goods_id' limit 1"; //定义sql
		
		
		
		
		$result=mysql_query($query); //发送sql查询
		
		$rows=@mysql_fetch_array($result);
		
		
		//选择的城市
		$city = $_GET['city'];
		
		//获取商品发布者信息
		$cate_name = $rows['cate_name'];
		$cate_id_1 = $rows['cate_id_1'];
		$cate_id_2 = $rows['cate_id_2'];
		$cate_id_3 = $rows['cate_id_3'];
		$cate_id_4 = $rows['cate_id_4'];
		$cate_id = $rows['cate_id'];
		
		$store_id = $rows['store_id'];
		
		if(empty($city)){
			
			$store_query="SELECT *FROM `ecm_store_user` where (cate_id in($cate_id) or cate_id in($cate_id_1) or cate_id in($cate_id_2) or cate_id in($cate_id_3) or cate_id in($cate_id_4)) and status='0'"; //定义sql
		}else{
			$shi = mb_substr($city,-1,1,'utf-8');//
			if($shi == '市'){
				$store_query="SELECT *FROM `ecm_store_user` where (cate_id in($cate_id) or cate_id in($cate_id_1) or cate_id in($cate_id_2) or cate_id in($cate_id_3) or cate_id in($cate_id_4)) and status='0' and s_city='$city'"; //定义sql
			}else{
				$store_query="SELECT *FROM `ecm_store_user` where (cate_id in($cate_id) or cate_id in($cate_id_1) or cate_id in($cate_id_2) or cate_id in($cate_id_3) or cate_id in($cate_id_4)) and status='0' and s_county='$city'"; //定义sql
			}
			
		}
		
		
		
		$store_result=mysql_query($store_query); //发送sql查询
		
		$zimu = array(
		'0'=>'A',
		'1'=>'B',
		'2'=>'C',
		'3'=>'D',
		'4'=>'E',
		'5'=>'F',
		'6'=>'G',
		'7'=>'H',
		'8'=>'I',
		'9'=>'J',
		'10'=>'K',
		'11'=>'L',
		'12'=>'M',
		'13'=>'N',
		'14'=>'O',
		'15'=>'P',
		'16'=>'Q',
		'17'=>'R',
		'18'=>'S',
		'19'=>'T',
		'20'=>'U',
		'21'=>'V',
		'22'=>'W',
		'23'=>'X',
		'23'=>'Y',
		'23'=>'Z',
		);
		$i=1;
		while($store_rows=@mysql_fetch_array($store_result)){
			$store_rowss .="<li style='width: auto;list-style-type:upper-alpha'>";
			$store_rowss .="	<i>".$i."</i>";
			$store_rowss .="	<p style='width: auto;'>";
			$store_rowss .="	  <strong>{$store_rows['name']}</strong>";
			$store_rowss .="	  <span>地址：{$store_rows['s_province']}{$store_rows['s_city']}{$store_rows['s_county']}{$store_rows['xiangxi']}</span>";
			$store_rowss .="	  <span>电话：{$store_rows['tel']}</span>";
			$store_rowss .="	</p>";
			$store_rowss .="  </li>";
			$i++;
		}
		
					  
					
		
		
		$this->assign('store_rows', $store_rowss);
		
		$this->display('search.weizhi.html');
	
	}
	//群发短信
	function duanxin(){
		
		$mobile = trim($_POST['phone']);
		$content = trim($_POST['content']);
		$nb_user = trim($_POST['nb_user']);
		
		if($nb_user == 1){
		
			$content="【59家居网】{$content}";  //发送内容3s
			$time='';     //发送时间，为空时是即时发送
			$res = send($mobile,$content);
		
			echo"<script>alert('短信发送成功');history.go(-1);</script>"; 
			exit;
			
		}
	}
	//装修公司列表
	function zx(){
		
	
		if($_GET['up'] == 'add'){
			$password 	= 'e10adc3949ba59abbe56e057f20f883e';
			
				//SELECT * FROM `ecm_store_user` WHERE `s_city`='广州市' and `uid`=0
				
			$member_query=mysql_query("SELECT uid,mobe FROM `ecm_store_user` where uid='0' limit 100"); //定义sql
			//echo "<pre>";
			while($a = @mysql_fetch_array($member_query)){
		
				$time 	= date('Y-m-d H:i:s',time());
				//添加用户
				
				$user_name = $a['mobe'];
				mysql_query("INSERT INTO ecm_member(user_name,password, real_name, reg_time, types,nb_user)VALUES('$user_name', '$password','$user_name','$time', '6','0')");
				
				
				//修改用户
				$member_queryaa=mysql_query("SELECT user_id FROM `ecm_member` order by user_id DESC limit 0,1"); //获取最后一个用户ID
				$bb = @mysql_fetch_array($member_queryaa);
				
				$userid = $bb["user_id"];
				mysql_query("UPDATE `ecm_store_user` SET  `uid`='$userid' WHERE mobe='$user_name'");
				
				
			}
			
			//header('Location:index.php?app=search&act=zx&types='.$_GET['types']);
		}
		
		
		$user_id = $_SESSION['user_info']['user_id'];
		$member_this=mysql_query("SELECT nb_user FROM `ecm_member` where user_id='$user_id' order by user_id DESC"); //获取最后一个用户ID
		$member = @mysql_fetch_array($member_this);
		
		
		
		//保存县区
		$_SESSION['city_qu'] = $_GET['qu'];
		//选择的城市
		$city = $_SESSION['city'];
		$id = intval($_GET['id']);
		$city_qu = $_SESSION['city_qu'];
		$member_styles = $_GET['types'];
		
		//获取商品发布者信息
		
		//if($id > 1){
		
			//$member_query = mysql_query("SELECT user_id FROM `ecm_member` where user_id='$id' and types='$member_styles' limit 0,26"); //定义sql
			
		//}else{
		
			///$member_query = "SELECT user_id FROM `ecm_member` where types='$member_styles' limit 0,26"; //定义sql
			
		//}
		
		//分页
		$Page_size=26;
		
		
		if(empty($city_qu)){
					
			$result = mysql_query("SELECT t1.email,t1.uid,t1.name,t1.s_province,t1.s_city,t1.s_county,t1.xiangxi,t1.tel,t1.mobe FROM ecm_store_user AS t1 , ecm_member AS t2 WHERE t1.uid = t2.user_id and t2.types='$member_styles' and status='0' and t1.s_city='$city' and t1.status='0' group by t1.name ");
			
		}else{
			
			$result = mysql_query("SELECT t1.email,t1.uid,t1.name,t1.s_province,t1.s_city,t1.s_county,t1.xiangxi,t1.tel,t1.mobe FROM ecm_store_user AS t1 , ecm_member AS t2 WHERE t1.uid = t2.user_id and t2.types='$member_styles' and status='0' and t1.s_city='$city' and t1.s_county='$city_qu' and t1.status='0' group by t1.name ");
			
		}
		
		
		$count = @mysql_num_rows($result); 
		
		
		$page_count = ceil($count/$Page_size); 
		
		$init=1; 
		$page_len=7; 
		$max_p=$page_count; 
		$pages=$page_count; 
		
		//判断当前页码 
		if(empty($_GET['page'])||$_GET['page']<0){ 
			$page=1; 
		}else { 
			$page=$_GET['page']; 
		}
		
		$offset=$Page_size*($page-1); 
		
		
		$zimu = array(
			'0'=>'A',
			'1'=>'B',
			'2'=>'C',
			'3'=>'D',
			'4'=>'E',
			'5'=>'F',
			'6'=>'G',
			'7'=>'H',
			'8'=>'I',
			'9'=>'J',
			'10'=>'K',
			'11'=>'L',
			'12'=>'M',
			'13'=>'N',
			'14'=>'O',
			'15'=>'P',
			'16'=>'Q',
			'17'=>'R',
			'18'=>'S',
			'19'=>'T',
			'20'=>'U',
			'21'=>'V',
			'22'=>'W',
			'23'=>'X',
			'24'=>'Y',
			'25'=>'Z',
			);
			$i=0;
			$num = 0;	
			$s_county = '';
			$em = '';
		//获取是否有数据
		//if(@mysql_num_rows($member_query) < 1){
		//	$store_rowss ="<div style='width:100%;text-align:center;color:#ccc;font-size:16px;line-height:100px;'>抱歉，暂无相关数据！</div>";
		//}else{
		
			//while($member_rows=@mysql_fetch_array($member_query)){
				
		

				if(empty($city_qu)){
					
					//$store_query="SELECT a.email,a.uid,a.name,a.s_province,a.s_city,a.s_county,a.xiangxi,a.tel FROM ecm_store_user as a where uid='SELECT user_id FORM ecm_member where types=$member_styles' and s_city='$city' and status='0' limit 0,26"; //定义sql
					
					$store_query = "SELECT t1.id,t1.email,t1.uid,t1.name,t1.s_province,t1.s_city,t1.s_county,t1.xiangxi,t1.tel,t1.mobe FROM ecm_store_user AS t1 , ecm_member AS t2 WHERE t1.uid = t2.user_id and t2.types='$member_styles' and status='0' and t1.name<>'' and t1.s_city='$city' and t1.status='0'  group by t1.name order by id desc limit $offset,$Page_size";
					
				}else{
					
					//$store_query="SELECT email,uid,name,s_province,s_city,s_county,xiangxi,tel FROM `ecm_store_user` where uid='$user_id' and s_city='$city' and s_county='$city_qu' and status='0' limit 0,26"; //定义sql
					
					$store_query = "SELECT t1.id,t1.email,t1.uid,t1.name,t1.s_province,t1.s_city,t1.s_county,t1.xiangxi,t1.tel,t1.mobe FROM ecm_store_user AS t1 , ecm_member AS t2 WHERE t1.uid = t2.user_id and t2.types='$member_styles' and status='0' and t1.name<>'' and t1.s_city='$city' and t1.s_county='$city_qu' and t1.status='0' group by t1.name order by id desc limit $offset,$Page_size";
					
				}
				
				
				$store_result=mysql_query($store_query); //发送sql查询
				
			if(@mysql_num_rows($store_result) < 1){
			
				$store_rowss ="<div style='width:100%;text-align:center;color:#ccc;font-size:16px;line-height:100px;'>抱歉，暂无相关数据！</div>";
				
			}else{
			
				while($store_rows=@mysql_fetch_array($store_result)){
				
					$store_rowss .="<li id='cailiao'style='width: auto;list-style-type:upper-alpha;'>";
					$store_rowss .="	<i>".$zimu[$i]."</i>";
					$store_rowss .="	<p style='width: auto;'>";
					//$store_rowss .="	  <strong><a href='index.php?app=search&act=dianpu_content&id=".$store_rows['uid']."'>{$store_rows['name']}</a></strong>";
					$store_rowss .="	  <strong><a target='_blank' href='index.php?app=search&act=dianpu_content&id=".$store_rows['uid']."' style='font-size:14px;'>{$store_rows['name']}</a></strong>";
					$store_rowss .="	  <span style='font-size:12px;display:block;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap;width:100%;'>地址：{$store_rows['s_province']}{$store_rows['s_city']}{$store_rows['s_county']}{$store_rows['xiangxi']}</span>";
					if(empty($store_rows['tel'])){
						$store_rowss .="	  <span style='font-size:12px;'>电话：{$store_rows['mobe']}</span>";
					}else{
						$store_rowss .="	  <span style='font-size:12px;'>电话：{$store_rows['tel']}</span>";
					}
					
					$store_rowss .="	</p>";
					$store_rowss .="  </li>";
					$store_rowss .="  <input type='hidden'id='sql_email' class='sql_email' name='sql_email' value='".$store_rows['email']."'/>";
					$s_county[$i] = $store_rows['s_county'].$store_rows['xiangxi'];
					$i++;
					$num++;
					
					$em = $store_rows['email'].',';
					
					
					if(preg_match_all("/^1[34578]\d{9}$/", $store_rows['mobe'], $tel)){
						$mobe .= $store_rows['tel'].',';
					}
					
				}
				
				
				$page_len = ($page_len%2)?$page_len:$pagelen+1;//页码个数 
				$pageoffset = ($page_len-1)/2;//页码个数左右偏移量 
				
				$key='<div class="page">'; 
				$key.="<span>$page/$pages</span> "; //第几页,共几页 
				if($page!=1){ 
					
					$key.="<a href='index.php?app=search&act=zx&types=$member_styles&page=1'>第一页</a>";
					$key.="<a href='index.php?app=search&act=zx&types=$member_styles&page=".($page-1)."'>上一页</a>";
				}else { 
					$key.="第一页 ";//第一页 
					$key.="上一页"; //上一页 
				} 
				
				
				if($pages>$page_len){ 
					//如果当前页小于等于左偏移 
					if($page<=$pageoffset){ 
						$init=1; 
						$max_p = $page_len; 
					}else{//如果当前页大于左偏移 
						//如果当前页码右偏移超出最大分页数 
						if($page+$pageoffset>=$pages+1){ 
							$init = $pages-$page_len+1; 
						}else{ 
							//左右偏移都存在时的计算 
							$init = $page-$pageoffset; 
							$max_p = $page+$pageoffset; 
						} 
					} 
				} 
				
				for($i=$init;$i<=$max_p;$i++){ 
					if($i==$page){ 
						$key.=' <span>'.$i.'</span>'; 
					} else { 
						$key.="<a href='index.php?app=search&act=zx&types=$member_styles&page=".$i."'>".$i."</a>";
					} 
				} 
			
				if($page!=$pages){ 
					
					$key.="<a href='index.php?app=search&act=zx&types=$member_styles&page=".($page+1)."'>下一页</a>";
					$key.="<a href='index.php?app=search&act=zx&types=$member_styles&page=$pages'>最后一页</a>"; //最后一页 
				}else { 
					$key.="下一页 ";//下一页 
					$key.="最后一页"; //最后一页 
				} 
				
				$key.='</div>'; 
				
						  
			}			
		//}
		
		 
	
		$this->assign('mobe', substr($mobe,0,strlen($mobe)-1));
		$this->assign('pege', $key);
		$this->assign('store_rows', $store_rowss);
		
		$this->assign('nb_user', $member['nb_user']);
		
		
		/*if($member_styles == 2 ){
		
			$this->assign('s_county', json_encode($s_county));
			$this->assign('num', $num);
			$this->display('search.zx_map.html');
			
		
		}else{
		
			$this->display('search.zx.html');
			
		}*/
		
		$this->display('search.zx.html');
	}
	
	function zx_help(){
	
		$this->display('search.zx_help.html');
	
	}
	
	/* 最新材料推荐 */
    function hot_index()
    {  
		// ecodemall 过滤非法参数
		if(!$this->_check_query_param_by_orders()){
			header('Location:index.php');exit;
		}
        // 查询参数
        $param = $this->_get_query_param();
        if (empty($param))
        {
            header('Location: index.php?app=category');
            exit;
        }
        if (isset($param['cate_id']) && $param['layer'] === false)
        {
            $this->show_warning('no_such_category');
            return;
        }

        /* 筛选条件 */
        $this->assign('filters', $this->_get_filter($param));

        /* 按分类、品牌、地区、价格区间统计商品数量 */
        $stats = $this->_get_group_by_info($param, ENABLE_SEARCH_CACHE);

        $this->assign('categories', $stats['by_category']);
        $this->assign('category_count', count($stats['by_category']));

        $this->assign('brands', $stats['by_brand']);
        $this->assign('brand_count', count($stats['by_brand']));

        $this->assign('price_intervals', $stats['by_price']);

        $this->assign('regions', $stats['by_region']);
        $this->assign('region_count', count($stats['by_region']));
	
        /* 排序 */
        $orders = $this->_get_orders();
        $this->assign('orders', $orders);

        /* 分页信息 */
        $page = $this->_get_page(NUM_PER_PAGE);
        $page['item_count'] = $stats['total_count'];
        $this->_format_page($page);
        $this->assign('page_info', $page);

        /* 商品列表 */
        $sgrade_mod =& m('sgrade');
        $sgrades    = $sgrade_mod->get_options();
        $conditions = $this->_get_goods_conditions($param);
        $goods_mod  =& m('goods');
			
        $goods_list = $goods_mod->get_list(array(
            'conditions' => $conditions,
            'order'      => isset($_GET['order']) && isset($orders[trim(str_replace('asc','',str_replace('desc','',$_GET['order'])))]) ? $_GET['order'] : 'add_time desc',
            'limit'      => $page['limit'],
        ));
        foreach ($goods_list as $key => $goods)
        {
            $step = intval(Conf::get('upgrade_required'));
            $step < 1 && $step = 5;
            $store_mod =& m('store');
            $goods_list[$key]['credit_image'] = $this->_view->res_base . '/images/' . $store_mod->compute_credit($goods['credit_value'], $step);
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
            $goods_list[$key]['grade_name'] = $sgrades[$goods['sgrade']];
        }
        $this->assign('goods_list', $goods_list);

        /* 商品展示方式 */
        $display_mode = ecm_getcookie('goodsDisplayMode');
        if (empty($display_mode) || !in_array($display_mode, array('list', 'squares')))
        {
            $display_mode = 'squares'; // 默认格子方式
        }
        $this->assign('display_mode', $display_mode);

        /* 取得导航 */
        $this->assign('navs', $this->_get_navs());

        /* 当前位置 */
        $cate_id = isset($param['cate_id']) ? $param['cate_id'] : 0;
        $this->_curlocal($this->_get_goods_curlocal($cate_id));
        
        /* 配置seo信息 */
        $this->_config_seo($this->_get_seo_info('goods', $cate_id));
		
		// ecodemall
		import('init.lib');
		$init = new Init_SearchApp();
		$this->assign('allcategories',$init->get_all_category_tree(0));
		$this->assign("recommend_goods", $this->_get_list_goods($param["cate_id"])); 
		$this->assign('rank_goods', $this->_get_list_goods($param['cate_id'],'rank'));
		// end
		//var_dump($this->_get_list_goods($param["cate_id"]));
        $this->display('search.hot_index.html');
    }
    /* 搜索商品 */
    function index()
    {  
		// ecodemall 过滤非法参数
		if(!$this->_check_query_param_by_orders()){
			header('Location:index.php');exit;
		}
        // 查询参数
        $param = $this->_get_query_param();
        if (empty($param))
        {
            header('Location: index.php?app=category');
            exit;
        }
        if (isset($param['cate_id']) && $param['layer'] === false)
        {
            $this->show_warning('no_such_category');
            return;
        }

        /* 筛选条件 */
        $this->assign('filters', $this->_get_filter($param));

        /* 按分类、品牌、地区、价格区间统计商品数量 */
        $stats = $this->_get_group_by_info($param, ENABLE_SEARCH_CACHE);

        $this->assign('categories', $stats['by_category']);
        $this->assign('category_count', count($stats['by_category']));

        $this->assign('brands', $stats['by_brand']);
        $this->assign('brand_count', count($stats['by_brand']));

        $this->assign('price_intervals', $stats['by_price']);

        $this->assign('regions', $stats['by_region']);
        $this->assign('region_count', count($stats['by_region']));
	
        /* 排序 */
        $orders = $this->_get_orders();
        $this->assign('orders', $orders);

        /* 分页信息 */
        $page = $this->_get_page(NUM_PER_PAGE);
        $page['item_count'] = $stats['total_count'];
        $this->_format_page($page);
        $this->assign('page_info', $page);

        /* 商品列表 */
        $sgrade_mod = m('sgrade');
        $sgrades    = $sgrade_mod->get_options();
        $conditions = $this->_get_goods_conditions($param);
        $goods_mod  = m('goods');
			
        $goods_list = $goods_mod->get_list(array(
            'conditions' => $conditions,
            'order'      => isset($_GET['order']) && isset($orders[trim(str_replace('asc','',str_replace('desc','',$_GET['order'])))]) ? $_GET['order'] : 'add_time desc',
            'limit'      => $page['limit'],
        ));
        foreach ($goods_list as $key => $goods)
        {
            $step = intval(Conf::get('upgrade_required'));
            $step < 1 && $step = 5;
            $store_mod =& m('store');
            $goods_list[$key]['credit_image'] = $this->_view->res_base . '/images/' . $store_mod->compute_credit($goods['credit_value'], $step);
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
            $goods_list[$key]['grade_name'] = $sgrades[$goods['sgrade']];
        }
        $this->assign('goods_list', $goods_list);

        /* 商品展示方式 */
        $display_mode = ecm_getcookie('goodsDisplayMode');
        if (empty($display_mode) || !in_array($display_mode, array('list', 'squares')))
        {
            $display_mode = 'squares'; // 默认格子方式
        }
        $this->assign('display_mode', $display_mode);

        /* 取得导航 */
        $this->assign('navs', $this->_get_navs());

        /* 当前位置 */
        $cate_id = isset($param['cate_id']) ? $param['cate_id'] : 0;
        $this->_curlocal($this->_get_goods_curlocal($cate_id));
        
        /* 配置seo信息 */
        $this->_config_seo($this->_get_seo_info('goods', $cate_id));
		
		// ecodemall
		
		import('init.lib');
		$init = new Init_SearchApp();
		$this->assign('allcategories',$init->get_all_category_tree(0));
		$this->assign("recommend_goods", $this->_get_list_goods($param["cate_id"])); 
		$this->assign('rank_goods', $this->_get_list_goods($param['cate_id'],'rank'));
		// end
		//var_dump($this->_get_list_goods($param["cate_id"]));
        $this->display('search.goods.wind.html');
    }
	
	/* 列表页排行，推荐商品 jiaju ecodemall */
	function _get_list_goods($cate_id,$type='recommend')
	{
		$goods_mod  =& m('goods');
		if($cate_id>0){
			$gcategory_mod =& bm('gcategory');
            $cate_ids = implode(",",$gcategory_mod->get_descendant_ids($cate_id));
			$conditions = " AND cate_id IN (".$cate_ids.")";
		} else {
			$conditions = "";
		}
		if($type=='rank'){
			$order = 'sales desc,goods_id desc';
			$recommended = ' 1=1 ';
			$limit = 10;
		} else {
			$order = 'recommended desc,goods_id desc';
			$recommended = ' recommended=1 ';
			$limit = 4;
		}
		
		$data = $goods_mod->find(array(
		   "conditions" => "if_show=1 AND closed=0 AND " . $recommended . $conditions,
		   "order"      => $order,
		   "join"       => "has_goodsstatistics",
		   "fields"     => "g.goods_id,default_image,price,goods_name,sales",
		   "limit"      => $limit
		));
		return $data;
	}

    /* 搜索店铺 */
    function store()
    {
        /* 取得导航 */
        $this->assign('navs', $this->_get_navs());

        /* 取得该分类及子分类cate_id */
        $cate_id = empty($_GET['cate_id']) ? 0 : intval($_GET['cate_id']);
        $cate_ids=array();
        $condition_id='';
        if ($cate_id > 0)
        {
            $scategory_mod =& m('scategory');
            $cate_ids = $scategory_mod->get_descendant($cate_id);
        }

        /* 取得cate_id */
        $cat=$_GET['cate_id'];
        $this->assign('cat',$cat);

        /* 取得region_name */
        $field_region_name=$_GET['region_name'];
        $this->assign('field_region_name', $field_region_name);

        /* 取得region_id */
        $rid=$_GET['rid'];
        if (intval($rid)) {
            $this->assign('rid',$rid);
            $db=&db();
            $field=$db->getall('select * from `zt55o1_db`.`ecm_region` where `parent_id`="'.$rid.'"');
            $this->assign('field',$field);
        }

        $fid=$_GET['region_id'];
        $this->assign('fid',$fid);

        /* 店铺分类检索条件 */
        $condition_id=implode(',',$cate_ids);
        $condition_id && $condition_id = ' AND cate_id IN(' . $condition_id . ')';

        /* 其他检索条件 */
        $conditions = $this->_get_query_conditions(array(
            array( //店铺名称
                'field' => 'store_name',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'keyword',
                'type'  => 'string',
            ),
            array( //地区名称
                'field' => 'region_name',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'region_name',
                'type'  => 'string',
            ),
            array( //地区id
                'field' => 'region_id',
                'equal' => '=',
                'assoc' => 'AND',
                'name'  => 'region_id',
                'type'  => 'string',
            ),
            array( //商家用户名
                'field' => 'user_name',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'user_name',
                'type'  => 'string',
            ),
        ));
		
		// jiaju ecodemall  safe care
		$orders = array(
		    'sales desc',
			'sales asc',
			'price desc',
			'price asc',
			'add_time desc',
		    'add_time asc',
			'comments desc',
			'comments asc',
		    'credit_value desc',
		    'credit_value asc',
		  	'views desc',
		   	'views asc',
		);
		
        $model_store =& m('store');
        $regions = $model_store->list_regions();
        $page   =   $this->_get_page(9);   //获取分页信息
        $stores = $model_store->find(array(
            'conditions'  => 'state = ' . STORE_OPEN . $condition_id . $conditions,
            'limit'   =>$page['limit'],
            'order'   => empty($_GET['order']) || !in_array($_GET['order'], $orders) ? 'sort_order' : $_GET['order'], // jiaju ecodemall $orders
            'join'    => 'belongs_to_user,has_scategory',

            'count'   => true   //允许统计
        ));

        $model_goods = &m('goods');

        foreach ($stores as $key => $store)
        {
            //店铺logo
            empty($store['store_logo']) && $stores[$key]['store_logo'] = Conf::get('default_store_logo');

            //商品数量
            $stores[$key]['goods_count'] = $model_goods->get_count_of_store($store['store_id']);

            //等级图片
            $step = intval(Conf::get('upgrade_required'));
            $step < 1 && $step = 5;
            $stores[$key]['credit_image'] = $this->_view->res_base . '/images/' . $model_store->compute_credit($store['credit_value'], $step);

        }
        $page['item_count']=$model_store->getCount();   //获取统计数据
        $this->_format_page($page);

        /* 当前位置 */
        $this->_curlocal($this->_get_store_curlocal($cate_id));
        $scategorys = $this->_list_scategory();
        $this->assign('stores', $stores);
        $this->assign('regions', $regions);
        $this->assign('cate_id', $cate_id);
        $this->assign('scategorys', $scategorys);
        $this->assign('page_info', $page);
        /* 配置seo信息 */
        $this->_config_seo($this->_get_seo_info('store', $cate_id));
        $this->display('search.store.html');
    }
	 // ecodemall 过滤非法参数
	function _check_query_param_by_orders()
	{
		$order = $_GET['order'];
		if(empty($order)){
			return true;
		}
		$orders = array(
		   'sales desc',
			'sales asc',
			'price desc',
			'price asc',
			'add_time desc',
		    'add_time asc',
			'comments desc',
			'comments asc',
		    'credit_value desc',
		    'credit_value asc',
		  	'views desc',
		   	'views asc',  
		);
		
		if(in_array($order, $orders)){
			return true;
		} else {
			return false;
		}	
	}

    function groupbuy()
    {
        empty($_GET['state']) &&  $_GET['state'] = 'on';
        $conditions = '1=1';

		// jiaju ecodemall  safe care
		$orders = array(
		   'views desc',
		   'views asc',
		);
		

        if ($_GET['state'] == 'on')
        {
            //$orders['end_time asc'] = Lang::get('lefttime');
			$orders[] = 'end_time desc';// jiaju ecodemall 
			$orders[] = 'end_time asc'; // jiaju ecodemall 
            $conditions .= ' AND gb.state ='. GROUP_ON .' AND gb.end_time>' . gmtime();
        }
        elseif ($_GET['state'] == 'end')
        {
            $conditions .= ' AND (gb.state=' . GROUP_ON . ' OR gb.state=' . GROUP_END . ') AND gb.end_time<=' . gmtime();
        }
        else
        {
            $conditions .= $this->_get_query_conditions(array(
                array(      //按团购状态搜索
                    'field' => 'gb.state',
                    'name'  => 'state',
                    'handler' => 'groupbuy_state_translator',
                )
            ));
        }
        $conditions .= $this->_get_query_conditions(array(
            array( //活动名称
                'field' => 'group_name',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'keyword',
                'type'  => 'string',
            ),
        ));
        $page = $this->_get_page(NUM_PER_PAGE);   //获取分页信息
        $groupbuy_mod = &m('groupbuy');
        $groupbuy_list = $groupbuy_mod->find(array(
            'conditions'    => $conditions,
            'fields'        => 'gb.group_name,gb.spec_price,gb.min_quantity,gb.store_id,gb.state,gb.end_time,g.default_image,default_spec,s.store_name',
            'join'          => 'belong_store, belong_goods',
            'limit'         => $page['limit'],
            'count'         => true,   //允许统计
            'order'         => isset($_GET['order']) && in_array($_GET['order'], $orders) ? $_GET['order'] : 'group_id desc',// jiaju ecodemall
        ));
        if ($ids = array_keys($groupbuy_list))
        {
            $quantity = $groupbuy_mod->get_join_quantity($ids);
        }
        foreach ($groupbuy_list as $key => $groupbuy)
        {
            $groupbuy_list[$key]['quantity'] = empty($quantity[$key]['quantity']) ? 0 : $quantity[$key]['quantity'];
            $groupbuy['default_image'] || $groupbuy_list[$key]['default_image'] = Conf::get('default_goods_image');
            $groupbuy['spec_price'] = unserialize($groupbuy['spec_price']);
            $groupbuy_list[$key]['group_price'] = $groupbuy['spec_price'][$groupbuy['default_spec']]['price'];
            $groupbuy['state'] == GROUP_ON && $groupbuy_list[$key]['lefttime'] = lefttime($groupbuy['end_time']);
        }
        $this->assign('state', array(
             'on' => Lang::get('group_on'),
             'end' => Lang::get('group_end'),
             'finished' => Lang::get('group_finished'),
             'canceled' => Lang::get('group_canceled'))
        );
        $this->assign('orders', $orders);
        // 当前位置
        $this->_curlocal(array(array('text' => Lang::get('groupbuy'))));
        $this->_config_seo('title', Lang::get('groupbuy') . ' - ' . Conf::get('site_title'));
        $page['item_count'] = $groupbuy_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->assign('nav_groupbuy', 1); // 标识当前页面是团购列表，用于设置导航状态
        $this->assign('page_info', $page);
        $this->assign('groupbuy_list',$groupbuy_list);
        $this->assign('recommended_groupbuy', $this->_recommended_groupbuy(2));
        $this->assign('last_join_groupbuy', $this->_last_join_groupbuy(2));
        $this->display('search.groupbuy.html');
    }

    // 推荐团购活动
    function _recommended_groupbuy($_num)
    {
        $model_groupbuy =& m('groupbuy');
        $data = $model_groupbuy->find(array(
            'join'          => 'belong_goods,belong_store', // ecodemall jiaju
            'conditions'    => 'gb.recommended=1 AND gb.state=' . GROUP_ON . ' AND gb.end_time>' . gmtime(),
            'fields'        => 'group_id, goods.default_image, group_name, gb.end_time, spec_price,gb.min_quantity,gb.store_id,s.store_name',// tyioocm jiaju
            'order'         => 'group_id DESC',
            'limit'         => $_num,
        ));
		
		// ecodemall jiaju
		if ($ids = array_keys($data))
        {
            $quantity = $model_groupbuy->get_join_quantity($ids);
		}
		// end 
		
        foreach ($data as $gb_id => $gb_info)
        {
			$data[$gb_id]['quantity'] = empty($quantity[$gb_id]['quantity']) ? 0 : $quantity[$gb_id]['quantity']; // jiaju ecodemall
            $price = current(unserialize($gb_info['spec_price']));
            empty($gb_info['default_image']) && $data[$gb_id]['default_image'] = Conf::get('default_goods_image');
            $data[$gb_id]['lefttime']   = lefttime($gb_info['end_time']);
            $data[$gb_id]['price']      = $price['price'];
        }
        return $data;
    }

    // 最新参加的团购
    function _last_join_groupbuy($_num)
    {
        $model_groupbuy =& m('groupbuy');
        $data = $model_groupbuy->find(array(
            'join' => 'be_join,belong_goods,belong_store',
            'fields' =>'gb.group_id,gb.group_name,gb.group_id,groupbuy_log.add_time,gb.spec_price,goods.default_image,gb.end_time,gb.min_quantity,gb.store_id,s.store_name',
			// tyioocm jiaju
            'conditions' => 'groupbuy_log.user_id > 0',
            'order' => 'groupbuy_log.add_time DESC',
            'limit' => $_num,
        ));
		// ecodemall jiaju
		if ($ids = array_keys($data))
        {
            $quantity = $model_groupbuy->get_join_quantity($ids);
		}
		// end 
		
        foreach ($data as $gb_id => $gb_info)
        {
			$data[$gb_id]['quantity'] = empty($quantity[$gb_id]['quantity']) ? 0 : $quantity[$gb_id]['quantity']; // jiaju ecodemall
            $price = current(unserialize($gb_info['spec_price']));
            empty($gb_info['default_image']) && $data[$gb_id]['default_image'] = Conf::get('default_goods_image');
			$data[$gb_id]['lefttime']   = lefttime($gb_info['end_time']); // jiaju ecodemall
            $data[$gb_id]['price']      = $price['price'];
        }
        return $data;
    }

    /* 取得店铺分类 */
    function _list_scategory()
    {
        $scategory_mod =& m('scategory');
        $scategories = $scategory_mod->get_list(-1,true);

        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($scategories, 'cate_id', 'parent_id', 'cate_name');
        return $tree->getArrayList(0);
    }

    function _get_goods_curlocal($cate_id)
    {
        $parents = array();
        if ($cate_id)
        {
            $gcategory_mod =& bm('gcategory');
            $parents = $gcategory_mod->get_ancestor($cate_id, true);
        }

        $curlocal = array(
            array('text' => LANG::get('all_categories'), 'url' => "javascript:dropParam('cate_id')"),
        );
        foreach ($parents as $category)
        {
            $curlocal[] = array('text' => $category['cate_name'], 'url' => "javascript:replaceParam('cate_id', '" . $category['cate_id'] . "')");
        }
        unset($curlocal[count($curlocal) - 1]['url']);

        return $curlocal;
    }

    function _get_store_curlocal($cate_id)
    {
        $parents = array();
        if ($cate_id)
        {
            $scategory_mod =& m('scategory');
            $scategory_mod->get_parents($parents, $cate_id);
        }

        $curlocal = array(
            array('text' => LANG::get('all_categories'), 'url' => url('app=category&act=store')),
        );
        foreach ($parents as $category)
        {
            $curlocal[] = array('text' => $category['cate_name'], 'url' => url('app=search&act=store&cate_id=' . $category['cate_id']));
        }
        unset($curlocal[count($curlocal) - 1]['url']);
        return $curlocal;
    }

    /**
     * 取得查询参数（有值才返回）
     *
     * @return  array(
     *              'keyword'   => array('aa', 'bb'),
     *              'cate_id'   => 2,
     *              'layer'     => 2, // 分类层级
     *              'brand'     => 'ibm',
     *              'region_id' => 23,
     *              'price'     => array('min' => 10, 'max' => 100),
     *          )
     */
    function _get_query_param()
    {
        static $res = null;
        if ($res === null)
        {
            $res = array();
    
            // keyword
            $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
            if ($keyword != '')
            {
                //$keyword = preg_split("/[\s," . Lang::get('comma') . Lang::get('whitespace') . "]+/", $keyword);
                $tmp = str_replace(array(Lang::get('comma'),Lang::get('whitespace'),' '),',', $keyword);
                $keyword = explode(',',$tmp);
                sort($keyword);
                $res['keyword'] = $keyword;
            }
    
            // cate_id
            if (isset($_GET['cate_id']) && intval($_GET['cate_id']) > 0)
            {
                $res['cate_id'] = $cate_id = intval($_GET['cate_id']);
                $gcategory_mod  =& bm('gcategory');
                $res['layer']   = $gcategory_mod->get_layer($cate_id, true);
            }
    
            // brand
            if (isset($_GET['brand']))
            {
                $brand = trim($_GET['brand']);
                $res['brand'] = $brand;
            }
    
            // region_id
            if (isset($_GET['region_id']) && intval($_GET['region_id']) > 0)
            {
                $res['region_id'] = intval($_GET['region_id']);
            }
    
            // price
            if (isset($_GET['price']))
            {
                $arr = explode('-', $_GET['price']);
                $min = abs(floatval($arr[0]));
                $max = abs(floatval($arr[1]));
                if ($min * $max > 0 && $min > $max)
                {
                    list($min, $max) = array($max, $min);
                }
    
                $res['price'] = array(
                    'min' => $min,
                    'max' => $max
                );
            }
        }

        return $res;
    }

    /**
     * 取得过滤条件
     */
    function _get_filter($param)
    {
        static $filters = null;
        if ($filters === null)
        {
            $filters = array();
            if (isset($param['keyword']))
            {
                $keyword = join(' ', $param['keyword']);
                $filters['keyword'] = array('key' => 'keyword', 'name' => LANG::get('keyword'), 'value' => $keyword);
            }
            isset($param['brand']) && $filters['brand'] = array('key' => 'brand', 'name' => LANG::get('brand'), 'value' => $param['brand']);
            if (isset($param['region_id']))
            {
                // todo 从地区缓存中取
                $region_mod =& m('region');
                $row = $region_mod->get(array(
                    'conditions' => $param['region_id'],
                    'fields' => 'region_name'
                ));
                $filters['region_id'] = array('key' => 'region_id', 'name' => LANG::get('region'), 'value' => $row['region_name']);
            }
            if (isset($param['price']))
            {
                $min = $param['price']['min'];
                $max = $param['price']['max'];
                if ($min <= 0)
                {
                    $filters['price'] = array('key' => 'price', 'name' => LANG::get('price'), 'value' => LANG::get('le') . ' ' . price_format($max));
                }
                elseif ($max <= 0)
                {
                    $filters['price'] = array('key' => 'price', 'name' => LANG::get('price'), 'value' => LANG::get('ge') . ' ' . price_format($min));
                }
                else
                {
                    $filters['price'] = array('key' => 'price', 'name' => LANG::get('price'), 'value' => price_format($min) . ' - ' . price_format($max));
                }
            }
        }
            

        return $filters;
    }

    /**
     * 取得查询条件语句
     *
     * @param   array   $param  查询参数（参加函数_get_query_param的返回值说明）
     * @return  string  where语句
     */
    function _get_goods_conditions($param)
    {
        /* 组成查询条件 */
        $conditions = " g.if_show = 1 AND g.closed = 0 AND s.state = 1"; // 上架且没有被禁售，店铺是开启状态,
        if (isset($param['keyword']))
        {
            $conditions .= $this->_get_conditions_by_keyword($param['keyword'], ENABLE_SEARCH_CACHE);
        }
        if (isset($param['cate_id']))
        {
            $conditions .= " AND g.cate_id_{$param['layer']} = '" . $param['cate_id'] . "'";
        }
        if (isset($param['brand']))
        {
            $conditions .= " AND g.brand = '" . $param['brand'] . "'";
        }
        if (isset($param['region_id']))
        {
            $conditions .= " AND s.region_id = '" . $param['region_id'] . "'";
        }
        if (isset($param['price']))
        {
            $min = $param['price']['min'];
            $max = $param['price']['max'];
            $min > 0 && $conditions .= " AND g.price >= '$min'";
            $max > 0 && $conditions .= " AND g.price <= '$max'";
        }

        return $conditions;
    }

    /**
     * 根据查询条件取得分组统计信息
     *
     * @param   array   $param  查询参数（参加函数_get_query_param的返回值说明）
     * @param   bool    $cached 是否缓存
     * @return  array(
     *              'total_count' => 10,
     *              'by_category' => array(id => array('cate_id' => 1, 'cate_name' => 'haha', 'count' => 10))
     *              'by_brand'    => array(array('brand' => brand, 'count' => count))
     *              'by_region'   => array(array('region_id' => region_id, 'region_name' => region_name, 'count' => count))
     *              'by_price'    => array(array('min' => 10, 'max' => 50, 'count' => 10))
     *          )
     */
    function _get_group_by_info($param, $cached)
    {
        $data = false;

        if ($cached)
        {
            $cache_server =& cache_server();
            $key = 'group_by_info_' . var_export($param, true);
            $data = $cache_server->get($key);
        }

        if ($data === false)
        {
            $data = array(
                'total_count' => 0,
                'by_category' => array(),
                'by_brand'    => array(),
                'by_region'   => array(),
                'by_price'    => array()
            );

            $goods_mod =& m('goods');
            $store_mod =& m('store');
            $table = " {$goods_mod->table} g LEFT JOIN {$store_mod->table} s ON g.store_id = s.store_id";
            $conditions = $this->_get_goods_conditions($param);
            $sql = "SELECT COUNT(*) FROM {$table} WHERE" . $conditions;
            $total_count = $goods_mod->getOne($sql);
            if ($total_count > 0)
            {
                $data['total_count'] = $total_count;
                /* 按分类统计 */
                $cate_id = isset($param['cate_id']) ? $param['cate_id'] : 0;
                $sql = "";
                if ($cate_id > 0)
                {
                    $layer = $param['layer'];
                    if ($layer < 4)
                    {
                        $sql = "SELECT g.cate_id_" . ($layer + 1) . " AS id, COUNT(*) AS count FROM {$table} WHERE" . $conditions . " AND g.cate_id_" . ($layer + 1) . " > 0 GROUP BY g.cate_id_" . ($layer + 1) . " ORDER BY count DESC";
                    }
                }
                else
                {
                    $sql = "SELECT g.cate_id_1 AS id, COUNT(*) AS count FROM {$table} WHERE" . $conditions . " AND g.cate_id_1 > 0 GROUP BY g.cate_id_1 ORDER BY count DESC";
                }

                if ($sql)
                {
                    $category_mod =& bm('gcategory');
                    $children = $category_mod->get_children($cate_id, true);
                    $res = $goods_mod->db->query($sql);
                    while ($row = $goods_mod->db->fetchRow($res))
                    {
                        $data['by_category'][$row['id']] = array(
                            'cate_id'   => $row['id'],
                            'cate_name' => $children[$row['id']]['cate_name'],
                            'count'     => $row['count']
                        );
                    }
                }

                /* 按品牌统计 */
                $sql = "SELECT g.brand, COUNT(*) AS count FROM {$table} WHERE" . $conditions . " AND g.brand > '' GROUP BY g.brand ORDER BY count DESC";
                $by_brands = $goods_mod->db->getAllWithIndex($sql, 'brand');
                
                /* 滤去未通过商城审核的品牌 */
                if ($by_brands)
                {
                    $m_brand = &m('brand');
                    $brand_conditions = db_create_in(addslashes_deep(array_keys($by_brands)), 'brand_name');
                    $brands_verified = $m_brand->getCol("SELECT brand_name FROM {$m_brand->table} WHERE " . $brand_conditions . ' AND if_show=1');
                    foreach ($by_brands as $k => $v)
                    {
                        if (!in_array($k, $brands_verified))
                        {
                            unset($by_brands[$k]);
                        }
                    }
                }
				
				import('init.lib');
				$by_brands = Init_SearchApp::_get_group_by_info_by_brands($by_brands,$param);
				
                $data['by_brand'] = $by_brands;
                
                
                /* 按地区统计 */
                $sql = "SELECT s.region_id, s.region_name, COUNT(*) AS count FROM {$table} WHERE" . $conditions . " AND s.region_id > 0 GROUP BY s.region_id ORDER BY count DESC";
				
				$by_regions = Init_SearchApp::_get_group_by_info_by_region($sql,$param);
                $data['by_region'] = $by_regions;
				/*  end  */
				

                /* 按价格统计 */
                if ($total_count > NUM_PER_PAGE)
                {
                    $sql = "SELECT MIN(g.price) AS min, MAX(g.price) AS max FROM {$table} WHERE" . $conditions;
                    $row = $goods_mod->getRow($sql);
                    $min = $row['min'];
                    $max = min($row['max'], MAX_STAT_PRICE);
                    $step = max(ceil(($max - $min) / PRICE_INTERVAL_NUM), MIN_STAT_STEP);
                    $sql = "SELECT FLOOR((g.price - '$min') / '$step') AS i, count(*) AS count FROM {$table} WHERE " . $conditions . " GROUP BY i ORDER BY i";
                    $res = $goods_mod->db->query($sql);
                    while ($row = $goods_mod->db->fetchRow($res))
                    {
                        $data['by_price'][] = array(
                            'count' => $row['count'],
                            'min'   => $min + $row['i'] * $step,
                            'max'   => $min + ($row['i'] + 1) * $step,
                        );
                    }
                }
            }

            if ($cached)
            {
                $cache_server->set($key, $data, SEARCH_CACHE_TTL);
            }
        }
		
        return $data;
    }

    /**
     * 根据关键词取得查询条件（可能是like，也可能是in）
     *
     * @param   array       $keyword    关键词
     * @param   bool        $cached     是否缓存
     * @return  string      " AND (0)"
     *                      " AND (goods_name LIKE '%a%' AND goods_name LIKE '%b%')"
     *                      " AND (goods_id IN (1,2,3))"
     */
    function _get_conditions_by_keyword($keyword, $cached)
    {
        $conditions = false;

        if ($cached)
        {
            $cache_server =& cache_server();
            $key1 = 'query_conditions_of_keyword_' . join("\t", $keyword);
            $conditions = $cache_server->get($key1);
        }

        if ($conditions === false)
        {
            /* 组成查询条件 */
            $conditions = array();
            foreach ($keyword as $word)
            {
                $conditions[] = "g.goods_name LIKE '%{$word}%'";
            }
            $conditions = join(' AND ', $conditions);

            /* 取得满足条件的商品数 */
            $goods_mod =& m('goods');
            $sql = "SELECT COUNT(*) FROM {$goods_mod->table} g WHERE " . $conditions;
            $current_count = $goods_mod->getOne($sql);
            if ($current_count > 0)
            {
                if ($current_count < MAX_ID_NUM_OF_IN)
                {
                    /* 取得商品表记录总数 */
                    $cache_server =& cache_server();
                    $key2 = 'record_count_of_goods';
                    $total_count = $cache_server->get($key2);
                    if ($total_count === false)
                    {
                        $sql = "SELECT COUNT(*) FROM {$goods_mod->table}";
                        $total_count = $goods_mod->getOne($sql);
                        $cache_server->set($key2, $total_count, SEARCH_CACHE_TTL);
                    }

                    /* 不满足条件，返回like */
                    if (($current_count / $total_count) < MAX_HIT_RATE)
                    {
                        /* 取得满足条件的商品id */
                        $sql = "SELECT goods_id FROM {$goods_mod->table} g WHERE " . $conditions;
                        $ids = $goods_mod->getCol($sql);
                        $conditions = 'g.goods_id' . db_create_in($ids);
                    }
                }
            }
            else
            {
                /* 没有满足条件的记录，返回0 */
                $conditions = "0";
            }

            if ($cached)
            {
                $cache_server->set($key1, $conditions, SEARCH_CACHE_TTL);
            }
        }

        return ' AND (' . $conditions . ')';
    }

    /* 商品排序方式  edit jiaju ecodemall  */
    function _get_orders()
    {
        return array(
            ''             => Lang::get('default_order'),
            'sales'        => Lang::get('sales_desc'),
			'price'        => Lang::get('price'),
			'add_time'     => Lang::get('add_time'),
			'comments'      => Lang::get('comment'),
            'credit_value' => Lang::get('credit_value'),
            'views'        => Lang::get('views')
        );
    }
    
    function _get_seo_info($type, $cate_id)
    {
        $seo_info = array(
            'title'       => '',
            'keywords'    => '',
            'description' => ''
        );
        $parents = array(); // 所有父级分类包括本身
        switch ($type)
        {
            case 'goods':                
                if ($cate_id)
                {
                    $gcategory_mod =& bm('gcategory');
                    $parents = $gcategory_mod->get_ancestor($cate_id, true);
                    $parents = array_reverse($parents);
                }
                $filters = $this->_get_filter($this->_get_query_param());
                foreach ($filters as $k => $v)
                {
                    $seo_info['keywords'] .= $v['value']  . ',';
                }
                break;
            case 'store':
                if ($cate_id)
                {
                    $scategory_mod =& m('scategory');
                    $scategory_mod->get_parents($parents, $cate_id);
                    $parents = array_reverse($parents);
                }
        }
        
        foreach ($parents as $key => $cate)
        {
            $seo_info['title'] .= $cate['cate_name'] . ' - ';
            $seo_info['keywords'] .= $cate['cate_name']  . ',';
            if ($cate_id == $cate['cate_id'])
            {
                $seo_info['description'] = $cate['cate_name'] . ' ';
            }
        }
        $seo_info['title'] .= Lang::get('searched_'. $type) . ' - ' .Conf::get('site_title');
        $seo_info['keywords'] .= Conf::get('site_title');
        $seo_info['description'] .= Conf::get('site_title');
        return $seo_info;
    }
	
	function field(){
		/* 取得导航 */
        $this->assign('navs', $this->_get_navs());
		
        $scategorys = $this->_list_scategory();
        $this->assign('scategorys', $scategorys);
        $this->display('search.field.html');
	}
	//公司类别分类
	function morestore(){
		$gtype=$_GET['gtype'];
		$query="";
		$s_county=trim($_GET['s_county']);
		$selected="";
		$city=city();
		if(empty($s_county)){
			//已选条件
			$selected="全".$city;
			$query="select * from ecm_company where gtype like '{$gtype}' and s_city like '{$city}' ";
		}else{
			//已选条件
			$selected=city()."-".$s_county;
			$query="select * from ecm_company where gtype like '{$gtype}' and s_city like '{$city}' and s_county like '{$s_county}' ";
		}
		$result=mysql_query($query); //发送sql查询
		$list=array();
		if($result != false){
			while($row=@mysql_fetch_assoc($result)){
				$list[]=$row;
			}
		}
		//$city=city();
		$this->assign('selected',$selected);
		$this->assign('city',$city);
		$tiao=count($list);
		$this->assign('tiao',$tiao);
		$this->assign('gtype',$gtype);
		$this->assign('list',$list);
		 
		$this->display('morestore.html');
	}
}

?>
