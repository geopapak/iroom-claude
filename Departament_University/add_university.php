<?php
include '../errorReporting.php';
ini_set('display_errors',1);
require  "../connectDB.php";

try{
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$name =filter_var( $_POST['Name'], FILTER_SANITIZE_STRING);

$query_get_rows = "SELECT * FROM university WHERE name='$name'";
$result_get_rows = $dbh->prepare($query_get_rows);
$result_get_rows->execute();         
$num_get_rows = $result_get_rows->rowCount();

if($num_get_rows >0){
	header('Location:university.php');
}else{
$sql= "INSERT INTO university(name) VALUES (:name)";
$sth = $dbh->prepare($sql, array());
$result = $sth-> execute(array(':name' => $name ));
  header('Location:university.php');
}
	} catch (Exception $e) {
    echo "error on inserting data" .$e;   
}
?>