<?php
require_once './libs/db_mysql.php';
require_once './libs/configer.php';

use diplomat\Mysql;
//use diplomat\Configer; 
/*
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = new Mysql();

$input = $_GET['p'];
$input = (array)json_decode($input);

$result = $db->insert( $input );
var_dump($result);
echo $db->error;
*/

$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'mypage.php';  // change accordingly

	if( !file_exists ('./conf/config.php') ){
		//header('Location: ''/');
		header("location: ./install.php");
	} else {
		Configer::setFile('./conf/config.php');
		$config = Configer::getInstance();
		echo $config['id'] ."<br />\n";
	}

?>