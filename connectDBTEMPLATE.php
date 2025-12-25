<?php 
/*
*
*Created by Giwrgos Papakis 614
*
* Arxeio gia connect sthn vash
*
*/
include 'errorReporting.php';


$host = '/zstorage/home/ictest00614/mysql/run/mysql.sock';
//$host = '/var/db/mysql/mysql.sock';
//$dbname = 'irooms2';
$dbname = 'iRoom';
//$user = 'irooms';
$user = 'iroom';
//$pass = 'irooms444';
$pass = 'iroom';

try
{
	
 	$dbh = new PDO("mysql:unix_socket=$host;dbname=$dbname;charset=utf8", $user,$pass);
 	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 	$dbh->query('set character_set_client=utf8');
 	$dbh->query('set character_set_connection=utf8');
	$dbh->query('set character_set_results=utf8');
 	$dbh->query('set character_set_server=utf8');

}catch(PDOException $e){
	die('Connection error:' . $e->getmessage()); 
}

if (empty($dbh)) { die("Cannot connect to database"); } 
?>
