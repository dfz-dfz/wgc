<?php

include_once("connect.php");
SESSION_START();
$pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
$uid =  isset($_SESSION['userid'])?$_SESSION['userid']:"";
if($uid == '' ){
    echo -1;exit;
}
$username = isset($_SESSION['username'])?$_SESSION['username']:"";
$content = isset($_POST['con']) ? strip_tags($_POST['con']) : "";

$t = time() - 20;
$sql = "SELECT * FROM `ecm_zhaopin_pinlun` WHERE uid = " . $uid . " AND addtime >" . $t . " AND content = '" . $content . "'";
$query = mysql_query($sql);
$num = mysql_num_rows($query);
if ($num == 0) {
    $sql = "INSERT INTO `ecm_zhaopin_pinlun` (`pid`, `uid`, `uname`, `content`, `addtime`) VALUES ('" . $pid . "', '" . $uid . "',  '" . $username . "',  '" . $content . "',  '" . time() . "');";
    $query = mysql_query($sql);
}
