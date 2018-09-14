<?php


class zhaopinApp extends MallbaseApp
{
   
	
	function index(){
		
		var_dump($_GET);
		
        $this->assign('scategorys', $scategorys);
        $this->display('zhaopin.html');
	}
}

?>
