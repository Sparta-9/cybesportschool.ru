<?php
	include_once '../sys/config/db-cred.inc.php';
	
	foreach ($C as $name => $val) {
		define($name, $val); 
	}
	
	$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
	$dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
	
	function __autoload($class){
		$filename = "../sys/class/class.".$class.".inc.php";
		if (file_exists($filename)){
			include_once $filename;
		}
	}
	
