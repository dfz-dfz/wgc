<?php
return array(
	'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'zt55o1_db', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'Hll72xiwr43p0ia5padma', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'ecm_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'CHECK_ROOT' => true,  //开启rbac权限
    'TMPL_CACHE_ON' =>  false,        // 是否开启模板编译缓存,设为false则每次都会重新编译
	'ACTION_CACHE_ON'  => false,  // 默认关闭Action 缓存
	'HTML_CACHE_ON'   => false,   // 默认关闭静态缓存
	'AUTO_LOGIN_TIME'=>3600 * 24 * 7,
	'SHOW_PAGE_TRACE'=>false, //追踪模式
    'MY_CATCH_DIR' =>'./cache/', //缓存目录
    'topic_pass'=>false,	//是否开启话题审核
    
);