<?php
//文件上传类
function upload($file=null,$maxSize=0,$exts=0,$savePath='')
{
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   = $maxSize;// 设置附件上传大小
    $upload->exts      = $exts; //array('jpg', 'gif', 'png', 'jpeg'); 设置附件上传类型
    $upload->savePath  = $savePath; // 设置附件上传目录
	// 上传文件
    if($file)
      $info = $upload->uploadOne($file);
    else
      $info = $upload->upload();
    if(!$info) {
	// 上传错误提示错误信息
		//print_r($upload->getError());die;
		//$this->error($upload->getError());
		return false;
    }else{
	// 上传成功
		return $info;
	}
}
//二分查找 索引一位数组（数组里查找某个元素） 
function bin_sch($array, $low, $high, $serch_value){ 
	if($low <= $high){ 
		$mid = intval(($low+$high)/2); 
		if($array[$mid] == $serch_value){ 
			return $mid; 
		}elseif($serch_value < $array[$mid]){ 
			return bin_sch($array, $low, $mid-1, $serch_value); 
		}else{ 
			return bin_sch($array, $mid+1, $high, $serch_value); 
		} 
	} 
	return -1; 
}

//顺序查找（数组里查找某个元素） 
/*
$array 查找数组
$n 数组的长度
$k 查找的值
*/
function seq_sch($array, $n, $k){ 
	$array[$n] = $k; 
	$i=0;
	for($i=0; $i<$n; $i++){ 
		if($array[$i]==$k){ 
			break; 
		} 
	} 
	if ($i<$n){ 
		return $i; 
	}else{ 
		return -1; 
	} 
}


//冒泡排序（数组排序）(最大沉底)
function bubble_sort($array) 
{ 
    $count = count($array); 
    if ($count <= 0) return false;
    for($i=0; $i<$count; $i++){ 
        for($j=$count-1; $j>$i; $j--){ 
            if ($array[$j] < $array[$j-1]){ 
                $tmp = $array[$j]; 
                $array[$j] = $array[$j-1]; 
                $array[$j-1] = $tmp; 
            } 
        } 
    } 
    return $array; 
}

//快速排序（数组排序） 
function quick_sort($array) {
    if(count($array) <= 1){return $array;}
    $key = $array[0]; 
    $left_arr = array(); 
    $right_arr = array();
    for ($i=1; $i<count($array); $i++){ 
        if ($array[$i] <= $key){$left_arr[] = $array[$i];} 
        else{$right_arr[] = $array[$i];}
    }
    $left_arr = quick_sort($left_arr); 
    $right_arr = quick_sort($right_arr);
    return array_merge($left_arr, array($key), $right_arr); 
}

//字符串长度 
function mystrlen($str)
{ 
    if ($str == '') return 0;
    $count = 0; 
    while (1){ 
        if ($str[$count] != NULL){ 
            $count++; 
            continue; 
        }else{ 
             break; 
        } 
    } 
    return $count; 
}

//截取子串 
function mysubstr($str, $start, $length=NULL) 
{
	$substr="";
    if ($str=='' || $start>strlen($str)) return; 
    if (($length!=NULL) && ($start>0) && ($length>strlen($str)-$start)) return; 
    if (($length!=NULL) && ($start<0) && ($length>strlen($str)+$start)) return; 
    if ($length == NULL) $length = (strlen($str) - $start); 

    if ($start < 0){ 
	    for ($i=(strlen($str)+$start); $i<(strlen($str)+$start+$length); $i++) { 
	    	$substr .= $str[$i]; 
	    } 
    }
    if ($length > 0){ 
	    for ($i=$start; $i<($start+$length); $i++) { 
	    $substr .= $str[$i]; 
	    } 
    }
    if ($length < 0){ 
	    for ($i=$start; $i<(strlen($str)+$length); $i++) { 
	    	$substr .= $str[$i]; 
	    } 
    } 
    return $substr; 
}

//字符串翻转 
function mystrrev($str) 
{ 
	$rev_str="";
	if($str == ''){return 0;} 
	for($i=(strlen($str)-1); $i>=0; $i--){ 
		$rev_str .= $str[$i]; 
	} 
	return $rev_str; 
}

//字符串比较 ,1大于，-1小于，0等于，false不等于
function mystrcmp($s1, $s2) 
{ 
	if(strlen($s1) < strlen($s2)){return -1;}
	if (strlen($s1) > strlen($s2)){return 1;}
	for ($i=0; $i<strlen($s1); $i++){ 
		if ($s1[$i] == $s2[$i]){ 
			continue; 
		}else{ 
			return false; 
		} 
	} 
	return 0; 
}

//查找子字符串在母字符串中的位置 
function mystrstr($str, $substr) 
{ 
	$m = strlen($str); 
	$n = strlen($substr); 
	if($m < $n){return false;}
	for($i=0; $i<=($m-$n+1); $i++){ 
	$sub = substr($str, $i, $n); 
	if (strcmp($sub, $substr) == 0){return $i;} 
	} 
	return false; 
}




//删除索引数组指定位置的元素 ，键值重新排列
function delete_array_element($array, $i) 
{
	$len = count($array); 
	for ($j=$i; $j<$len; $j++){ 
		$array[$j] = $array[$j+1]; 
	} 
	array_pop($array); 
	return $array; 
}


//字符串替换 
function mystr_replace($substr, $newsubstr, $str) 
{ 
	$m = strlen($str); 
	$n = strlen($substr); 
	$x = strlen($newsubstr); 
	if (strpos($mystring, $findme) == false) return false;
	for ($i=0; $i<=($m-$n+1); $i++){
		$pos = strpos($mystring, $findme); 
		$str = str_delete($str, $pos, $n); 
		$str = str_insert($str, $pos, $newsubstr); 
	} 
	return $str; 
}

//插入一段字符串 
function mystr_insert($str, $i, $substr) 
{ 
	for($j=0; $j<$i; $j++){ 
		$startstr .= $str[$j]; 
	} 
	for ($j=$i; $j<strlen($str); $j++){ 
		$laststr .= $str[$j]; 
	} 
	$str = ($startstr . $substr . $laststr);
	return $str; 
}

//删除一段字符串 
function mystr_delete($str, $i, $j) 
{ 
	for ($c=0; $c<$i; $c++){ 
		$startstr .= $str[$c]; 
	} 
	for ($c=($i+$j); $c<strlen($str); $c++){ 
		$laststr .= $str[$c]; 
	} 
	$str = ($startstr . $laststr);
	return $str; 
}

//复制字符串,将$s1拼接到$s2中 $s2.$s1
function strcpy($s1, $s2) 
{ 
	if (strlen($s1)==NULL || !isset($s2)) return;
	for ($i=0; $i<strlen($s1); $i++){ 
		$s2[] = $s1[$i]; 
	} 
	return $s2; 
}
//连接字符串 $s1.$s2
function strcat($s1, $s2) 
{ 
	if (!isset($s1) || !isset($s2)) return; 
	$newstr = $s1; 
	for($i=0; $i<count($s2); $i++){ 
	$newstr .= $s2[$i]; 
	} 
	return $newsstr; 
}


//简单编码函数,编码字符串有长度限制（与php_decode函数对应） 
function php_encode($str) 
{ 
	$s="";
	if (empty($str) || strlen($str)>128){return false;}
	for($i=0; $i<strlen($str); $i++){ 
		//返回 $str[$i] 的 ASCII值
		$c = ord($str[$i]); 
		if ($c>31 && $c<107){$c += 20;} 
		if ($c>106 && $c<127){$c -= 75;} 
		//chr($c)从不同的 ASCII 值返回字符
		$word = chr($c); 
		$s .= $word; 
	}
	return $s; 
}

//简单解码函数（与php_encode函数对应） 
function php_decode($str) 
{ 
	$s="";
	$word="";
	if($str=='' && strlen($str)>128){return false;}
	for($i=0; $i<strlen($str); $i++){ 
		$c = ord($str[$i]); 
		if ($c>106 && $c<127) $c = $c-20; 
		if ($c>31 && $c<107) $c = $c+75; 
		$word = chr($c); 
		$s .= $word; 
	}
	return $s; 
}

//简单加密函数（与php_decrypt函数对应） ,其实就是一种输入a得b的一种事先约定好的暗号式加密方式
function php_encrypt($str) 
{ 
	$encrypt_key = 'abcdefghijklmnopqrstuvwxyz1234567890'; 
	$decrypt_key = 'ngzqtcobmuhelkpdawxfyivrsj2468021359';
	$enstr="";
	if (strlen($str) == 0){return false;}
	for ($i=0; $i<strlen($str); $i++){ 
		for ($j=0; $j<strlen($encrypt_key); $j++){ 
			if ($str[$i] == $encrypt_key[$j]){ 
				$enstr .= $decrypt_key[$j]; 
				break; 
			} 
		} 
	}
	return $enstr; 
}

// 弹框跳转
function alert($msg,$url=''){
	echo "<script>";
		echo "alert('$msg');";
		if($url){
			echo "window.location.href='$url';";
		}else{
			echo "window.history.go(-1);";
		}
	echo "</script>";
}

//获取现有url的所有参数,放入数组参数列表，并把重复的替换,去掉空的参数值
function getUrlvalues($params)
{
  $data=array();
  foreach($_GET as $k=>$v){
  	$v=trim($v);
  	if(!empty($v)){
  		$data[$k]=$v;
  	}
  }
  foreach($params as $key=>$val){
  	$val=trim($val);
  	if(!empty($val)){
  		$data[$key]=$val;
  	}
  }
  return $data;
}

/**  
* 获取客户端IP  （通用）
* @return [string] [description]
*/ 
function getClientIp(){    
 $ip = NULL;     
 if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
	    $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']); 
	    $pos =  array_search('unknown',$arr);      
	    if(false !== $pos){unset($arr[$pos]);}
	    $ip   =  trim($arr[0]);   
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) { 
        $ip = $_SERVER['HTTP_CLIENT_IP'];     
    }elseif (isset($_SERVER['REMOTE_ADDR'])) { 
        $ip = $_SERVER['REMOTE_ADDR'];    
	}     
    // IP地址合法验证     
  $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';   
     return $ip;
}

/**  
* 获取在线IP  
* @return String  
*/ 
function getOnlineIp($format=0) {
	global $S_GLOBAL;
	if(empty($S_GLOBAL['onlineip'])) {
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],'unknown')) { 
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		$S_GLOBAL['onlineip'] = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
	}
	if($format) {
		$ips = explode('.', $S_GLOBAL['onlineip']);
		for($i=0;$i<3;$i++) {
			$ips[$i] = intval($ips[$i]);
		}
		return sprintf('%03d%03d%03d', $ips[0], $ips[1], $ips[2]);
	} else {
		return $S_GLOBAL['onlineip'];
	}
}

/**  
* 获取url  
* @return [type] [description]  
*/ 
function getUrl(){   
	$pageURL = 'http';   
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
	     $pageURL .= "s";
	    }   
	    $pageURL .= "://"; 
	    if ($_SERVER["SERVER_PORT"] != "80") {
	        $pageURL .= $_SERVER["HTTP_HOST"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];   
	    } else {
	        $pageURL .= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	    } 
	        return $pageURL; 
}

/**  
* 获取当前站点的访问路径根目录  
* @return [type] [description]  
*/
function getSiteUrl(){
	$uri = $_SERVER['REQUEST_URI']?$_SERVER['REQUEST_URI']:($_SERVER['PHP_SELF']?$_SERVER['PHP_SELF']:$_SERVER['SCRIPT_NAME']);
	return 'http://'.$_SERVER['HTTP_HOST'].substr($uri, 0, strrpos($uri, '/')+1); 
}
function get_domain()
{
    /* 协议 */
    $protocol = (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';

    /* 域名或IP地址 */
    if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
    {
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
    }
    elseif (isset($_SERVER['HTTP_HOST']))
    {
        $host = $_SERVER['HTTP_HOST'];
    }
    else
    {
        /* 端口 */
        if (isset($_SERVER['SERVER_PORT']))
        {
            $port = ':' . $_SERVER['SERVER_PORT'];

            if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol))
            {
                $port = '';
            }
        }
        else
        {
            $port = '';
        }

        if (isset($_SERVER['SERVER_NAME']))
        {
            $host = $_SERVER['SERVER_NAME'] . $port;
        }
        elseif (isset($_SERVER['SERVER_ADDR']))
        {
            $host = $_SERVER['SERVER_ADDR'] . $port;
        }
    }

    return $protocol . $host;
}

// /**
//  * 获得网站的URL地址
//  *
//  * @return  string
//  */
function site_url()
{
    return get_domain() . substr(PHP_SELF, 0, strrpos(PHP_SELF, '/'));
}

/**  
* 字符串截取，支持中文和其他编码  
* @param  [string]  $str     [字符串]  
* @param  integer $start   [起始位置]  
* @param  integer $length  [截取长度]  
* @param  string  $charset [字符串编码]  
* @param  boolean $suffix  [是否有省略号]  
* @return [type]           [description]  
*/
function msubstr($str, $start=0, $length=15, $charset="utf-8", $suffix=true){
      if(function_exists("mb_substr")) {
            return mb_substr($str, $start, $length, $charset);
        } elseif(function_exists('iconv_substr')) {
            return iconv_substr($str,$start,$length,$charset);
        }
        $re['utf-8']   =  "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/"; 
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/"; 
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";  
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";  
        preg_match_all($re[$charset], $str, $match); 
        $slice = join("",array_slice($match[0], $start, $length)); 
         if($suffix) {
            return $slice."…"; 
         }
    return $slice; 
}


//根据IP地址获取所在城市的详细信息 返回：
    // [start] => -1
    // [end] => -1
    // [country] => 中国
    // [province] => 广东
    // [city] => 广州
    // [district] => 
    // [isp] => 
    // [type] => 
    // [desc] => 
    // [ip] => 219.137.123.156
function GetIpLookup($ip = ''){
    if(empty($ip)){
        $ip = getip();
    }
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
    if(empty($res)){ return false; }
    $jsonMatches = array();
    preg_match('#\{.+?\}#', $res, $jsonMatches);
    if(!isset($jsonMatches[0])){ return false; }
    $json = json_decode($jsonMatches[0], true);
    if(isset($json['ret']) && $json['ret'] == 1){
        $json['ip'] = $ip;
        unset($json['ret']);
    }else{
        return false;
    }
    return $json;
}

// /**  
// * php 实现js escape 函数   编码
// * @param  [type] $string   [description]  
// * @param  string $encoding [description] 
// * @return [type]           [description]  
// */
function escape($string, $encoding='UTF-8'){
	$return = null;
	for ($x = 0; $x < mb_strlen($string, $encoding);$x++){
	    $str = mb_substr($string, $x,1, $encoding);
	   if (strlen($str) > 1){
	       // 多字节字符        
	       	$return .= "%u" . strtoupper(bin2hex(mb_convert_encoding($str, 'UCS-2', $encoding)));
	   }else{
	          $return .= "%" . strtoupper(bin2hex($str));
	         } 
	}  
	return $return; 
}


// /**
// * php 实现 js unescape函数    解码
// * @param  [type] $str [description]  
// * @return [type]      [description]  
// */
function unescape($str){
      $str = rawurldecode($str);
      preg_match_all("/(?:%u.{4})|.{4};|&#\d+;|.+/U",$str,$r);
      $ar = $r[0];
	    foreach($ar as $k=>$v){
	        if(substr($v,0,2) == "%u"){
	            $ar[$k] =  iconv("UCS-2","utf-8//IGNORE",pack("H4",substr($v,-4)));
	        }elseif(substr($v,0,3) == ""){
	            $ar[$k] = iconv("UCS-2","utf-8",pack("H4",substr($v,3,-1)));
	        } elseif(substr($v,0,2) == "&#"){
	            echo substr($v,2,-1)."";
	            $ar[$k] = iconv("UCS-2","utf-8",pack("n",substr($v,2,-1)));
	        }
	    }
    return join("",$ar); 
}


// /**   
// * 数字转人名币  
// * @param  [type] $num [description] 
// * @return [type]      [description]  
// */
function num2rmb($num){
	$c1 = "零壹贰叁肆伍陆柒捌玖";     
	$c2 = "分角元拾佰仟万拾佰仟亿";     
	$num = round($num, 2);     
	$num = $num * 100;     
	if (strlen($num) > 10) {          
		return "oh,sorry,the number is too long!";     
	}      
	$i = 0;     
	$c = "";     
	while (1) {         
		if ($i == 0) {              
			$n = substr($num, strlen($num)-1, 1);         
		} else {              
			$n = $num % 10;         
		}          
		$p1 = substr($c1, 3 * $n, 3);         
		$p2 = substr($c2, 3 * $i, 3);          
		if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {              
			$c = $p1 . $p2 . $c;         
		} else {              
			$c = $p1 . $c;         
		}          
		$i = $i + 1;         
		$num = $num / 10;         
		$num = (int)$num;         
		if ($num == 0) {             
			break;         
		}     
	}     
	$j = 0;      
	$slen = strlen($c);     
	while ($j < $slen) {          
		$m = substr($c, $j, 6);         
		if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {             
			$left = substr($c, 0, $j);             
			$right = substr($c, $j + 3);             
			$c = $left . $right;             
			$j = $j-3;             
			$slen = $slen-3;
	}       $j = $j + 3;     
	}     
	if (substr($c, strlen($c)-3, 3) == '零') {         
	$c = substr($c, 0, strlen($c)-3);     
	} 
	// if there is a '0' on the end , chop it out     
	return $c . "整"; 
}


 /**  
 * 下载本地指定目录的文件，而且是html格式
 * @param  [type] $filename [description]  
 * @param  string $dir      [description]  
 * @return [type]           [description]  
 */
function downloads($filename,$dir='./'){ 
	$filepath = $dir.$filename;     
	if (!file_exists($filepath)){         
		header("Content-type: text/html; charset=utf-8");         
		echo "File not found!";         
		exit;     
	}else{         
	 	$file = fopen($filepath,"r");          
	 	Header("Content-type: application/octet-stream");         
	 	Header("Accept-Ranges: bytes");          
	 	Header("Accept-Length: ".filesize($filepath));         
	 	Header("Content-Disposition: attachment; filename=".$filename);         
	 	echo fread($file, filesize($filepath));         
	 	fclose($file);     
	}
}
//远程指定文件下载
/*
*从远程下载文件到本地指定目录
*$url  远程文件完整url
*$save_dir 保存本地路径 以‘/’结尾表示目录
*$filename 保存在本地的文件名 必须指定
*$type 获取文件的方式 0文件流  其他CRUL方式 目前0是可以下载的
*/
// r   only read    只读。在文件的开头开始。 
// r+  read/write   读/写。在文件的开头开始。 
// w   only write   只写。打开并清空文件的内容；如果文件不存在，则创建新文件。 
// w+  read/write   读/写。打开并清空文件的内容；如果文件不存在，则创建新文件。 
// a   and to       追加。打开并向文件文件的末端进行写操作，如果文件不存在，则创建新文件。 
// a+  read/and to  读/追加。通过向文件末端写内容，来保持文件内容。 
// x   only write   只写。创建新文件。如果文件以存在，则返回 FALSE。 
// x+  read/write   读/写。创建新文件。如果文件已存在，则返回 FALSE 和一个错误。 
function getFile($url,$save_dir='',$filename='',$type=0){
	  if(trim($url)==''){
	   return false;
	  }
	  if(trim($save_dir)==''){
	   $save_dir='./';
	  }
	  if(0!==strrpos($save_dir,'/')){
	   $save_dir.='/';
	  }
	  //创建保存目录
	  if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
	   return false;
	  }
	 //获取远程文件所采用的方法
	 if($type){
	  $ch=curl_init();
	  $timeout=10;
	  curl_setopt($ch,CURLOPT_URL,$url);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
	  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	  $content=curl_exec($ch);
	 }else{
	  ob_start();
	  readfile($url);
	  $content=ob_get_contents();
	  ob_end_clean();
	  }
	 $size=strlen($content);
	 //文件大小
	 $fp2=@fopen($save_dir.$filename,'w');
	 fwrite($fp2,$content);
	 fclose($fp2);
	 unset($content,$url);
	 return array('file_name'=>$filename,'save_path'=>$save_dir.$filename);
}
// /**  
// * 创建一个目录树   可以递进创建
// * @param  [type]  $dir  [description]  
// * @param  integer $mode [description]  
// * @return [type]        [description]  
// */
function mkdirs($dir, $mode=0777){     
	if (!is_dir($dir)) {          
		mkdirs(dirname($dir), $mode);         
		return mkdir($dir, $mode);     
	}     
	return true; 
}

// /**
// *获得日期是上中下旬  
// * @param  [int] $j [几号]  
// * @return [array]    [description]  
// * @author [yangsheng@yahoo.com]  
// */
function getTenDays($j) {        
	$j = intval($j);      
	if($j < 1 || $j > 31){         
		return false;//不是日期     
	}    
	$tenDays = ceil($j/10);     
	switch ($tenDays) {         
		case 1://上旬             
		return array('tenday_of_month'=>1,'tenday_cn'=>'上旬',);             
		break;         
		case 2://中旬              
		return array('tenday_of_month'=>2,'tenday_cn'=>'中旬',);             
		break;                 
		default://下旬             
		return array('tenday_of_month'=>3,'tenday_cn'=>'下旬',);             
		break;     
	}     
	return false; 
}

// /**  
// * 根据月份获得当前第几季度  
// * @param  [int] $n [月份]  
// * @param  [int] $y [年]  
// * @return [array]    [description]  
// */
function getQuarter($n,$y=null){      
	$n = intval($n);     
	if($n < 1 || $n > 12){         
		return false;   //不是月份     
	}     
	$quarter = ceil($n/3);     
	switch ($quarter) {         
		case 1: //第一季度             
		return array('current_quarter' => 1, 'quarter_cn'=>$y?$y.'-Q1':'Q1');             
		break;         
		case 2: //第二季度 
		return array('current_quarter' => 2, 'quarter_cn'=>$y?$y.'-Q2':'Q2');             
		break;          
		case 3: //第三季度             
		return array('current_quarter' => 3, 'quarter_cn'=>$y?$y.'-Q3':'Q3');             
		break;          
		case 4: //第四季度              
		return array('current_quarter' => 4, 'quarter_cn'=>$y?$y.'-Q4':'Q4');             
		break;     
	}       
	return false; 
} 

// /**  
// * 根据一个时间戳得到详细信息  
// * @param  [type] $time [时间戳]  
// * @return [type]         
// * @author [yangsheng@yahoo.com]  
// */
function getDateInfo($time){     
	$day_of_week_cn=array("日","一","二","三","四","五","六"); //中文星期     
	$week_of_month_cn = array('','第1周','第2周','第3周','第4周','第5周','第6周');//本月第几周     
	$tenDays= getTenDays(date('j',$time)); //获得旬     
	$quarter = getQuarter(date('n',$time),date('Y',$time));// 获取季度           
	$dimDate = array(         
		'date_key' => strtotime(date('Y-m-d',$time)), //日期时间戳          
		'date_day' => date('Y-m-d',$time), //日期YYYY-MM-DD          
		'current_year' => date('Y',$time),//数字年          
		'current_quarter' => $quarter['current_quarter'], //季度         
		'quarter_cn' =>$quarter['quarter_cn'],         
		'current_month' =>date('n',$time),//月         
		'month_cn' =>date('Y-m',$time), //月份         
		'tenday_of_month' =>$tenDays['tenday_of_month'],//数字旬         
		'tenday_cn' =>$tenDays['tenday_cn'],//中文旬         
		'week_of_month' =>ceil(date('j',$time)/7), //本月第几周         
		'week_of_month_cn' =>$week_of_month_cn[ceil(date('j',$time)/7)],//中文当月第几周         
		'day_of_year' =>date('z',$time)+1,  //年份中的第几天         
		'day_of_month' =>date('j',$time),//得到几号         
		'day_of_week' =>date('w',$time)>0 ? date('w',$time):7,//星期几         
		'day_of_week_cn' =>'星期'.$day_of_week_cn[date('w',$time)],      
		);     
	return $dimDate; 
}


// /**
//  * 获得用户的真实IP地址
//  *
//  * @return  string
//  */
function real_ip()
{
    static $realip = NULL;

    if ($realip !== NULL)
    {
        return $realip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
}

// /**
//  * 验证输入的邮件地址是否合法
//  *
//  * @param   string      $email      需要验证的邮件地址
//  *
//  * @return bool
//  */
function is_email($user_email)
{
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,5}\$/i";
    if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false)
    {
        if (preg_match($chars, $user_email))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

// /**
//  * 检查是否为一个合法的时间格式
//  *
//  * @param   string  $time
//  * @return  void
//  */
function is_time($time)
{
    $pattern = '/[\d]{4}-[\d]{1,2}-[\d]{1,2}\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2}/';

    return preg_match($pattern, $time);
}

/**
 * 递归方式的对变量中的特殊字符进行转义
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function addslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
    }
}

// /**
//  * 将对象成员变量或者数组的特殊字符进行转义
//  *
//  * @access   public
//  * @param    mix        $obj      对象或者数组
//  * @author   Xuan Yan
//  *
//  * @return   mix                  对象或者数组
//  */
function addslashes_deep_obj($obj)
{
    if (is_object($obj) == true)
    {
        foreach ($obj AS $key => $val)
        {
            if ( ($val) == true)
            {
                $obj->$key = addslashes_deep_obj($val);
            }
            else
            {
                $obj->$key = addslashes_deep($val);
            }
        }
    }
    else
    {
        $obj = addslashes_deep($obj);
    }

    return $obj;
}

// /**
//  * 递归方式的对变量中的特殊字符去除转义
//  *
//  * @access  public
//  * @param   mix     $value
//  *
//  * @return  mix
//  */
function stripslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        return is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
    }
}
// /**
//  *  将一个字串中含有全角的数字字符、字母、空格或'%+-()'字符转换为相应半角字符
//  *
//  * @access  public
//  * @param   string       $str         待转换字串
//  *
//  * @return  string       $str         处理后字串
//  */
function make_semiangle($str)
{
    $arr = array('０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4',
                 '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9',
                 'Ａ' => 'A', 'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E',
                 'Ｆ' => 'F', 'Ｇ' => 'G', 'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J',
                 'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 'Ｎ' => 'N', 'Ｏ' => 'O',
                 'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 'Ｔ' => 'T',
                 'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y',
                 'Ｚ' => 'Z', 'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd',
                 'ｅ' => 'e', 'ｆ' => 'f', 'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i',
                 'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l', 'ｍ' => 'm', 'ｎ' => 'n',
                 'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r', 'ｓ' => 's',
                 'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x',
                 'ｙ' => 'y', 'ｚ' => 'z',
                 '（' => '(', '）' => ')', '［' => '[', '］' => ']', '【' => '[',
                 '】' => ']', '〖' => '[', '〗' => ']', '「' => '[', '」' => ']',
                 '『' => '[', '』' => ']', '｛' => '{', '｝' => '}', '《' => '<',
                 '》' => '>',
                 '％' => '%', '＋' => '+', '—' => '-', '－' => '-', '～' => '-',
                 '：' => ':', '。' => '.', '、' => ',', '，' => '.', '、' => '.',
                 '；' => ',', '？' => '?', '！' => '!', '…' => '-', '‖' => '|',
                 '＂' => '"', '＇' => '`', '｀' => '`', '｜' => '|', '〃' => '"',
                 '　' => ' ');

    return strtr($str, $arr);
}

// /**
//  * 格式化费用：可以输入数字或百分比的地方 其实就是将单位去掉 百分号保留
//  *
//  * @param   string      $fee    输入的费用
//  */
function format_fee($fee)
{
    $fee = make_semiangle($fee);
    if (strpos($fee, '%') === false)
    {
        return floatval($fee);
    }
    else
    {
        return floatval($fee) . '%';
    }
}

// /**
//  * 根据总金额和费率计算费用
//  *
//  * @param     float    $amount    总金额
//  * @param     string    $rate    费率（可以是固定费率，也可以是百分比）
//  * @param     string    $type    类型：s 保价费 p 支付手续费 i 发票税费
//  * @return     float    费用
//  */
function compute_fee($amount, $rate, $type)
{
    $amount = floatval($amount);
    if (strpos($rate, '%') === false)
    {
        return round(floatval($rate), 2);
    }
    else
    {
        $rate = floatval($rate) / 100;
        if ($type == 's')
        {
            return round($amount * $rate, 2);
        }
        elseif($type == 'p')
        {
            return round($amount * $rate / (1 - $rate), 2);
        }
        else
        {
            return round($amount * $rate, 2);
        }
    }
}

// /**
//  * 获取服务器的ip
//  *
//  * @access      public
//  *
//  * @return string
//  **/
function real_server_ip()
{
    static $serverip = NULL;

    if ($serverip !== NULL)
    {
        return $serverip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['SERVER_ADDR']))
        {
            $serverip = $_SERVER['SERVER_ADDR'];
        }
        else
        {
            $serverip = '0.0.0.0';
        }
    }
    else
    {
        $serverip = getenv('SERVER_ADDR');
    }

    return $serverip;
}
// /**
//  * 获得用户操作系统的换行符
//  *
//  * @access  public
//  * @return  string
//  */
function get_crlf()
{
/* LF (Line Feed, 0x0A, \N) 和 CR(Carriage Return, 0x0D, \R) */
    if (stristr($_SERVER['HTTP_USER_AGENT'], 'Win'))
    {
        $the_crlf = "\r\n";
    }
    elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Mac'))
    {
        $the_crlf = "\r"; // for old MAC OS
    }
    else
    {
        $the_crlf = "\n";
    }

    return $the_crlf;
}

// /**
//  *  fopen封装函数
//  *
//  *  @author wj
//  *  @param string $url
//  *  @param int    $limit
//  *  @param string $post
//  *  @param string $cookie
//  *  @param boolen $bysocket
//  *  @param string $ip
//  *  @param int    $timeout
//  *  @param boolen $block
//  *  @return responseText
//  */
function ecm_fopen($url, $limit = 500000, $post = '', $cookie = '', $bysocket = false, $ip = '', $timeout = 15, $block = true)
{
    $return = '';
    $matches = parse_url($url);
    $host = $matches['host'];
    $path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
    $port = !empty($matches['port']) ? $matches['port'] : 80;

    if($post)
    {
        $out = "POST $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= 'Content-Length: '.strlen($post)."\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cache-Control: no-cache\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
        $out .= $post;
    }
    else
    {
        $out = "GET $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
    }
    $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
    if(!$fp)
    {
        return '';
    }
    else
    {
        stream_set_blocking($fp, $block);
        stream_set_timeout($fp, $timeout);
        @fwrite($fp, $out);
        $status = stream_get_meta_data($fp);
        if(!$status['timed_out'])
        {
            while (!feof($fp))
            {
                if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n"))
                {
                    break;
                }
            }

            $stop = false;
            while(!feof($fp) && !$stop)
            {
                $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                $return .= $data;
                if($limit)
                {
                    $limit -= strlen($data);
                    $stop = $limit <= 0;
                }
            }
        }
        @fclose($fp);
        return $return;
    }
}

// /**
//  * 危险 HTML代码过滤器
//  *
//  * @param   string  $html   需要过滤的html代码
//  *
//  * @return  string
//  */
function html_filter($html)
{
    $filter = array(
        "/\s/",
        "/<(\/?)(script|i?frame|style|html|body|title|link|\?|\%)([^>]*?)>/isU",//object|meta|
        "/(<[^>]*)on[a-zA-Z]\s*=([^>]*>)/isU",
        );

    $replace = array(
        " ",
        "&lt;\\1\\2\\3&gt;",
        "\\1\\2",
        );

    $str = preg_replace($filter,$replace,$html);
    return $str;
}

// /**
//  * 通过该函数运行函数可以抑制错误
//  *
//  * @author  weberliu
//  * @param   string      $fun        要屏蔽错误的函数名
//  * @return  mix         函数执行结果
//  */
function _at($fun)
{
    $arg = func_get_args();
    unset($arg[0]);
    $ret_val = @call_user_func_array($fun, $arg);

    return $ret_val;
}

// /**
//  * 返回是否是通过浏览器访问的页面
//  *
//  * @author wj
//  * @param  void
//  * @return boolen
//  */
function is_from_browser()
{
    static $ret_val = null;
    if ($ret_val === null)
    {
        $ret_val = false;
        $ua = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';
        if ($ua)
        {
            if ((strpos($ua, 'mozilla') !== false) && ((strpos($ua, 'msie') !== false) || (strpos($ua, 'gecko') !== false)))
            {
                $ret_val = true;
            }
            elseif (strpos($ua, 'opera'))
            {
                $ret_val = true;
            }
        }
    }
    return $ret_val;
}

// //发送邮件
function sendMail($to, $title, $content) {   
  
	
	require_once(ROOT_PATH . "/PHPMailer/PHPMailerAutoload.php");  
	require_once(ROOT_PATH . "/PHPMailer/class.phpmailer.php"); 

	$mail = new PHPMailer(); //实例化
	
	
	$mail->IsSMTP(); // 启用SMTP
	$mail->Host='smtp.163.com'; //smtp服务器的名称（这里以QQ邮箱为例）
	$mail->SMTPAuth = TRUE; //启用smtp认证
	$mail->Username = 'kf201679'; //你的邮箱名
	$mail->Password = 'Kf123456' ; //邮箱密码
	$mail->From = 'kf201679@163.com'; //发件人地址（也就是你的邮箱地址）
	$mail->FromName = '59家居'; //发件人姓名
	$mail->AddAddress($to,"尊敬的客户");
	$mail->WordWrap = 50; //设置每行字符长度
	$mail->IsHTML(TRUE); // 是否HTML格式邮件
	$mail->CharSet='utf-8'; //设置邮件编码
	$mail->Subject =$title; //邮件主题
	$mail->Body = $content; //邮件内容
	$mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
	
	
	return($mail->Send());
}

// /**
// * 杨工
// * 2016-09-08
// *优易网php短信接口
// */
class UeSmsApi{
	function sendSMS($mobile,$content)
	{
	    $http = 'http://inter.smswang.net:7801/sms';
	    $extno='1069032239089422';
	    $action='send';
		
		$account='000432';
		$password='DJnmS7';
		
	    $data = array
	    (
	        'action'=>$action,
	        'account'=>$account,					//账户密码
	        'password'=>$password,			//账户密码
	        'mobile'=>$mobile,				//目标号码
	        'content'=>$content,			//
	        'extno'=>$extno,
	    );
	    $re= $this->postSMS($http,$data);			//POST方式提交
	//    var_dump($re);exit;
	    if(stristr($re,'OK'))
	    {
	        return "发送成功!";
	    }
	    else
	    {
	        return "发送失败! XML信息".$re;
	    }
	}

	function postSMS($url,$data='')
	{
	    $row = parse_url($url);
	    $row['port']='7803';
	    $host = $row['host'];
	    $port = $row['port'] ? $row['port']:80;
	    $file = $row['path'];
	    $post='';
	    while (list($k,$v) = each($data))
	    {
	        $post .= rawurlencode($k)."=".rawurlencode($v)."&";	//תURL��׼��
	    }
	    $post = substr( $post , 0 , -1 );
	    $len = strlen($post);
	    $fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
	    if (!$fp) {
	        return "$errstr ($errno)\n";
	    } else {
	        $receive = '';
	        $out = "POST $file HTTP/1.1\r\n";
	        $out .= "Host: $host\r\n";
	        $out .= "Content-type: application/x-www-form-urlencoded\r\n";
	        $out .= "Connection: Close\r\n";
	        $out .= "Content-Length: $len\r\n\r\n";
	        $out .= $post;
	        fwrite($fp, $out);
	        while (!feof($fp)) {
	            $receive .= fgets($fp, 128);
	        }
	        fclose($fp);
	        $receive = explode("\r\n\r\n",$receive);
	        unset($receive[0]);
	        return implode("",$receive);
	    }
	}
}
//发送短信
function send($mobile,$content){
	$send = new UeSmsApi();
	$send -> sendSMS($mobile,$content);	
}

//极光推送
class Jpush_send{
        private $app_key = '63c55a3a8cca474da3cb0aaf';        //待发送的应用程序(appKey)，只能填一个。
        private $master_secret = '435d8388d9fb07e0462c2d0d';    //主密码
        private $url = "https://api.jpush.cn/v3/push";      //推送的地址
        public function __construct($app_key=null, $master_secret=null,$url=null) {
            if ($app_key) $this->app_key = $app_key;
            if ($master_secret) $this->master_secret = $master_secret;
            if ($url) $this->url = $url;
        }
        public function send_pub($receive,$content,$m_type,$m_txt,$m_time){
           
            $m_time = '86400';//离线保留时间
            
            $message="";//存储推送状态
            $result = $this->push($receive,$content,$m_type,$m_txt,$m_time);
            if($result){
                $res_arr = json_decode($result, true);
				echo '<pre>';
				print_r($res_arr);
				echo '</pre>';die;
                if(isset($res_arr['error'])){                       //如果返回了error则证明失败
                    echo $res_arr['error']['message'];          //错误信息
                    $error_code=$res_arr['error']['code'];             //错误码
                        switch ($error_code) {
                            case 200:
                                $message= '发送成功！';
                                break;
                            case 1000:
                                $message= '失败(系统内部错误)';
                                break;
                            case 1001:
                                $message = '失败(只支持 HTTP Post 方法，不支持 Get 方法)';
                                break;
                            case 1002:
                                $message= '失败(缺少了必须的参数)';
                                break;
                            case 1003:
                                $message= '失败(参数值不合法)';
                                break;
                            case 1004:
                                $message= '失败(验证失败)';
                                break;
                            case 1005:
                                $message= '失败(消息体太大)';
                                break;
                            case 1008:
                                $message= '失败(appkey参数非法)';
                                break;
                            case 1020:
                                $message= '失败(只支持 HTTPS 请求)';
                                break;
                            case 1030:
                                $message= '失败(内部服务超时)';
                                break;
                            default:
                                $message= '失败(返回其他状态，目前不清楚额，请联系开发人员！)';
                                break;
                        }
                }else{
                    $message="发送成功！";
                }
            }else{      
                $message='接口调用失败或无响应';
            }
            echo  "<script>alert('推送信息:{$message}')</script>";
        }

        public function push($receiver='all',$content='',$m_type='',$m_txt='',$m_time='86400'){
            $base64=base64_encode("$this->app_key:$this->master_secret");
            $header=array("Authorization:Basic $base64","Content-Type:application/json");
            $data = array();
            $data['platform'] = 'all';          //目标用户终端手机的平台类型android,ios,winphone
            $data['audience'] = $receiver;      //目标用户
             
            $data['notification'] = array(
                    //统一的模式--标准模式
                    "alert"=>$content,
                     //安卓自定义
                    "android"=>array(
                            "alert"=>$content,
                            "title"=>"",
                            "builder_id"=>1,
                            "extras"=>array("type"=>$m_type, "txt"=>$m_txt)
                    ),
                    //ios的自定义
                    "ios"=>array(
                             "alert"=>$content,
                            "badge"=>"1",
                            "sound"=>"default",
                             "extras"=>array("type"=>$m_type, "txt"=>$m_txt)
                    )
            );
    
            //苹果自定义---为了弹出值方便调测
            $data['message'] = array(
                    "msg_content"=>$content,
                    "extras"=>array("type"=>$m_type, "txt"=>$m_txt)
            );
    
            //附加选项
            $data['options'] = array(
                    "sendno"=>time(),
                    "time_to_live"=>$m_time, //保存离线时间的秒数默认为一天
                    "apns_production"=>false, //布尔类型   指定 APNS 通知发送环境：0开发环境，1生产环境。或者传递false和true
            );
            $param = json_encode($data);
            $res = $this->push_curl($param,$header);
             
            if($res){       //得到返回值--成功已否后面判断
                return $res;
            }else{          //未得到返回值--返回失败
                return false;
            }
        }
    
        //推送的Curl方法
        public function push_curl($param="",$header="") {
            if (empty($param)) { return false; }
            $postUrl = $this->url;
            $curlPost = $param;
            $ch = curl_init();                                      //初始化curl
            curl_setopt($ch, CURLOPT_URL,$postUrl);                 //抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);           // 增加 HTTP Header（头）里的字段
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $data = curl_exec($ch);                                 //运行curl
            curl_close($ch);
            return $data;
        }
    
}
function tuisong(){
	$fetion = new Jpush_send(); 
	 // $receive = 'all';//全部 
	 // $receive = array('tag'=>array('中国'));//标签 
	$receive = array('alias'=>array('2'),'alias'=>array('1'));//别名 
	$content = '信息中心提醒：您有一条待审核的业务'; 
	$m_type = 'tb'; 
	$m_txt = '891'; 
	$m_time = '600';        //离线保留时间 
	$res=$fetion->send_pub($receive, $content ,$m_type, $m_txt ,$m_time); 
	echo $res;
}
?>