<?php
require_once './libs/db_mysql.php';
use diplomat\Mysql;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = new Mysql();

$input = $_GET['p'];
$input = (array)json_decode($input);

$result = $db->insert( $input );
var_dump($result);
echo $db->error;

?>