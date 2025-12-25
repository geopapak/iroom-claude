<?php
session_start();
require_once('../connectDB.php');

$get_id=filter_var( $_GET['ID'] , FILTER_SANITIZE_NUMBER_INT);

$sql = "DELETE FROM type_room where ID = :get_id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':get_id', $get_id, PDO::PARAM_INT);   
$stmt->execute();

$_SESSION['deletecourse']=1;
header('location:typeroom.php');
exit();
?>